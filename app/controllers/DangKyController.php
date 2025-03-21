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
        if (!isset($_SESSION['maSV'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        $maSV = $_SESSION['maSV'];
        $registeredCourses = [];
        $totalCredits = 0;

        if (isset($_COOKIE['registered_courses_' . $maSV])) {
            $registeredCourses = json_decode($_COOKIE['registered_courses_' . $maSV], true);
            
            // Get course details from database
            $placeholders = str_repeat('?,', count($registeredCourses) - 1) . '?';
            $query = "SELECT * FROM HocPhan WHERE MaHP IN ($placeholders)";
            $stmt = $this->db->prepare($query);
            $stmt->execute($registeredCourses);
            $registeredCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Calculate total credits
            foreach ($registeredCourses as $course) {
                $totalCredits += $course['SoTinChi'];
            }
        }
        
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
}
?>