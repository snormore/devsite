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
if($_NAV['module'] != 'fileman')
	return;

echo '<div style="text-align:center">';

if($_NAV['page'] == 'index' || $_NAV['page'] == 'newfolder' || $_NAV['page'] == 'upload' || $_NAV['page'] == 'edit' || $_NAV['page'] == 'delete')
{
	?>
	|
	<a href="index.php?mod=fileman&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>">file manager</a> |
	<a href="index.php?mod=fileman&page=newfolder&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>">new folder</a> |
	<a href="index.php?mod=fileman&page=upload&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>">upload</a> |
	<a href="index.php?mod=fileman&page=edit&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>">edit</a> |
	<a href="index.php?mod=fileman&page=delete&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>">delete</a> |
	<br />
	<?php
}
elseif($_NAV['page'] == 'file')
{
	?>
	|
	<a href="index.php?mod=fileman&pid=<?=$Project->pid?>&dir=<?=$Fileman->dir?>">file manager</a> |
	<br />
	<?php
}
?>
</div>
<br />