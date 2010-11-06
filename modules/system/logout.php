<?php
/**
 * Logout.
 *
 * @package	System
 * @version	0.1
 * @author	Steven Normore
*/
Auth::doLogout();
header('Location: ./index.php');
?>