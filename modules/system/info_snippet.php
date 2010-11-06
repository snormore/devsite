<?php
/**
 * Information snippet file.
 *
 * Displays current information about user logged in.
 *
 * @package	System
 * @version	0.1
 * @author	Steven Normore
*/

if(!empty($Me))
{
	?>
	<b>User:</b> <?=$Me->handle?>
	<?php
	/* project info */
	if(!empty($_GET['pid']) && !is_array($_GET['pid']))
	{
		require_once(MODULES_PATH.'projects/Project.php');
		$Project = new Project($_GET['pid']);
		echo '<br /><b>Project:</b> '.$Project->name;
		unset($Project);
	}

	/* team info */
	if(!empty($_GET['tid']) && !is_array($_GET['tid']) && !empty($_GET['pid']))
	{
		require_once(MODULES_PATH.'teams/Team.php');
		$Team = new Team($_GET['tid']);
		echo '<br /><b>Team:</b> '.$Team->name;
		unset($Team);
	}

	/* task info */
	if(!empty($_GET['taskid']) && !is_array($_GET['taskid']) && !empty($_GET['tid']) && !empty($_GET['pid']))
	{
		require_once(MODULES_PATH.'tasks/Task.php');
		$Task = new Task($_GET['taskid']);
		echo '<br /><b>Task:</b> '.$Task->name;
		unset($Task);
	}
}
else
	echo 'none';

?>