<?php
$pageTitle = "About Us - Company Profile & Mission";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<section class="py-3 bg-light border-bottom">
    <div class="container text-center py-1">
        <h2 class="font-weight-bold text-dark mb-1 fs-3">About SolarSphere</h2>
        <p class="text-secondary small mb-0">Leading the clean energy revolution with high-efficiency solar panel installations.</p>
    </div>
</section>

<!-- Company Story -->
<section class="py-5">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-tag">Our Legacy</span>
                <h2 class="section-title">Powering Thousands of Homes &amp; Businesses Since 2016</h2>
                <p class="text-muted mb-4">
                    Founded with a vision to make clean solar energy accessible, reliable, and affordable, Solar Shop has grown into a premier turn-key solar solutions provider. From residential rooftop solar panels to multi-megawatt commercial plants, we deliver end-to-end solar engineering excellence.
                </p>
                <p class="text-muted mb-4">
                    We partner with global Tier-1 manufacturers like Loom Solar, Havells, Tata Power Solar, and Luminous to ensure your solar investment yields maximum power generation for over 25 years.
                </p>
                
                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-circle-check text-success fs-3"></i>
                            <div>
                                <h6 class="font-weight-bold mb-0">Government Approved</h6>
                                <small class="text-muted">MNRE Empanelled Vendor</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-medal text-warning fs-3"></i>
                            <div>
                                <h6 class="font-weight-bold mb-0">25-Year Guarantee</h6>
                                <small class="text-muted">Tier-1 Modules Warranty</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <img src="<?php echo SITE_URL; ?>/assets/images/project-2.jpg" class="img-fluid rounded-4 shadow-lg" alt="Solar Engineers at work" onerror="this.src='<?php echo SITE_URL; ?>/assets/images/panel-540w.jpg'">
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Cards -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="solar-card">
                    <div class="feature-icon-wrapper">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h3 class="font-weight-bold mb-3">Our Mission</h3>
                    <p class="text-muted">To empower households and businesses with sustainable, clean, and cost-effective solar energy solutions while reducing carbon footprints and promoting energy independence.</p>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="solar-card">
                    <div class="feature-icon-wrapper">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h3 class="font-weight-bold mb-3">Our Vision</h3>
                    <p class="text-muted">To be the most trusted renewable energy brand nationwide, known for engineering precision, transparent pricing, hassle-free subsidy processing, and customer-first support.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-tag">Meet Our Experts</span>
            <h2 class="section-title">Our Dedicated Solar Leadership Team</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="solar-card text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white shadow mb-3" style="width: 100px; height: 100px; background: #374151;">
                        <i class="fa-solid fa-user-tie text-warning fs-1"></i>
                    </div>
                    <h5 class="font-weight-bold mb-1">Rohan Verma</h5>
                    <p class="text-success font-weight-semibold mb-3">Founder &amp; Managing Director</p>
                    <p class="text-muted small">12+ years of renewable energy experience in solar plant design and corporate strategy.</p>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="solar-card text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white shadow mb-3" style="width: 100px; height: 100px; background: #374151;">
                        <i class="fa-solid fa-user-gear text-warning fs-1"></i>
                    </div>
                    <h5 class="font-weight-bold mb-1">Neha Sharma</h5>
                    <p class="text-success font-weight-semibold mb-3">Head of Solar Engineering</p>
                    <p class="text-muted small">Specialist in hybrid inverter synchronization, structural load analysis, and net metering.</p>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="solar-card text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white shadow mb-3" style="width: 100px; height: 100px; background: #374151;">
                        <i class="fa-solid fa-headset text-warning fs-1"></i>
                    </div>
                    <h5 class="font-weight-bold mb-1">Amitabh Roy</h5>
                    <p class="text-success font-weight-semibold mb-3">Customer Support Manager</p>
                    <p class="text-muted small">Ensures 100% smooth post-installation maintenance and quick warranty assistance.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
