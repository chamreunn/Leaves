<?php
$pageTitle = "ទំព័រដើម";
$sidebar = "report";
ob_start(); // Start output buffering
include('../../config/dbconn.php');
include('../../controllers/form_process.php');
?>
<h2 class="mef2">របាយការណ៍សវនកម្ម</h2>
<!-- First card (always present) -->
<div class="card">
    <div class="card-header">Row 1</div>
    <div class="card-body">
        <form id="formValidationExamples" class="row g-3 needs-validation" method="POST">
            <input type="hidden" name="login_type" value="report">
            <input type="hidden" name="adminid" value="<?php echo $_SESSION['userid'] ?>">
            <div class="mb-3">
                <label for="headline" class="form-label">ចំណងជើង</label>
                <input type="text" class="form-control" id="headline" required autofocus name="headline"
                    placeholder="Input">
            </div>
            <div class="mb-3">
                <label for="paragraph" class="form-label">Paragraph</label>
                <!-- Replace textarea with CKEditor -->
                <textarea class="form-control ckeditor" rows="4" cols="3" id="paragraph" required name="paragraph"
                    placeholder="Textarea"></textarea>
            </div>
            <div class="mb-3">
                <label for="reports" class="form-label">របាយការណ</label>
                <!-- Replace textarea with CKEditor -->
                <textarea class="form-control ckeditor" rows="4" cols="3" id="reports" required name="reports"
                    placeholder="Textarea"></textarea>
            </div>
            <div class="d-flex">
                <button class="btn btn-success mt-3">Submit</button>
            </div>
        </form>

        <!-- Initialize CKEditor for textarea elements -->



    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php include('../../includes/layout.php'); ?>