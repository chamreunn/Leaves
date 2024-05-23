<?php
session_start();
// Include database connection
include('../../config/dbconn.php');

// Redirect to index page if the user is not authenticated
if (!isset($_SESSION['userid'])) {
  header('Location: ../../index.php');
  exit();
}

// Set page-specific variables
$pageTitle = "ទំព័រដើម";
$sidebar = "audit";
$userId = $_SESSION['userid']; // Assuming the user ID is stored in the session

// Fetch user-specific data from the database if needed
// Example: Leave statistics (Replace with actual database queries)
$leaveTaken = 10; // Replace with a query to fetch the actual number of leaves taken
$leaveApproved = 5; // Replace with a query to fetch the actual number of leaves approved
$leaveRejected = 2; // Replace with a query to fetch the actual number of leaves rejected
$leaveThisWeek = 3; // Replace with a query to fetch the actual number of leaves this week
// Start output buffering
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $reportTitle = $_POST['report_title'];
  $reportDataStep1 = $_POST['report_data_step1'];
  $step = $_POST['step'];
  $userId = $_SESSION['userid'];

  // Validate form data
  $errors = [];
  if (empty($reportTitle)) {
    $errors[] = "Report title is required";
  }

  if (empty($reportDataStep1)) {
    $errors[] = "Report data is required";
  }

  // Check if there are no errors before inserting into the database
  if (empty($errors)) {
    // File upload handling
    $targetDir = "../../uploads/tblreports/";
    $attachmentStep1 = $_FILES['attachment_step1']['name'];
    $targetFilePath = $targetDir . basename($attachmentStep1);
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowedTypes = array('pdf', 'doc', 'docx');
    if (!in_array($fileType, $allowedTypes)) {
      $errors[] = "Only PDF, DOC, DOCX files are allowed.";
    } else {
      // Upload file to server
      if (move_uploaded_file($_FILES["attachment_step1"]["tmp_name"], $targetFilePath)) {
        // Insert report data into database based on step
        if ($step == 1) {
          $stmt = $dbh->prepare("INSERT INTO tblreports (user_id, report_title, Description, attachment_step1) VALUES (?, ?, ?, ?)");
          $stmt->execute([$userId, $reportTitle, $reportDataStep1, $targetFilePath]);
        } elseif ($step == 2) {
          $stmt = $dbh->prepare("UPDATE tblreports SET step2_approved = 0, Description2 = ?, attachment_step2 = ? WHERE user_id = ? AND step2_approved = 0");
          $stmt->execute([$reportDataStep1, $targetFilePath, $userId]);
        } elseif ($step == 3) {
          $stmt = $dbh->prepare("UPDATE tblreports SET step3_approved = 0, Description3 = ?, attachment_step3 = ? WHERE user_id = ? AND step3_approved = 0");
          $stmt->execute([$reportDataStep1, $targetFilePath, $userId]);
        }

        // Check if the query was successful
        if ($stmt->rowCount() > 0) {
          // Success message or redirect
          $msg = "Report submitted successfully.";
        } else {
          $errors[] = "Failed to submit the report. Please try again.";
        }
      } else {
        $errors[] = "There was an error uploading the file.";
      }
    }
  }
}

try {
  // Fetch reports for the current user, including pending reports
  $stmt = $dbh->prepare("
      SELECT r.*, u.Honorific, u.FirstName, u.LastName, u.RoleId, u.Profile, ro.RoleName
      FROM tblreports r
      JOIN tbluser u ON r.user_id = u.id
      JOIN tblrole ro ON u.RoleId = ro.id
      WHERE r.user_id = :userid
      AND (r.step2_approved = 0 OR r.step3_approved = 0 OR r.step3_approved = 1 OR r.completed = 1)
  ");
  $stmt->bindParam(':userid', $userId);
  $stmt->execute();
  $approvedReports = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Check if any data is fetched
  if (empty($approvedReports)) {
    // No approved reports found
    $message = "No approved reports found for the current user.";
  }
} catch (PDOException $e) {
  // Handle database connection error
  $message = "Database error: " . $e->getMessage();
}
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
<div class="row gy-4 gy-sm-1">
    <div class="col-sm-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h2 class="card-title">Approved Reports</h2>
                    <!-- Button to trigger modal -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requeststep1">
                        Create Report
                    </button>
                </div>
                <?php if (empty($approvedReports)) : ?>
                <div class="d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <img src="../../assets/img/illustrations/empty-box.png" class="avatar avatar-xl mt-4" alt="">
                        <h6 class="mt-4">No data available!</h6>
                    </div>
                </div>
                <?php else : ?>
                <?php foreach ($approvedReports as $approvedReport) : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="border rounded-3 shadow-sm m-2" style="width: 18rem;">
                            <!-- User Avatar -->
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="avatar avatar-lg">
                                    <img src="<?php echo htmlspecialchars($approvedReport['Profile']); ?>" alt="Avatar"
                                        class="rounded-circle mt-2" style="object-fit: cover;">
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- User Name -->
                                <h5 class="card-title text-center mef2 mb-1">
                                    <?php echo htmlspecialchars($approvedReport['Honorific'] . ' ' . $approvedReport['FirstName'] . ' ' . $approvedReport['LastName']); ?>
                                </h5>
                                <!-- User Position -->
                                <p class="card-text text-center mt-0">
                                    <?php echo htmlspecialchars($approvedReport['RoleName']); ?>
                                </p>

                                <!-- Report Title -->
                                <h5 class="card-title">
                                    <?php echo htmlspecialchars($approvedReport['report_title']); ?>
                                </h5>

                                <!-- Approval Status -->
                                <?php if ($approvedReport['completed'] == 1) : ?>
                                <p class="card-text text-center">
                                    <span class="badge bg-label-primary">Completed</span>
                                </p>
                                <a href="view_completed_report.php?id=<?php echo $approvedReport['id']; ?>"
                                    class="btn btn-label-primary w-100">View Report</a>
                                <?php else : ?>
                                <?php if ($approvedReport['step1_approved'] == 1) : ?>
                                <?php if (!empty($approvedReport['report_data_step1'])) : ?>
                                <p class="card-text text-center">
                                    <span class="badge bg-label-success">Report Submitted</span>
                                </p>
                                <!-- Request Date -->
                                <p class="card-text">Request Date:
                                    <?php echo date('d-M-Y', strtotime($approvedReport['created_at'])); ?>
                                </p>
                                <?php if (!empty($approvedReport['attachment_step1'])) : ?>
                                <p class="card-text">Attachment: <a class="text-primary fw-bold"
                                        href="<?php echo htmlspecialchars($approvedReport['attachment_step1']); ?>"
                                        target="_blank">View Document</a></p>
                                <?php endif; ?>

                                <?php if ($approvedReport['step2_approved'] == 0) : ?>
                                <?php if (empty($approvedReport['attachment_step2'])) : ?>
                                <a href="view_report_step1.php?id=<?php echo $approvedReport['id']; ?>"
                                    class="btn btn-info w-100 mb-1">Edit Report</a>
                                <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal"
                                    data-bs-target="#requeststep2">Request Step 2</button>
                                <?php else : ?>
                                <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal"
                                    data-bs-target="#requeststep3" disabled>Request Step 2 (Pending)</button>
                                <?php endif; ?>
                                <?php else : ?>
                                <?php if ($approvedReport['step3_approved'] == 0) : ?>
                                <?php if (empty($approvedReport['attachment_step3'])) : ?>
                                <a href="view_report_step2.php?id=<?php echo $approvedReport['id']; ?>"
                                    class="btn btn-primary w-100 mb-2">Edit Report</a>
                                <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal"
                                    data-bs-target="#requeststep3">Request Step 3</button>
                                <?php else : ?>
                                <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal"
                                    data-bs-target="#requeststep3" disabled>Request Step 3 (Pending)</button>
                                <?php endif; ?>
                                <?php else : ?>
                                <a href="create_report_step3.php?id=<?php echo $approvedReport['id']; ?>"
                                    class="btn btn-primary w-100">Create Report Step 3</a>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php else : ?>

                                <p class="card-text text-center">
                                    <span class="badge bg-label-success">Approved</span>
                                </p>

                                <!-- Request Date -->
                                <p class="card-text">Request Date:
                                    <?php echo date('d-M-Y', strtotime($approvedReport['created_at'])); ?>
                                </p>
                                <?php if (!empty($approvedReport['attachment_step1'])) : ?>
                                <p class="card-text">Attachment: <a class="text-primary fw-bold"
                                        href="<?php echo htmlspecialchars($approvedReport['attachment_step1']); ?>"
                                        target="_blank">View Document</a></p>
                                <?php endif; ?>
                                <a href="create_report_step1.php?id=<?php echo $approvedReport['id']; ?>"
                                    class="btn btn-primary w-100">Create Report Step 1</a>
                                <?php endif; ?>
                                <?php else : ?>
                                <p class="card-text text-center">
                                    <span class="badge bg-label-warning">Pending</span>
                                </p>

                                <!-- Request Date -->
                                <p class="card-text">Request Date:
                                    <?php echo date('d-M-Y', strtotime($approvedReport['created_at'])); ?>
                                </p>
                                <?php if (!empty($approvedReport['attachment_step1'])) : ?>
                                <p class="card-text">Attachment: <a class="text-primary fw-bold"
                                        href="<?php echo htmlspecialchars($approvedReport['attachment_step1']); ?>"
                                        target="_blank">View Document</a></p>
                                <?php endif; ?>
                                <button type="button" class="btn btn-secondary w-100" disabled>Create Report Step
                                    1</button>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Modal for creating a new report - Step 1 -->
<div class="modal animate__animated animate__bounceIn" id="requeststep1" tabindex="-1"
    aria-labelledby="createReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title mef2" id="createReportModalLabel">បង្កើតសំណើ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form for creating a new report - Step 1 -->
                <form id="createReportForm" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="step" value="1">
                    <label class="form-label" for="report_title">ឈ្មោះសំណើ:</label><small
                        class="text-danger fw-bold">*</small><br>
                    <input class="form-control" type="text" value="សេចក្តីព្រាងរបាយការណ៍សវនកម្ម" id="report_title"
                        name="report_title" required><br>
                    <label class="form-label" for="report_data_step1">បរិយាយអំពីសំណើ:</label><br>
                    <textarea class="form-control" id="report_data_step1" name="report_data_step1"></textarea><br>
                    <label class="form-label" for="attachment_step1">ឯកសារភ្ជាប់:</label><small
                        class="text-danger fw-bold">*</small><br>
                    <input class="form-control" type="file" id="attachment_step1" name="attachment_step1" required><br>
                    <button class="btn btn-primary w-100" type="submit">បញ្ជូន</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for creating a new report - Step 2 -->
<div class="modal animate__animated animate__bounceIn" id="requeststep2" tabindex="-1"
    aria-labelledby="createReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title mef2" id="createReportModalLabel">បង្កើតសំណើ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form for creating a new report - Step 2 -->
                <form id="createReportForm" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="step" value="2">
                    <label class="form-label" for="report_title">ឈ្មោះសំណើ:</label><small
                        class="text-danger fw-bold">*</small><br>
                    <input class="form-control" type="text" value="សេចក្តីព្រាងបឋមរបាយការណ៍សវនកម្ម" id="report_title"
                        name="report_title" required><br>
                    <label class="form-label" for="report_data_step1">បរិយាយអំពីសំណើ:</label><br>
                    <textarea class="form-control" id="report_data_step1" name="report_data_step1"></textarea><br>
                    <label class="form-label" for="attachment_step1">ឯកសារភ្ជាប់:</label><small
                        class="text-danger fw-bold">*</small><br>
                    <input class="form-control" type="file" id="attachment_step1" name="attachment_step1" required><br>
                    <button class="btn btn-primary w-100" type="submit">បញ្ជូន</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for creating a new report - Step 3 -->
<div class="modal animate__animated animate__bounceIn" id="requeststep3" tabindex="-1"
    aria-labelledby="createReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->

            <div class="modal-header">
                <h5 class="modal-title mef2" id="createReportModalLabel">បង្កើតសំណើ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form for creating a new report - Step 3 -->
                <form id="createReportForm" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="step" value="3">
                    <label class="form-label" for="report_title">ឈ្មោះសំណើ:</label><small
                        class="text-danger fw-bold">*</small><br>
                    <input class="form-control" type="text" value="របាយការណ៍សវនកម្ម" id="report_title"
                        name="report_title" required><br>
                    <label class="form-label" for="report_data_step1">បរិយាយអំពីសំណើ:</label><br>
                    <textarea class="form-control" id="report_data_step1" name="report_data_step1"></textarea><br>
                    <label class="form-label" for="attachment_step1">ឯកសារភ្ជាប់:</label><small
                        class="text-danger fw-bold">*</small><br>
                    <input class="form-control" type="file" id="attachment_step1" name="attachment_step1" required><br>
                    <button class="btn btn-primary w-100" type="submit">បញ្ជូន</button>
                </form>
            </div>
        </div>
    </div>
</div>





<?php $content = ob_get_clean(); ?>

<?php include('../../includes/layout.php'); ?>