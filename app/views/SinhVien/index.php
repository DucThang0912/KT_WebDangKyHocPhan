<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Danh sách sinh viên</h2>
    <a href="http://localhost/KT_WebDangKyHocPhan/index.php?controller=sinhvien&action=create" class="btn btn-primary">Thêm mới</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Mã SV</th>
                <th>Họ tên</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Ngành học</th>
                <th>Hình</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['MaSV']; ?></td>
                <td><?php echo $row['HoTen']; ?></td>
                <td><?php echo $row['GioiTinh']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['NgaySinh'])); ?></td>
                <td><?php echo $row['TenNganh']; ?></td>
                <td>
                    <?php if($row['Hinh']) { ?>
                        <img src="/KT_WebDangKyHocPhan/<?php echo $row['Hinh']; ?>" class="img-thumbnail" width="80">
                    <?php } ?>
                </td>
                <td>
                    <a href="http://localhost/KT_WebDangKyHocPhan/index.php?controller=sinhvien&action=detail&id=<?php echo $row['MaSV']; ?>" class="btn btn-info btn-sm">Chi tiết</a>
                    <a href="http://localhost/KT_WebDangKyHocPhan/index.php?controller=sinhvien&action=edit&id=<?php echo $row['MaSV']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="http://localhost/KT_WebDangKyHocPhan/index.php?controller=sinhvien&action=confirmDelete&id=<?php echo $row['MaSV']; ?>" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>