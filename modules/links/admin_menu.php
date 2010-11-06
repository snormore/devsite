<?php
/**
 * Links module header file.
 *
 * @package	Links
 * @version	0.1
 * @author	Steven Normore
*/
if($_NAV['module'] != 'links')
	return;

if($Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) || $Project->hasRights($Me->uid, PRIGHTS_LEADER))
{
	?>
	<div style="text-align:center">
	|
	<a href="index.php?mod=links&page=index&pid=<?=$Project->pid?>">links</a> |
	<a href="index.php?mod=links&page=new&pid=<?=$Project->pid?>">create link</a> |
	<a href="index.php?mod=links&page=delete&pid=<?=$Project->pid?>">delete link</a> |
	</div>
	<br />
	<?php
}
?>