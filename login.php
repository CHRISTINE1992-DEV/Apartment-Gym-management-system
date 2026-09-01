<?php
require_once 'config.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter username and password';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        
        if ($user && verifyPassword($password, $user['password_hash'])) {
            if ($user['status'] === 'suspended') {
                $error = 'Your account has been suspended. Please contact support.';
            } elseif ($user['status'] === 'inactive') {
                $error = 'Your account is inactive. Please activate your account.';
            } else {
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['login_time'] = time();
             
                $redirect = $_SESSION['redirect_url'] ?? 'dashboard.php';
                unset($_SESSION['redirect_url']);
                redirect($redirect);
            }
        } else {
            $error = 'Invalid username or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hebron Apartment Gym MS</title>
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
        
        .login-container {
            width: 100%;
            max-width: 420px;
        }
        
        .login-box {
            background: white;
            border-radius: 20px;
            padding: 45px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-logo .logo-img {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 8px;
        }
        
        .login-logo .logo-img img {
            height: 50px;
            width: auto;
        }
        
        .login-logo .logo-img .logo-text {
            font-size: 30px;
            font-weight: 700;
            color: var(--dark);
        }
        
        .login-logo .logo-img .logo-text span {
            color: var(--red);
        }
        
        .login-logo .logo-subtitle {
            color: #888;
            font-size: 14px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        .login-logo .logo-divider {
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
        
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .form-options label {
            color: #666;
            font-size: 14px;
            cursor: pointer;
        }
        
        .form-options label input {
            margin-right: 6px;
        }
        
        .form-options a {
            color: var(--red);
            text-decoration: none;
            font-size: 14px;
        }
        
        .form-options a:hover {
            text-decoration: underline;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--dark);
            color: white;
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
        
        .btn-login:hover {
            background: #0d2a4a;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(7, 29, 73, 0.3);
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
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
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        
        .register-link a {
            color: var(--red);
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 480px) {
            .login-box {
                padding: 30px 20px;
            }
            
            .login-logo .logo-img img {
                height: 40px;
            }
            
            .login-logo .logo-img .logo-text {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-logo">
                <div class="logo-img">
                    <img src="images/logo.png" alt="Tinah Gym Pro">
                    <span class="logo-text">Hebron Apartment  <span>Gym MS</span></span>
                </div>
                <p class="logo-subtitle">Hebron Apartment Gym MS</p>
                <div class="logo-divider"></div>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username or Email</label>
                    <input type="text" id="username" name="username" placeholder="Enter username or email" required>
                </div>
                
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <div class="form-options">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="forgot_password.php">Forgot Password?</a>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
            
            <div class="register-link">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>