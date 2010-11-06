<?php
/**
 * New project file.
 *
 * Create a new project.
 *
 * @package	Projects
 * @version	0.1
 * @author	Steven Normore
*/
require_once(MODULES_PATH.'projects/Project.php');
if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN))
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

	// everything is ok, so create the project
	mysql_query("INSERT INTO projects (name,createdby,created,description,homepage) VALUES ('".$_POST['name']."','".$Me->uid."',NOW(),'".$_POST['desc']."','".FText::fText2db($_POST['homepage'])."')");
	$pid = mysql_insert_id();
    foreach($_POST['uid'] as $lid)
    {
		if(is_numeric($lid))
    		mysql_query("INSERT INTO project_members (uid,pid,rights) VALUES ('".$lid."','".$pid."','".PRIGHTS_LEADER."')");
    }

	header('Location: index.php?mod=projects');
	return;
}

?>

<div style="text-align:center">
<form action="./index.php?mod=projects&page=new" method="post">
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">new project</td></tr>
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
$result = mysql_query("SELECT id,handle FROM users");
while($row = mysql_fetch_assoc($result))
{
	?><input type="checkbox" name="uid[]" value="<?=$row['id']?>" class="normal"> <?=$row['handle']?><br />
	<?php
}
?>
</div></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">homepage </td>
<td class="tbl1_cell" style="text-align:left">
<?php FText::showEditor('homepage'); ?>
</td>
</tr>
<tr>
<td class='tbl1_footer' colspan="5">
<input type="submit" value="Submit" name="submit" />
<input type="button" value="Cancel" onClick="window.location='index.php?mod=projects'" />
</td>
</tr>
</table>
</form>
</div>