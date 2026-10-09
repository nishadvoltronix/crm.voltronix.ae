<?php
$this->rbac->require('permissions.manage');
?>

<div class="row">

    <!-- RIGHT: USERS LIST -->
    <div class="col-md-12">

        <div class="form-panel p-0">

            <table class="table table-hover mb-0">
                <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th class="text-end" width="260">Actions</th>
                </tr>
                </thead>
                <tbody>

                <?php if (!empty($users)): foreach ($users as $u): ?>
                    <tr>
                        <td>
                            <strong><?= html_escape($u->username) ?></strong>
                        </td>

                        <td>
                            <p class="text-muted"><?= html_escape($u->email) ?></p>
                        </td>


                        <td>
                            <?php
                                $role = trim($u->department_role);
                                ?>
                                <span class="badge <?= empty($role) ? 'bg-secondary' : 'bg-primary' ?>">
                                    <?= empty($role) ? 'Not Assigned' : html_escape($role) ?>
                                </span>
                        </td>

                        <td class="text-end">

                            <button class="btn btn-sm btn-outline-primary" data-pc-animate="3d-flip-horizontal"
                                     data-bs-toggle="modal"
                                     data-bs-target="#animateModal-<?php echo $u->id; ?>">
                              <i class="ph ph-pencil"></i>
                            </button>

                        </td>
                    </tr>

                        <div class="modal fade" id="animateModal-<?= $u->id; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                              <div class="modal-content shadow-lg border-0">

                                <!-- Header -->
                                <div class="modal-header bg-primary text-white">
                                  <h5 class="modal-title" style="color: #fff">
                                    <i class="ph ph-user-plus me-2"></i> Assign Department
                                  </h5>
                                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Body -->
                                <div class="modal-body">
                                  <form method="POST" action="<?php echo base_url('index.php/Permissions/assign_departments_role'); ?>">

                                      <input type="hidden" value="<?php echo $u->id; ?>" name="ID">
                                      <!-- Job Info -->
                                      <div class="form-group">
                                            <label>Select Department</label>

                                            <select name="department_role" class="form-control" required>
                                                <option value="">-- Select Department --</option>
                                                <option value="Electrical" <?= ($u->department_role == 'Electrical') ? 'selected' : '' ?>>Electrical</option>
                                                <option value="Civil" <?= ($u->department_role == 'Civil') ? 'selected' : '' ?>>Civil</option>
                                                <option value="PM" <?= ($u->department_role == 'PM') ? 'selected' : '' ?>>PM</option>
                                                <option value="Switchgear" <?= ($u->department_role == 'Switchgear') ? 'selected' : '' ?>>Switchgear</option>
                                                <option value="Maintenance" <?= ($u->department_role == 'Maintenance') ? 'selected' : '' ?>>Maintenance</option>
                                                <option value="Accounts" <?= ($u->department_role == 'Accounts') ? 'selected' : '' ?>>Accounts</option>
                                                <option value="Operations" <?= ($u->department_role == 'Operations') ? 'selected' : '' ?>>Operations</option>
                                            </select>
                                        </div>

                                      <hr>

                                </div>

                                <!-- Footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="ph ph-x me-1"></i> Close
                                  </button>
                                  <button type="submit" class="btn btn-primary">
                                    <i class="ph ph-check-circle me-1"></i> Save
                                  </button>
                                </div>
                                </form>

                              </div>
                            </div>
                          </div>

                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No admin users found
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
