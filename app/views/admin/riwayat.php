<?php
if (!isset($conn)) {
    include __DIR__ . '/../../../config/koneksi.php';
}

$query = "
SELECT 
    p.id_pesanan,
    p.no_meja,
    p.total_harga,
    p.tanggal,
    p.status,
    m.nama_menu,
    pd.jumlah
FROM pesanan p
JOIN pesanan_detail pd ON p.id_pesanan = pd.id_pesanan
JOIN menu m ON pd.id_menu = m.id_menu
WHERE p.status IN ('terkonfirmasi','dibatalkan','selesai')
ORDER BY p.id_pesanan DESC
";

$result = mysqli_query($conn, $query);

$pesanan_list = [];
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id_pesanan'];
    if (!isset($pesanan_list[$id])) {
        $pesanan_list[$id] = [
            'id_pesanan' => $row['id_pesanan'],
            'no_meja'    => $row['no_meja'],
            'total_harga'=> $row['total_harga'],
            'tanggal'    => $row['tanggal'],
            'status'     => $row['status'],
            'items'      => [],
        ];
    }
    $pesanan_list[$id]['items'][] = [
        'nama_menu' => $row['nama_menu'],
        'jumlah'    => $row['jumlah'],
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Riwayat Pesanan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    :root{
        --brown:#5c3d2e;
        --brown-light:#8b6347;
        --cream:#faf7f4;
        --sand:#f3ece6;
        --ink:#1a1412;
        --muted:#9c8b82;
        --border:#e8ddd6;
        --sidebar-w:230px;
    }

    body{
        font-family:'DM Sans',sans-serif;
        background:linear-gradient(135deg,#faf7f4,#f3ece6);
    }

    /* SIDEBAR */
    .sidebar{
        position:fixed; top:0; left:0;
        width:230px; height:100vh;
        background:rgba(255,255,255,0.82);
        backdrop-filter:blur(14px);
        border-right:1px solid #e8ddd6;
        padding:28px 18px;
        z-index:1000;
        display:flex; flex-direction:column;
    }
    .sidebar nav{ margin-top:4px; display:flex; flex-direction:column; flex:1; }
    .sidebar-header{ padding-bottom:24px; margin-bottom:20px; border-bottom:1px solid #e8ddd6; text-align:center; }
    .sidebar-header h4{ font-family:'Playfair Display',serif; font-size:1.3rem; font-weight:700; color:#5c3d2e; letter-spacing:.08em; margin:0; }
    .sidebar-header span{ display:block; margin-top:4px; font-size:.72rem; letter-spacing:.18em; color:#9c8b82; text-transform:uppercase; }
    .nav-link-admin{ display:flex; align-items:center; gap:14px; padding:13px 16px; border-radius:14px; color:#9c8b82; text-decoration:none; font-size:.92rem; font-weight:500; transition:.25s ease; margin-bottom:6px; }
    .nav-link-admin i{ font-size:1.1rem; }
    .nav-link-admin:hover{ background:#f3ece6; color:#5c3d2e; transform:translateX(3px); }
    .nav-link-admin.active{ background:#5c3d2e; color:#fff; box-shadow:0 10px 25px rgba(92,61,46,.18); }
    .nav-link-admin.logout{ margin-top:auto; color:#c0392b; }
    .nav-link-admin.logout:hover{ background:rgba(192,57,43,.08); color:#c0392b; }

    /* MAIN */
    .main-content{ margin-left:var(--sidebar-w); padding:42px; }
    .main-content h2{ font-family:'Playfair Display',serif; font-size:2rem; }

    /* SEARCH BOX */
    .search-box{ position:relative; width:220px; }
    .search-box i{ position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--muted); font-size:.9rem; pointer-events:none; }
    .search-box input{ width:100%; padding:9px 14px 9px 36px; border:1px solid var(--border); border-radius:10px; font-family:'DM Sans',sans-serif; font-size:.88rem; background:#fff; color:var(--ink); outline:none; transition:border-color .2s,box-shadow .2s; }
    .search-box input:focus{ border-color:var(--brown-light); box-shadow:0 0 0 3px rgba(92,61,46,.08); }
    .search-box input::placeholder{ color:var(--muted); }

    /* ── TABLE WRAPPER ── */
    .table-wrap {
        background: #fff;
        border-radius: 18px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 24px rgba(92,61,46,.07);
        overflow: hidden;
    }

    /* ── TABLE HEAD ── */
    .table-riwayat { width:100%; border-collapse:collapse; }

    .table-riwayat thead tr {
        background: var(--brown);
    }

    .table-riwayat thead th {
        padding: 15px 18px;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: rgba(255,255,255,.75);
        border: none;
        white-space: nowrap;
    }

    .table-riwayat thead th:first-child { border-radius: 0; }

    /* ── TABLE BODY ── */
    .table-riwayat tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }

    .table-riwayat tbody tr:last-child { border-bottom: none; }

    .table-riwayat tbody tr:hover { background: #fdf9f7; }

    .table-riwayat tbody td {
        padding: 14px 18px;
        font-size: .9rem;
        vertical-align: middle;
        color: var(--ink);
    }

    /* ID cell */
    .cell-id {
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--brown);
    }
    .cell-id sup {
        font-family: 'DM Sans', sans-serif;
        font-size: .65rem;
        font-weight: 600;
        color: var(--muted);
    }

    /* Meja cell */
    .cell-meja {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--sand);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: .8rem;
        font-weight: 600;
        color: var(--brown);
    }

    /* Tanggal */
    .cell-date-main { font-size: .88rem; font-weight: 500; color: var(--ink); }
    .cell-date-time { font-size: .75rem; color: var(--muted); margin-top: 1px; }

    /* Total */
    .cell-total { font-weight: 700; font-size: .92rem; color: var(--ink); }

    /* Status pills */
    .pill-selesai {
        display: inline-flex; align-items: center; gap: 5px;
        background: #dcfce7; color: #16a34a;
        padding: 5px 12px; border-radius: 20px;
        font-size: .75rem; font-weight: 700;
    }
    .pill-batal {
        display: inline-flex; align-items: center; gap: 5px;
        background: #fee2e2; color: #dc2626;
        padding: 5px 12px; border-radius: 20px;
        font-size: .75rem; font-weight: 700;
    }
    .pill-dot {
        width: 6px; height: 6px; border-radius: 50%;
        display: inline-block;
    }
    .pill-selesai .pill-dot { background: #16a34a; }
    .pill-batal  .pill-dot { background: #dc2626; }

    /* Detail button */
    .btn-detail {
        display: inline-flex; align-items: center; gap: 6px;
        background: transparent;
        border: 1px solid var(--border);
        color: var(--brown);
        padding: 6px 14px; border-radius: 10px;
        font-size: .8rem; font-weight: 600;
        cursor: pointer;
        transition: background .2s, border-color .2s, color .2s;
    }
    .btn-detail:hover {
        background: var(--brown);
        border-color: var(--brown);
        color: #fff;
    }

    /* NO RESULT */
    .no-result {
        text-align:center; color:var(--muted);
        font-size:.92rem; padding:40px 0;
    }
    .no-result i { font-size:2rem; display:block; margin-bottom:8px; opacity:.5; }

    /* TABLE FOOTER */
    .table-footer {
        padding: 12px 18px;
        border-top: 1px solid var(--border);
        font-size: .78rem;
        color: var(--muted);
        background: #fdfaf8;
    }

    /* MODAL */
    .modal-content{ border-radius:16px; border:1px solid var(--border); }
    .modal-header{ background:var(--brown); color:#fff; border-radius:15px 15px 0 0; border-bottom:none; }
    .modal-header .btn-close{ filter:invert(1); }
    .modal-title{ font-family:'Playfair Display',serif; font-size:1.1rem; }
    .modal-detail-table thead tr{ background:var(--sand); }
    .modal-detail-table thead th{ font-weight:600; font-size:.85rem; color:var(--brown); padding:10px 14px; border-bottom:1px solid var(--border); }
    .modal-detail-table tbody td{ padding:10px 14px; font-size:.9rem; border-bottom:1px solid var(--border); }
    .modal-detail-table tbody tr:last-child td{ border-bottom:none; }
    .modal-total{ background:var(--sand); border-radius:10px; padding:12px 16px; margin-top:14px; font-weight:600; color:var(--brown); }
</style>
</head>

<body>
<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-header text-center">
        <h4>KOPI DESA</h4>
        <span>Admin Panel</span>
    </div>
    <nav>
        <a href="/KopiDesa/public/index.php?page=dashboard" class="nav-link-admin">
            <i class="bi bi-speedometer2"></i><span>Dashboard</span>
        </a>
        <a href="/KopiDesa/public/index.php?page=admin_menu" class="nav-link-admin">
            <i class="bi bi-cup-hot"></i><span>Data Menu</span>
        </a>
        <a href="/KopiDesa/public/index.php?page=admin_pesanan" class="nav-link-admin">
            <i class="bi bi-cart-check"></i><span>Data Pesanan</span>
        </a>
        <a href="/KopiDesa/public/index.php?page=admin_riwayat" class="nav-link-admin active">
            <i class="bi bi-clock-history"></i><span>Riwayat</span>
        </a>
        <a href="/KopiDesa/public/index.php?page=logout" class="nav-link-admin logout">
            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
        </a>
    </nav>
</aside>

<!-- MAIN -->
<div class="main-content">

    <h2>Riwayat Pesanan</h2>

    <!-- SEARCH BAR -->
    <div class="d-flex align-items-center gap-3 mt-3 mb-3">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="number" id="searchId" placeholder="Cari ID pesanan..." min="1">
        </div>
        <div id="search-info" style="font-size:.85rem;color:var(--muted);"></div>
    </div>

    <!-- TABLE -->
    <div class="table-wrap">
        <div class="table-responsive">
            <table class="table-riwayat">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Meja</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php foreach ($pesanan_list as $p): ?>
                    <tr data-id="<?= $p['id_pesanan'] ?>">

                        <td>
                            <span class="cell-id">
                                <sup>#</sup><?= $p['id_pesanan'] ?>
                            </span>
                        </td>

                        <td>
                            <span class="cell-meja">
                                <i class="bi bi-geo-alt" style="font-size:.75rem;"></i>
                                Meja <?= $p['no_meja'] ?>
                            </span>
                        </td>

                        <td>
                            <div class="cell-date-main"><?= date('d M Y', strtotime($p['tanggal'])) ?></div>
                            <div class="cell-date-time"><?= date('H:i', strtotime($p['tanggal'])) ?></div>
                        </td>

                        <td>
                            <span class="cell-total">Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></span>
                        </td>

                        <td>
                            <?php if ($p['status'] == 'terkonfirmasi'): ?>
                                <span class="pill-selesai">
                                    <span class="pill-dot"></span> Selesai
                                </span>
                            <?php else: ?>
                                <span class="pill-batal">
                                    <span class="pill-dot"></span> Dibatalkan
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <button class="btn-detail"
                                data-bs-toggle="modal"
                                data-bs-target="#modalDetail"
                                data-id="<?= $p['id_pesanan'] ?>"
                                data-meja="<?= $p['no_meja'] ?>"
                                data-tanggal="<?= $p['tanggal'] ?>"
                                data-total="<?= number_format($p['total_harga'], 0, ',', '.') ?>"
                                data-status="<?= $p['status'] ?>"
                                data-items='<?= htmlspecialchars(json_encode($p['items']), ENT_QUOTES) ?>'>
                                <i class="bi bi-eye" style="font-size:.8rem;"></i> Detail
                            </button>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- NO RESULT -->
        <div class="no-result d-none" id="noResult">
            <i class="bi bi-inbox"></i>
            Pesanan tidak ditemukan.
        </div>

        <!-- FOOTER COUNT -->
        <div class="table-footer" id="tableFooter">
            Total <?= count($pesanan_list) ?> pesanan
        </div>
    </div>

</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-receipt me-2"></i>Detail Pesanan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between mb-3" style="font-size:.9rem;color:var(--muted);">
                    <span><i class="bi bi-hash me-1"></i><span id="modal-id"></span></span>
                    <span><i class="bi bi-grid me-1"></i>Meja <span id="modal-meja"></span></span>
                    <span><i class="bi bi-calendar3 me-1"></i><span id="modal-tanggal"></span></span>
                </div>
                <table class="table modal-detail-table mb-0">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th class="text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody id="modal-items"></tbody>
                </table>
                <div class="modal-total d-flex justify-content-between">
                    <span>Total Harga</span>
                    <span>Rp <span id="modal-total"></span></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// SEARCH BY ID
document.getElementById('searchId').addEventListener('input', function () {
    const keyword  = this.value.trim();
    const rows     = document.querySelectorAll('#tableBody tr');
    const info     = document.getElementById('search-info');
    const noResult = document.getElementById('noResult');
    const footer   = document.getElementById('tableFooter');
    let visible    = 0;

    rows.forEach(function (row) {
        const id = row.getAttribute('data-id');
        if (keyword === '' || id.includes(keyword)) {
            row.style.display = ''; visible++;
        } else {
            row.style.display = 'none';
        }
    });

    info.textContent   = keyword ? visible + ' hasil ditemukan' : '';
    footer.textContent = keyword ? visible + ' pesanan ditampilkan' : 'Total ' + rows.length + ' pesanan';
    noResult.classList.toggle('d-none', visible > 0);
});

// MODAL DETAIL
document.getElementById('modalDetail').addEventListener('show.bs.modal', function (e) {
    const btn = e.relatedTarget;
    document.getElementById('modal-id').textContent      = btn.dataset.id;
    document.getElementById('modal-meja').textContent    = btn.dataset.meja;
    document.getElementById('modal-tanggal').textContent = btn.dataset.tanggal;
    document.getElementById('modal-total').textContent   = btn.dataset.total;

    const items = JSON.parse(btn.dataset.items);
    const tbody = document.getElementById('modal-items');
    tbody.innerHTML = '';
    items.forEach(function (item) {
        tbody.innerHTML += `
            <tr>
                <td>${item.nama_menu}</td>
                <td class="text-center">${item.jumlah}</td>
            </tr>
        `;
    });
});
</script>
</body>
</html>