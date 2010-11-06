<?php
/**
 * Delete bookmark.
 *
 * @package	Bookmarks
 * @version	0.1
 * @author	Steven Normore
*/
if(empty($Me))
	return;
include_once(MODULES_PATH.'bookmarks/menu.php');

if(!empty($_POST['submit']))
{
	foreach($_POST['linkid'] as $linkid)
	{
		if(is_numeric($linkid))
			mysql_query("DELETE FROM bookmarks WHERE uid='".$Me->uid."' AND id='".$linkid."'");
	}
	header('Location: index.php?mod=bookmarks');
	return;
}
?>
<div style="text-align:center">
<form action="index.php?mod=bookmarks&page=delete" method="post">
<table cellspacing="0" cellpadding="0" border="0" class="tbl1">
<tr><td class="tbl1_header">links</td></tr>
<?php
$result = mysql_query("SELECT id,name,href FROM bookmarks WHERE uid='".$Me->uid."'");
if(mysql_num_rows($result) == 0)
	echo '<tr><td class="tbl1_cell" style="padding:20px 20px 20px 20px">no links</td></tr>';
while($row = mysql_fetch_assoc($result))
{
	?><tr><td class="tbl1_cell"><input type="checkbox" name="linkid[]" value="<?=$row['id']?>" class="normal" /> <a href="<?=$row['href']?>"><?=$row['name']?></a></td></tr>
	<?php
}
?>
<tr>
<td class="tbl1_footer" colspan="2">
<input type="submit" value="Submit" name="submit" />
<input type="button" value="Cancel" onClick="window.location='index.php?mod=bookmarks'" />
</td>
</tr>
</table>
</form>
</div>