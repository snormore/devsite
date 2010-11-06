<?php
/**
 * This is included when a member is deleted from the main devsite.
 *
 * This will delete everything that has to do with the member being deleted
 * from the projects database, and will tell all children to do the same.
 * Note: The variable $uid contains the id of the member to be deleted.
 *
 * @package	Projects
 * @version	0.1
 * @author	Steven Normore
*/
if(empty($uid))
	return;

require_once(MODULES_PATH.'projects/Project.php');
$_rc_projects = mysql_query("SELECT pid FROM project_members WHERE uid='".$uid."'");
while($_row_projects = mysql_fetch_assoc($_rc_projects))
{
	$Project = new Project($_row_projects['pid']);
	foreach($Project->children as $child)
	{
		@include(MODULES_PATH.$child.'/pmember_delete.php');
	}
	unset($Project);
}
mysql_query("DELETE FROM project_members WHERE uid='".$uid."'");
?>