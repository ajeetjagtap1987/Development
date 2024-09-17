<?php
$encrypter = \Config\Services::encrypter();
$u_id = bin2hex($encrypter->encrypt($user[0]['id']));
?>
          <!-- Page title -->
       	<div class="page-header d-print-none">
			<div class="container-xl">
				<?php echo @view('includes/breadcrumb2', ['level_1' => 'User List', 'level_1_url' => 'users/list', 'level_2' => 'User Change Password']); ?>
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
						    <div class="card-header">
				                <h3 class="card-title">Change Password - <?= $user[0]['first_name'].' '.$user[0]['last_name']?></h3>
				            </div>
			                <div class="card-body">
			                	<form action="<?= base_url();?>/users/update-password/<?=$u_id?>" method="post" autocomplete="off">
								<?= csrf_field();  ?>
			                  	<div class="form-group mb-3 ">
			                      <label class="form-label required">New Password*</label>
			                      <div>
			                        <input type="password" class="form-control" placeholder="New Password" name="new_password" id="new_password" required="true">
			                      </div>
			                    </div>
			                    <div class="form-group mb-3 ">
			                      <label class="form-label required">Confirm Password*</label>
			                      <div >
			                         <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm_password" required="true">
			                      </div>
			                    </div>
			                    <div class="form-footer">
			                      <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?');">Update</button>
			                    </div>
			                  </form>
			                </div>
		                </div>
	            	</div>
	          	</div>
	        </div>
        </div>