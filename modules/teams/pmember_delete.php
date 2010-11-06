<?php
/**
 * This is included when a member is deleted from the project members section.
 *
 * This will delete everything that has to do with the project member being
 * deleted from the teams database, and will tell all children to do the same.
 * Note: The variable $uid contains the id of the member to be deleted.
 *		$Project should exist.
 *
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/
if(empty($Project) || empty($uid))
	return;

require_once(MODULES_PATH.'teams/Team.php');
$_rc_teams = mysql_query("SELECT id FROM teams WHERE pid='".$Project->pid."'");
while($_row_teams = mysql_fetch_assoc($_rc_teams))
{
	$Team = new Team($_row_teams['id']);
	foreach($Team->children as $child)
	{
		@include(MODULES_PATH.$child.'/tmember_delete.php');
	}
	unset($Team);
	mysql_query("DELETE FROM team_members WHERE uid='".$uid."' AND tid='".$_row_teams['id']."'");
}
?>