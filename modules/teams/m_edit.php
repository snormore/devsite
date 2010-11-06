<?php
/**
 * Edit team member file.
 *
 * Edit team member.
 *
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'teams/header.php');
if($ret !== true)
	return;

include(MODULES_PATH.'teams/admin_menu.php');

if(empty($_POST['uid']))
{
	?>
	<div style="text-align:center">
	<form action='index.php?mod=teams&page=m_edit&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>' method='post'>
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
		if($Team->hasRights($row['uid'], TRIGHTS_LEADER) && !$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER) && $row['uid'] != $Me->uid)
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
	<input type='submit' value='Submit' />
	<input type='button' value='Cancel' onClick="window.location='index.php?mod=teams&page=members&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>'" />
	</td></tr>
	</table>
	</form>
	</div>
	<?php
	return;
}

if(!is_numeric($_POST['uid']))
{
	header('Location: index.php?mod=teams&page=members&pid='.$Project->pid.'&tid='.$Team->tid);
	return;
}
if(!empty($_POST['submit']))
{
	if(!get_magic_quotes_gpc())
		$_POST['job'] = addslashes($_POST['job']);
	$_POST['job'] = htmlentities($_POST['job']);

	mysql_query("UPDATE team_members SET job='".$_POST['job']."' WHERE tid='".$Team->tid."' AND uid='".$_POST['uid']."'");

	header('Location: index.php?mod=teams&page=members&pid='.$Project->pid.'&tid='.$Team->tid);
	return;
}

$result = mysql_query("SELECT job FROM team_members WHERE tid='".$Team->tid."' AND uid='".$_POST['uid']."'");
$row = mysql_fetch_assoc($result);
?>
<div style="text-align:center">
<form action="index.php?mod=teams&page=m_edit&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>" method="post">
<div style="text-align:center">
Occupation<br />
<input type="text" name="job" value="<?=$row['job']?>" />
<input type="hidden" name="uid" value="<?=$_POST['uid']?>" />
<br /><br />
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=teams&page=members&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>'" />
</div>
</form>
</div>