<?php
/**
* Description:	The main class for Database.
* Author:		Joken Villanueva
* Date Created:	october 27, 2013
* Revised By:		
*/
date_default_timezone_set('Asia/Manila');
//Database Constants
defined('DB_SERVER') ? null : define("DB_SERVER","localhost");//define our database server
defined('DB_USER') ? null : define("DB_USER","rms_user");		  //define our database user	
defined('DB_PASS') ? null : define("DB_PASS","rms_pass");			  //define our database Password	
defined('DB_NAME') ? null : define("DB_NAME","rms"); //define our database Name

$thisFile = str_replace('\\', '/', __FILE__);
$docRoot =$_SERVER['DOCUMENT_ROOT'];

$webRoot  = str_replace(array($docRoot, 'includes/config.php'), '', $thisFile);
$srvRoot  = str_replace('config/config.php','', $thisFile);

define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);
?>