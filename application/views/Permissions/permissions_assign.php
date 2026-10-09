<?php
$this->rbac->require('permissions.manage');
?>

<div class="container-fluid">

    <!-- Page title -->
    <div class="mb-4">
        <h4 class="mb-0">Admin user</h4>
        <small class="text-muted">Select an admin to manage permissions</small>
    </div>

    <div class="row">

        <!-- LEFT COLUMN -->
        <div class="col-md-4">

            <form method="get" action="<?= site_url('index.php/Permissions/permissions_assign') ?>">
                <div class="form-group">
                    <label class="font-weight-600">Admin user</label>
                    <select name="admin_id" class="form-control">
                        <option value="">Select admin</option>
                        <?php foreach ($admins as $a): ?>
                            <option value="<?= $a->id ?>"
                                <?= ($selected_admin_id == $a->id ? 'selected' : '') ?>>
                                <?= html_escape($a->username . ' (' . $a->email . ')') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-2">
                    Load
                </button>
            </form>

            <?php if ($selected_admin_id): ?>
                <div class="alert alert-info mt-3">
                    Editing permissions for selected admin
                </div>
            <?php endif; ?>

        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-md-8">

            <?php if ($selected_admin_id): ?>

                <div class="mb-3">
                    <h5 class="mb-1">Permissions</h5>
                    <small class="text-muted">Enable or disable permissions below</small>
                </div>

                <form method="post" action="<?= site_url('index.php/Permissions/save_permissions') ?>">
                    <input type="hidden" name="admin_id" value="<?= $selected_admin_id ?>">

                    <?php foreach ($permission_groups as $group): ?>
                        <div class="mb-3">
                            <strong class="d-block mb-1">
                                <?= html_escape($group->label) ?>
                            </strong>

                            <?php foreach ($permissions as $p): ?>
                                <?php if ($p->group_id == $group->id): ?>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="permissions[]"
                                               value="<?= $p->id ?>"
                                               id="perm<?= $p->id ?>"
                                               <?= in_array($p->id, $assigned_permission_ids) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm<?= $p->id ?>">
                                            <?= html_escape($p->label) ?>
                                        </label>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </div>
                    <?php endforeach; ?>

                    <div class="mt-4">
                        <button class="btn btn-primary">
                            Save
                        </button>
                        <a href="<?= site_url('index.php/Permissions/users') ?>"
                           class="btn btn-secondary ml-2">
                            Back
                        </a>
                    </div>

                </form>

            <?php else: ?>

                <div class="text-muted">
                    Please select an admin user to assign permissions.
                </div>

            <?php endif; ?>

        </div>

    </div>

</div>
