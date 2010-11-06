<?php
/**
 * Delete team member file.
 *
 * Delete team member(s).
 *
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'teams/header.php');
if($ret !== true)
	return;

include(MODULES_PATH.'teams/admin_menu.php');

if(!empty($_POST['submit']))
{
	if($Team->hasRights($_POST['uid'], TRIGHTS_LEADER) && !$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER))
	{
		header('Location: index.php?mod=teams&page=members&pid='.$Project->pid.'&tid='.$Team->tid);
		return;
	}
	if(!get_magic_quotes_gpc())
		$_POST['job'] = addslashes($_POST['job']);

	// children
	$uid = $_POST['uid'];
	foreach($Team->children as $child)
	{
		@include(MODULES_PATH.$child.'/tmember_delete.php');
	}
    if(is_numeric($_POST['uid']))
    	mysql_query("DELETE FROM team_members WHERE uid='".$_POST['uid']."' AND tid='".$Team->tid."'");

	header('Location: index.php?mod=teams&page=members&pid='.$Project->pid.'&tid='.$Team->tid);
	return;
}

?>
<div style="text-align:center">
<form action='index.php?mod=teams&page=m_delete&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>' method='post'>
<table class="tbl1">
<tr>
<td class="tbl1_header">&nbsp;</td>
<td class="tbl1_header">handle</td>
<td class="tbl1_header">name</td>
<td class="tbl1_header">occupation</td>
</tr>
<?php
$result = mysql_query("SELECT uid,job,rights FROM team_members WHERE tid='".$Team->tid."'");
while($row = mysql_fetch_assoc($result))
{
	if($Team->hasRights($row['uid'], TRIGHTS_LEADER) && !$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER))
		continue;
	$rc = mysql_query("SELECT handle,first,last FROM users WHERE id='".$row['uid']."'");
	$user = mysql_fetch_assoc($rc);
	?><tr>
	<td class="tbl1_cell"><input type="radio" name="uid" value="<?=$row['uid']?>" class="normal" /></td>
	<td class="tbl1_cell"><?=$user['handle']?></td>
	<td class="tbl1_cell"><?=$user['last'].', '.$user['first']?></td>
	<td class="tbl1_cell"><?=$row['job']?></td>
	</tr>
	<?php
}
?>
<tr><td class="tbl1_footer" colspan="4">
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=teams&page=members&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>'" />
</td></tr>
</table>
</form>
</div>