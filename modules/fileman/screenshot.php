<?php
/**
 * Output screenshot image.
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

// output image
$result = mysql_query("SELECT screenshot,screenshot_type FROM fm_files WHERE path='".$Fileman->dir."' AND name='".$_GET['fname']."'");
$row = mysql_fetch_assoc($result);
header('Content-type: '.$row['screenshot_type']);
echo $row['screenshot'];
?>