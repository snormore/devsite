<?php
/**
 * Root folder coniguration file.
 *
 * @package	DevSite
 * @version	0.1
 * @author	Steven Normore
*/

/**#@+
 * Location constants.
 * 
 * These constants contain the locations of the main parts of the system
 * relative to the root directory.
*/
define('THEME_PATH',	'themes/default/');
define('MODULES_PATH',	'modules/');
define('LIB_PATH',		'lib/');

/**#@+
 * Authentication constants.
 * @access private
*/
define('COOKIE_NAME', '<==COOKIE_NAME==>');
define('COOKIE_KEY', '<==COOKIE_KEY==>');

/**
 * MySQL database hostname
 * @var $db_host	string
*/
$db_host = '<==DB_HOST==>';
/**
 * MySQL database username.
 * @var $db_user	string
*/
$db_user = '<==DB_USER==>';
/**
 * MySQL database password.
 * @var $db_pass	string
*/
$db_pass = '<==DB_PASS==>';
/**
 * MySQL database, database name.
 * @var $db_dbname	string
*/
$db_dbname = '<==DB_DBNAME==>';

/**
 * Array containing modules that are installed.
 * @var $_modules array
*/
$_modules = array(
	'system',
	'members',
	'projects',
	'teams',
	'tasks',
	'agenda',
	'fileman',
	'forum',
	'links',
	'bookmarks'
);

/**
 * Array containing pages for each module.
 * @var $_pages array
*/
$_pages = array(
	'system'=>array(
		'index',
		'login',
		'logout',
		'myinfo',
		'myinfo_edit',
		'myinfo_pass'
	),
	'members'=>array(
		'index',
		'register',
		'delete',
		'details',
		'edit',
		'changepass'
	),
	'projects'=>array(
		'index',
		'proj',
		'new',
		'delete',
		'edit',
		'members',
		'm_new',
		'm_delete'
	),
	'teams'=>array(
		'index',
		'tm',
		'new',
		'delete',
		'edit',
		'members',
		'm_new',
		'm_delete',
		'm_edit'
	),
	'tasks'=>array(
		'index',
		'tsk',
		'new',
		'delete',
		'edit'
	),
	'agenda'=>array(
		'index',
		'day',
		'event',
		'new_event',
		'edit_event',
		'delete_event',
		'events'
	),
	'fileman'=>array(
		'index',
		'newfolder',
		'upload',
		'file',
		'delete',
		'edit'
	),
	'forum'=>array(
		'index',
		'reply',
		'edit',
		'delete'
	),
	'links'=>array(
		'index',
		'new',
		'delete'
	),
	'bookmarks'=>array(
		'index',
		'new',
		'delete'
	)
);
?>