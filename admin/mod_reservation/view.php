<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$code=$_GET['code'];

 
		// $query="SELECT  `G_FNAME` ,  `G_LNAME` ,  `G_ADDRESS`,  p.`number`,  p.`address` ,  p.`TRANSDATE` ,  p.`CONFIRMATIONCODE`,  p.`client_name`  ,  `PQTY` ,  `SPRICE` ,p.`STATUS`,g.`GUESTID`,DATE(r.`ARRIVAL`) as ARRIVAL
    // FROM  `tblpayment` p,  `tblguest` g,`tblreservation` r
		// 		WHERE p.`GUESTID` = g.`GUESTID` AND p.`CONFIRMATIONCODE` = r.`CONFIRMATIONCODE` AND p.`CONFIRMATIONCODE`='".$code."'";
		// $mydb->setQuery($query);
		// $res = $mydb->loadSingleResult();

		// $reserve = new Reservation();
		
    
    // $datenow = date("Y-m-d");
    // $rDate = date($res->ARRIVAL);
    // if($rDate == $datenow){
    //   if($res->STATUS=='Confirmed'){
    //     $stats = '<li class="next"><a href="/admin/mod_reservation/controller.php?action=checkin&code='.$res->CONFIRMATIONCODE.
    //   '">Checkin &rarr;</a></li>';
    //   }elseif($res->STATUS=='Checkedin'){
    //   $stats = '<li class="next"><a href="/admin/mod_reservation/controller.php?action=checkout&code='.$res->CONFIRMATIONCODE.
    //   '">Checkout &rarr;</a></li>';
    //   }elseif($res->STATUS=='Checkedout'){
    //   $stats= "";
    //   }else{
    //     $stats = '<li class="next"><a href="/admin/mod_reservation/controller.php?action=confirm&code='.$res->CONFIRMATIONCODE.
    //   '">Confirm &rarr;</a></li>';
    //   }
    // }else{
    //   $stats = "";
    // }
		
    // $statsView = $res->STATUS;
 

?>
<div class="container">

<div id="id01" class="w3-modal">
    <div class="w3-modal-content">
      <div class="w3-container">
        <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
        <div class="container">
	<?php
		check_message();
			
		?>
		<!-- <div class="panel panel-primary"> -->
	  	<!-- </div> -->
	  	<!--End of Main Panel-->

</div><!--End of container-->

<div class="modal fade" id="myModal" tabindex="-1">

</div>
      </div>
    </div>
  </div>
	<!-- Old View -->
 	<div class="col-lg-3 hide ">  
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title ">Guest Information</h3><hr/>
            </div>
            <div class="box-body no-padding">
              <ul class="">
                <li class="active"><a><i class="fa fa-inbox"></i> Client Name :
                  <br><b><?php echo $res->client_name; ?></b></span></a></li>
                <!-- <li class="active"><a><i class="fa fa-envelope-o"></i> LASTNAME :
                <span class="pull-right"><?php echo $res->G_LNAME; ?></span></a></li> -->
                <li class="active"><a><i class="fa fa-file-text-o"></i> ADDRESS : 
                
                <br><b><?php echo $res->address; ?></b> </a>
                <li class="active"><a><i class="fa fa-file-text-o"></i> Mobile Number : <br/>
                <b><?php echo $res->number; ?></b> </a>
                </li>
                
               
              </ul>
              <br>
              
            </div>
            <!-- /.box-body -->
          </div>
 	</div> 


 <div class="">     

        <!-- <div class="row">
            <div class="col-lg-12">
               
                <h1 class="page-header">Reservation
                    <small>Details</small> 
                    <?php
                     
                      if($statsView == 'Checkedin'){
                        // echo $statsView;`
                        // echo '<a onclick="document.getElementById(`id01`).style.display=`block`" class="btn btn-success btn-xs" ><i class="icon-edit">Add item</a>';
                      }else if($statsView == 'Checkedout'){
                        // echo '<a href="/guest/readmessage.php?code='.$code.'" class="btn btn-success btn-xs" ><i class="icon-edit">Print Receipt</a>'; 
                      }
                    ?>
                </h1> 
                
            </div>
        </div> -->


  
				<div class="panel-body">
					<?php 
						$res = new Reservation();
						$status = $res->getStatusByCode($_GET['code'])->STATUS;
						if ($status === 'Checkedout') {
							// echo '<h2><a href="/guest/readmessage.php?code='.$_GET['code'].'" class="btn btn-success btn-xs" ><i class="icon-edit">Print Receipt</a></h2>';
						}
					?>
					
			<!-- <h3 align="left">List of Services</h3> -->
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
        <!-- /.row --> 
<?php

// $query="SELECT * 
// 				FROM  `tblreservation` r,  `tblguest` g,  `tblroom` rm, tblaccomodation a
// 				WHERE r.`ROOMID` = rm.`ROOMID` 
// 				AND a.`ACCOMID` = rm.`ACCOMID` 
// 				AND g.`GUESTID` = r.`GUESTID`  AND r.`STATUS`<>'Cancelled'
// 				AND  `CONFIRMATIONCODE` = '".$code."'";
// $mydb->setQuery($query);
// $res = $mydb->loadResultList();
$reservation = new Reservation();
$res = $reservation->reservationsByCode($_GET['code']);

foreach ($res as $key => $cur) {
// $image = '/admin/mod_room/'.$cur->ROOMIMAGE;	
// $day=dateDiff(date($cur->ARRIVAL),date($cur->DEPARTURE));
$accomodation = new Accomodation();
$accom = $accomodation->single_accomodation($cur->ACCOMOID);
// var_dump($accom);die;
$day=dateDiff(date($cur->ARRIVAL),date($cur->DEPARTURE));
$arrival = date_create($cur->ARRIVAL);
$departure = date_create($cur->DEPARTURE);
?>

        <!-- Blog Post Row -->
        <!-- ≈ -->
        <!-- /.row -->

				<!-- New View -->
				<tr>
				<td><?php echo strval($key+1) ?></td>
				<td><?php echo $accom->ACCOMODATION ?></td>
				<td><?php echo $accom->ACCOMDESC; ?></td>
				<td>
					<?php
						if (strpos(date_format($arrival, 'm/d/Y H:i:s'), '00:00:00') !== false || strpos(date_format($arrival, 'm/d/Y H:i:s'), '12:00:00') !== false) {
							echo date_format($arrival, 'm/d/Y');
						} else {
							echo date_format($arrival, 'm/d/Y h:i A');
						}
				 ?></td>
				<td>
					<?php 
						if (strpos(date_format($departure, 'm/d/Y H:i:s'), '00:00:00') !== false || strpos(date_format($departure, 'm/d/Y H:i:s'), '12:00:00') !== false) {
							echo date_format($departure, 'm/d/Y');
						} else {
							echo date_format($departure, 'm/d/Y h:i A');
						}
						?>
				</td>
				<td><?php echo ($day==0) ? '1' : $day; ?></td>
				<td><?php echo $cur->RPRICE; ?></td>
				<!-- <td align="center"><a  class="btn btn-danger btn-xs"  href="controller.php?action=deleteitem&code=<?php echo $code; ?>&RESERVEID=<?php echo $cur->RESERVEID; ?>" ><i class="icon-edit">Remove</a> </td> -->
				</tr>
        
       <?php }  

       ?>


				
				 	
				</table>
				
	  		</div>

      </div>


			

		
        <!-- Pager -->
        <div class="row">
            <ul class="pager">
                <li class="previous"><a href="<?php echo '/admin/mod_reservation/index.php'; ?>">&larr; Back</a>
                </li>
            </ul>
        </div>
        <!-- /.row -->
