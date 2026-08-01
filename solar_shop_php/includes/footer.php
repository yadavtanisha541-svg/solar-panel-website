<?php
$address = get_site_setting('address', 'Plot No. 45, Solar Energy Park, Sector 62, Noida, UP');
$phone = get_site_setting('phone', '+91 98765 43210');
$email = get_site_setting('email', 'info@solarpanelshop.com');
?>

<!-- Footer -->
<footer class="footer-solar w-100 m-0">
    <div class="container-fluid px-4 px-lg-5">
        <div class="row g-4">
            <!-- Col 1: About -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="fa-solid fa-sun fs-2 text-warning"></i>
                    <span class="fs-4 font-weight-bold text-dark" style="font-family: 'Outfit', sans-serif;">Solar<span class="text-warning">Sphere</span></span>
                </div>
                <p class="text-secondary small lh-base mb-3">Leading solar panel shop &amp; turn-key solar power solutions provider. We design, install and maintain top-tier solar power systems for residential, commercial &amp; industrial clients.</p>
                <div class="d-flex gap-3 fs-5">
                    <a href="#" class="text-secondary hover-accent"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="text-secondary hover-accent"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="text-secondary hover-accent"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="text-secondary hover-accent"><i class="fa-brands fa-linkedin"></i></a>
                    <a href="#" class="text-secondary hover-accent"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div class="col-lg-2 col-md-6">
                <h5 class="font-weight-bold text-dark mb-3">Quick Links</h5>
                <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                    <li><a href="<?php echo SITE_URL; ?>/index.php" class="text-secondary"><i class="fa-solid fa-angle-right me-2 text-warning"></i>Home</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/about.php" class="text-secondary"><i class="fa-solid fa-angle-right me-2 text-warning"></i>About Us</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/products.php" class="text-secondary"><i class="fa-solid fa-angle-right me-2 text-warning"></i>Products</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/services.php" class="text-secondary"><i class="fa-solid fa-angle-right me-2 text-warning"></i>Services</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/calculator.php" class="text-secondary"><i class="fa-solid fa-angle-right me-2 text-warning"></i>Calculator</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/faq.php" class="text-secondary"><i class="fa-solid fa-angle-right me-2 text-warning"></i>FAQ</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/contact.php" class="text-secondary"><i class="fa-solid fa-angle-right me-2 text-warning"></i>Contact Us</a></li>
                </ul>
            </div>

            <!-- Col 3: Product Categories -->
            <div class="col-lg-3 col-md-6">
                <h5 class="font-weight-bold text-dark mb-3">Solar Categories</h5>
                <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                    <li><a href="<?php echo SITE_URL; ?>/products.php?cat=solar-panels" class="text-secondary"><i class="fa-solid fa-solar-panel me-2 text-warning"></i>Solar Panels</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/products.php?cat=solar-inverters" class="text-secondary"><i class="fa-solid fa-bolt me-2 text-warning"></i>Solar Inverters</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/products.php?cat=solar-batteries" class="text-secondary"><i class="fa-solid fa-car-battery me-2 text-warning"></i>Solar Batteries</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/products.php?cat=solar-water-heaters" class="text-secondary"><i class="fa-solid fa-fire-flame-simple me-2 text-warning"></i>Solar Water Heaters</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/products.php?cat=solar-street-lights" class="text-secondary"><i class="fa-solid fa-lightbulb me-2 text-warning"></i>Solar Street Lights</a></li>
                </ul>
            </div>

            <!-- Col 4: Contact Details -->
            <div class="col-lg-3 col-md-6">
                <h5 class="font-weight-bold text-dark mb-3">Contact Details</h5>
                <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                    <li class="d-flex align-items-start gap-3">
                        <i class="fa-solid fa-location-dot text-warning fs-5 mt-1"></i>
                        <span class="text-secondary small"><?php echo htmlspecialchars($address); ?></span>
                    </li>
                    <li class="d-flex align-items-center gap-3">
                        <i class="fa-solid fa-phone text-warning fs-5"></i>
                        <a href="tel:<?php echo $phone; ?>" class="text-secondary small"><?php echo htmlspecialchars($phone); ?></a>
                    </li>
                    <li class="d-flex align-items-center gap-3">
                        <i class="fa-solid fa-envelope text-warning fs-5"></i>
                        <a href="mailto:<?php echo $email; ?>" class="text-secondary small"><?php echo htmlspecialchars($email); ?></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom text-center mt-5 pt-3 border-top">
            <p class="mb-0 text-muted small">&copy; <?php echo date('Y'); ?> <strong><?php echo SITE_NAME; ?></strong>. All Rights Reserved. Built with Core PHP &amp; MySQL.</p>
        </div>
    </div>
</footer>

<!-- Modal: Free Site Survey Request -->
<div class="modal fade" id="siteSurveyModal" tabindex="-1" aria-labelledby="siteSurveyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header text-white" style="background: var(--dark-green-gradient); border-radius: 20px 20px 0 0;">
                <h5 class="modal-title font-weight-bold" id="siteSurveyModalLabel"><i class="fa-solid fa-solar-panel me-2 text-warning"></i>Book Free Solar Site Survey</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo SITE_URL; ?>/contact.php" method="POST">
                    <input type="hidden" name="action" value="site_survey">
                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Full Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Rahul Sharma" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-semibold">Mobile Number *</label>
                            <input type="tel" name="phone" class="form-control" placeholder="+91 9876543210" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="name@email.com">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-semibold">City / Location *</label>
                            <input type="text" name="city" class="form-control" placeholder="e.g. New Delhi" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-semibold">System Requirement</label>
                            <select name="system_type" class="form-select">
                                <option value="Residential Solar (3kW - 10kW)">Residential (3kW - 10kW)</option>
                                <option value="Commercial Solar (10kW - 100kW)">Commercial (10kW - 100kW)</option>
                                <option value="Solar Water Heater">Solar Water Heater</option>
                                <option value="Solar Battery / Inverter">Inverter & Battery</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Average Monthly Electricity Bill</label>
                        <select name="monthly_bill" class="form-select">
                            <option value="Under ₹5,000">Under ₹5,000</option>
                            <option value="₹5,000 - ₹15,000">₹5,000 - ₹15,000</option>
                            <option value="₹15,000 - ₹50,000">₹15,000 - ₹50,000</option>
                            <option value="Above ₹50,000">Above ₹50,000</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Additional Details</label>
                        <textarea name="message" class="form-control" rows="2" placeholder="Tell us about your rooftop area or requirements..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-solar-primary w-100 py-3">Submit Site Survey Request <i class="fa-solid fa-paper-plane ms-2"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Lightbox Image Popup -->
<div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center p-0">
                <img id="lightboxModalImage" src="" class="img-fluid rounded-4 shadow-lg mb-2" alt="Solar Project Preview">
                <h5 id="lightboxModalTitle" class="text-white mt-2"></h5>
                <button type="button" class="btn btn-sm btn-light mt-3" data-bs-dismiss="modal">Close Preview</button>
            </div>
        </div>
    </div>
</div>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
<script src="<?php echo SITE_URL; ?>/assets/js/animations.js"></script>

</body>
</html>
