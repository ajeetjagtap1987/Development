	<!-- Page title -->
	<div class="page-header d-print-none">
		<div class="container-xl">
			<?php echo @view('includes/breadcrumb2', ['level_1' => 'Vendor List', 'level_1_url' => 'vendor/list', 'level_2' => 'Vendor Create']); ?>
		</div>
	</div>
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
						<form action="<?php echo base_url(); ?>/vendor/insert" id="insert" method="post" enctype="multipart/form-data" autocomplete="off">
							<input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
							<div class="card-header bg-light">
								<h4 class="card-title">Supplier's Details</h4>
							</div>
							<div class="card-body">
								<div class="row">

								<div class="form-group col-md-6 mb-3 ">
								<label class="form-label required">Supplier Type</label>
								<select class="form-select" name="supplier_type" >
												<option value="service_provider">Service Provider</option>
												<option value="vendor">Vendor</option>

											</select>
											</div>

									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Supplier Name</label>
										<div>
											<input type="text" name="supplier_name" class="form-control" placeholder="Enter Supplier Name">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Email ID</label>
										<div>
											<input type="email" name="business_email_address" class="form-control" placeholder="Enter Mailing / Business Address">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Plot No / Floor / Bldg Name</label>
										<div>
											<input type="text" name="plot_floor_building" class="form-control" placeholder="Enter Plot No / Floor / Bldg Name">
										</div>
									</div>
									<div class="form-group col-md-12 mb-3 ">
										<label class="form-label required">Street Address 1</label>
										<div>
											<input type="text" name="street_address_one" class="form-control" placeholder="Enter Street Address 1">
										</div>
									</div>
									<div class="form-group col-md-12 mb-3 ">
										<label class="form-label">Street Address 2</label>
										<div>
											<input type="text" name="street_address_two" class="form-control" placeholder="Enter Street Address 2">
										</div>
									</div>

									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Country</label>
										<div>
											<!-- <input type="text" name="country" class="form-control" placeholder="Enter Country" required> -->

											<select class="form-select" name="country" required="" id="country">
												<option value="">Select</option>
												<?php
												if (count($country) > 0) {
													foreach ($country as $c) {
														echo '<option value="' . $c['id'] . '">' . $c['name'] . '</option>';
													}
												}
												?>
											</select>

										</div>
									</div>

									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">State</label>
										<div>

											<select class="form-select" name="state" id="state">
												<option value="">Select</option>
												<option value="other">Other</option>

											</select>




										</div>
										<br>
										<div class="form-group col-md-6 mb-3 " id="new_state" style="display:none;">

											<div>
												<input type="text" name="new_state" class="form-control" placeholder="Enter new State">
											</div>
										</div>
									</div>



									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">City</label>
										<div>
											<input type="text" name="city" class="form-control" placeholder="Enter City">
										</div>
									</div>


									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Pin code</label>
										<div>
											<input type="text" name="pincode" class="form-control number" placeholder="Enter Pin code">
										</div>
									</div>
								</div>
							</div>
							<div class="card-header bg-light">
								<h4 class="card-title">Contact Person</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Contact Person Name</label>
										<div>
											<input type="text" name="director_contact_person_name" class="form-control" placeholder="Enter Contact Person Name">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Designation</label>
										<div>
											<input type="text" name="director_designation" class="form-control" placeholder="Enter Designation">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">Telephone No.(with STD code)</label>
										<div>
											<input type="text" name="director_telephone" class="form-control number" placeholder="Enter Telephone No.">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Mobile No.</label>
										<div>
											<input type="text" name="director_mobile" class="form-control number" placeholder="Enter Mobile No.">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Email Address</label>
										<div>
											<input type="email" name="director_email_address" class="form-control" placeholder="Enter Email Address">
										</div>
									</div>
								</div>
							</div>
							<div class="card-header bg-light">
								<h4 class="card-title">Finance</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label">Contact Person Name</label>
										<div>
											<input type="text" name="finance_contact_person_name" class="form-control" placeholder="Enter Contact Person Name">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label">Designation</label>
										<div>
											<input type="text" name="finance_designation" class="form-control" placeholder="Enter Designation">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label">Telephone No.(with STD code)</label>
										<div>
											<input type="text" name="finance_telephone" class="form-control number" placeholder="Enter Telephone No.">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label">Mobile No.</label>
										<div>
											<input type="text" name="finance_mobile" class="form-control number" placeholder="Enter Mobile No.">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label">Email Address</label>
										<div>
											<input type="email" name="finance_email_address" class="form-control" placeholder="Enter Email Address">
										</div>
									</div>
								</div>
							</div>
							<div class="card-header bg-light">
								<h4 class="card-title">Purchase</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">Contact Person Name</label>
										<div>
											<input type="text" name="purchase_contact_person_name" class="form-control" placeholder="Enter Contact Person Name">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">Designation</label>
										<div>
											<input type="text" name="purchase_designation" class="form-control" placeholder="Enter Designation">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">Telephone No.(with STD code)</label>
										<div>
											<input type="text" name="purchase_telephone" class="form-control number" placeholder="Enter Telephone No.">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">Mobile No.</label>
										<div>
											<input type="text" name="purchase_mobile" class="form-control number" placeholder="Enter Mobile No.">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">Email Address</label>
										<div>
											<input type="email" name="purchase_email_address" class="form-control" placeholder="Enter Email Address">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">Date of Commencement of Business</label>
										<div class="input-icon mb-2">
											<input class="form-control datepicker" name="business_commencement_date" id="business_commencement_date" placeholder="Select Expiry Date">
											<span class="input-icon-addon">
												<i class="ti ti-calendar"></i>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="card-header bg-light">
								<h4 class="card-title">TAX Details</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Permanent Account Number ( PAN )</label>
										<div>
											<input type="text" name="pan_number" class="form-control" placeholder="Enter Contact Person Name">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">Attached PAN Copy</label>
										<div>
											<input type="file" name="pan_copy_attachment" class="form-control" placeholder="" accept="image/*">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">TAN No.</label>
										<div>
											<input type="text" name="tan_number" class="form-control" placeholder="Enter TAN No.">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">CIN No.</label>
										<div>
											<input type="text" name="cin_number" class="form-control" placeholder="Enter CIN No.">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">IEC No.</label>
										<div>
											<input type="text" name="iec_number" class="form-control" placeholder="Enter IEC No.">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Gst Registration Number</label>
										<div>
											<input type="text" name="gst_registration_number" class="form-control" placeholder="Enter Gst Registration Number">
										</div>
									</div>
								</div>
							</div>
							<div class="card-header bg-light">
								<h4 class="card-title">Bank Details</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Account Name</label>
										<div>
											<input type="text" name="bank_account_name" class="form-control" placeholder="Enter Account Name">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Account Number</label>
										<div>
											<input type="text" name="bank_account_number" class="form-control number" placeholder="Enter Account Number">
										</div>
									</div>


									<div class="form-group col-md-6 mb-3">
										<label class="form-label required">Account Type</label>
										<div>
											<select class="form-select" name="bank_account_type">
												<option value="">Select</option>
												<option value="Saving">Saving Account</option>
												<option value="Current">Current Account</option>
											</select>
										</div>
									</div>


									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Bank Name</label>
										<div>
											<input type="text" name="bank_name" class="form-control" placeholder="Enter Bank Name">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Branch Name & Code</label>
										<div>
											<input type="text" name="bank_branch_name_and_code" class="form-control" placeholder="Enter Branch Name & Code">
										</div>
									</div>
									<div class="form-group col-md-12 mb-3 ">
										<label class="form-label ">Address (including Pin code)</label>
										<div>
											<textarea type="text" name="bank_address" class="form-control" placeholder="Address"></textarea>
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">Banks Telephone No. (with STD codes)</label>
										<div>
											<input type="text" name="bank_telephone" class="form-control number" placeholder="Enter Banks Telephone No. (with STD codes)">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">NEFT IFSC Code</label>
										<div>
											<input type="text" name="bank_neft_ifsc_code" class="form-control" placeholder="Enter NEFT IFSC Code">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">9 Digit MICR Code (appearing on cheque book)</label>
										<div>
											<input type="text" name="bank_micr_code" class="form-control" placeholder="Enter 9 Digit MICR Code (appearing on cheque book)">
										</div>
									</div>
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label ">SWIFT Code / ABA Code / SORT Code / IBAN</label>
										<div>
											<input type="text" name="bank_swift_code_aba_code_sort_code_iban" class="form-control" placeholder="Enter SWIFT Code / ABA Code / SORT Code / IBAN">
										</div>
									</div>
								</div>
							</div>
							<div class="card-header bg-light">
								<h4 class="card-title">Other Information</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="form-group col-md-6 mb-3 ">
										<label class="form-label required">Type of Organization</label>
										<div>
											<div>
												<label class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" name="organisation_type[]" value="Company">
													<span class="form-check-label">Company</span>
												</label>
												<label class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" name="organisation_type[]" value="Individual">
													<span class="form-check-label">Individual</span>
												</label>
												<label class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" name="organisation_type[]" value="Partnership">
													<span class="form-check-label">Partnership</span>
												</label>
												<label class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" name="organisation_type[]" value="Others">
													<span class="form-check-label">Others</span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="form-footer">
										<button type="submit" class="btn btn-primary submit_button">Submit</button>
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
		$("#insert").validate({

			rules: {
				supplier_name: {
					required: true
				},
				business_email_address: {
					required: true,
					email: true
				},
				plot_floor_building: {
					required: true,

				},
				street_address_one: {
					required: true
				},

				country: {
					required: true
				},

				state: {
					required: true,

				},
				city: {
					required: true
				},
				pincode: {
					required: true
				},
				director_contact_person_name: {
					required: true
				},
				director_designation: {
					required: true
				},

				director_mobile: {
					required: true,
					digits: true
				},
				director_email_address: {
					required: true,
					email: true
				},
				pan_number: {
					required: true
				},
				
				
				
				gst_registration_number: {
					required: true
				},
				bank_account_name: {
					required: true
				},
				bank_account_number: {
					required: true,
					digits: true
				},
				bank_account_type: {
					required: true
				},
				bank_name: {
					required: true,
				},
				bank_branch_name_and_code: {
					required: true
				},
				"organisation_type[]": {
					required: true
				},

			},
			messages: {
				supplier_name: {
					required: "Please enter the supplier name."
				},
				business_email_address: {
					required: "Please enter your business email address.",
					email: "Please enter a valid email address."
				},
				plot_floor_building: {
					required: "Please enter the plot/floor/building information."
				},
				street_address_one: {
					required: "Please enter the street address."
				},
				country: {
					required: "Please select a country."
				},
				state: {
					required: "Please select a state."
				},
				city: {
					required: "Please enter the city."
				},
				pincode: {
					required: "Please enter the pincode."
				},
				director_contact_person_name: {
					required: "Please enter the director/contact person name."
				},
				director_designation: {
					required: "Please enter the director's designation."
				},
				director_mobile: {
					required: "Please enter the director's mobile number."
				},
				director_email_address: {
					required: "Please enter the director's email address."
				},
				pan_number: {
					required: "Please enter the PAN number."
				},
				
				
				gst_registration_number: {
					required: "Please enter the GST registration number."
				},
				bank_account_name: {
					required: "Please enter the bank account name."
				},
				bank_account_number: {
					required: "Please enter the bank account number.",
					digits: "Please enter a valid number.",
				},
				bank_account_type: {
					required: "Please select the bank account type."
				},
				bank_name: {
					required: "Please enter the bank name."
				},
				bank_branch_name_and_code: {
					required: "Please enter the bank branch name and code."
				},
				"organisation_type[]": {
					required: "Please select at least one organisation type."
				},

			},
			errorPlacement: function(error, element) {
				// Custom error placement for checkboxes
				if (element.attr("type") === "checkbox") {
					error.insertAfter(element.closest("div"));
				} else {
					error.insertAfter(element);
				}
			},
			submitHandler: function(form) {

				var post_url = $(form).attr("action");
				var request_method = $(form).attr("method");
				var form_data = new FormData(form);


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
							processData: false
						}).done(function(response) {
							if (response.status == 'success') {
								window.location.href = '<?php echo base_url() ?>/vendor/list';
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


			}

		});




		//   $("#insert").submit(function(event) {



		//   });


	


		$(document).ready(function() {


			$("#country").change(function(event) {

				var selectElement = $('#state');
				selectElement.empty();

				var selectedCountry = $(this).val();
				$('#new_state').css('display', 'none');
				event.preventDefault();


				$.ajax({
					url: "<?php echo base_url() ?>/token/",
					method: "GET",
					success: function(token) {


						$.ajax({
							url: "<?php echo base_url('get_state'); ?>",
							method: "POST",
							data: {
								contry_id: selectedCountry,
								csrf_test_name: token
							},
							dataType: 'json',
							success: function(data) {


								if (data.length > 0) {


									$.each(data, function(index, data) {
										if (data.id) {
											$('#state').append('<option value="' + data.id + '">' + data.name + '</option>');
										}

									});


									$('#state').prepend('<option value="">Select</option>');
									$('#state').append('<option value="other">Other</option>');


								} else {
									$('#state').prepend('<option value="">Select</option>');
									$('#state').append('<option value="other">Other</option>');
								}


							}

						})

					}
				});

			});


		});


		$(document).ready(function() {
			$('#state').change(function() {
				var selectedValue = $(this).val();
				console.log(selectedValue);

				if (selectedValue == "other") {
					$('#new_state').show();
				} else {
					$('#new_state').css('display', 'none');
				}
			});
		});
	</script>