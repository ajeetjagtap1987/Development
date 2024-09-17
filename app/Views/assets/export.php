<div class="container-xl">
	<!-- Page title -->
	<div class="page-header d-print-none">
		<?php echo @view('includes/breadcrumb2', ['level_1' => 'Asset List', 'level_1_url' => 'assets/list', 'level_2' => 'Asset Export']); ?>
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
							<form action="<?php echo base_url(); ?>/assets/export-data" method="post" autocomplete="off">
								<?= csrf_field();  ?>


								<div class="row">

									<div class="form-group col-md-6 mb-3">
										<label class="form-label ">Category</label>
										<select name="category_id" class="form-control" required>
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


									<div class="form-group col-md-6 mb-3">
										<label class="form-label ">Manufacturer</label>
										<select name="manufacturer_id[]" class="form-control" multiple=""  multiple multiselect-search="true" multiselect-select-all="true">

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


								<div class="row">
									<div class="form-group col-md-6 mb-3">
										<label class="form-label ">Vendor</label>
										<select name="vendor_id[]" class="form-control" multiple=""  multiple multiselect-search="true" multiselect-select-all="true">
											<?php
											if (count($vendor) > 0) {
												foreach ($vendor as $ven) {
													echo '<option value="' . $ven['id'] . '">' . $ven['supplier_name'] . '</option>';
												}
											}
											?>
										</select>

									</div>

									<div class="col-lg-6">
							<div class="form-group">
				            <label for="inputname" class="control-label col-form-label">Created Date</label>
				            <input type="text" class="form-control daterangepicker1" id="created_at" name="created_at" >
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
	$(function() {
	    $('.daterangepicker1').daterangepicker({
	    	drops: 'up',
		    autoUpdateInput: false,
		    locale: {
		      cancelLabel: 'Clear'
		    },
		     "dateLimit": {
                "month": 1
            }
	    });
	    $('.daterangepicker1').on('apply.daterangepicker', function(ev, picker) {
	    $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
	    });
	    $('.daterangepicker1').on('cancel.daterangepicker', function(ev, picker) {
	    $(this).val('');
	    });

	    $('.show_per_page').change(function(){
	        filter_data(1);
	    });
    });
</script>