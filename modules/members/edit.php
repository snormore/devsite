<?php
/**
 * Edit member file.
 *
 * Edit member info.
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
		$_POST['rights'] = addslashes($_POST['rights']);
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
	if(mysql_num_rows(mysql_query("SELECT id FROM users WHERE handle='".$_POST['handle']."' AND id!='".$User->uid."'")) > 0)
	{
		$error = true;
		$err_msg[] = 'Handle already used';
	}
	if(!$Me->hasRights(GRIGHTS_SADMIN) && (strstr($_POST['rights'],GRIGHTS_SADMIN) || strstr($_POST['rights'],GRIGHTS_ADMIN)))
	{
		$error = true;
		$err_msg[] = 'You must be a super admin to register a super admin or an admin';
	}
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && strstr($_POST['rights'], GRIGHTS_VIEWALL))
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

	// everything is ok, so edit the user
	$rc = mysql_query("UPDATE users SET handle='".$_POST['handle']."',first='".$_POST['first']."',last='".$_POST['last']."',country='".$_POST['country']."',email='".$_POST['email']."',rights='".$_POST['rights']."' WHERE id='".$User->uid."'");

	header('Location: index.php?mod=members&page=details&uid='.$User->uid);
	return;
}

$result = mysql_query("SELECT first,last,country,email,rights FROM users WHERE id='".$User->uid."'");
$row = mysql_fetch_assoc($result);
?>
<div style="text-align:center">
<form action="index.php?mod=members&page=edit&uid=<?=$User->uid?>" method="post">
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">edit member</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">handle </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="handle" value="<?=$User->handle?>" /></td>
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
<?php
if($Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN))
{
	?>
	<tr>
	<td class="tbl1_cell" style="text-align:right;vertical-align:top"><a href="rights.html" target="_blank">rights</a> </td>
	<td class="tbl1_cell" style="text-align:left"><input type="text" name="rights" value="<?=$row['rights']?>" /></td>
	</tr>
	<?php
}
?>
<tr>
<td class='tbl1_footer' colspan="2">
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=members&page=details&uid=<?=$User->uid?>'" />
</td>
</tr>
</table>
</form>
</div>