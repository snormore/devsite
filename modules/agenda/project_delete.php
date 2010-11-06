<?php
/**
 * This is included when a project is deleted.
 *
 * This will delete everything that has to do with the project being
 * deleted from the agenda database.
 * Note: The variable $Project->pid contains the id of the project to be deleted.
 *		$Project should exist.
 *
 * @package	Agenda
 * @version	0.1
 * @author	Steven Normore
*/
if(empty($Project))
	return;

mysql_query("DELETE FROM events WHERE pid='".$Project->pid."'");
?>