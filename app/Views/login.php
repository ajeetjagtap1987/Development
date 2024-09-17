<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Log In - <?php echo PROJECT_NAME?></title>
    <!-- CSS files -->
    <link href="<?php echo base_url();?>/public/assets/img/favicon.svg" sizes="32x32" rel="icon">
    <link href="<?php echo base_url();?>/public/assets/css/template.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>/public/assets/css/template-icons.min.css" rel="stylesheet"/>
    <script src="<?php echo base_url();?>/public/assets/js/jquery.min.js" ></script>
  </head>
  <body  class=" border-top-wide border-primary d-flex flex-column">
    <div class="page page-center">
      <div class="container-tight py-4">
        <div class="text-center">
          <a href="<?php echo base_url();?>/login" class="navbar-brand navbar-brand-autodark">
            <img src="<?php echo base_url();?>/public/assets/img/digitalzone_logo.svg" width="180" alt="<?= PROJECT_NAME?>">
          </a>
        </div>
        <div class="text-center mb-4">
          <!-- <h1 style="font-family: futura-pt, Verdana, Arial, sans-serif;"><?php echo PROJECT_NAME?></h1> -->
        </div>
        <?php
        if( isset($error) ) {
        ?>
          <div class="alert alert-danger alert-dismissible">
            <?php echo $error; ?>
          </div>  
        <?php
        }
        ?>
        <?php
        if( isset($success) ) {
        ?>
          <div class="alert alert-success alert-dismissible">
            <?php echo $success; ?>
          </div>  
        <?php
        }
        ?>
        <?php
          if(session()->has("error")){
          ?>
            <div class="alert alert-danger alert-dismissible">
              <?php echo session("error"); ?>
            </div>  
          <?php
          }
          ?>
          <?php
          if(session()->has("success")){
          ?>
            <div class="alert alert-success alert-dismissible">
              <?php echo session("success"); ?>
            </div>  
          <?php
          }
        ?>
        <form class="card card-md" action="<?php echo base_url();?>/user-login" method="post" autocomplete="off">
		 <?= csrf_field(); // Add the CSRF token as a hidden input field ?>
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Login to your account</h2>
            <div class="mb-3">
              <label class="form-label">Email address</label>
              <input type="email" name="email" class="form-control" placeholder="Enter email" autocomplete="off" required>
            </div>
            <div class="mb-2">
              <div class="input-group input-group-flat">
                <input type="password" name="password" class="form-control password"  placeholder="Password" autocomplete="off" required>
                <span class="input-group-text" style="padding:0px">
                  <a href="#" class="link-secondary showpassword" title="Show password" data-bs-toggle="tooltip" style="padding: 0px 4px;">
                    <i class="ti ti-eye"></i>
                  </a>
                </span>
              </div>
            </div>
            <!-- <div class="mb-2">
              <label class="form-check">
                <input type="checkbox" class="form-check-input"/>
                <span class="form-check-label">Remember me on this device</span>
              </label>
            </div> -->
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100">Log In</button>
            </div>
          </div>
        </form>
        <!-- <div class="text-center text-muted mt-3">
          Don't have account yet? <a href="./sign-up.html" tabindex="-1">Sign up</a>
        </div> -->
      </div>
    </div>
    <script src="<?php echo base_url();?>/public/assets/js/template.min.js" defer></script>
    <script type="text/javascript">
      $(".showpassword").click(function(){
          if ($('.password').attr('type') === "password") {
            $(".password").prop("type", "text");
          } else {
            $(".password").prop("type", "password");
          }
      });
       
    </script>
  </body>
</html>