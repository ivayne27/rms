
<form class="form-horizontal well span6" action="controller.php?action=add" method="POST">

	<fieldset>
		<legend>New Accomodation</legend>
											
          
          <div class="form-group">
            <div class="col-md-8">
              <label class="col-md-4 control-label" for=
              "ACCOMODATION">Service name:</label>

              <div class="col-md-8">
              	<input name="deptid" type="hidden" value="">
                 <input class="form-control input-sm" id="ACCOMODATION" name="ACCOMODATION" placeholder=
									  "Service name" type="text" value="">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-8">
              <label class="col-md-4 control-label" for=
              "ACCOMDESC">Description:</label>

              <div class="col-md-8">
                   <input class="form-control input-sm" id="ACCOMDESC" name="ACCOMDESC" placeholder=
									  "Description" type="text" value="">
              </div>
            </div>
          </div>

					<div class="form-group">
            <div class="col-md-8">
              <label class="col-md-4 control-label" for=
              "max_person_included">Max person included:</label>

              <div class="col-md-8">
                   <input required class="form-control input-sm" id="max_person_included" name="max_person_included" placeholder=
									  "Max person included" type="number" value="<?php echo $result->max_person_included ? $result->max_person_included : ''; ?>">
              </div>
            </div>
          </div>

					<div class="form-group">
            <div class="col-md-8">
              <label class="col-md-4 control-label" for=
              "price">Price:</label>

              <div class="col-md-8">
                   <input required class="form-control input-sm" id="price" name="price" placeholder=
									  "Price" type="number" value="<?php echo $result->price ? $result->price : ''; ?>">
              </div>
            </div>
          </div>

		 <div class="form-group">
            <div class="col-md-8">
              <label class="col-md-4 control-label" for=
              "idno"></label>

              <div class="col-md-8">
                <button class="btn btn-primary" name="save" type="submit" >Save</button>
              </div>
            </div>
          </div>

			
	</fieldset>	


</form>
<!-- Pager -->
<div class="row">
    <ul class="pager">
        <li class="previous"><a href="<?php echo '/admin/mod_room/index.php'; ?>">&larr; Back</a>
        </li>
    </ul>
</div>

</div><!--End of container-->
			

