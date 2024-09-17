<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">
          Asset Lists
        </h2>
      </div>
      <!-- Page title actions -->
      <div class="col-12 col-md-auto ms-auto d-print-none">
        <div class="d-flex">
        <a href="<?php echo base_url() ?>/assets/export" class="btn btn-success">
            <i class="ti ti-plus"></i>
            Export Assets
          </a> &nbsp;&nbsp;
          <!-- <input type="search" class="form-control d-inline-block w-9 me-3" placeholder="Search user…"/> -->
          <a href="<?php echo base_url() ?>/assets/create" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Create Asset
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
              <a href="#" class="btn btn-icon btn-primary" style="margin: 0px 6px;padding: 4px; float: right;" data-bs-toggle="modal" data-bs-target="#modal-filter" title="Filter"><i class="ti ti-filter"></i></a>
              <div class="ms-auto text-muted">
                <div class="ms-2 d-inline-block">
                  <div class="input-icon">
                    <input type="text" value="" id="keyword" class="form-control" placeholder="Search…">
                    <span class="input-icon-addon"><i class='ti ti-search'></i></span>
                  </div>
                </div>
              </div>
              <div class="text-muted">
                <button class="btn btn-icon btn-primary clear_filter" style="margin: 0px 0px 0px 8px;"><i class="ti ti-refresh"></i></button>
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


<div class="modal modal-blur fade" id="modal-filter" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title">Filter</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
				  	<div class="col-lg-6">
							<div class="form-group">
				            <label for="inputname" class="control-label col-form-label">Category</label>
				            <select class="form-control custom-select" id="category" name="category" style="width: 100%; height:36px;" >
				            	<option selected="true" value="">All</option>
                      <?php
																if (count($category) > 0) {
																	foreach ($category as $cat) {
																		echo '<option value="' . $cat['id'] . '">' . $cat['category_name'] . '</option>';
																	}
																}
																?>
				            </select>
				        </div>
				    </div>
                    <div class="col-lg-6">
							<div class="form-group">
				            <label for="inputname" class="control-label col-form-label">Manufacturer</label>
				            <select class="form-control custom-select" id="manufacturer" name="manufacturer" style="width: 100%; height:36px;" >
				            	<option selected="true" value="">All</option>
                      <?php
																if (count($manufacturer) > 0) {
																	foreach ($manufacturer as $mf) {
																		echo '<option value="' . $mf['id'] . '">' . $mf['name'] . '</option>';
																	}
																}
																?>
				            </select>
				        </div>
				    </div>
				</div>
        <div class="row">
				  	<div class="col-lg-6">
							<div class="form-group">
				            <label for="inputname" class="control-label col-form-label">Vendor</label>
				            <select class=" form-control custom-select" id="vendor" name="vendor" style="width: 100%; height:36px;" >
				            	<option selected="true" value="">All</option>
                      <?php
																if (count($vendor) > 0) {
																	foreach ($vendor as $ven) {
																		echo '<option value="' . $ven['id'] . '">' . $ven['supplier_name'] . '</option>';
																	}
																}
																?>
				            </select>
				        </div>
				    </div>
            <div class="col-lg-6">
							<div class="form-group">
				            <label for="inputname" class="control-label col-form-label">Created Date</label>
				            <input type="text" class="form-control daterangepicker1" id="created_at" name="created_at" >
				        </div>
				  </div>
				</div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="inputname" class="control-label col-form-label">Asset Status</label>
              <select class=" form-control custom-select" id="status" name="status" style="width: 100%; height:36px;">
                <option selected="true" value="">All</option>
                <option value="1">Spare</option>
                <option value="2">Assign</option>

              </select>
            </div>
          </div>
        </div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-info clear_filter" data-bs-dismiss="modal">Clear Filter</button>
				<button class="btn btn-primary ms-auto advance_search">Submit</button>
			</div>
            </form>
        </div>
      </div>
    </div>


    <div class="modal modal-blur fade" id="delete_assets_model" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title">Delete Assets</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <form action="<?php echo base_url(); ?>/assets/delete" method="post" id="asset_delete_form" autocomplete="off">
       <?= csrf_field();  ?>
         <div class="modal-body">
           <div class="form-group col-md-12 mb-3 ">
             <input type="hidden" name="asset_id" id="delete_user_asset_id" class="form-control" required>

             <div class="d-flex justify-content-center">
              <div class="text-center">
                <iframe src="https://lottie.host/embed/c0e2f2a7-d394-483f-82f1-961954c3970e/3Tw8Z7KxEx.json"></iframe>
                <h3>Are you sure?</h3>
              </div>
            </div>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
           <button type="submit" class="btn btn-primary submit_button" >Submit</button>
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

function deleteAssets(id) {
     $('#delete_user_asset_id').val('');
     if (id) {

       $('#delete_user_asset_id').val(id);
       $('#delete_assets_model').modal('show');
     }

   }

   $("#asset_delete_form").submit(function(event) {
     event.preventDefault();
     var post_url = $(this).attr("action");
     var request_method = $(this).attr("method");
     var form_data = new FormData(this);


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

             window.location.href = '<?php echo base_url() ?>/assets/list ?>';
             Swal.fire({
               icon: response.status,
               text: response.message,
             })
           } else {
             Swal.fire({
               icon: 'warning',
               text: response.message,
             })
             $('#delete_assets_model').modal('hide');
           }


         });
       }
     });

   });


$(function() {
	    $('.daterangepicker1').daterangepicker({
	    	drops: 'up',
		    autoUpdateInput: false,
		    locale: {
		      cancelLabel: 'Clear'
		    },
		     "dateLimit": {
                "month": 1
            }
	    });
	    $('.daterangepicker1').on('apply.daterangepicker', function(ev, picker) {
	    $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
	    });
	    $('.daterangepicker1').on('cancel.daterangepicker', function(ev, picker) {
	    $(this).val('');
	    });
	    $('.show_per_page').change(function(){
	        filter_data(1);
	    });
    });

  $(document).ready(function() {
    filter_data(1);
  });

  $('#sort_by').change(function() {
    filter_data(1);
  });
  $('#order_by').change(function() {
    filter_data(1);
  });
  $('#show').change(function() {
    filter_data(1);
  });

  $('.clear_filter').click(function() {
    location.reload();
  });
  $('#keyword').keyup(function() {

    filter_data(1);
  });
  $('.advance_search').click(function(){
        filter_data(1);
    });
  $(function() {
    $('.show_per_page').change(function() {
      filter_data(1);
    });
  });

  // filter_data(1);
  $(document).ready(function() {
    $('#refresh_filter').click(function() {
      filter_data(1);
      // $("#my_div").load(" #my_div");

    });
  });

  function filter_data(page) {
    // $('.filter_data').html('<div id="loading" style="" ></div>');
    $('.loader').css('display', 'flex');
    var show_per_page = $('.show_per_page').val();
    var keyword = $('#keyword').val().trim();
    var csrf_test_name = $("input[name=csrf_test_name]").val();
    var category      = $("#category option:selected").val();
    var manufacturer      = $("#manufacturer option:selected").val();
    var vendor      = $("#vendor option:selected").val();
    // var show          = $("#show option:selected").val();
    var created_at    = $("#created_at").val();
    var status = $("#status option:selected").val();


    $.ajax({
      url: "<?php echo base_url() ?>/token/",
      method: "GET",
      success: function(token) {

        $.ajax({
          url: "<?php echo base_url() ?>/assets/filter/" + page,
          method: "POST",
          data: {
            show_per_page: show_per_page,
            keyword: keyword,
            created_at: created_at,
            csrf_test_name: token,
            category: category,
            manufacturer: manufacturer,
            vendor: vendor,
            status: status,
          },
          success: function(data) {

            $('.loader').css('display', 'none');
            $('#modal-filter').modal('hide');
            $('.filter_data').html(data);
          }
        })

      }
    });


  }
  $(document).on('click', 'ul.pagination li a', function(e) {
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