<?php
/**
 * Create new folder.
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
	if(!get_magic_quotes_gpc())
	{
		$_POST['name'] = addslashes($_POST['name']);
		$_POST['shortdesc'] = addslashes($_POST['shortdesc']);
	}
	if(!$Fileman->checkFilename($_POST['name']))
	{
		echo 'Invalid filename.';
		return;
	}
	$_POST['name'] = htmlentities($_POST['name']);
	$_POST['shortdesc'] = htmlentities($_POST['shortdesc']);
	$cwd = getcwd();
	chdir(FM_ROOT_PATH.$Project->pid);
	if(!mkdir($Fileman->dir.$_POST['name'], 0777))
	{
		echo '<div class="error" style="text-align:center">Invalid folder name. Folder could already exist or you might just have an invalid filename.</div>';
		return;
	}
	else
	{
		mysql_query("INSERT INTO fm_folders (path,name,shortdesc,uid,pid) VALUES ('".$Fileman->dir."','".$_POST['name']."','".$_POST['shortdesc']."','".$Me->uid."','".$Project->pid."')");
		$Fileman->modifyLog('the folder \''.$Fileman->dir.$_POST['name'].'\' was created by '.$Me->handle);
	}
	chdir($cwd);
	if(empty($_POST['name']) || $error)
	{
		echo '<div class="error" style="text-align:center">Invalid folder name.</div>';
		return;
	}
	header('Location: index.php?mod=fileman&pid='.$Project->pid.'&dir='.$Fileman->dir);
	return;
}
?>
<div style="text-align:center">
<form action="index.php?mod=fileman&page=newfolder&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>" method="post">
<table border="0" cellpadding="0" cellspacing="0" class="tbl1">
<tr><td colspan="2" class="tbl1_header">create new folder</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">location </td>
<td class="tbl1_cell" style="text-align:left"><?=$Fileman->dir?></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">folder name </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="name" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">description </td>
<td class="tbl1_cell" style="text-align:left"><textarea name="shortdesc" cols="60" rows="3"></textarea></td>
</tr>
<tr>
<tr><td colspan="2" class="tbl1_footer"><input type="submit" value="Submit" name="submit" /> <input type="button" value="Cancel" onClick="window.location='index.php?mod=fileman&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>'"></td></tr>
</table>
</form>
</div>