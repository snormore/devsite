<?php
/**
 * Header file for all teams module pages.
 *
 * This page will check to make sure the current team is valid and that
 * you are alowed to view it. Return true if it is, false if not.
 *
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');	// weird, gotta do it this way
if($ret !== true)
	return false;

if(empty($_GET['tid']))
	return false;

/* make sure team is actual a member of the projct id given */
$result = mysql_query("SELECT id FROM teams WHERE pid='".$Project->pid."' AND id='".$_GET['tid']."'");
if(mysql_num_rows($result) != 1)
	return false;

require_once(MODULES_PATH.'teams/Team.php');
$Team = new Team($_GET['tid']);

/* check per page */
if($_NAV['page'] == 'edit' || $_NAV['page'] == 'm_new' || $_NAV['page'] == 'm_delete' || $_NAV['page'] == 'm_edit')
{
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER) && !$Team->hasRights($Me->uid, TRIGHTS_LEADER))
		return false;
	return true;
}
return true;
?>