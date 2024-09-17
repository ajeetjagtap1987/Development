<?php
$encrypter = \Config\Services::encrypter();
$e_id=bin2hex($encrypter->encrypt($application[0]['id']));
?>
 	<div class="page-header d-print-none">
		<div class="container-xl">
    <?php echo @view('includes/breadcrumb2', ['level_1' => 'Application List', 'level_1_url' => 'application/list', 'level_2' => 'Application Edit']); ?>
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
                	<form action="<?= base_url();?>/application/update/<?= $e_id?>" id="update" method="post" autocomplete="off">
                  <?= csrf_field();  ?>
                    <div class="form-group mb-3 ">
                      <label class="form-label required">Name</label>
                      <div>
                        <input type="text" name="name" class="form-control" placeholder="Enter Application Name" value="<?= $application[0]['name']?>" required>
                      </div>
                    </div>
                    <div class="form-group mb-3 ">
                      <label class="form-label required">Category</label>
                      <div>
                      		<select type="text" class="form-control" name="category_id" required >
                      			<option value="">Select Category</option>
										      	<?php 
																if(count($category)>0){
																	foreach( $category as $cat ){
																		$select = $application[0]['category_id'] == $cat['id'] ? 'selected' : '';
																		echo '<option value="'.$cat['id'].'" '.$select.'>'.$cat['category_name'].'</option>';
																  }
																}
										      	?>
													</select>
                      </div>
                    </div>
                    <div class="form-footer">
		                <button type="submit" class="btn btn-primary submit_button" onclick="return confirm('Are you sure?');">Update</button>
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
              // Swal.fire({
              //   icon: response.status,
              //   text: response.message,
              // });
              window.location.href = '<?php echo base_url()?>/application/list';
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