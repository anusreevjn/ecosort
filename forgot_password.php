<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
require_once 'db_connect.php';

// Include the files you provided
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a 6-digit numeric code
        $code = rand(100000, 999999);
        $expiry = date("Y-m-d H:i:s", strtotime('+15 minutes'));

        // Store code in database
        $update = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expiry = ? WHERE email = ?");
        $update->execute([$code, $expiry, $email]);

        // Send Email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ecosortcontact@gmail.com'; // Your Gmail
            $mail->Password   = 'hgjy qxpc sbrb qhug';    // 16-digit Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('your_gmail@gmail.com', 'EcoSort Support');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'EcoSort Password Reset Code';
            $mail->Body    = "Your password reset code is: <b>$code</b>. It expires in 15 minutes.";

            $mail->send();
            header("Location: reset_password.php?email=" . urlencode($email));
            exit();
        } catch (Exception $e) {
            $message = "Mail error: " . $mail->ErrorInfo;
        }
    } else {
        $message = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - EcoSort</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <style>
        /* CSS reused from your login.php for consistency */
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
            background-image: linear-gradient(rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.5)), url('assets/password.jpg');
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
        <p class="login-text">Forgot Password</p>
        <form method="POST">
            <?php if ($message) echo "<p style='color:red; text-align:center;'>$message</p>"; ?>
            <div class="input-group">
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <button type="submit" class="btn">Send Code</button>
        </form>
        <br><p style="text-align:center;font-size:1.2rem" class="loginregistertext">Back to <a href="login.php">Login</a>.</p>
    </div>
</body>
</html>