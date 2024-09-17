<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CategoryModel;
use App\Models\AssetsModel;
use App\Models\LicenseModel;
use App\Models\CommonModel;
use App\Models\VendorInvoiceModel;
use App\Models\VendorModel;

class Dashboard extends Controller
{
    public $data = null;
    function __construct()
    {
        $user_id = session('user_id');
        if (!$user_id) {
            header('Location: ' . base_url() . '/login');
            exit;
        }
    }
    public function index()
    {
        if (!is_file(APPPATH . 'Views/index.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $CategoryModel = new CategoryModel();
        $category = $CategoryModel->select('id')->findAll();

        $AssetsModel = new AssetsModel();
        $assetAssignCount = [];
        $assetBufferCount = [];
        foreach ($category as $cat) {
            $query = $AssetsModel->select('id')
                ->where('category_id', $cat)
                ->where('status', 2)
                ->where('deleted_by', NULL)
                ->findAll();

            $assetAssignCount[] = count($query);

            $query2 = $AssetsModel->select('id')
                ->where('category_id', $cat)
                ->where('status', 1)
                ->where('deleted_by', NULL)
                ->findAll();

            $assetBufferCount[] = count($query2);
        }
        $category_array = $CategoryModel->select('category_name')->findAll();
        $category_name = implode(',', array_map(function ($element) {
            return "'" . $element['category_name'] . "'";
        }, $category_array));

        $data['spareAsset'] = implode(',', $assetBufferCount);
        $data['assignAsset'] = implode(',', $assetAssignCount);
        $data['category'] = $category_name;


        $CommonModel = new CommonModel();
        $LicenseModel = new LicenseModel();
        $LicenseName = $CommonModel->getData('license_name');

        $LicenseActiveCount = [];
        $LicenseExpiryCount = [];

        foreach ($LicenseName as $l_name) {


            $active_licence_query = $LicenseModel->select('id')
            ->where('license_name_id', $l_name['id'])
            ->groupStart()
                ->where('license.expiry_date >', date('Y-m-d'))
                ->orWhere('license.expiry_date', 0000-00-00)
            ->groupEnd()
            ->where('deleted_by', NULL)
            ->findAll();


            $LicenseActiveCount[] = count($active_licence_query);

            $expiry_licence_query = $LicenseModel->select('id')
            ->where('license.expiry_date !=', 0000-00-00)
            ->where('license_name_id', $l_name['id'])
            ->where('license.expiry_date <=', date('Y-m-d'))
            ->where('deleted_by', NULL)
            ->findAll();


            $LicenseExpiryCount[] = count($expiry_licence_query);
        }

        $LicenseNames = json_encode(array_column($LicenseName, 'name'));

        $data['LicenseActiveCount'] = implode(',', $LicenseActiveCount);
        $data['LicenseExpiryCount'] = implode(',', $LicenseExpiryCount);
        $data['LicenseNames'] = $LicenseNames;

        $VendorInvoiceModel = new VendorInvoiceModel();

        $vendorArray = $VendorInvoiceModel->select('YEAR(invoice_date) as year, MONTH(invoice_date) as month, SUM(total_amount) as total_amount')
            ->groupBy('YEAR(invoice_date), MONTH(invoice_date)')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->findAll();

        $vendorYearData = array();
        foreach ($vendorArray as $entry) {
            $year = $entry['year'];
            $vendorYearData[$year][] = $entry;
        }

        $vendorInvoice = array();
        foreach ($vendorYearData as $year => $asset_data) {
            $yearData = array_column($asset_data, 'total_amount', 'month');
            $yearData += array_fill(1, 12, 0);
            ksort($yearData);
            // print_r($yearData);die;
            $vendorInvoice[$year] = implode(',', array_values(array_map('floatval', $yearData)));


        }


        $data['vendor_invoice'] = $vendorInvoice;

        $VendorModel = new VendorModel();


        $Vendor_data = $VendorModel->select('id')->where('deleted_by', NULL)->findAll();

        $vendorListYearData = array();

        $distinctYears = $VendorInvoiceModel->distinct()->select('YEAR(invoice_date) as year')->findAll();
        $allYears = array_column($distinctYears, 'year');

        foreach ($Vendor_data as $Vendor) {
            $vendorListArray = $VendorInvoiceModel->select('YEAR(invoice_date) as year, vendor_id, SUM(total_amount) as total_amount')
                ->groupBy('YEAR(invoice_date), vendor_id')
                ->where('vendor_id', $Vendor['id'])
                ->orderBy('year', 'asc')
                ->findAll();

            $vendorData = array_fill_keys($allYears, 0);

            foreach ($vendorListArray as $entry) {
                $year = $entry['year'];
                $vendorData[$year] = $entry['total_amount'];
            }

            $vendorListYearData[$Vendor['id']] = $vendorData;
        }

        $combinedData = array();
        foreach ($vendorListYearData as $subArray) {
            foreach ($subArray as $year => $value) {
                if (!isset($combinedData[$year])) {
                    $combinedData[$year] = array();
                }
                $combinedData[$year][] = $value;
            }

        }

        $vendor_details = json_encode($combinedData, JSON_PRETTY_PRINT);

        $vendor_name = $VendorModel->select('supplier_name')->where('deleted_by', NULL)->findAll();

        $new_vendor_array = array_map(function ($string) {
            $words = explode(' ', $string);
            return implode(' ', array_slice($words, 0, 2));
        }, array_column($vendor_name, 'supplier_name'));

        $data['vendor_details'] = $vendor_details;
        $data['vendor_names'] = json_encode($new_vendor_array);


        return view('includes/header', $data)
            . view('index.php')
            . view('includes/footer');
    }
}
