
  <div class="page-header d-print-none">
  	<div class="container-xl">
    <?php echo @view('includes/breadcrumb2', ['level_1' => 'Office Location List', 'level_1_url' => 'office_location/list', 'level_2' => 'Office Location Create']); ?>
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
                <div class="card-body">
                	<form action="<?php echo base_url();?>/office_location/insert" method="post" id="insert" autocomplete="off">
                  <?= csrf_field();  ?>

                  <div class="form-group mb-3 ">
                      <label class="form-label">Country</label>
                      <div>
                        <select class="form-select" name="country" required="">
                        	<option value="">Select</option>
                        	<?php
											if (count($country) > 0) {
												foreach ($country as $d) {
													echo '<option value="' . $d['id'] . '">' . $d['name'] . '</option>';
												}
											}
											?>
                        </select>	
                      </div>
                    </div>

                  	<div class="form-group mb-3 ">
                      <label class="form-label required">Location</label>
                      <div >
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                      </div>
                    </div>
                    <div class="form-group mb-3 ">
                      <label class="form-label required">Address</label>
                      <div>
                        <textarea name="address" class="form-control" placeholder="Enter Address" required></textarea>
                      </div>
                    </div>
                    <div class="form-footer">
                    	<button type="submit" class="btn btn-primary submit_button" onclick="return confirm('Are you sure?');">Submit</button>
                      <button class="btn btn-primary loader_button" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                      </button>
                    </div>
                  </form>
                </div>
              </div>
        	</div>
      	</div>
    </div>
  </div>

<script type="text/javascript">
	$("#insert").submit(function(event){
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
              window.location.href = '<?php echo base_url()?>/office_location/list';
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