<?php
require_once __DIR__ . '/includes/header.php';

$db = getDB();

// Statistics Counters
$totalProducts = 0;
$totalProjects = 0;
$totalInquiries = 0;
$pendingInquiries = 0;
$recentInquiries = [];

try {
    $totalProducts = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $totalProjects = $db->query("SELECT COUNT(*) FROM projects")->fetchColumn();
    $totalInquiries = $db->query("SELECT COUNT(*) FROM inquiries")->fetchColumn();
    $pendingInquiries = $db->query("SELECT COUNT(*) FROM inquiries WHERE status = 'Pending'")->fetchColumn();

    $stmt = $db->query("SELECT * FROM inquiries ORDER BY id DESC LIMIT 5");
    $recentInquiries = $stmt->fetchAll();
} catch (Exception $e) {}
?>

<div class="row g-4 mb-4">
    <!-- Stat 1: Total Products -->
    <div class="col-md-3">
        <div class="admin-stat-card border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Products</h6>
                    <h2 class="font-weight-bold mb-0 text-dark"><?php echo $totalProducts; ?></h2>
                </div>
                <div class="p-3 bg-success bg-opacity-10 text-success rounded-circle">
                    <i class="fa-solid fa-solar-panel fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 2: Projects Gallery -->
    <div class="col-md-3">
        <div class="admin-stat-card border-start border-4 border-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Projects Completed</h6>
                    <h2 class="font-weight-bold mb-0 text-dark"><?php echo $totalProjects; ?></h2>
                </div>
                <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-circle">
                    <i class="fa-solid fa-images fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 3: Total Inquiries -->
    <div class="col-md-3">
        <div class="admin-stat-card border-start border-4 border-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Inquiries</h6>
                    <h2 class="font-weight-bold mb-0 text-dark"><?php echo $totalInquiries; ?></h2>
                </div>
                <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-circle">
                    <i class="fa-solid fa-envelope fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 4: Pending Action -->
    <div class="col-md-3">
        <div class="admin-stat-card border-start border-4 border-danger">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Pending Surveys</h6>
                    <h2 class="font-weight-bold mb-0 text-danger"><?php echo $pendingInquiries; ?></h2>
                </div>
                <div class="p-3 bg-danger bg-opacity-10 text-danger rounded-circle">
                    <i class="fa-solid fa-clock fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Inquiries Table -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white p-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="font-weight-bold text-dark mb-0"><i class="fa-solid fa-envelope-open-text me-2 text-success"></i> Recent Customer Inquiries</h5>
        <a href="<?php echo SITE_URL; ?>/admin/inquiries.php" class="btn btn-sm btn-solar-primary">View All Inquiries</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Customer Name</th>
                        <th>Mobile Phone</th>
                        <th>City</th>
                        <th>System Type</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recentInquiries)): ?>
                        <?php foreach ($recentInquiries as $inq): ?>
                            <tr>
                                <td>#<?php echo $inq['id']; ?></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($inq['type']); ?></span></td>
                                <td><strong><?php echo htmlspecialchars($inq['name']); ?></strong></td>
                                <td><a href="tel:<?php echo $inq['phone']; ?>"><?php echo htmlspecialchars($inq['phone']); ?></a></td>
                                <td><?php echo htmlspecialchars($inq['city']); ?></td>
                                <td><?php echo htmlspecialchars($inq['system_type']); ?></td>
                                <td>
                                    <?php if ($inq['status'] === 'Pending'): ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php elseif ($inq['status'] === 'Contacted'): ?>
                                        <span class="badge bg-info text-white">Contacted</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Resolved</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d M Y, h:i A', strtotime($inq['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No inquiries logged yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
