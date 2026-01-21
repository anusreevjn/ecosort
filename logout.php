<?php
session_start();

// 1. Clear all session variables
$_SESSION = array();

// 2. Destroy the session cookie if it exists
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// 3. Destroy the session on the server
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out - EcoSort</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <meta http-equiv="refresh" content="10;url=login.php">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0fdf4; /* Matches your login.php theme */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }
        .logout-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,.1);
            max-width: 400px;
        }
        h2 { color: #10b981; margin-bottom: 10px; }
        p { color: #4b5563; }
        .countdown {
            font-size: 1.5rem;
            font-weight: 700;
            color: #b90c0cff; /* Uses your primary-pink color from style.css */
            margin: 20px 0;
        }
        .btn-manual {
            display: inline-block;
            text-decoration: none;
            color: #10b981;
            font-weight: 600;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <h2>Successfully Logged Out</h2>
        <p>Thank you for using EcoSort to help the environment.</p>
        <div class="countdown" id="timer">10</div>
        <p>Redirecting you to the login page...</p>
        <a href="login.php" class="btn-manual">Click here to go now</a>
    </div>

    <script>
        // Simple visual countdown script
        let timeLeft = 10;
        const timerElement = document.getElementById('timer');
        
        const countdown = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;
            if (timeLeft <= 0) clearInterval(countdown);
        }, 1000);
    </script>
</body>
</html>