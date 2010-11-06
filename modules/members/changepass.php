<?php
/**
 * Change password of member file.
 *
 * Change the pass of a member.
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
	$rc = mysql_query("UPDATE users SET pass='".md5($_POST['pass1'])."' WHERE id='".$User->uid."'");

	header('Location: index.php?mod=members&page=details&uid='.$User->uid);
	return;
}

?>
<div style="text-align:center">
<form action="index.php?mod=members&page=changepass&uid=<?=$User->uid?>" method="post">
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
<input type='button' value='Cancel' onClick="window.location='index.php?mod=members&page=details&uid=<?=$User->uid?>'" />
</td>
</tr>
</table>
</form>
</div>