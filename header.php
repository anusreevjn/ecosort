<?php
session_start(); 
require_once 'db_connect.php'; 
// 1. Get the current page filename
$current_page = basename($_SERVER['PHP_SELF']);

// 2. Define public pages that don't require a login
$public_pages = ['index.php', 'login.php', 'signup.php'];

// 3. Redirect to login if user is NOT logged in and trying to access a restricted page
if (!isset($_SESSION['user_email']) && !in_array($current_page, $public_pages)) {
    header("Location: login.php");
    exit();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoSort - Green Header</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/components.css">
    <style>
        :root {
            --primary-green: #10b981;
            --primary-dark: #059669;
            --primary-light: #f0fdf4; /* Replaced pinkish background */
            --gradient-primary: linear-gradient(135deg, #10b981, #059669);
            
            --white: #ffffff;
            --gray-100: #f3f4f6;
            --gray-700: #374151;
            --transition-normal: 200ms ease-in-out;
        }

        /* --- HEADER & NAV --- */
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gradient-primary);
            border-radius: var(--radius-full);
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Fix for Logo Icon */
        /* Find and replace .logo-icon in components.css */
.logo-icon {
    width: 48px; /* */
    height: 48px; /* */
    background: var(--white); /* */
    border-radius: 50%; /* Changed from var(--radius-xl) to 50% */
    display: flex; /* */
    align-items: center; /* */
    justify-content: center; /* */
    color: var(--white); /* */
}

        .logo-img {
            width: 80%;
            height: 80%;
            object-fit: contain;
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">
                    <div class="logo-icon">
                        <img src="assets/ecosort.png" alt="EcoSort Logo" class="logo-img">
                    </div>
                    <div class="logo-text">
                        <h1>EcoSort</h1>
                        <p>Giving Recycling a New Life</p>
                    </div>
                </a>

                <nav class="nav">
    <ul class="nav-list">
        <li>
            <a href="index.php" class="nav-link <?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : ''; ?>">Home</a>
        </li>
        <li>
            <a href="directory.php" class="nav-link <?php echo ($current_page == 'directory.php') ? 'active' : ''; ?>">Directory</a>
        </li>
        <li>
            <a href="schedules.php" class="nav-link <?php echo ($current_page == 'schedules.php') ? 'active' : ''; ?>">Schedules</a>
        </li>
        <li>
            <a href="impacts.php" class="nav-link <?php echo ($current_page == 'impacts.php') ? 'active' : ''; ?>">Impacts</a>
        </li>
        <li>
            <a href="about.php" class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About & FAQ</a>
        </li>
    </ul>
</nav>



                <div class="header-controls">
                    

                    <div class="auth-buttons">
    <?php if (isset($_SESSION['user_email'])): ?>
        
        <a href="logout.php" class="btn-secondary ">Logout</a>
    <?php else: ?>
        <a href="login.php" class="btn-secondary">Login</a> 
        
        <a href="signup.php" class="btn-primary">Sign Up</a>
    <?php endif; ?>
</div>
                    <button class="mobile-menu-btn" id="mobileMenuBtn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mobile-menu" id="mobileMenu">
                <nav class="mobile-nav">
                    <a href="index.php" class="mobile-nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a>
        <a href="directory.php" class="mobile-nav-link <?php echo ($current_page == 'directory.php') ? 'active' : ''; ?>">Directory</a>
        <a href="schedules.php" class="mobile-nav-link <?php echo ($current_page == 'schedules.php') ? 'active' : ''; ?>">Schedules</a>
        <a href="impacts.php" class="mobile-nav-link <?php echo ($current_page == 'impacts.php') ? 'active' : ''; ?>">Impacts</a>
        <a href="about.php" class="mobile-nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About & FAQ</a>
                    <hr style="border: 0; border-top: 1px solid var(--gray-200); margin: 0.5rem 0;">
                    <?php if (!isset($_SESSION['user_email'])): ?>
                        <a href="login.php" class="mobile-nav-link">Login</a>
                        <a href="signup.php" class="mobile-nav-link" style="color: var(--primary-green);">Sign Up</a>
                    <?php else: ?>
                        <a href="logout.php" class="mobile-nav-link">Logout</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.getElementById('themeToggle');
            const sunIcon = document.querySelector('.sun-icon');
            const moonIcon = document.querySelector('.moon-icon');

            const setTheme = (theme) => {
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
                if (theme === 'dark') {
                    sunIcon?.classList.add('hidden');
                    moonIcon?.classList.remove('hidden');
                } else {
                    sunIcon?.classList.remove('hidden');
                    moonIcon?.classList.add('hidden');
                }
            };

            setTheme(localStorage.getItem('theme') || 'light');

            themeToggle?.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                setTheme(currentTheme === 'light' ? 'dark' : 'light');
            });

            // Mobile Menu Fix
            const mobileBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            mobileBtn?.addEventListener('click', () => {
                mobileMenu.classList.toggle('show');
            });
        });
    </script>
</body>
</html>