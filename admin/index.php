<?php
$title ="Home";
require_once("../includes/initialize.php");
 if (!isset($_SESSION['ADMIN_ID'])){
 	redirect('login.php');
 	return true;
 }


 include 'modal.php'; 
$content='home.php';

include 'themes/backendTemplate.php';
redirect('/admin/mod_room/index.php');
?>
