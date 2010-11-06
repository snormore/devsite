<?php
/**
 * File Manager index file.
 *
 * @package	Fileman
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');
if($ret !== true)
	return;
require_once(MODULES_PATH.'fileman/Fileman.php');
if(empty($_GET['dir']))
	$_GET['dir'] = './';
$Fileman = new Fileman($Project, $_GET['dir']);
require_once(MODULES_PATH.'fileman/menu.php');

/* scan for database entries with no file/folder counterpart. */
$cwd = getcwd();
chdir(FM_ROOT_PATH.$Project->pid);
$result = mysql_query("SELECT id,name,path FROM fm_files WHERE pid='".$Project->pid."'");
while($row = mysql_fetch_assoc($result))
{
	if(!file_exists($row['path'].$row['name']))
		mysql_query("DELETE FROM fm_files WHERE pid='".$Project->pid."' AND id='".$row['id']."' AND name='".$row['name']."' AND path='".$row['path']."'");
}
$result = mysql_query("SELECT name,path FROM fm_folders WHERE pid='".$Project->pid."'");
while($row = mysql_fetch_assoc($result))
{
	if(!is_dir($row['path'].$row['name']))
		mysql_query("DELETE FROM fm_folders WHERE pid='".$Project->pid."' AND name='".$row['name']."' AND path='".$row['path']."'");
}
chdir($cwd);
?>
<div style="text-align:center">
<table class="tbl1">
<tr><td colspan="5" class="tbl1_cell" style="border-bottom:solid 1pt #000000">
<?php $Fileman->showLocation(); ?>
</td></tr>
<tr>
<td class="tbl1_header">&nbsp;</td>
<td class="tbl1_header">filename</td>
<td class="tbl1_header">description</td>
<td class="tbl1_header">last modified</td>
<td class="tbl1_header">size (kb)</td>
<?php $Fileman->showList(); ?>
</tr>
</table>
<div style="text-align:center">