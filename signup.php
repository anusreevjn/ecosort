<?php
session_start();
require_once 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        $error = "This email is already registered!";
    } else {
        // Insert new user (Plain text password as requested)
        $stmt = $pdo->prepare("INSERT INTO users (email, full_name, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$email, $full_name, $password])) {
            header("Location: login.php?signup=success");
            exit();
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - EcoSort</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            width: 100%;
            min-height: 100vh;
            background-color: #f0fdf4; /* Light green background */
            background-image: linear-gradient(rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.5)), url('assets/signup.jpg');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 400px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,.2);
            padding: 40px 30px;
        }

        .signup-text {
            color: #10b981; /* Green text */
            font-weight: 600;
            font-size: 1.3rem;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            width: 100%;
            height: 50px;
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            height: 100%;
            border: 2px solid #a7f3d0; /* Light green border */
            padding: 15px 20px;
            font-size: 1rem;
            border-radius: 30px;
            background: transparent;
            outline: none;
            transition: .3s;
        }

        .input-group input:focus {
            border-color: #059669; /* Darker green on focus */
        }

        .btn {
            width: 100%;
            padding: 15px;
            text-align: center;
            border: none;
            background: #10b981; /* Primary green */
            outline: none;
            border-radius: 30px;
            font-size: 1.1rem;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #059669; /* Hover dark green */
        }

        .loginregistertext {
            color: #333;
            text-align: center;
            font-size: 0.95rem;
        }

        .loginregistertext a {
            text-decoration: none;
            color: #10b981; /* Green link */
            font-weight: 600;
        }

        .google-btn {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }

        @media (max-width: 430px) {
            .container {
                width: 90%;
                padding: 30px 20px;
            }
        }
    </style>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body>
<div class="container">
    <p class="signup-text" style="font-family: 'Poppins', sans-serif;">Create Your Account</p>
    <?php if (isset($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
    <form action="signup.php" method="POST">
        <div class="input-group">
            <input type="text" name="name" class="input-field" placeholder="Full Name" required>
        </div>
        
        <div class="input-group">
            <input type="email" name="email" class="input-field" placeholder="Email" required>
        </div>
        
        <div class="input-group">
            <input type="password" name="password" class="input-field" placeholder="Password" required>
        </div>
        
        <div class="input-group">
            <button type="submit" class="btn">Sign Up</button>
        </div>
    </form>


    <p class="loginregistertext">Already have an account? <a href="login.php">Login Here</a>.</p>
</div>
</body>
</html>