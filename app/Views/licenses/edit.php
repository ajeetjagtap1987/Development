<?php
$encrypter = \Config\Services::encrypter();
$e_id = bin2hex($encrypter->encrypt($license[0]['id']));
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <?php echo @view('includes/breadcrumb2', ['level_1' => 'License List', 'level_1_url' => 'licenses/list', 'level_2' => 'License Edit']); ?>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="row row-cards">
      <div class="col-12">
        <?php
        if (session()->has("error")) {
        ?>
          <div class="alert alert-danger alert-dismissible">
            <?php echo session("error"); ?>
          </div>
        <?php
        }
        ?>
        <?php
        if (session()->has("success")) {
        ?>
          <div class="alert alert-success alert-dismissible">
            <?php echo session("success"); ?>
          </div>
        <?php
        }
        ?>
        <div class="card">
          <div class="card-body">
            <form action="<?= base_url(); ?>/licenses/update/<?= $e_id ?>" id="update" method="post" autocomplete="off">
              <?= csrf_field();  ?>
              <div class="form-group mb-3 ">
                <label class="form-label required">License Name</label>
                <div>

                  <select type="text" class="form-select " name="software_name" id="license">
                    <option value="">Select Software</option>
                    <?php
                    if (count($application) > 0) {
                      foreach ($application as $app) {
                        $select = $license[0]['license_name_id'] == $app['id'] ? 'selected' : '';
                        echo '<option value="' . $app['id'] . '" ' . $select . '>' . $app['name'] . '</option>';
                      }
                    }
                    ?>
                    <option value="other">Other</option>
                  </select>

                </div>
              </div>


              <div class="form-group mb-3 " id="new_license" style="display:none;">
                <label class="form-label required">Add New License Name</label>
                <div>
                  <input type="text" name="new_license" class="form-control" placeholder="Enter Product Key">
                </div>
              </div>

              <div class="form-group mb-3 ">
                <label class="form-label required">Manufacturer</label>
                <div>
                  <select type="text" class="form-control" name="manufacturer_id" required>
                    <option value="">Select Manufacturer</option>
                    <?php
                    if (count($manufacturer) > 0) {
                      foreach ($manufacturer as $mf) {
                        $select = $license[0]['manufacturer_id'] == $mf['id'] ? 'selected' : '';
                        echo '<option value="' . $mf['id'] . '" ' . $select . '>' . $mf['name'] . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group mb-3 ">
                <label class="form-label ">Product Key</label>
                <div>
                  <input type="text" name="product_key" class="form-control" placeholder="Enter Product Key" value="<?= $license[0]['product_key'] ?>">
                </div>
              </div>
              <div class="form-group mb-3 ">
                <label class="form-label required">Assign To</label>
                <div>
                  <input type="text" name="license_to_name" class="form-control" placeholder="Enter License To Name" value="<?= $license[0]['license_to_name'] ?>" required>
                </div>
              </div>
              <div class="form-group mb-3 ">
                <label class="form-label required">License To Email</label>
                <div>
                  <input type="email" name="license_to_email" class="form-control" placeholder="Enter License To Email" value="<?= $license[0]['license_to_email'] ?>" required>
                </div>
              </div>


              <div class="form-group mb-3 ">
                <label class="form-label ">Start Date</label>
                <div class="input-icon mb-2">
                  <input class="form-control datepicker" name="start_date" id="start_date" placeholder="Select Start Date" value="<?= $license[0]['start_date'] ?>">
                  <span class="input-icon-addon">
                    <i class="ti ti-calendar"></i>
                  </span>
                </div>
              </div>


              <div class="form-group mb-3 ">
                <label class="form-label ">Expiry Date</label>
                <div class="input-icon mb-2">
                  <input class="form-control datepicker" name="expiry_date" id="expiry_date" placeholder="Select Expiry Date" value="<?= $license[0]['expiry_date'] ?>">
                  <span class="input-icon-addon">
                    <i class="ti ti-calendar"></i>
                  </span>
                </div>
              </div>

              <div class="row">


              <div class="form-group mb-3 col-4">
                      <label class="form-label required">Currency</label>
                      <div>
                        <select class="form-select" name="currency" required>
                          <option value="">Select</option>
                          <option value="₹" <?php if ($license[0]['currency'] === "₹") echo 'selected="selected"'; ?>>INR(₹)</option>
                          <option value="$" <?php if ($license[0]['currency'] === "$") echo 'selected="selected"'; ?>>USD($)</option>
                        </select>
                      </div>
                    </div>

                <div class="form-group mb-3 col-4">
                  <label class="form-label required">Price</label>
                  <div>
                    <input type="text" value="<?= $license[0]['price'] ?>" name="price" class="form-control number" placeholder="Price" required>
                  </div>
                </div>




                <div class="form-group mb-3 col-4">
                  <label class="form-label required">Renewal</label>
                  <div>
                    <select type="text" class="form-control" name="renewal" required>

                      <option value="Yearly" <?php if ($license[0]['renewal'] === "Yearly") echo 'selected="selected"'; ?>>Yearly</option>
                      <option value="Half-yearly" <?php if ($license[0]['renewal'] === "Half-yearly") echo 'selected="selected"'; ?>>Half-yearly</option>
                      <option value="Quarterly" <?php if ($license[0]['renewal'] === "Quarterly") echo 'selected="selected"'; ?>>Quarterly</option>
                      <option value="Monthly" <?php if ($license[0]['renewal'] === "Monthly") echo 'selected="selected"'; ?>>Monthly</option>
                    </select>
                  </div>
                </div>
              </div>


              <div class="form-group mb-3 ">
                <label class="form-label">Note</label>
                <div>
                  <textarea name="note" class="form-control" placeholder="Enter note"><?= $license[0]['note'] ?></textarea>
                </div>
              </div>
              <div class="form-group mb-3 ">
                <label class="form-label required">User Limit</label>
                <div>
                  <input type="text" name="user_limit" class="form-control number" placeholder="Enter User Limit" value="<?= $license[0]['user_limit'] ?>" required>
                </div>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary submit_button" onclick="return confirm('Are you sure?');">Update</button>
                <button class="btn btn-primary loader_button" type="button" disabled>
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Loading...
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {



    $('#license').change(function() {
      var selectedValue = $(this).val();
      console.log(selectedValue);

      if (selectedValue == "other") {
        $('#new_license').show();
      } else {
        $('#new_license').css('display', 'none');
      }
    });


    $('#currency').change(function() {
      var selectedValue = $(this).val();


      if (selectedValue == "other") {
        $('#other_currency').show();
      } else {
        $('#other_currency').css('display', 'none');
      }
    });



  });


  $("#update").validate({

    rules: {
      software_name: {
        required: true
      },
      category_id: {
        required: true
      },
      license_to_email: {
        required: true,
        email: true
      },
      manufacturer_id: {
        required: true
      },


      license_to_name: {
        required: true,

      },

      user_limit: {
        required: true
      },

    },
    messages: {
      software_name: {
        required: "Please enter the software name."
      },
      category_id: {
        required: "Please select a category."
      },
      license_to_email: {
        required: "Please enter your email address.",
        email: "Please enter a valid email address."
      },
      manufacturer_id: {
        required: "Please select a manufacturer."
      },

      license_to_name: {
        required: "Please enter the license holder's name.",
      },

      user_limit: {
        required: "Please enter the user limit."
      },

    },
    submitHandler: function(form) {

      var post_url = $(form).attr("action");
      var request_method = $(form).attr("method");
      var form_data = new FormData(form);
      $('.submit_button').css('display', 'none');
      $('.loader_button').css('display', 'block');
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
          // Swal.fire({
          //   icon: response.status,
          //   text: response.message,
          // });
          window.location.href = '<?php echo base_url() ?>/licenses/list';
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





  // $("#update").submit(function(event){
  //   event.preventDefault();


  // });
</script>