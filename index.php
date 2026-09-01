<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hebron Apartment Gym MS - Fitness Center</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #eef4ff;
        }
    
        :root {
            --dark: #071d49;
            --light: #42a5f5;
            --red: #e53935;
            --white: #fff;
            --gray: #f5f7fa;
        }

        /* Header */
        header {
            background: var(--dark);
            padding: 15px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #fff;
            font-size: 28px;
            cursor: pointer;
        }

        #navbar {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        #navbar ul {
            display: flex;
            list-style: none;
        }

        #navbar ul li {
            margin-left: 25px;
        }

        #navbar ul li a {
            color: #fff;
            text-decoration: none;
            transition: .3s;
            font-size: 15px;
        }

        #navbar ul li a:hover {
            color: var(--light);
        }

        .buttons {
            display: flex;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo img {
            height: 40px;
            width: auto;
        }

        .logo span {
            color: var(--red);
        }

        .buttons a {
            text-decoration: none;
            padding: 10px 25px;
            margin-left: 10px;
            border-radius: 40px;
            font-weight: bold;
            transition: .3s;
        }

        .login {
            background: transparent;
            border: 2px solid var(--light);
            color: white;
        }

        .login:hover {
            background: var(--light);
        }

        .register {
            background: var(--red);
            color: white;
        }

        .register:hover {
            background: #c62828;
        }

        /* Hero Section */
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 80px 8%;
            background: linear-gradient(135deg, #071d49, #1a3a6a);
            color: white;
            min-height: 500px;
        }

        .hero-text {
            width: 55%;
        }

        .hero-text h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero-text h1 span {
            color: #ff5252;
        }

        .hero-text p {
            line-height: 1.8;
            margin-bottom: 30px;
            font-size: 18px;
            color: #cce4ff;
        }

        .hero-text .btn-primary {
            background: var(--red);
            padding: 15px 35px;
            border-radius: 40px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            display: inline-block;
            transition: .3s;
        }

        .hero-text .btn-primary:hover {
            background: #c62828;
            transform: scale(1.05);
        }

        .hero-image {
            width: 40%;
        }

        .hero-image img {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .4);
        }

        /* Section Titles */
        .section-title {
            text-align: center;
            font-size: 35px;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .section-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 40px;
            font-size: 18px;
        }

        /* About Section */
        .about-section {
            padding: 70px 8%;
            background: white;
        }

        .about-container {
            display: flex;
            gap: 50px;
            align-items: center;
        }

        .about-image {
            flex: 1;
        }

        .about-image img {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,.1);
        }

        .about-content {
            flex: 1;
        }

        .about-content h2 {
            color: var(--dark);
            font-size: 32px;
            margin-bottom: 20px;
        }

        .about-content h2 span {
            color: var(--red);
        }

        .about-content p {
            color: #555;
            line-height: 1.8;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .about-features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }

        .about-features li {
            list-style: none;
            color: #333;
            font-weight: 500;
        }

        .about-features li i {
            color: var(--red);
            margin-right: 8px;
        }

        /* Training Gallery */
        .training-gallery {
            padding: 70px 8%;
            background: var(--gray);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .gallery-item {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
            transition: .4s;
            cursor: pointer;
            aspect-ratio: 4/3;
        }

        .gallery-item:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: .4s;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-item .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(transparent, rgba(7, 29, 73, .85));
            color: white;
            transform: translateY(30px);
            transition: .4s;
            opacity: 0;
        }

        .gallery-item:hover .overlay {
            transform: translateY(0);
            opacity: 1;
        }

        .gallery-item .overlay h4 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .gallery-item .overlay p {
            font-size: 14px;
            opacity: .9;
        }

        .gallery-item .overlay .badge {
            display: inline-block;
            background: var(--red);
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 11px;
            margin-top: 5px;
        }

        /* Quick Access Cards */
        .quick-access {
            padding: 70px 8%;
            background: white;
        }

        .access-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .access-card {
            background: var(--gray);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: .3s;
            border: 2px solid transparent;
            text-decoration: none;
            color: var(--dark);
        }

        .access-card:hover {
            transform: translateY(-8px);
            border-color: var(--red);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .1);
        }

        .access-card i {
            font-size: 45px;
            color: var(--red);
            margin-bottom: 15px;
        }

        .access-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .access-card p {
            color: #666;
            font-size: 14px;
        }

        .access-card .arrow {
            display: inline-block;
            margin-top: 15px;
            color: var(--red);
            font-weight: bold;
        }

        /* Features Section */
        .features {
            padding: 70px 8%;
            background: var(--gray);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .feature-item {
            text-align: center;
            padding: 30px 20px;
            background: white;
            border-radius: 15px;
            transition: .3s;
        }

        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .1);
        }

        .feature-item i {
            font-size: 40px;
            color: var(--red);
            margin-bottom: 15px;
        }

        .feature-item h4 {
            color: var(--dark);
            margin-bottom: 10px;
        }

        .feature-item p {
            color: #666;
            font-size: 14px;
        }

        /* Stats Section */
        .stats {
            padding: 60px 8%;
            background: var(--dark);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 45px;
            color: white;
        }

        .stat-item p {
            color: #aac6ec;
            font-size: 16px;
            font-weight: 600;
        }

        .stat-item i {
            font-size: 40px;
            color: var(--red);
            display: block;
            margin-bottom: 10px;
        }

        /* Contact Section */
        .contact-form {
    background-image: url('images/contactbg.jpg');
    background-size: cover;
    background-position: center;
    padding: 40px;
    border-radius: 15px;
    position: relative;
    color: white;
}

        .contact-section {
            padding: 70px 8%;
            background: white;
        }

        .contact-container {
            display: flex;
            gap: 50px;
        }

        .contact-info {
            flex: 1;
        }

        .contact-info h3 {
            color: var(--dark);
            font-size: 24px;
            margin-bottom: 20px;
        }

        .contact-info p {
            color: #555;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .contact-detail {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .contact-detail i {
            width: 45px;
            height: 45px;
            background: var(--red);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .contact-detail .detail-text h4 {
            color: var(--dark);
            font-size: 16px;
        }

        .contact-detail .detail-text p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }

        .contact-form {
            flex: 1;
            background: var(--gray);
            padding: 40px;
            border-radius: 15px;
        }

        .contact-form h3 {
            color: var(--dark);
            font-size: 24px;
            margin-bottom: 20px;
        }

        .contact-form .form-group {
            margin-bottom: 18px;
        }

        .contact-form .form-group label {
            display: block;
            font-weight: 500;
            color: #333;
            margin-bottom: 5px;
        }

        .contact-form .form-group input,
        .contact-form .form-group textarea,
        .contact-form .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: .3s;
        }

        .contact-form .form-group input:focus,
        .contact-form .form-group textarea:focus,
        .contact-form .form-group select:focus {
            border-color: var(--red);
            outline: none;
        }

        .contact-form .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .contact-form .btn-submit {
            background: var(--red);
            color: white;
            padding: 14px 35px;
            border: none;
            border-radius: 40px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: .3s;
            width: 100%;
        }

        .contact-form .btn-submit:hover {
            background: #c62828;
            transform: scale(1.02);
        }

        .map-container {
            margin-top: 30px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,.1);
        }

        .map-container iframe {
            width: 100%;
            height: 350px;
            border: none;
        }

        /* Success Message */
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            display: none;
        }

        .alert-success.show {
            display: block;
        }

        /* Footer */
        footer {
            position: relative;
            background: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1200') center center/cover no-repeat;
            color: #fff;
            padding: 70px 8% 30px;
            margin-top: 0;
            overflow: hidden;
        }

        footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(7, 29, 73, .92);
        }

        .footer-container,
        .copyright {
            position: relative;
            z-index: 2;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 30px;
        }

        .footer-column {
            flex: 1;
            min-width: 200px;
        }

        .footer-column h3 {
            color: #42a5f5;
            margin-bottom: 20px;
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-column h3 img {
            height: 30px;
            width: auto;
        }

        .footer-column p {
            color: #ddd;
            line-height: 1.8;
        }

        .footer-column a {
            display: block;
            color: #ddd;
            text-decoration: none;
            margin-bottom: 12px;
            transition: .3s;
            font-size: 14px;
        }

        .footer-column a:hover {
            color: #fff;
            padding-left: 8px;
        }

        .footer-column a i {
            width: 20px;
            color: var(--red);
        }

        .social {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social a {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .15);
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-decoration: none;
            transition: .3s;
            margin: 0;
        }

        .social a:hover {
            background: #e53935;
            transform: translateY(-4px);
        }

        .copyright {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, .2);
            text-align: center;
            color: #ddd;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .gallery-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .about-container {
                flex-direction: column;
            }
            .contact-container {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .about-features {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 900px) {
            header {
                flex-wrap: wrap;
            }

            .menu-toggle {
                display: block;
            }

            #navbar {
                width: 100%;
                display: none;
                flex-direction: column;
                background: #071d49;
                margin-top: 15px;
                border-radius: 12px;
                overflow: hidden;
            }

            #navbar.active {
                display: flex;
            }

            #navbar ul {
                width: 100%;
                flex-direction: column;
            }

            #navbar ul li {
                margin: 0;
                border-bottom: 1px solid rgba(255, 255, 255, .1);
            }

            #navbar ul li:last-child {
                border-bottom: none;
            }

            #navbar ul li a {
                display: block;
                padding: 16px 20px;
            }

            .buttons {
                width: 100%;
                flex-direction: column;
                padding: 20px;
                gap: 15px;
            }

            .buttons a {
                width: 100%;
                text-align: center;
                margin: 0;
            }

            .hero {
                flex-direction: column;
                text-align: center;
                padding: 50px 5%;
            }

            .hero-text,
            .hero-image {
                width: 100%;
            }

            .hero-image {
                margin-top: 35px;
            }

            .hero-text h1 {
                font-size: 32px;
            }

            .footer-container {
                flex-direction: column;
                text-align: center;
            }

            .footer-column h3 {
                justify-content: center;
            }

            .social {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .logo img {
                height: 30px;
            }
            .logo {
                font-size: 20px;
            }
            .hero-text h1 {
                font-size: 26px;
            }
            .access-grid {
                grid-template-columns: 1fr;
            }
            .gallery-grid {
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }
        }

        @media (max-width: 400px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Tinah Gym Pro">
            <span></span>
        </div>

        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>

        <nav id="navbar">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#membership">Membership</a></li>
                <li><a href="#trainers">Trainers</a></li>
                <li><a href="#classes">Classes</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>

            <div class="buttons">
                <a href="login.php" class="login">Login</a>
                <a href="register.php" class="register">Register</a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-text">
            <h1>Welcome to <span>Hebron Apartment Gym MS</span></h1>
            <p>Complete Gym Management System. Manage members, trainers, classes, payments, and more all in one place.</p>
            <a href="#training" class="btn-primary">Explore Training</a>
        </div>
        <div class="hero-image">
            
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about-section" id="about">
        <div class="about-container">
            <div class="about-image">
                
            </div>
            <div class="about-content">
                <h2>About <span>Hebron Apartment Gym MS</span></h2>
                <p>Hebron Apartment Gym MS is a premier apartment-based gym management system located in the heart of Kitengela. We provide top-notch fitness facilities and professional training services to residents and the surrounding community.</p>
                <p>Our mission is to make fitness accessible, convenient, and enjoyable for everyone. Whether you're a beginner or a seasoned athlete, we have the programs and equipment to help you achieve your fitness goals.</p>
                <ul class="about-features">
                    <li><i class="fas fa-check-circle"></i> Apartment-based fitness center</li>
                    <li><i class="fas fa-check-circle"></i> State-of-the-art equipment</li>
                    <li><i class="fas fa-check-circle"></i> Certified professional trainers</li>
                    <li><i class="fas fa-check-circle"></i> Flexible membership plans</li>
                    <li><i class="fas fa-check-circle"></i> 24/7 access for members</li>
                    <li><i class="fas fa-check-circle"></i> Safe and clean environment</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stat-item">
            <i class="fas fa-users"></i>
            <h3>2,500+</h3>
            <p>Happy Members</p>
        </div>
        <div class="stat-item">
            <i class="fas fa-dumbbell"></i>
            <h3>50+</h3>
            <p>Training Programs</p>
        </div>
        <div class="stat-item">
            <i class="fas fa-chalkboard-teacher"></i>
            <h3>20+</h3>
            <p>Expert Trainers</p>
        </div>
        <div class="stat-item">
            <i class="fas fa-award"></i>
            <h3>15+</h3>
            <p>Awards Won</p>
        </div>
    </section>

    <!-- Training Gallery -->
    <section class="training-gallery" id="training">
        <h2 class="section-title">Training Programs</h2>
        <p class="section-subtitle">Explore our wide range of professional training programs</p>

        <div class="gallery-grid">
            <!-- Row 1 -->
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?w=600" alt="Cardio Training">
                <div class="overlay">
                    <h4>Cardio Training</h4>
                    <p>High-energy cardio workouts</p>
                    <span class="badge">Popular</span>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1532384748853-8f54a8f476e2?w=600" alt="Strength Training">
                <div class="overlay">
                    <h4>Strength Training</h4>
                    <p>Build muscle & increase power</p>
                    <span class="badge">Advanced</span>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=600" alt="Yoga">
                <div class="overlay">
                    <h4>Yoga & Flexibility</h4>
                    <p>Find balance & inner peace</p>
                    <span class="badge">Beginner</span>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1518611012118-696072aa579a?w=600" alt="HIIT Training">
                <div class="overlay">
                    <h4>HIIT Training</h4>
                    <p>Intense interval training</p>
                    <span class="badge">Advanced</span>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1541532713592-79a0317b6b77?w=600" alt="Boxing">
                <div class="overlay">
                    <h4>Boxing & MMA</h4>
                    <p>Build strength & discipline</p>
                    <span class="badge">Intermediate</span>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600" alt="Pilates">
                <div class="overlay">
                    <h4>Pilates</h4>
                    <p>Core strength & posture</p>
                    <span class="badge">Beginner</span>
                </div>
            </div>

            <!-- Row 3 -->
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1583454110551-21f2fa2afe61?w=600" alt="CrossFit">
                <div class="overlay">
                    <h4>CrossFit</h4>
                    <p>Full body conditioning</p>
                    <span class="badge">Advanced</span>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07e?w=600" alt="Zumba Dance">
                <div class="overlay">
                    <h4>Zumba Dance</h4>
                    <p>Fun dance fitness classes</p>
                    <span class="badge">Beginner</span>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1576678927484-cc907957088c?w=600" alt="Spinning">
                <div class="overlay">
                    <h4>Spinning</h4>
                    <p>High-intensity cycling</p>
                    <span class="badge">Intermediate</span>
                </div>
            </div>

            <!-- Row 4 -->
            <div class="gallery-item">
                <img src="images/kettletraining.jpg" alt="Kettlebell Training">
                <div class="overlay">
                    <h4>Kettlebell Training</h4>
                    <p>Dynamic strength training</p>
                    <span class="badge">Intermediate</span>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1571731956672-f2b94d7dd0cb?w=600" alt="Calisthenics">
                <div class="overlay">
                    <h4>Calisthenics</h4>
                    <p>Bodyweight mastery</p>
                    <span class="badge">Advanced</span>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=600" alt="Functional Training">
                <div class="overlay">
                    <h4>Functional Training</h4>
                    <p>Everyday strength & mobility</p>
                    <span class="badge">All Levels</span>
                </div>
            </div>

            <!-- Row 5 -->
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1549060279-7e168fcee0c2?w=600" alt="TRX">
                <div class="overlay">
                    <h4>TRX Suspension</h4>
                    <p>Core & balance training</p>
                    <span class="badge">Intermediate</span>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1581009137042-c552e485697a?w=600" alt="Personal Training">
                <div class="overlay">
                    <h4>Personal Training</h4>
                    <p>One-on-one expert coaching</p>
                    <span class="badge">Premium</span>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1538805060514-97d9cc17730c?w=600" alt="Recovery">
                <div class="overlay">
                    <h4>Recovery & Stretching</h4>
                    <p>Post-workout recovery</p>
                    <span class="badge">Beginner</span>
                </div>
            </div>

            <!-- Row 6 -->
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1556817411-31ae72fa3ea0?w=600" alt="Team Training">
                <div class="overlay">
                    <h4>Team Training</h4>
                    <p>Group fitness sessions</p>
                    <span class="badge">Popular</span>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1570829460005-c840387bb1ca?w=600" alt="Seniors Fitness">
                <div class="overlay">
                    <h4>Seniors Fitness</h4>
                    <p>Gentle & effective workouts</p>
                    <span class="badge">Beginner</span>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1518310383802-640c2de311b2?w=600" alt="Kids Fitness">
                <div class="overlay">
                    <h4>Kids Fitness</h4>
                    <p>Fun fitness for children</p>
                    <span class="badge">Kids</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Access Cards -->
    <section class="quick-access" id="features">
        <h2 class="section-title">Quick Access</h2>
        <p class="section-subtitle">Manage all aspects of your gym from one dashboard</p>

        <div class="access-grid">
            <a href="admin/membership.php" class="access-card">
                <i class="fas fa-users"></i>
                <h3>Gym Members</h3>
                <p>View, add, and manage all gym members</p>
                <span class="arrow">Access →</span>
            </a>

            <a href="admin/membership_mgmt.php" class="access-card">
                <i class="fas fa-id-card"></i>
                <h3>Membership Mgmt</h3>
                <p>Registration, renewal & attendance tracking</p>
                <span class="arrow">Access →</span>
            </a>

            <a href="admin/trainers.php" class="access-card">
                <i class="fas fa-chalkboard-teacher"></i>
                <h3>Trainers</h3>
                <p>Manage trainer profiles and schedules</p>
                <span class="arrow">Access →</span>
            </a>

            <a href="admin/trainer_mgmt.php" class="access-card">
                <i class="fas fa-calendar-alt"></i>
                <h3>Trainer Mgmt</h3>
                <p>Scheduling and payroll management</p>
                <span class="arrow">Access →</span>
            </a>

            <a href="admin/classes.php" class="access-card">
                <i class="fas fa-dumbbell"></i>
                <h3>Class & Session Mgmt</h3>
                <p>Bookings, group classes & personal training</p>
                <span class="arrow">Access →</span>
            </a>

            <a href="admin/payments.php" class="access-card">
                <i class="fas fa-credit-card"></i>
                <h3>Payment & Billing</h3>
                <p>Invoices, subscriptions & receipts</p>
                <span class="arrow">Access →</span>
            </a>

            <a href="admin/reports.php" class="access-card">
                <i class="fas fa-chart-bar"></i>
                <h3>Reports & Analytics</h3>
                <p>Member reports, revenue & utilization stats</p>
                <span class="arrow">Access →</span>
            </a>

            <a href="admin/database.php" class="access-card">
                <i class="fas fa-database"></i>
                <h3>Database & Storage</h3>
                <p>All records in one centralized location</p>
                <span class="arrow">Access →</span>
            </a>

            <a href="admin/notifications.php" class="access-card">
                <i class="fas fa-bell"></i>
                <h3>Notifications</h3>
                <p>SMS, Email & App Alerts</p>
                <span class="arrow">Access →</span>
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="membership">
        <h2 class="section-title">Key Features</h2>
        <p class="section-subtitle">Everything you need to run your gym efficiently</p>

        <div class="features-grid">
            <div class="feature-item">
                <i class="fas fa-user-plus"></i>
                <h4>Member Registration</h4>
                <p>Quick and easy member signup with all necessary details</p>
            </div>

            <div class="feature-item">
                <i class="fas fa-sync-alt"></i>
                <h4>Membership Renewal</h4>
                <p>Automatic renewal reminders and easy payment processing</p>
            </div>

            <div class="feature-item">
                <i class="fas fa-clipboard-check"></i>
                <h4>Attendance Tracking</h4>
                <p>Monitor member check-ins and class attendance in real-time</p>
            </div>

            <div class="feature-item">
                <i class="fas fa-calendar-check"></i>
                <h4>Class Scheduling</h4>
                <p>Schedule group classes and personal training sessions</p>
            </div>

            <div class="feature-item">
                <i class="fas fa-money-bill-wave"></i>
                <h4>Payment Processing</h4>
                <p>Secure payment handling with invoice generation</p>
            </div>

            <div class="feature-item">
                <i class="fas fa-chart-line"></i>
                <h4>Revenue Tracking</h4>
                <p>Real-time revenue analytics and financial reporting</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <h2 class="section-title">Contact Us</h2>
        <p class="section-subtitle">Get in touch with us for any inquiries or support</p>

        <div class="contact-container">
            <div class="contact-info">
                <h3>Get In Touch</h3>
                <p>We're here to help! Reach out to us through any of the following channels:</p>

                <div class="contact-detail">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="detail-text">
                        <h4>Address</h4>
                        <p>Kitengela, Kajiado County, Kenya</p>
                    </div>
                </div>

                <div class="contact-detail">
                    <i class="fas fa-phone"></i>
                    <div class="detail-text">
                        <h4>Phone</h4>
                        <p>+254 700 123 456</p>
                    </div>
                </div>

                <div class="contact-detail">
                    <i class="fas fa-envelope"></i>
                    <div class="detail-text">
                        <h4>Email</h4>
                        <p>info@tinahgympro.com</p>
                    </div>
                </div>

                <div class="contact-detail">
                    <i class="fas fa-clock"></i>
                    <div class="detail-text">
                        <h4>Working Hours</h4>
                        <p>Monday - Saturday: 6:00 AM - 10:00 PM</p>
                        <p>Sunday: 8:00 AM - 8:00 PM</p>
                    </div>
                </div>
            </div>

            <div class="contact-form" id="contactForm">
                <h3>Send Us a Message</h3>
                
                <div class="alert-success" id="successMessage">
                    <i class="fas fa-check-circle"></i> Your message has been sent successfully! We'll get back to you shortly.
                </div>
                <form action="submit_contact.php" method="POST">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select id="subject" name="subject" required>
                            <option value="">Select a subject</option>
                            <option value="General Inquiry">General Inquiry</option>
                            <option value="Membership">Membership Information</option>
                            <option value="Training Programs">Training Programs</option>
                            <option value="Support">Support</option>
                            <option value="Feedback">Feedback</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" placeholder="Write your message here..." required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
        </div>

        <!-- Google Map of Kitengela -->
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255282.7293358407!2d36.80801907919185!3d-1.5202324792161731!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f3b5c9b8d3b5b%3A0x5b5c5b5c5b5c5b5c!2sKitengela%2C%20Kenya!5e0!3m2!1sen!2sus!4v1700000000000" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h3>
                    <img src="images/logo.png" alt="Tinah Gym Pro Logo">
                    
                </h3>
                <p>Complete gym management solution for modern fitness centers.</p>
            </div>

            <div class="footer-column">
                <h3>Quick Links</h3>
                <a href="index.html"><i class="fas fa-chevron-right"></i> Home</a>
                <a href="#about"><i class="fas fa-chevron-right"></i> About Us</a>
                <a href="#training"><i class="fas fa-chevron-right"></i> Training Programs</a>
                <a href="#membership"><i class="fas fa-chevron-right"></i> Membership</a>
                <a href="#contact"><i class="fas fa-chevron-right"></i> Contact</a>
            </div>

            <div class="footer-column">
                <h3>Admin Panels</h3>
                <a href="admin/membership.php"><i class="fas fa-chevron-right"></i> Gym Members</a>
                <a href="admin/membership_mgmt.php"><i class="fas fa-chevron-right"></i> Membership Mgmt</a>
                <a href="admin/trainers.php"><i class="fas fa-chevron-right"></i> Trainers</a>
                <a href="admin/trainer_mgmt.php"><i class="fas fa-chevron-right"></i> Trainer Mgmt</a>
                <a href="admin/classes.php"><i class="fas fa-chevron-right"></i> Class & Session Mgmt</a>
                <a href="admin/payments.php"><i class="fas fa-chevron-right"></i> Payment & Billing</a>
                <a href="admin/reports.php"><i class="fas fa-chevron-right"></i> Reports & Analytics</a>
                <a href="admin/database.php"><i class="fas fa-chevron-right"></i> Database & Storage</a>
                <a href="admin/notifications.php"><i class="fas fa-chevron-right"></i> Notifications</a>
            </div>

            <div class="footer-column">
                <h3>Follow Us</h3>
                <div class="social">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <div class="copyright">
            &copy; 2026 Hebron Apartment Gym MS. All Rights Reserved.
        </div>
    </footer>

    <script>
        const menuToggle = document.getElementById("menuToggle");
        const navbar = document.getElementById("navbar");

        menuToggle.addEventListener("click", () => {
            navbar.classList.toggle("active");
            if (navbar.classList.contains("active")) {
                menuToggle.innerHTML = '<i class="fas fa-times"></i>';
            } else {
                menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });

        document.querySelectorAll("#navbar a").forEach(link => {
            link.addEventListener("click", () => {
                navbar.classList.remove("active");
                menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            });
        });

        // Form submission handler
        document.querySelector('.contact-form form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('submit_contact.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('successMessage').classList.add('show');
                    this.reset();
                    setTimeout(() => {
                        document.getElementById('successMessage').classList.remove('show');
                    }, 5000);
                } else {
                    alert('There was an error sending your message. Please try again.');
                }
            })
            .catch(error => {
                alert('There was an error sending your message. Please try again.');
            });
        });
    </script>

</body>
</html>