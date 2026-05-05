<?php
// =============================================
// login.php — Login & Authentication
// =============================================
session_start();
include 'config/db.php';

// If already logged in, redirect
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin.php');
    } else {
        header('Location: index.php');
    }
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(mysqli_real_escape_string($conn, $_POST['email'] ?? ''));
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        $hashedPassword = md5($password);
        $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND password = '$hashedPassword'");

        if ($query && mysqli_num_rows($query) > 0) {
            $user = mysqli_fetch_assoc($query);
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Log the login
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $ua = mysqli_real_escape_string($conn, $_SERVER['HTTP_USER_AGENT'] ?? 'unknown');
            $uid = intval($user['user_id']);
            mysqli_query($conn, "INSERT INTO login_logs (user_id, email, ip_address, user_agent) VALUES ($uid, '$email', '$ip', '$ua')");

            if ($user['role'] === 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    }
}

// Check for registration success message
if (isset($_GET['registered'])) {
    $success = 'Account created successfully! Please log in.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CA Cera</title>
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

        .login-wrapper {
            display: flex;
            width: 1100px;
            max-width: 95vw;
            min-height: 640px;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.4);
        }

        .login-brand {
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

        .login-brand::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, transparent 60%);
            animation: brandGlow 8s ease-in-out infinite alternate;
        }

        @keyframes brandGlow {
            0% { transform: translate(0, 0); }
            100% { transform: translate(-20px, 20px); }
        }

        .login-brand-logo {
            font-family: 'Playfair Display', serif;
            font-size: 56px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .login-brand-logo span {
            font-style: italic;
            color: #d4a74a;
        }

        .login-brand-tagline {
            color: rgba(255,255,255,0.5);
            font-size: 17px;
            letter-spacing: 3px;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
        }

        .login-brand-features {
            margin-top: 48px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative;
            z-index: 1;
        }

        .login-brand-feature {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.6);
            font-size: 17px;
        }

        .login-brand-feature span {
            font-size: 24px;
        }

        .login-form-side {
            flex: 1;
            background: #ffffff;
            padding: 56px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form-title {
            font-family: 'Poppins', sans-serif;
            font-size: 36px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 6px;
        }

        .login-form-subtitle {
            color: #888;
            font-size: 17px;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 24px;
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

        .login-btn {
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

        .login-btn:hover {
            background: #333;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 24px 0;
            color: #ccc;
            font-size: 16px;
        }

        .login-divider::before,
        .login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e5e5;
        }

        .login-footer {
            text-align: center;
            font-size: 17px;
            color: #888;
        }

        .login-footer a {
            color: #1a1a1a;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .login-footer a:hover {
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

        .alert-success {
            background: #f0fff4;
            border: 1px solid #c6f6d5;
            color: #276749;
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
            .login-brand { display: none; }
            .login-wrapper { border-radius: 0; min-height: 100vh; }
            .login-form-side { padding: 32px 24px; }
        }
    </style>
</head>
<body>

<a href="index.php" class="back-home">← Back to Home</a>

<div class="login-wrapper">
    <!-- LEFT — Brand Panel -->
    <div class="login-brand">
        <div class="login-brand-logo">CA <span>Cera</span></div>
        <div class="login-brand-tagline">Premium Sanitaryware</div>

        <div class="login-brand-features">
            <div class="login-brand-feature">
                <span>🏆</span> India's Leading Sanitaryware Brand
            </div>
            <div class="login-brand-feature">
                <span>🛡️</span> 5-Year Product Warranty
            </div>
            <div class="login-brand-feature">
                <span>🚚</span> Pan-India Delivery Network
            </div>
            <div class="login-brand-feature">
                <span>✨</span> Premium Quality Certified
            </div>
        </div>
    </div>

    <!-- RIGHT — Login Form -->
    <div class="login-form-side">
        <h1 class="login-form-title">Welcome back</h1>
        <p class="login-form-subtitle">Enter your credentials to access your account</p>

        <?php if ($error): ?>
            <div class="alert-error">⚠️ <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert-success">✅ <?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-input" placeholder="you@example.com" required
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="login-btn">Sign In →</button>
        </form>

        <div class="login-divider">or</div>

        <div class="login-footer">
            Don't have an account? <a href="register.php">Create Account</a>
        </div>
    </div>
</div>

</body>
</html>
