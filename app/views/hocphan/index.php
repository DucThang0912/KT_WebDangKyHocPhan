<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Danh sách học phần</h2>
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
            <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['MaHP']; ?></td>
                <td><?php echo $row['TenHP']; ?></td>
                <td><?php echo $row['SoTinChi']; ?></td>
                <td>
                    <?php if(isset($_SESSION['maSV']) || isset($_COOKIE['student_id'])) { ?>
                        <a href="?controller=dangky&action=registerCourse&maHP=<?php echo $row['MaHP']; ?>" 
                           class="btn btn-success btn-sm">Đăng ký</a>
                    <?php } else { ?>
                        <a href="?controller=auth&action=login" class="btn btn-secondary btn-sm">Đăng nhập để đăng ký</a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>