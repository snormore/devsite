<?php
/**
 * Project members file.
 *
 * Show all project members.
 *
 * @package	Projects
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;

include(MODULES_PATH.'projects/admin_menu.php');
?>
<div style="text-align:center">
<span style="background-color:#CCFF99;font-weight:bold;padding:5px 5px 5px 5px">Project Leader</span>
<br /><br />
<table class="tbl1">
<tr>
<td class="tbl1_header">handle</td>
<td class="tbl1_header">name</td>
</tr>
<?php
$result = mysql_query("SELECT uid FROM project_members WHERE pid='".$Project->pid."'");
while($row = mysql_fetch_assoc($result))
{
	$rc = mysql_query("SELECT handle,first,last FROM users WHERE id='".$row['uid']."'");
	$user = mysql_fetch_assoc($rc);
	?><tr>
	<td class="tbl1_cell"<?=$Project->hasRights($row['uid'], PRIGHTS_LEADER)?' style="background-color:#CCFF99;font-weight:bold"':'';?>><?=$user['handle']?></td>
	<td class="tbl1_cell"<?=$Project->hasRights($row['uid'], PRIGHTS_LEADER)?' style="background-color:#CCFF99;font-weight:bold"':'';?>><?=$user['last'].', '.$user['first']?></td>
	</tr>
	<?php
}
?>
</table>
</div>