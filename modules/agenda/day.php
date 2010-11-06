<?php
/**
 * Display a day and its events.
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
<div style="text-align:right"><span style="background-color:#C0C0C0">Today</span>: <?=gmdate('H:i, l, F d, Y')?> GMT</div>
<h4 style="text-align:center">
<a href="index.php?mod=agenda&page=day&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->last_date)?>">&lt;&lt;</a>&nbsp;
<?=gmdate('l F j, Y', mktime(0,0,0,$Agenda->date['month'],$Agenda->date['day'],$Agenda->date['year']))?>
&nbsp;<a href="index.php?mod=agenda&page=day&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->next_date)?>">&gt;&gt;</a>
</h4>
<?php $Agenda->showJumpTo($_NAV['page'])?>
<div style="text-align:center">

<!-- mini calendar -->
<table cellspacing="0" cellpadding="0" border="0" class="calendar_small">
<tr>
<td class="calsmall_days">S</td>
<td class="calsmall_days">M</td>
<td class="calsmall_days">T</td>
<td class="calsmall_days">W</td>
<td class="calsmall_days">T</td>
<td class="calsmall_days">F</td>
<td class="calsmall_days">S</td>
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
			<td class="calsmall_day" <?php if(gmdate('Ymd', mktime(0,0,0,$Agenda->date['month'],$day,$Agenda->date['year'])) == gmdate('Ymd')) { echo 'style="background-color: #C0C0C0"'; } ?>>
			<?php
			if($day == $Agenda->date['day'])
			{
				?><b><?=$day?></b></a>
				<?php
			}
			else
			{
				?><a class="cal_link" href="./index.php?mod=agenda&page=day&pid=<?=$Project->pid?>&t=<?=$Agenda->date['year'].'-'.$Agenda->date['month'].'-'.$day?>"><?=$day?></a>
				<?php
			}
			?>
			</td>
			<?php
		}
		else
		{
		?><td class="calsmall_day">&nbsp;</td>
		<?php
		}
	}
	?></tr>
	<?php
}
?>
</table>
<br /><br />

<!-- Events -->
<table cellpadding="0" cellspacing="0" border="0" class="tbl1">
<tr><td class="tbl1_header">events</td></tr>
<?php
$result = mysql_query("SELECT id,name FROM events WHERE pid='".$Project->pid."' AND t='".$Agenda->formatDate($Agenda->date)."'");
if(mysql_num_rows($result) == 0)
	echo '<tr><td class="tbl1_cell" style="padding:20px 20px 20px 20px">No events</td></tr>';
while($row = mysql_fetch_assoc($result))
{
	?><tr><td class="tbl1_cell">&rsaquo; <a href='./index.php?mod=agenda&page=event&pid=<?=$Project->pid?>&eid=<?=$row['id']?>'><?=$row['name']?></a></td></tr>
	<?php
}
?>
</table>
</div>