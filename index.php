<?php
$pageTitle = "Home - Modern Solar Energy Solutions";
require_once __DIR__ . '/includes/header.php';

$db = getDB();

// Fetch Featured Products
$featuredProducts = [];
try {
    $stmt = $db->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.is_featured = 1 ORDER BY p.id DESC LIMIT 4");
    $featuredProducts = $stmt->fetchAll();
} catch (Exception $e) {}

// Fetch Projects Preview
$projects = [];
try {
    $stmt = $db->query("SELECT * FROM projects ORDER BY id DESC LIMIT 4");
    $projects = $stmt->fetchAll();
} catch (Exception $e) {}

// Fetch Testimonials
$testimonials = [];
try {
    $stmt = $db->query("SELECT * FROM testimonials WHERE is_approved = 1 ORDER BY id DESC LIMIT 3");
    $testimonials = $stmt->fetchAll();
} catch (Exception $e) {}
?>

<!-- Hero Section with House Solar Panels Sunrise Video Background -->
<section class="hero-section">
    <!-- Full Screen Background Video -->
    <video autoplay loop muted playsinline class="hero-bg-video" style="width: 100%; height: 100%; object-fit: cover;">
        <source src="<?php echo SITE_URL; ?>/assets/images/hero-video.mp4" type="video/mp4">
    </video>
    
    <!-- Soft Overlay for Contrast -->
    <div class="hero-bg-overlay"></div>

    <div class="container-fluid px-3 px-lg-5 position-relative" style="z-index: 3;">
        <div class="row">
            <div class="col-lg-8 text-start hero-text-col" data-aos="fade-up">
                <h1 class="hero-title-clean mb-3">
                    Power Your Home <br class="d-block d-md-none">with <span class="hero-title-accent">Clean Solar Energy</span>
                </h1>
                <p class="hero-lead-clean mb-4">
                    Premium Solar Panels for Homes, Businesses &amp; Industries. Reliable Performance, Expert Installation, and Long-Term Savings.
                </p>
                <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 mt-4 hero-btn-group">
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-solar-primary font-weight-bold rounded-2">
                        Contact Us <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                    <button class="btn btn-solar-outline text-white border-white font-weight-bold rounded-2" data-bs-toggle="modal" data-bs-target="#siteSurveyModal">
                        Book Survey <i class="fa-solid fa-calendar-check ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Continuous Crossfade Video Playlist Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const v1 = document.getElementById('heroVideo1');
    const v2 = document.getElementById('heroVideo2');
    if (!v1 || !v2) return;

    const playlist = [
        "<?php echo SITE_URL; ?>/assets/images/hero-video-1.mp4",
        "<?php echo SITE_URL; ?>/assets/images/hero-video-2.mp4",
        "<?php echo SITE_URL; ?>/assets/images/hero-video-3.mp4"
    ];

    let currentIdx = 0;
    let activeVideo = v1;
    let nextVideo = v2;

    function handleVideoEnd() {
        const nextIdx = (currentIdx + 1) % playlist.length;
        nextVideo.src = playlist[nextIdx];
        nextVideo.load();
        
        nextVideo.oncanplay = function() {
            nextVideo.oncanplay = null;
            nextVideo.play().then(function() {
                nextVideo.style.opacity = '1';
                activeVideo.style.opacity = '0';
                
                const temp = activeVideo;
                activeVideo = nextVideo;
                nextVideo = temp;
                currentIdx = nextIdx;

                activeVideo.removeEventListener('ended', handleVideoEnd);
                activeVideo.addEventListener('ended', handleVideoEnd);
            }).catch(function(err) {
                console.log('Video play error:', err);
            });
        };
    }

    v1.addEventListener('ended', handleVideoEnd);
});
</script>

<!-- Government Certified & Performance Stats Bar -->
<section class="py-4 border-bottom bg-white">
    <div class="container py-1">
        <div class="row justify-content-center align-items-center g-3 g-md-4">
            <!-- Badge 1: 1500kW+ -->
            <div class="col-6 col-lg-3">
                <div class="d-flex align-items-center justify-content-start gap-2 gap-sm-3 ps-lg-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-1" style="background: #F3F4F6; border: 2px solid #E5E7EB; width: 44px; height: 44px; flex-shrink: 0;">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white shadow-sm" style="background: #374151; width: 30px; height: 30px;">
                            <i class="fa-solid fa-solar-panel" style="font-size: 0.85rem;"></i>
                        </div>
                    </div>
                    <div>
                        <div class="fs-5 fs-md-4 font-weight-bold lh-1 text-dark stat-number mb-1" data-target="1500" data-suffix="kW+">1500kW+</div>
                        <small class="text-muted font-weight-semibold d-block" style="font-size: 0.78rem; line-height: 1.2;">Solar Power Installed</small>
                    </div>
                </div>
            </div>

            <!-- Badge 2: 98% -->
            <div class="col-6 col-lg-3">
                <div class="d-flex align-items-center justify-content-start gap-2 gap-sm-3 ps-lg-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-1" style="background: #F3F4F6; border: 2px solid #E5E7EB; width: 44px; height: 44px; flex-shrink: 0;">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white shadow-sm" style="background: #374151; width: 30px; height: 30px;">
                            <i class="fa-solid fa-face-smile" style="font-size: 0.85rem;"></i>
                        </div>
                    </div>
                    <div>
                        <div class="fs-5 fs-md-4 font-weight-bold lh-1 text-dark stat-number mb-1" data-target="98" data-suffix="%">98%</div>
                        <small class="text-muted font-weight-semibold d-block" style="font-size: 0.78rem; line-height: 1.2;">Customer Satisfaction</small>
                    </div>
                </div>
            </div>

            <!-- Badge 3: 10+ Years -->
            <div class="col-6 col-lg-3">
                <div class="d-flex align-items-center justify-content-start gap-2 gap-sm-3 ps-lg-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-1" style="background: #F3F4F6; border: 2px solid #E5E7EB; width: 44px; height: 44px; flex-shrink: 0;">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white shadow-sm" style="background: #374151; width: 30px; height: 30px;">
                            <i class="fa-solid fa-award" style="font-size: 0.85rem;"></i>
                        </div>
                    </div>
                    <div>
                        <div class="fs-5 fs-md-4 font-weight-bold lh-1 text-dark stat-number mb-1" data-target="10" data-suffix="+ Years">10+ Years</div>
                        <small class="text-muted font-weight-semibold d-block" style="font-size: 0.78rem; line-height: 1.2;">Industry Experience</small>
                    </div>
                </div>
            </div>

            <!-- Badge 4: 850+ -->
            <div class="col-6 col-lg-3">
                <div class="d-flex align-items-center justify-content-start gap-2 gap-sm-3 ps-lg-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-1" style="background: #F3F4F6; border: 2px solid #E5E7EB; width: 44px; height: 44px; flex-shrink: 0;">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white shadow-sm" style="background: #374151; width: 30px; height: 30px;">
                            <i class="fa-solid fa-circle-check" style="font-size: 0.85rem;"></i>
                        </div>
                    </div>
                    <div>
                        <div class="fs-5 fs-md-4 font-weight-bold lh-1 text-dark stat-number mb-1" data-target="850" data-suffix="+">850+</div>
                        <small class="text-muted font-weight-semibold d-block" style="font-size: 0.78rem; line-height: 1.2;">Projects Completed</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Greener Tomorrow / Premier Solar Provider Section -->
<section class="py-5 my-4" style="background: #F3F4F6;">
    <div class="container py-3">
        <div class="row align-items-center g-5">
            <!-- Left Side: Clean Borderless Solar Farm Sunset Photo -->
            <div class="col-lg-5 text-center" data-aos="fade-right">
                <img src="<?php echo SITE_URL; ?>/assets/images/solar-farm-sunset.jpg" class="img-fluid motion-img-float shadow-sm border" style="max-height: 420px; width: 100%; object-fit: cover; border-radius: 20px;" alt="Solar Farm Sunset">
            </div>

            <!-- Right Side: Clean Content tailored for SolarSphere -->
            <div class="col-lg-7" data-aos="fade-left">
                <h2 class="display-6 font-weight-bold text-dark mb-3 lh-sm">
                    Harness the Power of the Sun with India's Premier Solar Solutions Provider
                </h2>
                <p class="text-secondary fs-6 mb-4 lh-base">
                    At <strong>SolarSphere</strong>, we believe the future is bright when it's powered by clean, renewable solar energy. As a leading solar panel &amp; installation provider, we capture the limitless potential of solar power to electrify homes and businesses nationwide. Our expansive product portfolio is tailored to the diverse needs of residential, commercial, and industrial enterprises.
                </p>

                <div class="d-flex align-items-center gap-3 mt-4">
                    <a href="<?php echo SITE_URL; ?>/about.php" class="btn btn-solar-primary btn-lg px-4 py-2 font-weight-bold rounded-2">
                        Learn More About Us <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
        </div>
    </div>
</section>

<!-- Join the Renewable Energy Revolution Section -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container py-3">
        <div class="text-center max-w-700 mx-auto mb-5" data-aos="fade-up">
            <span class="text-uppercase font-weight-bold text-muted small" style="letter-spacing: 2px;">Why Choose Solar</span>
            <h2 class="display-5 text-dark mt-1 mb-2" style="font-weight: 300;">Join the Renewable Energy Revolution</h2>
            <p class="text-secondary fs-6">Empowering homes, commercial enterprises &amp; industrial units with high-performance solar infrastructure.</p>
        </div>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4 text-center justify-content-center">
            <!-- Item 1 -->
            <div class="col" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4 bg-white rounded-1 shadow-sm border border-light-subtle h-100">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-1" style="width: 48px; height: 48px; background: #F3F4F6; color: #374151; font-size: 1.25rem;">
                        <i class="fa-solid fa-ranking-star"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Top Tier</h5>
                    <p class="text-muted small mb-0 lh-base">Trusted Solar Solutions Provider in North India</p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="col" data-aos="fade-up" data-aos-delay="200">
                <div class="p-4 bg-white rounded-1 shadow-sm border border-light-subtle h-100">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-1" style="width: 48px; height: 48px; background: #F3F4F6; color: #374151; font-size: 1.25rem;">
                        <i class="fa-solid fa-solar-panel"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">1,500+ kW</h5>
                    <p class="text-muted small mb-0 lh-base">Total capacity operational across solar installations</p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="col" data-aos="fade-up" data-aos-delay="300">
                <div class="p-4 bg-white rounded-1 shadow-sm border border-light-subtle h-100">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-1" style="width: 48px; height: 48px; background: #F3F4F6; color: #374151; font-size: 1.25rem;">
                        <i class="fa-solid fa-warehouse"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">850+ Sites</h5>
                    <p class="text-muted small mb-0 lh-base">Rooftop installations for homes, farms &amp; factories</p>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="col" data-aos="fade-up" data-aos-delay="400">
                <div class="p-4 bg-white rounded-1 shadow-sm border border-light-subtle h-100">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-1" style="width: 48px; height: 48px; background: #F3F4F6; color: #374151; font-size: 1.25rem;">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">1,800+ T</h5>
                    <p class="text-muted small mb-0 lh-base">Annual CO₂ carbon emissions offset through solar power</p>
                </div>
            </div>

            <!-- Item 5 -->
            <div class="col" data-aos="fade-up" data-aos-delay="500">
                <div class="p-4 bg-white rounded-1 shadow-sm border border-light-subtle h-100">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-1" style="width: 48px; height: 48px; background: #F3F4F6; color: #374151; font-size: 1.25rem;">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">99.4%+</h5>
                    <p class="text-muted small mb-0 lh-base">System availability ensuring maximum energy production</p>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Solar Energy Infrastructure Section -->
<section class="py-5 bg-white border-top">
    <div class="container py-3">
        <div class="row align-items-center g-5">
            <!-- Left Side: Tailored Content for SolarSphere -->
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="display-6 font-weight-bold text-dark mb-4 lh-sm">
                    SolarSphere Energy Infrastructure Solutions
                </h2>
                <p class="text-secondary fs-6 mb-3 lh-base">
                    At <strong>SolarSphere</strong>, we are committed to revolutionizing clean energy accessibility across India by engineering state-of-the-art rooftop solar systems, commercial arrays, and high-performance energy storage solutions.
                </p>
                <p class="text-secondary fs-6 mb-3 lh-base">
                    Our MNRE-approved solar panel deployments leverage Tier-1 Mono PERC and Bifacial technologies, ensuring maximum power output even under high ambient temperature conditions and low-light environments.
                </p>
                <p class="text-secondary fs-6 mb-3 lh-base">
                    We manage end-to-end turnkey solar execution—from initial free site surveys, DISCOM net-metering regulatory approvals, structural mounting engineering, to lifetime remote performance monitoring and maintenance.
                </p>
                <p class="text-secondary fs-6 mb-0 lh-base">
                    Driven by innovation and customer-first service, SolarSphere empowers homeowners, agricultural farms, and industrial plants to cut electricity expenses by up to 90% while advancing India's net-zero carbon vision.
                </p>
            </div>

            <!-- Right Side: Autoplay Solar Infrastructure Video -->
            <div class="col-lg-6 text-center" data-aos="fade-left">
                <div style="overflow: hidden; border-radius: 20px; width: 100%; height: 580px; background: #ffffff;">
                    <video autoplay loop muted playsinline style="width: 100%; height: 630px; margin-top: -28px; object-fit: cover; object-position: 50% 10%; background: #ffffff; display: block;">
                        <source src="<?php echo SITE_URL; ?>/assets/images/greener-tomorrow-video.mp4" type="video/mp4">
                    </video>
                </div>
            </div>
    </div>
</section>

<!-- Solar Products Categories Grid Section -->
<section class="py-5 bg-white border-top">
    <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5" data-aos="fade-up">
            <span class="text-uppercase font-weight-bold text-muted small" style="letter-spacing: 2px;">Our Equipment</span>
            <h2 class="display-5 text-dark mt-2 mb-2" style="font-weight: 300;">High Quality Solar Equipment</h2>
            <p class="text-secondary fs-6">Explore our tier-1 certified solar equipment engineered for long-lasting performance and maximum energy savings.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Box 1: Solar Panels -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4 bg-white rounded-3 shadow-sm border border-light-subtle h-100">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-1" style="width: 44px; height: 44px; background: #F3F4F6; color: #374151; font-size: 1.25rem;">
                        <i class="fa-solid fa-solar-panel"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Solar Panels</h5>
                    <p class="text-muted small mb-0 lh-base">High-efficiency Mono PERC &amp; Bifacial solar modules with up to 21.5% power efficiency rating for maximum output.</p>
                </div>
            </div>

            <!-- Box 2: Solar Inverters -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="150">
                <div class="p-4 bg-white rounded-3 shadow-sm border border-light-subtle h-100">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-1" style="width: 44px; height: 44px; background: #F3F4F6; color: #374151; font-size: 1.25rem;">
                        <i class="fa-solid fa-bolt-lightning"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Solar Inverters</h5>
                    <p class="text-muted small mb-0 lh-base">Advanced On-Grid, Off-Grid &amp; Hybrid inverters equipped with smart MPPT tracking for seamless power synchronization.</p>
                </div>
            </div>

            <!-- Box 3: Solar Batteries -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="p-4 bg-white rounded-3 shadow-sm border border-light-subtle h-100">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-1" style="width: 44px; height: 44px; background: #F3F4F6; color: #374151; font-size: 1.25rem;">
                        <i class="fa-solid fa-car-battery"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Solar Batteries</h5>
                    <p class="text-muted small mb-0 lh-base">Long life C10 rated Tubular &amp; Lithium-ion solar storage batteries providing reliable 24/7 power backup.</p>
                </div>
            </div>

            <!-- Box 4: Solar Water Heaters -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
                <div class="p-4 bg-white rounded-3 shadow-sm border border-light-subtle h-100">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-1" style="width: 44px; height: 44px; background: #F3F4F6; color: #374151; font-size: 1.25rem;">
                        <i class="fa-solid fa-fire-flame-simple"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Solar Water Heaters</h5>
                    <p class="text-muted small mb-0 lh-base">Eco-friendly ETC &amp; FPC solar thermal water heating systems for domestic, commercial &amp; industrial hot water needs.</p>
                </div>
            </div>

            <!-- Box 5: Solar Street Lights -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="p-4 bg-white rounded-3 shadow-sm border border-light-subtle h-100">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-1" style="width: 44px; height: 44px; background: #F3F4F6; color: #374151; font-size: 1.25rem;">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Solar Street Lights</h5>
                    <p class="text-muted small mb-0 lh-base">All-in-one integrated LED solar street lights with automatic dusk-to-dawn sensors and LiFePO4 batteries.</p>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Featured Products Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center max-w-700 mx-auto mb-5" data-aos="fade-up">
            <span class="text-uppercase font-weight-bold text-muted small" style="letter-spacing: 2px;">Featured Products</span>
            <h2 class="display-5 text-dark mt-1 mb-2" style="font-weight: 300;">Featured Solar Equipment</h2>
        </div>

        <div class="row g-4">
            <?php if (!empty($featuredProducts)): ?>
                <?php foreach ($featuredProducts as $prod): ?>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up">
                        <div class="product-card">
                            <div class="product-img-wrapper">
                                <span class="product-badge"><?php echo htmlspecialchars($prod['category_name']); ?></span>
                                <img src="<?php echo SITE_URL . '/assets/images/' . htmlspecialchars($prod['image']); ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>" onerror="this.src='<?php echo SITE_URL; ?>/assets/images/panel-540w.jpg'">
                            </div>
                            <div class="product-content">
                                <div>
                                    <h5 class="product-title"><?php echo htmlspecialchars($prod['name']); ?></h5>
                                    <div class="text-muted small mb-2"><i class="fa-solid fa-microchip text-warning me-1"></i> <?php echo htmlspecialchars($prod['capacity']); ?></div>
                                </div>
                                <div class="mt-auto pt-3 border-top">
                                    <div class="d-flex align-items-baseline justify-content-between mb-2">
                                        <span class="font-weight-bold text-dark fs-5"><?php echo format_price($prod['price']); ?></span>
                                        <?php if ($prod['old_price']): ?>
                                            <small class="text-muted text-decoration-line-through"><?php echo format_price($prod['old_price']); ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex gap-2 align-items-center">
                                        <a href="<?php echo SITE_URL; ?>/product-detail.php?id=<?php echo $prod['id']; ?>" class="btn btn-outline-secondary btn-sm flex-fill text-nowrap py-2 d-inline-flex align-items-center justify-content-center font-weight-semibold" style="border-radius: 6px;" title="View Details">
                                            <i class="fa-solid fa-eye me-1"></i> Details
                                        </a>
                                        <a href="https://api.whatsapp.com/send?phone=<?php echo get_site_setting('whatsapp', '919876543210'); ?>&text=Hi,%20I%20want%20to%20order%20<?php echo urlencode($prod['name']); ?>" class="btn btn-dark btn-sm flex-fill text-nowrap py-2 d-inline-flex align-items-center justify-content-center font-weight-bold" style="border-radius: 6px; background: #1F2937;" target="_blank">
                                            <i class="fa-solid fa-cart-shopping me-1"></i> Order Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-4">
                    <p class="text-muted">No featured products found. Add products from Admin Panel.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-5">
            <a href="<?php echo SITE_URL; ?>/products.php" class="btn btn-solar-outline px-4 py-2">View All Products <i class="fa-solid fa-arrow-right ms-1"></i></a>
        </div>
    </div>
</section>

<!-- Solar Savings & System Size Calculator Section -->
<section class="py-5 bg-light border-top" id="solar-calculator">
    <div class="container py-3">
        <div class="text-center max-w-700 mx-auto mb-5" data-aos="fade-up">
            <span class="text-uppercase font-weight-bold text-muted small" style="letter-spacing: 2px;">Professional Solar Calculator</span>
            <h2 class="display-5 text-dark mt-1 mb-2" style="font-weight: 300;">Calculate Your Solar System Size, Cost &amp; Savings</h2>
            <p class="text-secondary fs-6">Instant estimation of system size, PM Surya Ghar Govt. subsidy, 575W panel count, lifetime ROI, and carbon offset.</p>
        </div>

        <div class="row g-4 align-items-stretch justify-content-center">
            <!-- Left Side: Inputs, System Type & Mode Selector -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="p-4 bg-white rounded-1 shadow-sm border border-light-subtle h-100 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Mode Selector Tabs -->
                        <div class="nav nav-pills nav-fill bg-light p-1 rounded-1 mb-3 border" id="calcTabs" role="tablist">
                            <button class="nav-link active font-weight-semibold py-2 px-2 small" id="bill-tab" data-bs-toggle="tab" data-bs-target="#mode-bill" type="button" role="tab" onclick="switchCalcMode('bill')">
                                <i class="fa-solid fa-file-invoice-dollar me-1"></i> Monthly Bill
                            </button>
                            <button class="nav-link font-weight-semibold py-2 px-2 small" id="kw-tab" data-bs-toggle="tab" data-bs-target="#mode-kw" type="button" role="tab" onclick="switchCalcMode('kw')">
                                <i class="fa-solid fa-solar-panel me-1"></i> System Size
                            </button>
                            <button class="nav-link font-weight-semibold py-2 px-2 small" id="roof-tab" data-bs-toggle="tab" data-bs-target="#mode-roof" type="button" role="tab" onclick="switchCalcMode('roof')">
                                <i class="fa-solid fa-house-chimney me-1"></i> Roof Area
                            </button>
                            <button class="nav-link font-weight-semibold py-2 px-2 small" id="emi-tab" data-bs-toggle="tab" data-bs-target="#mode-emi" type="button" role="tab" onclick="switchCalcMode('emi')">
                                <i class="fa-solid fa-calculator me-1"></i> Solar Loan EMI
                            </button>
                        </div>

                        <!-- Tab 4: Solar Loan EMI Input -->
                        <div class="calc-mode-panel d-none" id="panel-emi">
                            <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                                <h5 class="font-weight-bold text-dark mb-0 text-uppercase" style="letter-spacing: 0.5px; font-size: 1.05rem;">
                                    <i class="fa-solid fa-calculator text-success me-2"></i>Configure Solar Loan Financing
                                </h5>
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill font-weight-semibold small">
                                    Flexible EMI Options
                                </span>
                            </div>

                            <!-- 1. Down Payment Slider -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="font-weight-bold text-dark mb-0 small text-uppercase" style="letter-spacing: 0.5px;">Down Payment</label>
                                    <span class="badge bg-dark font-weight-bold fs-6 px-3 py-1" id="emiDownPayDisplay">₹30,000</span>
                                </div>
                                <input type="range" class="form-range" id="inputEmiDownPay" min="0" max="150000" step="5000" value="30000" oninput="calculateEmiMaster()">
                                <div class="d-flex justify-content-between text-muted small mt-1">
                                    <span id="emiDownMin">₹0</span>
                                    <span id="emiDownMax">₹1,56,000</span>
                                </div>
                            </div>

                            <!-- Derived Loan Amount Display Box -->
                            <div class="p-3 mb-4 rounded-1 border bg-light">
                                <small class="text-muted font-weight-bold d-block text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Derived Loan Amount (Cost - Down Payment)</small>
                                <h4 class="font-weight-bold text-dark mb-0" id="emiLoanAmountDisplay">₹1,26,000</h4>
                            </div>

                            <!-- 2. Interest Rate Slider -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="font-weight-bold text-dark mb-0 small text-uppercase" style="letter-spacing: 0.5px;">Interest Rate</label>
                                    <span class="badge bg-dark font-weight-bold fs-6 px-3 py-1" id="emiRateDisplay">8.5% P.A.</span>
                                </div>
                                <input type="range" class="form-range" id="inputEmiRate" min="6" max="15" step="0.25" value="8.5" oninput="calculateEmiMaster()">
                                <div class="d-flex justify-content-between text-muted small mt-1">
                                    <span>6%</span>
                                    <span>10%</span>
                                    <span>15%</span>
                                </div>
                            </div>

                            <!-- 3. Loan Duration Slider -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="font-weight-bold text-dark mb-0 small text-uppercase" style="letter-spacing: 0.5px;">Loan Duration</label>
                                    <span class="badge bg-dark font-weight-bold fs-6 px-3 py-1" id="emiTenureDisplay">5 Years</span>
                                </div>
                                <input type="range" class="form-range" id="inputEmiTenure" min="1" max="10" step="1" value="5" oninput="calculateEmiMaster()">
                                <div class="d-flex justify-content-between text-muted small mt-1">
                                    <span>1 Year</span>
                                    <span>5 Years</span>
                                    <span>10 Years</span>
                                </div>
                            </div>

                            <!-- Financing Highlights Badges -->
                            <div class="pt-3 border-top d-flex flex-wrap gap-2 text-muted small font-weight-semibold mb-3">
                                <span class="badge bg-light text-secondary border py-2 px-3"><i class="fa-solid fa-circle-check text-success me-1"></i> No Cost EMI Available</span>
                                <span class="badge bg-light text-secondary border py-2 px-3"><i class="fa-solid fa-circle-check text-success me-1"></i> 8.5% Low Interest</span>
                                <span class="badge bg-light text-secondary border py-2 px-3"><i class="fa-solid fa-circle-check text-success me-1"></i> Up to 10 Years Tenure</span>
                            </div>
                        </div>

                        <!-- Standard Inputs Wrapper (Hides when EMI mode is active) -->
                        <div id="standard-inputs-wrapper">
                            <!-- Tab 1: Monthly Bill Input -->
                            <div class="calc-mode-panel" id="panel-bill">
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="font-weight-bold text-dark mb-0 fs-6">Monthly Electricity Bill (₹)</label>
                                        <span class="badge bg-dark fs-6 px-3 py-2" id="billValDisplay">₹5,000</span>
                                    </div>
                                    <input type="range" class="form-range" id="inputBillSlider" min="1000" max="50000" step="500" value="5000" oninput="calculateSolarMaster()">
                                    <div class="d-flex justify-content-between text-muted small mt-1">
                                        <span>₹1,000</span>
                                        <span>₹25,000</span>
                                        <span>₹50,000+</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2: System Size Input -->
                            <div class="calc-mode-panel d-none" id="panel-kw">
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="font-weight-bold text-dark mb-0 fs-6">Desired Solar System Size (kW)</label>
                                        <span class="badge bg-dark fs-6 px-3 py-2" id="kwValDisplay">5.0 kW</span>
                                    </div>
                                    <input type="range" class="form-range" id="inputKwSlider" min="1" max="50" step="0.5" value="5" oninput="calculateSolarMaster()">
                                    <div class="d-flex justify-content-between text-muted small mt-1">
                                        <span>1 kW</span>
                                        <span>25 kW</span>
                                        <span>50 kW</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 3: Roof Area Input -->
                            <div class="calc-mode-panel d-none" id="panel-roof">
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="font-weight-bold text-dark mb-0 fs-6">Available Rooftop Area (sq.ft.)</label>
                                        <span class="badge bg-dark fs-6 px-3 py-2" id="roofValDisplay">500 sq.ft.</span>
                                    </div>
                                    <input type="range" class="form-range" id="inputRoofSlider" min="100" max="5000" step="50" value="500" oninput="calculateSolarMaster()">
                                    <div class="d-flex justify-content-between text-muted small mt-1">
                                        <span>100 sq.ft.</span>
                                        <span>2,500 sq.ft.</span>
                                        <span>5,000 sq.ft.</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Property Type Selector -->
                            <div class="mt-3 mb-3">
                                <label class="form-label font-weight-semibold text-muted small text-uppercase" style="letter-spacing: 1px;">Property Type</label>
                                <div class="d-flex gap-2 flex-wrap" id="propertyTypeGroup">
                                    <button type="button" class="btn btn-property-type active" data-type="residential" onclick="selectPropertyType(this)">
                                        <i class="fa-solid fa-house me-1"></i> Residential
                                    </button>
                                    <button type="button" class="btn btn-property-type" data-type="commercial" onclick="selectPropertyType(this)">
                                        <i class="fa-solid fa-building me-1"></i> Commercial
                                    </button>
                                    <button type="button" class="btn btn-property-type" data-type="industrial" onclick="selectPropertyType(this)">
                                        <i class="fa-solid fa-industry me-1"></i> Industrial
                                    </button>
                                </div>
                            </div>

                            <!-- Tariff Rate & City Input -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label font-weight-semibold text-muted small">Electricity Rate (₹/unit)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">₹</span>
                                        <input type="number" class="form-control" id="inputRate" value="8" min="3" max="20" step="0.5" onchange="calculateSolarMaster()" onkeyup="calculateSolarMaster()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label font-weight-semibold text-muted small">City / Location</label>
                                    <input type="text" class="form-control" id="inputCity" placeholder="e.g. New Delhi" value="Delhi / NCR">
                                </div>
                            </div>

                            <!-- PM Surya Ghar Govt. Subsidy Option Toggle -->
                            <div class="mt-3 p-3 bg-light rounded-1 border">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <label class="font-weight-bold text-dark mb-0 small d-block" for="inputSubsidyToggle" style="cursor: pointer;">
                                            <i class="fa-solid fa-hand-holding-dollar text-success me-1"></i> Apply PM Surya Ghar Govt. Subsidy
                                        </label>
                                        <small class="text-muted">Up to ₹78,000 Govt. Subsidy for Residential Solar</small>
                                    </div>
                                    <div class="form-check form-switch ms-3">
                                        <input class="form-check-input fs-5" type="checkbox" id="inputSubsidyToggle" checked onchange="calculateSolarMaster()" style="cursor: pointer;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lead Capture Form -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="font-weight-bold text-dark mb-3"><i class="fa-solid fa-headset text-warning me-2"></i>Get Free Solar Consultation &amp; Site Survey</h6>
                        <form id="calcLeadForm" onsubmit="handleCalcLead(event)">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" id="leadName" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="tel" class="form-control form-control-sm" id="leadPhone" placeholder="Mobile Number" required pattern="[0-9]{10}">
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-solar-primary w-100 font-weight-bold py-2">
                                        Get Free Solar Consultation <i class="fa-solid fa-paper-plane ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Side: Enhanced Results Grid & EMI View -->
            <div class="col-lg-6">
                <div class="p-4 bg-white rounded-1 shadow-sm border border-light-subtle h-100 d-flex flex-column justify-content-between">
                    <!-- Standard Results Panel -->
                    <div id="panel-results-standard">
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                            <h5 class="font-weight-bold text-dark mb-0">Professional Solar Summary</h5>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-3 py-2 rounded-pill font-weight-semibold">
                                <i class="fa-solid fa-sun me-1"></i> PM Surya Ghar Subsidy
                            </span>
                        </div>

                        <!-- Results Grid -->
                        <div class="row g-3">
                            <!-- 1. Recommended System Size -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Solar Size</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resSystemKw">5.2 kW</h4>
                                    <small class="text-muted" id="resRoofArea">Area: 520 sq.ft.</small>
                                </div>
                            </div>

                            <!-- 2. Daily Generation -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Daily Generation</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resDailyGen">21 Units</h4>
                                    <small class="text-muted">Avg / Day</small>
                                </div>
                            </div>

                            <!-- 3. Monthly Generation -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Monthly Units</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resMonthlyGen">624 Units</h4>
                                    <small class="text-muted" id="resYearlyGen">7,488 / Yr</small>
                                </div>
                            </div>

                            <!-- 4. Est. System Cost -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">System Cost</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resSystemCost">₹2,34,000</h4>
                                    <small class="text-muted">Without Subsidy</small>
                                </div>
                            </div>

                            <!-- 5. Subsidy Amount -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-success bg-opacity-10 rounded-1 border border-success border-opacity-20 h-100">
                                    <span class="text-success small d-block mb-1 font-weight-semibold">Govt. Subsidy</span>
                                    <h4 class="font-weight-bold text-success mb-0" id="resSubsidy">₹78,000</h4>
                                    <small class="text-success">PM Surya Ghar</small>
                                </div>
                            </div>

                            <!-- 6. Net Cost After Subsidy -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Final Net Cost</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resNetCost">₹1,56,000</h4>
                                    <small class="text-muted">After Subsidy</small>
                                </div>
                            </div>

                            <!-- 7. Panels Count (575W) -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Solar Panels</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resPanels">10 Panels</h4>
                                    <small class="text-muted">575W Mono PERC</small>
                                </div>
                            </div>

                            <!-- 8. Monthly Savings -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Monthly Savings</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resMonthlySavings">₹5,000</h4>
                                    <small class="text-muted">Bill Reduction</small>
                                </div>
                            </div>

                            <!-- 9. Yearly Savings -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Yearly Savings</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resYearlySavings">₹60,000</h4>
                                    <small class="text-muted">Annual Return</small>
                                </div>
                            </div>

                            <!-- 10. Payback Period -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">Payback Period</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resPayback">2.6 Years</h4>
                                    <small class="text-muted">Fast ROI</small>
                                </div>
                            </div>

                            <!-- 11. 25-Year Savings -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">25-Yr Lifetime</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resLifetimeSavings">₹15,00,000</h4>
                                    <small class="text-muted">Total Benefit</small>
                                </div>
                            </div>

                            <!-- 12. CO2 Offset -->
                            <div class="col-md-4 col-6">
                                <div class="p-3 bg-light rounded-1 border h-100">
                                    <span class="text-muted small d-block mb-1 font-weight-semibold">🌱 CO₂ Offset</span>
                                    <h4 class="font-weight-bold text-dark mb-0" id="resCo2">~6.2 Tons</h4>
                                    <small class="text-muted">Green Impact/Yr</small>
                                </div>
                            </div>
                        </div>

                        <!-- Highlight Guarantee Banner -->
                        <div class="mt-4 p-3 rounded-1 bg-dark text-white d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="font-weight-bold mb-1"><i class="fa-solid fa-circle-check text-warning me-2"></i>Residential Roof Suitable: <span id="resRoofSuitable">Yes (Ideal)</span></h6>
                                <small class="text-gray-300">Complete Net-Metering &amp; DISCOM Approval Included</small>
                            </div>
                            <button class="btn btn-sm btn-solar-accent" data-bs-toggle="modal" data-bs-target="#siteSurveyModal">
                                Claim Subsidy
                            </button>
                        </div>
                    </div>

                    <!-- EMI Results Panel (Shown when Solar Loan EMI tab is active) -->
                    <div id="panel-results-emi" class="d-none">
                        <div class="mb-4 pb-2 border-bottom">
                            <h5 class="font-weight-bold text-dark mb-1 text-uppercase" style="letter-spacing: 0.5px; font-size: 1.05rem;">
                                EMI Cost Breakdown
                            </h5>
                            <small class="text-muted text-uppercase d-block" style="font-size: 0.72rem; letter-spacing: 0.5px;">Estimates are based on reducing balance interest rates</small>
                        </div>

                        <!-- Big Estimated Monthly EMI Card -->
                        <div class="text-center py-4 px-3 mb-4 rounded-3 border" style="background: #FAFDFB;">
                            <span class="text-muted font-weight-bold text-uppercase d-block mb-1" style="font-size: 0.8rem; letter-spacing: 1px;">Estimated Monthly EMI</span>
                            <h2 class="display-5 font-weight-bold mb-1" style="color: #059669;" id="emiMonthlyDisplay">₹2,584</h2>
                            <small class="text-muted font-weight-semibold text-uppercase" id="emiTenureMonthsLabel">FOR 60 MONTHS TENURE</small>
                        </div>

                        <!-- Detailed Breakdown List -->
                        <div class="d-flex flex-column gap-3 mb-4 px-2">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-secondary small font-weight-semibold">Down Payment Made</span>
                                <span class="font-weight-bold text-dark" id="emiRowDownPayment">₹30,000</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-secondary small font-weight-semibold">Loan Principal Amount</span>
                                <span class="font-weight-bold text-dark" id="emiRowPrincipal">₹1,26,000</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-secondary small font-weight-semibold">Interest Rate Charged</span>
                                <span class="font-weight-bold text-dark" id="emiRowInterestRate">8.5% P.A.</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-secondary small font-weight-semibold">Total Interest Payable</span>
                                <span class="font-weight-bold text-dark" id="emiRowTotalInterest">₹29,040</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 pt-3">
                                <span class="font-weight-bold text-dark fs-6">Total Cost (Principal + Interest)</span>
                                <span class="font-weight-bold text-dark fs-5" id="emiRowTotalCost">₹1,55,040</span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-3 border-top">
                            <button class="btn btn-dark w-100 py-3 font-weight-bold text-white shadow-sm rounded-3 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#siteSurveyModal" style="background: #1F2937;">
                                <i class="fa-solid fa-file-pdf fs-5 text-warning"></i> Download Proposal &amp; Apply Loan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Property Type Toggle Buttons */
.btn-property-type {
    border: 1.5px solid #D1D5DB;
    background: #F9FAFB;
    color: #374151;
    font-weight: 600;
    font-size: 0.85rem;
    padding: 8px 20px;
    border-radius: 50px;
    transition: all 0.22s ease;
    outline: none !important;
    box-shadow: none !important;
}
.btn-property-type:hover {
    border-color: #9CA3AF;
    background: #F3F4F6;
    color: #111827;
}
.btn-property-type.active {
    background: #1F2937;
    color: #ffffff !important;
    border-color: #1F2937;
    box-shadow: 0 4px 14px rgba(31,41,55,0.22) !important;
}
</style>

<!-- Solar Calculator JS Script -->
<script>
let currentCalcMode = 'bill';
let currentSystemType = 'grid';
let currentPropertyType = 'residential';
let currentNetSystemCost = 156000;

function selectPropertyType(btn) {
    // Update active state
    document.querySelectorAll('#propertyTypeGroup .btn-property-type').forEach(b => {
        b.classList.remove('active');
    });
    btn.classList.add('active');
    currentPropertyType = btn.getAttribute('data-type');

    // Auto-toggle PM Subsidy based on property type
    const subsidyToggle = document.getElementById('inputSubsidyToggle');
    if (subsidyToggle) {
        if (currentPropertyType === 'residential') {
            subsidyToggle.disabled = false;
            subsidyToggle.checked = true;
        } else {
            subsidyToggle.checked = false;
            subsidyToggle.disabled = true;
        }
    }
    calculateSolarMaster();
}

function switchCalcMode(mode) {
    currentCalcMode = mode;

    // Hide all mode panels
    document.getElementById('panel-bill').classList.add('d-none');
    document.getElementById('panel-kw').classList.add('d-none');
    document.getElementById('panel-roof').classList.add('d-none');
    document.getElementById('panel-emi').classList.add('d-none');

    const standardInputs = document.getElementById('standard-inputs-wrapper');
    const panelStandardResults = document.getElementById('panel-results-standard');
    const panelEmiResults = document.getElementById('panel-results-emi');

    if (mode === 'emi') {
        // EMI Mode: Show EMI input panel, hide standard inputs, show EMI results on right
        document.getElementById('panel-emi').classList.remove('d-none');
        if (standardInputs) standardInputs.classList.add('d-none');
        if (panelStandardResults) panelStandardResults.classList.add('d-none');
        if (panelEmiResults) panelEmiResults.classList.remove('d-none');
        calculateEmiMaster();
    } else {
        // Standard Solar Mode: Show selected input panel, show standard inputs, show standard results on right
        document.getElementById('panel-' + mode).classList.remove('d-none');
        if (standardInputs) standardInputs.classList.remove('d-none');
        if (panelStandardResults) panelStandardResults.classList.remove('d-none');
        if (panelEmiResults) panelEmiResults.classList.add('d-none');
        calculateSolarMaster();
    }
}

function setSystemType(type) {
    currentSystemType = type;
    document.querySelectorAll('.system-type-btn').forEach(btn => {
        btn.classList.remove('active', 'btn-dark');
        btn.classList.add('btn-outline-dark');
    });
    
    const activeBtn = document.getElementById('type-' + type);
    if (activeBtn) {
        activeBtn.classList.remove('btn-outline-dark');
        activeBtn.classList.add('active', 'btn-dark');
    }

    const descElem = document.getElementById('sysTypeDesc');
    if (type === 'grid') descElem.innerText = 'Lowest Cost Grid Connected';
    else if (type === 'hybrid') descElem.innerText = 'Grid Connected + Battery Backup';
    else if (type === 'offgrid') descElem.innerText = 'Standalone Battery System';

    calculateSolarMaster();
}

function calculateSolarMaster() {
    let rate = parseFloat(document.getElementById('inputRate').value) || 8;
    let systemKw = 5.0;
    let monthlyBill = 5000;

    if (currentCalcMode === 'bill') {
        monthlyBill = parseFloat(document.getElementById('inputBillSlider').value) || 5000;
        document.getElementById('billValDisplay').innerText = '₹' + monthlyBill.toLocaleString('en-IN');
        let monthlyUnits = monthlyBill / rate;
        systemKw = monthlyUnits / 120;
    } else if (currentCalcMode === 'kw') {
        systemKw = parseFloat(document.getElementById('inputKwSlider').value) || 5.0;
        document.getElementById('kwValDisplay').innerText = systemKw.toFixed(1) + ' kW';
        monthlyBill = Math.round(systemKw * 120 * rate);
    } else if (currentCalcMode === 'roof') {
        let area = parseFloat(document.getElementById('inputRoofSlider').value) || 500;
        document.getElementById('roofValDisplay').innerText = area.toLocaleString('en-IN') + ' sq.ft.';
        systemKw = area / 100;
        monthlyBill = Math.round(systemKw * 120 * rate);
    }

    if (systemKw < 0.5) systemKw = 0.5;
    let roundedKw = parseFloat(systemKw.toFixed(1));
    
    // Core Power Metrics
    let monthlyGen = Math.round(roundedKw * 120);
    let dailyGen = Math.round(monthlyGen / 30);
    let yearlyGen = Math.round(monthlyGen * 12);
    let monthlySavings = Math.round(monthlyGen * rate);
    let yearlySavings = Math.round(monthlySavings * 12);
    let lifetimeSavings = Math.round(yearlySavings * 25);
    
    // Roof Area & Panel Count (575W Panel)
    let reqArea = Math.round(roundedKw * 100);
    let panelsReq = Math.ceil((roundedKw * 1000) / 575);
    let isRoofSuitable = reqArea <= 2500 ? "Yes (Ideal)" : "Commercial Roof Req.";

    // System Type Pricing (per kW)
    let pricePerKw = 45000; // Grid-Tied default
    if (currentSystemType === 'hybrid') pricePerKw = 65000;
    if (currentSystemType === 'offgrid') pricePerKw = 75000;

    let systemCost = Math.round(roundedKw * pricePerKw);

    // Subsidy Calculation (PM Surya Ghar / MNRE Guidelines)
    let isSubsidyApplied = document.getElementById('inputSubsidyToggle') ? document.getElementById('inputSubsidyToggle').checked : true;
    let subsidy = 0;
    if (isSubsidyApplied) {
        if (roundedKw <= 1) subsidy = 30000;
        else if (roundedKw <= 2) subsidy = 60000;
        else subsidy = 78000; // Capped at ₹78,000
    }

    let netCost = Math.max(0, systemCost - subsidy);
    let paybackYears = yearlySavings > 0 ? (netCost / yearlySavings).toFixed(1) : "3.5";
    let co2Tons = (roundedKw * 1.2).toFixed(1);

    // Update UI elements
    document.getElementById('resSystemKw').innerText = roundedKw + ' kW';
    document.getElementById('resRoofArea').innerText = 'Area: ' + reqArea.toLocaleString('en-IN') + ' sq.ft.';
    document.getElementById('resDailyGen').innerText = dailyGen.toLocaleString('en-IN') + ' Units';
    document.getElementById('resMonthlyGen').innerText = monthlyGen.toLocaleString('en-IN') + ' Units';
    document.getElementById('resYearlyGen').innerText = yearlyGen.toLocaleString('en-IN') + ' / Yr';
    
    document.getElementById('resMonthlySavings').innerText = '₹' + monthlySavings.toLocaleString('en-IN');
    document.getElementById('resYearlySavings').innerText = '₹' + yearlySavings.toLocaleString('en-IN');
    document.getElementById('resLifetimeSavings').innerText = '₹' + lifetimeSavings.toLocaleString('en-IN');
    
    document.getElementById('resSystemCost').innerText = '₹' + systemCost.toLocaleString('en-IN');
    document.getElementById('resSubsidy').innerText = '₹' + subsidy.toLocaleString('en-IN');
    document.getElementById('resNetCost').innerText = '₹' + netCost.toLocaleString('en-IN');
    
    document.getElementById('resPanels').innerText = panelsReq + ' Panels';
    document.getElementById('resPayback').innerText = paybackYears + ' Years';
    document.getElementById('resCo2').innerText = '~' + co2Tons + ' Tons';
    document.getElementById('resRoofSuitable').innerText = isRoofSuitable;

    // Sync Net Cost to Loan Calculator & Recalculate EMI
    currentNetSystemCost = netCost;
    calculateEmiMaster();
}

function calculateEmiMaster() {
    const downPayElem = document.getElementById('inputEmiDownPay');
    const rateElem = document.getElementById('inputEmiRate');
    const tenureElem = document.getElementById('inputEmiTenure');
    if (!downPayElem || !rateElem || !tenureElem) return;

    if (currentNetSystemCost > 0) {
        downPayElem.max = currentNetSystemCost;
        if (parseInt(downPayElem.value, 10) > currentNetSystemCost) {
            downPayElem.value = Math.round(currentNetSystemCost * 0.2);
        }
    }

    const downPayment = parseInt(downPayElem.value, 10) || 0;
    const annualRate = parseFloat(rateElem.value) || 8.5;
    const tenureYears = parseInt(tenureElem.value, 10) || 5;

    const principal = Math.max(0, currentNetSystemCost - downPayment);
    const tenureMonths = tenureYears * 12;
    const monthlyRate = annualRate / (12 * 100);

    let monthlyEmi = 0;
    if (principal > 0 && monthlyRate > 0) {
        monthlyEmi = Math.round(
            (principal * monthlyRate * Math.pow(1 + monthlyRate, tenureMonths)) /
            (Math.pow(1 + monthlyRate, tenureMonths) - 1)
        );
    }

    const totalPaid = (monthlyEmi * tenureMonths) + downPayment;
    const totalInterest = Math.max(0, (monthlyEmi * tenureMonths) - principal);

    // Update UI Elements
    document.getElementById('emiDownPayDisplay').innerText = '₹' + downPayment.toLocaleString('en-IN');
    document.getElementById('emiDownMin').innerText = '₹0';
    document.getElementById('emiDownMax').innerText = '₹' + currentNetSystemCost.toLocaleString('en-IN');
    document.getElementById('emiLoanAmountDisplay').innerText = '₹' + principal.toLocaleString('en-IN');
    document.getElementById('emiRateDisplay').innerText = annualRate + '% P.A.';
    document.getElementById('emiTenureDisplay').innerText = tenureYears + (tenureYears === 1 ? ' Year' : ' Years');

    document.getElementById('emiMonthlyDisplay').innerText = '₹' + monthlyEmi.toLocaleString('en-IN');
    document.getElementById('emiTenureMonthsLabel').innerText = 'FOR ' + tenureMonths + ' MONTHS TENURE';

    document.getElementById('emiRowDownPayment').innerText = '₹' + downPayment.toLocaleString('en-IN');
    document.getElementById('emiRowPrincipal').innerText = '₹' + principal.toLocaleString('en-IN');
    document.getElementById('emiRowInterestRate').innerText = annualRate + '% P.A.';
    document.getElementById('emiRowTotalInterest').innerText = '₹' + totalInterest.toLocaleString('en-IN');
    document.getElementById('emiRowTotalCost').innerText = '₹' + totalPaid.toLocaleString('en-IN');
}

function handleCalcLead(e) {
    e.preventDefault();
    const name = document.getElementById('leadName').value;
    const phone = document.getElementById('leadPhone').value;
    const city = document.getElementById('inputCity').value || 'Delhi / NCR';
    const kw = document.getElementById('resSystemKw').innerText;

    alert(`Thank you ${name}! Your free consultation request for a ${kw} solar system in ${city} has been received. Our engineer will call you at ${phone} shortly.`);
    document.getElementById('calcLeadForm').reset();
}

document.addEventListener('DOMContentLoaded', function() {
    calculateSolarMaster();

    const inputs = ['inputBillSlider', 'inputKwSlider', 'inputRoofSlider', 'inputRate', 'inputCity', 'inputEmiDownPay', 'inputEmiRate', 'inputEmiTenure'];
    inputs.forEach(id => {
        const elem = document.getElementById(id);
        if (elem) {
            elem.addEventListener('input', calculateSolarMaster);
            elem.addEventListener('change', calculateSolarMaster);
            elem.addEventListener('keyup', calculateSolarMaster);
        }
    });
});
</script>



<!-- Call To Action (CTA) Banner -->
<section class="py-5 text-white w-100 m-0" style="background: #1F2937;">
    <div class="container text-center py-4" data-aos="zoom-in">
        <h2 class="font-weight-bold mb-3 display-5">Ready to Reduce Your Electricity Bill to ZERO?</h2>
        <p class="lead mb-4 max-w-700 mx-auto text-gray-200">Get in touch with our solar energy engineers for a 100% free rooftop site survey &amp; customized payback estimate.</p>
        <div class="d-flex justify-content-center gap-3">
            <button class="btn btn-solar-accent btn-lg px-5" data-bs-toggle="modal" data-bs-target="#siteSurveyModal">
                Book Free Site Survey <i class="fa-solid fa-clipboard-check ms-2"></i>
            </button>
            <a href="tel:<?php echo $phone; ?>" class="btn btn-outline-light btn-lg px-4">
                <i class="fa-solid fa-phone me-2"></i> Call: <?php echo $phone; ?>
            </a>
        </div>
    </div>
</section>


<?php require_once __DIR__ . '/includes/footer.php'; ?>
