<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\VendorInvoiceModel;
use App\Models\CommonModel;
use App\Models\VendorModel;

class VendorInvoice extends Controller
{

    function __construct()
    {
        $user_id = session('user_id');
        if (!$user_id) {
            header('Location: ' . base_url() . '/login');
            exit;
        }
        if (!in_array(ACCESS_VENDOR_INVOICE, session('user_access'))) {
            header('Location: ' . base_url());
            exit;
        }
    }
    public function list()
    {
        if (!is_file(APPPATH . 'Views/vendor_invoice/list.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $cache = \Config\Services::cache();

        $cache->clean();
        $VendorModel = new VendorModel();
        $data['vendor'] = $VendorModel->select('id,supplier_name')->findAll();

        return view('includes/header') . view('vendor_invoice/list', $data) . view('includes/footer');
    }

    public function create()
    {
        if (!is_file(APPPATH . 'Views/vendor_invoice/create.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $data['vendor'] = $CommonModel->getAllActiveData($table_name = 'vendor');
        return view('includes/header') . view('vendor_invoice/create', $data) . view('includes/footer');
    }

    public function vendorInvoiceInsert()
    {

        $CommonModel = new CommonModel();
        $formattedInvoiceDate = date('Y-m-d', strtotime($_POST['invoice_date']));
        $checkdata = $CommonModel->checkVendorInvoiceByVendor($_POST['vendor_id'], $_POST['invoice_no']);
        if (count($checkdata) == 0) {


            $checkinvoice_no =
                $data = array(
                    'vendor_id' => isset($_POST['vendor_id']) ? trim($_POST['vendor_id']) : '',
                    'invoice_no' => isset($_POST['invoice_no']) ? trim($_POST['invoice_no']) : '',
                    'invoice_date' => isset($formattedInvoiceDate) ? trim($formattedInvoiceDate) : '',
                    'total_items_count' => isset($_POST['total_items_count']) ? trim($_POST['total_items_count']) : '',
                    'total_amount' => isset($_POST['total_amount']) ? trim($_POST['total_amount']) : '',
                    'gst' => isset($_POST['gst']) ? trim($_POST['gst']) : '',
                    'e_way_bill_no' => isset($_POST['e_way_bill_no']) ? trim($_POST['e_way_bill_no']) : '',
                    'currency' => isset($_POST['currency']) ? trim($_POST['currency']) : '',
                    'status' => ACTIVE,
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => session('user_id')
                );





            $last_id = $CommonModel->insert_data($table_name = 'vendor_invoice', $data);

            if ($last_id) {

                $vendor_info = $CommonModel->getDataByColumnName($table_name = 'vendor', $column_name = 'id', $value = $data['vendor_id']);

                $log = $CommonModel->logCreate('ADD', 'Inserted new vendor invoice, Invoice no -' . $_POST['invoice_no']." ".'of vendor'." ".$vendor_info[0]['supplier_name']);

                if (!empty($_POST["asset"])) {
                    $dataToInsert = array();
                    foreach ($_POST["asset"] as $assetData) {
                        $asset = array(
                            'name' => $assetData["'name'"],
                            'count' => $assetData["'count'"],
                            'price' => $assetData["'price'"],
                            'gst' => $assetData["'gst'"],
                            'amount' => $assetData["'amount'"],
                        );

                        $assetWithID = array('invoice_id' => $last_id) + $asset;

                        $dataToInsert[] = $assetWithID;
                    }



                    if (!empty($dataToInsert)) {
                        $CommonModel->insert_data_batch($table_name = 'vendor_invoice_items', $dataToInsert);
                    }
                }




                if (!file_exists(PUBLIC_PATH . 'uploads/vendor/')) {
                    mkdir(PUBLIC_PATH . 'uploads/vendor/', 0777);
                    chmod(PUBLIC_PATH . 'uploads/vendor/', 0777);
                }

                $invoice_attachment = 0;
                if ($this->request->getFile('invoice_copy_attachment')) {
                    $file = $this->request->getFile('invoice_copy_attachment');
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move(PUBLIC_PATH . 'uploads/vendor', $newName);
                        $invoice_attachment = 1;
                        $file_data = array(
                            'reference_id' => $last_id,
                            'type' => VENDOR_INVOICE,
                            'file_name' => $newName,
                            'file_url' => 'uploads/vendor/' . $newName,
                            'created_date' => date('Y-m-d H:i:s'),
                            'created_by' => session('user_id'),
                        );
                        $CommonModel->insert_data($table_name = 'files', $file_data);
                    }
                }

                $encrypter = \Config\Services::encrypter();
                $e_last_id = bin2hex($encrypter->encrypt($last_id));
                if ($invoice_attachment == 0) {
                    session()->setFlashdata("success", "Created successfully. Invoice copy is not attached successfully. Please check and Upload again!!");
                } else {
                    session()->setFlashdata("success", "Created successfully!!");
                }
                $response['status'] = 'success';
                $response['message'] = 'Created successfully!!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Something went wrong, please try again!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invoice number already exists!!';
        }

        echo json_encode($response);
        exit;
    }

    public function edit($e_id)
    {
        if (!is_file(APPPATH . 'Views/vendor_invoice/edit.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'vendor_invoice', $id);

        $items = $CommonModel->getDataByColumnName($table_name = 'vendor_invoice_items', $column_name = "invoice_id", $value = $id);



        if (count($result) > 0) {
            $result[0]['invoice_date'] = date('d-m-Y', strtotime($result[0]['invoice_date']));

            $data['vendor_invoice'] = $result;
            $data['items'] = $items;
            $data['vendor'] = $CommonModel->getAllActiveData($table_name = 'vendor');
            $data['vendor_invoice_copy'] = $CommonModel->getFilesByReferIDAndType($id, VENDOR_INVOICE);

            return view('includes/header') . view('vendor_invoice/edit', $data) . view('includes/footer');
        } else {
            session()->setFlashdata("error", "Something went wrong, please try again!!");
            return redirect()->to(base_url() . '/vendor_invoice/list');
        }
    }

    public function vendorInvoiceUpdate($e_id)
    {

        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'vendor_invoice', $id);

        $formattedInvoiceDate = date('Y-m-d', strtotime($_POST['invoice_date']));
        if (count($result) > 0) {
            $vendor_id = isset($_POST['vendor_id']) ? $_POST['vendor_id'] : '';
            $invoice_no = isset($_POST['invoice_no']) ? $_POST['invoice_no'] : '';
            if ($result[0]['vendor_id'] != $vendor_id && $result[0]['invoice_no'] != $invoice_no) {
                $checkdata = $CommonModel->checkVendorInvoiceByVendor($vendor_id, $invoice_no);

            } else {
                $checkdata = array();
            }
            if (count($checkdata) == 0) {

                $data = array(
                    'vendor_id' => isset($_POST['vendor_id']) ? trim($_POST['vendor_id']) : '',
                    'invoice_no' => isset($_POST['invoice_no']) ? trim($_POST['invoice_no']) : '',
                    'invoice_date' => isset($formattedInvoiceDate) ? trim($formattedInvoiceDate) : '',

                    'total_amount' => isset($_POST['total_amount']) ? trim($_POST['total_amount']) : '',
                    'e_way_bill_no' => isset($_POST['e_way_bill_no']) ? trim($_POST['e_way_bill_no']) : '',
                    'currency' => isset($_POST['currency']) ? trim($_POST['currency']) : '',
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => session('user_id')
                );




                $CommonModel->update_data($table_name = 'vendor_invoice', $id, $data);


                if (!empty($_POST["asset"])) {
                    $update_assets = array(); // Array for items with an 'id'
                    $insert_assets = array(); // Array for items without an 'id'

                    foreach ($_POST["asset"] as $assetData) {
                        if (isset($assetData["id"])) {
                            $update_asset = array(
                                'name' => $assetData["name"],
                                'count' => $assetData["count"],
                                'price' => $assetData["price"],
                                'gst' => $assetData["gst"],
                                'amount' => $assetData["amount"],
                                'id' => $assetData["id"],
                            );

                            $update_assets[] = $update_asset;
                        } else {
                            $new_asset_data = array(
                                'name' => $assetData["name"],
                                'count' => $assetData["count"],
                                'price' => $assetData["price"],
                                'gst' => $assetData["gst"],
                                'amount' => $assetData["amount"],
                            );

                            $assetWithID = array('invoice_id' => $id) + $new_asset_data;



                            $insert_assets[] = $assetWithID;
                        }
                    }


                    // You can now perform batch update and insert operations
                    if (!empty($update_assets)) {
                        $CommonModel->update_data_batch($table_name = 'vendor_invoice_items', $update_assets);
                    }

                    if (!empty($insert_assets)) {
                        $CommonModel->insert_data_batch($table_name = 'vendor_invoice_items', $insert_assets);
                    }
                }


                $vendor_info = $CommonModel->getDataByColumnName($table_name = 'vendor', $column_name = 'id', $value = $data['vendor_id']);

                $log = $CommonModel->logCreate('UPDATE', 'Updated vendor invoice, Invoice no -' . $data['invoice_no']." ".'of vendor'." ".$vendor_info[0]['supplier_name']);

                if ($this->request->getFile('invoice_copy_attachment')) {
                    $file = $this->request->getFile('invoice_copy_attachment');
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move(PUBLIC_PATH . 'uploads/vendor', $newName);
                        $vendor_invoice_copy = $CommonModel->getFilesByReferIDAndType($id, VENDOR_INVOICE);
                        if (count($vendor_invoice_copy) > 0) {

                            unlink('./' . PUBLIC_PATH . $vendor_invoice_copy[0]['file_url']);
                            $file_data = array(
                                'file_name' => $newName,
                                'file_url' => 'uploads/vendor/' . $newName,
                                'created_date' => date('Y-m-d H:i:s'),
                                'created_by' => session('user_id'),
                            );
                            $CommonModel->update_data($table_name = 'files', $vendor_invoice_copy[0]['id'], $file_data);
                        } else {
                            $file_data = array(
                                'reference_id' => $id,
                                'type' => VENDOR_INVOICE,
                                'file_name' => $newName,
                                'file_url' => 'uploads/vendor/' . $newName,
                                'created_date' => date('Y-m-d H:i:s'),
                                'created_by' => session('user_id'),
                            );
                            $CommonModel->insert_data($table_name = 'files', $file_data);
                        }
                    }
                }

                // $log = $CommonModel->logCreate('UPDATED', 'Vendor Invoice Updated -' . $_POST['invoice_no']);



                session()->setFlashdata("success", "Updated successfully!!");
                $response['status'] = 'success';
                $response['message'] = 'Updated successfully!!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Invoice number already exists!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Something went wrong, please try again!!';
        }
        echo json_encode($response);
        exit;
    }


    public function vendorInvoiceFilter($page_no)
    {

        $csrfToken = csrf_hash();
        $request = service('request');
        $searchData = $request->getPost();
        // Get data
        $VendorInvoiceModel = new VendorInvoiceModel();
        if ($searchData['keyword'] != '') {

            $where = "(invoice_no like '" . $searchData['keyword'] . "%')";
            $paginateData = $VendorInvoiceModel->select('*')
                ->where($where);

        }

        if ($searchData['vendor'] != '') {
            $paginateData = $VendorInvoiceModel->where('vendor_id', $searchData['vendor']);
        }

        if (isset($searchData['created_at']) && $searchData['created_at'] != '') {

            $str = explode(" - ", $searchData['created_at']);
            $str1 = str_replace("/", "-", trim($str[0]));
            $str2 = str_replace("/", "-", trim($str[1]));
            $paginateData = $VendorInvoiceModel->where('date(invoice_date) >=', $str1);
            $paginateData = $VendorInvoiceModel->where('date(invoice_date) <=', $str2);
        }

        $paginateData = $VendorInvoiceModel->where('deleted_by', NULL)->paginate($searchData['show_per_page'], 'default', $page_no);

        $output = array(
            'paginateData' => $paginateData,
            'pager' => $VendorInvoiceModel->pager,
            'csrfToken' => $csrfToken,
        );
        return view('vendor_invoice/filter_list', $output);
    }


    public function VendorInvoiceItemDelete()
    {
        $request = service('request');
        $invoice_id = $request->getPost();

        if (count($invoice_id) > 0) {

            $CommonModel = new CommonModel();
            $CommonModel->deleteDataByColumnName($table_name = 'vendor_invoice_items', $column_name = "id", $id = $invoice_id['items_id']);

            $response['status'] = 'success';
            $response['message'] = 'item deleted successfully';
        } else {
            session()->setFlashdata("unsuccess", "item not remove please try again ");
            $response['status'] = 'unsuccess';
            $response['message'] = 'item not remove please try again';
        }

        echo json_encode($response);
        exit;

    }
}
