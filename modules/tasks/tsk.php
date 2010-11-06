<?php
/**
 * Team file.
 *
 * Show all team info; homepage, descriptions, etc.
 *
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'tasks/header.php');
if($ret !== true)
	return;

include(MODULES_PATH.'tasks/admin_menu.php');

require_once(LIB_PATH.'FText.php');

$result = mysql_query("SELECT objective,created,body,updated,percent FROM tasks WHERE id='".$Task->taskid."'");
$row = mysql_fetch_assoc($result);
?>
<div class="infoview">

<div class="title"><?=$Task->name?></div>
<br />
<b>Created</b> <?=$row['created']?>
<br />
<b>Last updated</b> <?=$row['updated']?>
<br />
<b>Percent Complete</b> <?=$row['percent']?>%
<br /><br />
<b>Assigned to</b>
<?php
$result = mysql_query("SELECT uid FROM task_members WHERE taskid='".$Task->taskid."'");
$i = mysql_num_rows($result);
if($i == 0)
	echo 'Nobody';
while($row2 = mysql_fetch_assoc($result))
{
	$rc = mysql_query("SELECT handle FROM users WHERE id='".$row2['uid']."'");
	$user = mysql_fetch_assoc($rc);
	echo $user['handle'];
	if($i > 1)
		echo ', ';
	$i--;
}
?>
<br /><br />
<b>Objective:</b><br />
<?=$row['objective']?>
<br /><br />
<?=FText::fText2html($row['body'])?>

</div>