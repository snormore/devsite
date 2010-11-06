<?php
/**
 * New team member file.
 *
 * Add a new team member.
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
		$_POST['job'] = addslashes($_POST['job']);

    if(is_numeric($_POST['uid']))
    	mysql_query("INSERT INTO team_members (uid,tid,rights,job) VALUES ('".$_POST['uid']."','".$Team->tid."','','".$_POST['job']."')");

	header('Location: index.php?mod=teams&page=members&pid='.$Project->pid.'&tid='.$Team->tid);
	return;
}

?>

<form action='index.php?mod=teams&page=m_new&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>' method='post'>
<div style="text-align:center">
<div class='user-list'>
<?php
$result = mysql_query("SELECT uid FROM project_members WHERE pid='".$Project->pid."'");
while($row = mysql_fetch_assoc($result))
{
	$rc = mysql_query("SELECT uid FROM team_members WHERE tid='".$Team->tid."' AND uid='".$row['uid']."'");
	if(mysql_num_rows($rc) == 0)
	{
		$rc = mysql_query("SELECT handle FROM users WHERE id='".$row['uid']."'");
		$user = mysql_fetch_assoc($rc);
		?><input type="radio" name="uid" value="<?=$row['uid']?>" class="normal"> <?=$user['handle']?><br />
		<?php
	}
}
?>
</div>
<br />
Occupation<br />
<input type="text" name="job" value="" />
<br /><br />
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=teams&page=members&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>'" />
</div>
</form>