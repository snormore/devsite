<?php
/**
 * Main index file for teams module.
 *
 * This page will display all current teams for the current project.
 *
 * @package	Teams
 * @version	0.1
 * @author	Steven Normore
*/

$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;
require_once(MODULES_PATH.'teams/Team.php');
include(MODULES_PATH.'teams/admin_menu.php');
?>
<div style="text-align:center">
<table class="tbl1">
<tr>
<td class="tbl1_header">team</td>
<td class="tbl1_header">members</td>
<td class="tbl1_header">description</td>
</tr>
<?php
$output .= '<tr><td class="tbl1_cell"><a href="./index.php?mod=teams&page=tm&pid=%p&tid=%i">%n</a></td><td class="tbl1_cell">%m</td><td class="tbl1_cell">%d</td></tr>'."\n";
Team::showTeams($output);
?>
</table>
</div>