<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Kopi Desa</title>

    <?php
    if (!isset($total_menu) || !isset($profit) || !isset($sale) || !isset($total_pending) || !isset($pending_orders)) {
        if (!isset($conn)) {
            include __DIR__ . '/../../../config/koneksi.php';
        }

        $total_menu = 0;
        $profit = 0;
        $sale = 0;
        $total_pending = 0;
        $pending_orders = [];

        if (isset($conn) && $conn) {
            $query_menu = mysqli_query($conn, "SELECT COUNT(*) as total FROM menu");
            $result_menu = $query_menu ? mysqli_fetch_assoc($query_menu) : null;
            $total_menu = $result_menu ? $result_menu['total'] : 0;

            $query_pending = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status = 'menunggu'");
            $result_pending = $query_pending ? mysqli_fetch_assoc($query_pending) : null;
            $total_pending = $result_pending ? $result_pending['total'] : 0;

            $query_profit = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM pesanan WHERE status = 'selesai'");
            $result_profit = $query_profit ? mysqli_fetch_assoc($query_profit) : null;
            $profit = $result_profit && $result_profit['total'] !== null ? $result_profit['total'] : 0;

            $query_sale = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status = 'selesai'");
            $result_sale = $query_sale ? mysqli_fetch_assoc($query_sale) : null;
            $sale = $result_sale ? $result_sale['total'] : 0;

            $query_pending_orders = mysqli_query($conn, "SELECT p.id_pesanan, p.no_meja, p.total_harga, p.tanggal, p.status,
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
            }
        }
    }
    ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        :root {
            --brown: #5c3d2e;
            --brown-light: #8b6347;
            --cream: #faf7f4;
            --sand: #f3ece6;
            --ink: #1a1412;
            --muted: #9c8b82;
            --border: #e8ddd6;
            --green: #2d6a4f;
            --sidebar-w: 230px;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #faf7f4 0%, #f6f0eb 35%, #f3ece6 70%, #faf7f4 100%);
            background-attachment: fixed;
            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            overflow-x: hidden;
        }

        /* ── SIDEBAR (tidak diubah) ── */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: 230px; height: 100vh;
            background: rgba(255,255,255,0.82);
            backdrop-filter: blur(14px);
            border-right: 1px solid #e8ddd6;
            padding: 28px 18px;
            z-index: 1000;
            display: flex; flex-direction: column;
        }
        .sidebar nav { margin-top: 4px; display: flex; flex-direction: column; flex: 1; }
        .sidebar-header { padding-bottom: 24px; margin-bottom: 20px; border-bottom: 1px solid var(--border); }
        .sidebar-header h4 { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; color: #5c3d2e; letter-spacing: .08em; margin: 0; }
        .sidebar-header span { display: block; margin-top: 4px; font-size: .72rem; letter-spacing: .18em; color: var(--muted); text-transform: uppercase; }
        .nav-link-admin { display: flex; align-items: center; gap: 14px; padding: 13px 16px; border-radius: 14px; color: var(--muted); text-decoration: none; font-size: .92rem; font-weight: 500; transition: .25s ease; margin-bottom: 6px; }
        .nav-link-admin i { font-size: 1.1rem; }
        .nav-link-admin:hover { background: var(--sand); color: var(--brown); transform: translateX(2px); }
        .nav-link-admin.active { background: var(--brown); color: white; box-shadow: 0 10px 25px rgba(92,61,46,.18); }
        .nav-link-admin.logout { margin-top: auto; color: #c0392b; }
        .nav-link-admin.logout:hover { background: rgba(192,57,43,.08); }

        /* ── MAIN ── */
        .main-content { margin-left: var(--sidebar-w); min-height: 100vh; padding: 42px; }

        .top-head { margin-bottom: 32px; }
        .top-head h2 { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
        .top-head p { color: var(--muted); font-size: .92rem; }

        /* ── SUMMARY CARDS ── */
        .summary-card {
            position: relative; overflow: hidden;
            border-radius: 22px; padding: 32px 28px;
            min-height: 160px;
            display: flex; flex-direction: column; justify-content: space-between;
            box-shadow: 0 8px 32px rgba(0,0,0,.08);
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .summary-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,.12); }

        .summary-card.green {
            background: linear-gradient(135deg, #2d6a4f 0%, #40916c 100%);
            color: white;
        }
        .summary-card.brown {
            background: linear-gradient(135deg, #5c3d2e 0%, #7a5240 100%);
            color: white;
        }
        .summary-label {
            font-size: .72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .18em;
            opacity: .7; margin-bottom: 10px;
        }
        .summary-value {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem; font-weight: 700; line-height: 1.1;
        }
        .summary-icon {
            position: absolute; right: 20px; bottom: 16px;
            font-size: 5rem; opacity: .1;
            pointer-events: none;
        }

        /* ── STAT CARDS ── */
        .stat-card {
            background: rgba(255,255,255,.9);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 24px 22px;
            box-shadow: 0 4px 20px rgba(0,0,0,.04);
            transition: transform .25s ease;
        }
        .stat-card:hover { transform: translateY(-3px); }

        .stat-label {
            font-size: .72rem; font-weight: 700;
            letter-spacing: .16em; text-transform: uppercase;
            color: var(--muted); margin-bottom: 14px;
        }

        /* ── MENU LIST ── */
        .menu-row {
            display: flex; justify-content: space-between;
            align-items: center; padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }
        .menu-row:last-child { border-bottom: none; }
        .menu-row-name { font-weight: 600; font-size: .88rem; color: var(--ink); }
        .menu-row-cat { font-size: .74rem; color: var(--muted); margin-top: 2px; }
        .menu-row-price { font-size: .85rem; font-weight: 600; color: var(--brown); text-align: right; }
        .pill {
            display: inline-block; padding: 2px 8px; border-radius: 20px;
            font-size: .65rem; font-weight: 700; margin-top: 3px;
        }
        .pill-green { background: #dcfce7; color: #16a34a; }
        .pill-red   { background: #fee2e2; color: #dc2626; }

        /* ── EXPORT BUTTON ── */
        .btn-export {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            width: 100%; padding: 13px 20px; border-radius: 14px;
            background: linear-gradient(135deg, #2d6a4f, #40916c);
            color: white; font-size: .9rem; font-weight: 600;
            border: none; cursor: pointer; text-decoration: none;
            transition: opacity .2s, transform .2s;
            box-shadow: 0 4px 16px rgba(45,106,79,.25);
        }
        .btn-export:hover { opacity: .9; transform: translateY(-1px); color: white; }

        /* ── ORDER CARDS ── */
        .order-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            margin-bottom: 12px;
            transition: box-shadow .2s;
        }
        .order-card:hover { box-shadow: 0 4px 20px rgba(92,61,46,.08); }

        .order-card-head {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px;
            padding: 16px 20px;
        }

        .order-id {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem; font-weight: 700; color: var(--ink);
        }
        .order-id sup { font-size: .7rem; color: var(--muted); font-family: 'DM Sans', sans-serif; }

        .order-meta {
            display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
            margin-top: 4px;
        }
        .order-meta span {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: .82rem; color: var(--muted);
        }

        .order-total {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; font-weight: 700; color: var(--ink);
        }

        /* status pills */
        .status-pill {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 12px; border-radius: 20px;
            font-size: .78rem; font-weight: 700;
        }
        .status-pill.menunggu  { background: #fef3c7; color: #d97706; }
        .status-pill.konfirmasi{ background: #dcfce7; color: #16a34a; }
        .status-pill.batal     { background: #fee2e2; color: #dc2626; }

        /* action buttons */
        .btn-konfirmasi {
            padding: 7px 16px; border-radius: 10px; border: none;
            background: #dcfce7; color: #16a34a;
            font-size: .82rem; font-weight: 700; cursor: pointer;
            transition: background .2s;
        }
        .btn-konfirmasi:hover { background: #bbf7d0; }

        .btn-batalkan {
            padding: 7px 16px; border-radius: 10px; border: none;
            background: #fee2e2; color: #dc2626;
            font-size: .82rem; font-weight: 700; cursor: pointer;
            transition: background .2s;
        }
        .btn-batalkan:hover { background: #fecaca; }

        .btn-detail-order {
            padding: 7px 14px; border-radius: 10px;
            border: 1px solid var(--border); background: transparent;
            color: var(--muted); font-size: .82rem; font-weight: 600;
            cursor: pointer; transition: all .2s;
            display: inline-flex; align-items: center; gap: 5px;
        }
        .btn-detail-order:hover { background: var(--sand); color: var(--brown); border-color: var(--brown-light); }

        /* order detail rows */
        .order-detail-body {
            border-top: 1px solid var(--border);
            padding: 0 20px;
        }
        .order-detail-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 10px 0; border-bottom: 1px dashed var(--border);
            font-size: .88rem;
        }
        .order-detail-row:last-child { border-bottom: none; }
        .order-detail-row .item-name { color: var(--ink); font-weight: 500; }
        .order-detail-row .item-qty {
            display: inline-block; padding: 1px 7px;
            background: var(--sand); border-radius: 6px;
            font-size: .75rem; font-weight: 700;
            color: var(--brown); margin-left: 6px;
        }
        .order-detail-row .item-price { color: var(--muted); font-weight: 500; }
        .order-total-row {
            display: flex; justify-content: space-between;
            padding: 12px 0;
            font-weight: 700; font-size: .92rem;
            color: var(--ink);
        }

        /* mobile */
        .mobile-topbar {
            display: none; position: sticky; top: 0; z-index: 999;
            padding: 16px 20px;
            background: rgba(255,255,255,.82); backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            align-items: center; justify-content: space-between;
        }
        .mobile-topbar h5 { margin: 0; font-family: 'Playfair Display', serif; color: var(--brown); font-weight: 700; }
        .mobile-topbar i { font-size: 1.3rem; color: var(--brown); }

        @media (max-width: 768px) {
            .sidebar { display: none; }
            .mobile-topbar { display: flex; }
            .main-content { margin-left: 0; padding: 24px 18px 40px; }
            .top-head h2 { font-size: 1.6rem; }
            .summary-value { font-size: 1.8rem; }
        }
        @media (max-width: 576px) {
            .main-content { padding: 18px 14px 32px; }
            .summary-value { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

<!-- MOBILE TOPBAR -->
<div class="mobile-topbar">
    <h5>KOPI DESA</h5>
    <i class="bi bi-grid"></i>
</div>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-header text-center">
        <h4>KOPI DESA</h4>
        <span>Admin Panel</span>
    </div>
    <nav>
        <a href="/KopiDesa/public/index.php?page=dashboard" class="nav-link-admin active">
            <i class="bi bi-speedometer2"></i><span>Dashboard</span>
        </a>
        <a href="/KopiDesa/public/index.php?page=admin_menu" class="nav-link-admin">
            <i class="bi bi-cup-hot"></i><span>Data Menu</span>
        </a>
        <a href="/KopiDesa/public/index.php?page=admin_pesanan" class="nav-link-admin">
            <i class="bi bi-cart-check"></i><span>Data Pesanan</span>
        </a>
        <a href="/KopiDesa/public/index.php?page=admin_riwayat" class="nav-link-admin">
            <i class="bi bi-clock-history"></i><span>Riwayat</span>
        </a>
        <a href="/KopiDesa/public/index.php?page=logout" class="nav-link-admin logout">
            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
        </a>
    </nav>
</aside>

<!-- MAIN -->
<main class="main-content">

    <!-- TOP HEAD -->
    <div class="top-head">
        <h2>Administrator Dashboard</h2>
        <p>Pantau ringkasan penjualan dan performa café secara real-time.</p>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-6">
            <div class="summary-card green">
                <div>
                    <div class="summary-label">Total Profit</div>
                    <div class="summary-value">Rp <?= number_format($profit, 0, ',', '.') ?></div>
                </div>
                <i class="bi bi-cash-stack summary-icon"></i>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="summary-card brown">
                <div>
                    <div class="summary-label">Total Transaksi</div>
                    <div class="summary-value"><?= $sale ?> <span style="font-size:1.1rem;opacity:.7;">Transaksi</span></div>
                </div>
                <i class="bi bi-bag-check summary-icon"></i>
            </div>
        </div>
    </div>

    <!-- BOTTOM SECTION -->
    <div class="row g-4 align-items-stretch">

        <!-- LEFT: menu list + export -->
        <div class="col-12 col-xl-4 d-flex flex-column gap-4">

            <!-- MENU LIST CARD -->
            <div class="stat-card" style="flex:1; max-height:420px; display:flex; flex-direction:column;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="stat-label mb-0">Menu Tersedia</div>
                    <span style="background:var(--sand);color:var(--brown);font-size:.75rem;font-weight:700;padding:3px 10px;border-radius:20px;">
                        <?= $total_menu ?> Item
                    </span>
                </div>

                <div style="overflow-y:auto; flex:1; padding-right:4px;">
                    <?php if (!empty($menu_list)): ?>
                        <?php foreach ($menu_list as $menu): ?>
                        <div class="menu-row">
                            <div>
                                <div class="menu-row-name"><?= htmlspecialchars($menu['nama_menu']) ?></div>
                                <div class="menu-row-cat"><?= htmlspecialchars($menu['kategori_menu']) ?></div>
                            </div>
                            <div class="text-end">
                                <div class="menu-row-price">Rp <?= number_format($menu['harga'], 0, ',', '.') ?></div>
                                <?php if ($menu['status'] == 'tersedia'): ?>
                                    <span class="pill pill-green">Tersedia</span>
                                <?php else: ?>
                                    <span class="pill pill-red">Habis</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="font-size:.85rem;color:var(--muted);padding-top:8px;">Belum ada menu.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- EXPORT CARD -->
            <div class="stat-card " style="max-height:120px; display:flex; flex-direction:column; align-items:center; justify-content:center; padding: 80px 20px;">
                <div class="stat-label">Export Laporan</div>
                <a href="index.php?page=export_excel" class="btn-export mt-2">
                    <i class="bi bi-file-earmark-excel-fill"></i>
                    Download Excel
                </a>
            </div>

        </div>

        <!-- RIGHT: pending orders -->
        <div class="col-12 col-xl-8">
            <div class="stat-card h-100 d-flex flex-column">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="stat-label mb-0">Pesanan Aktif</div>
                    <?php if ($total_pending > 0): ?>
                    <span style="background:#fef3c7;color:#d97706;font-size:.75rem;font-weight:700;padding:3px 10px;border-radius:20px;">
                        <?= $total_pending ?> Menunggu
                    </span>
                    <?php endif; ?>
                </div>

                <?php if (!empty($pending_orders)): ?>
                <div style="overflow-y:auto; max-height:500px; padding-right:6px; flex:1;">
                    <?php foreach ($pending_orders as $order): ?>

                    <div class="order-card">

                        <!-- HEADER -->
                        <div class="order-card-head">
                            <div>
                                <div class="order-id">
                                    <sup>#</sup><?= $order['id_pesanan'] ?>
                                </div>
                                <div class="order-meta">
                                    <span><i class="bi bi-geo-alt"></i> Meja <?= $order['no_meja'] ?></span>
                                    <span><i class="bi bi-clock"></i> <?= date('H:i', strtotime($order['tanggal'])) ?></span>
                                    <?php if ($order['status'] == 'menunggu'): ?>
                                        <span class="status-pill menunggu"><i class="bi bi-dot" style="font-size:1rem;"></i>Menunggu</span>
                                    <?php elseif ($order['status'] == 'terkonfirmasi'): ?>
                                        <span class="status-pill konfirmasi"><i class="bi bi-check-circle-fill" style="font-size:.75rem;"></i>Terkonfirmasi</span>
                                    <?php else: ?>
                                        <span class="status-pill batal"><i class="bi bi-x-circle-fill" style="font-size:.75rem;"></i>Dibatalkan</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="order-total">Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></span>

                                <?php if ($order['status'] == 'menunggu'): ?>
                                    <form action="/KopiDesa/public/index.php?page=update_pesanan" method="POST" class="m-0">
                                        <input type="hidden" name="id_pesanan" value="<?= $order['id_pesanan'] ?>">
                                        <input type="hidden" name="status" value="terkonfirmasi">
                                        <button type="submit" class="btn-konfirmasi">
                                            <i class="bi bi-check-lg me-1"></i>Konfirmasi
                                        </button>
                                    </form>
                                    <form action="/KopiDesa/public/index.php?page=update_pesanan" method="POST" class="m-0">
                                        <input type="hidden" name="id_pesanan" value="<?= $order['id_pesanan'] ?>">
                                        <input type="hidden" name="status" value="dibatalkan">
                                        <button type="submit" class="btn-batalkan">
                                            <i class="bi bi-x-lg me-1"></i>Batalkan
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <button class="btn-detail-order"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#detail-<?= $order['id_pesanan'] ?>">
                                    <i class="bi bi-chevron-down"></i> Detail
                                </button>
                            </div>
                        </div>

                        <!-- DETAIL COLLAPSE -->
                        <div class="collapse" id="detail-<?= $order['id_pesanan'] ?>">
                            <div class="order-detail-body">
                                <?php
                                    $items = array_filter(explode('||', $order['items']));
                                    foreach ($items as $itemString):
                                        list($name, $qty, $price, $subtotal) = explode('|', $itemString);
                                ?>
                                <div class="order-detail-row">
                                    <span class="item-name">
                                        <?= htmlspecialchars($name) ?>
                                        <span class="item-qty">x<?= $qty ?></span>
                                    </span>
                                    <span class="item-price">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                                </div>
                                <?php endforeach; ?>
                                <div class="order-total-row">
                                    <span>Total</span>
                                    <span style="color:var(--brown);">Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php endforeach; ?>
                </div>

                <?php else: ?>
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--muted);gap:8px;padding:40px 0;">
                        <i class="bi bi-inbox" style="font-size:2rem;"></i>
                        <span style="font-size:.9rem;">Tidak ada pesanan aktif saat ini.</span>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>