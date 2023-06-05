
<div class="container">
	<?php
		check_message();
			
		?>
		<!-- <div class="panel panel-primary"> -->
			<div class="panel-body">
			<h3 align="left">List of Services</h3>
			    <form action="/admin/mod_accomodation/controller.php?action=delete" Method="POST">  					
				<table id="example" style="font-size:12px" class="table table-striped table-hover table-responsive"  cellspacing="0">
					
				  <thead>
				  	<tr  >
				  	<th>No.</th>
				  		<th align="left"  width="10">
				  		 <input type="checkbox" name="chkall" id="chkall" onclick="return checkall('selector[]');"> 
				  		</th>
				  		<!-- <th>Room#</th> -->
				  		<th align="left"  width="150">Services</th>	
				  		<th align="left" width="120">Description</th>
				  		<th align="left" width="120">Max Person Included</th> 
				  		<th align="left"  width="100">Price</th>
							<th align="left"  width="200">Action</th>
				  		<!-- <th># of Rooms</th> -->
				  	</tr>	
				  </thead>
				  <tbody>
				  	<?php 
				  		$mydb->setQuery("SELECT * from tblaccomodation");
				
				  		$cur = $mydb->loadResultList();


						foreach ($cur as $key => $result) {
				  		echo '<tr>';
						echo '<td width="5%" align="center">' . strval($key+1) . '</td>';
				  		echo '<td align="left"  width="10"><input type="checkbox" name="selector[]" id="selector[]" value="'.$result->ACCOMID. '"/> 
				  				</td>';
									//<img src="'. $result->ROOMIMAGE.'" width="60" height="40" title="'. $result->ROOM .'"/>
				  		// echo '<td><a href="index.php?view=edit&id='.$result->ROOMID.'">' . ' '.$result->ROOMNUM.'</a></td>';
						echo '<td><a href="index.php?view=edit&id='.$result->ACCOMID.'">'. $result->ACCOMODATION.'</a></td>';
				  		// echo '<td>'. $result->ROOMDESC.'</td>';
						// echo '<td>'. $result->ACCOMODATION.' ('. $result->ACCOMDESC.')</td>';
						echo '<td>'. $result->ACCOMDESC.'</td>';
				  		echo '<td>'. $result->max_person_included.'</td>';
				  		
				  		echo '<td> ₱'. $result->price.'</td>';
				  		// echo '<td>'.$result->ROOMNUM.' </td>';
							echo '<td> 
								<a href="/admin/mod_accomodation/index.php?view=edit&id='.$result->ACCOMID.'" class="btn btn-primary mb-1 btn-sm btn-mt-4" ><i class="fa fa-edit"></i> Edit</a>
								<a href="/admin/mod_accomodation/controller.php?action=delete&id='.$result->ACCOMID.'" class="btn btn-danger mb-1 btn-sm btn-mt-4" ><i class="fa fa-trash"></i> Delete</a>
									 </td>';
				  		echo '</tr>';
				  	} 
				  	?>
				  </tbody>
				 	
				</table>
				<div class="btn-group">
				  <a href="/admin/mod_accomodation/index.php?view=add" class="btn btn-default">New</a>
				  <button type="submit" class="btn btn-default" name="delete"><span class="glyphicon glyphicon-trash"></span> Delete Selected</button>
				</div>
				</form>
	  		</div><!--End of Panel Body-->
	  	<!-- </div> -->
	  	<!--End of Main Panel-->

</div><!--End of container-->

<div class="modal fade" id="myModal" tabindex="-1">

</div>