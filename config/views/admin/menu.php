<?php
include __DIR__ . '/../../../config/koneksi.php';

$query = "SELECT * FROM menu ORDER BY id_menu DESC";
$menus = mysqli_query($conn, $query);

if (!$menus) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu - Kopi Desa</title>

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
        --green: #27ae60;
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

    .top-head h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 4px;
    }

    .top-head p {
        color: var(--muted);
        font-size: .92rem;
    }

    /* ===== TOOLBAR ===== */

    .toolbar {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        align-items: center;
    }

    .search-wrap {
        position: relative;
        flex: 1;
    }

    .search-wrap i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: 1rem;
        pointer-events: none;
    }

    .search-input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border-radius: 13px;
        border: 1px solid var(--border);
        background: rgba(255, 255, 255, .85);
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        color: var(--ink);
        outline: none;
        transition: .2s;
    }

    .search-input:focus {
        border-color: var(--brown-light);
        background: #fff;
    }

    .filter-select {
        padding: 10px 14px;
        border-radius: 13px;
        border: 1px solid var(--border);
        background: rgba(255, 255, 255, .85);
        font-family: 'DM Sans', sans-serif;
        font-size: .88rem;
        color: var(--ink);
        cursor: pointer;
        outline: none;
    }

    .btn-tambah {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--brown);
        color: #fff;
        border: none;
        border-radius: 13px;
        padding: 10px 20px;
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        font-weight: 600;
        cursor: pointer;
        transition: .25s;
        white-space: nowrap;
        box-shadow: 0 6px 18px rgba(92, 61, 46, .2);
        text-decoration: none;
    }

    .btn-tambah:hover {
        background: var(--brown-light);
        color: #fff;
    }

    /* ===== CARD GRID ===== */

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        align-content: start;
    }

    .menu-card {
        background: rgba(255, 255, 255, .88);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        transition: .25s ease;
        display: flex;
        flex-direction: column;
    }

    .menu-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 32px rgba(92, 61, 46, .12);
    }

    .card-img-wrap {
        width: 100%;
        height: 130px;
        background: linear-gradient(135deg, #f5ece6, #faf7f4);
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid var(--border);
        position: relative;
        overflow: hidden;
    }

    .card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: .7rem;
        font-weight: 700;
    }

    .badge-tersedia {
        background: #eaf6f0;
        color: #1a6b3e;
    }

    .badge-habis {
        background: #fdf0ef;
        color: #a83228;
    }

    .card-body {
        padding: 19px 15px 10px;
        flex: 1;
    }

    .card-name {
        font-weight: 700;
        font-size: .92rem;
        color: var(--ink);
        margin-bottom: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cat-pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        margin-bottom: 8px;
        font-size: .72rem;
        font-weight: 600;
    }

    .cat-coffee    { background: #f5ece6; color: #7a4525; }
    .cat-noncoffee { background: #e8f1f8; color: #1a4d8b; }
    .cat-snack     { background: #fdf5e0; color: #8a6010; }

    .card-footer-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px 13px;
        border-top: 1px solid var(--border);
    }

    .card-price {
        font-family: 'Playfair Display', serif;
        font-size: .98rem;
        font-weight: 700;
        color: var(--brown);
    }

    .card-actions {
        display: flex;
        gap: 7px;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        cursor: pointer;
        transition: .2s;
        background: transparent;
        color: var(--muted);
        text-decoration: none;
    }

    .btn-action:hover {
        background: var(--sand);
    }

    .btn-edit:hover {
        color: #b97a20;
        border-color: #e8c87a;
    }

    .btn-delete:hover {
        color: #c0392b;
        border-color: #f5b8b3;
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 0;
        color: var(--muted);
    }

    .empty-state i {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 10px;
        opacity: .5;
    }

    /* ===== MODAL ===== */

    .modal.fade .modal-dialog {
        transform: scale(.93) translateY(10px);
        transition: .25s ease;
    }

    .modal.show .modal-dialog {
        transform: scale(1) translateY(0);
    }

    .modal-content {
        border: none;
        border-radius: 24px;
        overflow: hidden;
        background: rgba(255, 255, 255, .97);
        backdrop-filter: blur(18px);
        box-shadow: 0 24px 60px rgba(0, 0, 0, .15), 0 6px 20px rgba(92, 61, 46, .10);
    }

    .modal-header {
        border: none;
        padding: 22px 26px 10px;
        background: linear-gradient(to bottom, rgba(250, 247, 244, .9), rgba(255, 255, 255, .7));
    }

    .modal-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--brown);
    }

    .modal-body {
        padding: 22px 26px;
    }

    .modal-footer {
        border: none;
        padding: 16px 26px 24px;
        background: rgba(250, 247, 244, .55);
    }

    .form-label,
    .modal-body label {
        font-size: .82rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--brown);
        margin-bottom: 7px;
    }

    .form-control,
    .form-select {
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 11px 15px;
        font-size: .9rem;
        font-family: 'DM Sans', sans-serif;
        background: var(--cream);
        transition: .25s ease;
        box-shadow: none;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--brown-light);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(139, 99, 71, .12);
    }

    input[type="file"].form-control {
        padding: 10px 14px;
    }

    .preview-img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 16px;
        border: 2px solid var(--border);
    }

    .modal .btn {
        border: none;
        border-radius: 13px;
        padding: 10px 20px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        transition: .25s ease;
    }

    .modal .btn-primary {
        background: var(--brown);
        color: #fff;
    }

    .modal .btn-primary:hover {
        background: var(--brown-light);
        transform: translateY(-1px);
    }

    .modal .btn-success {
        background: var(--green);
        color: #fff;
    }

    .modal .btn-success:hover {
        background: #219150;
        transform: translateY(-1px);
    }

    .modal .btn-secondary {
        background: #ebe5e1;
        color: var(--brown);
    }

    .modal .btn-secondary:hover {
        background: #ddd2cb;
    }

    .btn-close {
        opacity: .6;
        transition: .2s ease;
    }

    .btn-close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    /* ===== RESPONSIVE ===== */

    @media (max-width: 1100px) {
        .menu-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            display: none;
        }

        .main-content {
            margin-left: 0;
            padding: 24px 18px;
        }

        .menu-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .menu-grid {
            grid-template-columns: 1fr;
        }
    }
    .card-desc{
    font-size:.78rem;
    color:var(--muted);
    line-height:1.1;
    padding-right:40px ;
    margin-top:-5px;
    margin-bottom:5px;

    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;

    min-height:38px;
}

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
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="/KopiDesa/public/index.php?page=admin_menu" class="nav-link-admin active">
            <i class="bi bi-cup-hot"></i> Data Menu
        </a>

        <a href="/KopiDesa/public/index.php?page=admin_pesanan" class="nav-link-admin">
            <i class="bi bi-cart-check"></i> Data Pesanan
        </a>

        <a href="/KopiDesa/public/index.php?page=admin_riwayat" class="nav-link-admin">
            <i class="bi bi-clock-history"></i> Riwayat
        </a>

        <a href="/KopiDesa/public/index.php?page=logout" class="nav-link-admin logout">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>

    </nav>

</aside>

<!-- MAIN -->
<main class="main-content">

    <!-- TOP HEAD -->
    <div class="top-head d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Kelola Menu</h2>
            <p>Tambah, edit, dan hapus menu Kopi Desa</p>
        </div>
        <button class="btn-tambah"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle"></i> Tambah Menu
        </button>
    </div>

    <!-- TOOLBAR SEARCH & FILTER -->
    <div class="toolbar">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text"
                   id="searchInput"
                   class="search-input"
                   placeholder="Cari nama menu..."
                   oninput="filterCards()">
        </div>
        <select class="filter-select" id="filterKategori" onchange="filterCards()">
            <option value="">Semua Kategori</option>
            <option value="Coffee">Coffee</option>
            <option value="Non-Coffee">Non-Coffee</option>
            <option value="Snack">Snack</option>
        </select>
    </div>

    <!-- CARD GRID -->
    <div class="menu-grid" id="menuGrid">

        <?php while ($m = mysqli_fetch_assoc($menus)): ?>

        <?php
            $kat = $m['kategori_menu'];
            if ($kat === 'Coffee') $catClass = 'cat-coffee';
            elseif ($kat === 'Non-Coffee') $catClass = 'cat-noncoffee';
            else $catClass = 'cat-snack';
        ?>

        <div class="menu-card"
             data-nama="<?= strtolower(htmlspecialchars($m['nama_menu'])) ?>"
             data-kategori="<?= htmlspecialchars($m['kategori_menu']) ?>">

            <!-- GAMBAR -->
            <div class="card-img-wrap">
                <img src="/KopiDesa/public/assets/uploads/<?= htmlspecialchars($m['gambar']) ?>"
                     alt="<?= htmlspecialchars($m['nama_menu']) ?>"
                     onerror="this.style.display='none'">

                <?php if ($m['status'] == 'tersedia'): ?>
                    <span class="card-status-badge badge-tersedia">Tersedia</span>
                <?php else: ?>
                    <span class="card-status-badge badge-habis">Tidak Tersedia</span>
                <?php endif; ?>
            </div>

            <!-- BODY -->
<div class="card-body">
        <span class="cat-pill <?= $catClass ?>">
        <?= htmlspecialchars($m['kategori_menu']) ?>
    </span>

    <div class="card-name">
        <?= htmlspecialchars($m['nama_menu']) ?>
    </div>

    <div class="card-desc">
        <?= !empty($m['deskripsi']) 
            ? htmlspecialchars($m['deskripsi']) 
            : 'Tidak ada deskripsi menu.' ?>
    </div>



</div>

            <!-- FOOTER -->
            <div class="card-footer-row">
                <span class="card-price">
                    Rp <?= number_format($m['harga'], 0, ',', '.') ?>
                </span>
                <div class="card-actions">

                    <!-- TOMBOL EDIT -->
                    <button class="btn-action btn-edit"
                            title="Edit"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEdit<?= $m['id_menu'] ?>">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <!-- TOMBOL HAPUS -->
                    <a href="/KopiDesa/public/index.php?page=hapus_menu&id=<?= $m['id_menu'] ?>"
                       class="btn-action btn-delete"
                       title="Hapus"
                       onclick="return confirm('Hapus menu ini?')">
                        <i class="bi bi-trash"></i>
                    </a>

                </div>
            </div>

        </div>

        <?php endwhile; ?>

        <!-- EMPTY STATE (tersembunyi, muncul via JS) -->
        <div class="empty-state" id="emptyState" style="display:none;">
            <i class="bi bi-cup-hot"></i>
            <p>Tidak ada menu yang ditemukan.</p>
        </div>

    </div>

</main>

<!-- ==============================
     MODAL EDIT (per menu)
     ============================== -->

<?php
mysqli_data_seek($menus, 0);
while ($m = mysqli_fetch_assoc($menus)):
?>

<div class="modal fade"
     id="modalEdit<?= $m['id_menu'] ?>"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <form action="index.php?page=edit_menu_aksi"
              method="POST"
              enctype="multipart/form-data"
              class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="id_menu"    value="<?= $m['id_menu'] ?>">
                <input type="hidden" name="gambar_lama" value="<?= $m['gambar'] ?>">

                <!-- NAMA -->
                <div class="mb-3">
                    <label class="form-label">Nama Menu</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="<?= htmlspecialchars($m['nama_menu']) ?>"
                           required>
                </div>

                <!-- KATEGORI -->
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="Coffee"      <?= $m['kategori_menu'] == 'Coffee'      ? 'selected' : '' ?>>Coffee</option>
                        <option value="Non-Coffee"  <?= $m['kategori_menu'] == 'Non-Coffee'  ? 'selected' : '' ?>>Non-Coffee</option>
                        <option value="Snack"       <?= $m['kategori_menu'] == 'Snack'       ? 'selected' : '' ?>>Snack</option>
                    </select>
                </div>

                <!-- HARGA -->
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number"
                           name="harga"
                           class="form-control"
                           value="<?= $m['harga'] ?>"
                           required>
                </div>
                <!-- DESKRIPSI -->
<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea 
        name="deskripsi"
        class="form-control"
        rows="4"><?= htmlspecialchars($m['deskripsi']) ?></textarea>
</div>

                <!-- STATUS -->
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="tersedia"       <?= $m['status'] == 'tersedia'       ? 'selected' : '' ?>>Tersedia</option>
                        <option value="tidak tersedia" <?= $m['status'] == 'tidak tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
                    </select>
                </div>


                <!-- FOTO -->
                <div class="mb-3">
                    <label class="form-label">Ganti Foto</label>
                    <input type="file" name="gambar" class="form-control">
                    <div class="mt-3">
                        <img src="/KopiDesa/public/assets/uploads/<?= htmlspecialchars($m['gambar']) ?>"
                             class="preview-img"
                             onerror="this.style.display='none'">
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>

        </form>

    </div>

</div>

<?php endwhile; ?>

<!-- ==============================
     MODAL TAMBAH
     ============================== -->

<div class="modal fade" id="modalTambah" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <form action="index.php?page=tambah_menu_aksi"
              method="POST"
              enctype="multipart/form-data"
              class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- NAMA -->
                <div class="mb-3">
                    <label class="form-label">Nama Menu</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <!-- KATEGORI -->
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="Coffee">Coffee</option>
                        <option value="Non-Coffee">Non-Coffee</option>
                        <option value="Snack">Snack</option>
                    </select>
                </div>

                <!-- HARGA -->
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>

                <!-- DESKRIPSI -->
<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea 
        name="deskripsi"
        class="form-control"
        rows="4"
        placeholder="Masukkan deskripsi menu..."></textarea>
</div>

                <!-- FOTO -->
                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="gambar" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>

        </form>

    </div>

</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SEARCH & FILTER -->
<script>
function filterCards() {
    const q      = document.getElementById('searchInput').value.toLowerCase();
    const f      = document.getElementById('filterKategori').value;
    const cards  = document.querySelectorAll('#menuGrid .menu-card');
    const empty  = document.getElementById('emptyState');
    let visible  = 0;

    cards.forEach(card => {
        const nama    = card.dataset.nama;
        const kategori = card.dataset.kategori;
        const matchQ  = nama.includes(q);
        const matchF  = !f || kategori === f;

        if (matchQ && matchF) {
            card.style.display = 'flex';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    empty.style.display = visible === 0 ? 'block' : 'none';
}
</script>

</body>
</html>