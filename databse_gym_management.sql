-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 01, 2026 at 02:47 PM
-- Server version: 8.0.41
-- PHP Version: 8.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techcod2_gym_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int NOT NULL,
  `admin_id` int DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `details` text,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `admin_id`, `action`, `details`, `ip_address`, `created_at`) VALUES
(4, 1, 'logout', NULL, '102.0.27.74', '2026-07-23 07:51:53'),
(5, 1, 'logout', NULL, '102.0.27.74', '2026-07-23 10:05:50'),
(6, 1, 'logout', NULL, '102.0.27.74', '2026-07-23 10:47:25'),
(7, 1, 'logout', NULL, '102.0.27.74', '2026-07-23 10:50:17'),
(8, 1, 'logout', NULL, '102.0.27.74', '2026-07-23 12:17:24'),
(9, 1, 'logout', NULL, '105.161.172.168', '2026-07-27 14:06:09'),
(10, 1, 'logout', NULL, '102.210.152.37', '2026-07-30 08:41:17'),
(11, 1, 'logout', NULL, '102.210.152.37', '2026-07-30 09:18:17'),
(12, 1, 'logout', NULL, '102.210.152.37', '2026-07-31 06:44:55'),
(13, 1, 'logout', NULL, '102.210.152.37', '2026-07-31 18:41:37'),
(14, 1, 'logout', NULL, '102.210.152.37', '2026-07-31 18:45:03');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('admin','manager','staff') DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `password_hash`, `full_name`, `role`, `created_at`, `last_login`) VALUES
(1, 'admin', 'admin@gym.com', 'admin@2026', 'Administrator', 'admin', '2026-07-20 18:13:56', '2026-07-31 18:41:57');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int NOT NULL,
  `member_id` int DEFAULT NULL,
  `check_in_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `check_out_time` datetime DEFAULT NULL,
  `status` enum('Checked In','Checked Out') DEFAULT 'Checked In',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `description` text,
  `trainer_id` int DEFAULT NULL,
  `category` enum('Yoga','Pilates','Cardio','Strength','HIIT','Dance','Cycling','Boxing','Other') DEFAULT 'Other',
  `max_capacity` int DEFAULT '20',
  `duration_minutes` int DEFAULT '60',
  `difficulty` enum('Beginner','Intermediate','Advanced') DEFAULT 'Intermediate',
  `location` varchar(100) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `description`, `trainer_id`, `category`, `max_capacity`, `duration_minutes`, `difficulty`, `location`, `status`, `created_at`) VALUES
(2, 'HIIT Blast', 'High intensity interval training for maximum results', 3, 'HIIT', 15, 45, 'Intermediate', 'Studio B', 'Active', '2026-07-20 18:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `class_bookings`
--

CREATE TABLE `class_bookings` (
  `id` int NOT NULL,
  `member_id` int DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  `schedule_id` int DEFAULT NULL,
  `booking_date` date NOT NULL,
  `status` enum('Confirmed','Cancelled','Attended') DEFAULT 'Confirmed',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule`
--

CREATE TABLE `class_schedule` (
  `id` int NOT NULL,
  `class_id` int DEFAULT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `status` enum('Active','Cancelled') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_schedule`
--

INSERT INTO `class_schedule` (`id`, `class_id`, `day_of_week`, `start_time`, `end_time`, `status`, `created_at`) VALUES
(4, 2, 'Tuesday', '18:00:00', '18:45:00', 'Active', '2026-07-20 18:13:58'),
(5, 2, 'Thursday', '18:00:00', '18:45:00', 'Active', '2026-07-20 18:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Pending','Read','Replied','Archived') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'john@example.com', '+254 700 111 222', 'Membership Inquiry', 'I would like to know more about your premium membership plans. Do you offer family discounts?', 'Pending', '2026-07-21 10:51:20', '2026-07-21 10:51:20'),
(2, 'Jane Smith', 'jane@example.com', '+254 700 333 444', 'Training Programs', 'I am interested in personal training sessions. What are your rates and availability?', 'Read', '2026-07-21 10:51:20', '2026-07-21 10:51:20'),
(3, 'Mike Johnson', 'mike@example.com', '+254 700 555 666', 'Support', 'I am having trouble logging into my member account. Please assist.', 'Replied', '2026-07-21 10:51:20', '2026-07-21 10:51:20'),
(4, 'John Doe', 'john@example.com', '+254 700 111 222', 'Membership Inquiry', 'I would like to know more about your premium membership plans. Do you offer family discounts?', 'Pending', '2026-07-21 13:46:09', '2026-07-21 13:46:09'),
(5, 'Jane Smith', 'jane@example.com', '+254 700 333 444', 'Training Programs', 'I am interested in personal training sessions. What are your rates and availability?', 'Read', '2026-07-21 13:46:09', '2026-07-21 13:46:09'),
(6, 'Mike Johnson', 'mike@example.com', '+254 700 555 666', 'Support', 'I am having trouble logging into my member account. Please assist.', 'Replied', '2026-07-21 13:46:09', '2026-07-21 13:46:09');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `category` varchar(50) DEFAULT NULL,
  `instructor` varchar(100) DEFAULT NULL,
  `duration` int DEFAULT NULL COMMENT 'in hours',
  `price` decimal(10,2) DEFAULT '0.00',
  `level` enum('Beginner','Intermediate','Advanced') DEFAULT 'Beginner',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `category`, `instructor`, `duration`, `price`, `level`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Personal Training Certification', 'Become a certified personal trainer', 'Certification', 'John Doe', 40, 499.99, 'Advanced', 'active', '2026-07-30 06:16:56', '2026-07-30 06:16:56'),
(2, 'Nutrition Fundamentals', 'Learn the basics of nutrition', 'Nutrition', 'Jane Smith', 20, 299.99, 'Beginner', 'active', '2026-07-30 06:16:56', '2026-07-30 06:16:56'),
(3, 'Advanced Strength Training', 'Master advanced strength techniques', 'Strength', 'Mike Johnson', 30, 399.99, 'Intermediate', 'active', '2026-07-30 06:16:56', '2026-07-30 06:16:56'),
(4, 'Yoga Instructor Course', 'Become a certified yoga instructor', 'Yoga', 'Sarah Wilson', 50, 599.99, 'Advanced', 'active', '2026-07-30 06:16:56', '2026-07-30 06:16:56'),
(5, 'Group Fitness Leadership', 'Lead group fitness classes', 'Group Fitness', 'Emily Davis', 25, 349.99, 'Intermediate', 'active', '2026-07-30 06:16:56', '2026-07-30 06:16:56'),
(6, 'Sports Psychology', 'Mental training for athletes', 'Psychology', 'Dr. Robert Brown', 15, 249.99, 'Beginner', 'active', '2026-07-30 06:16:56', '2026-07-30 06:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int NOT NULL,
  `member_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `address` text,
  `emergency_contact` varchar(100) DEFAULT NULL,
  `emergency_phone` varchar(20) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `join_date` date NOT NULL,
  `membership_type` enum('Basic','Premium','VIP','Day Pass') DEFAULT 'Basic',
  `membership_status` enum('Active','Expired','Suspended','Cancelled') DEFAULT 'Active',
  `membership_expiry` date DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `member_id`, `first_name`, `last_name`, `email`, `phone`, `date_of_birth`, `gender`, `address`, `emergency_contact`, `emergency_phone`, `profile_image`, `join_date`, `membership_type`, `membership_status`, `membership_expiry`, `notes`, `created_at`, `updated_at`) VALUES
(2, 'M002', 'Jane', 'Smith', 'jane.smith@email.com', '555-0102', '1988-08-22', 'Female', NULL, NULL, NULL, NULL, '2024-02-01', 'Basic', 'Active', '2025-02-01', NULL, '2026-07-20 18:13:57', '2026-07-20 18:13:57');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text,
  `duration_months` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `features` text,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `name`, `description`, `duration_months`, `price`, `features`, `status`, `created_at`) VALUES
(1, 'Basic', 'Access to gym floor and basic equipment', 1, 49.99, 'Gym access, Locker room', 'Active', '2026-07-20 18:13:57'),
(2, 'Premium', 'Full access including classes and trainers', 1, 79.99, 'Gym access, All classes, Personal trainer consultation', 'Active', '2026-07-20 18:13:57'),
(3, 'VIP', 'Premium access with additional perks', 1, 129.99, 'Gym access, All classes, Personal trainer, Sauna, Towel service', 'Active', '2026-07-20 18:13:57'),
(4, 'Day Pass', 'Single day access', 0, 15.99, 'Full day gym access', 'Active', '2026-07-20 18:13:57');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `member_id` int DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `payment_method` enum('Cash','Credit Card','Debit Card','Bank Transfer','Online','M-Pesa') DEFAULT 'Cash',
  `payment_type` enum('Membership','Class','Personal Training','Other') DEFAULT 'Membership',
  `reference_number` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `status` enum('Pending','Completed','Failed','Refunded') DEFAULT 'Completed',
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `member_id`, `amount`, `payment_date`, `payment_method`, `payment_type`, `reference_number`, `phone_number`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(4, 2, 200.00, '2026-07-23 09:57:00', 'Cash', 'Membership', 'mmmmm', '0717778664', 'Completed', 'mmmmmmm', '2026-07-23 09:58:14', '2026-07-23 09:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` int NOT NULL,
  `trainer_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `certifications` text,
  `experience_years` int DEFAULT '0',
  `profile_image` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive','On Leave') DEFAULT 'Active',
  `hire_date` date NOT NULL,
  `hourly_rate` decimal(10,2) DEFAULT '0.00',
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `trainer_id`, `first_name`, `last_name`, `email`, `phone`, `specialization`, `certifications`, `experience_years`, `profile_image`, `status`, `hire_date`, `hourly_rate`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'T001', 'Sarah', 'Wilson', 'sarah.w@trainer.com', '555-0201', 'Strength Training', NULL, 8, NULL, 'Active', '2023-01-15', 50.00, NULL, '2026-07-20 18:13:57', '2026-07-20 18:13:57'),
(2, 'T002', 'David', 'Brown', 'david.b@trainer.com', '555-0202', 'Yoga & Flexibility', NULL, 5, NULL, 'Active', '2023-06-01', 45.00, NULL, '2026-07-20 18:13:57', '2026-07-20 18:13:57'),
(3, 'T003', 'Emily', 'Davis', 'emily.d@trainer.com', '555-0203', 'Cardio & HIIT', NULL, 3, NULL, 'Active', '2024-01-10', 40.00, NULL, '2026-07-20 18:13:57', '2026-07-20 18:13:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','user','trainer') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `full_name`, `phone`, `role`, `status`, `created_at`, `updated_at`) VALUES
(2, 'user', 'user@tinahgym.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sample User', '+254 700 000 000', 'user', 'active', '2026-07-30 06:36:48', '2026-07-30 06:36:48'),
(3, 'Eric', 'barario64@gmail.com', '$2y$10$3154meBoZwPCpzB6jz.UG.6Je9ObkViJRkt7KBcKe/ygECGbJbaF.', 'Eric barario Mairura', '0712739003', 'user', 'active', '2026-07-30 06:41:23', '2026-07-30 06:41:23'),
(4, 'thenrymunyoki@gmail.com', 'thenrymunyoki@gmail.com', '$2y$10$m0opL3SC4XrBVhbfGap.TOYxoDDuFNCRnHJRz5Fxb1E5SezUyryzi', 'Henry', '31686479', 'user', 'active', '2026-07-30 06:48:11', '2026-07-30 07:22:44');

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `course_id` int NOT NULL,
  `enrollment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `progress` int DEFAULT '0',
  `status` enum('enrolled','in_progress','completed','dropped') COLLATE utf8mb4_unicode_ci DEFAULT 'enrolled',
  `completion_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_courses`
--

INSERT INTO `user_courses` (`id`, `user_id`, `course_id`, `enrollment_date`, `progress`, `status`, `completion_date`, `created_at`, `updated_at`) VALUES
(1, 4, 5, '2026-07-30 09:19:16', 0, 'enrolled', NULL, '2026-07-30 09:19:16', '2026-07-30 09:19:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `class_bookings`
--
ALTER TABLE `class_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_booking` (`member_id`,`class_id`,`schedule_id`,`booking_date`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_id` (`member_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_expires` (`expires_at`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_member_id` (`member_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_payment_date` (`payment_date`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trainer_id` (`trainer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_enrollment` (`user_id`,`course_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_course_id` (`course_id`),
  ADD KEY `idx_status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `class_bookings`
--
ALTER TABLE `class_bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_schedule`
--
ALTER TABLE `class_schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD CONSTRAINT `admin_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `class_bookings`
--
ALTER TABLE `class_bookings`
  ADD CONSTRAINT `class_bookings_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_bookings_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_bookings_ibfk_3` FOREIGN KEY (`schedule_id`) REFERENCES `class_schedule` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD CONSTRAINT `class_schedule_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD CONSTRAINT `user_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
