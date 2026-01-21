<?php
session_start();
require_once 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user from database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Check if user exists and password matches (plain text comparison)
    if ($user && $user['password'] === $password) {
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['full_name'];
        
        header("Location: dashboard.php"); // Redirect to home page
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - EcoSort</title>
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
            background-image: linear-gradient(rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.5)), url('assets/login.jpg');
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

        .login-text {
            color: #10b981; /* Green text */
            font-weight: 600;
            font-size: 1.3rem;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            width: 100%;
            height: 50px;
            margin-bottom: 25px;
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
            border-color: #059669; /* Focus darker green */
        }

        .btn {
            width: 100%;
            padding: 15px;
            text-align: center;
            border: none;
            background: #10b981; /* Primary green button */
            outline: none;
            border-radius: 30px;
            font-size: 1.1rem;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #059669; /* Hover green */
        }

        .loginregistertext {
            color: #333;
            text-align: center;
            font-size: 0.95rem;
             margin-top: 10px;
            margin-bottom: 10px;
            line-height: 1.2; 
        }

        .loginregistertext a {
            text-decoration: none;
            color: #10b981; /* Link green */
            font-weight: 600;
            display: inline-block;
            margin-left: 3px;
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
    
</head>
<body>
    <div class="container">
        <p class="login-text">Login to EcoSort</p>
        <form id="loginForm" method="POST">
            <?php if (!empty($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <div class="input-group">
                <button name="submit" class="btn" type="submit">Login</button>
            </div>
        </form>
        
        <p class="loginregistertext">Don't have an account?<a href="signup.php"> Register Here</a>.</p>
        <p class="loginregistertext">Forgot password?<a href="forgot_password.php"> Reset Here</a>.</p>
    </div>
</body>
</html>