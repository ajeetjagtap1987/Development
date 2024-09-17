				 <!-- Page title -->
        <div class="page-header d-print-none">
        	<div class="container-xl">
          <?php echo @view('includes/breadcrumb2', ['level_1' => 'Assets List', 'level_1_url' => 'assets/list', 'level_2' => 'Asset Create']); ?>
        	</div>
        </div>
        <style type="text/css">
        	.hide_div{
        		display: none;
        	}
        </style>
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
			                	<form action="<?php echo base_url();?>/assets/insert" method="post" id="insert" autocomplete="off">
				                	<div class="row">	
				                    <div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label required">Category</label>
				                      <div>
				                      		<select type="text" class="form-select category_id" name="category_id" required value="">
				                      			<option value="">Select Category</option>
														      	<?php 
																				if(count($category)>0){
																					foreach( $category as $cat ){
																						echo '<option value="'.$cat['id'].'">'.$cat['category_name'].'</option>';
																				  }
																				}
														      	?>
																	</select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label required">Manufacturer</label>
				                      <div>
				                      		<select type="text" class="form-select" name="manufacturer_id" required value="">
				                      			<option value="">Select Manufacturer</option>
														      	<?php 
																				if(count($manufacturer)>0){
																					foreach( $manufacturer as $mf ){
																						echo '<option value="'.$mf['id'].'">'.$mf['name'].'</option>';
																				  }
																				}
														      	?>
																	</select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label required">Vendor</label>
				                      <div>
				                      		<select type="text" class="form-select vendor_id" name="vendor_id" required value="">
				                      			<option value="">Select Vendor</option>
														      	<?php 
																				if(count($vendor)>0){
																					foreach( $vendor as $ven ){
																						echo '<option value="'.$ven['id'].'">'.$ven['supplier_name'].'</option>';
																				  }
																				}
														      	?>
																	</select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label required">Vendor Invoice</label>
				                      <div>
																	<select class="form-select invoice_no_id" name="invoice_no_id" required>
																		<option value="">Select</option>
					                        </select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label required">Office Location</label>
				                      <div>
				                      		<select type="text" class="form-select" name="asset_location_id" required value="">
				                      			<option value="">Select Office Location</option>
														      	<?php 
																				if(count($office_location)>0){
																					foreach( $office_location as $ol ){
																						echo '<option value="'.$ol['id'].'">'.$ol['name'].'</option>';
																				  }
																				}
														      	?>
																	</select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label required">Price</label>
				                      <div>
				                        <input type="text" name="price" class="form-control number" placeholder="Enter Price" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label required">Purchase Date</label>
				                      <div class="input-icon mb-2">
																			<input class="form-control datepicker" name="purchase_date" placeholder="Select Purchase Date" required>
																			<span class="input-icon-addon">
																			<i class="ti ti-calendar"></i>
																			</span>
															</div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label required">Warranty Expiry Date</label>
				                      <div class="input-icon mb-2">
																			<input class="form-control datepicker" name="warranty_expiry_date" placeholder="Select Warranty Expiry Date" required>
																			<span class="input-icon-addon">
																			<i class="ti ti-calendar"></i>
																			</span>
															</div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label required">Asset ID</label>
				                      <div>
				                        <input type="text" name="asset_id" class="form-control" placeholder="Enter Asset ID" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label required">Model Name</label>
				                      <div>
				                        <input type="text" name="model_name" class="form-control" placeholder="Enter Model Name" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label required">Serial No.</label>
				                      <div>
				                        <input type="text" name="serial_no" class="form-control" placeholder="Enter Serial No." required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 processor_div hide_div">
				                      <label class="form-label required">Processor</label>
				                      <div>
				                        <input type="text" name="processor" class="form-control processor_input" placeholder="Enter Processor" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 installed_ram_div hide_div">
				                      <label class="form-label required">Installed RAM</label>
				                      <div>
				                        <input type="text" name="installed_ram" class="form-control installed_ram_input" placeholder="Enter Installed RAM" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-2 mb-3 hard_disk_div hide_div">
				                      <label class="form-label required">Hard Disk</label>
				                      <div>
																	<select class="form-select hard_disk_input" name="hard_disk" required>
																		<option value="">Select</option>
																		<option value="SSD">SSD</option>
																		<option value="HDD">HDD</option>
					                        </select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-4 mb-3 storage_capacity_unit_div hide_div">
				                      <label class="form-label required">Storage Capacity</label>
				                      <div>
				                      	<div class="row g-2">
			                            <div class="col-6">
			                              <select name="storage_capacity_unit storage_capacity_unit_input" class="form-select">
			                                <option value="">Select</option>
			                                <option value="MB">MB</option>
			                                <option value="GB">GB</option>
			                                <option value="TB">TB</option>
			                              </select>
			                            </div>
			                            <div class="col-6">
			                              <input type="text" name="storage_capacity" class="form-control number storage_capacity_unit_input" placeholder="Enter Storage Capacity" required>
			                            </div>
                           			 </div>
				                      </div>
				                    </div>

        		
				                    <div class="form-group col-md-6 mb-3 windows_edition_div hide_div">
				                      <label class="form-label required">Windows Edition</label>
				                      <div>
				                        <input type="text" name="windows_edition" class="form-control windows_edition_input" placeholder="Enter Windows Edition" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 device_id_div hide_div">
				                      <label class="form-label required">Device ID</label>
				                      <div>
				                        <input type="text" name="device_id" class="form-control device_id_input" placeholder="Enter Device ID" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 product_id_div hide_div">
				                      <label class="form-label required">Product ID</label>
				                      <div>
				                        <input type="text" name="product_id" class="form-control product_id_input" placeholder="Enter Product ID" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 screen_size_div hide_div">
				                      <label class="form-label required">Screen Size</label>
				                      <div>
				                        <input type="text" name="screen_size" class="form-control screen_size_input" placeholder="Enter Screen Size" required>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 type_div hide_div">
				                      <label class="form-label required">Type</label>
				                      <div>
																<select class="form-select type_input" name="type" required>
																	<option value="">Select</option>
																	<option value="Wired">Wired</option>
																	<option value="Wireless">Wireless</option>
				                        </select>
				                      </div>
				                    </div>
				                    <div class="form-group col-md-6 mb-3 adp_warranty_div hide_div">
				                      <label class="form-label required">ADP Warranty</label>
				                      <div>
				                        <input type="text" name="adp_warranty" class="form-control adp_warranty_input" placeholder="Enter ADP Warranty" required>
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
                        	$('.invoice_no_id').append('<option value="'+data.id+'">'+data.invoice_no+'</option>');
                        }

                      });
                  }
              });
    });
  });
  $(document).ready(function (){
    $(".category_id").change(function (){ 
        var category_id = $('.category_id').val();
				$('.processor_div').hide();
				$('.installed_ram_div').hide();
				$('.hard_disk_div').hide();
				$('.storage_capacity_unit_div').hide();
				$('.windows_edition_div').hide();
				$('.device_id_div').hide();
				$('.product_id_div').hide();
				$('.screen_size_div').hide();
				$('.type_div').hide();
				$('.adp_warranty_div').hide();
				$('.processor_input').prop("required", false);
				$('.installed_ram_input').prop("required", false);
				$('.hard_disk_input').prop("required", false);
				$('.storage_capacity_unit_input').prop("required", false);
				$('.windows_edition_input').prop("required", false);
				$('.device_id_input').prop("required", false);
				$('.product_id_input').prop("required", false);
				$('.screen_size_input').prop("required", false);
				$('.type_input').prop("required", false);
				$('.adp_warranty_input').prop("required", false);
        if(category_id ==1 ){
		        $('.processor_div').show();
						$('.installed_ram_div').show();
						$('.hard_disk_div').show();
						$('.storage_capacity_unit_div').show();
						$('.windows_edition_div').show();
						$('.device_id_div').show();
						$('.product_id_div').show();
						$('.processor_input').prop("required", true);
						$('.installed_ram_input').prop("required", true);
						$('.hard_disk_input').prop("required", true);
						$('.storage_capacity_unit_input').prop("required", true);
						$('.windows_edition_input').prop("required", true);
						$('.device_id_input').prop("required", true);
						$('.product_id_input').prop("required", true);
        }
    });
  });
  
</script>