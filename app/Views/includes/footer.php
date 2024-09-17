<?php
  if(session()->has("error")){
  ?>
    <script type="text/javascript">
      $(document).ready(function() {
        Swal.fire({
          icon: "error",
          text: "<?php echo session("error"); ?>",
        });
      });  
    </script>
  <?php
  }
  ?>
  <?php
  if(session()->has("success")){
  ?>
    <script type="text/javascript">
      $(document).ready(function() {
        Swal.fire({
          icon: "success",
          text: "<?php echo session("success"); ?>",
        });
      });
   </script>
  <?php
  }
?>
     <footer class="footer footer-transparent d-print-none">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-lg-auto ms-lg-auto">
               <!--  <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item"><a href="./docs/index.html" class="link-secondary">Documentation</a></li>
                  <li class="list-inline-item"><a href="./license.html" class="link-secondary">License</a></li>
                </ul> -->
              </div>
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    Copyright &copy; <?php echo date('Y');?>
                    <a href="<?php echo base_url();?>" class="link-secondary"><?php echo PROJECT_NAME ?></a>.
                    All rights reserved.
                  </li>
                  <!-- <li class="list-inline-item">
                    <a href="./changelog.html" class="link-secondary" rel="noopener">
                      v1.0.0-beta11
                    </a>
                  </li> -->
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New report</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="Your report name">
            </div>
            <label class="form-label">Report type</label>
            <div class="form-selectgroup-boxes row mb-3">
              <div class="col-lg-6">
                <label class="form-selectgroup-item">
                  <input type="radio" name="report-type" value="1" class="form-selectgroup-input" checked>
                  <span class="form-selectgroup-label d-flex align-items-center p-3">
                    <span class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </span>
                    <span class="form-selectgroup-label-content">
                      <span class="form-selectgroup-title strong mb-1">Simple</span>
                      <span class="d-block text-muted">Provide only basic data needed for the report</span>
                    </span>
                  </span>
                </label>
              </div>
              <div class="col-lg-6">
                <label class="form-selectgroup-item">
                  <input type="radio" name="report-type" value="1" class="form-selectgroup-input">
                  <span class="form-selectgroup-label d-flex align-items-center p-3">
                    <span class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </span>
                    <span class="form-selectgroup-label-content">
                      <span class="form-selectgroup-title strong mb-1">Advanced</span>
                      <span class="d-block text-muted">Insert charts and additional advanced analyses to be inserted in the report</span>
                    </span>
                  </span>
                </label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-8">
                <div class="mb-3">
                  <label class="form-label">Report url</label>
                  <div class="input-group input-group-flat">
                    <span class="input-group-text">
                     
                    </span>
                    <input type="text" class="form-control ps-0"  value="report-01" autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Visibility</label>
                  <select class="form-select">
                    <option value="1" selected>Private</option>
                    <option value="2">Public</option>
                    <option value="3">Hidden</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Client name</label>
                  <input type="text" class="form-control">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Reporting period</label>
                  <input type="date" class="form-control">
                </div>
              </div>
              <div class="col-lg-12">
                <div>
                  <label class="form-label">Additional information</label>
                  <textarea class="form-control" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>
            <a href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
              <i class="ti ti-copyright"></i>
              Create new report
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="modal modal-blur fade" id="imagemodal" tabindex="-1" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Preview</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <img src="" id="imagepreview" style="width: auto;" >
          </div>
          <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div> -->
    <script type="text/javascript">
      $(".imageModel").on("click", function() {
         $('#imagepreview').attr('src', $('.imageresource').attr('src')); 
         $('#imagemodal').modal('show'); 
      });
      $(function(){
           $(".number").keypress(function (e) {
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)){
              //$("#errmsg").html("Number Only").stop().show().fadeOut("slow");
              alert('Number Only');
              return false;
            }
           });
      });
      if(sessionStorage.getItem("theme-set") == 'hide-theme-light'){
        $("body").attr("class", "theme-light");

      }else if(sessionStorage.getItem("theme-set") == 'hide-theme-dark'){
        $("body").attr("class", "theme-dark");
      }else{
        $("body").attr("class", "theme-light");
      }
      $(document).ready(function () {
          $('.theme-set').click(function (e) {
              if(sessionStorage.getItem("theme-set") == 'hide-theme-dark'){
                sessionStorage.setItem("theme-set", "hide-theme-light");
                $("body").attr("class", "theme-light");
              }else if(sessionStorage.getItem("theme-set") == 'hide-theme-light'){
                sessionStorage.setItem("theme-set", "hide-theme-dark");
                $("body").attr("class", "theme-dark");
              }else{
                sessionStorage.setItem("theme-set", "hide-theme-light");
                $("body").attr("class", "theme-light");
              }
              
          });
      });
      $(document).ready(function () {
          $('.nav_active').click(function (e) {
             sessionStorage.setItem("nav-active", $(this).attr('href'));
          });
      });
      $(document).ready(function() {
        var pathname = window.location.href;
        var pathname_arr=pathname.split('/');
        var nav_active_path=pathname_arr[4];
        $('.br-sideleft .br-sideleft-menu').find('.active').removeClass('active');
        // $('.nav_active').each(function() {
        //     if($(this).attr('href') == pathname) {
        //       console.log(nav_active_path);
        //         $(this).parent().addClass('active');
        //     }else{
        //       if(sessionStorage.getItem("nav-active")){
        //         if($(this).attr('href') == sessionStorage.getItem("nav-active")){
        //           $(this).parent().addClass('active');
        //         }
        //       }
        //     }
        // });
        $('.nav_active').each(function() {
          if(nav_active_path==''){
            $('.home').addClass('active');
          }else{
            $('.'+nav_active_path).addClass('active');
          }
        });
      });
      $(document).ready(function () {
          $('.setting_sub_nav_active').click(function (e) {
             sessionStorage.setItem("nav-active", $(this).attr('href'));
          });
      });
      $(document).ready(function() {
        var pathname = window.location.href;
        $('.br-sideleft .br-sideleft-menu').find('.active').removeClass('active');
        $('.setting_sub_nav_active').each(function() {
            if($(this).attr('href') == pathname) {
                $(this).addClass('active');
                $('.setting_sub_nav').addClass('active');
            }else{
              if(sessionStorage.getItem("nav-active")){
                if($(this).attr('href') == sessionStorage.getItem("nav-active")){
                  $(this).addClass('active');
                  $('.setting_sub_nav').addClass('active');
                }
              }
            }
        });
      });
   </script>
    <!-- Libs JS -->
    <!-- <script src="<?php echo base_url();?>/public/assets/libs/apexcharts/dist/apexcharts.min.js" defer></script>
    <script src="<?php echo base_url();?>/public/assets/libs/jsvectormap/dist/js/jsvectormap.min.js" defer></script>
    <script src="<?php echo base_url();?>/public/assets/libs/jsvectormap/dist/maps/world.js" defer></script>
    <script src="<?php echo base_url();?>/public/assets/libs/bootstrap/dist/js/bootstrap.min.js" defer></script>
    <script src="<?php echo base_url();?>/public/assets/libs/jsvectormap/dist/maps/world-merc.js" defer></script> -->
    <!--  Core -->
    
    <script src="<?php echo base_url();?>/public/assets/libs/select2/dist/js/select2.full.min.js" ></script>
    <script src="<?php echo base_url();?>/public/assets/js/template.min.js" defer></script>
    <script src="<?php echo base_url();?>/public/assets/js/multiselect-dropdown.js" defer></script>
    <script src="<?php echo base_url();?>/public/assets/js/sweetalert2.all.min.js" defer></script>
    <script src="<?php echo base_url() ?>/public/assets/libs/daterangepicker/moment.min.js" defer></script>
    <script src="<?php echo base_url() ?>/public/assets/libs/datepicker/bootstrap-datepicker.min.js" defer></script>
    <script src="<?php echo base_url() ?>/public/assets/libs/daterangepicker/daterangepicker.min.js" defer></script>
    <script type="text/javascript">
      $(function(){
          $('.datepicker').datepicker({
            // startDate: '-4d',
            format: 'yyyy-mm-dd'
          });
      });
     
      
   </script>
  </body>
</html>