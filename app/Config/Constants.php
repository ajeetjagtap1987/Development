<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');


define('PROJECT_NAME', 'IT Inventory Management');

//Status
define('ACTIVE', '1');
define('INACTIVE', '0');
define('RESIGNED', '2');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

// User Type 
define('ADMIN', 1);
define('TECHNICIAN', 2);
define('EMPLOYEE', 3);

define ("USER_TYPE",array (
                            1 =>'Admin',
                            2 =>'Technician',
                            3 =>'Employee'
                        ));



// Access
define('ACCESS_USER',1);
define('ACCESS_CATEGORY',2);
define('ACCESS_MANUFACTURER',3);
define('ACCESS_OFFICE_LOCATION',4);
define('ACCESS_LICENSE',5);
define('ACCESS_VENDOR',6);
define('ACCESS_VENDOR_INVOICE',7);
define('ACCESS_ASSETS',8);
define('ACCESS_ASSETS_ASSIGN',9);
define('ACCESS_APPLICATION',10);


//User work location
define('WORK_LOCATION_OFFICE',1);
define('WORK_LOCATION_HOME',2);

// Category Type 
define('CATEGORY_ASSET', 1);
define('CATEGORY_LICENSE', 2);
define('CATEGORY_APPLICATION', 3);

define ("CATEGORY_TYPE",array (
                            1 =>'Asset',
                            2 =>'License',
                            3 =>'Application'
                        )); 





// define('REQUESTED', 1);
// define('IN_PROGRESS', 2);
// define('INTEGRATED', 3);
// define('HOLD_REQUEST', 4);
// define('HOLD_RELEASE', 5);
// define('STOP', 6);

// define ("REQUEST_STATUS",array (
//                                     1 =>'Request placed',
//                                     2 =>'Request In-Progress',
//                                     3 =>'Integrated',
//                                     4 =>'Hold Request',
//                                     5 =>'Hold Release',
//                                     6 =>'Stop',
//                                 )); 


// define ("REQUEST_STATUS_COLOR",array (
//                                     1 =>'bg-azure',
//                                     2 =>'bg-orange',
//                                     3 =>'bg-success',
//                                     4 =>'bg-success',
//                                     5 =>'bg-success',
//                                     6 =>'bg-danger',
//                                 )); 


define('DATETIMEFORMAT', 'd-M-Y h:i A');
define('DATEFORMAT', 'd-M-Y');

define('PUBLIC_PATH', 'public/');

//File Upload
define('VENDOR_PANCARD', 1);
define('VENDOR_INVOICE', 2);

// Assets Status
define('ASSET_BUFFER', 1);
define('ASSET_ASSIGN', 2);
define('ASSET_DAMAGE', 3);
define('ASSET_REPAIR', 4);
define ("ASSET_STATUS",array (
                            1 =>'Buffer',
                            2 =>'Assign',
                            3 =>'Damage',
                            4 =>'Repair'
                        )); 


// User Assets Assign Status
define('ASSIGNED', 1);
define('REVOKE', 2);

// User Assets Assign Limit
define('USER_ASSIGN_LIMIT', 2);

