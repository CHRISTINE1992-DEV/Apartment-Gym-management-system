<?php
require_once 'config.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';
$success = '';
$step = 'request'; // request, verify, reset
$user_email = '';

// Step 1: Request password reset - Check if email exists
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_email'])) {
    $email = sanitize($_POST['email'] ?? '');
    
    if (empty($email)) {
        $error = 'Please enter your email address';
    } elseif (!validateEmail($email)) {
        $error = 'Please enter a valid email address';
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id, username FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user) {
            // Email exists, proceed to reset
            $step = 'reset';
            $user_email = $email;
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_user_id'] = $user['id'];
            $success = 'Email verified! Please enter your new password.';
        } else {
            $error = 'No account found with this email address. Please check and try again.';
        }
    }
}

// Step 2: Reset password (direct without token)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $email = $_SESSION['reset_email'] ?? '';
    $user_id = $_SESSION['reset_user_id'] ?? '';
    
    if (empty($email) || empty($user_id)) {
        $error = 'Session expired. Please start over.';
        $step = 'request';
    } elseif (empty($password)) {
        $error = 'Please enter a password';
    } elseif (!validatePassword($password)) {
        $error = 'Password must be at least 6 characters';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        // Update password
        $hashed_password = hashPassword($password);
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->execute([$hashed_password, $user_id]);
        
        // Clear session
        unset($_SESSION['reset_email']);
        unset($_SESSION['reset_user_id']);
        
        setFlashMessage('success', 'Password reset successfully! Please login with your new password.');
        redirect('login.php');
    }
}

// Reset the process (start over)
if (isset($_GET['reset'])) {
    unset($_SESSION['reset_email']);
    unset($_SESSION['reset_user_id']);
    $step = 'request';
    $error = '';
    $success = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Hebron Apartment Gym MS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --dark: #071d49;
            --light: #42a5f5;
            --red: #e53935;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #071d49 0%, #1a3a6a 50%, #2a5a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 440px;
        }
        
        .box {
            background: white;
            border-radius: 20px;
            padding: 45px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo .logo-img {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 8px;
        }
        
        .logo .logo-img img {
            height: 45px;
            width: auto;
        }
        
        .logo .logo-img .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
        }
        
        .logo .logo-img .logo-text span {
            color: var(--red);
        }
        
        .logo .subtitle {
            color: #888;
            font-size: 14px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        .logo .divider {
            width: 60px;
            height: 3px;
            background: var(--red);
            margin: 12px auto 0;
            border-radius: 2px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }
        
        .form-group label i {
            color: var(--red);
            margin-right: 6px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: border-color 0.3s;
            background: #f8f9fa;
        }
        
        .form-group input:focus {
            border-color: var(--dark);
            outline: none;
            background: white;
            box-shadow: 0 0 0 3px rgba(7, 29, 73, 0.1);
        }
        
        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-primary {
            background: var(--dark);
            color: white;
        }
        
        .btn-primary:hover {
            background: #0d2a4a;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(7, 29, 73, 0.3);
        }
        
        .btn-red {
            background: var(--red);
            color: white;
        }
        
        .btn-red:hover {
            background: #c62828;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(229, 57, 53, 0.4);
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 14px;
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        
        .alert-danger i {
            color: #dc2626;
            margin-top: 2px;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .alert-success i {
            color: #059669;
            margin-top: 2px;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        
        .back-link a {
            color: var(--red);
            text-decoration: none;
            font-weight: 600;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
        
        .info-text {
            color: #666;
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .password-requirements {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }
        
        .email-display {
            background: #f0f2f5;
            padding: 12px 16px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
        }
        
        .email-display strong {
            color: var(--dark);
        }
        
        @media (max-width: 480px) {
            .box {
                padding: 30px 20px;
            }
            
            .logo .logo-img img {
                height: 35px;
            }
            
            .logo .logo-img .logo-text {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box">
            <div class="logo">
                <div class="logo-img">
                    <img src="images/logo.png" alt="Tinah Gym Pro">
                    <span class="logo-text">Tinah <span>Pro</span></span>
                </div>
                <p class="subtitle"><?php echo $step === 'reset' ? 'Reset Password' : 'Forgot Password'; ?></p>
                <div class="divider"></div>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($step === 'reset'): ?>
                <!-- Reset Password Form -->
                <p class="info-text">
                    Enter your new password below. Make sure it's at least 6 characters long.
                </p>
                
                <div class="email-display">
                    <i class="fas fa-envelope" style="color: var(--red);"></i>
                    Resetting password for: <strong><?php echo htmlspecialchars($user_email); ?></strong>
                </div>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> New Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter new password (min 6 characters)" required>
                        <div class="password-requirements">Minimum 6 characters</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password"><i class="fas fa-check-circle"></i> Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
                    </div>
                    
                    <button type="submit" name="reset_password" class="btn btn-red">
                        <i class="fas fa-key"></i> Reset Password
                    </button>
                </form>
                
                <div class="back-link">
                    <a href="?reset=1"><i class="fas fa-undo"></i> Start Over</a> &nbsp;|&nbsp;
                    <a href="login.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
                </div>
                
            <?php else: ?>
                <!-- Verify Email Form -->
                <p class="info-text">
                    Enter your registered email address to reset your password.
                </p>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your registered email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    </div>
                    
                    <button type="submit" name="verify_email" class="btn btn-primary">
                        <i class="fas fa-check-circle"></i> Verify Email
                    </button>
                </form>
                
                <div class="back-link">
                    <a href="login.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>