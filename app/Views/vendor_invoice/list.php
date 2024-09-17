 <!-- Page title -->
 <div class="page-header d-print-none">
   <div class="container-xl">
     <div class="row g-2 align-items-center">
       <div class="col">
         <h2 class="page-title">
           Vendor Invoice Lists
         </h2>
       </div>
       <!-- Page title actions -->
       <div class="col-12 col-md-auto ms-auto d-print-none">
         <div class="d-flex">
           <!-- <input type="search" class="form-control d-inline-block w-9 me-3" placeholder="Search user…"/> -->
           <a href="<?php echo base_url() ?>/vendor_invoice/create" class="btn btn-primary">
             <i class="ti ti-plus"></i>
             Create Vendor Invoice
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
              <label for="inputname" class="control-label col-form-label">Vendor</label>
              <select class="form-control custom-select" id="vendor" name="vendor" style="width: 100%; height:36px;">
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
				            <label for="inputname" class="control-label col-form-label">Invoice Date</label>
				            <input type="text" class="form-control daterangepicker1" id="created_at" name="created_at" value="">
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

 <?= csrf_field(); ?>
 <script type="text/javascript">
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
   $(function() {
     $('.show_per_page').change(function() {
       filter_data(1);
     });
   });
   $('.advance_search').click(function(){
        filter_data(1);
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
     // var sort_by       = $("#sort_by option:selected").val();
     // var order_by      = $("#order_by option:selected").val();
     // var show          = $("#show option:selected").val();
     // var created_date    = $("#created_date").val();
     var vendor          = $("#vendor option:selected").val();
     var created_at    = $("#created_at").val();
     var sort_by = order_by = show = created_date = '';

     $.ajax({
       url: "<?php echo base_url() ?>/token/",
       method: "GET",
       success: function(token) {

         $.ajax({
           url: "<?php echo base_url() ?>/vendor_invoice/filter/" + page,
           method: "POST",
           data: {
            show_per_page: show_per_page,
             sort_by: sort_by,
             order_by: order_by,
             vendor: vendor,
             show: show,
             keyword: keyword,
             created_at: created_at,
             csrf_test_name: token
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