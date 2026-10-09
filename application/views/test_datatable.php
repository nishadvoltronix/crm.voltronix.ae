<!DOCTYPE html>
<html>
<head>
    <title>Jobs</title>

    <link rel="stylesheet" href="<?php echo base_url('include/dist/assets/css/jquery.dataTables.min.css'); ?>">
</head>
<body>

<table id="jobsTable" class="table table-striped table-bordered">

    <thead>
        <tr>
            <th>Date Created</th>
            <th>Job ID</th>
            <th>Job Date</th>
            <th>Account Name</th>
            <th>Status</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($records as $row): ?>
        <tr>
            <td><?= $row['created_at']; ?></td>
            <td><?= $row['job_deal_number']; ?></td>
            <td><?= $row['job_deal_date']; ?></td>
            <td><?= $row['account_name']; ?></td>
            <td><?= $row['status']; ?></td>
            <td><?= number_format($row['service_charge'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script src="<?php echo base_url('include/dist/assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/jquery.dataTables.min.js'); ?>"></script>

<script>
$(function () {
    $('#jobsTable').DataTable({
        searching: true,
        paging: true,
        ordering: true,
        info: true
    });
});
</script>

</body>
</html>
