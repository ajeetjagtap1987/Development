<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">
          User Lists
        </h2>
      </div>
      <!-- Page title actions -->
      <div class="col-12 col-md-auto ms-auto d-print-none">
        <div class="d-flex">
          <!-- <input type="search" class="form-control d-inline-block w-9 me-3" placeholder="Search user…"/> -->
          <a href="<?php echo base_url() ?>/users-allotment_report/export" class="btn btn-info">
            <i class="ti ti-download"></i>
            Export Allotment report
          </a> &nbsp;&nbsp;
          <a href="<?php echo base_url() ?>/users/export" class="btn btn-success">
            <i class="ti ti-plus"></i>
            Export User
          </a> &nbsp;&nbsp;
          <a href="<?php echo base_url() ?>/users/create" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Create user
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="row row-cards">
      <div class="col-12">
        <div class="card">
          <div class="card-body border-bottom py-3">
            <div class="d-flex">
              <div class="text-muted">
                Show
                <div class="mx-2 d-inline-block">
                  <select class="form-control show_per_page">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="40">40</option>
                    <option value="60">60</option>
                  </select>
                </div>
                entries
              </div>
              <div class="ms-auto text-muted">
                <div class="ms-2 d-inline-block">
                  <div class="input-icon">
                    <input type="text" value="" id="keyword" class="form-control" placeholder="Search…">
                    <span class="input-icon-addon"><i class='ti ti-search'></i></span>
                  </div>
                </div>
              </div>
              <div class="text-muted">
                <button class="btn btn-icon btn-primary clear_filter" style="margin: 0px 0px 0px 8px;"><i
                    class="ti ti-refresh"></i></button>
              </div>
            </div>
          </div>
          <div class="overlay-wrapper">
            <div class="overlay loader"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
            </div>
            <div class="filter_data">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal modal-blur fade" id="delete_user_model" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?php echo base_url(); ?>/users/delete" method="post" id="user_delete_form" autocomplete="off">
        <?= csrf_field(); ?>
        <div class="modal-body">
          <div class="form-group col-md-12 mb-3 ">
            <input type="hidden" name="user_id" id="delete_user_id" class="form-control" required>

            <div class="d-flex justify-content-center">
              <div class="text-center">
                <!-- <i class="ti ti-trash"></i> -->

                <iframe src="https://lottie.host/embed/c0e2f2a7-d394-483f-82f1-961954c3970e/3Tw8Z7KxEx.json"></iframe>
                <h3>Are you sure?</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary submit_button">Submit</button>
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

  function deleteUser(id) {
    $('#delete_user_id').val('');
    if (id) {
      $('#delete_user_id').val(id);
      $('#delete_user_model').modal('show');
    }
  }

  $("#user_delete_form").submit(function (event) {
    event.preventDefault();
    var post_url = $(this).attr("action");
    var request_method = $(this).attr("method");
    var form_data = new FormData(this);

    $.ajax({
      url: "<?php echo base_url() ?>/token/",
      method: "GET",
      success: function (token) {

        form_data.append('csrf_test_name', token);

        $.ajax({
          url: post_url,
          type: request_method,
          data: form_data,
          dataType: 'json',
          contentType: false,
          cache: false,
          processData: false
        }).done(function (response) {
          if (response.status == 'success') {

            window.location.href = '<?php echo base_url() ?>/users/list ?>';
            Swal.fire({
              icon: response.status,
              text: response.message,
            })
          } else {
            Swal.fire({
              icon: response.status,
              text: response.message,
            })
            $('#delete_user_model').modal('hide');
          }
        });
      }
    });

  });



  $(document).ready(function () {
    filter_data(1);
  });

  $('#sort_by').change(function () {
    filter_data(1);
  });
  $('#order_by').change(function () {
    filter_data(1);
  });
  $('#show').change(function () {
    filter_data(1);
  });

  $('.clear_filter').click(function () {
    location.reload();
  });
  $('#keyword').keyup(function () {
    if (this.value.length < 4) return;
    filter_data(1);
  });
  $(function () {
    $('.show_per_page').change(function () {
      filter_data(1);
    });
  });

  // filter_data(1);
  $(document).ready(function () {
    $('#refresh_filter').click(function () {
      filter_data(1);
      // $("#my_div").load(" #my_div");

    });
  });

  function filter_data(page) {
    // $('.filter_data').html('<div id="loading" style="" ></div>');
    $('.loader').css('display', 'flex');
    var show_per_page = $('.show_per_page').val();
    var csrf_test_name = $("input[name=csrf_test_name]").val();
    var keyword = $('#keyword').val().trim();
    // var sort_by       = $("#sort_by option:selected").val();
    // var order_by      = $("#order_by option:selected").val();
    // var show          = $("#show option:selected").val();
    // var created_date    = $("#created_date").val();
    var sort_by = order_by = show = created_date = '';

    $.ajax({
      url: "<?php echo base_url() ?>/token/",
      method: "GET",
      success: function (token) {

        $.ajax({
          url: "<?php echo base_url() ?>/users/filter/" + page,
          method: "POST",
          data: {
            show_per_page: show_per_page,
            sort_by: sort_by,
            order_by: order_by,
            show: show,
            keyword: keyword,
            created_date: created_date,
            csrf_test_name: token
          },
          // statusCode: {
          //   403: function () {
          //     Swal.fire({
          //       icon: 'error',
          //       text: 'CSRF token verification failed',
          //     });
          //     window.location.href = '<?php echo base_url() ?>';
          //   }
          // },
          success: function (data) {

            $('.loader').css('display', 'none');
            $('.filter_data').html(data);
          }
        })


      }
    });
  }
  $(document).on('click', 'ul.pagination li a', function (e) {
    e.preventDefault();
    let page_url = $(this).attr('href');
    var page = page_url.substring(page_url.lastIndexOf('=') + 1);

    filter_data(page);
  });
  // $(document).on('click', '.pagination li a', function(event){
  //     event.preventDefault();
  //     alert();
  //     var page = $(this).data('ci-pagination-page');
  //     filter_data(page);
  // });
</script>