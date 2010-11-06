<?php
/**
 * Main index file for System module.
 *
 * This is the "home" of this module, it is the page that gets called by
 * default.
 *
 * @package	System
 * @version	0.1
 * @author	Steven Normore
*/
if(Auth::isAuth() !== true)
	return;
?>
Welcome <?=$Me->handle?>
<br /><br />
You last logged with the IP of <?=$Me->getLastIP()?> on <?=$Me->getLastDate()?>.