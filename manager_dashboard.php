<?php
require_once 'admin_connect.php';
require_once 'admin_auth.php';

// Initialize database and auth
$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);

// Check if user is logged in and has manager role
if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'manager') {
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
    <meta name="description" content="Lab Manager Dashboard - DWU Paramed Laboratory">
    <title>Lab Manager Dashboard - DWU Paramed Laboratory</title>

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
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="flask-outline"></ion-icon>
                        </span>
                        <span class="title">Lab Operations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Staff Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="bar-chart-outline"></ion-icon>
                        </span>
                        <span class="title">Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </span>
                        <span class="title">Scheduling</span>
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
                    <h1 id="welcome-heading">Lab Management Dashboard</h1>
                    <p>Oversee laboratory operations, staff, and performance metrics</p>
                </section>

                <div class="card-grid">
                    <div class="card">
                        <div class="card-content">
                            <div class="numbers">142</div>
                            <div class="cardName">Tests Today</div>
                        </div>
                        <div class="iconBx" aria-hidden="true">
                            <ion-icon name="flask-outline"></ion-icon>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content">
                            <div class="numbers">12</div>
                            <div class="cardName">Staff On Duty</div>
                        </div>
                        <div class="iconBx" aria-hidden="true">
                            <ion-icon name="people-outline"></ion-icon>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content">
                            <div class="numbers">92%</div>
                            <div class="cardName">On-Time Completion</div>
                        </div>
                        <div class="iconBx" aria-hidden="true">
                            <ion-icon name="timer-outline"></ion-icon>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content">
                            <div class="numbers">K4,250</div>
                            <div class="cardName">Revenue Today</div>
                        </div>
                        <div class="iconBx" aria-hidden="true">
                            <ion-icon name="cash-outline"></ion-icon>
                        </div>
                    </div>
                </div>

                <div class="details-section">
                    <section class="performance-metrics" aria-labelledby="performance-heading">
                        <div class="section-header">
                            <h2 id="performance-heading">Performance Metrics</h2>
                            <a href="#" class="btn">Full Report</a>
                        </div>

                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <ion-icon name="bar-chart-outline"></ion-icon>
                                <p>Test Volume Chart</p>
                            </div>
                        </div>
                    </section>

                    <section class="staff-schedule" aria-labelledby="staff-heading">
                        <div class="section-header">
                            <h2 id="staff-heading">Staff Schedule</h2>
                            <a href="#" class="btn">Manage</a>
                        </div>

                        <div class="schedule-list">
                            <div class="schedule-item">
                                <div class="staff-info">
                                    <img src="images/staff1.jpg" alt="Staff photo">
                                    <div>
                                        <h4>Dr. Michael Chen</h4>
                                        <p>Pathologist</p>
                                    </div>
                                </div>
                                <div class="schedule-shift">
                                    <span>8:00 AM - 4:00 PM</span>
                                </div>
                            </div>

                            <div class="schedule-item">
                                <div class="staff-info">
                                    <img src="images/staff2.jpg" alt="Staff photo">
                                    <div>
                                        <h4>Linda Johnson</h4>
                                        <p>Lab Technician</p>
                                    </div>
                                </div>
                                <div class="schedule-shift">
                                    <span>9:00 AM - 5:00 PM</span>
                                </div>
                            </div>

                            <div class="schedule-item">
                                <div class="staff-info">
                                    <img src="images/staff3.jpg" alt="Staff photo">
                                    <div>
                                        <h4>Robert Smith</h4>
                                        <p>Lab Technician</p>
                                    </div>
                                </div>
                                <div class="schedule-shift">
                                    <span>12:00 PM - 8:00 PM</span>
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