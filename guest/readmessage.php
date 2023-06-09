 <?php  
  require_once("../includes/initialize.php");


 
// $sql = "UPDATE `tblpayment` SET `MSGVIEW`=1 WHERE `CONFIRMATIONCODE` ='" . $_GET['code'] ."'";
//  $mydb->setQuery($sql);
//  $mydb->executeQuery(); 


 			
      // $query ="SELECT g.`GUESTID`, `G_FNAME`, `G_LNAME`, `G_ADDRESS`,`CONFIRMATIONCODE`, `TRANSDATE`, `ARRIVAL`, `DEPARTURE`, `RPRICE`,`client_name`
      //          FROM `tblguest` g ,`tblreservation` r 
      //          WHERE g.`GUESTID`=r.`GUESTID` and `CONFIRMATIONCODE` ='".$_GET['code']."'";
      // $mydb->setQuery($query);
      // $result = $mydb->loadsingleResult(); 
			$reserve = new Reservation();
			// $res = $reserve->reservationsByCode($_GET['code']);
			$res = $reserve->singleByCode($_GET['code']);
			$client_name = $res->client_name;
			$address = $res->address;
			$trans_date = date('M  d, Y  h:i a', strtotime('now'));
 			$adds = $reserve->additional_reservations($_GET['code']);
			 $days =  dateDiff(date($res->ARRIVAL),date($res->DEPARTURE));
			$pays = $reserve->getPayments($_GET['code']);
			$total_pays = array_sum(array_column($pays, 'payment'));
     ?>

		 <style>
			table, th, td {
				border: 1px solid black;
				border-collapse: collapse;
			}
			@media print {
	.myDivToPrint {
			background-color: white;
			height: 100%;
			width: 100%;
			position: fixed;
			top: 0;
			left: 0;
			margin: 0;
			padding: 15px;
			font-size: 14px;
			line-height: 18px;
			max-width: 375px;
	}
}
		 </style>
    <form action="/guest/readprint.php?" method="POST" target="_blank">
    <!-- Main content -->
    <section class="invoice myDivToPrint" style="max-width: 525px; margin: 0 auto;">
      <!-- title row -->
      <!-- <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
             <i class="fa fa-globe"></i>
            <small class="pull-right">Date: <?php echo date('m/d/Y'); ?></small>
          </h2>
        </div>
      </div> -->
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
         <h2 style="margin-bottom: 0;"><center>Nixie's Mountain Resort</center></h2>
				 <h3 style="margin:0;"><center>Aritao, Nueva Vizcaya</center></h3>
        </div>
        <br>
				<p style="border-color: #000; border-top: 1px dashed #333; margin: 0;"></p>
				<h4 style="margin: 8px 0;"><center>Resort Receipt</center></h4>
				<p style="border-color: #000; border-top: 1px dashed #333; margin: 0;"></p>

				<p style="text-align: right;"><?php echo $trans_date ?></p>
        <!-- /.col -->
        <div style="padding: 15px 0;" class="col-sm-4 invoice-col">
					<p style="margin: 0 0 5px 0;">
						<strong>Name:</strong>
						<span style="text-decoration: underline;"><?php echo $client_name; ?></span>
					</p>
					<p style="margin: 0 0 5px 0;">
						<strong>Contact #:</strong>
						<span style="text-decoration: underline;"><?php echo $res->mnumber; ?></span>
					</p>
					<p style="margin: 0 0 5px 0;">
						<strong>Address:</strong>
						<span style="text-decoration: underline;"><?php echo $address; ?></span>
					</p>
         
        </div>
        <!-- Table -->
				<table style="width:100%; font-size: 14px;">
					<tr>
						<th>Description</th>
						<th>Arrival</th>
						<th>Departure</th>
						<th>Day(s)</th>
						<th>Price</th>
						<th>Qty</th>
						<th>Sub Total</th>
					</tr>
					<tr> 
            <!-- <td style="text-align: center;"><?php echo $res->ACCOMODATION ;?></td> -->
            <td style="text-align: center;"><?php echo $res->ACCOMDESC ?></td>
            <td style="text-align: center;"> ₱<?php echo number_format($res->price, 2, '.', ',') ;?></td>
            <td style="text-align: center;"><?php
						$arrival = date_create($res->ARRIVAL);
						if (strpos(date_format($arrival, 'm/d/Y H:i:s'), '00:00:00') !== false || strpos(date_format($arrival, 'm/d/Y H:i:s'), '12:00:00') !== false) {
							echo date_format($arrival, 'm/d/Y');
						} else {
							echo date_format($arrival, 'm/d/Y h:i A');
						}
						// echo date_format(date_create($res->ARRIVAL),'m/d/Y');?></td>
            <td style="text-align: center;"><?php 
						$departure = date_create($res->DEPARTURE);
						if (strpos(date_format($departure, 'm/d/Y H:i:s'), '00:00:00') !== false || strpos(date_format($departure, 'm/d/Y H:i:s'), '12:00:00') !== false) {
							echo date_format($departure, 'm/d/Y');
						} else {
							echo date_format($departure, 'm/d/Y h:i A');
						}
						// echo date_format(date_create($res->DEPARTURE),'m/d/Y');?></td>
            <td style="text-align: center;"><?php echo ($days==0) ? '1' : $days;?></td>
						<td style="text-align: center;"> <?php echo $res->accom_qty;?></td>
            <td style="text-align: center;"> ₱<?php  echo number_format($res->price * $res->accom_qty, 2, '.', ',') ;?></td>
          </tr>
					<?php  
							$total_price = $res->price;
						foreach ($adds as $add) {
							
             ?>

            <tr> 
              <!-- <td style="text-align: center;"><?php echo $add->ACCOMODATION ;?></td> -->
              <td style="text-align: center;"><?php echo $add->ACCOMDESC ?></td>
              <td style="text-align: center;"> ₱<?php echo number_format($add->price, 2, '.', ',') ;?></td>
              <td style="text-align: center;"><?php echo date_format(date_create($res->ARRIVAL),'m/d/Y');?></td>
              <td style="text-align: center;"><?php echo date_format(date_create($res->DEPARTURE),'m/d/Y');?></td>
              <td style="text-align: center;"><?php echo ($days==0) ? '1' : $days;?></td>
              <td style="text-align: center;"> <?php echo $add->qty;?></td>
              <td style="text-align: center;"> ₱<?php echo number_format($add->price * $add->qty, 2, '.', ',') ;?></td>
            </tr>
            
            
            <?php 
             @$tot += $add->RPRICE;
						 $total_price += $add->price * $add->qty;
            } ?>
				</table>
					<br>
				<p style="border-color: #000; border-top: 1px dashed #333; margin: 0;"></p>
				<br>
				<div style="padding: 0 60px;  display: flex; justify-content: space-between;">
					<p style="margin: 0 0 5px 0; float:left;">
						<strong>Total:</strong>
					</p>
					<p style="margin: 0 0 5px 0; float:right;">
						<span>₱ <?php echo number_format($total_price, 2, '.', ',') ; ?></span>
					</p>
				</div>
				<div style="padding: 0 60px;  display: flex; justify-content: space-between;">
					<p style="margin: 0 0 5px 0; float:left;">
						<strong>Received:</strong>
					</p>
					<p style="margin: 0 0 5px 0; float:right;">
						<span>₱ <?php echo number_format($total_pays, 2, '.', ','); ?></span>
					</p>
				</div>
				<div style="padding: 0 60px;  display: flex; justify-content: space-between;">
					<p style="margin: 0 0 5px 0; float:left;">
						<strong>Balance:</strong>
					</p>
					<p style="margin: 0 0 5px 0; float:right;">
						<span>₱ <?php echo number_format($total_pays - $total_price, 2, '.', ','); ?></span>
					</p>
				</div>
				<br>
				<p style="border-color: #000; border-top: 1px dashed #333; margin: 0;"></p>

				<div style="padding: 15px 0;" class="col-sm-4 invoice-col">
					<p style="margin: 0 0 5px 0;">
						<strong>Prepared by:</strong>
						<span style="text-decoration: underline;"><?php echo $_SESSION['ADMIN_UNAME']; ?></span>
					</p>
				</div>

				<p style="border-color: #000; border-top: 1px dashed #333; margin: 0;"></p>

				<h4><center>Thank you!</center></h4>


    </section>
    </form>

		<!-- this row will not appear when printing -->
		<div class="row no-print">
        <div class="col-xs-12" style="display: flex; justify-content: center; align-items: center;">
          <!-- <a href="guest/readprint.php?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a> -->
          
					<button style="margin-right: 5px;" type="button"><a style="text-decoration: none; color: black;" href="/admin/mod_reservation/index.php">Go Back</a></button>
					<button type="button" onclick="window.print()"  ><i class="fa fa-print"></i> Print</button>
  <!--         <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
          </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button> -->
        </div>
      </div>
    <!-- /.content -->
    <div class="clearfix"></div>
 

 