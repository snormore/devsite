<?php
/**
 * @package Fileman
*/

/**#@+
 * Constants.
*/
define('FM_ROOT_PATH', MODULES_PATH.'fileman/root/');
define('FM_FOLDER_ICON', THEME_PATH.'images/fm_folder.jpg');
define('FM_FILE_ICON', THEME_PATH.'images/fm_file.gif');

/**
 * Fileman class.
 *
 * File Manager class.
 * @package	Fileman
 * @version	0.1
 * @author	Steven Normore
*/
class Fileman
{
	/**
	 * Project object.
	 * @var $Project object
	*/
	var $Project;

	/**
	 * Current directory.
	 * @var $dir string
	*/
	var $dir;

	/**
	 * Class constructor.
	 * Initialize things.
	 * @param object Project object.
	 * @param string directory relative to project root, begings with '/'.
	*/
	function Fileman($Project, $dir = './')
	{
		if(!get_magic_quotes_gpc())
			$dir = addslashes($dir);
		$this->Project = $Project;
		@mkdir(FM_ROOT_PATH.$Project->pid, 0777);
		$this->dir = $dir;

		// validate directory string
		if(strstr($dir, '../') || strstr($dir, "..\\") || substr($dir, 0, 1) != '.' || substr($dir, strlen($dir)-1, 1) != '/')
			$this->dir = './';
	}

	/**
	 * Validates the filename.
	 * @param string filename
	 * @return boolean valid filename
	*/
	function checkFilename($filename)
	{
		if(strstr($filename, '/') || strstr($filename, "\\"))
			return false;
		else
			return true;
	}

	/**
	 * Shows the list of files and folders for the current directory.
	*/
	function showList($mode = '')
	{
		global $Me;

		$cwd = getcwd();

		if(!chdir(FM_ROOT_PATH.$this->Project->pid))
			return;
		$handle = opendir($this->dir);
		if(!$handle)
			return;

		// parent directory
		if($this->dir != './')
		{
			$a_dir = split('/', $this->dir);
			for($i=0;$i<count($a_dir)-2;$i++) { $parent .= $a_dir[$i].'/'; }
			?><tr>
			<td class="tbl1_cell" style="vertical-align:top"><?php if($mode=='delete' || $mode=='edit') { ?><input type="<?php echo $mode=='delete'?'checkbox':'radio'; ?>" disabled class="normal" />&nbsp;<?php } ?><a href="index.php?mod=fileman&pid=<?=$this->Project->pid?>&dir=<?=$parent?>"><img src="<?=FM_FOLDER_ICON?>" style="border-width:0px" alt="" /></a></td>
			<td class="tbl1_cell" style="vertical-align:top"><a href="index.php?mod=fileman&pid=<?=$this->Project->pid?>&dir=<?=$parent?>">..</a></td>
			<td class="tbl1_cell">Parent Directory</td>
			<td class="tbl1_cell"><?=gmdate('m.d.y', filemtime($this->dir.'..'))?></td>
			<td class="tbl1_cell">0</td>
			</tr>
			<?php
		}

		// folders
		while($file = readdir($handle))
		{
			if(is_dir($this->dir.$file) && $file != '.' && $file != '..')
			{
				$result = mysql_query("SELECT shortdesc FROM fm_folders WHERE path='".$this->dir."' AND name='".$file."' AND pid='".$this->Project->pid."'");
				if(mysql_num_rows($result) == 0)
					mysql_query("INSERT INTO fm_folders (name,path,shortdesc,uid,pid) VALUES ('".$file."','".$this->dir."','','".$Me->uid."','".$this->Project->pid."')");
				$row = mysql_fetch_assoc($result);
				?><tr>
				<td class="tbl1_cell" style="vertical-align:top">
				<?php
				if($mode=='delete') { ?><input type="checkbox" name="fname[]" value="<?=$file?>" class="normal" />&nbsp;<?php }
				elseif($mode=='edit') { ?><input type="radio" name="fname" value="<?=$file?>" class="normal" />&nbsp;<?php }
				?>
				<a href="index.php?mod=fileman&pid=<?=$this->Project->pid?>&dir=<?=$this->dir.$file.'/'?>"><img src="<?=FM_FOLDER_ICON?>" style="border-width:0px" alt="" /></a></td>
				<td class="tbl1_cell" style="vertical-align:top"><a href="index.php?mod=fileman&pid=<?=$this->Project->pid?>&dir=<?=$this->dir.$file.'/'?>"><?=$file?></a></td>
				<td class="tbl1_cell"><?=$row['shortdesc']?></td>
				<td class="tbl1_cell"><?=gmdate('m.d.y', filemtime($this->dir.$file))?></td>
				<td class="tbl1_cell">0</td>
				</tr>
				<?php
			}
		}
		rewinddir($handle);

		// files
		while($file = readdir($handle))
		{
			if(is_file($this->dir.$file))
			{
				$result = mysql_query("SELECT shortdesc FROM fm_files WHERE path='".$this->dir."' AND name='".$file."' AND pid='".$this->Project->pid."'");
				if(mysql_num_rows($result) == 0)
					mysql_query("INSERT INTO fm_files (name,path,shortdesc,uid,pid) VALUES ('".$file."','".$this->dir."','','".$Me->uid."','".$this->Project->pid."')");
				$row = mysql_fetch_assoc($result);
				?><tr>
				<td class="tbl1_cell" style="vertical-align:top">
				<?php
				if($mode=='delete') { ?><input type="checkbox" name="fname[]" value="<?=$file?>" class="normal" />&nbsp;<?php }
				elseif($mode=='edit') { ?><input type="radio" name="fname" value="<?=$file?>" class="normal" />&nbsp;<?php }
				?>
				<a href="index.php?mod=fileman&page=file&pid=<?=$this->Project->pid?>&dir=<?=$this->dir?>&fname=<?=$file?>"><img src="<?=FM_FILE_ICON?>" style="border-width:0px" alt="" /></a></td>
				<td class="tbl1_cell" style="vertical-align:top"><a href="index.php?mod=fileman&page=file&pid=<?=$this->Project->pid?>&dir=<?=$this->dir?>&fname=<?=$file?>"><?=$file?></a></td>
				<td class="tbl1_cell"><?=$row['shortdesc']?></td>
				<td class="tbl1_cell"><?=gmdate('m.d.y', filemtime($this->dir.$file))?></td>
				<td class="tbl1_cell"><?=round(filesize($this->dir.$file)/1000,1)?></td>
				</tr>
				<?php
			}
		}

		chdir($cwd);
	}

	/**
	 * Show location snippet.
	*/
	function showLocation()
	{
		$a_dir = split('/',$this->dir);
		$dir = '';
		foreach($a_dir as $d)
		{
			if(!empty($d))
			{
				$dir .= $d.'/';
				echo '<a href="index.php?mod=fileman&pid='.$this->Project->pid.'&dir='.$dir.'">'.$d.'</a>/';
			}
		}
	}

	/**
	 * Recursively deletes a directory and all of its sub-directories
	 * and the files in them.
	 * @param string directory to be deleted, must end with a '/'
	*/
	function deldir($dir)
	{
		$current_dir = opendir($dir);
		while($entryname = readdir($current_dir))
		{
			if(is_dir($dir.$entryname) and ($entryname != '.' and $entryname!='..'))
			{
				$this->deldir($dir.$entryname.'/');
			}
			elseif($entryname != "." and $entryname!="..")
			{
				mysql_query("DELETE FROM fm_files WHERE path='".$dir."' AND name='".$entryname."' AND pid='".$this->Project->pid."'");
				unlink($dir.$entryname);
			}
		}
		closedir($current_dir);
		rmdir($dir);
		mysql_query("DELETE FROM fm_folders WHERE path='".dirname($dir)."/' AND name='".basename($dir)."' AND pid='".$this->Project->pid."'");
	}


	/**
	 * Output $text in log file.
	 * cwd must be set to the project root directory when called.
	 * @param string Text to output into log file.
	*/
	function modifyLog($text)
	{
		$fh = fopen('modify.log', 'a+');
		if($fh)
		{
			fputs($fh, '['.gmdate('m.d.y H:i').'] '.$text."\r\n");
			fclose($fh);
		}
		else
			echo "ASDFSDF<br />";
	}
}
?>