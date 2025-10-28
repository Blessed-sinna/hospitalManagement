<?php
require_once 'admin_connect.php';
require_once 'admin_auth.php';

// Initialize database and auth
$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);

// Check if user is logged in
if (!$auth->isLoggedIn()) {
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
    <meta name="description" content="Laboratory Management System Admin Dashboard">
    <title>Admin Dashboard - DWU Paramed Laboratory</title>

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

            <!-- Role Selection -->
            <div class="role-selector">
                <div class="role-label">Current Role:</div>
                <div class="role-dropdown">
                    <button class="role-toggle" id="roleToggle">
                        <span id="currentRole"><?php echo ucfirst($currentUser['role']); ?></span>
                        <ion-icon name="chevron-down-outline"></ion-icon>
                    </button>
                    <div class="role-menu" id="roleMenu">
                        <?php if ($currentUser['role'] === 'admin'): ?>
                            <a href="#" data-role="admin">System Admin</a>
                        <?php endif; ?>
                        <?php if (in_array($currentUser['role'], ['admin', 'manager'])): ?>
                            <a href="#" data-role="manager">Lab Manager</a>
                        <?php endif; ?>
                        <?php if (in_array($currentUser['role'], ['admin', 'manager', 'technician'])): ?>
                            <a href="#" data-role="technician">Lab Technician</a>
                        <?php endif; ?>
                        <?php if (in_array($currentUser['role'], ['admin', 'manager', 'receptionist'])): ?>
                            <a href="#" data-role="receptionist">Receptionist</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <ul class="nav-menu" id="navMenu">
                <!-- Navigation items will be dynamically populated based on role -->
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
                <!-- Content will be dynamically loaded based on role -->
            </div>
        </main>
    </div>

    <!-- Accessibility: Skip to content link -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Templates for different role views -->
    <template id="adminView">
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
    </template>

    <template id="managerView">
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
    </template>

    <template id="technicianView">
        <section class="welcome-banner" aria-labelledby="welcome-heading">
            <h1 id="welcome-heading">Lab Technician Dashboard</h1>
            <p>Manage test queue, process samples, and enter results</p>
        </section>

        <div class="card-grid">
            <div class="card">
                <div class="card-content">
                    <div class="numbers">18</div>
                    <div class="cardName">Pending Tests</div>
                </div>
                <div class="iconBx" aria-hidden="true">
                    <ion-icon name="time-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="numbers">7</div>
                    <div class="cardName">In Progress</div>
                </div>
                <div class="iconBx" aria-hidden="true">
                    <ion-icon name="flask-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="numbers">24</div>
                    <div class="cardName">Completed Today</div>
                </div>
                <div class="iconBx" aria-hidden="true">
                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="numbers">3</div>
                    <div class="cardName">Urgent Tests</div>
                </div>
                <div class="iconBx" aria-hidden="true">
                    <ion-icon name="alert-circle-outline"></ion-icon>
                </div>
            </div>
        </div>

        <div class="details-section">
            <section class="test-queue" aria-labelledby="queue-heading">
                <div class="section-header">
                    <h2 id="queue-heading">Test Queue</h2>
                    <div class="filter-options">
                        <button class="filter-btn active">All</button>
                        <button class="filter-btn">Pending</button>
                        <button class="filter-btn">In Progress</button>
                        <button class="filter-btn">Urgent</button>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Test ID</th>
                                <th scope="col">Patient</th>
                                <th scope="col">Test Type</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>T-10245</td>
                                <td>John Doe</td>
                                <td>CBC</td>
                                <td><span class="priority high">High</span></td>
                                <td><span class="status pending">Pending</span></td>
                                <td>
                                    <button class="action-btn">Start</button>
                                </td>
                            </tr>

                            <tr>
                                <td>T-10246</td>
                                <td>Jane Smith</td>
                                <td>Lipid Panel</td>
                                <td><span class="priority medium">Medium</span></td>
                                <td><span class="status in-progress">In Progress</span></td>
                                <td>
                                    <button class="action-btn">Continue</button>
                                </td>
                            </tr>

                            <tr>
                                <td>T-10247</td>
                                <td>Robert Johnson</td>
                                <td>HbA1c</td>
                                <td><span class="priority low">Low</span></td>
                                <td><span class="status pending">Pending</span></td>
                                <td>
                                    <button class="action-btn">Start</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="equipment-status" aria-labelledby="equipment-heading">
                <div class="section-header">
                    <h2 id="equipment-heading">Equipment Status</h2>
                    <a href="#" class="btn">View All</a>
                </div>

                <div class="equipment-list">
                    <div class="equipment-item">
                        <div class="equipment-icon">
                            <ion-icon name="hardware-chip-outline"></ion-icon>
                        </div>
                        <div class="equipment-details">
                            <h4>Hematology Analyzer</h4>
                            <div class="status-indicator active"></div>
                            <p>Operational</p>
                        </div>
                    </div>

                    <div class="equipment-item">
                        <div class="equipment-icon">
                            <ion-icon name="hardware-chip-outline"></ion-icon>
                        </div>
                        <div class="equipment-details">
                            <h4>Chemistry Analyzer</h4>
                            <div class="status-indicator active"></div>
                            <p>Operational</p>
                        </div>
                    </div>

                    <div class="equipment-item">
                        <div class="equipment-icon">
                            <ion-icon name="hardware-chip-outline"></ion-icon>
                        </div>
                        <div class="equipment-details">
                            <h4>Centrifuge</h4>
                            <div class="status-indicator warning"></div>
                            <p>Maintenance Due</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </template>

    <template id="receptionistView">
        <section class="welcome-banner" aria-labelledby="welcome-heading">
            <h1 id="welcome-heading">Reception Dashboard</h1>
            <p>Manage patient appointments, registrations, and front-desk operations</p>
        </section>

        <div class="card-grid">
            <div class="card">
                <div class="card-content">
                    <div class="numbers">24</div>
                    <div class="cardName">Appointments Today</div>
                </div>
                <div class="iconBx" aria-hidden="true">
                    <ion-icon name="calendar-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="numbers">8</div>
                    <div class="cardName">Checked In</div>
                </div>
                <div class="iconBx" aria-hidden="true">
                    <ion-icon name="checkmark-done-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="numbers">5</div>
                    <div class="cardName">Waiting</div>
                </div>
                <div class="iconBx" aria-hidden="true">
                    <ion-icon name="hourglass-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="numbers">3</div>
                    <div class="cardName">New Registrations</div>
                </div>
                <div class="iconBx" aria-hidden="true">
                    <ion-icon name="person-add-outline"></ion-icon>
                </div>
            </div>
        </div>

        <div class="details-section">
            <section class="today-schedule" aria-labelledby="schedule-heading">
                <div class="section-header">
                    <h2 id="schedule-heading">Today's Schedule</h2>
                    <a href="#" class="btn">Add Appointment</a>
                </div>

                <div class="appointment-list">
                    <div class="appointment-card">
                        <div class="appointment-time">
                            <div class="time">9:00 AM</div>
                        </div>
                        <div class="appointment-details">
                            <h3>John Doe</h3>
                            <div class="appointment-meta">
                                <span><ion-icon name="person-outline"></ion-icon> Dr. Sarah Johnson</span>
                                <span><ion-icon name="flask-outline"></ion-icon> Blood Work</span>
                            </div>
                        </div>
                        <div class="appointment-status">
                            <span class="status-badge checked-in">Checked In</span>
                        </div>
                    </div>

                    <div class="appointment-card">
                        <div class="appointment-time">
                            <div class="time">9:30 AM</div>
                        </div>
                        <div class="appointment-details">
                            <h3>Jane Smith</h3>
                            <div class="appointment-meta">
                                <span><ion-icon name="person-outline"></ion-icon> Dr. Michael Chen</span>
                                <span><ion-icon name="flask-outline"></ion-icon> Urinalysis</span>
                            </div>
                        </div>
                        <div class="appointment-status">
                            <span class="status-badge waiting">Waiting</span>
                        </div>
                    </div>

                    <div class="appointment-card">
                        <div class="appointment-time">
                            <div class="time">10:00 AM</div>
                        </div>
                        <div class="appointment-details">
                            <h3>Robert Johnson</h3>
                            <div class="appointment-meta">
                                <span><ion-icon name="person-outline"></ion-icon> Dr. Linda Williams</span>
                                <span><ion-icon name="flask-outline"></ion-icon> Lipid Panel</span>
                            </div>
                        </div>
                        <div class="appointment-status">
                            <span class="status-badge scheduled">Scheduled</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="quick-actions" aria-labelledby="actions-heading">
                <div class="section-header">
                    <h2 id="actions-heading">Quick Actions</h2>
                </div>

                <div class="action-grid">
                    <button class="action-card">
                        <div class="action-icon">
                            <ion-icon name="person-add-outline"></ion-icon>
                        </div>
                        <div class="action-title">New Patient</div>
                        <div class="action-desc">Register a new patient</div>
                    </button>

                    <button class="action-card">
                        <div class="action-icon">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                        <div class="action-title">Schedule</div>
                        <div class="action-desc">Book an appointment</div>
                    </button>

                    <button class="action-card">
                        <div class="action-icon">
                            <ion-icon name="checkmark-done-outline"></ion-icon>
                        </div>
                        <div class="action-title">Check In</div>
                        <div class="action-desc">Check in patient</div>
                    </button>

                    <button class="action-card">
                        <div class="action-icon">
                            <ion-icon name="cash-outline"></ion-icon>
                        </div>
                        <div class="action-title">Payment</div>
                        <div class="action-desc">Process payment</div>
                    </button>
                </div>
            </section>
        </div>
    </template>

    <!-- Scripts -->
    <script>
        // Pass the user role to JavaScript
        const currentUserRole = '<?php echo $currentUser['role']; ?>';
    </script>
    <script src="js/admin_main.js"></script>

    <!-- Use Icon from Ionicon -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>