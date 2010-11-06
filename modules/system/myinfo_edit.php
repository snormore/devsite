<?php
/**
 * Edit my user info.
 *
 * Edit user info of currently logged in user.
 *
 * @package	System
 * @version	0.1
 * @author	Steven Normore
*/
if(Auth::isAuth() !== true)
	return;

if(!empty($_POST['submit']))
{
	if(!get_magic_quotes_gpc())
	{
		$_POST['first'] = addslashes($_POST['first']);
		$_POST['last'] = addslashes($_POST['last']);
		$_POST['country'] = addslashes($_POST['country']);
		$_POST['email'] = addslashes($_POST['email']);
	}
	$error = false;
	$err_msg = array();
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
	if($error)
	{
		echo '<div class="error">The following erorrs occured:</div><ul type="square">';
		foreach($err_msg as $msg){ echo '<li>'.$msg.'</li>'; }
		echo '</ul>';
		return;
	}

	// everything is ok, so edit the user
	$rc = mysql_query("UPDATE users SET first='".$_POST['first']."',last='".$_POST['last']."',country='".$_POST['country']."',email='".$_POST['email']."' WHERE id='".$Me->uid."'");

	header('Location: index.php?mod=system&page=myinfo');
	return;
}

$result = mysql_query("SELECT first,last,country,email FROM users WHERE id='".$Me->uid."'");
$row = mysql_fetch_assoc($result);
?>
<div style="text-align:center">
|
<a href="index.php?mod=system&page=myinfo">my info</a> |
<a href="index.php?mod=system&page=myinfo_edit">edit</a> |
<a href="index.php?mod=system&page=myinfo_pass">change password</a> |
</div>
<br />
<div style="text-align:center">
<form action="index.php?mod=system&page=myinfo_edit" method="post">
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">edit my info</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">handle </td>
<td class="tbl1_cell" style="text-align:left"><?=$Me->handle?></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">first name </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="first" value="<?=$row['first']?>" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">last name </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="last" value="<?=$row['last']?>" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">country </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="country" value="<?=$row['country']?>" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">email </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="email" value="<?=$row['email']?>" /></td>
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