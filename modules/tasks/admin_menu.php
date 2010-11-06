<?php
/**
 * Menu file for admin menu.
 *
 * Displays admin menu on the top of the content cell.
 *
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/
if($_NAV['module'] != 'tasks')
	return;

if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER) && !$Team->hasRights($Me->uid, TRIGHTS_LEADER))
	return;

echo '<div style="text-align:center">';

if($_NAV['page'] == 'index' || $_NAV['page'] == 'new' || $_NAV['page'] == 'delete')
{
	?>
	|
	<a href="index.php?mod=tasks&page=index&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>">tasks</a> |
	<a href="index.php?mod=tasks&page=new&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>">new task</a> |
	<a href="index.php?mod=tasks&page=delete&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>">delete task</a> |
	<br />
	<?php
}
elseif($_NAV['page'] == 'tsk' || $_NAV['page'] == 'edit')
{
	?>
	|
	<a href="index.php?mod=tasks&page=tsk&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>&taskid=<?=$Task->taskid?>">task home</a> |
	<a href="index.php?mod=tasks&page=edit&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>&taskid=<?=$Task->taskid?>">edit task</a> |
	<br />
	<?php
}
?>
</div>
<br />