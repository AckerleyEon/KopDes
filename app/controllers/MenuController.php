<?php
require_once '../app/models/Menu.php';

class MenuController {
    private $menuModel;
    private $db;

    public function __construct($db_conn) {
        $this->db = $db_conn;
        $this->menuModel = new Menu($db_conn);
    }

    // =========================
    // CUSTOMER
    // =========================

    public function home() {
        require_once '../app/views/customer/home.php';
    }

    public function index() {
        $menus = $this->menuModel->getAllMenu();
        require_once '../app/views/customer/menu.php';
    }

    // =========================
    // ADMIN MENU (FIX UTAMA)
    // =========================
    public function adminMenu() {

        $query = "SELECT * FROM menu ORDER BY id_menu DESC";
        $menus = mysqli_query($this->db, $query);

        if (!$menus) {
            die("Query Error: " . mysqli_error($this->db));
        }

        require_once '../app/views/admin/menu.php';
    }

    // =========================
    // TAMBAH MENU (ADMIN)
    // =========================
public function simpanMenu()
{
    $nama       = $_POST['nama_menu'];
    $harga      = $_POST['harga'];
    $kategori   = $_POST['kategori_menu'];
    $deskripsi  = $_POST['deskripsi'];

    // =========================
    // UPLOAD GAMBAR
    // =========================
    $gambarName = $_FILES['gambar']['name'];
    $tmpName    = $_FILES['gambar']['tmp_name'];

    // folder upload
    $uploadDir = "uploads/";

    // bikin nama unik
    $newName = time() . "_" . $gambarName;

    // path final
    $uploadPath = $uploadDir . $newName;

    // pindahkan file
    move_uploaded_file($tmpName, $uploadPath);

    // =========================
    // SIMPAN KE DATABASE
    // =========================
    $query = "INSERT INTO menu 
              (nama_menu, harga, kategori_menu, deskripsi, gambar)
              VALUES
              ('$nama', '$harga', '$kategori', '$deskripsi', '$uploadPath')";

    mysqli_query($this->db, $query);

    header("Location: index.php?page=admin_menu");
    exit();
}
    // =========================
    // EDIT MENU (ADMIN)
    // =========================
      
}