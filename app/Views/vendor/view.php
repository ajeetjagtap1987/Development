<?php
$encrypter = \Config\Services::encrypter();
$e_id=bin2hex($encrypter->encrypt($vendor[0]['id']));
?>
   	<div class="page-header d-print-none">
   	   <div class="container-xl">
      	<?php echo @view('includes/breadcrumb2', ['level_1' => 'Vendor List', 'level_1_url' => 'vendor/list', 'level_2' => $vendor[0]['supplier_name']]); ?>
  	   </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
              	<div class="col-12">
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
	              	<div class="card">
		                	 
		                    <div class="card-header bg-light">
			              			<h4 class="card-title">Supplier's Details</h4>
			              		</div>	
				                <div class="card-body">
				                	<div class="row">	
				                  	<div class="form-group col-md-12 mb-3 ">
				                      <label class="form-label ">Supplier Name</label>
				                      <div>
				                        <input type="text" name="supplier_name" class="form-control" placeholder="Enter Supplier Name" value="<?= $vendor[0]['supplier_name']?>" disabled  >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Mailing / Business Address</label>
				                      <div>
				                        <input type="email" name="business_email_address" class="form-control" placeholder="Enter Mailing / Business Address" value="<?= $vendor[0]['business_email_address']?>"  disabled>
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Plot No / Floor / Bldg Name</label>
				                      <div>
				                        <input type="text" name="plot_floor_building" class="form-control" placeholder="Enter Plot No / Floor / Bldg Name"  value="<?= $vendor[0]['plot_floor_building']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-12 mb-3 ">
				                      <label class="form-label ">Street Address 1</label>
				                      <div>
				                        <input type="text" name="street_address_one" class="form-control" placeholder="Enter Street Address 1" value="<?= $vendor[0]['street_address_one']?>" disabled disabled>
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-12 mb-3 ">
				                      <label class="form-label">Street Address 2</label>
				                      <div>
				                        <input type="text" name="street_address_two" class="form-control" placeholder="Enter Street Address 2" value="<?= $vendor[0]['street_address_two']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">City</label>
				                      <div>
				                        <input type="text" name="city" class="form-control" placeholder="Enter City" value="<?= $vendor[0]['city']?>" disabled  >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Country</label>
				                      <div>
				                        <input type="text" name="country" class="form-control" placeholder="Enter Country" value="<?= $vendor[0]['country']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">State</label>
				                      <div>
				                        <input type="text" name="state" class="form-control" placeholder="Enter State" value="<?= $vendor[0]['state']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Pin code</label>
				                      <div>
				                        <input type="text" name="pincode" class="form-control number" placeholder="Enter Pin code" value="<?= $vendor[0]['pincode']?>" disabled >
				                      </div>
				                    </div>
				                  </div>
				                </div>  
				                <div class="card-header bg-light">
			              			<h4 class="card-title">Director</h4>
			              		</div>	
				                <div class="card-body">  
				                	<div class="row">
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Contact Person Name</label>
				                      <div>
				                        <input type="text" name="director_contact_person_name" class="form-control" placeholder="Enter Contact Person Name" value="<?= $vendor[0]['director_contact_person_name']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Designation</label>
				                      <div>
				                        <input type="text" name="director_designation" class="form-control" placeholder="Enter Designation" value="<?= $vendor[0]['director_designation']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Telephone No.(with STD code)</label>
				                      <div>
				                        <input type="text" name="director_telephone" class="form-control number" placeholder="Enter Telephone No." value="<?= $vendor[0]['director_telephone']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Mobile No.</label>
				                      <div>
				                        <input type="text" name="director_mobile" class="form-control number" placeholder="Enter Mobile No." value="<?= $vendor[0]['director_mobile']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Email Address</label>
				                      <div>
				                        <input type="email" name="director_email_address" class="form-control" placeholder="Enter Email Address" value="<?= $vendor[0]['director_email_address']?>" disabled >
				                      </div>
				                    </div>
				                	</div>
				                </div>	
				                <div class="card-header bg-light">
			              			<h4 class="card-title">Finance</h4>
			              		</div>	
				                <div class="card-body"> 
				                	<div class="row">
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label">Contact Person Name</label>
				                      <div>
				                        <input type="text" name="finance_contact_person_name" class="form-control" placeholder="Enter Contact Person Name" value="<?= $vendor[0]['finance_contact_person_name']?>" disabled>
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label">Designation</label>
				                      <div>
				                        <input type="text" name="finance_designation" class="form-control" placeholder="Enter Designation" value="<?= $vendor[0]['finance_designation']?>" disabled>
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label">Telephone No.(with STD code)</label>
				                      <div>
				                        <input type="text" name="finance_telephone" class="form-control number" placeholder="Enter Telephone No." value="<?= $vendor[0]['finance_telephone']?>" disabled>
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label">Mobile No.</label>
				                      <div>
				                        <input type="text" name="finance_mobile" class="form-control number" placeholder="Enter Mobile No." value="<?= $vendor[0]['finance_mobile']?>" disabled>
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label">Email Address</label>
				                      <div>
				                        <input type="email" name="finance_email_address" class="form-control" placeholder="Enter Email Address" value="<?= $vendor[0]['finance_email_address']?>" disabled>
				                      </div>
				                    </div>
				                	</div>
				                </div>	
				                <div class="card-header bg-light">
			              			<h4 class="card-title">Purchase</h4>
			              		</div>	
				                <div class="card-body">  
				                	<div class="row">
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Contact Person Name</label>
				                      <div>
				                        <input type="text" name="purchase_contact_person_name" class="form-control" placeholder="Enter Contact Person Name"  value="<?= $vendor[0]['purchase_contact_person_name']?>" disabled>
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Designation</label>
				                      <div>
				                        <input type="text" name="purchase_designation" class="form-control" placeholder="Enter Designation" value="<?= $vendor[0]['purchase_designation']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Telephone No.(with STD code)</label>
				                      <div>
				                        <input type="text" name="purchase_telephone" class="form-control number" placeholder="Enter Telephone No." value="<?= $vendor[0]['purchase_telephone']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Mobile No.</label>
				                      <div>
				                        <input type="text" name="purchase_mobile" class="form-control number" placeholder="Enter Mobile No." value="<?= $vendor[0]['purchase_mobile']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Email Address</label>
				                      <div>
				                        <input type="email" name="purchase_email_address" class="form-control" placeholder="Enter Email Address" value="<?= $vendor[0]['purchase_email_address']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Date of Commencement of Business</label>
				                      <div class="input-icon mb-2">
																<input class="form-control datepicker" name="business_commencement_date" placeholder="Select Expiry Date" value="<?= $vendor[0]['business_commencement_date']?>" disabled >
																<span class="input-icon-addon">
																<i class="ti ti-calendar"></i>
																</span>
															</div>
				                    </div>
				                	</div>
				                </div>
				                <div class="card-header bg-light">
			              			<h4 class="card-title">TAX Details</h4>
			              		</div>	
				                <div class="card-body"> 
				                	<div class="row">
					                  	<div class="form-group col-md-6 mb-3 ">
					                      <label class="form-label ">Permanent Account Number ( PAN )</label>
					                      <div>
					                        <input type="text" name="pan_number" class="form-control" placeholder="Enter Contact Person Name" value="<?= $vendor[0]['pan_number']?>" disabled >
					                      </div>
					                    </div>
					                  	<div class="form-group col-md-6 mb-3 ">
					                      <label class="form-label ">Attached PAN Copy</label>
					                      <div>
					                        <input type="file" name="pan_copy_attachment" class="form-control" placeholder="" accept="image/*" disabled>
					                      </div>
					                      <div class="mt-3">
					                      	<?php if(count($vendor_pancard)>0){
					                      		  echo '<a class="imageModel" href="#"><img class="img-thumbnail imageresource" width="250px" src="'.base_url()."/".PUBLIC_PATH.$vendor_pancard[0]['file_url'].'"/></a>';
					                      	}?>
					                      </div>
					                    </div>
					                  	<div class="form-group col-md-6 mb-3 ">
					                      <label class="form-label ">TAN No.</label>
					                      <div>
					                        <input type="text" name="tan_number" class="form-control" placeholder="Enter TAN No."  value="<?= $vendor[0]['tan_number']?>" disabled >
					                      </div>
					                    </div>
					                  	<div class="form-group col-md-6 mb-3 ">
					                      <label class="form-label ">CIN No.</label>
					                      <div>
					                        <input type="text" name="cin_number" class="form-control" placeholder="Enter CIN No." value="<?= $vendor[0]['cin_number']?>" disabled >
					                      </div>
					                    </div>
					                  	<div class="form-group col-md-6 mb-3 ">
					                      <label class="form-label ">IEC No.</label>
					                      <div>
					                        <input type="text" name="iec_number" class="form-control" placeholder="Enter IEC No." value="<?= $vendor[0]['iec_number']?>" disabled >
					                      </div>
					                    </div>
					                    <div class="form-group col-md-6 mb-3 ">
					                      <label class="form-label ">Gst Registration Number</label>
					                      <div>
					                        <input type="text" name="gst_registration_number" class="form-control" placeholder="Enter Gst Registration Number"  value="<?= $vendor[0]['gst_registration_number']?>" disabled >
					                      </div>
					                    </div>
					                </div> 
				                </div>
				                <div class="card-header bg-light">
			              			<h4 class="card-title">Bank Details</h4>
			              		</div>	
				                <div class="card-body"> 
				                	<div class="row">
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Account Name</label>
				                      <div>
				                        <input type="text" name="bank_account_name" class="form-control" placeholder="Enter Account Name" value="<?= $vendor[0]['bank_account_name']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Account Number</label>
				                      <div>
				                        <input type="text" name="bank_account_number" class="form-control number" placeholder="Enter Account Number" value="<?= $vendor[0]['bank_account_number']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Account Type</label>
				                      <div>
				                        <input type="text" name="bank_account_type" class="form-control" placeholder="Enter Account Type" value="<?= $vendor[0]['bank_account_type']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Bank Name</label>
				                      <div>
				                        <input type="text" name="bank_name" class="form-control" placeholder="Enter Bank Name" value="<?= $vendor[0]['bank_name']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Branch Name & Code</label>
				                      <div>
				                        <input type="text" name="bank_branch_name_and_code" class="form-control" placeholder="Enter Branch Name & Code" value="<?= $vendor[0]['bank_branch_name_and_code']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-12 mb-3 ">
				                      <label class="form-label ">Address (including Pin code)</label>
				                      <div>
				                        <textarea type="text" name="bank_address" class="form-control" placeholder="Address" ><?= $vendor[0]['bank_address']?></textarea>
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Banks Telephone No. (with STD codes)</label>
				                      <div>
				                        <input type="text" name="bank_telephone" class="form-control number" placeholder="Enter Banks Telephone No. (with STD codes)" value="<?= $vendor[0]['bank_telephone']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">NEFT IFSC Code</label>
				                      <div>
				                        <input type="text" name="bank_neft_ifsc_code" class="form-control" placeholder="Enter NEFT IFSC Code" value="<?= $vendor[0]['bank_neft_ifsc_code']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">9 Digit MICR Code (appearing on cheque book)</label>
				                      <div>
				                        <input type="text" name="bank_micr_code" class="form-control" placeholder="Enter 9 Digit MICR Code (appearing on cheque book)" value="<?= $vendor[0]['bank_micr_code']?>" disabled >
				                      </div>
				                    </div>
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">SWIFT Code / ABA Code / SORT Code / IBAN</label>
				                      <div>
				                        <input type="text" name="bank_swift_code_aba_code_sort_code_iban" class="form-control" placeholder="Enter SWIFT Code / ABA Code / SORT Code / IBAN" value="<?= $vendor[0]['bank_swift_code_aba_code_sort_code_iban']?>" disabled >
				                      </div>
				                    </div>
				                	</div>  
				                </div>
				                <div class="card-header bg-light">
			              			<h4 class="card-title">Other Information</h4>
			              		</div>	
				                <div class="card-body"> 
				                	<div class="row">
				                  	<div class="form-group col-md-6 mb-3 ">
				                      <label class="form-label ">Type of Organization</label>
				                      <div>
						                <div>
						                	<?php $organisation_type=explode(',', $vendor[0]['organisation_type']);?>
			                              <label class="form-check form-check-inline">
			                                <input class="form-check-input organisation_type" type="checkbox" name="organisation_type[]" value="Company" <?php echo in_array('Company', $organisation_type) == 'Company' ? 'checked' : '' ?> disabled>
			                                <span class="form-check-label">Company</span>
			                              </label>
			                              <label class="form-check form-check-inline">
			                                <input class="form-check-input organisation_type" type="checkbox" name="organisation_type[]"  value="Individual" <?php echo in_array('Individual', $organisation_type) == 'Individual' ? 'checked' : '' ?> disabled>
			                                <span class="form-check-label">Individual</span>
			                              </label>
			                              <label class="form-check form-check-inline">
			                                <input class="form-check-input organisation_type" type="checkbox" name="organisation_type[]" value="Partnership" <?php echo in_array('Partnership', $organisation_type) == 'Partnership' ? 'checked' : '' ?> disabled >
			                                <span class="form-check-label">Partnership</span>
			                              </label>
			                              <label class="form-check form-check-inline">
			                                <input class="form-check-input organisation_type" type="checkbox" name="organisation_type[]" value="Others" <?php echo in_array('Others', $organisation_type) == 'Others' ? 'checked' : '' ?> disabled>
			                                <span class="form-check-label">Others</span>
			                              </label>
			                            </div>
				                      </div>
				                    </div>
				                </div> 
	                </div>
            	</div>
          	</div>
        </div>
    </div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".organisation_type").on('change', function(event){
	    		if ($('input[name="organisation_type[]"]:checked').length == 0) {
			    		$(".organisation_type").attr('required', 'required');
			    }else{
			    		$(".organisation_type").removeAttr('required');
			    }
		});
	});
  	$("#update").submit(function(event){
      event.preventDefault();
      var post_url = $(this).attr("action");
      var request_method = $(this).attr("method");
      var form_data = new FormData(this);
        $('.submit_button').css('display','none');
        $('.loader_button').css('display','block');
        $.ajax({
          url : post_url,
          type: request_method,
          data : form_data,
          dataType: 'json',
          contentType: false,
          cache: false,
          processData:false
        }).done(function(response){ 
            if(response.status == 'success' ){
              // Swal.fire({
              //   icon: response.status,
              //   text: response.message,
              // });
              window.location.href = '<?php echo base_url()?>/vendor/list';
            }else{
              Swal.fire({
                icon: response.status,
                text: response.message,
              })
            } 
            $('.submit_button').css('display','block');
            $('.loader_button').css('display','none');
            
        });
     
  	});
</script>