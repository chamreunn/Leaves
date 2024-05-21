<?php
$pageTitle = "កំណត់រចនាសម្ព័ន្ធ";
$sidebar = "settings";
ob_start(); // Start output buffering
include('../../config/dbconn.php');
include('../../controllers/form_process.php');
try {
  // Retrieve existing data if available
  $sql = "SELECT * FROM tblsystemsettings";
  $result = $dbh->query($sql);

  if ($result->rowCount() > 0) {
      // Fetch data and pre-fill the form fields
      $row = $result->fetch(PDO::FETCH_ASSOC);
      $system_name = $row["system_name"];
      // Assuming icon and cover paths are stored in the database
      $icon_path = $row["icon_path"];
      $cover_path = $row["cover_path"];
  } else {
      // If no data available, set default values
      $system_name = "";
      $icon_path = "../../assets/img/avatars/no-image.jpg";
      $cover_path = "../../assets/img/pages/profile-banner.png";
  }
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>
<h5 class="mb-3">System Settings</h5>
<form id="formAuthentication" class="mb-3" onsubmit="submitForm()" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="login_type" value="setting-system">
    <!-- System Name -->
    <div class="row mt-0">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header mb-3 border-bottom">
                    <h6 class="mb-0"><i
                            class='bx bxs-business me-2 mx-0 bg-label-primary rounded-circle p-2 mb-0'></i>System Name
                    </h6>
                </div>
                <div class="card-body">
                    <div class="col-12 fv-plugins-icon-container">
                        <label class="form-label" for="systemname">Full Name</label>
                        <input type="text" id="systemname" class="form-control" placeholder="John Doe" name="systemname"
                            value="<?php echo htmlspecialchars($system_name); ?>">
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Icons System -->
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header mb-3 border-bottom">
                    <h6 class="mb-0"><i
                            class='bx bxs-business mx-0 me-2 bg-label-primary rounded-circle p-2 mb-0'></i>Logo
                        System</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="<?php echo htmlspecialchars($icon_path); ?>" alt="user-avatar"
                            class="d-block rounded-circle" height="100" width="100" id="uploadedAvatar"
                            style="object-fit: cover;">
                        <div class="button-wrapper">
                            <label for="uploadIcon" class="btn btn-outline-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload new icon</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" name="iconfile" id="uploadIcon" class="account-file-input" hidden=""
                                    accept="image/png, image/jpeg">
                            </label>
                            <button type="button" class="btn btn-label-secondary account-image-reset mb-4">
                                <i class="bx bx-reset d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>
                            <p class="text-muted mb-0">Allowed JPG, GIF, or PNG. Max size of 800K</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cover Picture -->
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center mb-3 border-bottom">
                    <h6 class="mb-0"><i
                            class='bx bxs-business mx-0 me-2 bg-label-primary rounded-circle p-2 mb-0'></i>Cover
                        System
                    </h6>
                    <label for="uploadCover" class="btn btn-outline-primary" tabindex="0">
                        <span class="d-none d-sm-block"><i class="bx bx-photo-album me-2"></i>Upload Cover</span>
                        <i class="bx bx-upload d-block d-sm-none"></i>
                        <input type="file" id="uploadCover" name="coverfile" class="account-file-input" hidden
                            accept="image/png, image/jpeg" onchange="displaySelectedCover(this)">
                    </label>
                </div>
                <div class="card-body border-bottom">
                    <div class="user-profile-header-banner text-center">
                        <label for="uploadCover" class="upload-cover-label">
                            <img src="<?php echo htmlspecialchars($cover_path); ?>" alt="Banner image" class="rounded"
                                id="uploadedCover" style="width: 100%;height: 40vh; object-fit: cover;">
                        </label>
                    </div>
                </div>
                <div class="d-flex px-md-4 p-3 justify-content-end">
                    <button type="button" class="btn btn-outline-danger" onclick="resetSettings()">Discard</button>
                    <button class="btn btn-primary mx-2">Save Settings</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
function resetSettings() {
    // Reset form values or perform other actions here
    // For demonstration, let's reload the page
    location.reload();
}
</script>


<?php $content = ob_get_clean(); ?>
<?php include('../../includes/layout.php'); ?>