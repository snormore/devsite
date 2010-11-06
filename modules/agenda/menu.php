<?php
/**
 * Menu file agenda module.
 *
 * @package	Agenda
 * @version	0.1
 * @author	Steven Normore
*/
if($_NAV['module'] != 'agenda')
	return;
?>
<div style="text-align:center">
|
<a href="index.php?mod=agenda&page=index&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->date)?>">calendar</a> |
<a href="index.php?mod=agenda&page=day&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->date)?>">day view</a> |
<a href="index.php?mod=agenda&page=events&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->date)?>">events</a> |
<?php
if($_NAV['page'] == 'day' || $_NAV['page'] == 'new_event' || $_NAV['page'] == 'events')
{
	?><a href="index.php?mod=agenda&page=new_event&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->date)?>">new event</a> |
	<?php
}
elseif($_NAV['page'] == 'event' || $_NAV['page'] == 'edit_event' || $_NAV['page'] == 'delete_event')
{
	?><a href="index.php?mod=agenda&page=edit_event&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->date)?>&eid=<?=$_GET['eid']?>">edit event</a> |
	<a href="index.php?mod=agenda&page=delete_event&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->date)?>&eid=<?=$_GET['eid']?>">delete event</a> |
	<?php
}
?>
</div>
<br />