<?php
/**
 * Edit team file.
 *
 * Edits a team.
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
	if(!get_magic_quotes_gpc())
	{
		$_POST['name'] = addslashes($_POST['name']);
		$_POST['desc'] = addslashes($_POST['desc']);
	}
	$_POST['name'] = htmlentities($_POST['name']);
	$_POST['desc'] = htmlentities($_POST['desc']);
	if(empty($_POST['name']) || strlen($_POST['name']) > MAX_TEAMS_NAME)
	{
		echo '<div class="error">Invalid project name. Must be greater than 0 and less than '.MAX_TEAMS_NAME.'  characters in length.</div>';
		return;
	}

	mysql_query("UPDATE teams SET name='".$_POST['name']."', description='".$_POST['desc']."' WHERE id='".$Team->tid."'");
	// leaders
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER))
	{
		header('Location: index.php?mod=teams&page=tm&pid='.$Project->pid.'&tid='.$Team->tid);
		return;
	}
	$result = mysql_query("SELECT uid,rights FROM team_members WHERE tid='".$Team->tid."'");
	while($row = mysql_fetch_assoc($result))
	{
		if(in_array($row['uid'], $_POST['uid']) && !strstr($row['rights'], TRIGHTS_LEADER))
			mysql_query("UPDATE team_members SET rights='".TRIGHTS_LEADER.$row['rights']."' WHERE tid='".$Team->tid."' AND uid='".$row['uid']."'");
		elseif(!in_array($row['uid'], $_POST['uid']) && strstr($row['rights'], TRIGHTS_LEADER))
			mysql_query("UPDATE team_members SET rights='".str_replace(TRIGHTS_LEADER,'',$row['rights'])."' WHERE tid='".$Team->tid."' AND uid='".$row['uid']."'");
	}

	header('Location: index.php?mod=teams&page=tm&pid='.$Project->pid.'&tid='.$Team->tid);
	return;
}

$result = mysql_query("SELECT description FROM teams WHERE id='".$Team->tid."'");
$row = mysql_fetch_assoc($result);
?>
<form action='index.php?mod=teams&page=edit&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>' method='post'>
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">edit team</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">name </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="name" value="<?=$Team->name?>" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">description </td>
<td class="tbl1_cell" style="text-align:left"><textarea name="desc" cols="60" rows="4"><?=$row['description']?></textarea></td>
</tr>
<?php
if($Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) || $Project->hasRights($Me->uid, PRIGHTS_LEADER))
{
	?>
	<tr>
	<td class="tbl1_cell" style="text-align:right; vertical-align:top">leaders </td>
	<td class="tbl1_cell" style="text-align:left"><div class='user-list'>
	<?php
	$result = mysql_query("SELECT uid,rights FROM team_members WHERE tid='".$Team->tid."'");
	while($members = mysql_fetch_assoc($result))
	{
		$user = mysql_fetch_assoc(mysql_query("SELECT handle FROM users WHERE id='".$members['uid']."'"));
		?><input type="checkbox" name="uid[]" value="<?=$members['uid']?>" class="normal"<?php echo $Team->hasRights($members['uid'], TRIGHTS_LEADER)?' checked':''; ?> /> <?=$user['handle']?><br />
		<?php
	}
	?>
	</div></td>
	</tr>
	<?php
}
?>
<tr>
<td class='tbl1_footer' colspan="5">
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='./?mod=teams&page=tm&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>'" />
</td>
</table>
</form>