<?php
/**
 * Register member file.
 *
 * Register new member. Need admin or super admin rights to do this. To
 * register an admin, must have super admin rights.
 *
 * @package	Members
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'members/header.php');
if($ret !== true)
	return;

if(!empty($_POST['submit']))
{
	if(!get_magic_quotes_gpc())
	{
		$_POST['handle'] = addslashes($_POST['handle']);
		$_POST['first'] = addslashes($_POST['first']);
		$_POST['last'] = addslashes($_POST['last']);
		$_POST['country'] = addslashes($_POST['country']);
		$_POST['email'] = addslashes($_POST['email']);
	}
	$error = false;
	$err_msg = array();
	if(empty($_POST['handle']) || strlen($_POST['handle']) > MAX_USERS_HANDLE)
	{
		$error = true;
		$err_msg[] = 'Invalid handle (1 - '.(MAX_USERS_HANDLE).')';
	}
	if(strlen($_POST['first']) > MAX_USERS_FIRST)
	{
		$error = true;
		$err_msg[] = 'Invalid firstname (0 - '.(MAX_USERS_FIRST).')';
	}
	if(strlen($_POST['last']) > MAX_USERS_LAST)
	{
		$error = true;
		$err_msg[] = 'Invalid lastname (0 - '.(MAX_USERS_LAST).')';
	}
	if(strlen($_POST['country']) > MAX_USERS_COUNTRY)
	{
		$error = true;
		$err_msg[] = 'Invalid country (0 - '.(MAX_USERS_COUNTRY).')';
	}
	if(strlen($_POST['email']) > MAX_USERS_EMAIL)
	{
		$error = true;
		$err_msg[] = 'Invalid email (0 - '.(MAX_USERS_EMAIL).')';
	}
	if(mysql_num_rows(mysql_query("SELECT id FROM users WHERE handle='".$_POST['handle']."'")) > 0)
	{
		$error = true;
		$err_msg[] = 'Handle already used';
	}
	if($_POST['pass1'] !== $_POST['pass2'])
	{
		$error = true;
		$err_msg[] = 'Passwords do not match';
	}
	if(empty($_POST['pass1']) || strlen($_POST['pass1']) > MAX_USERS_PASS || addslashes($_POST['pass1']) !== $_POST['pass1'])
	{
		$error = true;
		$err_msg[] = 'Invalid password (0 - '.(MAX_USERS_PASS).'). Password only contain alphanumeric characters and the underscore \'_\'';
	}
	if(!$Me->hasRights(GRIGHTS_SADMIN) && (in_array(GRIGHTS_SADMIN,$_POST['rights']) || in_array(GRIGHTS_ADMIN,$_POST['rights'])))
	{
		$error = true;
		$err_msg[] = 'You must be a super admin to register a super admin or an admin';
	}
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && in_array(GRIGHTS_VIEWALL,$_POST['rights']))
	{
		$error = true;
		$err_msg[] = 'You must be at least an admin register a read-only admin';
	}
	if($error)
	{
		echo '<div class="error">The following erorrs occured:</div><ul type="square">';
		foreach($err_msg as $msg){ echo '<li>'.$msg.'</li>'; }
		echo '</ul>';
		return;
	}

	foreach($_POST['rights'] as $r) { $rights .= $r; }
	if(!get_magic_quotes_gpc())
		$rights = addslashes($rights);

	// everything is ok, so register the user
	$rc = mysql_query("INSERT INTO users (handle,pass,first,last,country,email,created,rights,last_date,last_ip) VALUES ('".$_POST['handle']."','".md5($_POST['pass1'])."','".$_POST['first']."','".$_POST['last']."','".$_POST['country']."','".$_POST['email']."',NOW(),'".$rights."','[first login]','[first login]')");
	if(!$rc)
	{
		echo '<div class="error">Error adding user to database.</div>';
		return;
	}

	header('Location: index.php?mod=members');
	return;
}

?>

<div style="text-align:center">
<form action="index.php?mod=members&page=register" method="post">
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">register member</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">handle </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="handle" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">first name </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="first" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">last name </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="last" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">country </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="country" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">email </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="email" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right;vertical-align:top"><a href="rights.html" target="_blank">rights</a> </td>
<td class="tbl1_cell" style="text-align:left">
<input type="checkbox" name="rights[]" value="s" class="normal" /> super admin<br />
<input type="checkbox" name="rights[]" value="a" class="normal" /> admin<br />
<input type="checkbox" name="rights[]" value="r" class="normal" /> read-only admin<br />
</td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">password </td>
<td class="tbl1_cell" style="text-align:left"><input type="password" name="pass1" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">confirm password </td>
<td class="tbl1_cell" style="text-align:left"><input type="password" name="pass2" value="" /></td>
</tr>
<tr>
<td class='tbl1_footer' colspan="2">
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=members'" />
</td>
</tr>
</table>
</form>
</div>