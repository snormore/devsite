<?php
/**
 * Menu file for system module.
 *
 * Displays the main menu.
 *
 * @package	System
 * @version	0.1
 * @author	Steven Normore
*/
?>
-
<?php
if(!empty($Me))
{
	?><a href="./index.php?mod=system">home</a> -
	<a href="./index.php?mod=projects">projects</a> -
	<?php
	if($Me->hasRights(GRIGHTS_ADMIN.GRIGHTS_SADMIN.GRIGHTS_VIEWALL))
	{
		?><a href="./index.php?mod=members">members</a> -
		<?php
	}
	?><a href="./index.php?mod=system&page=myinfo">my info</a> -
	<a href="./index.php?mod=bookmarks&page=index">bookmarks</a> -
	<a href="./index.php?mod=system&page=logout">logout</a> -
	<?php
}
else
{
	?><a href="./index.php?mod=system&page=login">login</a> -
	<?php
}
?>
<a href="./index.php?mod=system&page=help">help</a> -