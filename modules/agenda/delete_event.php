<?php
/**
 * Delete event.
 *
 * @package	Agenda
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;
require_once(MODULES_PATH.'agenda/Agenda.php');
if(!is_numeric($_GET['eid']))
	return;
$result = mysql_query("SELECT name,t,description FROM events WHERE id='".$_GET['eid']."' AND pid='".$Project->pid."'");
$row = mysql_fetch_assoc($result);
if(mysql_num_rows($result) == 0)
	return;
$Agenda = new Agenda($row['t'], 'day');
if($Agenda->formatDate($Agenda->date) != $row['t'])
	return;
require_once(MODULES_PATH.'agenda/menu.php');

require_once(LIB_PATH.'FText.php');

if(!empty($_POST['submit']))
{
	if(!is_numeric($_GET['eid']))
		return;
	mysql_query("DELETE FROM events WHERE id='".$_GET['eid']."'");
	header('Location: index.php?mod=agenda&page=day&pid='.$Project->pid.'&t='.$Agenda->formatDate($Agenda->date));
	return;
}
?>
<form action="index.php?mod=agenda&page=delete_event&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->date)?>&eid=<?=$_GET['eid']?>" method="post">
<div style="text-align:center">
Are you sure you want to delete this event?
<br /><br />
<input type='submit' value=' Yes ' name="submit" />
<input type='button' value=' No ' onClick="window.location='index.php?mod=agenda&page=event&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->date)?>&eid=<?=$_GET['eid']?>'" />
</form>
</div>