<?php
require_once __DIR__ . "/../models/HocPhan.php";

class HocPhanController {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    private function isAuthenticated() {
        return isset($_SESSION['maSV']) || isset($_COOKIE['student_id']);
    }

    public function index() {
        if (!$this->isAuthenticated()) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        
        $query = "SELECT * FROM HocPhan";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        require_once __DIR__ . "/../views/hocphan/index.php";
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maHP = $_POST['maHP'];
            $tenHP = $_POST['tenHP'];
            $soTinChi = $_POST['soTinChi'];

            $query = "INSERT INTO HocPhan(MaHP, TenHP, SoTinChi) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$maHP, $tenHP, $soTinChi]);

            header("Location: /KT_WebDangKyHocPhan/hocphan/index");
            exit();
        }
        
        require_once __DIR__ . "/../views/hocphan/create.php";
    }

    public function edit() {
        $maHP = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenHP = $_POST['tenHP'];
            $soTinChi = $_POST['soTinChi'];

            $query = "UPDATE HocPhan SET TenHP = ?, SoTinChi = ? WHERE MaHP = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$tenHP, $soTinChi, $maHP]);

            header("Location: index.php?controller=hocphan&action=index");
            exit();
        }

        $query = "SELECT * FROM HocPhan WHERE MaHP = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$maHP]);
        $hocphan = $stmt->fetch(PDO::FETCH_ASSOC);
        
        require_once __DIR__ . "/../views/hocphan/edit.php";
    }

    public function delete() {
        $maHP = $_GET['id'];
        
        $query = "DELETE FROM HocPhan WHERE MaHP = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$maHP]);

        header("Location: index.php?controller=hocphan&action=index");
        exit();
    }

    public function detail() {
        $maHP = $_GET['id'];
        
        $query = "SELECT * FROM HocPhan WHERE MaHP = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$maHP]);
        $hocphan = $stmt->fetch(PDO::FETCH_ASSOC);
        
        require_once __DIR__ . "/../views/hocphan/detail.php";
    }
}
?>