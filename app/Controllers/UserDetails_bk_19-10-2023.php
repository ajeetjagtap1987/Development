<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\UserAssetsModel;
use App\Models\UserLicensesModel;
use App\Models\UserApplicationsModel;
use App\Models\CommonModel;
use App\Models\LicenseModel;


class UserDetails extends Controller
{

    function __construct(){ 
        $user_id = session('user_id');
        if(!$user_id){
            header('Location: '.base_url().'/login');
            exit;
        }
        if(!in_array( ACCESS_USER, session('user_access'))){
             header('Location: '.base_url());
            exit;
        }
    } 

    public function list($e_id)
    {
        if (! is_file(APPPATH . 'Views/users/details.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id=$encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $UserModel = new UserModel();
        $result =  $UserModel->getUserById($id);
        if(count($result) > 0){
            $data['user'] = $result;
            $CommonModel = new CommonModel();
            $data['category'] =  $CommonModel->getAllDataByColumnName($table_name='category',$column_name='category_type',$value=CATEGORY_ASSET);
            $data['application'] =  $CommonModel->getSelectiveData($table_name='application',$column_name='id,name');
            $data['license'] =  $CommonModel->getSelectiveData($table_name='license_name',$column_name='id,name');
            // $UserLicenseModel = new LicenseModel();
            // $license = $UserLicenseModel
            // ->select('license.*, application.*, license.software_name as software')
            // ->join('application', 'license.software_name = application.id', 'left')
            // ->findAll();
          
            // $data['license'] =   $license;
           
            return view('includes/header').view('users/details',$data).view('includes/footer');
        }else{
            session()->setFlashdata("error", "Something went wrong, please try again!!"); 
            return redirect()->to(base_url().'/users/list');
        }
    }


    
    
    public function userAssetsFilter( $page_no ) {

        $request = service('request');
        $searchData = $request->getPost();
        $UserAssetsModel = new UserAssetsModel();
        $paginateData = $UserAssetsModel->select('user_assets.*,assets.*,user_assets.id,user_assets.asset_id,user_assets.user_id,user_assets.created_date,assets.asset_id as a_asset_id,assets.id as a_id')->join('assets', 'user_assets.asset_id = assets.id', 'left')->where('user_assets.user_id',$searchData['user_id'])->where('user_assets.status',ASSIGNED);
        if ($searchData['keyword'] != '') {
            $paginateData = $UserAssetsModel->like('assets.model_name', trim($searchData['keyword']), 'both')->orLike('assets.asset_id', trim($searchData['keyword']));
        }
        $query  = $paginateData->get();
        $paginateData = $query->getResultArray();
        $output =array(
            'paginateData' => $paginateData,
        );
        return view('users/user_assets_filter_list',$output);

    }

    public function userAssetsAssign($e_id)
    {

       
        try {
            $encrypter = \Config\Services::encrypter();
            $u_id=$encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $asset_id = isset($_POST['asset_id']) ? $_POST['asset_id'] : '';

        if($asset_id){
            foreach($asset_id as $a_id){
             
            
        

        $CommonModel = new CommonModel(); 
        $checkassets =  $CommonModel->getAllDataByColumnName($table_name='assets',$column_name='id',$value=$a_id);
        if(count($checkassets)>0){
            $checkcategory =  $CommonModel->getAllDataByColumnName($table_name='category',$column_name='id',$value=$checkassets[0]['category_id']);
            $user_asset_data =  $CommonModel->getUserAssetsByAssetId($a_id);
            if(count($user_asset_data)>=$checkcategory[0]['user_assign_limit'] && count($user_asset_data)==$checkcategory[0]['user_assign_limit']){
                $response['status']='error';
                $response['message']='Assets already assigned for '.$checkcategory[0]['user_assign_limit'].' users';
            }else{
                $user_asset_assigned =  $CommonModel->checkUserAssetsAssigned($u_id,$a_id);
                if(count($user_asset_assigned)>0){
                    $response['status']='error';
                    $response['message']='Assets already assigned for this user';
                }else{
                    $data = array(
                        'user_id' => $u_id,
                        'asset_id' => isset($a_id) ? trim($a_id) : '',
                        'status' => ASSIGNED,
                        'created_date' => date('Y-m-d H:i:s'),
                        'created_by' => session('user_id')
                    );
                    $last_id =  $CommonModel->insert_data($table_name='user_assets',$data);
                    if($last_id){
                        $data_assets = array(
                            'status' => ASSET_ASSIGN,
                            'updated_date' => date('Y-m-d H:i:s'),
                            'updated_by' => session('user_id')
                        );
                        $CommonModel->update_data( $table_name = 'assets',$a_id, $data_assets);
                        session()->setFlashdata("success", "Created successfully!!");
                        $response['status']='success';
                        $response['message']='Created successfully!!';
                    }else{
                        $response['status']='error';
                        $response['message']='Something went wrong, please try again!!';
                    } 
                } 
            }
            
        }else{
            $response['status']='error';
            $response['message']='Something went wrong, please try again!!';

        }
    }  }
        echo json_encode($response);
        exit;
        
    }

    public function userAssetsRevoke($e_id)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            $u_id=$encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $user_asset_id = isset($_POST['user_asset_id']) ? $_POST['user_asset_id'] : '';
        $CommonModel = new CommonModel();
        $checkdata =  $CommonModel->getAllDataByColumnName($table_name='user_assets',$column_name='id',$value=$user_asset_id);
        if(count($checkdata) > 0){
            if($checkdata[0]['user_id'] == $u_id){
                if($checkdata[0]['status'] == ASSIGNED){
                    $data_user_assets = array(
                                    'status' => REVOKE,
                                    'reason' => isset($_POST['revoke_reason']) ? $_POST['revoke_reason'] : '',
                                    'updated_date' => date('Y-m-d H:i:s'),
                                    'updated_by' => session('user_id')
                                );
                    $CommonModel->update_data( $table_name = 'user_assets', $user_asset_id, $data_user_assets);

                    $user_asset_data =  $CommonModel->getUserAssetsByAssetId($checkdata[0]['asset_id']);
                    if(count($user_asset_data)==0){
                        $data_assets = array(
                            'status' => ASSET_BUFFER,
                            'updated_date' => date('Y-m-d H:i:s'),
                            'updated_by' => session('user_id')
                        );
                        $CommonModel->update_data( $table_name = 'assets', $checkdata[0]['asset_id'], $data_assets);
                    }
                    session()->setFlashdata("success", "Asset revoked successfully!!");
                    $response['status']='success';
                    $response['message']='Asset revoked successfully!!';
                }else{
                    $response['status']='error';
                    $response['message']='Asset already revoked. Please reload the page and check it!!';
                }
            }else{
                $response['status']='error';
                $response['message']='Something went wrong, please try again!!';
            }
            
        }else{
            $response['status']='error';
            $response['message']='Something went wrong, please try again!!';

        }
        echo json_encode($response);
        exit;
        
    }
    public function userLicensesFilter( $page_no ) {

        $request = service('request');
        $searchData = $request->getPost();
        $UserLicensesModel = new UserLicensesModel();
        // $paginateData = $UserLicensesModel->select('user_licenses.*,license.*,user_licenses.id,user_licenses.license_id,user_licenses.user_id,user_licenses.created_date,license.id as l_id')->join('license', 'user_licenses.license_id = license.id', 'left')->where('user_licenses.user_id',$searchData['user_id'])->where('user_licenses.status',ASSIGNED);
       
        $paginateData = $UserLicensesModel
        ->select('user_licenses.*, license.*, user_licenses.id as ul_id, user_licenses.license_id, user_licenses.user_id, user_licenses.created_date, license.id as l_id, license_name.*')
        ->join('license', 'user_licenses.license_id = license.id', 'left')
        ->join('license_name', 'license_name.id = license.license_name_id', 'left')
        ->where('user_licenses.user_id', $searchData['user_id'])
        ->where('user_licenses.status', ASSIGNED);
      


        if ($searchData['keyword'] != '') {
            $paginateData = $UserLicensesModel->like('license_name.name', trim($searchData['keyword']), 'both');
        }
        $query  = $paginateData->get();
        $paginateData = $query->getResultArray();
     
        $output =array(
            'paginateData' => $paginateData,
        );

        
        return view('users/user_licenses_filter_list',$output);

    }


    public function licenseGetKeys(){

        $request = service('request');
        $searchData = $request->getPost();

        $software=$searchData['software'];
        $CommonModel = new CommonModel();
        $result = $CommonModel->getSpecificDataByColumnName($table_name = 'license', $column_name = 'license_name_id',$value=$software,$select='id,product_key');

       
        echo json_encode($result);

    }

    public function userLicensesAssign($e_id)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            $u_id=$encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }


        $license_ids = isset($_POST['license_id']) ? $_POST['license_id'] : (isset($_POST['no_product_key_license']) ? (array)$_POST['no_product_key_license'] : []);

      

        $CommonModel = new CommonModel();
        if($license_ids){

           

            foreach($license_ids as $license){
        $checklicense =  $CommonModel->getAllDataByColumnName($table_name='license',$column_name='id',$value=$license);
        if(count($checklicense)>0){
            $user_licence_data =  $CommonModel->getUserLicenseByLicenseId($license);
            if(count($user_licence_data)>=$checklicense[0]['user_limit'] && count($user_licence_data)==$checklicense[0]['user_limit']){
                $response['status']='error';
                $response['message']='License already assigned for '.$checklicense[0]['user_limit'].' users';
            }else{
                $user_license_assigned =  $CommonModel->checkUserLicenseAssigned($u_id,$license);
                if(count($user_license_assigned)>0){
                    $response['status']='error';
                    $response['message']='License already assigned for this user';
                }else{
                    $data = array(
                        'user_id' => $u_id,
                        'license_id' => isset($license) ? trim($license) : '',
                        'status' => ASSIGNED,
                        'created_date' => date('Y-m-d H:i:s'),
                        'created_by' => session('user_id')
                    );
                    $last_id =  $CommonModel->insert_data($table_name='user_licenses',$data);
                    if($last_id){
                        session()->setFlashdata("success", "Created successfully!!");
                        $response['status']='success';
                        $response['message']='Created successfully!!';
                    }else{
                        $response['status']='error';
                        $response['message']='Something went wrong, please try again!!';
                    } 
                } 
            }
            
        }else{
            $response['status']='error';
            $response['message']='Something went wrong, please try again!!';

        }
    }}
        echo json_encode($response);
        exit;
        
    }
    public function userLicensesRevoke($e_id)
    {

     
        try {
            $encrypter = \Config\Services::encrypter();
            $u_id=$encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $user_license_id = isset($_POST['user_license_id']) ? $_POST['user_license_id'] : '';

        
        $CommonModel = new CommonModel();
        $checkdata =  $CommonModel->getAllDataByColumnName($table_name='user_licenses',$column_name='id',$value=$user_license_id);
        
        if(count($checkdata) > 0){
            if($checkdata[0]['user_id'] == $u_id){
                if($checkdata[0]['status'] == ASSIGNED){
                    $data_user_licese = array(
                                    'status' => REVOKE,
                                    'reason' => isset($_POST['revoke_reason']) ? $_POST['revoke_reason'] : '',
                                    'updated_date' => date('Y-m-d H:i:s'),
                                    'updated_by' => session('user_id')
                                );
                    $CommonModel->update_data( $table_name ='user_licenses', $user_license_id, $data_user_licese);

                    session()->setFlashdata("success", "License revoked successfully!!");
                    $response['status']='success';
                    $response['message']='License revoked successfully!!';
                }else{
                    $response['status']='error';
                    $response['message']='License already revoked. Please reload the page and check it!!';
                }
            }else{
                $response['status']='error';
                $response['message']='Something went wrong, please try again!!';
            }
            
        }else{
            $response['status']='error';
            $response['message']='Something went wrong, please try again!!';

        }
        echo json_encode($response);
        exit;
        
    }
    public function userApplicationFilter( $page_no ) {

      
        $request = service('request');
        $searchData = $request->getPost();
        $UserApplicationsModel = new UserApplicationsModel();
        $paginateData = $UserApplicationsModel->select('user_applications.*,application.*,user_applications.id,user_applications.application_id,user_applications.user_id,user_applications.created_date,application.id as l_id')->join('application', 'user_applications.application_id = application.id', 'left')->where('user_applications.user_id',$searchData['user_id'])->where('user_applications.status',ASSIGNED);
        if ($searchData['keyword'] != '') {
            $paginateData = $UserApplicationsModel->like('application.name', trim($searchData['keyword']), 'both');
        }
        $query  = $paginateData->get();
        $paginateData = $query->getResultArray();
        $output =array(
            'paginateData' => $paginateData,
        );

     
        return view('users/user_applications_filter_list',$output);

    }
    public function userApplicationAssign($e_id)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            $u_id=$encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $application_id = isset($_POST['application_id']) ? $_POST['application_id'] : '';

        $CommonModel = new CommonModel();
        
        if($application_id){
            foreach($application_id as $a_id){


       
        $checkdata =  $CommonModel->getAllDataByColumnName($table_name='application',$column_name='id',$value=$a_id);
        if(count($checkdata) > 0){
                $user_application_assigned =  $CommonModel->checkUserApplicationsAssigned($u_id,$a_id);
                if(count($user_application_assigned)>0){
                    $response['status']='error';
                    $response['message']='Application already assigned for this user';
                }else{
                    $data = array(
                            'user_id' => $u_id,
                            'application_id' => isset($a_id) ? trim($a_id) : '',
                            'status' => ASSIGNED,
                            'created_date' => date('Y-m-d H:i:s'),
                            'created_by' => session('user_id')
                        );
                    $last_id =  $CommonModel->insert_data($table_name='user_applications',$data);
                    session()->setFlashdata("success", "Created successfully!!");
                    $response['status']='success';
                    $response['message']='Created successfully!!';
                }
            
        }else{
            $response['status']='error';
            $response['message']='Something went wrong, please try again!!';

        }
    }}
        echo json_encode($response);
        exit;
    }


    public function userApplicationRevoke($e_id)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            $u_id=$encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $user_application_id = isset($_POST['user_application_id']) ? $_POST['user_application_id'] : '';
        $CommonModel = new CommonModel();
        $checkdata =  $CommonModel->getAllDataByColumnName($table_name='user_applications',$column_name='id',$value=$user_application_id);
        if(count($checkdata) > 0){
            if($checkdata[0]['user_id'] == $u_id){
                if($checkdata[0]['status'] == ASSIGNED){
                    $data_user_assets = array(
                                    'status' => REVOKE,
                                    'reason' => isset($_POST['revoke_reason']) ? $_POST['revoke_reason'] : '',
                                    'updated_date' => date('Y-m-d H:i:s'),
                                    'updated_by' => session('user_id')
                                );
                    $CommonModel->update_data( $table_name = 'user_applications', $user_application_id, $data_user_assets);

                    session()->setFlashdata("success", "Application revoked successfully!!");
                    $response['status']='success';
                    $response['message']='Application revoked successfully!!';
                }else{
                    $response['status']='error';
                    $response['message']='Application already revoked. Please reload the page and check it!!';
                }
            }else{
                $response['status']='error';
                $response['message']='Something went wrong, please try again!!';
            }
            
        }else{
            $response['status']='error';
            $response['message']='Something went wrong, please try again!!';
        }
        echo json_encode($response);
        exit;
        
    }

}