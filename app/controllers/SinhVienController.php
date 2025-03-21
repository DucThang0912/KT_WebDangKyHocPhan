<?php
require_once __DIR__ . "/../models/SinhVien.php";
require_once __DIR__ . "/../models/NganhHoc.php";

class SinhVienController {
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        $query = "SELECT sv.*, nh.TenNganh 
                 FROM SinhVien sv 
                 LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        require_once __DIR__ . "/../views/sinhvien/index.php";
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'];
            $hoTen = $_POST['hoTen'];
            $gioiTinh = $_POST['gioiTinh'];
            $ngaySinh = $_POST['ngaySinh'];
            $maNganh = $_POST['maNganh'];
            
            $hinh = '';
            if(isset($_FILES['hinh']) && $_FILES['hinh']['error'] === 0) {
                $hinh = 'public/images/' . $_FILES['hinh']['name'];
                $targetPath = dirname(dirname(__DIR__)) . '/public/images/' . $_FILES['hinh']['name'];
                move_uploaded_file($_FILES['hinh']['tmp_name'], $targetPath);
            }

            $query = "INSERT INTO SinhVien(MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                     VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh]);

            header("Location: index.php?controller=sinhvien&action=index");
            exit();
        }

        $queryNganh = "SELECT * FROM NganhHoc";
        $stmtNganh = $this->db->prepare($queryNganh);
        $stmtNganh->execute();
        
        require_once __DIR__ . "/../views/sinhvien/create.php";
    }

    public function edit() {
        $maSV = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hoTen = $_POST['hoTen'];
            $gioiTinh = $_POST['gioiTinh'];
            $ngaySinh = $_POST['ngaySinh'];
            $maNganh = $_POST['maNganh'];
            
            $hinh = $_POST['hinh_cu'];
            if(isset($_FILES['hinh']) && $_FILES['hinh']['error'] === 0) {
                // Delete old image if exists
                if($hinh && file_exists(dirname(dirname(__DIR__)) . '/' . $hinh)) {
                    unlink(dirname(dirname(__DIR__)) . '/' . $hinh);
                }
                
                $hinh = 'public/images/' . $_FILES['hinh']['name'];
                $targetPath = dirname(dirname(__DIR__)) . '/' . $hinh;
                move_uploaded_file($_FILES['hinh']['tmp_name'], $targetPath);
            }

            $query = "UPDATE SinhVien 
                     SET HoTen = ?, GioiTinh = ?, NgaySinh = ?, Hinh = ?, MaNganh = ? 
                     WHERE MaSV = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh, $maSV]);

            header("Location: index.php?controller=sinhvien&action=index");
            exit();
        }

        $query = "SELECT * FROM SinhVien WHERE MaSV = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$maSV]);
        $sinhvien = $stmt->fetch(PDO::FETCH_ASSOC);

        $queryNganh = "SELECT * FROM NganhHoc";
        $stmtNganh = $this->db->prepare($queryNganh);
        $stmtNganh->execute();
        
        require_once __DIR__ . "/../views/sinhvien/edit.php";
    }

    public function confirmDelete() {
        $maSV = $_GET['id'];
        
        $query = "SELECT sv.*, nh.TenNganh 
                 FROM SinhVien sv 
                 LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
                 WHERE sv.MaSV = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$maSV]);
        $sinhvien = $stmt->fetch(PDO::FETCH_ASSOC);
        
        require_once __DIR__ . "/../views/sinhvien/delete.php";
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'];
            
            // Delete the student's image if it exists
            $query = "SELECT Hinh FROM SinhVien WHERE MaSV = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$maSV]);
            $sinhvien = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($sinhvien['Hinh']) {
                $imagePath = dirname(dirname(__DIR__)) . '/' . $sinhvien['Hinh'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            // Delete the student record
            $query = "DELETE FROM SinhVien WHERE MaSV = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$maSV]);

            header("Location: index.php?controller=sinhvien&action=index");
            exit();
        }
    }

    public function detail() {
        $maSV = $_GET['id'];
        
        $query = "SELECT sv.*, nh.TenNganh 
                 FROM SinhVien sv 
                 LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
                 WHERE sv.MaSV = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$maSV]);
        $sinhvien = $stmt->fetch(PDO::FETCH_ASSOC);
        
        require_once __DIR__ . "/../views/sinhvien/detail.php";
    }
}
?>