<?php
$pageTitle = "Solar Article";
require_once __DIR__ . '/includes/header.php';

$slug = isset($_GET['slug']) ? sanitize($_GET['slug']) : '';
$db = getDB();

$blog = null;
try {
    $stmt = $db->prepare("SELECT * FROM blogs WHERE slug = :slug LIMIT 1");
    $stmt->execute([':slug' => $slug]);
    $blog = $stmt->fetch();

    if ($blog) {
        // Increment views
        $db->prepare("UPDATE blogs SET views = views + 1 WHERE id = :id")->execute([':id' => $blog['id']]);
    }
} catch (Exception $e) {}

if (!$blog) {
    echo '<div class="container py-5 text-center"><h2>Article Not Found</h2><a href="' . SITE_URL . '/blog.php" class="btn btn-solar-primary mt-3">Back to Blog</a></div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $blog['title'] . " - Solar Guide";
?>

<section class="py-5">
    <div class="container max-w-900">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/blog.php">Blog</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($blog['title']); ?></li>
            </ol>
        </nav>

        <h1 class="font-weight-bold display-5 mb-3"><?php echo htmlspecialchars($blog['title']); ?></h1>
        <div class="d-flex align-items-center gap-3 text-muted mb-4 pb-3 border-bottom">
            <span><i class="fa-solid fa-user text-warning me-1"></i> <?php echo htmlspecialchars($blog['author']); ?></span>
            <span><i class="fa-solid fa-calendar text-warning me-1"></i> <?php echo date('F d, Y', strtotime($blog['created_at'])); ?></span>
            <span><i class="fa-solid fa-eye text-warning me-1"></i> <?php echo $blog['views']; ?> Views</span>
        </div>

        <div class="mb-4 text-center">
            <img src="<?php echo SITE_URL . '/assets/images/' . htmlspecialchars($blog['image']); ?>" class="img-fluid rounded-4 shadow-sm" alt="<?php echo htmlspecialchars($blog['title']); ?>" onerror="this.src='<?php echo SITE_URL; ?>/assets/images/blog-1.jpg'">
        </div>

        <div class="fs-5 lh-lg text-dark mb-5">
            <?php echo nl2br(htmlspecialchars($blog['content'])); ?>
        </div>

        <div class="p-4 bg-light rounded-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="font-weight-bold mb-1">Want Solar Installed at Your Property?</h5>
                <p class="text-muted mb-0 small">Get free site evaluation &amp; instant payback quotation.</p>
            </div>
            <button class="btn btn-solar-primary" data-bs-toggle="modal" data-bs-target="#siteSurveyModal">Get Quote <i class="fa-solid fa-arrow-right ms-1"></i></button>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
