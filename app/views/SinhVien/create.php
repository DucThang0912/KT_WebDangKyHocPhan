<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Thêm sinh viên mới</h2>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label>Mã sinh viên:</label>
                <input type="text" name="maSV" required class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Họ tên:</label>
                <input type="text" name="hoTen" required class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Giới tính:</label>
                <select name="gioiTinh" required class="form-control">
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label>Ngày sinh:</label>
                <input type="date" name="ngaySinh" required class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Hình ảnh:</label>
                <input type="file" name="hinh" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Ngành học:</label>
                <select name="maNganh" required class="form-control">
                    <?php while($nganh = $stmtNganh->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $nganh['MaNganh']; ?>"><?php echo $nganh['TenNganh']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="/KT" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>