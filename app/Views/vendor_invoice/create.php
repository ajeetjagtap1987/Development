<div class="page-header d-print-none">
	<div class="container-xl">
		<?php echo @view('includes/breadcrumb2', ['level_1' => 'Vendor Invoice List', 'level_1_url' => 'vendor_invoice/list', 'level_2' => 'Vendor Invoice Create']); ?>
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
						<form action="<?php echo base_url(); ?>/vendor_invoice/insert" method="post" enctype="multipart/form-data" id="insert" autocomplete="off" class="insert">

							<div class="form-group mb-3 ">
								<label class="form-label required">Vendor</label>
								<div>
									<select type="text" class="form-control" name="vendor_id" value="">
										<option value="">Select Vendor</option>
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
							<div class="form-group mb-3 ">
								<label class="form-label required">Invoice Date</label>
								<div class="input-icon mb-2">
									<input class="form-control datepicker" name="invoice_date" id="invoice_date" placeholder="Select Invoice Date">
									<span class="input-icon-addon">
										<i class="ti ti-calendar"></i>
									</span>
								</div>
							</div>
							<div class="form-group mb-3 ">
								<label class="form-label required">Invoice No.</label>
								<div>
									<input type="text" name="invoice_no" class="form-control " placeholder="Enter Invoice No.">
								</div>
							</div>
							<div class="form-group mb-3 ">
								<label class="form-label">E-Way Bill No</label>
								<div>
									<input type="text" name="e_way_bill_no" class="form-control" placeholder="Enter E-Way Bill No">
								</div>
							</div>

							<div class="caldiv">
								<div class="row">
									<div class="form-group mb-3 col-3">
										<label class="form-label required">Invoice Assets Details</label>
										<div>
											<input type="text" name="asset[0]['name']" class="form-control" placeholder="Enter Invoice Assets Details">
										</div>
									</div>


									<div class="form-group mb-3 col-2">
										<label class="form-label required">Total Quantity Count</label>
										<div>
											<input type="text" name="asset[0]['count']" class="form-control  quantity" placeholder="Enter Total Quantity Count">
										</div>
									</div>


									<div class="form-group mb-3 col-2">
										<label class="form-label required">Price</label>
										<div>
											<input type="text" name="asset[0]['price']" class="form-control  price" placeholder="price">
										</div>
									</div>


									<div class="form-group mb-3 col-2">
										<label class="form-label required">GST</label>
										<div>
											<select class="form-select" name="asset[0]['gst']">
												<option value="">Select</option>

												<option value="0">0%</option>
												<option value="5">5%</option>
												<option value="12">12%</option>
												<option value="18">18%</option>
												<option value="28">28%</option>
											</select>
										</div>
									</div>



									<div class="form-group mb-3 col-2">
										<label class="form-label required">Amount</label>
										<div>
											<input type="text" name="asset[0]['amount']" class="form-control  amount" readonly placeholder="amount">
										</div>
									</div>




								</div>



								<div id="inputContainer"></div>
							</div>

							<button type="button" class="btn btn-primary " id="addInput">Add</button>


							<div class="form-group mb-3 ">
								<label class="form-label required">Total Amount</label>
								<div>
									<input type="text" name="total_amount" class="form-control number" placeholder="Enter Total Amount">
								</div>
							</div>

							<div class="form-group mb-3">
								<label class="form-label required">Currency</label>
								<div>
									<select class="form-select" name="currency" required>
										<option value="">Select</option>
										<option value="₹">INR(₹)</option>
										<option value="$">USD($)</option>
									</select>
								</div>
							</div>





							<div class="form-group col-md-6 mb-3 ">
								<label class="form-label required">Attached Invoice Copy</label>
								<div>
									<input type="file" name="invoice_copy_attachment" class="form-control" placeholder="" accept="image/*">
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

$(document).ready(function (){
    $('#invoice_date').datepicker({
          format: 'dd-mm-yyyy', 
             autoclose: true
      });
  });



	document.addEventListener('DOMContentLoaded', function() {


		const addButton = document.getElementById('addInput');
		const inputContainer = document.getElementById('inputContainer');

		let inputCounter = 1;


		$("#insert").validate({

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

				invoice_copy_attachment: {
					required: true
				},
				"asset[0]['name']": {
					required: true,
				},
				"asset[0]['count']": {
					required: true,
					number: true
				},
				"asset[0]['price']": {
					required: true,
					number: true
				},
				"asset[0]['gst']": {
					required: true,
				},
				"asset[0]['amount']": {
					required: true,
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
				invoice_copy_attachment: {
					required: "Please attach the invoice copy."
				},
				"asset[0]['name']": {
					required: "Please enter the Invoice details.",

				},
				"asset[0]['count']": {
					required: "This field is required.",
					number: "Please enter a valid number."
				},
				"asset[0]['price']": {
					required: "This field is required.",
					number: "Please enter a valid number."
				},
				"asset[0]['amount']": {
					required: "This field is required.",
				},


			},
			submitHandler: function(form) {

				var post_url = $(form).attr("action");
				var request_method = $(form).attr("method");
				var form_data = new FormData(form);


				$.ajax({
					url: "<?php echo base_url() ?>/token/",
					method: "GET",
					success: function(token) {

						form_data.append('csrf_test_name', token);
						form_data.append('total_items_count', inputCounter);
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

			}


		});

		addButton.addEventListener('click', function() {

			const newInputDiv = document.createElement('div');
			newInputDiv.classList.add('row');

			const currentIndex = inputCounter; // Store the current index
			const nameIndex = `asset[${currentIndex}]['name']`;
			const countIndex = `asset[${currentIndex}]['count']`;
			const priceIndex = `asset[${currentIndex}]['price']`;
			const gstIndex = `asset[${currentIndex}]['gst']`;
			const amountIndex = `asset[${currentIndex}]['amount']`;

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
				inputCounter--;
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



		function updateTotalAmount() {
			const totalAmountField = document.querySelector('input[name="total_amount"]');
			const amountFields = document.querySelectorAll('.amount');
			console.log(amountFields);
			let totalAmount = 0;

			amountFields.forEach(function(field) {
				if (!isNaN(parseFloat(field.value))) {
					totalAmount += parseFloat(field.value);
				}
			});

			totalAmountField.value = totalAmount.toFixed(2);
		}


		function calculateRowAmount() {
			const quantity = parseFloat(document.querySelector('input[name="asset[0][\'count\']"]').value);
			const price = parseFloat(document.querySelector('input[name="asset[0][\'price\']"]').value);
			const gst = parseFloat(document.querySelector('select[name="asset[0][\'gst\']"]').value);
			const amountField = document.querySelector('input[name="asset[0][\'amount\']"]');

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
		const quantityInput = document.querySelector('input[name="asset[0][\'count\']"]');
		const priceInput = document.querySelector('input[name="asset[0][\'price\']"]');
		const gstSelect = document.querySelector('select[name="asset[0][\'gst\']"]');

		quantityInput.addEventListener('keyup', calculateRowAmount);
		priceInput.addEventListener('keyup', calculateRowAmount);
		gstSelect.addEventListener('change', calculateRowAmount);



		// let gstSelect = document.querySelector('[name="gst"]');
		// let totalAmountInput = document.querySelector('[name="total_amount"]');


		// let quantities = [];
		// let prices = [];


		// function updateTotalAmount() {


		// 	quantities = document.querySelectorAll('.quantity');
		// 	prices = document.querySelectorAll('.price');

		// 	let totalAmount = 0;


		// 	for (let i = 0; i < quantities.length; i++) {
		// 		let quantity = parseFloat(quantities[i].value) || 0;
		// 		let price = parseFloat(prices[i].value) || 0;

		// 		totalAmount += quantity * price;
		// 	}


		// 	let gstRate = parseFloat(gstSelect.value);

		// 	if (!isNaN(gstRate)) {
		// 		totalAmount += (totalAmount * gstRate) / 100;
		// 	}

		// 	totalAmountInput.value = totalAmount.toFixed(2);

		// 	for (let i = 0; i < quantities.length; i++) {
		// 		quantities[i].addEventListener('keyup', updateTotalAmount);
		// 		prices[i].addEventListener('keyup', updateTotalAmount);
		// 	}

		// }

		// gstSelect.addEventListener('change', updateTotalAmount);


		// updateTotalAmount();


		// $("#insert").submit(function(event) {
		// 	event.preventDefault();


		// });


	});
</script>