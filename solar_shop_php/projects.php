<?php
$pageTitle = "Past Projects Gallery - Completed Solar Installations";
require_once __DIR__ . '/includes/header.php';

$db = getDB();

// Fetch Projects
$projects = [];
try {
    $stmt = $db->query("SELECT * FROM projects ORDER BY id DESC");
    $projects = $stmt->fetchAll();
} catch (Exception $e) {}
?>

<!-- Header Banner -->
<section class="py-3 bg-light border-bottom">
    <div class="container text-center py-1">
        <h2 class="font-weight-bold text-dark mb-1 fs-3">Solar Projects Gallery</h2>
        <p class="text-secondary small mb-0">Explore photos of our successfully installed rooftop, commercial &amp; agricultural solar plants.</p>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-5">
    <div class="container">
        
        <!-- Filter Tabs -->
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="btn-group flex-wrap gap-2" role="group">
                <button type="button" class="btn btn-solar-primary gallery-filter-btn active" data-filter="all">All Projects</button>
                <button type="button" class="btn btn-solar-outline gallery-filter-btn" data-filter="Residential">Residential</button>
                <button type="button" class="btn btn-solar-outline gallery-filter-btn" data-filter="Commercial">Commercial</button>
                <button type="button" class="btn btn-solar-outline gallery-filter-btn" data-filter="Agricultural">Agricultural</button>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="row g-4">
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $proj): ?>
                    <div class="col-md-6 col-lg-4 gallery-item <?php echo htmlspecialchars($proj['category']); ?>" data-aos="fade-up">
                        <div class="project-card">
                            <a href="<?php echo SITE_URL . '/assets/images/' . htmlspecialchars($proj['image']); ?>" class="project-lightbox" data-title="<?php echo htmlspecialchars($proj['title']); ?>">
                                <img src="<?php echo SITE_URL . '/assets/images/' . htmlspecialchars($proj['image']); ?>" alt="<?php echo htmlspecialchars($proj['title']); ?>" onerror="this.src='<?php echo SITE_URL; ?>/assets/images/project-1.jpg'">
                                <div class="project-overlay">
                                    <span class="badge bg-warning text-dark font-weight-bold mb-2 align-self-start"><?php echo htmlspecialchars($proj['category']); ?> • <?php echo htmlspecialchars($proj['capacity_kw']); ?></span>
                                    <h5 class="font-weight-bold mb-1"><?php echo htmlspecialchars($proj['title']); ?></h5>
                                    <p class="small text-gray-200 mb-1"><i class="fa-solid fa-user me-1"></i> <?php echo htmlspecialchars($proj['client_name']); ?></p>
                                    <p class="small text-gray-300 mb-0"><i class="fa-solid fa-location-dot me-1"></i> <?php echo htmlspecialchars($proj['location']); ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No projects found in gallery.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
