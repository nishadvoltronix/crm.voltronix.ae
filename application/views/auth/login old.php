<!doctype html>
<html lang="en">
  <!-- [Head] start -->

  <head>

      <title><?php echo $title ?? 'Voltronix CRM'; ?></title>
<!-- [Meta] -->
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
<meta
  name="description"
  content="Admindek - Modern responsive dashboard template built with Bootstrap 5. Features dark/light themes, RTL support, and extensive UI components for admin panels and web applications."
/>
<meta
  name="keywords"
  content="Admindek - Bootstrap 5 admin template, responsive dashboard, dark mode, RTL support, admin panel, UI components, web application template, modern dashboard"
/>
<meta name="author" content="DashboardPack.com" />
<meta name="theme-color" content="#1e293b" />
<meta name="color-scheme" content="light dark" />

<!-- [Open Graph] -->
<meta property="og:type" content="website" />
<meta property="og:title" content="Analytics Dashboard | Admindek Dashboard Template" />
<meta property="og:description" content="Modern responsive dashboard template built with Bootstrap 5. Features dark/light themes, RTL support, and extensive UI components." />
<meta property="og:site_name" content="Admindek" />

<!-- [Twitter/X Card] -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Analytics Dashboard | Admindek Dashboard Template" />
<meta name="twitter:description" content="Modern responsive dashboard template built with Bootstrap 5. Features dark/light themes, RTL support, and extensive UI components." />

<!-- [Favicon] icons -->
<link rel="icon" href="<?php echo base_url('include/dist/assets/images/favicon_voltronix.png');?>" type="image/svg+xml" />
<link rel="apple-touch-icon" href="<?php echo base_url('include/dist/assets/images/apple-touch-icon.png');?>" />
<link rel="manifest" href="<?php echo base_url('include/dist/assets/images/site.webmanifest');?>" />
      
<link rel="stylesheet" href="<?php echo base_url('include/dist/assets/css/plugins/uppy.min.css');?>" />

<!-- map-vector css -->
<link rel="stylesheet" href="<?php echo base_url('include/assets/css/plugins/jsvectormap.min.css');?>" />
      
<!-- [Font] Family -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
<!-- [phosphor Icons] https://phosphoricons.com/ -->
<link rel="stylesheet" href="<?php echo base_url('include/dist/assets/css/plugins/phosphor-icons.css');?>" />
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="<?php echo base_url('include/dist/assets/css/plugins/tabler-icons.min.css');?>" />
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="<?php echo base_url('include/dist/assets/css/style.css'); ?>" id="main-style-link" />
      
      <link rel="stylesheet" href="<?php echo base_url('include/dist/assets/css/style.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('include/dist/assets/css/style-preset.css'); ?>" />
<!-- [Vite Development Scripts] -->
<!-- Development script removed for production -->

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

    <div class="auth-main loginbg">


      <div class="auth-wrapper v2">
        <div class="auth-sidecontent">
          <div class="d-flex align-items-center w-100 justify-content-center">
            <div class="col-md-8">
              <!--<h1 class="text-white mb-5">Voltronix</h1>
              <p class="text-white"
                >Track leads, monitor every interaction, and manage your sales pipeline with ease.</p
              >-->
            </div>
          </div>
        </div>
        <div class="auth-form">
          <div class="card my-0">
            <div class="card-body">
              <div class="text-center">
                <a href="#"><img src="<?php echo base_url('include/dist/assets/images/voltronix_logo.png'); ?>" alt="img" width="260px"/></a>
              </div>
              <h5 class="text-center f-w-500 mt-4 mb-3"><i>Login to your Workspace</i></h5>

            <?= form_open('index.php/login/authenticate') ?>

              <div class="mb-3">
                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Email Address" />
              </div>
              <div class="mb-3">
                <input type="password" name="password"  class="form-control" id="floatingInput1" placeholder="Password" />
              </div>
              <div class="d-flex mt-1 justify-content-between align-items-center">
                <div class="form-check">
                  <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="" />
                  <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                </div>
                
              </div>
              <div class="text-center mt-4">
                <button type="submit" class="btn btn-dangers shadow px-sm-4">Login</button>
              </div>

            <?php if (!empty($error)): ?>
                <center><div class="alert alert-dangers py-1 px-2 mb-0 login_error_msg" role="alert">
                     <span class="text-dark"><?= $error ?></span>
                </div></center>
            <?php endif; ?>


             <?= form_close() ?>

            </div>
          </div>
        </div>
        <!--/*** Form Paste Here ***/

        /*** Form Paste Here ***/-->
      </div>
    </div>

    <!-- Required JS -->
<script src="<?php echo base_url('include/dist/assets/js/plugins/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/plugins/simplebar.min.js'); ?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/plugins/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/plugins/i18next.min.js'); ?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/plugins/i18nextHttpBackend.min.js'); ?>"></script>
<script src="<?php echo base_url('include/dist/assets/js/script.js'); ?>"></script>
<script src="../assets/js/theme.js"></script>
<script src="../assets/js/multi-lang.js"></script>


  </body>
  <!-- [Body] end -->
</html>

