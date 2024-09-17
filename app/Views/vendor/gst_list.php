<?php
$encrypter = \Config\Services::encrypter();
$e_id=bin2hex($encrypter->encrypt($vendor[0]['id']));
?>
   <!-- Page title -->
        <div class="page-header d-print-none">
        	<div class="container-xl">
				<div class="row g-2 align-items-center">
				  <div class="col">
				    <h2 class="page-title">
				      Vendor GST Lists
				    </h2>
				  </div>
				  <div class="col-12 col-md-auto ms-auto d-print-none">
				    <div class="d-flex">
				      <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
				        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
				        <li class="breadcrumb-item"><a href="<?php echo base_url().'/vendor/list'?>">Vendor List</a></li>
				        <li class="breadcrumb-item text-white"><a href="<?php echo base_url()?>/vendor_gst/create/<?php echo $e_id?>" class="btn btn-sm btn-primary text-white">
	                    Add Vendor GST Details
	                  </a></li>
				      </ol>
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
			                       		<button class="btn btn-icon btn-primary clear_filter" style="margin: 0px 0px 0px 8px;"><i class="ti ti-refresh"></i></button>
			                      </div>
			                    </div>
		                  	</div>
		                  	<div class="overlay-wrapper">
								<div class="overlay loader"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
								</div>
								<div class="filter_data" >
								</div>
                      	  	</div>
                		</div>
	            	</div>
	          	</div>
	        </div>
        </div>
        
<script type="text/javascript">
	  $(document).ready(function(){
        filter_data(1);
    });

    $('#sort_by').change(function(){
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
    $('#keyword').keyup(function(){
        if( this.value.length < 4 ) return;
        filter_data(1);
    });
    $(function(){
        $('.show_per_page').change(function(){
        filter_data(1);
    });
    });
    
        // filter_data(1);
    $(document).ready(function() {  
	    $('#refresh_filter').click(function(){  
	            filter_data(1);
	            // $("#my_div").load(" #my_div");
	            
	    });
    });
     function filter_data(page)
    {
        // $('.filter_data').html('<div id="loading" style="" ></div>');
        $('.loader').css('display','flex');
        var show_per_page = $('.show_per_page').val();
        var keyword       = $('#keyword').val().trim();
        var vendor_id       = <?php echo $vendor[0]['id'] ?>;
        // var sort_by       = $("#sort_by option:selected").val();
        // var order_by      = $("#order_by option:selected").val();
        // var show          = $("#show option:selected").val();
        // var created_date    = $("#created_date").val();
        var sort_by = order_by = show = '';
        $.ajax({
            url:"<?php echo base_url() ?>/vendor/gstlist_filter/"+page,
            method:"POST",
            data:{show_per_page:show_per_page,sort_by:sort_by, order_by:order_by, show:show, keyword:keyword,vendor_id:vendor_id},
            success:function(data)
            {
                
                $('.loader').css('display','none');
                $('.filter_data').html(data);
            }
        })
    }
    $(document).on('click', 'ul.pagination li a', function(e){
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