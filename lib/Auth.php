<?php
/**
 * Authentication package
 *
 * @package	Authentication
 * @version	0.1
 * @author	Steven Normore
*/

/**
 * Include configuration file.
 *
 * The following information is required from this file.
 * - string $COOKIE_NAME, name of cookie.
 * - string $COOKIE_KEY, key for cookie encryption.
*/
require_once('config.php');

/**
 * Auth class.
 *
 * Class to manage the authentication of users.
*/
class Auth
{
	/**
	 * Checks to see if current user is logged in.
	 *
	 * @return  boolean true if user is logged in, false if not.
	*/
	function isAuth()
	{
		static $is_auth;
		
		if(isset($is_auth))
			return $is_auth;
		if(empty($_COOKIE[COOKIE_NAME]))
		{
			$is_auth = false;
			return $is_auth;
		}
		$mac = md5(COOKIE_KEY . md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . COOKIE_KEY));
		if(strncmp($mac, $_COOKIE[COOKIE_NAME], strlen($mac)) == 0)
			$is_auth = true;
		else
			$is_auth = false;
		return $is_auth;
	}

	/**
	 * Login, set cookie and update database.
	 *
	 * @param	integer User ID, from database, to be logged in.
	*/
	function doLogin($uid)
	{
		$mac = md5(COOKIE_KEY . md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . COOKIE_KEY)) . ':' . $uid;
		setcookie(COOKIE_NAME, $mac, 0, '/', '', 0);
		mysql_query("UPDATE users SET last_date=NOW(), last_ip='".$_SERVER['REMOTE_ADDR']."' WHERE id='".$uid."'");
	}

	/**
	 * Logout, unset cookie.
	*/
	function doLogout()
	{
		setcookie(COOKIE_NAME, '', time()-3600, '/', '', 0);
	}

	/**
	 * Gets and returns the currently logged in users id.
	 *
	 * @return  integer id of user currently logged in, or false on failure.
	*/
	function getUserId()
	{
		$mac = md5(COOKIE_KEY . md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . COOKIE_KEY));
		if(empty($_COOKIE[COOKIE_NAME]) || strncmp($mac, $_COOKIE[COOKIE_NAME], strlen($mac)) != 0)
			return 0;
		$a_cookie = explode(':', $_COOKIE[COOKIE_NAME]);
		$uid = $a_cookie[sizeof($a_cookie)-1];
		return (is_numeric($uid) ? $uid : 0);
	}

	/**
	 * Checks the data input by a user to see if it is valid.
	 *
	 * @return  mixed	users id on success, false on failure.
	*/
	function checkUser($handle, $password)
	{
		$result = mysql_query("SELECT id FROM users WHERE handle='".$handle."' AND pass='".md5($password)."'");
		$row = mysql_fetch_assoc($result);
		if($row)
			return $row['id'];
		else
			return 0;
	}

	/**
	 * Generate random password.
	 * @return  string password
	*/
	function randomPass($length = 8)
	{
		$password = "";
		$possible = "0123456789abcdefghijklmnopqrstuvwxyz";

		while($i < $length)
		{
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
			if(!strstr($password, $char))
			{
				$password .= $char;
				$i++;
			}
		}
		return $password;
	}
}
?>