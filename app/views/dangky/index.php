<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Danh sách học phần đã đăng ký</h2>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5>Thống kê</h5>
        <p>Số môn đã đăng ký: <?php echo count($registeredCourses); ?></p>
        <p>Tổng số tín chỉ: <?php echo $totalCredits; ?></p>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Mã HP</th>
                <th>Tên học phần</th>
                <th>Số tín chỉ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($registeredCourses as $course) { ?>
            <tr>
                <td><?php echo $course['MaHP']; ?></td>
                <td><?php echo $course['TenHP']; ?></td>
                <td><?php echo $course['SoTinChi']; ?></td>
                <td>
                    <a href="?controller=dangky&action=removeCourse&maHP=<?php echo $course['MaHP']; ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Bạn có chắc muốn xóa học phần này?')">
                        Xóa
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>