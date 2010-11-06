<?php
/**
 * Create new bookmark.
 *
 * @package	Links
 * @version	0.1
 * @author	Steven Normore
*/
if(empty($Me))
	return;
include_once(MODULES_PATH.'bookmarks/menu.php');

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
		echo '<div class="error" style="text-align:center">Invalid bookmark</div>';
		return;
	}
	mysql_query("INSERT INTO bookmarks (name,href,uid) VALUES ('".$_POST['name']."','".$_POST['href']."','".$Me->uid."')");

	header('Location: index.php?mod=bookmarks');
	return;
}

$_GET['from'] = htmlentities($_GET['from']);
?>
<div style="text-align:center">
<form action="index.php?mod=bookmarks&page=new" method="post">
<table class="tbl1">
<tr><td colspan="2" class="tbl1_header">create bookmark</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">bookark name </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="name" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">bookark url </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="href" value="<?=$_GET['from']?>" /></td>
</tr>
<tr>
<td class="tbl1_footer" colspan="2">
<input type="submit" value="Submit" name="submit" />
<input type="button" value="Cancel" onClick="window.location='index.php?mod=bookmarks'" />
</td>
</tr>
</table>
</form>
</div>