<?php
/**
 * Reply to thread.
 *
 * @package	Forum
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
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
	mysql_query("INSERT INTO forum (topic,body,parent,uid,pid,created) VALUES ('".$_POST['topic']."','".$_POST['body']."','".$_GET['fid']."','".$Me->uid."','".$Project->pid."',NOW())");
	header('Location: index.php?mod=forum&pid='.$Project->pid.'&fid='.$_GET['fid']);
	return;
}

if($_GET['fid'] != 0)
{
	$result = mysql_query("SELECT id,topic,body,uid,created,parent FROM forum WHERE pid='".$Project->pid."' AND id='".$_GET['fid']."'");
	$row = mysql_fetch_assoc($result);
	$rc = mysql_query("SELECT handle FROM users WHERE id='".$row['uid']."'");
	$user = mysql_fetch_assoc($rc);
	?><table cellpadding="0" cellspacing="0" border="0" class="forum">
	<tr><td colspan="2" class="forum_topic"><?=$row['topic']?></td></tr>
	<tr>
	<td class="forum_left">
	<div class="forum_left">
	<b>Author</b> <?=$user['handle']?><br />
	<b>Created</b> <?=$row['created']?><br />
	<b>Replys</b> <?=mysql_num_rows(mysql_query("SELECT id FROM forum WHERE parent='".$row['id']."'"))?>
	<br />
	</div>
	</td>
	<td class="forum_content"><?=FText::fText2html($row['body'])?></td>
	</tr>
	</table>
	<br /><br />
	<hr noshade style="background-color: #000000" size="1"/>
	<br /><br />
	<?php
}

?>
<div style="text-align:center">
<form action="index.php?mod=forum&page=reply&pid=<?=$Project->pid?>&fid=<?=$_GET['fid']?>" method="post">
<table border="0" cellpadding="0" cellspacing="0" class="tbl1">
<tr><td colspan="2" class="tbl1_header"><?=$_GET['fid'] == 0?'new thread':'reply'?></td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">topic </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="topic" value="<?=!empty($row['topic'])?'Re: '.$row['topic']:''?>" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">author </td>
<td class="tbl1_cell" style="text-align:left"><?=$Me->handle?></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right;vertical-align:top">message </td>
<td class="tbl1_cell" style="text-align:left"><?php FText::showEditor('body'); ?></td>
</tr>
<tr>
<tr><td colspan="2" class="tbl1_footer"><input type="submit" value="Submit" name="submit" /> <input type="button" value="Cancel" onClick="window.location='index.php?mod=forum&pid=<?=$Project->pid?>&fid=<?=$_GET['fid']?>'"></td></tr>
</table>
</form>
</div>