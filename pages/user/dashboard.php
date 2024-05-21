<?php
session_start();
include('../../config/dbconn.php');

// Redirect to index page if the user is not authenticated
if (!isset($_SESSION['userid'])) {
    header('Location: ../../index.php');
    exit();
}

// Set page-specific variables
$pageTitle = "ទំព័រដើម";
$sidebar = "home";
$userId = $_SESSION['userid']; // Assuming the user ID is stored in the session

// Fetch user-specific data from the database if needed
// Example: Leave statistics (Replace with actual database queries)
$leaveTaken = 10; // Replace with a query to fetch the actual number of leaves taken
$leaveApproved = 5; // Replace with a query to fetch the actual number of leaves approved
$leaveRejected = 2; // Replace with a query to fetch the actual number of leaves rejected
$leaveThisWeek = 3; // Replace with a query to fetch the actual number of leaves this week

// Start output buffering
ob_start();
?>
<div class="row">
    <!-- single card  -->
    <div class="col-9 col-sm-12">
        <div class="card mb-4">
            <div class="card-widget-separator-wrapper">
                <div class="card-body card-widget-separator">
                    <div class="row gy-4 gy-sm-1">
                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                <div>
                                    <h3 class="mb-1"><?php echo $leaveTaken; ?></h3>
                                    <p class="mb-0">Leave Taken</p>
                                </div>
                                <span class="badge bg-label-warning rounded p-2 me-sm-4">
                                    <i class='bx bx-calendar-check bx-sm'></i>
                                </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                <div>
                                    <h3 class="mb-1"><?php echo $leaveApproved; ?></h3>
                                    <p class="mb-0">Leave Approved</p>
                                </div>
                                <span class="badge bg-label-success rounded p-2 me-lg-4">
                                    <i class='bx bx-check-double bx-sm'></i>
                                </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                <div>
                                    <h3 class="mb-1"><?php echo $leaveRejected; ?></h3>
                                    <p class="mb-0">Leave Rejected</p>
                                </div>
                                <span class="badge bg-label-danger rounded p-2 me-sm-4">
                                    <i class='bx bx-x-circle bx-sm'></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h3 class="mb-1"><?php echo $leaveThisWeek; ?></h3>
                                    <p class="mb-0">Leave This Week</p>
                                </div>
                                <span class="badge bg-label-primary rounded p-2">
                                    <i class='bx bx-calendar-event bx-sm'></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// Capture the content for the layout
$content = ob_get_clean();

// Include the layout
include('../../includes/layout.php');
?>