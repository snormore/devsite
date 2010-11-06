<?php
/**
 * Delete project file.
 *
 * Deletes a project and all of its child modules that are connected to it.
 *
 * @package	Projects
 * @version	0.1
 * @author	Steven Normore
*/
require_once(MODULES_PATH.'projects/Project.php');
if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN))
	return;
include(MODULES_PATH.'projects/admin_menu.php');

if(!empty($_POST['submit']))
{
	if(!is_array($_POST['pid']))
		return;
	foreach($_POST['pid'] as $id)
	{
		if(is_numeric($id))
		{
			$Project = new Project($id);
			foreach($Project->children as $child)
			{
				@include(MODULES_PATH.$child.'/project_delete.php');
			}
			unset($Project);
			mysql_query("DELETE FROM project_members WHERE pid='".$id."'");
			mysql_query("DELETE FROM projects WHERE id='".$id."'");
		}
	}
	header('Location: index.php?mod=projects');
	return;
}
?>

<div style="text-align:center">

<div class="error">Warning: Deleting a project will delete all corrosponding child module information that is connected with the deleted project(s).</div>
<br /><br />
<form action="./?mod=projects&page=delete" method="post">
<table class="tbl1">
<tr>
<td class="tbl1_header">&nbsp;</td>
<td class="tbl1_header">project</td>
<td class="tbl1_header">members</td>
<td class="tbl1_header">description</td>
</tr>
<?php
$output .= '<tr><td class="tbl1_cell"><input type="checkbox" name="pid[]" value="%i" class="normal"></td><td class="tbl1_cell"><a href="./index.php?mod=projects&page=proj&pid=%i">%n</a></td><td class="tbl1_cell">%m</td><td class="tbl1_cell">%d</td></tr>'."\n";
Project::showProjects($Me, $output);
?>
<tr><td class='tbl1_footer' colspan="6">
<input type='submit' value='Delete' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=projects'" />
</td></tr>
</table>
</div>