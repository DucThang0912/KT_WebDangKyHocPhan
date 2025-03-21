<?php
require_once "app/config/database.php";
require_once "app/controllers/SinhVienController.php";
require_once "app/controllers/HocPhanController.php";
require_once "app/controllers/DangKyController.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'SinhVien';

$controllerName = ucfirst($controller) . "Controller";
$controller = new $controllerName();
$controller->$action();
?>