<?php
/**
 * This is included when a member is deleted from the team members section.
 *
 * This will delete everything that has to do with the team member being
 * deleted from the tasks database, and will tell all children to do the same.
 * Note: The variable $uid contains the id of the member to be deleted.
 *		$Project should exist.
 *		$Team should exist.
 *
 * @package	Tasks
 * @version	0.1
 * @author	Steven Normore
*/
if(empty($Team) || empty($Project) || empty($uid))
	return;

$_rc_tasks = mysql_query("SELECT id FROM tasks WHERE tid='".$Team->tid."'");
while($_row_tasks = mysql_fetch_assoc($_rc_tasks))
{
	mysql_query("DELETE FROM task_members WHERE uid='".$uid."' AND taskid='".$_row_tasks['id']."'");
}
?>