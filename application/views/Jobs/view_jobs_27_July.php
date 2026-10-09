<style>
#jobsTable {
    visibility: hidden;
}

#jobsTable td {
    line-height: 2.2;
}

.cell-scroll {
    max-width: 260px;
    max-height: 60px;
    overflow-y: auto;
    overflow-x: hidden;
    white-space: normal;
    word-break: break-word;
    line-height: 1.4;
}

.status-box {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.bg-success-light {
    background: #e9f7ef;
}

.bg-success-dark {
    background: #1b8f4d;
}

.text-success-closed {
    color: #ffffff;
}

.text-success {
    color: #198754;
}

.bg-hold-light {
    background: #f6c5ca;
}

.text-hold {
    color: #ce0b0b;
}
</style>

<?php
function status_badge($status)
{
    if (empty($status)) {
        return 'secondary';
    }

    switch ($status) {
        case 'Completed':
            return 'warning';

        case 'Process':
            return 'purple';

        case 'Hold':
            return 'dangers';

        case 'Assigned':
            return 'danger';

        default:
            return 'secondary';
    }
}
?>

<div class="col-sm-12">
    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <div class="dt-responsive">

                    <table id="jobsTable" class="table table-hover mb-0 w-100">
                        <thead> 
                            <tr>
                                <th>Job ID</th>
                                <th>Job Date</th>
                                <th>Account Name</th>
                                <th>Sales Agent</th>
                                <th>Job Status</th>
                                <th>DEWA</th>
                                <th>Civil</th>
                                <th>PM</th>
                                <th>SWGR</th>
                                <th>MTN</th>
                                <th>Accounts</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($records as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['job_deal_number']); ?></td>

                                    <td><?= htmlspecialchars($row['job_deal_date']); ?></td>

                                    <td>
                                        <div class="cell-scroll">
                                            <?= htmlspecialchars($row['account_name']); ?>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge bg-warning">
                                            --
                                        </span>
                                    </td>

                                    <td>
                                        <?php if (empty($row['Job_Status']) || $row['Job_Status'] === 'Active') { ?>
                                            <div class="status-box bg-success-light text-success">Active</div>
                                        <?php } elseif ($row['Job_Status'] == 'Hold') { ?>
                                            <div class="status-box bg-hold-light text-hold">Hold</div>
                                        <?php } elseif ($row['Job_Status'] == 'Closed') { ?>
                                            <div class="status-box bg-success-dark text-success-closed">Closed</div>
                                        <?php } else { ?>
                                            <div class="status-box bg-success-light text-success">Active</div>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <span 
                                            class="badge bg-<?= status_badge($row['electrical_status']); ?>"
                                            data-bs-toggle="tooltip"
                                            title="<?= htmlspecialchars($row['electrical_assigned_to'] ?? 'Not Assigned'); ?>">
                                            <?= htmlspecialchars($row['electrical_status'] ?? 'Not Assigned'); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span 
                                            class="badge bg-<?= status_badge($row['civil_status']); ?>"
                                            data-bs-toggle="tooltip"
                                            title="<?= htmlspecialchars($row['civil_assigned_to'] ?? 'Not Assigned'); ?>">
                                            <?= htmlspecialchars($row['civil_status'] ?? 'Not Assigned'); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span 
                                            class="badge bg-<?= status_badge($row['pm_status']); ?>"
                                            data-bs-toggle="tooltip"
                                            title="<?= htmlspecialchars($row['pm_assigned_to'] ?? 'Not Assigned'); ?>">
                                            <?= htmlspecialchars($row['pm_status'] ?? 'Not Assigned'); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span 
                                            class="badge bg-<?= status_badge($row['swg_status']); ?>"
                                            data-bs-toggle="tooltip"
                                            title="<?= htmlspecialchars($row['swg_assigned_to'] ?? 'Not Assigned'); ?>">
                                            <?= htmlspecialchars($row['swg_status'] ?? 'Not Assigned'); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span 
                                            class="badge bg-<?= status_badge($row['mtn_status']); ?>"
                                            data-bs-toggle="tooltip"
                                            title="<?= htmlspecialchars($row['mtn_assigned_to'] ?? 'Not Assigned'); ?>">
                                            <?= htmlspecialchars($row['mtn_status'] ?? 'Not Assigned'); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-success">Pending</span>
                                    </td>

                                    <td class="text-end">
                                        <?= number_format((float)$row['service_charge'], 2); ?>
                                    </td>

                                    <td>
                                        <a href="<?= base_url('index.php/Jobs/lead_detail/' . $row['id']); ?>">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" title="View">
                                                <i class="ph ph-eye"></i>
                                            </button>
                                        </a>

                                        <button 
                                            type="button"
                                            class="btn btn-sm btn-outline-primary assign-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#assignModal"
                                            data-id="<?= htmlspecialchars($row['id']); ?>"
                                            data-account="<?= htmlspecialchars($row['account_name']); ?>"
                                            data-job="<?= htmlspecialchars($row['job_deal_number']); ?>"
                                            data-description="<?= htmlspecialchars($row['complaint_info'] ?? ''); ?>"
                                            data-electrical-name="<?= htmlspecialchars(
                                                $row['electrical_assigned_to'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                            title="Assign Department">
                                            <i class="ph ph-pencil"></i>
                                        </button>

                                        <button 
                                            type="button"
                                            class="btn btn-sm btn-outline-dangers hold-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#holdModal"
                                            data-id="<?= htmlspecialchars($row['id']); ?>"
                                            data-account="<?= htmlspecialchars($row['account_name']); ?>"
                                            data-job="<?= htmlspecialchars($row['job_deal_number']); ?>"
                                            data-status="<?= htmlspecialchars($row['Job_Status'] ?? 'Active'); ?>"
                                            title="Put Job on Hold">
                                            <i class="ti ti-player-pause"></i>
                                        </button>

                                        <button 
                                            type="button"
                                            class="btn btn-sm btn-outline-purple accounts-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#accountsModal"
                                            data-id="<?= htmlspecialchars($row['id']); ?>"
                                            data-account="<?= htmlspecialchars($row['account_name']); ?>"
                                            data-job="<?= htmlspecialchars($row['job_deal_number']); ?>"
                                            title="Assign Accounts">
                                            <i class="ti ti-currency-dollar"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>


<!-- Assign Departments Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" style="color:#fff;">
                    <i class="ph ph-user-plus me-2"></i> Assign Departments
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="<?= base_url('index.php/Jobs/assign_job_departments'); ?>">
                <div class="modal-body">

                    <input type="hidden" name="ID" id="assign_job_id">

                    <div class="text-center mb-4">
                        <h5 class="fw-bold text-dark mb-2">
                            <i class="ph ph-buildings text-primary me-2"></i>
                            <span id="assign_account_name"></span>
                        </h5>

                        <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-light border mb-3">
                            <i class="ph ph-hash text-primary me-2"></i>
                            <span class="text-muted me-1">Job ID:</span>
                            <strong id="assign_job_number"></strong>
                        </div>

                        <div class="bg-light border rounded p-3">
                            <div class="text-muted small mb-2">
                                <i class="ph ph-chat-text text-primary me-1"></i>
                                Complaint Description
                            </div>

                            <div class="text-dark" id="assign_description"></div>
                        </div>
                    </div>

                    <hr>

                    <div class="row g-4">

                        <div class="col-md">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">

                                    <div class="d-flex justify-content-between align-items-start">
                                        <span></span>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger unassign-department-btn"
                                            title="Unassign DEWA user"
                                            data-department="electrical"
                                        >
                                            <i class="ph ph-user-minus"></i>
                                        </button>
                                    </div>

                                    <div class="mb-3">
                                        <span class="avatar avatar-md bg-primary-subtle text-primary rounded-circle">
                                            <i class="ph ph-lightning fs-4"></i>
                                        </span>
                                    </div>

                                    <h6 class="fw-semibold">DEWA Approval</h6>

                                    <select
                                        class="form-select mt-2"
                                        name="electrical_user"
                                        id="electrical_user"
                                    >
                                        <option value="">Select User</option>

                                        <?php foreach ($e_users as $user): ?>
                                            <option value="<?= (int) $user->id; ?>">
                                                <?= htmlspecialchars(
                                                    $user->username,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <br>

                                    <p class="mb-2 text-muted" style="font-size: 13px;">
                                        <i class="ph ph-user me-1 text-primary"></i>
                                        <strong>Assigned To:</strong><br>

                                        <span
                                            id="electrical_assigned_name"
                                            class="text-danger fw-semibold"
                                        >
                                            Not Assigned
                                        </span>
                                    </p>

                                </div>
                                    </div>
                        </div>

                        <div class="col-md">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <span class="avatar avatar-md bg-success-subtle text-success rounded-circle">
                                            <i class="ph ph-buildings fs-4"></i>
                                        </span>
                                    </div>

                                    <h6 class="fw-semibold">Civil Approval</h6>

                                    <select class="form-select mt-2" name="civil_user">
                                        <option value="">Select User</option>
                                        <?php foreach ($c_users as $user): ?>
                                            <option value="<?= $user->id; ?>">
                                                <?= htmlspecialchars($user->username); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <span class="avatar avatar-md bg-warning-subtle text-warning rounded-circle">
                                            <i class="ph ph-user-gear fs-4"></i>
                                        </span>
                                    </div>

                                    <h6 class="fw-semibold">Project Manager</h6>

                                    <select class="form-select mt-2" name="pm_user">
                                        <option value="">Select User</option>
                                        <?php foreach ($pm_users as $user): ?>
                                            <option value="<?= $user->id; ?>">
                                                <?= htmlspecialchars($user->username); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <span class="avatar avatar-md bg-info-subtle text-info rounded-circle">
                                        <i class="ph ph-plug fs-4"></i>
                                    </span>
                                    </div>

                                    <h6 class="fw-semibold">SwitchGear</h6>

                                    <select class="form-select mt-2" name="swg_user">
                                        <option value="">Select User</option>
                                        <?php foreach ($swg_users as $user): ?>
                                            <option value="<?= $user->id; ?>">
                                                <?= htmlspecialchars($user->username); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <span class="avatar avatar-md bg-danger-subtle text-danger rounded-circle">
                                        <i class="ph ph-wrench fs-4"></i>
                                    </span>
                                    </div>

                                    <h6 class="fw-semibold">Maintenance</h6>

                                    <select class="form-select mt-2" name="mtn_user">
                                        <option value="">Select User</option>
                                        <?php foreach ($mtn_users as $user): ?>
                                            <option value="<?= $user->id; ?>">
                                                <?= htmlspecialchars($user->username); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="ph ph-x me-1"></i> Close
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="ph ph-check-circle me-1"></i> Save Assignments
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- Accounts Modal -->
<div class="modal fade" id="accountsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">

            <div class="modal-header bg-purple text-white">
                <h5 class="modal-title" style="color:#fff;">
                    <i class="ph ph-user-plus me-2"></i> Accounts Department
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="<?= base_url('index.php/Jobs/assign_accounts_department'); ?>">
                <div class="modal-body">

                    <input type="hidden" name="ID" id="accounts_job_id">

                    <div class="text-center mb-4">
                        <h5 class="fw-semibold mb-1">
                            <i class="ph ph-buildings me-1 text-primary"></i>
                            <span id="accounts_account_name"></span>
                        </h5>

                        <p class="text-muted mb-0">
                            <i class="ph ph-hash me-1"></i>
                            Job ID: <strong id="accounts_job_number"></strong>
                        </p>
                    </div>

                    <hr>

                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">

                            <div class="mb-3">
                                <span class="avatar avatar-md bg-primary-subtle text-primary rounded-circle">
                                    <i class="ti ti-zoom-money fs-4"></i>
                                </span>
                            </div>

                            <h6 class="fw-semibold">Accounts</h6>

                            <select class="form-select mt-2" name="accounts_user">
                                <option value="">Select User</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user->id; ?>">
                                        <?= htmlspecialchars($user->username); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="ph ph-x me-1"></i> Close
                    </button>

                    <button type="submit" class="btn btn-purple">
                        <i class="ph ph-check-circle me-1"></i> Save Assignments
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- Hold Modal -->
<div class="modal fade" id="holdModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">

            <div class="modal-header bg-dangers text-white">
                <h5 class="modal-title" style="color:#fff;">
                    <i class="ti ti-player-pause me-1"></i>
                    Are you sure you want to update this project?
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="<?= base_url('index.php/Jobs/hold_full_job'); ?>">
                <div class="modal-body">

                    <input type="hidden" name="ID" id="hold_job_id">

                    <div class="text-center mb-4">
                        <h5 class="fw-semibold mb-1">
                            <i class="ph ph-buildings me-1 text-primary"></i>
                            <span id="hold_account_name"></span>
                        </h5>

                        <p class="text-muted mb-0">
                            <i class="ph ph-hash me-1"></i>
                            Job ID: <strong id="hold_job_number"></strong>
                        </p>
                    </div>

                    <hr>

                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">

                            <h6 class="fw-semibold">Project Status</h6>

                            <select class="form-select mt-2" id="hold_job_status" name="Job_Status">
                                <option value="">--Select--</option>
                                <option value="Active">Active</option>
                                <option value="Hold">Hold</option>
                                <option value="Closed">Closed</option>
                            </select>

                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="ph ph-x me-1"></i> Close
                    </button>

                    <button type="submit" class="btn btn-dangers">
                        <i class="ph ph-check-circle me-1"></i> Save
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


<script src="<?= base_url('include/dist/assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?= base_url('include/dist/assets/js/jquery.dataTables.min.js'); ?>"></script>

<script>
$(function () {

    $('#jobsTable').DataTable({
        searching: true,
        paging: true,
        ordering: true,
        info: true,
        pageLength: 25,
        deferRender: true,
        order: [[0, 'desc']],
        initComplete: function () {
            $('#jobsTable').css('visibility', 'visible');
        }
    });

    $(document).on('click', '.assign-btn', function () {

        $('#assign_job_id').val($(this).data('id'));
        $('#assign_account_name').text($(this).data('account'));
        $('#assign_job_number').text($(this).data('job'));
        $('#assign_description').text($(this).data('description'));

        // Show assigned user
        var electricalName = $(this).data('electrical-name');

        if (electricalName && electricalName !== '') {
            $('#electrical_assigned_name')
                .text(electricalName)
                .removeClass('text-danger')
                .addClass('text-dark');
        } else {
            $('#electrical_assigned_name')
                .text('Not Assigned')
                .removeClass('text-dark')
                .addClass('text-danger');
        }

    });

    $(document).on('click', '.accounts-btn', function () {
        $('#accounts_job_id').val($(this).data('id'));
        $('#accounts_account_name').text($(this).data('account'));
        $('#accounts_job_number').text($(this).data('job'));
    });

    $(document).on('click', '.hold-btn', function () {
        $('#hold_job_id').val($(this).data('id'));
        $('#hold_account_name').text($(this).data('account'));
        $('#hold_job_number').text($(this).data('job'));

        var status = $(this).data('status');

        if (!status || status === '') {
            status = 'Active';
        }

        $('#hold_job_status').val(status);
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"], [title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

});
</script>