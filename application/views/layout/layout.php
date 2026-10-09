<!doctype html>
<html lang="en">
  <!-- [Head] start -->

  <head>
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="<?= base_url('include/dist/assets/css/jquery.dataTables.min.css'); ?>">
    
    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url('include/dist/assets/css/plugins/phosphor-icons.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('include/dist/assets/css/plugins/tabler-icons.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('include/dist/assets/css/hrms.css'); ?>" id="main-style-link" />
    <link rel="icon" href="<?php echo base_url('include/dist/assets/images/favicon_voltronix.png');?>" type="image/svg+xml" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?= base_url('include/dist/assets/css/style.css'); ?>">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?= base_url('include/dist/assets/css/select2.min.css'); ?>">

    <!-- OPTIONAL: remove Google font if CSP causes trouble -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"> -->

    <style>
      .file-name-design {
    white-space: normal;
    word-break: break-word;
    overflow-wrap: anywhere;
}
    </style>

</head>

  <!-- [Head] end -->
  <!-- [Body] Start -->

  <body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<!-- [ Pre-loader ] End -->
 <!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="<?php echo base_url(); ?>" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="<?php echo base_url('include/dist/assets/images/logo-voltronix.png'); ?>" class="img-fluid logo-lg" alt="logo" />
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item pc-caption">
  <label data-i18n="Navigation">Navigation</label>
</li>

<li class="pc-item">
  <a href="<?php echo base_url(); ?>" class="pc-link">
    <span class="pc-micon">  <i class="ph ph-house-line"></i> </span><span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
  </a>
</li>
        
<?php if ($this->rbac->can('leads.view') || $this->rbac->can('leads.manage')): ?>
<li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link">
        <span class="pc-micon">
            <i class="ph ph-layout"></i>
        </span>
        <span class="pc-mtext">Leads Pipeline</span>
        <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
    </a>

    <ul class="pc-submenu">

        <?php if ($this->rbac->can('leads.manage')): ?>
        <li class="pc-item">
            <a class="pc-link" href="<?= base_url('index.php/Admincrm/Pipeline_Dashboard') ?>">
                Agents Pipelines
            </a>
        </li>

  

       <li class="pc-item">
            <a class="pc-link" href="<?= base_url('index.php/Admincrm/Admin_Pipeline_Dashboard') ?>">
                <?= $this->session->userdata('admin_name'); ?> Pipeline
            </a>

        </li>

        <li class="pc-item">
            <a class="pc-link" href="<?= base_url('index.php/Admincrm/Search_Agent_Pipeline') ?>">
                Search Agent
            </a>
        </li>

       
        <?php endif; ?>

        <?php if ($this->rbac->can('leads.view')): ?>
        <li class="pc-item" style="display:none;">
            <a class="pc-link" href="<?= base_url('index.php/Admincrm/dealsproposals1') ?>">
                Dashboard
            </a>
        </li>
        <?php endif; ?>

    </ul>
</li>
<?php endif; ?>

<?php if ($this->rbac->can('leads.manage.agents')): ?>
<li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link">
        <span class="pc-micon">
            <i class="ph ph-layout"></i>
        </span>
        <span class="pc-mtext">Leads Pipeline</span>
        <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
    </a>

    <ul class="pc-submenu">

        <li class="pc-item">
            <a class="pc-link" href="<?= base_url('index.php/Admincrm/Pipeline_Dashboard') ?>">
                Pipelines
            </a>
        </li>

    </ul>
</li>
<?php endif; ?>
        
<?php if ($this->rbac->can('deals.manage') || $this->rbac->can('deals.view')): ?>
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon">
      <i class="ph ph-handshake"></i>
    </span>
    <span class="pc-mtext" data-i18n="Deals">Deals</span>
    <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
  </a>
  <ul class="pc-submenu">
    <?php if ($this->rbac->can('deals.manage')): ?>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Admincrm/create_deals" data-i18n="Create Deal">Create Deal</a></li>
    <?php endif; ?>

    <?php if ($this->rbac->can('deals.view')): ?>
    <!--  <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Deals/view_deals">View All Deals</a></li> -->
    <?php endif; ?>
  </ul>
</li>
<?php endif; ?>


<?php if ($this->rbac->can('leads.view') || $this->rbac->can('leads.manage') || $this->rbac->can('leads.manage.agents')): ?>      
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon">
      <i class="ph ph-file-plus"></i>
    </span>
    <span class="pc-mtext" data-i18n="Quotations">Quotations</span>
    <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
  </a>
  <ul class="pc-submenu">
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Admincrm/create_quotation" data-i18n="Create Quotation">Create Quotation</a></li>
    <?php if ($this->rbac->can('leads.view') || $this->rbac->can('leads.manage')): ?>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Admincrm/all_quotations" data-i18n="View All Quotations">View All Quotations</a></li>
    <?php endif; ?>
    <?php if ($this->rbac->can('leads.manage.agents')): ?>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Admincrm/all_quotations" data-i18n="View All Quotations">View All Quotations</a></li>
    <?php endif; ?>
  </ul>
</li>
<?php endif; ?>




<?php if ($this->rbac->can('items.write') || $this->rbac->can('items.view')): ?>
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon">
      <i class="ti ti-file-invoice-filled"></i>
    </span>
    <span class="pc-mtext" data-i18n="Items">Items</span>
    <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
  </a>
  <ul class="pc-submenu">
    <?php if ($this->rbac->can('items.write')): ?>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Admincrm/create_item" data-i18n="Create Items">Create Items</a></li>
    <?php endif; ?>
    <?php if ($this->rbac->can('items.view')): ?>
    <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Items/view_items" data-i18n="View All Items">View All Items</a></li>
    <?php endif; ?>
  </ul>
</li>
<?php endif; ?>

<?php if ($this->rbac->can('dashboard.view')): ?>

<li class="pc-item pc-caption">
  <label data-i18n="Jobs">Jobs</label>
  <i class="ph ph-book-open-text"></i>
</li>

<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon">
      <i class="ti ti-briefcase"></i>
    </span>
    <span class="pc-mtext" data-i18n="Jobs Departments">Jobs Departments</span>
    <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
  </a>
  <ul class="pc-submenu">
    <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Jobs/Pending_Assigning" data-i18n="Pending Assigning">Pending Assigning</a></li>
    <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Jobs/Under_Process_Won_Jobs" data-i18n="Under Process">Under Process</a></li>
    <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Jobs/Completed_Won_Jobs" data-i18n="Completed">Completed</a></li>
    <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Jobs/Hold_Won_Jobs" data-i18n="Hold">Hold</a></li>
    <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Jobs/Closed_Won_Jobs" data-i18n="Closed">Closed</a></li>
    <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Jobs/view_all_jobs" data-i18n="All Jobs">All Jobs</a></li>
  </ul>
</li>
<?php endif; ?>

<?php if ($this->rbac->can('electrical.manage')): ?>
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon">
      <i class="ph ph-lightning"></i>
    </span>
    <span class="pc-mtext" data-i18n="Electrical">Electrical</span>
    <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
  </a>
  <ul class="pc-submenu">
    <?php if ($this->rbac->can('electrical.manage')): ?>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Electrical/Pending_Electrical_Jobs" data-i18n="Pending">Pending</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Electrical/Process_Electrical_Jobs" data-i18n="Process">Process</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Electrical/Completed_Electrical_Jobs" data-i18n="Completed">Completed</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Electrical/Hold_Electrical_Jobs" data-i18n="Hold">Hold</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Electrical/view_all">View All</a></li>
    <?php endif; ?>
  </ul>
</li>
<?php endif; ?>

<?php if ($this->rbac->can('civil.manage')): ?>
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon">
      <i class="ph ph-buildings"></i>
    </span>
    <span class="pc-mtext" data-i18n="Civil">Civil</span>
    <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
  </a>
  <ul class="pc-submenu">
    <?php if ($this->rbac->can('civil.manage')): ?>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Civil/Pending_Civil_Jobs" data-i18n="Pending">Pending</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Civil/Process_Civil_Jobs" data-i18n="Process">Process</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Civil/Completed_Civil_Jobs" data-i18n="Completed">Completed</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Civil/Hold_Civil_Jobs" data-i18n="Hold">Hold</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Civil/view_all">View All</a></li>
    <?php endif; ?>
  </ul>
</li>
<?php endif; ?>

<?php if ($this->rbac->can('project_manager.manage')): ?>
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon">
      <i class="ph ph-user-gear"></i>
    </span>
    <span class="pc-mtext" data-i18n="Project Manager">Project Manager</span>
    <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
  </a>
  <ul class="pc-submenu">
    <?php if ($this->rbac->can('project_manager.manage')): ?>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Project_Manager/Pending_Project_Manager_Jobs" data-i18n="Pending">Pending</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Project_Manager/Process_Project_Manager_Jobs" data-i18n="Process">Process</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Project_Manager/Completed_Project_Manager_Jobs" data-i18n="Completed">Completed</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Project_Manager/Hold_Project_Manager_Jobs" data-i18n="Hold">Hold</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Project_Manager/view_all">View All</a></li>
    <?php endif; ?>
  </ul>
</li>
<?php endif; ?>

<?php if ($this->rbac->can('switchgear.manage')): ?>
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon">
      <i class="ph ph-lightning"></i>
    </span>
    <span class="pc-mtext" data-i18n="Switchgear">Switchgear</span>
    <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
  </a>
  <ul class="pc-submenu">
    <?php if ($this->rbac->can('switchgear.manage')): ?>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Switchgear/Pending_Switchgear_Jobs" data-i18n="Pending">Pending</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Switchgear/Process_Switchgear_Jobs" data-i18n="Process">Process</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Switchgear/Completed_Switchgear_Jobs" data-i18n="Completed">Completed</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Switchgear/Hold_Switchgear_Jobs" data-i18n="Hold">Hold</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Switchgear/view_all">View All</a></li>
    <?php endif; ?>
  </ul>
</li>
<?php endif; ?>

<?php if ($this->rbac->can('maintenance.manage')): ?>
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon">
      <i class="ph ph-wrench"></i>
    </span>
    <span class="pc-mtext" data-i18n="Maintenance">Maintenance</span>
    <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
  </a>
  <ul class="pc-submenu">
    <?php if ($this->rbac->can('maintenance.manage')): ?>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Maintenance/Pending_Maintenance_Jobs" data-i18n="Pending">Pending</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Maintenance/Process_Maintenance_Jobs" data-i18n="Process">Process</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Maintenance/Completed_Maintenance_Jobs" data-i18n="Completed">Completed</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Maintenance/Hold_Maintenance_Jobs" data-i18n="Hold">Hold</a></li>
      <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/Maintenance/view_all">View All</a></li>
    <?php endif; ?>
  </ul>
</li>
<?php endif; ?>
     
<?php if($this->rbac->can('permissions.manage')): ?>
  <li class="pc-item pc-caption">
    <label data-i18n="Settings">Settings</label>
  <i class="ph ph-book-open-text"></i>
</li>
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon">
      <i class="ti ti-settings"></i>
    </span>
    <span class="pc-mtext" data-i18n="Permission & Users">Permission & Users</span>
    <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
  </a>
  <ul class="pc-submenu">
    <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/permissions/users" data-i18n="Users">Users</a></li>
    <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/permissions/permission_assign_departments" data-i18n="Assign Departments">Assign Departments</a></li>
    <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/permissions/permissions_assign" data-i18n="Assign Permissions">Assign Permissions</a></li>
    <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/permissions/permission_groups" data-i18n="Groups">Groups</a></li>
    <li class="pc-item"><a class="pc-link" href="<?php echo base_url();?>index.php/permissions/permissions_master" data-i18n="Permissions">Permissions</a></li>
  </ul>
</li>
<?php endif; ?>

<?php if ($this->rbac->can('dashboard.view')): ?>

<li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link">
        <span class="pc-micon"><i class="ti ti-report-analytics"></i></span><span class="pc-mtext" data-i18n="Reports">Reports</span>
        <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
    <span class="pc-badge" style="background: #198754; width: auto; min-width: 20px; padding: 2px 6px; border-radius: 10px; font-size: 9px; font-weight: 600;">New</span>
    </a>

    <ul class="pc-submenu">

        <li class="pc-item pc-hasmenu">
            <a href="#!" class="pc-link">
                <span class="pc-mtext">Employees</span>
                <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
            </a>

            <ul class="pc-submenu">
                <li class="pc-item">
                    <a class="pc-link" href="<?= base_url('index.php/Reports/employee_performance'); ?>">
                        Employee Performance
                    </a>
                </li>

                <li class="pc-item">
                    <a class="pc-link" href="<?= base_url('index.php/Reports/employee_tasks'); ?>">
                        Employee Tasks
                    </a>
                </li>

                <li class="pc-item">
                    <a class="pc-link" href="<?= base_url('index.php/Reports/department_workload'); ?>">
                        Department Workload
                    </a>
                </li>
            </ul>
        </li>
<!--
        <li class="pc-item pc-hasmenu">
            <a href="#!" class="pc-link">
                <span class="pc-mtext">Jobs</span>
                <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
            </a>

            <ul class="pc-submenu">
                <li class="pc-item">
                    <a class="pc-link" href="<?= base_url('index.php/Reports/all_jobs'); ?>">
                        All Jobs Report
                    </a>
                </li>

                <li class="pc-item">
                    <a class="pc-link" href="<?= base_url('index.php/Reports/won_jobs'); ?>">
                        Won Jobs Report
                    </a>
                </li>

                <li class="pc-item">
                    <a class="pc-link" href="<?= base_url('index.php/Reports/hold_jobs'); ?>">
                        Hold Jobs Report
                    </a>
                </li>
            </ul>
        </li>

        <li class="pc-item pc-hasmenu">
            <a href="#!" class="pc-link">
                <span class="pc-mtext">Finance</span>
                <span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>
            </a>

            <ul class="pc-submenu">
                <li class="pc-item">
                    <a class="pc-link" href="<?= base_url('index.php/Reports/service_charge'); ?>">
                        Service Charge
                    </a>
                </li>

                <li class="pc-item">
                    <a class="pc-link" href="<?= base_url('index.php/Reports/revenue_summary'); ?>">
                        Revenue Summary
                    </a>
                </li>
            </ul>
        </li>

-->

    </ul>
</li>
<?php endif; ?>


      </ul>
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end -->
 <!-- [ Header Topbar ] start -->
<header class="pc-header">
  <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <li class="pc-h-item pc-sidebar-collapse">
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ph ph-list"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ph ph-list"></i>
      </a>
    </li>
    <li class="dropdown pc-h-item">
      <a
        class="pc-head-link dropdown-toggle arrow-none m-0 trig-drp-search"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ph ph-magnifying-glass"></i>
      </a>
      <div class="dropdown-menu pc-h-dropdown drp-search">
        <form class="px-3 py-2">
          <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . ." />
        </form>
      </div>
    </li>
  </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">
   <!-- <li class="dropdown pc-h-item">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ph ph-sun-dim"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
          <i class="ph ph-moon"></i>
          <span>Dark</span>
        </a>
        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
          <i class="ph ph-sun"></i>
          <span>Light</span>
        </a>
        <a href="#!" class="dropdown-item" onclick="layout_change_default()">
          <i class="ph ph-cpu"></i>
          <span>Default</span>
        </a>
      </div>
    </li>
    <li class="dropdown pc-h-item d-none d-md-inline-flex">
      <a
        class="pc-head-link head-link-primary dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ph ph-translate"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-end pc-h-dropdown lng-dropdown">
        <a href="#!" class="dropdown-item" data-lng="en">
          <span>
            English
            <small>(UK)</small>
          </span>
        </a>
        <a href="#!" class="dropdown-item" data-lng="fr">
          <span>
            français
            <small>(French)</small>
          </span>
        </a>
        <a href="#!" class="dropdown-item" data-lng="ro">
          <span>
            Română
            <small>(Romanian)</small>
          </span>
        </a>
        <a href="#!" class="dropdown-item" data-lng="cn">
          <span>
            中国人
            <small>(Chinese)</small>
          </span>
        </a>
      </div>
    </li>
    <li class="dropdown pc-h-item">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ph ph-diamonds-four"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
        <a href="#!" class="dropdown-item">
          <i class="ph ph-user"></i>
          <span>My Account</span>
        </a>
        <a href="#!" class="dropdown-item">
          <i class="ph ph-gear"></i>
          <span>Settings</span>
        </a>
        <a href="#!" class="dropdown-item">
          <i class="ph ph-lifebuoy"></i>
          <span>Support</span>
        </a>
        <a href="#!" class="dropdown-item">
          <i class="ph ph-lock-key"></i>
          <span>Lock Screen</span>
        </a>
        <a href="#!" class="dropdown-item">
          <i class="ph ph-power"></i>
          <span>Logout</span>
        </a>
      </div>
    </li>
    <li class="dropdown pc-h-item">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ph ph-bell"></i>
        <span class="badge bg-success pc-h-badge">5</span>
      </a>
      <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header d-flex align-items-center justify-content-between">
          <h5 class="m-0">Notifications</h5>
          <a href="#!" class="btn btn-link btn-sm">Mark all read</a>
        </div>
        <div class="dropdown-body text-wrap header-notification-scroll position-relative" style="max-height: calc(100vh - 215px)">
          <p class="text-span">Today</p>
          <div class="card bg-transparent mb-2 border-0">
            <div class="card-body p-3 rounded" style="background: rgba(var(--bs-light-rgb), 0.3); transition: all 0.2s ease;" onmouseover="this.style.background='rgba(var(--bs-primary-rgb), 0.05)'" onmouseout="this.style.background='rgba(var(--bs-light-rgb), 0.3)'">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="ph ph-credit-card text-success" style="font-size: 16px;"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <span class="float-end text-sm text-muted">2 min ago</span>
                  <h5 class="text-body mb-2">Payment Received</h5>
                  <p class="mb-0">$2,499.00 payment received for Pro Plan subscription from Acme Corp</p>
                </div>
              </div>
            </div>
          </div>
          <div class="card bg-transparent mb-2 border-0">
            <div class="card-body p-3 rounded" style="background: rgba(var(--bs-light-rgb), 0.3); transition: all 0.2s ease;" onmouseover="this.style.background='rgba(var(--bs-primary-rgb), 0.05)'" onmouseout="this.style.background='rgba(var(--bs-light-rgb), 0.3)'">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="ph ph-users text-primary" style="font-size: 16px;"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <span class="float-end text-sm text-muted">1 hour ago</span>
                  <h5 class="text-body mb-2">New Team Member</h5>
                  <p class="mb-0">Sarah Johnson joined your workspace and was assigned to the Marketing team</p>
                </div>
              </div>
            </div>
          </div>
          <div class="card bg-transparent mb-2 border-0">
            <div class="card-body p-3 rounded" style="background: rgba(var(--bs-light-rgb), 0.3); transition: all 0.2s ease;" onmouseover="this.style.background='rgba(var(--bs-primary-rgb), 0.05)'" onmouseout="this.style.background='rgba(var(--bs-light-rgb), 0.3)'">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="ph ph-chart-line text-warning" style="font-size: 16px;"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <span class="float-end text-sm text-muted">3 hours ago</span>
                  <h5 class="text-body mb-2">Monthly Report Ready</h5>
                  <p class="mb-0">Your January 2025 analytics report is ready. Revenue up 24% vs last month</p>
                </div>
              </div>
            </div>
          </div>
          <p class="text-span">Yesterday</p>
          <div class="card bg-transparent mb-2 border-0">
            <div class="card-body p-3 rounded" style="background: rgba(var(--bs-light-rgb), 0.3); transition: all 0.2s ease;" onmouseover="this.style.background='rgba(var(--bs-primary-rgb), 0.05)'" onmouseout="this.style.background='rgba(var(--bs-light-rgb), 0.3)'">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <div class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="ph ph-shield-check text-danger" style="font-size: 16px;"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <span class="float-end text-sm text-muted">18 hours ago</span>
                  <h5 class="text-body mb-2">Security Alert</h5>
                  <p class="mb-2">New login detected from San Francisco, CA. If this wasn't you, please secure your account</p>
                  <button class="btn btn-sm btn-outline-secondary me-2">Ignore</button>
                  <button class="btn btn-sm btn-danger">Secure Account</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card bg-transparent mb-2 border-0">
            <div class="card-body p-3 rounded" style="background: rgba(var(--bs-light-rgb), 0.3); transition: all 0.2s ease;" onmouseover="this.style.background='rgba(var(--bs-primary-rgb), 0.05)'" onmouseout="this.style.background='rgba(var(--bs-light-rgb), 0.3)'">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="ph ph-rocket text-info" style="font-size: 16px;"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <span class="float-end text-sm text-muted">1 day ago</span>
                  <h5 class="text-body mb-2">Feature Update</h5>
                  <p class="mb-0">New AI-powered insights are now available in your dashboard. Check out the enhanced analytics</p>
                </div>
              </div>
            </div>
          </div>
          <div class="card bg-transparent mb-2 border-0">
            <div class="card-body p-3 rounded" style="background: rgba(var(--bs-light-rgb), 0.3); transition: all 0.2s ease;" onmouseover="this.style.background='rgba(var(--bs-primary-rgb), 0.05)'" onmouseout="this.style.background='rgba(var(--bs-light-rgb), 0.3)'">
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <img class="img-radius avatar rounded-0" src="" alt="Generic placeholder image" />
                </div>
                <div class="flex-grow-1 ms-3">
                  <span class="float-end text-sm text-muted">5 hour ago</span>
                  <h5 class="text-body mb-2">Security</h5>
                  <p class="mb-0"
                    >Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                    type and scrambled it to make a type</p
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="text-center py-2">
          <a href="#!" class="link-danger">Clear all Notifications</a>
        </div>
      </div>
    </li>-->
    <li class="dropdown pc-h-item header-user-profile">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        data-bs-auto-close="outside"
        aria-expanded="false"
      >
        <i class="ph ph-user-circle"></i> 
      </a>Hello! <?= $this->session->userdata('admin_name'); ?>
      <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <h6 class="mb-0"><?= $this->session->userdata('admin_name'); ?></h6>
      
          <span class="badge bg-success-subtle text-success mt-1">Active</span>
        </div>
        <a class="dropdown-item">
          <i class="ph ph-user-circle"></i>
          <span><?= $this->session->userdata('admin_email'); ?></span>
        </a>
        <!--<a href="#!" class="dropdown-item">
          <i class="ph ph-buildings"></i>
          <span>Workspace Settings</span>
        </a>
        <a href="#!" class="dropdown-item">
          <i class="ph ph-credit-card"></i>
          <span>Billing & Usage</span>
        </a>
        <a href="#!" class="dropdown-item">
          <i class="ph ph-users-three"></i>
          <span>Team Management</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#!" class="dropdown-item">
          <i class="ph ph-headset"></i>
          <span>Support Center</span>
        </a>
        <a href="#!" class="dropdown-item">
          <i class="ph ph-keyboard"></i>
          <span>Keyboard Shortcuts</span>
        </a>
        <a href="#!" class="dropdown-item">
          <i class="ph ph-download"></i>
          <span>Download Mobile App</span>
        </a>-->
        <div class="dropdown-divider"></div>
        <a href="<?= site_url('index.php/login/logout') ?>" class="dropdown-item text-danger">
          <i class="ph ph-sign-out"></i>
          <span>Sign Out</span>
        </a>
      </div>
    </li>
  </ul>
</div>
 </div>
</header>
<!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pc-container">
      <div class="pc-content">
        <!-- [ breadcrumb ] start -->
<div class="page-header">
  <div class="page-block">
    <div class="row align-items-center">

      <div class="col-md-12">
        <div class="page-header-title">
          <h5 class="mb-0">
            <?= isset($title) ? $title : 'Dashboard'; ?>
          </h5>
        </div>
      </div>

      <div class="col-md-6">
        <ul class="breadcrumb mb-0">

          <li class="breadcrumb-item">
            <a href="<?= base_url(''); ?>">Home</a>
          </li>

          <?php if (!empty($breadcrumbs)): ?>
            <?php foreach ($breadcrumbs as $breadcrumb): ?>
              <?php if (!empty($breadcrumb['url'])): ?>
                <li class="breadcrumb-item">
                  <a href="<?= base_url($breadcrumb['url']); ?>">
                    <?= $breadcrumb['label']; ?>
                  </a>
                </li>
              <?php else: ?>
                <li class="breadcrumb-item active" aria-current="page">
                  <?= $breadcrumb['label']; ?>
                </li>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>

        </ul>
      </div>

      <?php if ($this->uri->segment(2) === 'view_all_jobs') { ?>
      <div class="col-md-6">
          <div class="text-end">
              <a href="<?= base_url('index.php/jobs/export_all_jobs_excel') ?>" 
                class="btn btn-outline-warning btn-sm">
                <i class="ph ph-download-simple me-1"></i>Export
              </a>

          </div>
      </div>
      <?php } ?>


    </div>
  </div>
</div>

<!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
          
            <!-- Dynamic Content -->
           
                <?php
                if (isset($render)) {
                    $this->load->view($render);
                }
                ?>
            </div>
            
        </div>
        <!-- [ Main Content ] end -->
      </div>
    </div>
    <!-- [ Main Content ] end -->
    <footer class="pc-footer">
  <div class="footer-wrapper container-fluid">
    <div class="row">
      <div class="col my-1">
        
      </div>
      <div class="col-md-auto my-1">
       
      </div>
    </div>
  </div>
</footer>
 <div class="pct-c-btn-modern">
  <button type="button" class="customizer-trigger" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_pc_layout" data-bs-toggle="tooltip" data-bs-placement="left" title="Theme Customizer">
    <div class="trigger-icon">
      <i class="ph ph-palette"></i>
    </div>
    <div class="trigger-text">Customize</div>
  </button>
</div>
<div class="offcanvas border-0 pct-offcanvas-modern offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
  <div class="customizer-header">
    <div class="header-content">
      <div class="header-icon">
        <i class="ph ph-paint-brush"></i>
      </div>
      <div class="header-info">
        <h5 class="customizer-title">Theme Customizer</h5>
        <p class="customizer-subtitle">Personalize your experience</p>
      </div>
    </div>
    <div class="header-actions">
      <button type="button" class="btn-reset" id="layoutreset" data-bs-toggle="tooltip" title="Reset to defaults">
        <i class="ph ph-arrow-clockwise"></i>
      </button>
      <button type="button" class="btn-close-modern" data-bs-dismiss="offcanvas" aria-label="Close">
        <i class="ph ph-x"></i>
      </button>
    </div>
  </div>
  <div class="customizer-search">
    <div class="search-container">
      <i class="ph ph-magnifying-glass search-icon"></i>
      <input type="text" class="search-input" placeholder="Search settings..." id="customizer-search">
    </div>
  </div>
  
  <div class="quick-theme-toggle">
    <div class="quick-toggle-header">
      <h6 class="toggle-title">Theme Mode</h6>
      <p class="toggle-subtitle">Quick switch between themes</p>
    </div>
    <div class="theme-mode-switcher">
      <button class="theme-mode-btn active" data-mode="light" onclick="layout_change('light');" data-bs-toggle="tooltip" title="Light Mode">
        <i class="ph ph-sun"></i>
        <span>Light</span>
      </button>
      <button class="theme-mode-btn" data-mode="dark" onclick="layout_change('dark');" data-bs-toggle="tooltip" title="Dark Mode">
        <i class="ph ph-moon"></i>
        <span>Dark</span>
      </button>
    </div>
  </div>
  <div class="customizer-navigation">
    <div class="nav-pills-modern" id="customizer-nav" role="tablist">
      <button class="nav-pill active" id="layout-tab" data-bs-toggle="pill" data-bs-target="#layout-panel" type="button" role="tab" aria-controls="layout-panel" aria-selected="true">
        <i class="ph ph-layout"></i>
        <span>Layout</span>
      </button>
      <button class="nav-pill" id="colors-tab" data-bs-toggle="pill" data-bs-target="#colors-panel" type="button" role="tab" aria-controls="colors-panel" aria-selected="false">
        <i class="ph ph-palette"></i>
        <span>Colors</span>
      </button>
      <button class="nav-pill" id="advanced-tab" data-bs-toggle="pill" data-bs-target="#advanced-panel" type="button" role="tab" aria-controls="advanced-panel" aria-selected="false">
        <i class="ph ph-gear-six"></i>
        <span>Advanced</span>
      </button>
    </div>
  </div>
  <div class="customizer-content">
    <div class="tab-content-modern" id="customizer-content">
      <div class="tab-pane-modern fade show active" id="layout-panel" role="tabpanel" aria-labelledby="layout-tab" tabindex="0">
        <div class="settings-group">
          <div class="group-header">
            <h6 class="group-title">Sidebar Configuration</h6>
            <p class="group-description">Customize your sidebar appearance</p>
          </div>
          <div class="setting-item">
            <div class="setting-info">
              <label class="setting-label">Sidebar Theme</label>
              <span class="setting-help">Choose between light and dark sidebar</span>
            </div>
            <div class="setting-control">
              <div class="toggle-group">
                <button class="toggle-option" data-value="true" onclick="layout_theme_sidebar_change('true');" data-bs-toggle="tooltip" title="Light Sidebar">
                  <i class="ph ph-sun"></i>
                  <span>Light</span>
                </button>
                <button class="toggle-option active" data-value="false" onclick="layout_theme_sidebar_change('false');" data-bs-toggle="tooltip" title="Dark Sidebar">
                  <i class="ph ph-moon"></i>
                  <span>Dark</span>
                </button>
              </div>
            </div>
          </div>
          <div class="setting-item">
            <div class="setting-info">
              <label class="setting-label">Sidebar Icons</label>
              <span class="setting-help">Show or hide navigation icons</span>
            </div>
            <div class="setting-control">
              <div class="toggle-group sidebar-icons">
                <button class="toggle-option active" data-value="true" onclick="layout_sidebar_icons_change('true');" data-bs-toggle="tooltip" title="Show Icons">
                  <i class="ph ph-squares-four"></i>
                  <span>Show</span>
                </button>
                <button class="toggle-option" data-value="false" onclick="layout_sidebar_icons_change('false');" data-bs-toggle="tooltip" title="Hide Icons">
                  <i class="ph ph-minus-square"></i>
                  <span>Hide</span>
                </button>
              </div>
            </div>
          </div>
          <div class="setting-item">
            <div class="setting-info">
              <label class="setting-label">Sidebar Caption</label>
              <span class="setting-help">Show or hide navigation captions</span>
            </div>
            <div class="setting-control">
              <div class="image-toggle-group">
                <button class="image-toggle active" data-value="true" onclick="layout_caption_change('true');" data-bs-toggle="tooltip" title="Show Captions">
                  <img src="<?php echo base_url('include/dist/assets/images/customizer/caption-on.svg'); ?>" alt="Caption On" class="toggle-preview">
                  <span class="toggle-label">Show</span>
                </button>
                <button class="image-toggle" data-value="false" onclick="layout_caption_change('false');" data-bs-toggle="tooltip" title="Hide Captions">
                  <img src="<?php echo base_url('include/dist/assets/images/customizer/caption-off.svg'); ?>" alt="Caption Off" class="toggle-preview">
                  <span class="toggle-label">Hide</span>
                </button>
              </div>
            </div>
          </div>
          <div class="setting-item pc-rtl">
            <div class="setting-info">
              <label class="setting-label">Text Direction</label>
              <span class="setting-help">Left-to-right or right-to-left layout</span>
            </div>
            <div class="setting-control">
              <div class="image-toggle-group">
                <button class="image-toggle active" data-value="false" onclick="layout_rtl_change('false');" data-bs-toggle="tooltip" title="Left to Right">
                  <img src="<?php echo base_url('include/dist/assets/images/customizer/caption-off.svg'); ?>" alt="LTR" class="toggle-preview">
                  <span class="toggle-label">LTR</span>
                </button>
                <button class="image-toggle" data-value="true" onclick="layout_rtl_change('true');" data-bs-toggle="tooltip" title="Right to Left">
                  <img src="" alt="RTL" class="toggle-preview">
                  <span class="toggle-label">RTL</span>
                </button>
              </div>
            </div>
          </div>
          <div class="setting-item pc-box-width">
            <div class="setting-info">
              <label class="setting-label">Layout Width</label>
              <span class="setting-help">Container width configuration</span>
            </div>
            <div class="setting-control">
              <div class="image-toggle-group">
                <button class="image-toggle active" data-value="false" onclick="change_box_container('false')" data-bs-toggle="tooltip" title="Full Width Layout">
                  <img src="" alt="Full Width" class="toggle-preview">
                  <span class="toggle-label">Full</span>
                </button>
                <button class="image-toggle" data-value="true" onclick="change_box_container('true')" data-bs-toggle="tooltip" title="Fixed Width Layout">
                  <img src="" alt="Fixed Width" class="toggle-preview">
                  <span class="toggle-label">Fixed</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane-modern fade" id="colors-panel" role="tabpanel" aria-labelledby="colors-tab" tabindex="0">
        <div class="settings-group">
          <div class="group-header">
            <h6 class="group-title">Theme Colors</h6>
            <p class="group-description">Customize your color scheme</p>
          </div>
          <div class="setting-item">
            <div class="setting-info">
              <label class="setting-label">Primary Color</label>
              <span class="setting-help">Choose your main brand color</span>
            </div>
            <div class="setting-control">
              <div class="color-palette preset-color">
                <button class="color-swatch-small active" data-bs-toggle="tooltip" title="Ocean Blue" data-value="preset-1">
                  <span class="color-preview-small" style="background: #4680ff;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Royal Purple" data-value="preset-2">
                  <span class="color-preview-small" style="background: #7c4dff;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Rose Pink" data-value="preset-3">
                  <span class="color-preview-small" style="background: #e91e63;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Crimson Red" data-value="preset-4">
                  <span class="color-preview-small" style="background: #dc2626;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Vibrant Orange" data-value="preset-5">
                  <span class="color-preview-small" style="background: #ff9800;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Golden Yellow" data-value="preset-6">
                  <span class="color-preview-small" style="background: #ffd54f;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Forest Green" data-value="preset-7">
                  <span class="color-preview-small" style="background: #4caf50;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Aqua Cyan" data-value="preset-8">
                  <span class="color-preview-small" style="background: #00bcd4;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
              </div>
              <button class="reset-color-btn" data-target="preset-color" data-bs-toggle="tooltip" title="Reset to default">
                <i class="ph ph-arrow-clockwise"></i>
                <span>Reset to Default</span>
              </button>
            </div>
          </div>
          <div class="setting-item">
            <div class="setting-info">
              <label class="setting-label">Header Theme</label>
              <span class="setting-help">Customize header background color</span>
            </div>
            <div class="setting-control">
              <div class="color-palette header-color">
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Ocean Blue" data-value="preset-1">
                  <span class="color-preview-small" style="background: #4680ff;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Royal Purple" data-value="preset-2">
                  <span class="color-preview-small" style="background: #7c4dff;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Rose Pink" data-value="preset-3">
                  <span class="color-preview-small" style="background: #e91e63;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Crimson Red" data-value="preset-4">
                  <span class="color-preview-small" style="background: #dc2626;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Vibrant Orange" data-value="preset-5">
                  <span class="color-preview-small" style="background: #ff9800;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Golden Yellow" data-value="preset-6">
                  <span class="color-preview-small" style="background: #ffd54f;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Forest Green" data-value="preset-7">
                  <span class="color-preview-small" style="background: #4caf50;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Aqua Cyan" data-value="preset-8">
                  <span class="color-preview-small" style="background: #00bcd4;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
              </div>
              <button class="reset-color-btn" data-target="header-color" data-bs-toggle="tooltip" title="Reset to default">
                <i class="ph ph-arrow-clockwise"></i>
                <span>Reset to Default</span>
              </button>
            </div>
          </div>
          <div class="setting-item">
            <div class="setting-info">
              <label class="setting-label">Navbar Theme</label>
              <span class="setting-help">Customize navigation bar colors</span>
            </div>
            <div class="setting-control">
              <div class="color-palette navbar-color">
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Ocean Blue" data-value="preset-1">
                  <span class="color-preview-small" style="background: #4680ff;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Royal Purple" data-value="preset-2">
                  <span class="color-preview-small" style="background: #7c4dff;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Rose Pink" data-value="preset-3">
                  <span class="color-preview-small" style="background: #e91e63;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Crimson Red" data-value="preset-4">
                  <span class="color-preview-small" style="background: #dc2626;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Vibrant Orange" data-value="preset-5">
                  <span class="color-preview-small" style="background: #ff9800;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Golden Yellow" data-value="preset-6">
                  <span class="color-preview-small" style="background: #ffd54f;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Forest Green" data-value="preset-7">
                  <span class="color-preview-small" style="background: #4caf50;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Aqua Cyan" data-value="preset-8">
                  <span class="color-preview-small" style="background: #00bcd4;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
              </div>
              <button class="reset-color-btn" data-target="navbar-color" data-bs-toggle="tooltip" title="Reset to default">
                <i class="ph ph-arrow-clockwise"></i>
                <span>Reset to Default</span>
              </button>
            </div>
          </div>
          <div class="setting-item">
            <div class="setting-info">
              <label class="setting-label">Logo Theme</label>
              <span class="setting-help">Brand logo area customization</span>
            </div>
            <div class="setting-control">
              <div class="color-palette logo-color">
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Ocean Blue" data-value="preset-1">
                  <span class="color-preview-small" style="background: #4680ff;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Royal Purple" data-value="preset-2">
                  <span class="color-preview-small" style="background: #7c4dff;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Rose Pink" data-value="preset-3">
                  <span class="color-preview-small" style="background: #e91e63;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Crimson Red" data-value="preset-4">
                  <span class="color-preview-small" style="background: #dc2626;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Vibrant Orange" data-value="preset-5">
                  <span class="color-preview-small" style="background: #ff9800;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Golden Yellow" data-value="preset-6">
                  <span class="color-preview-small" style="background: #ffd54f;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Forest Green" data-value="preset-7">
                  <span class="color-preview-small" style="background: #4caf50;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Aqua Cyan" data-value="preset-8">
                  <span class="color-preview-small" style="background: #00bcd4;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
              </div>
              <button class="reset-color-btn" data-target="logo-color" data-bs-toggle="tooltip" title="Reset to default">
                <i class="ph ph-arrow-clockwise"></i>
                <span>Reset to Default</span>
              </button>
            </div>
          </div>
          <div class="setting-item">
            <div class="setting-info">
              <label class="setting-label">Caption Colors</label>
              <span class="setting-help">Navigation caption text colors</span>
            </div>
            <div class="setting-control">
              <div class="color-palette caption-color">
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Ocean Blue" data-value="preset-1">
                  <span class="color-preview-small" style="background: #4680ff;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Royal Purple" data-value="preset-2">
                  <span class="color-preview-small" style="background: #7c4dff;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Rose Pink" data-value="preset-3">
                  <span class="color-preview-small" style="background: #e91e63;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Crimson Red" data-value="preset-4">
                  <span class="color-preview-small" style="background: #dc2626;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Vibrant Orange" data-value="preset-5">
                  <span class="color-preview-small" style="background: #ff9800;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Golden Yellow" data-value="preset-6">
                  <span class="color-preview-small" style="background: #ffd54f;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Forest Green" data-value="preset-7">
                  <span class="color-preview-small" style="background: #4caf50;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
                <button class="color-swatch-small" data-bs-toggle="tooltip" title="Aqua Cyan" data-value="preset-8">
                  <span class="color-preview-small" style="background: #00bcd4;"></span>
                  <i class="ph ph-check color-check"></i>
                </button>
              </div>
              <button class="reset-color-btn" data-target="caption-color" data-bs-toggle="tooltip" title="Reset to default">
                <i class="ph ph-arrow-clockwise"></i>
                <span>Reset to Default</span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane-modern fade" id="advanced-panel" role="tabpanel" aria-labelledby="advanced-tab" tabindex="0">
        <div class="settings-group">
          <div class="group-header">
            <h6 class="group-title">Advanced Settings</h6>
            <p class="group-description">Fine-tune interface details</p>
          </div>
          <div class="setting-item">
            <div class="setting-info">
              <label class="setting-label">Dropdown Menu Icons</label>
              <span class="setting-help">Choose icons for expandable menus</span>
            </div>
            <div class="setting-control">
              <div class="icon-selector drp-menu-icon">
                <button class="icon-option active" data-value="preset-1" data-bs-toggle="tooltip" title="Chevron Right">
                  <i class="ti ti-chevron-right"></i>
                </button>
                <button class="icon-option" data-value="preset-2" data-bs-toggle="tooltip" title="Double Chevron">
                  <i class="ti ti-chevrons-right"></i>
                </button>
                <button class="icon-option" data-value="preset-3" data-bs-toggle="tooltip" title="Caret Right">
                  <i class="ti ti-caret-right"></i>
                </button>
                <button class="icon-option" data-value="preset-4" data-bs-toggle="tooltip" title="Plus Circle">
                  <i class="ti ti-circle-plus"></i>
                </button>
                <button class="icon-option" data-value="preset-5" data-bs-toggle="tooltip" title="Plus">
                  <i class="ti ti-plus"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="setting-item">
            <div class="setting-info">
              <label class="setting-label">Link Indicators</label>
              <span class="setting-help">Icons for menu link items</span>
            </div>
            <div class="setting-control">
              <div class="icon-selector drp-menu-link-icon">
                <button class="icon-option active" data-value="preset-1" data-bs-toggle="tooltip" title="No Icon">
                  <span class="no-icon">None</span>
                </button>
                <button class="icon-option" data-value="preset-2" data-bs-toggle="tooltip" title="Arrow Right">
                  <i class="ti ti-arrow-narrow-right"></i>
                </button>
                <button class="icon-option" data-value="preset-3" data-bs-toggle="tooltip" title="Chevron Right">
                  <i class="ti ti-chevron-right"></i>
                </button>
                <button class="icon-option" data-value="preset-4" data-bs-toggle="tooltip" title="Double Chevron">
                  <i class="ti ti-chevrons-right"></i>
                </button>
                <button class="icon-option" data-value="preset-5" data-bs-toggle="tooltip" title="Corner Down">
                  <i class="ti ti-corner-down-right"></i>
                </button>
                <button class="icon-option" data-value="preset-6" data-bs-toggle="tooltip" title="Dash">
                  <i class="ti ti-minus"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url('include/dist/assets/js/jquery-3.6.0.min.js') ?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/jquery.dataTables.min.js'); ?>"></script>

<script src="<?php echo base_url('include/dist/assets/js/select2.min.js'); ?>"></script>

    <!-- [Page Specific JS] start -->
    <!-- apexcharts js -->
    <script src="<?php echo base_url('include/dist/assets/js/plugins/apexcharts.min.js'); ?>"></script>
    
    <!-- Vector maps -->
    <script src="<?php echo base_url('include/dist/assets/js/plugins/jsvectormap.min.js'); ?>"></script>
    <script src="<?php echo base_url('include/dist/assets/js/plugins/world.js'); ?>"></script>
    
    <!-- Enhanced Dashboard Widgets -->
    <script src="<?php echo base_url('include/dist/assets/js/widgets/world-low.js'); ?>"></script>
    <script src="<?php echo base_url('include/dist/assets/js/widgets/device-chart.js'); ?>"></script>
    <script src="<?php echo base_url('include/dist/assets/js/widgets/happy-sad-ball.js'); ?>"></script>
    
 
    <!-- [Page Specific JS] end -->
    <!-- Required JS -->
<script src="<?php echo base_url('include/dist/assets/js/plugins/popper.min.js')?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/plugins/simplebar.min.js')?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/plugins/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/plugins/i18next.min.js')?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/plugins/i18nextHttpBackend.min.js')?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/script.js')?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/theme.js')?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/multi-lang.js')?>"></script>






  </body>
  <!-- [Body] end -->
</html>
