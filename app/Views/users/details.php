<style>
.modal-content{
	height: 400px !important;
}

.modal-footer {
    position: absolute !important;
    bottom: 0 !important;
    left: 0 !important;
    right: 0 !important;
    
}
</style>


<?php


use App\Models\CommonModel;
$CommonModel = new CommonModel();
$encrypter = \Config\Services::encrypter();
$u_id=bin2hex($encrypter->encrypt($user[0]['id']));
$data['u_id']=$u_id;
?>	
        <!-- Page title -->
       	<div class="page-header d-print-none">
		<div class="container-xl">
			<div class="row g-2 align-items-center">
			  <div class="col">
			    <h2 class="page-title">
			      <?php echo $user[0]['first_name'].' '.$user[0]['last_name'];
				if($user[0]['status'] == ACTIVE){
		                    echo '<span class="badge bg-success" style="margin-left:10px">Active</span>';
		                }elseif($user[0]['status'] == RESIGNED){
		                    echo '<span class="badge bg-danger" style="margin-left:10px">RESIGNED</span>';
		                }?>
			    </h2>
			  </div>
			  <div class="col-12 col-md-auto ms-auto d-print-none">
			    <div class="d-flex">
			      <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
			        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
			        <li class="breadcrumb-item"><a href="<?php echo base_url().'/users/list' ?>">User List</a></li>
			        <li class="breadcrumb-item active" aria-current="page"><a href="#">View</a></li>
			      </ol>
			    </div>
			  </div>
			</div>
		</div>
        </div>
        <div class="page-body">
	        <div class="container-xl">
	            <div class="row row-cards">
	              	<div class="col-12">
		              	<div class="card">
		              		<div class="card-header">
			                    <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist" style="padding: 0;">
			                      <li class="nav-item" role="presentation">
			                        <a href="#val_info" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab" tabindex="-1"><h4 style="margin: 0px">Info</h4></a>
			                      </li>
			                      <!-- <li class="nav-item" role="presentation">
			                        <a href="#val_assets" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"><h4 style="margin: 0px">Assets</h4></a>
			                      </li>
			                      <li class="nav-item" role="presentation">
			                        <a href="#val_licenses" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"><h4 style="margin: 0px">Licenses</h4></a>
			                      </li>
			                      <li class="nav-item" role="presentation">
			                        <a href="#val_applications" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"><h4 style="margin: 0px">Applications</h4></a>
			                      </li> -->
			                      <li class="nav-item" role="presentation">
			                        <a href="#val_history" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"><h4 style="margin: 0px">History</h4></a>
			                      </li>
			                    </ul>
	                  		</div>
			                <div class="card-body">
			                    <div class="tab-content">
			                      	<div class="tab-pane fade active show" id="val_info" role="tabpanel">
							
							<div class="card mb-2">
							    <div class="card-header bg-primary text-white" style="padding: 0.5rem 1.2rem;">
							      <h3 class="card-title">User Info</h3>
							      
							    </div> 
							    <div class="card-body"> 
							        <div class="row">
									<table class="table table-bordered table-striped table-responsive table-sm">
									  <tbody>
									    <tr>
									      <th scope="row"  width="110px">Name</th>
									      <td><?php echo $user[0]['first_name'].' '.$user[0]['last_name']?></td>
									    </tr>
									    <tr>
									      <th scope="row" >Email Address</th>
									      <td><?php echo $user[0]['email']?></td>
									    </tr>
									    <tr>
									      <th scope="row" >Job Title</th>
									      <td><?php echo $user[0]['job_title']?></td>
									    </tr>
						<?php
							if($user[0]['microsoft_365_business_licence']=='Microsoft 365 Business Standard'){
						?>
										<tr>
									      <th scope="row" >Microsoft 365 Business Std</th>
									      <td><?php echo $user[0]['microsoft_365_business_licence']?></td>
									    </tr>


										<?php
							}
							else{
								
						?>
						
						<tr >
									      <th scope="row" >Microsoft 365 Business Basic</th>
									   
										  <td ><?php echo $user[0]['microsoft_365_apps_for_business']?></td>
									    </tr>
										<?php
						}
								
							?>


									    <tr>
									      <th scope="row" >Reporting Head</th>
									      <td><?php echo $user[0]['reporting_head']?></td>
									    </tr>
									    <tr>
									      <th scope="row" >User Type</th>
									      <td>
											<?php 
											foreach (USER_TYPE as $key => $value) {
							                    			if($user[0]['user_type'] == $key){
								                         echo $value;
								                	}
									                }
									            	?>
									       </td>
									    </tr>
									    <tr>
									      <th scope="row" >Joining Date</th>
									      <td>
									      	<?php if(isset($user[0]['joining_date']) && $user[0]['joining_date'] !=''){
									      		echo 
									      		date( DATEFORMAT, strtotime($user[0]['joining_date']));
									      		}
									      	?>
									      </td>
									    </tr>
									    <tr>
									      <th scope="row" >Created Date</th>
									      <td>
									      	<?php $convert_time = $CommonModel->converToTz($user[0]['created_date']);
									      		echo $convert_time;
									      	?>
									      </td>
									    </tr>
									  </tbody>
									</table>
							        </div>  
							    </div>
							</div>
							<?php echo view('users/details_assets',$data)?>
							 <?php echo view('users/details_licenses',$data)?> 
							<?php echo view('users/details_applications',$data)?>    
			                      	</div>
			                      	<!-- <div class="tab-pane fade" id="val_assets" role="tabpanel">
								            		 
			                      	</div>
			                      	<div class="tab-pane fade" id="val_licenses" role="tabpanel">
								            		 <?php echo view('users/details_licenses',$data)?>  
			                      	</div>
			                      	<div class="tab-pane fade" id="val_applications" role="tabpanel">
								                <?php echo view('users/details_applications',$data)?>
			                      	</div> -->
			                      	<div class="tab-pane fade" id="val_history" role="tabpanel">
								                
			                      	</div>
			                    </div>
			                </div>
		                </div>
	            	</div>
	          	</div>
	        </div>
        </div>

        