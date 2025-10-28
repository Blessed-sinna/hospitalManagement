<?php
require_once 'admin_connect.php';
require_once 'admin_auth.php';

// Initialize database and auth
$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);

// Check if user is logged in and has admin role
if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

// Get current user data
$currentUser = $auth->getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="System Administrator Dashboard - DWU Paramed Laboratory">
    <title>System Admin Dashboard - DWU Paramed Laboratory</title>

    <!-- Styles -->
    <link rel="stylesheet" href="css/admin_style.css">

    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://unpkg.com">
</head>
<body>
    <div class="app-container">
        <!-- ============= Navigation =========== -->
        <nav class="navigation" role="navigation" aria-label="Main navigation">
            <div class="nav-header">
                <a href="#" class="brand">
                    <span class="icon" aria-hidden="true">
                        <ion-icon name="flask-outline"></ion-icon>
                    </span>
                    <span class="title">DWU Lab Admin</span>
                </a>
            </div>

            <ul class="nav-menu" id="navMenu">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="grid-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin_manage_users.php" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">User Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="shield-outline"></ion-icon>
                        </span>
                        <span class="title">Security</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="server-outline"></ion-icon>
                        </span>
                        <span class="title">System Health</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Audit Logs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Settings</span>
                    </a>
                </li>
                <li class="nav-item nav-logout">
                    <a href="admin_logout.php" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Log Out</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="topbar" role="banner">
                <button class="menu-toggle" aria-label="Toggle navigation menu" aria-expanded="false">
                    <ion-icon name="menu-outline"></ion-icon>
                </button>

                <div class="logo">
                    <img src="images/dwu_logo.png" alt="DWU Paramed Laboratory logo">
                </div>

                <div class="search">
                    <label for="search-input" class="visually-hidden">Search</label>
                    <input type="text" id="search-input" placeholder="Search dashboard..." aria-label="Search">
                    <button type="submit" aria-label="Submit search">
                        <ion-icon name="search-outline"></ion-icon>
                    </button>
                </div>

                <div class="user-actions">
                    <button class="notification-btn" aria-label="Notifications">
                        <ion-icon name="notifications-outline"></ion-icon>
                        <span class="notification-badge" aria-hidden="true">5</span>
                    </button>

                    <div class="user-profile">
                        <img src="images/image4.jpg" alt="Admin profile picture">
                        <span class="user-name"><?php echo htmlspecialchars($currentUser['name']); ?></span>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="dashboard-content" id="dashboardContent">
                <section class="welcome-banner" aria-labelledby="welcome-heading">
                    <h1 id="welcome-heading">System Administration Dashboard</h1>
                    <p>Manage system-wide settings, users, and security configurations</p>
                </section>

                <div class="card-grid">
                    <div class="card">
                        <div class="card-content">
                            <div class="numbers">24</div>
                            <div class="cardName">Active Users</div>
                        </div>
                        <div class="iconBx" aria-hidden="true">
                            <ion-icon name="people-outline"></ion-icon>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content">
                            <div class="numbers">98%</div>
                            <div class="cardName">System Uptime</div>
                        </div>
                        <div class="iconBx" aria-hidden="true">
                            <ion-icon name="server-outline"></ion-icon>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content">
                            <div class="numbers">3</div>
                            <div class="cardName">Pending Updates</div>
                        </div>
                        <div class="iconBx" aria-hidden="true">
                            <ion-icon name="cloud-download-outline"></ion-icon>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content">
                            <div class="numbers">0</div>
                            <div class="cardName">Security Alerts</div>
                        </div>
                        <div class="iconBx" aria-hidden="true">
                            <ion-icon name="shield-checkmark-outline"></ion-icon>
                        </div>
                    </div>
                </div>

                <div class="details-section">
                    <section class="system-overview" aria-labelledby="system-heading">
                        <div class="section-header">
                            <h2 id="system-heading">System Overview</h2>
                            <a href="#" class="btn">View Details</a>
                        </div>

                        <div class="system-metrics">
                            <div class="metric-card">
                                <h3>Database Status</h3>
                                <div class="status-indicator active"></div>
                                <p>Operational</p>
                            </div>

                            <div class="metric-card">
                                <h3>Backup Status</h3>
                                <div class="status-indicator active"></div>
                                <p>Last: Today 03:00 AM</p>
                            </div>

                            <div class="metric-card">
                                <h3>API Health</h3>
                                <div class="status-indicator active"></div>
                                <p>All endpoints responsive</p>
                            </div>

                            <div class="metric-card">
                                <h3>Storage Usage</h3>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 65%"></div>
                                </div>
                                <p>65% of 1TB used</p>
                            </div>
                        </div>
                    </section>

                    <section class="recent-activity" aria-labelledby="activity-heading">
                        <div class="section-header">
                            <h2 id="activity-heading">Recent Activity</h2>
                            <a href="#" class="btn">View All</a>
                        </div>

                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <ion-icon name="person-add-outline"></ion-icon>
                                </div>
                                <div class="activity-details">
                                    <h4>New user registered</h4>
                                    <p>Dr. Sarah Johnson added to system</p>
                                    <span class="activity-time">2 hours ago</span>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon">
                                    <ion-icon name="shield-outline"></ion-icon>
                                </div>
                                <div class="activity-details">
                                    <h4>Security scan completed</h4>
                                    <p>No vulnerabilities detected</p>
                                    <span class="activity-time">5 hours ago</span>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon">
                                    <ion-icon name="cloud-download-outline"></ion-icon>
                                </div>
                                <div class="activity-details">
                                    <h4>System backup completed</h4>
                                    <p>All data successfully backed up</p>
                                    <span class="activity-time">Today, 03:00 AM</span>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>

    <!-- Accessibility: Skip to content link -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Scripts -->
    <script src="js/admin_main.js"></script>

    <!-- Use Icon from Ionicon -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>