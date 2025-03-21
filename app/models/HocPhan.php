<?php
class HocPhan {
    private $maHP;
    private $tenHP;
    private $soTinChi;

    public function getMaHP() {
        return $this->maHP;
    }

    public function setMaHP($maHP) {
        $this->maHP = $maHP;
    }

    public function getTenHP() {
        return $this->tenHP;
    }

    public function setTenHP($tenHP) {
        $this->tenHP = $tenHP;
    }

    public function getSoTinChi() {
        return $this->soTinChi;
    }

    public function setSoTinChi($soTinChi) {
        $this->soTinChi = $soTinChi;
    }
}
?>