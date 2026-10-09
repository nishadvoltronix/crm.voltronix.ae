<?php if ($this->rbac->can('dashboard.view')): ?>
<!-- [ Enhanced KPI Cards ] start -->
          <div class="col-md-6 col-xl-3">
            <div class="card bg-brand-color-1">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="flex-grow-1">
                    <h6 class="mb-2 text-white">Total Won Jobs</h6>
                    <h2 class="text-white mb-0 f-w-300"><?php echo $total_won_jobs_admin; ?></h2>
                    <p class="text-white mb-0">
                      Till date
                    </p>
                  </div>
                  <div class="flex-shrink-0">
                      <i class="ph ph-briefcase text-white" style="font-size: 60px;"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-xl-3">
            <div class="card bg-brand-color-golden">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="flex-grow-1">
                    <h6 class="mb-2 text-white">Pending Department Assign</h6>
                    <h2 class="text-white mb-0 f-w-300"><?php echo $pending_jobs_assign_admin; ?></h2>
                    <p class="text-white mb-0">
                      Till date
                    </p>
                  </div>
                  <div class="flex-shrink-0">
                    <i class="ti ti-hierarchy text-white" style="font-size: 60px;"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-xl-3">
            <div class="card bg-brand-color-2">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="flex-grow-1">
                    <h6 class="mb-2 text-white">Pending Accounts Clearance</h6>
                    <h2 class="text-white mb-0 f-w-300"><?= $accounts_summary['total_pending']; ?></h2>
                    <p class="text-white mb-0">
                      Against <?= $accounts_summary['pending_jobs'] ?? 0; ?> jobs
                    </p>
                  </div>
                  <div class="flex-shrink-0">
                    <i class="ti ti-currency-dirham text-white" style="font-size: 60px;"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-xl-3">
            <div class="card bg-brand-color-green">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="flex-grow-1">
                    <h6 class="mb-2 text-white">Complete Jobs</h6>
                    <h2 class="text-white mb-0 f-w-300"><?php echo $completed_jobs_assign_departments_admin; ?></h2>
                    <p class="text-white mb-0">
                      Till date
                    </p>
                  </div>
                  <div class="flex-shrink-0">
                    <i class="ph ph-flag text-white" style="font-size: 60px;"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- [ Enhanced KPI Cards ] end -->
          <!-- [ Real-time Analytics ] end -->

          <!-- [ Deals Overview ] start -->
          <div class="col-xl-4">
            <div class="card">
              <div class="card-header">
                <h5>Deals Overview</h5>
              </div>
              <div class="card-body">
                <div id="lead-pipeline-chart" style="height: 200px;"></div>
                <div class="row mt-3">
                  <div class="col-12 pt-3 pb-3 border-top">
                    <div class="d-flex align-items-center justify-content-between">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-desktop text-primary me-2 f-18"></i>
                        Qualification
                      </span>
                      <span class="fw-bold chart-value" data-label="Qualification"><?php echo $pending_percentage;?>%</span>
                    </div>
                    <div class="progress mt-2" style="height: 4px;">
                      <div class="progress-bar bg-primary" style="width: <?php echo $pending_percentage;?>%"></div>
                    </div>
                  </div>
                  <div class="col-12 pt-3 pb-3 border-top">
                    <div class="d-flex align-items-center justify-content-between">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-device-mobile text-success me-2 f-18"></i>
                        Site Visit
                      </span>
                      <span class="fw-bold chart-value" data-label="Site Visit"><?php echo $site_visit_percentage;?>%</span>
                    </div>
                    <div class="progress mt-2" style="height: 4px;">
                      <div class="progress-bar bg-success" style="width: <?php echo $site_visit_percentage;?>%"></div>
                    </div>
                  </div>
                  <div class="col-12 pt-3 pb-3 border-top">
                    <div class="d-flex align-items-center justify-content-between">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-device-mobile text-success me-2 f-18"></i>
                        Proposal
                      </span>
                      <span class="fw-bold chart-value" data-label="Proposal"><?php echo $proposal_percentage;?>%</span>
                    </div>
                    <div class="progress mt-2" style="height: 4px;">
                      <div class="progress-bar bg-success" style="width: <?php echo $proposal_percentage;?>%"></div>
                    </div>
                  </div>
                  <div class="col-12 pt-3 pb-3 border-top">
                    <div class="d-flex align-items-center justify-content-between">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-device-mobile text-success me-2 f-18"></i>
                        Closed to Won
                      </span>
                      <span class="fw-bold chart-value" data-label="Closed to Won"><?php echo $close_to_won_percentage;?>%</span>
                    </div>
                    <div class="progress mt-2" style="height: 4px;">
                      <div class="progress-bar bg-yellow-500" style="width: <?php echo $close_to_won_percentage;?>%"></div>
                    </div>
                  </div>
                  <div class="col-12 pt-3 pb-3 border-top">
                    <div class="d-flex align-items-center justify-content-between">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-device-mobile text-dangers me-2 f-18"></i>
                        Ommitted
                      </span>
                      <span class="fw-bold chart-value" data-label="Omitted"><?php echo $ommitted_percentage;?>%</span>
                    </div>
                    <div class="progress mt-2" style="height: 4px;">
                      <div class="progress-bar bg-dangers" style="width: <?php echo $ommitted_percentage;?>%"></div>
                    </div>
                  </div>
                  <div class="col-12 pt-3 border-top">
                    <div class="d-flex align-items-center justify-content-between">
                      <span class="d-flex align-items-center">
                        <i class="ph ph-device-tablet text-secondary me-2 f-18"></i>
                        Big Project & Others
                      </span>
                      <span class="fw-bold chart-value" data-label="Big Projects"><?php echo $big_project_percentage;?>%</span>
                    </div>
                    <div class="progress mt-2" style="height: 4px;">
                      <div class="progress-bar bg-secondary" style="width: <?php echo $big_project_percentage;?>%"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- [ Device Analytics ] end -->

          <!-- [ Interactive World Map ] start -->
          <div class="col-xl-8">
            <div class="card">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h5>User Workload Matrix</h5>
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-outline-primary btn-sm">
                    <i class="ph ph-download-simple me-1"></i>Export
                  </button>
                  <button type="button" class="btn btn-primary btn-sm">
                    <i class="ph ph-plus me-1"></i>Add New
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <div class="dt-responsive">
                  <table id="UsersTable" class="table table-hover mb-0 w-100" id="advanced-table">
                    <thead>
                      <tr>
                        <th>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="select-all">
                          </div>
                        </th>
                        <th>Employee Name</th>
                        <th>No. of Electrical</th>
                        <th>No. of Civil</th>
                        <th>No. of PM</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($records as $row): ?>
                      <tr>
                        <td>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox">
                          </div>
                        </td>
                        <td>
                          <div class="d-flex align-items-center">
                            <div>
                              <h6 class="text-muted"><?= htmlspecialchars($row['name']) ?></h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div>
                            <h6 class="badge bg-danger"><?= $row['electrical_count'] ?></h6>
                          </div>
                        </td>
                        <td>
                          <h6 class="badge bg-success"><?= $row['civil_count'] ?></h6>
                        </td>
                        <td>
                          <h6 class="badge bg-warning"><?= $row['pm_count'] ?></h6>
                        </td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary">
                              <i class="ph ph-eye"></i>
                            </button>
                          </div>
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


          <div class="col-xl-8">
            <div class="card">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h5>Department Progress</h5>
              </div>
              <div class="card-body" style="background-color: #F4F7FA !important;">
                <div class="row">
                  <div class="col-md-4">
                    <div class="card Active-visitor">
                      <div class="card-body text-center">
                        <h4 class="mb-3">Electrical</h4>
                        <i class="ph ph-lightning f-60 text-success"></i>
                        <h2 class="f-w-300 mt-3"><?php echo $count_total_electrical_department_assigned; ?></h2>
                        <span class="text-muted">Total Assigned</span>
                        <div class="progress mt-4 m-b-40">
                          <div
                            class="progress-bar bg-brand-color-1"
                            role="progressbar"
                            style="width: 75%; height: 7px"
                            aria-valuenow="75"
                            aria-valuemin="0"
                            aria-valuemax="100"
                          ></div>
                        </div>
                        <div class="row card-active">
                          <div class="col-md-3 col-6">
                            <h5><?php echo $count_total_electrical_department_status_assigned; ?></h5>
                            <span class="text-muted" style="font-size: 9px;">Pending</span>
                          </div>
                          <div class="col-md-3 col-6">
                            <h5><?php echo $count_total_electrical_department_status_progress; ?></h5>
                            <span class="text-muted" style="font-size: 9px;">Progress</span>
                          </div>
                          <div class="col-md-3 col-12">
                            <h5><?php echo $count_total_electrical_department_status_completed; ?></h5>
                            <span class="text-muted" style="font-size: 9px;">Completed</span>
                          </div>
                          <div class="col-md-3 col-12">
                            <h5><?php echo $count_total_electrical_department_status_hold; ?></h5>
                            <span class="text-muted" style="font-size: 9px;">Hold</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card Active-visitor">
                      <div class="card-body text-center">
                        <h5 class="mb-3">Civil</h5>
                        <i class="ph ph-buildings f-60 text-success"></i>
                        <h2 class="f-w-300 mt-3"><?php echo $count_total_civil_department_assigned; ?></h2>
                        <span class="text-muted">Total Assigned</span>
                        <div class="progress mt-4 m-b-40">
                          <div
                            class="progress-bar bg-brand-color-1"
                            role="progressbar"
                            style="width: 75%; height: 7px"
                            aria-valuenow="75"
                            aria-valuemin="0"
                            aria-valuemax="100"
                          ></div>
                        </div>
                        <div class="row card-active">
                          <div class="col-md-3 col-6">
                            <h5><?php echo $count_total_civil_department_status_assigned; ?></h5>
                            <span class="text-muted" style="font-size: 9px;">Pending</span>
                          </div>
                          <div class="col-md-3 col-6">
                            <h5><?php echo $count_total_civil_department_status_progress; ?></h5>
                            <span class="text-muted" style="font-size: 9px;">Progress</span>
                          </div>
                          <div class="col-md-3 col-12">
                            <h5><?php echo $count_total_civil_department_status_completed; ?></h5>
                            <span class="text-muted" style="font-size: 9px;">Completed</span>
                          </div>
                          <div class="col-md-3 col-12">
                            <h5><?php echo $count_total_civil_department_status_hold; ?></h5>
                            <span class="text-muted" style="font-size: 9px;">Hold</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card Active-visitor">
                      <div class="card-body text-center">
                        <h5 class="mb-3">Project Manager</h5>
                        <i class="ph ph-user-gear f-60 text-success"></i>
                        <h2 class="f-w-300 mt-3"><?php echo $count_total_pm_department_assigned; ?></h2>
                        <span class="text-muted">Total Assigned</span>
                        <div class="progress mt-4 m-b-40">
                          <div
                            class="progress-bar bg-brand-color-1"
                            role="progressbar"
                            style="width: 75%; height: 7px"
                            aria-valuenow="75"
                            aria-valuemin="0"
                            aria-valuemax="100"
                          ></div>
                        </div>
                        <div class="row card-active">
                          <div class="col-md-3 col-6">
                            <h5><?php echo $count_total_pm_department_status_assigned; ?></h5>
                            <span class="text-muted" style="font-size: 9px;">Pending</span>
                          </div>
                          <div class="col-md-3 col-6">
                            <h5><?php echo $count_total_pm_department_status_progress; ?></h5>
                            <span class="text-muted" style="font-size: 9px;">Progress</span>
                          </div>
                          <div class="col-md-3 col-12">
                            <h5><?php echo $count_total_pm_department_status_completed; ?></h5>
                            <span class="text-muted" style="font-size: 9px;">Completed</span>
                          </div>
                          <div class="col-md-3 col-12">
                            <h5><?php echo $count_total_pm_department_status_hold; ?></h5>
                            <span class="text-muted" style="font-size: 9px;">Hold</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- [ Interactive World Map ] end -->

          <!-- [ Sentiment Analysis & Quick Stats ] start -->
          <div class="col-xl-4">
            <div class="card bg-brand-color-2">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col-auto">
                    <i class="ti ti-discount-check-filled text-success" style="font-size: 60px; color: #fff !important;"></i>
                  </div>
                  <div class="col">
                    <h2 class="text-white f-w-300"><?php echo $count_todays_leads; ?></h2>
                    <h5 class="text-white">Today's Leads</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="card bg-brand-color-dark">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col-auto">
                    <i class="ti ti-moneybag-plus text-success" style="font-size: 60px; color: #fff !important;"></i>
                  </div>
                  <div class="col">
                    <h2 class="text-white f-w-300">30</h2>
                    <h5 class="text-white">Cleared Accounts</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="card bg-brand-color-1">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col-auto">
                    <i class="ti ti-calendar-week text-success" style="font-size: 60px; color: #fff !important;"></i>
                  </div>
                  <div class="col">
                    <h2 class="text-white f-w-300"><?php echo $count_monthly_leads; ?></h2>
                    <h5 class="text-white">Total Leads this Month</h5>
                  </div>
                </div>
              </div>
            </div>
            </div>
            
          </div>
          
          <!-- [ Daily Feed ] end -->


<script>

document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    var options = {
      chart: {
        height: 220,
        type: 'pie'
      },
      dataLabels: {
        enabled: false
      },
      series: [23, 35, 28],
      colors: ['#1de9b6', '#a389d4', '#04a9f5'],
      labels: ['Desktop', 'Mobile', 'Tablet'],
      legend: {
        show: false
      }
    };
    var chart = new ApexCharts(document.querySelector('#lead-pipeline-chart1'), options);
    chart.render();
  }, 500);
});

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {

        let series = [];
        let labels = [];

        document.querySelectorAll('.chart-value').forEach(el => {
            series.push(parseFloat(el.innerText));
            labels.push(el.dataset.label);
        });

        var options = {
            chart: {
                height: 220,
                type: 'pie'
            },
            dataLabels: {
                enabled: false
            },
            series: series,
            labels: labels,
            colors: ['#1de9b6', '#a389d4', '#04a9f5'],
            legend: {
                show: false
            }
        };

        new ApexCharts(
            document.querySelector('#lead-pipeline-chart1'),
            options
        ).render();

    }, 500);
});
</script>

<script>
const STATUS_COLORS = {
    'Qualification': '#1ABC9C',
    'Site Visit': '#FF9800',
    'Proposal': '#00BCD4',
    'Closed to Won': '#4CAF50',
    'Omitted': '#DC2626',
    'Big Projects': '#9E9E9E'
};
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const chartEl = document.querySelector('#lead-pipeline-chart');
    const valueEls = document.querySelectorAll('.chart-value');

    if (!chartEl || valueEls.length === 0) return;

    let series = [];
    let labels = [];
    let colors = [];

    valueEls.forEach(el => {
        const value = parseFloat(el.textContent.trim());
        const label = el.getAttribute('data-label');

        if (!isNaN(value) && label) {
            series.push(value);
            labels.push(label);

            // 🎨 assign color per label
            colors.push(
                STATUS_COLORS[label] || '#cccccc' // fallback color
            );
        }
    });

    var options = {
        chart: {
            height: 220,
            type: 'donut'
        },
        plotOptions: {
            pie: {
             donut: {
              size: '80%'   // ↑ bigger hole = thinner ring
             }
            }
        },
        dataLabels: {
            enabled: false
        },
        series: series,
        labels: labels,
        colors: colors,
        legend: {
            show: false
        }
    };

    new ApexCharts(chartEl, options).render();
});
</script>
<script src="<?php echo base_url('include/dist/assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/jquery.dataTables.min.js'); ?>"></script>
<script>
$(function () {
    $('#UsersTable').DataTable({
        searching: true,
        paging: true,
        ordering: true,
        info: true,
        order: [[0, 'desc']]
    });
});
</script>
<?php endif; ?>

<?php if ($this->rbac->can('electric_dashboard.view')): ?>
<div class="row">
<!-- [ Electric Count section ] start -->
          <h4>Electrical</h4>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Electrical/Pending_Electrical_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_pending_electrical_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Pending</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-hourglass f-30 text-white bg-danger"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Electrical/Process_Electrical_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_process_electrical_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Under Process</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-spinner f-30 text-white bg-purple"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Electrical/Completed_Electrical_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_completed_electrical_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Completed</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-seal-check f-30 text-white bg-brand-color-1"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Electrical/Hold_Electrical_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_hold_electrical_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Hold</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-pause-circle f-30 text-white bg-dangers"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <!-- [ Electric Count section ] end -->
</div>

<div class="row">

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-2 assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-calendar-check text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Assigned Today</h5>
                <h3 class="text-white f-w-300"><?php echo $total_assigned_today_electrical_jobs_count; ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-1 assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-chart-line-up text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Completed This Month</h5>
                <h3 class="text-white f-w-300"><?php echo $total_completed_this_month_electrical_jobs_count; ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-golden assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-stack text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Jobs</h5>
                <h3 class="text-white f-w-300"><?php echo $total_electrical_jobs_assigned_to_user; ?></h3>
              </div>
            </div>
          </div>

</div>
<?php endif; ?>

<?php if ($this->rbac->can('civil_dashboard.view')): ?>
<div class="row">
<!-- [ Civil Count section ] start -->
          <h4>Civil</h4>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Civil/Pending_Civil_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_pending_civil_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Pending</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-hourglass f-30 text-white bg-danger"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Civil/Process_Civil_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_process_civil_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Under Process</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-spinner f-30 text-white bg-purple"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Civil/Completed_Civil_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_completed_civil_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Completed</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-seal-check f-30 text-white bg-brand-color-1"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Civil/Hold_Civil_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_hold_civil_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Hold</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-pause-circle f-30 text-white bg-dangers"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <!-- [ Civil Count section ] end -->
</div>

<div class="row">

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-2 assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-calendar-check text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Assigned Today</h5>
                <h3 class="text-white f-w-300"><?php echo $total_assigned_today_civil_jobs_count; ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-1 assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-chart-line-up text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Completed This Month</h5>
                <h3 class="text-white f-w-300"><?php echo $total_completed_this_month_civil_jobs_count; ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-golden assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-stack text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Jobs</h5>
                <h3 class="text-white f-w-300"><?php echo $total_civil_jobs_assigned_to_user; ?></h3>
              </div>
            </div>
          </div>

</div>
<?php endif; ?>

<?php if ($this->rbac->can('pm_dashboard.view')): ?>
<div class="row">
<!-- [ PM Count section ] start -->
          <h4>Project Manager</h4>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Project_Manager/Pending_Project_Manager_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_pending_pm_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Pending</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-hourglass f-30 text-white bg-danger"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Project_Manager/Process_Project_Manager_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_process_pm_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Under Process</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-spinner f-30 text-white bg-purple"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Project_Manager/Completed_Project_Manager_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_completed_pm_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Completed</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-seal-check f-30 text-white bg-brand-color-1"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Project_Manager/Hold_Project_Manager_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_hold_pm_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Hold</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-pause-circle f-30 text-white bg-dangers"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <!-- [ PM Count section ] end -->
</div>

<div class="row">

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-2 assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-calendar-check text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Assigned Today</h5>
                <h3 class="text-white f-w-300"><?php echo $total_assigned_today_pm_jobs_count; ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-1 assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-chart-line-up text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Completed This Month</h5>
                <h3 class="text-white f-w-300"><?php echo $total_completed_this_month_pm_jobs_count; ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-golden assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-stack text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Jobs</h5>
                <h3 class="text-white f-w-300"><?php echo $total_pm_jobs_assigned_to_user; ?></h3>
              </div>
            </div>
          </div>

</div>
<?php endif; ?>

<?php if ($this->rbac->can('switchgear_dashboard.view')): ?>
<div class="row">
<!-- [ PM Count section ] start -->
          <h4>Switchgear</h4>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Switchgear/Pending_Switchgear_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_pending_swt_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Pending</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-hourglass f-30 text-white bg-danger"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Switchgear/Process_Switchgear_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_process_swt_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Under Process</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-spinner f-30 text-white bg-purple"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Switchgear/Completed_Switchgear_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_completed_swt_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Completed</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-seal-check f-30 text-white bg-brand-color-1"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Switchgear/Hold_Switchgear_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_hold_swt_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Hold</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-pause-circle f-30 text-white bg-dangers"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <!-- [ PM Count section ] end -->
</div>

<div class="row">

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-2 assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-calendar-check text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Assigned Today</h5>
                <h3 class="text-white f-w-300"><?php echo $total_assigned_today_swt_jobs_count; ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-1 assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-chart-line-up text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Completed This Month</h5>
                <h3 class="text-white f-w-300"><?php echo $total_completed_this_month_swt_jobs_count; ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-golden assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-stack text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Jobs</h5>
                <h3 class="text-white f-w-300"><?php echo $total_swt_jobs_assigned_to_user; ?></h3>
              </div>
            </div>
          </div>

</div>
<?php endif; ?>

<?php if ($this->rbac->can('maintenance_dashboard.view')): ?>
<div class="row">
<!-- [ PM Count section ] start -->
          <h4>Maintenance</h4>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Maintenance/Pending_Maintenance_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_pending_mtn_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Pending</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-hourglass f-30 text-white bg-danger"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Maintenance/Process_Maintenance_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_process_mtn_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Under Process</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-spinner f-30 text-white bg-purple"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Maintenance/Completed_Maintenance_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_completed_mtn_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Completed</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-seal-check f-30 text-white bg-brand-color-1"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl-3">
            <a href="<?php echo base_url();?>index.php/Maintenance/Hold_Maintenance_Jobs">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $total_hold_mtn_jobs_count; ?></h2>
                    <h5 class="text-muted mb-0">Hold</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-pause-circle f-30 text-white bg-dangers"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <!-- [ PM Count section ] end -->
</div>

<div class="row">

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-2 assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-calendar-check text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Assigned Today</h5>
                <h3 class="text-white f-w-300"><?php echo $total_assigned_today_mtn_jobs_count; ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-1 assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-chart-line-up text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Completed This Month</h5>
                <h3 class="text-white f-w-300"><?php echo $total_completed_this_month_mtn_jobs_count; ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-golden assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-stack text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Jobs</h5>
                <h3 class="text-white f-w-300"><?php echo $total_mtn_jobs_assigned_to_user; ?></h3>
              </div>
            </div>
          </div>

</div>
<?php endif; ?>

<?php if ($this->rbac->can('sales_dashboard.view')): ?>
<div class="row">
<!-- [ Sales Count section ] start -->
          <h4>Sales</h4>
          <div class="col-md-6 col-xl">
            <a href="<?php echo base_url();?>index.php/Admincrm/Pipeline_Dashboard">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $pending_qualification_count; ?></h2>
                    <h5 class="text-muted mb-0">Qualification</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-clock-countdown f-30 text-white bg-primary"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          
          <div class="col-md-6 col-xl">
            <a href="<?php echo base_url();?>index.php/Admincrm/Pipeline_Dashboard">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $pending_site_visit_count; ?></h2>
                    <h5 class="text-muted mb-0">Site Visit</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-map-pin f-30 text-white bg-danger"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl">
            <a href="<?php echo base_url();?>index.php/Admincrm/Pipeline_Dashboard">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $pending_proposal_count; ?></h2>
                    <h5 class="text-muted mb-0">Proposal</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-note-pencil f-30 text-white bg-green-500"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl">
            <a href="<?php echo base_url();?>index.php/Admincrm/Pipeline_Dashboard">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $pending_won_count; ?></h2>
                    <h5 class="text-muted mb-0">Won</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph ph-trophy f-30 text-white bg-yellow-500"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl">
            <a href="<?php echo base_url();?>index.php/Admincrm/Pipeline_Dashboard">
            <div class="card card-customer">
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col">
                    <h2 class="mb-2 f-w-300"><?php echo $pending_ommitted_count; ?></h2>
                    <h5 class="text-muted mb-0">Lost</h5>
                  </div>
                  <div class="col-auto">
                    <i class="ph ph-x-circle f-30 text-white bg-pink-500"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
          <!-- [ Sales Count section ] end -->
</div>

<div class="row">

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-2 assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-calendar-check text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Assigned Today</h5>
                <h3 class="text-white f-w-300"><?php echo $tasks_assigned_leads_today; ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-1 assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-chart-line-up text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Assigned This Month</h5>
                <h3 class="text-white f-w-300"><?php echo $tasks_assigned_leads_month; ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-xl-4">
            <div class="card bg-brand-color-golden assets-value">
              <div class="bg-img"></div>
              <div class="card-body text-center">
                <i class="ph ph-stack text-white f-30"></i>
                <h5 class="text-white m-t-20 m-b-15">Total Leads Assigned</h5>
                <h3 class="text-white f-w-300"><?php echo $tasks_assigned_leads_count_user; ?></h3>
              </div>
            </div>
          </div>

</div>
<?php endif; ?>