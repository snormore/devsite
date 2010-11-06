<?php
/**
 * Delete a file or folder.
 *
 * @package	Fileman
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;
require_once(MODULES_PATH.'fileman/Fileman.php');
if(empty($_GET['dir']))
	$_GET['dir'] = './';
$Fileman = new Fileman($Project, $_GET['dir']);
require_once(MODULES_PATH.'fileman/menu.php');

if(!empty($_POST['submit']))
{
	$cwd = getcwd();
	chdir(FM_ROOT_PATH.$Project->pid);
	foreach($_POST['fname'] as $fname)
	{
		if(!get_magic_quotes_gpc())
			$fname = addslashes($fname);
		if($Fileman->checkFilename($fname))
		{
			if(is_dir($Fileman->dir.$fname))
			{
				$Fileman->deldir($Fileman->dir.$fname.'/');
				$Fileman->modifyLog('the folder \''.$Fileman->dir.$fname.'\' and its subitems were deleted by '.$Me->handle);
			}
			else
			{
				if($Fileman->dir.$fname == './modify.log' && !$Me->hasRights(GRIGHTS_ADMIN.GRIGHTS_SADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER))
					continue;
				unlink($Fileman->dir.$fname);
				mysql_query("DELETE FROM fm_files WHERE path='".$Fileman->dir."' AND name='".$fname."' AND pid='".$Project->pid."'");
				$Fileman->modifyLog('the file \''.$Fileman->dir.$fname.'\' was deleted by '.$Me->handle);
			}
		}
	}
	chdir($cwd);
	header('Location: index.php?mod=fileman&pid='.$Project->pid.'&dir='.$Fileman->dir);
	return;
}
?>
<div class="error" style="text-align:center">Warning: Delete a folder will delete all files and folders in its sub-directories.</div>
<br />
<div style="text-align:center">
<form action="index.php?mod=fileman&page=delete&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>" method="post">
<table class="tbl1">
<tr><td colspan="5" class="tbl1_cell" style="border-bottom:solid 1pt #000000"><?php $Fileman->showLocation(); ?></td></tr>
<tr>
<td class="tbl1_header">&nbsp;</td>
<td class="tbl1_header">filename</td>
<td class="tbl1_header">description</td>
<td class="tbl1_header">last modified</td>
<td class="tbl1_header">size (kb)</td>
<?php $Fileman->showList('delete'); ?>
</tr>
<tr>
<tr><td colspan="5" class="tbl1_footer"><input type="submit" value="Submit" name="submit" /> <input type="button" value="Cancel" onClick="window.location='index.php?mod=fileman&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>'" /></td></tr>
</table>
</form>
</div>