<?php
/**
 * Header file for all project module pages.
 *
 * This page will check to make sure the current project is valid and that
 * you are alowed to view it. Return true if it is, false if not.
 *
 * @package	Projects
 * @version	0.1
 * @author	Steven Normore
*/
if(Auth::isAuth() !== true || empty($_GET['pid']))
	return false;

require_once(MODULES_PATH.'projects/Project.php');
$Project = new Project($_GET['pid']);

/* check per page */
if($_NAV['module'] != 'projects')
	return $Project->isAllowed($Me);

if($_NAV['page'] == 'edit')
{
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER))
		return false;
	return true;
}

return $Project->isAllowed($Me);
?>