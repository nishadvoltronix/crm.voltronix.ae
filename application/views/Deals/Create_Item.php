<style>
.quote-modal {
    position: fixed;
    inset: 0;
    z-index: 99999;
}

.quote-modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
}

.quote-modal-box {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90%;
    max-width: 420px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    padding: 28px 24px;
    text-align: center;
    font-family: Arial, sans-serif;
}

.quote-spinner {
    width: 58px;
    height: 58px;
    margin: 0 auto 18px;
    border: 5px solid #e9ecef;
    border-top: 5px solid #0d6efd;
    border-radius: 50%;
    animation: quoteSpin 0.8s linear infinite;
}

@keyframes quoteSpin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.quote-modal-title {
    margin: 0 0 10px;
    font-size: 22px;
    font-weight: 700;
    color: #222;
}

.quote-modal-text {
    margin: 0;
    font-size: 14px;
    line-height: 1.6;
    color: #666;
}

.quote-result-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 16px;
    border-radius: 50%;
    line-height: 64px;
    font-size: 30px;
    font-weight: bold;
    color: #fff;
    background: #198754;
}

.quote-result-icon.error {
    background: #dc3545;
}

.quote-result-details {
    margin-top: 18px;
    padding: 14px 16px;
    background: #f8f9fa;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    text-align: left;
    font-size: 14px;
    color: #333;
}

.quote-result-details div + div {
    margin-top: 8px;
}

.quote-modal-btn {
    margin-top: 20px;
    background: #0d6efd;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 22px;
    font-size: 14px;
    cursor: pointer;
}

.quote-modal-btn:hover {
    background: #0b5ed7;
}
</style>
<!-- ================= CREATE ITEM ================= -->
<div class="card">
  <div class="card-body">
    <form id="ItemForm">
      <div class="card shadow-sm">
        <div class="card-header bg-light text-white">
          <h6 class="mb-0">
            <i class="fas fa-box me-2"></i> Add New Item
          </h6>
        </div>

        <div class="card-body">
          <div class="row g-3">

            <div class="col-md-12">
              <label class="form-label">Item Name <span style="color:red;">*</span></label>
              <input 
                type="text" 
                class="form-control" 
                name="item_name" 
                placeholder="Enter item name"
                required>
            </div>

            <div class="col-md-12">
              <label class="form-label">Description (Optional)</label>
              <textarea class="form-control" name="item_description" rows="3"></textarea>
            </div>

          </div>
        </div>

        <div class="card-footer text-end">
          <button type="submit" class="btn btn-dangers px-4 submitButton">
            <i class="fas fa-save me-1"></i> Save Item
            <span class="loader buttonLoader ms-2 d-none"></span>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Item Status Modal -->
<div id="itemStatusModal" class="quote-modal" style="display:none;">
    <div class="quote-modal-backdrop"></div>

    <div class="quote-modal-box">
        <div id="itemLoadingState">
            <div class="quote-spinner"></div>
            <h4 class="quote-modal-title">Creating Item</h4>
            <p class="quote-modal-text">Please wait, item is being created in Zoho...</p>
        </div>

        <div id="itemResultState" style="display:none;">
            <div id="itemResultIcon" class="quote-result-icon">✓</div>
            <h4 id="itemResultTitle" class="quote-modal-title">Item Created Successfully</h4>
            <p id="itemResultText" class="quote-modal-text"></p>

            <div id="itemResultDetails" class="quote-result-details" style="display:none;">
                <div><strong>Item Name:</strong> <span id="itemNameText"></span></div>
            </div>

            <button type="button" id="itemCreateAnotherBtn" class="quote-modal-btn" style="margin-right:8px;">
                Create Another
            </button>
            <button type="button" id="itemModalOkBtn" class="quote-modal-btn">
                OK
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const itemForm = document.getElementById('ItemForm');

    if (itemForm) {
        itemForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const submitBtn = itemForm.querySelector('.submitButton');
            const loader = itemForm.querySelector('.buttonLoader');
            const originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';

            const formData = {
                item_name: itemForm.querySelector('[name="item_name"]').value.trim(),
                item_description: itemForm.querySelector('[name="item_description"]').value.trim()
            };

            if (!formData.item_name) {
                alert('Item Name is required.');
                return;
            }

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-save me-1"></i> Saving...';
            }

            if (loader) {
                loader.classList.remove('d-none');
            }

            openItemLoadingModal();

            fetch('<?= base_url("index.php/Admincrm/create_item_zoho") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(formData)
            })
            .then(async function (response) {
                const text = await response.text();
                console.log('create_item_zoho raw:', text);

                if (!response.ok) {
                    throw new Error('HTTP ' + response.status + ': ' + text);
                }

                return JSON.parse(text);
            })
            .then(function (response) {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHtml;
                }

                if (loader) {
                    loader.classList.add('d-none');
                }

                if (response.success) {
                    showItemSuccessModal(
                        response.message || 'Item created successfully.',
                        response.item_name || '',
                    );
                    itemForm.reset();
                } else {
                    showItemErrorModal(response.error || 'Failed to create item.');
                }
            })
            .catch(function (error) {
                console.error(error);

                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHtml;
                }

                if (loader) {
                    loader.classList.add('d-none');
                }

                showItemErrorModal(error.message || 'Something went wrong.');
            });
        });
    }

    const okBtn = document.getElementById('itemModalOkBtn');
    if (okBtn) {
        okBtn.addEventListener('click', function () {
            closeItemModal();
        });
    }

    const createAnotherBtn = document.getElementById('itemCreateAnotherBtn');
    if (createAnotherBtn) {
        createAnotherBtn.addEventListener('click', function () {
            closeItemModal();
            const itemNameInput = document.querySelector('#ItemForm [name="item_name"]');
            if (itemNameInput) {
                itemNameInput.focus();
            }
        });
    }
});

function openItemLoadingModal() {
    document.getElementById('itemStatusModal').style.display = 'block';
    document.getElementById('itemLoadingState').style.display = 'block';
    document.getElementById('itemResultState').style.display = 'none';
}

function showItemSuccessModal(message, itemName, productId) {
    document.getElementById('itemLoadingState').style.display = 'none';
    document.getElementById('itemResultState').style.display = 'block';

    const icon = document.getElementById('itemResultIcon');
    icon.className = 'quote-result-icon';
    icon.innerHTML = '✓';

    document.getElementById('itemResultTitle').innerText = 'Item Created Successfully';
    document.getElementById('itemResultText').innerText = message || 'Item created successfully. Now you can make quotation.';

    if (itemName || productId) {
        document.getElementById('itemResultDetails').style.display = 'block';
        document.getElementById('itemNameText').innerText = itemName || '-';
     //   document.getElementById('itemZohoIdText').innerText = productId || '-';
    } else {
        document.getElementById('itemResultDetails').style.display = 'none';
    }
}

function showItemErrorModal(message) {
    document.getElementById('itemLoadingState').style.display = 'none';
    document.getElementById('itemResultState').style.display = 'block';

    const icon = document.getElementById('itemResultIcon');
    icon.className = 'quote-result-icon error';
    icon.innerHTML = '!';

    document.getElementById('itemResultTitle').innerText = 'Item Creation Failed';
    document.getElementById('itemResultText').innerText = message || 'Failed to create item.';
    document.getElementById('itemResultDetails').style.display = 'none';
}

function closeItemModal() {
    document.getElementById('itemStatusModal').style.display = 'none';
}
</script>