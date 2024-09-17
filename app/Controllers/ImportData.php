<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AssetsModel;
use App\Models\CommonModel;
use App\Models\CategoryModel;


class ImportData extends Controller
{

	function __construct()
	{
		$user_id = session('user_id');
		if (!$user_id) {
			header('Location: ' . base_url() . '/login');
			exit;
		}
		if (!in_array(ACCESS_ASSETS, session('user_access'))) {
			header('Location: ' . base_url());
			exit;
		}
	}
	public function index()
	{
		if (!is_file(APPPATH . 'Views/import/index.php')) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		$CommonModel = new CommonModel();
		$data['category'] =  $CommonModel->getSelectiveData($table_name = 'category', $column_name = 'id,category_name');

		return view('includes/header') . view('import/index', $data) . view('includes/footer');
	}

	public function importAssetFile()
	{


		ini_set('max_execution_time', 5096);
		ini_set('memory_limit', '5096M');
		$CommonModel = new CommonModel();
		if (!empty($_FILES['asset_file']['name'])) {

			$asset_file = $CommonModel->parseCsv($_FILES['asset_file']['tmp_name']);


			$parsecsvcheckutf = $CommonModel->parseCsvCheckUtf($_FILES['asset_file']['tmp_name']);
			$checkCsvUtf = $CommonModel->checkCsvUtf($parsecsvcheckutf[0]);
			if ($checkCsvUtf) {
				session()->setFlashdata("error", "Uploaded file format is not match. Please upload a CSV file in UTF-8 format.");
				return redirect()->to(base_url() . '/import');
				die;
			}



			if ($_POST['category_id'] == 1) {

				$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'price', 'processor', 'installed_ram', 'ram_unit', 'host_name', 'hard_disk', 'storage_capacity', 'storage_capacity_unit', 'windows_edition', 'windows_key', 'device_id', 'product_id');
			} elseif ($_POST['category_id'] == 2 || $_POST['category_id'] == 19) {
				$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name',  'screen_size');
			} elseif ($_POST['category_id'] == 3 || $_POST['category_id'] == 4) {
				$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'type');
			} elseif ($_POST['category_id'] == 5) {
				$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'price', 'processor', 'installed_ram', 'ram_unit', 'hard_disk', 'storage_capacity', 'storage_capacity_unit', 'windows_edition', 'windows_key', 'device_id', 'product_id', 'screen_size', 'adp_warranty');
			} elseif ($_POST['category_id'] == 6 || $_POST['category_id'] == 7 || $_POST['category_id'] == 8 || $_POST['category_id'] == 9 || $_POST['category_id'] == 10 || $_POST['category_id'] == 11 || $_POST['category_id'] == 12 || $_POST['category_id'] == 13 || $_POST['category_id'] == 14 || $_POST['category_id'] == 15 || $_POST['category_id'] == 18 || $_POST['category_id'] == 20 || $_POST['category_id'] == 21 || $_POST['category_id'] == 25 || $_POST['category_id'] == 26) {
				$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name');
			} elseif ($_POST['category_id'] == 16) {
				$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'processor', 'installed_ram', 'ram_unit',  'storage_capacity', 'storage_capacity_unit',);
			} elseif ($_POST['category_id'] == 17) {
				$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'processor', 'installed_ram', 'ram_unit', 'hard_disk', 'storage_capacity', 'storage_capacity_unit',);
			} else {
				$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'price', 'processor', 'installed_ram', 'ram_unit', 'host_name', 'hard_disk', 'storage_capacity', 'storage_capacity_unit', 'windows_edition', 'windows_key', 'device_id', 'product_id', 'screen_size', 'type', 'adp_warranty');
			}


			if (!empty($asset_file[0])) {

				$csv_header = preg_replace("/[^(\x20-\x7F)]*/", "", array_keys($asset_file[0]));

				if (array_diff($asset_file_headers_default, $csv_header)) {
					$diff_column = count(array_diff($asset_file_headers_default, $csv_header)) > 0 ? implode(', ', array_diff($asset_file_headers_default, $csv_header)) : '';
					$error_column_match = 'File Column and Required Column does not match. The different columns are ' . $diff_column;
					session()->setFlashdata("error", $error_column_match);
					return redirect()->to(base_url() . '/import');
					die;
				}

				$if_error = '';
				$array_row = [];
				$error_file_data = [];
				$error_file_row = [];
				$inserted_row=[];
				foreach ($asset_file as $asset_value) {
					$error_file_data = [];

					if ($asset_value['category']) {
						$checkcategory =  $CommonModel->getAllDataByColumnName($table_name = 'category', $column_name = 'category_name', $value = $asset_value['category']);
						if (count($checkcategory) > 0) {
							$category_id = $checkcategory[0]['id'];
						} else {
							$category_id = '';
							$error_file_data[] = 'Category not match';
						}
					} else {
						$category_id = '';
						$error_file_data[] = 'Category not match';
					}
					if ($asset_value['vendor']) {
						$checkvendor =  $CommonModel->getAllDataByColumnName($table_name = 'vendor', $column_name = 'supplier_name', $value = $asset_value['vendor']);
						if (count($checkvendor) > 0) {
							$vendor_id = $checkvendor[0]['id'];
							if ($asset_value['invoice_no']) {
								$checkinvoice_no =  $CommonModel->checkVendorInvoiceByVendor($checkvendor[0]['id'], $asset_value['invoice_no']);
								if (count($checkinvoice_no) > 0) {
									$invoice_no_id = $checkinvoice_no[0]['id'];
								} else {
									$invoice_no_id = '';
									$error_file_data[] = 'Invoice no. not match';
								}
							} else {
								$invoice_no_id = '';
								$error_file_data[] = 'Invoice no. not match';
							}
						} else {
							$vendor_id = '';
							$error_file_data[] = 'Vendor not match';
						}
					} else {
						$vendor_id = '';
						$error_file_data[] = 'Vendor not match';
					}
					if ($asset_value['manufacturer']) {
						$checkmanufacturer =  $CommonModel->getAllDataByColumnName($table_name = 'manufacturer', $column_name = 'name', $value = $asset_value['manufacturer']);
						if (count($checkmanufacturer) > 0) {
							$manufacturer_id = $checkmanufacturer[0]['id'];
						} else {
							$manufacturer_id = '';
							$error_file_data[] = 'Manufacturer not match';
						}
					} else {
						$manufacturer_id = '';
						$error_file_data[] = 'Manufacturer not match';
					}
					if ($asset_value['asset_id']) {
						$checkasset_id =  $CommonModel->getAllDataByColumnName($table_name = 'assets', $column_name = 'asset_id', $value = $asset_value['asset_id']);
						if (count($checkasset_id) > 0) {
							$error_file_data[] = 'Assets Id already exits';
						}
					} else {
						$error_file_data[] = 'Assets Id is blank';
					}
					if ($asset_value['asset_location']) {
						$checkasset_location =  $CommonModel->getAllDataByColumnName($table_name = 'office_location', $column_name = 'name', $value = $asset_value['asset_location']);
						if (count($checkasset_location) > 0) {
							$asset_location_id = $checkasset_location[0]['id'];
						} else {
							$asset_location_id = '';
							$error_file_data[] = 'Asset Location not match';
						}
					} else {
						$asset_location_id = '';
						$error_file_data[] = 'Asset Location not match';
					}
					$asset_value['error'] = '';
					if (!empty($error_file_data)) {
						$asset_value['error'] = implode(' | ', $error_file_data);
						$error_file_row[] = $asset_value;
					} else {

						$data = array(
							'category_id' => $category_id,
							'vendor_id' => $vendor_id,
							'invoice_no_id' => $invoice_no_id,
							'purchase_date' => isset($asset_value['purchase_date']) ? date('Y-m-d', strtotime($asset_value['purchase_date'])) : '',
							'asset_id' => isset($asset_value['asset_id']) ? trim($asset_value['asset_id']) : '',
							'manufacturer_id' => $manufacturer_id,
							'serial_no' => isset($asset_value['serial_no']) ? trim($asset_value['serial_no']) : '',
							'warranty_expiry_date' => isset($asset_value['warranty_expiry_date']) ? date('Y-m-d', strtotime($asset_value['warranty_expiry_date'])) : '',
							'asset_location_id' => $asset_location_id,
							'model_name' => isset($asset_value['model_name']) ? trim($asset_value['model_name']) : '',
							'price' => isset($asset_value['price']) ? trim($asset_value['price']) : '',
							'processor' => isset($asset_value['processor']) ? trim($asset_value['processor']) : '',
							'installed_ram' => isset($asset_value['installed_ram']) ? trim($asset_value['installed_ram']) : '',
							'ram_unit' => isset($asset_value['ram_unit']) ? trim($asset_value['ram_unit']) : '',
							'host_name' => isset($asset_value['host_name']) ? trim($asset_value['host_name']) : '',
							'hard_disk' => isset($asset_value['hard_disk']) ? trim($asset_value['hard_disk']) : '',
							'storage_capacity' => isset($asset_value['storage_capacity']) ? trim($asset_value['storage_capacity']) : '',
							'storage_capacity_unit' => isset($asset_value['storage_capacity_unit']) ? trim($asset_value['storage_capacity_unit']) : '',
							'windows_edition' => isset($asset_value['windows_edition']) ? trim($asset_value['windows_edition']) : '',
							'windows_key' => isset($asset_value['windows_key']) ? trim($asset_value['windows_key']) : '',
							'device_id' => isset($asset_value['device_id']) ? trim($asset_value['device_id']) : '',
							'product_id' => isset($asset_value['product_id']) ? trim($asset_value['product_id']) : '',
							'screen_size' => isset($asset_value['screen_size']) ? trim($asset_value['screen_size']) : '',
							'type' => isset($asset_value['type']) ? trim($asset_value['type']) : '',
							'adp_warranty' => isset($asset_value['adp_warranty']) ? trim($asset_value['adp_warranty']) : '',
							'status' => ASSET_BUFFER,
						);


						if ($category_id == 1) {
							$data['purchase_date'] = empty($data['purchase_date']) ? 'NA' : $data['purchase_date'];
							$data['asset_id'] = empty($data['asset_id']) ? 'NA' : $data['asset_id'];
							$data['serial_no'] = empty($data['serial_no']) ? 'NA' : $data['serial_no'];
							$data['warranty_expiry_date'] = empty($data['warranty_expiry_date']) ? 'NA' : $data['warranty_expiry_date'];
							$data['model_name'] = empty($data['model_name']) ? 'NA' : $data['model_name'];
							$data['price'] = empty($data['price']) ? 'NA' : $data['price'];
							$data['processor'] = empty($data['processor']) ? 'NA' : $data['processor'];
							$data['installed_ram'] = empty($data['installed_ram']) ? 'NA' : $data['installed_ram'];
							$data['ram_unit'] = empty($data['ram_unit']) ? 'NA' : $data['ram_unit'];
							$data['host_name'] = empty($data['host_name']) ? 'NA' : $data['host_name'];
							$data['hard_disk'] = empty($data['hard_disk']) ? 'NA' : $data['hard_disk'];
							$data['storage_capacity'] = empty($data['storage_capacity']) ? 'NA' : $data['storage_capacity'];
							$data['storage_capacity_unit'] = empty($data['storage_capacity_unit']) ? 'NA' : $data['storage_capacity_unit'];
							$data['windows_edition'] = empty($data['windows_edition']) ? 'NA' : $data['windows_edition'];
							$data['windows_key'] = empty($data['windows_key']) ? 'NA' : $data['windows_key'];
							$data['device_id'] = empty($data['device_id']) ? 'NA' : $data['device_id'];
							$data['product_id'] = empty($data['product_id']) ? 'NA' : $data['product_id'];
						} elseif ($category_id == 2 || $category_id == 19) {

							$data['purchase_date'] = empty($data['purchase_date']) ? 'NA' : $data['purchase_date'];
							$data['asset_id'] = empty($data['asset_id']) ? 'NA' : $data['asset_id'];
							$data['serial_no'] = empty($data['serial_no']) ? 'NA' : $data['serial_no'];
							$data['warranty_expiry_date'] = empty($data['warranty_expiry_date']) ? 'NA' : $data['warranty_expiry_date'];
							$data['model_name'] = empty($data['model_name']) ? 'NA' : $data['model_name'];
							$data['price'] = empty($data['price']) ? 'NA' : $data['price'];
							$data['screen_size'] = empty($data['screen_size']) ? 'NA' : $data['screen_size'];
						} elseif ($category_id == 3 || $category_id == 4) {

							$data['purchase_date'] = empty($data['purchase_date']) ? 'NA' : $data['purchase_date'];
							$data['asset_id'] = empty($data['asset_id']) ? 'NA' : $data['asset_id'];
							$data['serial_no'] = empty($data['serial_no']) ? 'NA' : $data['serial_no'];
							$data['warranty_expiry_date'] = empty($data['warranty_expiry_date']) ? 'NA' : $data['warranty_expiry_date'];
							$data['model_name'] = empty($data['model_name']) ? 'NA' : $data['model_name'];
							$data['price'] = empty($data['price']) ? 'NA' : $data['price'];
							$data['screen_size'] = empty($data['screen_size']) ? 'NA' : $data['screen_size'];
						} elseif ($category_id == 5) {

							$data['purchase_date'] = empty($data['purchase_date']) ? 'NA' : $data['purchase_date'];

							$data['asset_id'] = empty($data['asset_id']) ? 'NA' : $data['asset_id'];
							$data['serial_no'] = empty($data['serial_no']) ? 'NA' : $data['serial_no'];
							$data['warranty_expiry_date'] = empty($data['warranty_expiry_date']) ? 'NA' : $data['warranty_expiry_date'];
							$data['model_name'] = empty($data['model_name']) ? 'NA' : $data['model_name'];
							$data['price'] = empty($data['price']) ? 'NA' : $data['price'];
							$data['processor'] = empty($data['processor']) ? 'NA' : $data['processor'];
							$data['installed_ram'] = empty($data['installed_ram']) ? 'NA' : $data['installed_ram'];
							$data['ram_unit'] = empty($data['ram_unit']) ? 'NA' : $data['ram_unit'];
							$data['hard_disk'] = empty($data['hard_disk']) ? 'NA' : $data['hard_disk'];
							$data['storage_capacity'] = empty($data['storage_capacity']) ? 'NA' : $data['storage_capacity'];

							$data['storage_capacity_unit'] = empty($data['storage_capacity_unit']) ? 'NA' : $data['storage_capacity_unit'];
							$data['windows_edition'] = empty($data['windows_edition']) ? 'NA' : $data['windows_edition'];
							$data['windows_key'] = empty($data['windows_key']) ? 'NA' : $data['windows_key'];
							$data['device_id'] = empty($data['device_id']) ? 'NA' : $data['device_id'];
							$data['product_id'] = empty($data['product_id']) ? 'NA' : $data['product_id'];
							$data['screen_size'] = empty($data['screen_size']) ? 'NA' : $data['screen_size'];
							$data['adp_warranty'] = empty($data['adp_warranty']) ? 'NA' : $data['adp_warranty'];
						} elseif ($category_id == 6 || $category_id == 7 || $category_id == 8 || $category_id == 9 || $category_id == 10 || $category_id == 11 || $category_id == 12 || $category_id == 13 || $category_id == 14 || $category_id == 15 || $category_id == 18 || $category_id == 20 || $category_id == 21 || $category_id == 25 || $category_id == 26) {

							$data['purchase_date'] = empty($data['purchase_date']) ? 'NA' : $data['purchase_date'];

							$data['asset_id'] = empty($data['asset_id']) ? 'NA' : $data['asset_id'];
							$data['serial_no'] = empty($data['serial_no']) ? 'NA' : $data['serial_no'];
							$data['warranty_expiry_date'] = empty($data['warranty_expiry_date']) ? 'NA' : $data['warranty_expiry_date'];
							$data['model_name'] = empty($data['model_name']) ? 'NA' : $data['model_name'];
							$data['price'] = empty($data['price']) ? 'NA' : $data['price'];
						} elseif ($category_id == 16) {

							$data['purchase_date'] = empty($data['purchase_date']) ? 'NA' : $data['purchase_date'];
							$data['asset_id'] = empty($data['asset_id']) ? 'NA' : $data['asset_id'];
							$data['serial_no'] = empty($data['serial_no']) ? 'NA' : $data['serial_no'];
							$data['warranty_expiry_date'] = empty($data['warranty_expiry_date']) ? 'NA' : $data['warranty_expiry_date'];
							$data['model_name'] = empty($data['model_name']) ? 'NA' : $data['model_name'];
							$data['price'] = empty($data['price']) ? 'NA' : $data['price'];
							$data['processor'] = empty($data['processor']) ? 'NA' : $data['processor'];
							$data['installed_ram'] = empty($data['installed_ram']) ? 'NA' : $data['installed_ram'];
							$data['ram_unit'] = empty($data['ram_unit']) ? 'NA' : $data['ram_unit'];
							$data['storage_capacity'] = empty($data['storage_capacity']) ? 'NA' : $data['storage_capacity'];
							$data['storage_capacity_unit'] = empty($data['storage_capacity_unit']) ? 'NA' : $data['storage_capacity_unit'];
						} elseif ($category_id == 17) {

							$data['purchase_date'] = empty($data['purchase_date']) ? 'NA' : $data['purchase_date'];
							$data['asset_id'] = empty($data['asset_id']) ? 'NA' : $data['asset_id'];
							$data['serial_no'] = empty($data['serial_no']) ? 'NA' : $data['serial_no'];
							$data['warranty_expiry_date'] = empty($data['warranty_expiry_date']) ? 'NA' : $data['warranty_expiry_date'];
							$data['model_name'] = empty($data['model_name']) ? 'NA' : $data['model_name'];
							$data['price'] = empty($data['price']) ? 'NA' : $data['price'];
							$data['processor'] = empty($data['processor']) ? 'NA' : $data['processor'];
							$data['installed_ram'] = empty($data['installed_ram']) ? 'NA' : $data['installed_ram'];
							$data['ram_unit'] = empty($data['ram_unit']) ? 'NA' : $data['ram_unit'];
							$data['hard_disk'] = empty($data['hard_disk']) ? 'NA' : $data['hard_disk'];
							$data['storage_capacity'] = empty($data['storage_capacity']) ? 'NA' : $data['storage_capacity'];
							$data['storage_capacity_unit'] = empty($data['storage_capacity_unit']) ? 'NA' : $data['storage_capacity_unit'];
						} else {
							session()->setFlashdata("unsuccess", "Please Check Selected Category .");
							return redirect()->to(base_url() . '/import');
						}




						// if($category_id==2){
						// 	$data = array(
						// 		'category_id' => $category_id,
						// 		'vendor_id' => $vendor_id,
						// 		'invoice_no_id' => $invoice_no_id,
						// 		'purchase_date' => isset($asset_value['purchase_date']) ? date('Y-m-d',strtotime($asset_value['purchase_date'])) : 'NA',
						// 		'asset_id' => isset($asset_value['asset_id']) ? trim($asset_value['asset_id']) : '',
						// 		'manufacturer_id' => $manufacturer_id,
						// 		'serial_no' => isset($asset_value['serial_no']) ? trim($asset_value['serial_no']) : 'NA',
						// 		'warranty_expiry_date' => isset($asset_value['warranty_expiry_date']) ? date('Y-m-d',strtotime($asset_value['warranty_expiry_date'])) : 'NA',
						// 		'asset_location_id' => $asset_location_id,
						// 		'model_name' => isset($asset_value['model_name']) ? trim($asset_value['model_name']) : 'NA',
						// 		'price' => isset($asset_value['price']) ? trim($asset_value['price']) : 'NA',
						// 		'processor' => isset($asset_value['processor']) ? trim($asset_value['processor']) : '',
						// 		'installed_ram' => isset($asset_value['installed_ram']) ? trim($asset_value['installed_ram']) : '',
						// 		'ram_unit' => isset($asset_value['ram_unit']) ? trim($asset_value['ram_unit']) : '',
						// 		'host_name' => isset($asset_value['host_name']) ? trim($asset_value['host_name']) : '',
						// 		'hard_disk' => isset($asset_value['hard_disk']) ? trim($asset_value['hard_disk']) : '',
						// 		'storage_capacity' => isset($asset_value['storage_capacity']) ? trim($asset_value['storage_capacity']) : '',
						// 		'storage_capacity_unit' => isset($asset_value['storage_capacity_unit']) ? trim($asset_value['storage_capacity_unit']) : '',
						// 		'windows_edition' => isset($asset_value['windows_edition']) ? trim($asset_value['windows_edition']) : '',
						// 		'windows_key' => isset($asset_value['windows_key']) ? trim($asset_value['windows_key']) : '',
						// 		'device_id' => isset($asset_value['device_id']) ? trim($asset_value['device_id']) : '',
						// 		'product_id' => isset($asset_value['product_id']) ? trim($asset_value['product_id']) : '',
						// 		'screen_size' => isset($asset_value['screen_size']) ? trim($asset_value['screen_size']) : '',
						// 		'type' => isset($asset_value['type']) ? trim($asset_value['type']) : '',
						// 		'adp_warranty' => isset($asset_value['adp_warranty']) ? trim($asset_value['adp_warranty']) : '',
						// 		'status' => ASSET_BUFFER,
						// 	);
						// }

						// $data = array(
						//     'category_id' => $category_id,
						//     'vendor_id' => $vendor_id,
						//     'invoice_no_id' => $invoice_no_id,
						//     'purchase_date' => isset($asset_value['purchase_date']) ? date('Y-m-d',strtotime($asset_value['purchase_date'])) : '',
						//     'asset_id' => isset($asset_value['asset_id']) ? trim($asset_value['asset_id']) : '',
						//     'manufacturer_id' => $manufacturer_id,
						//     'serial_no' => isset($asset_value['serial_no']) ? trim($asset_value['serial_no']) : '',
						//     'warranty_expiry_date' => isset($asset_value['warranty_expiry_date']) ? date('Y-m-d',strtotime($asset_value['warranty_expiry_date'])) : '',
						//     'asset_location_id' => $asset_location_id,
						//     'model_name' => isset($asset_value['model_name']) ? trim($asset_value['model_name']) : '',
						//     'price' => isset($asset_value['price']) ? trim($asset_value['price']) : '',
						//     'processor' => isset($asset_value['processor']) ? trim($asset_value['processor']) : '',
						//     'installed_ram' => isset($asset_value['installed_ram']) ? trim($asset_value['installed_ram']) : '',
						// 	'ram_unit' => isset($asset_value['ram_unit']) ? trim($asset_value['ram_unit']) : '',
						//     'host_name' => isset($asset_value['host_name']) ? trim($asset_value['host_name']) : '',
						//     'hard_disk' => isset($asset_value['hard_disk']) ? trim($asset_value['hard_disk']) : '',
						//     'storage_capacity' => isset($asset_value['storage_capacity']) ? trim($asset_value['storage_capacity']) : '',
						//     'storage_capacity_unit' => isset($asset_value['storage_capacity_unit']) ? trim($asset_value['storage_capacity_unit']) : '',
						//     'windows_edition' => isset($asset_value['windows_edition']) ? trim($asset_value['windows_edition']) : '',
						//     'windows_key' => isset($asset_value['windows_key']) ? trim($asset_value['windows_key']) : '',
						//     'device_id' => isset($asset_value['device_id']) ? trim($asset_value['device_id']) : '',
						//     'product_id' => isset($asset_value['product_id']) ? trim($asset_value['product_id']) : '',
						//     'screen_size' => isset($asset_value['screen_size']) ? trim($asset_value['screen_size']) : '',
						//     'type' => isset($asset_value['type']) ? trim($asset_value['type']) : '',
						//     'adp_warranty' => isset($asset_value['adp_warranty']) ? trim($asset_value['adp_warranty']) : '',
						//     'status' => ASSET_BUFFER,
						// );


						$inserted_row[]=$CommonModel->insert_data($table_name = 'assets', $data);

					}
				}

				$log =$CommonModel->logCreate('IMPORT', 'Imported assets, total count - ' . count($asset_file) . ", successful - " . count($inserted_row) . ", unsuccessful - " . (count($asset_file) - count($inserted_row)));


				if (!empty($error_file_row)) {

					$filename = 'asset_upload_error_' . time();
					$handle = fopen("uploads/$filename.csv", "w");
					fputcsv($handle, array_merge($asset_file_headers_default, array('error')));
					foreach ($error_file_row as $values) {
						$temp = [];
						foreach ($values as $key1 => $values1) {
							$temp[] = $values1;
						}
						fputcsv($handle, $temp);
						// $csvfile.=$temp."\n";
					}

					if ($handle) {
						ob_clean();
						fclose($handle);
						header('Content-Type: application/octet-stream');
						header('Content-Type: application/download');
						header('Content-Encoding: UTF-8');
						header('Content-Type: application/csv; charset=UTF-8');
						header('Content-Disposition: attachment; filename=' . basename("uploads/$filename.csv"));
						header('Pragma: no-cache');
						header('Expires: 0');
						header('Cache-Control: must-revalidate');
						header('Pragma: public');
						header('Content-Length: ' . filesize("uploads/$filename.csv"));
						echo "\xEF\xBB\xBF";
						readfile("uploads/$filename.csv");
						unlink("uploads/$filename.csv");
						exit;
					}
				}


				session()->setFlashdata("success", "Data upload successfully.");
				return redirect()->to(base_url() . '/import');
				die;
			}else {
				session()->setFlashdata("error", "Empty File, please try again!!");
				return redirect()->to(base_url() . '/import');
			}
		} else {
			session()->setFlashdata("error", "Something went wrong, please try again!!");
			return redirect()->to(base_url() . '/import');
		}
	}

	public function importUserFile()
	{
		ini_set('max_execution_time', 5096);
		ini_set('memory_limit', '5096M');
		$CommonModel = new CommonModel();
		if (!empty($_FILES['user_file']['name'])) {

			$user_file = $CommonModel->parseCsv($_FILES['user_file']['tmp_name']);
			$parsecsvcheckutf = $CommonModel->parseCsvCheckUtf($_FILES['user_file']['tmp_name']);
			$checkCsvUtf = $CommonModel->checkCsvUtf($parsecsvcheckutf[0]);
			if ($checkCsvUtf) {
				session()->setFlashdata("error", "Uploaded file format is not match. Please upload a CSV file in UTF-8 format.");
				return redirect()->to(base_url() . '/import');
				die;
			}
			$user_file_headers_default = array('first_name', 'last_name', 'email', 'job_title', 'department', 'reporting_head', 'user_type', 'user_work_location', 'joining_date', 'microsoft_365_business_licence', 'microsoft_365_apps_for_business');
			if (!empty($user_file[0])) {
				$csv_header = preg_replace("/[^(\x20-\x7F)]*/", "", array_keys($user_file[0]));

				if (array_diff($user_file_headers_default, $csv_header)) {
					$diff_column = count(array_diff($user_file_headers_default, $csv_header)) > 0 ? implode(', ', array_diff($user_file_headers_default, $csv_header)) : '';
					$error_column_match = 'File Column and Required Column does not match. The different columns are ' . $diff_column;
					session()->setFlashdata("error", $error_column_match);
					return redirect()->to(base_url() . '/import');
					die;
				}

				$if_error = '';
				$array_row = [];
				$error_file_data = [];
				$error_file_row = [];
				$inserted_row=[];
				foreach ($user_file as $user_value) {
					$error_file_data = [];
					if ($user_value['user_work_location']) {
						if ($user_value['user_work_location'] == 'Office') {
							$user_work_location = WORK_LOCATION_OFFICE;
						} elseif ($user_value['user_work_location'] == 'Home') {
							$user_work_location = WORK_LOCATION_HOME;
						} else {
							$category_id = '';
							$error_file_data[] = 'Work location not match';
						}
					} else {
						$category_id = '';
						$error_file_data[] = 'Work location not match';
					}

					if ($user_value['email']) {
						$checkuser_id =  $CommonModel->getAllDataByColumnName($table_name = 'user', $column_name = 'email', $value = $user_value['email']);
						if (count($checkuser_id) > 0) {
							$error_file_data[] = 'Email already exits';
						}
					} else {
						$error_file_data[] = 'Email already exits';
					}
					if ($user_value['microsoft_365_business_licence']) {
						if ($user_value['microsoft_365_business_licence'] != 'Microsoft 365 Business Standard' && $user_value['microsoft_365_business_licence'] != 'Microsoft 365 Business Basic') {
							$error_file_data[] = 'Microsoft 365 Licence not match';
						}
					}

					// 	if($user_value['reporting_head']){
					// 	if($user_value['reporting_head'] == 'TL'){
					// 		$user_reporting_head=REPORTING_H_TL;
					// 	}elseif($user_value['reporting_head'] == 'Manager'){
					// 		$user_reporting_head=REPORTING_H_MANAGER;
					// 	}else{
					// 		$category_id='';
					// 		$error_file_data[]='Reporting head not match';
					// 	}
					// }else{
					// 		$category_id='';
					// 		$error_file_data[]='Reporting head not match';
					// }


					if ($user_value['user_type']) {
						if ($user_value['user_type'] == 'Admin') {
							$user_type = ADMIN;
						} elseif ($user_value['user_type'] == 'Technician') {
							$user_type = TECHNICIAN;
						} elseif ($user_value['user_type'] == 'Employee') {
							$user_type = EMPLOYEE;
						} else {
							$category_id = '';
							$error_file_data[] = 'User Type not match';
						}
					} else {
						$category_id = '';
						$error_file_data[] = 'User Type not match';
					}
					if ($user_value['department']) {
						$checkuser_dp = $CommonModel->getDataByColumnName($table_name = 'department', $column_name = 'name', $value = $user_value['department']);
						if (count($checkuser_dp) > 0) {
							$dp_id = $checkuser_dp[0]['id'];
						} else {

							$error_file_data[] = 'department not match';
						}
						// if($user_value['department'] == ''){
						// 	$user_reporting_head=REPORTING_H_TL;
						// }elseif($user_value['department'] == 'Manager'){
						// 	$user_reporting_head=REPORTING_H_MANAGER;
						// }else{
						// 	$category_id='';
						// 	$error_file_data[]='Reporting head not match';
						// }
					} else {
						$category_id = '';
						$error_file_data[] = 'department not match';
					}

					$user_value['error'] = '';
					if (!empty($error_file_data)) {
						$user_value['error'] = implode(' | ', $error_file_data);
						$error_file_row[] = $user_value;
					} else {
						$data = array(
							'first_name' => isset($user_value['first_name']) ? trim($user_value['first_name']) : '',
							'last_name' => isset($user_value['last_name']) ? trim($user_value['last_name']) : '',
							'email' => isset($user_value['email']) ? trim($user_value['email']) : '',
							'job_title' => isset($user_value['job_title']) ? trim($user_value['job_title']) : '',
							'password' => md5('Dz@123'),
							'user_type' => EMPLOYEE,
							'department' => isset($dp_id) ? trim($dp_id) : '',
							'reporting_head' => isset($user_value['reporting_head']) ? trim($user_value['reporting_head']) : '',
							'user_work_location' => isset($user_work_location) ? trim($user_work_location) : '',
							'joining_date' => isset($user_value['joining_date']) ? date('Y-m-d', strtotime($user_value['joining_date'])) : '',
							'microsoft_365_business_licence' => isset($user_value['microsoft_365_business_licence']) ? trim($user_value['microsoft_365_business_licence']) : '',
							'microsoft_365_apps_for_business' => isset($user_value['microsoft_365_apps_for_business']) ? trim($user_value['microsoft_365_apps_for_business']) : '',
							'status' => ACTIVE,
							'created_date' => date('Y-m-d H:i:s'),
							'created_by' => session('user_id')
						);
						$inserted_row[]=$CommonModel->insert_data($table_name = 'user', $data);

					}
				}


				$log = $CommonModel->logCreate('IMPORT', 'Imported users , total count -' . count($user_file)." ".',successful-'.count($inserted_row)." ".',unsuccessfull-'.(count($user_file) - count($inserted_row)));

				if (!empty($error_file_row)) {

					$filename = 'user_upload_error_' . time();
					$handle = fopen("uploads/$filename.csv", "w");
					fputcsv($handle, array_merge($user_file_headers_default, array('error')));
					foreach ($error_file_row as $values) {
						$temp = [];
						foreach ($values as $key1 => $values1) {
							$temp[] = $values1;
						}
						fputcsv($handle, $temp);
						// $csvfile.=$temp."\n";
					}
					if ($handle) {
						ob_clean();
						fclose($handle);
						header('Content-Type: application/octet-stream');
						header('Content-Type: application/download');
						header('Content-Encoding: UTF-8');
						header('Content-Type: application/csv; charset=UTF-8');
						header('Content-Disposition: attachment; filename=' . basename("uploads/$filename.csv"));
						header('Pragma: no-cache');
						header('Expires: 0');
						header('Cache-Control: must-revalidate');
						header('Pragma: public');
						header('Content-Length: ' . filesize("uploads/$filename.csv"));
						echo "\xEF\xBB\xBF";
						readfile("uploads/$filename.csv");
						unlink("uploads/$filename.csv");
						exit;
					}
				}

				session()->setFlashdata("success", "Data upload successfully.");
				return redirect()->to(base_url() . '/import');
				die;
			}
			else {
				session()->setFlashdata("error", "Empty File, please try again!!");
				return redirect()->to(base_url() . '/import');
			}
		} else {
			session()->setFlashdata("error", "Something went wrong, please try again!!");
			return redirect()->to(base_url() . '/import');
		}
	}

	public function downloadImportFileHeader($type)
	{



		ini_set('max_execution_time', 5096);
		ini_set('memory_limit', '5096M');

		$CategoryModel = new CategoryModel();

		$CategoryData = $CategoryModel
			->select('category.id, category.category_name')
			->where('category.id', $type)
			->first();


		if ($type == 501) {
			$filename = 'user_import' . '_' . time();
		} elseif ($type == 502) {
			$filename = 'asset_import' . '_' . time();
		} else {
			$filename = $CategoryData['category_name'] . '_' . time();
		}

		// $filename = $type . '_' . time();

		$handle = fopen("uploads/$filename.csv", "w");

		if ($type == 1) {
			//main all filled
			// $asset_file_headers_default=array('category', 'vendor', 'invoice_no', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'price', 'processor', 'installed_ram','ram_unit', 'host_name', 'hard_disk', 'storage_capacity', 'storage_capacity_unit', 'windows_edition', 'windows_key', 'device_id', 'product_id', 'screen_size', 'type', 'adp_warranty');
			//cpu//	1
			$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'price', 'processor', 'installed_ram', 'ram_unit', 'host_name', 'hard_disk', 'storage_capacity', 'storage_capacity_unit', 'windows_edition', 'windows_key', 'device_id', 'product_id');
			//moniter 2//	television 19
			// $asset_file_headers_default=array('category', 'vendor', 'invoice_no','price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name',  'screen_size' );
			//keyboard 3/mouse 4
			// $asset_file_headers_default=array('category', 'vendor', 'invoice_no','price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name','type');

			//laptop 5
			// $asset_file_headers_default=array('category', 'vendor', 'invoice_no', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'price', 'processor', 'installed_ram','ram_unit', 'hard_disk', 'storage_capacity', 'storage_capacity_unit', 'windows_edition', 'windows_key', 'device_id', 'product_id', 'screen_size','adp_warranty');
			//Laptop Charger 6 // i phone 7 // projector 8 // sound system 9 // printer 10 // switches 11 // routers 12 // firewall 13 //webcam 14 //  usb pendriv 15 // headset 18 // access point 20 // other asset 21 // harddisk 25 // wifi 26
			// $asset_file_headers_default=array('category', 'vendor', 'invoice_no','price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name');

			//external storage 16
			// $asset_file_headers_default=array('category', 'vendor', 'invoice_no', 'price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'processor', 'installed_ram','ram_unit',  'storage_capacity', 'storage_capacity_unit',);

			//server 17
			// $asset_file_headers_default=array('category', 'vendor', 'invoice_no', 'price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'processor', 'installed_ram','ram_unit', 'hard_disk', 'storage_capacity', 'storage_capacity_unit',);

			//
			fputcsv($handle, $asset_file_headers_default);
		}

		if ($type == 2 || $type == 19) {
			$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name',  'screen_size');
			fputcsv($handle, $asset_file_headers_default);
		}


		if ($type == 3 || $type == 4) {
			$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'type');
			fputcsv($handle, $asset_file_headers_default);
		}

		if ($type == 5) {
			$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'price', 'processor', 'installed_ram', 'ram_unit', 'hard_disk', 'storage_capacity', 'storage_capacity_unit', 'windows_edition', 'windows_key', 'device_id', 'product_id', 'screen_size', 'adp_warranty');
			fputcsv($handle, $asset_file_headers_default);
		}

		if ($type == 6 || $type == 7 || $type == 8 || $type == 9 || $type == 10 || $type == 11 || $type == 12 || $type == 13 || $type == 14 || $type == 15 || $type == 18 || $type == 20 || $type == 21 || $type == 25 || $type == 26) {
			$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name');
			fputcsv($handle, $asset_file_headers_default);
		}

		if ($type == 16) {
			$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'processor', 'installed_ram', 'ram_unit',  'storage_capacity', 'storage_capacity_unit',);
			fputcsv($handle, $asset_file_headers_default);
		}


		if ($type == 17) {
			$asset_file_headers_default = array('category', 'vendor', 'invoice_no', 'price', 'purchase_date', 'asset_id', 'manufacturer', 'serial_no', 'warranty_expiry_date', 'asset_location', 'model_name', 'processor', 'installed_ram', 'ram_unit', 'hard_disk', 'storage_capacity', 'storage_capacity_unit',);
			fputcsv($handle, $asset_file_headers_default);
		}


		if ($type == 501) {
			$user_file_headers_default = array('first_name', 'last_name', 'email', 'job_title', 'department', 'reporting_head', 'user_type', 'user_work_location', 'joining_date', 'microsoft_365_business_licence', 'microsoft_365_apps_for_business');
			fputcsv($handle, $user_file_headers_default);
		}
		if ($type == 502) {
			$user_file_headers_default = array('email', 'asset_id');
			fputcsv($handle, $user_file_headers_default);
		}
		if ($handle) {
			ob_clean();
			fclose($handle);
			header('Content-Type: application/octet-stream');
			header('Content-Type: application/download');
			header('Content-Encoding: UTF-8');
			header('Content-Type: application/csv; charset=UTF-8');
			header('Content-Disposition: attachment; filename=' . basename("uploads/$filename.csv"));
			header('Pragma: no-cache');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize("uploads/$filename.csv"));
			echo "\xEF\xBB\xBF";
			readfile("uploads/$filename.csv");
			unlink("uploads/$filename.csv");
			exit;
		}
	}




	public function importUserAssignAssetFile()
	{
		ini_set('max_execution_time', 5096);
		ini_set('memory_limit', '5096M');
		$CommonModel = new CommonModel();
		if (!empty($_FILES['user_assets_file']['name'])) {

			$user_assets_file = $CommonModel->parseCsv($_FILES['user_assets_file']['tmp_name']);
			$parsecsvcheckutf = $CommonModel->parseCsvCheckUtf($_FILES['user_assets_file']['tmp_name']);
			$checkCsvUtf = $CommonModel->checkCsvUtf($parsecsvcheckutf[0]);
			if ($checkCsvUtf) {
				session()->setFlashdata("error", "Uploaded file format is not match. Please upload a CSV file in UTF-8 format.");
				return redirect()->to(base_url() . '/import');
				die;
			}
			$user_assets_file_headers_default = array('email', 'asset_id');
			if (!empty($user_assets_file[0])) {
				$csv_header = preg_replace("/[^(\x20-\x7F)]*/", "", array_keys($user_assets_file[0]));

				if (array_diff($user_assets_file_headers_default, $csv_header)) {
					$diff_column = count(array_diff($user_assets_file_headers_default, $csv_header)) > 0 ? implode(', ', array_diff($user_assets_file_headers_default, $csv_header)) : '';
					$error_column_match = 'File Column and Required Column does not match. The different columns are ' . $diff_column;
					session()->setFlashdata("error", $error_column_match);
					return redirect()->to(base_url() . '/import');
					die;
				}

				$if_error = '';
				$array_row = [];
				$error_file_data = [];
				$error_file_row = [];
				$inserted_row=[];
				foreach ($user_assets_file as $user_assets_value) {
					$error_file_data = [];
					if ($user_assets_value['asset_id']) {
						$checkasset_id =  $CommonModel->getAllDataByColumnName($table_name = 'assets', $column_name = 'asset_id', $value = $user_assets_value['asset_id']);
						if (count($checkasset_id) > 0) {
							$assetid = $checkasset_id[0]['id'];
							$checkcategory =  $CommonModel->getAllDataByColumnName($table_name = 'category', $column_name = 'id', $value = $checkasset_id[0]['category_id']);
							if (count($checkcategory) > 0) {
								$user_asset_data =  $CommonModel->getUserAssetsByAssetId($assetid);
								if (count($user_asset_data) >= $checkcategory[0]['user_assign_limit'] && count($user_asset_data) == $checkcategory[0]['user_assign_limit']) {
									$error_file_data[] = 'Assets already asigned for ' . $checkcategory[0]['user_assign_limit'] . ' users';
								}
							}
						} else {
							$assetid = '';
							$error_file_data[] = 'Assets Id not found';
						}
					} else {
						$error_file_data[] = 'Assets Id is blank';
					}
					if ($user_assets_value['email']) {
						$checkuser_id =  $CommonModel->getAllDataByColumnName($table_name = 'user', $column_name = 'email', $value = $user_assets_value['email']);
						if (count($checkuser_id) > 0) {
							$userid = $checkuser_id[0]['id'];
						} else {
							$userid = '';
							$error_file_data[] = 'Email not found';
						}
					} else {
						$error_file_data[] = 'Email is blank';
					}
					$user_asset_assigned =  $CommonModel->checkUserAssetsAssigned($userid, $assetid);
					if (count($user_asset_assigned) > 0) {
						$error_file_data[] = 'Assets already asigned for this user';
					}

					$user_assets_value['error'] = '';
					if (!empty($error_file_data)) {
						$user_assets_value['error'] = implode(' | ', $error_file_data);
						$error_file_row[] = $user_assets_value;
					} else {
						$data = array(
							'user_id' => $userid,
							'asset_id' => $assetid,
							'status' => ASSIGNED,
							'created_date' => date('Y-m-d H:i:s'),
							'created_by' => session('user_id')
						);
						$CommonModel->insert_data($table_name = 'user_assets', $data);
						$data_assets = array(
							'status' => ASSET_ASSIGN,
							'updated_date' => date('Y-m-d H:i:s'),
							'updated_by' => session('user_id')
						);
						$inserted_row[]=$CommonModel->update_data($table_name = 'assets', $assetid, $data_assets);
					}
				}

				$log = $CommonModel->logCreate('IMPORT', 'Imported users , total count -' . count($user_assets_file)." ".',successful-'.count($inserted_row)." ".',unsuccessfull-'.(count($user_assets_file) - count($inserted_row)));


				if (!empty($error_file_row)) {

					$filename = 'allocate_assets_upload_error_' . time();
					$handle = fopen("uploads/$filename.csv", "w");
					fputcsv($handle, array_merge($user_assets_file_headers_default, array('error')));
					foreach ($error_file_row as $values) {
						$temp = [];
						foreach ($values as $key1 => $values1) {
							$temp[] = $values1;
						}
						fputcsv($handle, $temp);
						// $csvfile.=$temp."\n";
					}
					if ($handle) {
						ob_clean();
						fclose($handle);
						header('Content-Type: application/octet-stream');
						header('Content-Type: application/download');
						header('Content-Encoding: UTF-8');
						header('Content-Type: application/csv; charset=UTF-8');
						header('Content-Disposition: attachment; filename=' . basename("uploads/$filename.csv"));
						header('Pragma: no-cache');
						header('Expires: 0');
						header('Cache-Control: must-revalidate');
						header('Pragma: public');
						header('Content-Length: ' . filesize("uploads/$filename.csv"));
						echo "\xEF\xBB\xBF";
						readfile("uploads/$filename.csv");
						unlink("uploads/$filename.csv");
						exit;
					}
				}

				session()->setFlashdata("success", "Data upload successfully.");
				return redirect()->to(base_url() . '/import');
				die;
			} else {
				session()->setFlashdata("error", "Something went wrong, please try again!!");
				return redirect()->to(base_url() . '/import');
			}
		} else {
			session()->setFlashdata("error", "Something went wrong, please try again!!");
			return redirect()->to(base_url() . '/import');
		}
	}
}
