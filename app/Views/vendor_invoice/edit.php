<?php
$encrypter = \Config\Services::encrypter();
$e_id = bin2hex($encrypter->encrypt($vendor_invoice[0]['id']));
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <?php echo @view('includes/breadcrumb2', ['level_1' => 'Vendor Invoice List', 'level_1_url' => 'vendor_invoice/list', 'level_2' => 'Vendor Invoice Edit']); ?>
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
            <form action="<?php echo base_url(); ?>/vendor_invoice/update/<?= $e_id ?>" method="post" enctype="multipart/form-data" id="update" autocomplete="off">
              <?= csrf_field(); ?>
              <div class="row">
                <div class="form-group mb-3 ">
                  <label class="form-label required">Vendor</label>
                  <div>
                    <select type="text" class="form-control" name="vendor_id" required value="">
                      <option value="">Select Vendor</option>
                      <?php
                      if (count($vendor) > 0) {
                        foreach ($vendor as $ven) {
                          $select = $vendor_invoice[0]['vendor_id'] == $ven['id'] ? 'selected' : '';
                          echo '<option value="' . $ven['id'] . '" ' . $select . '>' . $ven['supplier_name'] . '</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group mb-3 ">
                  <label class="form-label required">Invoice Date</label>
                  <div class="input-icon mb-2">
                    <input class="form-control datepicker" name="invoice_date" id="invoice_date" placeholder="Select Invoice Date" value="<?= $vendor_invoice[0]['invoice_date'] ?>" required>
                    <span class="input-icon-addon">
                      <i class="ti ti-calendar"></i>
                    </span>
                  </div>
                </div>
                <div class="form-group mb-3 ">
                  <label class="form-label required">Invoice No.</label>
                  <div>
                    <input type="text" name="invoice_no" class="form-control " placeholder="Enter Invoice No." value="<?= $vendor_invoice[0]['invoice_no'] ?>" required>
                  </div>
                </div>
                <div class="form-group mb-3 ">
                  <label class="form-label">E-Way Bill No</label>
                  <div>
                    <input type="text" name="e_way_bill_no" class="form-control" placeholder="Enter E-Way Bill No" value="<?= $vendor_invoice[0]['e_way_bill_no'] ?>">
                  </div>
                </div>
                <!-- <div class="form-group mb-3 ">
                        <label class="form-label">Invoice Assets Details</label>
                        <div>
                          <textarea name="invoice_assets_details" class="form-control" placeholder="Enter Invoice Assets Details"><?= $vendor_invoice[0]['invoice_assets_details'] ?></textarea>
                        </div>
                      </div>
                      <div class="form-group mb-3 ">
                        <label class="form-label required">Total Quantity Count</label>
                        <div>
                          <input type="text" name="total_quantity_count" class="form-control number" placeholder="Enter Total Quantity Count" value="<?= $vendor_invoice[0]['total_items_count'] ?>" required>
                        </div>
                      </div> -->
            
            

                      <div class="row ">
                      <div class="form-group mb-3 col-3">
                        <label class="form-label">Invoice Assets Details</label>
                   
                      </div>


                      <div class="form-group mb-3 col-2">
                        <label class="form-label required">Total Quantity Count</label>
                     
                      </div>


                      <div class="form-group mb-3 col-2">
                        <label class="form-label required">Price</label>
                      
                      </div>

                      <div class="form-group mb-3 col-2">
                        <label class="form-label required">GST</label>
                    
                      </div>

                      <div class="form-group mb-3 col-2">
                        <label class="form-label required">Amount</label>
                      
                      </div>

                     


                    </div>

                      <div id="loop_div">
                <?php

                if (count($items) > 0) {
                  foreach ($items as $index => $item) {
                    $lastIndex = count($items) - 1;
                ?>


                    <div id="array-index-data" data-input-counter="<?= $lastIndex ?>"></div>
                    <div class="row items_div">
                      <div class="form-group mb-3 col-3">
                       
                        <div>
                          <input type="text" class="form-control name" value="<?= $item['name'] ?>" name="asset[<?= $index ?>][<?= 'name' ?>]" placeholder="Enter Invoice Assets Details">
                        </div>
                      </div>


                      <div class="form-group mb-3 col-2">
                      
                        <div>
                          <input type="text" value="<?= $item['count'] ?>" name="asset[<?= $index ?>][<?= 'count' ?>]" class="form-control  quantity" placeholder="Enter Total Quantity Count" required>
                        </div>
                      </div>


                      <div class="form-group mb-3 col-2">
                      
                        <div>
                          <input type="text" value="<?= $item['price'] ?>" name="asset[<?= $index ?>][<?= 'price' ?>]" class="form-control  price" placeholder="price" required>
                        </div>
                      </div>

                      <div class="form-group mb-3 col-2">
                  
                        <div>
                          <select name="asset[<?= $index ?>][<?= 'gst' ?>]" class="form-select required gst" required>
                            <option value="0" <?= ($item['gst'] == 0) ? 'selected' : '' ?>>0%</option>
                            <option value="5" <?= ($item['gst'] == 5) ? 'selected' : '' ?>>5%</option>
                            <option value="12" <?= ($item['gst'] == 12) ? 'selected' : '' ?>>12%</option>
                            <option value="18" <?= ($item['gst'] == 18) ? 'selected' : '' ?>>18%</option>
                            <option value="28" <?= ($item['gst'] == 28) ? 'selected' : '' ?>>28%</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group mb-3 col-2">
                      
                        <div>
                          <input type="text" value="<?= $item['amount'] ?>" name="asset[<?= $index ?>][<?= 'amount' ?>]" class="form-control  amount" placeholder="price" required>
                        </div>
                      </div>

                      <div class="form-group mb-3 col-1">
                      <div>
          <button type="button"  value="<?= $item['id'] ?>" class="btn btn-danger btn-sm remove_data" >X</button>
      </div>
      </div>
                      <input type="hidden" value="<?= $item['id'] ?>" name="asset[<?= $index ?>][<?= 'id' ?>]">


                    </div>


                <?php

                  }
                }
                ?>

</div>
                <div id="inputContainer"></div>
                <button type="button" class="btn btn-primary col-1" id="addInput">Add</button>

                <div class="form-group mb-3">
                  <label class="form-label required">Currency</label>
                  <div>
                    <select class="form-select" name="currency" required>
                      <option value="">Select</option>
                      <option value="₹" <?php echo $vendor_invoice[0]['currency'] == '₹' ? 'selected' : '' ?>>INR(₹)</option>
                      <option value="$" <?php echo $vendor_invoice[0]['currency'] == '$' ? 'selected' : '' ?>>USD($)</option>
                    </select>
                  </div>
                </div>
                <div class="form-group mb-3 ">
                  <label class="form-label required">Total Amount</label>
                  <div>
                    <input type="text" name="total_amount" readonly class="form-control number" placeholder="Enter Total Amount" value="<?= $vendor_invoice[0]['total_amount'] ?>" required>
                  </div>
                </div>




                <div class="form-group col-md-6 mb-3 ">
                  <label class="form-label ">Attached Invoice Copy</label>
                  <div>
                    <input type="file" name="invoice_copy_attachment" class="form-control" placeholder="" accept="image/*">
                  </div>
                </div>
                <div class="form-group col-md-6 mb-3 ">
                  <label class="form-label ">Attached file</label>
                  <div>
                    <?php if (count($vendor_invoice_copy) > 0) {
                      echo '<a class="btn btn-icon btn-sm btn-info me-3" target="_blank" title="View" href="' . base_url() . "/" . PUBLIC_PATH . $vendor_invoice_copy[0]['file_url'] . '"><i class="ti ti-eye"></i></a>';
                      echo '<a class="btn btn-icon btn-sm btn-success" target="_blank" title="Download" href="' . base_url() . "/" . PUBLIC_PATH . $vendor_invoice_copy[0]['file_url'] . '" download><i class="ti ti-download"></i></a>';
                    } ?>
                  </div>
                </div>
              </div>
              <div class="form-footer">
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
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {

    $('#invoice_date').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true
    });
  });



  $(document).on('click', ".remove_data", function() {
    var items_id = $(this).val();
    var button = $(this);

    $.ajax({
        url: "<?php echo base_url() ?>/token/",
        method: "GET",
        success: function(token) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/vendor_invoice/invoice-items",
                data: {
                    items_id: items_id,
                    csrf_test_name: token
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        button.closest(".items_div").remove();
                        updateTotalAmount();
                    }
                }
            });
        }
    });
});


  
  let addButton = document.getElementById('addInput');

  let inputContainer = document.getElementById('inputContainer');
let arrayIndexDataElement = document.getElementById('array-index-data');
let inputCounterget = arrayIndexDataElement ? parseInt(arrayIndexDataElement.getAttribute('data-input-counter')) : 0;

   let inputCounter= inputCounterget + 1;
  addButton.addEventListener('click', function() {

    const newInputDiv = document.createElement('div');
    newInputDiv.classList.add('row');

    const currentIndex = inputCounter; // Store the current index
    const nameIndex = `asset[${currentIndex}][name]`;
    const countIndex = `asset[${currentIndex}][count]`;
    const priceIndex = `asset[${currentIndex}][price]`;
    const gstIndex = `asset[${currentIndex}][gst]`;
    const amountIndex = `asset[${currentIndex}][amount]`;

    const invoiceAssetsDetailsInput = document.createElement('div');
    invoiceAssetsDetailsInput.classList.add('col-3');
    invoiceAssetsDetailsInput.innerHTML = `
      <div class="form-group mb-3 ">
        
          <div>
              <input type="text" name="${nameIndex}"  class="form-control " placeholder="Enter Invoice Assets Details">
          </div>
      </div>
  `;
    newInputDiv.appendChild(invoiceAssetsDetailsInput);

    const totalQuantityCountInput = document.createElement('div');
    totalQuantityCountInput.classList.add('col-2');
    totalQuantityCountInput.innerHTML = `
      <div class="form-group mb-3 ">
       
          <div>
              <input type="text" name="${countIndex}" class="form-control number quantity"  placeholder="Enter Total Quantity Count" >
          </div>
      </div>
  `;
    newInputDiv.appendChild(totalQuantityCountInput);

    const priceInput = document.createElement('div');
    priceInput.classList.add('col-2');
    priceInput.innerHTML = `
      <div class="form-group mb-3 ">
         
          <div>
              <input type="text" name="${priceIndex}" class="form-control number price"  placeholder="Enter Price" >
          </div>
      </div>
  `;
    newInputDiv.appendChild(priceInput);


    const gstselect = document.createElement('div');
    gstselect.classList.add('col-2');
    gstselect.innerHTML = `
<div class="form-group mb-3">
          
          <div>
            <select class="form-select gst" name="${gstIndex}" >
              <option value="">Select</option>
              <option value="0">0%</option>
              <option value="5">5%</option>
              <option value="12">12%</option>
              <option value="18">18%</option>
              <option value="28">28%</option>
            </select>
          </div>
        </div>
  `;
    newInputDiv.appendChild(gstselect);


    const AmountInput = document.createElement('div');
    AmountInput.classList.add('col-2');
    AmountInput.innerHTML = `
      <div class="form-group mb-3 ">
         
          <div>
              <input type="text" name="${amountIndex}" class="form-control amount" readonly placeholder="Enter Price" >
          </div>
      </div>
  `;
    newInputDiv.appendChild(AmountInput);



    const remove = document.createElement('div');
    remove.classList.add('col-1');
    remove.innerHTML = `
      <div>
          <button type="button" class="btn btn-danger btn-sm remove-input" >X</button>
      </div>
  `;
    newInputDiv.appendChild(remove);

    inputContainer.appendChild(newInputDiv);





    function calculateRowAmount() {
				const quantity = parseFloat(inputContainer.querySelector(`input[name="${countIndex}"]`).value);

				const price = parseFloat(inputContainer.querySelector(`input[name="${priceIndex}"]`).value);
				const gst = parseFloat(inputContainer.querySelector(`select[name="${gstIndex}"]`).value);
				const amountField = inputContainer.querySelector(`input[name="${amountIndex}"]`);

				if (!isNaN(quantity) && !isNaN(price) && !isNaN(gst)) {
					const amount = (quantity * price * (1 + gst / 100)).toFixed(2);
					console.log(amount);
					amountField.value = amount;
					updateTotalAmount()
				} else {
					amountField.value = "";
				}
			}

			// Attach onchange event listeners to the fields
			const quantityInput = inputContainer.querySelector(`input[name="${countIndex}"]`);
			const priceInputs = inputContainer.querySelector(`select[name="${gstIndex}"]`);
			const gstSelect = inputContainer.querySelector(`input[name="${amountIndex}"]`);

			quantityInput.addEventListener('change', calculateRowAmount);
			priceInputs.addEventListener('change', calculateRowAmount);
			gstSelect.addEventListener('change', calculateRowAmount);



			const removeInputButton = newInputDiv.querySelector('.remove-input');
			removeInputButton.addEventListener('click', function() {

				inputContainer.removeChild(newInputDiv);
				inputCounter-1;
				updateTotalAmount();
			});







    inputCounter++;

    $("#insert").validate().settings.rules[priceIndex] = {
				required: true,
				number: true
			};


			$("#insert").validate().settings.messages[priceIndex] = {
				required: "This field is required.",
				number: "Please enter a valid number."
			};



			$("#insert").validate().settings.rules[nameIndex] = {
				required: true,
			};


			$("#insert").validate().settings.messages[nameIndex] = {
				required: "This field is required.",
			};



			$("#insert").validate().settings.rules[countIndex] = {
				required: true,
				number: true
			};


			$("#insert").validate().settings.messages[countIndex] = {
				required: "This field is required.",
				number: "Please enter a valid number."

			};


			$("#insert").validate().settings.rules[gstIndex] = {
				required: true,
			};


			$("#insert").validate().settings.messages[gstIndex] = {
				required: "This field is required.",
			};

			$("#insert").validate().settings.rules[amountIndex] = {
				required: true,
			};


			$("#insert").validate().settings.messages[amountIndex] = {
				required: "This field is required.",
			};



  });



  function calculateRowAmount(inputContainer) {
    const quantity = parseFloat(inputContainer.querySelector('.quantity').value);
    const price = parseFloat(inputContainer.querySelector('.price').value);
    const gst = parseFloat(inputContainer.querySelector('.gst').value);
    const amountField = inputContainer.querySelector('.amount');

    if (!isNaN(quantity) && !isNaN(price) && !isNaN(gst)) {
      const amount = (quantity * price * (1 + gst / 100)).toFixed(2);
      amountField.value = amount;
      updateTotalAmount();
    } else {
      amountField.value = "";
    }
  }


  const inputContainers = document.querySelectorAll('.items_div');

  inputContainers.forEach(inputContainer => {
    inputContainer.querySelector('.quantity').addEventListener('keyup', () => calculateRowAmount(inputContainer));
    inputContainer.querySelector('.price').addEventListener('keyup', () => calculateRowAmount(inputContainer));
    inputContainer.querySelector('.gst').addEventListener('change', () => calculateRowAmount(inputContainer));
  });


  function updateTotalAmount() {
    const totalAmountField = document.querySelector('input[name="total_amount"]');
    const amountFields = document.querySelectorAll('.amount');

    let totalAmount = 0;

    amountFields.forEach(function(field) {
      if (!isNaN(parseFloat(field.value))) {
        totalAmount += parseFloat(field.value);
      }
    });

    totalAmountField.value = totalAmount.toFixed(2);
  }



  $("#update").validate({

    rules: {
      vendor_id: {
        required: true
      },
      invoice_date: {
        required: true
      },
      invoice_no: {
        required: true
      },

    },
    messages: {
      vendor_id: {
        required: "Please select a vendor."
      },
      invoice_date: {
        required: "Please select an invoice date."
      },
      invoice_no: {
        required: "Please enter an invoice number."
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
          window.location.href = '<?php echo base_url() ?>/vendor_invoice/list';
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
</script>