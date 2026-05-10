<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Kopi Desa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            --sidebar-w: 200px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--cream);
            color: var(--ink);
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: white;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 40px 24px;
            z-index: 100;
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
        .logo-m {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }
        .logo span {
            display: block;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 400;
            color: var(--muted);
            letter-spacing: 0.2em;
            margin-top: 2px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 14px;
            border-radius: 10px;
            color: var(--muted);
            background: var(--cream);
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
            padding: 60px 40px;
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

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── CARD HEADER ── */
        .card-head {
            padding: 36px 36px 28px;
            border-bottom: 1px solid var(--border);
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
        }

        /* ── ITEM LIST ── */
        .items-list { padding: 8px 36px; }

        .cart-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
            gap: 12px;
        }
        .cart-row:last-child { border-bottom: none; }

        .item-info { flex: 1; min-width: 0; }
        .item-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .item-unit-price {
            font-size: 0.75rem;
            color: var(--muted);
        }

        /* ── QTY CONTROL ── */
        .qty-control {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .btn-qty {
            width: 28px; height: 28px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--ink);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            line-height: 1;
            transition: all 0.15s;
        }
        .btn-qty:hover { background: var(--sand); border-color: var(--brown-light); color: var(--brown); }

        .qty-number {
            font-size: 0.85rem;
            font-weight: 600;
            min-width: 18px;
            text-align: center;
            color: var(--ink);
        }

        /* ── ITEM RIGHT ── */
        .item-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .item-subtotal {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--ink);
            white-space: nowrap;
        }

        .btn-remove {
            color: var(--border);
            font-size: 0.9rem;
            text-decoration: none;
            transition: color 0.15s;
            display: flex;
            align-items: center;
        }
        .btn-remove:hover { color: #c0392b; }

        /* ── EMPTY STATE ── */
        .empty-state {
            padding: 48px 20px;
            text-align: center;
        }
        .empty-state i {
            font-size: 2rem;
            color: var(--border);
            display: block;
            margin-bottom: 12px;
        }
        .empty-state p {
            font-size: 0.82rem;
            color: var(--muted);
            margin-bottom: 20px;
        }
        .btn-back {
            display: inline-block;
            padding: 10px 24px;
            border-radius: 10px;
            background: var(--brown);
            color: white;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-back:hover { background: var(--ink); color: white; }

        /* ── CARD FOOTER ── */
        .card-foot {
            padding: 20px 36px 32px;
            border-top: 1px solid var(--border);
            background: var(--cream);
        }

        .summary-line {
            display: flex;
            justify-content: space-between;
            font-size: 0.78rem;
            color: var(--muted);
            margin-bottom: 8px;
        }
        .summary-line .val-green { color: var(--green); font-weight: 600; }

        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 14px 0;
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

        /* ── BUTTON ── */
        .btn-checkout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            background: var(--brown);
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-checkout:hover {
            background: var(--ink);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(92, 61, 46, 0.25);
        }
        .btn-checkout i { font-size: 1rem; }

        /* ── MODAL ── */
        .modal-content {
            border: 1px solid var(--border) !important;
            border-radius: 18px !important;
            font-family: 'DM Sans', sans-serif;
            overflow: hidden;
        }

        .modal-inner-body {
            padding: 36px 28px 16px;
            text-align: center;
        }

        .modal-icon {
            font-size: 2rem;
            color: var(--muted);
            display: block;
            margin-bottom: 12px;
        }

        .modal-question {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--ink);
            margin: 0 0 6px;
        }

        .modal-sub {
            font-size: 0.78rem;
            color: var(--muted);
        }

        .modal-footer-custom {
            padding: 16px 28px 28px;
            display: flex;
            gap: 10px;
            border-top: 1px solid var(--border);
            background: var(--cream);
        }

        .btn-cancel {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-cancel:hover { background: var(--sand); color: var(--brown); }

        .btn-confirm {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: var(--brown);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .btn-confirm:hover { background: var(--ink); color: white; }

        /* ── MOBILE NAV ── */
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
        @media (max-width: 576px){

            .modal-dialog{
                margin: 1rem auto !important;
                width: calc(100% - 32px);
                max-width: 340px;
            }

        }

        body.cart-no-animation .card {
            animation: none !important;
        }

    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="logo">Kopi Desa <span>Est. 2026</span></div>
    <a href="index.php?page=menu" class="nav-item"><i class="bi bi-grid"></i> Menu</a>
    <a href="index.php?page=keranjang" class="nav-item active"><i class="bi bi-bag"></i> Keranjang</a>
</aside>

<!-- MOBILE NAV -->
<nav class="navbar-mobile">
    <span class="logo-m">KOPI DESA</span>
    <a href="index.php?page=menu"><i class="bi bi-arrow-left"></i></a>
</nav>

<!-- MAIN -->
<main class="main">
    <div class="card">

        <!-- HEADER -->
        <div class="card-head">
            <h2>Keranjang</h2>
            <p>Periksa pesanan Anda sebelum melanjutkan.</p>
        </div>

        <!-- ITEM LIST -->
        <div class="items-list">
            <?php
            $total_bayar = 0;
            if (!empty($_SESSION['keranjang'])):
                foreach ($_SESSION['keranjang'] as $id_menu => $jumlah):
                    $query = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu = '$id_menu'");
                    $data  = mysqli_fetch_assoc($query);
                    if ($data):
                        $subtotal     = $data['harga'] * $jumlah;
                        $total_bayar += $subtotal;
            ?>
            <div class="cart-row">
                <div class="item-info">
                    <div class="item-name"><?= $data['nama_menu'] ?></div>
                    <div class="item-unit-price">Rp <?= number_format($data['harga'], 0, ',', '.') ?></div>
                </div>

                <div class="qty-control">
                    <a href="index.php?page=decrease_qty&id=<?= $id_menu ?>" class="btn-qty">−</a>
                    <span class="qty-number"><?= $jumlah ?></span>
                    <a href="index.php?page=increase_qty&id=<?= $id_menu ?>" class="btn-qty">+</a>
                </div>

                <div class="item-right">
                    <span class="item-subtotal">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                    <a href="index.php?page=remove_from_cart&id=<?= $id_menu ?>"
                       class="btn-remove"
                       title="Hapus">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </div>
            <?php
                    endif;
                endforeach;
            else:
            ?>
            <div class="empty-state">
                <i class="bi bi-bag-x"></i>
                <p>Keranjang kamu masih kosong.</p>
                <a href="index.php?page=menu" class="btn-back">Lihat Menu</a>
            </div>
            <?php endif; ?>
        </div>

        <!-- FOOTER -->
        <?php if ($total_bayar > 0): ?>
        <div class="card-foot">
            <div class="summary-line">
                <span>Subtotal</span>
                <span>Rp <?= number_format($total_bayar, 0, ',', '.') ?></span>
            </div>
            <div class="summary-line">
                <span>Pajak &amp; Layanan</span>
                <span class="val-green">Gratis</span>
            </div>

            <hr class="divider">

            <div class="total-row">
                <span class="total-label">Total</span>
                <span class="total-amount">Rp <?= number_format($total_bayar, 0, ',', '.') ?></span>
            </div>

            <a href="index.php?page=checkout" class="btn-checkout">
                <i class="bi bi-check2-circle"></i>
                Konfirmasi Pesanan
            </a>
        </div>
        <?php endif; ?>

    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const storageKey = 'keranjangPageAnimated';
        if (sessionStorage.getItem(storageKey)) {
            document.body.classList.add('cart-no-animation');
        } else {
            sessionStorage.setItem(storageKey, 'true');
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
