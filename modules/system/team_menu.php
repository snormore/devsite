<?php
if(!empty($_GET['tid']) && !is_array($_GET['tid']) && !empty($_GET['pid']))
{
	?>
	<a href="index.php?mod=teams&page=tm&pid=<?=$_GET['pid']?>&tid=<?=$_GET['tid']?>">home</a><br />
	<a href="index.php?mod=teams&page=members&pid=<?=$_GET['pid']?>&tid=<?=$_GET['tid']?>">members</a><br />
	<a href="index.php?mod=tasks&page=index&pid=<?=$_GET['pid']?>&tid=<?=$_GET['tid']?>">tasks</a>
	<?php
}
else
	echo 'no team selected';
?>