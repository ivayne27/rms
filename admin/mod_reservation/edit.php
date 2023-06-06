<?php 
require_once("../../includes/initialize.php");


if (isset($_POST['submit'])) {
  # code...
      $sql = "UPDATE `tblreservation` SET `TRANSDATE`='".date_format(date_create($_POST['TRANSDATE']),'Y-m-d h:i')."', `CONFIRMATIONCODE`='".$_POST['CONFIRMATIONCODE']."', `STATUS`='".$_POST['STATUS']."' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";
      $mydb->setQuery($sql);
      $mydb->executeQuery(); 


      $sql = "UPDATE `tblreservation` SET `client_name`='".$_POST['name']."', `mnumber`='".$_POST['last']."', `address`='".$_POST['address']."' WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";
      $mydb->setQuery($sql);
      $mydb->executeQuery(); 
      // $guest = New Guest();
      // $guest->G_FNAME          = $_POST['name'];    
      // $guest->G_LNAME          = $_POST['last'];  
      // $guest->G_ADDRESS        = $_POST['address'] ;   
      // $guest->update($_GET['id']); 
      message("Reservation has been updated!", "success");
      redirect("index.php");
}
  
$guest = New Guest();
$res = $guest->guest_details($_GET['code']);

?>

<h1 align="center">Edit Reservation</h1>

<form class="form-horizontal" action="" method="post" onsubmit="return personalInfo()" name="personal" >
    <!-- Main content -->
    <section class="content">

      <div class="row">
 
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
    <br/>
       
            <!-- /.box-header -->
            <div class="box-body no-padding">
 
              <div class="table-responsive mailbox-messages">
     <div><h2>Guest Information</h2></div>
                <div class="form-group">
                      <div class="col-md-10">
                        <label class="col-md-4 control-label" for=
                        "name">Client Name:</label>

                        <div class="col-md-8">
                          <input name="" type="hidden">
                          <input name="name" type="text"  value="<?php echo $res->client_name; ?>"class="form-control input-sm" id="name" />
                        </div>
                      </div>
                    </div>  

                      <div class="form-group">
                      <div class="col-md-10">
                        <label class="col-md-4 control-label" for=
                        "last">Mobile Number</label>

                        <div class="col-md-8">
                          <input name="last" type="text" value="<?php echo $res->mnumber; ?>" class="form-control input-sm" id="last" />
                        </div>
                      </div>
                    </div> 

                     <div class="form-group">
                      <div class="col-md-10">
                        <label class="col-md-4 control-label" for=
                        "address">ADDRESS:</label>

                        <div class="col-md-8">
                          <input name="address" type="text" value="<?php echo $res->address; ?>" class="form-control input-sm" id="address" />
                        </div>
                      </div>
                    </div> 
		



			

		

		<div class="hide">
     <div><h2>Reservation Details</h2></div>
     <?php
$code = $_GET['code'];

$query="SELECT * 
        FROM  `tblreservation` WHERE  `CONFIRMATIONCODE` = '".$code."'";
$mydb->setQuery($query);
$res = $mydb->loadSingleResult();
?>
<!-- 3f84uq -->

                    <div class="form-group">
                      <div class="col-md-10">
                        <label class="col-md-4 control-label" for=
                        "TRANSDATE">Transaction Date:</label>
                        <div class="col-md-8">
                        <div class="input-group " >  
                        <div class="input-group-addon"> 
                              <i class="fa fa-calendar"></i>
                            </div>
                        <input id="datemask2" name="TRANSDATE"  value="<?php echo date_format(date_create($res->TRANSDATE),'m/d/Y H:m'); ?>" type="text" class="form-control input-sm datemask2"   data-inputmask="'alias': 'mm/dd/yyyy'" data-mask required>
           
                        </div>     
 
                         </div>
                      </div>
                    </div> 
                    <div class="form-group">
                      <div class="col-md-10">
                        <label class="col-md-4 control-label" for=
                        "CONFIRMATIONCODE">Confirmation Code:</label>

                        <div class="col-md-8">
                          <input name="CONFIRMATIONCODE" type="text" value="<?php echo $res->CONFIRMATIONCODE; ?>" class="form-control input-sm" id="CONFIRMATIONCODE" />
                        </div>
                      </div>
                    </div> 
                    <div class="form-group">
                      <div class="col-md-10">
                        <label class="col-md-4 control-label" for=
                        "STATUS">Status:</label>

                        <div class="col-md-8">
                          <input name="STATUS" type="text" value="<?php echo $res->STATUS; ?>" class="form-control input-sm" id="STATUS" />
                        </div>
                      </div>
                    </div> 
                     <!-- /.box-body -->
									</div>
            <div class="box-footer no-padding"> 
                <div class="pull-right"> 
                  <div class="btn-group">
                   <input name="submit" type="submit" value="Save"  class="btn btn-primary" onclick="return personalInfo();"/>
                     </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
              </div>
   
     
              </div>
              <!-- /.mail-box-messages -->
							<hr class=" border-top border-primary">
							<div class="panel-body">
								<!-- <h3 align="left">List of Services</h3> -->
								<h2><a onclick="document.getElementById(`id01`).style.display=`block`" class="btn btn-success btn-sm" ><i class="icon-edit">Add item</a></h2>
									<table id="example" style="font-size:12px" class="table table-striped table-hover table-responsive"  cellspacing="0">
										
										<thead>
											<tr>
											<th width="10">No.</th>
												<!-- <th>Room#</th> -->
												<th align="left"  width="200">Service</th>	
												<th align="left"  width="200">Description</th>	
												<th align="left"  width="200">Arrival</th>	
												<!-- <th align="left" width="120">Description</th> -->
												<th align="left" width="120">Departure</th> 
												<th align="left" width="90">Day(s)</th>
												<th align="left"  width="200">Price</th>
												<!-- <th># of Rooms</th> -->
											</tr>	
										</thead>
										<tbody>

										<?php

					// $query="SELECT * 
					// 				FROM  `tblreservation` r,  `tblguest` g,  `tblroom` rm, tblaccomodation a
					// 				WHERE r.`ROOMID` = rm.`ROOMID` 
					// 				AND a.`ACCOMID` = rm.`ACCOMID` 
					// 				AND g.`GUESTID` = r.`GUESTID`  AND r.`STATUS`<>'Cancelled'
					// 				AND  `CONFIRMATIONCODE` = '".$_GET['code']."'";
					// $mydb->setQuery($query);
					// $res = $mydb->loadResultList();
					$reservation = new Reservation();
					$res = $reservation->reservationsByCode($_GET['code']);
					// var_dump($res);
					foreach ($res as $key => $cur) {
					// $image = '/admin/mod_room/'.$cur->ROOMIMAGE;	
					$accomodation = new Accomodation();
					$accom = $accomodation->single_accomodation($cur->ACCOMOID);
					// var_dump($accom);die;
					$day=dateDiff(date($cur->ARRIVAL),date($cur->DEPARTURE));
					$arrival = date_create($cur->ARRIVAL);
					$departure = date_create($cur->DEPARTURE);
					?>

									<!-- New View -->
									<tr>
									<td><?php echo strval($key+1) ?></td>
									<td><?php echo $accom->ACCOMODATION ?></td>
									<td><?php echo $accom->ACCOMDESC; ?></td>
									<td><?php 
										if (strpos(date_format($arrival, 'm/d/Y H:i:s'), '00:00:00') !== false || strpos(date_format($arrival, 'm/d/Y H:i:s'), '12:00:00') !== false) {
											echo date_format($arrival, 'm/d/Y');
										} else {
											echo date_format($arrival, 'm/d/Y h:i A');
										}
									?></td>
									<td><?php 
									if (strpos(date_format($departure, 'm/d/Y H:i:s'), '00:00:00') !== false || strpos(date_format($departure, 'm/d/Y H:i:s'), '12:00:00') !== false) {
										echo date_format($departure, 'm/d/Y');
									} else {
										echo date_format($departure, 'm/d/Y h:i A');
									}?></td>
									<td><?php echo ($day==0) ? '1' : $day; ?></td>
									<td><?php echo $cur->RPRICE; ?></td>
									<td align="center"><a  class="btn btn-danger btn-xs"  href="controller.php?action=deleteitem&code=<?php echo $code; ?>&RESERVEID=<?php echo $cur->RESERVEID; ?>" ><i class="icon-edit">Remove</a> </td>
									</tr>
									
								<?php }  

								?>


									
										
									</table>
									
									</div>

									<!-- Pager -->
        <div class="row">
            <ul class="pager">
                <li class="previous"><a href="<?php echo '/admin/mod_reservation/index.php'; ?>">&larr; Back</a>
                </li>
            </ul>
        </div>

            </div>
           
            </div>
          </div>
          <!-- /. box --> 
          </div>
    </section>
    <!-- /.content -->
  </form>



	<!-- Modal Add item -->

	<div id="id01" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
        <div class="container">
	<?php
		check_message();
			
		?>
		<!-- <div class="panel panel-primary"> -->
			<div class="panel-body">
			<h3 align="left">List of Services</h3> 					
				<table id="example" style="font-size:12px" class="table table-striped table-hover table-responsive"  cellspacing="0">
					
				  <thead>
				  	<tr  >
				  	<th></th>
				  		<!-- <th align="left"  width="100">
				  		 
				  		Image</th> -->
				  		<!-- <th>Room#</th> -->
				  		<th align="left"  width="100">Services</th>	
				  		<th align="left" width="200">Description</th>
				  		<!-- <th align="left" width="120">Accomodation</th>  -->
				  		<th align="left" width="10">Person</th>
				  		<th align="left"  width="50">Price</th>
							<th align="left"  width="10">Qty</th>
				  		<!-- <th># of Rooms</th> -->
				  	</tr>	
				  </thead>
				  <tbody>
				  	<?php 
							//get accomodation
				  		$mydb->setQuery("SELECT * FROM tblaccomodation");
				
				  		$cur = $mydb->loadResultList();
						foreach ($cur as $result) {
							$user = isset($_GET['id']) ? $_GET['id'] : 0;
				  		echo '<tr>';
							// href="controller.php?action=insertitem&code='.$code.'&accomid='.$result->ACCOMID.'&price='. $result->price.'&user='. $user .'"
						echo '<td width="5%" align="center">
							<a  class="btn btn-success btn-xs add-item-accomodation" data-code="'.$code.'" data-accomid="'.$result->ACCOMID.'" data-price="'.$result->price.'" data-user="'.$user.'" data-qty="1" >
								<i class="icon-edit">Add item
							</a> 
							</td>';
				  		// echo '<td align="left"  width="120"> 
				  				// <img src="../mod_room/'. $result->ROOMIMAGE.'" width="60" height="40" title="'. $result->ROOM .'"/></td>';
				  		// echo '<td><a href="index.php?view=edit&id='.$result->ROOMID.'">' . ' '.$result->ROOMNUM.'</a></td>';
						echo '<td>'. $result->ACCOMODATION.'</a></td>';
				  		// echo '<td>'. $result->ROOMDESC.'</td>';
						// echo '<td>'. $result->ACCOMODATION.' ('. $result->ACCOMDESC.')</td>';
						echo '<td>'. $result->ACCOMDESC.'</td>';
				  		echo '<td>'. $result->max_person_included.'</td>';
				  		
				  		echo '<td> ₱'. $result->price.'</td>';
				  		// echo '<td>'.$result->ROOMNUM.' </td>';
							if ($result->ACCOMID == 20) {
								echo '<td><input class="form-control input-sm accom-input-qty" accomid="'.$result->ACCOMID.'" type="text" min="1" value="1" oninput="this.value=this.value.replace(/[^0-9]/g,'."''".')" ></td>';
							} else {
								echo '<td>1</td>';
							}
				  		echo '</tr>';
				  	} 
				  	?>
				  </tbody>
				 	
				</table>
				<div class="btn-group">
				  
				</div>
				</form>
	  		</div><!--End of Panel Body-->
	  	<!-- </div> -->
	  	<!--End of Main Panel-->

</div><!--End of container-->

<div class="modal fade" id="myModal" tabindex="-1">

</div>
      </div>
    </div>
  </div>