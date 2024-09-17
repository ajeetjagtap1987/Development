<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\VendorModel;
use App\Models\VendorGstModel;
use App\Models\CommonModel;

class Vendor extends Controller
{

    function __construct()
    {
        $user_id = session('user_id');
        if (!$user_id) {
            header('Location: ' . base_url() . '/login');
            exit;
        }
        if (!in_array(ACCESS_VENDOR, session('user_access'))) {
            header('Location: ' . base_url());
            exit;
        }
    }
    public function list()
    {
        if (!is_file(APPPATH . 'Views/vendor/list.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return view('includes/header') . view('vendor/list') . view('includes/footer');
    }

    public function create()
    {
        if (!is_file(APPPATH . 'Views/vendor/create.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $data['category'] = $CommonModel->getAllActiveData($table_name = 'category');
        $data['manufacturer'] = $CommonModel->getAllActiveData($table_name = 'manufacturer');

        $data['country'] = $CommonModel->getData($table_name = 'country');

        return view('includes/header') . view('vendor/create', $data) . view('includes/footer');
    }

    public function vendorInsert()
    {
        $CommonModel = new CommonModel();
        $supplier_name = isset($_POST['supplier_name']) ? $_POST['supplier_name'] : '';
        $state = isset($_POST['state']) ? $_POST['state'] : '';
        $newstate = isset($_POST['new_state']) ? $_POST['new_state'] : '';
        $country = isset($_POST['country']) ? $_POST['country'] : '';


        if ($state == "other") {

            $state_data = array(
                'name' => isset($newstate) ? trim($newstate) : '',
                'country_id' => isset($country) ? trim($country) : '',
            );

            $state_id = $CommonModel->insert_data($table_name = 'state', $state_data);
            $poststate = $state_id;
        } else {
            $poststate = $state;
        }



        $checkdata = $CommonModel->getAllDataByColumnName($table_name = 'vendor', $column_name = 'supplier_name', $value = $supplier_name);
        if (count($checkdata) == 0) {
            $data = array(
                'supplier_type' => isset($_POST['supplier_type']) ? trim($_POST['supplier_type']) : '',
                'supplier_name' => isset($_POST['supplier_name']) ? trim($_POST['supplier_name']) : '',
                'business_email_address' => isset($_POST['business_email_address']) ? trim($_POST['business_email_address']) : '',
                'plot_floor_building' => isset($_POST['plot_floor_building']) ? trim($_POST['plot_floor_building']) : '',
                'street_address_one' => isset($_POST['street_address_one']) ? trim($_POST['street_address_one']) : '',
                'street_address_two' => isset($_POST['street_address_two']) ? trim($_POST['street_address_two']) : '',
                'city' => isset($_POST['city']) ? trim($_POST['city']) : '',
                'country' => isset($_POST['country']) ? trim($_POST['country']) : '',
                'state' => isset($poststate) ? trim($poststate) : '',
                'pincode' => isset($_POST['pincode']) ? trim($_POST['pincode']) : '',
                'director_contact_person_name' => isset($_POST['director_contact_person_name']) ? trim($_POST['director_contact_person_name']) : '',
                'director_designation' => isset($_POST['director_designation']) ? trim($_POST['director_designation']) : '',
                'director_telephone' => isset($_POST['director_telephone']) ? trim($_POST['director_telephone']) : '',
                'director_mobile' => isset($_POST['director_mobile']) ? trim($_POST['director_mobile']) : '',
                'director_email_address' => isset($_POST['director_email_address']) ? trim($_POST['director_email_address']) : '',
                'finance_contact_person_name' => isset($_POST['finance_contact_person_name']) ? trim($_POST['finance_contact_person_name']) : '',
                'finance_designation' => isset($_POST['finance_designation']) ? trim($_POST['finance_designation']) : '',
                'finance_telephone' => isset($_POST['finance_telephone']) ? trim($_POST['finance_telephone']) : '',
                'finance_mobile' => isset($_POST['finance_mobile']) ? trim($_POST['finance_mobile']) : '',
                'finance_email_address' => isset($_POST['finance_email_address']) ? trim($_POST['finance_email_address']) : '',
                'purchase_contact_person_name' => isset($_POST['purchase_contact_person_name']) ? trim($_POST['purchase_contact_person_name']) : '',
                'purchase_designation' => isset($_POST['purchase_designation']) ? trim($_POST['purchase_designation']) : '',
                'purchase_telephone' => isset($_POST['purchase_telephone']) ? trim($_POST['purchase_telephone']) : '',
                'purchase_mobile' => isset($_POST['purchase_mobile']) ? trim($_POST['purchase_mobile']) : '',
                'purchase_email_address' => isset($_POST['purchase_email_address']) ? trim($_POST['purchase_email_address']) : '',
                'business_commencement_date' => isset($_POST['business_commencement_date']) ? trim($_POST['business_commencement_date']) : '',
                'pan_number' => isset($_POST['pan_number']) ? trim($_POST['pan_number']) : '',
                'tan_number' => isset($_POST['tan_number']) ? trim($_POST['tan_number']) : '',
                'cin_number' => isset($_POST['cin_number']) ? trim($_POST['cin_number']) : '',
                'iec_number' => isset($_POST['iec_number']) ? trim($_POST['iec_number']) : '',
                'gst_registration_number' => isset($_POST['gst_registration_number']) ? trim($_POST['gst_registration_number']) : '',
                'bank_account_name' => isset($_POST['bank_account_name']) ? trim($_POST['bank_account_name']) : '',
                'bank_account_number' => isset($_POST['bank_account_number']) ? trim($_POST['bank_account_number']) : '',
                'bank_account_type' => isset($_POST['bank_account_type']) ? trim($_POST['bank_account_type']) : '',
                'bank_name' => isset($_POST['bank_name']) ? trim($_POST['bank_name']) : '',
                'bank_branch_name_and_code' => isset($_POST['bank_branch_name_and_code']) ? trim($_POST['bank_branch_name_and_code']) : '',
                'bank_address' => isset($_POST['bank_address']) ? trim($_POST['bank_address']) : '',
                'bank_telephone' => isset($_POST['bank_telephone']) ? trim($_POST['bank_telephone']) : '',
                'bank_neft_ifsc_code' => isset($_POST['bank_neft_ifsc_code']) ? trim($_POST['bank_neft_ifsc_code']) : '',
                'bank_micr_code' => isset($_POST['bank_micr_code']) ? trim($_POST['bank_micr_code']) : '',
                'bank_swift_code_aba_code_sort_code_iban' => isset($_POST['bank_swift_code_aba_code_sort_code_iban']) ? trim($_POST['bank_swift_code_aba_code_sort_code_iban']) : '',
                'organisation_type' => isset($_POST['organisation_type']) ? implode(',', $_POST['organisation_type']) : '',
                'status' => ACTIVE,
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => session('user_id')
            );




            $last_id = $CommonModel->insert_data($table_name = 'vendor', $data);
            if ($last_id) {

                $log = $CommonModel->logCreate('ADD', 'Inserted new Vendor-' . $_POST['supplier_name']);

                if (!file_exists(PUBLIC_PATH . 'uploads/vendor/')) {
                    mkdir(PUBLIC_PATH . 'uploads/vendor/', 0777);
                    chmod(PUBLIC_PATH . 'uploads/vendor/', 0777);
                }

                $pan_attachment = 0;
                if ($this->request->getFile('pan_copy_attachment')) {
                    $file = $this->request->getFile('pan_copy_attachment');
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = time() . '_' . $file->getRandomName();
                        $file->move(PUBLIC_PATH . 'uploads/vendor', $newName);
                        $pan_attachment = 1;
                        $file_data = array(
                            'reference_id' => $last_id,
                            'type' => VENDOR_PANCARD,
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
                if ($pan_attachment == 0) {
                    session()->setFlashdata("success", "Created successfully. Pan copy is not attached successfully. Please check and Upload again!!");
                } else {
                    session()->setFlashdata("success", "Created successfully!!");
                }

                $response['status'] = 'success';
                $response['message'] = 'Created successfully!!';
                $response['last_id'] = $e_last_id;
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Something went wrong, please try again!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Supplier name already exists!!';

        }
        echo json_encode($response);
        exit;

    }

    public function edit($e_id)
    {
        if (!is_file(APPPATH . 'Views/vendor/edit.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'vendor', $id);
        if (count($result) > 0) {
            $data['vendor'] = $result;
            $data['country'] = $CommonModel->getData($table_name = 'country');
            $data['state'] = $CommonModel->getData($table_name = 'state');
            $data['vendor_pancard'] = $CommonModel->getFilesByReferIDAndType($id, VENDOR_PANCARD);
            return view('includes/header') . view('vendor/edit', $data) . view('includes/footer');
        } else {
            session()->setFlashdata("error", "Something went wrong, please try again!!");
            return redirect()->to(base_url() . '/vendor/list');
        }
    }

    public function vendorUpdate($e_id)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'vendor', $id);
        if (count($result) > 0) {
            $supplier_name = isset($_POST['supplier_name']) ? $_POST['supplier_name'] : '';
            if ($result[0]['supplier_name'] != $supplier_name) {
                $checkdata = $CommonModel->getAllDataByColumnName($table_name = 'vendor', $column_name = 'supplier_name', $value = $supplier_name);
            } else {
                $checkdata = array();
            }
            if (count($checkdata) == 0) {
                $data = array(
                    'supplier_type' => isset($_POST['supplier_type']) ? trim($_POST['supplier_type']) : '',
                    'supplier_name' => isset($_POST['supplier_name']) ? trim($_POST['supplier_name']) : '',
                    'business_email_address' => isset($_POST['business_email_address']) ? trim($_POST['business_email_address']) : '',
                    'plot_floor_building' => isset($_POST['plot_floor_building']) ? trim($_POST['plot_floor_building']) : '',
                    'street_address_one' => isset($_POST['street_address_one']) ? trim($_POST['street_address_one']) : '',
                    'street_address_two' => isset($_POST['street_address_two']) ? trim($_POST['street_address_two']) : '',
                    'city' => isset($_POST['city']) ? trim($_POST['city']) : '',
                    'country' => isset($_POST['country']) ? trim($_POST['country']) : '',
                    'state' => isset($_POST['state']) ? trim($_POST['state']) : '',
                    'pincode' => isset($_POST['pincode']) ? trim($_POST['pincode']) : '',
                    'director_contact_person_name' => isset($_POST['director_contact_person_name']) ? trim($_POST['director_contact_person_name']) : '',
                    'director_designation' => isset($_POST['director_designation']) ? trim($_POST['director_designation']) : '',
                    'director_telephone' => isset($_POST['director_telephone']) ? trim($_POST['director_telephone']) : '',
                    'director_mobile' => isset($_POST['director_mobile']) ? trim($_POST['director_mobile']) : '',
                    'director_email_address' => isset($_POST['director_email_address']) ? trim($_POST['director_email_address']) : '',
                    'finance_contact_person_name' => isset($_POST['finance_contact_person_name']) ? trim($_POST['finance_contact_person_name']) : '',
                    'finance_designation' => isset($_POST['finance_designation']) ? trim($_POST['finance_designation']) : '',
                    'finance_telephone' => isset($_POST['finance_telephone']) ? trim($_POST['finance_telephone']) : '',
                    'finance_mobile' => isset($_POST['finance_mobile']) ? trim($_POST['finance_mobile']) : '',
                    'finance_email_address' => isset($_POST['finance_email_address']) ? trim($_POST['finance_email_address']) : '',
                    'purchase_contact_person_name' => isset($_POST['purchase_contact_person_name']) ? trim($_POST['purchase_contact_person_name']) : '',
                    'purchase_designation' => isset($_POST['purchase_designation']) ? trim($_POST['purchase_designation']) : '',
                    'purchase_telephone' => isset($_POST['purchase_telephone']) ? trim($_POST['purchase_telephone']) : '',
                    'purchase_mobile' => isset($_POST['purchase_mobile']) ? trim($_POST['purchase_mobile']) : '',
                    'purchase_email_address' => isset($_POST['purchase_email_address']) ? trim($_POST['purchase_email_address']) : '',
                    'business_commencement_date' => isset($_POST['business_commencement_date']) ? trim($_POST['business_commencement_date']) : '',
                    'pan_number' => isset($_POST['pan_number']) ? trim($_POST['pan_number']) : '',
                    'tan_number' => isset($_POST['tan_number']) ? trim($_POST['tan_number']) : '',
                    'cin_number' => isset($_POST['cin_number']) ? trim($_POST['cin_number']) : '',
                    'iec_number' => isset($_POST['iec_number']) ? trim($_POST['iec_number']) : '',
                    'gst_registration_number' => isset($_POST['gst_registration_number']) ? trim($_POST['gst_registration_number']) : '',
                    'bank_account_name' => isset($_POST['bank_account_name']) ? trim($_POST['bank_account_name']) : '',
                    'bank_account_number' => isset($_POST['bank_account_number']) ? trim($_POST['bank_account_number']) : '',
                    'bank_account_type' => isset($_POST['bank_account_type']) ? trim($_POST['bank_account_type']) : '',
                    'bank_name' => isset($_POST['bank_name']) ? trim($_POST['bank_name']) : '',
                    'bank_branch_name_and_code' => isset($_POST['bank_branch_name_and_code']) ? trim($_POST['bank_branch_name_and_code']) : '',
                    'bank_address' => isset($_POST['bank_address']) ? trim($_POST['bank_address']) : '',
                    'bank_telephone' => isset($_POST['bank_telephone']) ? trim($_POST['bank_telephone']) : '',
                    'bank_neft_ifsc_code' => isset($_POST['bank_neft_ifsc_code']) ? trim($_POST['bank_neft_ifsc_code']) : '',
                    'bank_micr_code' => isset($_POST['bank_micr_code']) ? trim($_POST['bank_micr_code']) : '',
                    'bank_swift_code_aba_code_sort_code_iban' => isset($_POST['bank_swift_code_aba_code_sort_code_iban']) ? trim($_POST['bank_swift_code_aba_code_sort_code_iban']) : '',
                    'organisation_type' => isset($_POST['organisation_type']) ? implode(',', $_POST['organisation_type']) : '',
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => session('user_id')
                );
                $CommonModel->update_data($table_name = 'vendor', $id, $data);
                $log = $CommonModel->logCreate('UPDATE', 'Updated Vendor-' . $_POST['supplier_name']);

                if (!file_exists(PUBLIC_PATH . 'uploads/vendor/')) {
                    mkdir(PUBLIC_PATH . 'uploads/vendor/', 0777);
                    chmod(PUBLIC_PATH . 'uploads/vendor/', 0777);
                }
                if ($this->request->getFile('pan_copy_attachment')) {
                    $file = $this->request->getFile('pan_copy_attachment');
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move(PUBLIC_PATH . 'uploads/vendor', $newName);
                        $vendor_pancard_copy = $CommonModel->getFilesByReferIDAndType($id, VENDOR_PANCARD);
                        if (count($vendor_pancard_copy) > 0) {

                            unlink('./' . PUBLIC_PATH . $vendor_pancard_copy[0]['file_url']);
                            $file_data = array(
                                'file_name' => $newName,
                                'file_url' => 'uploads/vendor/' . $newName,
                                'created_date' => date('Y-m-d H:i:s'),
                                'created_by' => session('user_id'),
                            );
                            $CommonModel->update_data($table_name = 'files', $vendor_pancard_copy[0]['id'], $file_data);
                        } else {
                            $file_data = array(
                                'reference_id' => $id,
                                'type' => VENDOR_PANCARD,
                                'file_name' => $newName,
                                'file_url' => 'uploads/vendor/' . $newName,
                                'created_date' => date('Y-m-d H:i:s'),
                                'created_by' => session('user_id'),
                            );
                            $CommonModel->insert_data($table_name = 'files', $file_data);
                        }

                    }
                }

                session()->setFlashdata("success", "Updated successfully!!");
                $response['status'] = 'success';
                $response['message'] = 'Updated successfully!!';

            } else {
                $response['status'] = 'error';
                $response['message'] = 'Supplier name already exists!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Something went wrong, please try again!!';
        }
        echo json_encode($response);
        exit;
    }


    public function get_State()
    {
        $request = service('request');
        $searchData = $request->getPost();

        $country_id = $searchData['contry_id'];
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataByColumnName($table_name = 'state', $column_name = 'country_id', $value = $country_id);


        echo json_encode($result);
    }


    public function view($e_id)
    {
        if (!is_file(APPPATH . 'Views/vendor/view.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'vendor', $id);
        if (count($result) > 0) {
            $data['vendor'] = $result;
            $data['vendor_pancard'] = $CommonModel->getFilesByReferIDAndType($id, VENDOR_PANCARD);
            return view('includes/header') . view('vendor/view', $data) . view('includes/footer');
        } else {
            session()->setFlashdata("error", "Something went wrong, please try again!!");
            return redirect()->to(base_url() . '/vendor/list');
        }
    }
    public function vendorFilter($page_no)
    {
        $request = service('request');
        $searchData = $request->getPost();
        // Get data
        $VendorModel = new VendorModel();
        if ($searchData['keyword'] == '') {
            $paginateData = $VendorModel->where('deleted_by', NULL)->paginate($searchData['show_per_page'], 'default', $page_no);

        } else {
            $where = "(supplier_name like '" . $searchData['keyword'] . "%')";
            $paginateData = $VendorModel->select('*')
                ->where('deleted_by', NULL)
                ->where($where)
                ->paginate($searchData['show_per_page'], 'default', $page_no);
        }

        $output = array(
            'paginateData' => $paginateData,
            'pager' => $VendorModel->pager,
        );
        return view('vendor/filter_list', $output);
    }

    public function vendorGstList($e_id)
    {
        if (!is_file(APPPATH . 'Views/vendor/gst_list.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'vendor', $id);
        if (count($result) > 0) {
            $data['vendor'] = $result;
            return view('includes/header') . view('vendor/gst_list', $data) . view('includes/footer');
        } else {
            session()->setFlashdata("error", "Something went wrong, please try again!!");
            return redirect()->to(base_url() . '/vendor/list');
        }
    }

    public function vendorGstListFilter($page_no)
    {
        $csrfToken = csrf_hash();
        $request = service('request');
        $searchData = $request->getPost();
        // Get data
        $VendorGstModel = new VendorGstModel();
        if ($searchData['keyword'] == '') {
            $paginateData = $VendorGstModel->where('deleted_by', NULL)->paginate($searchData['show_per_page'], 'default', $page_no);

        } else {
            $where = "(gst_registration_number like '" . $searchData['keyword'] . "%')";
            $paginateData = $VendorModel->select('*')
                ->where('vendor_id', $searchData['vendor_id'])
                ->where('deleted_by', NULL)
                ->where($where)
                ->paginate($searchData['show_per_page'], 'default', $page_no);
        }

        $output = array(
            'paginateData' => $paginateData,
            'pager' => $VendorGstModel->pager,
            'csrfToken' => $csrfToken,
        );
        return view('vendor/gstlist_filter', $output);
    }

    public function vendorGstcreate($e_id)
    {
        if (!is_file(APPPATH . 'Views/vendor/gst_create.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'vendor', $id);
        if (count($result) > 0) {
            $data['vendor'] = $result;
            return view('includes/header') . view('vendor/gst_create', $data) . view('includes/footer');
        } else {
            session()->setFlashdata("error", "Something went wrong, please try again!!");
            return redirect()->to(base_url() . '/vendor/gst_list/' . $e_id);
        }
    }

    public function vendorGstInsert($e_id)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'vendor', $id);
        if (count($result) > 0) {
            $gst_registration_number = isset($_POST['gst_registration_number']) ? $_POST['gst_registration_number'] : '';
            $CommonModel = new CommonModel();
            $checkdata = $CommonModel->getAllDataByColumnName($table_name = 'vendor_gst_detail', $column_name = 'gst_registration_number', $value = $gst_registration_number);
            if (count($checkdata) == 0) {
                $data = array(
                    'vendor_id' => $id,
                    'plot_floor_building' => isset($_POST['plot_floor_building']) ? trim($_POST['plot_floor_building']) : '',
                    'street_address_one' => isset($_POST['street_address_one']) ? trim($_POST['street_address_one']) : '',
                    'street_address_two' => isset($_POST['street_address_two']) ? trim($_POST['street_address_two']) : '',
                    'city' => isset($_POST['city']) ? trim($_POST['city']) : '',
                    'country' => isset($_POST['country']) ? trim($_POST['country']) : '',
                    'state' => isset($_POST['state']) ? trim($_POST['state']) : '',
                    'pincode' => isset($_POST['pincode']) ? trim($_POST['pincode']) : '',
                    'gst_registration_number' => isset($_POST['gst_registration_number']) ? trim($_POST['gst_registration_number']) : '',
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => session('user_id')
                );
                $last_id = $CommonModel->insert_data($table_name = 'vendor_gst_detail', $data);
                if ($last_id) {
                    session()->setFlashdata("success", "Created successfully!!");
                    $response['status'] = 'success';
                    $response['message'] = 'Created successfully!!';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Something went wrong, please try again!!';
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Gst registration number already exists!!';

            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Something went wrong, please try again!!';
        }
        echo json_encode($response);
        exit;
    }

    public function vendorGstedit($e_id)
    {
        if (!is_file(APPPATH . 'Views/vendor/gst_edit.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'vendor_gst_detail', $id);
        if (count($result) > 0) {
            $data['vendor_gst'] = $result;
            return view('includes/header') . view('vendor/gst_edit', $data) . view('includes/footer');
        } else {
            session()->setFlashdata("error", "Something went wrong, please try again!!");
            return redirect()->to(base_url() . '/vendor/list/');
        }
    }

    public function vendorGstUpdate($e_id)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            $id = $encrypter->decrypt(hex2bin($e_id));
        } catch (\Exception $e) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $CommonModel = new CommonModel();
        $result = $CommonModel->getDataById($table_name = 'vendor_gst_detail', $id);
        if (count($result) > 0) {
            $gst_registration_number = isset($_POST['gst_registration_number']) ? $_POST['gst_registration_number'] : '';
            if ($result[0]['gst_registration_number'] != $gst_registration_number) {
                $checkdata = $CommonModel->getAllDataByColumnName($table_name = 'vendor_gst_detail', $column_name = 'gst_registration_number', $value = $gst_registration_number);
            } else {
                $checkdata = array();
            }
            if (count($checkdata) == 0) {
                $data = array(
                    'plot_floor_building' => isset($_POST['plot_floor_building']) ? trim($_POST['plot_floor_building']) : '',
                    'street_address_one' => isset($_POST['street_address_one']) ? trim($_POST['street_address_one']) : '',
                    'street_address_two' => isset($_POST['street_address_two']) ? trim($_POST['street_address_two']) : '',
                    'city' => isset($_POST['city']) ? trim($_POST['city']) : '',
                    'country' => isset($_POST['country']) ? trim($_POST['country']) : '',
                    'state' => isset($_POST['state']) ? trim($_POST['state']) : '',
                    'pincode' => isset($_POST['pincode']) ? trim($_POST['pincode']) : '',
                    'gst_registration_number' => isset($_POST['gst_registration_number']) ? trim($_POST['gst_registration_number']) : '',
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => session('user_id')
                );
                $CommonModel->update_data($table_name = 'vendor_gst_detail', $id, $data);



                session()->setFlashdata("success", "Updated successfully!!");
                $response['status'] = 'success';
                $response['message'] = 'Updated successfully!!';

            } else {
                $response['status'] = 'error';
                $response['message'] = 'Gst registration number already exists!!';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Something went wrong, please try again!!';
        }
        echo json_encode($response);
        exit;
    }

}