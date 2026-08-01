<?php
$pageTitle = "Contact Us - Solar Panel Shop";
require_once __DIR__ . '/includes/header.php';

$db = getDB();
$messageSent = false;
$errorMessage = '';

// Handle Form Submission (Both Contact & Site Survey)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? sanitize($_POST['action']) : 'contact_inquiry';
    $name = isset($_POST['name']) ? sanitize($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize($_POST['phone']) : '';
    $city = isset($_POST['city']) ? sanitize($_POST['city']) : '';
    $systemType = isset($_POST['system_type']) ? sanitize($_POST['system_type']) : '';
    $monthlyBill = isset($_POST['monthly_bill']) ? sanitize($_POST['monthly_bill']) : '';
    $msg = isset($_POST['message']) ? sanitize($_POST['message']) : '';

    if (empty($name) || empty($phone)) {
        set_flash('danger', 'Please enter your Name and Mobile Phone Number.');
    } else {
        try {
            $inquiryType = ($action === 'site_survey') ? 'Free Site Survey' : 'Contact Inquiry';
            
            $stmt = $db->prepare("INSERT INTO inquiries (type, name, email, phone, city, system_type, monthly_bill, message, status) VALUES (:type, :name, :email, :phone, :city, :system, :bill, :msg, 'Pending')");
            $stmt->execute([
                ':type' => $inquiryType,
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':city' => $city,
                ':system' => $systemType,
                ':bill' => $monthlyBill,
                ':msg' => $msg
            ]);

            // Optional PHPMailer Integration structure
            /*
            require 'vendor/autoload.php';
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com';
            $mail->Password = 'your-app-password';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('noreply@solarshop.com', 'Solar Shop Website');
            $mail->addAddress(get_site_setting('email'));
            $mail->Subject = "New Solar Inquiry from $name";
            $mail->Body = "Name: $name\nPhone: $phone\nEmail: $email\nCity: $city\nMessage: $msg";
            $mail->send();
            */

            set_flash('success', 'Thank you! Your solar inquiry has been received. Our team will contact you within 24 hours.');
        } catch (Exception $e) {
            set_flash('danger', 'Database Error: Could not save your inquiry. ' . $e->getMessage());
        }
    }
}

$phone = get_site_setting('phone', '+91 98765 43210');
$altPhone = get_site_setting('alt_phone', '+91 98123 45678');
$email = get_site_setting('email', 'info@solarpanelshop.com');
$address = get_site_setting('address', 'Plot No. 45, Solar Energy Park, Sector 62, Noida, UP - 201301');
$googleMap = get_site_setting('google_map');
$whatsapp = get_site_setting('whatsapp', '919876543210');
?>

<!-- Header Banner -->
<section class="py-3 bg-light border-bottom">
    <div class="container text-center py-1">
        <h2 class="font-weight-bold text-dark mb-1 fs-3">Contact Us</h2>
        <p class="text-secondary small mb-0">Have questions about solar installation or government subsidies? Get in touch today!</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        
        <?php get_flash(); ?>

        <div class="row g-5">
            <!-- Contact Info Sidebar -->
            <div class="col-lg-5" data-aos="fade-right">
                <div class="p-4 bg-white rounded-4 shadow-sm border h-100">
                    <span class="section-tag">Reach Out</span>
                    <h3 class="font-weight-bold mb-4">We are Here to Help You Go Solar</h3>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="feature-icon-wrapper flex-shrink-0" style="width: 50px; height: 50px; font-size: 1.25rem;">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h6 class="font-weight-bold mb-1">Our Showroom &amp; Office</h6>
                            <p class="text-muted small mb-0"><?php echo htmlspecialchars($address); ?></p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="feature-icon-wrapper flex-shrink-0" style="width: 50px; height: 50px; font-size: 1.25rem;">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <h6 class="font-weight-bold mb-1">Call Us Directly</h6>
                            <p class="text-muted small mb-0"><a href="tel:<?php echo $phone; ?>" class="text-dark font-weight-semibold"><?php echo htmlspecialchars($phone); ?></a> / <a href="tel:<?php echo $altPhone; ?>" class="text-dark font-weight-semibold"><?php echo htmlspecialchars($altPhone); ?></a></p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="feature-icon-wrapper flex-shrink-0" style="width: 50px; height: 50px; font-size: 1.25rem;">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <h6 class="font-weight-bold mb-1">Email Support</h6>
                            <p class="text-muted small mb-0"><a href="mailto:<?php echo $email; ?>" class="text-dark font-weight-semibold"><?php echo htmlspecialchars($email); ?></a></p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="feature-icon-wrapper flex-shrink-0" style="width: 50px; height: 50px; font-size: 1.25rem; background: #25D366; color: #fff;">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <h6 class="font-weight-bold mb-1">Instant WhatsApp Chat</h6>
                            <a href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp; ?>&text=Hi%20Solar%20Shop" target="_blank" class="btn btn-sm btn-success rounded-pill px-3 mt-1">
                                Chat with Solar Expert <i class="fa-brands fa-whatsapp ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7" data-aos="fade-left">
                <div class="solar-card">
                    <h3 class="font-weight-bold mb-4">Send Us a Message</h3>
                    
                    <form action="<?php echo SITE_URL; ?>/contact.php" method="POST">
                        <input type="hidden" name="action" value="contact_inquiry">
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Your Full Name *</label>
                                <input type="text" name="name" class="form-control form-control-lg fs-6" placeholder="e.g. Ramesh Kumar" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Phone / Mobile Number *</label>
                                <input type="tel" name="phone" class="form-control form-control-lg fs-6" placeholder="+91 9876543210" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Email Address</label>
                                <input type="email" name="email" class="form-control form-control-lg fs-6" placeholder="name@domain.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">City / Location</label>
                                <input type="text" name="city" class="form-control form-control-lg fs-6" placeholder="e.g. Delhi, Jaipur, Noida">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Interested Solar Solution</label>
                            <select name="system_type" class="form-select form-select-lg fs-6">
                                <option value="Rooftop Solar Panels">Rooftop Solar Panels (3kW - 10kW)</option>
                                <option value="Commercial & Industrial Solar">Commercial &amp; Industrial Solar (10kW+)</option>
                                <option value="Solar Inverter / Battery Storage">Solar Inverter &amp; Battery Storage</option>
                                <option value="Solar Water Heater">Solar Water Heater</option>
                                <option value="Solar Street Lights">Solar Street Lights</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Message or Inquiry Details</label>
                            <textarea name="message" class="form-control" rows="4" placeholder="Tell us how we can help you..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-solar-primary btn-lg w-100 py-3">Send Inquiry Now <i class="fa-solid fa-paper-plane ms-2"></i></button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Google Maps Embed -->
        <?php if (!empty($googleMap)): ?>
            <div class="mt-5 rounded-4 overflow-hidden shadow-sm border" data-aos="zoom-in">
                <iframe src="<?php echo $googleMap; ?>" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
