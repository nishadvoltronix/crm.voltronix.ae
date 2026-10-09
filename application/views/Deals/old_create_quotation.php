

      <!-- ================= CREATE QUOTATION ================= -->

       <div class="card shadow-sm">


  <div class="card-body">
    <form id="reProposalForm">

      <!-- Deal Info -->
      <h6 class="text text-dangers mb-3">Deal Information</h6>
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Deal Number <span class="text-dangers">*</span></label>
          <input type="text" class="form-control" name="dealNumber" placeholder="DEAL-0001" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Subject <span class="text-dangers">*</span></label>
          <input type="text" class="form-control" name="subject" placeholder="Proposal subject" required>
        </div>
      </div>

      <hr class="my-4">

      <!-- Items -->
      <h6 class="text text-dangers mb-3">Proposal Items</h6>
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead class="table-light text-center">
            <tr>
              <th width="40">#</th>
              <th>Item</th>
              <th width="90">UOM</th>
              <th width="80">Qty</th>
              <th width="120">Price</th>
              <th width="120">Discount</th>
              <th width="130">Total</th>
              <th width="50"></th>
            </tr>
          </thead>
          <tbody id="itemRows">
            <!-- Dynamic rows -->
          </tbody>
        </table>
      </div>

      <button type="button" id="addItem" class="btn btn-outline-dangers mb-3">
        <i class="fas fa-plus me-1"></i> Add Item
      </button>

      <hr class="my-4">

      <!-- Totals -->
      <h6 class="text-dangers mb-3">Calculation Summary</h6>
      <div class="row">
        <div class="col-md-4 offset-md-8">
          <div class="mb-2">
            <label class="form-label">Sub Total</label>
            <input class="form-control" name="subTotal" readonly>
          </div>

          <div class="mb-2">
            <label class="form-label">Discount</label>
            <input class="form-control" name="discount" placeholder="Enter discount">
          </div>

          <div class="mb-2">
            <label class="form-label">VAT (%)</label>
            <input class="form-control" name="vat" value="5" readonly>
          </div>

          <div class="mb-2">
            <label class="form-label">Adjustment</label>
            <input class="form-control" name="adjustment" placeholder="Adjustment amount">
          </div>

          <div class="mb-2">
            <label class="form-label fw-bold">Grand Total</label>
            <input class="form-control fw-bold text-success" name="grandTotal" readonly>
          </div>
        </div>
      </div>
      
      <div class="card shadow-sm mt-4">
  <div class="card-header bg-light">
    <h6 class="mb-0 text-dark">
      <i class="fas fa-info-circle me-2 text-dangers"></i> Additional Details
    </h6>
  </div>

  <div class="card-body">
    <div class="row g-3">

      <div class="col-md-4">
        <label class="form-label">Kind Attention</label>
        <input type="text" name="kind_attention" class="form-control" placeholder="Person / Department">
        <div class="error-message"></div>
      </div>

      <div class="col-md-4">
        <label class="form-label">Project</label>
        <input type="text" name="project" class="form-control" placeholder="Project name">
        <div class="error-message"></div>
      </div>

      <div class="col-md-4">
        <label class="form-label">Terms of Payment</label>
        <input type="text" name="termsOfPayment" class="form-control" placeholder="e.g. 30 Days">
        <div class="error-message"></div>
      </div>

      <div class="col-md-6">
        <label class="form-label">Specification</label>
        <textarea class="form-control" name="specification" rows="3" placeholder="Technical specifications"></textarea>
        <div class="error-message"></div>
      </div>

      <div class="col-md-6">
        <label class="form-label">General Exclusion</label>
        <textarea class="form-control" name="generalExclusion" rows="3" placeholder="Excluded items or scope"></textarea>
        <div class="error-message"></div>
      </div>

      <div class="col-md-4">
        <label class="form-label">Brand</label>
        <input type="text" class="form-control" name="brand" placeholder="Brand name">
        <div class="error-message"></div>
      </div>

      <div class="col-md-4">
        <label class="form-label">Warranty</label>
        <input type="text" class="form-control" name="warranty" placeholder="Warranty period">
        <div class="error-message"></div>
      </div>

      <div class="col-md-4">
        <label class="form-label">Delivery</label>
        <input type="text" class="form-control" name="delivery" placeholder="Delivery timeline">
        <div class="error-message"></div>
      </div>

      <div class="col-md-8">
        <label class="form-label">Notes</label>
        <textarea class="form-control" name="notes" rows="3" placeholder="Additional remarks"></textarea>
        <div class="error-message"></div>
      </div>

      <div class="col-md-4">
        <label class="form-label">Valid Until</label>
        <input type="date" class="form-control" name="validUntil" onclick="this.showPicker()">
        <div class="error-message"></div>
      </div>

    </div>
  </div>

</div>


      <!-- Actions -->
      <div class="card-footer text-end mt-4">
        <button type="submit" class="btn btn-dangers px-4 submitButton">
          <i class="fas fa-save me-1"></i> Save Proposal
          <span class="loader buttonLoader ms-2 d-none"></span>
        </button>
      </div>

    </form>
  </div>
</div>

<!-- Include jQuery and Select2 JavaScript -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- Optional: Include Bootstrap's JavaScript (jQuery and Popper.js) for accordion functionality -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script>

 		//add a row for each product and Initialize Select2 for each row
		$(document).ready(function () {
			let rowCount = 1; // Track the number of rows

			// Function to initialize Select2 for a row
			function initializeSelect2(row) {
				const productDetails = {}; // Store product descriptions for quick access
				let loading = false; // Prevent multiple concurrent requests
				let hasMoreRecords = true; // Indicator for more records
				let page = 1; // Current page for pagination
				let lastQuery = ''; // To track the last search query

				$(row).find('.itemName').select2({
					placeholder: 'Search for an item..',
					allowClear: true,
					width: '100%',
					ajax: {
						transport: function (params, success, failure) {
							const query = params.data.q || ''; // Capture the current search query

							// Reset pagination and clear results if the query changes
							if (query !== lastQuery) {
								page = 1; // Reset to the first page
								hasMoreRecords = true; // Reset the flag for more records
								lastQuery = query; // Update the last query
								success({ results: [] }); // Clear previous results in the dropdown
							}

							// Prevent multiple requests or if no more records
							if (loading || !hasMoreRecords) return;

							loading = true; // Mark as loading

							fetch(`https://app.voltronix.ae/voltronix/deal/products?page=${page}&per_page=20&q=${encodeURIComponent(query)}`)
								.then((response) => response.json())
								.then((data) => {
									const results = [];
									if (data.success && Array.isArray(data.products)) {
										data.products.forEach((product) => {
											productDetails[product.id] = product.description || ''; // Cache product descriptions
											results.push({ id: product.id, text: product.name }); // Format for Select2
										});

										hasMoreRecords = data.more_records; // Update the flag for more records
										page++; // Increment page for the next request

										success({ results, pagination: { more: hasMoreRecords } }); // Send results to Select2
									} else {
										hasMoreRecords = false; // No more records
										success({ results: [], pagination: { more: false } });
									}
								})
								.catch((error) => {
									console.error('Error fetching products:', error);
									failure(error);
								})
								.finally(() => {
									loading = false; // Reset loading state
								});
						},
						processResults: function (data) {
							return data; // The transport already formats the response correctly
						},
						delay: 250, // Add delay to prevent excessive requests
					},
					templateResult: formatOption,
					templateSelection: formatOption,
				});

				// Handle description display when a product is selected
				$(row).find('.itemName').on('change', function () {
					const selectedItemId = $(this).val();
					const descriptionField = $(row).find('.itemDescription');

					// Clear the description if no item is selected
					if (!selectedItemId) {
						descriptionField.val('');
						return;
					}

					// Fetch the product description from the stored details
					const selectedDescription = productDetails[selectedItemId];
					descriptionField.val(selectedDescription || '');
				});
			}

			// Format long text in dropdown and selection
			function formatOption(option) {
				if (!option.id) return option.text; // Show placeholder
				return $('<span class="wrap-text"></span>').text(option.text); // Wrap long text
			}

			// Function to update row numbers
			function updateRowNumbers() {
				$('#itemRows tr').each(function (index) {
					$(this).find('td:first').text(index + 1); // Update the S.NO column
				});
			}

			// Add new row on button click
			$('#addItem').on('click', function () {
				rowCount++;
				const newRow = `
					<tr class="item-row">
						<td>${$('#itemRows tr').length + 1}</td>
						<td class="align-top">
                        <input type="hidden" class="product_id" name="product_id[]">
                        <input type="hidden" class="product_name" name="product_name[]">

                        <select class="form-control form-control-sm itemName mb-1" name="itemName[]" required>
                          <option value="">- Select Item -</option>
                        </select>

                        <textarea 
                          name="itemDescription[]" 
                          class="form-control form-control-sm itemDescription"
                          rows="3"
                          placeholder="Description (optional)">
                        </textarea>

                        <div class="error-message"></div>
                      </td>

						<td>
							<select class="form-control uom" name="uom[]" required>
								<option value="">-None-</option>
								<option value="NOS" selected>NOS</option>
								<option value="PCS">PCS</option>
								<option value="LS">LS</option>
								<option value="BAG">BAG</option>
								<option value="BKT">BKT</option>
								<option value="BND">BND</option>
								<option value="BOWL">BOWL</option>
								<option value="BX">BX</option>
								<option value="CRD">CRD</option>
								<option value="CM">CM</option>
								<option value="CS">CS</option>
								<option value="CTN">CTN</option>
								<option value="DZ">DZ</option>
								<option value="EA">EA</option>
								<option value="FT">FT</option>
								<option value="GAL">GAL</option>
								<option value="GROSS">GROSS</option>
								<option value="IN">IN</option>
								<option value="KIT">KIT</option>
								<option value="LOT">LOT</option>
								<option value="M">M</option>
								<option value="MM">MM</option>
								<option value="PC">PC</option>
								<option value="PK">PK</option>
								<option value="PK100">PK100</option>
								<option value="PK50">PK50</option>
								<option value="PR">PR</option>
								<option value="RACK">RACK</option>
								<option value="RL">RL</option>
								<option value="SET">SET</option>
								<option value="SET3">SET3</option>
								<option value="SET4">SET4</option>
								<option value="SET5">SET5</option>
								<option value="SGL">SGL</option>
								<option value="SHT">SHT</option>
								<option value="SQFT">SQFT</option>
								<option value="TUBE">TUBE</option>
								<option value="YD">YD</option>
								<option value="SQM">SQM</option>
							</select>
							<div class="error-message"></div>
						</td>
						<td>
							<input type="number" name="quantity[]" value="1" class="form-control quantity" placeholder="Quantity" required>
							<div class="error-message"></div>
						</td>
						<td>
							<input type="number" name="unitPrice[]" value="0" class="form-control unitPrice" placeholder="Unit Price" required>
							<div class="error-message"></div>
						</td>
						<td style="min-width: 100px;">
							<input type="number" name="itemDiscount[]" value="0" class="form-control no-arrows itemDiscount" placeholder="Discount" required>
							<div class="error-message"></div>
						</td>
						<td>
							<input type="number" name="total[]" class="form-control total" placeholder="Total" readonly>
							<div class="error-message"></div>
						</td>
						<td>
							<button type="button" class="btn btn-danger btn-sm remove-row">
								<i class="bi bi-trash"></i> <!-- Bootstrap trash icon -->
							</button>
						</td>
					</tr>
				`;
				$('#itemRows').append(newRow);

				// Initialize Select2 for the new row
				initializeSelect2($('#itemRows tr:last'));

				// Update row numbers
				updateRowNumbers();
			});

			 // Remove row when the "Remove" button is clicked
			 $('#itemRows').on('click', '.remove-row', function () {
				$(this).closest('tr').remove(); // Remove the closest row
				updateRowNumbers(); // Update the row numbers
			});

			// Initialize Select2 for the primary row
			initializeSelect2($('#itemRows tr:first'));
		});

		// Separate calculateTotals function
		function calculateTotals() {
			let subTotal = 0;

			// Loop through each row and calculate totals with discount
			$('.item-row').each(function () {
				const quantity = parseFloat($(this).find('.quantity').val()) || 0;
				const unitPrice = parseFloat($(this).find('.unitPrice').val()) || 0;
				const discountPercentage = parseFloat($(this).find('.itemDiscount').val()) || 0;

				const baseTotal = quantity * unitPrice;
				const discountFactor = 1 - (discountPercentage / 100);
				const discountedTotal = baseTotal * discountFactor;

				$(this).find('.total').val(discountedTotal.toFixed(2));
				subTotal += discountedTotal;
			});

			$('#sub-total').val(subTotal.toFixed(2));

			// Calculate overall totals with safeguards
			const discountAmount = parseFloat($('#discount').val()) || 0; // Overall discount (AED)
			const subTotalAfterDiscount = Math.max(0, subTotal - discountAmount); // Prevent negative
			const vatPercentage = 5;
			const vat = (vatPercentage / 100) * subTotalAfterDiscount;
			const adjustment = parseFloat($('#adjustment').val()) || 0;
			const grandTotal = subTotalAfterDiscount + vat + adjustment;

			// Debug output
			console.log({
				subTotal: subTotal.toFixed(2),
				discountAmount: discountAmount.toFixed(2),
				subTotalAfterDiscount: subTotalAfterDiscount.toFixed(2),
				vat: vat.toFixed(2),
				adjustment: adjustment.toFixed(2),
				grandTotal: grandTotal.toFixed(2)
			});

			$('#grand-total').val(grandTotal.toFixed(2));
		}

		// Attach event listeners to recalculate totals
		$('#itemRows').on('input', '.quantity, .unitPrice, .itemDiscount', calculateTotals);
		$('#discount, #adjustment').on('input', calculateTotals);

	    // toggle icons
		$(document).ready(function () {
			// Initialize icons based on the initial state of collapses
			if ($("#collapseOne").hasClass("show")) {
				$("#addDealIcon").removeClass("bi-plus-circle").addClass("bi-dash-circle");
			} else {
				$("#addDealIcon").removeClass("bi-dash-circle").addClass("bi-plus-circle");
			}

			// Collapse Three
			$("#collapseThree").on("shown.bs.collapse", function () {
				$("#editQuoteIcon").removeClass("bi-plus-circle").addClass("bi-dash-circle");
			});

			$("#collapseThree").on("hidden.bs.collapse", function () {
				$("#editQuoteIcon").removeClass("bi-dash-circle").addClass("bi-plus-circle");
			});

			// Collapse Two
			$("#collapseTwo").on("shown.bs.collapse", function () {
				$("#addProposalIcon").removeClass("bi-plus-circle").addClass("bi-dash-circle");
			});

			$("#collapseTwo").on("hidden.bs.collapse", function () {
				$("#addProposalIcon").removeClass("bi-dash-circle").addClass("bi-plus-circle");
			});
			
			// Collapse Four
			$("#collapseFour").on("shown.bs.collapse", function () {
				$("#addItemIcon").removeClass("bi-plus-circle").addClass("bi-dash-circle");
			});

			$("#collapseFour").on("hidden.bs.collapse", function () {
				$("#addItemIcon").removeClass("bi-dash-circle").addClass("bi-plus-circle");
			});

			// Collapse One
			$("#collapseOne").on("shown.bs.collapse", function () {
				$("#addDealIcon").removeClass("bi-plus-circle").addClass("bi-dash-circle");
			});

			$("#collapseOne").on("hidden.bs.collapse", function () {
				$("#addDealIcon").removeClass("bi-dash-circle").addClass("bi-plus-circle");
			});
		});

		// Set today's date as the minimum date
		const dateInput = document.getElementById('valid-until');
		const today = new Date().toISOString().split('T')[0]; // Format the date as YYYY-MM-DD
		dateInput.setAttribute('min', today);
		
		// Set today's date as the minimum date
		const dateInput2 = document.getElementById('valid-until2');
		const today2 = new Date().toISOString().split('T')[0]; // Format the date as YYYY-MM-DD
		dateInput2.setAttribute('min', today2);

		// Fetch item names2 from the API and quote details for editing a quote
		$(document).ready(function () {
            const productDetails = {};
            let loading = false;
            let hasMoreRecords = true;
            let page = 1;
            let lastQuery = '';
        
            // Function to initialize Select2 for a row
            function initializeSelect2(row, preloadedDescription = '') {
                $(row).find('.itemName').select2({
                    placeholder: 'Search for an item.',
                    allowClear: true,
                    width: '100%',
                    ajax: {
                        transport: function (params, success, failure) {
                            const query = params.data.q || '';
                            if (query !== lastQuery) {
                                page = 1;
                                hasMoreRecords = true;
                                lastQuery = query;
                                success({ results: [] });
                            }
                            if (loading || !hasMoreRecords) return;
                            loading = true;
                            fetch(`https://app.voltronix.ae/voltronix/deal/products?page=${page}&per_page=20&q=${encodeURIComponent(query)}`)
                                .then((response) => response.json())
                                .then((data) => {
                                    const results = [];
                                    if (data.success && Array.isArray(data.products)) {
                                        data.products.forEach((product) => {
                                            productDetails[product.id] = product.description || '';
                                            results.push({ id: product.id, text: product.name });
                                        });
                                        hasMoreRecords = data.more_records;
                                        page++;
                                        success({ results, pagination: { more: hasMoreRecords } });
                                    } else {
                                        hasMoreRecords = false;
                                        success({ results: [], pagination: { more: false } });
                                    }
                                })
                                .catch((error) => {
                                    console.error('Error fetching products:', error);
                                    failure(error);
                                })
                                .finally(() => {
                                    loading = false;
                                });
                        },
                        processResults: function (data) {
                            return data;
                        },
                        delay: 250,
                    },
                });
        
                $(row).find('.itemName').on('change', function () {
                    const selectedItemId = $(this).val();
                    const descriptionField = $(row).find('.itemDescription');
                    if (!selectedItemId) {
                        descriptionField.val('');
                        return;
                    }
                    // Only update description if not preloaded (i.e., user manually selects an item)
                    if (!preloadedDescription) {
                        const selectedDescription = productDetails[selectedItemId] || '';
                        descriptionField.val(selectedDescription);
                    }
                    row.find('.product_id').val(selectedItemId);
                    row.find('.product_name').val($(this).find('option:selected').text());
                });
            }
        
            // Function to add a new row with pre-filled data
            function addItemRow(itemData = {}, includeDeleteButton = true) {
                const rowCount = $('#itemRows2 tbody tr').length + 1;
                const newRow = `
                    <tr class="item-row">
                        <td>${rowCount}</td>
                        <td class="align-top">
                        <input type="hidden" class="product_id" name="product_id[]" value="${itemData.product_id || ''}">
                        <input type="hidden" class="product_name" name="product_name[]" value="${itemData.product_name || ''}">

                        <select class="form-control form-control-sm itemName mb-1" name="itemName[]" required>
                          <option value="">- Select Item -</option>
                        </select>

                        <textarea 
                          name="itemDescription[]" 
                          class="form-control form-control-sm itemDescription"
                          rows="3"
                          placeholder="Description (optional)">
                        ${itemData.product_description || ''}</textarea>

                        <div class="error-message"></div>
                      </td>
                        <td>
                            
                            <select class="form-control itemName" name="itemName[]" required>
                                <option value="">-None-</option>
                            </select>
                            <textarea name="itemDescription[]" class="itemDescription" cols="30" rows="3" style="width: 100%; border: 1px solid #ced4da;">${itemData.product_description || ''}</textarea>
                            <div class="error-message"></div>
                        </td>
                        <td>
                            <select class="form-control uom" name="uom[]" required>
                                <option value="">-None-</option>
                                <option value="NOS" ${itemData.uom === 'NOS' ? 'selected' : ''}>NOS</option>
                                <option value="PCS" ${itemData.uom === 'PCS' ? 'selected' : ''}>PCS</option>
                                <option value="LS" ${itemData.uom === 'LS' ? 'selected' : ''}>LS</option>
                                <option value="BAG" ${itemData.uom === 'BAG' ? 'selected' : ''}>BAG</option>
                                <option value="BKT" ${itemData.uom === 'BKT' ? 'selected' : ''}>BKT</option>
                                <option value="BND" ${itemData.uom === 'BND' ? 'selected' : ''}>BND</option>
                                <option value="BOWL" ${itemData.uom === 'BOWL' ? 'selected' : ''}>BOWL</option>
                                <option value="BX" ${itemData.uom === 'BX' ? 'selected' : ''}>BX</option>
                                <option value="CRD" ${itemData.uom === 'CRD' ? 'selected' : ''}>CRD</option>
                                <option value="CM" ${itemData.uom === 'CM' ? 'selected' : ''}>CM</option>
                                <option value="CS" ${itemData.uom === 'CS' ? 'selected' : ''}>CS</option>
                                <option value="CTN" ${itemData.uom === 'CTN' ? 'selected' : ''}>CTN</option>
                                <option value="DZ" ${itemData.uom === 'DZ' ? 'selected' : ''}>DZ</option>
                                <option value="EA" ${itemData.uom === 'EA' ? 'selected' : ''}>EA</option>
                                <option value="FT" ${itemData.uom === 'FT' ? 'selected' : ''}>FT</option>
                                <option value="GAL" ${itemData.uom === 'GAL' ? 'selected' : ''}>GAL</option>
                                <option value="GROSS" ${itemData.uom === 'GROSS' ? 'selected' : ''}>GROSS</option>
                                <option value="IN" ${itemData.uom === 'IN' ? 'selected' : ''}>IN</option>
                                <option value="KIT" ${itemData.uom === 'KIT' ? 'selected' : ''}>KIT</option>
                                <option value="LOT" ${itemData.uom === 'LOT' ? 'selected' : ''}>LOT</option>
                                <option value="M" ${itemData.uom === 'M' ? 'selected' : ''}>M</option>
                                <option value="MM" ${itemData.uom === 'MM' ? 'selected' : ''}>MM</option>
                                <option value="PC" ${itemData.uom === 'PC' ? 'selected' : ''}>PC</option>
                                <option value="PK" ${itemData.uom === 'PK' ? 'selected' : ''}>PK</option>
                                <option value="PK100" ${itemData.uom === 'PK100' ? 'selected' : ''}>PK100</option>
                                <option value="PK50" ${itemData.uom === 'PK50' ? 'selected' : ''}>PK50</option>
                                <option value="PR" ${itemData.uom === 'PR' ? 'selected' : ''}>PR</option>
                                <option value="RACK" ${itemData.uom === 'RACK' ? 'selected' : ''}>RACK</option>
                                <option value="RL" ${itemData.uom === 'RL' ? 'selected' : ''}>RL</option>
                                <option value="SET" ${itemData.uom === 'SET' ? 'selected' : ''}>SET</option>
                                <option value="SET3" ${itemData.uom === 'SET3' ? 'selected' : ''}>SET3</option>
                                <option value="SET4" ${itemData.uom === 'SET4' ? 'selected' : ''}>SET4</option>
                                <option value="SET5" ${itemData.uom === 'SET5' ? 'selected' : ''}>SET5</option>
                                <option value="SGL" ${itemData.uom === 'SGL' ? 'selected' : ''}>SGL</option>
                                <option value="SHT" ${itemData.uom === 'SHT' ? 'selected' : ''}>SHT</option>
                                <option value="SQFT" ${itemData.uom === 'SQFT' ? 'selected' : ''}>SQFT</option>
                                <option value="TUBE" ${itemData.uom === 'TUBE' ? 'selected' : ''}>TUBE</option>
                                <option value="YD" ${itemData.uom === 'YD' ? 'selected' : ''}>YD</option>
                                <option value="SQM" ${itemData.uom === 'SQM' ? 'selected' : ''}>SQM</option>
                            </select>
                            <div class="error-message"></div>
                        </td>
                        <td style="min-width: 100px;">
                            <input type="number" name="quantity[]" class="form-control no-arrows quantity" placeholder="Quantity" value="${itemData.quantity || ''}" required>
                            <div class="error-message"></div>
                        </td>
                        <td style="min-width: 100px;">
                            <input type="number" name="unitPrice[]" class="form-control no-arrows unitPrice" placeholder="Unit Price" value="${itemData.service_charge || ''}" required>
                            <div class="error-message"></div>
                        </td>
                        <td style="min-width: 100px;">
                            <input type="number" name="itemDiscount[]" class="form-control no-arrows itemDiscount" placeholder="Discount" value="${itemData.item_discount || '0'}" required>
                            <div class="error-message"></div>
                        </td>
                        <td style="min-width: 100px;">
                            <input type="number" name="total[]" class="form-control total" placeholder="Total" value="${itemData.total || ''}" readonly>
                            <div class="error-message"></div>
                        </td>
                        <td>
                            ${includeDeleteButton ? `
                                <button type="button" class="btn btn-danger btn-sm remove-row">
                                    <i class="bi bi-trash"></i>
                                </button>
                            ` : ''}
                        </td>
                    </tr>
                `;
                $('#itemRows2 tbody').append(newRow);
                initializeSelect2($('#itemRows2 tbody tr:last'), itemData.product_description || '');
        
                // Pre-select item in Select2
                if (itemData.product_id && itemData.product_name) {
                    const $select = $('#itemRows2 tbody tr:last .itemName');
                    $select.append(new Option(itemData.product_name, itemData.product_id, true, true)).trigger('change');
                }
            }
        
            // Fetch quote details on Enter key press
            $('#QuoteNumber').on('keypress', function (e) {
                if (e.which === 13) { // Enter key
                    e.preventDefault();
                    const quoteNumber = $(this).val();
                    if (quoteNumber.trim() === '') return;
        
                    $.ajax({
                        url: '<?php echo site_url('web/dashboard/get_quote_details'); ?>',
                        type: 'POST',
                        dataType: 'json',
                        contentType: 'application/json',
                        data: JSON.stringify({ QuoteNumber: quoteNumber }),
                        success: function (response) {
                            if (response.success) {
                                const data = response.data;
                                const items = response.items || [];
        
                                // Populate static fields
                                $('#subject2').val(data.subject || '');
                                $('#kind_attention2').val(data.kind_attention || '');
                                $('#project2').val(data.project_name || '');
                                $('#specification2').val(data.specification || '');
                                $('#general-exclusion2').val(data.general_exclusion || '');
                                $('#brand2').val(data.brand || '');
                                $('#warranty2').val(data.warranty || '');
                                $('#delivery2').val(data.delivery || '');
                                $('#notes2').val(data.notes || '');
                                $('#terms-of-payment2').val(data.terms_of_payment || '');
                                $('#valid-until2').val(data.valid_until || '');
                                $('#sub-total2').val(data.sub_total || '');
                                $('#discount2').val(data.discount || '');
                                $('#adjustment2').val(data.adjustment || '');
                                $('#grand-total2').val(data.grand_total || '');
        
                                // Clear existing rows
                                $('#itemRows2 tbody').empty();
        
                                // Populate item rows
                                if (items.length > 0) {
                                    items.forEach((item, index) => {
                                        // First row (index 0) should not have a delete button
                                        const includeDeleteButton = index !== 0;
                                        addItemRow(item, includeDeleteButton);
                                    });
                                } else {
                                    addItemRow({}, false); // Add a blank row if no items, no delete button
                                }
        
                                calculateTotals();
                            } else {
                                console.error('API Error:', response.error || 'Failed to fetch quote details.');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.error || 'Failed to fetch quote details.',
                                });
                            }
                        },
                        error: function () {
                            console.error('AJAX Error: Error fetching quote details.');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An unexpected error occurred while fetching quote details.',
                            });
                        }
                    });
                }
            });
        
            // Add new row on button click
            $('#addItem2').on('click', function () {
                addItemRow(); // Default behavior includes delete button for manually added rows
            });
        
            // Remove row
            $('#itemRows2').on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
                updateRowNumbers();
                calculateTotals();
            });
        
            // Update row numbers
            function updateRowNumbers() {
                $('#itemRows2 tbody tr').each(function (index) {
                    $(this).find('td:first').text(index + 1);
                });
            }
        
            // Calculate totals
            function calculateTotals() {
                let subTotal = 0;
                $('.item-row').each(function () {
                    const quantity = parseFloat($(this).find('.quantity').val()) || 0;
                    const unitPrice = parseFloat($(this).find('.unitPrice').val()) || 0;
                    const discountPercentage = parseFloat($(this).find('.itemDiscount').val()) || 0;
                    const baseTotal = quantity * unitPrice;
                    const discountFactor = 1 - (discountPercentage / 100);
                    const discountedTotal = baseTotal * discountFactor;
                    $(this).find('.total').val(discountedTotal.toFixed(2));
                    subTotal += discountedTotal;
                });
                $('#sub-total2').val(subTotal.toFixed(2));
                const discountAmount = parseFloat($('#discount2').val()) || 0;
                const subTotalAfterDiscount = Math.max(0, subTotal - discountAmount);
                const vatPercentage = 5;
                const vat = (vatPercentage / 100) * subTotalAfterDiscount;
                const adjustment = parseFloat($('#adjustment2').val()) || 0;
                const grandTotal = subTotalAfterDiscount + vat + adjustment;
                $('#grand-total2').val(grandTotal.toFixed(2));
            }
        
            // Handle form submission
            $('#editQuoteForm').submit(function (e) {
                e.preventDefault();
                $('.error-message').empty();
        
                const formData = {
                    QuoteNumber: $('#QuoteNumber').val(),
                    subject: $('#subject2').val(),
                    kind_attention: $('#kind_attention2').val(),
                    project: $('#project2').val(),
                    termsOfPayment: $('#terms-of-payment2').val(),
                    specification: $('#specification2').val(),
                    generalExclusion: $('#general-exclusion2').val(),
                    brand: $('#brand2').val(),
                    warranty: $('#warranty2').val(),
                    delivery: $('#delivery2').val(),
                    notes: $('#notes2').val(),
                    validUntil: $('#valid-until2').val(),
                    subTotal: $('#sub-total2').val(),
                    discount: $('#discount2').val(),
                    adjustment: $('#adjustment2').val(),
                    grandTotal: $('#grand-total2').val(),
                    items: []
                };
        
                let hasErrors = false;
                $('#itemRows2 tbody tr').each(function () {
                    const item = {
                        product_id: $(this).find('.product_id').val(),
                        product_name: $(this).find('.product_name').val(),
                        itemName: $(this).find('.itemName').val(),
                        itemDescription: $(this).find('.itemDescription').val(),
                        uom: $(this).find('.uom').val(),
                        quantity: $(this).find('.quantity').val(),
                        itemDiscount: $(this).find('.itemDiscount').val(),
                        unitPrice: $(this).find('.unitPrice').val(),
                        total: $(this).find('.total').val()
                    };
                    if (!item.itemName) {
                        $(this).find('.error-message').text('Item Name is required.');
                        hasErrors = true;
                        return false; // Break the .each loop
                    }
                    formData.items.push(item);
                });
        
                if (hasErrors) {
                    return; // Stop submission if there are validation errors
                }
        
                // Show SweetAlert loading spinner
                Swal.fire({
                    title: 'Submitting...',
                    text: 'Please wait while your proposal is being updated.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
        
                $.ajax({
                    url: 'dashboard/edit_proposal',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Proposal Edited!',
                                html: `
                                    <p>${response.message}</p>
                                    <a href="<?= site_url('web/deal/download-quote/') ?>${response.id}"
                                    class="btn btn-success btn-sm" 
                                    title="Download Quote" target="_blank" 
                                    rel="noopener noreferrer">
                                        <i class="bi bi-download"></i> Download Quote
                                    </a>
                                `,
                                showConfirmButton: true,
                                customClass: {
                                    confirmButton: 'btn-custom-ok'
                                }
                            }).then(() => {
                                $('#editQuoteForm')[0].reset();
                                $('#itemRows2 tbody').empty();
                                addItemRow({}, false); // Add a blank row without delete button
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.error || 'Failed to edit proposal.',
                                showConfirmButton: true,
                                customClass: {
                                    confirmButton: 'btn-custom-ok'
                                }
                            });
                        }
                    },
                    error: function (xhr) {
                        const errorMessage = xhr.responseJSON?.error || 'An unexpected error occurred.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Form Submission Error',
                            text: errorMessage,
                            showConfirmButton: true,
                            customClass: {
                                confirmButton: 'btn-custom-ok'
                            }
                        });
                    }
                });
            });
        
            // Recalculate totals on input change
            $('#itemRows2').on('input', '.quantity, .unitPrice, .itemDiscount, #discount2, #adjustment2', function () {
                calculateTotals();
            });
        
            // Initial blank row (no delete button by default)
            addItemRow({}, false);
        });

		// Handle logout
		$(document).ready(function() {
			// Handle logout button click
			$('#logoutButton').click(function(e) {
				e.preventDefault(); // Prevent the default button action

				// Optionally, show a confirmation popup before logout
				Swal.fire({
					title: 'Are you sure you want to log out?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes, log out!',
					cancelButtonText: 'Cancel'
				}).then((result) => {
					if (result.isConfirmed) {
						// Show loader while logging out
						$('#logoutButton').prop('disabled', true).text('Logging out...');

						// AJAX request to logout the user
						$.ajax({
							url: 'Login/logout', // This should be the route for logging out
							type: 'POST',
							dataType: 'json',
							success: function(response) {
								if (response.success) {
									Swal.fire({
										icon: 'success',
										title: 'Logged Out',
										text: 'You have been successfully logged out.',
										showConfirmButton: false,
										timer: 1500
									}).then(() => {
										window.location.href = 'Login/index';
									});
								} else {
									// Handle any errors returned from the logout
									Swal.fire({
										icon: 'error',
										title: 'Logout Failed',
										text: response.message || 'An unexpected error occurred.',
										showConfirmButton: true
									});
								}
							},
							error: function(xhr) {
								// Hide loader and re-enable button on error
								$('#logoutButton').prop('disabled', false).text('Logout');

								// Show an error message
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'An error occurred while logging out. Please try again.',
									showConfirmButton: true
								});
							}
						});
					}
				});
			});
		});

		$(document).ready(function() {
			
			// Handle product selection and store values in hidden fields for all rows
			$(document).on('change', '.itemName', function () {
				const row = $(this).closest('tr'); // Get the closest row
				const productId = $(this).val(); // Get product_id from value
				const productName = $(this).find('option:selected').text(); // Get product_name from text

				// Store these values in hidden fields within the same row
				row.find('.product_id').val(productId);
				row.find('.product_name').val(productName);
			});

			$('#reProposalForm').submit(function (e) {
				e.preventDefault();

				// Reset any previous error messages
				$('.error-message').empty();

				// Collect form data
				const formData = {
					dealNumber: $('#deal-number').val(),
					subject: $('#subject').val(),
					kind_attention: $('#kind_attention').val(),
					project: $('#project').val(),
					termsOfPayment: $('#terms-of-payment').val(),
					specification: $('#specification').val(),
					generalExclusion: $('#general-exclusion').val(),
					brand: $('#brand').val(),
					warranty: $('#warranty').val(),
					delivery: $('#delivery').val(),
					notes: $('#notes').val(),
					validUntil: $('#valid-until').val(),
					subTotal: $('#sub-total').val(),
					discount: $('#discount').val(),
					adjustment: $('#adjustment').val(),
					grandTotal: $('#grand-total').val(),
					items: []
				};

				// Collect data for each item row and validate
				let hasErrors = false;
				$('#itemRows tr').each(function () {
					const item = {
						product_id: $(this).find('.product_id').val(),
						product_name: $(this).find('.product_name').val(),
						itemName: $(this).find('.itemName').val(),
						itemDescription: $(this).find('.itemDescription').val(),
						uom: $(this).find('.uom').val(),
						quantity: $(this).find('.quantity').val(),
						itemDiscount: $(this).find('.itemDiscount').val(),
						unitPrice: $(this).find('.unitPrice').val(),
						total: $(this).find('.total').val()
					};

					// Validate itemName before adding to formData
					if (!item.itemName) {
						$(this).find('.error-message').text('Item Name is required.');
						hasErrors = true;
						return false; // Stop the .each loop
					}

					formData.items.push(item);
				});

				if (hasErrors) {
					return; // Stop submission if there are validation errors
				}

				// Show SweetAlert loading spinner
				Swal.fire({
					title: 'Creating Proposal...',
					text: 'Please wait while your proposal is being created.',
					allowOutsideClick: false,
					allowEscapeKey: false,
					didOpen: () => {
						Swal.showLoading();
					}
				});

				// AJAX request for proposal creation
				$.ajax({
					url: 'dashboard/add_proposal',
					type: 'POST',
					data: JSON.stringify(formData),
					contentType: 'application/json',
					dataType: 'json',
					success: function (response) {
						if (response.success) {
							Swal.fire({
								icon: 'success',
								title: 'Proposal Created!',
								html: `
									<p>${response.message}</p>
									<a href="<?= site_url('web/deal/download-quote/') ?>${response.id}"
									class="btn btn-success btn-sm" 
									title="Download Quote" target="_blank" 
									rel="noopener noreferrer">
										<i class="bi bi-download"></i> Download Quote
									</a>
								`,
								showConfirmButton: true,
								customClass: {
									confirmButton: 'btn-custom-ok'
								}
							}).then(() => {
								// Reset the form after showing success message
								$('#reProposalForm')[0].reset();

								// Clear all dynamically added rows except the first one
								$('#itemRows tr').not(':first').remove();

								// Reset the row count to 1
								$('#itemRows tr:first td:first').text('1');

								// Reinitialize Select2 on the remaining row if needed
								const firstRow = $('#itemRows tr:first');
								firstRow.find('.itemName').val('').trigger('change'); // Clear selection
								firstRow.find('.itemDescription').val('');
								firstRow.find('.uom').val('');
								firstRow.find('.quantity').val('');
								firstRow.find('.itemDiscount').val('0');
								firstRow.find('.unitPrice').val('');
								firstRow.find('.total').val('');
							});
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: response.error || 'Failed to create proposal.',
								showConfirmButton: true,
								customClass: {
									confirmButton: 'btn-custom-ok'
								}
							});
						}
					},
					error: function (xhr) {
						const errorMessage = xhr.responseJSON?.error || 'An unexpected error occurred. Please try again.';
						Swal.fire({
							icon: 'error',
							title: 'Form Submission Error',
							text: errorMessage,
							showConfirmButton: true,
							customClass: {
								confirmButton: 'btn-custom-ok'
							}
						});
					}
				});
			});

			$('#DealForm').on('submit', function(e) {
				e.preventDefault();

				// Reset any previous error messages
				$('.error-message').empty();

				// Collect form data
				var formData = {
					first_name: $('#first_name').val(),
					last_name: $('#last_name').val(),
					VZ_app_user_id: $('#VZ_app_user_id').val(),
					company_name: $('#company_name').val(),
					customer_email: $('#customer_email').val(),
					mobile_num: $('#mobile_num').val(),
					phone: $('#phone').val(),
					Assign_Department: $('[name="Assign_Department"]').val(),
					pBox: $('#p_box').val(),
					trn: $('#trn').val(),
					complaint_info: $('#description').val(),
					address: $('#address').val()
				};

				// Show SweetAlert loading spinner
				Swal.fire({
					title: 'Creating Deal...',
					text: 'Please wait while your deal is being created.',
					allowOutsideClick: false,
					allowEscapeKey: false,
					didOpen: () => {
						Swal.showLoading();
					}
				});

				// AJAX request to create the deal
				$.ajax({
					url: '<?php echo site_url('deals/create_lead_in_zoho'); ?>',
					type: 'POST',
					dataType: 'json',
					contentType: 'application/json',
					data: JSON.stringify(formData),
					success: function(response) {
						if (response.success) {
							const dealId = response.deal_id;

							// Fetch the DealNumber
							$.ajax({
								url: '<?php echo site_url('web/dashboard/get_deal_number'); ?>',
								type: 'POST',
								dataType: 'json',
								data: JSON.stringify({ deal_id: dealId }),
								contentType: 'application/json',
								success: function(dealResponse) {
									if (dealResponse.success) {
										const dealNumber = dealResponse.DealNumber;
										Swal.fire({
											title: 'Deal Created Successfully!',
											html: `
												<p>Deal Number: <strong id="dealNumber">${dealNumber}</strong></p>
												<button onclick="copyDealNumber()" class="btn btn-primary">Copy Deal Number</button>
											`,
											icon: 'success',
											showConfirmButton: true,
											customClass: {
												confirmButton: 'btn-custom-ok'
											}
										}).then(() => {
											// Reset the form after success
											$('#DealForm')[0].reset();
										});
									} else {
										Swal.fire({
											icon: 'warning',
											title: 'Warning',
											text: 'Deal created, but failed to fetch Deal Number.',
											showConfirmButton: true,
											customClass: {
												confirmButton: 'btn-custom-ok'
											}
										});
									}
								},
								error: function() {
									Swal.fire({
										icon: 'error',
										title: 'Error',
										text: 'Unable to retrieve Deal Number.',
										showConfirmButton: true,
										customClass: {
											confirmButton: 'btn-custom-ok'
										}
									});
								}
							});
						} else if (response.errors) {
							let errorMessages = '';
							$.each(response.errors, function(key, value) {
								errorMessages += `${value}<br>`;
							});
							Swal.fire({
								icon: 'warning',
								title: 'Validation Errors',
								html: errorMessages,
								showConfirmButton: true,
								customClass: {
									confirmButton: 'btn-custom-ok'
								}
							});
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: response.error || 'An error occurred.',
								showConfirmButton: true,
								customClass: {
									confirmButton: 'btn-custom-ok'
								}
							});
						}
					},
					error: function(xhr) {
						const errorMessage = xhr.responseJSON?.error || 'An unexpected error occurred. Please try again.';
						Swal.fire({
							icon: 'error',
							title: 'Form Submission Error',
							text: errorMessage,
							showConfirmButton: true,
							customClass: {
								confirmButton: 'btn-custom-ok'
							}
						});
					}
				});
			});

		});
		
		// Item Form Submission
		document.getElementById('ItemForm').addEventListener('submit', function(e) {
			e.preventDefault();

			const formData = {
				Product_Name: document.getElementById('item_name').value,
				Description: document.getElementById('item_description').value,
				VZ_app_user_id: document.getElementById('VZ_app_user_id').value
			};

			const submitButton = this.querySelector('.submitButton');
			const loader = this.querySelector('.buttonLoader');
			submitButton.disabled = true;
			loader.style.display = 'inline-block';

			// Show loading SweetAlert
			Swal.fire({
				title: 'Creating Item...',
				text: 'Please wait while the item is being created in Zoho CRM.',
				allowOutsideClick: false,
				didOpen: () => {
					Swal.showLoading();
				}
			});

			fetch('<?php echo site_url('web/deals/create_item_in_zoho'); ?>', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(formData)
			})
			.then(response => response.json().then(data => ({ status: response.status, ok: response.ok, body: data })))
			.then(({ status, ok, body }) => {
				submitButton.disabled = false;
				loader.style.display = 'none';

				// Close loading SweetAlert
				Swal.close();

				if (body.success) {
					Swal.fire({
						icon: 'success',
						title: 'Item Created!',
						html: `${body.message}<br>Product ID: ${body.product_id}`,
						confirmButtonColor: '#d10908',
						confirmButtonText: 'OK'
					}).then(() => {
						document.getElementById('ItemForm').reset();
					});
				} else {
					let errorMessage = body.error || 'Failed to create item in Zoho CRM.';
					let isDuplicateError = false;

					// Check if the error mentions 'duplicate'
					if (errorMessage.toLowerCase().includes('duplicate') || (body.details && JSON.stringify(body.details).toLowerCase().includes('duplicate'))) {
						isDuplicateError = true;
					}

					if (body.errors) {
						errorMessage += '<br><ul>' + Object.values(body.errors).map(err => `<li>${err}</li>`).join('') + '</ul>';
					} else if (body.details) {
						errorMessage += `<br>Details: ${JSON.stringify(body.details)}`;
					}

					if (isDuplicateError) {
						Swal.fire({
							icon: 'warning',
							title: 'Duplicate Item Detected',
							html: `
								It looks like a similar item already exists or is in the Recycle Bin.<br><br>
								<b>Tip:</b> Please check your CRM's Recycle Bin and delete the old record if needed, then try again.`,
							confirmButtonColor: '#d10908',
							confirmButtonText: 'OK'
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Creation Failed',
							html: errorMessage,
							confirmButtonColor: '#d10908',
							confirmButtonText: 'OK'
						});
					}
				}
			})
			.catch(error => {
				submitButton.disabled = false;
				loader.style.display = 'none';

				// Close loading SweetAlert
				Swal.close();

				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'An unexpected error occurred while creating the item. Please try again later.',
					confirmButtonColor: '#d10908',
					confirmButtonText: 'OK'
				});
				console.error('Error:', error);
			});

		});

		// Copy Deal Number function
		function copyDealNumber() {
			const dealNumber = document.getElementById('dealNumber').textContent;
			navigator.clipboard.writeText(dealNumber).then(() => {
				Swal.fire('Copied!', 'Deal Number copied to clipboard.', 'success');
			}).catch((error) => {
				Swal.fire('Error', 'Failed to copy Deal Number.', 'error');
			});
		}
	</script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Bootstrap JS and dependencies -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>



