<?php
require_once 'admin_connect.php';
require_once 'admin_auth.php';

// Initialize database and auth
$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);

// Logout user
$auth->logout();

// Redirect to login page
header("Location: admin_login.php");
exit();
?>