<?php
require_once __DIR__ . "/../models/DangKy.php";
require_once __DIR__ . "/../models/ChiTietDangKy.php";

class DangKyController {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        $query = "SELECT dk.*, sv.HoTen 
                 FROM DangKy dk 
                 LEFT JOIN SinhVien sv ON dk.MaSV = sv.MaSV";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        require_once __DIR__ . "/../views/dangky/index.php";
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maDK = $_POST['maDK'];
            $ngayDK = $_POST['ngayDK'];
            $maSV = $_POST['maSV'];

            $query = "INSERT INTO DangKy(MaDK, NgayDK, MaSV) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$maDK, $ngayDK, $maSV]);

            header("Location: index.php?controller=dangky&action=index");
            exit();
        }
        
        require_once __DIR__ . "/../views/dangky/create.php";
    }

    public function edit() {
        $maDK = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ngayDK = $_POST['ngayDK'];
            $maSV = $_POST['maSV'];

            $query = "UPDATE DangKy SET NgayDK = ?, MaSV = ? WHERE MaDK = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$ngayDK, $maSV, $maDK]);

            header("Location: index.php?controller=dangky&action=index");
            exit();
        }

        $query = "SELECT * FROM DangKy WHERE MaDK = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$maDK]);
        $dangky = $stmt->fetch(PDO::FETCH_ASSOC);
        
        require_once __DIR__ . "/../views/dangky/edit.php";
    }

    public function delete() {
        $maDK = $_GET['id'];
        
        $query = "DELETE FROM DangKy WHERE MaDK = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$maDK]);

        header("Location: index.php?controller=dangky&action=index");
        exit();
    }

    public function detail() {
        $maDK = $_GET['id'];
        
        $query = "SELECT dk.*, sv.HoTen 
                 FROM DangKy dk 
                 LEFT JOIN SinhVien sv ON dk.MaSV = sv.MaSV 
                 WHERE dk.MaDK = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$maDK]);
        $dangky = $stmt->fetch(PDO::FETCH_ASSOC);
        
        require_once __DIR__ . "/../views/dangky/detail.php";
    }
}
?>