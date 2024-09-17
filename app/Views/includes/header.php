<?php
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?php echo PROJECT_NAME?></title>
    <!-- CSS files -->
    <link href="<?php echo base_url();?>/public/assets/img/favicon.svg" sizes="32x32" rel="icon">
    <link href="<?php echo base_url();?>/public/assets/css/template.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>/public/assets/css/template-icons.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>/public/assets/css/common.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>/public/assets/css/sweetalert2.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>/public/assets/libs/daterangepicker/daterangepicker.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>/public/assets/libs/datepicker/bootstrap-datepicker.min.css" rel="stylesheet"/>
    <script src="<?php echo base_url();?>/public/assets/js/jquery.min.js" ></script>
    <script src="<?php echo base_url();?>/public/assets/js/jquery_validate.js" ></script>
    <link href="<?php echo base_url();?>/public/assets/libs/select2/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="<?php echo base_url();?>/public/assets/libs/select2/dist/js/select2.min.js" ></script>

    <style>
    label.error {
  color: red !important;
}


    </style>
  </head>
  <body class="">
    <div class="page">
      <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3" style="padding: 0px;font-family: futura-pt, Verdana, Arial, sans-serif;">
            <a href="<?php echo base_url();?>">
              <img src="<?php echo base_url();?>/public/assets/img/digitalzone_logo.svg" alt="<?php echo PROJECT_NAME?>" style="height: 2.5rem;" class="navbar-brand-image">
            </a> <!--  | <?php echo PROJECT_NAME?> -->
          </h1>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item d-none d-md-flex me-3">
              <div class="btn-list">

              </div>
            </div>
            <!-- <div class="d-none d-md-flex">
              <div class="nav-item dropdown d-none d-md-flex me-3">
                <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                  <i class="ti ti-bell"></i>
                  <span class="badge bg-red"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Last updates</h3>
                    </div>
                    <div class="list-group list-group-flush list-group-hoverable">
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                          <div class="col text-truncate">
                            <a href="#" class="text-body d-block">Example 1</a>
                            <div class="d-block text-muted text-truncate mt-n1">
                              Change deprecated html tags to text decoration classes (#29604)
                            </div>
                          </div>
                          <div class="col-auto">
                            <a href="#" class="list-group-item-actions">
                              <i class="ti ti-star text-muted"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-auto"><span class="status-dot d-block"></span></div>
                          <div class="col text-truncate">
                            <a href="#" class="text-body d-block">Example 2</a>
                            <div class="d-block text-muted text-truncate mt-n1">
                              justify-content:between ⇒ justify-content:space-between (#29734)
                            </div>
                          </div>
                          <div class="col-auto">
                            <a href="#" class="list-group-item-actions show">
                              <i class="ti ti-star text-yellow"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-auto"><span class="status-dot d-block"></span></div>
                          <div class="col text-truncate">
                            <a href="#" class="text-body d-block">Example 3</a>
                            <div class="d-block text-muted text-truncate mt-n1">
                              Update change-version.js (#29736)
                            </div>
                          </div>
                          <div class="col-auto">
                            <a href="#" class="list-group-item-actions">
                              <i class="ti ti-star text-muted"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-auto"><span class="status-dot status-dot-animated bg-green d-block"></span></div>
                          <div class="col text-truncate">
                            <a href="#" class="text-body d-block">Example 4</a>
                            <div class="d-block text-muted text-truncate mt-n1">
                              Regenerate package-lock.json (#29730)
                            </div>
                          </div>
                          <div class="col-auto">
                            <a href="#" class="list-group-item-actions">
                              <i class="ti ti-star text-muted"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
            <div class="d-none d-md-flex">
              <a href="#" class="nav-link px-0 theme-set hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                <i class="ti ti-sun" width="24" height="24" ></i>
              </a>
              <a href="#" class="nav-link px-0 theme-set hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                <i class="ti ti-moon" width="24" height="24" ></i>
              </a>
            </div>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                <div class="col-auto">
                  <span class="avatar rounded">
                    <?php
                        $name_words = explode(" ", session('full_name'));
                        $name_acronym = "";

                        foreach ($name_words as $nw) {
                          $name_acronym .= mb_substr($nw, 0, 1);
                        }
                        echo $name_acronym;
                    ?>
                  </span>
                </div>
               <!--  <span class="avatar avatar-sm" style="background-image: url(<?php echo base_url();?>/public/assets/img/avatars/default.png)"></span> -->
                <div class="d-none d-xl-block ps-2">
                  <div><?= session('full_name');?></div>
                  <div class="mt-1 small text-muted">
                    <?php
                        foreach (USER_TYPE as $key => $value) {
                         echo session('user_type') == $key ? $value : '';
                        }
                    ?>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="<?php echo base_url();?>/my-change-password" class="dropdown-item">Change Password</a>
                <a href="<?php echo base_url();?>/logout"  onclick="return confirm('Are you sure?');" class="dropdown-item">Logout</a>
              </div>
            </div>
          </div>
        </div>
      </header>
      <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar navbar-light">
            <div class="container-xl">
              <ul class="navbar-nav ">
                <li class="nav-item home">
                  <a class="nav-link nav_active" href="<?php echo base_url();?>/" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <i class="ti ti-home"></i>
                    </span>
                    <span class="nav-link-title">
                      Home
                    </span>
                  </a>
                </li>
                <?php
                if(in_array( ACCESS_USER, session('user_access'))){
                ?>
                <li class="nav-item users">
                  <a class="nav-link nav_active" href="<?php echo base_url();?>/users/list" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <i class="ti ti-users"></i>
                    </span>
                    <span class="nav-link-title">
                     Users & Allocate Assets
                    </span>
                  </a>
                </li>
                <?php
                }
                ?>
                <?php
                if(in_array( ACCESS_ASSETS, session('user_access'))){
                ?>
                <li class="nav-item assets">
                  <a class="nav-link nav_active" href="<?php echo base_url();?>/assets/list" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <i class="ti ti-keyboard"></i>
                    </span>
                    <span class="nav-link-title">
                     Assets
                    </span>
                  </a>
                </li>
                <?php
                }
                ?>
                <li class="nav-item setting_sub_nav dropdown">
                  <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <i class="ti ti-settings"></i>
                    </span>
                    <span class="nav-link-title">
                      Settings
                    </span>
                  </a>
                  <div class="dropdown-menu " data-bs-popper="static">
                    <div class="dropdown-menu-columns">
                      <div class="dropdown-menu-column">
                        <?php

                        if(in_array(ACCESS_CATEGORY, session('user_access'))){
                        ?>
                          <a class="dropdown-item setting_sub_nav_active" href="<?php echo base_url();?>/category/list" >
                            Category
                          </a>
                        <?php
                        }
                        ?>


                        <?php
                        if(in_array( ACCESS_MANUFACTURER, session('user_access'))){
                        ?>
                          <a class="dropdown-item setting_sub_nav_active" href="<?php echo base_url();?>/manufacturer/list" >
                            Manufacturer
                          </a>
                        <?php
                        }
                        ?>
                        <?php
                        if(in_array( ACCESS_OFFICE_LOCATION, session('user_access'))){
                        ?>
                          <a class="dropdown-item setting_sub_nav_active" href="<?php echo base_url();?>/office_location/list" >
                            Office Location
                          </a>
                        <?php
                        }
                        ?>
                        <?php
                        if(in_array( ACCESS_LICENSE, session('user_access'))){
                        ?>
                          <a class="dropdown-item setting_sub_nav_active" href="<?php echo base_url();?>/licenses/list" >
                            License
                          </a>
                        <?php
                        }
                        ?>
                        <?php
                        if(in_array( ACCESS_APPLICATION, session('user_access'))){
                        ?>
                          <a class="dropdown-item setting_sub_nav_active" href="<?php echo base_url();?>/application/list" >
                            Application
                          </a>
                        <?php
                        }
                        ?>
                        <?php
                        if(in_array( ACCESS_VENDOR, session('user_access'))){
                        ?>
                          <a class="dropdown-item setting_sub_nav_active" href="<?php echo base_url();?>/vendor/list" >
                            Vendor
                          </a>
                        <?php
                        }
                        ?>
                        <?php
                        if(in_array( ACCESS_VENDOR_INVOICE, session('user_access'))){
                        ?>
                          <a class="dropdown-item setting_sub_nav_active" href="<?php echo base_url();?>/vendor_invoice/list" >
                            Vendor Invoice
                          </a>
                        <?php
                        }
                        ?>
                        <?php
                        if(session('user_type') == ADMIN || TECHNICIAN){
                        ?>
                          <a class="dropdown-item setting_sub_nav_active" href="<?php echo base_url();?>/import" >
                            Import Data
                          </a>
                        <?php
                        }
                        ?>
                          <?php
                        if(session('user_type') == ADMIN){
                        ?>
                          <a class="dropdown-item setting_sub_nav_active" href="<?php echo base_url();?>/log-details" >
                           log Details
                          </a>
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </li>
                <!-- <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="4" /><circle cx="12" cy="12" r="9" /><line x1="15" y1="15" x2="18.35" y2="18.35" /><line x1="9" y1="15" x2="5.65" y2="18.35" /><line x1="5.65" y1="5.65" x2="9" y2="9" /><line x1="18.35" y1="5.65" x2="15" y2="9" /></svg>
                    </span>
                    <span class="nav-link-title">
                      Help
                    </span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo base_url();?>">
                      Documentation
                    </a>
                    <a class="dropdown-item" href="<?php echo base_url();?>">
                      Changelog
                    </a>

                  </div>
                </li> -->
              </ul>
             <!--  <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                <form action="." method="get">
                  <div class="input-icon">
                    <span class="input-icon-addon">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
                    </span>
                    <input type="text" value="" class="form-control" placeholder="Search…" aria-label="Search in website">
                  </div>
                </form>
              </div> -->
            </div>
          </div>
        </div>
      </div>
      <div class="page-wrapper">
