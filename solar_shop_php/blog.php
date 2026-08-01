<?php
$pageTitle = "Solar Blog - Guides & Tips for PM Surya Ghar Scheme";
require_once __DIR__ . '/includes/header.php';

$db = getDB();

$blogs = [];
try {
    $stmt = $db->query("SELECT * FROM blogs ORDER BY id DESC");
    $blogs = $stmt->fetchAll();
} catch (Exception $e) {}
?>

<!-- Header Banner -->
<section class="py-5 text-white" style="background: var(--dark-green-gradient);">
    <div class="container text-center py-4">
        <h1 class="font-weight-bold display-4">Solar Energy Blog &amp; Guides</h1>
        <p class="lead text-gray-200">Stay updated with latest solar panel technology, government subsidies &amp; energy saving tips.</p>
    </div>
</section>

<!-- Blog Listing Grid -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php if (!empty($blogs)): ?>
                <?php foreach ($blogs as $blog): ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up">
                        <div class="solar-card p-0 overflow-hidden d-flex flex-column h-100">
                            <div style="height: 200px; overflow: hidden;">
                                <img src="<?php echo SITE_URL . '/assets/images/' . htmlspecialchars($blog['image']); ?>" class="w-100 h-100 object-fit-cover" alt="<?php echo htmlspecialchars($blog['title']); ?>" onerror="this.src='<?php echo SITE_URL; ?>/assets/images/blog-1.jpg'">
                            </div>
                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <div class="text-muted small mb-2"><i class="fa-solid fa-calendar me-1"></i> <?php echo date('M d, Y', strtotime($blog['created_at'])); ?> • <i class="fa-solid fa-user me-1"></i> <?php echo htmlspecialchars($blog['author']); ?></div>
                                <h5 class="font-weight-bold mb-3"><a href="<?php echo SITE_URL; ?>/blog-detail.php?slug=<?php echo $blog['slug']; ?>" class="text-dark hover-primary"><?php echo htmlspecialchars($blog['title']); ?></a></h5>
                                <p class="text-muted small mb-4"><?php echo htmlspecialchars($blog['summary']); ?></p>
                                <div class="mt-auto">
                                    <a href="<?php echo SITE_URL; ?>/blog-detail.php?slug=<?php echo $blog['slug']; ?>" class="btn btn-solar-outline btn-sm">Read Article <i class="fa-solid fa-arrow-right ms-1"></i></a>
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
