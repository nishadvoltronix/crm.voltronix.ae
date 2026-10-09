<style>
.report-card {
    border: 1px solid #eef0f4;
    border-radius: 14px;
    background: #fff;
    padding: 20px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.04);
}

.report-icon {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.report-value {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 0;
}

.report-label {
    color: #6c757d;
    font-size: 13px;
}

.chart-box {
    border: 1px solid #eef0f4;
    border-radius: 14px;
    background: #fff;
    padding: 20px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.04);
    min-height: 340px;
}

.table-card {
    border: 1px solid #eef0f4;
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 4px 14px rgba(0,0,0,0.04);
}

.table th {
    font-size: 12px;
    white-space: nowrap;
    vertical-align: middle;
}

.table td {
    font-size: 13px;
    vertical-align: middle;
    white-space: nowrap;
}

.text-green {
    color: #0ead69;
    font-weight: 600;
}

.text-red {
    color: #ff4d4f;
    font-weight: 600;
}
</style>

<?php
$total_deals = (int)($summary['total_deals'] ?? 0);
$won_jobs = (int)($summary['won_jobs'] ?? 0);
$win_rate = $total_deals > 0 ? ($won_jobs / $total_deals) * 100 : 0;

$stage_chart = $stage_chart ?? [];
$job_chart = $job_chart ?? [];
$monthly_amount_chart = $monthly_amount_chart ?? [];
?>

<div class="row mb-3">
    <div class="col-md-8">
        <h4 class="fw-bold mb-1">Employee Performance Report</h4>
        <div class="text-muted">
            Reports <i class="ti ti-chevron-right mx-1"></i>
            Employees <i class="ti ti-chevron-right mx-1"></i>
            Employee Performance
        </div>
    </div>

    <div class="col-md-4 text-end">
        <form method="GET" action="<?= base_url('index.php/Reports/employee_performance'); ?>" class="d-flex gap-2 justify-content-end">
            <input type="date" name="date_from" class="form-control form-control-sm" value="<?= htmlspecialchars($date_from); ?>">
            <input type="date" name="date_to" class="form-control form-control-sm" value="<?= htmlspecialchars($date_to); ?>">
            <button type="submit" class="btn btn-sm btn-primary">
                Filter
            </button>
        </form>
    </div>
</div>

<div class="row g-3 mb-3">

    <div class="col-md-2">
        <div class="report-card">
            <div class="d-flex align-items-center gap-3">
                <div class="report-icon bg-primary-subtle text-primary">
                    <i class="ti ti-users fs-3"></i>
                </div>
                <div>
                    <div class="report-label">Total Employees</div>
                    <p class="report-value"><?= number_format($summary['total_employees']); ?></p>
                    <small class="text-muted">Active Employees</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="report-card">
            <div class="d-flex align-items-center gap-3">
                <div class="report-icon bg-success-subtle text-success">
                    <i class="ti ti-briefcase fs-3"></i>
                </div>
                <div>
                    <div class="report-label">Total Deals</div>
                    <p class="report-value"><?= number_format($summary['total_deals']); ?></p>
                    <small class="text-muted">All Stages</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="report-card">
            <div class="d-flex align-items-center gap-3">
                <div class="report-icon bg-warning-subtle text-warning">
                    <i class="ti ti-trophy fs-3"></i>
                </div>
                <div>
                    <div class="report-label">Won Jobs</div>
                    <p class="report-value"><?= number_format($summary['won_jobs']); ?></p>
                    <small class="text-muted"><?= number_format($win_rate, 2); ?>% Win Rate</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="report-card">
            <div class="d-flex align-items-center gap-3">
                <div class="report-icon bg-purple text-white">
                    <i class="ti ti-cash fs-3"></i>
                </div>
                <div>
                    <div class="report-label">Total Won Amount</div>
                    <p class="report-value">AED <?= number_format($summary['total_won_amount'], 2); ?></p>
                    <small class="text-muted">Closed Won Deals</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-1">
        <div class="report-card text-center">
            <div class="report-label">Active</div>
            <p class="report-value text-success"><?= number_format($summary['active_jobs']); ?></p>
        </div>
    </div>

    <div class="col-md-2">
        <div class="report-card text-center">
            <div class="report-label">Hold Jobs</div>
            <p class="report-value text-danger"><?= number_format($summary['hold_jobs']); ?></p>
            <small class="text-muted">On Hold</small>
        </div>
    </div>

</div>

<div class="row g-3 mb-3">

    <div class="col-md-4">
        <div class="chart-box">
            <h6 class="fw-bold mb-3">Deals by Stage</h6>
            <canvas id="stageChart" height="230"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="chart-box">
            <h6 class="fw-bold mb-3">Job Status Overview</h6>
            <canvas id="jobChart" height="230"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="chart-box">
            <h6 class="fw-bold mb-3">Total Won Amount by Month</h6>
            <canvas id="amountChart" height="230"></canvas>
        </div>
    </div>

</div>

<div class="table-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Employee Performance Details</h5>
    </div>

    <div class="p-3">
        <div class="table-responsive">
            <table id="employeeReportTable" class="table table-bordered table-hover w-100">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee Name</th>
                        <th>Total Deals</th>
                        <th>Qualification</th>
                        <th>Site Visit</th>
                        <th>Proposal / Price Quote</th>
                        <th>Closed Won</th>
                        <th>Closed Lost</th>
                        <th>Omitted / Proposal Omitted</th>
                        <th>Active Jobs</th>
                        <th>Hold Jobs</th>
                        <th>Closed Jobs</th>
                        <th>Total Won Amount</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; foreach ($records as $row): ?>
                        <tr>
                            <td><?= $i++; ?></td>

                            <td>
                                <strong><?= htmlspecialchars($row['username']); ?></strong>
                                <br>
                                <small class="text-muted">Employee</small>
                            </td>

                            <td><?= number_format($row['total_deals']); ?></td>
                            <td><?= number_format($row['qualification_count']); ?></td>
                            <td><?= number_format($row['site_visit_count']); ?></td>
                            <td><?= number_format($row['proposal_count']); ?></td>

                            <td class="text-green">
                                <?= number_format($row['closed_won_count']); ?>
                            </td>

                            <td class="text-red">
                                <?= number_format($row['closed_lost_count']); ?>
                            </td>

                            <td>
                                <?= number_format($row['omitted_count'] + $row['proposal_omitted_count']); ?>
                            </td>

                            <td><?= number_format($row['active_jobs']); ?></td>

                            <td class="text-red">
                                <?= number_format($row['hold_jobs']); ?>
                            </td>

                            <td class="text-green">
                                <?= number_format($row['closed_jobs']); ?>
                            </td>

                            <td>
                                AED <?= number_format($row['total_won_amount'], 2); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<script src="<?= base_url('include/dist/assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?= base_url('include/dist/assets/js/jquery.dataTables.min.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(function () {
    $('#employeeReportTable').DataTable({
        searching: true,
        paging: true,
        ordering: true,
        info: true,
        pageLength: 10,
        order: [[2, 'desc']]
    });
});
</script>

<script>
const stageData = [
    <?= (int)($stage_chart['qualification'] ?? 0); ?>,
    <?= (int)($stage_chart['site_visit'] ?? 0); ?>,
    <?= (int)($stage_chart['proposal'] ?? 0); ?>,
    <?= (int)($stage_chart['closed_won'] ?? 0); ?>,
    <?= (int)($stage_chart['closed_lost'] ?? 0); ?>,
    <?= (int)($stage_chart['omitted'] ?? 0); ?>
];

new Chart(document.getElementById('stageChart'), {
    type: 'doughnut',
    data: {
        labels: [
            'Qualification',
            'Site Visit',
            'Proposal / Price Quote',
            'Closed Won',
            'Closed Lost',
            'Omitted'
        ],
        datasets: [{
            data: stageData,
            backgroundColor: [
                '#3b82f6',
                '#22c55e',
                '#facc15',
                '#a855f7',
                '#ef4444',
                '#9ca3af'
            ]
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

const jobData = [
    <?= (int)($job_chart['active_jobs'] ?? 0); ?>,
    <?= (int)($job_chart['hold_jobs'] ?? 0); ?>,
    <?= (int)($job_chart['closed_jobs'] ?? 0); ?>
];

new Chart(document.getElementById('jobChart'), {
    type: 'doughnut',
    data: {
        labels: ['Active Jobs', 'Hold Jobs', 'Closed Jobs'],
        datasets: [{
            data: jobData,
            backgroundColor: [
                '#14b8a6',
                '#fbbf24',
                '#9ca3af'
            ]
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

const monthLabels = [
    <?php foreach ($monthly_amount_chart as $m): ?>
        "<?= $m['month_name']; ?>",
    <?php endforeach; ?>
];

const monthAmounts = [
    <?php foreach ($monthly_amount_chart as $m): ?>
        <?= (float)$m['total_amount']; ?>,
    <?php endforeach; ?>
];

new Chart(document.getElementById('amountChart'), {
    type: 'bar',
    data: {
        labels: monthLabels,
        datasets: [{
            label: 'Won Amount',
            data: monthAmounts,
            backgroundColor: '#3b82f6',
            borderRadius: 6
        }]
    },
    options: {
        scales: {
            y: {
                ticks: {
                    callback: function(value) {
                        return 'AED ' + value.toLocaleString();
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>