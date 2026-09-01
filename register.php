<?php
require_once 'config.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $full_name = sanitize($_POST['full_name'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    
    // Validate
    if (empty($username)) {
        $errors[] = 'Username is required';
    } elseif (strlen($username) < 3) {
        $errors[] = 'Username must be at least 3 characters';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!validateEmail($email)) {
        $errors[] = 'Invalid email address';
    }
    
    if (empty($password)) {
        $errors[] = 'Password is required';
    } elseif (!validatePassword($password)) {
        $errors[] = 'Password must be at least 6 characters';
    }
    
    if ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match';
    }
    
    if (empty($full_name)) {
        $errors[] = 'Full name is required';
    }
    
    // Check if username exists
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors[] = 'Username already taken';
        }
    }
    
    // Check if email exists
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Email already registered';
        }
    }
    
    // Insert user
    if (empty($errors)) {
        $hashed_password = hashPassword($password);
        
        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, password_hash, full_name, phone, role, status)
            VALUES (?, ?, ?, ?, ?, 'user', 'active')
        ");
        
        if ($stmt->execute([$username, $email, $hashed_password, $full_name, $phone])) {
            setFlashMessage('success', 'Registration successful! Please login.');
            redirect('login.php');
        } else {
            $errors[] = 'Registration failed. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Hebron Apartment Gym MS</title>
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
        
        .register-container {
            width: 100%;
            max-width: 480px;
        }
        
        .register-box {
            background: white;
            border-radius: 20px;
            padding: 45px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        
        .register-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-logo .logo-img {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 8px;
        }
        
        .register-logo .logo-img img {
            height: 45px;
            width: auto;
        }
        
        .register-logo .logo-img .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
        }
        
        .register-logo .logo-img .logo-text span {
            color: var(--red);
        }
        
        .register-logo .logo-subtitle {
            color: #888;
            font-size: 14px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        .register-logo .logo-divider {
            width: 60px;
            height: 3px;
            background: var(--red);
            margin: 12px auto 0;
            border-radius: 2px;
        }
        
        .form-group {
            margin-bottom: 18px;
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
            font-size: 14px;
            transition: border-color 0.3s;
            background: #f8f9fa;
        }
        
        .form-group input:focus {
            border-color: var(--dark);
            outline: none;
            background: white;
            box-shadow: 0 0 0 3px rgba(7, 29, 73, 0.1);
        }
        
        .btn-register {
            width: 100%;
            padding: 14px;
            background: var(--red);
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
        
        .btn-register:hover {
            background: #c62828;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(229, 57, 53, 0.4);
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
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .alert-success i {
            color: #059669;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        
        .login-link a {
            color: var(--red);
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 480px) {
            .register-box {
                padding: 30px 20px;
            }
            
            .register-logo .logo-img img {
                height: 35px;
            }
            
            .register-logo .logo-img .logo-text {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-box">
            <div class="register-logo">
                <div class="logo-img">
                    <img src="images/logo.png" alt="Gym MS">
                    <span class="logo-text">Hebron Apartment  <span>Gym MS</span></span>
                </div>
                <p class="logo-subtitle">Create Account</p>
                <div class="logo-divider"></div>
            </div>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <ul style="margin:0;padding-left:20px;">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="full_name"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="username"><i class="fas fa-user-tag"></i> Username</label>
                    <input type="text" id="username" name="username" placeholder="Choose a username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Phone Number</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter your phone number" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password (min 6 characters)" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password"><i class="fas fa-check-circle"></i> Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
                
                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>
            
            <div class="login-link">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        </div>
    </div>
</body>
</html>