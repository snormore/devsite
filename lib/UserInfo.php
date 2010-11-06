<?php
/**
 * User class.
 *
 * This class manages the info of a user. Usually used for currently
 * logged in user. Note: Must be connected to MySQL database before using
 * this class.
 *
 * @package	DevSite
 * @version	0.1
 * @author	Steven Normore
*/

/**#@+
 * Glabal rights constants
*/
define('GRIGHTS_SADMIN',	's');	// super admin
define('GRIGHTS_ADMIN',		'a');	// admin
define('GRIGHTS_VIEWALL',	'r');	// read-only admin access

/**#@+
 * Size constants
*/
define('MAX_USERS_HANDLE',  30);
define('MAX_USERS_PASS',    20);
define('MAX_USERS_FIRST',   30);
define('MAX_USERS_LAST',    30);
define('MAX_USERS_COUNTRY', 30);
define('MAX_USERS_EMAIL',   80);
define('MAX_USERS_RIGHTS',  20);
define('MAX_USERS_LASTIP',  20);

class UserInfo
{
	/**
	 * User id.
	 * @var $uid integer.
	*/
	var $uid = 0;

	/**
	 * User handle/nickname.
	 * @var $handle string.
	*/
	var $handle = '';

	/**
	 * Users global rights.
	 * @var $rights string.
	*/
	var $global_rights = '';

	/**
	 * Class constructor.
	 *
	 * Initialize some general user info.
	 * @param integer user id
	*/
	function UserInfo($uid)
	{
		$result = mysql_query("SELECT handle,rights FROM users WHERE id='".$uid."'");
		$row = mysql_fetch_assoc($result);
		$this->uid = $uid;
		$this->handle = $row['handle'];
		$this->global_rights = $row['rights'];
	}

	/**
	 * Returns last ip logged in with.
	 * @return integer last ip
	*/
	function getLastIP()
	{
		$result = mysql_query("SELECT last_ip FROM users WHERE id='".$this->uid."'");
		$row = mysql_fetch_assoc($result);
		return $row['last_ip'];
	}

	/**
	 * Returns last date logged in.
	 * @return string last date
	*/
	function getLastDate()
	{
		$result = mysql_query("SELECT last_date FROM users WHERE id='".$this->uid."'");
		$row = mysql_fetch_assoc($result);
		return $row['last_date'];
	}

	/**
	 * Determines if the user has any of these gobal rights.
	 * @param	string	string of rights
	 * @return	boolean	Wheather user has any of the rights or not.
	*/
	function hasRights($rights)
	{
		for($i = 0; $i < strlen($rights); $i++)
			if(strstr($this->global_rights, $rights{$i}))
				return true;
		return false;
	}
}
?>