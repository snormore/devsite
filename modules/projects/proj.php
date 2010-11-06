<?php
/**
 * Project file.
 *
 * Show all project info; homepage, descriptions, etc.
 *
 * @package	Projects
 * @version	0.1
 * @author	Steven Normore
*/
$ret = require(MODULES_PATH.'projects/header.php');	// weird, gotta do it this way
if($ret !== true)
	return;

include(MODULES_PATH.'projects/admin_menu.php');

// we're going to need this class to display the homepage
require_once(LIB_PATH.'FText.php');

$result = mysql_query("SELECT created,description,homepage,updated FROM projects WHERE id='".$Project->pid."'");
$row = mysql_fetch_assoc($result);
?>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>

<td style="vertical-align:top; text-align:left">
<div class="infoview">
<div class="title"><?=$Project->name?></div>
<br />
<b>Created</b> <?=$row['created']?>
<br /><br />
<?=$row['description']?>
<br /><br />
<?=FText::fText2html($row['homepage'])?>
</div>
</td>

<td style="vertical-align:top;text-align:right">
	<!-- quick links -->
	<table cellpadding="0" cellspacing="0" border="0" class="menu">
	<tr><td><img src="<?=THEME_PATH?>images/quicklinks_title.jpg" alt="" style="border-width:0px" /></td></tr>
	<tr><td class="menu_content">
	<div class="menu_content" style="text-align:left;padding:10px 10px 10px 10px">
	<?php
	$result = mysql_query("SELECT name,href FROM links WHERE pid='".$Project->pid."' LIMIT 10");
	if(mysql_num_rows($result) == 0)
		echo '<div style="text-align:center">no links</div>';
	while($row = mysql_fetch_assoc($result))
	{
		echo '&rsaquo; <a href="'.$row['href'].'">'.$row['name'].'</a><br />';
	}
	?>
	</div>
	<?php
	if(mysql_num_rows($result) >= 10)
	{
		?><br /><div style="text-align:right;padding-right:20px">
		<a href="index.php?mod=links&pid=<?=$Project->pid?>">More...</a>
		</div>
		<?php
	}
	?>
	</td></tr>
	<tr><td><img src="<?=THEME_PATH?>images/left_menu_bottom.jpg" alt="" style="border-width:0px" /></td></tr>
	</table>
</td>

</tr>
</table>