<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Sửa thông tin sinh viên</h2>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Mã sinh viên:</label>
                <input type="text" value="<?php echo $sinhvien['MaSV']; ?>" readonly class="form-control">
            </div>
            <div class="form-group">
                <label>Họ tên:</label>
                <input type="text" name="hoTen" value="<?php echo $sinhvien['HoTen']; ?>" required class="form-control">
            </div>
            <div class="form-group">
                <label>Giới tính:</label>
                <select name="gioiTinh" class="form-control">
                    <option value="Nam" <?php echo $sinhvien['GioiTinh'] == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                    <option value="Nữ" <?php echo $sinhvien['GioiTinh'] == 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ngày sinh:</label>
                <input type="date" name="ngaySinh" value="<?php echo $sinhvien['NgaySinh']; ?>" required class="form-control">
            </div>
            <div class="form-group">
                <label>Hình:</label>
                <?php if($sinhvien['Hinh']) { ?>
                    <div class="mb-2">
                        <img src="/KT_WebDangKyHocPhan/<?php echo $sinhvien['Hinh']; ?>" class="img-thumbnail" width="100">
                    </div>
                <?php } ?>
                <input type="file" name="hinh" class="form-control">
                <input type="hidden" name="hinh_cu" value="<?php echo $sinhvien['Hinh']; ?>">
            </div>
            <div class="form-group">
                <label>Ngành học:</label>
                <select name="maNganh" required class="form-control">
                    <?php while($nganh = $stmtNganh->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $nganh['MaNganh']; ?>" 
                                <?php echo $sinhvien['MaNganh'] == $nganh['MaNganh'] ? 'selected' : ''; ?>>
                            <?php echo $nganh['TenNganh']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="?controller=sinhvien&action=index" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>