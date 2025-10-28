<?php
require_once 'admin_connect.php';
require_once 'admin_auth.php';

// Initialize database and auth
$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);

// Check if user is logged in and has receptionist role
if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'receptionist') {
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
    <meta name="description" content="Receptionist Dashboard - DWU Paramed Laboratory">
    <title>Receptionist Dashboard - DWU Paramed Laboratory</title>

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
                            <ion-icon name="calendar-outline"></ion-icon>
                        </span>
                        <span class="title">Appointments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="person-add-outline"></ion-icon>
                        </span>
                        <span class="title">Patient Registration</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="checkmark-done-outline"></ion-icon>
                        </span>
                        <span class="title">Check-in/Check-out</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="cash-outline"></ion-icon>
                        </span>
                        <span class="title">Billing</span>
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