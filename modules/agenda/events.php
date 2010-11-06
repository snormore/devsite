<?php
/**
 * Display calendar for angeda.
 *
 * @package	Agenda
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;
require_once(MODULES_PATH.'agenda/Agenda.php');
$Agenda = new Agenda($_GET['t'], 'day');
require_once(MODULES_PATH.'agenda/menu.php');

?>
<div style="text-align:right">Today: <?=gmdate('H:i, l, F d, Y')?> GMT</div>
<div style="text-align:center">
<table border="0" cellpadding="0" cellspacing="0" class="tbl1">
<tr>
<td class="tbl1_header">event</td>
<td class="tbl1_header">date y-m-d</td>
</tr>
<?php
$result = mysql_query("SELECT id,name,t FROM events WHERE pid='".$Project->pid."' ORDER BY t");
while($row = mysql_fetch_assoc($result))
{
	?><tr>
	<td class="tbl1_cell"><a href="index.php?mod=agenda&page=event&pid=<?=$Project->pid?>&t=<?=$Agenda->t?>&eid=<?=$row['id']?>"><?=$row['name']?></a></td>
	<td class="tbl1_cell"><?=$row['t']?></td>
	</tr>
	<?php
}
?>
</table>
</div>