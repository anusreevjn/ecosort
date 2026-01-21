<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
require_once 'db_connect.php';
// Get email from URL or from the POST data if form was submitted
$email = $_REQUEST['email'] ?? ''; 
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = trim($_POST['code']);
    $new_password = $_POST['new_password'];

    // DEBUG TIP: Ensure the email here matches exactly what is in your database 'reset_token' row
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND reset_token = ? AND reset_expiry > NOW()");
    $stmt->execute([$email, $code]);
    $user = $stmt->fetch();

    if ($user) {
        // Update password and clear the token so it can't be used twice
        $update = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE email = ?");
        $update->execute([$new_password, $email]);
        
        echo "<script>alert('Password reset successful!'); window.location='login.php';</script>";
        exit();
    } else {
        $error = "Invalid or expired code for: " . htmlspecialchars($email);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - EcoSort</title>
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
        .btn:hover { background: #059669; }
    </style>
</head>
<body>
    <div class="container">
        <p class="login-text">Verify Reset Code</p>
        <form method="POST" action="reset_password.php?email=<?php echo urlencode($email); ?>">
            <?php if ($error) echo "<p style='color:red; text-align:center; font-size:0.8rem;'>$error</p>"; ?>
            
            <p style="text-align:center; font-size:1.2rem; margin-bottom:10px;">Email: <b><?php echo htmlspecialchars($email); ?></b></p>
            
            <div class="input-group">
    <label>Verification Code</label>
    <input type="text" name="code" placeholder="Enter the 6-digit code" required>
</div><br>
<div class="input-group">
    <label>New Password</label>
    <input type="password" name="new_password" placeholder="Enter new password" required>
</div>
            <br><button type="submit" class="btn">Reset Password</button> 
        </form>
        <br><p style="text-align:center;font-size:1.2rem" class="loginregistertext">Back to <a href="login.php">Login</a>.</p>
    </div>
</body>
</html>