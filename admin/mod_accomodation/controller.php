<?php 
require_once("../../includes/initialize.php");
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
	doInsert();
	break;
	
	case 'edit' :
	doEdit();
	break;
	
	case 'delete' :
	doDelete();
	break;


	}
function doInsert(){
		
	if ($_POST['ACCOMODATION'] == "" OR $_POST['ACCOMDESC'] == "") {
		message("All fields required!", "error");
		redirect("index.php?view=add");

	}else{

		$accomodation = new Accomodation();
		$name	= $_POST['ACCOMODATION'];
		$desc    = $_POST['ACCOMDESC'];

		
		$accomodation->ACCOMODATION =$_POST['ACCOMODATION'];
		$accomodation->ACCOMDESC =  $_POST['ACCOMDESC'];
		$accomodation->max_person_included =  $_POST['max_person_included'];
		$accomodation->price =  $_POST['price'];
		
		
		 $istrue = $accomodation->create(); 
		 if ($istrue == 1){
		 	message("New [". $name ."] created successfully!", "success");
		 	redirect('/admin/mod_room/index.php');
		 	
		 }


	}	
}
function doEdit(){
	if ($_POST['ACCOMODATION'] == "" OR $_POST['ACCOMDESC'] == "") {
			message("All fields required!", "error");
			redirect("index.php?view=edit");
		
	}else{

		$accomodation = new Accomodation();
		 
		$accomodation->ACCOMODATION =$_POST['ACCOMODATION'];
		$accomodation->ACCOMDESC =  $_POST['ACCOMDESC'];
		$accomodation->max_person_included =  $_POST['max_person_included'];
		$accomodation->price =  $_POST['price'];
			
			
			$accomodation->update($_POST['ACCOMID']); 
			
		 	message("Edited [". $_POST['ACCOMODATION'] ."] Updated successfully!", "success");
		 	redirect('/admin/mod_room/index.php');
			 	
	
		
	}	
		
}

function doDelete(){
	$accomodation = new Accomodation();
	if (isset($_GET['id'])) {
		//delete single
		$accomodation->delete($_GET['id']);
	} else {
		//multi delete using checkbox as a selector
		@$id=$_POST['selector'];
		  $key = count($id);
		for($i=0;$i<$key;$i++){
	 
			
			$accomodation->delete($id[$i]);
		}
	}
		
	

		message("Accomodation already Deleted!","info");
		redirect('/admin/mod_room/index.php');

}

?>