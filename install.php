<?php
/**
 * DevSite installation file.
 *
 * This file installs DevSite. It will initialize everything that needs to be
 * initialized, which includes creating all of the necessary tables in the
 * database and creating the first super admin user.
 *
 * @package	DevSite
 * @version	0.1
 * @author	Steven Normore
*/

if(file_exists('install.lock'))
	return;
?>
<html>
<head>
<title>DevSite Installation</title>
</head>
</head>
<body>

<?php
if(!empty($_POST['submit']))
{
	$errors = array();

	// MySQL Info
	if(empty($_POST['db_host']))
		$errors[] = 'MySQL Host';
	if(empty($_POST['db_user']))
		$errors[] = 'MySQL User';
	if(empty($_POST['db_pass']))
		$errors[] = 'MySQL Password';
	if(empty($_POST['db_dbname']))
		$errors[] = 'MySQL Database Name';

	// Security
	if(empty($_POST['cookie_name']))
		$errors[] = 'Cookie Name';
	if(empty($_POST['cookie_key']))
		$errors[] = 'Cookie Key';

	// Admin Registration
	if(empty($_POST['handle']))
		$errors[] = 'Admin Handle';
	if(empty($_POST['pass1']) || empty($_POST['pass2']))
		$errors[] = 'Password';

	// Check for errors
	if(count($errors))
	{
		echo 'The following fields were invalid,<br /><ul>';
		foreach($errors as $value)
			echo '<li>'.$value.'</li>';
		echo '</body></html>';
		return;
	}

	if($_POST['pass1'] !== $_POST['pass2'])
	{
		echo '<b>Passwords don\'t match.</b>';
		echo '</body></html>';
		return;
	}

	// Connect to MySQL database
	if(!mysql_connect($_POST['db_host'], $_POST['db_user'], $_POST['db_pass']))
	{
		echo '<b>Unable to connect to database.</b>';
		echo '</body></html>';
		return;
	}
	if(!mysql_query("CREATE DATABASE `".$_POST['db_dbname']."`"))
	{
		echo '<b>Error creating database "'.$_POST['db_dbname'].'"</b><br />'.mysql_error();
		echo '</body></html>';
		return;
	}
	mysql_select_db($_POST['db_dbname']);

	// Create MySQL tables
	$handle = fopen('install.sql', 'r');
	$sql = '';
	$i = 0;
	while(!feof($handle))
	{
		$i++;
		$line = fgets($handle);
		$tline = trim($line);
		if($tline[0] != '#' && !empty($tline))
			$sql .= $line;
		$tsql = trim($sql);
		if(strlen($tsql) && $tsql[strlen($tsql)-1] == ';')
		{
			if(!mysql_query($sql))
			{
				echo '<b>MySQL error occured in "install.sql" on line '.$i.'</b><br />';
				echo mysql_error();
				echo '</body></html>';
				return;
			}
			$sql = '';
		}
	}
	fclose($handle);

	// Add admin to database
	mysql_query("INSERT INTO users (handle,pass,first,last,email,country,created,rights) VALUES ('".$_POST['handle']."','".md5($_POST['pass1'])."','".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['email']."','".$_POST['country']."',NOW(),'s')");

	// Insert info into config file
	$CONFIG = 'config.php';
	$handle = fopen($CONFIG, 'rb');
	if(!$handle)
	{
		echo 'Unable to open config file, "'.$CONFIG.'"';
		echo '</body></html>';
		return;
	}
	$buffer = fread($handle, filesize($CONFIG));
	$buffer = str_replace('<==COOKIE_NAME==>', $_POST['cookie_name'], $buffer);
	$buffer = str_replace('<==COOKIE_KEY==>', $_POST['cookie_key'], $buffer);
	$buffer = str_replace('<==DB_HOST==>', $_POST['db_host'], $buffer);
	$buffer = str_replace('<==DB_USER==>', $_POST['db_user'], $buffer);
	$buffer = str_replace('<==DB_PASS==>', $_POST['db_pass'], $buffer);
	$buffer = str_replace('<==DB_DBNAME==>', $_POST['db_dbname'], $buffer);
	fclose($handle);
	rename($CONFIG, 'config.bak.php');
	touch($CONFIG);
	$handle = fopen($CONFIG, 'wb');
	fwrite($handle, $buffer);
	fclose($handle);

	touch('install.lock');

	echo '<h3>Installation successful</h3><br />';
	echo 'Please delete the files "install.php" and "install.sql" for security reasons.';
	echo '</body></html>';
	return;
}
?>
<form action="install.php" method="post">
<div style="text-align:center">
* Required Fields
<br /><br />

<table cellpadding="5" cellspacing="0" border="0" style="border:solid 1pt #000000;margin:auto">
<tr><td colspan="2" style="text-align:center;background-color:#003366;color:#FFFFFF;border-bottom:solid 1pt #000000">MySQL Database Information</td></tr>
<tr>
<td style="text-align:right">Host* </td>
<td style="text-align:left"><input type="text" name="db_host" value="" /></td>
</tr>
<tr>
<td style="text-align:right">User* </td>
<td style="text-align:left"><input type="text" name="db_user" value="" /></td>
</tr>
<tr>
<td style="text-align:right">Password* </td>
<td style="text-align:left"><input type="text" name="db_pass" value="" /></td>
</tr>
<tr>
<td style="text-align:right">Database Name* </td>
<td style="text-align:left"><input type="text" name="db_dbname" value="devsite" /></td>
</tr>
</table>

<br /><br />

<table cellpadding="5" cellspacing="0" border="0" style="border:solid 1pt #000000;margin:auto">
<tr><td colspan="2" style="text-align:center;background-color:#003366;color:#FFFFFF;border-bottom:solid 1pt #000000">Security</td></tr>
<tr>
<td style="text-align:right">Cookie Name* </td>
<td style="text-align:left"><input type="text" name="cookie_name" value="devsite" /></td>
</tr>
<tr>
<td style="text-align:right">Secret Cookie Key* </td>
<td style="text-align:left"><input type="text" name="cookie_key" value="" /></td>
</tr>
</table>

<br /><br />

<table cellpadding="5" cellspacing="0" border="0" style="border:solid 1pt #000000;margin:auto">
<tr><td colspan="2" style="text-align:center;background-color:#003366;color:#FFFFFF;border-bottom:solid 1pt #000000">Admin Registration</td></tr>
<tr>
<td style="text-align:right">Handle* </td>
<td style="text-align:left"><input type="text" name="handle" value="" /></td>
</tr>
<tr>
<td style="text-align:right">First Name </td>
<td style="text-align:left"><input type="text" name="firstname" value="" /></td>
</tr>
<tr>
<td style="text-align:right">Last Name </td>
<td style="text-align:left"><input type="text" name="lastname" value="" /></td>
</tr>
<tr>
<td style="text-align:right">Email </td>
<td style="text-align:left"><input type="text" name="email" value="" /></td>
</tr>
<tr>
<td style="text-align:right">Country </td>
<td style="text-align:left"><input type="text" name="country" value="" /></td>
</tr>
<tr>
<td style="text-align:right">Password* </td>
<td style="text-align:left"><input type="text" name="pass1" value="" /></td>
</tr>
<tr>
<td style="text-align:right">Confirm Password* </td>
<td style="text-align:left"><input type="text" name="pass2" value="" /></td>
</tr>
</table>

<br /><br />
<input type="submit" name="submit" value="Install" />
<input type="reset" value="Reset" />

</div>
</form>

</body>
</html>