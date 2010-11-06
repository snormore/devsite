<?php
/**
 * View information for individual file.
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

if(!get_magic_quotes_gpc())
	$_GET['fname'] = addslashes($_GET['fname']);
if(!$Fileman->checkFilename($_GET['fname']))
{
	echo 'Invalid filename.';
	return;
}
$result = mysql_query("SELECT shortdesc,longdesc,uid,screenshot FROM fm_files WHERE path='".$Fileman->dir."' AND name='".$_GET['fname']."' AND pid='".$Project->pid."'");
$row = mysql_fetch_assoc($result);
$result = mysql_query("SELECT handle FROM users WHERE id='".$row['uid']."'");
$user = mysql_fetch_assoc($result);

$cwd = getcwd();
chdir(FM_ROOT_PATH.$Project->pid);
?>
<div class="infoview">
<b>filename:</b> <?=$_GET['fname']?><br />
<b>location:</b><?php $Fileman->showLocation(); ?><br />
<b>uploaded by:</b> <?=$user['handle']?><br />
<b>last modified:</b> <?=gmdate('m.d.y', filemtime($Fileman->dir.$_GET['fname']))?><br />
<b>size:</b> <?=round(filesize($Fileman->dir.$_GET['fname'])/1000, 1)?> kb<br />
<b>description:</b><br /><?=$row['shortdesc']?><br />
<br />
<a href="<?=MODULES_PATH?>fileman/download.php?pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>&fname=<?=$_GET['fname']?>">Download</a>
<?php
if(!empty($row['screenshot']))
{
	?><br /><br /><img src="<?=MODULES_PATH?>fileman/screenshot.php?pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>&fname=<?=$_GET['fname']?>" />
	<?php
}
?>
<br /><br />
<?=FText::fText2html($row['longdesc'])?>

</div>
<?php
chdir($cwd);
?>