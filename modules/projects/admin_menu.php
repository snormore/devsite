<?php
/**
 * Menu file for admin menu.
 *
 * Displays admin menu on the top of the content cell.
 *
 * @package	Projects
 * @version	0.1
 * @author	Steven Normore
*/
if($_NAV['module'] != 'projects')
	return;

echo '<div style="text-align:center">';

if($_NAV['page'] == 'index' || $_NAV['page'] == 'new' || $_NAV['page'] == 'delete')
{
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN))
	{
		echo '</div><br />';
		return;
	}
	?>
	|
	<a href="index.php?mod=projects&page=index">projects</a> |
	<a href="index.php?mod=projects&page=new">new project</a> |
	<a href="index.php?mod=projects&page=delete">delete project</a> |
	<br />
	<?php
}
elseif($_NAV['page'] == 'proj' || $_NAV['page'] == 'edit')
{
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER))
	{
		echo '</div><br />';
		return;
	}
	?>
	|
	<a href="index.php?mod=projects&page=proj&pid=<?=$Project->pid?>">project home</a> |
	<a href="index.php?mod=projects&page=edit&pid=<?=$Project->pid?>">edit project</a> |
	<br />
	<?php
}
elseif($_NAV['page'] == 'members' || $_NAV['page'] == 'm_new' || $_NAV['page'] == 'm_delete')
{
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER))
	{
		echo '</div><br />';
		return;
	}
	?>
	|
	<a href="index.php?mod=projects&page=members&pid=<?=$Project->pid?>">members</a> |
	<a href="index.php?mod=projects&page=m_new&pid=<?=$Project->pid?>">new</a> |
	<a href="index.php?mod=projects&page=m_delete&pid=<?=$Project->pid?>">delete</a> |
	<br />
	<?php
}
?>
</div>
<br />