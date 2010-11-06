<?php
/**#@+
 * Team constants
*/
define('MAX_TEAMS_NAME',	50);
define('TRIGHTS_LEADER',	'l');

/**
 * Team class.
 *
 * Manages a single team object.
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/
class Team
{
	/**
	 * Team id.
	 * @var $tid integer
	*/
	var $tid = 0;
	/**
	 * Team name.
	 * @var $name string
	*/
	var $name = '';	/**
	 * Array of child modules.
	 * @var $test array
	*/
	var $children = array(
		'tasks'
	);

	/**
	 * Class constructor.
	 * Initialize team info.
	 * @param integer Project id.
	*/
	function Team($id)
	{
		$this->tid = $id;
		$result = mysql_query("SELECT name FROM teams WHERE id='".$id."'");
		$row = mysql_fetch_assoc($result);
		$this->name = $row['name'];
	}

	/**
	 * Determines if the user has any of these team rights.
	 * @param	integer	user id to check.
	 * @param	string	string of rights
	 * @return	boolean	Wheather user has any of the rights or not.
	*/
	function hasRights($uid, $rights)
	{
		$result = mysql_query("SELECT rights FROM team_members WHERE tid='".$this->tid."' AND uid='".$uid."'");
		$row = mysql_fetch_assoc($result);
		for($i = 0; $i < strlen($rights); $i++)
			if(strstr($row['rights'], $rights{$i}))
				return true;
		return false;
	}

	/**
	 * Show teams.
	 * Show all teams in the output format specified.
	 * @param	object	UserInfo object of the user you want to show the
	 * teams to.
	 * @param	string	Output format to show the teams in.
	*/
	function showTeams($output)
	{
		global $Project;

		$search = array(
			'%i',	// team id
			'%p',	// project id
			'%n',	// team name
			'%d',	// team description
			'%m'	// number of members
		);

		$result = mysql_query("SELECT * FROM teams WHERE pid='".$Project->pid."'");

		while($row = mysql_fetch_assoc($result))
		{
			$replace = array(
				$row['id'],
				$Project->pid,
				$row['name'],
				$row['description'],
				mysql_num_rows(mysql_query("SELECT uid FROM team_members WHERE tid='".$row['id']."'"))
			);
			echo str_replace($search, $replace, $output);
		}
	}
}
?>