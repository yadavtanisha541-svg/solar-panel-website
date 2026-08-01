<?php
require_once __DIR__ . '/includes/header.php';

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? sanitize($_POST['action']) : '';

    if ($action === 'create' || $action === 'update') {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $title = sanitize($_POST['title']);
        $slug = slugify($title);
        $author = sanitize($_POST['author']);
        $summary = sanitize($_POST['summary']);
        $content = sanitize($_POST['content']);

        $imageName = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageName = upload_image('image');
        }

        try {
            if ($action === 'create') {
                $finalImage = $imageName ? $imageName : 'blog-1.jpg';
                $stmt = $db->prepare("INSERT INTO blogs (title, slug, author, summary, content, image) VALUES (:title, :slug, :author, :summary, :content, :img)");
                $stmt->execute([
                    ':title' => $title,
                    ':slug' => $slug,
                    ':author' => $author,
                    ':summary' => $summary,
                    ':content' => $content,
                    ':img' => $finalImage
                ]);
                set_flash('success', 'Blog post created successfully!');
            } else {
                if ($imageName) {
                    $stmt = $db->prepare("UPDATE blogs SET title=:title, slug=:slug, author=:author, summary=:summary, content=:content, image=:img WHERE id=:id");
                    $stmt->execute([
                        ':title' => $title,
                        ':slug' => $slug,
                        ':author' => $author,
                        ':summary' => $summary,
                        ':content' => $content,
                        ':img' => $imageName,
                        ':id' => $id
                    ]);
                } else {
                    $stmt = $db->prepare("UPDATE blogs SET title=:title, slug=:slug, author=:author, summary=:summary, content=:content WHERE id=:id");
                    $stmt->execute([
                        ':title' => $title,
                        ':slug' => $slug,
                        ':author' => $author,
                        ':summary' => $summary,
                        ':content' => $content,
                        ':id' => $id
                    ]);
                }
                set_flash('success', 'Blog post updated successfully!');
            }
        } catch (Exception $e) {
            set_flash('danger', 'Error: ' . $e->getMessage());
        }
    } elseif ($action === 'delete') {
        $id = (int)$_POST['id'];
        $db->prepare("DELETE FROM blogs WHERE id = :id")->execute([':id' => $id]);
        set_flash('success', 'Blog post deleted.');
    }
}

$blogs = $db->query("SELECT * FROM blogs ORDER BY id DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold mb-0">Manage Solar Blogs &amp; Articles</h4>
    <button class="btn btn-solar-primary" data-bs-toggle="modal" data-bs-target="#blogModal" onclick="resetBlogForm()">
        <i class="fa-solid fa-plus me-1"></i> Write New Article
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Banner</th>
                        <th>Article Title</th>
                        <th>Author</th>
                        <th>Views</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($blogs)): ?>
                        <?php foreach ($blogs as $b): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo SITE_URL . '/assets/images/' . htmlspecialchars($b['image']); ?>" width="60" height="40" class="rounded object-fit-cover" alt="" onerror="this.src='<?php echo SITE_URL; ?>/assets/images/blog-1.jpg'">
                                </td>
                                <td><strong><?php echo htmlspecialchars($b['title']); ?></strong></td>
                                <td><?php echo htmlspecialchars($b['author']); ?></td>
                                <td><span class="badge bg-secondary"><?php echo $b['views']; ?></span></td>
                                <td><?php echo date('d M Y', strtotime($b['created_at'])); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1" onclick='editBlog(<?php echo json_encode($b); ?>)'>
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="" method="POST" class="d-inline" onsubmit="return confirm('Delete this blog post?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $b['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No blog posts written yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="blogModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-dark text-white rounded-top-4">
                <h5 class="modal-title" id="bModalTitle">Write Solar Article</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="POST" enctype="multipart/form-data" id="blogForm">
                    <input type="hidden" name="action" id="bAction" value="create">
                    <input type="hidden" name="id" id="bId" value="">

                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label font-weight-semibold">Article Title *</label>
                            <input type="text" name="title" id="bTitle" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label font-weight-semibold">Author Name *</label>
                            <input type="text" name="author" id="bAuthor" class="form-control" value="Solar Team" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Short Summary / Excerpt *</label>
                        <input type="text" name="summary" id="bSummary" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Full Article Content *</label>
                        <textarea name="content" id="bContent" class="form-control" rows="6" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-semibold">Header Banner Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-solar-primary w-100 py-3">Publish Article</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function resetBlogForm() {
    document.getElementById('bAction').value = 'create';
    document.getElementById('bId').value = '';
    document.getElementById('blogForm').reset();
    document.getElementById('bModalTitle').innerText = 'Write Solar Article';
}

function editBlog(b) {
    document.getElementById('bAction').value = 'update';
    document.getElementById('bId').value = b.id;
    document.getElementById('bTitle').value = b.title;
    document.getElementById('bAuthor').value = b.author;
    document.getElementById('bSummary').value = b.summary;
    document.getElementById('bContent').value = b.content;
    document.getElementById('bModalTitle').innerText = 'Edit Solar Article';
    
    new bootstrap.Modal(document.getElementById('blogModal')).show();
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
