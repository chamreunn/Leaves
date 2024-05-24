<?php
// include('../config/dbconn.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $loginType = $_POST['login_type'];

  if ($loginType == 'setting-system') {
    // Handle system settings
    try {
      // Retrieve form data
      $system_name = $_POST["systemname"];
      $icon_file = $_FILES["iconfile"]["name"];
      $icon_temp = $_FILES["iconfile"]["tmp_name"];
      $cover_file = $_FILES["coverfile"]["name"];
      $cover_temp = $_FILES["coverfile"]["tmp_name"];

      // Check if data already exists in the database
      $sql = "SELECT * FROM tblsystemsettings";
      $result = $dbh->query($sql);

      if ($result->rowCount() > 0) {
        // Update existing data
        $sql = "UPDATE tblsystemsettings SET system_name='$system_name'";
        if ($icon_file != "") {
          move_uploaded_file($icon_temp, "../../assets/img/pages/icons_page/" . $icon_file);
          $sql .= ", icon_path='../../assets/img/pages/icons_page/$icon_file'";
        }
        if ($cover_file != "") {
          move_uploaded_file($cover_temp, "../../assets/img/pages/cover_page/" . $cover_file);
          $sql .= ", cover_path='../../assets/img/pages/cover_page/$cover_file'";
        }
      } else {
        // Insert new data
        $sql = "INSERT INTO tblsystemsettings (system_name, icon_path, cover_path) VALUES ('$system_name', '../../assets/img/pages/icons_page/$icon_file', '../../assets/img/pages/cover_page/$cover_file')";
      }

      $dbh->exec($sql);
      sleep(2); // Optional delay
      $msg = "Settings saved successfully";
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  } elseif ($loginType == 'role') {
    // Retrieve form data
    $roleName = $_POST['rname'];
    $color = $_POST['colors'];
    $permissionIds = isset($_POST['pid']) ? $_POST['pid'] : array(); // Retrieve permission IDs

    try {
      // Insert or update role in tblrole
      if (!empty($_POST['role_id'])) {
        // Update role if role_id is provided
        $roleId = $_POST['role_id'];
        $sql = "UPDATE tblrole SET RoleName = :roleName, Colors = :color WHERE id = :roleId";
      } else {
        // Insert new role
        $sql = "INSERT INTO tblrole (RoleName, Colors, CreationDate, UpdateAt) VALUES (:roleName, :color, NOW(), NOW())";
      }

      // Prepare the SQL statement
      $stmt = $dbh->prepare($sql);

      // Bind parameters
      $stmt->bindParam(':roleName', $roleName, PDO::PARAM_STR);
      $stmt->bindParam(':color', $color, PDO::PARAM_STR);
      if (!empty($_POST['role_id'])) {
        // Bind roleId parameter if updating role
        $stmt->bindParam(':roleId', $roleId, PDO::PARAM_INT);
      }

      // Execute the query
      if ($stmt->execute()) {
        // If insertion/update is successful
        $roleId = !empty($_POST['role_id']) ? $_POST['role_id'] : $dbh->lastInsertId();

        // Delete existing role-permission relationships
        $sqlDeleteRolePermissions = "DELETE FROM tblrolepermission WHERE RoleId = :roleId";
        $stmtDeleteRolePermissions = $dbh->prepare($sqlDeleteRolePermissions);
        $stmtDeleteRolePermissions->bindParam(':roleId', $roleId, PDO::PARAM_INT);
        $stmtDeleteRolePermissions->execute();

        // Update existing permissions for this role in tblpermission
        foreach ($permissionIds as $permissionId) {
          $sqlUpdatePermission = "UPDATE tblpermission SET RoleId = :roleId WHERE PermissionId = :permissionId";
          $stmtUpdatePermission = $dbh->prepare($sqlUpdatePermission);
          $stmtUpdatePermission->bindParam(':roleId', $roleId, PDO::PARAM_INT);
          $stmtUpdatePermission->bindParam(':permissionId', $permissionId, PDO::PARAM_INT);
          $stmtUpdatePermission->execute();

          // Insert new role-permission relationships into tblrolepermission
          $sqlInsertRolePermission = "INSERT INTO tblrolepermission (RoleId, PermissionId) VALUES (:roleId, :permissionId)";
          $stmtInsertRolePermission = $dbh->prepare($sqlInsertRolePermission);
          $stmtInsertRolePermission->bindParam(':roleId', $roleId, PDO::PARAM_INT);
          $stmtInsertRolePermission->bindParam(':permissionId', $permissionId, PDO::PARAM_INT);
          $stmtInsertRolePermission->execute();
        }

        $msg = "Role updated successfully";
      } else {
        // If there's an error
        $error = "Error updating role";
      }
    } catch (PDOException $e) {
      // Handle database errors
      $error = "Database error: " . $e->getMessage();
    }
  } elseif ($loginType == 'permission') {
    // Retrieve form data
    $permissionName = $_POST['modalPermissionName'];
    $engPermissionName = $_POST['engnameper'];
    $permissionType = $_POST['pertype'];
    $permissionIcon = $_POST['pericons'];

    try {
      // Insert permission into tblpermission
      $sql = "INSERT INTO tblpermission (PermissionName, EngName, Type, IconClass, CreationDate, UpdateAt) VALUES (:permissionName, :engPermissionName, :permissionType, :permissionIcon, NOW(), NOW())";

      // Prepare the SQL statement
      $stmt = $dbh->prepare($sql);

      // Bind parameters
      $stmt->bindParam(':permissionName', $permissionName, PDO::PARAM_STR);
      $stmt->bindParam(':engPermissionName', $engPermissionName, PDO::PARAM_STR);
      $stmt->bindParam(':permissionType', $permissionType, PDO::PARAM_STR);
      $stmt->bindParam(':permissionIcon', $permissionIcon, PDO::PARAM_STR);

      // Execute the query
      if ($stmt->execute()) {
        $msg = "Permission inserted successfully";
      } else {
        $error = "Error inserting permission";
      }
    } catch (PDOException $e) {
      // Handle database errors
      $error = "Database error: " . $e->getMessage();
    }
  } elseif ($loginType == 'regulator_name') {
    // Retrieve form data
    $regulatorname = $_POST['regulatorname'];
    $shortname = $_POST['shortname'];

    try {
      // Insert permission into tblpermission
      $sql = "INSERT INTO tblregulator (RegulatorName, ShortName, created_at) VALUES (:regulatorname, :shortname, NOW())";

      // Prepare the SQL statement
      $stmt = $dbh->prepare($sql);

      // Bind parameters
      $stmt->bindParam(':regulatorname', $regulatorname, PDO::PARAM_STR);
      $stmt->bindParam(':shortname', $shortname, PDO::PARAM_STR);

      // Execute the query
      if ($stmt->execute()) {
        $msg = "Regulator inserted successfully";
      } else {
        $error = "Error inserting permission";
      }
    } catch (PDOException $e) {
      // Handle database errors
      $error = "Database error: " . $e->getMessage();
    }
  } elseif ($loginType == 'adduser') {
    try {
      // Retrieve form data
      $honorific = $_POST['honorific'];
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $gender = $_POST['gender'];
      $contact = $_POST['contact'];
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password']; // No hashing here
      $status = $_POST['status'];
      $dob = $_POST['dob'];
      $department = $_POST['department'];
      $office = $_POST['office'];
      $role = $_POST['role'];
      $address = $_POST['address'];
      $permissions = isset($_POST['permissionid']) ? implode(",", $_POST['permissionid']) : '';
      $profileImage = '';

      // Handle file upload
      if ($_FILES['profile']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["profile"]["tmp_name"];
        $name = basename($_FILES["profile"]["name"]);
        $target_dir = __DIR__ . "/var/www/html/assets/img/avatars/";
        $target_file = $target_dir . $name;
        $relative_path = "/var/www/html/assets/img/avatars/" . $name;

        if (move_uploaded_file($tmp_name, $target_file)) {
          $profileImage = $relative_path;
        } else {
          $error = "Failed to upload profile image.";
        }
      }

      // Check for duplicate username, email, firstname, lastname, and contact
      $sql_check_duplicate = "SELECT * FROM tbluser WHERE  Email = :email OR Contact = :contact";
      $stmt_check_duplicate = $dbh->prepare($sql_check_duplicate);
      $stmt_check_duplicate->bindParam(':email', $email);
      $stmt_check_duplicate->bindParam(':contact', $contact);
      $stmt_check_duplicate->execute();

      if ($stmt_check_duplicate->rowCount() > 0) {
        $error = "User with the same Email or Contact already exists.";
      } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert data into tbluser
        $sql_insert_user = "INSERT INTO tbluser (Honorific, FirstName, LastName, Gender, Contact, UserName, Email, Password, Status, DateofBirth, Department, Office, RoleId, PermissionId, Address, Profile, CreationDate, UpdateAt)
                                VALUES (:honorific, :firstname, :lastname, :gender, :contact, :username, :email, :password, :status, :dob, :department, :office, :role, :permissions, :address, :profileImage, NOW(), NOW())";

        $query_insert_user = $dbh->prepare($sql_insert_user);

        // Bind parameters and execute query
        $query_insert_user->bindParam(':honorific', $honorific, PDO::PARAM_STR);
        $query_insert_user->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $query_insert_user->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $query_insert_user->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query_insert_user->bindParam(':contact', $contact, PDO::PARAM_STR);
        $query_insert_user->bindParam(':username', $username, PDO::PARAM_STR);
        $query_insert_user->bindParam(':email', $email, PDO::PARAM_STR);
        $query_insert_user->bindParam(':password', $hashedPassword, PDO::PARAM_STR); // Using hashed password
        $query_insert_user->bindParam(':status', $status, PDO::PARAM_INT);
        $query_insert_user->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query_insert_user->bindParam(':department', $department, PDO::PARAM_STR);
        $query_insert_user->bindParam(':office', $office, PDO::PARAM_STR);
        $query_insert_user->bindParam(':role', $role, PDO::PARAM_INT);
        $query_insert_user->bindParam(':permissions', $permissions, PDO::PARAM_STR);
        $query_insert_user->bindParam(':address', $address, PDO::PARAM_STR);
        $query_insert_user->bindParam(':profileImage', $profileImage, PDO::PARAM_STR);

        if ($query_insert_user->execute()) {
          $msg = "User inserted successfully.";

          // Get the ID of the inserted user
          $last_insert_id = $dbh->lastInsertId();

          // Get the list of user IDs associated with the role
          $sql_get_user_ids = "SELECT UserId FROM tblrole WHERE id = :role";
          $stmt_get_user_ids = $dbh->prepare($sql_get_user_ids);
          $stmt_get_user_ids->bindParam(':role', $role, PDO::PARAM_INT);
          $stmt_get_user_ids->execute();
          $user_ids = $stmt_get_user_ids->fetchAll(PDO::FETCH_COLUMN);

          // Append the newly inserted user ID to the list of user IDs associated with the role
          $user_ids[] = $last_insert_id;

          // Update the AssignTo field in tblrole table with the updated list of user IDs
          $updated_user_ids = implode(',', $user_ids);
          $sql_update_assign_to = "UPDATE tblrole SET UserId = :updated_user_ids WHERE id = :role";
          $stmt_update_assign_to = $dbh->prepare($sql_update_assign_to);
          $stmt_update_assign_to->bindParam(':updated_user_ids', $updated_user_ids, PDO::PARAM_STR);
          $stmt_update_assign_to->bindParam(':role', $role, PDO::PARAM_INT);
          $stmt_update_assign_to->execute();
        } else {
          $error = "Error inserting user.";
        }
      }
    } catch (PDOException $e) {
      $error = "Database error: " . $e->getMessage();
    }
  } elseif ($loginType == 'update-permission') {
    try {
      // Assuming $getid contains the user ID
      $userId = $_POST['upermission'];

      // Prepare permission string
      $permissions = isset($_POST['pid']) ? implode(",", $_POST['pid']) : '';

      // Update permissions in tbluser
      $sql = "UPDATE tbluser SET PermissionId = :permissions WHERE id = :userId";
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(':permissions', $permissions, PDO::PARAM_STR);
      $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

      if ($stmt->execute()) {
        $msg = "Permissions updated successfully.";
      } else {
        $error = "Failed to update permissions.";
      }
    } catch (PDOException $e) {
      $error = "Database error: " . $e->getMessage();
    }
  } elseif ($loginType == 'updatepass') {
    // Handle password update
    if (!empty($_POST["updatepassid"]) && !empty($_POST["formValidationPass"]) && !empty($_POST["formValidationConfirmPass"])) {
      $getid = $_POST['updatepassid'];
      $password = $_POST['formValidationPass'];
      $confirmPassword = $_POST['formValidationConfirmPass'];

      // Check if passwords match
      if ($password === $confirmPassword) {
        // Check if password meets requirements
        if (preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.{8,})/', $password)) {
          // Hash the password using MD5
          $hashedPassword = md5($password);

          // Update password in tbluser table
          try {
            $query = "UPDATE tbluser SET Password = :password WHERE id = :id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':id', $getid);
            $stmt->execute();
            sleep(1);
            $msg = 'ពាក្យសម្ងាត់បានធ្វើឲ្យប្រសើរប្រាស់ប្រាក់ទទួលបានដោយជោគជ័យ។';
          } catch (PDOException $e) {
            // Handle database errors
            sleep(1);
            $error = "កំហុស​ក្នុង​ទិន្នន័យ​ម៉ោងរបស់បញ្ហាទិញជាំទទួល: " . $e->getMessage();
          }
        } else {
          sleep(1);
          $error = 'ពាក្យសម្ងាត់ត្រូវតែធំជាងមួយ ៨ តួ មាន​តួ​អក្សរ​ធំមួយតួ និង​មាន​និមិត្ត​ទឹកប្រាក់មួយតួ។';
        }
      } else {
        sleep(1);
        $error = 'ពាក្យសម្ងាត់មិនត្រូវដល់។';
      }
    } else {
      sleep(1);
      $error = 'សូម​ផ្ដល់​ពាក្យសម្ងាត់​ដើម្បី​ធ្វើ​ឲ្យបាន​ប៉ុន្មាន។';
    }
  } elseif ($loginType == 'twofacode') {
    // Handle 2FA secret update
    if (!empty($_POST['twofacodeid']) && !empty($_POST['modalEnableOTPPhone']) && !empty($_POST['secret'])) {
      $getid = intval($_POST['twofacodeid']);
      $authCode = $_POST['modalEnableOTPPhone'];
      $secret = $_POST['secret'];

      // Verify the authentication code
      $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
      if ($g->checkCode($secret, $authCode)) {
        try {
          $query = "UPDATE tbluser SET TwoFASecret = :secret, authenticator_enabled = 1 WHERE id = :id";
          $stmt = $dbh->prepare($query);
          $stmt->bindParam(':secret', $secret);
          $stmt->bindParam(':id', $getid, PDO::PARAM_INT);
          $stmt->execute();

          // Set success message
          $msg = "Two-factor authentication disconnected successfully.";
          // Redirect or refresh the page
          header("Location: " . $_SERVER['PHP_SELF'] . "?uid=" . $getid);
          exit();
        } catch (PDOException $e) {
          // Handle database errors
          $error = "Error updating the secret: " . $e->getMessage();
        }
      } else {
        $error = 'Invalid authentication code.';
      }
    } else {
      $error = 'Please provide the authentication code.';
    }
  } elseif ($loginType == 'disconnect_twofa') {
    // Handle disconnecting 2FA
    if (!empty($_POST['twofacodeid'])) {
      $getid = intval($_POST['twofacodeid']);

      try {
        // Clear TwoFASecret and set authenticator_enabled to 0
        $query = "UPDATE tbluser SET TwoFASecret = NULL, authenticator_enabled = 0 WHERE id = :id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':id', $getid, PDO::PARAM_INT);
        $stmt->execute();

        // Set success message
        $msg = "Two-factor authentication disconnected successfully.";

        // Redirect or refresh the page
        header("Location: " . $_SERVER['PHP_SELF'] . "?uid=" . $getid);
      } catch (PDOException $e) {
        // Handle database errors
        $error = "Error disconnecting 2FA: " . $e->getMessage();
      }
    } else {
      $error = 'User ID is missing.';
    }
  } elseif ($loginType == 'report') {
    if (!empty($_POST['adminid'])) {
      $getid = intval($_POST['adminid']);

      try {
        // Prepare SQL statement
        $stmt = $dbh->prepare("INSERT INTO form_data (headline, paragraph, data, admin_id)
        VALUES (:headline, :paragraph, :reports, :adminid)");

        // Bind parameters and execute the statement
        $stmt->bindParam(':headline', $_POST['headline']);
        $stmt->bindParam(':paragraph', $_POST['paragraph']);
        $stmt->bindParam(':reports', $_POST['reports']);
        $stmt->bindParam(':adminid', $_POST['adminid']);
        $stmt->execute();

        // Set success message
        $msg = "Report submitted successfully!";
      } catch (PDOException $e) {
        // Handle database errors
        $error = "Error submitting report: " . $e->getMessage();
      }
    } else {
      $error = 'User ID is missing.';
    }
  } elseif ($loginType == 'requests') {
    $userId = $_POST['userId'];
    $headofunit = $_POST['headofunit'];
    $regulatorId = isset($_POST['regulator']) ? $_POST['regulator'] : '';
    $description = isset($_POST['formValidationName']) ? $_POST['formValidationName'] : '';
    $document = $_FILES['document'];
    $title = 'សំណើបង្កើតសេចក្តីព្រាងរបាយការណ៍។';

    // Handle file upload
    $targetDir = "../../assets/img/documents/";
    $fileName = basename($document['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow only certain file formats
    $allowedTypes = ['jpg', 'png', 'pdf', 'doc', 'docx'];
    if (!in_array($fileType, $allowedTypes)) {
      die('Sorry, only JPG, PNG, PDF, DOC, & DOCX files are allowed.');
    }

    // Move uploaded file to the target directory
    if (!move_uploaded_file($document['tmp_name'], $targetFilePath)) {
      die('Sorry, there was an error uploading your file.');
    }

    // Insert data into the database
    $sql = "INSERT INTO tblrequests (user_id, Regulator,Title, Description, send_to, Document)
    VALUES (:user_id, :regulator_id,:title, :description, :sendto, :document_path)";
    $stmt = $dbh->prepare($sql);

    try {
      $stmt->execute([
        ':user_id' => $userId,
        ':regulator_id' => $regulatorId,
        ':title' => $title,
        ':description' => $description,
        ':sendto' => $headofunit,
        ':document_path' => $targetFilePath
      ]);
      $msg = 'Request submitted successfully.';

      // Log activity
      $activityName = $_POST['formValidationName'];
      $activityDate = date('Y-m-d H:i:s');
      $activityDescription = 'បានដាក់សំណើបង្កើតរបាយការណ៍ព្រាងសវនកម្ម។';
      $createdBy = $userId;

      $activitySql = "INSERT INTO tblactivity (UserId, ActivityName, ActivityDate, ActivityDescription, CreatedBy)
                        VALUES (:user_id, :activity_name, :activity_date, :activity_description, :created_by)";
      $activityStmt = $dbh->prepare($activitySql);
      $activityStmt->execute([
        ':user_id' => $userId,
        ':activity_name' => $activityName,
        ':activity_date' => $activityDate,
        ':activity_description' => $activityDescription,
        ':created_by' => $createdBy
      ]);

      // Create notification for admin
      $userid = $userId;
      $adminId = $headofunit; // Assuming admin user ID is 1, adjust this according to your database
      $notificationContent = 'បានដាក់' . " " . $title; // Customize notification content as needed
      $notificationType = 'request'; // Customize notification type as needed

      $notificationSql = "INSERT INTO tblnotifications (user_id, content,send_to, type) VALUES (:user_id, :content, :sendto, :type)";
      $notificationStmt = $dbh->prepare($notificationSql);
      $notificationStmt->execute([
        ':user_id' => $userid,
        ':content' => $notificationContent,
        ':sendto' => $adminId,
        ':type' => $notificationType
      ]);
    } catch (PDOException $e) {
      $error = 'Error: ' . $e->getMessage();
    }
  } elseif ($loginType == 'departments') {
    // Check if form fields are not empty
    if (!empty($_POST['department']) && !empty($_POST['headdep'])) {
      // Retrieve form data
      $departmentName = $_POST['department'];
      $headofunit = $_POST['headofunit'];
      $depheadofunit = implode(",", $_POST["depheadofunit"]);
      $headOfDepartment = $_POST['headdep'];
      $depHeadOfDepartment = $_POST["deheaddep"];

      try {
        // Prepare SQL statement
        $stmt = $dbh->prepare("INSERT INTO tbldepartments
        (DepartmentName, HeadOfDepartment, DepHeadOfDepartment, HeadOfUnit, DepHeadOfUnit ,CreationDate)
            VALUES (:department, :headdep, :deheaddep, :headofunit, :depheadofunit, NOW())");

        // Bind parameters and execute the statement
        $stmt->bindParam(':department', $departmentName);
        $stmt->bindParam(':headdep', $headOfDepartment);
        $stmt->bindParam(':deheaddep', $depHeadOfDepartment);
        $stmt->bindParam(':headofunit', $headofunit);
        $stmt->bindParam(':depheadofunit', $depheadofunit);
        $stmt->execute();

        // Set success message
        $msg = "Department created successfully!";
      } catch (PDOException $e) {
        // Handle database errors
        $error = "Error creating department: " . $e->getMessage();
      }
    } else {
      $error = 'Please fill in all required fields.';
    }
  } elseif ($loginType == 'edepartment') {
    // Check if form fields are not empty
    if (!empty($_POST['edepname']) && !empty($_POST['eheaddep'])) {
      // Retrieve form data
      $departmentName = $_POST['edepname'];
      $headofunit = $_POST['eheadofunit'];
      $depheadofunit = implode(",", $_POST["edepheadofunit"]);
      $headOfDepartment = $_POST['eheaddep'];
      $depHeadOfDepartment = $_POST["edeheaddep"];
      $getid = $_POST['edepid'];

      try {
        // Prepare SQL statement
        $stmt = $dbh->prepare("UPDATE tbldepartments SET
        DepartmentName = :department,
        HeadOfUnit = :headofunit,
        DepHeadOfUnit = :depheadofunit,
        HeadOfDepartment = :headdep,
        DepHeadOfDepartment = :deheaddep,
        UpdateAt = NOW() WHERE id = :departmentId");

        // Bind parameters and execute the statement
        $stmt->bindParam(':department', $departmentName);
        $stmt->bindParam(':headofunit', $headofunit);
        $stmt->bindParam(':depheadofunit', $depheadofunit);
        $stmt->bindParam(':headdep', $headOfDepartment);
        $stmt->bindParam(':deheaddep', $depHeadOfDepartment);
        $stmt->bindParam(':departmentId', $getid);
        $stmt->execute();

        // Set success message
        $msg = "Department updated successfully!";
      } catch (PDOException $e) {
        // Handle database errors
        $error = "Error updating department: " . $e->getMessage();
      }
    } else {
      $error = 'Please fill in all required fields.';
    }
  } elseif ($loginType == 'insert_report') {
    try {
      // Prepare the insert statement
      $stmt = $dbh->prepare("UPDATE tblreports SET headline = :headline, report_data_step1 = :data WHERE id = :requestid");

      // Initialize arrays to store all headlines and data
      $allHeadlines = [];
      $allData = [];

      // Loop through form data and collect headlines and data
      foreach ($_POST as $key => $value) {
        // Check if the key corresponds to a headline or textarea input
        if (strpos($key, 'headline') !== false) {
          $index = substr($key, strlen('headline'));
          $allHeadlines[$index] = $value;
        } elseif (strpos($key, 'formValidationTextarea') !== false) {
          $index = substr($key, strlen('formValidationTextarea'));
          $allData[$index] = $value;
        }
      }

      // Combine all headlines and data into strings separated by a delimiter
      $headlineString = implode(',', $allHeadlines);
      $dataString = implode(',', $allData);

      // Get user ID (replace this with your user ID retrieval method)
      $user_id = $_SESSION['userid'];
      $requestid = $_POST['requestid'];
      $status = 'processing'; // Typo corrected from 'proccessing' to 'processing'

      // Bind parameters and execute the statement
      $stmt->bindParam(':headline', $headlineString);
      $stmt->bindParam(':data', $dataString);
      $stmt->bindParam(':requestid', $requestid);
      $stmt->execute();

      // Set success message
      $msg = "success";
      sleep(1);
      header('Location: dashboard.php');
    } catch (PDOException $e) {
      // Handle database errors
      echo "Error: " . $e->getMessage();
      exit();
    }
  } elseif ($loginType == 'edit_report') {
    $reportId = $_POST['reportid'];
    $updatedData = $_POST['updatedData'];

    try {
      // Prepare the update statement
      $stmt = $dbh->prepare("UPDATE tblreports SET report_data_step1 = :data WHERE id = :id");

      // Bind parameters
      $stmt->bindValue(':data', implode(',', $updatedData), PDO::PARAM_STR);
      $stmt->bindParam(':id', $reportId, PDO::PARAM_INT);

      // Execute the statement
      if ($stmt->execute()) {
        $msg = 'success';
      } else {
        // Log execution failure
        error_log("Error executing SQL query: " . implode(' ', $stmt->errorInfo()));
        $error = "Failed to execute SQL query";
      }
    } catch (PDOException $e) {
      // Handle database errors
      error_log("Database error: " . $e->getMessage());
      $error = "Database error: " . $e->getMessage();
    }
  } elseif ($loginType == 'requests2') {
    $status = 'pending';
    $title = 'សំណើបង្កើតសេចក្តីព្រាងបឋមរបាយការណ៍សវនកម្ម។';
    $requestid = $_POST['requestid'];

    // Ensure the request ID is set and not empty
    if (isset($requestid) && !empty($requestid)) {
      // Prepare SQL query to update the request
      $sql = "UPDATE tblrequests SET Title = :title, status = :status WHERE id = :requestid";
      $stmt = $dbh->prepare($sql);

      try {
        // Execute the prepared statement with the provided parameters
        $stmt->execute([
          ':title' => $title,
          ':status' => $status,
          ':requestid' => $requestid
        ]);
        $msg = 'Request submitted successfully.';
      } catch (PDOException $e) {
        // Capture and handle the error if the query fails
        $error = 'Error: ' . $e->getMessage();
      }
    } else {
      $error = 'Invalid request ID.';
    }
  } elseif ($loginType == 'requestfinall') {
    $status = 'inprocess';
    $title = 'សំណើបង្កើតរបាយការណ៍សវនកម្ម។';
    $requestid = $_POST['requestid'];

    // Ensure the request ID is set and not empty
    if (isset($requestid) && !empty($requestid)) {
      // Prepare SQL query to update the request
      $sql = "UPDATE tblrequests SET Title = :title, status = :status WHERE id = :requestid";
      $stmt = $dbh->prepare($sql);

      try {
        // Execute the prepared statement with the provided parameters
        $stmt->execute([
          ':title' => $title,
          ':status' => $status,
          ':requestid' => $requestid
        ]);
        $msg = 'Request submitted successfully.';
      } catch (PDOException $e) {
        // Capture and handle the error if the query fails
        $error = 'Error: ' . $e->getMessage();
      }
    } else {
      $error = 'Invalid request ID.';
    }
  } elseif ($loginType == 'report2') {
    $reportId = $_POST['reportid'];
    $updatedData = $_POST['updatedData']; // This will be an array

    try {
      // Begin transaction
      $dbh->beginTransaction();

      $data = implode(',', array_map('trim', $updatedData));

      $stmt = $dbh->prepare("UPDATE tblrequests SET data = :data, status = 'inprogress' WHERE id = :id");
      $stmt->bindParam(':data', $data, PDO::PARAM_STR);
      $stmt->bindParam(':id', $reportId, PDO::PARAM_INT);
      $stmt->execute();

      // Commit transaction
      $dbh->commit();

      $msg = 'Request updated and status set to pending successfully.';
    } catch (PDOException $e) {
      // Rollback transaction on error
      $dbh->rollBack();
      $error = 'Error: ' . $e->getMessage();
    }
  } elseif ($loginType == 'end-report') {
    $reportId = $_POST['reportid'];
    $updatedData = $_POST['updatedData']; // This will be an array

    try {
      // Begin transaction
      $dbh->beginTransaction();

      // Update the data in tblrequests
      $data = implode(',', array_map('trim', $updatedData));

      $stmt = $dbh->prepare("UPDATE tblrequests SET data = :data, status = 'completed' WHERE id = :id");
      $stmt->bindParam(':data', $data, PDO::PARAM_STR);
      $stmt->bindParam(':id', $reportId, PDO::PARAM_INT);
      $stmt->execute();

      // Commit transaction
      $dbh->commit();

      $msg = 'Request updated and status set to pending successfully.';
    } catch (PDOException $e) {
      // Rollback transaction on error
      $dbh->rollBack();
      $error = 'Error: ' . $e->getMessage();
    }
  } elseif ($loginType == 'report1') {
    $userId = $_POST['userid'];
    $reportTitle = htmlspecialchars($_POST['report_title']);
    $reportData = htmlspecialchars($_POST['report_data']);
    $targetDir = "../uploads/tblreports/"; // Adjust the path as per your file structure
    $targetFile = $targetDir . basename($_FILES["attachment"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is a valid image or PDF
    if ($fileType != "jpg" && $fileType != "jpeg" && $fileType != "png" && $fileType != "pdf") {
      $error = "Sorry, only JPG, JPEG, PNG, and PDF files are allowed.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["attachment"]["size"] > 5000000) {
      $error = "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    if ($uploadOk && move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFile)) {
      $stmt = $dbh->prepare("INSERT INTO tblreports (user_id, report_title, report_data_step1, attachment_step1) VALUES (:userId, :reportTitle, :reportData, :attachment)");
      $stmt->bindParam(':userId', $userId);
      $stmt->bindParam(':reportTitle', $reportTitle);
      $stmt->bindParam(':reportData', $reportData);
      $stmt->bindParam(':attachment', $targetFile);

      if ($stmt->execute()) {
        $msg = "Report submitted successfully.";
      } else {
        $error = "Error submitting report.";
      }
    } else {
      $error = "Sorry, there was an error uploading your file.";
    }
  } elseif ($loginType == 'createreport2') {
    $reportId = $_POST['reportid'];
    $updatedData = $_POST['updatedData'];
    $headline = $_POST['headline'];

    try {
      // Prepare the update statement
      $stmt = $dbh->prepare("UPDATE tblreports SET report_data_step2 = :data, headline =:headline WHERE id = :id");

      // Bind parameters
      $stmt->bindValue(':data', implode(',', $updatedData), PDO::PARAM_STR);
      $stmt->bindValue(':headline', implode(',', $headline), PDO::PARAM_STR);
      $stmt->bindParam(':id', $reportId, PDO::PARAM_INT);

      // Execute the statement
      if ($stmt->execute()) {
        $msg = 'success';
        sleep(1);
        header('Location: dashboard.php');
      } else {
        // Log execution failure
        error_log("Error executing SQL query: " . implode(' ', $stmt->errorInfo()));
        $error = "Failed to execute SQL query";
      }
    } catch (PDOException $e) {
      // Handle database errors
      error_log("Database error: " . $e->getMessage());
      $error = "Database error: " . $e->getMessage();
    }
  } elseif ($loginType == 'createreport3') {
    $reportId = $_POST['reportid'];
    $updatedData = $_POST['updatedData'];
    $headline = $_POST['headline'];
    $completed = '1';

    try {
      // Prepare the update statement
      $stmt = $dbh->prepare("UPDATE tblreports SET report_data_step3 = :data, headline =:headline, completed =:completed WHERE id = :id");

      // Bind parameters
      $stmt->bindValue(':data', implode(',', $updatedData), PDO::PARAM_STR);
      $stmt->bindValue(':headline', implode(',', $headline), PDO::PARAM_STR);
      $stmt->bindParam(':completed', $completed, PDO::PARAM_INT);
      $stmt->bindParam(':id', $reportId, PDO::PARAM_INT);

      // Execute the statement
      if ($stmt->execute()) {
        $msg = 'success';
        sleep(1);
        header('Location: dashboard.php');
      } else {
        // Log execution failure
        error_log("Error executing SQL query: " . implode(' ', $stmt->errorInfo()));
        $error = "Failed to execute SQL query";
      }
    } catch (PDOException $e) {
      // Handle database errors
      error_log("Database error: " . $e->getMessage());
      $error = "Database error: " . $e->getMessage();
    }
  } else {
    $error = "Invalid login type.";
  }
}
