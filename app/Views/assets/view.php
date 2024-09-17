<?php
use App\Models\CommonModel;
$CommonModel = new CommonModel();
$encrypter = \Config\Services::encrypter();
$e_id=bin2hex($encrypter->encrypt($assets[0]['id']));
?>
				 <!-- Page title -->
        <div class="page-header d-print-none">
        	<div class="container-xl">
          <?php echo @view('includes/breadcrumb2', ['level_1' => 'Assets List', 'level_1_url' => 'assets/list', 'level_2' =>  $assets[0]['asset_id'] ]); ?>
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
																				foreach( $category as $cat ){
																					echo $assets[0]['category_id'] == $cat['id'] ? $cat['category_name'] : '';
																			  }
																			}
																      	?>
																      	
																      </td>
																    </tr>
																   	<tr>
																      <th scope="row" width="180px">Manufacturer</th>
																      <td>
																      	<?php 
																			if(count($manufacturer)>0){
																				foreach( $manufacturer as $mf ){
																					echo $assets[0]['manufacturer_id'] == $mf['id'] ? $mf['name'] : '';;
																			  }
																			}
																      	?>
																      </td>
																    </tr>
																   	<tr>
																      <th scope="row" width="180px">Vendor</th>
																      <td>
																      	<?php 
																			if(count($vendor)>0){
																				foreach( $vendor as $ven ){
																					echo $assets[0]['vendor_id'] == $ven['id'] ? $ven['supplier_name'] : '';
																			  }
																			}
																      	?>
																      </td>
																    </tr>
																   	<tr>
																      <th scope="row" width="180px">Vendor Invoice</th>
																      <td>
																      	<?php 
																			if(count($vendor_invoice)>0){
																				foreach( $vendor_invoice as $vi ){
																					echo $assets[0]['invoice_no_id'] == $vi['id'] ? $vi['invoice_no'].'('.$vi['currency'].')' : '';
																			  }
																			}
																      	?>
																      </td>
																    </tr>
																   	<tr>
																      <th scope="row" width="180px">Office Location</th>
																      <td>
																      	<?php 
																			if(count($office_location)>0){
																				foreach( $office_location as $ol ){
																					echo $assets[0]['asset_location_id'] == $ol['id'] ? $ol['name'] : '';
																			  }
																			}
																      	?>
																      </td>
																    </tr>
																    <tr>
																      <th scope="row">Price with GST</th>
																      <td><?= $assets[0]['price']?></td>
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
																      <td><?= $assets[0]['installed_ram']?></td>
																    </tr>
																    <tr class="desk_div lap_div server_div hide_div">
																      <th scope="row">Hard Disk</th>
																      <td><?= $assets[0]['hard_disk']?></td>
																    </tr>
																    <tr class="desk_div lap_div server_div es_div hide_div">
																      <th scope="row">Storage Capacity</th>
																      <td><?= $assets[0]['storage_capacity_unit'].' '.$assets[0]['storage_capacity']?></td>
																    </tr>
																    <tr class="desk_div lap_div hide_div">
																      <th scope="row">Windows Edition</th>
																      <td><?= $assets[0]['windows_edition']?></td>
																    </tr>
																    <tr class="desk_div lap_div hide_div">
																      <th scope="row">>Windows Key</th>
																      <td><?= $assets[0]['windows_key']?></td>
																    </tr>
																    <tr class="desk_div hide_div">
																      <th scope="row">Host Name</th>
																      <td><?= $assets[0]['host_name']?></td>
																    </tr>
																    <tr class="desk_div lap_div hide_div">
																      <th scope="row">Device ID<</th>
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
				                	<!-- <div class="row">	
															
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label ">Category</label>
				                      <div>
				                      		<select type="text" class="form-select category_id" name="category_id"  disabled value="" >
				                      			<option value="">Select Category</option>
														      	<?php 
																				if(count($category)>0){
																					foreach( $category as $cat ){
																						$select = $assets[0]['category_id'] == $cat['id'] ? 'selected' : '';
																						echo '<option value="'.$cat['id'].'" '.$select.'>'.$cat['category_name'].'</option>';
																				  }
																				}
														      	?>
																	</select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label ">Manufacturer</label>
				                      <div>
				                      		<select type="text" class="form-select" name="manufacturer_id"  value="" disabled>
				                      			<option value="">Select Manufacturer</option>
														      	<?php 
																				if(count($manufacturer)>0){
																					foreach( $manufacturer as $mf ){
																						$select = $assets[0]['manufacturer_id'] == $mf['id'] ? 'selected' : '';
																						echo '<option value="'.$mf['id'].'" '.$select.'>'.$mf['name'].'</option>';
																				  }
																				}
														      	?>
																	</select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label ">Vendor</label>
				                      <div>
				                      		<select type="text" class="form-select vendor_id" name="vendor_id"  value="" disabled>
				                      			<option value="">Select Vendor</option>
														      	<?php 
																				if(count($vendor)>0){
																					foreach( $vendor as $ven ){
																						$select = $assets[0]['vendor_id'] == $ven['id'] ? 'selected' : '';
																						echo '<option value="'.$ven['id'].'" '.$select.'>'.$ven['supplier_name'].'</option>';
																				  }
																				}
														      	?>
																	</select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label ">Vendor Invoice</label>
				                      <div>
																	<select class="form-select invoice_no_id" name="invoice_no_id"  disabled>
																		<option value="">Select</option>
																		
																		<?php 
																				if(count($vendor_invoice)>0){
																					foreach( $vendor_invoice as $vi ){
																						$select = $assets[0]['invoice_no_id'] == $vi['id'] ? 'selected' : '';
																						echo '<option value="'.$vi['id'].'" '.$select.'>'.$vi['invoice_no'].'('.$vi['currency'].')'.'</option>';
																				  }
																				}
														      	?>
					                        </select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label ">Office Location</label>
				                      <div>
				                      		<select type="text" class="form-select" name="asset_location_id"  value="" disabled>
				                      			<option value="">Select Office Location</option>
														      	<?php 
																				if(count($office_location)>0){
																					foreach( $office_location as $ol ){
																						$select = $assets[0]['asset_location_id'] == $ol['id'] ? 'selected' : '';
																						echo '<option value="'.$ol['id'].'" '.$select.'>'.$ol['name'].'</option>';
																				  }
																				}
														      	?>
																	</select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label ">Price with GST</label>
				                      <div>
				                        <input type="text" name="price" class="form-control number" value="<?= $assets[0]['price']?>" placeholder="Enter Price with GST" disabled>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label ">Purchase Date</label>
				                      <div class="input-icon mb-2">
																			<input class="form-control datepicker" name="purchase_date" value="<?= $assets[0]['purchase_date']?>" placeholder="Select Purchase Date" disabled>
																			<span class="input-icon-addon">
																			<i class="ti ti-calendar"></i>
																			</span>
															</div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label ">Warranty Expiry Date</label>
				                      <div class="input-icon mb-2">
																			<input class="form-control datepicker" name="warranty_expiry_date" placeholder="Select Warranty Expiry Date" value="<?= $assets[0]['warranty_expiry_date']?>" disabled>
																			<span class="input-icon-addon">
																			<i class="ti ti-calendar"></i>
																			</span>
															</div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label ">Asset ID</label>
				                      <div>
				                        <input type="text" name="asset_id" class="form-control" placeholder="Enter Asset ID" value="<?= $assets[0]['asset_id']?>" disabled>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label ">Model Name</label>
				                      <div>
				                        <input type="text" name="model_name" class="form-control" placeholder="Enter Model Name" value="<?= $assets[0]['model_name']?>" disabled>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label ">Serial No.</label>
				                      <div>
				                        <input type="text" name="serial_no" class="form-control" placeholder="Enter Serial No." value="<?= $assets[0]['serial_no']?>" disabled>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 desk_div lap_div server_div es_div hide_div">
				                      <label class="form-label ">Processor</label>
				                      <div>
				                        <input type="text" name="processor" class="form-control desk_input lap_input server_input es_input" placeholder="Enter Processor" value="<?= $assets[0]['processor']?>" disabled>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 desk_div lap_div server_div es_div hide_div">
				                      <label class="form-label ">Installed RAM</label>
				                      <div>
				                        <input type="text" name="installed_ram" class="form-control desk_input lap_input server_input es_input" placeholder="Enter Installed RAM" value="<?= $assets[0]['installed_ram']?>" disabled>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-2 mb-3 desk_div lap_div server_div hide_div">
				                      <label class="form-label ">Hard Disk</label>
				                      <div>
																	<select class="form-select desk_input lap_input server_input" name="hard_disk" disabled>
																		<option value="">Select</option>
																		<option value="SSD" <?php echo $assets[0]['hard_disk'] == 'SSD' ? 'selected' : '' ?>>SSD</option>
																		<option value="HDD" <?php echo $assets[0]['hard_disk'] == 'HDD' ? 'selected' : '' ?>>HDD</option>
					                        </select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-4 mb-3 desk_div lap_div server_div es_div hide_div">
				                      <label class="form-label ">Storage Capacity</label>
				                      <div>
				                      	<div class="row g-2">
			                            <div class="col-6">
			                              <select name="storage_capacity_unit desk_input lap_input server_input es_input" class="form-select" disabled>
			                                <option value="">Select</option>
			                                <option value="MB" <?php echo $assets[0]['storage_capacity_unit'] == 'MB' ? 'selected' : '' ?>>MB</option>
			                                <option value="GB" <?php echo $assets[0]['storage_capacity_unit'] == 'GB' ? 'selected' : '' ?>>GB</option>
			                                <option value="TB" <?php echo $assets[0]['storage_capacity_unit'] == 'TB' ? 'selected' : '' ?>>TB</option>
			                              </select>
			                            </div>
			                            <div class="col-6">
			                              <input type="text" name="storage_capacity" class="form-control number desk_input lap_input server_input es_input" value="<?= $assets[0]['storage_capacity']?>" placeholder="Enter Storage Capacity"  disabled>
			                            </div>
                           			 </div>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 desk_div lap_div hide_div">
				                      <label class="form-label ">Windows Edition</label>
				                      <div>
				                        <input type="text" name="windows_edition" class="form-control desk_input lap_input" placeholder="Enter Windows Edition" value="<?= $assets[0]['windows_edition']?>" disabled>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 desk_div lap_div hide_div">
				                      <label class="form-label ">Device ID</label>
				                      <div>
				                        <input type="text" name="device_id" class="form-control desk_input lap_input" placeholder="Enter Device ID" value="<?= $assets[0]['device_id']?>" disabled>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 desk_div lap_div hide_div">
				                      <label class="form-label ">Product ID</label>
				                      <div>
				                        <input type="text" name="product_id" class="form-control desk_input lap_input" placeholder="Enter Product ID" value="<?= $assets[0]['product_id']?>" disabled>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 lap_div monitor_div tv_div hide_div">
				                      <label class="form-label ">Screen Size</label>
				                      <div>
				                        <input type="text" name="screen_size" class="form-control lap_input monitor_input tv_input" placeholder="Enter Screen Size" value="<?= $assets[0]['screen_size']?>" disabled>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 mouse_div keyboard_div hide_div">
				                      <label class="form-label ">Type</label>
				                      <div>
																<select class="form-select mouse_input keyboard_input" name="type" disabled>
																	<option value="">Select</option>
																	<option value="Wired" <?php echo $assets[0]['type'] == 'Wired' ? 'selected' : '' ?>>Wired</option>
																	<option value="Wireless" <?php echo $assets[0]['type'] == 'Wireless' ? 'selected' : '' ?>>Wireless</option>
				                        </select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 lap_div hide_div">
				                      <label class="form-label ">ADP Warranty</label>
				                      <div>
				                        <input type="text" name="adp_warranty" class="form-control lap_input" placeholder="Enter ADP Warranty" value="<?= $assets[0]['price']?>" disabled>
				                      </div>
				                    </div>
				                  </div>  --> 
			                </div>
		                </div>
		                <div class="card">
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
										                                    <th>User Name</th>
										                                    <th>User Email</th>
										                                  </tr>';
										                  foreach($user_asset_data as $uad){
										                    $user_data =  $CommonModel->getDataById($table_name='user',$uad['user_id']);
										                    if(count($user_data)>0){
										                    $u_id=bin2hex($encrypter->encrypt($user_data[0]['id']));
										                    $asset_info.='<tr>
										                                    <td><a href="'.base_url().'/users/details/'.$u_id.'" title="Detail" target="_blank">'.$user_data[0]['first_name'].' '.$user_data[0]['last_name'].'</a></td>
										                                    <td>'.$user_data[0]['email'].'</td>
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