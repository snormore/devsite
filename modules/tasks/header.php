<?php
/**
 * Header file for all tasks module pages.
 *
 * This page will check to make sure the current task is valid and that
 * you are alowed to view it. Return true if it is, false if not.
 *
 * @package	Tasks
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'teams/header.php');	// weird, gotta do it this way
if($ret !== true)
	return false;

if(empty($_GET['taskid']))
	return false;

/* make sure task is actually a member of the team id given */
$result = mysql_query("SELECT id FROM tasks WHERE tid='".$Team->tid."' AND id='".$_GET['taskid']."'");
if(mysql_num_rows($result) != 1)
	return false;

require_once(MODULES_PATH.'tasks/Task.php');
$Task = new Task($_GET['taskid']);

/* check per page */
if($_NAV['page'] == 'edit')
{
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER) && !$Team->hasRights($Me->uid, TRIGHTS_LEADER))
		return false;
	return true;
}
return true;
?>