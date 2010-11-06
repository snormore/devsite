<?php
/**
 * Main index file for projects module.
 *
 * This page will display all current projects which user is allowed to
 * access.
 *
 * @package	Projects
 * @version	0.1
 * @author	Steven Normore
*/

require_once(MODULES_PATH.'projects/Project.php');

include(MODULES_PATH.'projects/admin_menu.php');
?>
You have access to the following projects,
<br /><br />
<div style="text-align:center">
<table class="tbl1">
<tr>
<td class="tbl1_header">project</td>
<td class="tbl1_header">members</td>
<td class="tbl1_header">description</td>
</tr>
<?php
$output .= '<tr><td class="tbl1_cell"><a href="./index.php?mod=projects&page=proj&pid=%i">%n</a></td><td class="tbl1_cell">%m</td><td class="tbl1_cell">%d</td></tr>'."\n";
Project::showProjects($Me, $output);
?>
</table>
</div>