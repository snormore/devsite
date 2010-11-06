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

if(!empty($_POST['submit']))
{
	if(!get_magic_quotes_gpc())
		$_POST['name'] = addslashes($_POST['name']);
	$_POST['name'] = htmlentities($_POST['name']);
	if(empty($_POST['topic']))
	{
		?><div class="error" style="text-align:center">Invalid topic</div><?php
		return;
	}
	elseif(empty($_POST['body']))
	{
		?><div class="error" style="text-align:center">Invalid message</div><?php
		return;
	}
	mysql_query("UPDATE forum SET topic='".$_POST['topic']."',body='".$_POST['body']."' WHERE id='".$_GET['fid']."' AND pid='".$Project->pid."'");
	header('Location: index.php?mod=forum&pid='.$Project->pid.'&fid='.$_GET['fid']);
	return;
}

$result = mysql_query("SELECT topic,body,uid,created FROM forum WHERE id='".$_GET['fid']."'");
$row = mysql_fetch_assoc($result);
$user = mysql_fetch_assoc(mysql_query("SELECT handle FROM users WHERE id='".$row['uid']."'"));
?>
<div style="text-align:center">
<form action="index.php?mod=forum&page=edit&pid=<?=$Project->pid?>&fid=<?=$_GET['fid']?>" method="post">
<table border="0" cellpadding="0" cellspacing="0" class="tbl1">
<tr><td colspan="2" class="tbl1_header">edit thread</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">topic </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="topic" value="<?=$row['topic']?>" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">author </td>
<td class="tbl1_cell" style="text-align:left"><?=$user['handle']?></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right;vertical-align:top">message </td>
<td class="tbl1_cell" style="text-align:left"><?php FText::showEditor('body',$row['body']); ?></td>
</tr>
<tr>
<tr><td colspan="2" class="tbl1_footer"><input type="submit" value="Submit" name="submit" /> <input type="button" value="Cancel" onClick="window.location='index.php?mod=forum&pid=<?=$Project->pid?>&fid=<?=$_GET['fid']?>'"></td></tr>
</table>
</form>
</div>