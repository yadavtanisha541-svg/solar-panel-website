# ☀️ Solar Panel Shop Website (Core PHP & MySQL)

A modern, fast, fully responsive **Solar Panel Shop & Turnkey Solar Services Website** built in **Core PHP (PDO)**, **MySQL**, **Bootstrap 5**, **AOS.js**, and custom green/gold CSS themes.

---

## 🌟 Key Features

### 🏢 Public Website Pages
1. **Home (`index.php`)**:
   - Hero banner with sunburst animated background (`#059669` deep green & `#FBBF24` gold theme)
   - Interactive **Solar ROI & Savings Calculator**
   - Quick stats counter (1500+ kW installed, 98% satisfaction)
   - Why Choose Us (PM Surya Ghar subsidy guidance, 25-yr warranty)
   - Featured Solar Panels, Inverters, & Storage Batteries preview
   - Past Projects Gallery & Customer Testimonials slider
2. **About Us (`about.php`)**: Company story, mission & vision cards, leadership team, MNRE certifications.
3. **Products Catalog (`products.php` & `product-detail.php`)**:
   - Dynamic MySQL listing with category filtering:
     - **Solar Panels** (Mono PERC Half-cut, Poly)
     - **Solar Inverters** (Hybrid, On-grid, Off-grid)
     - **Solar Batteries** (Lithium-ion, Tubular)
     - **Solar Water Heaters**
     - **Solar Street Lights**
   - Full technical specification badges, price tag, and WhatsApp inquiry button.
4. **Services (`services.php`)**:
   - Rooftop installation, Commercial plants, Lifetime maintenance, Free site survey booking modal.
   - 4-step installation process timeline.
5. **Projects / Gallery (`projects.php`)**:
   - Filterable photo gallery (Residential, Commercial, Agricultural) with Lightbox image preview modal.
6. **Testimonials (`testimonials.php`)**: Star rating reviews from verified clients.
7. **Blog (`blog.php` & `blog-detail.php`)**: SEO-friendly articles on PM Surya Ghar scheme & solar guides.
8. **Contact Us (`contact.php`)**:
   - Contact form storing inquiries directly in MySQL.
   - PHPMailer SMTP structure included for email notification.
   - Floating WhatsApp button (`https://api.whatsapp.com/send?...`)
   - Interactive Google Maps embed.

---

## 🔐 Admin Control Panel (`/admin`)

- **Secure Login (`/admin/login.php`)**: Password hashing (`password_hash` & `password_verify`) and session guard.
- **Default Admin Credentials**:
  - **Email:** `admin@solar.com`
  - **Password:** `AdminPassword123!`
- **Dashboard Overview (`/admin/index.php`)**: Real-time stats for products, projects, total inquiries, and pending site survey requests.
- **Products CRUD (`/admin/products.php`)**: Add, Edit, Delete solar equipment with image upload & category selection.
- **Projects CRUD (`/admin/projects.php`)**: Add, Edit, Delete installation gallery photos.
- **Inquiries Manager (`/admin/inquiries.php`)**: View contact inquiries & free site survey bookings with status toggle (`Pending`, `Contacted`, `Resolved`).
- **Testimonials CRUD (`/admin/testimonials.php`)**: Manage client reviews & star ratings.
- **Blog Manager (`/admin/blogs.php`)**: Create & edit solar educational articles.
- **Site Settings (`/admin/settings.php`)**: Edit phone numbers, email, address, WhatsApp number, and Google Map iframe.

---

## 🚀 How to Run Locally

### Option 1: PHP Built-in Server (Easiest)
1. Open terminal / PowerShell in the project directory:
   ```bash
   cd "C:\Users\WINDOWS 11\.gemini\antigravity\scratch\solar_shop_php"
   ```
2. Run the PHP development server:
   ```bash
   php -S localhost:8000
   ```
3. Open your browser and navigate to:
   - Public Website: `http://localhost:8000`
   - Admin Panel: `http://localhost:8000/admin`

*(Note: The database automatically connects to MySQL or uses SQLite fallback `config/solar_shop.sqlite` out-of-the-box!)*

### Option 2: MySQL Setup (XAMPP / WAMP)
1. Open PhpMyAdmin or MySQL Workbench.
2. Create database `solar_shop_db`.
3. Import `schema.sql`:
   ```bash
   mysql -u root -p solar_shop_db < schema.sql
   ```
4. Update database credentials in `config/config.php` if necessary.

---

## 🎨 Color Palette & Design System
- **Primary:** `#059669` (Deep Green)
- **Accent:** `#FBBF24` (Sunlight Yellow / Gold)
- **Background:** `#F9FAFB` (Soft off-white)
- **Text:** `#1F2937` (Dark slate gray)
- **Dark Gradient:** `#064E3B` (Dark green gradient)
- **Typography:** `Poppins` Google Font
