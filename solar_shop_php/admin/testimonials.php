<?php
require_once __DIR__ . '/includes/header.php';

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? sanitize($_POST['action']) : '';

    if ($action === 'create' || $action === 'update') {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $name = sanitize($_POST['client_name']);
        $roleLoc = sanitize($_POST['role_location']);
        $rating = (int)$_POST['rating'];
        $review = sanitize($_POST['review_text']);
        $isApproved = isset($_POST['is_approved']) ? 1 : 0;

        $imageName = null;
        if (isset($_FILES['client_image']) && $_FILES['client_image']['error'] === UPLOAD_ERR_OK) {
            $imageName = upload_image('client_image');
        }

        try {
            if ($action === 'create') {
                $finalImage = $imageName ? $imageName : 'user-1.jpg';
                $stmt = $db->prepare("INSERT INTO testimonials (client_name, role_location, rating, review_text, client_image, is_approved) VALUES (:name, :role, :rating, :review, :img, :app)");
                $stmt->execute([
                    ':name' => $name,
                    ':role' => $roleLoc,
                    ':rating' => $rating,
                    ':review' => $review,
                    ':img' => $finalImage,
                    ':app' => $isApproved
                ]);
                set_flash('success', 'Testimonial added!');
            } else {
                if ($imageName) {
                    $stmt = $db->prepare("UPDATE testimonials SET client_name=:name, role_location=:role, rating=:rating, review_text=:review, client_image=:img, is_approved=:app WHERE id=:id");
                    $stmt->execute([
                        ':name' => $name,
                        ':role' => $roleLoc,
                        ':rating' => $rating,
                        ':review' => $review,
                        ':img' => $imageName,
                        ':app' => $isApproved,
                        ':id' => $id
                    ]);
                } else {
                    $stmt = $db->prepare("UPDATE testimonials SET client_name=:name, role_location=:role, rating=:rating, review_text=:review, is_approved=:app WHERE id=:id");
                    $stmt->execute([
                        ':name' => $name,
                        ':role' => $roleLoc,
                        ':rating' => $rating,
                        ':review' => $review,
                        ':app' => $isApproved,
                        ':id' => $id
                    ]);
                }
                set_flash('success', 'Testimonial updated!');
            }
        } catch (Exception $e) {
            set_flash('danger', 'Error: ' . $e->getMessage());
        }
    } elseif ($action === 'delete') {
        $id = (int)$_POST['id'];
        $db->prepare("DELETE FROM testimonials WHERE id = :id")->execute([':id' => $id]);
        set_flash('success', 'Testimonial deleted.');
    }
}

$testimonials = $db->query("SELECT * FROM testimonials ORDER BY id DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold mb-0">Manage Customer Testimonials</h4>
    <button class="btn btn-solar-primary" data-bs-toggle="modal" data-bs-target="#testiModal" onclick="resetTestiForm()">
        <i class="fa-solid fa-plus me-1"></i> Add Testimonial
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Client Name</th>
                        <th>Role / Location</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Approved</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($testimonials)): ?>
                        <?php foreach ($testimonials as $t): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo SITE_URL . '/assets/images/' . htmlspecialchars($t['client_image']); ?>" width="45" height="45" class="rounded-circle object-fit-cover" alt="" onerror="this.src='<?php echo SITE_URL; ?>/assets/images/user-1.jpg'">
                                </td>
                                <td><strong><?php echo htmlspecialchars($t['client_name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($t['role_location']); ?></td>
                                <td>
                                    <span class="text-warning">
                                        <?php for ($i=0; $i<$t['rating']; $i++): ?><i class="fa-solid fa-star"></i><?php endfor; ?>
                                    </span>
                                </td>
                                <td><small>"<?php echo htmlspecialchars(substr($t['review_text'], 0, 70)); ?>..."</small></td>
                                <td>
                                    <?php if ($t['is_approved']): ?>
                                        <span class="badge bg-success">Yes</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1" onclick='editTesti(<?php echo json_encode($t); ?>)'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="" method="POST" class="d-inline" onsubmit="return confirm('Delete this testimonial?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $t['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No testimonials added yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="testiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-dark text-white rounded-top-4">
                <h5 class="modal-title" id="tModalTitle">Add Testimonial</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="POST" enctype="multipart/form-data" id="testiForm">
                    <input type="hidden" name="action" id="tAction" value="create">
                    <input type="hidden" name="id" id="tId" value="">

                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Client Name *</label>
                        <input type="text" name="client_name" id="tName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Role / Location *</label>
                        <input type="text" name="role_location" id="tRole" class="form-control" placeholder="e.g. Home Owner, New Delhi" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Star Rating *</label>
                        <select name="rating" id="tRating" class="form-select">
                            <option value="5">5 Stars ★★★★★</option>
                            <option value="4">4 Stars ★★★★☆</option>
                            <option value="3">3 Stars ★★★☆☆</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Review Text *</label>
                        <textarea name="review_text" id="tReview" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Client Photo</label>
                        <input type="file" name="client_image" class="form-control" accept="image/*">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_approved" id="tApproved" value="1" checked>
                        <label class="form-check-label font-weight-bold" for="tApproved">Approved for Website</label>
                    </div>

                    <button type="submit" class="btn btn-solar-primary w-100 py-3">Save Testimonial</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function resetTestiForm() {
    document.getElementById('tAction').value = 'create';
    document.getElementById('tId').value = '';
    document.getElementById('testiForm').reset();
    document.getElementById('tModalTitle').innerText = 'Add Testimonial';
}

function editTesti(t) {
    document.getElementById('tAction').value = 'update';
    document.getElementById('tId').value = t.id;
    document.getElementById('tName').value = t.client_name;
    document.getElementById('tRole').value = t.role_location;
    document.getElementById('tRating').value = t.rating;
    document.getElementById('tReview').value = t.review_text;
    document.getElementById('tApproved').checked = t.is_approved == 1;
    document.getElementById('tModalTitle').innerText = 'Edit Testimonial';
    
    new bootstrap.Modal(document.getElementById('testiModal')).show();
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
