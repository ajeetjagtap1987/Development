<div class="container-xl">
	<!-- Page title -->
	<div class="page-header d-print-none">
		<?php echo @view('includes/breadcrumb2', ['level_1' => 'User List', 'level_1_url' => 'users/list', 'level_2' => 'User Create']); ?>
	</div>
	<script>

	</script>
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
							<form action="<?php echo base_url(); ?>/users/user-register" method="post" id="insert" autocomplete="off">
								<?= csrf_field();  ?>
								<div class="form-group mb-3 ">
									<label class="form-label required">First Name</label>
									<div>
										<input type="text" name="first_name" class="form-control" placeholder="Enter First Name"><!-- 
			                        <small class="form-hint">We'll never share your email with anyone else.</small> -->
									</div>
								</div>
								<div class="form-group mb-3 ">
									<label class="form-label required">Last Name</label>
									<div>
										<input type="text" name="last_name" class="form-control" placeholder="Enter Last Name">
									</div>
								</div>
								<div class="form-group mb-3 ">
									<label class="form-label required">Email Address</label>
									<div>
										<input type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
									</div>
								</div>
								<div class="form-group  mb-3 ">
									<label class="form-label required">Job Title</label>
									<div>
										<input type="text" name="job_title" class="form-control" placeholder="Enter Job Title">
									</div>
								</div>
								<div class="form-group mb-3 ">
									<label class="form-label required">Reporting Head</label>
									<div>
										<input type="text" name="reporting_head" class="form-control" placeholder="Enter Reporting Head name">
										<!-- <select class="form-select" name="reporting_head" >
											<option value="">Select</option>
											<option value="TL">TL</option>
											<option value="Manager">Manager</option>
										</select> -->
									</div>
								</div>
								<div class="form-group mb-3 ">
									<label class="form-label">User Work Location</label>
									<div>
										<select class="form-select" name="user_work_location">
											<option value="">Select</option>
											<option value="<?php echo WORK_LOCATION_OFFICE ?>">Office</option>
											<option value="<?php echo WORK_LOCATION_HOME ?>">Home</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 ">
									<label class="form-label ">Joining Date</label>
									<div class="input-icon mb-2">
										<input class="form-control datepicker" name="joining_date" id="joining_date" placeholder="Select Joining Date">
										<span class="input-icon-addon">
											<i class="ti ti-calendar"></i>
										</span>
									</div>
								</div>
								<?php if (session('user_type') == ADMIN) { ?>
									<div class="form-group mb-3 ">
										<label class="form-label ">Select User Type</label>
										<div>
											<select class="form-select" name="user_type">
												<option value="">Select</option>
												<?php
												foreach (USER_TYPE as $key => $value) {
													if ($key != ADMIN) {
														echo '<option value="' . $key . '" >' . $value . '</option>';
													}
												}
												?>
											</select>
										</div>
									</div>
								<?php } ?>

								<div class="form-group mb-3 ">
									<label class="form-label ">Department</label>
									<div>
										<select class="form-select " name="department">
											<option value="">Select</option>

											<?php
											if (count($department) > 0) {
												foreach ($department as $d) {
													echo '<option value="' . $d['id'] . '">' . $d['name'] . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>

								<div class="form-group mb-3 ">
									<label class="form-label">Microsoft 365 Business</label>
									<div>
										<select class="form-select microsoft_365_business_licence" name="microsoft_365_business_licence">
											<option value="">Select</option>
											<option value="Microsoft 365 Business Standard">Microsoft 365 Business Standard</option>
											<option value="Microsoft 365 Business Basic">Microsoft 365 Business Basic</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-3 microsoft_365_apps_for_business_div" style="display: none;">
									<label class="form-label">Microsoft 365 Apps for business</label>
									<div>
										<div class="row g-2">
											<div class="col-12">
												<div class="input-group mb-2">
													<input type="text" name="microsoft_365_apps_for_business_username" class="form-control microsoft_365_apps_for_business_input" value="" placeholder="Username">
													<span class="input-group-text">
														@
													</span>
													<select name="microsoft_365_apps_for_business_domainname" class="form-select microsoft_365_apps_for_business_input">
														<option value="">domainname.com</option>
														<option value="digitalzone.com">digitalzone.com</option>
														<option value="digitalzonein.com">digitalzonein.com</option>
													</select>
												</div>
											</div>
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
</div>


<script type="text/javascript">
	// $(document).ready(function() {
	//     $("#type_role").on('change', function() {
	//         $(this).find("option:selected").each(function() {
	//             var type = $(this).attr("value");
	//             if (type == 6 || type == 7) {
	//                 $(".sqa").show();
	//             } else {
	//                 $(".sqa").hide();
	//             }

	//         });
	//     }).change();
	// });



	$(document).ready(function() {


		$('#joining_date').datepicker({
			format: 'dd-mm-yyyy',

			autoclose: true
		});

		$("#insert").validate({

			rules: {
				first_name: {
					required: true
				},
				last_name: {
					required: true
				},
				email: {
					required: true,
					email: true
				},
				job_title: {
					required: true
				},

				reporting_head: {
					required: true
				},

				joining_date: {
					required: true,

				},
				user_type: {
					required: true
				},
				department: {
					required: true
				},

			},
			messages: {
				first_name: {
					required: "Please enter your first name."
				},
				last_name: {
					required: "Please enter your last name."
				},
				email: {
					required: "Please enter your email address.",
					email: "Please enter a valid email address."
				},
				job_title: {
					required: "Please enter your job title."
				},
				reporting_head: {
					required: "Please select a reporting head."
				},

				joining_date: {
					required: "Please select a joining date.",

				},
				user_type: {
					required: "Please select a user type."
				},
				department: {
					required: "Please select a department."
				},

			},
			submitHandler: function(form) {

				var post_url = $(form).attr("action");
				var request_method = $(form).attr("method");
				var form_data = new FormData(form);
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
							window.location.href = '<?php echo base_url() ?>/users/list/';
						}
					},
				}).done(function(response) {
					if (response.status == 'success') {
						// Swal.fire({
						//   icon: response.status,
						//   text: response.message,
						// });
						window.location.href = '<?php echo base_url() ?>/users/list';
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


	// 	function submit_data(){


	// 	$("#insert").submit(function(event) {
	// 		event.preventDefault();


	// 	});
	// }

	$(document).ready(function() {



		$(".microsoft_365_business_licence").change(function() {
			var microsoft_365_business_licence = $('.microsoft_365_business_licence').val();
			$('.microsoft_365_apps_for_business_div').hide();
			$('.microsoft_365_apps_for_business_input').prop("required", false);

			if (microsoft_365_business_licence == 'Microsoft 365 Business Basic') {
				$('.microsoft_365_apps_for_business_div').show();
				$('.microsoft_365_apps_for_business_input').prop("required", true);
			} else {
				$('.microsoft_365_apps_for_business_div').hide();
				$('.microsoft_365_apps_for_business_input').prop("required", false);
			}
		});
	});
</script>