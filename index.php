<?php
session_start();
error_reporting(0);
//ini_set('display_errors', 1);

include('config/dbconn.php');
include('controllers/form_process.php');
try {
  // Retrieve existing data if available
  $sql = "SELECT * FROM tblsystemsettings";
  $result = $dbh->query($sql);

  if ($result->rowCount() > 0) {
      // Fetch data and pre-fill the form fields
      $row = $result->fetch(PDO::FETCH_ASSOC);
      $system_name = $row["system_name"];
      // Assuming icon and cover paths are stored in the database with ../../
      $icon_path_relative = $row["icon_path"];
      $cover_path_relative = $row["cover_path"];

      // Remove ../../ from the paths
      $icon_path = str_replace('../../', '', $icon_path_relative);
      $cover_path = str_replace('../../', '', $cover_path_relative);
  } else {
      // If no data available, set default values
      $system_name = "";
      $icon_path = "assets/img/avatars/no-image.jpg";
      $cover_path = "assets/img/pages/profile-banner.png";
  }
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="kh" class="light-style layout-wide  customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?php echo $pageTitle = "ចូលប្រើប្រាស់ប្រព័ន្ធ"; ?></title>

    <meta name="description"
        content="Most Powerful &amp; Comprehensive Bootstrap 5 HTML Admin Dashboard Template built for developers!" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5" />
    <!-- Canonical SEO -->
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <!-- Icons -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/rtl/core-dark.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="assets/vendor/libs/@form-validation/form-validation.css" />
    <link rel="stylesheet" href="assets/vendor/libs/spinkit/spinkit.css">

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css">

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
    <script src="assets/js/login.js"></script>
</head>

<?php include('includes/alert.php'); ?>

<body>
    <nav class=" layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme position-fixed w-100
        shadow-none px-3 px-md-5" id=" layout-navbar">
        <div class="container">
            <div class="navbar-brand app-brand demo d-xl-flex py-0 me-4 ">
                <a href="index.html" class="app-brand-link gap-2">
                    <span class="app-brand-logo demo">
                        <img src="<?php echo htmlspecialchars($icon_path); ?>" class="avatar avat" alt="">
                    </span>
                    <span class="app-brand-text demo menu-text fw-bold mef2 d-xl-block d-none d-sm-none"
                        style="font-size: 1.2rem"><?php echo htmlspecialchars($system_name); ?></span>
                </a>
            </div>
        </div>
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Language -->
            <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="bx bx-globe bx-sm"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-language="kh"
                            data-text-direction="ltr">
                            <span class="align-middle">
                                ភាសាខែ្មរ
                            </span>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-language="en"
                            data-text-direction="ltr">
                            <span class="align-middle">English</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- /Language -->
            <li class="nav-item dropdown-style-switcher dropdown me-4 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="bx bx-sm"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                            <span class="align-middle"><i class="bx bx-sun me-2"></i>Light</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                            <span class="align-middle"><i class="bx bx-moon me-2"></i>Dark</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                            <span class="align-middle"><i class="bx bx-desktop me-2"></i>System</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Content -->
    <div class="authentication-wrapper authentication-cover content">
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5 ">
                <div class="w-100 d-flex justify-content-center mt-5">
                    <div>
                        <img src="<?php echo htmlspecialchars($cover_path); ?>"
                            style="width: 100%;height: 70vh; object-fit: cover;" alt="">
                    </div>
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4 shadow-none">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand mb-5 d-flex align-items-center justify-content-center">
                        <a href="index.html" class="app-brand-link gap-2">
                            <span class="app-brand-log demo">
                                <img src="<?php echo htmlspecialchars($icon_path); ?>" class="avatar avatar-xl" alt="">
                            </span>
                        </a>
                    </div>
                    <form id="formAuthentication" class="mb-3" method="POST">
                        <input type="hidden" name="login_type" value="login">
                        <div class="mb-3">
                            <label for="email" class="form-label" data-i18n="Username">ឈ្មោះមន្ត្រី
                                <span class="text-danger fw-bold">*</span>
                            </label>
                            <input type="text" class="form-control" id="email" name="username"
                                placeholder="សូមបញ្ចូលឈ្មោះមន្ត្រី" autofocus required />
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password" data-i18n="Password">
                                    ពាក្យសម្ងាត់
                                    <span class="text-danger fw-bold">*</span>
                                </label>
                                <a href="auth-forgot-password-cover.html">
                                    <small>ភ្លេចពាក្យសម្ងាត់?</small>
                                </a>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100 mt-4" data-i18n="Login">
                            ចូលប្រើប្រាស់ប្រព័ន្ធ
                        </button>
                    </form>


                    <div class="divider my-4">
                        <div class="divider-text" data-i18n="OR">ឬ</div>
                    </div>

                    <div class="d-flex justify-content-center mb-3">
                        <a href="pages/supperadmin/index.php" data-i18n="Admin"
                            class="btn btn-label-secondary w-100">អេដមីន</a>
                    </div>

                    <div class="d-flex justify-content-center">
                        <a href="" class="btn btn-label-primary w-100" data-i18n="Back">ត្រឡប់ទៅកាន់ប្រព័ន្ធឌីជីថល</a>
                    </div>
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>

    <!-- / Content -->
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/libs/hammer/hammer.js"></script>
    <script src="assets/vendor/libs/i18n/i18n.js"></script>
    <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <!-- endbuild -->
    <!-- Vendors JS -->
    <script src="assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="assets/vendor/libs/@form-validation/auto-focus.js"></script>
    <script src="assets/vendor/libs/block-ui/block-ui.js"></script>
    <!-- Main JS -->
    <script src="assets/js/main.js"></script>
    <!-- Page JS -->
    <script src="assets/js/pages-auth.js"></script>
    <script src="assets/js/ui-toasts.js"></script>
    <script src="assets/vendor/libs/toastr/toastr.js"></script>
</body>


</html>
