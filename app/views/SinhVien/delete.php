<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Xác nhận xóa sinh viên</h2>
</div>

<div class="card">
    <div class="card-body">
        <div class="alert alert-danger">
            <h5>Bạn có chắc chắn muốn xóa sinh viên này?</h5>
        </div>
        
        <div class="detail-info">
            <div class="row">
                <div class="col-md-8">
                    <p><strong>Mã sinh viên:</strong> <?php echo $sinhvien['MaSV']; ?></p>
                    <p><strong>Họ tên:</strong> <?php echo $sinhvien['HoTen']; ?></p>
                    <p><strong>Giới tính:</strong> <?php echo $sinhvien['GioiTinh']; ?></p>
                    <p><strong>Ngày sinh:</strong> <?php echo date('d/m/Y', strtotime($sinhvien['NgaySinh'])); ?></p>
                    <p><strong>Ngành học:</strong> <?php echo $sinhvien['TenNganh']; ?></p>
                </div>
                <div class="col-md-4">
                    <?php if($sinhvien['Hinh']) { ?>
                        <div class="text-center">
                            <img src="/KT/<?php echo $sinhvien['Hinh']; ?>" class="img-fluid rounded">
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <form method="POST" action="?controller=sinhvien&action=delete">
                <input type="hidden" name="maSV" value="<?php echo $sinhvien['MaSV']; ?>">
                <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                <a href="?controller=sinhvien&action=index" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>