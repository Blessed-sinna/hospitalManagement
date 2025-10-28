<?php
require_once 'admin_connect.php';
require_once 'admin_auth.php';

// Initialize database and auth
$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);

// Check if user is logged in and has technician role
if (!$auth->isLoggedIn() || $auth->getUserRole() !== 'technician') {
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
    <meta name="description" content="Lab Technician Dashboard - DWU Paramed Laboratory">
    <title>Lab Technician Dashboard - DWU Paramed Laboratory</title>

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
                            <ion-icon name="list-outline"></ion-icon>
                        </span>
                        <span class="title">Test Queue</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="flask-outline"></ion-icon>
                        </span>
                        <span class="title">Sample Processing</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Result Entry</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="hardware-chip-outline"></ion-icon>
                        </span>
                        <span class="title">Equipment</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="icon" aria-hidden="true">
                            <ion-icon name="reader-outline"></ion-icon>
                        </span>
                        <span class="title">Protocols</span>
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