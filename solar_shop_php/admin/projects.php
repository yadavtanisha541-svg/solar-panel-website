<?php
require_once __DIR__ . '/includes/header.php';

$db = getDB();

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? sanitize($_POST['action']) : '';

    if ($action === 'create' || $action === 'update') {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $title = sanitize($_POST['title']);
        $category = sanitize($_POST['category']);
        $clientName = sanitize($_POST['client_name']);
        $location = sanitize($_POST['location']);
        $capacityKw = sanitize($_POST['capacity_kw']);
        $description = sanitize($_POST['description']);

        $imageName = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageName = upload_image('image');
        }

        try {
            if ($action === 'create') {
                $finalImage = $imageName ? $imageName : 'project-1.jpg';
                $stmt = $db->prepare("INSERT INTO projects (title, category, client_name, location, capacity_kw, description, image) VALUES (:title, :cat, :client, :loc, :cap, :desc, :img)");
                $stmt->execute([
                    ':title' => $title,
                    ':cat' => $category,
                    ':client' => $clientName,
                    ':loc' => $location,
                    ':cap' => $capacityKw,
                    ':desc' => $description,
                    ':img' => $finalImage
                ]);
                set_flash('success', 'Project added to gallery successfully!');
            } else {
                if ($imageName) {
                    $stmt = $db->prepare("UPDATE projects SET title=:title, category=:cat, client_name=:client, location=:loc, capacity_kw=:cap, description=:desc, image=:img WHERE id=:id");
                    $stmt->execute([
                        ':title' => $title,
                        ':cat' => $category,
                        ':client' => $clientName,
                        ':loc' => $location,
                        ':cap' => $capacityKw,
                        ':desc' => $description,
                        ':img' => $imageName,
                        ':id' => $id
                    ]);
                } else {
                    $stmt = $db->prepare("UPDATE projects SET title=:title, category=:cat, client_name=:client, location=:loc, capacity_kw=:cap, description=:desc WHERE id=:id");
                    $stmt->execute([
                        ':title' => $title,
                        ':cat' => $category,
                        ':client' => $clientName,
                        ':loc' => $location,
                        ':cap' => $capacityKw,
                        ':desc' => $description,
                        ':id' => $id
                    ]);
                }
                set_flash('success', 'Project updated successfully!');
            }
        } catch (Exception $e) {
            set_flash('danger', 'Error: ' . $e->getMessage());
        }
    } elseif ($action === 'delete') {
        $id = (int)$_POST['id'];
        try {
            $stmt = $db->prepare("DELETE FROM projects WHERE id = :id");
            $stmt->execute([':id' => $id]);
            set_flash('success', 'Project removed from gallery!');
        } catch (Exception $e) {
            set_flash('danger', 'Error: ' . $e->getMessage());
        }
    }
}

$projects = $db->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold mb-0">Manage Projects &amp; Work Gallery</h4>
    <button class="btn btn-solar-primary" data-bs-toggle="modal" data-bs-target="#projectModal" onclick="resetProjForm()">
        <i class="fa-solid fa-plus me-1"></i> Upload New Project Photo
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Photo</th>
                        <th>Project Title</th>
                        <th>Category</th>
                        <th>Client</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($projects)): ?>
                        <?php foreach ($projects as $proj): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo SITE_URL . '/assets/images/' . htmlspecialchars($proj['image']); ?>" width="60" height="45" class="rounded object-fit-cover" alt="" onerror="this.src='<?php echo SITE_URL; ?>/assets/images/project-1.jpg'">
                                </td>
                                <td><strong><?php echo htmlspecialchars($proj['title']); ?></strong></td>
                                <td><span class="badge bg-warning text-dark"><?php echo htmlspecialchars($proj['category']); ?></span></td>
                                <td><?php echo htmlspecialchars($proj['client_name']); ?></td>
                                <td><?php echo htmlspecialchars($proj['location']); ?></td>
                                <td><strong><?php echo htmlspecialchars($proj['capacity_kw']); ?></strong></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1" onclick='editProj(<?php echo json_encode($proj); ?>)'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="" method="POST" class="d-inline" onsubmit="return confirm('Delete this project photo?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $proj['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No projects uploaded yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-dark text-white rounded-top-4">
                <h5 class="modal-title" id="projModalTitle">Add Project Photo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="POST" enctype="multipart/form-data" id="projForm">
                    <input type="hidden" name="action" id="projAction" value="create">
                    <input type="hidden" name="id" id="projId" value="">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label font-weight-semibold">Project Title *</label>
                            <input type="text" name="title" id="pTitle" class="form-control" placeholder="e.g. 10kW Rooftop Solar Plant" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-semibold">Category *</label>
                            <select name="category" id="pCategory" class="form-select" required>
                                <option value="Residential">Residential</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Agricultural">Agricultural</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label font-weight-semibold">Client Name *</label>
                            <input type="text" name="client_name" id="pClient" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label font-weight-semibold">Location / City *</label>
                            <input type="text" name="location" id="pLoc" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label font-weight-semibold">Capacity (kW) *</label>
                            <input type="text" name="capacity_kw" id="pCap" class="form-control" placeholder="e.g. 10 kW" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Description</label>
                        <textarea name="description" id="pDesc" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Project Image Photo *</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-solar-primary w-100 py-3 mt-3">Upload Project</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function resetProjForm() {
    document.getElementById('projAction').value = 'create';
    document.getElementById('projId').value = '';
    document.getElementById('projForm').reset();
    document.getElementById('projModalTitle').innerText = 'Add Project Photo';
}

function editProj(proj) {
    document.getElementById('projAction').value = 'update';
    document.getElementById('projId').value = proj.id;
    document.getElementById('pTitle').value = proj.title;
    document.getElementById('pCategory').value = proj.category;
    document.getElementById('pClient').value = proj.client_name;
    document.getElementById('pLoc').value = proj.location;
    document.getElementById('pCap').value = proj.capacity_kw;
    document.getElementById('pDesc').value = proj.description || '';
    document.getElementById('projModalTitle').innerText = 'Edit Project Photo';
    
    new bootstrap.Modal(document.getElementById('projectModal')).show();
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
