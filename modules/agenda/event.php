<?php
/**
 * Display information about a specific event.
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
?>
<div class="infoview">

<b>Event</b> <?=$row['name']?><br />
<b>Date</b> <?=$row['t']?></b><br />
<br />
<?=FText::fText2html($row['description'])?>

</div>