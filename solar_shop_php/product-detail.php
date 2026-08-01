<?php
$pageTitle = "Product Details";
require_once __DIR__ . '/includes/header.php';

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$db = getDB();

$product = null;
try {
    $stmt = $db->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = :id LIMIT 1");
    $stmt->execute([':id' => $productId]);
    $product = $stmt->fetch();
} catch (Exception $e) {}

if (!$product) {
    echo '<div class="container py-5 text-center"><h2>Product Not Found</h2><a href="' . SITE_URL . '/products.php" class="btn btn-solar-primary mt-3">Back to Products</a></div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $product['name'] . " - Solar Details";
$phone = get_site_setting('phone', '+91 98765 43210');
?>

<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>/products.php">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['name']); ?></li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Product Image -->
            <div class="col-lg-6">
                <div class="p-3 bg-white rounded-4 shadow-sm border text-center">
                    <img src="<?php echo SITE_URL . '/assets/images/' . htmlspecialchars($product['image']); ?>" class="img-fluid rounded-3" alt="<?php echo htmlspecialchars($product['name']); ?>" onerror="this.src='<?php echo SITE_URL; ?>/assets/images/panel-540w.jpg'">
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6">
                <span class="badge bg-warning text-dark font-weight-bold px-3 py-2 rounded-pill mb-2"><?php echo htmlspecialchars($product['category_name']); ?></span>
                <h1 class="font-weight-bold mb-3"><?php echo htmlspecialchars($product['name']); ?></h1>
                
                <div class="mb-3 d-flex align-items-center gap-3">
                    <span class="display-6 font-weight-bold text-success"><?php echo format_price($product['price']); ?></span>
                    <?php if ($product['old_price']): ?>
                        <del class="fs-4 text-muted"><?php echo format_price($product['old_price']); ?></del>
                    <?php endif; ?>
                    <span class="badge bg-success-subtle text-success border border-success px-2 py-1">In Stock</span>
                </div>

                <div class="p-3 bg-light rounded-3 mb-4">
                    <div class="d-flex align-items-center gap-2 text-dark font-weight-semibold">
                        <i class="fa-solid fa-microchip text-warning fs-5"></i> Capacity / Specification: <span><?php echo htmlspecialchars($product['capacity']); ?></span>
                    </div>
                </div>

                <h5 class="font-weight-bold mb-2">Description</h5>
                <p class="text-muted mb-4"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

                <?php if (!empty($product['features'])): ?>
                    <h5 class="font-weight-bold mb-2">Key Features</h5>
                    <ul class="list-unstyled mb-4">
                        <?php foreach (explode(',', $product['features']) as $feat): ?>
                            <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i> <?php echo htmlspecialchars(trim($feat)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if (!empty($product['specifications'])): ?>
                    <h5 class="font-weight-bold mb-2">Technical Specifications</h5>
                    <div class="p-3 bg-light rounded-3 mb-4 small text-dark">
                        <?php foreach (explode(';', $product['specifications']) as $spec): ?>
                            <div class="py-1 border-bottom d-flex justify-content-between">
                                <span><?php echo htmlspecialchars(trim($spec)); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="d-flex gap-3">
                    <button class="btn btn-solar-primary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#siteSurveyModal">
                        Request Price Quote <i class="fa-solid fa-paper-plane ms-2"></i>
                    </button>
                    <a href="https://api.whatsapp.com/send?phone=<?php echo get_site_setting('whatsapp', '919876543210'); ?>&text=Hi,%20I%20am%20interested%20in%20<?php echo urlencode($product['name']); ?>" class="btn btn-solar-accent btn-lg px-4 font-weight-bold" target="_blank">
                        <i class="fa-solid fa-cart-shopping me-2"></i> Order Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
