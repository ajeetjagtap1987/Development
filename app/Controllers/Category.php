<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CategoryModel;
use App\Models\CommonModel;


class Category extends Controller
{

    function __construct()
    {
        $user_id = session('user_id');
        if (!$user_id) {
            header('Location: ' . base_url() . '/login');
            exit;
        }
        if (!in_array(ACCESS_CATEGORY, session('user_access'))) {
            header('Location: ' . base_url());
            exit;
        }
    }


    // public function gettoken(){

    //     $CommonModel = new CommonModel();
    // return  $CommonModel->token();
    // }

    public function list()
    {
        $csrfToken = csrf_hash();

        if (!is_file(APPPATH . 'Views/category/list.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return view('includes/header') . view('category/list', compact('csrfToken')) . view('includes/footer');
    }



    public function create()
    {
        if (!is_file(APPPATH . 'Views/category/create.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        return view('includes/header') . view('category/create') . view('includes/footer');
    }

    public function categoryInsert()
    {
        $category_name = isset($_POST['category_name']) ? $_POST['category_name'] : '';
        $CommonModel = new CommonModel();
        $checkdata = $CommonModel->getAllDataByColumnName($table_name = 'category', $column_name = 'category_name', $value = $category_name);
        if (count($checkdata) == 0) {
            $data = array(
                'category_name' => isset($_POST['category_name']) ? trim($_POST['category_name']) : '',
                'category_type' => isset($_POST['category_type']) ? trim($_POST['category_type']) : '',
                'user_assign_limit' => isset($_POST['user_assign_limit']) ? trim($_POST['user_assign_limit']) : '',
                'status' => ACTIVE,
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => session('user_id')
            );
            $last_id = $CommonModel->insert_data($table_name = 'category', $data);
            if ($last_id) {
                $log = $CommonModel->logCreate('ADD', 'Inserted new Category -' . $_POST['category_name']);

                session()->setFlashdata("success", "Created successfully!!");
                $response['status'] = 'success';
                $response['message'] = 'Created successfully!!';


            } else {
                $response['status'] = 'error';
                $response['message'] = 'Something went wrong, please try again!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Category name already exists!!';

        }
        echo json_encode($response);
        exit;

    }

    public function edit($e_id)
    {
        if (!is_file(APPPATH . 'Views/category/edit.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'category', $id);
        if (count($result) > 0) {
            $data['category'] = $result;

            return view('includes/header') . view('category/edit', $data) . view('includes/footer');
        } else {
            session()->setFlashdata("error", "Something went wrong, please try again!!");
            return redirect()->to(base_url() . '/category/list');
        }
    }

    public function categoryUpdate($e_id)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'category', $id);
        if (count($result) > 0) {
            $category_name = isset($_POST['category_name']) ? $_POST['category_name'] : '';
            if ($result[0]['category_name'] != $category_name) {
                $checkdata = $CommonModel->getAllDataByColumnName($table_name = 'category', $column_name = 'category_name', $value = $category_name);
            } else {
                $checkdata = array();
            }
            if (count($checkdata) == 0) {
                $data = array(
                    'category_name' => isset($_POST['category_name']) ? trim($_POST['category_name']) : '',
                    'user_assign_limit' => isset($_POST['user_assign_limit']) ? trim($_POST['user_assign_limit']) : '',
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => session('user_id')
                );


                $CommonModel->update_data($table_name = 'category', $id, $data);

                $log = $CommonModel->logCreate('UPDATE', 'Category Updated -' . $_POST['category_name']);
                session()->setFlashdata("success", "Updated successfully!!");
                $response['status'] = 'success';
                $response['message'] = 'Updated successfully!!';

            } else {
                $response['status'] = 'error';
                $response['message'] = 'Category name already exists!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Something went wrong, please try again!!';
        }
        echo json_encode($response);
        exit;
    }


    public function categoryFilter($page_no)
    {

        $csrfToken = csrf_hash();


        $request = service('request');
        $searchData = $request->getPost();


        // Get data
        $CategoryModel = new CategoryModel();
        if ($searchData['keyword'] == '') {
            $paginateData = $CategoryModel->where('deleted_by', NULL)->paginate($searchData['show_per_page'], 'default', $page_no);

        } else {
            $where = "(category_name like '" . $searchData['keyword'] . "%')";
            $paginateData = $CategoryModel->select('*')
                ->where('deleted_by', NULL)
                ->where($where)
                ->paginate($searchData['show_per_page'], 'default', $page_no);
        }

        $output = array(
            'paginateData' => $paginateData,
            'pager' => $CategoryModel->pager,

            'csrfToken' => $csrfToken,
        );


        return view('category/filter_list', $output);

    }

}