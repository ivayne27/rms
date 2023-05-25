<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$code=$_GET['code'];

 
		$query="SELECT  `G_FNAME` ,  `G_LNAME` ,  `G_ADDRESS`,  p.`number`,  p.`address` ,  p.`TRANSDATE` ,  p.`CONFIRMATIONCODE`,  p.`client_name`  ,  `PQTY` ,  `SPRICE` ,p.`STATUS`,g.`GUESTID`,DATE(r.`ARRIVAL`) as ARRIVAL
    FROM  `tblpayment` p,  `tblguest` g,`tblreservation` r
				WHERE p.`GUESTID` = g.`GUESTID` AND p.`CONFIRMATIONCODE` = r.`CONFIRMATIONCODE` AND p.`CONFIRMATIONCODE`='".$code."'";
		$mydb->setQuery($query);
		$res = $mydb->loadSingleResult();
    
    $datenow = date("Y-m-d");
    $rDate = date($res->ARRIVAL);
    if($rDate == $datenow){
      if($res->STATUS=='Confirmed'){
        $stats = '<li class="next"><a href="'.WEB_ROOT .'admin/mod_reservation/controller.php?action=checkin&code='.$res->CONFIRMATIONCODE.
      '">Confirmed &rarr;</a></li>';
      }elseif($res->STATUS=='Checkedin'){
      $stats = '<li class="next"><a href="'.WEB_ROOT .'admin/mod_reservation/controller.php?action=checkout&code='.$res->CONFIRMATIONCODE.
      '">Checkin &rarr;</a></li>';
      }elseif($res->STATUS=='Checkedout'){
      $stats= "";
      }else{
        $stats = '<li class="next"><a href="'.WEB_ROOT .'admin/mod_reservation/controller.php?action=confirm&code='.$res->CONFIRMATIONCODE.
      '">Confirm &rarr;</a></li>';
      }
    }else{
      $stats = "";
    }
		
    $statsView = $res->STATUS;
 

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
			<div class="panel-body">
			<h3 align="left">List of Services</h3> 					
				<table id="example" style="font-size:12px" class="table table-striped table-hover table-responsive"  cellspacing="0">
					
				  <thead>
				  	<tr  >
				  	<th></th>
				  		<th align="left"  width="100">
				  		 
				  		Image</th>
				  		<!-- <th>Room#</th> -->
				  		<th align="left"  width="200">Services</th>	
				  		<!-- <th align="left" width="120">Description</th> -->
				  		<th align="left" width="120">Accomodation</th> 
				  		<th align="left" width="90">Person</th>
				  		<th align="left"  width="200">Price</th>
				  		<!-- <th># of Rooms</th> -->
				  	</tr>	
				  </thead>
				  <tbody>
				  	<?php 
				  		$mydb->setQuery("SELECT *,ACCOMODATION FROM tblroom r, tblaccomodation a WHERE r.ACCOMID = a.ACCOMID ORDER BY  ROOMID ASC ");
				
				  		$cur = $mydb->loadResultList();

						foreach ($cur as $result) {
             
				  		echo '<tr>';
						echo '<td width="5%" align="center"><a  class="btn btn-success btn-xs"  href="controller.php?action=insertitem&code='.$code.'&roomid='.$result->ROOMID.'&price='. $result->PRICE.'&user='. $res->GUESTID.'" ><i class="icon-edit">Add item</a> </td>';
				  		echo '<td align="left"  width="120"> 
				  				<img src="../mod_room/'. $result->ROOMIMAGE.'" width="60" height="40" title="'. $result->ROOM .'"/></td>';
				  		// echo '<td><a href="index.php?view=edit&id='.$result->ROOMID.'">' . ' '.$result->ROOMNUM.'</a></td>';
						echo '<td><a href="index.php?view=edit&id='.$result->ROOMID.'">'. $result->ROOM.' ('. $result->ROOMDESC.')</a></td>';
				  		// echo '<td>'. $result->ROOMDESC.'</td>';
						// echo '<td>'. $result->ACCOMODATION.' ('. $result->ACCOMDESC.')</td>';
						echo '<td>'. $result->ACCOMODATION.'</td>';
				  		echo '<td>'. $result->NUMPERSON.'</td>';
				  		
				  		echo '<td> ₱'. $result->PRICE.'</td>';
				  		// echo '<td>'.$result->ROOMNUM.' </td>';
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
 <div class="col-lg-3">  
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

 <div class="col-lg-9">     

        <div class="row">
            <div class="col-lg-12">
               
                <h1 class="page-header">Reservation
                    <small>Details</small> 
                    <?php
                     
                      if($statsView == 'Checkedin'){
                        // echo $statsView;`
                        echo '<a onclick="document.getElementById(`id01`).style.display=`block`" class="btn btn-success btn-xs" ><i class="icon-edit">Add item</a>';
                      }else if($statsView == 'Checkedout'){
                        echo '<a href="/hbs/guest/readmessage.php?code='.$code.'" class="btn btn-success btn-xs" ><i class="icon-edit">Print Receipt</a>'; 
                      }
                    ?>
                </h1> 
                
            </div>
        </div>

        
        <!-- /.row --> 
<?php

$query="SELECT * 
				FROM  `tblreservation` r,  `tblguest` g,  `tblroom` rm, tblaccomodation a
				WHERE r.`ROOMID` = rm.`ROOMID` 
				AND a.`ACCOMID` = rm.`ACCOMID` 
				AND g.`GUESTID` = r.`GUESTID`  AND r.`STATUS`<>'Cancelled'
				AND  `CONFIRMATIONCODE` = '".$code."'";
$mydb->setQuery($query);
$res = $mydb->loadResultList();

foreach ($res as $cur) {
$image = WEB_ROOT . 'admin/mod_room/'.$cur->ROOMIMAGE;	
$day=dateDiff(date($cur->ARRIVAL),date($cur->DEPARTURE));

?>

        <!-- Blog Post Row -->
        <div class="row">
            <!-- <div class="col-md-1 text-center">
                <p><i class="fa fa-camera fa-4x"></i>
                </p>
                <p>June 17, 2014</p>
            </div> -->
            <div class="col-md-3"> 
                    <img class="img-responsive img-hover" src="<?php echo $image ; ?>" alt=""> 
            </div>
            <div class="col-md-6">
            <div class="box box-solid">
            <ul class="nav nav-pills nav-stacked">
            	<li><h3>
                    <?php echo $cur->ROOM; ?> [ <small><?php echo $cur->ACCOMODATION; ?></small> ]
                </h3>
                </li>
                <li></li>
            </ul>
            <td width="5%" align="center"><a  class="btn btn-danger btn-xs"  href="controller.php?action=deleteitem&code=<?php echo $code; ?>&RESERVEID=<?php echo $cur->RESERVEID; ?>" ><i class="icon-edit">Remove</a> </td>
                <p><strong>ARRIVAL: </strong><?php echo date_format(date_create($cur->ARRIVAL),'m/d/Y');?></p>
                <p><strong>DEPARTURE: </strong><?php echo date_format(date_create($cur->DEPARTURE),'m/d/Y'); ?></p>
                <p><strong>Day(s): </strong><?php echo ($day==0) ? '1' : $day; ?></p>
                <p><strong>PRICE: </strong>₱<?php echo $cur->RPRICE; ?></p>
                <!-- <a class="btn btn-danger" href="<?php echo WEB_ROOT .'admin/mod_reservation/controller.php?id='.$cur->RESERVEID.'&action=cancelroom'; ?>">Cancel<i class="fa fa-angle-right"></i></a> -->
            </div>
        </div>
        </div>
        <!-- /.row -->

        <hr>
        
       <?php }  

       ?>
      </div>
        <!-- Pager -->
        <div class="row">
            <ul class="pager">
                <li class="previous"><a href="<?php echo WEB_ROOT .'admin/mod_reservation/index.php'; ?>">&larr; Back</a>
                </li>
               <?php echo $stats; ?>
            </ul>
        </div>
        <!-- /.row -->

        <hr>