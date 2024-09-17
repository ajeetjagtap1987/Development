<?php
use App\Models\CommonModel;

$CommonModel = new CommonModel();
$encrypter = \Config\Services::encrypter();
$e_id = $license[0]['id'];
$e_id = $license[0]['id'];
$product_key = $license[0]['product_key'];

// $licenseName = $license[0]['license_name_id'];
// print_r($product_key);
// die;
?>
<!-- Page title -->
<div class="page-header d-print-none">
	<div class="container-xl">
		<div class="row g-2 align-items-center">
			<div class="col">

			</div>
			<div class="col-12 col-md-auto ms-auto d-print-none">
				<div class="d-flex">
					<ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
						<li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url() . '/licenses/list' ?>">License
								List</a>
						</li>
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
				<div class="card mb-2">
					<div class="card-header bg-primary text-white" style="padding: 0.5rem 1.2rem;">
						<h3 class="card-title">Licenses Details</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<table class="table table-bordered table-striped table-responsive table-sm">
								<tbody>
									<tr>
										<th scope="row" width="180px">Licenses Name</th>
										<td>
											<?php
											echo $license_name;

											?>

										</td>
									</tr>

									<tr>
										<th scope="row" width="180px">Product Key</th>
										<td>
											<?php
											echo $product_key;
											?>
										</td>
									</tr>



									<tr>
										<th scope="row" width="180px">License_to_email</th>
										<td>
											<?php
											echo $license_to_email = $license[0]['license_to_email'];

											?>
										</td>
									</tr>

									<tr>
										<th scope="row" width="180px">Manufacturer</th>
										<td>
											<?php
											if (count($manufacturer) > 0) {
												echo $manufacturer[0]['name'];
											}
											?>
										</td>
									</tr>

									<tr>
										<th scope="row" width="180px">Start Date</th>
										<td>
											<?php
											echo $start_date = $license[0]['start_date'];
											?>
										</td>
									</tr>

									<tr>
										<th scope="row" width="180px">End Date</th>
										<td>
											<?php
											echo $expiry_date = $license[0]['expiry_date'];
											?>
										</td>
									</tr>

									<tr>
										<th scope="row" width="180px">Price</th>
										<td>
											<?php
											echo $price = $license[0]['price'];
											?>
										</td>
									</tr>
									<tr>
										<th scope="row" width="180px">User limit</th>
										<td>
											<?php
											echo $price = $license[0]['user_limit'];
											?>
										</td>
									</tr>


								</tbody>
							</table>
						</div>
					</div>
				</div>

				<!-- Licenses Assigned List -->
				<div class="card mb-2">
					<div class="card-header bg-primary text-white" style="padding: 0.5rem 1.2rem;">
						<h3 class="card-title">Licenses Assigned User List</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<?php
							$user_asset_data = $CommonModel->getUserLicenseByLicenseId($e_id);
							// print_r($user_asset_data1);
							// die;
							$asset_info = '';
							if (count($user_asset_data) > 0) {
								$asset_info .= '<table class="table table-bordered table-striped table-responsive table-sm">
										                  <tbody>';
								$asset_info .= '<tr>
										                                    <th>Name</th>
										                                    <th>Email</th>
										                                    <th>Job Title</th>
										                                    <th>Reporting Head</th>
										                                  </tr>';
								foreach ($user_asset_data as $uad) {
									$user_data = $CommonModel->getDataById($table_name = 'user', $uad['user_id']);
									if (count($user_data) > 0) {
										$u_id = bin2hex($encrypter->encrypt($user_data[0]['id']));
										$asset_info .= '<tr>
										                                    <td><a href="' . base_url() . '/users/details/' . $u_id . '" title="Detail" target="_blank">' . $user_data[0]['first_name'] . ' ' . $user_data[0]['last_name'] . '</a></td>
										                                    <td>' . $user_data[0]['email'] . '</td>
										                                    <td>' . $user_data[0]['job_title'] . '</td>
										                                    <td>' . $user_data[0]['reporting_head'] . '</td>
										                                  </tr>';
									}
								}

								$asset_info .= '</tbody>
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
	$(document).ready(function () {
		$('.desk_div').hide();
		$('.lap_div').hide();
		$('.server_div').hide();
		$('.es_div').hide();
		$('.monitor_div').hide();
		$('.tv_div').hide();
		$('.mouse_div').hide();
		$('.keyboard_div').hide();
		var category_id = $('#category_id').val();
		if (category_id == 1) {
			$('.desk_div').show();
		}
		if (category_id == 2) {
			$('.monitor_div').show();
		}
		if (category_id == 3) {
			$('.keyboard_div').show();
		}
		if (category_id == 4) {
			$('.mouse_div').show();
		}
		if (category_id == 5) {
			$('.lap_div').show();
		}
		if (category_id == 16) {
			$('.es_div').show();
		}
		if (category_id == 17) {
			$('.server_div').show();
		}
		if (category_id == 19) {
			$('.tv_div').show();
		}
	});
</script>