<style>
#jobsTable td {
    line-height: 2.8;
}

.wrap-text {
 /* white-space: normal !important;
    word-break: break-word;
 */
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
                 <table id="jobsTable" class="table table-hover mb-0 w-100" id="advanced-table">
                  
                  <thead>
                      <tr>
                          <th>Date Assigned</th>
                          <th>Job ID</th>
                          <th>Job Date</th>
                          <th>Account Name</th>
                          <th>Deal Status</th>
                          <th>Overall Status</th>
                          <th>Department</th>
                          <th>Department Assigned To</th>
                          <th>Your Status</th>
                          <th>Action</th>
                      </tr>
                  </thead>

                  <tbody>
                      <?php foreach ($records as $row): ?>
                      <tr>
                          <td><?= $row['assigned_date']; ?></td>
                          <td><?= $row['job_deal_number']; ?></td>
                          <td><?= $row['job_deal_date']; ?></td>
                          <td><div class="cell-scroll"><?= $row['account_name']; ?></div></td>
                          <td><span class="badge bg-warning"><?php echo $row['status']; ?></span></td>
                          <?php if (empty($row['Job_Status']) || $row['Job_Status'] === 'Active') { ?>
                                <td>
                                    <div class="status-box bg-success-light text-success">
                                        Active
                                    </div>
                                </td>
                          <?php } elseif ($row['Job_Status'] == 'Hold') { ?>
                                <td>
                                    <div class="status-box bg-hold-light text-hold">
                                        <?php echo $row['Job_Status']; ?>
                                    </div>
                                </td>
                          <?php } elseif ($row['Job_Status'] == 'Closed') { ?>
                                <td>
                                    <div class="status-box bg-hold-light text-hold">
                                        <?php echo $row['Job_Status']; ?>
                                    </div>
                                </td>
                          <?php } ?>
                          <td><?=$row['my_department']; ?></td>
                          <td><?=$row['job_assigned_to']; ?></td>
                          <td><span class="badge bg-<?= status_badge($row['my_status']); ?>"><?php echo $row['my_status']; ?></span></td>

                          <?php if($row['my_department'] == "Electrical"){ ?>
                          <td><a href="<?php echo base_url('index.php/Electrical/lead_detail/'.$row['id']); ?>">
                             <button class="btn btn-sm btn-primary">
                              <i class="ph ph-pencil"></i>
                            </button></a>
                            </span></td>
                          <?php } ?>
                          <?php if($row['my_department'] == "Civil"){ ?>
                          <td><a href="<?php echo base_url('index.php/Civil/lead_detail/'.$row['id']); ?>">
                             <button class="btn btn-sm btn-primary">
                              <i class="ph ph-pencil"></i>
                            </button></a>
                            </span></td>
                          <?php } ?>
                          <?php if($row['my_department'] == "PM"){ ?>
                          <td><a href="<?php echo base_url('index.php/Project_Manager/lead_detail/'.$row['id']); ?>">
                             <button class="btn btn-sm btn-primary">
                              <i class="ph ph-pencil"></i>
                            </button></a>
                            </span></td>
                          <?php } ?>
                          <?php if($row['my_department'] == "Switchgear"){ ?>
                          <td><a href="<?php echo base_url('index.php/Switchgear/lead_detail/'.$row['id']); ?>">
                             <button class="btn btn-sm btn-primary">
                              <i class="ph ph-pencil"></i>
                            </button></a>
                            </span></td>
                          <?php } ?>
                          <?php if($row['my_department'] == "Maintenance"){ ?>
                          <td><a href="<?php echo base_url('index.php/Maintenance/lead_detail/'.$row['id']); ?>">
                             <button class="btn btn-sm btn-primary">
                              <i class="ph ph-pencil"></i>
                            </button></a>
                            </span></td>
                          <?php } ?>

                      </tr>
                      <?php endforeach; ?>
                  </tbody>
                    
                      <?php foreach ($records as $row): ?>
                          <div class="modal fade" id="animateModal-<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content shadow-lg border-0">

                                <!-- Header -->
                                <div class="modal-header bg-primary text-white">
                                  <h5 class="modal-title" style="color: #fff">
                                    <i class="ph ph-user-plus me-2"></i> Assign Departments
                                  </h5>
                                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Body -->
                                <div class="modal-body">
                                  <form method="POST" action="<?php echo base_url('index.php/Jobs/assign_job_departments'); ?>">

                                      <input type="hidden" value="<?php echo $row['id']; ?>" name="ID">
                                      <!-- Job Info -->
                                      <div class="text-center mb-4">
                                        <h5 class="fw-semibold mb-1">
                                          <i class="ph ph-buildings me-1 text-primary"></i>
                                          <?= $row['account_name']; ?>
                                        </h5>
                                        <p class="text-muted mb-0">
                                          <i class="ph ph-hash me-1"></i>
                                          Job ID: <strong><?= $row['job_deal_number']; ?></strong>
                                        </p>
                                      </div>

                                      <hr>

                                      <div class="row g-4">

                                        <!-- Electrical -->
                                        <div class="col-md-4">
                                          <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-body text-center">
                                              <div class="mb-3">
                                                <span class="avatar avatar-md bg-primary-subtle text-primary rounded-circle">
                                                  <i class="ph ph-lightning fs-4"></i>
                                                </span>
                                              </div>
                                              <h6 class="fw-semibold">Electrical</h6>
                                              <select class="form-select mt-2" name="electrical_user">
                                                  <option value="">Select User</option>
                                                  <?php foreach ($users as $user): ?>
                                                      <option value="<?= $user->id; ?>">
                                                          <?= $user->username; ?>
                                                      </option>
                                                  <?php endforeach; ?>
                                              </select>
                                            </div>
                                          </div>
                                        </div>

                                        <!-- Civil -->
                                        <div class="col-md-4">
                                          <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-body text-center">
                                              <div class="mb-3">
                                                <span class="avatar avatar-md bg-success-subtle text-success rounded-circle">
                                                  <i class="ph ph-buildings fs-4"></i>
                                                </span>
                                              </div>
                                              <h6 class="fw-semibold">Civil</h6>
                                              <select class="form-select mt-2" name="civil_user">
                                                  <option value="">Select User</option>
                                                  <?php foreach ($users as $user): ?>
                                                      <option value="<?= $user->id; ?>">
                                                          <?= $user->username; ?>
                                                      </option>
                                                  <?php endforeach; ?>
                                              </select>
                                            </div>
                                          </div>
                                        </div>

                                        <!-- Project Manager -->
                                        <div class="col-md-4">
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
                                                  <?php foreach ($users as $user): ?>
                                                      <option value="<?= $user->id; ?>">
                                                          <?= $user->username; ?>
                                                      </option>
                                                  <?php endforeach; ?>
                                              </select>

                                            </div>
                                          </div>
                                        </div>

                                      </div>

                                  

                                </div>

                                <!-- Footer -->
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
                      <?php endforeach; ?>

                      <?php foreach ($records as $row): ?>
                          <div class="modal fade" id="accountsModal-<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                              <div class="modal-content shadow-lg border-0">

                                <!-- Header -->
                                <div class="modal-header bg-purple text-white">
                                  <h5 class="modal-title" style="color: #fff">
                                    <i class="ph ph-user-plus me-2"></i> Accounts Departments
                                  </h5>
                                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Body -->
                                <div class="modal-body">
                                  <form method="POST" action="<?php echo base_url('index.php/Jobs/assign_accounts_department'); ?>">

                                      <input type="hidden" value="<?php echo $row['id']; ?>" name="ID">
                                      <!-- Job Info -->
                                      <div class="text-center mb-4">
                                        <h5 class="fw-semibold mb-1">
                                          <i class="ph ph-buildings me-1 text-primary"></i>
                                          <?= $row['account_name']; ?>
                                        </h5>
                                        <p class="text-muted mb-0">
                                          <i class="ph ph-hash me-1"></i>
                                          Job ID: <strong><?= $row['job_deal_number']; ?></strong>
                                        </p>
                                      </div>

                                      <hr>

                                      <div class="row">

                                        <!-- Accounts -->
                                        <div class="col-md-12">
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
                                                          <?= $user->username; ?>
                                                      </option>
                                                  <?php endforeach; ?>
                                              </select>
                                            </div>
                                          </div>
                                        </div>

                                      </div>

                                  

                                </div>

                                <!-- Footer -->
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
                      <?php endforeach; ?>


                      

                 </table>
                </div>
                </div>
              </div>
            </div>
          </div>

<script src="<?php echo base_url('include/dist/assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/jquery.dataTables.min.js'); ?>"></script>

<script>
$(function () {
    $('#jobsTable').DataTable({
        searching: true,
        paging: true,
        ordering: true,
        info: true,
        order: [[0, 'desc']]
    });
});
</script>

 <script>
      var animateModal = document.getElementById('animateModal-<?php echo $row['id']; ?>');
      animateModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var recipient = button.getAttribute('data-pc-animate');
   //   var modalTitle = animateModal.querySelector('.modal-title');
        modalTitle.textContent = 'Animate Modal : ' + recipient;
        animateModal.classList.add('anim-' + recipient);
        if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
          document.body.classList.add('anim-' + recipient);
        }
      });
      animateModal.addEventListener('hidden.bs.modal', function (event) {
        removeClassByPrefix(animateModal, 'anim-');
        removeClassByPrefix(document.body, 'anim-');
      });

      function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
          let value = node.classList[i];
          if (value.startsWith(prefix)) {
            node.classList.remove(value);
          }
        }
      }
    </script>