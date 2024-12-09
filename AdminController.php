<?php
include_once 'db.php';

class AdminController {
    private $conn;

    public function __construct() {
        $db = new Database();  // 创建 Database 实例
        $this->conn = $db->getConnection();  // 获取连接
    }

    public function login($username, $password) {
        $query = $this->conn->prepare("SELECT * FROM admins WHERE username = ?");
        $query->bind_param("s", $username);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // 使用 password_verify 来验证哈希密码
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                // 密码验证成功
                return true;
            } else {
                // 密码错误
                return false;
            }
        } else {
            // 用户名不存在
            return false;
        }
    }

    // 例如注册或更新时使用 password_hash 来保存密码
    public function register($username, $password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query = $this->conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        $query->bind_param("ss", $username, $hashed_password);
        return $query->execute();
    }

    public function ApplyVisitor($name, $IC, $email, $phone, $visitor_code, $visit_date, $status, $valid_days) {
        // 设置二维码过期日期
        $expiration_time = strtotime($visit_date . ' +' . $valid_days . ' days');
    
        // QR Code 数据信息
        $qr_data = json_encode([
            "visitor_code" => $visitor_code
        ]);
    
        // 创建 QR Code
        $qrCode = new QrCode(
            data: $qr_data,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );
    
        $writer = new PngWriter();
        $filePath = '../qrcodes/' . $visitor_code . '.png';
    
        // 保存 QR Code 到文件
        $result = $writer->write($qrCode);
        $result->saveToFile($filePath);
    
        // 检查是否已存在该 visitor_code
        $stmt = $this->conn->prepare("SELECT * FROM visitors WHERE visitor_code = ?");
        $stmt->bind_param("s", $visitor_code);
        $stmt->execute();
        $result = $stmt->get_result(); // 获取完整结果集
        $stmt->close();
    
        if ($result->num_rows > 0) {
            echo "Error: Visitor code already exists.";
            return false;
        } else {
            // 插入访客数据
            $stmt = $this->conn->prepare("INSERT INTO visitors (name, IC, email, phone, visitor_code, qr_code, visit_date, status, valid_days) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $name, $IC, $email, $phone, $visitor_code, $filePath, $visit_date, $status, $valid_days);
            $stmt->execute();
    
            // 获取插入的访客 ID
            $visitor_id = $stmt->insert_id;
            $stmt->close();
    
            // 插入 QR Code 数据到 qr_codes 表
            $stmt = $this->conn->prepare("INSERT INTO qr_codes (visitor_id, qr_code, generated_at, expires_at) VALUES (?, ?, ?, ?)");
            $generated_at = date('Y-m-d H:i:s');
            $expires_at = date('Y-m-d H:i:s', $expiration_time);
            $stmt->bind_param("isss", $visitor_id, $visitor_code, $generated_at, $expires_at);
            $stmt->execute();
            $stmt->close();
    
            // 发送电子邮件包含 QR Code（可选）
            // $this->sendEmailWithQRCode($email, $name, $filePath);
    
            return true;
        }
    }
    

}
