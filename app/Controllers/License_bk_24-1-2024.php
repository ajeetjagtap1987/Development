<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LicenseModel;
use App\Models\CommonModel;

class License extends Controller
{

    function __construct()
    {
        $user_id = session('user_id');
        if (!$user_id) {
            header('Location: ' . base_url() . '/login');
            exit;
        }
        if (!in_array(ACCESS_LICENSE, session('user_access'))) {
            header('Location: ' . base_url());
            exit;
        }
    }
    public function list()
    {
        if (!is_file(APPPATH . 'Views/licenses/list.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $data['manufacturer'] = $CommonModel->getAllActiveData($table_name = 'manufacturer');
        $data['application'] = $CommonModel->getSelectiveData($table_name = 'license_name', $column_name = 'id,name');

        return view('includes/header') . view('licenses/list', $data) . view('includes/footer');
    }

    public function create()
    {
        if (!is_file(APPPATH . 'Views/licenses/create.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $data['category'] = $CommonModel->getAllDataByColumnName($table_name = 'category', $column_name = 'category_type', $value = CATEGORY_LICENSE);
        $data['manufacturer'] = $CommonModel->getAllActiveData($table_name = 'manufacturer');
        $data['application'] = $CommonModel->getSelectiveData($table_name = 'license_name', $column_name = 'id,name');


        return view('includes/header') . view('licenses/create', $data) . view('includes/footer');
    }

    public function licenseInsert()
    {
        $product_key = isset($_POST['product_key']) ? $_POST['product_key'] : '';

        $CommonModel = new CommonModel();
        $license = isset($_POST['license_name']) ? $_POST['license_name'] : '';
        $new_license = isset($_POST['new_license']) ? $_POST['new_license'] : '';

        if (!empty($product_key) && $product_key != 'NA') {
            $checkdata = $CommonModel->getAllDataByColumnName($table_name = 'license', $column_name = 'product_key', $value = $product_key);
        } else {
            $checkdata = [];
        }

        if (count($checkdata) == 0) {
            if ($license == "other") {
                $new_license_data = array(
                    'name' => isset($new_license) ? trim($new_license) : '',
                );

                $license_name_id = $CommonModel->insert_data($table_name = 'license_name', $new_license_data);
                $postlicense_id = $license_name_id;
            } else {
                $postlicense_id = $license;
            }

            $data = array(
                'license_name_id' => isset($postlicense_id) ? trim($postlicense_id) : '',
                // 'category_id' => isset($_POST['category_id']) ? trim($_POST['category_id']) : '',
                'manufacturer_id' => isset($_POST['manufacturer_id']) ? trim($_POST['manufacturer_id']) : '',
                'product_key' => isset($_POST['product_key']) ? trim($_POST['product_key']) : '',
                'license_to_name' => isset($_POST['license_to_name']) ? trim($_POST['license_to_name']) : '',
                'license_to_email' => isset($_POST['license_to_email']) ? trim($_POST['license_to_email']) : '',
                'start_date' => isset($_POST['start_date']) ? trim($_POST['start_date']) : '',
                'expiry_date' => isset($_POST['expiry_date']) ? trim($_POST['expiry_date']) : '',
                'price' => isset($_POST['price']) ? trim($_POST['price']) : '',
                'currency' => isset($_POST['currency']) ? trim($_POST['currency']) : '',
                'renewal' => isset($_POST['renewal']) ? trim($_POST['renewal']) : '',
                'note' => isset($_POST['note']) ? trim($_POST['note']) : '',
                'user_limit' => isset($_POST['user_limit']) ? trim($_POST['user_limit']) : '',
                'status' => ACTIVE,
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => session('user_id')
            );
            $last_id = $CommonModel->insert_data($table_name = 'license', $data);
            if ($last_id) {

                $license_names =  $CommonModel->getDataByColumnName($table_name='license_name',$column_name='id',$value=$data['license_name_id']);

                $log = $CommonModel->logCreate(
                    'ADD',
                    'Inserted new License , license name - ' . $license_names[0]['name'] . ' , product key -' . (empty($data['product_key']) ? 'NA' : $data['product_key']) ,
                );

                session()->setFlashdata("success", "Created successfully!!");
                $response['status'] = 'success';
                $response['message'] = 'Created successfully!!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Something went wrong, please try again!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Product_key already exists!!';
        }


        echo json_encode($response);
        exit;
    }

    public function edit($e_id)
    {
        if (!is_file(APPPATH . 'Views/licenses/edit.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'license', $id);
        if (count($result) > 0) {

            $data['license'] = $result;
            $data['category'] = $CommonModel->getAllDataByColumnName($table_name = 'category', $column_name = 'category_type', $value = CATEGORY_LICENSE);
            $data['manufacturer'] = $CommonModel->getAllActiveData($table_name = 'manufacturer');
            $data['application'] = $CommonModel->getSelectiveData($table_name = 'license_name', $column_name = 'id,name');

            return view('includes/header') . view('licenses/edit', $data) . view('includes/footer');
        } else {
            session()->setFlashdata("error", "Something went wrong, please try again!!");
            return redirect()->to(base_url() . '/licenses/list');
        }
    }

    public function licenseUpdate($e_id)
    {
        $product_key = isset($_POST['product_key']) ? $_POST['product_key'] : '';
        $formattedDate = date('Y-m-d', strtotime($_POST['expiry_date']));

        $license = isset($_POST['software_name']) ? $_POST['software_name'] : '';
        $new_license = isset($_POST['new_license']) ? $_POST['new_license'] : '';


        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'license', $id);
        if (count($result) > 0) {

            if ($result[0]['product_key'] != $product_key) {
                // $checkdata =  $CommonModel->getAllDataByColumnName($table_name = 'license', $column_name = 'product_key', $value = $product_key);

                $checkdata = $CommonModel->getAllDataByColumnNameExceptCurrent(
                    $table_name = 'license',
                    $column_name = 'product_key',
                    $value = $product_key,
                    $currentRecordId = $id
                );
            } else {
                $checkdata = array();
            }
            if (count($checkdata) == 0) {


                if ($license == "other") {

                    $new_license_data = array(
                        'name' => isset($new_license) ? trim($new_license) : '',

                    );


                    $license_name_id = $CommonModel->insert_data($table_name = 'license_name', $new_license_data);
                    $postlicense_id = $license_name_id;
                } else {
                    $postlicense_id = $license;
                }

                $data = array(
                    'license_name_id' => isset($postlicense_id) ? trim($postlicense_id) : '',
                    // 'category_id' => isset($_POST['category_id']) ? trim($_POST['category_id']) : '',
                    'manufacturer_id' => isset($_POST['manufacturer_id']) ? trim($_POST['manufacturer_id']) : '',
                    'product_key' => isset($_POST['product_key']) ? trim($_POST['product_key']) : '',
                    'license_to_name' => isset($_POST['license_to_name']) ? trim($_POST['license_to_name']) : '',
                    'license_to_email' => isset($_POST['license_to_email']) ? trim($_POST['license_to_email']) : '',
                    'start_date' => isset($_POST['start_date']) ? trim($_POST['start_date']) : '',
                    'expiry_date' => isset($formattedDate) ? trim($formattedDate) : '',
                    'price' => isset($_POST['price']) ? trim($_POST['price']) : '',
                    'currency' => isset($_POST['currency']) ? trim($_POST['currency']) : '',
                    'renewal' => isset($_POST['renewal']) ? trim($_POST['renewal']) : '',
                    'note' => isset($_POST['note']) ? trim($_POST['note']) : '',
                    'user_limit' => isset($_POST['user_limit']) ? trim($_POST['user_limit']) : '',
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => session('user_id')
                );
                $CommonModel->update_data($table_name = 'license', $id, $data);

                $license_names =  $CommonModel->getDataByColumnName($table_name='license_name',$column_name='id',$value=$data['license_name_id']);

                $log = $CommonModel->logCreate(
                    'UPDATE',
                    'Updated License , license name - ' . $license_names[0]['name'] . ' , product key -' . (empty($data['product_key']) ? 'NA' : $data['product_key']) ,
                );

                session()->setFlashdata("success", "Updated successfully!!");
                $response['status'] = 'success';
                $response['message'] = 'Updated successfully!!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Product key  already exists!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Something went wrong, please try again!!';
        }
        echo json_encode($response);
        exit;
    }


    public function licenseFilter($page_no)
    {

        $csrfToken = csrf_hash();
        $request = service('request');
        $searchData = $request->getPost();
        // Get data
        $LicenseModel = new LicenseModel();

        if ($searchData['keyword'] != '') {
            $where = "(license_name.name like '" . $searchData['keyword'] . "%')";
            $paginateData = $LicenseModel
                ->where($where);
        }
        if ($searchData['license'] != '') {
            $paginateData = $LicenseModel->where('license.license_name_id', $searchData['license']);
        }
        if ($searchData['manufacturer'] != '') {
            $paginateData = $LicenseModel->where('license.manufacturer_id', $searchData['manufacturer']);
        }
        if ($searchData['status'] != '') {
            if ($_POST['status'] == 0) {
                $paginateData = $LicenseModel->where('license.expiry_date <=', date('Y-m-d'));
            } else {
                $paginateData = $LicenseModel->where('license.expiry_date >=', date('Y-m-d'));
            }
        }
        if (isset($searchData['renewal']) && $searchData['renewal'] != '') {
            $paginateData = $LicenseModel->whereIn('license.renewal', $searchData['renewal']);
        }
        if (isset($searchData['created_at']) && $searchData['created_at'] != '') {
            $str = explode(" - ", $searchData['created_at']);
            $str1 = str_replace("/", "-", trim($str[0]));
            $str2 = str_replace("/", "-", trim($str[1]));
            $paginateData = $LicenseModel->where('date(expiry_date) >=', $str1);
            $paginateData = $LicenseModel->where('date(expiry_date) <=', $str2);
        }
        $paginateData = $LicenseModel->select('license.*, license_name.*, license_name.name as software,license.id as license_id')
            ->join('license_name', 'license.license_name_id = license_name.id', 'left')
            ->where('license.deleted_by', NULL)->paginate($searchData['show_per_page'], 'default', $page_no);
        $output = array(
            'paginateData' => $paginateData,
            'pager' => $LicenseModel->pager,
            'csrfToken' => $csrfToken,
        );
        return view('licenses/filter_list', $output);
    }

    public function licensesAutocomplete()
    {
        $searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';
        $data = [];
        if (!empty($searchTerm)) {
            $LicenseModel = new LicenseModel();
            $licenses = $LicenseModel->getAssetDataBySoftwareName($searchTerm);
            if (count($licenses) > 0) {
                foreach ($licenses as $license) {
                    $data[] = ['id' => $license['id'], 'text' => $license['software_name']];
                }
            }
        }
        echo json_encode($data);
    }

    public function getlicenseById($id)
    {

        $CommonModel = new CommonModel();
        // $assetsDetails = $CommonModel->getAllDataByColumnName($table_name='license',$coloumnname='id',$id);


        $UserLicenseModel = new LicenseModel();
        $assetsDetails = $UserLicenseModel
            ->select('license.*, license_name.*, license.license_name_id as software,license.id as license_id')
            ->join('license_name', 'license.license_name_id = license_name.id', 'left')
            ->where('license.id', $id)
            ->findAll();

        $data['status'] = 'success';
        $data['message'] = 'Done';
        $asset_info = '';
        if (count($assetsDetails) > 0) {
            $asset_status = '';
            foreach (ASSET_STATUS as $key => $value) {
                if ($assetsDetails[0]['status'] == $key) {
                    $asset_status = $value;
                }
            }
            $asset_info .= '<table class="table table-bordered table-striped table-responsive table-sm">
                  <tbody>
                    <tr>
                      <th scope="row" width="110px">Software Name</th>
                      <td>' . $assetsDetails[0]['name'] . '</td>
                    </tr>
                    <tr>
                      <th scope="row" width="110px">Product Key</th>
                      <td>' . $assetsDetails[0]['product_key'] . '</td>
                    </tr>
                    <tr>
                      <th scope="row" width="110px">Expiry_date</th>
                      <td>' . $assetsDetails[0]['expiry_date'] . '</td>
                    </tr>
                    <tr>
                      <th scope="row" width="110px">Status</th>
                      <td>' . $asset_status . '</td>
                    </tr>
                  </tbody>
                </table>';
            $user_asset_data = $CommonModel->getUserLicenseByLicenseId($assetsDetails[0]['license_id']);
            if (count($user_asset_data) > 0) {
                $asset_info .= '<p>This asset is already assigned to the users below.</p>';
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
                        $asset_info .= '<tr>
                                    <td>' . $user_data[0]['first_name'] . ' ' . $user_data[0]['last_name'] . '</td>
                                    <td>' . $user_data[0]['email'] . '</td>
                                    <td>' . $user_data[0]['job_title'] . '</td>
                                    <td>' . $user_data[0]['reporting_head'] . '</td>
                                  </tr>';
                    }
                }

                $asset_info .= '</tbody>
                </table>';
            }
        }


        $data['asset_info'] = $asset_info;

        echo json_encode($data);
    }

    public function licenseExport()
    {

        if (!is_file(APPPATH . 'Views/licenses/export.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $data['license'] = $CommonModel->getData($table_name = 'license_name');
        $data['manufacturer'] = $CommonModel->getData($table_name = 'manufacturer');



        return view('includes/header') . view('licenses/export', $data) . view('includes/footer');
    }

    public function exportData()
    {
        $CommonModel = new CommonModel();
        $LicenseModel = new LicenseModel();
        $selectiveData = ['id', 'license_name_id', 'product_key', 'manufacturer_id', 'license_to_name', 'license_to_email', 'start_date', 'expiry_date', 'price', 'currency', 'renewal', 'note', 'user_limit'];

        $licenseDetails = $LicenseModel
            ->select($selectiveData);

        $request = service('request');
        $searchData = $request->getPost();

        if (isset($searchData['license_name']) && $searchData['license_name'] != '') {
            $licenseDetails->whereIn('license.license_name_id', $searchData['license_name']);
        }
        if (isset($searchData['manufacturer_id']) && $searchData['manufacturer_id'] != '') {
            $licenseDetails->whereIn('license.manufacturer_id', $searchData['manufacturer_id']);
        }
        if ($searchData['status'] != '') {
            if ($_POST['status'] == 0) {
                $licenseDetails->where('license.expiry_date <=', date('Y-m-d'));
            } else {
                $licenseDetails->where('license.expiry_date >=', date('Y-m-d'));
            }
        }
        if (isset($searchData['renewal']) && $searchData['renewal'] != '') {
            $licenseDetails->whereIn('license.renewal', $searchData['renewal']);
        }
        $licenseData = $licenseDetails->where('deleted_by', NULL)->findAll();
        if (count($licenseData) <= 0) {
            session()->setFlashdata("error", "No Data Found!!");
            return redirect()->to(base_url() . '/licenses/export');
        }
        $data = [];
        foreach ($licenseData as $data_fill) {
            if ($data_fill['license_name_id']) {
                $license_info = $CommonModel->getDataByColumnName($table_name = 'license_name', $column_name = 'id', $value = $data_fill['license_name_id']);
                $data_fill['license_name_id'] = $license_info[0]['name'];
            } else {
                $data_fill['license_name_id'] = '';
            }
            if ($data_fill['manufacturer_id']) {
                $manifacture_info = $CommonModel->getDataByColumnName($table_name = 'manufacturer', $column_name = 'id', $value = $data_fill['manufacturer_id']);
                $data_fill['manufacturer_id'] = $manifacture_info[0]['name'];
            } else {
                $data_fill['manufacturer_id'] = '';
            }
            $data[] = $data_fill;
        }
        header("Content-type: application/csv;charset=utf-8'");
        header("Content-Disposition: attachment; filename=\"license_report" . ".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');

        fwrite($handle, chr(239) . chr(187) . chr(191));

        if (!empty($data)) {
            $firstDataArray = reset($data);
            $columnHeaders = array_keys($firstDataArray);
            fputcsv($handle, $columnHeaders);
        }
        foreach ($data as $data_array) {
            fputcsv($handle, $data_array);
        }
        fclose($handle);
        $log = $CommonModel->logCreate('EXPORT', 'Exported license report , total count -' . count($data));

        exit;
    }

    public function licenseDelete()
    {

        if (empty($_POST['license_id'])) {

            $response['status'] = 'error';
            $response['message'] = 'something went wrong!!';
            echo json_encode($response);
        }

        $CommonModel = new CommonModel();
        $license_assign_info = $CommonModel->getUserLicenseByLicenseId($_POST['license_id']);

        if (count($license_assign_info) > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Cannot delete license , license status is assigned!!';
        } else {
            $data = array(
                'deleted_date' => date('Y-m-d H:i:s'),
                'deleted_by' => session('user_id'),
            );

            $asset_info = $CommonModel->update_data($table_name = 'license', $id = $_POST['license_id'], $value = $data);

            $license_info =  $CommonModel->getDataByColumnName($table_name='license',$column_name='id',$value=$_POST['license_id']);

            $license_names =  $CommonModel->getDataByColumnName($table_name='license_name',$column_name='id',$value=$license_info[0]['license_name_id']);

                $log = $CommonModel->logCreate(
                    'DELETE',
                    'Deteted License , license name - ' . $license_names[0]['name'] . ' , product key -' . (empty($license_info[0]['product_key']) ? 'NA' : $license_info[0]['product_key']) ,
                );

            $response['status'] = 'success';
            $response['message'] = 'deleted successfully!!';

        }

        echo json_encode($response);
    }
}
