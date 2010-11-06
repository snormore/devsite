<?php
if(!empty($_GET['pid']) && !is_array($_GET['pid']))
{
	?>
	<a href="index.php?mod=projects&page=proj&pid=<?=$_GET['pid']?>">home</a><br />
	<a href="index.php?mod=projects&page=members&pid=<?=$_GET['pid']?>">members</a><br />
	<a href="index.php?mod=teams&page=index&pid=<?=$_GET['pid']?>">teams</a><br />
	<a href="index.php?mod=agenda&page=index&pid=<?=$_GET['pid']?>">agenda</a><br />
	<a href="index.php?mod=fileman&page=index&pid=<?=$_GET['pid']?>">file manager</a><br />
	<a href="index.php?mod=forum&page=index&pid=<?=$_GET['pid']?>">forum</a><br />
	<a href="index.php?mod=links&page=index&pid=<?=$_GET['pid']?>">links</a>
	<?php
}
else
	echo 'no project selected';
?>