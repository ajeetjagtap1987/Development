				 <!-- Page title -->
				 <div class="page-header d-print-none">
				 	<div class="container-xl">
				 		<?php echo @view('includes/breadcrumb2', ['level_1' => 'Assets List', 'level_1_url' => 'assets/list', 'level_2' => 'Asset Create']); ?>
				 	</div>
				 </div>
				 <style type="text/css">
				 	.hide_div {
				 		display: none;
				 	}
				 </style>
				 <div class="page-body">
				 	<div class="container-xl">
				 		<div class="row row-cards">
				 			<div class="col-12">
				 				<?php
									if (session()->has("error")) {
									?>
				 					<div class="alert alert-danger alert-dismissible">
				 						<?php echo session("error"); ?>
				 					</div>
				 				<?php
									}
									?>
				 				<?php
									if (session()->has("success")) {
									?>
				 					<div class="alert alert-success alert-dismissible">
				 						<?php echo session("success"); ?>
				 					</div>
				 				<?php
									}
									?>
				 				<div class="card">
				 					<div class="card-body">
				 						<form action="<?php echo base_url(); ?>/assets/insert" method="post" id="insert" autocomplete="off" class="inputbox">

				 							<div class="row">
				 								<div class="form-group col-md-6 mb-3 ">
				 									<label class="form-label required">Category</label>
				 									<div>
				 										<select type="text" class="form-select category_id" name="category_id" required value="">
				 											<option value="">Select Category</option>
				 											<?php
																if (count($category) > 0) {
																	foreach ($category as $cat) {
																		echo '<option value="' . $cat['id'] . '">' . $cat['category_name'] . '</option>';
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
																if (count($manufacturer) > 0) {
																	foreach ($manufacturer as $mf) {
																		echo '<option value="' . $mf['id'] . '">' . $mf['name'] . '</option>';
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
																if (count($vendor) > 0) {
																	foreach ($vendor as $ven) {
																		echo '<option value="' . $ven['id'] . '">' . $ven['supplier_name'] . '</option>';
																	}
																}
																?>
				 										</select>
				 									</div>
				 								</div>
				 								<div class="form-group col-md-6 mb-3 ">
				 									<label class="form-label required">Vendor Invoice</label>
				 									<div>
				 										<select class="form-select invoice_no_id" name="invoice_no_id" required id="vendor_invoice">
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
																if (count($office_location) > 0) {
																	foreach ($office_location as $ol) {
																		echo '<option value="' . $ol['id'] . '">' . $ol['name'] . '</option>';
																	}
																}
																?>
				 										</select>
				 									</div>
				 								</div>
				 								<div class="form-group col-md-6 mb-3 ">
				 									<label class="form-label required">Price with GST(per unit)</label>
				 									<div>
				 										<input type="text" name="price" class="form-control number" placeholder="Enter Price with GST" required>
				 									</div>
				 								</div>
				 								<div class="form-group col-md-6 mb-3 ">
				 									<label class="form-label required">Purchase Date</label>
				 									<div class="input-icon mb-2">
				 										<input class="form-control datepicker" name="purchase_date" id="purchase_date" placeholder="Select Purchase Date" required>
				 										<span class="input-icon-addon">
				 											<i class="ti ti-calendar"></i>
				 										</span>
				 									</div>
				 								</div>
				 								<div class="form-group col-md-6 mb-3 ">
				 									<label class="form-label required">Warranty Expiry Date</label>
				 									<div class="input-icon mb-2">
				 										<input class="form-control datepicker" name="warranty_expiry_date" id="warranty_expiry_date" placeholder="Select Warranty Expiry Date" required>
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
				 										<input type="text" name="model_name" class="form-control" placeholder="Enter Model Name">
				 									</div>
				 								</div>
				 								<div class="form-group col-md-6 mb-3 ">
				 									<label class="form-label required">Serial No.</label>
				 									<div>
				 										<input type="text" name="serial_no" class="form-control" placeholder="Enter Serial No." required>
				 									</div>
				 								</div>
				 								<div class="form-group col-md-6 mb-3 desk_div lap_div server_div es_div hide_div">
				 									<label class="form-label required">Processor</label>
				 									<div>
				 										<input type="text" name="processor" class="form-control desk_input lap_input server_input es_input" placeholder="Enter Processor" required>
				 									</div>
				 								</div>
				 								<div class="form-group col-md-3 mb-3 desk_div lap_div server_div es_div hide_div">
				 									<label class="form-label required">Installed RAM</label>
				 									<div>
				 										<input type="text" name="installed_ram" class="form-control desk_input lap_input server_input es_input" placeholder="Enter Installed RAM" required>
				 									</div>
				 								</div>

												 <div class="form-group col-md-3 mb-3 desk_div lap_div server_div es_div hide_div">
				 									<label class="form-label required">RAM Storage Capacity Unit</label>
				 									<div>
				 									
														 <select name="ram_unit" class="form-select " required>
				 													<option selected="true" disabled="disabled">Choose Storage Capacity</option>
				 													<option value="MB">MB</option>
				 													<option value="GB">GB</option>
				 													<option value="TB">TB</option>
				 												</select>
													
													</div>
				 								</div>

				 								<div class="form-group col-md-2 mb-3 desk_div lap_div server_div hide_div">
				 									<label class="form-label required">Hard Disk</label>
				 									<div>
				 										<select class="form-select desk_input lap_input server_input" name="hard_disk" required>
				 											<option value="">Select</option>
				 											<option value="SSD">SSD</option>
				 											<option value="HDD">HDD</option>
				 										</select>
				 									</div>
				 								</div>
				 								<div class="form-group col-md-4 mb-3 desk_div lap_div server_div es_div hide_div">

				 									<div>
				 										<div class="row g-2">

				 											<div class="col-6">
				 												<label class="form-label required">Storage Capacity</label>
				 												<input type="text" name="storage_capacity" class="form-control number desk_input lap_input server_input es_input" placeholder="Enter Storage Capacity" required>
				 											</div>
				 											<div class="col-6">
				 												<label class="form-label required">Storage Capacity Unit</label>
				 												<select name="storage_capacity_unit" class="form-select desk_input lap_input server_input es_input" required>
				 													<option selected="true" disabled="disabled">Choose Storage Capacity</option>
				 													<option value="MB">MB</option>
				 													<option value="GB">GB</option>
				 													<option value="TB">TB</option>
				 												</select>
				 											</div>

				 										</div>
				 									</div>
				 								</div>


				 								<div class="form-group col-md-6 mb-3 desk_div lap_div hide_div">
				 									<label class="form-label required">Windows Edition</label>
				 									<div>
				 										<input type="text" name="windows_edition" class="form-control desk_input lap_input" placeholder="Enter Windows Edition" required>
				 									</div>
				 								</div>
				 								<div class="form-group col-md-6 mb-3 desk_div lap_div hide_div">
				 									<label class="form-label required">Windows Key</label>
				 									<div>
				 										<input type="text" name="windows_key" class="form-control desk_input lap_input" placeholder="Enter Windows Key" required>
				 									</div>
				 								</div>
				 								<div class="form-group col-md-6 mb-3 desk_div hide_div">
				 									<label class="form-label required">Host Name</label>
				 									<div>
				 										<input type="text" name="host_name" class="form-control desk_input" placeholder="Enter Host Name" required>
				 									</div>
				 								</div>
											<div id="remove_require">
				 								<div class="form-group col-md-6 mb-3 desk_div lap_div hide_div">
				 									<label class="form-label required">Device ID</label>
				 									<div>
				 										<input type="text" name="device_id" class="form-control  lap_input" placeholder="Enter Device ID" required>
				 									</div>
				 								</div>
				 								<div class="form-group col-md-6 mb-3 desk_div lap_div hide_div">
				 									<label class="form-label required">Product ID</label>
				 									<div>
				 										<input type="text" name="product_id" class="form-control  lap_input" placeholder="Enter Product ID" required>
				 									</div>
				 								</div>
												 </div>

				 								<div class="form-group col-md-6 mb-3 lap_div monitor_div tv_div hide_div">
				 									<label class="form-label required">Screen Size</label>
				 									<div>
				 										<input type="text" name="screen_size" class="form-control lap_input monitor_input tv_input" placeholder="Enter Screen Size" required>
				 									</div>
				 								</div>
				 								<div class="form-group col-md-6 mb-3 mouse_div keyboard_div hide_div">
				 									<label class="form-label ">Type</label>
				 									<div>
				 										<select class="form-select mouse_input keyboard_input" name="type">
				 											<option selected="true" disabled="disabled">Choose Type</option>
				 											<option value="Wired">Wired</option>
				 											<option value="Wireless">Wireless</option>
				 										</select>
				 									</div>
				 								</div>
				 								<div class="form-group col-md-6 mb-3 lap_div hide_div">
				 									<label class="form-label required">ADP Warranty</label>
				 									<div>
				 										<input type="text" name="adp_warranty" class="form-control lap_input" placeholder="Enter ADP Warranty" required>
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
				 	$("#insert").submit(function(event) {
				 		event.preventDefault();
				 		var post_url = $(this).attr("action");
				 		var request_method = $(this).attr("method");
				 		var form_data = new FormData(this);






				 		$(".inputbox :input:visible").each(function() {
				 			var element = $(this);
				 			var name = element.attr('name');
				 			var value = element.val();

				 			// Check if the element has a 'name' attribute
				 			if (name) {
				 				// Check if the element is required or not empty
				 				if (!element.prop('required') && value.trim() === '') {
				 					// If not required and empty, add "NA" value
				 					form_data.set(name, "NA");
				 				} else {
				 					// If required or not empty, add the actual value
				 					form_data.set(name, value);
				 				}
				 			}
				 		});

				 		for (var pair of form_data.entries()) {
				 			var name = pair[0];
				 			var value = pair[1];

				 			// Check if the field already exists in the formDataObject
				 			if (form_data.hasOwnProperty(name)) {
				 				// If it exists, convert its value to an array
				 				if (!Array.isArray(form_data[name])) {
				 					form_data[name] = [form_data[name]];
				 				}
				 				form_data[name].push(value);
				 			} else {
				 				// If it doesn't exist, add it as a single value
				 				form_data[name] = value;
				 			}
				 		}




				 		$.ajax({
				 			url: "<?php echo base_url() ?>/token/",
				 			method: "GET",
				 			success: function(token) {

				 				form_data.append('csrf_test_name', token);


				 				$('.submit_button').css('display', 'none');
				 				$('.loader_button').css('display', 'block');
				 				$.ajax({
				 					url: post_url,
				 					type: request_method,
				 					data: form_data,
				 					dataType: 'json',
				 					contentType: false,
				 					cache: false,
				 					processData: false,
				 					statusCode: {
				 						403: function() {
				 							// Handle 403 error (CSRF token verification failed)
				 							Swal.fire({
				 								icon: 'error',
				 								text: 'CSRF token verification failed',
				 							});
				 							//window.location.href = '<?php echo base_url() ?>/assets/list/';
				 						}
				 					},
				 				}).done(function(response) {

				 					if (response.status == 'success') {



				 						window.location.href = '<?php echo base_url() ?>/assets/list';

				 					} else {
				 						Swal.fire({
				 							icon: response.status,
				 							text: response.message,
				 						})
				 					}
				 					$('.submit_button').css('display', 'block');
				 					$('.loader_button').css('display', 'none');

				 				});

				 			}
				 		});

				 	});
				 	$(document).ready(function() {
				 		$(".vendor_id").change(function() {
				 			var vendor_id = $('.vendor_id').val();
				 			var data = dataType = '';
				 			var success = true;
				 			$('.invoice_no_id').find('option').not(':first').remove();
				 			$.ajax({
				 				type: "GET",
				 				url: "<?php echo base_url(); ?>/get-vendor-invoice-by-vendor/" + vendor_id,
				 				data: {},
				 				dataType: 'json',
				 				success: function(data) {
				 					$.each(data, function(index, data) {
				 						if (data.id) {
				 							$('.invoice_no_id').append('<option value="' + data.id + '">' + data.invoice_no + '(' + data.currency + ')' + '</option>');
				 						}

				 					});
				 				}
				 			});
				 		});


				 		$("#vendor_invoice").change(function() {
				 			var vendor_id = $('#vendor_invoice').val();



				 			$.ajax({
				 				url: "<?php echo base_url() ?>/token/",
				 				method: "GET",
				 				success: function(token) {


				 					$.ajax({
				 						type: "POST",
				 						url: "<?php echo base_url(); ?>/assets/get_purchase_date",
				 						data: {
				 							vendor_id: vendor_id,
				 							csrf_test_name: token
				 						},
				 						dataType: 'json',
				 						success: function(data) {
				 							// console.log(data[0].invoice_date);
				 							$('#purchase_date').val(data[0].invoice_date);

				 						}
				 					});

				 				}
				 			});
				 		});





				 	});
				 	$(document).ready(function() {
				 		$(".category_id").change(function() {
				 			var category_id = $('.category_id').val();
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
				 			if (category_id == 1) {
				 				$('.desk_div').show();
				 				$('.desk_input').prop("required", true);
								 $('#remove_require label.form-label.required').removeClass('required');
				 			}
				 			if (category_id == 2) {
				 				$('.monitor_div').show();
				 				$('.monitor_input').prop("required", true);
				 			}
				 			if (category_id == 3) {
				 				$('.keyboard_div').show();
				 				$('.keyboard_input').prop("required", true);
				 			}
				 			if (category_id == 4) {
				 				$('.mouse_div').show();
				 				$('.mouse_input').prop("required", true);
				 			}
				 			if (category_id == 5) {
				 				$('.lap_div').show();
				 				$('.lap_input').prop("required", true);
				 			}
				 			if (category_id == 16) {
				 				$('.es_div').show();
				 				$('.es_input').prop("required", true);
				 			}
				 			if (category_id == 17) {
				 				$('.server_div').show();
				 				$('.server_input').prop("required", true);
				 			}
				 			if (category_id == 19) {
				 				$('.tv_div').show();
				 				$('.tv_input').prop("required", true);
				 			}




				 			// var visibleInputs = $(".inputbox :input:visible").filter(function () {
				 			//     return !$(this).prop("required");
				 			// });


				 			// visibleInputs.each(function () {
				 			//     var input = $(this);



				 			//     input.val("Your Value Here");

				 			//     var inputName = input.attr('name'); 

				 			//     console.log("Input Name: " + inputName);
				 			// });
				 		});

				 		$('#purchase_date').datepicker({
				 			format: 'dd-mm-yyyy',

				 			autoclose: true
				 		});

				 		$('#warranty_expiry_date').datepicker({
				 			format: 'dd-mm-yyyy',

				 			autoclose: true
				 		});
				 	});
				 </script>