<?php
/**#@+
 * Project constants
 * @package Projects
*/
define('MAX_PROJECTS_NAME',	50);
define('PRIGHTS_LEADER',	'l');

/**
 * Project class.
 *
 * Manages a single project object.
 * @package	Projects
 * @version	0.1
 * @author	Steven Normore
*/
class Project
{
	/**
	 * Project id.
	 * @var $pid integer
	*/
	var $pid = 0;
	/**
	 * Project name.
	 * @var $name string
	*/
	var $name = '';
	/**
	 * Array of child modules.
	 * @var $test array
	*/
	var $children = array(
		'teams',
		'fileman',
		'agenda',
		'forum'
	);

	/**
	 * Class constructor.
	 * Initialize project info.
	 * @param integer Project id.
	*/
	function Project($id)
	{
		$this->pid = $id;
		$result = mysql_query("SELECT name FROM projects WHERE id='".$id."'");
		$row = mysql_fetch_assoc($result);
		$this->name = $row['name'];
	}

	/**
	 * Determines if user is allowed access to current project.
	 * @param	object	UserInfo object of the user you want to check against.
	 * @return	boolean	Wheather user is allowed to access the project.
	*/
	function isAllowed($User)
	{
		if(mysql_num_rows(mysql_query("SELECT id FROM projects WHERE id='".$this->pid."'")) == 0)
			return false;
		if($User->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN.GRIGHTS_VIEWALL))
			return true;
		$result = mysql_query("SELECT uid FROM project_members WHERE uid='".$User->uid."' AND pid='".$this->pid."'");
		if(mysql_num_rows($result) > 0)
			return true;
		else
			return false;
	}

	/**
	 * Determines if the user has any of these project rights.
	 * @param	integer	user id to check.
	 * @param	string	string of rights
	 * @return	boolean	Wheather user has any of the rights or not.
	*/
	function hasRights($uid, $rights)
	{
		$result = mysql_query("SELECT rights FROM project_members WHERE pid='".$this->pid."' AND uid='".$uid."'");
		$row = mysql_fetch_assoc($result);
		for($i = 0; $i < strlen($rights); $i++)
			if(strstr($row['rights'], $rights{$i}))
				return true;
		return false;
	}

	/**
	 * Show projects.
	 * Show all projects in the output format specified.
	 * @param	object	UserInfo object of the user you want to show the
	 * projecs to.
	 * @param	string	Output format to show the projects in.
	*/
	function showProjects($User, $output)
	{
		$search = array(
			'%i',	// project id
			'%n',	// project name
			'%d',	// project description
			'%m'	// number of members
		);

		if($User->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN.GRIGHTS_VIEWALL))
			$result = mysql_query("SELECT * FROM projects");
		else
			$result = mysql_query("SELECT * FROM projects,project_members WHERE project_members.pid=projects.id AND project_members.uid='".$User->uid."'");

		while($row = mysql_fetch_assoc($result))
		{
			$replace = array(
				$row['id'],
				$row['name'],
				$row['description'],
				mysql_num_rows(mysql_query("SELECT uid FROM project_members WHERE pid='".$row['id']."'"))
			);
			echo str_replace($search, $replace, $output);
		}
	}
}
?>