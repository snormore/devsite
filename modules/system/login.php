<?php
/**
 * Login file.
 *
 * This file contains the html for the login process, and also the call to actually
 * login.
 *
 * @package	System
 * @version	0.1
 * @author	Steven Normore
*/
if(!empty($_POST['submit']))
{
	$id = Auth::checkUser($_POST['handle'], $_POST['pass']);
	if($id > 0)
	{
		Auth::doLogin($id);
		header('Location: ./index.php?mod='.$Module->name );
	}
	else
		echo '<div class="error" style="text-align:center">Login failed.</div>';
}
?>
<div style="text-align:center">
<form action="./index.php?mod=system&page=login" method="post">
<table cellspacing="0" class="tbl1">
<tr><td colspan="2" class="tbl1_header">login</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">handle </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="handle" value="" size="10" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">password </td>
<td class="tbl1_cell" style="text-align:left"><input type="password" name="pass" value="" size="10" /></td>
</tr>
<tr><td colspan="2" class="tbl1_cell" style="text-align:center"><input type="submit" name="submit" value="login" /></td></tr>
</table>
</form>
<a href='#'>Forgot Your Password?</a>
</div>
