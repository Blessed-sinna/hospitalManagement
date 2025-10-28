// DOM elements
const navMenu = document.getElementById('navMenu');
const dashboardContent = document.getElementById('dashboardContent');
const menuToggle = document.querySelector('.menu-toggle');
const navigation = document.querySelector('.navigation');
const mainContent = document.querySelector('.main-content');
const logoutLink = document.querySelector('.nav-logout');

// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    // Setup event listeners
    setupEventListeners();

    // Setup search functionality
    setupSearch();

    // Setup notification badge
    updateNotificationBadge();
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

    // Logout functionality
    if (logoutLink) {
        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'admin_logout.php';
        });
    }
}

// Setup search functionality
function setupSearch() {
    const searchInput = document.getElementById('search-input');
    const searchButton = document.querySelector('.search button');

    if (!searchInput || !searchButton) return;

    function performSearch() {
        const searchTerm = searchInput.value.trim().toLowerCase();

        if (searchTerm) {
            // In a real app, this would filter the content or send to a search page
            console.log('Searching for:', searchTerm);

            // For demo purposes, we'll just show an alert
            alert('Search functionality would filter content for: ' + searchTerm);
        }
    }

    searchButton.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
}

// Update notification badge
function updateNotificationBadge() {
    const notificationBtn = document.querySelector('.notification-btn');
    if (!notificationBtn) return;

    const badge = notificationBtn.querySelector('.notification-badge');

    // Simulate updating notifications (replace with actual data)
    const unreadCount = 5; // This would come from your backend

    if (unreadCount > 0) {
        badge.textContent = unreadCount > 9 ? "9+" : unreadCount;
        badge.style.display = 'flex';
    } else {
        badge.style.display = 'none';
    }

    // Setup notification click
    notificationBtn.addEventListener('click', function() {
        // In a real app, this would open a notification panel
        alert('Opening notification panel');
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