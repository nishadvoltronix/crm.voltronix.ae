<?php
$this->rbac->require('permissions.manage');

/*
Controller provides:
$groups
$edit_group (optional)
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
                <?= isset($edit_group) ? 'Edit Permission Group' : 'Create Permission Group' ?>
            </h5>

            <form method="post" action="<?= site_url('index.php/Permissions/permission_group_save') ?>">

                <?php if (isset($edit_group)): ?>
                    <input type="hidden" name="id" value="<?= $edit_group->id ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Group Key</label>
                    <input type="text"
                           name="key"
                           class="form-control"
                           <?= isset($edit_group) ? 'readonly' : 'required' ?>
                           value="<?= isset($edit_group) ? html_escape($edit_group->key) : '' ?>"
                           placeholder="e.g. employees">
                    <small class="text-muted">Cannot be changed later</small>
                </div>

                <div class="form-group">
                    <label>Label</label>
                    <input type="text"
                           name="label"
                           class="form-control"
                           required
                           value="<?= isset($edit_group) ? html_escape($edit_group->label) : '' ?>">
                </div>

                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number"
                           name="sort_order"
                           class="form-control"
                           value="<?= isset($edit_group) ? $edit_group->sort_order : 0 ?>">
                </div>

                <button class="btn btn-primary btn-block">
                    <?= isset($edit_group) ? 'Update Group' : 'Create Group' ?>
                </button>

                <?php if (isset($edit_group)): ?>
                    <a href="<?= site_url('index.php/Permissions/permission_groups') ?>"
                       class="btn btn-link btn-block">
                        Cancel Edit
                    </a>
                <?php endif; ?>

            </form>
        </div>

    </div>

    <!-- RIGHT: GROUPS LIST -->
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <strong>Permission Groups</strong>
            </div>

            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Key</th>
                            <th>Label</th>
                            <th>Order</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (!empty($groups)): foreach ($groups as $g): ?>
                        <tr>
                            <td><code><?= html_escape($g->key) ?></code></td>
                            <td><?= html_escape($g->label) ?></td>
                            <td><?= (int)$g->sort_order ?></td>
                            <td>
                                <a href="<?= site_url('index.php/Permissions/permission_groups_edit/'.$g->id) ?>"
                                   class="btn btn-outline-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>

                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No permission groups found
                            </td>
                        </tr>

                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
