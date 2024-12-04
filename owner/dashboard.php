<?php
include_once('../db.php');
include_once('header.php');
include_once('../VisitorController.php');

if (!isset($_SESSION['owner_id'])) {
    echo "Owner ID is not set. Please log in.";
    exit;
}

$owner_id = $_SESSION['owner_id'];

// 创建 VisitorController 对象
$Visitor = new VisitorController();

// 调用 getVisitors 方法获取访客信息
$result = $Visitor->getVisitors($owner_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Visitors</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css"> <!-- 确保引入正确的 CSS 文件 -->
</head>
<body>
<main class="container my-5">
        <h2 class="text-center mb-4">Your Visitors</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Visitor Name</th>
                        <th>Visit Date</th>
                        <th>QR Code</th>
                        <th colspan=2>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['visit_date']); ?></td>
                                <td>
                                    <a href="view_qrcode.php?visitor_id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-primary btn-sm">
                                        View QR Code
                                    </a>
                                </td><td>
                                    <a href="update_visitor_date.php?visitor_id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-primary btn-sm">
                                        Change Visit Date
                                    </a>
                                </td>
                                <!-- 可以根据需求添加更多数据 -->
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No visitors found for this owner.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>

<?php 
include_once('../footer.php'); 
?>
