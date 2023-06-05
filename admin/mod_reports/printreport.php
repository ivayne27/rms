<?php
require_once("../../includes/initialize.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo isset($title) ? $title   :  ' ' ; ?></title>


<link href="/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="/admin/css/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="/admin/css/jquery.dataTables.css">
<link href="/admin/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" language="javascript" src="/admin/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="/admin/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="/admin/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="/admin/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="/admin/js/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
</head> 

 <body >
<div class="wrapper"> 
 
    <form action="" method="POST" >
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i>  
            Report
            <small class="pull-right">Date: <?php echo date('m/d/Y'); ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
    
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h4 class="">
            <i class="fa fa-globe"></i><?php echo (isset($_POST['categ'])) ? $_POST['categ'] : ''; ?>
            <small class="pull-right"> <?php echo (isset($_POST['start'])) ? 'From Date: ' .$_POST['start'] : ''; ?> <?php echo (isset($_POST['end'])) ? '<br> To Date: ' .$_POST['end'] : ''; ?> </small>
          </h4>
        </div>
        <!-- /.col -->
      </div>
   

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12  table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Guest</th>
              <th>Services</th>
              <th>Price</th>
							<th>Qty</th>
              <th>Arrival</th>
              <th>Departure</th>
              <th>Day(s)</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
             <?php 
	// $sql ="SELECT * 
	// 	 FROM  `tblaccomodation` A,  `tblroom` RM,  `tblreservation` RS,  `tblpayment` P,  `tblguest` G
	// 	 WHERE A.`ACCOMID` = RM.`ACCOMID` 
	// 	 AND RM.`ROOMID` = RS.`ROOMID` 
	// 	 AND RS.`CONFIRMATIONCODE` = P.`CONFIRMATIONCODE` 
	// 	 AND P.`GUESTID` = G.`GUESTID`  
	// 	 AND DATE(`ARRIVAL`) >=  '".$_POST['start']."' 
  //    AND DATE(`DEPARTURE`) <=  '".$_POST['end']."' AND P.STATUS='" .$_POST['categ']."' 
  //    AND CONCAT( `ACCOMODATION`, ' ', `ROOM` , ' ' , `ROOMDESC`) LIKE '%" .$_POST['txtsearch'] ."%'";
	// $mydb->setQuery($sql);
	// $res = $mydb->executeQuery();
	// $row_count = $mydb->num_rows($res);
	// $cur = $mydb->loadResultList();
	$reservation = new Reservation();
	$reserves = $reservation->searchReports('', $_POST['categ'], $_POST['start'], $_POST['end']);
	   
		$total = 0;
		if ($reserves >0){
			foreach ($reserves as $res) {
          $days =  dateDiff(date($res->ARRIVAL),date($res->DEPARTURE));
					$total = $res->RPRICE;
             ?>

						 <!-- Main Reserve -->
						 <tr> 
                    <td><?php echo $res->client_name;?></td>
                    <td>
											<?php echo $res->ACCOMODATION ;?>
											<br>
											<?php 
												foreach($res->adds as $add) { 
													echo '- ' . $add->ACCOMODATION . '<br>';
												}
											?>
										</td>
                    <td> ₱ <?php echo number_format($res->RPRICE, 2, '.', ',');?>
											<br>
											<?php 
												foreach($res->adds as $add) { 
													echo '₱ ' . number_format($add->price, 2, '.', ',') . '<br>';
												}
											?>
										</td>
                    <td><?php echo $res->accom_qty;?>
											<br>
											<?php 
												foreach($res->adds as $add) { 
													echo $add->qty . '<br>';
												}
											?>
										</td>
                    <td><?php echo date_format(date_create($res->ARRIVAL),'m/d/Y');?></td>
                    <td><?php echo date_format(date_create($res->DEPARTURE),'m/d/Y');?></td>
                    <td><?php echo ($days==0) ? '1' : $days;?></td>
                    <td> ₱ <?php echo number_format($res->RPRICE * $res->accom_qty, 2, '.', ',');?>
											<br>
											<?php 
												foreach($res->adds as $add) { 
													echo '₱ ' . number_format($add->price * $add->qty, 2, '.', ',') . '<br>';
													@$total += $add->price * $add->qty;
												}
											?>
										</td>
                  </tr>

            <!-- <tr> 
              <td><?php echo $res->client_name;?></td>
              <td><?php echo $result->ACCOMODATION . ' [' .$result->ROOM.']' ;?></td>
              <td> ₱ <?php echo $result->PRICE;?></td>
              <td><?php echo date_format(date_create($result->ARRIVAL),'m/d/Y');?></td>
              <td><?php echo date_format(date_create($result->DEPARTURE),'m/d/Y');?></td>
              <td><?php echo ($days==0) ? '1' : $days;?></td>
              <td> ₱ <?php echo $result->RPRICE;?></td>
            </tr> -->
            
            
            <?php 
              @$tot += $result->RPRICE;
            } 

            } 
            ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
       
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Total Amount</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Total:</th>
                <!-- <td > ₱ <?php echo @$tot ; ?></td> -->
								<td> ₱ <?php echo number_format(@$total, 2, '.', ',') ?></td>
              </tr>
       
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
 
    </section>
    </form>
    <!-- /.content -->
    <div class="clearfix"></div>
 
</div>
<!-- ./wrapper --> 
<script>
  window.onload = function(){
    window.print()
    setTimeout(function(){
      window.close()
    },750)
  }
</script>
</body>
</html> 