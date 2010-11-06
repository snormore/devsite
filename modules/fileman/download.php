<?php
/**
 * Download file.
 *
 * @package	Fileman
 * @version	0.1
 * @author	Steven Normore
*/
chdir('../../');	// devsite root
require_once('config.php');
require_once(LIB_PATH.'Auth.php');
require_once(LIB_PATH.'UserInfo.php');

// connect to mysql database
$dbh = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_dbname, $dbh);

if(!Auth::isAuth())
	return;
$Me = new UserInfo(Auth::getUserId());

$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;
require_once(MODULES_PATH.'fileman/Fileman.php');
if(empty($_GET['dir']))
	$_GET['dir'] = './';
$Fileman = new Fileman($Project, $_GET['dir']);

if(!get_magic_quotes_gpc())
	$_GET['fname'] = addslashes($_GET['fname']);
if(!Fileman::checkFilename($_GET['fname']))
	return;

// start
$cwd = getcwd();
chdir(FM_ROOT_PATH.$Project->pid);

// Set headers for download
header('Cache-control: max-age=31536000');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');           // date in the past
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');  // always modified
header('Content-type: application/octet-stream');
$attachment = strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE 5.5') ? '' : ' attachment;';
header('Content-Disposition:'.$attachment.' filename='.basename($_GET['fname']));
header('Content-length: '.filesize($Fileman->dir.$_GET['fname']));
header('Content-Transfer-Encoding: binary');
readfile($Fileman->dir.$_GET['fname']);

// Tested in: IE 6 Netscape 6.01 Netscape 6.2.1 Mozilla Opera Netscape 4

chdir($cwd);
?>