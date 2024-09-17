<style type="text/css">
   /* .select2-dropdown {
     z-index: 99999;
   } */

   .multiselect-dropdown {
    display: none !important;
   }
 </style>




 <div class="card mb-2">
   <div class="card-header bg-primary text-white" style="padding: 0.5rem 1.2rem;">
     <h3 class="card-title">Asset</h3>
     <button class="btn btn-icon bt-sm btn-light" style="min-height: auto;right: 1.2rem;position: absolute;" data-bs-toggle="modal" data-bs-target="#assign_assets_model"><i class="ti ti-plus"></i>Assign&nbsp;</button>
   </div>
   <div class="card-body" style="padding: 1rem 0rem">
     <div class="row">
       <!-- <div class="border-bottom py-2">
                <div class="d-flex">
                  <div class="text-muted">
                  </div>
                  <div class="ms-auto text-muted">
                    <div class="ms-2 d-inline-block">
                      
                    </div>
                    <div class="ms-2 d-inline-block">
                        <div class="input-icon">
                            <input type="text" value="" id="assets_keyword" class="form-control" placeholder="Search…">
                            <span class="input-icon-addon"><i class='ti ti-search'></i></span>
                        </div>
                    </div>
                  </div>
                  <div class="text-muted">
                      <button class="btn btn-icon btn-primary assets_clear_filter" style="margin: 0px 0px 0px 8px;"><i class="ti ti-refresh"></i></button>
                  </div>
                </div>
            </div> -->
       <div class="overlay-wrapper">
         <div class="overlay loader"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
         </div>
         <div class="assets_filter_data">
         </div>
       </div>
     </div>
   </div>
 </div>


 <div class="modal modal-blur fade modal-xl" id="assign_assets_model" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered " role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title">Assign Assets</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <form action="<?php echo base_url(); ?>/users-assets/assign/<?php echo $u_id; ?>" method="post" id="assign_assets" autocomplete="off">

         <div class="modal-body">
          <div class="row ">

          <div class="col-6">

           <div class="form-group  ">
             <label class="form-label required">Select Category</label>
             <div>
               <select type="text" class="form-select category_id" data-live-search="true" name="category_id" style="width: 100%; height:36px;display: initial;" required="true">
                 <option value="">Select Category</option>
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
           <br>

           <div class="form-group  ">
             <label class="form-label required">Assset Model Name</label>
             <div>
               <select class="asset_id form-select" multiple="multiple" id="asset_id" name="asset_id[]" data-live-search="true" style="width: 100%; height:36px;" required="true">
            
              </select>
         
             </div>
           </div>
          </div>

          <div class="col-6">
          <div class="form-group col-md-12 mb-3 asset_info">
           </div>
          </div>

        

          </div>

           
      
           
           <br>
           
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

 <div class="modal modal-blur fade" id="revoke_assets_model" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title">Revoke Assets</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <form action="<?php echo base_url(); ?>/users-assets/revoke/<?php echo $u_id; ?>" method="post" id="revoke_assets" autocomplete="off">

         <div class="modal-body">
           <div class="form-group col-md-12 mb-3 ">
             <input type="hidden" name="user_asset_id" id="revoke_user_asset_id" class="form-control" required>
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


 <script type="text/javascript">
   $(document).ready(function() {
     $(".category_id").select2({
       dropdownParent: $("#assign_assets_model")
     });


     $('#asset_id').select2({
      closeOnSelect : false,
			placeholder : "Placeholder",
			
			allowClear: true,
			tags: true 
    });

   

   });

  

   $(document).ready(function() {
     $(".category_id").change(function() {
       var category_id = $('.category_id').val();
       var data = dataType = '';
       var success = true;
       $('#asset_id').empty();
      //  $('.asset_id').find('option').not(':first').remove();
     

       $(".asset_id").select2({
            closeOnSelect: false,
            placeholder: "Placeholder",
            allowClear: true,
            templateResult: formatOption,
           
            dropdownParent: $("#assign_assets_model"),
        });

       $.ajax({
         type: "GET",
         url: "<?php echo base_url(); ?>/get-assetid-by-category/" + category_id,
         data: {},
         dataType: 'json',
         success: function(data) {
         
           $.each(data, function(index, data) {
             if (data.id) {
               var a_status = '';
               var assetStatusArray = <?php echo json_encode(ASSET_STATUS) ?>;
               $.each(assetStatusArray, function(index, value) {
                 if (data.status == index) {
                   a_status = value;
                 }
               });
               var option = new Option(data.model_name + " " + data.asset_id + " " + ' (' + a_status + ')', data.id, false, false);
                        option.setAttribute("data-checkbox", true);
                        $('.asset_id').append(option);
                                   }

           });
         }
       });
     });
   });

   function formatOption(option) {
    if (!option.id) return option.text;

    // Check if the custom data attribute "data-checkbox" is true
    var isCheckbox = option.element && option.element.getAttribute("data-checkbox") === "false";

    // Create a span with a checkbox and option text
    return $('<span><input type="checkbox" ' + (isCheckbox ? 'checked' : '') + '/>' + ' ' + option.text + '</span>');
}
   // $('.assets_name').select2({
   // 		dropdownParent: $('#assign_assets_model'),
   //     placeholder: 'Search and Select Asset',
   //     ajax: {
   //       url: '<?php echo base_url() ?>/assets/autocomplete',
   //       dataType: 'json',
   //       method:'GET',
   //       delay: 250,
   //       data: function (data) {
   //         return {
   //                 searchTerm: data.term // search term
   //               };
   //             },
   //             processResults: function (response) {
   //               return {
   //                 results:response
   //               };
   //             },
   //             cache: true
   //           }
   //   });
   $(document).ready(function() {
     assets_filter_data(1);
   });
   // assets list filter
   $('.assets_clear_filter').click(function() {
     window.location.href = '<?php echo base_url() ?>/users/details/<?php echo $u_id; ?>' + '#val_assets';
   });
   $('#assets_keyword').keyup(function() {
     if (this.value.length < 4) return;
     assets_filter_data(1);
   });

   function assets_filter_data(page) {
     $('.loader').css('display', 'flex');
     var show_per_page = $('.assets_show_per_page').val();
     var user_id = '<?php echo $user[0]['id']; ?>';
     var csrf_test_name = $("input[name=csrf_test_name]").val();
     //var keyword       = $('#assets_keyword').val().trim();
     var keyword = '';




         $.ajax({
           url: "<?php echo base_url() ?>/users-assets/filter/" + page,
           method: "POST",
           data: {
             user_id: user_id,
             show_per_page: show_per_page,
             keyword: keyword,
             csrf_test_name: csrf_test_name
           },
           success: function(data) {
        
             $('.loader').css('display', 'none');
             $('.assets_filter_data').html(data);
           }
         })

   

   }



   $(document).ready(function() {
     $(".asset_id").change(function() {
      
      var asset_id = $('.asset_id option:selected:last').val();
       var data = dataType = '';
       var success = true;
       $('.asset_info').html('');



       $.ajax({
         type: "GET",
         url: "<?php echo base_url(); ?>/get-assets-by-id/" + asset_id,
         data: {},
         dataType: 'json',
         success: function(data) {
           if (data.status == 'success') {
             $('.asset_info').html(data.asset_info);
           }
         }
       });
     });
   });
   $("#assign_assets").submit(function(event) {
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
             // $('#assign_assets_model').modal('hide');
             // $(".assets_name").select2("val", "");
             // $('.asset_info').html('');
             // Swal.fire({
             //   icon: response.status,
             //   text: response.message,
             // });
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
   $("#revoke_assets").submit(function(event) {
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

   function revokeAssets(id) {
     $('#revoke_user_asset_id').val('');
     if (id) {
     
       $('#revoke_user_asset_id').val(id);
       $('#revoke_assets_model').modal('show');
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