<?php
class Menu {
    private $db;

    public function __construct($db_conn) {
        $this->db = $db_conn;
    }

    public function getAllMenu() {
        $query = "SELECT * FROM menu";
        return mysqli_query($this->db, $query);
    }

    public function addMenu($nama, $harga, $kategori, $gambar) {
        $query = "INSERT INTO menu (nama_menu, harga, kategori_menu, gambar, status) 
                  VALUES ('$nama', '$harga', '$kategori', '$gambar', 'tersedia')";
        return mysqli_query($this->db, $query);
    }
}
?>