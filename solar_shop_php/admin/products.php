<?php
require_once __DIR__ . '/includes/header.php';

$db = getDB();

// Handle Actions (Create, Update, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? sanitize($_POST['action']) : '';

    if ($action === 'create' || $action === 'update') {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $categoryId = (int)$_POST['category_id'];
        $name = sanitize($_POST['name']);
        $slug = slugify($name);
        $capacity = sanitize($_POST['capacity']);
        $price = (float)$_POST['price'];
        $oldPrice = !empty($_POST['old_price']) ? (float)$_POST['old_price'] : null;
        $description = sanitize($_POST['description']);
        $specifications = sanitize($_POST['specifications']);
        $features = sanitize($_POST['features']);
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;

        // Image upload
        $imageName = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageName = upload_image('image');
        }

        try {
            if ($action === 'create') {
                $finalImage = $imageName ? $imageName : 'panel-540w.jpg';
                $stmt = $db->prepare("INSERT INTO products (category_id, name, slug, capacity, price, old_price, description, specifications, features, image, is_featured) VALUES (:cat, :name, :slug, :cap, :price, :old_price, :desc, :spec, :feat, :img, :feat_flag)");
                $stmt->execute([
                    ':cat' => $categoryId,
                    ':name' => $name,
                    ':slug' => $slug,
                    ':cap' => $capacity,
                    ':price' => $price,
                    ':old_price' => $oldPrice,
                    ':desc' => $description,
                    ':spec' => $specifications,
                    ':feat' => $features,
                    ':img' => $finalImage,
                    ':feat_flag' => $isFeatured
                ]);
                set_flash('success', 'Product created successfully!');
            } else {
                // Update
                if ($imageName) {
                    $stmt = $db->prepare("UPDATE products SET category_id=:cat, name=:name, slug=:slug, capacity=:cap, price=:price, old_price=:old_price, description=:desc, specifications=:spec, features=:feat, image=:img, is_featured=:feat_flag WHERE id=:id");
                    $stmt->execute([
                        ':cat' => $categoryId,
                        ':name' => $name,
                        ':slug' => $slug,
                        ':cap' => $capacity,
                        ':price' => $price,
                        ':old_price' => $oldPrice,
                        ':desc' => $description,
                        ':spec' => $specifications,
                        ':feat' => $features,
                        ':img' => $imageName,
                        ':feat_flag' => $isFeatured,
                        ':id' => $id
                    ]);
                } else {
                    $stmt = $db->prepare("UPDATE products SET category_id=:cat, name=:name, slug=:slug, capacity=:cap, price=:price, old_price=:old_price, description=:desc, specifications=:spec, features=:feat, is_featured=:feat_flag WHERE id=:id");
                    $stmt->execute([
                        ':cat' => $categoryId,
                        ':name' => $name,
                        ':slug' => $slug,
                        ':cap' => $capacity,
                        ':price' => $price,
                        ':old_price' => $oldPrice,
                        ':desc' => $description,
                        ':spec' => $specifications,
                        ':feat' => $features,
                        ':feat_flag' => $isFeatured,
                        ':id' => $id
                    ]);
                }
                set_flash('success', 'Product updated successfully!');
            }
        } catch (Exception $e) {
            set_flash('danger', 'Error: ' . $e->getMessage());
        }
    } elseif ($action === 'delete') {
        $id = (int)$_POST['id'];
        try {
            $stmt = $db->prepare("DELETE FROM products WHERE id = :id");
            $stmt->execute([':id' => $id]);
            set_flash('success', 'Product deleted successfully!');
        } catch (Exception $e) {
            set_flash('danger', 'Error: ' . $e->getMessage());
        }
    }
}

// Fetch categories
$categories = $db->query("SELECT * FROM categories")->fetchAll();

// Fetch products
$products = $db->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold mb-0">Manage Solar Products</h4>
    <button class="btn btn-solar-primary" data-bs-toggle="modal" data-bs-target="#productModal" onclick="resetForm()">
        <i class="fa-solid fa-plus me-1"></i> Add New Product
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Capacity</th>
                        <th>Price</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $prod): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo SITE_URL . '/assets/images/' . htmlspecialchars($prod['image']); ?>" width="55" height="45" class="rounded object-fit-cover" alt="" onerror="this.src='<?php echo SITE_URL; ?>/assets/images/panel-540w.jpg'">
                                </td>
                                <td><strong><?php echo htmlspecialchars($prod['name']); ?></strong></td>
                                <td><span class="badge bg-success-subtle text-success border border-success"><?php echo htmlspecialchars($prod['category_name']); ?></span></td>
                                <td><?php echo htmlspecialchars($prod['capacity']); ?></td>
                                <td><strong><?php echo format_price($prod['price']); ?></strong></td>
                                <td>
                                    <?php if ($prod['is_featured']): ?>
                                        <span class="badge bg-warning text-dark"><i class="fa-solid fa-star"></i> Featured</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Standard</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1" onclick='editProduct(<?php echo json_encode($prod); ?>)'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $prod['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Product Add / Edit Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-dark text-white rounded-top-4">
                <h5 class="modal-title" id="modalTitle">Add Solar Product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="POST" enctype="multipart/form-data" id="productForm">
                    <input type="hidden" name="action" id="formAction" value="create">
                    <input type="hidden" name="id" id="productId" value="">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-semibold">Product Name *</label>
                            <input type="text" name="name" id="prodName" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-semibold">Category *</label>
                            <select name="category_id" id="prodCat" class="form-select" required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label font-weight-semibold">Capacity / Spec Badge *</label>
                            <input type="text" name="capacity" id="prodCap" class="form-control" placeholder="e.g. 540 Watt / 5kW" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label font-weight-semibold">Price (₹) *</label>
                            <input type="number" step="0.01" name="price" id="prodPrice" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label font-weight-semibold">Old Price (₹)</label>
                            <input type="number" step="0.01" name="old_price" id="prodOldPrice" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Short Description *</label>
                        <textarea name="description" id="prodDesc" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-semibold">Features (Comma separated)</label>
                            <input type="text" name="features" id="prodFeatures" class="form-control" placeholder="Anti-PID, 25-yr warranty, High wind load">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-semibold">Technical Specs (Semicolon separated)</label>
                            <input type="text" name="specifications" id="prodSpecs" class="form-control" placeholder="Efficiency: 21.3%; Cell: Mono PERC">
                        </div>
                    </div>

                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-8">
                            <label class="form-label font-weight-semibold">Product Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-4 pt-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="prodFeatured" value="1">
                                <label class="form-check-label font-weight-bold" for="prodFeatured">Show on Homepage</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-solar-primary w-100 py-3 mt-3">Save Product</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function resetForm() {
    document.getElementById('formAction').value = 'create';
    document.getElementById('productId').value = '';
    document.getElementById('productForm').reset();
    document.getElementById('modalTitle').innerText = 'Add Solar Product';
}

function editProduct(prod) {
    document.getElementById('formAction').value = 'update';
    document.getElementById('productId').value = prod.id;
    document.getElementById('prodName').value = prod.name;
    document.getElementById('prodCat').value = prod.category_id;
    document.getElementById('prodCap').value = prod.capacity;
    document.getElementById('prodPrice').value = prod.price;
    document.getElementById('prodOldPrice').value = prod.old_price || '';
    document.getElementById('prodDesc').value = prod.description;
    document.getElementById('prodFeatures').value = prod.features || '';
    document.getElementById('prodSpecs').value = prod.specifications || '';
    document.getElementById('prodFeatured').checked = prod.is_featured == 1;
    document.getElementById('modalTitle').innerText = 'Edit Solar Product';
    
    new bootstrap.Modal(document.getElementById('productModal')).show();
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
