<?php
/**
 * Bookmarks index file.
 *
 * @package	Bookmarks
 * @version	0.1
 * @author	Steven Normore
*/
if(empty($Me))
	return;
include_once(MODULES_PATH.'bookmarks/menu.php');
?>
<div style="text-align:center">
<table cellspacing="0" cellpadding="0" border="0" class="tbl1">
<tr><td class="tbl1_header">my bookmarks</td></tr>
<?php
$result = mysql_query("SELECT name,href FROM bookmarks WHERE uid='".$Me->uid."'");
if(mysql_num_rows($result) == 0)
	echo '<tr><td class="tbl1_cell" style="text-align:center;padding:20px 20px 20px 20px">none</td></tr>';
while($row = mysql_fetch_assoc($result))
{
	?><tr><td class="tbl1_cell">&rsaquo; <a href="<?=$row['href']?>"><?=$row['name']?></a></td></tr>
	<?php
}
?>
</table>
</div>