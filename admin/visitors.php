<?php

include_once('../VisitorController.php');

// 实例化 VisitorController
$visitorManagement = new VisitorController();

// 获取所有访客数据
$visitors = $visitorManagement->getAllVisitors();

?>

<?php include('header.php'); ?>
<html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <h1>Visitors List</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Visitor Name</th>
                <th>Visitor IC</th>
                <th>Visitor Email</th>
                <th>Visitor Phone</th>
                <th>Visit Date</th>
                <th>QR Code Validity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($visitors)): ?>
                <?php foreach ($visitors as $index => $visitor): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($visitor['name']); ?></td>
                        <td><?php echo htmlspecialchars($visitor['IC']); ?></td>
                        <td><?php echo htmlspecialchars($visitor['email']); ?></td>
                        <td><?php echo htmlspecialchars($visitor['phone']); ?></td>
                        <td><?php echo htmlspecialchars($visitor['visit_date']); ?></td>
                        <td><?php echo htmlspecialchars($visitor['valid_days']) . ' days'; ?></td>
                        <td><?php echo htmlspecialchars($visitor['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No visitors found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</html>
<?php include('../footer.php'); ?>
