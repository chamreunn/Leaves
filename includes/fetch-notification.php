<?php
session_start();
require_once '../../config/dbconn.php';

// Check if the role is 'ប្រធានអង្គភាព'
if ($_SESSION['role'] == 'ប្រធានអង្គភាព') {
  // Fetch notifications
  $sql = "SELECT tblnotifications.*, tbluser.Firstname, tbluser.Lastname, tbluser.Profile
            FROM tblnotifications
            JOIN tbluser ON tblnotifications.user_id = tbluser.id
            ORDER BY tblnotifications.created_at DESC
            LIMIT 10";  // Limit to latest 10 notifications, adjust as needed
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Count total notifications
  $totalNotifications = count($notifications);
  $unreadCount = 0; // Initialize unread count

  // Check if there are no notifications
  if (empty($notifications)) {
    echo '<div class="text-center">
                <img src="../../assets/img/illustrations/empty-box.png" class="avatar avatar-xl mt-4" alt="">
                <h6 class="mt-4">No Notification Found!</h6>
              </div>';
  } else {
    // Generate HTML markup for notifications
    foreach ($notifications as $notification) {
      echo '<li class="list-group-item list-group-item-action d-flex align-items-center">';
      if (!empty($notification['Profile'])) {
        echo '<img src="' . $notification['Profile'] . '" alt="Profile" class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">';
      } else {
        echo '<span class="avatar-initial rounded-circle bg-label-success">' . $notification['Firstname'][0] . $notification['Lastname'][0] . '</span>';
      }

      // Check if the notification is unread
      if ($notification['is_read'] == 0) {
        $unreadCount++;
        echo '<div class="unread-dot"></div>';
      }

      echo '<div class="w-100">
                        <div class="d-flex justify-content-between">
                            <div class="user-info">
                                <h6 class="mb-1">' . $notification['Title'] . '</h6>
                                <p class="mb-0">' . $notification['content'] . '</p>
                                <small class="text-muted">' . $notification['Firstname'] . ' ' . $notification['Lastname'] . '</small>
                            </div>
                            <div class="add-btn">
                                <span class="badge bg-info">' . $notification['status'] . '</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">Created At: ' . $notification['created_at'] . '</small><br>';
      if (!empty($notification['Document'])) {
        echo '<small class="text-muted">Document: <a href="' . $notification['Document'] . '" target="_blank">View Document</a></small>';
      }
      echo '</div>
                    </div>
                    </li>';
    }

    // Display the notification count and update the badge counts
    echo '<script>
                  var totalNotifications = ' . $totalNotifications . ';
                  var unreadCount = ' . $unreadCount . ';
                  $("#notification-count").text(totalNotifications);
                  $("#unread-count").text(unreadCount);
                  if (unreadCount > 0) {
                      $("#notification-count").addClass("has-notifications");
                      $("#unread-count").addClass("has-notifications");
                  } else {
                      $("#notification-count").removeClass("has-notifications");
                      $("#unread-count").removeClass("has-notifications");
                  }
              </script>';
  }
}
