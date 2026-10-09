
<html>

 <head>
  <link rel="stylesheet" href="<?php echo base_url('include/dist/assets/css/jquery.dataTables.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('include/dist/assets/css/plugins/dataTables.bootstrap5.min.css'); ?>" />

</head>

<body>
<table id="jobsTable" class="display" style="width:100%">
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
        <?php foreach ($records as $record) { ?>
            <tr>
                <td><?= $record['created_at']; ?></td>
                <td><?= $record['job_deal_number']; ?></td>
                <td><?= $record['job_deal_date']; ?></td>
                <td><?= $record['account_name']; ?></td>
                <td><?= $record['status']; ?></td>
                <td><?= number_format($record['service_charge'], 2); ?></td>
            </tr>
        <?php } ?>
    </tbody>

    <tfoot>
        <tr>
            <th>Date Created</th>
            <th>Job ID</th>
            <th>Job Date</th>
            <th>Account Name</th>
            <th>Status</th>
            <th>Amount</th>
        </tr>
    </tfoot>
</table>

<script src="<?php echo base_url('include/dist/assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/jquery.dataTables.min.js'); ?>"></script>

<script>
$(document).ready(function () {
    $('#jobsTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        pageLength: 10
    });
});
</script>

</body>



</html>