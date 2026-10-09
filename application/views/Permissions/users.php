<?php
$this->rbac->require('permissions.manage');
?>

<div class="row">

    <!-- LEFT: CREATE / EDIT -->
    <div class="col-md-4">

        <form method="post" action="<?= site_url('index.php/Permissions/user_save') ?>">

            <?php if (isset($edit_user)): ?>
                <input type="hidden" name="id" value="<?= (int)$edit_user->id ?>">
            <?php endif; ?>

            <!-- SECTION HEADER -->
            <div class="section-header">
                <h5><?= isset($edit_user) ? 'Edit Admin User' : 'Create Admin User' ?></h5>
                <p>Create system users and link them to employee profiles</p>
            </div>

            <!-- FORM PANEL -->
            <div class="form-panel">

                <div class="row gx-4 gy-4">

                    <div class="col-md-12">
                        <div class="field-group">
                            <div class="field">
                                <label>Name *</label>
                                <input type="text" name="name" required
                                       value="<?= isset($edit_user) ? html_escape($edit_user->username) : '' ?>">
                                <small>Display name for admin panel</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="field-group">
                            <div class="field">
                                <label>Email *</label>
                                <input type="email" name="email" required
                                       value="<?= isset($edit_user) ? html_escape($edit_user->email) : '' ?>">
                                <small>Used for login and notifications</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="field-group">
                            <div class="field">
                                <label>Password <?= isset($edit_user) ? '(leave blank to keep)' : '*' ?></label>
                                <input type="password" name="password"
                                       <?= isset($edit_user) ? '' : 'required minlength="6"' ?>>
                                <small>Minimum 6 characters</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="field-group">
                            <div class="field">
                                <label>Status</label>
                                <select name="status">
                                    <option value="active"
                                        <?= isset($edit_user) && $edit_user->status === 'active' ? 'selected' : '' ?>>
                                        Active
                                    </option>
                                    <option value="inactive"
                                        <?= isset($edit_user) && $edit_user->status === 'inactive' ? 'selected' : '' ?>>
                                        Inactive
                                    </option>
                                </select>
                                <small>Inactive users cannot login</small>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- SAVE BAR -->
            <div class="save-bar">
                <span class="hint">
                    <?= isset($edit_user) ? 'Updating user will apply immediately' : 'New user can login after creation' ?>
                </span>

                <div>
                    <?php if (isset($edit_user)): ?>
                        <a href="<?= site_url('index.php/Permissions/users') ?>" class="btn btn-light me-2">
                            Cancel
                        </a>
                    <?php endif; ?>

                    <button class="btn btn-primary px-5">
                        <i class="fa fa-save me-2"></i>
                        <?= isset($edit_user) ? 'Update User' : 'Create User' ?>
                    </button>
                </div>
            </div>

        </form>

    </div>

    <!-- RIGHT: USERS LIST -->
    <div class="col-md-8">

        <!-- SECTION HEADER -->
        <div class="section-header">
            <h5>Admin Users</h5>
            <p>All system users with their employee linkage and access</p>
        </div>

        <div class="form-panel p-0">

            <table class="table table-hover mb-0">
                <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
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
                            <small class="text-muted"><?= html_escape($u->email) ?></small>
                        </td>


                        <td>
                            <span class="badge bg-<?= $u->status === 'active' ? 'success' : 'secondary' ?>">
                                <?= ucfirst($u->status) ?>
                            </span>
                        </td>

                        <td class="text-end">

                            <a href="<?= site_url('index.php/Permissions/users_edit/'.$u->id) ?>"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-edit"></i> Edit
                            </a>

                            <a href="<?= site_url('index.php/Permissions/permissions_assign?admin_id='.$u->id) ?>"
                               class="btn btn-sm btn-outline-dark">
                                <i class="fa fa-lock"></i> Permissions
                            </a>

                            <a href="<?= site_url('index.php/Permissions/user_toggle_status/'.$u->id) ?>"
                               class="btn btn-sm btn-outline-warning"
                               onclick="return confirm('Change user status?')">
                                <?= $u->status === 'active' ? 'Deactivate' : 'Activate' ?>
                            </a>

                        </td>
                    </tr>
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
