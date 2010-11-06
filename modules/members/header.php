<?php
/**
 * Header file for members module.
 *
 * This page will check to make sure the current user has the correct
 * permissions to view the page.
 *
 * @package	Members
 * @version	0.1
 * @author	Steven Normore
*/
if(Auth::isAuth() !== true)
	return false;

/* check per page */
if($_NAV['module'] != 'members')
	return false;

if($_NAV['page'] == 'register' || $_NAV['page'] == 'delete')
{
	if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN))
		return false;
	?>
	<div style="text-align:center">
	|
	<a href="index.php?mod=members&page=index">members</a> |
	<a href="index.php?mod=members&page=register">register</a> |
	<a href="index.php?mod=members&page=delete">delete</a> |
	</div>
	<br />
	<?php
	return true;
}
elseif($_NAV['page'] == 'index')
{
	if($Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN))
	{
		?>
		<div style="text-align:center">
		|
		<a href="index.php?mod=members&page=index">members</a> |
		<a href="index.php?mod=members&page=register">register</a> |
		<a href="index.php?mod=members&page=delete">delete</a> |
		</div>
		<br />
		<?php
		return true;
	}
	elseif($Me->hasRights(GRIGHTS_VIEWALL))
	{
		return true;
	}
	return false;
}
elseif($_NAV['page'] == 'details' || $_NAV['page'] == 'edit' || $_NAV['page'] == 'changepass')
{
	if(empty($_GET['uid']))
		return false;
	$User = new UserInfo($_GET['uid']);

	if($User->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Me->hasRights(GRIGHTS_SADMIN) && ($_NAV['page'] == 'edit' || $_NAV['page'] == 'changepass'))
		return false;

	if($Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN))
	{
		?>
		<div style="text-align:center">
		|
		<a href="index.php?mod=members&page=index">members</a> |
		<a href="index.php?mod=members&page=details&uid=<?=$User->uid?>">details</a> |
		<?php
		if(!$User->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) || $Me->hasRights(GRIGHTS_SADMIN))
		{
			?>
			<a href="index.php?mod=members&page=edit&uid=<?=$User->uid?>">edit</a> |
			<a href="index.php?mod=members&page=changepass&uid=<?=$User->uid?>">change password</a> |
			<?php
		}
		?>
		</div>
		<br />
		<?php
		return true;
	}
	elseif($Me->hasRights(GRIGHTS_VIEWALL))
	{
		if($_NAV['page'] == 'edit' || $_NAV['page'] == 'changepass')
			return false;
		?>
		<div style="text-align:center">
		|
		<a href="index.php?mod=members&page=index">members</a> |
		<a href="index.php?mod=members&page=details&uid=<?=$User->uid?>">details</a> |
		</div>
		<br />
		<?php
		return true;
	}
	return false;
}

return true;
?>