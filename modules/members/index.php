<?php
/**
 * Main index file for System module.
 *
 * Display all members of entire site.
 *
 * @package	Members
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'members/header.php');
if($ret !== true)
	return;
?>
<div style="text-align:center">
<table class="tbl1">
<tr>
<td class="tbl1_header">handle</td>
<td class="tbl1_header">name</td>
</tr>
<?php
$result = mysql_query("SELECT id,handle,first,last FROM users");
while($row = mysql_fetch_assoc($result))
{
	?><tr>
	<td class="tbl1_cell"><a href="index.php?mod=members&page=details&uid=<?=$row['id']?>"><?=$row['handle']?></a></td>
	<td class="tbl1_cell"><?=$row['last'].', '.$row['first']?></td>
	</tr>
	<?php
}
?>
</table>
</div>