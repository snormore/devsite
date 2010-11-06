<?php
/**
 * This is included when a project is deleted.
 *
 * This will delete everything that has to do with the project being
 * deleted from the forum database.
 * Note: The variable $Project->pid contains the id of the project to be deleted.
 *		$Project should exist.
 *
 * @package	Forum
 * @version	0.1
 * @author	Steven Normore
*/
if(empty($Project))
	return;

mysql_query("DELETE FROM forum WHERE pid='".$Project->pid."'");
?>