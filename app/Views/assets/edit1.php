<?php
$encrypter = \Config\Services::encrypter();
$e_id=bin2hex($encrypter->encrypt($assets[0]['id']));


?>
				 <!-- Page title -->
        <div class="page-header d-print-none">
        	<div class="container-xl">
          <?php echo @view('includes/breadcrumb2', ['level_1' => 'Assets List', 'level_1_url' => 'assets/list', 'level_2' => 'Asset Edit']); ?>
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
			                	<form action="<?= base_url();?>/assets/update/<?= $e_id?>" id="update" method="post" autocomplete="off">
				                	<div class="row">	
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label required">Category</label>
				                      <div>
				                      		<select type="text" class="form-select category_id" name="category_id" required disabled value="">
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
				                      <label class="form-label required">Manufacturer</label>
				                      <div>
				                      		<select type="text" class="form-select" name="manufacturer_id" required value="">
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
				                      <label class="form-label required">Vendor</label>
				                      <div>
				                      		<select type="text" class="form-select vendor_id" name="vendor_id" required value="">
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
				                      <label class="form-label required">Vendor Invoice</label>
				                      <div>
																	<select class="form-select invoice_no_id" name="invoice_no_id" required>
																		<option value="">Select</option>
																		
																		<?php 
																				if(count($vendor_invoice)>0){
																					foreach( $vendor_invoice as $vi ){
																						$select = $assets[0]['invoice_no_id'] == $vi['id'] ? 'selected' : '';
																						echo '<option value="'.$vi['id'].'" '.$select.'>'.$vi['invoice_no'].'</option>';
																				  }
																				}
														      	?>
					                        </select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label required">Office Location</label>
				                      <div>
				                      		<select type="text" class="form-select" name="asset_location_id" required value="">
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
				                      <label class="form-label required">Price with GST</label>
				                      <div>
				                        <input type="text" name="price" class="form-control number" value="<?= $assets[0]['price']?>" placeholder="Enter Price with GST" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label required">Purchase Date</label>
				                      <div class="input-icon mb-2">
																			<input class="form-control datepicker" name="purchase_date" value="<?= $assets[0]['purchase_date']?>" placeholder="Select Purchase Date" required>
																			<span class="input-icon-addon">
																			<i class="ti ti-calendar"></i>
																			</span>
															</div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label required">Warranty Expiry Date</label>
				                      <div class="input-icon mb-2">
																			<input class="form-control datepicker" name="warranty_expiry_date" placeholder="Select Warranty Expiry Date" value="<?= $assets[0]['warranty_expiry_date']?>" required>
																			<span class="input-icon-addon">
																			<i class="ti ti-calendar"></i>
																			</span>
															</div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label required">Asset ID</label>
				                      <div>
				                        <input type="text" name="asset_id" class="form-control" placeholder="Enter Asset ID" value="<?= $assets[0]['asset_id']?>" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label required">Model Name</label>
				                      <div>
				                        <input type="text" name="model_name" class="form-control" placeholder="Enter Model Name" value="<?= $assets[0]['model_name']?>" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3">
				                      <label class="form-label required">Serial No.</label>
				                      <div>
				                        <input type="text" name="serial_no" class="form-control" placeholder="Enter Serial No." value="<?= $assets[0]['serial_no']?>" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 desk_div lap_div server_div es_div hide_div">
				                      <label class="form-label required">Processor</label>
				                      <div>
				                        <input type="text" name="processor" class="form-control desk_input lap_input server_input es_input" placeholder="Enter Processor" value="<?= $assets[0]['processor']?>" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 desk_div lap_div server_div es_div hide_div">
				                      <label class="form-label required">Installed RAM</label>
				                      <div>
				                        <input type="text" name="installed_ram" class="form-control desk_input lap_input server_input es_input" placeholder="Enter Installed RAM" value="<?= $assets[0]['installed_ram']?>" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-2 mb-3 desk_div lap_div server_div hide_div">
				                      <label class="form-label required">Hard Disk</label>
				                      <div>
																	<select class="form-select desk_input lap_input server_input" name="hard_disk" required>
																		<option value="">Select</option>
																		<option value="SSD" <?php echo $assets[0]['hard_disk'] == 'SSD' ? 'selected' : '' ?>>SSD</option>
																		<option value="HDD" <?php echo $assets[0]['hard_disk'] == 'HDD' ? 'selected' : '' ?>>HDD</option>
					                        </select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-4 mb-3 desk_div lap_div server_div es_div hide_div">
				                      <label class="form-label required">Storage Capacity</label>
				                      <div>
				                      	<div class="row g-2">
			                            <div class="col-6">
			                              <select name="storage_capacity_unit desk_input lap_input server_input es_input" class="form-select">
			                                <option value="">Select</option>
			                                <option value="MB" <?php echo $assets[0]['storage_capacity_unit'] == 'MB' ? 'selected' : '' ?>>MB</option>
			                                <option value="GB" <?php echo $assets[0]['storage_capacity_unit'] == 'GB' ? 'selected' : '' ?>>GB</option>
			                                <option value="TB" <?php echo $assets[0]['storage_capacity_unit'] == 'TB' ? 'selected' : '' ?>>TB</option>
			                              </select>
			                            </div>
			                            <div class="col-6">
			                              <input type="text" name="storage_capacity" class="form-control number desk_input lap_input server_input es_input" value="<?= $assets[0]['storage_capacity']?>" placeholder="Enter Storage Capacity" required>
			                            </div>
                           			 </div>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 desk_div lap_div hide_div">
				                      <label class="form-label required">Windows Edition</label>
				                      <div>
				                        <input type="text" name="windows_edition" class="form-control desk_input lap_input" placeholder="Enter Windows Edition" value="<?= $assets[0]['windows_edition']?>" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 desk_div lap_div hide_div">
				                      <label class="form-label required">Windows Key</label>
				                      <div>
				                        <input type="text" name="windows_key" class="form-control desk_input lap_input" placeholder="Enter Windows Key" value="<?= $assets[0]['windows_key']?>" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 desk_div hide_div">
				                      <label class="form-label required">Host Name</label>
				                      <div>
				                        <input type="text" name="host_name" class="form-control desk_input" placeholder="Enter Host Name" value="<?= $assets[0]['host_name']?>" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 desk_div lap_div hide_div">
				                      <label class="form-label required">Device ID</label>
				                      <div>
				                        <input type="text" name="device_id" class="form-control desk_input lap_input" placeholder="Enter Device ID" value="<?= $assets[0]['device_id']?>" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 desk_div lap_div hide_div">
				                      <label class="form-label required">Product ID</label>
				                      <div>
				                        <input type="text" name="product_id" class="form-control desk_input lap_input" placeholder="Enter Product ID" value="<?= $assets[0]['product_id']?>" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 lap_div monitor_div tv_div hide_div">
				                      <label class="form-label required">Screen Size</label>
				                      <div>
				                        <input type="text" name="screen_size" class="form-control lap_input monitor_input tv_input" placeholder="Enter Screen Size" value="<?= $assets[0]['screen_size']?>" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 mouse_div keyboard_div hide_div">
				                      <label class="form-label required">Type</label>
				                      <div>
																<select class="form-select mouse_input keyboard_input" name="type" required>
																	<option value="">Select</option>
																	<option value="Wired" <?php echo $assets[0]['type'] == 'Wired' ? 'selected' : '' ?>>Wired</option>
																	<option value="Wireless" <?php echo $assets[0]['type'] == 'Wireless' ? 'selected' : '' ?>>Wireless</option>
				                        </select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 lap_div hide_div">
				                      <label class="form-label required">ADP Warranty</label>
				                      <div>
				                        <input type="text" name="adp_warranty" class="form-control lap_input" placeholder="Enter ADP Warranty" value="<?= $assets[0]['price']?>" required>
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
              window.location.href = '<?php echo base_url()?>/assets/list';
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
  $(document).ready(function (){
    $(".vendor_id").change(function (){  
        var vendor_id = $('.vendor_id').val();
        var data = dataType ='';
        var success = true;
        $('.invoice_no_id').find('option').not(':first').remove();
        $.ajax({
              type: "GET",
              url: "<?php echo base_url();?>/get-vendor-invoice-by-vendor/"+vendor_id,
              data: {},
              dataType:'json',
              success: function(data) 
                  {
                    $.each(data, function(index, data) 
                      {
                        if (data.id) 
                        { 
                        	$('.invoice_no_id').append('<option value="'+data.id+'">'+data.invoice_no+'('+data.currency+')'+'</option>');
                        }

                      });
                  }
              });
    });
  });
  $(document).ready(function (){
				$('.desk_div').hide();
				$('.lap_div').hide();
				$('.server_div').hide();
				$('.es_div').hide();
				$('.monitor_div').hide();
				$('.tv_div').hide();
				$('.mouse_div').hide();
				$('.keyboard_div').hide();
				$('.desk_input').prop("required", false);
				$('.lap_input').prop("required", false);
				$('.server_input').prop("required", false);
				$('.es_input').prop("required", false);
				$('.monitor_input').prop("required", false);
				$('.tv_input').prop("required", false);
				$('.mouse_input').prop("required", false);
				$('.keyboard_input').prop("required", false);
        if(category_id == 1){
		        $('.desk_div').show();
						$('.desk_input').prop("required", true);
        }
        if(category_id == 2){
		        $('.monitor_div').show();
						$('.monitor_input').prop("required", true);
        }
        if(category_id == 3){
		        $('.keyboard_div').show();
						$('.keyboard_input').prop("required", true);
        }
        if(category_id == 4){
		        $('.mouse_div').show();
						$('.mouse_input').prop("required", true);
        }
        if(category_id == 5){
		        $('.lap_div').show();
						$('.lap_input').prop("required", true);
        }
        if(category_id == 16){
		        $('.es_div').show();
						$('.es_input').prop("required", true);
        }
        if(category_id == 17){
		        $('.server_div').show();
						$('.server_input').prop("required", true);
        }
        if(category_id == 19){
		        $('.tv_div').show();
						$('.tv_input').prop("required", true);
        }
  });
</script>