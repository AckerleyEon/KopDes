<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pesanan - Kopi Desa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>

    :root {
        --brown: #5c3d2e;
        --brown-light: #8b6347;
        --cream: #faf7f4;
        --sand: #f3ece6;
        --ink: #1a1412;
        --muted: #9c8b82;
        --border: #e8ddd6;
        --sidebar-w: 230px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background: linear-gradient(135deg, #faf7f4 0%, #f6f0eb 35%, #f3ece6 70%, #faf7f4 100%);
        background-attachment: fixed;
        color: var(--ink);
        min-height: 100vh;
    }

    /* ===== SIDEBAR ===== */

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--sidebar-w);
        height: 100vh;
        background: rgba(255, 255, 255, 0.82);
        backdrop-filter: blur(14px);
        border-right: 1px solid var(--border);
        padding: 28px 18px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
    }

    .sidebar nav {
        display: flex;
        flex-direction: column;
        flex: 1;
        margin-top: 4px;
    }

    .sidebar-header {
        padding-bottom: 24px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border);
        text-align: center;
    }

    .sidebar-header h4 {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--brown);
        letter-spacing: .08em;
        margin: 0;
    }

    .sidebar-header span {
        display: block;
        margin-top: 4px;
        font-size: .72rem;
        letter-spacing: .18em;
        color: var(--muted);
        text-transform: uppercase;
    }

    .nav-link-admin {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 13px 16px;
        border-radius: 14px;
        color: var(--muted);
        text-decoration: none;
        font-size: .92rem;
        font-weight: 500;
        transition: .25s ease;
        margin-bottom: 6px;
    }

    .nav-link-admin i {
        font-size: 1.1rem;
    }

    .nav-link-admin:hover {
        background: var(--sand);
        color: var(--brown);
        transform: translateX(2px);
    }

    .nav-link-admin.active {
        background: var(--brown);
        color: #fff;
        box-shadow: 0 10px 25px rgba(92, 61, 46, .18);
    }

    .nav-link-admin.logout {
        margin-top: auto;
        color: #c0392b;
    }

    .nav-link-admin.logout:hover {
        background: rgba(192, 57, 43, .08);
    }

    /* ===== MAIN ===== */

    .main-content {
        margin-left: var(--sidebar-w);
        padding: 42px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* ===== TOP HEAD ===== */

    .top-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 22px;
    }

    .top-head h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.9rem;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 4px;
    }

    .top-head p {
        color: var(--muted);
        font-size: .88rem;
    }

    .total-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 20px;
        background: rgba(92, 61, 46, .1);
        color: var(--brown);
        font-size: .82rem;
        font-weight: 700;
    }

    /* ===== TABS ===== */

    .order-tabs {
        display: flex;
        gap: 6px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .order-tab {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 20px;
        font-size: .82rem;
        font-weight: 600;
        border: 1px solid var(--border);
        background: transparent;
        cursor: pointer;
        color: var(--muted);
        transition: .2s;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none;
    }

    .order-tab:hover {
        background: var(--sand);
        color: var(--brown);
    }

    .order-tab.active {
        background: var(--brown);
        color: #fff;
        border-color: var(--brown);
    }

    .tab-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
    }

    .dot-warn { background: #d97706; }
    .dot-ok   { background: #27ae60; }
    .dot-red  { background: #c0392b; }

    /* ===== ORDER LIST ===== */

    .order-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .order-item {
        background: rgba(255, 255, 255, .9);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        transition: .2s;
    }

    .order-item:hover {
        box-shadow: 0 6px 20px rgba(92, 61, 46, .08);
    }

    /* HEAD ROW */

    .order-head {
        display: flex;
        align-items: center;
        padding: 14px 18px;
        cursor: pointer;
        gap: 12px;
        user-select: none;
    }

    .order-id {
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--ink);
        flex-shrink: 0;
    }

    .order-meja {
        font-size: .8rem;
        color: var(--muted);
        background: var(--sand);
        padding: 3px 10px;
        border-radius: 20px;
        flex-shrink: 0;
    }

    .order-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: .73rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .sts-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .sts-menunggu     { background: #fef3c7; color: #92400e; }
    .sts-terkonfirmasi{ background: #d1fae5; color: #065f46; }
    .sts-dibatalkan   { background: #fee2e2; color: #991b1b; }
    .sd-warn { background: #d97706; }
    .sd-ok   { background: #10b981; }
    .sd-red  { background: #ef4444; }

    .order-total {
        font-family: 'Playfair Display', serif;
        font-size: .95rem;
        font-weight: 700;
        color: var(--brown);
        margin-left: auto;
    }

    .order-time {
        font-size: .78rem;
        color: var(--muted);
        flex-shrink: 0;
    }

    .order-chevron {
        font-size: 1.1rem;
        color: var(--muted);
        transition: transform .25s;
        flex-shrink: 0;
    }

    .order-chevron.open {
        transform: rotate(180deg);
    }

    /* DETAIL PANEL */

    .order-detail {
        display: none;
        border-top: 1px solid var(--border);
        background: rgba(243, 236, 230, .3);
    }

    .order-detail.open {
        display: block;
    }

    .detail-items {
        padding: 14px 18px 4px;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 9px 0;
        border-bottom: 1px dashed var(--border);
        font-size: .87rem;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .item-name {
        color: var(--ink);
    }

    .item-qty {
        display: inline-block;
        background: var(--sand);
        color: var(--muted);
        font-size: .72rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 20px;
        margin-left: 6px;
    }

    .item-sub {
        font-weight: 700;
        color: var(--brown);
        font-size: .85rem;
    }

    .detail-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 18px 14px;
    }

    .detail-total {
        font-family: 'Playfair Display', serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--brown);
    }

    .detail-actions {
        display: flex;
        gap: 7px;
    }

    .btn-konfirm {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: .82rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: .2s;
        background: #d1fae5;
        color: #065f46;
    }

    .btn-konfirm:hover {
        background: #a7f3d0;
    }

    .btn-batal {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: .82rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: .2s;
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-batal:hover {
        background: #fecaca;
    }

    /* EMPTY */

    .empty-state {
        text-align: center;
        padding: 60px 0;
        color: var(--muted);
    }

    .empty-state i {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 10px;
        opacity: .4;
    }

    /* RESPONSIVE */

    @media (max-width: 768px) {
        .sidebar { display: none; }
        .main-content { margin-left: 0; padding: 24px 18px; }
        .order-total { display: none; }
    }

    </style>
</head>

<body>

<!-- SIDEBAR -->
<aside class="sidebar">

    <div class="sidebar-header">
        <h4>KOPI DESA</h4>
        <span>Admin Panel</span>
    </div>

    <nav>

        <a href="/KopiDesa/public/index.php?page=dashboard" class="nav-link-admin">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <a href="/KopiDesa/public/index.php?page=admin_menu" class="nav-link-admin">
            <i class="bi bi-cup-hot"></i>
            <span>Data Menu</span>
        </a>

        <a href="/KopiDesa/public/index.php?page=admin_pesanan" class="nav-link-admin active">
            <i class="bi bi-cart-check"></i>
            <span>Data Pesanan</span>
        </a>

        <a href="/KopiDesa/public/index.php?page=admin_riwayat" class="nav-link-admin">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat</span>
        </a>

        <a href="/KopiDesa/public/index.php?page=logout" class="nav-link-admin logout">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>

    </nav>

</aside>

<!-- MAIN -->
<main class="main-content">

    <!-- TOP HEAD -->
    <div class="top-head">
        <div>
            <h2>Manajemen Pesanan</h2>
            <p>Pesanan aktif dan menunggu konfirmasi</p>
        </div>

<?php
$jumlah_menunggu = 0;
$cek_id = [];

if (isset($all_orders)) {
    mysqli_data_seek($all_orders, 0);

    while ($row = mysqli_fetch_assoc($all_orders)) {
        if ($row['status'] === 'menunggu') {
            $cek_id[$row['id_pesanan']] = true;
        }
    }

    $jumlah_menunggu = count($cek_id);

    mysqli_data_seek($all_orders, 0);
}
?>
<span class="total-badge">
    <i class="bi bi-cart-check"></i>
    <?= $jumlah_menunggu ?> Pesanan
</span>

    </div>

    <!-- FILTER TABS -->
    <?php $filter = isset($_GET['filter']) ? $_GET['filter'] : 'semua'; ?>

    <!-- ORDER LIST -->
    <div class="order-list">

    <?php if (isset($all_orders) && mysqli_num_rows($all_orders) > 0):

        $current_id  = null;
        $first       = true;
        $prev_total  = 0;
        $prev_id     = null;
        $prev_meja   = null;
        $prev_status = null;
        $prev_waktu  = null;
        $items_html  = '';

        while ($row = mysqli_fetch_assoc($all_orders)):

    // hanya tampilkan pesanan menunggu
    if ($row['status'] !== 'menunggu') continue;

            if ($filter !== 'semua' && $row['status'] !== $filter) continue;

            if ($current_id !== $row['id_pesanan']):

                if (!$first):
                    // Tutup order sebelumnya
                    $sts_class = $prev_status === 'menunggu'      ? 'sts-menunggu'
                               : ($prev_status === 'terkonfirmasi' ? 'sts-terkonfirmasi'
                               :                                      'sts-dibatalkan');
                    $dot_class = $prev_status === 'menunggu'      ? 'sd-warn'
                               : ($prev_status === 'terkonfirmasi' ? 'sd-ok'
                               :                                      'sd-red');
                    $sts_label = $prev_status === 'menunggu'      ? 'Menunggu'
                               : ($prev_status === 'terkonfirmasi' ? 'Terkonfirmasi'
                               :                                      'Dibatalkan');
                    ?>

                    <div class="order-item">

                        <div class="order-head" onclick="toggleDetail(<?= $prev_id ?>)">

                            <span class="order-id">#<?= $prev_id ?></span>

                            <span class="order-meja">
                                <i class="bi bi-geo-alt"></i> Meja <?= $prev_meja ?>
                            </span>

                            <span class="order-status <?= $sts_class ?>">
                                <span class="sts-dot <?= $dot_class ?>"></span>
                                <?= $sts_label ?>
                            </span>

                            <span class="order-total">
                                Rp <?= number_format($prev_total, 0, ',', '.') ?>
                            </span>

                            <span class="order-time">
                                <?= date('H:i', strtotime($prev_waktu)) ?>
                            </span>

                            <i class="bi bi-chevron-down order-chevron" id="chev-<?= $prev_id ?>"></i>

                        </div>

                        <div class="order-detail" id="det-<?= $prev_id ?>">

                            <div class="detail-items">
                                <?= $items_html ?>
                            </div>

                            <div class="detail-footer">

                                <span class="detail-total">
                                    Total &nbsp; Rp <?= number_format($prev_total, 0, ',', '.') ?>
                                </span>

                                <?php if ($prev_status === 'menunggu'): ?>

                                <div class="detail-actions">

                                    <form action="/KopiDesa/public/index.php?page=update_pesanan" method="POST">
                                        <input type="hidden" name="id_pesanan" value="<?= $prev_id ?>">
                                        <input type="hidden" name="status" value="terkonfirmasi">
                                        <button type="submit" class="btn-konfirm">
                                            <i class="bi bi-check-lg"></i> Konfirmasi
                                        </button>
                                    </form>

                                    <form action="/KopiDesa/public/index.php?page=update_pesanan" method="POST">
                                        <input type="hidden" name="id_pesanan" value="<?= $prev_id ?>">
                                        <input type="hidden" name="status" value="dibatalkan">
                                        <button type="submit" class="btn-batal">
                                            <i class="bi bi-x-lg"></i> Batalkan
                                        </button>
                                    </form>

                                </div>

                                <?php else: ?>

                                <span style="font-size:.8rem;color:var(--muted)">
                                    <?= $sts_label ?>
                                </span>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                    <?php
                endif;

                // Reset untuk order baru
                $current_id  = $row['id_pesanan'];
                $prev_id     = $row['id_pesanan'];
                $prev_meja   = $row['no_meja'];
                $prev_status = $row['status'];
                $prev_total  = $row['total_harga'];
                $prev_waktu  = $row['tanggal'];
                $items_html  = '';
                $first       = false;

            endif;

            // Kumpulkan item baris ini
$subtotal = $row['harga_menu'] * $row['jumlah'];

$items_html .= '
<div class="detail-item">
    <span class="item-name">'
        . htmlspecialchars($row['nama_menu'])
        . '<span class="item-qty">x' . $row['jumlah'] . '</span>'
    . '</span>
    <span class="item-sub">Rp ' . number_format($subtotal, 0, ',', '.') . '</span>
</div>';
        endwhile;

        // Tutup order terakhir (sama dengan blok di atas)
        if (!$first):
            $sts_class = $prev_status === 'menunggu'      ? 'sts-menunggu'
                       : ($prev_status === 'terkonfirmasi' ? 'sts-terkonfirmasi'
                       :                                      'sts-dibatalkan');
            $dot_class = $prev_status === 'menunggu'      ? 'sd-warn'
                       : ($prev_status === 'terkonfirmasi' ? 'sd-ok'
                       :                                      'sd-red');
            $sts_label = $prev_status === 'menunggu'      ? 'Menunggu'
                       : ($prev_status === 'terkonfirmasi' ? 'Terkonfirmasi'
                       :                                      'Dibatalkan');
            ?>

            <div class="order-item">

                <div class="order-head" onclick="toggleDetail(<?= $prev_id ?>)">

                    <span class="order-id">#<?= $prev_id ?></span>

                    <span class="order-meja">
                        <i class="bi bi-geo-alt"></i> Meja <?= $prev_meja ?>
                    </span>

                    <span class="order-status <?= $sts_class ?>">
                        <span class="sts-dot <?= $dot_class ?>"></span>
                        <?= $sts_label ?>
                    </span>

                    <span class="order-total">
                        Rp <?= number_format($prev_total, 0, ',', '.') ?>
                    </span>

                    <span class="order-time">
                        <?= date('H:i', strtotime($prev_waktu)) ?>
                    </span>

                    <i class="bi bi-chevron-down order-chevron" id="chev-<?= $prev_id ?>"></i>

                </div>

                <div class="order-detail" id="det-<?= $prev_id ?>">

                    <div class="detail-items">
                        <?= $items_html ?>
                    </div>

                    <div class="detail-footer">

                        <span class="detail-total">
                            Total &nbsp; Rp <?= number_format($prev_total, 0, ',', '.') ?>
                        </span>

                        <?php if ($prev_status === 'menunggu'): ?>

                        <div class="detail-actions">

                            <form action="/KopiDesa/public/index.php?page=update_pesanan" method="POST">
                                <input type="hidden" name="id_pesanan" value="<?= $prev_id ?>">
                                <input type="hidden" name="status" value="terkonfirmasi">
                                <button type="submit" class="btn-konfirm">
                                    <i class="bi bi-check-lg"></i> Konfirmasi
                                </button>
                            </form>

                            <form action="/KopiDesa/public/index.php?page=update_pesanan" method="POST">
                                <input type="hidden" name="id_pesanan" value="<?= $prev_id ?>">
                                <input type="hidden" name="status" value="dibatalkan">
                                <button type="submit" class="btn-batal">
                                    <i class="bi bi-x-lg"></i> Batalkan
                                </button>
                            </form>

                        </div>

                        <?php else: ?>

                        <span style="font-size:.8rem;color:var(--muted)"><?= $sts_label ?></span>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        <?php endif; ?>

    <?php else: ?>

        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>Tidak ada pesanan yang ditemukan.</p>
        </div>

    <?php endif; ?>

    </div><!-- end .order-list -->

</main>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- ACCORDION TOGGLE -->
<script>
function toggleDetail(id) {
    const det  = document.getElementById('det-'  + id);
    const chev = document.getElementById('chev-' + id);
    if (!det) return;
    const isOpen = det.classList.toggle('open');
    if (chev) chev.classList.toggle('open', isOpen);
}
</script>

</body>
</html>
