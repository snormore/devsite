<?php
/**
 * This is included when a project is deleted.
 *
 * This will delete everything that has to do with the project being
 * deleted from the teams database, and will tell all children to do the same.
 * Note: The variable $Project->pid contains the id of the project to be deleted.
 *		$Project should exist.
 *
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/
if(empty($Project))
	return;

require_once(MODULES_PATH.'teams/Team.php');
$_rc_teams = mysql_query("SELECT id FROM teams WHERE pid='".$Project->pid."'");
while($_row_teams = mysql_fetch_assoc($_rc_teams))
{
	$Team = new Team($_row_teams['id']);
	foreach($Team->children as $child)
	{
		@include(MODULES_PATH.$child.'/team_delete.php');
	}
	unset($Team);
}
mysql_query("DELETE FROM teams WHERE pid='".$Project->pid."'");
?>