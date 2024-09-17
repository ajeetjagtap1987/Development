  <div class="card mb-2">
    <div class="card-header bg-primary text-white" style="padding: 0.5rem 1.2rem;">
      <h3 class="card-title">Application</h3>
      <button class="btn btn-icon bt-sm btn-light" style="min-height: auto;right: 1.2rem;position: absolute;" data-bs-toggle="modal" data-bs-target="#assign_application_model"><i class="ti ti-plus"></i>Assign&nbsp;</button>
    </div>
    <div class="card-body" style="padding: 1rem 0rem">
      <div class="row">
        <div class="overlay-wrapper">
          <div class="overlay loader"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
          </div>
          <div class="application_filter_data">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal modal-blur fade " id="assign_application_model" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Assign Application</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?php echo base_url(); ?>/users-application/assign/<?php echo $u_id; ?>" method="post" id="assign_application" autocomplete="off">
          <div class="modal-body">

  


            <div class="form-group col-md-12 mb-3 ">
              <label class="form-label required">Application Name</label>
              <div>
                <select class="application_name form-select" multiple id="application_name" name="application_id[]"  data-live-search="true" style="width: 100%; height:36px;display: initial;" required="true">
                <option value="">Select Application</option>
               <?php
											if (count($application) > 0) {
												foreach ($application as $d) {
													echo '<option value="' . $d['id'] . '">' . $d['name'] . '</option>';
												}
											}
											?>
              </select>
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

  <div class="modal modal-blur fade" id="revoke_application_model" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Revoke Application</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?php echo base_url(); ?>/users-application/revoke/<?php echo $u_id; ?>" method="post" id="revoke_application" autocomplete="off">
          <div class="modal-body">
            <div class="form-group col-md-12 mb-3 ">
              <input type="hidden" name="user_application_id" id="revoke_user_application_id" class="form-control" required>
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
    $('.application_name').select2({
      closeOnSelect: false,
            allowClear: true,
            templateResult: formatOption,
      dropdownParent: $('#assign_application_model'),
      placeholder: 'Search and Select Application',
      // ajax: {
      //   url: '<?php echo base_url() ?>/appliaction/autocomplete',
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
    });
    $(document).ready(function() {
      application_filter_data(1);
    });
    // application list filter
    $('.application_clear_filter').click(function() {
      window.location.href = '<?php echo base_url() ?>/users/details/<?php echo $u_id; ?>' + '#val_applications';
    });
    $('#application_keyword').keyup(function() {
      if (this.value.length < 4) return;
      application_filter_data(1);
    });

    function application_filter_data(page) {
      $('.loader').css('display', 'flex');
      var show_per_page = $('.application_show_per_page').val();
      var user_id = '<?php echo $user[0]['id']; ?>';
      var csrf_test_name = $("input[name=csrf_test_name]").val();
      //var keyword       = $('#application_keyword').val().trim();
      var keyword = '';
      $.ajax({
        url: "<?php echo base_url() ?>/users-application/filter/" + page,
        method: "POST",
        data: {
          user_id: user_id,
          show_per_page: show_per_page,
          keyword: keyword,
          csrf_test_name: csrf_test_name
        },
        success: function(data) {
          $('.loader').css('display', 'none');
          $('.application_filter_data').html(data);
        }
      })
    }




    $("#assign_application").submit(function(event) {
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
              // $('#assign_application_model').modal('hide');
              // $(".application_name").select2("val", "");
              // $('.application_info').html('');
              // Swal.fire({
              //   icon: response.status,
              //   text: response.message,
              // });
              window.location.href = '<?php echo base_url() ?>/users/details/<?php echo $u_id; ?>' + '#val_applications';
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



    $("#revoke_application").submit(function(event) {
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
              window.location.href = '<?php echo base_url() ?>/users/details/<?php echo $u_id; ?>' + '#val_applications';
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

    function revokeApplication(id) {
      $('#revoke_user_application_id').val('');
      if (id) {
        $('#revoke_user_application_id').val(id);
        $('#revoke_application_model').modal('show');
      }
    }
    $(document).ready(function() {
      var len = 0;
      var maxchar = 250;
      $('.revoke_reason').keyup(function() {

        len = this.value.length;
        if (len > maxchar) {
          return false;
        } else if (len > 0) {
          $(".revoke_reason_count").html("Remaining characters: " + (maxchar - len));
        } else {
          $(".revoke_reason_count").html("Remaining characters: " + (maxchar));
        }
      })
    });
  </script>