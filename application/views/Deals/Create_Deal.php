<!-- ================= CREATE DEAL ================= -->

<style>
.deal-modal {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: none;
}

.deal-modal.show {
    display: block !important;
}

.deal-modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
}

.deal-modal-box {
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

.deal-spinner {
    width: 58px;
    height: 58px;
    margin: 0 auto 18px;
    border: 5px solid #e9ecef;
    border-top: 5px solid #0d6efd;
    border-radius: 50%;
    animation: dealSpin 0.8s linear infinite;
}

@keyframes dealSpin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.deal-modal-title {
    margin: 0 0 10px;
    font-size: 22px;
    font-weight: 700;
    color: #222;
}

.deal-modal-text {
    margin: 0;
    font-size: 14px;
    line-height: 1.6;
    color: #666;
}

.deal-result-icon {
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

.deal-result-icon.error {
    background: #dc3545;
}

.deal-result-details {
    margin-top: 18px;
    padding: 14px 16px;
    background: #f8f9fa;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    text-align: left;
    font-size: 14px;
    color: #333;
}

.deal-result-details div + div {
    margin-top: 8px;
}

.deal-modal-btn {
    margin-top: 20px;
    background: #0d6efd;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 22px;
    font-size: 14px;
    cursor: pointer;
}

.deal-modal-btn:hover {
    background: #0b5ed7;
}

.form-submitting {
    pointer-events: none;
    opacity: 0.85;
}
</style>

<div class="card">
  <div class="card-body">

    <form id="DealForm" method="post" action="<?= base_url('index.php/Admincrm/create_deal_detail') ?>">

        <div class="card shadow-sm">
          <div class="card-body">
            <h6 class="text mb-3 text-dangers">Customer Information</h6>
            <div class="row g-3">
              <div class="col-md-3">
                <label class="form-label">First Name <span class="text-dangers">*</span></label>
                <input type="text" class="form-control" name="first_name" placeholder="Enter first name" required>
              </div>

              <div class="col-md-3">
                <label class="form-label">Last Name <span class="text-dangers">*</span></label>
                <input type="text" class="form-control" name="last_name" placeholder="Enter last name" required>
              </div>

              <div class="col-md-3">
                <label class="form-label">Company <span class="text-dangers">*</span></label>
                <input type="text" class="form-control" name="company_name" placeholder="Company name" required>
              </div>

              <div class="col-md-3">
                <label class="form-label">Email <span class="text-dangers">*</span></label>
                <input type="email" class="form-control" name="customer_email" placeholder="example@email.com" required>
              </div>
            </div>

            <hr class="my-4">

            <h6 class="text mb-10 text-dangers">Contact Details</h6>
            <div class="row g-3">
              <div class="col-md-2">
                <label class="form-label">Mobile <span class="text-dangers">*</span></label>
                <input type="number" class="form-control" name="mobile_num" placeholder="Mobile no." required>
              </div>

              <div class="col-md-2">
                <label class="form-label">Phone <span class="text-dangers">*</span></label>
                <input type="number" class="form-control" name="phone" placeholder="Phone no." required>
              </div>

              <div class="col-md-3">
                <label class="form-label">Department <span class="text-dangers">*</span></label>
                <select class="form-select" name="assign_department" required>
                  <option selected disabled>Select department</option>
                  <option>VOLTRONIX CONTRACTING LLC</option>
                  <option>VOLTRONIX SWITCHGEAR LLC</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label">P. Box</label>
                <input type="text" class="form-control" name="p_box" placeholder="P.O Box">
              </div>

              <div class="col-md-2">
                <label class="form-label">TRN</label>
                <input type="number" class="form-control" name="trn" placeholder="TRN number">
              </div>
            </div>

            <hr class="my-4">

            <h6 class="text mb-3 text-dangers">Additional Information</h6>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Address <span class="text-dangers">*</span></label>
                <textarea class="form-control" rows="3" name="address" placeholder="Enter full address"></textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label">Deal Description <span class="text-dangers">*</span></label>
                <textarea class="form-control" rows="3" name="description" placeholder="Deal notes or description"></textarea>
              </div>
            </div>
          </div>

          <div class="card-footer text-end">
            <button type="submit" class="btn btn-dangers px-4" id="saveDealBtn">
              <i class="fas fa-save me-1"></i> Save Deal
            </button>
          </div>
        </div>
    </form>

  </div>
</div>

<!-- Deal Status Modal -->
<div id="dealStatusModal" class="deal-modal">
    <div class="deal-modal-backdrop"></div>

    <div class="deal-modal-box">
        <div id="dealLoadingState">
            <div class="deal-spinner"></div>
            <h4 class="deal-modal-title">Creating Deal</h4>
            <p class="deal-modal-text">
                Deal is being created. Please wait and do not click again.
            </p>
        </div>

        <div id="dealResultState" style="display:none;">
            <div id="dealResultIcon" class="deal-result-icon">✓</div>
            <h4 id="dealResultTitle" class="deal-modal-title">Deal Created Successfully</h4>
            <p id="dealResultText" class="deal-modal-text"></p>

            <div id="dealResultDetails" class="deal-result-details" style="display:none;">
                <div><strong>Zoho CRM ID:</strong> <span id="dealZohoIdText"></span></div>
            </div>

            <button type="button" id="dealModalOkBtn" class="deal-modal-btn">OK</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('DealForm');
    const modal = document.getElementById('dealStatusModal');
    const loadingState = document.getElementById('dealLoadingState');
    const resultState = document.getElementById('dealResultState');
    const resultIcon = document.getElementById('dealResultIcon');
    const resultTitle = document.getElementById('dealResultTitle');
    const resultText = document.getElementById('dealResultText');
    const resultDetails = document.getElementById('dealResultDetails');
    const zohoIdText = document.getElementById('dealZohoIdText');
    const okBtn = document.getElementById('dealModalOkBtn');
    const saveBtn = document.getElementById('saveDealBtn');

    let isSubmitting = false;

    function openDealLoadingModal() {
        modal.classList.add('show');
        loadingState.style.display = 'block';
        resultState.style.display = 'none';
    }

    function showDealSuccessModal(message, zohoId) {
        loadingState.style.display = 'none';
        resultState.style.display = 'block';

        resultIcon.className = 'deal-result-icon';
        resultIcon.innerHTML = '✓';
        resultTitle.innerText = 'Deal Created Successfully';
        resultText.innerText = message || 'Deal has been created successfully.';

        if (zohoId) {
            resultDetails.style.display = 'block';
            zohoIdText.innerText = zohoId;
        } else {
            resultDetails.style.display = 'none';
            zohoIdText.innerText = '';
        }
    }

    function showDealErrorModal(message) {
        loadingState.style.display = 'none';
        resultState.style.display = 'block';

        resultIcon.className = 'deal-result-icon error';
        resultIcon.innerHTML = '!';
        resultTitle.innerText = 'Creation Failed';
        resultText.innerText = message || 'Something went wrong while creating the deal.';
        resultDetails.style.display = 'none';
        zohoIdText.innerText = '';
    }

    function closeDealModal() {
        modal.classList.remove('show');
    }

    okBtn.addEventListener('click', function () {
        closeDealModal();
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (isSubmitting) {
            return false;
        }

        isSubmitting = true;
        form.classList.add('form-submitting');
        saveBtn.disabled = true;

        openDealLoadingModal();

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async function (response) {
            const text = await response.text();

            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                throw new Error(text || 'Invalid server response');
            }

            return data;
        })
        .then(function (res) {
            isSubmitting = false;
            form.classList.remove('form-submitting');
            saveBtn.disabled = false;

            if (res.status === 'success') {
                if (res.redirect_url) {
                    window.location.href = res.redirect_url;
                    return;
                }

                showDealSuccessModal(
                    res.message || 'Deal created successfully.',
                    res.zoho_crm_id || ''
                );
                form.reset();
            } else {
                showDealErrorModal(res.message || 'Failed to create deal.');
            }
        })
        .catch(function (error) {
            isSubmitting = false;
            form.classList.remove('form-submitting');
            saveBtn.disabled = false;
            showDealErrorModal(error.message || 'Something went wrong!');
        });
    });
});
</script>