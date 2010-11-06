<?php
/**
 * Team members file.
 *
 * Show all team members.
 *
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'teams/header.php');
if($ret !== true)
	return;

include(MODULES_PATH.'teams/admin_menu.php');
?>
<div style="text-align:center">
<table class="tbl1">
<tr>
<td class="tbl1_header">handle</td>
<td class="tbl1_header">name</td>
<td class="tbl1_header">occupation</td>
</tr>
<?php
$result = mysql_query("SELECT uid,job FROM team_members WHERE tid='".$Team->tid."'");
while($row = mysql_fetch_assoc($result))
{
	$rc = mysql_query("SELECT handle,first,last FROM users WHERE id='".$row['uid']."'");
	$user = mysql_fetch_assoc($rc);
	?><tr>
	<td class="tbl1_cell"><?=$user['handle']?></td>
	<td class="tbl1_cell"><?=$user['last'].', '.$user['first']?></td>
	<td class="tbl1_cell"><?=$row['job']?></td>
	</tr>
	<?php
}
?>
</table>
</div>