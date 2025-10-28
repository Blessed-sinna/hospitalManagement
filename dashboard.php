<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Patient Portal for accessing medical records, appointments, and health information">
    <title>Patient Portal - DWU Paramed Laboratory</title>
    
    <!-- Styles -->
    <style>
    /* Google fonts */
    @import url('https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');
    /* Globals */
    * {
        font-family: "Ubuntu", sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    :root {
        /* Patient-friendly color palette */
        --primary: #2c7a7b;      /* Calming teal */
        --primary-light: #4fd1c5; /* Lighter teal */
        --secondary: #4299e1;    /* Soft blue */
        --accent: #ed8936;       /* Warm orange for highlights */
        --success: #48bb78;      /* Green for positive status */
        --warning: #ecc94b;      /* Yellow for pending status */
        --danger: #e53e3e;       /* Red for urgent items */
        --white: #fff;
        --background: #f7fafc;    /* Light gray background */
        --card-bg: #ffffff;
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --border: #e2e8f0;
        --shadow: rgba(0, 0, 0, 0.08);
    }
    body {
        min-height: 100vh;
        overflow-x: hidden;
        background-color: var(--background);
        color: var(--text-primary);
    }
    .app-container {
        position: relative;
        width: 100%;
        display: flex;
    }
    /* Skip to content link for accessibility */
    .skip-link {
        position: absolute;
        top: -40px;
        left: 0;
        background: var(--primary);
        color: white;
        padding: 8px;
        z-index: 100;
        transition: top 0.3s;
    }
    .skip-link:focus {
        top: 0;
    }
    /* Navigation panel */
    .navigation {
        position: fixed;
        width: 260px;
        height: 100%;
        background: var(--primary);
        transition: 0.5s;
        overflow: hidden;
        z-index: 100;
        display: flex;
        flex-direction: column;
    }
    .navigation.active {
        width: 70px;
    }
    .nav-header {
        padding: 20px 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .brand {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--white);
    }
    .brand .icon {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }
    .brand .icon ion-icon {
        font-size: 1.8rem;
    }
    .brand .title {
        font-size: 1.2rem;
        font-weight: 600;
        white-space: nowrap;
    }
        /* Navigation panel */
.navigation {
    position: fixed;
    width: 260px;
    height: 100%;
    background: var(--primary);
    transition: 0.5s;
    overflow: hidden;
    z-index: 100;
    display: flex;
    flex-direction: column;
}

/* Scrollable navigation area */
.nav-scrollable {
    flex: 1;
    overflow-y: auto;
    /* Hide scrollbar for cleaner look */
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
}

/* For Webkit browsers (Chrome, Safari) */
.nav-scrollable::-webkit-scrollbar {
    width: 6px;
}

.nav-scrollable::-webkit-scrollbar-track {
    background: transparent;
}

.nav-scrollable::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
}

/* Logout container - stays at bottom */
.nav-logout-container {
    flex-shrink: 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

/* Rest of your existing navigation styles... */
    .nav-menu {
        list-style: none;
        padding: 20px 0;
        flex: 1;
    }
    .nav-item {
        position: relative;
    }
    .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        text-decoration: none;
        color: rgba(255, 255, 255, 0.8);
        transition: all 0.3s;
    }
    .nav-link:hover, .nav-link.active {
        background-color: rgba(255, 255, 255, 0.1);
        color: var(--white);
    }
    .nav-link.active {
        border-left: 4px solid var(--accent);
    }
    .nav-link .icon {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }
    .nav-link .icon ion-icon {
        font-size: 1.5rem;
    }
    .nav-link .title {
        white-space: nowrap;
        transition: opacity 0.3s;
    }
    .navigation.active .nav-link .title {
        opacity: 0;
    }
    .nav-logout {
        margin-top: auto;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    /* Main content */
    .main-content {
        position: absolute;
        width: calc(100% - 260px);
        left: 260px;
        min-height: 100vh;
        background: var(--background);
        transition: 0.5s;
    }
    .main-content.active {
        width: calc(100% - 70px);
        left: 70px;
    }
    /* Topbar */
    .topbar {
        width: 100%;
        height: 70px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
        background: var(--card-bg);
        box-shadow: 0 2px 10px var(--shadow);
    }
    .menu-toggle {
        background: none;
        border: none;
        font-size: 1.8rem;
        color: var(--text-primary);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        transition: background 0.3s;
    }
    .menu-toggle:hover {
        background: var(--background);
    }
    .logo {
        width: 50px;
        height: 50px;
    }
    .logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .search {
        position: relative;
        width: 400px;
    }
    .search label {
        position: relative;
        width: 100%;
        display: flex;
        align-items: center;
    }
    .search label input {
        width: 100%;
        height: 40px;
        border-radius: 20px;
        padding: 5px 20px;
        padding-left: 40px;
        font-size: 16px;
        outline: none;
        border: 1px solid var(--border);
        background: var(--background);
    }
    .search label input:focus {
        border-color: var(--primary-light);
    }
    .search label ion-icon {
        position: absolute;
        left: 12px;
        font-size: 1.2rem;
        color: var(--text-secondary);
    }
    .user-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .notification-btn {
        position: relative;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--text-primary);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        transition: background 0.3s;
    }
    .notification-btn:hover {
        background: var(--background);
    }
    .notification-badge {
        position: absolute;
        top: 0;
        right: 0;
        background: var(--danger);
        color: white;
        font-size: 0.7rem;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .user-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }
    .user-profile img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-light);
    }
    .user-name {
        font-weight: 500;
    }
    /* Dashboard content */
    .dashboard-content {
        padding: 20px;
    }
    /* Welcome banner */
    .welcome-banner {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        padding: 25px 30px;
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px var(--shadow);
    }
    .welcome-banner h1 {
        font-size: 1.8rem;
        margin-bottom: 8px;
    }
    .welcome-banner p {
        font-size: 1rem;
        opacity: 0.9;
    }
    .welcome-banner strong {
        color: var(--warning);
    }
    /* Card grid */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        grid-gap: 20px;
        margin-bottom: 30px;
    }
    .card {
        background: var(--card-bg);
        border-radius: 15px;
        padding: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 15px var(--shadow);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px var(--shadow);
    }
    .card-content {
        flex: 1;
    }
    .numbers {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 5px;
    }
    .cardName {
        color: var(--text-secondary);
        font-size: 1rem;
    }
    .iconBx {
        font-size: 2.5rem;
        color: var(--primary-light);
        opacity: 0.8;
    }
    /* Details section */
    .details-section {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }
    @media (min-width: 992px) {
        .details-section {
            grid-template-columns: 2fr 1fr;
        }
    }
    /* Section headers */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .section-header h2 {
        font-size: 1.5rem;
        color: var(--text-primary);
        font-weight: 600;
    }
    .btn {
        display: inline-block;
        padding: 8px 16px;
        background: var(--primary);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        transition: background 0.3s;
        border: none;
        cursor: pointer;
    }
    .btn:hover {
        background: var(--primary-light);
    }
    /* Tables */
    .table-container {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    thead th {
        text-align: left;
        padding: 12px 15px;
        background: var(--background);
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    tbody td {
        padding: 12px 15px;
        border-bottom: 1px solid var(--border);
    }
    tbody tr:last-child td {
        border-bottom: none;
    }
    tbody tr:hover {
        background: var(--background);
    }
    .status {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
    }
    .status.available {
        background: rgba(72, 187, 120, 0.2);
        color: var(--success);
    }
    .status.pending {
        background: rgba(236, 201, 75, 0.2);
        color: var(--warning);
    }
    .action-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }
    .action-link:hover {
        text-decoration: underline;
    }
    /* Appointment cards */
    .appointment-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .appointment-card {
        display: flex;
        background: var(--card-bg);
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 2px 10px var(--shadow);
        transition: transform 0.3s;
    }
    .appointment-card:hover {
        transform: translateY(-3px);
    }
    .appointment-date {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: var(--background);
        border-radius: 10px;
        padding: 10px;
        min-width: 70px;
        margin-right: 15px;
    }
    .date-day {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
    }
    .date-month {
        font-size: 0.9rem;
        color: var(--text-secondary);
        text-transform: uppercase;
    }
    .appointment-details {
        flex: 1;
    }
    .appointment-details h3 {
        font-size: 1.1rem;
        margin-bottom: 8px;
        color: var(--text-primary);
    }
    .appointment-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }
    .appointment-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .appointment-meta ion-icon {
        font-size: 1rem;
    }
    .appointment-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .btn-icon {
        background: none;
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s, color 0.3s;
    }
    .btn-icon:hover {
        background: var(--background);
        color: var(--primary);
    }
    /* Health reminders */
    .health-reminders {
        margin-bottom: 30px;
    }
    .health-reminders h2 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: var(--text-primary);
    }
    .reminder-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
    .reminder-card {
        display: flex;
        background: var(--card-bg);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 15px var(--shadow);
        transition: transform 0.3s;
    }
    .reminder-card:hover {
        transform: translateY(-3px);
    }
    .reminder-icon {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        width: 50px;
        height: 50px;
        background: var(--background);
        border-radius: 10px;
        margin-right: 15px;
    }
    .reminder-icon ion-icon {
        font-size: 1.8rem;
        color: var(--primary);
        padding-top: 10px;
    }
    .reminder-content {
        flex: 1;
    }
    .reminder-content h3 {
        font-size: 1.1rem;
        margin-bottom: 8px;
        color: var(--text-primary);
    }
    .reminder-content p {
        font-size: 0.95rem;
        color: var(--text-secondary);
        margin-bottom: 12px;
    }
    .btn-text {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        display: inline-block;
    }
    .btn-text:hover {
        text-decoration: underline;
    }
    /* Quick actions */
    .quick-actions {
        margin-bottom: 30px;
    }
    .quick-actions h2 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: var(--text-primary);
    }
    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    .action-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 15px var(--shadow);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
    }
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px var(--shadow);
    }
    .action-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background: var(--background);
        border-radius: 50%;
        margin-bottom: 15px;
    }
    .action-icon ion-icon {
        font-size: 1.8rem;
        color: var(--primary);
    }
    .action-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
    }
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .search {
            width: 250px;
        }
        
        .user-name {
            display: none;
        }
    }
    @media (max-width: 768px) {
        .navigation {
            width: 70px;
        }
        
        .main-content {
            width: calc(100% - 70px);
            left: 70px;
        }
        
        .nav-link .title {
            display: none;
        }
        
        .search {
            display: none;
        }
        
        .card-grid {
            grid-template-columns: 1fr;
        }
        
        .reminder-cards {
            grid-template-columns: 1fr;
        }
        
        .action-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 576px) {
        .topbar {
            padding: 0 15px;
        }
        
        .dashboard-content {
            padding: 15px;
        }
        
        .welcome-banner {
            padding: 20px;
        }
        
        .welcome-banner h1 {
            font-size: 1.5rem;
        }
        
        .appointment-card {
            flex-direction: column;
        }
        
        .appointment-date {
            margin-right: 0;
            margin-bottom: 10px;
            flex-direction: row;
            min-width: auto;
            padding: 5px 10px;
        }
        
        .date-day {
            margin-right: 5px;
        }
        
        .appointment-actions {
            flex-direction: row;
            justify-content: flex-end;
        }
    }
    </style>
    
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
                <ion-icon name="heart-outline"></ion-icon>
            </span>
            <span class="title">Patient Portal</span>
        </a>
    </div>
    
    <div class="nav-scrollable">
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link active" aria-current="page">
                    <span class="icon" aria-hidden="true">
                        <ion-icon name="home-outline"></ion-icon>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="icon" aria-hidden="true">
                        <ion-icon name="calendar-outline"></ion-icon>
                    </span>
                    <span class="title">My Appointments</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="icon" aria-hidden="true">
                        <ion-icon name="document-text-outline"></ion-icon>
                    </span>
                    <span class="title">Test Results</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="icon" aria-hidden="true">
                        <ion-icon name="folder-open-outline"></ion-icon>
                    </span>
                    <span class="title">Medical Records</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="icon" aria-hidden="true">
                        <ion-icon name="medkit-outline"></ion-icon>
                    </span>
                    <span class="title">Medications</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="icon" aria-hidden="true">
                        <ion-icon name="cash-outline"></ion-icon>
                    </span>
                    <span class="title">Billing & Payments</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="icon" aria-hidden="true">
                        <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                    </span>
                    <span class="title">Messages</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="icon" aria-hidden="true">
                        <ion-icon name="person-outline"></ion-icon>
                    </span>
                    <span class="title">My Profile</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="icon" aria-hidden="true">
                        <ion-icon name="help-circle-outline"></ion-icon>
                    </span>
                    <span class="title">Help & Support</span>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="nav-logout-container">
        <ul class="nav-menu">
            <li class="nav-item nav-logout">
                <a href="logout.php" class="nav-link">
                    <span class="icon" aria-hidden="true">
                        <ion-icon name="log-out-outline"></ion-icon>
                    </span>
                    <span class="title">Log Out</span>
                </a>
            </li>
        </ul>
    </div>
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
                    <input type="text" id="search-input" placeholder="Search your records..." aria-label="Search">
                    <button type="submit" aria-label="Submit search">
                        <ion-icon name="search-outline"></ion-icon>
                    </button>
                </div> 
                
                <div class="user-actions">
                    <button class="notification-btn" aria-label="Notifications">
                        <ion-icon name="notifications-outline"></ion-icon>
                        <span class="notification-badge" aria-hidden="true">3</span>
                    </button>
                    
                    <div class="user-profile">
                        <img src="images/image4.jpg" alt="Patient profile picture">
                        <span class="user-name"><?php echo isset($_SESSION['firstName']) ? $_SESSION['firstName'] : 'Patient'; ?></span>
                    </div>
                </div>
            </header>
            
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Welcome Banner -->
                <section class="welcome-banner" aria-labelledby="welcome-heading">
                    <h1 id="welcome-heading">Welcome back, <?php echo isset($_SESSION['firstName']) ? $_SESSION['firstName'] : 'Patient'; ?>!</h1>
                    <p>Here's your health summary for today. You have <strong>1 upcoming appointment</strong> and <strong>2 new test results</strong> available.</p>
                </section>
                
                <!-- CARDS -->
                <div class="card-grid">
                    <div class="card">
                        <div class="card-content">
                            <div class="numbers">1</div>
                            <div class="cardName">Upcoming Appointments</div>
                        </div>
                        <div class="iconBx" aria-hidden="true">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-content">
                            <div class="numbers">2</div>
                            <div class="cardName">New Test Results</div>
                        </div>
                        <div class="iconBx" aria-hidden="true">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-content">
                            <div class="numbers">3</div>
                            <div class="cardName">Active Prescriptions</div>
                        </div>
                        <div class="iconBx" aria-hidden="true">
                            <ion-icon name="medkit-outline"></ion-icon>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-content">
                            <div class="numbers">K150</div>
                            <div class="cardName">Outstanding Balance</div>
                        </div>
                        <div class="iconBx" aria-hidden="true">
                            <ion-icon name="cash-outline"></ion-icon>
                        </div>
                    </div>
                </div>
                
                <!-- Details Section -->
                <div class="details-section">
                    <!-- Recent Test Results -->
                    <section class="recent-tests" aria-labelledby="test-results-heading">
                        <div class="section-header">
                            <h2 id="test-results-heading">Recent Test Results</h2>
                            <a href="#" class="btn">View All Results</a>
                        </div>
                        
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Test Type</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Aug 13, 2025</td>
                                        <td>CBC (Complete Blood Count)</td>
                                        <td><span class="status available">Available</span></td>
                                        <td><a href="#" class="action-link">View</a></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Aug 10, 2025</td>
                                        <td>Lipid Panel</td>
                                        <td><span class="status available">Available</span></td>
                                        <td><a href="#" class="action-link">View</a></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Aug 5, 2025</td>
                                        <td>HbA1c</td>
                                        <td><span class="status pending">Processing</span></td>
                                        <td><a href="#" class="action-link">Details</a></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Jul 28, 2025</td>
                                        <td>Vitamin D</td>
                                        <td><span class="status available">Available</span></td>
                                        <td><a href="#" class="action-link">View</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    
                    <!-- Upcoming Appointments -->
                    <section class="upcoming-appointments" aria-labelledby="appointments-heading">
                        <div class="section-header">
                            <h2 id="appointments-heading">Upcoming Appointments</h2>
                            <a href="#" class="btn">Schedule New</a>
                        </div>
                        
                        <div class="appointment-list">
                            <div class="appointment-card">
                                <div class="appointment-date">
                                    <div class="date-day">18</div>
                                    <div class="date-month">Aug</div>
                                </div>
                                <div class="appointment-details">
                                    <h3>Annual Physical Examination</h3>
                                    <div class="appointment-meta">
                                        <span><ion-icon name="time-outline"></ion-icon> 10:30 AM</span>
                                        <span><ion-icon name="person-outline"></ion-icon> Dr. Sarah Johnson</span>
                                        <span><ion-icon name="location-outline"></ion-icon> Main Clinic</span>
                                    </div>
                                </div>
                                <div class="appointment-actions">
                                    <button class="btn-icon" aria-label="Reschedule appointment">
                                        <ion-icon name="calendar-outline"></ion-icon>
                                    </button>
                                    <button class="btn-icon" aria-label="Cancel appointment">
                                        <ion-icon name="close-circle-outline"></ion-icon>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="appointment-card">
                                <div class="appointment-date">
                                    <div class="date-day">25</div>
                                    <div class="date-month">Aug</div>
                                </div>
                                <div class="appointment-details">
                                    <h3>Cardiology Consultation</h3>
                                    <div class="appointment-meta">
                                        <span><ion-icon name="time-outline"></ion-icon> 2:15 PM</span>
                                        <span><ion-icon name="person-outline"></ion-icon> Dr. Michael Chen</span>
                                        <span><ion-icon name="videocam-outline"></ion-icon> Telehealth</span>
                                    </div>
                                </div>
                                <div class="appointment-actions">
                                    <button class="btn-icon" aria-label="Reschedule appointment">
                                        <ion-icon name="calendar-outline"></ion-icon>
                                    </button>
                                    <button class="btn-icon" aria-label="Cancel appointment">
                                        <ion-icon name="close-circle-outline"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                
                <!-- Health Reminders -->
                <section class="health-reminders" aria-labelledby="reminders-heading">
                    <h2 id="reminders-heading">Health Reminders</h2>
                    <div class="reminder-cards">
                        <div class="reminder-card">
                            <div class="reminder-icon">
                                <ion-icon name="medkit-outline"></ion-icon>
                            </div>
                            <div class="reminder-content">
                                <h3>Prescription Refill</h3>
                                <p>Your prescription for Metformin is due for refill in 5 days.</p>
                                <a href="#" class="btn-text">Request Refill</a>
                            </div>
                        </div>
                        
                        <div class="reminder-card">
                            <div class="reminder-icon">
                                <ion-icon name="fitness-outline"></ion-icon>
                            </div>
                            <div class="reminder-content">
                                <h3>Wellness Check</h3>
                                <p>Time to log your weekly blood pressure readings.</p>
                                <a href="#" class="btn-text">Log Now</a>
                            </div>
                        </div>
                        
                        <div class="reminder-card">
                            <div class="reminder-icon">
                                <ion-icon name="shield-checkmark-outline"></ion-icon>
                            </div>
                            <div class="reminder-content">
                                <h3>Vaccination</h3>
                                <p>You're due for your annual flu shot next month.</p>
                                <a href="#" class="btn-text">Schedule</a>
                            </div>
                        </div>
                    </div>
                </section>
                
                <!-- Quick Actions -->
                <section class="quick-actions" aria-labelledby="actions-heading">
                    <h2 id="actions-heading">Quick Actions</h2>
                    <div class="action-grid">
                        <button class="action-card">
                            <div class="action-icon">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </div>
                            <div class="action-title">Schedule Appointment</div>
                        </button>
                        
                        <button class="action-card">
                            <div class="action-icon">
                                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                            </div>
                            <div class="action-title">Message Provider</div>
                        </button>
                        
                        <button class="action-card">
                            <div class="action-icon">
                                <ion-icon name="document-text-outline"></ion-icon>
                            </div>
                            <div class="action-title">Request Records</div>
                        </button>
                        
                        <button class="action-card">
                            <div class="action-icon">
                                <ion-icon name="cash-outline"></ion-icon>
                            </div>
                            <div class="action-title">Pay Bill</div>
                        </button>
                    </div>
                </section>
            </div>
        </main>
    </div>
    
    <!-- Accessibility: Skip to content link -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    
    <!-- Scripts -->
    <script>
    // DOM elements
    const menuToggle = document.querySelector('.menu-toggle');
    const navigation = document.querySelector('.navigation');
    const mainContent = document.querySelector('.main-content');
    const searchInput = document.getElementById('search-input');
    const searchButton = searchInput.nextElementSibling;
    const notificationBtn = document.querySelector('.notification-btn');
    const userActions = document.querySelectorAll('.action-card');
    const appointmentActions = document.querySelectorAll('.appointment-actions .btn-icon');
    const reminderLinks = document.querySelectorAll('.btn-text');
    const testResultLinks = document.querySelectorAll('.action-link');
    
    // Initialize dashboard
    document.addEventListener('DOMContentLoaded', function() {
        // Setup event listeners
        setupEventListeners();
        
        // Setup notification badge
        updateNotificationBadge();
        
        // Setup appointment actions
        setupAppointmentActions();
        
        // Setup quick actions
        setupQuickActions();
        
        // Setup health reminders
        setupHealthReminders();
        
        // Setup test result links
        setupTestResultLinks();
    });
    
    // Setup event listeners
    function setupEventListeners() {
        // Menu toggle
        menuToggle.addEventListener('click', function() {
            navigation.classList.toggle('active');
            mainContent.classList.toggle('active');
            
            // Update aria-expanded for accessibility
            const isExpanded = navigation.classList.contains('active');
            menuToggle.setAttribute('aria-expanded', isExpanded);
        });
        
        // Navigation hover effects
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('mouseover', function() {
                navItems.forEach(i => i.classList.remove('hovered'));
                this.classList.add('hovered');
            });
        });
        
        // Search functionality
        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
        
        // Notification button
        notificationBtn.addEventListener('click', function() {
            showNotificationPanel();
        });
    }
    
    // Perform search
    function performSearch() {
        const searchTerm = searchInput.value.trim().toLowerCase();
        
        if (searchTerm) {
            // In a real app, this would filter content or send to a search page
            console.log('Searching for:', searchTerm);
            alert('Search functionality would filter content for: ' + searchTerm);
        }
    }
    
    // Update notification badge
    function updateNotificationBadge() {
        const badge = notificationBtn.querySelector('.notification-badge');
        
        // Simulate updating notifications (replace with actual data)
        const unreadCount = 3; // This would come from your backend
        
        if (unreadCount > 0) {
            badge.textContent = unreadCount > 9 ? "9+" : unreadCount;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }
    
    // Show notification panel (simulated)
    function showNotificationPanel() {
        // In a real app, this would open a notification panel
        const notifications = [
            { title: 'New test result available', message: 'Your CBC test results are ready for review.' },
            { title: 'Appointment reminder', message: 'You have an appointment with Dr. Sarah Johnson tomorrow at 10:30 AM.' },
            { title: 'Prescription refill', message: 'Your prescription for Metformin is due for refill in 5 days.' }
        ];
        
        let notificationHTML = '<div class="notification-panel"><h3>Notifications</h3><div class="notification-list">';
        
        notifications.forEach(notification => {
            notificationHTML += `
                <div class="notification-item">
                    <h4>${notification.title}</h4>
                    <p>${notification.message}</p>
                </div>
            `;
        });
        
        notificationHTML += '</div><button class="close-notifications">Close</button></div>';
        
        // Create and show notification panel
        const panel = document.createElement('div');
        panel.className = 'notification-overlay';
        panel.innerHTML = notificationHTML;
        document.body.appendChild(panel);
        
        // Close button functionality
        const closeBtn = panel.querySelector('.close-notifications');
        closeBtn.addEventListener('click', function() {
            document.body.removeChild(panel);
        });
        
        // Close when clicking outside
        panel.addEventListener('click', function(e) {
            if (e.target === panel) {
                document.body.removeChild(panel);
            }
        });
    }
    
    // Setup appointment actions
    function setupAppointmentActions() {
        appointmentActions.forEach(button => {
            button.addEventListener('click', function() {
                const appointmentCard = this.closest('.appointment-card');
                const appointmentTitle = appointmentCard.querySelector('h3').textContent;
                const isReschedule = this.querySelector('ion-icon').getAttribute('name') === 'calendar-outline';
                
                if (isReschedule) {
                    // Reschedule appointment
                    if (confirm(`Reschedule appointment: ${appointmentTitle}?`)) {
                        // In a real app, this would open a rescheduling form
                        alert('Rescheduling form would open here');
                    }
                } else {
                    // Cancel appointment
                    if (confirm(`Cancel appointment: ${appointmentTitle}?`)) {
                        // In a real app, this would send a request to cancel
                        appointmentCard.style.opacity = '0.5';
                        appointmentCard.style.pointerEvents = 'none';
                        alert('Appointment cancelled');
                    }
                }
            });
        });
    }
    
    // Setup quick actions
    function setupQuickActions() {
        userActions.forEach(action => {
            action.addEventListener('click', function() {
                const actionTitle = this.querySelector('.action-title').textContent;
                
                // In a real app, this would navigate to the appropriate page or open a modal
                switch(actionTitle) {
                    case 'Schedule Appointment':
                        alert('Opening appointment scheduling form');
                        break;
                    case 'Message Provider':
                        alert('Opening messaging interface');
                        break;
                    case 'Request Records':
                        alert('Opening records request form');
                        break;
                    case 'Pay Bill':
                        alert('Opening payment interface');
                        break;
                }
            });
        });
    }
    
    // Setup health reminders
    function setupHealthReminders() {
        reminderLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const reminderCard = this.closest('.reminder-card');
                const reminderTitle = reminderCard.querySelector('h3').textContent;
                
                // In a real app, this would perform the appropriate action
                switch(reminderTitle) {
                    case 'Prescription Refill':
                        alert('Opening prescription refill request form');
                        break;
                    case 'Wellness Check':
                        alert('Opening wellness data logging form');
                        break;
                    case 'Vaccination':
                        alert('Opening vaccination scheduling form');
                        break;
                }
            });
        });
    }
    
    // Setup test result links
    function setupTestResultLinks() {
        testResultLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const row = this.closest('tr');
                const testType = row.cells[1].textContent;
                
                // In a real app, this would open the test result details
                alert(`Opening test result details for: ${testType}`);
            });
        });
    }
    
    // Handle responsive behavior for smaller screens
    function handleResponsiveBehavior() {
        if (window.innerWidth <= 768) {
            // Auto-collapse navigation on mobile
            navigation.classList.add('active');
            mainContent.classList.add('active');
            menuToggle.setAttribute('aria-expanded', 'true');
        }
    }
    
    // Initialize responsive behavior
    window.addEventListener('load', handleResponsiveBehavior);
    window.addEventListener('resize', handleResponsiveBehavior);
    
    // Simulate real-time updates for test results
    function simulateTestResultUpdates() {
        const testRows = document.querySelectorAll('.recent-tests tbody tr');
        
        // Simulate a new test result becoming available
        setInterval(() => {
            // Find a pending test result
            const pendingTests = Array.from(testRows).filter(row => 
                row.querySelector('.status.pending')
            );
            
            if (pendingTests.length > 0) {
                const randomTest = pendingTests[Math.floor(Math.random() * pendingTests.length)];
                const statusElement = randomTest.querySelector('.status.pending');
                
                // Update status to available
                statusElement.classList.remove('pending');
                statusElement.classList.add('available');
                statusElement.textContent = 'Available';
                
                // Update notification badge
                const badge = document.querySelector('.notification-badge');
                const currentCount = parseInt(badge.textContent) || 0;
                badge.textContent = currentCount + 1;
                badge.style.display = 'flex';
                
                // Show a subtle notification
                randomTest.style.backgroundColor = 'rgba(72, 187, 120, 0.1)';
                setTimeout(() => {
                    randomTest.style.backgroundColor = '';
                }, 2000);
            }
        }, 30000); // Every 30 seconds for demo purposes
    }
    
    // Initialize test result simulation (only on dashboard page)
    document.addEventListener('DOMContentLoaded', () => {
        if (document.querySelector('.recent-tests')) {
            simulateTestResultUpdates();
        }
    });
    
    // Add notification panel styles dynamically
    const notificationStyles = document.createElement('style');
    notificationStyles.textContent = `
        .notification-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .notification-panel {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .notification-panel h3 {
            padding: 20px;
            border-bottom: 1px solid var(--border);
            margin: 0;
        }
        
        .notification-list {
            padding: 0;
        }
        
        .notification-item {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
        }
        
        .notification-item:last-child {
            border-bottom: none;
        }
        
        .notification-item h4 {
            margin: 0 0 5px;
            color: var(--text-primary);
        }
        
        .notification-item p {
            margin: 0;
            color: var(--text-secondary);
        }
        
        .close-notifications {
            display: block;
            width: 100%;
            padding: 15px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 0 0 12px 12px;
            font-weight: 500;
            cursor: pointer;
        }
        
        .close-notifications:hover {
            background: var(--primary-light);
        }
    `;
    document.head.appendChild(notificationStyles);
    </script>
    
    <!-- Use Icon from Ionicon -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>