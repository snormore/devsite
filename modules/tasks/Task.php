<?php
/**#@+
 * Task constants
*/
define('MAX_TASKS_NAME',	50);

/**
 * Task class.
 *
 * Manages a single task object.
 * @package	Tasks
 * @version	0.1
 * @author	Steven Normore
*/
class Task
{
	/**
	 * task id.
	 * @var $taskid integer
	*/
	var $taskid = 0;
	/**
	 * Task name.
	 * @var $name string
	*/
	var $name = '';

	/**
	 * Class constructor.
	 * Initialize task info.
	 * @param integer Project id.
	*/
	function Task($id)
	{
		$this->taskid = $id;
		$result = mysql_query("SELECT name FROM tasks WHERE id='".$id."'");
		$row = mysql_fetch_assoc($result);
		$this->name = $row['name'];
	}

	/**
	 * Returns and array of unassigned tasks for the specified team.
	 * @param	integer Team id.
	 * @return	array	unassigned tasks.
	*/
	function getUnassigned($tid)
	{
		$rc = mysql_query("SELECT id FROM tasks WHERE tid='".$tid."' AND percent!='100'");
		while($row = mysql_fetch_row($rc))
		{
			$rc1 = mysql_query("SELECT uid FROM task_members WHERE taskid='$row[0]'");
			if(mysql_num_rows($rc1) == 0) { $unassigned[] = $row[0]; }
		}
		return $unassigned;
	}

	/**
	 * Returns and array of assigned tasks for the specified team.
	 * @param	integer Team id.
	 * @return	array	assigned tasks.
	*/
	function getAssigned($tid)
	{
		$rc = mysql_query("SELECT id FROM tasks WHERE tid='".$tid."' AND percent!='100'");
		while($row = mysql_fetch_row($rc))
		{
			$rc1 = mysql_query("SELECT uid FROM task_members WHERE taskid='$row[0]'");
			if(mysql_num_rows($rc1) != 0) { $assigned[] = $row[0]; }
		}
		return $assigned;
	}

	/**
	 * Returns and array of completed tasks for the specified team.
	 * @param	integer Team id.
	 * @return	array	completed tasks.
	*/
	function getCompleted($tid)
	{
		$rc = mysql_query("SELECT id FROM tasks WHERE tid='".$_GET['tid']."' AND percent='100'");
		while($row = mysql_fetch_row($rc))
		{
			$completed[] = $row[0];
		}
		return $completed;
	}
}
?>