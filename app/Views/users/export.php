<div class="container-xl">
	<!-- Page title -->
	<div class="page-header d-print-none">
		<?php echo @view('includes/breadcrumb2', ['level_1' => 'User List', 'level_1_url' => 'users/list', 'level_2' => 'User Export']); ?>
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

						<!-- <a href="http://localhost/git_projects/it_inventory/users/details/f3ec216521cb68dbb1219867b35bbbda5fe57027b48eb62ed4d33c843b460f2620b5acd32ae538d0b167c3c1c3dd59cf3d" class="btn btn-icon btn-md btn-info p-1" title="Assign">Export All<i class="ti ti-download"></i></a>
						<br><br> -->
							<form action="<?php echo base_url(); ?>/users/export-data" method="post"  autocomplete="off">
								<?= csrf_field();  ?>


								<div class="row">


								<div class="form-group col-md-6 mb-3">
									<label class="form-label ">Department</label>
									<select name="department[]" class="form-control" multiple=""  multiple multiselect-search="true" multiselect-select-all="true">
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


