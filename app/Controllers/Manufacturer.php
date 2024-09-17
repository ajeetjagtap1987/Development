<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ManufacturerModel;
use App\Models\CommonModel;

class Manufacturer extends Controller
{

    function __construct()
    {
        $user_id = session('user_id');
        if (!$user_id) {
            header('Location: ' . base_url() . '/login');
            exit;
        }
        if (!in_array(ACCESS_MANUFACTURER, session('user_access'))) {
            header('Location: ' . base_url());
            exit;
        }
    }
    public function list()
    {
        if (!is_file(APPPATH . 'Views/manufacturer/list.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return view('includes/header') . view('manufacturer/list') . view('includes/footer');
    }

    public function create()
    {
        if (!is_file(APPPATH . 'Views/manufacturer/create.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        return view('includes/header') . view('manufacturer/create') . view('includes/footer');
    }

    public function manufacturerInsert()
    {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $CommonModel = new CommonModel();
        $checkdata = $CommonModel->getAllDataByColumnName($table_name = 'manufacturer', $column_name = 'name', $value = $name);
        if (count($checkdata) == 0) {
            $data = array(
                'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
                'status' => ACTIVE,
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => session('user_id')
            );
            $last_id = $CommonModel->insert_data($table_name = 'manufacturer', $data);
            if ($last_id) {

                $log = $CommonModel->logCreate('ADD', 'Inserted new Manufacturer -' . $_POST['name']);

                session()->setFlashdata("success", "Created successfully!!");
                $response['status'] = 'success';
                $response['message'] = 'Created successfully!!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Something went wrong, please try again!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Name already exists!!';

        }
        echo json_encode($response);
        exit;

    }

    public function edit($e_id)
    {
        if (!is_file(APPPATH . 'Views/manufacturer/edit.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'manufacturer', $id);
        if (count($result) > 0) {
            $data['manufacturer'] = $result;

            return view('includes/header') . view('manufacturer/edit', $data) . view('includes/footer');
        } else {
            session()->setFlashdata("error", "Something went wrong, please try again!!");
            return redirect()->to(base_url() . '/manufacturer/list');
        }
    }

    public function manufacturerUpdate($e_id)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'manufacturer', $id);
        if (count($result) > 0) {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            if ($result[0]['name'] != $name) {
                $checkdata = $CommonModel->getAllDataByColumnName($table_name = 'manufacturer', $column_name = 'name', $value = $name);
            } else {
                $checkdata = array();
            }
            if (count($checkdata) == 0) {
                $data = array(
                    'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => session('user_id')
                );
                $CommonModel->update_data($table_name = 'manufacturer', $id, $data);

                $log = $CommonModel->logCreate('UPDATE', 'Manufacturer Updated -' . $_POST['name']);

                session()->setFlashdata("success", "Updated successfully!!");
                $response['status'] = 'success';
                $response['message'] = 'Updated successfully!!';

            } else {
                $response['status'] = 'error';
                $response['message'] = 'Name already exists!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Something went wrong, please try again!!';
        }
        echo json_encode($response);
        exit;
    }


    public function manufacturerFilter($page_no)
    {

        $csrfToken = csrf_hash();
        // echo csrf_hash();die;
        $request = service('request');
        $searchData = $request->getPost();
        //$output['token'] = csrf_hash();
        // Get data 
        $ManufacturerModel = new ManufacturerModel();
        if ($searchData['keyword'] == '') {
            $paginateData = $ManufacturerModel->where('deleted_by', NULL)->paginate($searchData['show_per_page'], 'default', $page_no);

        } else {
            $where = "(name like '" . $searchData['keyword'] . "%')";
            $paginateData = $ManufacturerModel->select('*')
                ->where('deleted_by', NULL)
                ->where($where)
                ->paginate($searchData['show_per_page'], 'default', $page_no);
        }

        $output = array(
            'paginateData' => $paginateData,
            'pager' => $ManufacturerModel->pager,
            'csrfToken' => $csrfToken,
        );
        return view('manufacturer/filter_list', $output);

    }

}