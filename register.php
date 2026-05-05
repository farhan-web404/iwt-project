<?php
// =============================================
// register.php — Create New Account
// =============================================
session_start();
include 'config/db.php';

// If already logged in, redirect
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim(mysqli_real_escape_string($conn, $_POST['name'] ?? ''));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email'] ?? ''));
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        // Check if email already exists
        $checkQuery = mysqli_query($conn, "SELECT user_id FROM users WHERE email = '$email'");
        if ($checkQuery && mysqli_num_rows($checkQuery) > 0) {
            $error = 'An account with this email already exists.';
        } else {
            $hashedPassword = md5($password);
            $insertQuery = mysqli_query($conn, "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashedPassword', 'user')");

            if ($insertQuery) {
                header('Location: login.php?registered=1');
                exit;
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | CA Cera</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        html { zoom: 1.25; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f0f0f 0%, #1a1a2e 50%, #16213e 100%);
            font-family: 'Poppins', -apple-system, 'Segoe UI', sans-serif;
        }

        .register-wrapper {
            display: flex;
            width: 1100px;
            max-width: 95vw;
            min-height: 660px;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.4);
        }

        .register-brand {
            flex: 1;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 56px;
            position: relative;
            overflow: hidden;
        }

        .register-brand::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(212,167,74,0.05) 0%, transparent 60%);
            animation: brandGlow 8s ease-in-out infinite alternate;
        }

        @keyframes brandGlow {
            0% { transform: translate(0, 0); }
            100% { transform: translate(20px, -20px); }
        }

        .register-brand-logo {
            font-family: 'Playfair Display', serif;
            font-size: 56px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .register-brand-logo span {
            font-style: italic;
            color: #d4a74a;
        }

        .register-brand-tagline {
            color: rgba(255,255,255,0.5);
            font-size: 17px;
            letter-spacing: 3px;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
        }

        .register-brand-text {
            margin-top: 40px;
            color: rgba(255,255,255,0.5);
            font-size: 17px;
            line-height: 1.7;
            text-align: center;
            max-width: 300px;
            position: relative;
            z-index: 1;
        }

        .register-form-side {
            flex: 1;
            background: #ffffff;
            padding: 56px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register-form-title {
            font-family: 'Poppins', sans-serif;
            font-size: 36px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 6px;
        }

        .register-form-subtitle {
            color: #888;
            font-size: 17px;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 18px 20px;
            border: 1.5px solid #e5e5e5;
            border-radius: 14px;
            font-size: 17px;
            font-family: 'Poppins', sans-serif;
            background: #f8f8f8;
            transition: all 0.25s ease;
            outline: none;
            box-sizing: border-box;
        }

        .form-input:focus {
            border-color: #1a1a1a;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(26, 26, 26, 0.06);
        }

        .form-input::placeholder {
            color: #bbb;
        }

        .register-btn {
            width: 100%;
            padding: 18px;
            background: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 14px;
            font-size: 18px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
        }

        .register-btn:hover {
            background: #333;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .register-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 20px 0;
            color: #ccc;
            font-size: 16px;
        }

        .register-divider::before,
        .register-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e5e5;
        }

        .register-footer {
            text-align: center;
            font-size: 17px;
            color: #888;
        }

        .register-footer a {
            color: #1a1a1a;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .register-footer a:hover {
            color: #d4a74a;
        }

        .alert-error {
            background: #fff0f0;
            border: 1px solid #ffcccc;
            color: #cc3333;
            padding: 16px 20px;
            border-radius: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-home {
            position: fixed;
            top: 24px;
            left: 24px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
            z-index: 10;
        }

        .back-home:hover {
            color: #fff;
        }

        @media (max-width: 768px) {
            .register-brand { display: none; }
            .register-wrapper { border-radius: 0; min-height: 100vh; }
            .register-form-side { padding: 32px 24px; }
        }
    </style>
</head>
<body>

<a href="index.php" class="back-home">← Back to Home</a>

<div class="register-wrapper">
    <!-- LEFT — Brand Panel -->
    <div class="register-brand">
        <div class="register-brand-logo">CA <span>Cera</span></div>
        <div class="register-brand-tagline">Premium Sanitaryware</div>
        <p class="register-brand-text">
            Join the CA Cera community to access exclusive product catalogs, dealer pricing, and personalized recommendations for your projects.
        </p>
    </div>

    <!-- RIGHT — Registration Form -->
    <div class="register-form-side">
        <h1 class="register-form-title">Create Account</h1>
        <p class="register-form-subtitle">Fill in your details to get started</p>

        <?php if ($error): ?>
            <div class="alert-error">⚠️ <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-input" placeholder="John Doe" required
                    value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-input" placeholder="you@example.com" required
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" placeholder="Min. 6 characters" required>
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-input" placeholder="Repeat password" required>
            </div>

            <button type="submit" class="register-btn">Create Account →</button>
        </form>

        <div class="register-divider">or</div>

        <div class="register-footer">
            Already have an account? <a href="login.php">Sign In</a>
        </div>
    </div>
</div>

</body>
</html>
