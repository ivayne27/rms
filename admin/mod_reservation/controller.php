<?php
require_once("../../includes/initialize.php");
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'modify' :
	dbMODIFY();
	break;
	
	case 'delete' :
	doDelete();
	break;
	
	case 'deleteOne' :
	dbDELETEONE();
	break;
	case 'confirm' :
	doConfirm();
	break;
	case 'cancel' :
	doCancel();
	break;
	case 'checkin' :
	doCheckin();
	break;
	case 'checkout' :
	doCheckout();
	break;
	case 'cancelroom' :
	doCancelRoom();
	break;
	case 'insertitem' :
		doInsertNewItem();
	break;
	case 'additem' :
		doAddItem();
	break;
	case 'addpay' :
		doAddPay();
	break;
	case 'deleteitem' :
		deleteitem();
	break;
	case 'markaspaid' :
		doMarkAsPaid();
	break;
	case 'fetchservices' :
		doFetchServices();
	break;
	}
function doCheckout(){

		global $mydb;
		$dateNow = date('Y-m-d h:i:s', strtotime('now'));
		$sql = "UPDATE `tblreservation` SET `STATUS`='Checkedout', `DEPARTURE`='".$dateNow."' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'"; 
		$mydb->setQuery($sql);
		$mydb->executeQuery(); 

		$sql = "UPDATE `tblpayment` SET `STATUS`='Checkedout' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'"; 
		$mydb->setQuery($sql);
		$mydb->executeQuery(); 
					
		message("Reservation Upadated successfully!", "success");
		redirect('index.php');

}
function doCheckin(){
 
 global $mydb;

 $dateNow = date('Y-m-d h:i:s', strtotime('now'));

$sql = "UPDATE `tblreservation` SET `STATUS`='Checkedin', `ARRIVAL`='".$dateNow."' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'"; 
$mydb->setQuery($sql);
$mydb->executeQuery(); 
 

$sql = "UPDATE `tblpayment` SET `STATUS`='Checkedin' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'"; 
$mydb->setQuery($sql);
$mydb->executeQuery(); 

 
message("Reservation Upadated successfully!", "success");
redirect('index.php');



}


function doCancel(){
global $mydb;

$sql = "UPDATE `tblreservation` r,tblaccomodation rm SET ROOMNUM=ROOMNUM + 1 WHERE r.`ACCOMOID`=rm.`ACCOMID` AND `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";
$mydb->setQuery($sql);
$mydb->executeQuery(); 


$sql = "UPDATE `tblreservation` SET `STATUS`='Cancelled' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'"; 
$mydb->setQuery($sql);
$mydb->executeQuery(); 


$sql = "UPDATE `tblpayment` SET `STATUS`='Cancelled' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'"; 
$mydb->setQuery($sql);
$mydb->executeQuery(); 

				
message("Reservation Upadated successfully!", "success");
redirect('index.php');

}
function doCancelRoom(){ 
	global $mydb;

	$mydb->setQuery("SELECT * FROM `tblreservation` WHERE  `RESERVEID` ='" . $_GET['id'] ."'");
	$cur = $mydb->loadResultList(); 
	foreach ($cur as $result) {  

	$room = new Room(); 
	$room->ROOMNUM    = $room->ROOMNUM + 1; 
	$room->update($result->ROOMID); 

	}


$sql = "UPDATE `tblreservation` SET `STATUS`='Cancelled' WHERE `RESERVEID` ='" . $_GET['id'] ."'";
mysql_query($sql) or die(mysql_error());

				
message("Reservation Upadated successfully!", "success");
redirect('index.php');

}
function doInsertNewItem(){ 
	global $mydb;
	$code = $_GET['code'];
	// var_dump($code);
	$existingItemSql = "SELECT * from `tblreservation` where `CONFIRMATIONCODE` = '".$code."' limit 1";
	// var_dump($existingItemSql);
	$mydb->setQuery($existingItemSql);
	$resItem = current($mydb->loadResultList()); 
	// var_dump($resItem);
	// die;
	// $qty = (int) $_GET['qty'];
	// var_dump($_GET['qty'], $qty);
	for ($i = 0; $i < $_GET['qty']; $i++) {
		$sql = "INSERT into tblreservation (CONFIRMATIONCODE,ACCOMOID,RPRICE,GUESTID,TRANSDATE,ARRIVAL,DEPARTURE,PRORPOSE,STATUS,BOOKDATE,REMARKS,USERID,client_name,mnumber,address)
			values ('" . $_GET['code'] ."','" . $_GET['accomid'] ."','" . $_GET['price'] ."','" . $_GET['user'] ."','". date('Y-m-d h:i:s') ."','".$resItem->ARRIVAL."','".$resItem->DEPARTURE."','Travel','".$resItem->STATUS."','".date('Y-m-d h:i:s')."','additional','".$resItem->USERID."','".$resItem->client_name."','".$resItem->mnumber."','".$resItem->address."')";
		// echo $sql;
		$mydb->setQuery($sql);
		$mydb->executeQuery(); 
	}
	redirect('/admin/mod_reservation/index.php?view=edit&code=' . $_GET['code'] .'');
	message("Adde new Item!", "success");



	// $sql = "INSERT into tblreservation (CONFIRMATIONCODE,ACCOMOID,RPRICE,GUESTID,TRANSDATE,ARRIVAL,DEPARTURE,PRORPOSE,STATUS,BOOKDATE,REMARKS,USERID,client_name,mnumber,address)
	// values ('" . $_GET['code'] ."','" . $_GET['accomid'] ."','" . $_GET['price'] ."','" . $_GET['user'] ."','". date('Y-m-d h:i:s') ."','".$resItem->ARRIVAL."','".$resItem->DEPARTURE."','Travel','".$resItem->STATUS."','".date('Y-m-d h:i:s')."','additional','".$resItem->USERID."','".$resItem->client_name."','".$resItem->mnumber."','".$resItem->address."')";
	// echo $sql;
	// $mydb->setQuery($sql);
	// $mydb->executeQuery(); 
	

		
}
function deleteitem(){

	global $mydb;

	$sql = "DELETE FROM tblreservation WHERE RESERVEID='" . $_GET['RESERVEID'] ."'"; 
	$mydb->setQuery($sql);
	$mydb->executeQuery();
	message("Item deleted!", "danger");
	$reservation = new Reservation();
	if (empty($reservation->listOfreservation())) {
		redirect('index.php');
	} else {
		redirect('index.php?view=edit&code=' . $_GET['code'] .'');
	}
}

function doConfirm(){
global $mydb; 

$sql = "UPDATE `tblreservation` r,tblroom rm SET ROOMNUM=ROOMNUM - 1 WHERE r.`ROOMID`=rm.`ROOMID` AND  `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";

$mydb->setQuery($sql);
$mydb->executeQuery();


$sql = "UPDATE `tblreservation` SET `STATUS`='Confirmed' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";

$mydb->setQuery($sql);
$mydb->executeQuery(); 

$sql = "UPDATE `tblpayment` SET `STATUS`='Confirmed' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";

$mydb->setQuery($sql);
$mydb->executeQuery();






message("Reservation Upadated successfully!", "success");
redirect('index.php');

}	
 
function doDelete(){

	global $mydb;

	$sql = "DELETE FROM tblpayment WHERE CONFIRMATIONCODE='" . $_GET['code'] ."'"; 
	$mydb->setQuery($sql);
	$mydb->executeQuery();
	
	$sql = "DELETE FROM tblreservation WHERE CONFIRMATIONCODE='" . $_GET['code'] ."'"; 
	$mydb->setQuery($sql);
	$res = $mydb->executeQuery();
	if ($res) {
		# code...
	message("Reservation Deleted successfully!", "success");
 	redirect('index.php');
	}else{
	message("Reservation cannot be deleted!", "error");
 	redirect('index.php');
	}
  }

function doAddItem() {
	$confirmation_code = createRandomPassword();
	$accomodation = new Accomodation();
	$accomSelected = $accomodation->single_accomodation($_POST['accomodation']);
	// var_dump($_POST, $confirmation_code, $accomSelected);die;
	
  $reservation = new Reservation();
  $reservation->CONFIRMATIONCODE  = $confirmation_code;
  $reservation->TRANSDATE         = date('Y-m-d h:i:s'); 
  $reservation->ACCOMOID          = $_POST['accomodation'];
  $reservation->ARRIVAL           = date_format(date_create( $_POST['date']), 'Y-m-d');  
  $reservation->DEPARTURE         = date('Y-m-d',strtotime($_POST['date'] . ' +1 day')); 
  $reservation->RPRICE            = $accomSelected->price;  
  $reservation->GUESTID           = 0; 
  $reservation->PRORPOSE          = 'Travel';
  $reservation->STATUS            = 'Pending';
  $reservation->client_name       = $_POST['first_name'] . ' ' . $_POST['last_name'];
	$reservation->BOOKDATE					= date_format(date_create('now'), 'Y-m-d h:i:s');
	$reservation->REMARKS						= '';
	$reservation->USERID						= 0;
	$reservation->mnumber						= intval($_POST['mobile_no']);
	$reservation->address						= $_POST['address'];
  $reservation->create();
	redirect('/admin/mod_reservation/index.php');
}

function createRandomPassword() {

	$chars = "abcdefghijkmnopqrstuvwxyz023456789";

	srand((double)microtime()*1000000);

	$i = 0;

	$pass = '' ;
	while ($i <= 7) {

			$num = rand() % 33;

			$tmp = substr($chars, $num, 1);

			$pass = $pass . $tmp;

			$i++;

	}

	return $pass;

}

function doAddPay() {
	$res = new Reservation();
	var_dump($_POST);
	$insert = $res->insertPayment($_POST['code'], $_POST['pay']);

	if ($insert) {
		message("Payment success", 'success');
	} else {
		message("Payment failed.", 'danger');
	}
	redirect('/admin/mod_reservation/index.php');
}

function doMarkAsPaid() {
	$reservation = new Reservation();
	$res = $reservation->markAsPaid($_GET['code']);
	if ($res) {
		message('Mark as paid success.', 'success');
	} else {
		message('Mark as paid failed.', 'danger');
	}
	redirect('/admin/mod_reservation/index.php');
	}

function doFetchServices() {

	$accomodation = new Accomodation();
	$getAvailable = $accomodation->getAvailableServices($_GET['date']);
	echo json_encode(array_values($getAvailable));
}
	
?>
