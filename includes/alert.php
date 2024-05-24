<!-- Display success or error message -->
<?php if (isset($_GET['msg'])) { ?>
  <div class="bs-toast toast toast-ex animate__animated my-2 fade <?php echo ($_GET['status'] == 'success') ? 'bg-success' : 'bg-danger'; ?> animate__bounceInRight show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="1000">
    <div class="toast-header">
      <i class="bx bx-bell me-2"></i>
      <div class="me-auto fw-medium"><?php echo ($_GET['status'] == 'success') ? 'ជោគជ័យ' : 'បរាជ័យ'; ?></div>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <?php echo htmlentities($_GET['msg']); ?>
    </div>
  </div>
<?php } ?>
<script>
  setTimeout(function() {
    $('.toast').addClass(
      'bs-toast toast toast-ex animate__animated animate__slideOutRight'
    ); // Add the "fading-up" class to trigger animation
  }, 3000);

  // Auto dismiss after a certain duration
  setTimeout(function() {
    $('.toast').fadeTo("slow", 0.1, function() {
      $('.toast').alert('close')
    });
  }, 5000); // Adjust timing as needed

  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>
