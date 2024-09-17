<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LogModel;
use App\Models\CommonModel;


class Log extends Controller
{

    function __construct()
    {

        if (session('user_type') != ADMIN) {
            header('Location: ' . base_url() . '/login');
            exit;
        }

    }

    public function index()
    {
        $CommonModel = new CommonModel();
        $data['user'] = $CommonModel->getSelectiveActiveAdminTech($table_name = 'user','id,first_name,last_name');
        $csrfToken = csrf_hash();
        return view('includes/header') . view('log/list',$data) . view('includes/footer');
    }


    public function logFilter($page_no)
    {
        $csrfToken = csrf_hash();

        $LogModel = new LogModel();
        $request = service('request');
        $searchData = $request->getPost();

     if (isset($searchData['created_at']) && $searchData['created_at'] != '') {
            $str = explode(" - ", $searchData['created_at']);
            $str1 = str_replace("/", "-", trim($str[0]));
            $str2 = str_replace("/", "-", trim($str[1]));
            $paginateData = $LogModel->where('date(created_at) >=', $str1)->where('date(created_at) <=', $str2);

        }

        if (isset($searchData['action_by']) && $searchData['action_by'] != '') {
            $paginateData = $LogModel->where("JSON_EXTRACT(log, '$.action_by')", $searchData['action_by']);
        }

        $paginateData = $LogModel->orderBy('id DESC')->paginate($searchData['show_per_page'], 'default', $page_no);

        $output = array(
            'paginateData' => $paginateData,
            'pager' => $LogModel->pager,
            'csrfToken' => $csrfToken,
        );

        return view('log/filter_list', $output);

    }

}