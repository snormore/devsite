<?php
/**
 * Create new link.
 *
 * @package	Links
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;
if(!$Me->hasRights(GRIGHTS_SADMIN.GRIGHTS_ADMIN) && !$Project->hasRights($Me->uid, PRIGHTS_LEADER))
	return;
include_once(MODULES_PATH.'links/admin_menu.php');

if(!empty($_POST['submit']))
{
	if(!get_magic_quotes_gpc())
	{
		$_POST['name'] = addslashes($_POST['name']);
		$_POST['href'] = addslashes($_POST['href']);
	}
	$_POST['name'] = htmlentities($_POST['name']);
	$_POST['href'] = htmlentities($_POST['href']);
	if(empty($_POST['name']) || empty($_POST['href']))
	{
		echo '<div class="error" style="text-align:center">Invalid link</div>';
		return;
	}
	mysql_query("INSERT INTO links (name,href,pid) VALUES ('".$_POST['name']."','".$_POST['href']."','".$Project->pid."')");
	header('Location: index.php?mod=links&pid='.$Project->pid);
	return;
}
?>
<div style="text-align:center">
<form action="index.php?mod=links&page=new&pid=<?=$Project->pid?>" method="post">
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">create link</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">link name </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="name" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">link url </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="href" value="" /></td>
</tr>
<tr>
<td class="tbl1_footer" colspan="2">
<input type="submit" value="Submit" name="submit" />
<input type="button" value="Cancel" onClick="window.location='index.php?mod=links&pid=<?=$Project->pid?>'" />
</td>
</tr>
</table>
</form>
</div>