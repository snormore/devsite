<?php
/**
 * Output bookmarks snippet.
 *
 * @package	Bookmarks
 * @version	0.1
 * @author	Steven Normore
*/
if(empty($Me))
{
	echo 'none';
	return;
}

$result = mysql_query("SELECT name,href FROM bookmarks WHERE uid='".$Me->uid."' LIMIT 5");
if(mysql_num_rows($result) == 0)
	echo 'none<br />';
else
{
	?><div style="text-align:left" style="padding:5px 5px 5px 5px">
	<?php
	while($row = mysql_fetch_assoc($result))
	{
		?>&rsaquo; <a href="<?=$row['href']?>"><?=$row['name']?></a><br />
		<?php
	}
	?>
	</div>
	<div style="text-align:right">
	<a href="index.php?mod=bookmarks">More...</a>
	</div>
	<?php
}
?>
<br />
<a href="index.php?mod=bookmarks&page=new&from=index.php?<?=urlencode($_SERVER['QUERY_STRING'])?>">Boomark This Page!</a>