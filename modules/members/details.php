<?php
/**
 * Member details file.
 *
 * Displays information about a user.
 *
 * @package	Members
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'members/header.php');
if($ret !== true)
	return;

$result = mysql_query("SELECT first,last,country,email,rights FROM users WHERE id='".$User->uid."'");
$row = mysql_fetch_assoc($result);
?>
<div style="text-align:center">
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">member info</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">handle </td>
<td class="tbl1_cell" style="text-align:left"><?=$User->handle?></td>
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