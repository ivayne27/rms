 <?php 
require_once("../includes/initialize.php");
//echo date_format(date_create($_POST['dbirth']), 'Y-m-d');

if(isset($_POST['submit'])){
$guest = New Guest();
$guest->G_PASS = sha1($_POST['newpassword']); 
$guest->update($_SESSION['GUESTID']); 
session_start();
$_SESSION['address'] = $_POST['address'];
?>
<script type="text/javascript">
	window.location = '/index.php';
	
</script>

<?php  } 

if(isset($_POST['savephoto'])){
	if (!isset($_FILES['image']['tmp_name'])) {
			message("No Image Selected!", "error");
			 redirect("/index.php");
		}else{
			$file=$_FILES['image']['tmp_name'];
			$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
			$image_name= addslashes($_FILES['image']['name']);
			$image_size= getimagesize($_FILES['image']['tmp_name']);
			
			if ($image_size==FALSE) {
				message("That's not an image!");
				redirect("/index.php");
		   }else{
			
		
				$location= "guest/photos/".$_FILES["image"]["name"];
				
				move_uploaded_file($_FILES["image"]["tmp_name"], "photos/".$_FILES["image"]["name"]);
				
	 				$g = new Guest(); 
			    	
					$g->LOCATION = $location;
					$g->update($_SESSION['GUESTID']); 
					
				 	// message("Room Image Upadated successfully!", "success");
				 	// unset($_SESSION['id']);
				 	 redirect("/index.php");
 			}
 		}

}

?>
