<?php
/**
 * Menu file for admin menu.
 *
 * Displays admin menu on the top of the content cell.
 *
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/
if($_NAV['module'] != 'teams')
	return;

echo '<div style="text-align:center">';

if($_NAV['page'] == 'index' || $_NAV['page'] == 'new' || $_NAV['page'] == 'delete')
{
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER))
	{
		echo '</div><br />';
		return;
	}
	?>
	|
	<a href="index.php?mod=teams&page=index&pid=<?=$Project->pid?>">teams</a> |
	<a href="index.php?mod=teams&page=new&pid=<?=$Project->pid?>">new team</a> |
	<a href="index.php?mod=teams&page=delete&pid=<?=$Project->pid?>">delete team</a> |
	<br />
	<?php
}
elseif($_NAV['page'] == 'tm' || $_NAV['page'] == 'edit')
{
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER) && !$Team->hasRights($Me->uid, TRIGHTS_LEADER))
	{
		echo '</div><br />';
		return;
	}
	?>
	|
	<a href="index.php?mod=teams&page=tm&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>">team home</a> |
	<a href="index.php?mod=teams&page=edit&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>">edit team</a> |
	<br />
	<?php
}
elseif($_NAV['page'] == 'members' || $_NAV['page'] == 'm_new' || $_NAV['page'] == 'm_delete' || $_NAV['page'] == 'm_edit')
{
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER) && !$Team->hasRights($Me->uid, TRIGHTS_LEADER))
	{
		echo '</div><br />';
		return;
	}
	?>
	|
	<a href="index.php?mod=teams&page=members&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>">team members</a> |
	<a href="index.php?mod=teams&page=m_new&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>">new</a> |
	<a href="index.php?mod=teams&page=m_delete&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>">delete</a> |
	<a href="index.php?mod=teams&page=m_edit&pid=<?=$Project->pid?>&tid=<?=$Team->tid?>">edit</a>
	<br />
	<?php
}
?>
</div>
<br />