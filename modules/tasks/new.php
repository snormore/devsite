<?php
/**
 * New task file.
 *
 * Create a new task.
 *
 * @package	Tasks
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'teams/header.php');
if($ret !== true)
	return;

if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER) && !$Team->hasRights($Me->uid, TRIGHTS_LEADER))
	return;

include(MODULES_PATH.'tasks/admin_menu.php');

require_once(LIB_PATH.'FText.php');

if(!empty($_POST['submit']))
{
	require_once(MODULES_PATH.'tasks/Task.php');

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

	// everything is ok, so create the task
	mysql_query("INSERT INTO tasks (tid,name,createdby,created,updated,objective,body) VALUES ('".$Team->tid."','".$_POST['name']."','".$Me->uid."',NOW(),NOW(),'".$_POST['objective']."','".FText::fText2db($_POST['body'])."')");
	$taskid = mysql_insert_id();
    foreach($_POST['uid'] as $uid)
    {
		if(is_numeric($uid))
    		mysql_query("INSERT INTO task_members (uid,taskid) VALUES ('".$uid."','".$taskid."')");
    }

	header('Location: index.php?mod=tasks&pid='.$Project->pid.'&tid='.$Team->tid);
	return;
}

?>

<div style="text-align:center">
<form action="./index.php?mod=tasks&page=new&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>" method="post">
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">new task</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">name </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="name" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">objective </td>
<td class="tbl1_cell" style="text-align:left"><textarea name="objective" cols="60" rows="4"></textarea></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">assign to </td>
<td class="tbl1_cell" style="text-align:left"><div class='user-list'>
<?php
$result = mysql_query("SELECT uid FROM team_members WHERE tid='".$Team->tid."'");
while($row = mysql_fetch_assoc($result))
{
	$rc = mysql_query("SELECT handle FROM users WHERE id='".$row['uid']."'");
	$user = mysql_fetch_assoc($rc);
	?><input type="checkbox" name="uid[]" value="<?=$row['uid']?>" class="normal"> <?=$user['handle']?><br />
	<?php
}
?>
</div></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">homepage </td>
<td class="tbl1_cell" style="text-align:left">
<?php FText::showEditor('body'); ?>
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