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
        if (!isset($_SESSION['maSV']) && !isset($_COOKIE['student_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $maSV = isset($_SESSION['maSV']) ? $_SESSION['maSV'] : $_COOKIE['student_id'];
        $registeredCourses = [];
        $totalCredits = 0;
        $totalCourses = 0;

        if (isset($_COOKIE['registered_courses_' . $maSV])) {
            $registeredCoursesIds = json_decode($_COOKIE['registered_courses_' . $maSV], true);
            
            if (!empty($registeredCoursesIds)) {
                // Get course details from database
                $placeholders = str_repeat('?,', count($registeredCoursesIds) - 1) . '?';
                $query = "SELECT * FROM HocPhan WHERE MaHP IN ($placeholders)";
                $stmt = $this->db->prepare($query);
                $stmt->execute($registeredCoursesIds);
                $registeredCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Calculate totals
                $totalCourses = count($registeredCourses);
                foreach ($registeredCourses as $course) {
                    $totalCredits += $course['SoTinChi'];
                }
            }
        }
        
        $success = isset($_GET['success']) ? $_GET['success'] : null;
        $error = isset($_GET['error']) ? $_GET['error'] : null;
        
        require_once __DIR__ . "/../views/dangky/index.php";
    }

    private function getStudentId() {
        if (isset($_SESSION['maSV'])) {
            return $_SESSION['maSV'];
        } else if (isset($_COOKIE['student_id'])) {
            return $_COOKIE['student_id'];
        }
        return null;
    }

    public function registerCourse() {
        $maSV = $this->getStudentId();
        if (!$maSV) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $maHP = $_GET['maHP'];

        // Get existing registered courses
        $registeredCourses = isset($_COOKIE['registered_courses_' . $maSV]) 
            ? json_decode($_COOKIE['registered_courses_' . $maSV], true) 
            : [];

        // Check if course is already registered
        if (!in_array($maHP, $registeredCourses)) {
            $registeredCourses[] = $maHP;
            setcookie(
                'registered_courses_' . $maSV, 
                json_encode($registeredCourses), 
                time() + (86400 * 30), // 30 days
                '/'
            );
        }

        header("Location: index.php?controller=hocphan&action=index");
        exit();
    }

    public function removeCourse() {
        if (!isset($_SESSION['maSV'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $maHP = $_GET['maHP'];
        $maSV = $_SESSION['maSV'];

        if (isset($_COOKIE['registered_courses_' . $maSV])) {
            $registeredCourses = json_decode($_COOKIE['registered_courses_' . $maSV], true);
            
            // Remove the course
            $registeredCourses = array_diff($registeredCourses, [$maHP]);
            
            setcookie(
                'registered_courses_' . $maSV, 
                json_encode(array_values($registeredCourses)), 
                time() + (86400 * 30), 
                '/'
            );
        }

        header("Location: index.php?controller=dangky&action=index");
        exit();
    }

    public function saveRegistration() {
        $maSV = $this->getStudentId();
        if (!$maSV) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        if (isset($_COOKIE['registered_courses_' . $maSV])) {
            $registeredCourses = json_decode($_COOKIE['registered_courses_' . $maSV], true);
            
            if (!empty($registeredCourses)) {
                try {
                    $this->db->beginTransaction();

                    // Insert into DangKy table
                    $queryDangKy = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (NOW(), ?)";
                    $stmtDangKy = $this->db->prepare($queryDangKy);
                    $stmtDangKy->execute([$maSV]);
                    
                    $maDK = $this->db->lastInsertId();

                    // Insert into ChiTietDangKy table
                    $queryChiTiet = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)";
                    $stmtChiTiet = $this->db->prepare($queryChiTiet);
                    
                    foreach ($registeredCourses as $maHP) {
                        $stmtChiTiet->execute([$maDK, $maHP]);
                    }

                    $this->db->commit();

                    // Clear the cookie after successful save
                    setcookie('registered_courses_' . $maSV, '', time() - 3600, '/');

                    // Redirect with success message
                    header("Location: index.php?controller=dangky&action=index&success=1");
                    exit();

                } catch (Exception $e) {
                    $this->db->rollBack();
                    // Redirect with error message
                    header("Location: index.php?controller=dangky&action=index&error=1");
                    exit();
                }
            }
        }

        header("Location: index.php?controller=dangky&action=index");
        exit();
    }
}
?>