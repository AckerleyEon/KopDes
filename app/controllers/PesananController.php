<?php
class PesananController {
    private $db;

    public function __construct($db_conn) {
        $this->db = $db_conn;
    }

    private function formatRupiah($value) {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }

    private function generateReceiptPdf($orderId, $no_meja, $summary, $total_harga) {
        $date = date('d-m-Y H:i');
        
        // Build text content for PDF
        $text = "KOPI DESA\n";
        $text .= "STRUK PESANAN\n";
        $text .= "\n";
        $text .= "Order ID   : #" . $orderId . "\n";
        $text .= "Meja       : " . $no_meja . "\n";
        $text .= "Tanggal    : " . $date . "\n";
        $text .= "\n";
        $text .= "================================================\n";
        
        foreach ($summary as $item) {
            $text .= $item['nama'] . "\n";
            $text .= "  Qty: " . $item['jumlah'] . " x " . $this->formatRupiah($item['harga']) . "\n";
            $text .= "  Subtotal: " . $this->formatRupiah($item['subtotal']) . "\n";
        }
        
        $text .= "================================================\n";
        $text .= "TOTAL: " . $this->formatRupiah($total_harga) . "\n";
        $text .= "================================================\n";
        $text .= "\n";
        $text .= "Terima kasih atas pesanan Anda.\n";
        $text .= "Silakan tunjukkan struk ini kepada kasir.\n";
        
        // Build PDF with text stream
        $lines = explode("\n", $text);
        
        // Create stream with proper text positioning
        $stream = "";
        $yPosition = 750;
        
        foreach ($lines as $line) {
            $escapedLine = $this->escapePdfString($line);
            $stream .= "BT\n";
            $stream .= "/F1 11 Tf\n";
            $stream .= "50 " . $yPosition . " Td\n";
            $stream .= "(" . $escapedLine . ") Tj\n";
            $stream .= "ET\n";
            $yPosition -= 15;
        }
        
        // PDF objects
        $objects = [];
        $objects[] = "1 0 obj\n<</Type/Catalog/Pages 2 0 R>>\nendobj\n";
        $objects[] = "2 0 obj\n<</Type/Pages/Kids[3 0 R]/Count 1>>\nendobj\n";
        $objects[] = "3 0 obj\n<</Type/Page/Parent 2 0 R/MediaBox[0 0 595 842]/Resources<</Font<</F1 4 0 R>>>>/Contents 5 0 R>>\nendobj\n";
        $objects[] = "4 0 obj\n<</Type/Font/Subtype/Type1/BaseFont/Courier>>\nendobj\n";
        $objects[] = "5 0 obj\n<</Length " . strlen($stream) . ">>\nstream\n" . $stream . "\nendstream\nendobj\n";
        
        // Build PDF
        $pdf = "%PDF-1.4\n";
        $offsets = array(strlen($pdf));
        
        foreach ($objects as $obj) {
            $pdf .= $obj;
            $offsets[] = strlen($pdf);
        }
        
        // Xref
        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n";
        $pdf .= "0 " . (count($offsets)) . "\n";
        $pdf .= "0000000000 65535 f \n";
        
        for ($i = 0; $i < count($objects); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }
        
        // Trailer
        $pdf .= "trailer\n";
        $pdf .= "<</Size " . (count($offsets) + 1) . "/Root 1 0 R>>\n";
        $pdf .= "startxref\n";
        $pdf .= $xrefOffset . "\n";
        $pdf .= "%%EOF";
        
        return $pdf;
    }

    private function downloadReceiptPdf($orderId, $no_meja, $summary, $total_harga) {
        $pdf = $this->generateReceiptPdf($orderId, $no_meja, $summary, $total_harga);
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="struk_pesanan_' . $orderId . '_' . date('Ymd_His') . '.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        echo $pdf;
        exit();
    }

    private function escapePdfString($str) {
        $str = str_replace('\\', '\\\\', $str);
        $str = str_replace('(', '\\(', $str);
        $str = str_replace(')', '\\)', $str);
        return $str;
    }

    public function simpanPesanan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_SESSION['keranjang'])) {
                echo "<script>alert('Keranjang kosong. Tambahkan menu terlebih dahulu.'); window.location='index.php?page=keranjang';</script>";
                exit();
            }

            $no_meja = $_POST['no_meja']; // Menangkap no_meja dari input hidden
            $total_harga = 0;
            $items = [];
            $summary = []; // Simpan ringkasan pesanan terakhir

            // Hitung total harga dan buat snapshot summary
            foreach ($_SESSION['keranjang'] as $id => $jumlah) {
                $query = mysqli_query($this->db, "SELECT * FROM menu WHERE id_menu = $id");
                $menu = mysqli_fetch_assoc($query);
                $subtotal = $menu['harga'] * $jumlah;
                $total_harga += $subtotal;
                
                $items[] = [
                    'id_menu' => $id,
                    'harga'   => $menu['harga'],
                    'jumlah'  => $jumlah,
                    'subtotal'=> $subtotal
                ];

                $summary[$id] = [
                    'nama'     => $menu['nama_menu'],
                    'harga'    => $menu['harga'],
                    'jumlah'   => $jumlah,
                    'subtotal' => $subtotal
                ];
            }

            // Simpan pesanan ke tabel pesanan
            $insert_pesanan = mysqli_query($this->db, "INSERT INTO pesanan (total_harga, no_meja, status) 
                                                      VALUES ('$total_harga', '$no_meja', 'menunggu')");

if ($insert_pesanan) {

    $id_pesanan = mysqli_insert_id($this->db);

    // Simpan ID pesanan terakhir
    $_SESSION['last_order_id'] = $id_pesanan;

    foreach ($items as $item) {

        $id_m = $item['id_menu'];
        $hrg  = $item['harga'];
        $jml  = $item['jumlah'];
        $sub  = $item['subtotal'];

        mysqli_query(
            $this->db,
            "INSERT INTO pesanan_detail 
            (id_pesanan, id_menu, harga, jumlah, subtotal) 
            VALUES 
            ('$id_pesanan', '$id_m', '$hrg', '$jml', '$sub')"
        );
    }

    $_SESSION['keranjang_last'] = $summary;

    unset($_SESSION['keranjang']);

if (
    isset($_POST['download_pdf']) &&
    $_POST['download_pdf'] == '1'
) {
    $pdf = $this->generateReceiptPdf($id_pesanan, $no_meja, $summary, $total_harga);
    $_SESSION['pdf_download'] = $pdf;
    $_SESSION['pdf_filename'] = 'struk_pesanan_' . $id_pesanan . '_' . date('Ymd_His') . '.pdf';
}
    header("Location: index.php?page=checkout&status=success");
    exit();
}
        }
    }
}
?>