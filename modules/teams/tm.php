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
$ret = require(MODULES_PATH.'teams/header.php');
if($ret !== true)
	return;

include(MODULES_PATH.'teams/admin_menu.php');

$result = mysql_query("SELECT created,description FROM teams WHERE id='".$Team->tid."'");
$row = mysql_fetch_assoc($result);
?>
<div class="infoview">

<div class="title"><?=$Team->name?></div>
<br />
<b>Created</b> <?=$row['created']?>
<br /><br />
<b>Description:</b><br /><br />
<?=$row['description']?>

</div>