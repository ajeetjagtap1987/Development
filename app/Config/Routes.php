<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/login', 'Login::login');
$routes->get('/logout', 'Login::logout');
$routes->post('/user-login', 'Login::userLogin');



// User
$routes->get('/users/list', 'UserRegister::list');
$routes->get('/users/create', 'UserRegister::create');
$routes->post('/users/user-register', 'UserRegister::userInsert');
$routes->get('/users/edit/(:any)', 'UserRegister::edit/$1');
$routes->post('/users/user-update/(:any)', 'UserRegister::userUpdate/$1');
$routes->post('/users/filter/(:any)', 'UserRegister::userFilter/$1');
$routes->get('/users/change-password/(:any)', 'UserRegister::changePassword/$1');
$routes->post('/users/update-password/(:any)', 'UserRegister::updatePassword/$1');
$routes->get('/users/status-change/(:num)/(:any)', 'UserRegister::userStatusChange/$1/$2');
$routes->get('/users/login-access/(:any)', 'UserRegister::userLoginAccess/$1');
$routes->get('/users/export', 'UserRegister::userExport');
$routes->post('/users/export-data', 'UserRegister::userExportData');
$routes->post('/users/delete', 'UserRegister::userDelete');
//asset , license, application allotment report
$routes->get('/users-allotment_report/export', 'UserRegister::userAllotmentExport');

// User
$routes->get('/users/details/(:any)', 'UserDetails::list/$1');
$routes->post('/users-assets/filter/(:any)', 'UserDetails::userAssetsFilter/$1');
$routes->post('/users-assets/assign/(:any)', 'UserDetails::userAssetsAssign/$1');
$routes->post('/users-assets/revoke/(:any)', 'UserDetails::userAssetsRevoke/$1');
$routes->post('/users-licenses/filter/(:any)', 'UserDetails::userLicensesFilter/$1');
$routes->post('/users-licenses/assign/(:any)', 'UserDetails::userLicensesAssign/$1');
$routes->post('/users-licenses/revoke/(:any)', 'UserDetails::userLicensesRevoke/$1');
$routes->post('/users-application/filter/(:any)', 'UserDetails::userApplicationFilter/$1');
$routes->post('/users-application/assign/(:any)', 'UserDetails::userApplicationAssign/$1');
$routes->post('/users-application/revoke/(:any)', 'UserDetails::userApplicationRevoke/$1');


$routes->post('licenses/get_keys', 'UserDetails::licenseGetKeys');

// category
$routes->get('/category/list', 'Category::list');
$routes->get('/category/create', 'Category::create');
$routes->post('/category/insert', 'Category::categoryInsert');
$routes->get('/category/edit/(:any)', 'Category::edit/$1');
$routes->post('/category/update/(:any)', 'Category::categoryUpdate/$1');
$routes->post('/category/filter/(:any)', 'Category::categoryFilter/$1');

$routes->get('/token', 'CommonController::gettoken');


//departmemt
// $routes->get('/department/list', 'Department::list');
// $routes->post('/department/filter/(:any)', 'Department::departmentFilter/$1');


// manufacturer
$routes->get('/manufacturer/list', 'Manufacturer::list');
$routes->get('/manufacturer/create', 'Manufacturer::create');
$routes->post('/manufacturer/insert', 'Manufacturer::manufacturerInsert');
$routes->get('/manufacturer/edit/(:any)', 'Manufacturer::edit/$1');
$routes->post('/manufacturer/update/(:any)', 'Manufacturer::manufacturerUpdate/$1');
$routes->post('/manufacturer/filter/(:any)', 'Manufacturer::manufacturerFilter/$1');

// office_location
$routes->get('/office_location/list', 'OfficeLocation::list');
$routes->get('/office_location/create', 'OfficeLocation::create');
$routes->post('/office_location/insert', 'OfficeLocation::officeLocationInsert');
$routes->get('/office_location/edit/(:any)', 'OfficeLocation::edit/$1');
$routes->post('/office_location/update/(:any)', 'OfficeLocation::officeLocationUpdate/$1');
$routes->post('/office_location/filter/(:any)', 'OfficeLocation::officeLocationFilter/$1');

// license
$routes->get('/licenses/list', 'License::list');
$routes->get('/licenses/create', 'License::create');
$routes->post('/licenses/insert', 'License::licenseInsert');
$routes->get('/licenses/autocomplete', 'License::licensesAutocomplete');
$routes->get('/licenses/edit/(:any)', 'License::edit/$1');
$routes->post('/licenses/update/(:any)', 'License::licenseUpdate/$1');
$routes->post('/licenses/filter/(:any)', 'License::licenseFilter/$1');
$routes->get('/get-license-by-id/(:any)', 'License::getlicenseById/$1');
$routes->get('/licenses/export', 'License::licenseExport');
$routes->post('/licenses/export-data', 'License::exportData');
$routes->post('/licenses/delete', 'License::licenseDelete');
$routes->get('/licenses/details/(:any)', 'License::details/$1');

// application
$routes->get('/application/list', 'Application::list');
$routes->get('/application/create', 'Application::create');
$routes->post('/application/insert', 'Application::applicationInsert');
$routes->get('/appliaction/autocomplete', 'Application::applicationAutocomplete');
$routes->get('/application/edit/(:any)', 'Application::edit/$1');
$routes->post('/application/update/(:any)', 'Application::applicationUpdate/$1');
$routes->post('/application/filter/(:any)', 'Application::applicationFilter/$1');
$routes->post('/application/delete', 'Application::applicationDelete');

// vendor
$routes->get('/vendor/list', 'Vendor::list');
$routes->get('/vendor/create', 'Vendor::create');
$routes->post('/vendor/insert', 'Vendor::vendorInsert');
$routes->get('/vendor/edit/(:any)', 'Vendor::edit/$1');
$routes->post('/vendor/update/(:any)', 'Vendor::vendorUpdate/$1');
$routes->get('/vendor/view/(:any)', 'Vendor::view/$1');
$routes->post('/vendor/filter/(:any)', 'Vendor::vendorFilter/$1');
$routes->get('/vendor/gst_list/(:any)', 'Vendor::vendorGstList/$1');
$routes->post('/vendor/gstlist_filter/(:any)', 'Vendor::vendorGstListFilter/$1');
$routes->get('/vendor_gst/create/(:any)', 'Vendor::vendorGstcreate/$1');
$routes->post('/vendor_gst/insert/(:any)', 'Vendor::vendorGstInsert/$1');
$routes->get('/vendor_gst/edit/(:any)', 'Vendor::vendorGstedit/$1');
$routes->post('/vendor_gst/update/(:any)', 'Vendor::vendorGstUpdate/$1');
$routes->post('/get_state', 'Vendor::get_State');


// vendor_invoice
$routes->get('/vendor_invoice/list', 'VendorInvoice::list');
$routes->get('/vendor_invoice/create', 'VendorInvoice::create');
$routes->post('/vendor_invoice/insert', 'VendorInvoice::vendorInvoiceInsert');
$routes->get('/vendor_invoice/edit/(:any)', 'VendorInvoice::edit/$1');
$routes->post('/vendor_invoice/update/(:any)', 'VendorInvoice::vendorInvoiceUpdate/$1');
$routes->post('/vendor_invoice/filter/(:any)', 'VendorInvoice::vendorInvoiceFilter/$1');

// assets
$routes->get('/assets/list', 'Assets::list');
$routes->get('/assets/create', 'Assets::create');
$routes->post('/assets/insert', 'Assets::assetsInsert');
$routes->get('/assets/autocomplete', 'Assets::assetsAutocomplete');
$routes->get('/assets/edit/(:any)', 'Assets::edit/$1');
$routes->post('/assets/update/(:any)', 'Assets::assetsUpdate/$1');
$routes->get('/assets/details/(:any)', 'Assets::details/$1');
$routes->post('/assets/filter/(:any)', 'Assets::assetsFilter/$1');
$routes->get('/get-vendor-invoice-by-vendor/(:num)', 'Assets::getVendorInvoiceByVendor/$1');
$routes->get('/get-assets-by-id/(:any)', 'Assets::getAssetsById/$1');
$routes->get('/get-assetid-by-category/(:any)', 'Assets::getAssetsIdByCategory/$1');
$routes->post('/assets/get_purchase_date', 'Assets::get_purchaseDate');

$routes->get('/assets/export', 'Assets::assetExport');
$routes->post('/assets/export-data', 'Assets::export');
$routes->post('/assets/delete', 'Assets::deleteAsset');


// assets
$routes->get('/import', 'ImportData::index');
$routes->post('/import-asset-file', 'ImportData::importAssetFile');
$routes->post('/import-user-file', 'ImportData::importUserFile');
$routes->post('/import-user-assign-assets-file', 'ImportData::importUserAssignAssetFile');

$routes->get('/download-import-file-header/(:num)', 'ImportData::downloadImportFileHeader/$1');

//log
$routes->get('/log-details', 'Log::index');
$routes->post('/log/filter/(:any)', 'Log::logFilter/$1');



$routes->get('/', 'Dashboard::index');

$routes->get('(:any)', 'Pages::view/$1');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
