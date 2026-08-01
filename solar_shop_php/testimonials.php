<?php
$pageTitle = "Customer Testimonials & Reviews";
require_once __DIR__ . '/includes/header.php';

$db = getDB();

$testimonials = [];
try {
    $stmt = $db->query("SELECT * FROM testimonials WHERE is_approved = 1 ORDER BY id DESC");
    $testimonials = $stmt->fetchAll();
} catch (Exception $e) {}
?>

<!-- Header Banner -->
<section class="py-5 text-white" style="background: var(--dark-green-gradient);">
    <div class="container text-center py-4">
        <h1 class="font-weight-bold display-4">Customer Testimonials</h1>
        <p class="lead text-gray-200">See what our satisfied rooftop solar homeowners and industrial clients say about us.</p>
    </div>
</section>

<!-- Testimonials Grid -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php if (!empty($testimonials)): ?>
                <?php foreach ($testimonials as $testi): ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up">
                        <div class="testimonial-card h-100">
                            <div class="stars mb-3">
                                <?php for ($i = 1; $i <= $testi['rating']; $i++): ?>
                                    <i class="fa-solid fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="text-muted font-italic mb-4">"<?php echo htmlspecialchars($testi['review_text']); ?>"</p>
                            <div class="d-flex align-items-center gap-3 pt-3 border-top mt-auto">
                                <img src="<?php echo SITE_URL . '/assets/images/' . htmlspecialchars($testi['client_image']); ?>" width="55" height="55" class="rounded-circle shadow-sm" alt="<?php echo htmlspecialchars($testi['client_name']); ?>" onerror="this.src='<?php echo SITE_URL; ?>/assets/images/user-1.jpg'">
                                <div>
                                    <h6 class="font-weight-bold mb-0"><?php echo htmlspecialchars($testi['client_name']); ?></h6>
                                    <small class="text-muted"><i class="fa-solid fa-location-dot me-1 text-danger"></i> <?php echo htmlspecialchars($testi['role_location']); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
