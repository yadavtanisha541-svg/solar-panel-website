<?php
$pageTitle = "Solar Products - Panels, Inverters, Batteries & Water Heaters";
require_once __DIR__ . '/includes/header.php';

$db = getDB();

// Fetch Categories for filter tabs
$categories = [];
try {
    $stmt = $db->query("SELECT * FROM categories ORDER BY id ASC");
    $categories = $stmt->fetchAll();
} catch (Exception $e) {}

// Selected Category & Search Query filter
$selectedCatSlug = isset($_GET['cat']) ? sanitize($_GET['cat']) : '';
$searchQuery = isset($_GET['q']) ? sanitize($_GET['q']) : '';

// Build SQL Query
$sql = "SELECT p.*, c.name as category_name, c.slug as category_slug FROM products p JOIN categories c ON p.category_id = c.id WHERE 1=1";
$params = [];

if (!empty($selectedCatSlug)) {
    $sql .= " AND c.slug = :cat";
    $params[':cat'] = $selectedCatSlug;
}

if (!empty($searchQuery)) {
    $sql .= " AND (p.name LIKE :search OR p.description LIKE :search OR p.capacity LIKE :search)";
    $params[':search'] = '%' . $searchQuery . '%';
}

$sql .= " ORDER BY p.id DESC";

$products = [];
try {
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();
} catch (Exception $e) {}
?>

<!-- Unified Header & Filter Control Box -->
<section class="py-4 bg-light border-bottom mb-4">
    <div class="container">
        <div class="text-center mb-3">
            <h2 class="font-weight-bold text-dark mb-1 fs-3">Solar Products Catalog</h2>
            <p class="text-secondary small mb-0">High efficiency solar equipment backed by 25-year warranty &amp; official manufacturer support.</p>
        </div>

        <!-- Combined Filter & Search Bar in Single Unified Box -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form action="<?php echo SITE_URL; ?>/products.php" method="GET">
                    <div class="input-group shadow-sm">
                        <!-- Category Select Dropdown -->
                        <select name="cat" class="form-select border-secondary-subtle bg-white px-3 font-weight-medium" style="max-width: 220px;" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat['slug']); ?>" <?php echo $selectedCatSlug == $cat['slug'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        
                        <!-- Search Input -->
                        <input type="text" name="q" class="form-control px-3" placeholder="Search panel, inverter, battery..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                        
                        <!-- Search Button -->
                        <button class="btn btn-solar-primary px-4" type="submit"><i class="fa-solid fa-search me-1"></i> Search</button>
                        
                        <?php if (!empty($selectedCatSlug) || !empty($searchQuery)): ?>
                            <a href="<?php echo SITE_URL; ?>/products.php" class="btn btn-solar-outline"><i class="fa-solid fa-rotate-left"></i> Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Main Products Section -->
<section class="py-4">
    <div class="container">

        <!-- Products Grid -->
        <div class="row g-4">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $prod): ?>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up">
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
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-light rounded-4">
                        <i class="fa-solid fa-solar-panel fs-1 text-muted mb-3"></i>
                        <h4 class="text-muted">No products found matching your filter criteria.</h4>
                        <a href="<?php echo SITE_URL; ?>/products.php" class="btn btn-solar-primary mt-3">Reset Filters</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
