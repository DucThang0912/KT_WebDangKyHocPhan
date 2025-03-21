<?php
class NganhHoc {
    private $maNganh;
    private $tenNganh;

    public function getMaNganh() {
        return $this->maNganh;
    }

    public function setMaNganh($maNganh) {
        $this->maNganh = $maNganh;
    }

    public function getTenNganh() {
        return $this->tenNganh;
    }

    public function setTenNganh($tenNganh) {
        $this->tenNganh = $tenNganh;
    }
}
?>