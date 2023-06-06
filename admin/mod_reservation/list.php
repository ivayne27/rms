<?php
		check_message();
			
		?>


<!-- FORM Start add reservation -->

<form class="form-horizontal well span6" action="/admin/mod_reservation/controller.php?action=additem" method="POST">

	<fieldset>
		<legend>Add Reservation</legend>
          <div class="form-group">
            <div class="row">
              <label class="col-md-2 control-label" for=
              "first_name">Name:</label>
							<div class="row">
								<div class="col-md-4">
									<input name="deptid" type="hidden" value="">
									<input class="form-control input-sm" id="first_name" name="first_name" placeholder=
											"First name" type="text" value="">
								</div>
								<div class="col-md-4">
									<input name="deptid" type="hidden" value="">
									<input class="form-control input-sm" id="last_name" name="last_name" placeholder=
											"Last name" type="text" value="">
								</div>
							</div>
              
            </div>
          </div>

					<div class="form-group">
						<div class="row">
							<label class="col-md-2 control-label" for=
								"date">Date:</label>
							<div class="row">
								<div class="col-md-4 booking_dropdown">
										<input type="date" id="serviceDatePicker" class="datepicker-x booking_input booking_input_a booking_out form-control input-sm" placeholder="Select Date" name="date" required="required" value="<?php echo date('Y-m-d');?>" >
								</div>
							</div>
						</div>
          </div>

					<div class="form-group">
            <div class="row">
              <label class="col-md-2 control-label" for=
              "service">Service:</label>
							<div class="row">
								<div class="col-md-4">
									<div class="custom-select-wew">
                          <?php
                         $accomodation = New Accomodation();
                         $cur = $accomodation->listOfaccomodation(); 
                          ?>
                    <select name="accomodation" id="accomodation" class="form-control input-sm">
                      <option value="0">Service</option>
                      <?php  foreach ($cur as $result) { ?>
                          <option value="<?php echo $result->ACCOMID; ?>"><?php echo $result->ACCOMODATION; ?></option>
                          <?php  } ?>
                    </select>
                  </div>
								</div>
							</div>
            </div>
          </div>

          

					<div class="form-group">
            <div class="row">
              <label class="col-md-2 control-label" for=
              "pax">Person:</label>
							<div class="row">
								<div class="col-md-4">
										<input required class="form-control input-sm" id="pax" name="pax" placeholder=
											"Number of persons" type="text" min="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="">
								</div>
							</div>
            </div>
          </div>
					<div class="form-group">
            <div class="row">
              <label class="col-md-2 control-label" for=
              "mobile_no">Mobile No.:</label>
							<div class="row">
								<div class="col-md-4">
										<input required class="form-control input-sm" id="mobile_no" name="mobile_no" placeholder=
											"Mobile number" type="text" min="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="">
								</div>
							</div>
            </div>
          </div>

					<div class="form-group">
            <div class="row">
              <label class="col-md-2 control-label" for=
              "address">Address:</label>
							<div class="row">
								<div class="col-md-4">
										<input required class="form-control input-sm" id="address" name="address" placeholder=
											"Address" type="text" value="">
								</div>
							</div>
            </div>
          </div>

					

		 <div class="form-group">
            <div class="row">
              <label class="col-md-2 control-label" for=
              "idno"></label>
							<div class="row">
								<div class="col-md-8">
									<button style="display:flex; margin: 0 0 0 auto;" class="btn btn-primary d-flex justify-content-end" name="save" type="submit" >Add</button>
								</div>
							</div>
            </div>
          </div>

			
	</fieldset>	


</form>

</div><!--End of container-->
<!-- FORM End Reservation -->
<div class="container">
<!-- <div class="panel panel-primary"> -->
			<div class="panel-body">
			<h3 align="left">List of Reservations</h3>
<!-- <form  method="post" action="processreservation.php?action=delete"> -->
	<table id="table" style="font-size:12px" class="table table-striped table-hover table-responsive" cellspacing="0">
<thead>
<tr>
<td width="5%"><strong>No</strong></td>	

<td width="90"><strong>Guest</strong></td>
<!--<td width="10"><strong>Confirmation</strong></td>-->
<td width="80"><strong>Arrival Date</strong></td>
<!-- <td width="80"><strong>Confimation Code</strong></td> -->
<td width="70"><strong>Services</strong></td>
<td width="10"><strong>Qty</strong></td>
<td width="50"><strong>Total Price</strong></td>
<td width="80"><strong>Payments</strong></td>
<!-- <td width="80"><strong>Nights</strong></td> -->
<td width="80"><strong>Status</strong></td>
<td width="200"><strong>Action</strong></td>
</tr>
</thead>
<tbody>
<?php

$reservation = new Reservation();
// var_dump($reservation->listOfreservation());die;
// $mydb->setQuery("SELECT `G_FNAME` , `G_LNAME` , `G_ADDRESS` , p.`TRANSDATE` , p.`CONFIRMATIONCODE`, p.`client_name` , COUNT(r.RPRICE) as 'PQTY', SUM(r.RPRICE) as 'SPRICE' ,p.`STATUS`,g.`GUESTID`,DATE(MAX(r.`ARRIVAL`)) as ARRIVAL FROM `tblpayment` p, `tblguest` g,`tblreservation` r WHERE p.`GUESTID` = g.`GUESTID` AND p.`CONFIRMATIONCODE` = r.`CONFIRMATIONCODE` GROUP BY `G_FNAME` , `G_LNAME` , `G_ADDRESS` , p.`TRANSDATE` , p.`CONFIRMATIONCODE`, p.`client_name` , `PQTY`,p.`STATUS`,g.`GUESTID` ORDER BY p.`STATUS`='pending' desc;");
// $cur = $mydb->loadResultList();
$cur = $reservation->listOfreservation(true);
$datenow = date("Y-m-d");

				  			 
foreach ($cur as $key => $result) {
	$rDate = date_create($result->ARRIVAL);
	if (strpos(date_format($rDate, 'm/d/Y H:i:s'), '00:00:00') !== false || strpos(date_format($rDate, 'm/d/Y H:i:s'), '12:00:00') !== false) {
		$rDate = date_format($rDate, 'm/d/Y');
	} else {
		$rDate = date_format($rDate, 'm/d/Y h:i A');
	}

	$adds = $reservation->additional_reservations($result->CONFIRMATIONCODE);
	// var_dump($result);
	// var_dump($adds);
	$pays = $reservation->getPayments($result->CONFIRMATIONCODE);
?>
<tr>
<td width="5%" align="center"><?php echo strval($key+1); ?></td>
<td><?php echo $result->client_name; ?></td>
<!-- <td><?php echo $result->BOOKDATE ?></td>   -->
<td><?php  echo $rDate; ?></td>  
<!-- <td><?php echo $result->CONFIRMATIONCODE; ?></td> -->
<!-- <td><?php echo $result->PQTY; ?></td> -->
<!-- Services -->

<?php 
	echo "<td>";
	echo 	'' . $result->ACCOMODATION . '<br>';
	foreach ($adds as $a => $add) {
		echo '- ' . $add->ACCOMODATION . '<br>';
	}
	echo "</td>";

	echo "<td>";
	echo '' . $result->accom_qty . '<br>';
	foreach ($adds as $a => $add) {
		echo '' . $add->qty . '<br>';
	}
	echo "</td>";

	echo "<td>";
	echo '₱ ' . number_format($result->price, 2, '.', ',') . '<br>';
	$total_sum = $result->price;
	foreach ($adds as $a => $add) {
		$total_sum += $add->total_price;
		echo '₱ ' . number_format($add->total_price, 2, '.', ',') . '<br>';
	}

	
	
	// echo '<hr style="margin: 0; border-color: #333;">';
	if (!empty($adds)) {
		echo '<span style="margin: 0; border-color: #333; border-top: 1px; border-top-style: dashed;">₱ ' . number_format($total_sum, 2, '.', ',') . '</span><br>';
	}
	echo "</td>";

	echo '<td>';
	if (isset($pays)) {
		// var_dump($pays);
		$total_payments = 0;
		foreach ($pays as $p => $pay) {
			$total_payments += $pay->payment;
			echo '₱ ' . number_format($pay->payment, 2, '.', ',')  . '<br>';
		}
		if (!empty($pays) && count($pays) > 1) {
			echo '<span style="margin: 0; border-color: #333; border-top: 1px; border-top-style: dashed;">₱ ' . number_format($total_payments, 2, '.', ',') . '</span><br>';
		}
	}

	if ($result->paid != 1) {
	echo'<form action="controller.php?action=addpay" method="POST">
			<input type="hidden" name="code" value="'.$result->CONFIRMATIONCODE.'" >
			<input type="text" name="pay" class="form-control input-sm btn-mt-4" placeholder="Payment" oninput="this.value=this.value.replace(/[^0-9]/g,'."''".');">
			<button type="submit" class="btn-mt-4 btn btn-sm btn-success">Pay</button>
		</form>';
	} else {
		echo '<span class="text-success"><strong><i class="fa fa-check"></i>Paid</strong></span><br>';
		echo '<span class="text-primary">
		<i class="fa fa-money"></i>
		Change: </span><br> ₱ '.strval(number_format($total_payments - $total_sum, 2, '.', ',')).'<br>';
	}

	echo '</td>';
	// echo "<td>";
	// echo '₱ ' . $result->price . '<br>';
	// echo "</td>"
?>
<!-- <td>
	<?php
		echo '- ' . $result->ACCOMODATION . '<br>';
		foreach ($adds as $a => $add) {
			echo '- ' . $add->ACCOMODATION . '<br>';
		}
	?>
</td>
<td>
	<?php 
		echo '₱ ' . $result->price . '<br>';
	?>
</td> -->

<td>
	<?php echo $result->STATUS; ?></td> 
 <td >
	<?php 

		if ($total_payments >= $total_sum) {
			echo '<a href="/guest/readmessage.php?code='.$result->CONFIRMATIONCODE.'" class="btn btn-info btn-sm btn-mt-4">
			<i class="fa fa-print"></i>	Print
			</a>';

			if (!$result->paid) {
				echo ' <a href="controller.php?action=markaspaid&code='.$result->CONFIRMATIONCODE.'" class="btn btn-success btn-sm btn-mt-4">
				<i class="fa fa-money"></i>	Mark as Paid
				</a>';
			}
			
		}
		
		if($result->STATUS == 'Confirmed'){ ?>
		<!-- <a class="cls_btn" id="<?php echo $result->reservation_id; ?>" data-toggle='modal' href="#profile" title="Click here to Change Image." ><i class="icon-edit">test</a> -->
			<a href="index.php?view=view&code=<?php echo $result->CONFIRMATIONCODE; ?>" class="btn btn-info mb-1 btn-sm btn-mt-4" >
				View
			</a>
			<a href="controller.php?action=cancel&code=<?php echo $result->CONFIRMATIONCODE; ?>" class="btn btn-sm btn-mt-4 btn-cancel" >
			</i>Cancel</a>
			<?php 
				if($datenow == date_format(date_create($rDate),'Y-m-d')){
					echo '<a href="controller.php?action=checkin&code='.$result->CONFIRMATIONCODE.'" class="btn btn-success btn-sm btn-mt-4" ><i class="icon-edit">Check in</a>';
				}
			?>
			<a href="controller.php?action=delete&code=<?php echo $result->CONFIRMATIONCODE; ?>" class="btn btn-danger btn-sm btn-mt-4"  >
			<i class="fa fa-trash "></i> Delete</a>
			<a href="index.php?view=edit&code=<?php echo $result->CONFIRMATIONCODE; ?>&id=<?php echo $result->GUESTID; ?>" class="btn btn-primary btn-sm btn-mt-4"  >
			<i class="fa fa-edit"></i>
			Edit

			</a>
		<?php
		}elseif($result->STATUS == 'Checkedin'){
	?>
			<a href="index.php?view=view&code=<?php echo $result->CONFIRMATIONCODE; ?>" class="btn btn-info btn-sm btn-mt-4" >
				View
			</a>
			<a href="controller.php?action=checkout&code=<?php echo $result->CONFIRMATIONCODE; ?>" class="btn btn-warning btn-sm btn-mt-4" >
				Check out
			</a>
			<a href="controller.php?action=delete&code=<?php echo $result->CONFIRMATIONCODE; ?>" class="btn btn-danger btn-sm btn-mt-4"  >
			<i class="fa fa-trash"></i>
				Delete
			</a>
			<a href="index.php?view=edit&code=<?php echo $result->CONFIRMATIONCODE; ?>&id=<?php echo $result->GUESTID; ?>" class="btn btn-primary btn-sm btn-mt-4">
				<i class="fa fa-edit"></i>
				Edit
			</a>
	<?php
		}elseif($result->STATUS == 'Checkedout'){ ?>
			<a href="index.php?view=view&code=<?php echo $result->CONFIRMATIONCODE; ?>" class="btn btn-primary btn-sm btn-mt-4" >
			View</a>
			<a href="controller.php?action=delete&code=<?php echo $result->CONFIRMATIONCODE; ?>" class="btn btn-danger btn-sm btn-mt-4"  >
				<i class="fa fa-trash"></i>
				Delete
			</a>
			<a href="index.php?view=edit&code=<?php echo $result->CONFIRMATIONCODE; ?>&id=<?php echo $result->GUESTID; ?>" class="btn btn-primary btn-sm btn-mt-4"  >
				<i class="fa fa-edit"></i>
				Edit
			</a>
			
	<?php }else{
			?>
			<a href="index.php?view=view&code=<?php echo $result->CONFIRMATIONCODE; ?>" class="btn btn-primary btn-sm btn-mt-4" >
				View
			</a>
			<a href="controller.php?action=cancel&code=<?php echo $result->CONFIRMATIONCODE; ?>" class="btn btn-sm btn-mt-4 btn-cancel" >
				Cancel
			</a>
			<a href="controller.php?action=confirm&code=<?php echo $result->CONFIRMATIONCODE; ?>" class="btn btn-success btn-sm btn-mt-4"  >
				Confirm
			</a>
			<a href="controller.php?action=delete&code=<?php echo $result->CONFIRMATIONCODE; ?>" class="btn btn-danger btn-sm btn-mt-4"  >
				<i class="fa fa-trash"></i>
				Delete
			</a>
			<a href="index.php?view=edit&code=<?php echo $result->CONFIRMATIONCODE; ?>&id=<?php echo $result->GUESTID; ?>" class="btn btn-primary btn-sm btn-mt-4"  >
				<i class="fa fa-edit"></i>
				Edit
			</a>
	<?php
		}

	?>
	
	
</td>

<?php }
?>
		<div class="modal fade" id="profile" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						

						<div class="alert alert-info">Profile:</div>
					</div>

					<form action="#"  method=
					"post">
						<div class="modal-body">
					
												
								<div id="display">
									
										<p>ID : <div id="infoid"></div></p><br/>
											Name : <div id="infoname"></div><br/>
											Email Address : <div id="Email"></div><br/>
											Gender : <div id="Gender"></div><br/>
											Birthday : <div id="bday"></div>
										</p>
										
								</div>
						</div>

						<div class="modal-footer">
							<button class="btn btn-default" data-dismiss="modal" type=
							"button">Close</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

</table>

<!-- </form> -->
<!-- </div> -->
</div>