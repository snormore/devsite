<?php
/**
 * My user info.
 *
 * User info of currently logged in user.
 *
 * @package	System
 * @version	0.1
 * @author	Steven Normore
*/
if(Auth::isAuth() !== true)
	return;

$result = mysql_query("SELECT first,last,country,email,rights FROM users WHERE id='".$Me->uid."'");
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
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">my info</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">handle </td>
<td class="tbl1_cell" style="text-align:left"><?=$Me->handle?></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">first name </td>
<td class="tbl1_cell" style="text-align:left"><?=$row['first']?></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">last name </td>
<td class="tbl1_cell" style="text-align:left"><?=$row['last']?></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">country </td>
<td class="tbl1_cell" style="text-align:left"><?=$row['country']?></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">email </td>
<td class="tbl1_cell" style="text-align:left"><?=$row['email']?></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right;vertical-align:top"><a href="rights.html" target="_blank">rights</a> </td>
<td class="tbl1_cell" style="text-align:left"><?=$row['rights']?></td>
</tr>
</table>
</div>