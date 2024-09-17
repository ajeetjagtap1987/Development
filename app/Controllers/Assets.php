<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\AssetsModel;
use App\Models\CommonModel;

class Assets extends Controller
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
    public function list()
    {
        if (! is_file(APPPATH . 'Views/assets/list.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $CommonModel = new CommonModel();
        $data['category'] =  $CommonModel->getAllDataByColumnName($table_name='category',$column_name='category_type',$value=CATEGORY_ASSET);
        $data['manufacturer'] =  $CommonModel->getAllActiveData($table_name='manufacturer');
        $data['vendor'] =  $CommonModel->getAllActiveData($table_name='vendor');

        return view('includes/header').view('assets/list',$data).view('includes/footer');
    }
    public function create()
    {
        if (! is_file(APPPATH . 'Views/assets/create.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $data['category'] =  $CommonModel->getAllDataByColumnName($table_name='category',$column_name='category_type',$value=CATEGORY_ASSET);
        $data['manufacturer'] =  $CommonModel->getAllActiveData($table_name='manufacturer');
        $data['vendor'] =  $CommonModel->getAllActiveData($table_name='vendor');
        $data['office_location'] =  $CommonModel->getAllActiveData($table_name='office_location');
        return view('includes/header').view('assets/create',$data).view('includes/footer');
    }

    public function assetsInsert()
    {
        $asset_id = isset($_POST['asset_id']) ? $_POST['asset_id'] : '';


        $formattedDate = date('Y-m-d', strtotime($_POST['purchase_date']));
        $formattedExpiryDate = date('Y-m-d', strtotime($_POST['warranty_expiry_date']));


        $CommonModel = new CommonModel();
        $checkdata =  $CommonModel->getAllDataByColumnName($table_name='assets',$column_name='asset_id',$value=$asset_id);
        if(count($checkdata) == 0){
            $data = array(

                'category_id' => isset($_POST['category_id']) ? trim($_POST['category_id']) : '',
                'vendor_id' => isset($_POST['vendor_id']) ? trim($_POST['vendor_id']) : '',
                'invoice_no_id' => isset($_POST['invoice_no_id']) ? trim($_POST['invoice_no_id']) : '',
                // 'purchase_date' => isset($_POST['purchase_date']) ? trim($_POST['purchase_date']) : '',
                'purchase_date' => isset($formattedDate) ? trim($formattedDate) : '',
                'asset_id' => isset($_POST['asset_id']) ? trim($_POST['asset_id']) : '',
                'manufacturer_id' => isset($_POST['manufacturer_id']) ? trim($_POST['manufacturer_id']) : '',
                'serial_no' => isset($_POST['serial_no']) ? trim($_POST['serial_no']) : '',
                // 'warranty_expiry_date' => isset($_POST['warranty_expiry_date']) ? trim($_POST['warranty_expiry_date']) : '',
                'warranty_expiry_date' => isset($formattedExpiryDate) ? trim($formattedExpiryDate) : '',
                'asset_location_id' => isset($_POST['asset_location_id']) ? trim($_POST['asset_location_id']) : '',
                'model_name' => isset($_POST['model_name']) ? trim($_POST['model_name']) : '',
                'price' => isset($_POST['price']) ? trim($_POST['price']) : '',
                'processor' => isset($_POST['processor']) ? trim($_POST['processor']) : '',
                'installed_ram' => isset($_POST['installed_ram']) ? trim($_POST['installed_ram']) : '',
                'ram_unit' => isset($_POST['ram_unit']) ? trim($_POST['ram_unit']) : '',
                'host_name' => isset($_POST['host_name']) ? trim($_POST['host_name']) : '',
                'hard_disk' => isset($_POST['hard_disk']) ? trim($_POST['hard_disk']) : '',
                'storage_capacity' => isset($_POST['storage_capacity']) ? trim($_POST['storage_capacity']) : '',
                'storage_capacity_unit' => isset($_POST['storage_capacity_unit']) ? trim($_POST['storage_capacity_unit']) : '',
                'windows_edition' => isset($_POST['windows_edition']) ? trim($_POST['windows_edition']) : '',
                'windows_key' => isset($_POST['windows_key']) ? trim($_POST['windows_key']) : '',
                'device_id' => isset($_POST['device_id']) ? trim($_POST['device_id']) : '',
                'product_id' => isset($_POST['product_id']) ? trim($_POST['product_id']) : '',
                'screen_size' => isset($_POST['screen_size']) ? trim($_POST['screen_size']) : '',
                'type' => isset($_POST['type']) ? trim($_POST['type']) : '',
                'adp_warranty' => isset($_POST['adp_warranty']) ? trim($_POST['adp_warranty']) : '',
                'status' => ASSET_BUFFER,
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => session('user_id')
            );



            $last_id =  $CommonModel->insert_data($table_name='assets',$data);

            if($last_id){
                session()->setFlashdata("success", "Created successfully!!");

                $response['status']='success';
                $response['message']='Created successfully!!';
                $log = $CommonModel->logCreate('ADD', 'Inserted new Asset , '.' '.'Asset id -'.' '.$data['asset_id'] );

            }else{
                $response['status']='error';
                $response['message']='Something went wrong, please try again!!';
            }
        }else{
            $response['status']='error';
            $response['message']='Asset Id already exists!!';

        }
        echo json_encode($response);


        exit;


    }

    public function edit($e_id)

    {


        if (! is_file(APPPATH . 'Views/assets/edit.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id=$encrypter->decrypt(hex2bin($e_id));

        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result =  $CommonModel->getDataById($table_name='assets',$id);

        if(count($result) > 0){

            $result[0]['purchase_date'] = date('d-m-Y', strtotime($result[0]['purchase_date']));
            $result[0]['warranty_expiry_date'] = date('d-m-Y', strtotime($result[0]['warranty_expiry_date']));

            $data['assets'] = $result;
            $data['category'] =  $CommonModel->getAllDataByColumnName($table_name='category',$column_name='category_type',$value=CATEGORY_ASSET);

            $data['manufacturer'] =  $CommonModel->getAllActiveData($table_name='manufacturer');

            $data['vendor'] =  $CommonModel->getAllActiveData($table_name='vendor');

            $data['vendor_invoice'] =  $CommonModel->getAllDataByColumnName($table_name='vendor_invoice',$column_name='vendor_id',$value=$data['assets'][0]['vendor_id']);
            $data['office_location'] =  $CommonModel->getAllActiveData($table_name='office_location');


          return view('includes/header').view('assets/edit',$data).view('includes/footer');
        }else{
                session()->setFlashdata("error", "Something went wrong, please try again!!");
                return redirect()->to(base_url().'/assets/list');
        }
    }

    public function assetsUpdate($e_id)
    {

        try {
            $encrypter = \Config\Services::encrypter();
            $id=$encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result =  $CommonModel->getDataById($table_name='assets',$id);


        $formattedPurchaseDate = date('Y-m-d', strtotime($_POST['purchase_date']));
        $formattedExpiryDate = date('Y-m-d', strtotime($_POST['warranty_expiry_date']));

        if(count($result) > 0){
            $asset_id = isset($_POST['asset_id']) ? $_POST['asset_id'] : '';
            if($result[0]['asset_id'] != $asset_id){
                $checkdata =  $CommonModel->getAllDataByColumnName($table_name='assets',$column_name='asset_id',$value=$asset_id);
            }else{
                $checkdata=array();
            }
            if(count($checkdata) == 0){
                $data = array(
                            //'category_id' => isset($_POST['category_id']) ? trim($_POST['category_id']) : '',
                            'vendor_id' => isset($_POST['vendor_id']) ? trim($_POST['vendor_id']) : '',
                            'invoice_no_id' => isset($_POST['invoice_no_id']) ? trim($_POST['invoice_no_id']) : '',
                            'purchase_date' => isset($formattedPurchaseDate) ? trim($formattedPurchaseDate) : '',
                            'asset_id' => isset($_POST['asset_id']) ? trim($_POST['asset_id']) : '',
                            'manufacturer_id' => isset($_POST['manufacturer_id']) ? trim($_POST['manufacturer_id']) : '',
                            'serial_no' => isset($_POST['serial_no']) ? trim($_POST['serial_no']) : '',
                            'warranty_expiry_date' => isset($formattedExpiryDate) ? trim($formattedExpiryDate) : '',
                            'asset_location_id' => isset($_POST['asset_location_id']) ? trim($_POST['asset_location_id']) : '',
                            'model_name' => isset($_POST['model_name']) ? trim($_POST['model_name']) : '',
                            'price' => isset($_POST['price']) ? trim($_POST['price']) : '',
                            'processor' => isset($_POST['processor']) ? trim($_POST['processor']) : '',
                            'installed_ram' => isset($_POST['installed_ram']) ? trim($_POST['installed_ram']) : '',
                            'ram_unit' => isset($_POST['ram_unit']) ? trim($_POST['ram_unit']) : '',
                            'host_name' => isset($_POST['host_name']) ? trim($_POST['host_name']) : '',
                            'hard_disk' => isset($_POST['hard_disk']) ? trim($_POST['hard_disk']) : '',
                            'storage_capacity' => isset($_POST['storage_capacity']) ? trim($_POST['storage_capacity']) : '',
                            'storage_capacity_unit' => isset($_POST['storage_capacity_unit']) ? trim($_POST['storage_capacity_unit']) : '',
                            'windows_edition' => isset($_POST['windows_edition']) ? trim($_POST['windows_edition']) : '',
                            'windows_key' => isset($_POST['windows_key']) ? trim($_POST['windows_key']) : '',
                            'device_id' => isset($_POST['device_id']) ? trim($_POST['device_id']) : '',
                            'product_id' => isset($_POST['product_id']) ? trim($_POST['product_id']) : '',
                            'screen_size' => isset($_POST['screen_size']) ? trim($_POST['screen_size']) : '',
                            'type' => isset($_POST['type']) ? trim($_POST['type']) : '',
                            'adp_warranty' => isset($_POST['adp_warranty']) ? trim($_POST['adp_warranty']) : '',
                            'updated_date' => date('Y-m-d H:i:s'),
                            'updated_by' => session('user_id')
                );
                $CommonModel->update_data( $table_name = 'assets', $id, $data);
                session()->setFlashdata("success", "Updated successfully!!");
                $response['status']='success';
                $response['message']='Updated successfully!!';
                $log = $CommonModel->logCreate('UPDATE ', 'Asset Updated, '.' '.'Asset id -'.' '.$data['asset_id'] );

            }else{
                $response['status']='error';
                $response['message']='Asset Id already exists!!';
            }
        }else{
            $response['status']='error';
            $response['message']='Something went wrong, please try again!!';
        }
        echo json_encode($response);
        exit;
    }

    public function details($e_id)
    {
        if (! is_file(APPPATH . 'Views/assets/details.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id=$encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result =  $CommonModel->getDataById($table_name='assets',$id);
        if(count($result) > 0){
            $data['assets'] = $result;
            $data['category'] =  $CommonModel->getAllDataByColumnName($table_name='category',$column_name='id',$value=$data['assets'][0]['category_id']);
            $data['manufacturer'] = $CommonModel->getAllDataByColumnName($table_name='manufacturer',$column_name='id',$value=$data['assets'][0]['manufacturer_id']);
            $data['vendor'] =  $CommonModel->getAllDataByColumnName($table_name='vendor',$column_name='id',$value=$data['assets'][0]['vendor_id']);
            $data['vendor_invoice'] =  $CommonModel->getAllDataByColumnName($table_name='vendor_invoice',$column_name='id',$value=$data['assets'][0]['invoice_no_id']);
            $data['office_location'] =  $CommonModel->getAllActiveData($table_name='office_location');
          return view('includes/header').view('assets/details',$data).view('includes/footer');
        }else{
                session()->setFlashdata("error", "Something went wrong, please try again!!");
                return redirect()->to(base_url().'/assets/list');
        }
    }



    public function assetsFilter( $page_no ) {

        $request = service('request');
        $searchData = $request->getPost();
        $AssetsModel = new AssetsModel();
        if ($searchData['keyword'] != '') {
            $where = "(model_name LIKE '" . $searchData['keyword'] . "%' OR asset_id LIKE '" . $searchData['keyword'] . "%')";
            $paginateData = $AssetsModel->select('*')
                ->where($where);
        }
        if ($searchData['category'] != '') {
            $paginateData = $AssetsModel->where('category_id',$searchData['category']);
        }
        if ($searchData['manufacturer'] != '') {
            $paginateData = $AssetsModel->where('manufacturer_id',$searchData['manufacturer']);
        }
        if ($searchData['vendor'] != '') {
            $paginateData = $AssetsModel->where('vendor_id',$searchData['vendor']);
        }
        if ($searchData['status'] != '') {
            $paginateData = $AssetsModel->where('status', $searchData['status']);
        }
        if( isset($searchData['created_at']) && $searchData['created_at'] != '' ) {
            $str = explode(" - ",$searchData['created_at']);
            $str1=str_replace("/","-",trim($str[0]));
            $str2=str_replace("/","-",trim($str[1]));
            $paginateData = $AssetsModel->where('date(created_date) >=',$str1);
            $paginateData = $AssetsModel->where('date(created_date) <=',$str2);
        }
        $paginateData = $AssetsModel->where('deleted_by',NULL)->orderBy('id DESC')->paginate($searchData['show_per_page'],'default',$page_no);
        $output =array(
            'paginateData' => $paginateData,
            'pager' => $AssetsModel->pager,
        );
        return view('assets/filter_list',$output);
    }

    public function getVendorInvoiceByVendor($id)
    {
        $CommonModel = new CommonModel();
        $data = $CommonModel->getAllDataByColumnName($table_name='vendor_invoice',$coloumnname='vendor_id',$id);
        $data['status']         = 'success';
        $data['message']        = 'Done';
        echo json_encode($data);
    }

    public function getAssetsIdByCategory($id)
    {
        $CommonModel = new CommonModel();
        $data = $CommonModel->getAllDataByColumnName($table_name='assets',$coloumnname='category_id',$id);
        $data['status']         = 'success';
        $data['message']        = 'Done';
        echo json_encode($data);

    }


    public function assetsAutocomplete() {
        $searchTerm=isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';
        $data = [];
        if(!empty($searchTerm)){
            $AssetsModel = new AssetsModel();
            $assets = $AssetsModel->getAssetDataByModelName($searchTerm);
            if( count($assets) > 0 ) {
                foreach ($assets as $asset) {
                  $data[] = ['id'=>$asset['id'], 'text'=> $asset['model_name']];
                }
            }
        }
        echo json_encode($data);
    }


    public function getAssetsById($id)
    {
        $CommonModel = new CommonModel();
        $assetsDetails = $CommonModel->getAllDataByColumnName($table_name='assets',$coloumnname='id',$id);


        $data['status']         = 'success';
        $data['message']        = 'Done';
        $asset_info='';
        if(count($assetsDetails)>0){
            $asset_status='';
            foreach (ASSET_STATUS as $key => $value) {
                    if($assetsDetails[0]['status'] == $key){
                         $asset_status=$value;
                    }
                }
            $asset_info.='<table class="table table-bordered table-striped table-responsive table-sm">
                  <tbody>
                    <tr>
                      <th scope="row" width="110px">Model Name</th>
                      <td>'.$assetsDetails[0]['model_name'].'</td>
                    </tr>
                    <tr>
                      <th scope="row" width="110px">Asset Id</th>
                      <td>'.$assetsDetails[0]['asset_id'].'</td>
                    </tr>
                    <tr>
                      <th scope="row" width="110px">Serial Number</th>
                      <td>'.$assetsDetails[0]['serial_no'].'</td>
                    </tr>
                    <tr>
                      <th scope="row" width="110px">Status</th>
                      <td>'.$asset_status.'</td>
                    </tr>
                  </tbody>
                </table>';
            $user_asset_data =  $CommonModel->getUserAssetsByAssetId($assetsDetails[0]['id']);
            if(count($user_asset_data)>0){
                $asset_info.='<p>This asset is already assigned to the users below.</p>';
                $asset_info.='<table class="table table-bordered table-striped table-responsive table-sm">
                  <tbody>';
                  $asset_info.='<tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Job Title</th>
                                    <th>Reporting Head</th>
                                </tr>';
                  foreach($user_asset_data as $uad){
                    $user_data =  $CommonModel->getDataById($table_name='user',$uad['user_id']);
                    if(count($user_data)>0){
                    $asset_info.='<tr>
                                    <td>'.$user_data[0]['first_name'].' '.$user_data[0]['last_name'].'</td>
                                    <td>'.$user_data[0]['email'].'</td>
                                    <td>'.$user_data[0]['job_title'].'</td>
                                    <td>'.$user_data[0]['reporting_head'].'</td>
                                  </tr>';
                    }
                  }

                $asset_info.='</tbody>
                </table>';

            }

        }


        $data['asset_info']        = $asset_info;

        echo json_encode($data);

    }


    public function get_purchaseDate(){
        $request = service('request');
        $searchData = $request->getPost();

        $vendor_invoice=$searchData['vendor_id'];

        $CommonModel = new CommonModel();
        $result = $CommonModel->getSpecificDataByColumnName($table_name = 'vendor_invoice', $column_name = 'id',$value= $vendor_invoice,$select="invoice_date");


        echo json_encode($result);
    }

    public function assetExport(){
        if (!is_file(APPPATH . 'Views/assets/export.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();

        $data['category'] =  $CommonModel->getAllDataByColumnName($table_name='category',$column_name='category_type',$value=CATEGORY_ASSET);
        $data['manufacturer'] =  $CommonModel->getAllActiveData($table_name='manufacturer');
        $data['vendor'] =  $CommonModel->getAllActiveData($table_name='vendor');

        return view('includes/header') . view('assets/export',$data) . view('includes/footer');
    }

    public function export(){
        $AssetsModel = new AssetsModel();
        $CommonModel = new CommonModel();
        if ($_POST['category_id'] == 1) {
            $selectiveData = ['category_id', 'vendor_id', 'invoice_no_id', 'purchase_date', 'asset_id', 'manufacturer_id', 'serial_no', 'warranty_expiry_date', 'asset_location_id', 'model_name', 'price', 'processor', 'installed_ram', 'ram_unit', 'host_name', 'hard_disk', 'storage_capacity', 'storage_capacity_unit', 'windows_edition', 'windows_key', 'device_id', 'product_id','status'];
        } elseif ($_POST['category_id'] == 2 || $_POST['category_id'] == 19) {
            $selectiveData = ['category_id', 'vendor_id', 'invoice_no_id', 'price', 'purchase_date', 'asset_id', 'manufacturer_id', 'serial_no', 'warranty_expiry_date', 'asset_location_id', 'model_name',  'screen_size','status'];
        } elseif ($_POST['category_id'] == 3 || $_POST['category_id'] == 4) {
            $selectiveData = ['category_id', 'vendor_id', 'invoice_no_id', 'price', 'purchase_date', 'asset_id', 'manufacturer_id', 'serial_no', 'warranty_expiry_date', 'asset_location_id', 'model_name', 'type','status'];
        } elseif ($_POST['category_id'] == 5) {
            $selectiveData = ['category_id', 'vendor_id', 'invoice_no_id', 'purchase_date', 'asset_id', 'manufacturer_id', 'serial_no', 'warranty_expiry_date', 'asset_location_id', 'model_name', 'price', 'processor', 'installed_ram', 'ram_unit', 'hard_disk', 'storage_capacity', 'storage_capacity_unit', 'windows_edition', 'windows_key', 'device_id', 'product_id', 'screen_size', 'adp_warranty','status'];
        } elseif ($_POST['category_id'] == 6 || $_POST['category_id'] == 7 || $_POST['category_id'] == 8 || $_POST['category_id'] == 9 || $_POST['category_id'] == 10 || $_POST['category_id'] == 11 || $_POST['category_id'] == 12 || $_POST['category_id'] == 13 || $_POST['category_id'] == 14 || $_POST['category_id'] == 15 || $_POST['category_id'] == 18 || $_POST['category_id'] == 20 || $_POST['category_id'] == 21 || $_POST['category_id'] == 25 || $_POST['category_id'] == 26) {
            $selectiveData = ['category_id', 'vendor_id', 'invoice_no_id', 'price', 'purchase_date', 'asset_id', 'manufacturer_id', 'serial_no', 'warranty_expiry_date', 'asset_location_id', 'model_name','status'];
        } elseif ($_POST['category_id'] == 16) {
            $selectiveData = ['category_id', 'vendor_id', 'invoice_no_id', 'price', 'purchase_date', 'asset_id', 'manufacturer_id', 'serial_no', 'warranty_expiry_date', 'asset_location_id', 'model_name', 'processor', 'installed_ram', 'ram_unit',  'storage_capacity', 'storage_capacity_unit','status'];
        } elseif ($_POST['category_id'] == 17) {
            $selectiveData = ['category_id', 'vendor_id', 'invoice_no_id', 'price', 'purchase_date', 'asset_id', 'manufacturer_id', 'serial_no', 'warranty_expiry_date', 'asset_location_id', 'model_name', 'processor', 'installed_ram', 'ram_unit', 'hard_disk', 'storage_capacity', 'storage_capacity_unit','status'];
        } else {
            $selectiveData = ['category_id', 'vendor_id', 'invoice_no_id', 'purchase_date', 'asset_id', 'manufacturer_id', 'serial_no', 'warranty_expiry_date', 'asset_location_id', 'model_name', 'price', 'processor', 'installed_ram', 'ram_unit', 'host_name', 'hard_disk', 'storage_capacity', 'storage_capacity_unit', 'windows_edition', 'windows_key', 'device_id', 'product_id', 'screen_size', 'type', 'adp_warranty','status'];
        }
        // $selectiveData=['id','category_id','vendor_id','invoice_no_id','purchase_date','asset_id','manufacturer_id','serial_no','warranty_expiry_date','asset_location_id','model_name','price','processor','installed_ram','ram_unit','host_name','hard_disk','storage_capacity','storage_capacity_unit','windows_edition','windows_key','device_id','product_id','screen_size','type','adp_warranty','status'];
        $db_data = $AssetsModel
        ->select($selectiveData);
        $request = service('request');
        $searchData = $request->getPost();
        if ($searchData['category_id'] != '') {
            $db_data->where('category_id',$_POST['category_id']);
         }
         if (isset($searchData['vendor_id']) && $searchData['vendor_id'] != '') {
            $db_data->whereIn('vendor_id',$_POST['vendor_id']);
         }
         if (isset($searchData['manufacturer_id']) && $searchData['manufacturer_id'] != '') {
            $db_data->whereIn('manufacturer_id',$_POST['manufacturer_id']);
         }
         if( isset($searchData['created_at']) && $searchData['created_at'] != '' ) {
            $str = explode(" - ",$searchData['created_at']);
            $str1=str_replace("/","-",trim($str[0]));
            $str2=str_replace("/","-",trim($str[1]));
            $db_data->where('date(created_date) >=',$str1);
            $db_data->where('date(created_date) <=',$str2);
        }
         $asset_data=$db_data->where('deleted_by', NULL)->findAll();



        if(count($asset_data)<= 0){
            session()->setFlashdata("error", "No Data Found!!");
            return redirect()->to(base_url() . '/assets/export');
        }

        $data = [];
        foreach($asset_data as $data_fill){
            if($data_fill['category_id']){
                $catg_info = $CommonModel->getDataByColumnName($table_name = 'category', $column_name = 'id', $value = $data_fill['category_id']);
                $data_fill['category_id']= $catg_info[0]['category_name'];
            }
            else{
                $data_fill['category_id']= '';
            }
            if($data_fill['vendor_id']){

                $vendor_info = $CommonModel->getDataByColumnName($table_name = 'vendor', $column_name = 'id', $value = $data_fill['vendor_id']);

                $data_fill['vendor_id']= $vendor_info[0]['supplier_name'];
            }
            else{
                $data_fill['vendor_id']= '';
            }

            if ($data_fill['invoice_no_id']) {

                $invoice_id = $CommonModel->getAllDataByColumnName($table_name = 'vendor_invoice', $coloumnname = 'id',$data_fill['invoice_no_id']);

                $data_fill['invoice_no_id'] = $invoice_id[0]['invoice_no'];
            } else {
                $data_fill['invoice_no_id'] = '';
            }

            if($data_fill['manufacturer_id']){

                $man_info = $CommonModel->getDataByColumnName($table_name = 'manufacturer', $column_name = 'id', $value = $data_fill['manufacturer_id']);
                $data_fill['manufacturer_id']= $man_info[0]['name'];
            }
            else{
                $data_fill['manufacturer_id']= '';
            }
            if($data_fill['asset_location_id']){

                $dept_info = $CommonModel->getDataByColumnName($table_name = 'office_location', $column_name = 'id', $value = $data_fill['asset_location_id']);
                $data_fill['asset_location_id']= $dept_info[0]['name'];
            }else{
                $data_fill['asset_location_id']= '';
            }
            if($data_fill['status']){
                foreach (ASSET_STATUS as $key => $value) {
                    if ($key == $data_fill['status']) {
                        $data_fill['status'] = $value;
                        break;
                    }
                }

            }
            $data[] = $data_fill;
        }
         foreach ($data as $field => &$value) {
                if (empty($value)) {
                    $value = "N/A";
                }
            }

        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"asset_report".".csv\"");
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

        fclose($handle);
        $log = $CommonModel->logCreate('EXPORT', 'Exported asset report , total count -' . count($data));

        exit;
    }

    public function deleteAsset(){

        if(empty($_POST['asset_id'])){
            $response['status']='error';
            $response['message']='something went wrong!!';
            echo json_encode($response);
        }
        $CommonModel = new CommonModel();
        $asset_info = $CommonModel->getDataByColumnName($table_name = 'assets', $column_name = 'id', $value = $_POST['asset_id']);

        if($asset_info[0]['status']== ASSET_ASSIGN){
            $response['status']='error';
        $response['message']='Cannot delete asset , asset status is assigned!!';
        }
        else{

            $data = array(
                'deleted_date' => date('Y-m-d H:i:s'),
                'deleted_by' => session('user_id'),
            );

            $asset_update = $CommonModel->update_data($table_name = 'assets', $id = $_POST['asset_id'], $value = $data);
            $response['status']='success';
            $response['message']='Deleted successfully!!';

            $log = $CommonModel->logCreate('DELETE ', 'Asset Deleted, '.' '.'Asset id -'.' '.$asset_info[0]['asset_id'] );

        }

        echo json_encode($response);

    }
}