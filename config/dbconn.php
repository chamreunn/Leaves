<?php
// Database connection parameters
$host = '172.16.15.66'; // Hostname
$dbname = 'employeeleavedb'; // Database name
$username = 'root'; // Database username
$password = '*Iau@20242024'; // Database password

try {
  // Create a PDO instance
  $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

  // Set PDO error mode to exception
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Optionally, set character encoding
  $dbh->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
  // Handle connection errors
  echo "Connection failed: " . $e->getMessage();
}
