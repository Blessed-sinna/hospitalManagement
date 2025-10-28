<?php
require_once 'admin_connect.php';

// Initialize database
$database = new Database();
$db = $database->getConnection();

// Check if admin user already exists
$checkQuery = "SELECT id FROM admins WHERE username = 'admin' LIMIT 1";
$stmt = $db->prepare($checkQuery);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "Admin user already exists. Updating password...<br>";
    
    // Update the admin user password
    $password = password_hash('admin123', PASSWORD_DEFAULT);
    $updateQuery = "UPDATE admins SET password = :password, role = 'admin', name = 'System Administrator' WHERE username = 'admin'";
    $stmt = $db->prepare($updateQuery);
    $stmt->bindParam(':password', $password);
    
    if ($stmt->execute()) {
        echo "Admin user updated successfully!<br>";
        echo "Username: admin<br>";
        echo "Password: admin123<br>";
        echo "Role: admin<br>";
    } else {
        echo "Error updating admin user: " . implode(", ", $stmt->errorInfo()) . "<br>";
    }
} else {
    echo "Admin user does not exist. Creating...<br>";
    
    // Create the admin user
    $password = password_hash('admin123', PASSWORD_DEFAULT);
    $insertQuery = "INSERT INTO admins (username, password, role, name, email) VALUES (:username, :password, :role, :name, :email)";
    $stmt = $db->prepare($insertQuery);
    
    $username = 'admin';
    $role = 'admin';
    $name = 'System Administrator';
    $email = 'admin@dwulab.edu.pg';
    
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    
    if ($stmt->execute()) {
        echo "Admin user created successfully!<br>";
        echo "Username: admin<br>";
        echo "Password: admin123<br>";
        echo "Role: admin<br>";
    } else {
        echo "Error creating admin user: " . implode(", ", $stmt->errorInfo()) . "<br>";
    }
}

echo "<br><a href='admin_login.php'>Go to Login Page</a>";
?>