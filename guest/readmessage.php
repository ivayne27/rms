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
			$trans_date = date('Y-m-d H:i:s', strtotime('now'));
 			$adds = $reserve->additional_reservations($_GET['code']);
			 $days =  dateDiff(date($res->ARRIVAL),date($res->DEPARTURE));
			$pays = $reserve->getPayments($_GET['code']);
			$total_pays = array_sum(array_column($pays, 'payment'));
     ?>
    <form action="/guest/readprint.php?" method="POST" target="_blank">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
             <i class="fa fa-globe"></i>
            <small class="pull-right">Date: <?php echo date('m/d/Y'); ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>Nixie's Mountain Resort
             <br>Aritao, Nueva Vizcaya</strong>
          </address>
        </div>
        <br>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?php echo $client_name; ?>
            </strong><br>
            <?php echo $address; ?> 
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
        <br/>
        <br/>
          <!-- <b>Invoice #007612</b><br>
          <br> -->
          <b>Confirmation ID: </b> <br >
						<span style="background-color:blue;color:white"> <?php echo $_GET['code'] ?> </span>
          <input type="hidden" name="code" value="<?php echo $_GET['code']; ?>">
<br> <br>
          <b>Transaction Date:</b> <br> <?php echo  $trans_date ?>
<br> <br>
          <!-- <b>Account:</b> <?php echo $result->GUESTID; ?> -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
  <?php 
 
//  $query ="SELECT * 
//           FROM `tblaccomodation` A,`tblroom`  RM, `tblreservation` RS  
//           WHERE  A.`ACCOMID`=RM.`ACCOMID` AND RM.`ROOMID`=RS.`ROOMID` AND RS.`STATUS`<>'Cancelled' and `CONFIRMATIONCODE` ='".$_GET['code']."'";
//   $mydb->setQuery($query);
//  $res = $mydb->loadResultList(); 


     ?>
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th width="100">Item</th>
              <th width="150">Description</th>
              <th width="80">Price</th>
              <th width="100">Arrival</th>
              <th width="100">Departure</th>
              <th width="10">Day(s)</th>
							<th width="10">Qty</th>
              <th width="100">Subtotal</th>
            </tr>
            </thead>
            <tbody>
						<tr> 
              <td style="text-align: center;"><?php echo $res->ACCOMODATION ;?></td>
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
              <td style="text-align: center;"><?php echo $add->ACCOMODATION ;?></td>
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
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
         <!--  <p class="lead">Payment Methods:</p>
          <img src="../../dist/img/credit/visa.png" alt="Visa">
          <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
          <img src="../../dist/img/credit/american-express.png" alt="American Express">
          <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
          </p> -->
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Total Amount</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style=" text-align:left;">Total:</th>
                <!-- <td>₱<?php echo @$tot ; ?></td> -->
                <td>₱<?php echo number_format($total_price, 2, '.', ',') ; ?></td>
								
              </tr>
							<tr>
								<th style="text-align:left;" >Received:</th>
								<td>₱ <?php echo number_format($total_pays, 2, '.', ','); ?></td>
							</tr>
							<tr>
								<th style="text-align:left;" >Balance:</th>
								<td>₱ <?php echo number_format($total_pays - $total_price, 2, '.', ','); ?></td>
							</tr>
         <!--      <tr>
                <th>Tax (9.3%)</th>
                <td>$10.34</td>
              </tr>
              <tr>
                <th>Shipping:</th>
                <td>$5.80</td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>$265.24</td>
              </tr> -->
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <!-- <a href="guest/readprint.php?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a> -->
          <button type="button" onclick="window.print()"  ><i class="fa fa-print"></i> Print</button>
  <!--         <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
          </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button> -->
        </div>
      </div>
    </section>
    </form>
    <!-- /.content -->
    <div class="clearfix"></div>
 

 