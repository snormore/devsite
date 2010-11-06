<?php
/**
 * Edit thread.
 *
 * @package	Forum
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;
if(!$Me->hasRights(GRIGHTS_ADMIN.GRIGHTS_SADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER))
	return;
if(empty($_GET['fid']) || !is_numeric($_GET['fid']))
	$_GET['fid'] = 0;
require_once(LIB_PATH.'FText.php');

function delete_thread($fid)
{
	global $Project;
	$result = mysql_query("SELECT id FROM forum WHERE parent='".$fid."' AND pid='".$Project->pid."'");
	while($row = mysql_fetch_assoc($result))
	{
		delete_thread($row['id']);
	}
	mysql_query("DELETE FROM forum WHERE id='".$fid."' AND pid='".$Project->pid."'");
}

if(!empty($_POST['submit']))
{
	$row = mysql_fetch_assoc(mysql_query("SELECT parent FROM forum WHERE id='".$_GET['fid']."' AND pid='".$Project->pid."'"));

	delete_thread($_GET['fid']);
	header('Location: index.php?mod=forum&pid='.$Project->pid.'&fid='.$row['parent']);
	return;
}

$result = mysql_query("SELECT topic,body,uid,created FROM forum WHERE id='".$_GET['fid']."'");
$row = mysql_fetch_assoc($result);
$user = mysql_fetch_assoc(mysql_query("SELECT handle FROM users WHERE id='".$row['uid']."'"));
?>
<div style="text-align:center">
<form action="index.php?mod=forum&page=delete&pid=<?=$Project->pid?>&fid=<?=$_GET['fid']?>" method="post">
Are you sure you want to delete this thread and all of its sub-threads?
<br /><br />
<input type="submit" value="Yes" name="submit" />
<input type="button" value="No" onClick="window.location='index.php?mod=forum&pid=<?=$Project->pid?>&fid=<?=$_GET['fid']?>'">
</form>
</div>