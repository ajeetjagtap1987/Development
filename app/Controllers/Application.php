<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ApplicationModel;
use App\Models\CommonModel;

class Application extends Controller
{

    function __construct()
    {
        $user_id = session('user_id');
        if (!$user_id) {
            header('Location: ' . base_url() . '/login');
            exit;
        }
        if (!in_array(ACCESS_APPLICATION, session('user_access'))) {
            header('Location: ' . base_url());
            exit;
        }
    }
    public function list()
    {
        if (!is_file(APPPATH . 'Views/application/list.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return view('includes/header') . view('application/list') . view('includes/footer');
    }

    public function create()
    {
        if (!is_file(APPPATH . 'Views/application/create.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $data['category'] = $CommonModel->getAllDataByColumnName($table_name = 'category', $column_name = 'category_type', $value = CATEGORY_APPLICATION);
        return view('includes/header') . view('application/create', $data) . view('includes/footer');
    }

    public function applicationInsert()
    {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $CommonModel = new CommonModel();
        $checkdata = $CommonModel->getAllDataByColumnName($table_name = 'application', $column_name = 'name', $value = $name);
        if (count($checkdata) == 0) {
            $data = array(
                'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
                'category_id' => isset($_POST['category_id']) ? trim($_POST['category_id']) : '',
                'status' => ACTIVE,
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => session('user_id')
            );
            $last_id = $CommonModel->insert_data($table_name = 'application', $data);
            if ($last_id) {

                $log = $CommonModel->logCreate('ADD', 'Inserted new Application-' . $_POST['name']);

                session()->setFlashdata("success", "Created successfully!!");
                $response['status'] = 'success';
                $response['message'] = 'Created successfully!!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Something went wrong, please try again!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Application name already exists!!';

        }
        echo json_encode($response);
        exit;

    }

    public function edit($e_id)
    {
        if (!is_file(APPPATH . 'Views/application/edit.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'application', $id);
        if (count($result) > 0) {
            $data['application'] = $result;
            $data['category'] = $CommonModel->getAllDataByColumnName($table_name = 'category', $column_name = 'category_type', $value = CATEGORY_APPLICATION);

            return view('includes/header') . view('application/edit', $data) . view('includes/footer');
        } else {
            session()->setFlashdata("error", "Something went wrong, please try again!!");
            return redirect()->to(base_url() . '/application/list');
        }
    }

    public function applicationUpdate($e_id)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'application', $id);
        if (count($result) > 0) {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            if ($result[0]['name'] != $name) {
                $checkdata = $CommonModel->getAllDataByColumnName($table_name = 'application', $column_name = 'name', $value = $name);
            } else {
                $checkdata = array();
            }
            if (count($checkdata) == 0) {
                $data = array(
                    'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
                    'category_id' => isset($_POST['category_id']) ? trim($_POST['category_id']) : '',
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => session('user_id')
                );
                $CommonModel->update_data($table_name = 'application', $id, $data);

                $log = $CommonModel->logCreate('UPDATE', 'Application Updated-' . $_POST['name']);

                session()->setFlashdata("success", "Updated successfully!!");
                $response['status'] = 'success';
                $response['message'] = 'Updated successfully!!';

            } else {
                $response['status'] = 'error';
                $response['message'] = 'Application name already exists!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Something went wrong, please try again!!';
        }
        echo json_encode($response);
        exit;
    }


    public function applicationFilter($page_no)
    {

        $request = service('request');
        $searchData = $request->getPost();
        $csrfToken = csrf_hash();
        // Get data
        $ApplicationModel = new ApplicationModel();
        if ($searchData['keyword'] == '') {
            $paginateData = $ApplicationModel->where('deleted_by', NULL)->paginate($searchData['show_per_page'], 'default', $page_no);

        } else {
            $where = "(name like '" . $searchData['keyword'] . "%')";
            $paginateData = $ApplicationModel->select('*')
                ->where('deleted_by', NULL)
                ->where($where)
                ->paginate($searchData['show_per_page'], 'default', $page_no);
        }

        $output = array(
            'paginateData' => $paginateData,
            'pager' => $ApplicationModel->pager,
            'csrfToken' => $csrfToken,
        );
        return view('application/filter_list', $output);

    }

    public function applicationAutocomplete()
    {
        $searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';
        $data = [];
        if (!empty($searchTerm)) {
            $ApplicationModel = new ApplicationModel();
            $licenses = $ApplicationModel->getApplicationDataByName($searchTerm);
            if (count($licenses) > 0) {
                foreach ($licenses as $license) {
                    $data[] = ['id' => $license['id'], 'text' => $license['name']];
                }
            }
        }
        echo json_encode($data);
    }

    public function applicationDelete()
    {
        if (empty($_POST['applicatioin_id'])) {
            $response['status'] = 'error';
            $response['message'] = 'something went wrong!!';
            echo json_encode($response);
        }
        $CommonModel = new CommonModel();
        $license_assign_info = $CommonModel->getUserApplicationByAppId($_POST['applicatioin_id']);
        if (count($license_assign_info) > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Cannot delete application , application status is assigned!!';
        } else {
            $data = array(
                'deleted_date' => date('Y-m-d H:i:s'),
                'deleted_by' => session('user_id'),
            );
            $asset_info = $CommonModel->update_data($table_name = 'application', $id = $_POST['applicatioin_id'], $value = $data);
            $app_info = $CommonModel->getDataByColumnName($table_name = 'application', $column_name = 'id', $value = $_POST['applicatioin_id']);
            $log = $CommonModel->logCreate('DELETE', 'Application Deleted-' . " " . $app_info[0]['name']);
            $response['status'] = 'success';
            $response['message'] = 'deleted successfully!!';
        }
        echo json_encode($response);
    }

}