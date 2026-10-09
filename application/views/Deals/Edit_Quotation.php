<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quotation</title>

    <style>
        body {
            background: #f8f9fa;
        }

        .page-card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.06);
        }

        .table thead th {
            white-space: nowrap;
            vertical-align: middle;
            font-size: 14px;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .section-title {
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .summary-box {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 18px;
        }

        .btn-purple {
            background-color: #6f42c1;
            border-color: #6f42c1;
            color: #fff;
        }

        .btn-purple:hover {
            background-color: #5e35b1;
            border-color: #5e35b1;
            color: #fff;
        }

        .item-total,
        #grand-total {
            min-width: 120px;
        }

        #quotationTable {
            table-layout: fixed;
            width: 100%;
        }

        #quotationTable th,
        #quotationTable td {
            overflow: hidden;
            vertical-align: middle;
        }

        #quotationTable td:nth-child(2),
        #quotationTable th:nth-child(2) {
            width: 20% !important;
        }

        #quotationTable td:nth-child(3),
        #quotationTable th:nth-child(3) {
            width: 20% !important;
        }

        .select2-container {
            width: 100% !important;
            max-width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 31px !important;
            min-height: 31px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 29px !important;
            padding-left: 8px !important;
            padding-right: 24px !important;
            font-size: 13px !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .select2-container .select2-selection--single .select2-selection__arrow {
            height: 29px !important;
        }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="card page-card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <div>
                <h4 class="mb-0">Edit Quotation</h4>
                <small class="text-muted">
                    Company: <?php echo !empty($task['account_name']) ? $task['account_name'] : '-'; ?>
                    |
                    Quotation Date: <?php echo !empty($task['quote_date']) ? date('Y-m-d', strtotime($task['quote_date'])) : date('Y-m-d'); ?>
                    |
                    Quote Number: <?php echo !empty($task['quote_number']) ? $task['quote_number'] : '-'; ?>
                </small>
            </div>

            <div class="d-flex gap-2">
                <a href="<?php echo base_url('index.php/Admincrm/lead_detail/' . $task['id']); ?>" class="btn btn-secondary btn-sm">
                    <i class="ph ph-arrow-left me-1"></i>Back
                </a>

                <?php if (!empty($task['quote_number'])): ?>
                <a href="<?php echo base_url('index.php/Admincrm/download_deal_pdf/' . $task['id']); ?>" class="btn btn-danger btn-sm">
                    <i class="ph ph-download me-1"></i>Download PDF
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-body">
            <form action="<?php echo base_url('index.php/Admincrm/update_quotation'); ?>" method="post" id="quotationForm">

                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                <input type="hidden" name="quote_number" value="<?php echo !empty($task['quote_number']) ? $task['quote_number'] : ''; ?>">

                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Deal Number</label>
                        <input type="text" class="form-control" name="deal_number"
                               value="<?php echo !empty($task['deal_number']) ? htmlspecialchars($task['deal_number']) : ''; ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Quote Number</label>
                        <input type="text" class="form-control"
                               value="<?php echo !empty($task['quote_number']) ? htmlspecialchars($task['quote_number']) : ''; ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Quotation Date</label>
                        <input type="date" class="form-control" name="quotation_date"
                               value="<?php echo !empty($task['quote_date']) ? date('Y-m-d', strtotime($task['quote_date'])) : date('Y-m-d'); ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Valid Until</label>
                        <input type="date" class="form-control" name="valid_until"
                               value="<?php echo !empty($task['valid_until']) ? date('Y-m-d', strtotime($task['valid_until'])) : ''; ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Kind Attention</label>
                        <input type="text" class="form-control" name="kind_attention"
                               value="<?php echo !empty($task['kind_attention']) ? htmlspecialchars($task['kind_attention']) : ''; ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control" name="subject"
                               value="<?php echo !empty($task['subject']) ? htmlspecialchars($task['subject']) : ''; ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand"
                               value="<?php echo !empty($task['brand']) ? htmlspecialchars($task['brand']) : ''; ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Delivery Timeline</label>
                        <input type="text" class="form-control" id="delivery" name="delivery"
                               value="<?php echo !empty($task['delivery']) ? htmlspecialchars($task['delivery']) : ''; ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Project</label>
                        <input type="text" class="form-control" name="project_name"
                               value="<?php echo !empty($task['project_name']) ? htmlspecialchars($task['project_name']) : ''; ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Payment Terms</label>
                        <input type="text" class="form-control" name="termsOfPayment"
                               value="<?php echo !empty($task['terms_of_payment']) ? htmlspecialchars($task['terms_of_payment']) : ''; ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">General Exclusion</label>
                        <textarea class="form-control" name="generalExclusion" rows="3"><?php echo !empty($task['general_exclusion']) ? htmlspecialchars($task['general_exclusion']) : ''; ?></textarea>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Specifications</label>
                        <textarea class="form-control" id="specification" name="specification" rows="3"><?php echo !empty($task['specification']) ? htmlspecialchars($task['specification']) : ''; ?></textarea>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Warranty</label>
                        <textarea class="form-control" id="warranty" name="warranty" rows="3"><?php echo !empty($task['warranty']) ? htmlspecialchars($task['warranty']) : ''; ?></textarea>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"><?php echo !empty($task['notes']) ? htmlspecialchars($task['notes']) : ''; ?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="section-title mb-0">Quotation Items</div>
                    <button type="button" class="btn btn-purple btn-sm" id="addRowBtn">
                        <i class="ph ph-plus me-1"></i>Add Item
                    </button>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle" id="quotationTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 4%;">#</th>
                                <th style="width: 20%;">Product Name</th>
                                <th style="width: 26%;">Description</th>
                                <th style="width: 8%;">UOM</th>
                                <th style="width: 8%;">Qty</th>
                                <th style="width: 8%;">Unit Price</th>
                                <th style="width: 8%;">Discount %</th>
                                <th style="width: 8%;">Total</th>
                                <th style="width: 4%;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="quotationItemsBody">
                            <?php if (!empty($proposal_items)) : ?>
                                <?php foreach ($proposal_items as $index => $item) : ?>
                                    <tr>
                                        <td class="row-number"><?php echo $index + 1; ?></td>

                                        <td class="align-top">
                                            <input type="hidden" name="item_id[]" value="<?php echo $item['id']; ?>">
                                            <input type="hidden" class="product_id" name="product_id[]" value="<?php echo !empty($item['product_id']) ? htmlspecialchars($item['product_id']) : ''; ?>">
                                            <input type="hidden" class="product_name" name="product_name[]" value="<?php echo !empty($item['product_name']) ? htmlspecialchars($item['product_name']) : ''; ?>">

                                           <select class="form-control form-control-sm itemName mb-1"
        name="itemName[]"
        required>
        
    <?php if (!empty($item['product_id'])) : ?>
        <option
            value="<?php echo htmlspecialchars($item['product_id']); ?>"
            selected
        >
            <?php echo htmlspecialchars($item['product_name']); ?>
        </option>
    <?php else : ?>
        <option value=""></option>
    <?php endif; ?>

</select>

                                            <div class="error-message text-danger small mt-1"></div>
                                        </td>

                                        <td>
                                            <textarea name="product_description[]" class="form-control itemDescription" rows="2"><?php echo htmlspecialchars($item['product_description']); ?></textarea>
                                        </td>

                                        <td>
                                            <select class="form-control uom" name="uom[]" required>
                                                <option value="">-None-</option>
                                                <option value="NOS" <?php echo ($item['uom'] == 'NOS') ? 'selected' : ''; ?>>NOS</option>
                                                <option value="PCS" <?php echo ($item['uom'] == 'PCS') ? 'selected' : ''; ?>>PCS</option>
                                                <option value="LS" <?php echo ($item['uom'] == 'LS') ? 'selected' : ''; ?>>LS</option>
                                                <option value="EA" <?php echo ($item['uom'] == 'EA') ? 'selected' : ''; ?>>EA</option>
                                                <option value="SET" <?php echo ($item['uom'] == 'SET') ? 'selected' : ''; ?>>SET</option>
                                                <option value="SQM" <?php echo ($item['uom'] == 'SQM') ? 'selected' : ''; ?>>SQM</option>
                                            </select>
                                        </td>

                                        <td>
                                            <input type="number" step="0.01" min="1" name="quantity[]" class="form-control quantity"
                                                   value="<?php echo (float)$item['quantity']; ?>" required>
                                        </td>

                                        <td>
                                            <input type="number" step="0.01" min="0" name="service_charge[]" class="form-control unitPrice"
                                                   value="<?php echo (float)$item['service_charge']; ?>" required>
                                        </td>

                                        <td>
                                            <input type="number" step="0.01" min="0" name="item_discount[]" class="form-control itemDiscount"
                                                   value="<?php echo !empty($item['item_discount']) ? (float)$item['item_discount'] : 0; ?>">
                                        </td>

                                        <td>
                                            <input type="number" step="0.01" min="0" name="total[]" class="form-control total item-total"
                                                   value="<?php echo (float)$item['total']; ?>" readonly>
                                        </td>

                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger remove-row">
                                                <i class="ph ph-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td class="row-number">1</td>

                                    <td class="align-top">
                                        <input type="hidden" name="item_id[]" value="">
                                        <input type="hidden" class="product_id" name="product_id[]" value="">
                                        <input type="hidden" class="product_name" name="product_name[]" value="">

                                        <select class="form-control form-control-sm itemName mb-1"
                                                name="itemName[]"
                                                required>
                                            <option value=""></option>
                                        </select>

                                        <div class="error-message text-danger small mt-1"></div>
                                    </td>

                                    <td>
                                        <textarea name="product_description[]" class="form-control itemDescription" rows="2"></textarea>
                                    </td>

                                    <td>
                                        <select class="form-control uom" name="uom[]" required>
                                            <option value="">-None-</option>
                                            <option value="NOS" selected>NOS</option>
                                            <option value="PCS">PCS</option>
                                            <option value="LS">LS</option>
                                            <option value="EA">EA</option>
                                            <option value="SET">SET</option>
                                            <option value="SQM">SQM</option>
                                        </select>
                                    </td>

                                    <td>
                                        <input type="number" step="0.01" min="1" name="quantity[]" class="form-control quantity" value="1" required>
                                    </td>

                                    <td>
                                        <input type="number" step="0.01" min="0" name="service_charge[]" class="form-control unitPrice" value="0" required>
                                    </td>

                                    <td>
                                        <input type="number" step="0.01" min="0" name="item_discount[]" class="form-control itemDiscount" value="0">
                                    </td>

                                    <td>
                                        <input type="number" step="0.01" min="0" name="total[]" class="form-control total item-total" value="0" readonly>
                                    </td>

                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger remove-row">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <h6 class="text-danger mb-3">Calculation Summary</h6>
                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <div class="summary-box">
                            <div class="mb-2">
                                <label class="form-label">Sub Total</label>
                                <input type="number" step="0.01" class="form-control" id="sub-total" name="subTotal"
                                       value="<?php echo !empty($task['sub_total']) ? (float)$task['sub_total'] : 0; ?>" readonly>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Discount</label>
                                <input type="number" step="0.01" class="form-control" id="discount" name="discount"
                                       value="<?php echo !empty($task['discount']) ? (float)$task['discount'] : 0; ?>">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">VAT (%)</label>
                                <input type="number" step="0.01" class="form-control" id="vat" name="vat"
                                       value="<?php echo !empty($task['vat']) ? (float)$task['vat'] : 5; ?>" readonly>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Adjustment</label>
                                <input type="number" step="0.01" class="form-control" id="adjustment" name="adjustment"
                                       value="<?php echo !empty($task['adjustment']) ? (float)$task['adjustment'] : 0; ?>">
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-bold">Grand Total</label>
                                <input type="number" step="0.01" class="form-control fw-bold text-success" id="grand-total" name="grandTotal"
                                       value="<?php echo !empty($task['grand_total']) ? (float)$task['grand_total'] : 0; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="ph ph-floppy-disk me-1"></i>Update Quotation
                    </button>

                    <a href="<?php echo base_url('index.php/Admincrm/lead_detail/' . $task['id']); ?>" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('quotationForm');
    const tbody = document.getElementById('quotationItemsBody');
    const addRowBtn = document.getElementById('addRowBtn');

    const subTotalInput = document.getElementById('sub-total');
    const discountInput = document.getElementById('discount');
    const vatInput = document.getElementById('vat');
    const adjustmentInput = document.getElementById('adjustment');
    const grandTotalInput = document.getElementById('grand-total');

    let allProducts = [];

    function escapeHtml(str) {
        return String(str || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function updateRowNumbers() {
        const rows = tbody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            const numberCell = row.querySelector('.row-number');
            if (numberCell) {
                numberCell.textContent = index + 1;
            }
        });
    }

    function calculateTotals() {
        let subTotal = 0;

        tbody.querySelectorAll('tr').forEach(function (row) {
            const qty = parseFloat(row.querySelector('.quantity')?.value) || 0;
            const price = parseFloat(row.querySelector('.unitPrice')?.value) || 0;
            const itemDiscount = parseFloat(row.querySelector('.itemDiscount')?.value) || 0;

            const base = qty * price;
            const lineTotal = base - ((base * itemDiscount) / 100);

            const totalInput = row.querySelector('.total');
            if (totalInput) {
                totalInput.value = lineTotal.toFixed(2);
            }

            subTotal += lineTotal;
        });

        if (subTotalInput) subTotalInput.value = subTotal.toFixed(2);

        const headerDiscount = parseFloat(discountInput?.value) || 0;
        const vatPercent = parseFloat(vatInput?.value) || 5;
        const adjustment = parseFloat(adjustmentInput?.value) || 0;

        const afterDiscount = Math.max(0, subTotal - headerDiscount);
        const vatAmount = (afterDiscount * vatPercent) / 100;
        const grandTotal = afterDiscount + vatAmount + adjustment;

        if (grandTotalInput) grandTotalInput.value = grandTotal.toFixed(2);
    }

    /* function buildProductOptions(selectedId = '') {
        let html = '<option value="">Select Item</option>';

        allProducts.forEach(function (product) {
            const isSelected = String(product.id) === String(selectedId) ? 'selected' : '';

            html += `
                <option
                    value="${escapeHtml(product.id)}"
                    data-name="${escapeHtml(product.name)}"
                    data-description="${escapeHtml(product.description)}"
                    data-unit-price="${escapeHtml(product.unit_price)}"
                    ${isSelected}
                >
                    ${escapeHtml(product.name)}
                </option>
            `;
        });

        return html;
    } */

    /* function bindProductChange(selectElement) {
        const $select = $(selectElement);

        $select.off('change.productsync').on('change.productsync', function () {
            const row = this.closest('tr');
            const option = this.options[this.selectedIndex];

            const productId = this.value || '';
            const productName = option ? (option.dataset.name || '') : '';
            const description = option ? (option.dataset.description || '') : '';
            const unitPrice = option ? (option.dataset.unitPrice || '0') : '0';

            if (row.querySelector('.product_id')) {
                row.querySelector('.product_id').value = productId;
            }

            if (row.querySelector('.product_name')) {
                row.querySelector('.product_name').value = productName;
            }

            if (row.querySelector('.itemDescription')) {
                row.querySelector('.itemDescription').value = description;
            }

            const priceInput = row.querySelector('.unitPrice');
            if (priceInput && (!priceInput.value || parseFloat(priceInput.value) === 0)) {
                priceInput.value = unitPrice;
            }

            calculateTotals();
        });
    } */

    /* function initSelect2(selectElement) {
        if (!selectElement) return;

        const $select = $(selectElement);

        if ($select.hasClass('select2-hidden-accessible')) {
            $select.select2('destroy');
        }

        $select.select2({
            placeholder: 'Search product...',
            allowClear: true,
            width: '100%',
            dropdownAutoWidth: false
        });

        bindProductChange(selectElement);
    } */

        function initSelect2(selectElement) {
    if (!selectElement) return;

    const $select = $(selectElement);

    if ($select.hasClass('select2-hidden-accessible')) {
        $select.select2('destroy');
    }

    $select.select2({
        placeholder: 'Search product...',
        allowClear: true,
        width: '100%',
        minimumInputLength: 2,

        ajax: {
            url: '<?= base_url("index.php/Admincrm/get_products") ?>',
            dataType: 'json',
            delay: 200,

            data: function (params) {
                return {
                    q: params.term || ''
                };
            },

            processResults: function (data) {

                console.log('Product search:', data);

                if (!data.success || !Array.isArray(data.products)) {
                    return {
                        results: []
                    };
                }

                return {
                    results: data.products.map(function (product) {
                        return {
                            id: product.id,
                            text: product.name,
                            name: product.name,
                            description: product.description || '',
                            unit_price: product.unit_price || 0
                        };
                    })
                };
            },

            cache: true
        }
    });

    $select
        .off('select2:select.productsync')
        .on('select2:select.productsync', function (e) {

            const row = this.closest('tr');
            const product = e.params.data;

            row.querySelector('.product_id').value =
                product.id || '';

            row.querySelector('.product_name').value =
                product.name || product.text || '';

            row.querySelector('.itemDescription').value =
                product.description || '';

            row.querySelector('.unitPrice').value =
                product.unit_price || 0;

            calculateTotals();
        });

    $select
        .off('select2:clear.productsync')
        .on('select2:clear.productsync', function () {

            const row = this.closest('tr');

            row.querySelector('.product_id').value = '';
            row.querySelector('.product_name').value = '';
            row.querySelector('.itemDescription').value = '';
            row.querySelector('.unitPrice').value = 0;

            calculateTotals();
        });
}

    /* function populateRowDropdown(row) {
        const select = row.querySelector('.itemName');
        if (!select) return;

        const selectedId = select.getAttribute('data-selected-id') || row.querySelector('.product_id')?.value || '';
        select.innerHTML = buildProductOptions(selectedId);

        if (selectedId) {
            select.value = selectedId;
        }

        initSelect2(select);
    } */

    function addNewRow() {
        const rowCount = tbody.querySelectorAll('tr').length + 1;

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="row-number">${rowCount}</td>

            <td class="align-top">
                <input type="hidden" name="item_id[]" value="">
                <input type="hidden" class="product_id" name="product_id[]" value="">
                <input type="hidden" class="product_name" name="product_name[]" value="">

               <select
    class="form-control form-control-sm itemName mb-1"
    name="itemName[]"
    required
>
    <option value=""></option>
</select>

                <div class="error-message text-danger small mt-1"></div>
            </td>

            <td>
                <textarea name="product_description[]" class="form-control itemDescription" rows="2"></textarea>
            </td>

            <td>
                <select class="form-control uom" name="uom[]" required>
                    <option value="">-None-</option>
                    <option value="NOS" selected>NOS</option>
                    <option value="PCS">PCS</option>
                    <option value="LS">LS</option>
                    <option value="EA">EA</option>
                    <option value="SET">SET</option>
                    <option value="SQM">SQM</option>
                </select>
            </td>

            <td>
                <input type="number" step="0.01" min="1" name="quantity[]" class="form-control quantity" value="1" required>
            </td>

            <td>
                <input type="number" step="0.01" min="0" name="service_charge[]" class="form-control unitPrice" value="0" required>
            </td>

            <td>
                <input type="number" step="0.01" min="0" name="item_discount[]" class="form-control itemDiscount" value="0">
            </td>

            <td>
                <input type="number" step="0.01" min="0" name="total[]" class="form-control total item-total" value="0" readonly>
            </td>

            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger remove-row">
                    <i class="ph ph-trash"></i>
                </button>
            </td>
        `;

        tbody.appendChild(tr);

initSelect2(tr.querySelector('.itemName'));

updateRowNumbers();
calculateTotals();
    }

    /* async function loadProducts() {
        const url = '<?= base_url("index.php/Admincrm/get_products") ?>?q=';

        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const text = await response.text();
        console.log('get_products raw:', text);

        if (!response.ok) {
            throw new Error('HTTP ' + response.status + ': ' + text);
        }

        const data = JSON.parse(text);
        console.log('get_products parsed:', data);

        if (!data.success || !Array.isArray(data.products)) {
            throw new Error(data.error || 'Invalid products response');
        }

        allProducts = data.products;
    } */

    tbody.addEventListener('input', function (e) {
        if (
            e.target.classList.contains('quantity') ||
            e.target.classList.contains('unitPrice') ||
            e.target.classList.contains('itemDiscount')
        ) {
            calculateTotals();
        }
    });

    tbody.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-row');
        if (btn) {
            const rows = tbody.querySelectorAll('tr');

            if (rows.length > 1) {
                const row = btn.closest('tr');
                const select = row.querySelector('.itemName');

                if (select && $(select).hasClass('select2-hidden-accessible')) {
                    $(select).select2('destroy');
                }

                row.remove();
                updateRowNumbers();
                calculateTotals();
            }
        }
    });

    if (discountInput) {
        discountInput.addEventListener('input', calculateTotals);
    }

    if (adjustmentInput) {
        adjustmentInput.addEventListener('input', calculateTotals);
    }

    if (addRowBtn) {
        addRowBtn.addEventListener('click', function () {
            addNewRow();
        });
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            tbody.querySelectorAll('.error-message').forEach(function (el) {
                el.textContent = '';
            });

            const formData = {
                task_id: document.querySelector('input[name="task_id"]').value,
                quote_number: document.querySelector('input[name="quote_number"]').value,
                dealNumber: document.querySelector('input[name="deal_number"]').value,
                subject: document.querySelector('input[name="subject"]').value,
                kind_attention: document.querySelector('input[name="kind_attention"]')?.value || '',
                project: document.querySelector('input[name="project_name"]')?.value || '',
                termsOfPayment: document.querySelector('input[name="termsOfPayment"]')?.value || '',
                specification: document.querySelector('textarea[name="specification"]')?.value || '',
                generalExclusion: document.querySelector('textarea[name="generalExclusion"]')?.value || '',
                brand: document.querySelector('input[name="brand"]')?.value || '',
                warranty: document.querySelector('textarea[name="warranty"]')?.value || '',
                delivery: document.querySelector('input[name="delivery"]')?.value || '',
                notes: document.querySelector('textarea[name="notes"]')?.value || '',
                validUntil: document.querySelector('input[name="valid_until"]')?.value || '',
                quotation_date: document.querySelector('input[name="quotation_date"]')?.value || '',
                subTotal: document.getElementById('sub-total')?.value || 0,
                discount: document.getElementById('discount')?.value || 0,
                vat: document.getElementById('vat')?.value || 5,
                adjustment: document.getElementById('adjustment')?.value || 0,
                grandTotal: document.getElementById('grand-total')?.value || 0,
                items: []
            };

            let hasErrors = false;

            tbody.querySelectorAll('tr').forEach(function (row) {
                if (hasErrors) return;

                const item = {
    item_id: row.querySelector('input[name="item_id[]"]')?.value || '',

    product_id:
        row.querySelector('.product_id')?.value || '',

    product_name:
        row.querySelector('.product_name')?.value || '',

    itemName:
        row.querySelector('.product_name')?.value || '',

    itemDescription:
        row.querySelector('.itemDescription')?.value || '',

    uom:
        row.querySelector('.uom')?.value || '',

    quantity:
        row.querySelector('.quantity')?.value || 0,

    itemDiscount:
        row.querySelector('.itemDiscount')?.value || 0,

    unitPrice:
        row.querySelector('.unitPrice')?.value || 0,

    total:
        row.querySelector('.total')?.value || 0
};

                const errorBox = row.querySelector('.error-message');

                if (!item.product_id) {
                    if (errorBox) errorBox.textContent = 'Please select an item.';
                    hasErrors = true;
                    return;
                }

                if (!item.quantity || parseFloat(item.quantity) <= 0) {
                    if (errorBox) errorBox.textContent = 'Quantity must be greater than 0.';
                    hasErrors = true;
                    return;
                }

                formData.items.push(item);
            });

            if (hasErrors) return;

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn ? submitBtn.innerHTML : '';

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Updating...';
            }

            fetch('<?= base_url("index.php/Admincrm/update_quotation") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(formData)
            })
            .then(async function (response) {
                const text = await response.text();
                console.log('update_quotation raw:', text);

                if (!response.ok) {
                    throw new Error('HTTP ' + response.status + ': ' + text);
                }

                return JSON.parse(text);
            })
            .then(function (response) {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }

                if (response.success) {
                    alert(response.message || 'Quotation updated successfully.');
                    window.location.href = '<?= base_url("index.php/Admincrm/lead_detail/") ?>' + response.task_id;
                } else {
                    alert(response.error || 'Failed to update quotation.');
                }
            })
            .catch(function (error) {
                console.error(error);

                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }

                alert(error.message || 'Something went wrong.');
            });
        });
    }

    /* Initialize existing quotation product dropdowns */
tbody.querySelectorAll('.itemName').forEach(function (select) {
    initSelect2(select);
});

/* Recalculate existing quotation totals */
calculateTotals();

/*    loadProducts()
        .then(function () {
            tbody.querySelectorAll('tr').forEach(function (row) {
                populateRowDropdown(row);
            });
            calculateTotals();
        })
        .catch(function (error) {
            console.error('Product load failed:', error);
        }); */
});
</script>

</body>
</html>