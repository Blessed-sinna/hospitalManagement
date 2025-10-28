<?php
require_once 'admin_connect.php';

// Initialize database
$database = new Database();
$db = $database->getConnection();

// Function to create a user
function createUser($db, $username, $password, $role, $name, $email) {
    // Check if user already exists
    $checkQuery = "SELECT id FROM admins WHERE username = :username LIMIT 1";
    $stmt = $db->prepare($checkQuery);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "User '$username' already exists. Updating...<br>";
        
        // Update the user password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE admins SET password = :password, role = :role, name = :name, email = :email WHERE username = :username";
        $stmt = $db->prepare($updateQuery);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        
        if ($stmt->execute()) {
            echo "User '$username' updated successfully!<br>";
        } else {
            echo "Error updating user '$username': " . implode(", ", $stmt->errorInfo()) . "<br>";
        }
    } else {
        echo "Creating user '$username'...<br>";
        
        // Create the user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO admins (username, password, role, name, email) VALUES (:username, :password, :role, :name, :email)";
        $stmt = $db->prepare($insertQuery);
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        
        if ($stmt->execute()) {
            echo "User '$username' created successfully!<br>";
        } else {
            echo "Error creating user '$username': " . implode(", ", $stmt->errorInfo()) . "<br>";
        }
    }
}

// Create admin user
createUser($db, 'admin', 'admin123', 'admin', 'System Administrator', 'admin@dwulab.edu.pg');

// Create manager user
createUser($db, 'manager', 'manager123', 'manager', 'Lab Manager', 'manager@dwulab.edu.pg');

// Create technician user
createUser($db, 'technician', 'tech123', 'technician', 'Lab Technician', 'tech@dwulab.edu.pg');

// Create receptionist user
createUser($db, 'receptionist', 'recept123', 'receptionist', 'Receptionist', 'reception@dwulab.edu.pg');

echo "<br><h3>Test Users Created:</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Username</th><th>Password</th><th>Role</th><th>Name</th></tr>";
echo "<tr><td>admin</td><td>admin123</td><td>System Admin</td><td>System Administrator</td></tr>";
echo "<tr><td>manager</td><td>manager123</td><td>Lab Manager</td><td>Lab Manager</td></tr>";
echo "<tr><td>technician</td><td>tech123</td><td>Lab Technician</td><td>Lab Technician</td></tr>";
echo "<tr><td>receptionist</td><td>recept123</td><td>Receptionist</td><td>Receptionist</td></tr>";
echo "</table>";

echo "<br><a href='admin_login.php'>Go to Login Page</a>";
?>