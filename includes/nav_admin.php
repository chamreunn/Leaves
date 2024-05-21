<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-xxl">
        <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
            <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                    <img src="../../assets/img/icons/brands/logo2.png" class="avatar avat" alt="">
                </span>
                <span class="app-brand-text demo menu-text fw-bold mef2 d-xl-block d-none d-sm-none"
                    style="font-size: 1.2rem">អង្គភាពសវនកម្មផ្ទៃក្នុង</span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>

        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <?php
                if (isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
                    // User is logged in
                    ?>
                <!-- Search -->
                <li class="nav-item navbar-search-wrapper me-2 me-xl-0">
                    <a class="nav-link search-toggler" href="javascript:void(0);">
                        <i class="bx bx-search bx-sm"></i>
                    </a>
                </li>
                <!-- /Search -->

                <!-- Language Selector -->
                <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <i class="bx bx-globe bx-sm"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item active" href="javascript:void(0);" data-language="kh"
                                data-text-direction="ltr">
                                <span class="align-middle">ភាសាខែ្មរ</span>
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
                <!-- /Language Selector -->

                <!-- Style Switcher -->
                <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
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
                <!-- /Style Switcher -->

                <!-- Notification -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                    <a class="nav-link dropdown-toggle hide-arrow show" href="javascript:void(0);"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                        <i class="bx bx-bell bx-sm"></i>
                        <span class="badge bg-danger rounded-pill badge-notifications">5</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end py-0" data-bs-popper="static">
                        <li class="dropdown-menu-header border-bottom">
                            <div class="dropdown-header d-flex align-items-center py-3">
                                <h5 class="text-body mb-0 me-auto">Notification</h5>
                                <a href="javascript:void(0)" class="dropdown-notifications-all text-body"
                                    data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Mark all as read"
                                    data-bs-original-title="Mark all as read"><i
                                        class="bx fs-4 bx-envelope-open"></i></a>
                            </div>
                        </li>
                        <li class="dropdown-notifications-list scrollable-container ps ps--active-y">
                            <ul class="list-group list-group-flush" id="notifications">
                                <audio id="notification-sound" src="../../assets/notification/sound/notification.mp3"
                                    preload="auto">
                                </audio>
                                <div id="notifications-list"></div>
                            </ul>
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                            </div>
                            <div class="ps__rail-y" style="top: 0px; right: 0px; height: 480px;">
                                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 229px;"></div>
                            </div>
                        </li>
                        <li class="dropdown-menu-footer border-top p-3">
                            <button class="btn btn-primary text-uppercase w-100">View All Notifications</button>
                        </li>
                    </ul>
                </li>

                <!-- Settings Icon -->
                <li class="nav-item">
                    <a class="nav-link" href="settings.php" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-offset="0,1" title="Settings">
                        <i class="bx bx-cog bx-sm"></i>
                    </a>
                </li>
                <?php
                    // Check if user is from tbluser
                    if ($_SESSION['role'] !== 'supperadmin') {
                        // Display user-specific navbar items
                        ?>
                <!-- User Profile Dropdown -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-online">
                                    <img src="<?php echo (!empty(htmlentities($user['Profiles']))) ? '../../assets/img/avatars/' . htmlentities($user['Profiles']) : '../../assets/img/avatars/no-image.jpg'; ?>"
                                        style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                </div>
                            </div>
                            <div class="flex-grow-1 mx-2 d-none d-md-block">
                                <span class="fw-medium d-block"><?php echo $user['FullName']; ?></span>
                                <small class="text-muted"><?php echo $_SESSION['role']; ?></small>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="pages-account-settings-account.html">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="<?php echo (!empty(htmlentities($user['Profiles']))) ? '../../assets/img/avatars/' . htmlentities($user['Profiles']) : '../../assets/img/avatars/no-image.jpg'; ?>"
                                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-medium d-block"><?php echo $user['FullName']; ?></span>
                                        <small class="text-muted"><?php echo $_SESSION['role']; ?></small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="pages-profile-user.html">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Account</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="pages-account-settings-account.html">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Settings</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../../includes/logout.php">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Logout</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- /User Profile Dropdown -->
                <?php } else {
                        // Display admin-specific navbar items
                        ?>
                <!-- User Profile Dropdown -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-online">
                                    <img src="<?php echo (!empty(htmlentities($admin['Profiles']))) ? '../../assets/img/avatars/' . htmlentities($admin['Profiles']) : '../../assets/img/avatars/no-image.jpg'; ?>"
                                        style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                </div>
                            </div>
                            <div class="flex-grow-1 mx-2 d-none d-md-block">
                                <span class="fw-medium d-block"><?php echo $admin['fullname']; ?></span>
                                <small class="text-muted"><?php echo $admin['role']; ?></small>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="pages-account-settings-account.html">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="<?php echo (!empty(htmlentities($admin['Profiles']))) ? '../../assets/img/avatars/' . htmlentities($admin['Profiles']) : '../../assets/img/avatars/no-image.jpg'; ?>"
                                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-medium d-block"><?php echo $admin['fullname']; ?></span>
                                        <small class="text-muted"><?php echo $admin['role']; ?></small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="pages-profile-user.html">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Account</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="pages-account-settings-account.html">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Settings</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../../includes/logout.php">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Logout</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- /User Profile Dropdown -->
                <?php } ?>
                <?php } else {
                    // User is not logged in
                    ?>
                <!-- Logo and Name -->
                <li class="nav-item">
                    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
                        <a href="index.html" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <img src="../../assets/img/icons/brands/logo2.png" class="avatar avat" alt="">
                            </span>
                            <span class="app-brand-text demo menu-text fw-bold mef2 d-xl-block d-none d-sm-none"
                                style="font-size: 1.2rem">អង្គភាពសវនកម្មផ្ទៃក្នុង</span>
                        </a>
                        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                            <i class="bx bx-chevron-left bx-sm align-middle"></i>
                        </a>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div>

        <!-- Search Small Screens -->
        <div class="navbar-search-wrapper search-input-wrapper container-xxl d-none">
            <span class="twitter-typeahead container-xxl" style="position: relative; display: inline-block;">
                <input type="text" class="form-control search-input border-0 container-xxl tt-input"
                    placeholder="Search..." aria-label="Search..." autocomplete="off" spellcheck="false" dir="auto"
                    style="position: relative; vertical-align: top;">
                <pre aria-hidden="true"
                    style="position: absolute; visibility: hidden; white-space: pre; font-family: khmer-mef1, khmer-mef2; font-size: 15px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;"></pre>
                <div class="tt-menu navbar-search-suggestion ps"
                    style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;">
                    <div class="tt-dataset tt-dataset-pages"></div>
                    <div class="tt-dataset tt-dataset-files"></div>
                    <div class="tt-dataset tt-dataset-members"></div>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; right: 0px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                    </div>
                </div>
            </span>
            <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
        </div>
    </div>
</nav>