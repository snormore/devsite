<?php
/**
 * This is included when a project is deleted.
 *
 * This will delete everything that has to do with the project being
 * deleted from the fileman database.
 * Note: The variable $Project->pid contains the id of the project to be deleted.
 *		$Project should exist.
 *
 * @package	Fileman
 * @version	0.1
 * @author	Steven Normore
*/
if(empty($Project))
	return;

require_once(MODULES_PATH.'fileman/Fileman.php');

$cwd = getcwd();
chdir(FM_ROOT_PATH.$Project->pid);
// delete folders
$Fm = new Fileman($Project, './');	// only going to be used for Project, needed by deldir
$result = mysql_query("SELECT name,path FROM fm_folders WHERE pid='".$Project->pid."'");
while($row = mysql_fetch_assoc($result))
{
	if(is_dir($row['path'].$row['name']))
		$Fm->deldir($row['path'].$row['name'].'/');
}
unset($Fm);

// delete files
$result = mysql_query("SELECT name,path FROM fm_files WHERE pid='".$Project->pid."'");
while($row = mysql_fetch_assoc($result))
{
	unlink($row['path'].$row['name']);
}
mysql_query("DELETE FROM fm_files WHERE pid='".$Project->pid."'");

chdir($cwd);
rmdir(FM_ROOT_PATH.$Project->pid);
?>