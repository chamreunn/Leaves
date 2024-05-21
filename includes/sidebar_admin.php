<?php
if (isset($_SESSION['userid'])) {
?>
<aside id="layout-menu" class="layout-menu-horizontal menu menu-horizontal container-fluid flex-grow-0 bg-menu-theme"
    data-bg-class="bg-menu-theme"
    style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">
            <!-- Dashboards -->
            <li class="<?php if ($sidebar == 'home') { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                <a href="dashboard.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-dock-top"></i>
                    <div data-i18n="Late Documents">Late Documents </div>
                </a>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-calendar"></i>
                    <div data-i18n="Leaves">Leaves</div>
                </a>
            </li>

            <!-- Layouts -->
            <li
                class="<?php if (in_array($sidebar, ['admin_account','all-users-security','regulator','report','alluser', 'allsystem', 'role', 'permmission', 'department', 'office', 'position', 'eposition', 'leavetype', 'eleavetype', 'late', 'elate', 'ealluser'])) { echo 'menu-item active open'; } else { echo 'menu-item'; } ?>">
                <a href="javascript:void(0)"
                    class="<?php if ($sidebar == 'alluser') { echo 'menu-link menu-toggle active'; } else { echo 'menu-link menu-toggle'; } ?>">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Manage">គ្រប់គ្រង</div>
                </a>

                <ul class="menu-sub">
                    <li
                        class="<?php if (in_array($sidebar, ['alluser', 'ealluser'])) { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                        <a href="all-users.php"
                            class="<?php if (in_array($sidebar, ['alluser', 'ealluser'])) { echo 'menu-link active'; } else { echo 'menu-link'; } ?>">
                            <i class="menu-icon tf-icons bx bxs-user-account"></i>
                            <div data-i18n="គ្រប់គ្រងគណនីមន្ត្រី">គ្រប់គ្រងគណនីមន្ត្រី</div>
                        </a>
                    </li>
                    <li
                        class="<?php if (in_array($sidebar, ['admin_account'])) { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                        <a href="admin-account.php"
                            class="<?php if (in_array($sidebar, ['admin_account'])) { echo 'menu-link active'; } else { echo 'menu-link'; } ?>">
                            <i class="menu-icon tf-icons bx bx-user-circle"></i>
                            <div data-i18n="គ្រប់គ្រងគណនីអេតមីន">គ្រប់គ្រងគណនីអេតមីន</div>
                        </a>
                    </li>
                    <li
                        class="<?php if ($sidebar == 'department') { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                        <a href="department.php"
                            class="<?php if ($sidebar == 'department') { echo 'menu-link active'; } else { echo 'menu-link'; } ?>">
                            <i class="menu-icon tf-icons bx bx-buildings"></i>
                            <div data-i18n="គ្រប់គ្រងនាយកដ្ឋាន">គ្រប់គ្រងនាយកដ្ឋាន</div>
                        </a>
                    </li>
                    <li
                        class="<?php if ($sidebar == 'office') { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                        <a href="office.php"
                            class="<?php if ($sidebar == 'office') { echo 'menu-link active'; } else { echo 'menu-link'; } ?>">
                            <i class="menu-icon tf-icons bx bx-building-house"></i>
                            <div data-i18n="គ្រប់គ្រងការិយាល័យ">គ្រប់គ្រងការិយាល័យ</div>
                        </a>
                    </li>
                    <li
                        class="<?php if (in_array($sidebar, ['position', 'eposition'])) { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                        <a href="position.php"
                            class="<?php if (in_array($sidebar, ['position', 'eposition'])) { echo 'menu-link active'; } else { echo 'menu-link'; } ?>">
                            <i class="menu-icon tf-icons bx bxs-user-badge"></i>
                            <div data-i18n="គ្រប់គ្រងតួនាទី">គ្រប់គ្រងតួនាទី</div>
                        </a>
                    </li>
                    <li
                        class="<?php if (in_array($sidebar, ['leavetype', 'eleavetype'])) { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                        <a href="leave-type.php"
                            class="<?php if (in_array($sidebar, ['leavetype', 'eleavetype'])) { echo 'menu-link active'; } else { echo 'menu-link'; } ?>">
                            <i class="menu-icon tf-icons bx bx-calendar-edit"></i>
                            <div data-i18n="គ្រប់គ្រងប្រភេទច្បាប់">គ្រប់គ្រងប្រភេទច្បាប់</div>
                        </a>
                    </li>
                    <li
                        class="<?php if (in_array($sidebar, ['late', 'elate'])) { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                        <a href="late.php"
                            class="<?php if (in_array($sidebar, ['late', 'elate'])) { echo 'menu-link active'; } else { echo 'menu-link'; } ?>">
                            <i class="menu-icon tf-icons bx bx-objects-horizontal-left"></i>
                            <div data-i18n="គ្រប់គ្រងប្រភេទយឺត">គ្រប់គ្រងប្រភេទយឺត</div>
                        </a>
                    </li>
                    <li
                        class="<?php if ($sidebar == 'allsystem') { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                        <a href="all-system.php"
                            class="<?php if ($sidebar == 'allsystem') { echo 'menu-link active'; } else { echo 'menu-link'; } ?>">
                            <i class="menu-icon tf-icons bx bx-grid"></i>
                            <div data-i18n="គ្រប់គ្រងប្រព័ន្ធ">គ្រប់គ្រងប្រព័ន្ធ</div>
                        </a>
                    </li>
                    <li
                        class="<?php if ($sidebar == 'regulator') { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                        <a href="regulator.php"
                            class="<?php if ($sidebar == 'regulator') { echo 'menu-link active'; } else { echo 'menu-link'; } ?>">
                            <i class="menu-icon tf-icons bx bx-file"></i>
                            <div data-i18n="Manage Regulator">គ្រប់គ្រងនិយ័តករ</div>
                        </a>
                    </li>
                    <li
                        class="<?php if ($sidebar == 'report') { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                        <a href="reports.php"
                            class="<?php if ($sidebar == 'report') { echo 'menu-link active'; } else { echo 'menu-link'; } ?>">
                            <i class="menu-icon tf-icons bx bx-file"></i>
                            <div data-i18n="គ្រប់គ្រងរបាយការណ៍សវនកម្ម">គ្រប់គ្រងរបាយការណ៍សវនកម្ម</div>
                        </a>
                    </li>
                    <li
                        class="<?php if (in_array($sidebar, ['role', 'permmission'])) { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-check-shield"></i>
                            <div data-i18n="Role & Permmission">Role & Permmission</div>
                        </a>
                        <ul
                            class="<?php if (in_array($sidebar, ['role', 'permmission'])) { echo 'menu-sub active'; } else { echo 'menu-sub'; } ?>">
                            <li
                                class="<?php if ($sidebar == 'role') { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                                <a href="role.php"
                                    class="<?php if ($sidebar == 'role') { echo 'menu-link active'; } else { echo 'menu-link'; } ?>">
                                    <div data-i18n="Role">Role</div>
                                </a>
                            </li>
                            <li
                                class="<?php if ($sidebar == 'permmission') { echo 'menu-item active'; } else { echo 'menu-item'; } ?>">
                                <a href="permmission.php"
                                    class="<?php if ($sidebar == 'permmission') { echo 'menu-link active'; } else { echo 'menu-link'; } ?>">
                                    <div data-i18n="Permmission">Permmission</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
<?php } ?>