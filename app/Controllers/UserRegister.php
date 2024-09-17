<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\UserAssetsModel;
use App\Models\UserLicensesModel;
use App\Models\UserApplicationsModel;
use App\Models\CommonModel;

class UserRegister extends Controller
{

    function __construct()
    {
        $user_id = session('user_id');
        if (!$user_id) {
            header('Location: ' . base_url() . '/login');
            exit;
        }
        if (!in_array(ACCESS_USER, session('user_access'))) {
            header('Location: ' . base_url());
            exit;
        }
    }
    public function list()
    {
        if (!is_file(APPPATH . 'Views/users/list.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return view('includes/header') . view('users/list') . view('includes/footer');
    }

    public function create()
    {
        if (!is_file(APPPATH . 'Views/users/create.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $CommonModel = new CommonModel();
        $data['department'] = $CommonModel->getData($table_name = 'department');




        return view('includes/header') . view('users/create', $data) . view('includes/footer');
    }
    public function userInsert()
    {

        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $formattedDate = date('Y-m-d', strtotime($_POST['joining_date']));
        $UserModel = new UserModel();
        $CommonModel = new CommonModel();
        $result = $UserModel->userCheck($email);
        if (count($result) == 0) {
            if (isset($_POST['microsoft_365_business_licence']) && $_POST['microsoft_365_business_licence'] == 'Microsoft 365 Business Basic') {
                $microsoft_365_apps_for_business = isset($_POST['microsoft_365_apps_for_business_username']) ? trim($_POST['microsoft_365_apps_for_business_username']) . '@' . $_POST['microsoft_365_apps_for_business_domainname'] : '';
            } else {
                $microsoft_365_apps_for_business = '';
            }
            $data = array(
                'first_name' => isset($_POST['first_name']) ? trim($_POST['first_name']) : '',
                'last_name' => isset($_POST['last_name']) ? trim($_POST['last_name']) : '',
                'email' => isset($_POST['email']) ? trim($_POST['email']) : '',
                'job_title' => isset($_POST['job_title']) ? trim($_POST['job_title']) : '',
                'department' => isset($_POST['department']) ? trim($_POST['department']) : '',
                'password' => md5('Dz@123'),
                'user_type' => isset($_POST['user_type']) ? trim($_POST['user_type']) : EMPLOYEE,
                'reporting_head' => isset($_POST['reporting_head']) ? trim($_POST['reporting_head']) : '',
                'user_work_location' => isset($_POST['user_work_location']) ? trim($_POST['user_work_location']) : '',
                'joining_date' => isset($formattedDate) ? trim($formattedDate) : '',
                'microsoft_365_business_licence' => isset($_POST['microsoft_365_business_licence']) ? trim($_POST['microsoft_365_business_licence']) : '',
                'microsoft_365_apps_for_business' => $microsoft_365_apps_for_business,
                'status' => ACTIVE,
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => session('user_id')
            );
            $last_id = $UserModel->insert_data($data);
            if ($last_id) {

                $log = $CommonModel->logCreate('ADD', 'Inserted new User -' . $_POST['first_name'] . ' ' . $_POST['last_name']);

                if ($_POST['user_type'] == TECHNICIAN) {
                    $accesses = $CommonModel->getAllData($table_name = 'accesses');
                    foreach ($accesses as $access) {
                        $data_access = array(
                            'access_id' => $access['id'],
                            'user_id' => $last_id,
                            'created_date' => date('Y-m-d H:i:s'),
                            'created_by' => session('user_id')
                        );
                        $CommonModel->insert_data($table_name = 'user_accesses', $data_access);
                        // $userModelSecondDB->insert_data($table_name = 'user_accesses',$data_access);
                    }
                }
                session()->setFlashdata("success", "Created successfully!!");
                // return redirect()->to(base_url().'/users/create');
                $response['status'] = 'success';
                $response['message'] = 'Created successfully!!';
            } else {
                // session()->setFlashdata("error", "Something went wrong, please try again!!");
                // return redirect()->to(base_url().'/users/list');
                $response['status'] = 'error';
                $response['message'] = 'Something went wrong, please try again!!';
            }
        } else {
            // session()->setFlashdata("error", "Email Id already exists!!");
            // return redirect()->to(base_url().'/users/create');
            $response['status'] = 'error';
            $response['message'] = 'Email Id already exists!!';
        }
        echo json_encode($response);
        exit;
    }

    public function edit($e_id)
    {
        if (!is_file(APPPATH . 'Views/users/edit.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }



        $CommonModel = new CommonModel();

        $UserModel = new UserModel();
        $result = $UserModel->getUserById($id);


        if (count($result) > 0) {
            $result[0]['joining_date'] = date('d-m-Y', strtotime($result[0]['joining_date']));

            $data['user'] = $result;
            $data['department'] = $CommonModel->getData($table_name = 'department');
            return view('includes/header') . view('users/edit', $data) . view('includes/footer');
        } else {
            session()->setFlashdata("error", "Something went wrong, please try again!!");
            return redirect()->to(base_url() . '/users/list');
        }
    }

    public function userUpdate($e_id)
    {



        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $UserModel = new UserModel();
        $result = $UserModel->getUserById($id);



        $formattedDate = date('Y-m-d', strtotime($_POST['joining_date']));
        if (count($result) > 0) {
            if (isset($_POST['microsoft_365_business_licence']) && $_POST['microsoft_365_business_licence'] == 'Microsoft 365 Business Basic') {
                $microsoft_365_apps_for_business = isset($_POST['microsoft_365_apps_for_business_username']) ? trim($_POST['microsoft_365_apps_for_business_username']) . '@' . $_POST['microsoft_365_apps_for_business_domainname'] : '';
            } else {
                $microsoft_365_apps_for_business = '';
            }
            $data = array(
                'first_name' => isset($_POST['first_name']) ? trim($_POST['first_name']) : '',
                'last_name' => isset($_POST['last_name']) ? trim($_POST['last_name']) : '',
                'job_title' => isset($_POST['job_title']) ? trim($_POST['job_title']) : '',
                'department' => isset($_POST['department']) ? trim($_POST['department']) : '',
                'user_type' => isset($_POST['user_type']) ? trim($_POST['user_type']) : EMPLOYEE,
                'reporting_head' => isset($_POST['reporting_head']) ? trim($_POST['reporting_head']) : '',
                'user_work_location' => isset($_POST['user_work_location']) ? trim($_POST['user_work_location']) : '',
                'joining_date' => isset($formattedDate) ? trim($formattedDate) : '',
                'microsoft_365_business_licence' => isset($_POST['microsoft_365_business_licence']) ? trim($_POST['microsoft_365_business_licence']) : '',
                'microsoft_365_apps_for_business' => $microsoft_365_apps_for_business,
                'updated_date' => date('Y-m-d H:i:s'),
                'status' => isset($_POST['status']) ? trim($_POST['status']) : '',
                'updated_by' => session('user_id')
            );
            $last_id = $UserModel->update_data($id, $data);
            if ($last_id) {

                $CommonModel = new CommonModel();

                $log = $CommonModel->logCreate('UPDATE', 'User Updated : ' . $_POST['first_name'] . ' ' . $_POST['last_name'], );

                $check_accesses = $CommonModel->getSpecificDataByColumnName($table_name = 'user_accesses', $column_name = 'user_id', $value = $id, $select = 'id');

                if ($_POST['user_type'] == TECHNICIAN && count($check_accesses) == 0) {

                    $accesses = $CommonModel->getAllData($table_name = 'accesses');
                    foreach ($accesses as $access) {
                        $data_access = array(
                            'access_id' => $access['id'],
                            'user_id' => $id,
                            'created_date' => date('Y-m-d H:i:s'),
                            'created_by' => session('user_id')
                        );
                        $CommonModel->insert_data($table_name = 'user_accesses', $data_access);
                        // $userModelSecondDB->insert_data($table_name = 'user_accesses',$data_access);
                    }

                }

                if ($_POST['status'] == RESIGNED) {

                    $check_assign_assets = $UserModel->getAllAssignedDataByColumnName($table_name = 'user_assets', $column_name = 'user_id', $value = $id);

                    if (count($check_assign_assets) > 0) {
                        foreach ($check_assign_assets as $check_assign_asset) {
                            $data_user_assets = array(
                                'status' => REVOKE,
                                'reason' => isset($_POST['revoke_reason']) ? $_POST['revoke_reason'] : '',
                                'updated_date' => date('Y-m-d H:i:s'),
                                'updated_by' => session('user_id')
                            );
                            $CommonModel->update_data($table_name = 'user_assets', $check_assign_asset['id'], $data_user_assets);

                            $user_asset_data = $CommonModel->getUserAssetsByAssetId($check_assign_asset['asset_id']);
                            if (count($user_asset_data) == 0) {
                                $data_assets = array(
                                    'status' => ASSET_BUFFER,
                                    'updated_date' => date('Y-m-d H:i:s'),
                                    'updated_by' => session('user_id')
                                );
                                $CommonModel->update_data($table_name = 'assets', $check_assign_asset['asset_id'], $data_assets);
                            }
                        }
                    }
                    $check_assign_licenses = $UserModel->getAllAssignedDataByColumnName($table_name = 'user_licenses', $column_name = 'user_id', $value = $id);
                    if (count($check_assign_licenses) > 0) {
                        foreach ($check_assign_licenses as $check_assign_license) {
                            $data_user_licese = array(
                                'status' => REVOKE,
                                'reason' => isset($_POST['revoke_reason']) ? $_POST['revoke_reason'] : '',
                                'updated_date' => date('Y-m-d H:i:s'),
                                'updated_by' => session('user_id')
                            );
                            $CommonModel->update_data($table_name = 'user_licenses', $check_assign_license['id'], $data_user_licese);
                        }
                    }
                    $check_assign_applications = $UserModel->getAllAssignedDataByColumnName($table_name = 'user_applications', $column_name = 'user_id', $value = $id);
                    if (count($check_assign_applications) > 0) {
                        foreach ($check_assign_applications as $check_assign_application) {
                            $data_user_applications = array(
                                'status' => REVOKE,
                                'reason' => isset($_POST['revoke_reason']) ? $_POST['revoke_reason'] : '',
                                'updated_date' => date('Y-m-d H:i:s'),
                                'updated_by' => session('user_id')
                            );
                            $CommonModel->update_data($table_name = 'user_applications', $check_assign_application['id'], $data_user_applications);
                        }
                    }
                }
                session()->setFlashdata("success", "Updated successfully!!");
                $response['status'] = 'success';
                $response['message'] = 'Updated successfully!!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Something went wrong, please try again!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Something went wrong, please try again!!';
        }
        echo json_encode($response);
        exit;
    }

    public function changePassword($e_id)
    {
        if (!is_file(APPPATH . 'Views/users/change-password.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        if (session('user_type') == ADMIN) {
            $UserModel = new UserModel();
            $result = $UserModel->getUserById($id);
            if (count($result) > 0) {
                $data['user'] = $result;
                return view('includes/header') . view('users/change-password', $data) . view('includes/footer');
            }
        } else {
            session()->setFlashdata("error", "Only administrator has permission to perform this action");
            return redirect()->to(base_url() . '/users/list');
        }
    }

    public function updatePassword($e_id)
    {

        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }


        if (session('user_type') == ADMIN) {
            $UserModel = new UserModel();
            $result = $UserModel->getUserById($id);
            if (count($result) > 0) {
                if (trim($_POST['new_password']) == trim($_POST['confirm_password'])) {
                    $data = array(
                        'password' => md5(trim($_POST['new_password'])),
                    );
                    $last_id = $UserModel->update_data($id, $data);


                    if ($last_id) {
                        session()->setFlashdata("success", "Update successfully!!");
                        return redirect()->to(base_url() . '/users/list');
                    } else {
                        session()->setFlashdata("error", "Something went wrong, please try again!!");
                        return redirect()->to(base_url() . '/users/change-password/' . $id);
                    }
                } else {
                    session()->setFlashdata("error", "New password and confirm password does not match.");
                    return redirect()->to(base_url() . '/users/change-password/' . $id);
                }
            } else {
                session()->setFlashdata("error", "Something went wrong, please try again!!");
                return redirect()->to(base_url() . '/users/change-password/' . $id);
            }
        } else {
            session()->setFlashdata("error", "Only administrator has permission to perform this action");
            return redirect()->to(base_url() . '/users/list');
        }
    }

    public function userStatusChange($status, $e_id)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $UserModel = new UserModel();
        $result = $UserModel->getUserById($id);
        if (count($result) > 0 && $status != '') {

            if (session('user_type') == ADMIN) {
                $data = array(
                    'status' => $status,
                    'updated_by' => session('user_id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $last_id = $UserModel->update_data($id, $data);
                if ($last_id) {
                    session()->setFlashdata("success", "Status Update successfully!!");
                    return redirect()->to(base_url() . '/users/list');
                } else {
                    session()->setFlashdata("error", "Something went wrong, please try again!!");
                    return redirect()->to(base_url() . '/users/list');
                }
            } else {
                session()->setFlashdata("error", "This user is not in your list.");
                return redirect()->to(base_url() . '/users/list');
            }
        } else {
            session()->setFlashdata("error", "Something went wrong, please try again!!");
            return redirect()->to(base_url() . '/users/list');
        }
    }

    public function userFilter($page_no)
    {
        $request = service('request');
        $searchData = $request->getPost();
        // Get data
        $UserModel = new UserModel();
        $users = $UserModel->findAll();
        if (session('user_type') == ADMIN || session('user_type') == TECHNICIAN) {
            $user_type_array = array(ADMIN, TECHNICIAN, EMPLOYEE);
        } elseif (session('user_type') != ADMIN) {
            $user_type_array = array(EMPLOYEE);
        }
        if ($searchData['keyword'] == '') {
            $paginateData = $UserModel->whereIn('user_type', $user_type_array)->where('deleted_by', NULL)->where('user_type !=', 1)->paginate($searchData['show_per_page'], 'default', $page_no);
        } else {
            $where = "(first_name like '" . $searchData['keyword'] . "%' or email like '" . $searchData['keyword'] . "%')";
            $paginateData = $UserModel->select('*')
                ->where('deleted_by', NULL)
                ->whereIn('user_type', $user_type_array)
                ->where($where)
                ->where('user_type !=', 1)
                ->paginate($searchData['show_per_page'], 'default', $page_no);
        }
        $output = array(
            'paginateData' => $paginateData,
            'pager' => $UserModel->pager,
        );
        return view('users/filter_list', $output);
    }


    public function userExport()
    {
        if (!is_file(APPPATH . 'Views/users/export.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $data['department'] = $CommonModel->getData($table_name = 'department');
        return view('includes/header') . view('users/export', $data) . view('includes/footer');
    }

    public function userExportData()
    {

        $UserModel = new UserModel();
        $CommonModel = new CommonModel();
        $selectiveData = ['id', 'first_name', 'last_name', 'email', 'job_title', 'department', 'user_type', 'reporting_head', 'user_work_location', 'joining_date', 'microsoft_365_business_licence', 'microsoft_365_apps_for_business', 'status'];
        $db_data = $UserModel
            ->select($selectiveData)
            ->where('id !=', 1)->where('user.deleted_by', NULL);
        $request = service('request');
        $searchData = $request->getPost();
        if (isset($searchData['department']) && $searchData['department'] != '') {
            $db_data->whereIn('department', $_POST['department']);
        }
        $user_data = $db_data->findAll();
        if (count($user_data) <= 0) {
            session()->setFlashdata("error", "No Data Found!!");
            return redirect()->to(base_url() . '/users/export');
        }

        $data = [];
        foreach ($user_data as $data_fill) {
            if ($data_fill['user_work_location'] == WORK_LOCATION_OFFICE) {
                $data_fill['user_work_location'] = 'Office';
            } elseif ($data_fill['user_work_location'] == WORK_LOCATION_HOME) {
                $data_fill['user_work_location'] = 'Pune';
            } else {
                $data_fill['user_work_location'] = '';
            }

            if ($data_fill['department']) {
                $dept_info = $CommonModel->getDataByColumnName($table_name = 'department', $column_name = 'id', $value = $data_fill['department']);
                $data_fill['department'] = $dept_info[0]['name'];
            } else {
                $data_fill['department'] = '';
            }

            if ($data_fill['user_type'] == TECHNICIAN) {
                $data_fill['user_type'] = 'Technician';
            } elseif ($data_fill['user_type'] == EMPLOYEE) {
                $data_fill['user_type'] = 'Employee';
            } else {
                $data_fill['user_type'] = '';
            }

            if ($data_fill['status']) {

                if ($data_fill['status'] == ACTIVE) {
                    $data_fill['status'] = 'Active';
                } elseif ($data_fill['status'] == INACTIVE) {
                    $data_fill['status'] = 'Inactive';
                } elseif ($data_fill['status'] == RESIGNED) {
                    $data_fill['status'] = 'Resigned';
                }
            } else {
                $data_fill['status'] = '';
            }
            $data[] = $data_fill;
        }
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"user_report" . ".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');
        if (!empty($data)) {
            $firstDataArray = reset($data);
            $columnHeaders = array_keys($firstDataArray);
            fputcsv($handle, $columnHeaders);
        }

        foreach ($data as $data_array) {
            fputcsv($handle, $data_array);
        }

        $log = $CommonModel->logCreate('EXPORT', 'exported user list report , total count -' . count($data));


        fclose($handle);
        exit;

    }

    public function userAllotmentExport()
    {
        $UserModel = new UserModel();
        $CommonModel = new CommonModel();
        // $query = $UserModel->select('user.id,user.first_name,user.last_name,user.email,user.job_title,user.microsoft_365_business_licence,user.microsoft_365_apps_for_business,user.reporting_head,user.joining_date,user_assets.asset_id,user_licenses.license_id,user_applications.application_id,user_assets.created_date as asset_assigned_date,user_licenses.created_date as license_assigned_date,user_applications.created_date as application_assigned_date')
        //     ->join('user_assets', 'user_assets.user_id = user.id', 'left')
        //     ->join('user_applications', 'user_applications.user_id = user.id', 'left')
        //     ->join('user_licenses', 'user_licenses.user_id = user.id', 'left')
        //     ->where('user_assets.status', ASSIGNED)
        //     ->where('user_applications.status', ASSIGNED)
        //     ->where('user_licenses.status', ASSIGNED)
        //     ->where('user.deleted_by', NULL)
        //     ->orWhere('user_assets.user_id IS NOT NULL', null, false)
        //     ->orWhere('user_applications.user_id IS NOT NULL', null, false)
        //     ->orWhere('user_licenses.user_id IS NOT NULL', null, false)
        //     ->findAll();

        $query = $UserModel->select('user.id,user.first_name,user.last_name,user.email,user.job_title,user.microsoft_365_business_licence,user.microsoft_365_apps_for_business,user.reporting_head,user.joining_date,user_assets.asset_id,user_licenses.license_id,user_applications.application_id,user_assets.created_date as asset_assigned_date,user_licenses.created_date as license_assigned_date,user_applications.created_date as application_assigned_date')
            ->join('user_assets', 'user_assets.user_id = user.id AND user_assets.status = 1', 'left')
            ->join('user_applications', 'user_applications.user_id = user.id AND user_applications.status = 1', 'left')
            ->join('user_licenses', 'user_licenses.user_id = user.id AND user_licenses.status = 1', 'left')
            ->where('user.deleted_by', NULL)
            ->orWhere('user_assets.user_id IS NOT NULL', null, false)
            ->orWhere('user_applications.user_id IS NOT NULL', null, false)
            ->orWhere('user_licenses.user_id IS NOT NULL', null, false)
            ->findAll();


        if (count($query) <= 0) {
            session()->setFlashdata("error", "No Data Found!!");
            return redirect()->to(base_url() . '/users/list');
        }

        $modifiedArray = array_map(function ($subarray) {
            $subarray['name'] = $subarray['first_name'] . ' ' . $subarray['last_name'];
            unset($subarray['first_name'], $subarray['last_name']);
            return $subarray;
        }, $query);

        $groupedData = [];
        foreach ($modifiedArray as $row) {
            $user_id = $row['id'];
            $groupedData[$user_id][] = $row;
        }
        $data = [];
        function createFieldArray($fieldValues, $fieldName)
        {
            $resultArray = [];
            foreach ($fieldValues as $index => $value) {
                $resultArray[$fieldName] = $value;
            }
            return $resultArray;
        }
        foreach ($groupedData as $group_array) {

            $id = array_unique(array_column($group_array, 'id'));
            $name = array_unique(array_column($group_array, 'name'));
            $email = array_unique(array_column($group_array, 'email'));
            $job_title = array_unique(array_column($group_array, 'job_title'));
            $microsoft_365_business_licence = array_unique(array_column($group_array, 'microsoft_365_business_licence'));
            $microsoft_365_apps_for_business = array_unique(array_column($group_array, 'microsoft_365_apps_for_business'));
            $reporting_head = array_unique(array_column($group_array, 'reporting_head'));
            $joining_date = array_unique(array_column($group_array, 'joining_date'));
            $asset_id = array_unique(array_column($group_array, 'asset_id'));
            $license_id = array_unique(array_column($group_array, 'license_id'));
            $application_id = array_unique(array_column($group_array, 'application_id'));
            $asset_assigned_date = array_column($group_array, 'asset_assigned_date');
            $license_assigned_date = array_column($group_array, 'license_assigned_date');
            $application_assigned_date = array_column($group_array, 'application_assigned_date');

            $nameArray = createFieldArray($name, 'name');
            $emailArray = createFieldArray($email, 'email');
            $jobTitleArray = createFieldArray($job_title, 'job_title');
            $microsoft365BusinessLicenceArray = createFieldArray($microsoft_365_business_licence, 'microsoft_365_business_licence');
            $microsoft365AppsForBusinessArray = createFieldArray($microsoft_365_apps_for_business, 'microsoft_365_apps_for_business');
            $reportingHeadArray = createFieldArray($reporting_head, 'reporting_head');
            $joiningDateArray = createFieldArray($joining_date, 'joining_date');


            $assetTempArray = array_values($asset_id);
            $licenseTempArray = array_values($license_id);
            $applicationTempArray = array_values(array_filter($application_id));
            $assetAssignedDateTempArray = array_values($asset_assigned_date);
            $licenseAssignedDateTempArray = array_values($license_assigned_date);
            $applicationAssignedDateTempArray = array_values($application_assigned_date);

            $assetArray = [];

            if (isset($assetTempArray) && !empty($assetTempArray)) {

                for ($i = 0; $i < count($assetTempArray); $i++) {

                    if (count($assetAssignedDateTempArray) > 0 && !empty($assetTempArray[$i])) {

                        $asset_info = $CommonModel->getDataByColumnName($table_name = 'assets', $column_name = 'id', $value = $assetTempArray[$i]);
                        if (count($asset_info) > 0) {
                            $assetArray['asset_' . ($i + 1)] = $asset_info[0]['asset_id'];
                            $assetArray['asset_' . ($i + 1) . '_assigned_date'] = $assetAssignedDateTempArray[$i];
                        } else {
                            $assetArray['asset_' . ($i + 1)] = 'N/A';
                            $assetArray['asset_' . ($i + 1) . '_assigned_date'] = 'N/A';
                        }
                    }

                }
            }

            $licenseArray = [];

            if (isset($licenseTempArray) && !empty($licenseTempArray)) {

                for ($i = 0; $i < count($licenseTempArray); $i++) {

                    if (count($licenseAssignedDateTempArray) > 0 && !empty($licenseTempArray[$i])) {
                        $license_info = $CommonModel->getDataByColumnName($table_name = 'license', $column_name = 'id', $value = $licenseTempArray[$i]);
                        $license_name = $CommonModel->getDataByColumnName($table_name = 'license_name', $column_name = 'id', $value = $license_info[0]['license_name_id']);
                        $licenseArray['license_' . ($i + 1)] = $license_name[0]['name'];
                        $licenseArray['license_' . ($i + 1) . '_key'] = $license_info[0]['product_key'];
                        $licenseArray['license_' . ($i + 1) . '_assigned_date'] = $licenseAssignedDateTempArray[$i];
                    } else {
                        $licenseArray['license_' . ($i + 1)] = 'N/A';
                        $licenseArray['license_' . ($i + 1) . '_key'] = 'N/A';
                        $licenseArray['license_' . ($i + 1) . '_assigned_date'] = 'N/A';
                    }
                }

            }

            $applicationArray = [];


            if (isset($applicationTempArray) && !empty($applicationTempArray)) {
                for ($i = 0; $i < count($applicationTempArray); $i++) {


                    if (!empty($applicationTempArray[$i]) && !empty($applicationAssignedDateTempArray[$i])) {
                        $app_info = $CommonModel->getDataByColumnName($table_name = 'application', $column_name = 'id', $value = $applicationTempArray[$i]);

                        $applicationArray['application_' . ($i + 1)] = $app_info[0]['name'];
                        $applicationArray['application_' . ($i + 1) . '_assigned_date'] = $applicationAssignedDateTempArray[$i];
                    } else {

                        $applicationArray['application_' . ($i + 1)] = 'N/A';
                        $applicationArray['application_' . ($i + 1) . '_assigned_date'] = 'N/A';
                    }
                }
            }

            $data[] = array_merge($nameArray, $emailArray, $jobTitleArray, $microsoft365BusinessLicenceArray, $microsoft365AppsForBusinessArray, $reportingHeadArray, $joiningDateArray, $assetArray, $licenseArray, $applicationArray);

        }


        $allKeys = array_merge(...array_map('array_keys', $data));

        $headerKeys = array_unique($allKeys);


        $categoryOrder = array('asset', 'license', 'application');


        $categoryKeys = [];
        foreach ($headerKeys as $key) {
            preg_match('/^([a-zA-Z_]+)_?(\d*)/', $key, $matches);
            $category = $matches[1];
            $categoryKeys[$category][] = $key;
        }

        foreach ($categoryKeys as &$keys) {
            usort($keys, function ($a, $b) {
                preg_match('/^([a-zA-Z_]+)_?(\d*)/', $a, $aMatch);
                preg_match('/^([a-zA-Z_]+)_?(\d*)/', $b, $bMatch);
                return intval($aMatch[2]) - intval($bMatch[2]);
            });
        }


        $headerArray = array_merge(...array_values($categoryKeys));

        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"allotment_report" . ".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');

        $columnHeaders = array_values($headerArray);

        fputcsv($handle, $columnHeaders);



        foreach ($data as $data_array) {

            $orderedData = array();


            foreach ($columnHeaders as $header) {
                $orderedData[$header] = isset($data_array[$header]) ? $data_array[$header] : '';
            }

            foreach ($orderedData as $field => &$value) {
                if (empty($value)) {
                    $value = "N/A";
                }
            }

            fputcsv($handle, $orderedData);

        }

        fclose($handle);
        $log = $CommonModel->logCreate('EXPORT', 'exported user allotment report , total count -' . count($data));

        exit;

        // die;
    }

    public function userDelete()
    {

        if (empty($_POST['user_id'])) {

            $response['status'] = 'error';
            $response['message'] = 'something went wrong!!';
            echo json_encode($response);
        }
        $UserAssetsModel = new UserAssetsModel();
        $UserLicensesModel = new UserLicensesModel();
        $UserApplicationsModel = new UserApplicationsModel();

        $assetCount = $UserAssetsModel->select('id')->where('user_id', $_POST['user_id'])->where('status', 1)->findAll();
        $licenseCount = $UserLicensesModel->select('id')->where('user_id', $_POST['user_id'])->where('status', 1)->findAll();
        // $applicationCount = $UserApplicationsModel->select('id')->where('user_id', $_POST['user_id'])->where('status', 1)->findAll();


        if (count($assetCount) > 0 || count($licenseCount) > 0 ) {
            $response['status'] = 'error';
            $response['message'] = 'Cannot delete user , User has something allocated , check details !!';

        } else {
            $CommonModel = new CommonModel();
            $data = array(
                'deleted_date' => date('Y-m-d H:i:s'),
                'deleted_by' => session('user_id'),
            );

            $user_info = $CommonModel->update_data($table_name = 'user', $id = $_POST['user_id'], $value = $data);

            if ($user_info) {
                $user_details = $CommonModel->getSpecificDataByColumnName($table_name = 'user', $column_name = 'id', $value = $_POST['user_id'], $select = 'first_name,last_name');
                $log = $CommonModel->logCreate('DELETE', 'User Deleted -'. $user_details[0]['first_name'] . ' ' . $user_details[0]['last_name']);
                $response['status'] = 'success';
                $response['message'] = 'deleted successfully!!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'something went wrong, please try again!!';
            }

        }
        echo json_encode($response);

    }
}
