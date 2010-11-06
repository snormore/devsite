<?php
/**
 * Delete member file.
 *
 * Delete member(s).
 *
 * @package	Members
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'members/header.php');
if($ret !== true)
	return;

$sadmin = $Me->hasRights(GRIGHTS_SADMIN);

if(!empty($_POST['submit']))
{
	$error = false;
	require_once(MODULES_PATH.'projects/Project.php');
	foreach($_POST['uid'] as $uid)
	{
		if(is_numeric($uid))
		{
			$User = new UserInfo($uid);
			if(!$sadmin && $User->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN))
			{
				$error = true;
				$err_msg[] = $User->handle;
				continue;
			}
			unset($User);
			include(MODULES_PATH.'projects/member_delete.php');
    		mysql_query("DELETE FROM users WHERE id='".$uid."'");
		}
	}

	if($error)
	{
		echo '<div class="error">The following users could not be deleted because you do not have the required rights to do so.</div><ul type="square">';
		foreach($err_msg as $handle) { echo '<li>'.$handle.'</li>'; }
		echo '</ul>';
		return;
	}

	header('Location: index.php?mod=members');
	return;
}
?>
<form action="index.php?mod=members&page=delete" method="post">
<div style="text-align:center">
<table class="tbl1">
<tr>
<td class="tbl1_header">&nbsp;</td>
<td class="tbl1_header">handle</td>
<td class="tbl1_header">name</td>
</tr>
<?php
$result = mysql_query("SELECT id,handle,first,last FROM users");
while($row = mysql_fetch_assoc($result))
{
	?><tr>
	<td class="tbl1_cell"><input type="checkbox" name="uid[]" value="<?=$row['id']?>" class="normal" /></td>
	<td class="tbl1_cell"><a href="index.php?mod=members&page=details&uid=<?=$row['id']?>"><?=$row['handle']?></a></td>
	<td class="tbl1_cell"><?=$row['last'].', '.$row['first']?></td>
	</tr>
	<?php
}
?>
<tr>
<td class="tbl1_footer" colspan="3">
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=members'" />
</td>
</tr>
</table>
</div>
</form>