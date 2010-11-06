<?php
/**
 * Display main forum categories.
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

function showForumNav($next_id, $fid, $spaces)
{
	global $Project;
	$result = mysql_query("SELECT topic,parent FROM forum WHERE id='".$next_id."'");
	if(mysql_num_rows($result) != 0)
	{
		$row = mysql_fetch_assoc($result);
		echo $spaces;
		echo $next_id == $fid ? '<b>'.$row['topic'].'</b><br />' : '<a href="index.php?mod=forum&page=index&pid='.$Project->pid.'&fid='.$next_id.'">'.$row['topic'].'</a><br />';
		$result = mysql_query("SELECT id FROM forum WHERE parent='".$next_id."'");
		while($row = mysql_fetch_assoc($result))
		{
			showForumNav($row['id'], $fid, $spaces.'&nbsp;&nbsp;&nbsp;&nbsp;');
		}
	}
}

if($_GET['fid'] != 0)
{
	$result = mysql_query("SELECT id,topic,body,uid,created,parent FROM forum WHERE pid='".$Project->pid."' AND id='".$_GET['fid']."'");
	$row = mysql_fetch_assoc($result);

	$row2 = $row;
	while($row2['parent'] != 0)
	{
		$rc = mysql_query("SELECT id,parent FROM forum WHERE id='".$row2['parent']."'");
		$row2 = mysql_fetch_assoc($rc);
	}
	?><div style="text-align:center">
	<table cellpadding="0" cellspacing="0" border="0"><tr><td>
	<?php
	echo '<a href="index.php?mod=forum&pid='.$Project->pid.'">'.$Project->name.' Forum</a><br />';
	showForumNav($row2['id'], $_GET['fid'], '&nbsp;&nbsp;&nbsp;&nbsp;');
	?></td></tr></table></div><br />
	<?php

	// main thread
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
	<td class="forum_content">
	<?=FText::fText2html($row['body'])?><br /><br />
	<div style="text-align:right">
	<?php
	if($Me->hasRights(GRIGHTS_ADMIN.GRIGHTS_SADMIN) || $Project->hasRights($Me->uid, PRIGHTS_LEADER))
	{
		?><a href="index.php?mod=forum&page=delete&pid=<?=$Project->pid?>&fid=<?=$_GET['fid']?>">Delete</a> |
		<a href="index.php?mod=forum&page=edit&pid=<?=$Project->pid?>&fid=<?=$_GET['fid']?>">Edit</a> |
		<?php
	}
	?>
	<a href="index.php?mod=forum&page=reply&pid=<?=$Project->pid?>&fid=<?=$_GET['fid']?>">Reply</a>
	</div>
	</td>
	</tr>
	</table>
	<br /><br />
	<hr noshade style="background-color: #000000" size="1"/>
	<br /><br />
	<?php
}
else
{
	?><div style="text-align:center">
	|
	<a href="index.php?mod=forum&page=reply&pid=<?=$Project->pid?>">new thread</a> |
	</div>
	<br />
	<?php
}

// replys
$result = mysql_query("SELECT id,topic,body,uid,created FROM forum WHERE pid='".$Project->pid."' AND parent='".$_GET['fid']."'");
while($row = mysql_fetch_assoc($result))
{
	$rc = mysql_query("SELECT handle FROM users WHERE id='".$row['uid']."'");
	$user = mysql_fetch_assoc($rc);
	?><table cellpadding="0" cellspacing="0" border="0" class="forum">
	<tr><td colspan="2" class="forum_topic"><a href="index.php?mod=forum&page=index&pid=<?=$Project->pid?>&fid=<?=$row['id']?>"><?=$row['topic']?></a></td></tr>
	<tr>
	<td class="forum_left">
	<div class="forum_left">
	<b>Author</b> <?=$user['handle']?><br />
	<b>Created</b> <?=$row['created']?><br />
	<b>Replys</b> <?=mysql_num_rows(mysql_query("SELECT id FROM forum WHERE parent='".$row['id']."'"))?>
	<br />
	</div>
	</td>
	<td class="forum_content">
	<?=FText::fText2html($row['body'])?><br /><br />
	<div style="text-align:right">
	<?php
	if($Me->hasRights(GRIGHTS_ADMIN.GRIGHTS_SADMIN) || $Project->hasRights($Me->uid, PRIGHTS_LEADER))
	{
		?><a href="index.php?mod=forum&page=delete&pid=<?=$Project->pid?>&fid=<?=$row['id']?>">Delete</a> |
		<a href="index.php?mod=forum&page=edit&pid=<?=$Project->pid?>&fid=<?=$row['id']?>">Edit</a> |
		<?php
	}
	?>
	<a href="index.php?mod=forum&page=reply&pid=<?=$Project->pid?>&fid=<?=$row['id']?>">Reply</a>
	</div>
	</td>
	</tr>
	</table>
	<br />
	<?php
}
?>