<?php
require_once __DIR__ . '/includes/header.php';

$db = getDB();

// Update status or delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? sanitize($_POST['action']) : '';
    $id = (int)$_POST['id'];

    if ($action === 'update_status') {
        $status = sanitize($_POST['status']);
        try {
            $stmt = $db->prepare("UPDATE inquiries SET status = :status WHERE id = :id");
            $stmt->execute([':status' => $status, ':id' => $id]);
            set_flash('success', 'Inquiry status updated to ' . $status);
        } catch (Exception $e) {
            set_flash('danger', 'Error: ' . $e->getMessage());
        }
    } elseif ($action === 'delete') {
        try {
            $stmt = $db->prepare("DELETE FROM inquiries WHERE id = :id");
            $stmt->execute([':id' => $id]);
            set_flash('success', 'Inquiry record deleted.');
        } catch (Exception $e) {
            set_flash('danger', 'Error: ' . $e->getMessage());
        }
    }
}

$inquiries = $db->query("SELECT * FROM inquiries ORDER BY id DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold mb-0">Customer Inquiries &amp; Free Site Survey Bookings</h4>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Inquiry Type</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Location &amp; Bill</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($inquiries)): ?>
                        <?php foreach ($inquiries as $inq): ?>
                            <tr>
                                <td>#<?php echo $inq['id']; ?></td>
                                <td><span class="badge bg-dark"><?php echo htmlspecialchars($inq['type']); ?></span></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($inq['name']); ?></strong>
                                    <?php if ($inq['system_type']): ?>
                                        <div class="small text-muted"><?php echo htmlspecialchars($inq['system_type']); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div><i class="fa-solid fa-phone text-success me-1"></i> <a href="tel:<?php echo $inq['phone']; ?>"><?php echo htmlspecialchars($inq['phone']); ?></a></div>
                                    <?php if ($inq['email']): ?>
                                        <div class="small text-muted"><i class="fa-solid fa-envelope me-1"></i> <?php echo htmlspecialchars($inq['email']); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div><i class="fa-solid fa-location-dot text-danger me-1"></i> <?php echo htmlspecialchars($inq['city']); ?></div>
                                    <?php if ($inq['monthly_bill']): ?>
                                        <small class="text-success font-weight-semibold">Bill: <?php echo htmlspecialchars($inq['monthly_bill']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><small><?php echo htmlspecialchars($inq['message']); ?></small></td>
                                <td>
                                    <form action="" method="POST" class="d-inline">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="id" value="<?php echo $inq['id']; ?>">
                                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="Pending" <?php echo $inq['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Contacted" <?php echo $inq['status'] === 'Contacted' ? 'selected' : ''; ?>>Contacted</option>
                                            <option value="Resolved" <?php echo $inq['status'] === 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <form action="" method="POST" class="d-inline" onsubmit="return confirm('Delete this record?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $inq['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No inquiries received yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
