<?php
/**
 * Delete link.
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
	foreach($_POST['linkid'] as $linkid)
	{
		if(is_numeric($linkid))
			mysql_query("DELETE FROM links WHERE pid='".$Project->pid."' AND id='".$linkid."'");
	}
	header('Location: index.php?mod=links&pid='.$Project->pid);
	return;
}
?>
<div style="text-align:center">
<form action="index.php?mod=links&page=delete&pid=<?=$Project->pid?>" method="post">
<table cellspacing="0" cellpadding="0" border="0" class="tbl1">
<tr><td class="tbl1_header">links</td></tr>
<?php
$result = mysql_query("SELECT id,name,href FROM links WHERE pid='".$Project->pid."'");
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
<input type="button" value="Cancel" onClick="window.location='index.php?mod=links&pid=<?=$Project->pid?>'" />
</td>
</tr>
</table>
</form>
</div>