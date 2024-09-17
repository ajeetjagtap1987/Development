  <div class="card mb-2">
    <div class="card-header bg-primary text-white" style="padding: 0.5rem 1.2rem;">
      <h3 class="card-title">Licenses</h3>
      <button class="btn btn-icon bt-sm btn-light" style="min-height: auto;right: 1.2rem;position: absolute;" data-bs-toggle="modal" data-bs-target="#licenses_assets_model"><i class="ti ti-plus"></i>Assign&nbsp;</button>
    </div>
    <div class="card-body" style="padding: 1rem 0rem">
      <div class="row">
        <div class="overlay-wrapper">
          <div class="overlay loader"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
          </div>
          <div class="licenses_filter_data">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal modal-blur  modal-xl fade" id="licenses_assets_model" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Assign License</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?php echo base_url(); ?>/users-licenses/assign/<?php echo $u_id; ?>" method="post" id="assign_license" autocomplete="off">
          <div class="modal-body">
            <div class="row">

              <div class="col-6">

                <div class="form-group ">
                  <label class="form-label required">license Name</label>
                  <div>
                    <select class="license_name form-select" id="license_name" name="software" data-live-search="true" style="width: 100%; height:36px;display: initial;" required="true">
                    <option value="">Select license</option>
                    <?php
                      if (count($license) > 0) {
                        foreach ($license as $d) {
                          echo '<option value="' . $d['id'] . '">' . $d['name'] . '</option>';
                        }
                      }
                      ?>
                    </select>



                  </div>
                </div>


                <br>


                <div class="form-group  " id="key_div">
                  <label class="form-label required">Keys</label>
                  <div>

                    <select class="keys form-select" id="keys" name="license_id[]" multiple="multiple" data-live-search="true" style="width: 100%; height:36px;display: initial;" required="true">

                    </select>



                  </div>
                </div>

                <input type="hidden" id="no_product_key_license" name="no_product_key_license">
              </div>


              <div class="col-6">
                <div class="form-group col-md-12 mb-3 license_info">
                </div>
              </div>


            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary submit_button" onclick="return confirm('Are you sure?');">Submit</button>
            <button class="btn btn-primary loader_button" type="button" disabled>
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              Loading...
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="revoke_license_model" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Revoke Assets</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?php echo base_url(); ?>/users-licenses/revoke/<?php echo $u_id; ?>" method="post" id="revoke_license" autocomplete="off">
          <div class="modal-body">
            <div class="form-group col-md-12 mb-3 ">
              <input type="hidden" name="user_license_id" id="revoke_user_license_id" class="form-control" required>
              <label class="form-label required">Revoke Reason</label>
              <div>
                <textarea type="text" name="revoke_reason" class="form-control revoke_reason" placeholder="Revoke Reason" rows="4" maxlength="250" required></textarea>
                <span class="form-label-description revoke_reason_count"></span>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary submit_button" onclick="return confirm('Are you sure?');">Submit</button>
            <button class="btn btn-primary loader_button" type="button" disabled>
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              Loading...
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?= csrf_field(); ?>
  <script type="text/javascript">
    $(".keys").select2({
      closeOnSelect: false,
      placeholder: "Select Keys",
      allowClear: true,
      templateResult: formatOption,

      dropdownParent: $("#licenses_assets_model"),
    });


    // $('.license_name').select2({
    //   dropdownParent: $('#licenses_assets_model'),
    //   placeholder: 'Search and Select Software',




    // ajax: {
    //   url: '<?php echo base_url() ?>/licenses/autocomplete',
    //   dataType: 'json',
    //   method: 'GET',
    //   delay: 250,
    //   data: function(data) {
    //     return {
    //       searchTerm: data.term // search term
    //     };
    //   },
    //   processResults: function(response) {
    //     return {
    //       results: response
    //     };
    //   },
    //   cache: true
    // }
    // });


    $("#license_name").change(function(event) {

      var selectElement = $('#keys');
      selectElement.empty();

      var software = $(this).val();

      event.preventDefault();


      $.ajax({
        url: "<?php echo base_url() ?>/token/",
        method: "GET",
        success: function(token) {


          $.ajax({
            url: "<?php echo base_url('licenses/get_keys'); ?>",
            method: "POST",
            data: {
              software: software,
              csrf_test_name: token
            },
            dataType: 'json',
            success: function(data) {

    $.each(data, function(index, item) {

      if (item.product_key) { // Check if item.product_key exists
        $('#keys').append('<option value="' + item.id + '">' + item.product_key + '</option>');
      }
      else{
        $('#keys').prop('required', false);
    $('#key_div').css('display', 'none');

    $('#no_product_key_license').val(item.id);

      }
    });




            }

          })

        }
      });

    });




    $(document).ready(function() {
      licenses_filter_data(1);
    });
    //Licenses list filter
    $('.licenses_clear_filter').click(function() {
      window.location.href = '<?php echo base_url() ?>/users/details/<?php echo $u_id; ?>' + '#val_licenses';
    });
    $('#licenses_keyword').keyup(function() {
      if (this.value.length < 4) return;
      licenses_filter_data(1);
    });

    function licenses_filter_data(page) {
      $('.loader').css('display', 'flex');
      var show_per_page = $('.licenses_show_per_page').val();
      var user_id = '<?php echo $user[0]['id']; ?>';
      var csrf_test_name = $("input[name=csrf_test_name]").val();
      //var keyword       = $('#licenses_keyword').val().trim();
      var keyword = '';
      $.ajax({
        url: "<?php echo base_url() ?>/users-licenses/filter/" + page,
        method: "POST",
        data: {
          user_id: user_id,
          show_per_page: show_per_page,
          keyword: keyword,
          csrf_test_name: csrf_test_name
        },
        success: function(data) {
          $('.loader').css('display', 'none');
          $('.licenses_filter_data').html(data);
        }
      })
    }
    $(document).ready(function() {
      $(".keys").change(function() {

        var license_name = $('.keys').val();
        var data = dataType = '';
        var success = true;
        $('.license_info').html('');
        $.ajax({
          type: "GET",
          url: "<?php echo base_url(); ?>/get-license-by-id/" + license_name,
          data: {},
          dataType: 'json',
          success: function(data) {
            if (data.status == 'success') {
              $('.license_info').html(data.asset_info);
            }
          }
        });
      });
    });
    $("#assign_license").submit(function(event) {
      event.preventDefault();
      var post_url = $(this).attr("action");
      var request_method = $(this).attr("method");
      var form_data = new FormData(this);
      $('.submit_button').css('display', 'none');
      $('.loader_button').css('display', 'block');


      $.ajax({
        url: "<?php echo base_url() ?>/token/",
        method: "GET",
        success: function(token) {
          form_data.append('csrf_test_name', token);

          $.ajax({
            url: post_url,
            type: request_method,
            data: form_data,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false
          }).done(function(response) {
            if (response.status == 'success') {
              window.location.href = '<?php echo base_url() ?>/users/details/<?php echo $u_id; ?>' + '#val_licenses';
            } else {
              Swal.fire({
                icon: response.status,
                text: response.message,
              })
            }
            $('.submit_button').css('display', 'block');
            $('.loader_button').css('display', 'none');
          });
        }
      });


    });
    $("#revoke_license").submit(function(event) {
      event.preventDefault();
      var post_url = $(this).attr("action");
      var request_method = $(this).attr("method");
      var form_data = new FormData(this);
      $('.submit_button').css('display', 'none');
      $('.loader_button').css('display', 'block');


      $.ajax({
        url: "<?php echo base_url() ?>/token/",
        method: "GET",
        success: function(token) {


          form_data.append('csrf_test_name', token);


          $.ajax({
            url: post_url,
            type: request_method,
            data: form_data,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false
          }).done(function(response) {
            if (response.status == 'success') {
              window.location.href = '<?php echo base_url() ?>/users/details/<?php echo $u_id; ?>' + '#val_assets';
            } else {
              Swal.fire({
                icon: response.status,
                text: response.message,
              })
            }
            $('.submit_button').css('display', 'block');
            $('.loader_button').css('display', 'none');

          });
        }
      });

    });

    function revokeLicense(id) {
      var post_url = $('#revoke_user_license_id').val('');

      if (id) {
        console.log(id);
        $('#revoke_user_license_id').val(id);
        $('#revoke_license_model').modal('show');
      }
    }
  </script>