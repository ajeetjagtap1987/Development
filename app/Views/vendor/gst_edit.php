<?php
$encrypter = \Config\Services::encrypter();
$e_id=bin2hex($encrypter->encrypt($vendor_gst[0]['id']));
$e_vendor_id=bin2hex($encrypter->encrypt($vendor_gst[0]['vendor_id']));
?>
	
  <!-- Page title -->
  <div class="page-header d-print-none">
  	<div class="container-xl">
    <?php echo @view('includes/breadcrumb2', ['level_1' => 'Vendor GST List', 'level_1_url' => 'vendor/gst_list/'.$e_vendor_id, 'level_2' => 'Vendor GST Edit']); ?>
  	</div>
  </div>
  <div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
          	<div class="col-12">
					    <?php
				      if(session()->has("error")){
				      ?>
				        <div class="alert alert-danger alert-dismissible">
				          <?php echo session("error"); ?>
				        </div>  
				      <?php
				      }
				      ?>
				      <?php
				      if(session()->has("success")){
				      ?>
				        <div class="alert alert-success alert-dismissible">
				          <?php echo session("success"); ?>
				        </div>  
				      <?php
				      }
				      ?>
            	<div class="card">
                <form action="<?php echo base_url();?>/vendor_gst/update/<?php echo $e_id;?>" id="update" method="post" enctype="multipart/form-data" autocomplete="off">
                <div class="card-body">
                	<div class="row">	
                  	<div class="form-group col-md-6 mb-3 ">
                      <label class="form-label required">Gst Registration Number</label>
                      <div>
                        <input type="text" name="gst_registration_number" class="form-control" placeholder="Enter Gst Registration Number" value="<?= $vendor_gst[0]['gst_registration_number']?>" required>
                      </div>
                    </div>
                  	<div class="form-group col-md-6 mb-3 ">
                      <label class="form-label required">Plot No / Floor / Bldg Name</label>
                      <div>
                        <input type="text" name="plot_floor_building" class="form-control" placeholder="Enter Plot No / Floor / Bldg Name" value="<?= $vendor_gst[0]['plot_floor_building']?>" required>
                      </div>
                    </div>
                  	<div class="form-group col-md-12 mb-3 ">
                      <label class="form-label required">Street Address 1</label>
                      <div>
                        <input type="text" name="street_address_one" class="form-control" placeholder="Enter Street Address 1" value="<?= $vendor_gst[0]['street_address_one']?>" required>
                      </div>
                    </div>
                  	<div class="form-group col-md-12 mb-3 ">
                      <label class="form-label">Street Address 2</label>
                      <div>
                        <input type="text" name="street_address_two" class="form-control" placeholder="Enter Street Address 2" value="<?= $vendor_gst[0]['street_address_two']?>" >
                      </div>
                    </div>
                  	<div class="form-group col-md-6 mb-3 ">
                      <label class="form-label required">City</label>
                      <div>
                        <input type="text" name="city" class="form-control" placeholder="Enter City" value="<?= $vendor_gst[0]['city']?>" required>
                      </div>
                    </div>
                  	<div class="form-group col-md-6 mb-3 ">
                      <label class="form-label required" required>Country</label>
                      <div>
                        <input type="text" name="country" class="form-control" placeholder="Enter Country" value="<?= $vendor_gst[0]['country']?>" required>
                      </div>
                    </div>
                  	<div class="form-group col-md-6 mb-3 ">
                      <label class="form-label required">State</label>
                      <div>
                        <input type="text" name="state" class="form-control" placeholder="Enter State" value="<?= $vendor_gst[0]['state']?>" required>
                      </div>
                    </div>
                  	<div class="form-group col-md-6 mb-3 ">
                      <label class="form-label required">Pin code</label>
                      <div>
                        <input type="text" name="pincode" class="form-control number" placeholder="Enter Pin code" value="<?= $vendor_gst[0]['pincode']?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-footer">
                  	<button type="submit" class="btn btn-primary submit_button" onclick="return confirm('Are you sure?');">Submit</button>
                    <button class="btn btn-primary loader_button" type="button" disabled>
                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                      Loading...
                    </button>
                  </div>
                </div>
                </form>
              </div>
        	</div>
      	</div>
    </div>
  </div>

<script type="text/javascript">
	$("#update").submit(function(event){
      event.preventDefault();
      var post_url = $(this).attr("action");
      var request_method = $(this).attr("method");
      var form_data = new FormData(this);
        $('.submit_button').css('display','none');
        $('.loader_button').css('display','block');
        $.ajax({
          url : post_url,
          type: request_method,
          data : form_data,
          dataType: 'json',
          contentType: false,
          cache: false,
          processData:false
        }).done(function(response){ 
            if(response.status == 'success' ){
              window.location.href = '<?php echo base_url()?>/vendor/gst_list/<?php echo $e_vendor_id?>';
            }else{
              Swal.fire({
                icon: response.status,
                text: response.message,
              })
            } 
            $('.submit_button').css('display','block');
            $('.loader_button').css('display','none');
            
        });
     
  });
</script>