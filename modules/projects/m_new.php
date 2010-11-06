<?php
/**
 * New project member file.
 *
 * Add a new project member.
 *
 * @package	Projects
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;

include(MODULES_PATH.'projects/admin_menu.php');

if(!empty($_POST['submit']))
{
	foreach($_POST['uid'] as $uid)
	{
		if(is_numeric($uid))
			mysql_query("INSERT INTO project_members (uid,pid,rights) VALUES ('".$uid."','".$Project->pid."','')");
	}

	header('Location: index.php?mod=projects&page=members&pid='.$Project->pid);
	return;
}

?>

<form action="index.php?mod=projects&page=m_new&pid=<?=$Project->pid?>" method="post">
<div style="text-align:center">
<div class="user-list" style="height:150px;width:200px">
<?php
$result = mysql_query("SELECT id,handle FROM users");
while($row = mysql_fetch_assoc($result))
{
	$rc = mysql_query("SELECT uid FROM project_members WHERE pid='".$Project->pid."' AND uid='".$row['id']."'");
	if(mysql_num_rows($rc) == 0)
	{
		?><input type="checkbox" name="uid[]" value="<?=$row['id']?>" class="normal"> <?=$row['handle']?><br />
		<?php
	}
}
?>
</div>
<br /><br />
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=projects&page=members&pid=<?=$Project->pid?>'" />
</div>
</form>