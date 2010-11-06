<?php
/**
 * Delete team file.
 *
 * Deletes a team and all of its child modules that are connected to it.
 *
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;

include(MODULES_PATH.'teams/Team.php');
if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER))
	return;

include(MODULES_PATH.'teams/admin_menu.php');

if(!empty($_POST['submit']))
{
	if(!is_array($_POST['tid']))
		header('Location: index.php?mod=teams&pid='.$Project->pid);
	foreach($_POST['tid'] as $id)
	{
		if(is_numeric($id))
		{
			$Team = new Team($id);
			foreach($Team->children as $child)
			{
				@include(MODULES_PATH.$child.'/team_delete.php');
			}
			unset($Team);
			mysql_query("DELETE FROM team_members WHERE tid='".$id."'");
			mysql_query("DELETE FROM teams WHERE id='".$id."'");
		}
	}
	header('Location: index.php?mod=teams&pid='.$Project->pid);
	return;
}
?>

<div style="text-align:center">
<div class="error">Warning: Deleting a team will delete all corrosponding child module information that is connected with the deleted team(s).</div>
<br /><br />
<form action="./?mod=teams&page=delete&pid=<?=$Project->pid?>" method="post">
<table class="tbl1">
<tr>
<td class="tbl1_header">&nbsp;</td>
<td class="tbl1_header">team</td>
<td class="tbl1_header">members</td>
<td class="tbl1_header">description</td>
</tr>
<?php
$output .= '<tr><td class="tbl1_cell"><input type="checkbox" name="tid[]" value="%i" class="normal"></td><td class="tbl1_cell"><a href="./index.php?mod=teams&page=tm&pid=%p&tid=%i">%n</a></td><td class="tbl1_cell">%m</td><td class="tbl1_cell">%d</td></tr>'."\n";
Team::showTeams($output);
?>
<tr><td class='tbl1_footer' colspan="6">
<input type='submit' value='Delete' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=teams&pid=<?=$Project->pid?>'" />
</td></tr>
</table>
</div>