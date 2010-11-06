<?php
/**
 * This is included when a team is deleted.
 *
 * This will delete everything that has to do with the team being
 * deleted from the tasks database, and will tell all children to do the same.
 * Note: The variable $Team->tid contains the id of the team being.
 *
 * @package	Tasks
 * @version	0.1
 * @author	Steven Normore
*/
if(empty($Team))
	return;

$_rc_tasks = mysql_query("SELECT id FROM tasks WHERE tid='".$Team->tid."'");
while($_row_tasks = mysql_fetch_assoc($_rc_tasks))
{
	mysql_query("DELETE FROM task_members WHERE taskid='".$_row_tasks['id']."'");
}
mysql_query("DELETE FROM tasks WHERE tid='".$Team->tid."'");
?>