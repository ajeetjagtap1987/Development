
  <div class="page-header d-print-none">
  	<div class="container-xl">
    <?php echo @view('includes/breadcrumb2', ['level_1' => 'Import Data', 'level_1_url' => 'import', 'level_2' => 'Import']); ?>
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
            	<div class="card mb-4">
                <div class="card-header">
                  <h3 class="card-title">Assets Import</h3> &nbsp   &nbsp <h5 class="card-title">(Note : File format =  .csv , Date format = DD-MM-YYYY)</h5>
                  <!-- <a class="btn btn-icon bt-sm btn-primary" href="<?php echo base_url();?>/download-import-file-header/1" style="min-height: auto;right: 1.2rem;position: absolute;padding:4px;" ><i class="ti ti-download"></i>&nbsp;Sample</a> -->
                </div> 
                <div class="card-body">
                	<form action="<?php echo base_url();?>/import-asset-file" method="post"  autocomplete="off" enctype="multipart/form-data">
                  <?= csrf_field();  ?>

                  <div class="form-group mb-3 ">
                      <label class="form-label ">Category Name</label>
                      <div>
                      		<select type="text" class="form-control" name="category_id"   id="category">
                      			<option value="">Select Category Name</option>
										      	<?php 
																if(count($category)>0){
																	foreach( $category as $c ){
																		echo '<option value="'.$c['id'].'">'.$c['category_name'].'</option>';
																  }
																}
										      	?>
                            <option value="other">Other</option>
													</select>
                      </div>
                    </div>

                  <div class="form-group mb-3 ">
                      <label class="form-label required">Select File</label>
                      <div>
                        <input type="file" class="form-control" name="asset_file" id="asset_file" title="Browse file" accept=".csv" />
                      </div>
                    </div>
                    <div class="form-footer">
                    	<button type="submit" class="btn btn-primary submit_button" onclick="return confirm('Are you sure?');">Submit</button>
                    </div>
                  </form>
                </div>
              </div>

              <div class="card mb-4">
                <div class="card-header">
                  <h3 class="card-title">User Import</h3>  &nbsp   &nbsp <h5 class="card-title">(Note : File format =  .csv , Date format = DD-MM-YYYY )</h5>
                  <a class="btn btn-icon bt-sm btn-primary" href="<?php echo base_url();?>/download-import-file-header/501" style="min-height: auto;right: 1.2rem;position: absolute;padding:4px;" ><i class="ti ti-download"></i>&nbsp;Sample</a>
                </div> 
                <div class="card-body">
                  <form action="<?php echo base_url();?>/import-user-file" method="post"  autocomplete="off" enctype="multipart/form-data">
                  <?= csrf_field();  ?>
                  <div class="form-group mb-3 ">
                      <label class="form-label required">Select File</label>
                      <div>
                        <input type="file" class="form-control" name="user_file" id="user_file" title="Browse file" accept=".csv" />
                      </div>
                    </div>
                    <div class="form-footer">
                      <button type="submit" class="btn btn-primary submit_button" onclick="return confirm('Are you sure?');">Submit</button>
                    </div>
                  </form>
                </div>
              </div>

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Allocate Assets Import</h3> &nbsp   &nbsp <h5 class="card-title">( Note : File format =  .csv )</h5>
                  <a class="btn btn-icon bt-sm btn-primary" href="<?php echo base_url();?>/download-import-file-header/502" style="min-height: auto;right: 1.2rem;position: absolute;padding:4px;" ><i class="ti ti-download"></i>&nbsp;Sample</a>
                </div> 
                <div class="card-body">
                  <form action="<?php echo base_url();?>/import-user-assign-assets-file" method="post"  autocomplete="off" enctype="multipart/form-data">
                  <?= csrf_field();  ?>
                  <div class="form-group mb-3 ">
                      <label class="form-label required">Select File</label>
                      <div>
                        <input type="file" class="form-control" name="user_assets_file" id="user_assets_file" title="Browse file" accept=".csv" />
                      </div>
                    </div>
                    <div class="form-footer">
                      <button type="submit" class="btn btn-primary submit_button" onclick="return confirm('Are you sure?');">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
        	</div>
      	</div>
    </div>
  </div>


  <script>

$('#category').change(function() {
  var selectedValue = $(this).val();

  window.location.href = "download-import-file-header/" + selectedValue;

});


</script>
