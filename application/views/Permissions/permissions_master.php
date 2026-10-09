<?php
$this->rbac->require('permissions.manage');

/*
Controller provides:
$permissions
$permission_groups
$edit_permission (optional)
*/
?>

<style>
.form-box {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,.06);
}
</style>

<div class="row">

    <!-- LEFT: CREATE / EDIT -->
    <div class="col-md-4">

        <div class="form-box">
            <h5 class="mb-3">
                <?= isset($edit_permission) ? 'Edit Permission' : 'Create Permission' ?>
            </h5>

            <form method="post" action="<?= site_url('index.php/Permissions/permission_save') ?>">

                <?php if (isset($edit_permission)): ?>
                    <input type="hidden" name="id" value="<?= $edit_permission->id ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Permission Key</label>
                    <input type="text"
                           name="key"
                           class="form-control"
                           <?= isset($edit_permission) ? 'readonly' : 'required' ?>
                           value="<?= isset($edit_permission) ? html_escape($edit_permission->key) : '' ?>"
                           placeholder="e.g. employees.read">
                    <small class="text-muted">Cannot be changed later</small>
                </div>

                <div class="form-group">
                    <label>Label</label>
                    <input type="text"
                           name="label"
                           class="form-control"
                           required
                           value="<?= isset($edit_permission) ? html_escape($edit_permission->label) : '' ?>">
                </div>

                <div class="form-group">
                    <label>Permission Group</label>
                    <select name="group_id" class="form-control" required>
                        <option value="">-- Select Group --</option>
                        <?php foreach ($permission_groups as $g): ?>
                            <option value="<?= $g->id ?>"
                                <?= isset($edit_permission) && $edit_permission->group_id == $g->id ? 'selected' : '' ?>>
                                <?= html_escape($g->label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button class="btn btn-primary btn-block">
                    <?= isset($edit_permission) ? 'Update Permission' : 'Create Permission' ?>
                </button>

                <?php if (isset($edit_permission)): ?>
                    <a href="<?= site_url('index.php/Permissions/permissions_master') ?>"
                       class="btn btn-link btn-block">
                        Cancel Edit
                    </a>
                <?php endif; ?>

            </form>
        </div>

    </div>

    <!-- RIGHT: PERMISSIONS LIST -->
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <strong>Permissions</strong>
            </div>

            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Key</th>
                            <th>Label</th>
                            <th>Group</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (!empty($permissions)): foreach ($permissions as $p): ?>
                        <tr>
                            <td><code><?= html_escape($p->key) ?></code></td>
                            <td><?= html_escape($p->label) ?></td>
                            <td><?= html_escape($p->group_label) ?></td>
                            <td>
                                <a href="<?= site_url('index.php/Permissions/permissions_master_edit/'.$p->id) ?>"
                                   class="btn btn-outline-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>

                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No permissions found
                            </td>
                        </tr>

                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
