<?php
/**
 * Project links index file.
 *
 * @package	Links
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;
include_once(MODULES_PATH.'links/admin_menu.php');
?>
<div style="text-align:center">
<table cellspacing="0" cellpadding="0" border="0" class="tbl1">
<tr><td class="tbl1_header">links</td></tr>
<?php
$result = mysql_query("SELECT name,href FROM links WHERE pid='".$Project->pid."'");
if(mysql_num_rows($result) == 0)
	echo '<tr><td class="tbl1_cell" style="padding:20px 20px 20px 20px">no links</td></tr>';
while($row = mysql_fetch_assoc($result))
{
	?><tr><td class="tbl1_cell">&rsaquo; <a href="<?=$row['href']?>"><?=$row['name']?></a></td></tr>
	<?php
}
?>
</table>
</div>