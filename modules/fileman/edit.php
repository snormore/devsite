<?php
/**
 * edit a file.
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

if(empty($_POST['fname']))
{
	?>
	<div style="text-align:center">
	<form action="index.php?mod=fileman&page=edit&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>" method="post">
	<table class="tbl1">
	<tr><td colspan="5" class="tbl1_cell" style="border-bottom:solid 1pt #000000"><?php $Fileman->showLocation(); ?></td></tr>
	<tr>
	<td class="tbl1_header">&nbsp;</td>
	<td class="tbl1_header">filename</td>
	<td class="tbl1_header">description</td>
	<td class="tbl1_header">last modified</td>
	<td class="tbl1_header">size (kb)</td>
	<?php $Fileman->showList('edit'); ?>
	</tr>
	<tr>
	<tr><td colspan="5" class="tbl1_footer"><input type="submit" value="Submit" /> <input type="button" value="Cancel" onClick="window.location='index.php?mod=fileman&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>'"></td></tr>
	</table>
	</form>
	</div>
	<?php
	return;
}

if(!get_magic_quotes_gpc())
	addslashes($_POST['fname']);
if(!$Fileman->checkFilename($_POST['fname']))
{
	echo 'Invalid filename.';
	return;
}

$cwd = getcwd();
chdir(FM_ROOT_PATH.$Project->pid);

if(!empty($_POST['submit']))
{
	if(!get_magic_quotes_gpc())
	{
		$_POST['loc'] = addslashes($_POST['loc']);
		$_POST['name'] = addslashes($_POST['name']);
		$_POST['shortdesc'] = addslashes($_POST['shortdesc']);
	}
	if(!$Fileman->checkFilename($_POST['name']))
	{
		echo '<div class="error" style="text-align:center">Invalid filename.</div>';
		return;
	}
	if(substr($_POST['loc'], strlen($_POST['loc'])-1, 1) != '/')
		$_POST['loc'] .= '/';
	$NewDir = new Fileman($Project, $_POST['loc']);
	if($_POST['loc'] !== $NewDir->dir)
	{
		echo '<div class="error" style="text-align:center">Invalid new location.</div>';
		return;
	}
	unset($NewDir);
	if(is_dir($Fileman->dir.$_POST['fname']))	// folder
	{
		if(is_dir($_POST['loc'].$_POST['name']) && $_POST['loc'] != $Fileman->dir && $_POST['name'] != $_POST['fname'])
		{
			echo '<div class="error" style="text-align:center">Folder already exists.</div>';
			return;
		}
		if(!rename($Fileman->dir.$_POST['fname'], $_POST['loc'].$_POST['name']) && $_POST['loc'] != $Fileman->dir && $_POST['name'] != $_POST['fname'])
		{
			echo '<div class="error" style="text-align:center">Error renaming folder.</div>';
			return;
		}
		mysql_query("UPDATE fm_folders SET path='".$_POST['loc']."',name='".$_POST['name']."',shortdesc='".$_POST['shortdesc']."' WHERE path='".$Fileman->dir."' AND name='".$_POST['fname']."' AND pid='".$Project->pid."'");
		$Fileman->modifyLog('the folder \''.$Fileman->dir.$_POST['fname'].'\' was edited by '.$Me->handle.', it is now \''.$_POST['loc'].$_POST['name'].'\'');
		
		header('Location: index.php?mod=fileman&pid='.$Project->pid.'&dir='.$Fileman->dir);
		chdir($cwd);
		return;
	}
	else	// file
	{
		if(file_exists($_POST['loc'].$_POST['name']) && $_POST['loc'] != $Fileman->dir && $_POST['name'] != $_POST['fname'])
		{
			echo '<div class="error" style="text-align:center">Folder already exists.</div>';
			return;
		}
		if(!get_magic_quotes_gpc())
			$_POST['longdesc'] = addslashes($_POST['longdesc']);

		$ss_type = strrchr($_FILES['screenshot']['name'], '.');
		if($ss_type && ($ss_type == '.gif' || $ss_type == '.jpg' || $ss_type == 'bmp' || $ss_type == 'png') && !$_POST['rm_screenshot'])
		{
			$ss_type = substr($ss_type, 1, strlen($ss_type)-1);
			$ss_type = 'image/'.$ss_type;
			$sql = "UPDATE fm_files SET path='".$_POST['loc']."',name='".$_POST['name']."',shortdesc='".$_POST['shortdesc']."',longdesc='".$_POST['longdesc']."',screenshot=LOAD_FILE('".addslashes($_FILES['screenshot']['tmp_name'])."'),screenshot_type='".$ss_type."' WHERE path='".$Fileman->dir."' AND name='".$_POST['fname']."' AND pid='".$Project->pid."'";
		}
		elseif($_POST['rm_screenshot'])
		{
			$sql = "UPDATE fm_files SET path='".$_POST['loc']."',name='".$_POST['name']."',shortdesc='".$_POST['shortdesc']."',longdesc='".$_POST['longdesc']."',screenshot='',screenshot_type='' WHERE path='".$Fileman->dir."' AND name='".$_POST['fname']."' AND pid='".$Project->pid."'";
		}
		else
		{
			$sql = "UPDATE fm_files SET path='".$_POST['loc']."',name='".$_POST['name']."',shortdesc='".$_POST['shortdesc']."',longdesc='".$_POST['longdesc']."' WHERE path='".$Fileman->dir."' AND name='".$_POST['fname']."' AND pid='".$Project->pid."'";
		}
		if(!rename($Fileman->dir.$_POST['fname'], $_POST['loc'].$_POST['name']) && $_POST['loc'] != $Fileman->dir && $_POST['name'] != $_POST['fname'])
		{
			echo '<div class="error" style="text-align:center">Error renaming folder.</div>';
			return;
		}
		mysql_query($sql);
		$Fileman->modifyLog('the file \''.$Fileman->dir.$_POST['fname'].'\' was edited by '.$Me->handle.', it is now \''.$_POST['loc'].$_POST['name'].'\'');

		header('Location: index.php?mod=fileman&pid='.$Project->pid.'&dir='.$Fileman->dir);
		chdir($cwd);
		return;
	}
	return;
}

if(is_dir($Fileman->dir.$_POST['fname']))	// folder
{
	$result = mysql_query("SELECT shortdesc FROM fm_folders WHERE path='".$Fileman->dir."' AND name='".$_POST['fname']."' AND pid='".$Project->pid."'");
	$row = mysql_fetch_assoc($result);
	?>
	<div style="text-align:center">
	<form action="index.php?mod=fileman&page=edit&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>" method="post">
	<input type="hidden" name="fname" value="<?=$_POST['fname']?>" />
	<table border="0" cellpadding="0" cellspacing="0" class="tbl1">
	<tr><td colspan="2" class="tbl1_header">edit folder info</td></tr>
	<tr>
	<td class="tbl1_cell" style="text-align:right">current location </td>
	<td class="tbl1_cell" style="text-align:left"><?=$Fileman->dir?></td>
	</tr>
	<tr>
	<td class="tbl1_cell" style="text-align:right">new location </td>
	<td class="tbl1_cell" style="text-align:left"><input type="text" name="loc" value="<?=$Fileman->dir?>" /></td>
	</tr>
	<tr>
	<td class="tbl1_cell" style="text-align:right">filename </td>
	<td class="tbl1_cell" style="text-align:left"><input type="text" name="name" value="<?=$_POST['fname']?>" /></td>
	</tr>
	<tr>
	<td class="tbl1_cell" style="text-align:right;vertical-align:top">short description </td>
	<td class="tbl1_cell" style="text-align:left"><textarea name="shortdesc" cols="60" rows="3"><?=$row['shortdesc']?></textarea></td>
	</tr>
	<tr>
	<tr><td colspan="2" class="tbl1_footer"><input type="submit" value="Submit" name="submit" /> <input type="button" value="Cancel" onClick="window.location='index.php?mod=fileman&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>'"></td></tr>
	</table>
	</form>
	</div>
	<?php
}
else	// file
{
	$result = mysql_query("SELECT shortdesc,longdesc FROM fm_files WHERE path='".$Fileman->dir."' AND name='".$_POST['fname']."' AND pid='".$Project->pid."'");
	$row = mysql_fetch_assoc($result);
	?>
	<div style="text-align:center">
	<form enctype="multipart/form-data" action="index.php?mod=fileman&page=edit&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>" method="post">
	<input type="hidden" name="fname" value="<?=$_POST['fname']?>" />
	<input type="hidden" name="MAX_FILE_SIZE" value="<?=ini_get('upload_max_filesize')*1048576?>" />
	<table border="0" cellpadding="0" cellspacing="0" class="tbl1">
	<tr><td colspan="2" class="tbl1_header">edit file info</td></tr>
	<tr>
	<td class="tbl1_cell" style="text-align:right">current location </td>
	<td class="tbl1_cell" style="text-align:left"><?=$Fileman->dir?></td>
	</tr>
	<tr>
	<td class="tbl1_cell" style="text-align:right">new location </td>
	<td class="tbl1_cell" style="text-align:left"><input type="text" name="loc" value="<?=$Fileman->dir?>" /></td>
	</tr>
	<tr>
	<td class="tbl1_cell" style="text-align:right">filename </td>
	<td class="tbl1_cell" style="text-align:left"><input type="text" name="name" value="<?=$_POST['fname']?>" /></td>
	</tr>
	<tr>
	<td class="tbl1_cell" style="text-align:right;vertical-align:top">screenshot </td>
	<td class="tbl1_cell" style="text-align:left">
	<input type="file" name="screenshot" value="" /><br />
	<input type="checkbox" name="rm_screenshot" value="1" class="normal" /> delete current screenshot.<br />
	note: leave screenshot field and checkbox blank to leave<br />the current screen the way it is.
	</td>
	</tr>
	<tr>
	<td class="tbl1_cell" style="text-align:right;vertical-align:top">short description </td>
	<td class="tbl1_cell" style="text-align:left"><textarea name="shortdesc" cols="60" rows="3"><?=$row['shortdesc']?></textarea></td>
	</tr>
	<tr>
	<td class="tbl1_cell" style="text-align:right; vertical-align:top">long description </td>
	<td class="tbl1_cell" style="text-align:left">
	<?php FText::showEditor('longdesc', $row['longdesc'], 60, 20); ?>
	</td>
	</tr>
	<tr>
	<tr><td colspan="2" class="tbl1_footer"><input type="submit" value="Submit" name="submit" /> <input type="button" value="Cancel" onClick="window.location='index.php?mod=fileman&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>'"></td></tr>
	</table>
	</form>
	</div>
	<?php
}

chdir($cwd);
?>