<?php
/**
 * Main index file for tasks module.
 *
 * This page will display all current tasks for the current team.
 *
 * @package	Tasks
 * @version	0.1
 * @author	Steven Normore
*/

$ret = require(MODULES_PATH.'teams/header.php');
if($ret !== true)
	return;
require_once(MODULES_PATH.'tasks/Task.php');
include(MODULES_PATH.'tasks/admin_menu.php');

$unassigned = Task::getUnassigned($Team->tid);
$assigned = Task::getAssigned($Team->tid);
$completed = Task::getCompleted($Team->tid);
$max_rows = max(count($unassigned), count($assigned), count($completed));
?>
<div style="text-align:center">
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
	<td class="tbl1_cell" style="text-align:left"><a href="./?mod=tasks&page=tsk&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>&taskid=<?=$value?>"><?=$row[0]?></a> (<?=$row[1]?>%)</td>
	</tr>
	<?php
}
for($i = 0; $i < ($max_rows - count($unassigned)); $i++) { ?><tr><td class='tbl1_cell'>&nbsp;</td></tr><?php }
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
	<td class="tbl1_cell" style="text-align:left"><a href="./?mod=tasks&page=tsk&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>&taskid=<?=$value?>"><?=$row[0]?></a> (<?=$row[1]?>%)</td>
	</tr>
	<?php
}
for($i = 0; $i < ($max_rows - count($assigned)); $i++) { ?><tr><td class='tbl1_cell'>&nbsp;</td></tr><?php }
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
	$rc = mysql_query("SELECT name FROM tasks WHERE id='$value'");
	$row = mysql_fetch_row($rc);
	?>
	<tr>
	<td class="tbl1_cell" style="text-align:left"><a href="./?mod=tasks&page=tsk&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>&taskid=<?=$value?>"><?=$row[0]?></a></td>
	</tr>
	<?php
}
for($i = 0; $i < ($max_rows - count($completed)); $i++) { ?><tr><td class='tbl1_cell'>&nbsp;</td></tr><?php }
?>
</table>
</td>
<!-- completed tasks end -->

</tr>
</table>
</div>