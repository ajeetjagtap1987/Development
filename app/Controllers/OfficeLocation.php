<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\OfficeLocationModel;
use App\Models\CommonModel;

class OfficeLocation extends Controller
{

    function __construct()
    {
        $user_id = session('user_id');
        if (!$user_id) {
            header('Location: ' . base_url() . '/login');
            exit;
        }
        if (!in_array(ACCESS_OFFICE_LOCATION, session('user_access'))) {
            header('Location: ' . base_url());
            exit;
        }
    }
    public function list()
    {
        if (!is_file(APPPATH . 'Views/office_location/list.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return view('includes/header') . view('office_location/list') . view('includes/footer');
    }

    public function create()
    {
        if (!is_file(APPPATH . 'Views/office_location/create.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $CommonModel = new CommonModel();
        $data['country'] = $CommonModel->getData($table_name = 'country');

        return view('includes/header') . view('office_location/create', $data) . view('includes/footer');
    }

    public function officeLocationInsert()
    {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $CommonModel = new CommonModel();
        $checkdata = $CommonModel->getAllDataByColumnName($table_name = 'office_location', $column_name = 'name', $value = $name);
        if (count($checkdata) == 0) {
            $data = array(
                'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
                'address' => isset($_POST['address']) ? trim($_POST['address']) : '',
                'country' => isset($_POST['country']) ? trim($_POST['country']) : '',
                'status' => ACTIVE,
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => session('user_id')
            );
            $last_id = $CommonModel->insert_data($table_name = 'office_location', $data);
            if ($last_id) {

                $log = $CommonModel->logCreate('ADD', ' Inserted new Office Loacation -' . $_POST['name']);

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
        if (!is_file(APPPATH . 'Views/office_location/edit.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'office_location', $id);
        $data['country'] = $CommonModel->getData($table_name = 'country');
        if (count($result) > 0) {
            $data['office_location'] = $result;

            return view('includes/header') . view('office_location/edit', $data) . view('includes/footer');
        } else {
            session()->setFlashdata("error", "Something went wrong, please try again!!");
            return redirect()->to(base_url() . '/office_location/list');
        }
    }

    public function officeLocationUpdate($e_id)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'office_location', $id);
        if (count($result) > 0) {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            if ($result[0]['name'] != $name) {
                $checkdata = $CommonModel->getAllDataByColumnName($table_name = 'office_location', $column_name = 'name', $value = $name);
            } else {
                $checkdata = array();
            }
            if (count($checkdata) == 0) {
                $data = array(
                    'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
                    'address' => isset($_POST['address']) ? trim($_POST['address']) : '',
                    'country' => isset($_POST['country']) ? trim($_POST['country']) : '',
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => session('user_id')
                );
                $CommonModel->update_data($table_name = 'office_location', $id, $data);

                $log = $CommonModel->logCreate('UPDATE', 'Office Loaction Updated -' . $_POST['name']);

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


    public function officeLocationFilter($page_no)
    {
        $csrfToken = csrf_hash();
        $request = service('request');
        $searchData = $request->getPost();
        // Get data 
        $OfficeLocationModel = new OfficeLocationModel();
        if ($searchData['keyword'] == '') {


            $paginateData = $OfficeLocationModel
                ->select('office_location.*, country.*, office_location.name as office_location_name, country.name as country_name, office_location.id as office_location_id, country.id as country_id')
                ->join('country', 'office_location.country = country.id', 'left')
                ->where('office_location.deleted_by', NULL)
                ->paginate($searchData['show_per_page'], 'default', $page_no);

            // $paginateData = $OfficeLocationModel->where('deleted_by',NULL)->paginate($searchData['show_per_page'],'default',$page_no);

        } else {
            $where = "(office_location.name like '" . $searchData['keyword'] . "%')";
            // $paginateData = $OfficeLocationModel->select('*')
            //     ->where('deleted_by',NULL)
            //     ->where($where)             
            //     ->paginate($searchData['show_per_page'],'default',$page_no);


            $paginateData = $OfficeLocationModel
                ->select('office_location.*, country.*, office_location.name as office_location_name, country.name as country_name, office_location.id as office_location_id, country.id as country_id')
                ->join('country', 'office_location.country = country.id', 'left')
                ->where('deleted_by', NULL)
                ->where($where)
                ->paginate($searchData['show_per_page'], 'default', $page_no);



        }

        $output = array(
            'paginateData' => $paginateData,
            'pager' => $OfficeLocationModel->pager,
            'csrfToken' => $csrfToken,
        );
        return view('office_location/filter_list', $output);

    }

}