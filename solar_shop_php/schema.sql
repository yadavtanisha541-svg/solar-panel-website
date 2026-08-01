-- Solar Panel Shop Database Schema
-- Compatible with MySQL 5.7+ / 8.0+ & MariaDB

CREATE DATABASE IF NOT EXISTS `solar_shop_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `solar_shop_db`;

-- 1. Admin Users Table
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) DEFAULT 'admin',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default Admin User (Password: AdminPassword123!)
INSERT INTO `admin_users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Solar Admin', 'admin@solar.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.RAWef5eUO', 'admin')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- 2. Categories Table
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Categories
INSERT INTO `categories` (`id`, `name`, `slug`, `description`) VALUES
(1, 'Solar Panels', 'solar-panels', 'High efficiency Monocrystalline and Polycrystalline solar panels'),
(2, 'Solar Inverters', 'solar-inverters', 'On-grid, Off-grid and Hybrid solar inverters'),
(3, 'Solar Batteries', 'solar-batteries', 'Long lasting Lithium-ion and Tubular solar storage batteries'),
(4, 'Solar Water Heaters', 'solar-water-heaters', 'Eco-friendly solar water heating systems for domestic & industrial use'),
(5, 'Solar Street Lights', 'solar-street-lights', 'All-in-one integrated LED solar street lights')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- 3. Products Table
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `capacity` VARCHAR(100) DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `old_price` DECIMAL(10,2) DEFAULT NULL,
  `description` TEXT NOT NULL,
  `specifications` TEXT,
  `features` TEXT,
  `image` VARCHAR(255) DEFAULT 'default-product.jpg',
  `is_featured` TINYINT(1) DEFAULT 0,
  `stock_status` VARCHAR(50) DEFAULT 'in_stock',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Products
INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `capacity`, `price`, `old_price`, `description`, `specifications`, `features`, `image`, `is_featured`) VALUES
(1, 1, 'Loom Solar 540W Mono PERC Half-Cut Panel', 'loom-solar-540w-mono-perc', '540 Watt', 24500.00, 28000.00, 'Top tier high-efficiency Mono PERC half-cut solar module designed for maximum energy output even in cloudy weather.', 'Cell Type: Mono PERC; Efficiency: 21.3%; Frame: Anodized Aluminum; Warranty: 25 Years', 'Anti-PID Technology, High Wind & Snow Resistance, 25-Year Performance Guarantee, Extreme Temp Tolerance', 'panel-540w.jpg', 1),
(2, 1, 'Tata Power Solar 330W Polycrystalline Panel', 'tata-power-330w-poly', '330 Watt', 14200.00, 16500.00, 'Reliable and durable polycrystalline panel backed by Tata Power quality assurance for home and commercial solar setups.', 'Cell Type: Poly 72 cells; Efficiency: 17.5%; Output: 330W; Warranty: 25 Years', 'Made in India, High Tensile Strength Glass, Excellent Low-light Performance', 'panel-330w.jpg', 1),
(3, 2, 'Havells Enviro 5kW Hybrid Solar Inverter', 'havells-enviro-5kw-hybrid', '5 kW Dual MPPT', 62000.00, 70000.00, 'Smart hybrid inverter with dual MPPT tracker, Wi-Fi monitoring and seamless battery energy management.', 'Capacity: 5000W; Max Efficiency: 97.6%; Battery Voltage: 48V; Wi-Fi Built-in', 'Real-time Mobile App Monitoring, Dual MPPT Tracker, Touch Display, IP65 Waterproof Protection', 'inverter-5kw.jpg', 1),
(4, 2, 'Luminous Solar NXG 1800 24V Pure Sine Wave', 'luminous-nxg-1800-24v', '1.5 kVA / 24V', 11500.00, 13000.00, 'Ideal home off-grid inverter with intelligent solar optimization technology to reduce electricity bills.', 'System Voltage: 24V; Max Panel Power: 1200W; Waveform: Pure Sine Wave', 'ISOT Technology, Battery Gravity Builder, Smart Solar Savings Display', 'inverter-1800.jpg', 0),
(5, 3, 'Luminous Solar Tall Tubular Battery 150Ah', 'luminous-solar-150ah-battery', '150 Ah / 12V', 15800.00, 18000.00, 'Deep cycle long life solar tubular battery with ultra low maintenance and quick recharge capability.', 'Capacity: 150Ah @ C10; Warranty: 60 Months; Voltage: 12V', 'High Density Grid Paste, 60 Months Warranty, Deep Discharge Recovery, Spill-Proof Vented Plugs', 'battery-150ah.jpg', 1),
(6, 4, 'Supreme 200 Litres Solar Water Heater (ETC)', 'supreme-200l-solar-water-heater', '200 Litres/Day', 29500.00, 33000.00, 'Evacuated Tube Collector (ETC) high performance solar water heater with food-grade inner tank.', 'Tanks: 200L Stainless Steel 304; Tubes: 20 Evacuated Glass Tubes; Thermal Insulation: PUF', 'Instant Hot Water 24x7, Rust-Proof Outer Body, Zero Electricity Cost, 5 Year Warranty', 'water-heater-200l.jpg', 1),
(7, 5, 'All-In-One Integrated LED Solar Street Light 30W', 'integrated-solar-street-light-30w', '30W LED / 12V Solar', 7800.00, 9200.00, 'Compact solar street light with built-in LiFePO4 battery, motion sensor, and automatic dusk-to-dawn operation.', 'LED: 30W High Brightness; Battery: 12.8V LiFePO4; Motion Sensor: PIR Built-in', '100% Wireless Installation, Motion Sensor Dimming, Waterproof IP65 Rating, Automatic On/Off', 'street-light-30w.jpg', 0)
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- 4. Projects / Gallery Table
CREATE TABLE IF NOT EXISTS `projects` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `category` VARCHAR(100) NOT NULL DEFAULT 'Residential',
  `client_name` VARCHAR(150) NOT NULL,
  `location` VARCHAR(150) NOT NULL,
  `capacity_kw` VARCHAR(50) NOT NULL,
  `description` TEXT,
  `image` VARCHAR(255) NOT NULL,
  `completion_date` DATE DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Projects
INSERT INTO `projects` (`id`, `title`, `category`, `client_name`, `location`, `capacity_kw`, `description`, `image`, `completion_date`) VALUES
(1, '10kW Rooftop On-Grid Solar Plant', 'Residential', 'Sharma Villa', 'Green Park, New Delhi', '10 kW', 'Installed 10kW On-Grid solar plant with Tata Mono PERC modules reducing electricity bill by 90%.', 'project-1.jpg', '2026-03-15'),
(2, '50kW Commercial Factory Solar System', 'Commercial', 'Apex Textiles Ltd.', 'Noida Industrial Area', '50 kW', 'Turnkey 50kW commercial solar installation with Havells 50kW grid-tie inverter.', 'project-2.jpg', '2026-04-10'),
(3, '25kW Agricultural Solar Pump & Power', 'Agricultural', 'Kisan Agro Farm', 'Jaipur Rural, Rajasthan', '25 kW', 'Off-grid solar system powering submersible pumps and farm office operations.', 'project-3.jpg', '2026-05-20'),
(4, '15kW Hybrid Solar Plant with Battery Storage', 'Residential', 'Dr. Verma Residency', 'Gurugram Sector 45', '15 kW', 'Hybrid solar power system with Lithium battery backup ensuring uninterrupted 24x7 electricity.', 'project-4.jpg', '2026-06-05')
ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

-- 5. Testimonials Table
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `client_name` VARCHAR(150) NOT NULL,
  `role_location` VARCHAR(150) NOT NULL,
  `rating` INT NOT NULL DEFAULT 5,
  `review_text` TEXT NOT NULL,
  `client_image` VARCHAR(255) DEFAULT 'default-user.jpg',
  `is_approved` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Testimonials
INSERT INTO `testimonials` (`id`, `client_name`, `role_location`, `rating`, `review_text`, `client_image`, `is_approved`) VALUES
(1, 'Rajesh Kumar', 'Home Owner, New Delhi', 5, 'Solar Panel Shop team executed our 10kW installation flawlessly. My monthly electricity bill dropped from ₹14,000 to nearly zero! Highly professional service.', 'user-1.jpg', 1),
(2, 'Priya Malhotra', 'School Trustee, Noida', 5, 'We installed solar panels across our school building. Their free site survey was eye-opening and execution was super fast. Highly recommended!', 'user-2.jpg', 1),
(3, 'Vikram Singh', 'Factory Owner, Gurugram', 5, 'Excellent quality solar panels and heavy duty inverters. The payback period calculated by their experts was spot on. 5 stars for solar installation team.', 'user-3.jpg', 1)
ON DUPLICATE KEY UPDATE `client_name`=VALUES(`client_name`);

-- 6. Blogs Table
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `author` VARCHAR(100) DEFAULT 'Solar Expert',
  `content` LONGTEXT NOT NULL,
  `summary` TEXT,
  `image` VARCHAR(255) DEFAULT 'default-blog.jpg',
  `views` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Blogs
INSERT INTO `blogs` (`id`, `title`, `slug`, `author`, `content`, `summary`, `image`) VALUES
(1, 'PM Surya Ghar Muft Bijli Yojana: Guide & Subsidies', 'pm-surya-ghar-muft-bijli-yojana-guide', 'Solar Team', 'The Government of India has launched the PM Surya Ghar Muft Bijli Yojana to provide free electricity up to 300 units monthly to 1 crore households. Under this scheme, homeowners receive up to ₹78,000 direct subsidy for installing rooftop solar systems.', 'Learn how to claim up to ₹78,000 subsidy under PM Surya Ghar Yojana for home rooftop solar panels.', 'blog-1.jpg'),
(2, 'Monocrystalline vs Polycrystalline Solar Panels: Which to Choose?', 'mono-vs-poly-solar-panels-comparison', 'Engineers Team', 'Choosing the right solar panel type is crucial for efficiency and ROI. Monocrystalline panels offer higher efficiency (up to 22%) and sleek black aesthetics, while Polycrystalline panels are budget-friendly and durable for large spaces.', 'Discover key differences between Mono PERC and Poly solar modules to pick the best fit for your budget.', 'blog-2.jpg')
ON DUPLICATE KEY UPDATE `title`=VALUES(`title`);

-- 7. Inquiries Table (Contact Form & Free Site Survey Bookings)
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `type` VARCHAR(50) DEFAULT 'Contact Inquiry',
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `system_type` VARCHAR(100) DEFAULT NULL,
  `monthly_bill` VARCHAR(50) DEFAULT NULL,
  `message` TEXT,
  `status` VARCHAR(50) DEFAULT 'Pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Inquiries
INSERT INTO `inquiries` (`id`, `type`, `name`, `email`, `phone`, `city`, `system_type`, `monthly_bill`, `message`, `status`) VALUES
(1, 'Free Site Survey', 'Amit Patel', 'amit.patel@gmail.com', '+91 98765 43210', 'Delhi', '10 kW On-Grid', '₹12,000 - ₹18,000', 'Interested in rooftop solar panel installation for my 3-story house. Please schedule site survey.', 'Pending'),
(2, 'Product Inquiry', 'Sneha Gupta', 'sneha.gupta@yahoo.com', '+91 98123 45678', 'Noida', '5 kW Hybrid System', '₹7,000 - ₹10,000', 'Want price quote for 5kW Havells inverter with Lithium battery.', 'Contacted')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

-- 8. Site Settings Table
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Site Settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'Solar Panel Shop'),
('tagline', 'Clean, Renewable & Unlimited Solar Energy Solutions'),
('phone', '+91 98765 43210'),
('alt_phone', '+91 98123 45678'),
('email', 'info@solarpanelshop.com'),
('address', 'Plot No. 45, Solar Energy Park, Sector 62, Noida, UP - 201301'),
('whatsapp', '919876543210'),
('working_hours', 'Mon - Sat: 9:00 AM - 7:00 PM'),
('google_map', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14008.114757313888!2d77.3621415!3d28.6289295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce5456ef36d9f%3A0x3b7191b1286136c8!2sSector%2062%2C%20Noida%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin')
ON DUPLICATE KEY UPDATE `setting_value`=VALUES(`setting_value`);
