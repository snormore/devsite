<?php
/**
 * Change my password.
 *
 * Change the password of currently logged in user.
 *
 * @package	System
 * @version	0.1
 * @author	Steven Normore
*/
if(Auth::isAuth() !== true)
	return;

?><div style="text-align:center">
|
<a href="index.php?mod=system&page=myinfo">my info</a> |
<a href="index.php?mod=system&page=myinfo_edit">edit</a> |
<a href="index.php?mod=system&page=myinfo_pass">change password</a> |
</div>
<br />
<?php

if(!empty($_POST['submit']))
{
	$error = false;
	$err_msg = array();
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
	if($error)
	{
		echo '<div class="error">The following erorrs occured:</div><ul type="square">';
		foreach($err_msg as $msg){ echo '<li>'.$msg.'</li>'; }
		echo '</ul>';
		return;
	}

	// everything is ok
	mysql_query("UPDATE users SET pass='".md5($_POST['pass1'])."' WHERE id='".$Me->uid."'");

	echo '<div class="error" style="text-align:center">Your password has been changed. It will take effect the next time you log in.';
	return;
}

?>
<div style="text-align:center">
<form action="index.php?mod=system&page=myinfo_pass" method="post">
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">change password</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">new password </td>
<td class="tbl1_cell" style="text-align:left"><input type="password" name="pass1" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">confirm new password </td>
<td class="tbl1_cell" style="text-align:left"><input type="password" name="pass2" value="" /></td>
</tr>
<tr>
<td class='tbl1_footer' colspan="2">
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=system&page=myinfo'" />
</td>
</tr>
</table>
</form>
</div>