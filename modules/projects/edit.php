<?php
/**
 * Edit project file.
 *
 * Edits a project.
 *
 * @package	Projects
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');	// weird, gotta do it this way
if($ret !== true)
	return;

include(MODULES_PATH.'projects/admin_menu.php');

require_once(LIB_PATH.'FText.php');

if(!empty($_POST['submit']))
{
	if(!get_magic_quotes_gpc())
	{
		$_POST['name'] = addslashes($_POST['name']);
		$_POST['desc'] = addslashes($_POST['desc']);
	}
	$_POST['name'] = htmlentities($_POST['name']);
	$_POST['desc'] = htmlentities($_POST['desc']);
	if(empty($_POST['name']) || strlen($_POST['name']) > MAX_PROJECTS_NAME)
	{
		echo '<div class="error">Invalid project name. Must be greater than 0 and less than '.MAX_PROJECTS_NAME.'  characters in length.</div>';
		return;
	}

	mysql_query("UPDATE projects SET name='".$_POST['name']."', description='".$_POST['desc']."', homepage='".FText::fText2db($_POST['homepage'])."' WHERE id='".$Project->pid."'");
	// leaders
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN))
	{
		header('Location: index.php?mod=projects&page=proj&pid='.$Project->pid);
		return;
	}
	$result = mysql_query("SELECT uid,rights FROM project_members WHERE pid='".$Project->pid."'");
	while($row = mysql_fetch_assoc($result))
	{
		if(in_array($row['uid'], $_POST['uid']) && !strstr($row['rights'], PRIGHTS_LEADER))
			mysql_query("UPDATE project_members SET rights='".PRIGHTS_LEADER.$row['rights']."' WHERE pid='".$Project->pid."' AND uid='".$row['uid']."'");
		elseif(!in_array($row['uid'], $_POST['uid']) && strstr($row['rights'], PRIGHTS_LEADER))
			mysql_query("UPDATE project_members SET rights='".str_replace(PRIGHTS_LEADER,'',$row['rights'])."' WHERE pid='".$Project->pid."' AND uid='".$row['uid']."'");
	}

	header('Location: index.php?mod=projects&page=proj&pid='.$Project->pid);
	return;
}

$result = mysql_query("SELECT description,homepage FROM projects WHERE id='".$Project->pid."'");
$row = mysql_fetch_assoc($result);
?>
<form action='index.php?mod=projects&page=edit&pid=<?=$Project->pid?>' method='post'>
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">edit project</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">name </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="name" value="<?=$Project->name?>" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">description </td>
<td class="tbl1_cell" style="text-align:left"><textarea name="desc" cols="60" rows="4"><?=$row['description']?></textarea></td>
</tr>
<?php
if($Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN))
{
	?><tr>
	<td class="tbl1_cell" style="text-align:right; vertical-align:top">leaders </td>
	<td class="tbl1_cell" style="text-align:left"><div class='user-list'>
	<?php
	$result = mysql_query("SELECT uid,rights FROM project_members WHERE pid='".$Project->pid."'");
	while($members = mysql_fetch_assoc($result))
	{
		$user = mysql_fetch_assoc(mysql_query("SELECT handle FROM users WHERE id='".$members['uid']."'"));
		?><input type="checkbox" name="uid[]" value="<?=$members['uid']?>" class="normal"<?php echo $Project->hasRights($members['uid'], PRIGHTS_LEADER)?' checked':''; ?> /> <?=$user['handle']?><br />
		<?php
	}
	?></div></td>
	</tr>
	<?php
}
?>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">homepage </td>
<td class="tbl1_cell" style="text-align:left">
<?php FText::showEditor('homepage', $row['homepage']); ?>
</td>
</tr>
<tr>
<td class='tbl1_footer' colspan="5">
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='./?mod=projects&page=proj&pid=<?=$Project->pid?>'" />
</td>
</table>
</form>