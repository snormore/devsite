<?php
/**
 * New team file.
 *
 * Create a new team.
 *
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;

if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER))
	return;

include(MODULES_PATH.'teams/admin_menu.php');

if(!empty($_POST['submit']))
{
	require_once(MODULES_PATH.'teams/Team.php');

	if(!get_magic_quotes_gpc())
	{
		$_POST['name'] = addslashes($_POST['name']);
		$_POST['desc'] = addslashes($_POST['desc']);
	}
	$_POST['name'] = htmlentities($_POST['name']);
	$_POST['desc'] = htmlentities($_POST['desc']);
	if(empty($_POST['name']) || strlen($_POST['name']) > MAX_TEAMS_NAME)
	{
		echo '<div class="error">Invalid team name. Must be greater than 0 and less than '.MAX_TEAMS_NAME.'  characters in length.</div>';
		return;
	}

	// everything is ok, so create the team
	mysql_query("INSERT INTO teams (pid,name,createdby,created,description) VALUES ('".$Project->pid."','".$_POST['name']."','".$Me->uid."',NOW(),'".$_POST['desc']."')");
	$tid = mysql_insert_id();
    foreach($_POST['uid'] as $lid)
    {
		if(is_numeric($lid))
    		mysql_query("INSERT INTO team_members (uid,tid,rights,job) VALUES ('".$lid."','".$tid."','".TRIGHTS_LEADER."','Leader')");
    }

	header('Location: index.php?mod=teams&pid='.$Project->pid);
	return;
}

?>

<div style="text-align:center">
<form action='./index.php?mod=teams&page=new&pid=<?=$Project->pid?>' method='post'>
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">new team</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">name </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="name" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">description </td>
<td class="tbl1_cell" style="text-align:left"><textarea name="desc" cols="60" rows="4"></textarea></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">leaders </td>
<td class="tbl1_cell" style="text-align:left"><div class='user-list'>
<?php
$result = mysql_query("SELECT uid FROM project_members WHERE pid='".$Project->pid."'");
while($row = mysql_fetch_assoc($result))
{
	$rc = mysql_query("SELECT handle FROM users WHERE id='".$row['uid']."'");
	$user = mysql_fetch_assoc($rc);
	?><input type="checkbox" name="uid[]" value="<?=$row['uid']?>" class="normal"> <?=$user['handle']?><br />
	<?php
}
?>
</div></td>
</tr>
<tr>
<td class='tbl1_footer' colspan="5">
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=teams&pid=<?=$Project->pid?>'" />
</td>
</tr>
</table>
</form>
</div>