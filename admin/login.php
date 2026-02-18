<?php
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Simple hardcoded credentials for demo
    // Username: admin
    // Password: Admin@2026
    if ($username === 'admin' && $password === 'Admin@2026') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Manokamna Marketing</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary-color: #b5c99a;
            --primary-hover: #d8f6b1;
            --secondary-color: #092519;
            --bg-color: #fcfdfd;
            --text-heading: #101828;
            --text-body: #707070;
            --accent-overlay: rgba(181, 201, 154, 0.5);
            --font-main: "Figtree", sans-serif;
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        body {
            font-family: var(--font-main);
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--secondary-color) 0%, #1a4d36 100%);
            overflow: hidden;
            position: relative;
        }

        /* Ambient Background Elements */
        body::before,
        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: var(--primary-color);
            filter: blur(80px);
            opacity: 0.15;
            z-index: 0;
        }

        body::before {
            top: -100px;
            right: -100px;
        }

        body::after {
            bottom: -100px;
            left: -100px;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 50px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .logo-box {
            margin-bottom: 35px;
        }

        .logo-box img {
            height: 60px;
            margin-bottom: 15px;
        }

        h2 {
            color: #fff;
            font-size: 28px;
            margin: 0 0 10px 0;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        p.subtitle {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            margin-bottom: 35px;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
            text-align: left;
        }

        .form-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
            font-size: 18px;
        }

        input {
            width: 100%;
            padding: 16px 16px 16px 52px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--border-radius);
            color: #fff;
            font-family: inherit;
            font-size: 15px;
            box-sizing: border-box;
            transition: var(--transition);
        }

        input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(181, 201, 154, 0.1);
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--primary-color);
            color: var(--secondary-color);
            border: none;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px var(--primary-color);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .error-msg {
            background: rgba(255, 82, 82, 0.1);
            border: 1px solid rgba(255, 82, 82, 0.2);
            color: #ff5252;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 25px;
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .back-to-site {
            margin-top: 30px;
            display: inline-block;
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
        }

        .back-to-site:hover {
            color: var(--primary-color);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="glass-card">
            <div class="logo-box">
                <img src="../Manokamna Logo.png" alt="Manokamna Logo">
                <h2>Admin Central</h2>
                <p class="subtitle">Secure workspace for Manokamna Marketing</p>
            </div>

            <?php if ($error): ?>
                <div class="error-msg">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username" required autocomplete="off">
                </div>
                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn-login">Sign In <i class="fas fa-arrow-right"
                        style="margin-left: 8px;"></i></button>
            </form>

            <a href="../index.html" class="back-to-site"><i class="fas fa-arrow-left"></i> Back to Website</a>
        </div>
    </div>
</body>

</html>