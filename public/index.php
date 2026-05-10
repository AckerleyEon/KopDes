<?php
/**
 * FRONT CONTROLLER - Kopi Desa
 * Semua request (Halaman) melewati file ini terlebih dahulu.
 */

// 1. Pengaturan Error Reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Mulai Session
session_start();

// --- UPDATE TERBARU: TANGKAP NOMOR MEJA DARI URL SCAN QR ---
if (isset($_GET['table'])) {
    if (isset($_SESSION['no_meja']) && $_SESSION['no_meja'] !== $_GET['table']) {
        unset($_SESSION['keranjang']);
        unset($_SESSION['keranjang_last']);
        unset($_SESSION['last_order_id']);
    }
    $_SESSION['no_meja'] = $_GET['table'];
}
// ----------------------------------------------------------

// 3. Load Koneksi Database & Controller
require_once '../config/koneksi.php';
require_once '../app/controllers/MenuController.php';
require_once '../app/controllers/AdminController.php';
require_once '../app/controllers/PesananController.php';

// 4. Inisialisasi Controller
$menuCtrl    = new MenuController($conn);
$adminCtrl   = new AdminController($conn);
$pesananCtrl = new PesananController($conn);

// 5. Tangkap Parameter Halaman (Default: home)
$page = $_GET['page'] ?? 'home';
$controller = new AdminController($conn);

// 6. LOGIKA KERANJANG BELANJA (LOGIC ONLY)

// Tambah ke keranjang dari halaman Menu
if ($page == 'add_to_cart') {
    // Handle both GET (compatibility) dan POST (AJAX)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
        
        header('Content-Type: application/json');
    } else {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;
    }

    // minimal qty = 1
    if ($qty < 1) {
        $qty = 1;
    }

    // Reset status pesanan terakhir saat mulai memesan lagi
    if (isset($_SESSION['last_order_id'])) {
        unset($_SESSION['last_order_id']);
        unset($_SESSION['keranjang_last']);
    }

    // buat session keranjang jika belum ada
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // jika menu sudah ada di keranjang
    if (isset($_SESSION['keranjang'][$id])) {
        $_SESSION['keranjang'][$id] += $qty;
    } else {
        $_SESSION['keranjang'][$id] = $qty;
    }

    // Return response
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cart_count = count($_SESSION['keranjang']);
        echo json_encode(['success' => true, 'cart_count' => $cart_count]);
        exit();
    } else {
        echo "
        <script>
            alert('Menu berhasil ditambahkan!');
            window.location='index.php?page=keranjang';
        </script>
        ";
        exit();
    }
}

// Tambah Jumlah (+) di dalam Keranjang
if ($page == 'increase_qty') {
    $id = $_GET['id'];
    if (isset($_SESSION['keranjang'][$id])) {
        $_SESSION['keranjang'][$id]++;
    }
    header("Location: index.php?page=keranjang");
    exit();
}

// Kurangi Jumlah (-) di dalam Keranjang
if ($page == 'decrease_qty') {
    $id = $_GET['id'];
    if (isset($_SESSION['keranjang'][$id])) {
        $_SESSION['keranjang'][$id]--;
        // Jika jumlah jadi 0 atau kurang, hapus item dari keranjang
        if ($_SESSION['keranjang'][$id] <= 0) {
            unset($_SESSION['keranjang'][$id]);
        }
    }
    header("Location: index.php?page=keranjang");
    exit();
}

// Hapus Item (Tong Sampah)
if ($page == 'remove_from_cart') {
    $id = $_GET['id'];
    unset($_SESSION['keranjang'][$id]);
    header("Location: index.php?page=keranjang");
    exit();
}

// 7. ROUTING SYSTEM (DISPLAY PAGES)
switch($page) {
    
    // --------------------------
    //    HALAMAN CUSTOMER
    // --------------------------
    case 'home': 
        $menuCtrl->home(); 
        break;

    case 'admin_riwayat':
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=login");
            exit();
        }

        // pastikan koneksi tersedia
        require_once '../config/koneksi.php';

        include '../app/views/admin/riwayat.php';
        break;

    case 'menu': 
        $menuCtrl->index(); 
        break;

    case 'keranjang': 
        include '../app/views/customer/keranjang.php'; 
        break;

    case 'checkout': 
        include '../app/views/customer/checkout.php'; 
        break;

    case 'proses_checkout': 
        $pesananCtrl->simpanPesanan(); 
        break;

    case 'download_pdf':
        if (isset($_SESSION['pdf_download'])) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . ($_SESSION['pdf_filename'] ?? 'struk_pesanan.pdf') . '"');
            echo $_SESSION['pdf_download'];
            unset($_SESSION['pdf_download']);
            unset($_SESSION['pdf_filename']);
            exit();
        }
        break;

    case 'sukses': 
        include '../app/views/customer/sukses.php'; 
        break;

    case 'hapus_menu':
    $controller->hapusMenu();
    break;

    case 'edit_menu_aksi':
$controller = new AdminController($conn);
$controller->editMenu();
break;


    // --------------------------
    //    HALAMAN ADMIN (PANEL)
    // --------------------------
    case 'login': 
        include '../app/views/admin/login.php'; 
        break;

case 'update_pesanan':
    $adminCtrl->updatePesanan();
    break;
    case 'login_aksi':
        $adminCtrl->prosesLogin(); 
        break;

    case 'dashboard': 
        if (!isset($_SESSION['admin'])) { header("Location: index.php?page=login"); exit(); }
        $adminCtrl->dashboard(); 
        break;

    case 'admin_menu': 
        if (!isset($_SESSION['admin'])) { header("Location: index.php?page=login"); exit(); }
        $menuCtrl->adminMenu(); 
        break;

case 'tambah_menu_aksi': 
    if (!isset($_SESSION['admin'])) { 
        header("Location: index.php?page=login"); 
        exit(); 
    }

    $adminCtrl->tambahMenu(); 
    break;

    case 'edit_menu_aksi':
        if (!isset($_SESSION['admin'])) { header("Location: index.php?page=login"); exit(); }
        $menuCtrl->editMenu();
        break;

    case 'admin_pesanan':
        if (!isset($_SESSION['admin'])) { header("Location: index.php?page=login"); exit(); }
        $adminCtrl->listPesanan();
        break;

    case 'export_excel':
        if (!isset($_SESSION['admin'])) { header("Location: index.php?page=login"); exit(); }
        $adminCtrl->exportExcel();
        break;

    case 'logout': 
        // Update Logout agar menghapus session admin saja, bukan nomor meja
        unset($_SESSION['admin']);
        header("Location: index.php?page=login");
        break;

    // Jika halaman tidak ada, kembali ke Beranda
    default: 
        $menuCtrl->home(); 
        break;
}