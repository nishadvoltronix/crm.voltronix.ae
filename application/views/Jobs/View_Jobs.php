<style>
#jobsTable {
    visibility: hidden;
}

#jobsTable td {
    line-height: 2.2;
}

.fixed-info-box {
    height: 170px;
}

.scrollable-description {
    height: 105px;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 5px 8px;
    line-height: 1.5;
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

/*
 * Keep unassign button space identical
 * on every department card.
 */
.unassign-department-btn {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/*
 * Disabled unassign icon.
 */
.unassign-department-btn:disabled {
    opacity: 0.30;
    cursor: not-allowed;
}

/*
 * Keeps department cards aligned.
 */
.department-card .card-body {
    position: relative;
}

.department-unassign-area {
    height: 35px;
}

/*
 * Loading modal spinner.
 */
.unassign-spinner {
    width: 45px;
    height: 45px;
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

                    <table
                        id="jobsTable"
                        class="table table-hover mb-0 w-100"
                    >

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
                        <!--    <th>Accounts</th>  -->
                                <th>Amount</th>
                                <th>Action</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php foreach ($records as $row): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars(
                                            $row['job_deal_number']
                                        ); ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $row['job_deal_date']
                                        ); ?>
                                    </td>


                                    <td>

                                        <div class="cell-scroll">

                                            <?= htmlspecialchars(
                                                $row['account_name']
                                            ); ?>

                                        </div>

                                    </td>


                                    <td>

                                        <center>

                                            <?= htmlspecialchars(
                                                $row['agent_assigned_name']
                                            ); ?>

                                        </center>

                                    </td>


                                    <!-- Job Status -->
                                    <td>

                                        <?php if (
                                            empty($row['Job_Status']) ||
                                            $row['Job_Status'] === 'Active'
                                        ) { ?>

                                            <div class="status-box bg-success-light text-success">
                                                Active
                                            </div>

                                        <?php } elseif (
                                            $row['Job_Status'] == 'Hold'
                                        ) { ?>

                                            <div class="status-box bg-hold-light text-hold">
                                                Hold
                                            </div>

                                        <?php } elseif (
                                            $row['Job_Status'] == 'Closed'
                                        ) { ?>

                                            <div class="status-box bg-success-dark text-success-closed">
                                                Closed
                                            </div>

                                        <?php } else { ?>

                                            <div class="status-box bg-success-light text-success">
                                                Active
                                            </div>

                                        <?php } ?>

                                    </td>


                                    <!-- DEWA -->
                                    <td>

                                        <span
                                            class="badge bg-<?= status_badge(
                                                $row['electrical_status']
                                            ); ?>"
                                            data-bs-toggle="tooltip"
                                            title="<?= htmlspecialchars(
                                                $row['electrical_assigned_to']
                                                    ?? 'Not Assigned'
                                            ); ?>"
                                        >

                                            <?= htmlspecialchars(
                                                $row['electrical_status']
                                                    ?? 'Not Assigned'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- Civil -->
                                    <td>

                                        <span
                                            class="badge bg-<?= status_badge(
                                                $row['civil_status']
                                            ); ?>"
                                            data-bs-toggle="tooltip"
                                            title="<?= htmlspecialchars(
                                                $row['civil_assigned_to']
                                                    ?? 'Not Assigned'
                                            ); ?>"
                                        >

                                            <?= htmlspecialchars(
                                                $row['civil_status']
                                                    ?? 'Not Assigned'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- Project Manager -->
                                    <td>

                                        <span
                                            class="badge bg-<?= status_badge(
                                                $row['pm_status']
                                            ); ?>"
                                            data-bs-toggle="tooltip"
                                            title="<?= htmlspecialchars(
                                                $row['pm_assigned_to']
                                                    ?? 'Not Assigned'
                                            ); ?>"
                                        >

                                            <?= htmlspecialchars(
                                                $row['pm_status']
                                                    ?? 'Not Assigned'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- SwitchGear -->
                                    <td>

                                        <span
                                            class="badge bg-<?= status_badge(
                                                $row['swg_status']
                                            ); ?>"
                                            data-bs-toggle="tooltip"
                                            title="<?= htmlspecialchars(
                                                $row['swg_assigned_to']
                                                    ?? 'Not Assigned'
                                            ); ?>"
                                        >

                                            <?= htmlspecialchars(
                                                $row['swg_status']
                                                    ?? 'Not Assigned'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- Maintenance -->
                                    <td>

                                        <span
                                            class="badge bg-<?= status_badge(
                                                $row['mtn_status']
                                            ); ?>"
                                            data-bs-toggle="tooltip"
                                            title="<?= htmlspecialchars(
                                                $row['mtn_assigned_to']
                                                    ?? 'Not Assigned'
                                            ); ?>"
                                        >

                                            <?= htmlspecialchars(
                                                $row['mtn_status']
                                                    ?? 'Not Assigned'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- Accounts -->
                                  <!--  <td>

                                        <span class="badge bg-success">
                                            Pending
                                        </span>

                                    </td> -->


                                    <!-- Amount -->
                                    <td class="text-end">

                                        <?= number_format(
                                            (float) $row['service_charge'],
                                            2
                                        ); ?>

                                    </td>


                                    <!-- Actions -->
                                    <td>

                                        <!-- View -->
                                        <a
                                            href="<?= base_url(
                                                'index.php/Jobs/lead_detail/' .
                                                $row['id']
                                            ); ?>"
                                        >

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-secondary"
                                                title="View"
                                            >

                                                <i class="ph ph-eye"></i>

                                            </button>

                                        </a>


                                        <!-- Assign Departments -->
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-primary assign-btn"

                                            data-bs-toggle="modal"
                                            data-bs-target="#assignModal"

                                            data-id="<?= (int) $row['id']; ?>"

                                            data-account="<?= htmlspecialchars(
                                                $row['account_name'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"

                                            data-job="<?= htmlspecialchars(
                                                $row['job_deal_number'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"

                                            data-description="<?= htmlspecialchars(
                                                $row['complaint_info'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"

                                            data-admin-remarks="<?= htmlspecialchars(
                                                $row['Admin_Remarks'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"

                                            data-job-status="<?= htmlspecialchars(
                                                $row['Job_Status']
                                                    ?? 'Active',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"


                                            data-electrical-name="<?= htmlspecialchars(
                                                $row['electrical_assigned_to']
                                                    ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"

                                            data-electrical-status="<?= htmlspecialchars(
                                                $row['electrical_status']
                                                    ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"


                                            data-civil-name="<?= htmlspecialchars(
                                                $row['civil_assigned_to']
                                                    ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"

                                            data-civil-status="<?= htmlspecialchars(
                                                $row['civil_status']
                                                    ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"


                                            data-pm-name="<?= htmlspecialchars(
                                                $row['pm_assigned_to']
                                                    ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"

                                            data-pm-status="<?= htmlspecialchars(
                                                $row['pm_status']
                                                    ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"


                                            data-swg-name="<?= htmlspecialchars(
                                                $row['swg_assigned_to']
                                                    ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"

                                            data-swg-status="<?= htmlspecialchars(
                                                $row['swg_status']
                                                    ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"


                                            data-mtn-name="<?= htmlspecialchars(
                                                $row['mtn_assigned_to']
                                                    ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"

                                            data-mtn-status="<?= htmlspecialchars(
                                                $row['mtn_status']
                                                    ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"

                                            title="Assign Department"
                                        >

                                            <i class="ph ph-pencil"></i>

                                        </button>


                                        <!-- Hold -->
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-dangers hold-btn"

                                            data-bs-toggle="modal"

                                            data-bs-target="#holdModal"

                                            data-id="<?= htmlspecialchars(
                                                $row['id']
                                            ); ?>"

                                            data-account="<?= htmlspecialchars(
                                                $row['account_name']
                                            ); ?>"

                                            data-job="<?= htmlspecialchars(
                                                $row['job_deal_number']
                                            ); ?>"

                                            data-status="<?= htmlspecialchars(
                                                $row['Job_Status']
                                                    ?? 'Active'
                                            ); ?>"

                                            title="Put Job on Hold"
                                        >

                                            <i class="ti ti-player-pause"></i>

                                        </button>


                                        <!-- Accounts -->
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-purple accounts-btn"

                                            data-bs-toggle="modal"

                                            data-bs-target="#accountsModal"

                                            data-id="<?= htmlspecialchars(
                                                $row['id']
                                            ); ?>"

                                            data-account="<?= htmlspecialchars(
                                                $row['account_name']
                                            ); ?>"

                                            data-job="<?= htmlspecialchars(
                                                $row['job_deal_number']
                                            ); ?>"

                                            title="Assign Accounts"
                                        >

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



<!-- ====================================================== -->
<!-- ASSIGN DEPARTMENTS MODAL -->
<!-- ====================================================== -->

<div
    class="modal fade"
    id="assignModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content shadow-lg border-0">


            <div class="modal-header bg-primary text-white">

                <h5
                    class="modal-title"
                    style="color:#fff;"
                >

                    <i class="ph ph-user-plus me-2"></i>

                    Assign Departments

                </h5>


                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                method="POST"
                action="<?= base_url(
                    'index.php/Jobs/assign_job_departments'
                ); ?>"
            >

                <div class="modal-body">


                    <input
                        type="hidden"
                        name="ID"
                        id="assign_job_id"
                    >


                    <input
                        type="hidden"
                        id="assign_job_status"
                    >


                    <div class="text-center mb-4">


                        <h5 class="fw-bold text-dark mb-2">

                            <i
                                class="ph ph-buildings text-primary me-2"
                            ></i>

                            <span id="assign_account_name"></span>

                        </h5>


                        <div
                            class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-light border mb-3"
                        >

                            <i
                                class="ph ph-hash text-primary me-2"
                            ></i>

                            <span class="text-muted me-1">
                                Job ID:
                            </span>

                            <strong id="assign_job_number"></strong>

                        </div>

                        <div class="container">

    <div class="row g-3">

        <div class="col-md-6">

            <div class="bg-light border rounded p-3 fixed-info-box">

                <div class="text-muted small mb-2">

                    <i class="ph ph-chat-text text-primary me-1"></i>
                    Complaint Description

                </div>

                <div
                    class="text-dark scrollable-description"
                    id="assign_description"
                ></div>

            </div>

        </div>


        <div class="col-md-6">

            <div class="bg-light border rounded p-3 fixed-info-box">

                <div class="text-muted small mb-2">

                    <i class="ph ph-note-pencil text-primary me-1"></i>
                    Admin Remarks

                </div>

                <textarea
                    class="form-control"
                    id="assign_admin_remarks"
                    rows="2"
                    placeholder="Enter remarks here..."
                ><?= htmlspecialchars($row['Admin_Remarks'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>

                <div class="text-end mt-2">

                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        id="save_admin_remarks"
                    >
                        <i class="ph ph-floppy-disk me-1"></i>
                        Save Remarks
                    </button>

                </div>

                <div
                    id="remarks_save_message"
                    class="small mt-2"
                ></div>

            </div>

        </div>

    </div>

</div>


                        

                    </div>


                    <hr>


                    <div class="row g-4">


                        <!-- ================================================= -->
                        <!-- DEWA -->
                        <!-- ================================================= -->

                        <div class="col-md">

                            <div
                                class="card h-100 border-0 shadow-sm department-card"
                            >

                                <div class="card-body text-center">


                                    <div
                                        class="department-unassign-area d-flex justify-content-end"
                                    >

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger unassign-department-btn"

                                            data-department="electrical"

                                            data-department-label="DEWA Approval"

                                            title="No user assigned"

                                            disabled
                                        >

                                            <i
                                                class="ph ph-user-minus"
                                            ></i>

                                        </button>

                                    </div>


                                    <div class="mb-3">

                                        <span
                                            class="avatar avatar-md bg-primary-subtle text-primary rounded-circle"
                                        >

                                            <i
                                                class="ph ph-lightning fs-4"
                                            ></i>

                                        </span>

                                    </div>


                                    <h6 class="fw-semibold">
                                        DEWA Approval
                                    </h6>


                                    <select
                                        class="form-select mt-2"
                                        name="electrical_user"
                                        id="electrical_user"
                                    >

                                        <option value="">
                                            Select User
                                        </option>


                                        <?php foreach (
                                            $e_users as $user
                                        ): ?>

                                            <option
                                                value="<?= (int) $user->id; ?>"
                                            >

                                                <?= htmlspecialchars(
                                                    $user->username,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>


                                    <p
                                        class="mb-2 mt-3 text-muted"
                                        style="font-size:13px;"
                                    >

                                        <i
                                            class="ph ph-user me-1 text-primary"
                                        ></i>

                                        <strong>
                                            Assigned To:
                                        </strong>

                                        <br>


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



                        <!-- ================================================= -->
                        <!-- CIVIL -->
                        <!-- ================================================= -->

                        <div class="col-md">

                            <div
                                class="card h-100 border-0 shadow-sm department-card"
                            >

                                <div class="card-body text-center">


                                    <div
                                        class="department-unassign-area d-flex justify-content-end"
                                    >

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger unassign-department-btn"

                                            data-department="civil"

                                            data-department-label="Civil Approval"

                                            title="No user assigned"

                                            disabled
                                        >

                                            <i
                                                class="ph ph-user-minus"
                                            ></i>

                                        </button>

                                    </div>


                                    <div class="mb-3">

                                        <span
                                            class="avatar avatar-md bg-success-subtle text-success rounded-circle"
                                        >

                                            <i
                                                class="ph ph-buildings fs-4"
                                            ></i>

                                        </span>

                                    </div>


                                    <h6 class="fw-semibold">
                                        Civil Approval
                                    </h6>


                                    <select
                                        class="form-select mt-2"
                                        name="civil_user"
                                        id="civil_user"
                                    >

                                        <option value="">
                                            Select User
                                        </option>


                                        <?php foreach (
                                            $c_users as $user
                                        ): ?>

                                            <option
                                                value="<?= (int) $user->id; ?>"
                                            >

                                                <?= htmlspecialchars(
                                                    $user->username,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>


                                    <p
                                        class="mb-2 mt-3 text-muted"
                                        style="font-size:13px;"
                                    >

                                        <i
                                            class="ph ph-user me-1 text-success"
                                        ></i>

                                        <strong>
                                            Assigned To:
                                        </strong>

                                        <br>


                                        <span
                                            id="civil_assigned_name"
                                            class="text-danger fw-semibold"
                                        >

                                            Not Assigned

                                        </span>

                                    </p>

                                </div>

                            </div>

                        </div>



                        <!-- ================================================= -->
                        <!-- PROJECT MANAGER -->
                        <!-- ================================================= -->

                        <div class="col-md">

                            <div
                                class="card h-100 border-0 shadow-sm department-card"
                            >

                                <div class="card-body text-center">


                                    <div
                                        class="department-unassign-area d-flex justify-content-end"
                                    >

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger unassign-department-btn"

                                            data-department="pm"

                                            data-department-label="Project Manager"

                                            title="No user assigned"

                                            disabled
                                        >

                                            <i
                                                class="ph ph-user-minus"
                                            ></i>

                                        </button>

                                    </div>


                                    <div class="mb-3">

                                        <span
                                            class="avatar avatar-md bg-warning-subtle text-warning rounded-circle"
                                        >

                                            <i
                                                class="ph ph-user-gear fs-4"
                                            ></i>

                                        </span>

                                    </div>


                                    <h6 class="fw-semibold">
                                        Project Manager
                                    </h6>


                                    <select
                                        class="form-select mt-2"
                                        name="pm_user"
                                        id="pm_user"
                                    >

                                        <option value="">
                                            Select User
                                        </option>


                                        <?php foreach (
                                            $pm_users as $user
                                        ): ?>

                                            <option
                                                value="<?= (int) $user->id; ?>"
                                            >

                                                <?= htmlspecialchars(
                                                    $user->username,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>


                                    <p
                                        class="mb-2 mt-3 text-muted"
                                        style="font-size:13px;"
                                    >

                                        <i
                                            class="ph ph-user me-1 text-warning"
                                        ></i>

                                        <strong>
                                            Assigned To:
                                        </strong>

                                        <br>


                                        <span
                                            id="pm_assigned_name"
                                            class="text-danger fw-semibold"
                                        >

                                            Not Assigned

                                        </span>

                                    </p>

                                </div>

                            </div>

                        </div>



                        <!-- ================================================= -->
                        <!-- SWITCHGEAR -->
                        <!-- ================================================= -->

                        <div class="col-md">

                            <div
                                class="card h-100 border-0 shadow-sm department-card"
                            >

                                <div class="card-body text-center">


                                    <div
                                        class="department-unassign-area d-flex justify-content-end"
                                    >

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger unassign-department-btn"

                                            data-department="swg"

                                            data-department-label="SwitchGear"

                                            title="No user assigned"

                                            disabled
                                        >

                                            <i
                                                class="ph ph-user-minus"
                                            ></i>

                                        </button>

                                    </div>


                                    <div class="mb-3">

                                        <span
                                            class="avatar avatar-md bg-info-subtle text-info rounded-circle"
                                        >

                                            <i
                                                class="ph ph-plug fs-4"
                                            ></i>

                                        </span>

                                    </div>


                                    <h6 class="fw-semibold">
                                        SwitchGear
                                    </h6>


                                    <select
                                        class="form-select mt-2"
                                        name="swg_user"
                                        id="swg_user"
                                    >

                                        <option value="">
                                            Select User
                                        </option>


                                        <?php foreach (
                                            $swg_users as $user
                                        ): ?>

                                            <option
                                                value="<?= (int) $user->id; ?>"
                                            >

                                                <?= htmlspecialchars(
                                                    $user->username,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>


                                    <p
                                        class="mb-2 mt-3 text-muted"
                                        style="font-size:13px;"
                                    >

                                        <i
                                            class="ph ph-user me-1 text-info"
                                        ></i>

                                        <strong>
                                            Assigned To:
                                        </strong>

                                        <br>


                                        <span
                                            id="swg_assigned_name"
                                            class="text-danger fw-semibold"
                                        >

                                            Not Assigned

                                        </span>

                                    </p>

                                </div>

                            </div>

                        </div>



                        <!-- ================================================= -->
                        <!-- MAINTENANCE -->
                        <!-- ================================================= -->

                        <div class="col-md">

                            <div
                                class="card h-100 border-0 shadow-sm department-card"
                            >

                                <div class="card-body text-center">


                                    <div
                                        class="department-unassign-area d-flex justify-content-end"
                                    >

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger unassign-department-btn"

                                            data-department="mtn"

                                            data-department-label="Maintenance"

                                            title="No user assigned"

                                            disabled
                                        >

                                            <i
                                                class="ph ph-user-minus"
                                            ></i>

                                        </button>

                                    </div>


                                    <div class="mb-3">

                                        <span
                                            class="avatar avatar-md bg-danger-subtle text-danger rounded-circle"
                                        >

                                            <i
                                                class="ph ph-wrench fs-4"
                                            ></i>

                                        </span>

                                    </div>


                                    <h6 class="fw-semibold">
                                        Maintenance
                                    </h6>


                                    <select
                                        class="form-select mt-2"
                                        name="mtn_user"
                                        id="mtn_user"
                                    >

                                        <option value="">
                                            Select User
                                        </option>


                                        <?php foreach (
                                            $mtn_users as $user
                                        ): ?>

                                            <option
                                                value="<?= (int) $user->id; ?>"
                                            >

                                                <?= htmlspecialchars(
                                                    $user->username,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>


                                    <p
                                        class="mb-2 mt-3 text-muted"
                                        style="font-size:13px;"
                                    >

                                        <i
                                            class="ph ph-user me-1 text-danger"
                                        ></i>

                                        <strong>
                                            Assigned To:
                                        </strong>

                                        <br>


                                        <span
                                            id="mtn_assigned_name"
                                            class="text-danger fw-semibold"
                                        >

                                            Not Assigned

                                        </span>

                                    </p>

                                </div>

                            </div>

                        </div>


                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >

                        <i class="ph ph-x me-1"></i>

                        Close

                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i
                            class="ph ph-check-circle me-1"
                        ></i>

                        Save Assignments

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<!-- ====================================================== -->
<!-- UNASSIGN PROCESSING MODAL -->
<!-- ====================================================== -->

<div
    class="modal fade"
    id="unassignLoadingModal"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-sm modal-dialog-centered"
    >

        <div
            class="modal-content border-0 shadow-lg"
        >

            <div
                class="modal-body text-center p-5"
            >

                <div
                    class="spinner-border text-danger unassign-spinner mb-3"
                    role="status"
                >

                    <span class="visually-hidden">
                        Loading...
                    </span>

                </div>


                <h5 class="fw-semibold mb-2">

                    Unassigning Agent

                </h5>


                <p
                    class="text-muted mb-0"
                    id="unassignLoadingText"
                >

                    Please wait while we update the assignment.

                </p>

            </div>

        </div>

    </div>

</div>



<!-- ====================================================== -->
<!-- ACCOUNTS MODAL -->
<!-- ====================================================== -->

<div
    class="modal fade"
    id="accountsModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-md modal-dialog-centered">

        <div class="modal-content shadow-lg border-0">


            <div class="modal-header bg-purple text-white">

                <h5
                    class="modal-title"
                    style="color:#fff;"
                >

                    <i class="ph ph-user-plus me-2"></i>

                    Accounts Department

                </h5>


                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                method="POST"
                action="<?= base_url(
                    'index.php/Jobs/assign_accounts_department'
                ); ?>"
            >

                <div class="modal-body">


                    <input
                        type="hidden"
                        name="ID"
                        id="accounts_job_id"
                    >


                    <div class="text-center mb-4">

                        <h5 class="fw-semibold mb-1">

                            <i
                                class="ph ph-buildings me-1 text-primary"
                            ></i>

                            <span id="accounts_account_name"></span>

                        </h5>


                        <p class="text-muted mb-0">

                            <i class="ph ph-hash me-1"></i>

                            Job ID:

                            <strong id="accounts_job_number"></strong>

                        </p>

                    </div>


                    <hr>


                    <div class="card h-100 border-0 shadow-sm">

                        <div class="card-body text-center">


                            <div class="mb-3">

                                <span
                                    class="avatar avatar-md bg-primary-subtle text-primary rounded-circle"
                                >

                                    <i
                                        class="ti ti-zoom-money fs-4"
                                    ></i>

                                </span>

                            </div>


                            <h6 class="fw-semibold">
                                Accounts
                            </h6>


                            <select
                                class="form-select mt-2"
                                name="accounts_user"
                            >

                                <option value="">
                                    Select User
                                </option>


                                <?php foreach (
                                    $users as $user
                                ): ?>

                                    <option value="<?= $user->id; ?>">

                                        <?= htmlspecialchars(
                                            $user->username
                                        ); ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >

                        <i class="ph ph-x me-1"></i>

                        Close

                    </button>


                    <button
                        type="submit"
                        class="btn btn-purple"
                    >

                        <i class="ph ph-check-circle me-1"></i>

                        Save Assignments

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<!-- ====================================================== -->
<!-- HOLD MODAL -->
<!-- ====================================================== -->

<div
    class="modal fade"
    id="holdModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-md modal-dialog-centered">

        <div class="modal-content shadow-lg border-0">


            <div class="modal-header bg-dangers text-white">

                <h5
                    class="modal-title"
                    style="color:#fff;"
                >

                    <i class="ti ti-player-pause me-1"></i>

                    Are you sure you want to update this project?

                </h5>


                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                method="POST"
                action="<?= base_url(
                    'index.php/Jobs/hold_full_job'
                ); ?>"
            >

                <div class="modal-body">


                    <input
                        type="hidden"
                        name="ID"
                        id="hold_job_id"
                    >


                    <div class="text-center mb-4">

                        <h5 class="fw-semibold mb-1">

                            <i
                                class="ph ph-buildings me-1 text-primary"
                            ></i>

                            <span id="hold_account_name"></span>

                        </h5>


                        <p class="text-muted mb-0">

                            <i class="ph ph-hash me-1"></i>

                            Job ID:

                            <strong id="hold_job_number"></strong>

                        </p>

                    </div>


                    <hr>


                    <div class="card h-100 border-0 shadow-sm">

                        <div class="card-body text-center">


                            <h6 class="fw-semibold">
                                Project Status
                            </h6>


                            <select
                                class="form-select mt-2"
                                id="hold_job_status"
                                name="Job_Status"
                            >

                                <option value="">
                                    --Select--
                                </option>

                                <option value="Active">
                                    Active
                                </option>

                                <option value="Hold">
                                    Hold
                                </option>

                                <option value="Closed">
                                    Closed
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >

                        <i class="ph ph-x me-1"></i>

                        Close

                    </button>


                    <button
                        type="submit"
                        class="btn btn-dangers"
                    >

                        <i class="ph ph-check-circle me-1"></i>

                        Save

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<script
    src="<?= base_url(
        'include/dist/assets/js/jquery-3.6.0.min.js'
    ); ?>"
></script>

<script
    src="<?= base_url(
        'include/dist/assets/js/jquery.dataTables.min.js'
    ); ?>"
></script>


<script>

$(function () {


    /*
     * =====================================================
     * DATATABLE
     * =====================================================
     */

    $('#jobsTable').DataTable({

        searching: true,

        paging: true,

        ordering: true,

        info: true,

        pageLength: 25,

        deferRender: true,

        order: [[0, 'desc']],

        initComplete: function () {

            $('#jobsTable').css(
                'visibility',
                'visible'
            );

        }

    });



    /*
     * =====================================================
     * DEPARTMENT CONTROLS
     * =====================================================
     */

    var departmentControls = {

        electrical: {

            select: '#electrical_user',

            name: '#electrical_assigned_name'

        },

        civil: {

            select: '#civil_user',

            name: '#civil_assigned_name'

        },

        pm: {

            select: '#pm_user',

            name: '#pm_assigned_name'

        },

        swg: {

            select: '#swg_user',

            name: '#swg_assigned_name'

        },

        mtn: {

            select: '#mtn_user',

            name: '#mtn_assigned_name'

        }

    };



    /*
     * =====================================================
     * SHOW ASSIGNED USER
     * AND CONTROL UNASSIGN BUTTON
     * =====================================================
     */

    function showAssignedUser(
        department,
        userName,
        departmentStatus,
        jobStatus
    ) {

        var controls =
            departmentControls[department];


        if (!controls) {
            return;
        }


        userName = userName
            ? String(userName).trim()
            : '';


        departmentStatus =
            departmentStatus
                ? String(
                    departmentStatus
                ).trim()
                : '';


        jobStatus =
            jobStatus
                ? String(
                    jobStatus
                ).trim()
                : '';


        var nameElement =
            $(controls.name);


        var unassignButton = $(

            '.unassign-department-btn' +

            '[data-department="' +

            department +

            '"]'

        );



        /*
         * -----------------------------------------
         * Assigned Name
         * -----------------------------------------
         */

        if (userName !== '') {

            nameElement
                .text(userName)
                .removeClass(
                    'text-danger'
                )
                .addClass(
                    'text-dark'
                );

        } else {

            nameElement
                .text(
                    'Not Assigned'
                )
                .removeClass(
                    'text-dark'
                )
                .addClass(
                    'text-danger'
                );

        }



        /*
         * -----------------------------------------
         * Check status
         * -----------------------------------------
         */

        var isAssigned =
            userName !== '';


        var isDepartmentCompleted =

            departmentStatus
                .toLowerCase() ===
            'completed';


        var isJobClosed =

            jobStatus
                .toLowerCase() ===
            'closed';



        /*
         * -----------------------------------------
         * Button enabled
         * -----------------------------------------
         */

        if (
            isAssigned &&
            !isDepartmentCompleted &&
            !isJobClosed
        ) {

            unassignButton
                .prop(
                    'disabled',
                    false
                );


            unassignButton.attr(

                'title',

                'Unassign ' + userName

            );

        } else {


            /*
             * Always keep button visible.
             */

            unassignButton
                .prop(
                    'disabled',
                    true
                );


            if (isJobClosed) {

                unassignButton.attr(

                    'title',

                    'Cannot unassign from a closed job'

                );

            } else if (
                isDepartmentCompleted
            ) {

                unassignButton.attr(

                    'title',

                    'Cannot unassign a completed department'

                );

            } else {

                unassignButton.attr(

                    'title',

                    'No user assigned'

                );

            }

        }

    }



    /*
     * =====================================================
     * OPEN ASSIGN MODAL
     * =====================================================
     */

    $(document).on(
        'click',
        '.assign-btn',
        function () {


            var button = $(this);

            var taskId = $(this).data('id');

            var adminRemarks = $(this).data('admin-remarks');


            var jobStatus =
                button.attr(
                    'data-job-status'
                ) || 'Active';



            /*
             * Job Details
             */

            $('#assign_job_id').val(

                button.data('id')

            );


            $('#assign_job_status').val(

                jobStatus

            );


            $('#assign_account_name').text(

                button.data('account')

            );

            $('#assign_admin_remarks').val(adminRemarks || '');


            $('#assign_job_number').text(

                button.data('job')

            );


            $('#assign_description').text(

                button.data('description') || ''

            );



            /*
             * DEWA
             */

            showAssignedUser(

                'electrical',

                button.attr(
                    'data-electrical-name'
                ),

                button.attr(
                    'data-electrical-status'
                ),

                jobStatus

            );



            /*
             * CIVIL
             */

            showAssignedUser(

                'civil',

                button.attr(
                    'data-civil-name'
                ),

                button.attr(
                    'data-civil-status'
                ),

                jobStatus

            );



            /*
             * PROJECT MANAGER
             */

            showAssignedUser(

                'pm',

                button.attr(
                    'data-pm-name'
                ),

                button.attr(
                    'data-pm-status'
                ),

                jobStatus

            );



            /*
             * SWITCHGEAR
             */

            showAssignedUser(

                'swg',

                button.attr(
                    'data-swg-name'
                ),

                button.attr(
                    'data-swg-status'
                ),

                jobStatus

            );



            /*
             * MAINTENANCE
             */

            showAssignedUser(

                'mtn',

                button.attr(
                    'data-mtn-name'
                ),

                button.attr(
                    'data-mtn-status'
                ),

                jobStatus

            );



            /*
             * Reset dropdown selection
             */

            $('#electrical_user')
                .val('')
                .trigger('change');


            $('#civil_user')
                .val('')
                .trigger('change');


            $('#pm_user')
                .val('')
                .trigger('change');


            $('#swg_user')
                .val('')
                .trigger('change');


            $('#mtn_user')
                .val('')
                .trigger('change');

        }

    );



    /*
     * =====================================================
     * UNASSIGN DEPARTMENT
     * =====================================================
     */

    $(document).on(

        'click',

        '.unassign-department-btn',

        function () {


            var button = $(this);


            /*
             * Disabled button should do nothing
             */

            if (
                button.prop('disabled')
            ) {

                return;

            }



            var jobId =
                $('#assign_job_id').val();


            var jobStatus =
                $('#assign_job_status').val();


            var department =
                button.data(
                    'department'
                );


            var departmentLabel =
                button.data(
                    'department-label'
                );


            var controls =
                departmentControls[
                    department
                ];



            if (!jobId) {

                alert(
                    'Job ID is missing.'
                );

                return;

            }



            if (!controls) {

                alert(
                    'Invalid department.'
                );

                return;

            }



            /*
             * Extra browser validation
             */

            if (
                String(jobStatus)
                    .toLowerCase() ===
                'closed'
            ) {

                alert(
                    'You cannot unassign a user from a closed job.'
                );

                return;

            }



            var assignedUser = $(

                controls.name

            ).text().trim();



            if (
                assignedUser === '' ||
                assignedUser ===
                'Not Assigned'
            ) {

                return;

            }



            /*
             * Confirmation
             */

            var confirmed = confirm(

                'Are you sure you want to unassign ' +

                assignedUser +

                ' from ' +

                departmentLabel +

                '?'

            );


            if (!confirmed) {

                return;

            }



            /*
             * Disable button
             */

            button.prop(
                'disabled',
                true
            );



            /*
             * Loading message
             */

            $('#unassignLoadingText').html(

                'Unassigning <strong>' +

                $('<div>')
                    .text(assignedUser)
                    .html() +

                '</strong> from <strong>' +

                $('<div>')
                    .text(departmentLabel)
                    .html() +

                '</strong>.<br>Please wait...'

            );



            /*
             * Close Assign modal
             */

            var assignModalElement =
                document.getElementById(
                    'assignModal'
                );


            var assignModal =
                bootstrap.Modal.getInstance(
                    assignModalElement
                );


            if (assignModal) {

                assignModal.hide();

            }



            /*
             * Show processing modal.
             */

            setTimeout(
                function () {


                    var loadingModal =

                        new bootstrap.Modal(

                            document.getElementById(
                                'unassignLoadingModal'
                            ),

                            {
                                backdrop: 'static',
                                keyboard: false
                            }

                        );


                    loadingModal.show();



                    /*
                     * AJAX starts once loading
                     * modal is displayed.
                     */

                    $.ajax({


                        url:
                            "<?= base_url(
                                'index.php/Jobs/unassign_department'
                            ); ?>",


                        type:
                            'POST',


                        dataType:
                            'json',


                        data: {

                            job_id:
                                jobId,

                            department:
                                department

                        },



                        /*
                         * -----------------------------
                         * SUCCESS
                         * -----------------------------
                         */

                        success:
                            function (
                                response
                            ) {


                                if (
                                    response &&
                                    response.success ===
                                    true
                                ) {


                                    /*
                                     * Change loading text
                                     */

                                    $('#unassignLoadingText').html(

                                        '<span class="text-success">' +

                                        '<i class="ph ph-check-circle me-1"></i>' +

                                        'Successfully unassigned.' +

                                        '</span><br>' +

                                        'Opening job details...'

                                    );



                                    /*
                                     * Redirect to same
                                     * record detail page.
                                     */

                                    setTimeout(

                                        function () {

                                            window.location.href =

                                                "<?= base_url(
                                                    'index.php/Jobs/lead_detail/'
                                                ); ?>" +

                                                jobId;

                                        },

                                        700

                                    );


                                } else {


                                    loadingModal.hide();


                                    var message =

                                        response &&
                                        response.message

                                            ? response.message

                                            : 'Unable to unassign the user.';


                                    alert(message);



                                    /*
                                     * Reopen Assign modal
                                     * if operation failed.
                                     */

                                    setTimeout(

                                        function () {


                                            var modal =

                                                new bootstrap.Modal(

                                                    document.getElementById(
                                                        'assignModal'
                                                    )

                                                );


                                            modal.show();


                                            button.prop(
                                                'disabled',
                                                false
                                            );

                                        },

                                        300

                                    );

                                }

                            },



                        /*
                         * -----------------------------
                         * AJAX ERROR
                         * -----------------------------
                         */

                        error: function (xhr, status, error) {

    loadingModal.hide();

    console.log('AJAX Status:', status);
    console.log('AJAX Error:', error);
    console.log('Response Text:', xhr.responseText);

    var message =
        'Something went wrong while unassigning the user.';

    if (
        xhr.responseJSON &&
        xhr.responseJSON.message
    ) {

        message =
            xhr.responseJSON.message;

    } else if (xhr.responseText) {

        message +=
            '\n\nServer Response:\n' +
            xhr.responseText;

    }

    alert(message);

    setTimeout(
        function () {

            var modal =
                new bootstrap.Modal(
                    document.getElementById(
                        'assignModal'
                    )
                );

            modal.show();

            button.prop(
                'disabled',
                false
            );

        },
        300
    );
}

                    });


                },

                300

            );

        }

    );



    /*
     * =====================================================
     * ACCOUNTS MODAL
     * =====================================================
     */

    $(document).on(
        'click',
        '.accounts-btn',
        function () {


            $('#accounts_job_id').val(

                $(this).data('id')

            );


            $('#accounts_account_name').text(

                $(this).data('account')

            );


            $('#accounts_job_number').text(

                $(this).data('job')

            );

        }
    );



    /*
     * =====================================================
     * HOLD MODAL
     * =====================================================
     */

    $(document).on(
        'click',
        '.hold-btn',
        function () {


            $('#hold_job_id').val(

                $(this).data('id')

            );


            $('#hold_account_name').text(

                $(this).data('account')

            );


            $('#hold_job_number').text(

                $(this).data('job')

            );


            var status =
                $(this).data(
                    'status'
                );


            if (
                !status ||
                status === ''
            ) {

                status =
                    'Active';

            }


            $('#hold_job_status').val(
                status
            );

        }
    );



    /*
     * =====================================================
     * TOOLTIPS
     * =====================================================
     */

    var tooltipTriggerList =
        [].slice.call(

            document.querySelectorAll(

                '[data-bs-toggle="tooltip"]'

            )

        );


    tooltipTriggerList.map(

        function (
            tooltipTriggerEl
        ) {

            return new bootstrap.Tooltip(

                tooltipTriggerEl

            );

        }

    );


});

$(document).on('click', '#save_admin_remarks', function () {

    var task_id = $('#assign_job_id').val();
    var remarks = $('#assign_admin_remarks').val().trim();

    $.ajax({

        url: "<?= base_url('index.php/Jobs/save_admin_remarks'); ?>",

        type: "POST",

        dataType: "json",

        data: {
            task_id: task_id,
            remarks: remarks
        },

        success: function(response) {

    if (response.status === true) {

        $('#remarks_save_message')
            .removeClass('text-danger')
            .addClass('text-success')
            .text('Your remarks are saved.');

        setTimeout(function () {

            $('#remarks_save_message')
                .fadeOut(300, function () {

                    $(this)
                        .text('')
                        .show();

                });

        }, 3000);

    } else {

        $('#remarks_save_message')
            .removeClass('text-success')
            .addClass('text-danger')
            .text(response.message || 'Unable to save remarks.');

    }

}

    });

});

</script>