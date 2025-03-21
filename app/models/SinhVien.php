<?php
class SinhVien {
    private $maSV;
    private $hoTen;
    private $gioiTinh;
    private $ngaySinh;
    private $hinh;
    private $maNganh;

    public function getMaSV() {
        return $this->maSV;
    }

    public function setMaSV($maSV) {
        $this->maSV = $maSV;
    }

    public function getHoTen() {
        return $this->hoTen;
    }

    public function setHoTen($hoTen) {
        $this->hoTen = $hoTen;
    }

    public function getGioiTinh() {
        return $this->gioiTinh;
    }

    public function setGioiTinh($gioiTinh) {
        $this->gioiTinh = $gioiTinh;
    }

    public function getNgaySinh() {
        return $this->ngaySinh;
    }

    public function setNgaySinh($ngaySinh) {
        $this->ngaySinh = $ngaySinh;
    }

    public function getHinh() {
        return $this->hinh;
    }

    public function setHinh($hinh) {
        $this->hinh = $hinh;
    }

    public function getMaNganh() {
        return $this->maNganh;
    }

    public function setMaNganh($maNganh) {
        $this->maNganh = $maNganh;
    }
}
?>