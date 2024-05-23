<?php
// Fetch user permissions from tbl_user_permissions
$userId = $_SESSION['userid']; // Assuming you have the user's ID stored in the session
$query = "SELECT PermissionId FROM tbluser WHERE id = :userId";
$stmt = $dbh->prepare($query);
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$userPermissions = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Prepare a comma-separated string of permission IDs for the SQL query
$permissionIds = implode(',', $userPermissions);

// Query to fetch sidebar menu details based on user permissions
$query = "SELECT p.PermissionName, p.NavigationUrl, p.IconClass, p.EngName
          FROM tblpermission p
          WHERE p.id IN ($permissionIds)";

// Execute the query and fetch sidebar menu details
$stmt = $dbh->query($query);
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$currentUrl = basename($_SERVER['PHP_SELF']); // Get the current page filename
?>

<aside id="layout-menu" class="layout-menu-horizontal menu menu-horizontal container-fluid flex-grow-0 bg-menu-theme"
    data-bg-class="bg-menu-theme"
    style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">

            <li class="menu-item active">
                <a href="dashboard.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="Audit Reports">Audit Reports</div>
                </a>
            </li>
        </ul>
    </div>
</aside>


<!-- <div class="container-xxl d-flex h-100">
    <ul class="menu-inner">
        <?php foreach ($menuItems as $item): ?>
        <li class="menu-item <?php echo ($item['NavigationUrl'] === $currentUrl) ? 'active' : ''; ?>">
            <a href="<?php echo $item['NavigationUrl']; ?>" class="menu-link">
                <i class="menu-icon tf-icons bx <?php echo $item['IconClass']; ?>"></i>
                <div data-i18n="<?php echo $item['EngName']; ?>"><?php echo $item['PermissionName']; ?></div>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div> -->
