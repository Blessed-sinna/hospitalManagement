<?php
session_start();
require_once 'admin_connect.php';
require_once 'admin_auth.php';

// Initialize database and auth
$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);

// If already logged in, redirect to appropriate dashboard
if ($auth->isLoggedIn()) {
    $auth->redirectToDashboard();
    exit();
}

// Process login
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (empty($username) || empty($password) || empty($role)) {
        $error = "All fields are required";
    } else {
        // Debug: Check if user exists
        $userDebug = $auth->debugUserExists($username);
        
        if (!$userDebug) {
            $error = "User '$username' does not exist in the database";
        } else {
            $loginResult = $auth->login($username, $password, $role);

            if ($loginResult === true) {
                // Login successful, redirect to appropriate dashboard
                $auth->redirectToDashboard();
            } elseif ($loginResult === 'role_mismatch') {
                $error = "You don't have permission to access with the selected role. Your role is: " . $userDebug['role'];
            } else {
                $error = "Invalid username or password";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - DWU Paramed Laboratory</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Ubuntu", sans-serif;
        }

        body {
            background: linear-gradient(135deg, #2c5282, #4299e1);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 30px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            background: #f7fafc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-header .logo ion-icon {
            font-size: 40px;
            color: #2c5282;
        }

        .login-header h1 {
            color: #2c5282;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .login-header p {
            color: #718096;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2d3748;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #4299e1;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: #2c5282;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #4299e1;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: #fed7d7;
            color: #c53030;
            border: 1px solid #feb2b2;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #718096;
            font-size: 14px;
        }
        
        .debug-info {
            margin-top: 15px;
            padding: 10px;
            background: #f7fafc;
            border-radius: 8px;
            font-size: 12px;
            color: #4a5568;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo">
                <ion-icon name="flask-outline"></ion-icon>
            </div>
            <h1>DWU Laboratory</h1>
            <p>Admin Login System</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="admin_login.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="admin" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" value="admin123" required>
            </div>

            <div class="form-group">
                <label for="role">Login As</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="">Select Role</option>
                    <option value="admin" selected>System Admin</option>
                    <option value="manager">Lab Manager</option>
                    <option value="technician">Lab Technician</option>
                    <option value="receptionist">Receptionist</option>
                </select>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> DWU Paramed Laboratory. All rights reserved.</p>
        </div>
        
        <div class="debug-info">
            <p><strong>Default Credentials:</strong></p>
            <p>Username: admin</p>
            <p>Password: admin123</p>
            <p>Role: System Admin</p>
        </div>
    </div>

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>