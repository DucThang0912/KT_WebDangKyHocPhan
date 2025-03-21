<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Danh sách học phần đã đăng ký</h2>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <p class="mb-0"><strong>Tổng số môn:</strong> <?php echo $totalCourses; ?></p>
            </div>
            <div class="col-md-4">
                <p class="mb-0"><strong>Tổng số tín chỉ:</strong> <?php echo $totalCredits; ?></p>
            </div>
        </div>
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
            <?php if (!empty($registeredCourses)): ?>
                <?php foreach($registeredCourses as $course): ?>
                <tr>
                    <td><?php echo $course['MaHP']; ?></td>
                    <td><?php echo $course['TenHP']; ?></td>
                    <td><?php echo $course['SoTinChi']; ?></td>
                    <td>
                        <a href="?controller=dangky&action=removeCourse&maHP=<?php echo $course['MaHP']; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa học phần này?')">
                            Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Chưa có học phần nào được đăng ký</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-3">
    <a href="?controller=hocphan&action=index" class="btn btn-primary">Đăng ký thêm học phần</a>
    <?php if (!empty($registeredCourses)): ?>
        <a href="?controller=dangky&action=saveRegistration" class="btn btn-success">Lưu đăng ký học phần</a>
    <?php endif; ?>
</div>

<?php if (isset($success) && $success == 1): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Đăng ký học phần đã được lưu thành công!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($error) && $error == 1): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Có lỗi xảy ra khi lưu đăng ký học phần!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>