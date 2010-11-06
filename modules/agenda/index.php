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
$Agenda = new Agenda($_GET['t'], 'month');
require_once(MODULES_PATH.'agenda/menu.php');

?>
<div style="text-align:right">Today: <?=gmdate('H:i, l, F d, Y')?> GMT</div>
<h4 style="text-align:center">
<a href="index.php?mod=agenda&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->last_date)?>">&lt;&lt;</a>&nbsp;
<?=gmdate('F Y', mktime(0,0,0,$Agenda->date['month'],1,$Agenda->date['year']))?>
&nbsp;<a href="index.php?mod=agenda&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->next_date)?>">&gt;&gt;</a>
</h4>
<?php $Agenda->showJumpTo($_NAV['page'])?>
<div style="text-align:center">
<table border="0" cellpadding="0" cellspacing="0" class="calendar_big">
<tr>
<td class="calbig_days">Sun</td>
<td class="calbig_days">Mon</td>
<td class="calbig_days">Tue</td>
<td class="calbig_days">Wed</td>
<td class="calbig_days">Thu</td>
<td class="calbig_days">Fri</td>
<td class="calbig_days">Sat</td>
</tr>
<?php
$first_day = gmdate('w', mktime(0, 0, 0, $Agenda->date['month'], 1, $Agenda->date['year']));
$num_days = gmdate('t', mktime(0, 0, 0, $Agenda->date['month'], 1, $Agenda->date['year']));
for($i=1;$i<=ceil((7+$num_days-(7-$first_day))/7);$i++)    // week of month
{
	?><tr>
	<?php
    for($j=1;$j<=7;$j++)   // day of week
    {
		if(($i-1)*7+$j >= $first_day+1 && ($i-1)*7+$j-$first_day <= $num_days)
    	{
			$day = ($i-1)*7+$j-$first_day;
			?>
			<td class="calbig_day" <?php if(gmdate('Ymd', mktime(0,0,0,$Agenda->date['month'],$day,$Agenda->date['year'])) == gmdate('Ymd')) { echo 'style="background-color: #C0C0C0"'; } ?>>
			<div style="width:100%;height=100%;overflow:hidden">
			<a href="./index.php?mod=agenda&page=day&pid=<?=$Project->pid?>&t=<?=$Agenda->date['year'].'-'.$Agenda->date['month'].'-'.$day?>"><?=$day?></a> <?php if(gmdate('Ymd', mktime(0,0,0,$Agenda->date['month'],$day,$Agenda->date['year'])) == gmdate('Ymd')) { echo '<b>today</b>'; } ?><br>
			<?php
			$t = sprintf("%04d-%02d-%02d", $Agenda->date['year'], $Agenda->date['month'], $day);
			$result = mysql_query("SELECT id,name FROM events WHERE pid='".$Project->pid."' AND t='".$t."'");
			while($row = mysql_fetch_assoc($result))
			{
				?>
				&rsaquo; <a href="index.php?mod=agenda&page=event&pid=<?=$Project->pid?>&eid=<?=$row['id']?>"><?=$row['name']?></a><br>
				<?php
			}
			?>
			</div>
			</td>
			<?php
		}
		else
		{
		?><td class="calbig_day">&nbsp;</td>
		<?php
		}
	}
	?></tr>
	<?php
}
?>
</table>
</div>