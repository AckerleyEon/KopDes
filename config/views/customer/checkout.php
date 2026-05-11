<?php

$status = $_GET['status'] ?? null;

$real_status = null;

/*
|--------------------------------------------------------------------------
| Ambil status berdasarkan pesanan terakhir
|--------------------------------------------------------------------------
*/

if (
    isset($_SESSION['last_order_id']) &&
    isset($conn)
) {

    $last_order_id = $_SESSION['last_order_id'];

    $query_status = mysqli_query(
        $conn,
        "SELECT status
        FROM pesanan
        WHERE id_pesanan = '$last_order_id'
        LIMIT 1"
    );

    if ($query_status && mysqli_num_rows($query_status) > 0) {

        $data_status = mysqli_fetch_assoc($query_status);

        $real_status = $data_status['status'];
    }
}

/*
|--------------------------------------------------------------------------
| Sinkron status database
|--------------------------------------------------------------------------
*/

if ($real_status == 'terkonfirmasi') {

    $status = 'processing';

} elseif ($real_status == 'dibatalkan') {

    $status = 'canceling';
}

/*
|--------------------------------------------------------------------------
| Validasi status success
|--------------------------------------------------------------------------
| Success hanya boleh jika masih ada last_order_id
*/

if (
    $status == 'success' &&
    !isset($_SESSION['last_order_id'])
) {
    $status = null;
}

$is_success = $status == 'success';
$is_processing = $status == 'processing';
$is_canceling = $status == 'canceling';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $is_processing ? 'Pesanan Sedang Diproses' : ($is_success ? 'Pemesanan Berhasil' : 'Konfirmasi Pesanan') ?> - Kopi Desa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --brown: #5c3d2e;
            --brown-light: #8b6347;
            --cream: #faf7f4;
            --sand: #f0e9e1;
            --ink: #1a1412;
            --muted: #9c8b82;
            --green: #2d6a4f;
            --border: #e8ddd6;
            --sidebar-w: 0px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--cream);
            color: var(--ink);
            min-height: 100vh;
        }


        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 48px;
        }
        .logo span { display: block; font-family: 'DM Sans', sans-serif; font-size: 0.6rem; font-weight: 400; color: var(--muted); letter-spacing: 0.2em; margin-top: 2px; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 14px;
            border-radius: 10px;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.02em;
            margin-bottom: 4px;
            transition: all 0.2s;
        }
        .nav-item i { font-size: 1rem; }
        .nav-item:hover { background: var(--sand); color: var(--brown); }
        .nav-item.active { background: var(--brown); color: white; }

        /* ── MAIN ── */
        .main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 40px 40px;
        }

        /* ── CARD ── */
        .card {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--border);
            width: 100%;
            max-width: 560px;
            overflow: hidden;
            box-shadow: 0 2px 40px rgba(92, 61, 46, 0.06);
            animation: fadeUp 0.4s ease both;
        }

        .modal {
            position: fixed;
            inset: 0;
            z-index: 1050;
            display: none;
            overflow-x: hidden;
            overflow-y: auto;
            outline: 0;
            background: transparent;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex !important;
        }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 1040;
            background-color: rgba(0, 0, 0, 0.45);
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .modal-backdrop.show {
            opacity: 1;
        }

        .modal-dialog {
            max-width: 520px;
            margin: 1.5rem;
            transform: translateY(1.5rem);
            transition: transform 0.25s ease;
        }

        .modal.show .modal-dialog {
            transform: translateY(0);
        }

        .modal-dialog-centered {
            min-height: calc(100% - 3rem);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            border-radius: 28px !important;
            border: 0 !important;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            background: white;
        }

        .modal-inner-body {
            padding: 32px 28px 24px;
            text-align: center;
        }

        .modal-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 68px;
            height: 68px;
            border-radius: 18px;
            background: var(--sand);
            color: var(--green);
            font-size: 2rem;
            margin: 0 auto 18px;
        }

        .modal-question {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .modal-sub {
            font-size: 0.92rem;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 2px;
        }

        .modal-footer-custom {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            padding: 18px;
            background: var(--cream);
        }

        .btn-cancel,
        .btn-confirm {
            flex: 1 1 150px;
            border-radius: 14px;
            border: 0;
            padding: 12px 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-cancel {
            background: white;
            color: var(--ink);
            border: 1px solid var(--border);
        }

        .btn-cancel:hover {
            background: var(--sand);
        }

        .btn-confirm {
            background: var(--brown);
            color: white;
        }

        .btn-confirm:hover {
            background: var(--ink);
            transform: translateY(-1px);
        }

        .modal-dialog.custom-modal {
            max-width: 460px;
            width: calc(100% - 2rem);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── CARD HEADER ── */
        .card-head {
            padding: 36px 36px 28px;
            border-bottom: 1px solid var(--border);
        }

.status-icon {
    width: 52px; height: 52px;
    background: var(--sand);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    color: var(--muted);
    margin-bottom: 16px;
}

/* TAMBAH INI */
.status-icon.success {
    background: #dcfce7;
    color: #16a34a;
}

.status-icon.canceling {
    background: #fee2e2;
    color: #dc2626;
}

.status-icon.sent {
    background: #dbeafe;
    color: #2563eb;
}

        .card-head h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 4px;
        }

        .card-head p {
            font-size: 0.82rem;
            color: var(--muted);
            font-weight: 400;
        }

        .table-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--sand);
            color: var(--brown);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            margin-top: 10px;
            letter-spacing: 0.03em;
        }

        /* ── ITEMS ── */
        .items-list { padding: 8px 36px; }

        .item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
        }
        .item-row:last-child { border-bottom: none; }

        .item-left { display: flex; flex-direction: column; gap: 3px; }
        .item-name { font-size: 0.88rem; font-weight: 600; color: var(--ink); }

        .item-meta {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .item-qty {
            font-size: 0.7rem;
            font-weight: 600;
            background: var(--sand);
            color: var(--brown-light);
            padding: 2px 7px;
            border-radius: 4px;
        }
        .item-unit-price { font-size: 0.75rem; color: var(--muted); }

        .item-subtotal {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--ink);
            white-space: nowrap;
        }

        .empty-state {
            padding: 40px 0;
            text-align: center;
            color: var(--muted);
            font-size: 0.85rem;
        }
        .empty-state i { font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.4; }

        /* ── FOOTER ── */
        .card-foot {
            padding: 24px 36px 32px;
            border-top: 1px solid var(--border);
            background: var(--cream);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .total-label {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
        }
        .total-amount {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--ink);
        }

        /* ── BUTTONS ── */
        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-order {
            background: var(--brown);
            color: white;
        }
        .btn-order:hover {
            background: var(--ink);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(92, 61, 46, 0.25);
        }
        .btn-back {
            margin-top: 12px;
            background: var(--sand);
            color: var(--brown-light);
        }
        .btn-back:hover {
            background: var(--brown-light);
            color: white;
        }

        .btn-done {
            background: var(--green);
            color: white;
        }
        .btn-done:hover {
            background: #235c42;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(45, 106, 79, 0.25);
        }

        .btn-back-menu {
            background: var(--sand);
            color: var(--brown-light);
        }
        .btn-back-menu:hover {
            background: var(--brown-light);
            color: white;
        }

        .processing-animation {
            display: inline-flex;
            gap: 4px;
            align-items: center;
        }
        .processing-animation i {
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* ── MOBILE NAVBAR ── */
        .navbar-mobile {
            display: none;
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 16px 20px;
            position: sticky;
            top: 0;
            z-index: 200;
            align-items: center;
            justify-content: space-between;
        }
        .navbar-mobile .logo-m {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--brown);
        }
        .navbar-mobile a { color: var(--brown); font-size: 1.1rem; text-decoration: none; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .navbar-mobile { display: flex; }
            .main { margin-left: 0; padding: 24px 16px 48px; }
            .card-head, .items-list, .card-foot { padding-left: 24px; padding-right: 24px; }
        }
    </style>
</head>
<body>

<!-- MOBILE NAV -->
<nav class="navbar-mobile">
    <span class="logo-m">Kopi Desa</span>

</nav>

<!-- MAIN -->
<main class="main">
    <form action="index.php?page=proses_checkout" method="POST" style="width:100%;max-width:560px;">
        <div class="card">
            <!-- HEADER -->
           <!-- HEADER -->
<div class="card-head">

    <?php if ($is_processing): ?>
        <div class="status-icon success">
            <i class="bi bi-check2-circle"></i>
        </div>
        <h2 style="color:#16a34a;">Pemesanan Telah Berhasil</h2>
        <p>Pesanan Anda sedang disiapkan. Silakan tunggu di meja <?= $_SESSION['no_meja'] ?? '0' ?>.</p>

    <?php elseif ($is_canceling): ?>
        <div class="status-icon canceling">
            <i class="bi bi-x-circle"></i>
        </div>
        <h2 style="color:#dc2626;">Pemesanan Dibatalkan</h2>
        <p>Pesanan Anda telah dibatalkan. Silakan kembali ke menu untuk memesan lagi.</p>

    <?php elseif ($is_success): ?>
        <div class="status-icon sent">
            <i class="bi bi-send"></i>
        </div>
        <h2>Pesanan Tersampaikan</h2>
        <p>Lakukan pembayaran di kasir agar pesanan anda segera diproses.</p>
        <p>ID Pesanan: <strong>#<?= $last_order_id ?></strong><br></p>

    <?php else: ?>
        <h2>Cetak Struk & Konfirmasi Pesanan</h2>
        <p>Periksa kembali pesanan Anda sebelum mencetak struk dan melanjutkan.</p>
        <div class="table-badge">
            <i class="bi bi-geo-alt"></i>
            Meja <?= $_SESSION['no_meja'] ?? '0' ?>
        </div>
    <?php endif; ?>

</div>
            <!-- ITEM LIST -->
<div class="items-list">

    <?php 

    $total_bayar = 0;

    /*
    |--------------------------------------------------------------------------
    | Ambil item pesanan
    |--------------------------------------------------------------------------
    */

    if (
        ($is_success || $is_processing || $is_canceling)
        && isset($_SESSION['keranjang_last'])
    ) {

        $items = $_SESSION['keranjang_last'];

    } else {

        $items = $_SESSION['keranjang'] ?? [];
    }

    if (!empty($items)): 

        foreach ($items as $id_menu => $jumlah):

            /*
            |--------------------------------------------------------------------------
            | Jika status success / processing / canceling
            | data sudah berbentuk array lengkap
            |--------------------------------------------------------------------------
            */

if (is_array($jumlah)) {

    $nama = $jumlah['nama'] ?? 'Menu';
    $harga = $jumlah['harga'] ?? 0;
    $qty = $jumlah['jumlah'] ?? 0;
    $subtotal = $jumlah['subtotal'] ?? 0;

} else {

    $query = mysqli_query(
        $conn,
        "SELECT * FROM menu WHERE id_menu = '$id_menu'"
    );

    $data = mysqli_fetch_assoc($query);

    $nama = $data['nama_menu'] ?? 'Menu';
    $harga = $data['harga'] ?? 0;
    $qty = (int)$jumlah;
    $subtotal = $harga * $qty;
}

            $total_bayar += $subtotal;

    ?>
                    <div class="item-row">
                        <div class="item-left">
                            <span class="item-name"><?= $nama ?></span>
                            <div class="item-meta">
                                <span class="item-qty">×<?= $qty ?></span>
                                <span class="item-unit-price">Rp <?= number_format($harga, 0, ',', '.') ?></span>
                            </div>
                        </div>
                        <span class="item-subtotal">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                    </div>
                <?php endforeach; else: ?>
                    <div class="empty-state">
                        <i class="bi bi-bag-x"></i>
                        Tidak ada rincian pesanan.
                    </div>
                <?php endif; ?>
            </div>

            <!-- FOOTER -->
            <div class="card-foot">
                <div class="total-row">
                    <span class="total-label">Total</span>
                    <span class="total-amount">Rp <?= number_format($total_bayar, 0, ',', '.') ?></span>
                </div>

                <?php if ($is_processing): ?>
                    <p style="text-align: center; line-height: 1.6; font-size: 0.95rem; color: var(--muted); margin-bottom: 20px;">
                        <span class="processing-animation">
                            <i class="bi bi-clock-history"></i>
                            Tunggu sebentar, pesanan Anda sedang disiapkan...
                        </span>
                    </p>
                    <a href="index.php?page=menu" class="btn btn-back-menu"> <i class="bi bi-arrow-left"></i> Pesan menu lain?</a>
                <?php elseif ($is_canceling): ?>
                    <p style="text-align: center; line-height: 1.6; font-size: 0.95rem; color: var(--muted); margin-bottom: 20px;">
                        Pesanan Anda telah dibatalkan. Silakan kembali ke menu untuk memesan lagi.
                    <a href="index.php?page=menu" class="btn btn-back-menu"> <i class="bi bi-arrow-left"></i> Kembali ke menu</a>

                <?php elseif ($is_success): ?>
                    <p style="text-align: center; line-height: 1.3; letter-spacing: 0.5px;">Tunjukan halaman ini atau struk yang sudah di cetak ke kasir untuk melakukan pembayaran.</p>
                    <?php if (isset($_SESSION['pdf_download'])): ?>
                        <script>
                            window.onload = function() {
                                window.location.href = 'index.php?page=download_pdf';
                            };
                        </script>
                    <?php endif; ?>
                <?php else: ?>
                    <input type="hidden" name="no_meja" value="<?= $_SESSION['no_meja'] ?? 0 ?>">
                    <input type="hidden" name="download_pdf" value="1">
                    <button type="button" class="btn btn-order" data-bs-toggle="modal" data-bs-target="#modalKonfirmasi"> <i class="bi bi-download"></i> Cetak Struk dan Konfirmasi</button>
                    <a href="index.php?page=keranjang" class="btn btn-back"> <i class="bi bi-arrow-left"></i> Kembali ke keranjang</a>
                <?php endif; ?>
            </div>

        </div>

        <?php if (!$is_success && !$is_processing): ?>
        <div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-modal="true">
            <div class="modal-dialog modal-dialog-centered custom-modal">
                <div class="modal-content">

                    <div class="modal-inner-body">
                        <i class="bi bi-bag-check modal-icon"></i>
                        <p class="modal-question">Yakin ingin mencetak struk dan konfirmasi pesanan?</p>
                        <p class="modal-sub">Pastikan semua data sudah benar sebelum lanjut.</p>
                    </div>

                    <div class="modal-footer-custom">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="confirmCheckout" class="btn btn-confirm">
                            Ya, konfirmasi <i class="bi bi-check2-circle"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <?php endif; ?>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('confirmCheckout')?.addEventListener('click', function () {

    // submit form normal
    document.querySelector('form').submit();

});

    // Auto-refresh untuk status processing
    if (new URLSearchParams(window.location.search).get('status') === 'processing') {
        setTimeout(() => {
            location.reload();
        }, 3000);
    }
</script>
</body>
</html>
