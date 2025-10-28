<?php
class Auth {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Login user
    public function login($username, $password, $selectedRole) {
        $query = "SELECT id, username, password, role, name, email FROM admins WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Check if selected role matches user's role
                if ($user['role'] === $selectedRole) {
                    // Update last login
                    $this->updateLastLogin($user['id']);

                    // Start session
                    session_start();
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_username'] = $user['username'];
                    $_SESSION['admin_role'] = $user['role'];
                    $_SESSION['admin_name'] = $user['name'];

                    return true;
                } else {
                    return 'role_mismatch';
                }
            }
        }

        return false;
    }

    // Check if user is logged in
    public function isLoggedIn() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    // Get current user role
    public function getUserRole() {
        if ($this->isLoggedIn()) {
            return $_SESSION['admin_role'];
        }
        return null;
    }

    // Get current user data
    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            return [
                'id' => $_SESSION['admin_id'],
                'username' => $_SESSION['admin_username'],
                'role' => $_SESSION['admin_role'],
                'name' => $_SESSION['admin_name']
            ];
        }
        return null;
    }

    // Logout user
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Unset session variables
        unset($_SESSION['admin_logged_in']);
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_role']);
        unset($_SESSION['admin_name']);

        // Destroy session
        session_destroy();
    }

    // Update last login timestamp
    private function updateLastLogin($userId) {
        $query = "UPDATE admins SET last_login = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    }

    // Check if user has permission
    public function hasPermission($requiredRole) {
        if (!$this->isLoggedIn()) {
            return false;
        }

        $userRole = $this->getUserRole();

        // Define role hierarchy
        $roleHierarchy = [
            'admin' => 4,
            'manager' => 3,
            'technician' => 2,
            'receptionist' => 1
        ];

        return $roleHierarchy[$userRole] >= $roleHierarchy[$requiredRole];
    }
    
    // Debug function to check if user exists
    public function debugUserExists($username) {
        $query = "SELECT * FROM admins WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    
    // Redirect to appropriate dashboard based on role
    public function redirectToDashboard() {
        if (!$this->isLoggedIn()) {
            header("Location: admin_login.php");
            exit();
        }
        
        $role = $this->getUserRole();
        
        switch ($role) {
            case 'admin':
                header("Location: admin_dashboard.php");
                break;
            case 'manager':
                header("Location: manager_dashboard.php");
                break;
            case 'technician':
                header("Location: technician_dashboard.php");
                break;
            case 'receptionist':
                header("Location: receptionist_dashboard.php");
                break;
            default:
                header("Location: admin_login.php");
                break;
        }
        exit();
    }
}
?>