<?php
/**
 * Bookmarks menu file.
 *
 * @package	Bookmarks
 * @version	0.1
 * @author	Steven Normore
*/
if($_NAV['module'] != 'bookmarks')
	return;

if($Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) || $Project->hasRights($Me->uid, PRIGHTS_LEADER))
{
	?>
	<div style="text-align:center">
	|
	<a href="index.php?mod=bookmarks&page=index">bookmarks</a> |
	<a href="index.php?mod=bookmarks&page=new">create bookmark</a> |
	<a href="index.php?mod=bookmarks&page=delete">delete bookmark</a> |
	</div>
	<br />
	<?php
}
?>