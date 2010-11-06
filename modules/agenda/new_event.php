<?php
/**
 * Create a new event for the given date.
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

require_once(LIB_PATH.'FText.php');

if(!empty($_POST['submit']))
{
	if(!get_magic_quotes_gpc())
		$_POST['name'] = addslashes($_POST['name']);
	if(empty($_POST['name']) || strlen($_POST['name']) > MAX_EVENTS_NAME)
	{
		echo '<div class="error" style="text-align:center">Invalid event name. Must be greater than 0 and less than '.MAX_EVENTS_NAME.'  characters in length.</div>';
		return;
	}
	$a_t = explode('.', $_POST['date']);
	if(!checkdate($a_t[0],$a_t[1],$a_t[2]))
	{
		echo '<div class="error" style="text-align:center">Invalid date.</div>';
		return;
	}
	mysql_query("INSERT INTO events (name,t,uid,pid,description) VALUES ('".$_POST['name']."','".$Agenda->formatDate($Agenda->date)."','".$Me->uid."','".$Project->pid."','".FText::fText2db($_POST['description'])."')");
	header('Location: index.php?mod=agenda&page=day&pid='.$Project->pid.'&t='.$Agenda->formatDate($Agenda->date));
	return;
}
?>
<div style="text-align:center">
<form action="index.php?mod=agenda&page=new_event&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->date)?>" method="post">
<table cellpadding="0" cellspacing="0" border="0" class="tbl1">
<tr><td colspan="2" class="tbl1_header">new event</td></tr>
<tr>
<td class="tbl1_cell" style="text-align:right">event </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="name" value="" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right">date<br />(mm.dd.yyyy) </td>
<td class="tbl1_cell" style="text-align:left"><input type="text" name="date" value="<?=$Agenda->date['month'].'.'.$Agenda->date['day'].'.'.$Agenda->date['year']?>" /></td>
</tr>
<tr>
<td class="tbl1_cell" style="text-align:right; vertical-align:top">homepage </td>
<td class="tbl1_cell" style="text-align:left">
<?php FText::showEditor('description'); ?>
</td>
</tr>
<tr><td colspan="2" class="tbl1_footer">
<input type='submit' value='Submit' name="submit" />
<input type='button' value='Cancel' onClick="window.location='index.php?mod=agenda&page=day&pid=<?=$Project->pid?>&t=<?=$Agenda->formatDate($Agenda->date)?>'" />
</td></tr>
</table>
</form>
</div>