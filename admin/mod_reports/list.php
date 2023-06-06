 
<div class="wrapper">
  
 
    <form action="" method="POST" >
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> RESORT Report
            <small class="pull-right">Date: <?php echo date('m/d/Y'); ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
      <div class="col-sm-2 invoice-col">
        
      </div>
        <!-- <div class="col-sm-2 invoice-col">
          Service
          <address>
            <input class="form-control" size="20" type="text" value="<?php echo isset($_POST['txtsearch']) ? $_POST['txtsearch'] :'' ?>" Placeholder="Search For...." name="txtsearch" id="txtsearch">
        </address>    
      
        </div> -->
        <div class="col-sm-2 invoice-col">
          Status
          <address>
            <div class="form-group">
			  <select name="categ" class="form-control">
			  	<option value="Checkedin" <?php echo isset($_POST['categ']) && $_POST['categ'] == 'Checkedin' ? 'selected' :'' ?>>Checkedin</option>
        <option value="Checkedout" <?php echo isset($_POST['categ']) && $_POST['categ'] == 'Checkedout' ? 'selected' :'' ?>>Checkedout</option>
        <option value="Arrival" <?php echo isset($_POST['categ']) && $_POST['categ'] == 'Arrival' ? 'selected' :'' ?>>Arrival</option>
        <option value="Pending" <?php echo isset($_POST['categ']) && $_POST['categ'] == 'Pending' ? 'selected' :'' ?>>Pending</option>
        <option value="Confirmed" <?php echo isset($_POST['categ']) && $_POST['categ'] == 'Confirmed' ? 'selected' :'' ?>>Confirmed</option>
			  </select>
		  </div>
          </address>
        </div>

        <!-- /.col -->
        <div class="col-sm-2 invoice-col">
          From
          <address> 
		  <div class="form-group">
			 <input class="form-control date start " size="20" type="text" value="<?php echo (isset($_POST['start'])) ? $_POST['start'] : date('Y-m-d'); ?>" Placeholder="Check In" name="start" id="from" data-date="" data-date-format="yyyy-mm-dd" data-link-field="any" data-link-format="yyyy-mm-dd">
		 </div>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col">
        To
        <address>
        <div class="form-group"> 
		      <input class="form-control date end " size="20" type="text" value="<?php echo (isset($_POST['end'])) ? $_POST['end'] : date('Y-m-d'); ?>"  name="end" id="end" data-date="" data-date-format="yyyy-mm-dd" data-link-field="any" data-link-format="yyyy-mm-dd">
		  </div>
		  
        </address>

        </div>
        <!-- /.col -->
           <!-- /.col -->
        <div class="col-sm-2 invoice-col"> 
        <br/>
        <address>
        <div class="form-group"> 
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
		  </div>
		  
        </address>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <?php echo (isset($_POST['categ'])) ? '<i class="fa fa-globe"></i> ' . $_POST['categ'] : ''; ?>
            <small class="pull-right"> <?php echo (isset($_POST['start'])) ? 'From Date :' .$_POST['start'] : ''; ?> <?php echo (isset($_POST['end'])) ? ' To Date :' .$_POST['end'] : ''; ?> </small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
   

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 col-md-12 table-responsive">
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
	if(isset($_POST['submit'])){ 

  
	// $sql ="SELECT * 
	// 	 FROM  `tblaccomodation` A,  `tblroom` RM,  `tblreservation` RS,  `tblpayment` P,  `tblguest` G
	// 	 WHERE A.`ACCOMID` = RM.`ACCOMID` 
	// 	 AND RM.`ROOMID` = RS.`ROOMID` 
	// 	 AND RS.`CONFIRMATIONCODE` = P.`CONFIRMATIONCODE` 
  //    AND P.`GUESTID` = G.`GUESTID`  
  //    AND DATE(`ARRIVAL`) >=  '".$_POST['start']."'
	// 	 AND DATE(`DEPARTURE`) <=  '".$_POST['end']."' AND P.STATUS='" .$_POST['categ']."'
  //    AND CONCAT( `ACCOMODATION`, ' ', `ROOM` , ' ' , `ROOMDESC`) LIKE '%" .$_POST['txtsearch'] ."%'";
	$reservation = new Reservation();
	$reserves = $reservation->searchReports('', $_POST['categ'], $_POST['start'], $_POST['end']);
	// var_dump($reserves);
	

  // $mydb->setQuery($sql);
	// $res = $mydb->executeQuery();
	// $row_count = $mydb->num_rows($res);
	// $cur = $mydb->loadResultList();

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
									
                  <?php 
									
                    @$tot += $result->RPRICE;
                  } 

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
                <!-- <td> ₱ <?php echo @$tot ; ?></td> -->
                <td> ₱ <?php echo number_format(@$total, 2, '.', ',') ?></td>
              </tr> 
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</form>
<form action="printreport.php" method="POST" target="_blank">
<input type="hidden" name="txtsearch" value="<?php echo (isset($_POST['txtsearch'])) ? $_POST['txtsearch'] : ''; ?>">
 <input type="hidden" name="categ" value="<?php echo (isset($_POST['categ'])) ? $_POST['categ'] : ''; ?>">
    <input type="hidden" name="start" value="<?php echo (isset($_POST['start'])) ? $_POST['start'] :  date('Y-m-d'); ?>">
    <input type="hidden" name="end" value="<?php echo (isset($_POST['end'])) ? $_POST['end'] :  date('Y-m-d'); ?>">
      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12"> 
       <span class="pull-right"> <button type="submit" class="btn btn-primary"  ><i class="fa fa-print"></i> Print</button></span>  
          </div>
      </div>
    </section>
    </form>
    <!-- /.content -->
    <div class="clearfix"></div>
 
</div>
<!-- ./wrapper -->
 