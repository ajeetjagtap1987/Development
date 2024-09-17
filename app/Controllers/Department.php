<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\AssetsModel;
use App\Models\CommonModel;


class ImportData extends Controller
{

    function __construct(){ 
        $user_id = session('user_id');
        if(!$user_id){
            header('Location: '.base_url().'/login');
            exit;
        }
        if(!in_array( ACCESS_ASSETS, session('user_access'))){
             header('Location: '.base_url());
            exit;
        }
    } 

    public function index()
    {
        if (! is_file(APPPATH . 'Views/import/index.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
		

        return view('includes/header').view('department/list').view('includes/footer');
    }


    public function departmentFilter( $page_no ) {

        $csrfToken = csrf_hash();
        

        $request = service('request');
        $searchData = $request->getPost();


        // Get data 
        $CategoryModel = new DepartmentModel();
        if ($searchData['keyword'] == '') {
            $paginateData = $CategoryModel->where('deleted_by',NULL)->paginate($searchData['show_per_page'],'default',$page_no);

        } else {
            $where = "(category_name like '".$searchData['keyword']."%')";
            $paginateData = $CategoryModel->select('*')
                ->where('deleted_by',NULL)
                ->where($where)             
                ->paginate($searchData['show_per_page'],'default',$page_no);
        }

        $output =array(
            'paginateData' => $paginateData,
            'pager' => $CategoryModel->pager,
           
            'csrfToken' => $csrfToken, 
        );

   
        return view('category/filter_list',$output);

    }
}