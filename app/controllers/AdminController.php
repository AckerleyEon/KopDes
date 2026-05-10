<?php

class AdminController {
    private $db;

    public function __construct($db_conn) {
        $this->db = $db_conn;
    }

    // 1. FUNGSI PROSES LOGIN (Tetap sama)
    public function prosesLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = mysqli_real_escape_string($this->db, $_POST['username']);
            $pass = mysqli_real_escape_string($this->db, $_POST['password']);

            $query = mysqli_query($this->db, "SELECT * FROM admin WHERE username = '$user' AND password = '$pass'");
            $cek = mysqli_num_rows($query);

            if ($cek > 0) {
                $data = mysqli_fetch_assoc($query);
                $_SESSION['admin'] = $data['username'];
                $_SESSION['id_admin'] = $data['id_admin'];

                echo "<script>alert('Login Berhasil! Selamat Datang.'); window.location='index.php?page=dashboard';</script>";
            } else {
                echo "<script>alert('Username atau Password Salah!'); window.location='index.php?page=login';</script>";
            }
        }
    }

    // 2. TAMPILAN DASHBOARD (DIPERBARUI: Menambah Profit & Sale)
    public function dashboard() {
        // 1. Hitung Total Menu & Ambil List Menu
        $query_menu_count = mysqli_query($this->db, "SELECT COUNT(*) as total FROM menu");
        $total_menu = ($query_menu_count) ? (mysqli_fetch_assoc($query_menu_count)['total'] ?? 0) : 0;

        $menu_list = [];
        $query_menu_list = mysqli_query($this->db, "SELECT nama_menu, kategori_menu, harga, status FROM menu ORDER BY nama_menu ASC");
        if ($query_menu_list) {
            while ($row = mysqli_fetch_assoc($query_menu_list)) {
                $menu_list[] = $row;
            }
        }

        // 2. Hitung Pesanan Menunggu (Ubah nama variabel agar sinkron dengan view)
        $query_pesanan = mysqli_query($this->db, "SELECT COUNT(*) as total FROM pesanan WHERE status = 'menunggu'");
        $total_pending = 0;
        if ($query_pesanan) {
            $result_pesanan = mysqli_fetch_assoc($query_pesanan);
            $total_pending = $result_pesanan ? $result_pesanan['total'] : 0;
        }

        // Ambil daftar pesanan menunggu beserta detail item
        $pending_orders = [];
        $query_pending_orders = mysqli_query($this->db, "SELECT p.id_pesanan, p.no_meja, p.total_harga, p.tanggal, p.status,
            GROUP_CONCAT(CONCAT(m.nama_menu, '|', pd.jumlah, '|', pd.harga, '|', pd.subtotal) SEPARATOR '||') AS items
            FROM pesanan p
            LEFT JOIN pesanan_detail pd ON p.id_pesanan = pd.id_pesanan
            LEFT JOIN menu m ON pd.id_menu = m.id_menu
            WHERE p.status IN ('menunggu', 'terkonfirmasi', 'dibatalkan')
            GROUP BY p.id_pesanan, p.no_meja, p.total_harga, p.tanggal
            ORDER BY
            CASE
                WHEN p.status = 'menunggu' THEN 1
                WHEN p.status = 'terkonfirmasi' THEN 2
                WHEN p.status = 'dibatalkan' THEN 3
                ELSE 4
            END,
            p.id_pesanan DESC");
                    if ($query_pending_orders) {
            while ($row = mysqli_fetch_assoc($query_pending_orders)) {
                $pending_orders[] = $row;
            }
        } else {
            error_log('Pending orders query failed: ' . mysqli_error($this->db));
        }

        // 3. Hitung Profit (Hanya dari pesanan yang sudah 'terkonfirmasi')
        $query_profit = mysqli_query($this->db, "SELECT SUM(total_harga) as total FROM pesanan WHERE status = 'terkonfirmasi'");
        $profit = 0;
        if ($query_profit) {
            $res_profit = mysqli_fetch_assoc($query_profit);
            $profit = $res_profit['total'] ?? 0;
        }

        // 4. Hitung Total Sale (Hanya transaksi yang sudah 'terkonfirmasi')
        $query_sale = mysqli_query($this->db, "SELECT COUNT(*) as total FROM pesanan WHERE status = 'terkonfirmasi'");
        $sale = 0;
        if ($query_sale) {
            $res_sale = mysqli_fetch_assoc($query_sale);
            $sale = $res_sale['total'] ?? 0;
        }

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    // 3. DAFTAR PESANAN MASUK (Tetap sama)
public function listPesanan() {

    global $conn;

$query = "
SELECT 
    p.id_pesanan,
    p.no_meja,
    p.status,
    p.total_harga,
    p.tanggal,

    dp.jumlah,
    dp.harga,
    dp.subtotal,

    m.nama_menu,
    m.harga AS harga_menu

FROM pesanan p

JOIN pesanan_detail dp 
    ON p.id_pesanan = dp.id_pesanan

JOIN menu m 
    ON dp.id_menu = m.id_menu

ORDER BY p.id_pesanan DESC
";

    $all_orders = mysqli_query($this->db, $query);

    if (!$all_orders) {
        die("Query Error: " . mysqli_error($conn));
    }

    include '../app/views/admin/pesanan.php';
}
    // --- TAMBAHAN TERBARU: FUNGSI RIWAYAT ---
    public function riwayat() {
        // Mengambil semua data pesanan yang statusnya sudah 'terkonfirmasi'
        $query = mysqli_query($this->db, "SELECT * FROM pesanan WHERE status = 'terkonfirmasi' ORDER BY tanggal DESC");
        $riwayat = mysqli_fetch_all($query, MYSQLI_ASSOC);
        
        include '../app/views/admin/riwayat.php';
    }
public function updatePesanan()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id_pesanan'] ?? 0;
        $status = $_POST['status'] ?? '';

        $allowed = ['terkonfirmasi', 'dibatalkan'];

        if (in_array($status, $allowed)) {

            mysqli_query(
                $this->db,
                "UPDATE pesanan 
                 SET status='$status' 
                 WHERE id_pesanan='$id'"
            );
        }

        // 🔥 FIX INI: kembali ke halaman sebelumnya
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/KopiDesa/public/index.php?page=dashboard';

        header("Location: $redirect");
        exit;
    }
}

    public function hapusMenu(){

    $id = $_GET['id'];

    $query = mysqli_query($this->db,
        "DELETE FROM menu WHERE id_menu = '$id'");

    header("Location: index.php?page=admin_menu");
    exit;
}

public function tambahMenu(){

    $nama       = mysqli_real_escape_string($this->db, $_POST['nama']);
    $kategori   = mysqli_real_escape_string($this->db, $_POST['kategori']);
    $harga      = mysqli_real_escape_string($this->db, $_POST['harga']);
    $deskripsi  = mysqli_real_escape_string($this->db, $_POST['deskripsi']);

    $gambar = '';

    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0){

        $fileTmp  = $_FILES['gambar']['tmp_name'];
        $fileName = $_FILES['gambar']['name'];

        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // nama file baru
        $newName = strtolower($nama);
        $newName = preg_replace('/[^a-z0-9]+/i', '-', $newName);
        $newName = trim($newName, '-');

        $gambar = $newName . '-' . time() . '.' . $ext;

        // PATH YANG BENAR
        $uploadDir = __DIR__ . '/../../public/assets/uploads/';

        // buat folder jika belum ada
        if(!is_dir($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }

        // upload file
        $upload = move_uploaded_file(
            $fileTmp,
            $uploadDir . $gambar
        );

        // kalau gagal upload
        if(!$upload){
            die("Upload gambar gagal");
        }
    }

$query = "INSERT INTO menu
        (nama_menu, kategori_menu, harga, deskripsi, gambar, status)
        VALUES
        ('$nama', '$kategori', '$harga', '$deskripsi', '$gambar', 'tersedia')";

    $insert = mysqli_query($this->db, $query);

    if(!$insert){
        die(mysqli_error($this->db));
    }

    header("Location: index.php?page=admin_menu");
    exit;
}
    // 5. EXPORT EXCEL
    public function exportExcel() {
        // Hitung Profit & Sale (Hanya dari pesanan yang sudah 'terkonfirmasi')
        $query_profit = mysqli_query($this->db, "SELECT SUM(total_harga) as total FROM pesanan WHERE status = 'terkonfirmasi'");
        $profit = ($query_profit) ? (mysqli_fetch_assoc($query_profit)['total'] ?? 0) : 0;

        $query_sale = mysqli_query($this->db, "SELECT COUNT(*) as total FROM pesanan WHERE status = 'terkonfirmasi'");
        $sale = ($query_sale) ? (mysqli_fetch_assoc($query_sale)['total'] ?? 0) : 0;

        // Ambil Data Pesanan Terkonfirmasi dan Dibatalkan beserta Detailnya
        $query_pesanan = mysqli_query($this->db, "SELECT p.id_pesanan, p.tanggal, p.total_harga, p.no_meja, p.status,
            GROUP_CONCAT(CONCAT(m.nama_menu, ' (x', pd.jumlah, ')') SEPARATOR ', ') AS detail_menu
            FROM pesanan p
            LEFT JOIN pesanan_detail pd ON p.id_pesanan = pd.id_pesanan
            LEFT JOIN menu m ON pd.id_menu = m.id_menu
            WHERE p.status IN ('terkonfirmasi', 'dibatalkan')
            GROUP BY p.id_pesanan, p.no_meja, p.total_harga, p.tanggal, p.status
            ORDER BY p.tanggal DESC");

        $filename = "Laporan_Penjualan_KopiDesa_" . date('Y-m-d') . ".xls";

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "<table border='1'>";
        
        // Header Laporan
        echo "<tr><th colspan='6' style='font-size:20px;text-align:center;'>LAPORAN PENJUALAN KOPI DESA</th></tr>";
        echo "<tr><th colspan='6' style='text-align:center;'>Tanggal Cetak: " . date('d-m-Y H:i') . "</th></tr>";
        echo "<tr><td colspan='6'></td></tr>";

        // Summary
        echo "<tr><td colspan='2'><b>Total Profit</b></td><td colspan='4'>Rp " . number_format($profit, 0, ',', '.') . "</td></tr>";
        echo "<tr><td colspan='2'><b>Total Transaksi (Terkonfirmasi)</b></td><td colspan='4'>" . $sale . " Transaksi</td></tr>";
        echo "<tr><td colspan='6'></td></tr>";

        // Tabel Data
        echo "<tr>";
        echo "<th>ID Pesanan</th>";
        echo "<th>Tanggal</th>";
        echo "<th>No Meja</th>";
        echo "<th>Detail Menu</th>";
        echo "<th>Total Harga</th>";
        echo "<th>Status</th>";
        echo "</tr>";

        if ($query_pesanan && mysqli_num_rows($query_pesanan) > 0) {
            while ($row = mysqli_fetch_assoc($query_pesanan)) {
                $status_color = ($row['status'] == 'terkonfirmasi') ? "color:green;" : "color:red;";
                echo "<tr>";
                echo "<td align='center'>#" . $row['id_pesanan'] . "</td>";
                echo "<td>" . $row['tanggal'] . "</td>";
                echo "<td align='center'>" . $row['no_meja'] . "</td>";
                echo "<td>" . $row['detail_menu'] . "</td>";
                echo "<td align='right'>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
                echo "<td align='center' style='$status_color'><b>" . strtoupper($row['status']) . "</b></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' align='center'>Tidak ada data pesanan.</td></tr>";
        }

        echo "</table>";
        exit();
    }

     public function editMenu(){

    $id         = $_POST['id_menu'];
    $nama       = mysqli_real_escape_string($this->db, $_POST['nama']);
    $kategori   = mysqli_real_escape_string($this->db, $_POST['kategori']);
    $harga      = mysqli_real_escape_string($this->db, $_POST['harga']);
    $deskripsi  = mysqli_real_escape_string($this->db, $_POST['deskripsi']);
    $status     = mysqli_real_escape_string($this->db, $_POST['status']);

    $gambar = $_POST['gambar_lama'];

    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0){

        // hapus gambar lama
        $oldPath = __DIR__ . '/../../public/assets/uploads/' . $gambar;

        if(file_exists($oldPath)){
            unlink($oldPath);
        }

        $fileTmp  = $_FILES['gambar']['tmp_name'];
        $fileName = $_FILES['gambar']['name'];

        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // rename file
        $newName = strtolower($nama);
        $newName = preg_replace('/[^a-z0-9]+/i', '-', $newName);
        $newName = trim($newName, '-');

        $gambar = $newName . '-' . time() . '.' . $ext;

        $uploadDir = __DIR__ . '/../../public/assets/uploads/';

        if(!is_dir($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }

        move_uploaded_file(
            $fileTmp,
            $uploadDir . $gambar
        );
    }

$query = "UPDATE menu SET
            nama_menu      = '$nama',
            kategori_menu  = '$kategori',
            harga          = '$harga',
            deskripsi      = '$deskripsi',
            status         = '$status',
            gambar         = '$gambar'
        WHERE id_menu = '$id'";

    mysqli_query($this->db, $query);

    header("Location: index.php?page=admin_menu");
    exit;
}
 
}