<?php
/**
 * Delete task file.
 *
 * Deletes a task.
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

require_once(MODULES_PATH.'tasks/Task.php');
include(MODULES_PATH.'tasks/admin_menu.php');

if(!empty($_POST['submit']))
{
	if(!is_array($_POST['taskid']))
		header('Location: index.php?mod=tasks&pid='.$Project->pid.'&tid='.$Team->tid);
	foreach($_POST['taskid'] as $id)
	{
		if(is_numeric($id))
		{
			mysql_query("DELETE FROM task_members WHERE taskid='".$id."'");
			mysql_query("DELETE FROM tasks WHERE id='".$id."'");
		}
	}
	header('Location: index.php?mod=tasks&pid='.$Project->pid.'&tid='.$Team->tid);
	return;
}

$unassigned = Task::getUnassigned($Team->tid);
$assigned = Task::getAssigned($Team->tid);
$completed = Task::getCompleted($Team->tid);
$max_rows = max(count($unassigned), count($assigned), count($completed));
?>
<div style="text-align:center">
<form action="./?mod=tasks&page=delete&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>" method="post">
<table cellpadding="0" cellspacing="0" border="0" class="tbl1">

<tr>
<td class="tbl1_header">unassigned (<?=count($unassigned)?>)</td>
<td class="tbl1_header">assigned (<?=count($assigned)?>)</td>
<td class="tbl1_header">completed (<?=count($completed)?>)</td>
</tr>
<tr>

<!-- unassigned tasks start -->
<td>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<?php
foreach($unassigned as $value)
{
	$rc = mysql_query("SELECT name,percent FROM tasks WHERE id='$value'");
	$row = mysql_fetch_row($rc);
	?>
	<tr>
	<td class="tbl1_cell"><input type="checkbox" name="taskid[]" value="<?=$value?>" class="normal" /></td>
	<td class="tbl1_cell"><a href="index.php?mod=tasks&page=tsk&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>&taskid=<?=$value?>"><?=$row[0]?></a> (<?=$row[1]?>%)</td>
	</tr>
	<?php
}
for($i = 0; $i < ($max_rows - count($unassigned)); $i++) { ?><tr><td class="tbl1_cell"><input type="checkbox" class="normal" disabled="disabled" /></td><td class='tbl1_cell'>&nbsp;</td></tr><?php }
?>
</table>
</td>
<!-- unassigned tasks end -->

<!-- assigned tasks start -->
<td>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<?php
foreach($assigned as $value)
{
	$rc = mysql_query("SELECT name,percent FROM tasks WHERE id='$value'");
	$row = mysql_fetch_row($rc);
	?>
	<tr>
	<td class="tbl1_cell"><input type="checkbox" name="taskid[]" value="<?=$value?>" class="normal" /></td>
	<td class="tbl1_cell"><a href="index.php?mod=tasks&page=tsk&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>&taskid=<?=$value?>"><?=$row[0]?></a> (<?=$row[1]?>%)</td>
	</tr>
	<?php
}
for($i = 0; $i < ($max_rows - count($assigned)); $i++) { ?><tr><td class="tbl1_cell"><input type="checkbox" class="normal" disabled="disabled" /></td><td class='tbl1_cell'>&nbsp;</td></tr><?php }
?>
</table>
</td>
<!-- assigned tasks end -->

<!-- completed tasks start -->
<td>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<?php
foreach($completed as $value)
{
	$rc = mysql_query("SELECT name,percent FROM tasks WHERE id='$value'");
	$row = mysql_fetch_row($rc);
	?>
	<tr>
	<td class="tbl1_cell"><input type="checkbox" name="taskid[]" value="<?=$value?>" class="normal" /></td>
	<td class="tbl1_cell"><a href="index.php?mod=tasks&page=tsk&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>&taskid=<?=$value?>"><?=$row[0]?></a> (<?=$row[1]?>%)</td>
	</tr>
	<?php
}
for($i = 0; $i < ($max_rows - count($completed)); $i++) { ?><tr><td class="tbl1_cell"><input type="checkbox" class="normal" disabled="disabled" /></td><td class='tbl1_cell'>&nbsp;</td></tr><?php }
?>
</table>
</td>
<!-- completed tasks end -->

</tr>
<tr>
<td class='tbl1_footer' colspan="3">
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=tasks&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>'" />
</td>
</tr>
</table>
</form>
</div>