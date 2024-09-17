<?php
use App\Models\CommonModel;
$CommonModel = new CommonModel();
$encrypter = \Config\Services::encrypter();
$e_id=bin2hex($encrypter->encrypt($assets[0]['id']));
?>
				 <!-- Page title -->
        <div class="page-header d-print-none">
					<div class="container-xl">
						<div class="row g-2 align-items-center">
						  <div class="col">
						    <h2 class="page-title">
						      <?php echo $assets[0]['asset_id'];
									if($assets[0]['status'] == ASSET_BUFFER){
	                    echo '<span class="badge bg-primary" style="margin-left:10px">Buffer</span>';
	                }elseif($assets[0]['status'] == ASSET_ASSIGN){
	                    echo '<span class="badge bg-success" style="margin-left:10px">Assign</span>';
	                }elseif($assets[0]['status'] == ASSET_DAMAGE){
	                    echo '<span class="badge bg-warning" style="margin-left:10px">Damage</span>';
	                }elseif($assets[0]['status'] == ASSET_REPAIR){
	                    echo '<span class="badge bg-info" style="margin-left:10px">Repair</span>';
	                }?>
						    </h2>
						  </div>
						  <div class="col-12 col-md-auto ms-auto d-print-none">
						    <div class="d-flex">
						      <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
						        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
						        <li class="breadcrumb-item"><a href="<?php echo base_url().'/assets/list' ?>">Assets List</a></li>
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
		              	<div class="card mb-2">
		              		<div class="card-header bg-primary text-white" style="padding: 0.5rem 1.2rem;">
		              			<h3 class="card-title">Asset Details</h3>
		              		</div>
			                <div class="card-body">
			                	  <div class="row">
			                	  		<table class="table table-bordered table-striped table-responsive table-sm">
																<tbody>
																    <tr>
																      <th scope="row" width="180px">Category</th>
																      <td>
																      	<?php
																			if(count($category)>0){
																				echo $category[0]['category_name'];
																				echo '<input type="hidden" id="category_id" value="'.$category[0]['id'].'"/>';
																			}
																      	?>

																      </td>
																    </tr>
																   	<tr>
																      <th scope="row" width="180px">Manufacturer</th>
																      <td>
																      	<?php
																			if(count($manufacturer)>0){
																				echo $manufacturer[0]['name'];
																			}
																      	?>
																      </td>
																    </tr>
																    <tr>
																      <th scope="row">Asset ID</th>
																      <td><?= $assets[0]['asset_id']?></td>
																    </tr>
																    <tr>
																      <th scope="row">Model Name</th>
																      <td><?= $assets[0]['model_name']?></td>
																    </tr>
																    <tr>
																      <th scope="row">Serial No.</th>
																      <td><?= $assets[0]['serial_no']?></td>
																    </tr>
																    <tr class="desk_div lap_div server_div es_div hide_div">
																      <th scope="row">Processor</th>
																      <td><?= $assets[0]['processor']?></td>
																    </tr>
																    <tr class="desk_div lap_div server_div es_div hide_div">
																      <th scope="row">Installed RAM</th>
																      <td><?= $assets[0]['installed_ram'].' '.$assets[0]['ram_unit']?></td>
																    </tr>
																    <tr class="desk_div lap_div server_div hide_div">
																      <th scope="row">Hard Disk</th>
																      <td><?= $assets[0]['hard_disk']?></td>
																    </tr>
																    <tr class="desk_div lap_div server_div es_div hide_div">
																      <th scope="row">Storage Capacity</th>
																      <td><?= $assets[0]['storage_capacity'].' '.$assets[0]['storage_capacity_unit'] ?></td>
																    </tr>
																    <tr class="desk_div lap_div hide_div">
																      <th scope="row">Windows Edition</th>
																      <td><?= $assets[0]['windows_edition']?></td>
																    </tr>
																    <tr class="desk_div lap_div hide_div">
																      <th scope="row">Windows Key</th>
																      <td><?= $assets[0]['windows_key']?></td>
																    </tr>
																    <tr class="desk_div hide_div">
																      <th scope="row">Host Name</th>
																      <td><?= $assets[0]['host_name']?></td>
																    </tr>
																    <tr class="desk_div lap_div hide_div">
																      <th scope="row">Device ID</th>
																      <td><?= $assets[0]['device_id']?></td>
																    </tr>
																    <tr class="desk_div lap_div hide_div">
																      <th scope="row">Product ID</th>
																      <td><?= $assets[0]['product_id']?></td>
																    </tr>
																    <tr class="lap_div monitor_div tv_div hide_div">
																      <th scope="row">Screen Size</th>
																      <td><?= $assets[0]['screen_size']?></td>
																    </tr>
																    <tr class="mouse_div keyboard_div hide_div">
																      <th scope="row">Type</th>
																      <td><?= $assets[0]['type']?></td>
																    </tr>
																    <tr class="lap_div hide_div">
																      <th scope="row">ADP Warranty</th>
																      <td><?= $assets[0]['adp_warranty']?></td>
																    </tr>

																</tbody>
															</table>
			                	  </div>
			                </div>
		                </div>
		                <div class="card mb-2">
		              		<div class="card-header bg-primary text-white" style="padding: 0.5rem 1.2rem;">
		              			<h3 class="card-title">Asset Purchase Details</h3>
		              		</div>
			                <div class="card-body">
			                	  <div class="row">
			                	  		<table class="table table-bordered table-striped table-responsive table-sm">
																<tbody>
																    <tr>
																      <th scope="row" width="180px">Vendor</th>
																      <td>
																      	<?php
																			if(count($vendor)>0){
																					echo $vendor[0]['supplier_name'];
																			}
																      	?>
																      </td>
																    </tr>
																   	<tr>
																      <th scope="row" width="180px">Vendor Invoice</th>
																      <td>
																      	<?php
																			if(count($vendor_invoice)>0){
																				echo $vendor_invoice[0]['invoice_no'].'('.$vendor_invoice[0]['currency'].')';
																			}
																      	?>
																      </td>
																    </tr>
																   	<tr>
																      <th scope="row" width="180px">Office Location</th>
																      <td>
																      	<?php
																			if(count($office_location)>0){
																				echo $office_location[0]['name'];
																			}
																      	?>
																      </td>
																    </tr>
																    <tr>
																      <th scope="row">Price with GST</th>
																      <td><?= $assets[0]['price'].'('.$vendor_invoice[0]['currency'].')'?></td>
																    </tr>
																    <tr>
																      <th scope="row">Purchase Date</th>
																      <td>
																      	<?php if(isset($assets[0]['purchase_date']) && $assets[0]['purchase_date'] !=''){
																      		echo
																      		date( DATEFORMAT, strtotime($assets[0]['purchase_date']));
																      		}
																      	?>
																      </td>
																    </tr>
																    <tr>
																      <th scope="row">Warranty Expiry Date</th>
																      <td>
																      	<?php if(isset($assets[0]['warranty_expiry_date']) && $assets[0]['warranty_expiry_date'] !=''){
																      		echo
																      		date( DATEFORMAT, strtotime($assets[0]['warranty_expiry_date']));
																      		}
																      	?>
																      </td>
																    </tr>
																    <tr>
																      <th scope="row">Created Date</th>
																      <td>
																      	<?php $convert_time = $CommonModel->converToTz($assets[0]['created_date']);
																      		echo $convert_time;
																      	?>
																      </td>
																    </tr>
																</tbody>
															</table>
			                	  </div>
			                </div>
		                </div>
		                <div class="card mb-2">
		              		<div class="card-header bg-primary text-white" style="padding: 0.5rem 1.2rem;">
		              			<h3 class="card-title">Asset Assigned User List</h3>
		              		</div>
			                <div class="card-body">
			                	  <div class="row">
			                	  	<?php
													      $user_asset_data =  $CommonModel->getUserAssetsByAssetId($assets[0]['id']);
													      $asset_info='';
										            if(count($user_asset_data)>0){
										                $asset_info.='<table class="table table-bordered table-striped table-responsive table-sm">
										                  <tbody>';
										                  $asset_info.='<tr>
										                                    <th>Name</th>
										                                    <th>Email</th>
										                                    <th>Job Title</th>
										                                    <th>Reporting Head</th>
										                                  </tr>';
										                  foreach($user_asset_data as $uad){
										                    $user_data =  $CommonModel->getDataById($table_name='user',$uad['user_id']);
										                    if(count($user_data)>0){
										                    $u_id=bin2hex($encrypter->encrypt($user_data[0]['id']));
										                    $asset_info.='<tr>
										                                    <td><a href="'.base_url().'/users/details/'.$u_id.'" title="Detail" target="_blank">'.$user_data[0]['first_name'].' '.$user_data[0]['last_name'].'</a></td>
										                                    <td>'.$user_data[0]['email'].'</td>
										                                    <td>'.$user_data[0]['job_title'].'</td>
										                                    <td>'.$user_data[0]['reporting_head'].'</td>
										                                  </tr>';
										                    }
										                  }

										                $asset_info.='</tbody>
										                </table>';
										            }
										            echo $asset_info;
            								?>

			                	  </div>
			                </div>
		                </div>
	            	</div>
	          	</div>
	        </div>
        </div>

<script type="text/javascript">
  $(document).ready(function (){
				$('.desk_div').hide();
				$('.lap_div').hide();
				$('.server_div').hide();
				$('.es_div').hide();
				$('.monitor_div').hide();
				$('.tv_div').hide();
				$('.mouse_div').hide();
				$('.keyboard_div').hide();
				var category_id = $('#category_id').val();
        if(category_id == 1){
		        $('.desk_div').show();
        }
        if(category_id == 2){
		        $('.monitor_div').show();
        }
        if(category_id == 3){
		        $('.keyboard_div').show();
        }
        if(category_id == 4){
		        $('.mouse_div').show();
        }
        if(category_id == 5){
		        $('.lap_div').show();
        }
        if(category_id == 16){
		        $('.es_div').show();
        }
        if(category_id == 17){
		        $('.server_div').show();
        }
        if(category_id == 19){
		        $('.tv_div').show();
        }
  });
</script>