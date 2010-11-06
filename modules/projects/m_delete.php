<?php
/**
 * Delete project member file.
 *
 * Delete project member(s).
 *
 * @package	Projects
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;

include(MODULES_PATH.'projects/admin_menu.php');

$admin = $Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN);

if(!empty($_POST['submit']))
{
	foreach($_POST['uid'] as $uid)
	{
		if(is_numeric($uid))
		{
			foreach($Project->children as $child)
			{
				@include(MODULES_PATH.$child.'/pmember_delete.php');
			}
    		mysql_query("DELETE FROM project_members WHERE uid='".$uid."' AND pid='".$Project->pid."'");
		}
	}

	header('Location: index.php?mod=projects&page=members&pid='.$Project->pid);
	return;
}
?>
<form action='index.php?mod=projects&page=m_delete&pid=<?=$Project->pid?>' method='post'>
<?php
if($admin)
{
	?><div style="text-align:center">
	<span style="background-color:#CCFF99;font-weight:bold;padding:5px 5px 5px 5px">Project Leader</span>
	<br /><br />
	<?php
}
?>
<table class="tbl1">
<tr>
<td class="tbl1_header">&nbsp;</td>
<td class="tbl1_header">handle</td>
<td class="tbl1_header">name</td>
</tr>
<?php
$result = mysql_query("SELECT uid FROM project_members WHERE pid='".$Project->pid."'");
while($row = mysql_fetch_assoc($result))
{
	if($Project->hasRights($row[uid], PRIGHTS_LEADER) && !$admin)
		continue;
	$rc = mysql_query("SELECT handle,first,last FROM users WHERE id='".$row['uid']."'");
	$user = mysql_fetch_assoc($rc);
	$style = $Project->hasRights($row['uid'], PRIGHTS_LEADER)?'style="background-color:#CCFF99;font-weight:bold"':'';
	?><tr>
	<td class="tbl1_cell"<?=$style?>><input type="checkbox" name="uid[]" value="<?=$row['uid']?>" class="normal"<?=$style?> /></td>
	<td class="tbl1_cell"<?=$style?>><?=$user['handle']?></td>
	<td class="tbl1_cell"<?=$style?>><?=$user['last'].', '.$user['first']?></td>
	</tr>
	<?php
}
?>
<tr>
<td class="tbl1_footer" colspan="3">
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=projects&page=members&pid=<?=$Project->pid?>'" />
</td>
</tr>
</table>
</div>
</form>