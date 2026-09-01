<?php
require_once 'config.php';
requireLogin(); // This now checks for user_id and username

$user = currentUser(); // This now gets user session data
$user_id = $user['id'];

// Get user's enrolled courses
$stmt = $pdo->prepare("
    SELECT c.*, uc.enrollment_date, uc.progress, uc.status as enrollment_status
    FROM user_courses uc
    JOIN courses c ON uc.course_id = c.id
    WHERE uc.user_id = ?
    ORDER BY uc.enrollment_date DESC
");
$stmt->execute([$user_id]);
$enrolled_courses = $stmt->fetchAll();

// Get available courses (not enrolled)
$stmt = $pdo->prepare("
    SELECT * FROM courses 
    WHERE status = 'active' 
    AND id NOT IN (SELECT course_id FROM user_courses WHERE user_id = ?)
    ORDER BY created_at DESC
    LIMIT 6
");
$stmt->execute([$user_id]);
$available_courses = $stmt->fetchAll();

// Get stats
$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM user_courses WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_courses = $stmt->fetch()['total'];

$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM user_courses WHERE user_id = ? AND status = 'completed'");
$stmt->execute([$user_id]);
$completed_courses = $stmt->fetch()['total'];

$stmt = $pdo->prepare("SELECT AVG(progress) as avg_progress FROM user_courses WHERE user_id = ? AND status != 'completed'");
$stmt->execute([$user_id]);
$avg_progress = round($stmt->fetch()['avg_progress'] ?? 0);

// Handle course enrollment
if (isset($_GET['enroll']) && is_numeric($_GET['enroll'])) {
    $course_id = (int)$_GET['enroll'];
    
    // Check if already enrolled
    $stmt = $pdo->prepare("SELECT id FROM user_courses WHERE user_id = ? AND course_id = ?");
    $stmt->execute([$user_id, $course_id]);
    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO user_courses (user_id, course_id, status) VALUES (?, ?, 'enrolled')");
        $stmt->execute([$user_id, $course_id]);
        setFlashMessage('success', 'Successfully enrolled in the course!');
    } else {
        setFlashMessage('warning', 'You are already enrolled in this course.');
    }
    redirect('dashboard.php');
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    redirect('login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hebron Apartment Gym MS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            background: #f0f2f5;
        }
        
        /* Wrapper */
        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--dark);
            color: white;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            transition: transform 0.3s ease;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 700;
        }
        
        .sidebar-header .logo img {
            height: 35px;
            width: auto;
        }
        
        .sidebar-header .logo span {
            color: var(--red);
        }
        
        .sidebar-nav {
            padding: 20px 0;
        }
        
        .sidebar-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-nav li {
            margin-bottom: 2px;
        }
        
        .sidebar-nav .nav-section {
            color: rgba(255,255,255,0.3);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 20px 8px;
            font-weight: 700;
        }
        
        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .sidebar-nav a:hover {
            background: rgba(255,255,255,0.05);
            color: white;
        }
        
        .sidebar-nav a.active {
            background: rgba(230, 57, 70, 0.15);
            color: white;
            border-left-color: var(--red);
        }
        
        .sidebar-nav a i {
            width: 24px;
            margin-right: 12px;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
        }
        
        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .top-navbar .navbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .top-navbar .toggle-sidebar {
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: #333;
            display: none;
        }
        
        .top-navbar .page-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
        }
        
        .top-navbar .page-title i {
            color: var(--red);
        }
        
        .top-navbar .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .top-navbar .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #333;
        }
        
        .top-navbar .user-info i {
            font-size: 28px;
            color: var(--dark);
        }
        
        .top-navbar .user-info .badge {
            background: var(--red);
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
        }
        
        .top-navbar .logout-btn {
            background: var(--red);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
        }
        
        .top-navbar .logout-btn:hover {
            background: #c62828;
            transform: scale(1.02);
        }
        
        /* Content Area */
        .content-area {
            padding: 30px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
        }
        
        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: white;
            flex-shrink: 0;
        }
        
        .stat-info h3 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 2px;
            color: var(--dark);
        }
        
        .stat-info p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .section-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
        }
        
        .section-header h2 i {
            color: var(--red);
            margin-right: 10px;
        }
        
        .card-custom {
            background: white;
            border-radius: 15px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }
        
        .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .card-custom .card-body {
            padding: 25px;
        }
        
        .card-custom .card-title {
            font-weight: 700;
            color: var(--dark);
            font-size: 18px;
        }
        
        .card-custom .card-text {
            color: #666;
            font-size: 14px;
        }
        
        .card-custom .course-meta {
            display: flex;
            gap: 15px;
            margin: 10px 0;
            font-size: 13px;
            color: #888;
        }
        
        .card-custom .course-meta i {
            color: var(--red);
            margin-right: 4px;
        }
        
        .btn-primary-custom {
            background: var(--dark);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: #0d2a4a;
            color: white;
            transform: scale(1.02);
        }
        
        .btn-red-custom {
            background: var(--red);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-red-custom:hover {
            background: #c62828;
            color: white;
            transform: scale(1.02);
        }
        
        .progress-custom {
            height: 8px;
            border-radius: 10px;
            background: #e9ecef;
            margin-top: 10px;
        }
        
        .progress-custom .progress-bar {
            background: var(--red);
            border-radius: 10px;
        }
        
        .badge-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-enrolled {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .badge-in_progress {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-completed {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-dropped {
            background: #f8d7da;
            color: #721c24;
        }
        
        .alert-custom {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-success-custom {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-warning-custom {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .footer-custom {
            background: var(--dark);
            color: rgba(255,255,255,0.7);
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }
        
        .footer-custom a {
            color: var(--light);
            text-decoration: none;
        }
        
        .footer-custom a:hover {
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #888;
        }
        
        .empty-state i {
            font-size: 60px;
            color: #ddd;
            margin-bottom: 15px;
        }
        
        .row-custom {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }
        
        @media (max-width: 992px) {
            .row-custom {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .top-navbar .toggle-sidebar {
                display: block;
            }
            
            .content-area {
                padding: 15px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .top-navbar {
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <img src="images/logo.png" alt="Tinah Gym Pro">
                <span>Tinah Pro</span>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li class="nav-section">Main</li>
                <li>
                    <a href="dashboard.php" class="active">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                
                <li class="nav-section">Learning</li>
                <li>
                    <a href="#courses">
                        <i class="fas fa-book"></i> My Courses
                    </a>
                </li>
                <li>
                    <a href="#available-courses">
                        <i class="fas fa-book-open"></i> Available Courses
                    </a>
                </li>
                
                <li class="nav-section">Account</li>
                <li>
                    <a href="profile.php">
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li>
                    <a href="?logout=1" onclick="return confirm('Are you sure you want to logout?')">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="navbar-left">
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="page-title">
                    <i class="fas fa-chevron-right"></i> Dashboard
                </span>
            </div>
            
            <div class="navbar-right">
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo htmlspecialchars($user['name'] ?? $user['username'] ?? 'User'); ?></span>
                    <span class="badge"><?php echo ucfirst($user['role'] ?? 'user'); ?></span>
                </div>
                <a href="?logout=1" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </nav>
        
        <!-- Flash Messages -->
        <?php $flash = getFlashMessage(); if ($flash): ?>
        <div class="content-area" style="padding-bottom: 0;">
            <div class="alert-custom alert-<?php echo $flash['type']; ?>-custom">
                <i class="fas fa-<?php echo $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo $flash['message']; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Content Area -->
        <div class="content-area">
            
            <!-- Welcome Section -->
            <div class="mb-4">
                <h1 style="color: var(--dark); font-size: 32px; font-weight: 700;">
                    Welcome back, <span style="color: var(--red);"><?php echo htmlspecialchars($user['name'] ?? $user['username'] ?? 'User'); ?></span>! 👋
                </h1>
                <p style="color: #666; font-size: 16px;">Here's an overview of your learning progress.</p>
            </div>
            
            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #4a90d9;">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $total_courses; ?></h3>
                        <p>Enrolled Courses</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: #28a745;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $completed_courses; ?></h3>
                        <p>Completed</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: #ffc107;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $avg_progress; ?>%</h3>
                        <p>Average Progress</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: #17a2b8;">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $total_courses - $completed_courses; ?></h3>
                        <p>In Progress</p>
                    </div>
                </div>
            </div>
            
            <!-- My Courses -->
            <?php if (!empty($enrolled_courses)): ?>
            <div class="section-header" id="courses">
                <h2><i class="fas fa-graduation-cap"></i> My Courses</h2>
                <span style="color: #666; font-size: 14px;"><?php echo count($enrolled_courses); ?> courses</span>
            </div>
            
            <div class="row-custom">
                <?php foreach ($enrolled_courses as $course): ?>
                <div class="card-custom">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h5>
                            <span class="badge-status badge-<?php echo str_replace('_', '', $course['enrollment_status']); ?>">
                                <?php echo str_replace('_', ' ', ucfirst($course['enrollment_status'])); ?>
                            </span>
                        </div>
                        
                        <p class="card-text"><?php echo htmlspecialchars(substr($course['description'] ?? '', 0, 120)) . '...'; ?></p>
                        
                        <div class="course-meta">
                            <span><i class="fas fa-user-tie"></i> <?php echo htmlspecialchars($course['instructor'] ?? 'N/A'); ?></span>
                            <span><i class="fas fa-clock"></i> <?php echo $course['duration']; ?> hours</span>
                            <span><i class="fas fa-signal"></i> <?php echo $course['level']; ?></span>
                        </div>
                        
                        <div class="mt-2">
                            <div class="d-flex justify-content-between">
                                <span style="font-size: 13px; color: #666;">Progress</span>
                                <span style="font-size: 13px; font-weight: 600; color: var(--dark);"><?php echo $course['progress']; ?>%</span>
                            </div>
                            <div class="progress-custom">
                                <div class="progress-bar" style="width: <?php echo $course['progress']; ?>%;"></div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <?php if ($course['progress'] < 100): ?>
                                <a href="#" class="btn btn-primary-custom btn-sm">Continue Learning</a>
                            <?php else: ?>
                                <span class="badge badge-status badge-completed">
                                    <i class="fas fa-check-circle"></i> Completed
                                </span>
                            <?php endif; ?>
                            <span class="ms-2" style="font-size: 13px; color: #888;">
                                <i class="fas fa-calendar-alt"></i> <?php echo timeAgo($course['enrollment_date']); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <!-- Available Courses -->
            <div class="section-header" id="available-courses" style="margin-top: <?php echo !empty($enrolled_courses) ? '40px' : '0'; ?>">
                <h2><i class="fas fa-book-open"></i> Available Courses</h2>
                <span style="color: #666; font-size: 14px;"><?php echo count($available_courses); ?> courses available</span>
            </div>
            
            <?php if (!empty($available_courses)): ?>
            <div class="row-custom">
                <?php foreach ($available_courses as $course): ?>
                <div class="card-custom">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($course['description'] ?? '', 0, 120)) . '...'; ?></p>
                        
                        <div class="course-meta">
                            <span><i class="fas fa-user-tie"></i> <?php echo htmlspecialchars($course['instructor'] ?? 'N/A'); ?></span>
                            <span><i class="fas fa-clock"></i> <?php echo $course['duration']; ?> hours</span>
                            <span><i class="fas fa-signal"></i> <?php echo $course['level']; ?></span>
                        </div>
                        
                        <div class="mt-2">
                            <span style="font-weight: 600; color: var(--red); font-size: 16px;">
                               Ksh<?php echo number_format($course['price'], 2); ?>
                            </span>
                        </div>
                        
                        <div class="mt-3">
                            <a href="?enroll=<?php echo $course['id']; ?>" class="btn btn-red-custom btn-sm" onclick="return confirm('Enroll in this course?')">
                                <i class="fas fa-plus-circle"></i> Enroll Now
                            </a>
                            <span class="ms-2" style="font-size: 13px; color: #888;">
                                <i class="fas fa-users"></i> <?php echo rand(5, 50); ?> students enrolled
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-check-circle" style="color: #28a745;"></i>
                <h4>You're enrolled in all available courses!</h4>
                <p style="color: #888;">Check back later for new courses.</p>
            </div>
            <?php endif; ?>
            
        </div>
        
        <!-- Footer -->
        <footer class="footer-custom">
            <div class="container">
                <p>&copy; <?php echo date('Y'); ?> <strong style="color: white;">Tinah Gym Pro</strong>. All rights reserved.</p>
                <p>
                    <a href="#">Privacy Policy</a> | 
                    <a href="#">Terms of Service</a> | 
                    <a href="#">Contact Us</a>
                </p>
            </div>
        </footer>
        
    </div>
</div>

<!-- Toggle Sidebar Script -->
<script>
    document.getElementById('toggleSidebar').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>