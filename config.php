<?php
// ============================================
// CONFIGURATION & BOOTSTRAP
// ============================================

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================
// DATABASE CONFIGURATION
// ============================================
define('DB_HOST', 'localhost');
define('DB_USER', 'techcod2_gym_management');
define('DB_PASS', 'tinahgym@2026');
define('DB_NAME', 'techcod2_gym_management');
define('SITE_NAME', 'Tinah Gym Pro');
define('UPLOAD_PATH', __DIR__ . '/uploads/');

// ============================================
// DATABASE CONNECTION
// ============================================
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// ============================================
// USER AUTHENTICATION (Frontend - Main)
// ============================================
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

function currentUser() {
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'email' => $_SESSION['email'] ?? null,
        'name' => $_SESSION['full_name'] ?? null,
        'role' => $_SESSION['role'] ?? null
    ];
}

function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        if (ob_get_level()) ob_clean();
        header('Location: login.php');
        exit;
    }
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header('Location: dashboard.php');
        exit;
    }
}

// ============================================
// ADMIN AUTHENTICATION (Backend)
// ============================================
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']) && isset($_SESSION['admin_username']);
}

function currentAdminUser() {
    return [
        'id' => $_SESSION['admin_id'] ?? null,
        'username' => $_SESSION['admin_username'] ?? null,
        'name' => $_SESSION['admin_name'] ?? null,
        'role' => $_SESSION['admin_role'] ?? null,
        'email' => $_SESSION['admin_email'] ?? null
    ];
}

function requireAdminLogin() {
    if (!isAdminLoggedIn()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        if (ob_get_level()) ob_clean();
        header('Location: login.php');
        exit;
    }
}

// ============================================
// REDIRECT & FLASH MESSAGES
// ============================================
function redirect($url) {
    if (ob_get_level()) ob_clean();
    header('Location: ' . $url);
    exit;
}

function setFlashMessage($type, $message) {
    $_SESSION['flash_message'] = ['type' => $type, 'message' => $message];
}

function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $msg = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $msg;
    }
    return null;
}

// ============================================
// HELPER FUNCTIONS
// ============================================
function sanitize($input) {
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    return htmlspecialchars(strip_tags(trim($input)));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePassword($password) {
    return strlen($password) >= 6;
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

function generateToken() {
    return bin2hex(random_bytes(32));
}

function generateId($prefix) {
    global $pdo;
    $count = 1;
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM members WHERE member_id LIKE ?");
    $stmt->execute([$prefix . '%']);
    $total = $stmt->fetch()['total'];
    $count = $total + 1;
    return $prefix . str_pad($count, 3, '0', STR_PAD_LEFT);
}

function uploadFile($file, $targetDir, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']) {
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($file_ext, $allowedTypes) || $file['size'] > 10000000) {
        return false;
    }
    $new_name = uniqid() . '.' . $file_ext;
    if (move_uploaded_file($file['tmp_name'], $targetDir . $new_name)) {
        return $new_name;
    }
    return false;
}

function timeAgo($timestamp) {
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);
    $hours = round($seconds / 3600);
    $days = round($seconds / 86400);
    $weeks = round($seconds / 604800);
    $months = round($seconds / 2629440);
    $years = round($seconds / 31553280);
    
    if($seconds <= 60){
        return "Just Now";
    } else if($minutes <= 60){
        return ($minutes==1)?'1 minute ago':$minutes.' minutes ago';
    } else if($hours <= 24){
        return ($hours==1)?'1 hour ago':$hours.' hours ago';
    } else if($days <= 7){
        return ($days==1)?'1 day ago':$days.' days ago';
    } else if($weeks <= 4.3){
        return ($weeks==1)?'1 week ago':$weeks.' weeks ago';
    } else if($months <= 12){
        return ($months==1)?'1 month ago':$months.' months ago';
    } else {
        return ($years==1)?'1 year ago':$years.' years ago';
    }
}

// Create upload directories
$uploadDirs = ['profiles/', 'documents/', 'posters/', 'thumbnails/', 'movies/', 'courses/'];
foreach ($uploadDirs as $dir) {
    $fullPath = UPLOAD_PATH . $dir;
    if (!file_exists($fullPath)) {
        mkdir($fullPath, 0777, true);
    }
}

// Auto-authenticate for admin pages (skip login page)
$skip_auth = ['login.php', 'register.php', 'logout.php', 'forgot_password.php'];
$current_page = basename($_SERVER['PHP_SELF']);
if (!in_array($current_page, $skip_auth)) {
    // Check if it's an admin page
    if (strpos($current_page, 'admin') !== false || strpos(dirname($_SERVER['PHP_SELF']), 'admin') !== false) {
        requireAdminLogin();
    }
    // For regular pages, check user login (but skip if it's a public page)
    // Add more public pages as needed
    $public_pages = ['index.php'];
    if (!in_array($current_page, $public_pages)) {
        requireLogin();
    }
}
?>