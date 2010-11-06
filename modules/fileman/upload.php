<?php
/**
 * Upload a file.
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

require_once(LIB_PATH.'FText.php');

if(!empty($_POST['submit']))
{
	$cwd = getcwd();
	chdir(FM_ROOT_PATH.$Project->pid);
	if(!get_magic_quotes_gpc())
		$_POST['shortdesc'] = addslashes($_POST['shortdesc']);
	$_POST['shortdesc'] = htmlentities($_POST['shortdesc']);
	$_POST['longdesc'] = FText::fText2db($_POST['longdesc']);
	if(empty($_FILES['userfile']['name']) || file_exists($Fileman->dir . $_FILES['userfile']['name']))
	{
		echo '<div class="error" style="text-align:center">Invalid filename or file already exists.</div>';
		chdir($cwd);
		return;
	}
	else
	{
		$ss_type = strrchr($_FILES['screenshot']['name'], '.');
		if($ss_type && ($ss_type == '.gif' || $ss_type == '.jpg' || $ss_type == 'bmp' || $ss_type == 'png'))
		{
			$ss_type = substr($ss_type, 1, strlen($ss_type)-1);
			$ss_type = 'image/'.$ss_type;
			$sql = "INSERT INTO fm_files (path,name,shortdesc,longdesc,uid,screenshot,screenshot_type,pid) VALUES ('".$Fileman->dir."','".$_FILES['userfile']['name']."','".$_POST['shortdesc']."','".$_POST['longdesc']."','".$Me->uid."',LOAD_FILE('".addslashes($_FILES['screenshot']['tmp_name'])."'),'".$ss_type."','".$Project->pid."')";
		}
		else
		{
			$sql = "INSERT INTO fm_files (path,name,shortdesc,longdesc,uid,pid) VALUES ('".$Fileman->dir."','".$_FILES['userfile']['name']."','".$_POST['shortdesc']."','".$_POST['longdesc']."','".$Me->uid."','".$Project->pid."')";
		}
		@chmod($Fileman->dir, 0777);
		if(!mysql_query($sql) || !is_uploaded_file($_FILES['userfile']['tmp_name']))
		{
			echo '<div class="error" style="text-align:center">Upload failed.</div>';
			chdir($cwd);
			return;
		}
		elseif(!copy($_FILES['userfile']['tmp_name'], $Fileman->dir.$_FILES['userfile']['name']))
		{
			echo '<div class="error" style="text-align:center">Copy failed.</div>';
			chdir($cwd);
			return;
		}
		$Fileman->modifyLog('the file \''.$Fileman->dir.$_FILES['userfile']['name'].'\' was uploaded by '.$Me->handle);
	}
	header('Location: index.php?mod=fileman&pid='.$Project->pid.'&dir='.$Fileman->dir);
	chdir($cwd);
	return;
}
?>
<div style="text-align:center">
<form enctype="multipart/form-data" action="index.php?mod=fileman&page=upload&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="<?=ini_get('upload_max_filesize')*1048576?>" />
<table border="0" cellpadding="0" cellspacing="0" class="tbl1">
<tr><td colspan="2" class="tbl1_header">upload file</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">location </td>
<td class="tbl1_cell" style="text-align:left"><?=$Fileman->dir?></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">file </td>
<td class="tbl1_cell" style="text-align:left"><input type="file" name="userfile" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">screenshot </td>
<td class="tbl1_cell" style="text-align:left"><input type="file" name="screenshot" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">&nbsp;</td>
<td class="tbl1_cell" style="text-align:left"><div style="color:#333333">note: maximum filesize is <?=ini_get('upload_max_filesize')?>b</div></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right;vertical-align:top">short description </td>
<td class="tbl1_cell" style="text-align:left"><textarea name="shortdesc" cols="60" rows="3"></textarea></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">long description </td>
<td class="tbl1_cell" style="text-align:left">
<?php FText::showEditor('longdesc', '', 60, 20); ?>
</td>
</tr>
<tr>
<tr><td colspan="2" class="tbl1_footer"><input type="submit" value="Submit" name="submit" /> <input type="button" value="Cancel" onClick="window.location='index.php?mod=fileman&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>'"></td></tr>
</table>
</form>
</div>