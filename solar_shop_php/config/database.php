<?php
require_once __DIR__ . '/config.php';

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            // Attempt MySQL Connection via PDO
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Fallback to SQLite database if MySQL server or DB is not reachable locally
            try {
                $sqlitePath = __DIR__ . '/solar_shop.sqlite';
                if (!is_writable(__DIR__) && !file_exists($sqlitePath)) {
                    $sqlitePath = sys_get_temp_dir() . '/solar_shop.sqlite';
                }
                $isNewDb = !file_exists($sqlitePath);
                
                $this->pdo = new PDO("sqlite:" . $sqlitePath);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                if ($isNewDb) {
                    $this->seedSqlite($this->pdo);
                }
            } catch (Exception $sqliteErr) {
                die("Database Connection Error: " . $e->getMessage());
            }
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }

    private function seedSqlite($pdo) {
        $queries = [
            "CREATE TABLE IF NOT EXISTS admin_users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                role TEXT DEFAULT 'admin',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )",
            "INSERT OR IGNORE INTO admin_users (id, name, email, password, role) VALUES
            (1, 'Solar Admin', 'admin@solar.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.RAWef5eUO', 'admin')",

            "CREATE TABLE IF NOT EXISTS categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                slug TEXT NOT NULL UNIQUE,
                description TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )",
            "INSERT OR IGNORE INTO categories (id, name, slug, description) VALUES
            (1, 'Solar Panels', 'solar-panels', 'High efficiency Monocrystalline and Polycrystalline solar panels'),
            (2, 'Solar Inverters', 'solar-inverters', 'On-grid, Off-grid and Hybrid solar inverters'),
            (3, 'Solar Batteries', 'solar-batteries', 'Long lasting Lithium-ion and Tubular solar storage batteries'),
            (4, 'Solar Water Heaters', 'solar-water-heaters', 'Eco-friendly solar water heating systems'),
            (5, 'Solar Street Lights', 'solar-street-lights', 'All-in-one integrated LED solar street lights')",

            "CREATE TABLE IF NOT EXISTS products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                category_id INTEGER NOT NULL,
                name TEXT NOT NULL,
                slug TEXT NOT NULL UNIQUE,
                capacity TEXT,
                price REAL NOT NULL,
                old_price REAL,
                description TEXT NOT NULL,
                specifications TEXT,
                features TEXT,
                image TEXT DEFAULT 'panel-540w.jpg',
                is_featured INTEGER DEFAULT 0,
                stock_status TEXT DEFAULT 'in_stock',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )",
            "INSERT OR IGNORE INTO products (id, category_id, name, slug, capacity, price, old_price, description, specifications, features, image, is_featured) VALUES
            (1, 1, 'Loom Solar 540W Mono PERC Half-Cut Panel', 'loom-solar-540w-mono-perc', '540 Watt', 24500.00, 28000.00, 'Top tier high-efficiency Mono PERC half-cut solar module designed for maximum energy output.', 'Cell Type: Mono PERC; Efficiency: 21.3%; Frame: Anodized Aluminum; Warranty: 25 Years', 'Anti-PID Technology, High Wind & Snow Resistance, 25-Year Guarantee', 'panel-540w.jpg', 1),
            (2, 1, 'Tata Power Solar 330W Polycrystalline Panel', 'tata-power-330w-poly', '330 Watt', 6600.00, 8200.00, 'Reliable and durable polycrystalline panel backed by Tata Power quality assurance.', 'Cell Type: Poly 72 cells; Efficiency: 17.5%; Output: 330W; Warranty: 25 Years', 'Made in India, High Tensile Strength Glass, Excellent Low-light Performance', 'panel-330w.jpg', 1),
            (3, 2, 'Havells Enviro 5kW Hybrid Solar Inverter', 'havells-enviro-5kw-hybrid', '5 kW Dual MPPT', 68000.00, 75000.00, 'Smart hybrid inverter with dual MPPT tracker, Wi-Fi monitoring and seamless battery energy management.', 'Capacity: 5000W; Max Efficiency: 97.6%; Battery Voltage: 48V; Wi-Fi Built-in', 'Real-time Mobile App Monitoring, Dual MPPT Tracker, Touch Display, IP65 Waterproof Protection', 'inverter-5kw.jpg', 1),
            (4, 2, 'Luminous Solar NXG 1800 24V Pure Sine Wave', 'luminous-nxg-1800-24v', '1.5 kVA / 24V', 25000.00, 28500.00, 'Ideal home off-grid inverter with intelligent solar optimization technology.', 'System Voltage: 24V; Max Panel Power: 1200W; Waveform: Pure Sine Wave', 'ISOT Technology, Battery Gravity Builder, Smart Solar Savings Display', 'inverter-1800.jpg', 0),
            (5, 3, 'Luminous Solar Tall Tubular Battery 150Ah', 'luminous-solar-150ah-battery', '150 Ah / 12V', 11999.00, 14500.00, 'Deep cycle long life solar tubular battery with ultra low maintenance.', 'Capacity: 150Ah @ C10; Warranty: 60 Months; Voltage: 12V', 'High Density Grid Paste, 60 Months Warranty, Deep Discharge Recovery', 'battery-150ah.jpg', 1),
            (6, 4, 'Supreme 200 Litres Solar Water Heater (ETC)', 'supreme-200l-solar-water-heater', '200 Litres/Day', 49200.00, 54000.00, 'Evacuated Tube Collector (ETC) high performance solar water heater with food-grade inner tank.', 'Tanks: 200L Stainless Steel 304; Tubes: 20 Evacuated Glass Tubes', 'Instant Hot Water 24x7, Rust-Proof Outer Body, Zero Electricity Cost', 'water-heater-200l.jpg', 1),
            (7, 5, 'All-In-One Integrated LED Solar Street Light 30W', 'integrated-solar-street-light-30w', '30W LED / 12V Solar', 12800.00, 14500.00, 'Compact solar street light with built-in LiFePO4 battery and motion sensor.', 'LED: 30W High Brightness; Battery: 12.8V LiFePO4; Motion Sensor: PIR Built-in', '100% Wireless Installation, Motion Sensor Dimming, Waterproof IP65 Rating', 'street-light-30w.jpg', 0)",

            "CREATE TABLE IF NOT EXISTS projects (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                category TEXT DEFAULT 'Residential',
                client_name TEXT NOT NULL,
                location TEXT NOT NULL,
                capacity_kw TEXT NOT NULL,
                description TEXT,
                image TEXT NOT NULL,
                completion_date TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )",
            "INSERT OR IGNORE INTO projects (id, title, category, client_name, location, capacity_kw, description, image, completion_date) VALUES
            (1, '10kW Rooftop On-Grid Solar Plant', 'Residential', 'Sharma Villa', 'Green Park, New Delhi', '10 kW', 'Installed 10kW On-Grid solar plant with Mono PERC modules.', 'project-1.jpg', '2026-03-15'),
            (2, '50kW Commercial Factory Solar System', 'Commercial', 'Apex Textiles Ltd.', 'Noida Industrial Area', '50 kW', 'Turnkey 50kW commercial solar installation.', 'project-2.jpg', '2026-04-10'),
            (3, '25kW Agricultural Solar Pump & Power', 'Agricultural', 'Kisan Agro Farm', 'Jaipur Rural', '25 kW', 'Off-grid solar system powering submersible pumps.', 'project-3.jpg', '2026-05-20'),
            (4, '15kW Hybrid Solar Plant with Battery Storage', 'Residential', 'Dr. Verma Residency', 'Gurugram', '15 kW', 'Hybrid solar power system with Lithium battery backup.', 'project-4.jpg', '2026-06-05')",

            "CREATE TABLE IF NOT EXISTS testimonials (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                client_name TEXT NOT NULL,
                role_location TEXT NOT NULL,
                rating INTEGER DEFAULT 5,
                review_text TEXT NOT NULL,
                client_image TEXT DEFAULT 'user-1.jpg',
                is_approved INTEGER DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )",
            "INSERT OR IGNORE INTO testimonials (id, client_name, role_location, rating, review_text, client_image, is_approved) VALUES
            (1, 'Rajesh Kumar', 'Home Owner, New Delhi', 5, 'Solar Panel Shop team executed our 10kW installation flawlessly. My monthly electricity bill dropped from ₹14,000 to nearly zero!', 'user-1.jpg', 1),
            (2, 'Priya Malhotra', 'School Trustee, Noida', 5, 'We installed solar panels across our school building. Free site survey was eye-opening and execution was super fast.', 'user-2.jpg', 1),
            (3, 'Vikram Singh', 'Factory Owner, Gurugram', 5, 'Excellent quality solar panels and heavy duty inverters. 5 stars for their installation team!', 'user-3.jpg', 1)",

            "CREATE TABLE IF NOT EXISTS blogs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                slug TEXT NOT NULL UNIQUE,
                author TEXT DEFAULT 'Solar Expert',
                content TEXT NOT NULL,
                summary TEXT,
                image TEXT DEFAULT 'blog-1.jpg',
                views INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )",
            "INSERT OR IGNORE INTO blogs (id, title, slug, author, content, summary, image) VALUES
            (1, 'PM Surya Ghar Muft Bijli Yojana: Guide & Subsidies', 'pm-surya-ghar-muft-bijli-yojana-guide', 'Solar Team', 'The Government of India has launched the PM Surya Ghar Muft Bijli Yojana to provide free electricity up to 300 units monthly. Homeowners receive up to ₹78,000 direct subsidy for installing rooftop solar systems.', 'Learn how to claim up to ₹78,000 subsidy under PM Surya Ghar Yojana for home rooftop solar panels.', 'blog-1.jpg'),
            (2, 'Monocrystalline vs Polycrystalline Solar Panels', 'mono-vs-poly-solar-panels-comparison', 'Engineers Team', 'Choosing the right solar panel type is crucial for efficiency and ROI. Monocrystalline panels offer higher efficiency (up to 22%) while Polycrystalline panels are budget-friendly.', 'Discover key differences between Mono PERC and Poly solar modules to pick the best fit.', 'blog-2.jpg')",

            "CREATE TABLE IF NOT EXISTS inquiries (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                type TEXT DEFAULT 'Contact Inquiry',
                name TEXT NOT NULL,
                email TEXT NOT NULL,
                phone TEXT NOT NULL,
                city TEXT,
                system_type TEXT,
                monthly_bill TEXT,
                message TEXT,
                status TEXT DEFAULT 'Pending',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )",
            "INSERT OR IGNORE INTO inquiries (id, type, name, email, phone, city, system_type, monthly_bill, message, status) VALUES
            (1, 'Free Site Survey', 'Amit Patel', 'amit.patel@gmail.com', '+91 98765 43210', 'Delhi', '10 kW On-Grid', '₹12,000 - ₹18,000', 'Interested in rooftop solar panel installation for my 3-story house. Please schedule site survey.', 'Pending')",

            "CREATE TABLE IF NOT EXISTS site_settings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                setting_key TEXT NOT NULL UNIQUE,
                setting_value TEXT NOT NULL
            )",
            "INSERT OR IGNORE INTO site_settings (setting_key, setting_value) VALUES
            ('site_name', 'Solar Panel Shop'),
            ('tagline', 'Clean, Renewable & Unlimited Solar Energy Solutions'),
            ('phone', '+91 98765 43210'),
            ('alt_phone', '+91 98123 45678'),
            ('email', 'info@solarpanelshop.com'),
            ('address', 'Plot No. 45, Solar Energy Park, Sector 62, Noida, UP - 201301'),
            ('whatsapp', '919876543210'),
            ('working_hours', 'Mon - Sat: 9:00 AM - 7:00 PM'),
            ('google_map', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14008.114757313888!2d77.3621415!3d28.6289295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce5456ef36d9f%3A0x3b7191b1286136c8!2sSector%2062%2C%20Noida%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin')"
        ];

        foreach ($queries as $sql) {
            $pdo->exec($sql);
        }
    }
}

function getDB() {
    return Database::getInstance();
}
