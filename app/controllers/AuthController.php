<?php
class AuthController {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'];
            
            $query = "SELECT MaSV, HoTen FROM SinhVien WHERE MaSV = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$maSV]);
            
            if ($stmt->rowCount() > 0) {
                $student = $stmt->fetch(PDO::FETCH_ASSOC);
                session_start();
                $_SESSION['maSV'] = $student['MaSV'];
                $_SESSION['hoTen'] = $student['HoTen'];
                header("Location: index.php?controller=sinhvien&action=index");
                exit();
            } else {
                $error = "Mã số sinh viên không tồn tại";
            }
        }
        
        require_once __DIR__ . "/../views/auth/login.php";
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit();
    }
}
?>