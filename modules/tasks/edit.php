<?php
/**
 * Edit team file.
 *
 * Edits a team.
 *
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'tasks/header.php');
if($ret !== true)
	return;

include(MODULES_PATH.'tasks/admin_menu.php');

require_once(LIB_PATH.'FText.php');

if(!empty($_POST['submit']))
{
	if(!get_magic_quotes_gpc())
	{
		$_POST['name'] = addslashes($_POST['name']);
		$_POST['objective'] = addslashes($_POST['objective']);
	}
	$_POST['name'] = htmlentities($_POST['name']);
	$_POST['objective'] = htmlentities($_POST['objective']);
	if(empty($_POST['name']) || strlen($_POST['name']) > MAX_TASKS_NAME)
	{
		echo '<div class="error">Invalid task name. Must be greater than 0 and less than '.MAX_TASKS_NAME.'  characters in length.</div>';
		return;
	}
	if(!isset($_POST['percent']) || strlen($_POST['percent']) > 3 || !is_numeric($_POST['percent']) || $_POST['percent'] < 0 || $_POST['percent'] > 100)
	{
		echo '<div class="error">Invalid percent complete. It must be a number between or including 0 and 100.</div>';
		return;
	}

	mysql_query("UPDATE tasks SET name='".$_POST['name']."', objective='".$_POST['objective']."',body='".FText::fText2db($_POST['body'])."',percent='".$_POST['percent']."' WHERE id='".$Task->taskid."'");
	// assigned to
	mysql_query("DELETE FROM task_members WHERE taskid='".$Task->taskid."'");
	foreach($_POST['uid'] as $uid)
	{
		if(is_numeric($uid))
				mysql_query("INSERT INTO task_members (taskid,uid) VALUES ('".$Task->taskid."','".$uid."')");
	}

	header('Location: index.php?mod=tasks&page=tsk&pid='.$Project->pid.'&tid='.$Team->tid.'&taskid='.$Task->taskid);
	return;
}

$result = mysql_query("SELECT objective,body,percent FROM tasks WHERE id='".$Task->taskid."'");
$row = mysql_fetch_assoc($result);
?>
<div style="text-align:center">
<form action="./index.php?mod=tasks&page=edit&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>&taskid=<?=$Task->taskid?>" method="post">
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">edit task</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">name </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="name" value="<?=$Task->name?>" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">percent complete </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" size="2" name="percent" value="<?=$row['percent']?>" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">objective </td>
<td class="tbl1_cell" style="text-align:left"><textarea name="objective" cols="60" rows="4"><?=$row['objective']?></textarea></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">assign to </td>
<td class="tbl1_cell" style="text-align:left"><div class="user-list" style="height:150px;width:200px">
<?php
$result = mysql_query("SELECT uid FROM team_members WHERE tid='".$Team->tid."'");
while($members = mysql_fetch_assoc($result))
{
	$rc = mysql_query("SELECT handle FROM users WHERE id='".$members['uid']."'");
	$user = mysql_fetch_assoc($rc);
	$rc2 = mysql_query("SELECT uid FROM task_members WHERE taskid='".$Task->taskid."' AND uid='".$members['uid']."'");
	?><input type="checkbox" name="uid[]" value="<?=$members['uid']?>" class="normal"<?=(mysql_num_rows($rc2) > 0)?' checked':'';?>> <?=$user['handle']?><br />
	<?php
}
?>
</div></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">homepage </td>
<td class="tbl1_cell" style="text-align:left">
<?php FText::showEditor('body', $row['body']); ?>
</td>
</tr>
<tr>
<td class='tbl1_footer' colspan="5">
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=tasks&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>'" />
</td>
</tr>
</table>
</form>
</div>