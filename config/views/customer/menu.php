
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Kopi Desa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        *, *::before, *::after{
            box-sizing:border-box;
            margin:0;
            padding:0;
        }

        :root{
            --brown:#5c3d2e;
            --brown-light:#8b6347;
            --cream:#faf7f4;
            --sand:#f0e9e1;
            --ink:#1a1412;
            --muted:#9c8b82;
            --green:#2d6a4f;
            --border:#e8ddd6;
            --sidebar-w:200px;
        }

        html{
            scroll-behavior:smooth;
        }

        body{
            font-family:'DM Sans',sans-serif;
            background:var(--cream);
            color:var(--ink);
            min-height:100vh;
            overflow-x:hidden;
        }

        /* ───────────────── SIDEBAR ───────────────── */
        .sidebar{
            position:fixed;
            top:0;
            left:0;
            width:var(--sidebar-w);
            height:100vh;
            background:white;
            border-right:1px solid var(--border);
            display:flex;
            flex-direction:column;
            padding:40px 24px;
            z-index:1000;
        }

        .logo{
            font-family:'Playfair Display',serif;
            font-size:1.1rem;
            font-weight:700;
            color:var(--brown);
            letter-spacing:.08em;
            text-transform:uppercase;
            margin-bottom:48px;
        }

        .logo span{
            display:block;
            font-family:'DM Sans',sans-serif;
            font-size:.6rem;
            font-weight:400;
            color:var(--muted);
            letter-spacing:.2em;
            margin-top:2px;
        }

        .nav-item{
            display:flex;
            align-items:center;
            gap:10px;
            padding:11px 14px;
            border-radius:10px;
            color:var(--muted);
            background: var(--cream);
            text-decoration:none;
            font-size:.82rem;
            font-weight:500;
            letter-spacing:.02em;
            margin-bottom:4px;
            transition:.2s;
            position:relative;
        }

        .nav-item i{
            font-size:1rem;
        }

        .nav-item:hover{
            background:var(--sand);
            color:var(--brown);
        }

        .nav-item.active{
            background:var(--brown);
            color:white;
        }

        /* ───────────────── MOBILE NAV ───────────────── */
        .navbar-mobile{
            display:none;
            position:sticky;
            top:0;
            z-index:1200;
            background:rgba(255,255,255,.92);
            backdrop-filter:blur(14px);
            border-bottom:1px solid var(--border);
            padding:14px 20px;
            align-items:center;
            justify-content:space-between;
        }

        .logo-m{
            font-family:'Playfair Display',serif;
            font-size:1rem;
            font-weight:700;
            color:var(--brown);
            letter-spacing:.06em;
            text-transform:uppercase;
        }

        .cart-link-m{
            color:var(--brown);
            font-size:1.15rem;
            text-decoration:none;
            position:relative;
        }

        .cart-badge{
            position:absolute;
            top:30px;
            right:-8px;
            background:#dc3545;
            color:white;
            border-radius:50%;
            width:20px;
            height:20px;
            font-size:0.75rem;
            font-weight:600;
            display:none;
            align-items:center;
            justify-content:center;
            z-index:10;
        }

        .cart-badge-mobile{
            position:absolute;
            top:12px;
            right:-6px;
            background:#dc3545;
            color:white;
            border-radius:50%;
            width:18px;
            height:18px;
            font-size:0.7rem;
            font-weight:600;
            display:none;
            align-items:center;
            justify-content:center;
            z-index:10;
        }

        /* ───────────────── MAIN ───────────────── */
        .main{
            margin-left:var(--sidebar-w);
            min-height:100vh;
        }

        /* ───────────────── FIXED TOP AREA ───────────────── */
        .top-area{
            position:sticky;
            top:0;
            z-index:900;
            background:rgba(250,247,244,.92);
            backdrop-filter:blur(14px);
            border-bottom:1px solid rgba(232,221,214,.8);
            padding:30px 36px 18px;
        }

        .page-title{
            font-family:'Playfair Display',serif;
            display:flex;
            justify-content:space-between;
            font-size:1.55rem;
            font-weight:700;
            color:var(--ink);
            margin-bottom:18px;
        }

        /* ───────────────── SEARCH ───────────────── */
        .search-wrap{
            position:relative;
            max-width:420px;
            margin-bottom:16px;
        }

        .search-wrap i{
            position:absolute;
            left:14px;
            top:50%;
            transform:translateY(-50%);
            color:var(--muted);
            font-size:.85rem;
            pointer-events:none;
        }

        .search-wrap input{
            width:100%;
            height:46px;
            padding:10px 16px 10px 40px;
            border-radius:14px;
            border:1px solid var(--border);
            background:white;
            font-family:'DM Sans',sans-serif;
            font-size:.82rem;
            color:var(--ink);
            outline:none;
            transition:.2s;
        }

        .search-wrap input:focus{
            border-color:var(--brown-light);
            box-shadow:0 0 0 4px rgba(92,61,46,.08);
        }

        .search-wrap input::placeholder{
            color:#b9a79d;
        }

        /* ───────────────── CHIPS ───────────────── */
        .chips{
            display:flex;
            gap:8px;
            overflow-x:auto;
            padding-bottom:4px;
            scrollbar-width:none;
        }

        .chips::-webkit-scrollbar{
            display:none;
        }

        .chip{
            padding:8px 16px;
            border-radius:999px;
            border:1px solid var(--border);
            background:white;
            color:var(--muted);
            font-family:'DM Sans',sans-serif;
            font-size:.74rem;
            font-weight:600;
            letter-spacing:.05em;
            white-space:nowrap;
            cursor:pointer;
            transition:.2s;
            flex-shrink:0;
        }

        .chip:hover{
            border-color:var(--brown-light);
            color:var(--brown);
        }

        .chip.active{
            background:var(--brown);
            border-color:var(--brown);
            color:white;
            box-shadow:0 4px 16px rgba(92,61,46,.18);
        }

        /* ───────────────── CONTENT ───────────────── */
        .content-area{
            padding:24px 36px 50px;
        }

        /* ───────────────── MENU GRID ───────────────── */
        .menu-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(210px,1fr));
            gap:16px;
        }

        /* ───────────────── MENU CARD ───────────────── */
        .menu-card{
            background:white;
            border:1px solid var(--border);
            border-radius:18px;
            overflow:hidden;
            transition:.25s;
            animation:fadeUp .35s ease both;
        }

        .menu-card:hover{
            transform:translateY(-4px);
            box-shadow:0 12px 30px rgba(92,61,46,.08);
        }

        @keyframes fadeUp{
            from{
                opacity:0;
                transform:translateY(10px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        .menu-card-img{
            width:100%;
            height:150px;
            object-fit:cover;
            display:block;
            cursor:pointer;
        }

        .menu-card-body{
            padding:14px;
        }

        .menu-card-cat{
            font-size:.65rem;
            font-weight:700;
            letter-spacing:.12em;
            color:var(--muted);
            text-transform:uppercase;
            margin-bottom:5px;
        }

        .menu-card-name{
            font-size:.9rem;
            font-weight:600;
            color:var(--ink);
            margin-bottom:12px;
            overflow:hidden;
            text-overflow:ellipsis;
            white-space:nowrap;
        }

        .menu-card-footer{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
        }

        .menu-card-price{
            font-size:.86rem;
            font-weight:700;
            color:var(--green);
        }

        .btn-add{
            display:inline-flex;
            align-items:center;
            gap:5px;
            padding:7px 12px;
            border-radius:10px;
            background:var(--sand);
            border:1px solid var(--border);
            text-decoration:none;
            font-size:.72rem;
            font-weight:600;
            color:var(--brown);
            transition:.2s;
            white-space:nowrap;
        }

        .btn-add:hover{
            background:var(--brown);
            border-color:var(--brown);
            color:white;
        }

        /* ───────────────── MODAL ───────────────── */
        .modal-content{
            border-radius:20px !important;
            border:1px solid var(--border) !important;
            overflow:hidden;
        }

        .modal-img-wrap{
            position:relative;
        }

        #modalImage{
            width:100%;
            height:220px;
            object-fit:cover;
            display:block;
        }

        .modal-close-btn{
            position:absolute;
            top:12px;
            right:12px;
            width:34px;
            height:34px;
            border-radius:50%;
            border:none;
            background:rgba(0,0,0,.45);
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            cursor:pointer;
        }

        .modal-inner{
            padding:22px 24px 24px;
        }

        .modal-badge{
            display:inline-block;
            padding:4px 10px;
            border-radius:999px;
            background:var(--sand);
            color:var(--brown-light);
            font-size:.65rem;
            font-weight:700;
            letter-spacing:.08em;
            text-transform:uppercase;
            margin-bottom:10px;
        }

        #modalNama{
            font-family:'Playfair Display',serif;
            font-size:1.2rem;
            font-weight:700;
            margin-bottom:4px;
        }

        #modalHarga{
            color:var(--green);
            font-weight:700;
            margin-bottom:12px;
        }

        #modalDeskripsi{
            font-size:.78rem;
            color:var(--muted);
            line-height:1.7;
            margin-bottom:20px;
        }

        .divider{
            border:none;
            border-top:1px solid var(--border);
            margin:18px 0;
        }

        .qty-row{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:20px;
            margin-bottom:18px;
        }

        .qty-btn{
            width:34px;
            height:34px;
            border-radius:50%;
            border:1px solid var(--border);
            background:white;
            display:flex;
            align-items:center;
            justify-content:center;
            cursor:pointer;
            font-size:1.1rem;
            transition:.2s;
        }

        .qty-btn:hover{
            background:var(--sand);
        }

        #qtyValue{
            font-family:'Playfair Display',serif;
            font-size:1.2rem;
            font-weight:700;
            min-width:28px;
            text-align:center;
        }

        #modalButton{
            width:100%;
            height:50px;
            border-radius:14px;
            background:var(--brown);
            color:white;
            text-decoration:none;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            font-size:.82rem;
            font-weight:700;
            letter-spacing:.05em;
            text-transform:uppercase;
            transition:.2s;
        }

        #modalButton:hover{
            background:var(--ink);
            color:white;
        }

        /* ───────────────── RESPONSIVE ───────────────── */
        @media (max-width:1024px){
            .menu-grid{
                grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
            }
        }

        @media (max-width:768px){

            .sidebar{
                display:none;
            }

            .navbar-mobile{
                display:flex;
            }

            .main{
                margin-left:0;
            }

            .top-area{
                top:56px;
                padding:18px 16px 14px;
            }

            .content-area{
                padding:20px 16px 40px;
            }

            .page-title{
                font-size:1.3rem;
            }

            .menu-grid{
                grid-template-columns:repeat(2,1fr);
                gap:12px;
            }

            .menu-card-img{
                height:125px;
            }

            #modalImage{
                height:190px;
            }
        }

        @media (max-width:420px){

            .menu-card-price{
                font-size:.72rem;
            }

            .btn-add{
                font-size:.56rem;
                padding:5px 8px;
            }

        }

        @media (max-width:360px){

            .menu-grid{
                grid-template-columns:1fr;
            }

            .btn-add{
                font-size:.72rem;
                padding:7px 12px;
            }

            .menu-card-price{
                font-size:.86rem;
            }
        }

        @media (max-width:576px){

            .modal-dialog{
                width:calc(100% - 28px);
                max-width:340px;
                margin:1rem auto !important;
            }

        }
        .disabled-card{
    opacity:.6;
    filter:grayscale(100%);
    pointer-events:none;
    position:relative;
}

.disabled-card .menu-card-img{
    filter:grayscale(100%);
}

.unavailable-overlay{
    position:absolute;
    top:12px;
    right:12px;
    background:#dc3545;
    color:white;
    padding:6px 10px;
    border-radius:999px;
    font-size:.7rem;
    font-weight:700;
    z-index:5;
}

.btn-disabled{
    padding:7px 12px;
    border:none;
    border-radius:10px;
    background:#bdbdbd;
    color:white;
    font-size:.72rem;
    font-weight:600;
    cursor:not-allowed;
}
.menu-placeholder{
    width:100%;
    height:150px;
    display:none;
    align-items:center;
    justify-content:center;

    background:
        linear-gradient(
            135deg,
            #5c3d2e,
            #8b6347,
            #c4a484
        );

    color:white;
    font-size:2rem;
}

.disabled-card .menu-placeholder{
    filter:grayscale(100%);
}
#modalPlaceholder{
    width:100%;
    height:220px;
    display:none;
    align-items:center;
    justify-content:center;

    background:
        linear-gradient(
            135deg,
            #5c3d2e,
            #8b6347,
            #c4a484
        );

    color:white;
    font-size:2.5rem;
}

    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="logo">
        Kopi Desa
        <span>Est. 2026</span>
    </div>

    <a href="index.php?page=menu" class="nav-item active">
        <i class="bi bi-grid"></i>
        Menu
    </a>

    <a href="index.php?page=keranjang" class="nav-item">
        <i class="bi bi-bag"></i>
        Keranjang
        <span id="cartBadge" class="cart-badge">0</span>
    </a>
</aside>

<!-- MOBILE NAV -->
<nav class="navbar-mobile">
    <span class="logo-m">Kopi Desa</span>

    <a href="index.php?page=keranjang" class="cart-link-m">
        <i class="bi bi-bag"></i>
        <span id="cartBadgeMobile" class="cart-badge-mobile">0</span>
    </a>
</nav>

<!-- MAIN -->
<main class="main">

    <!-- FIXED HEADER AREA -->
    <div class="top-area">

        <div class="page-title">
            <span>Menu</span> <span>Meja <?= $_SESSION['no_meja'] ?? '0' ?></span>
        </div>

        <!-- SEARCH -->
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari menu...">
        </div>

        <!-- CATEGORY -->
        <div class="chips" id="categoryFilter">
            <button class="chip active" data-filter="all">Semua</button>
            <button class="chip" data-filter="coffee">Coffee</button>
            <button class="chip" data-filter="non-coffee">Non-Coffee</button>
            <button class="chip" data-filter="snack">Snack</button>
        </div>

    </div>

    <!-- CONTENT -->
    <div class="content-area">

        <div class="menu-grid" id="menuList">

            <?php while($row = mysqli_fetch_assoc($menus)): ?>

           <?php 
$status = strtolower($row['status']);
$isUnavailable = $status == 'tidak tersedia';
?>

<div 
    class="menu-card menu-column <?= $isUnavailable ? 'disabled-card' : '' ?>"

    data-category="<?= strtolower(trim($row['kategori_menu'])) ?>"
    data-name="<?= strtolower($row['nama_menu']) ?>"

    <?php if(!$isUnavailable): ?>
        onclick="openDetailModal(this)"

        data-id="<?= $row['id_menu'] ?>"
        data-nama="<?= htmlspecialchars($row['nama_menu']) ?>"
        data-harga="<?= number_format($row['harga'], 0, ',', '.') ?>"
        data-gambar="../public/assets/uploads/<?= $row['gambar'] ?>"
        data-kategori="<?= htmlspecialchars($row['kategori_menu']) ?>"
        data-deskripsi="<?= htmlspecialchars($row['deskripsi']) ?>"
    <?php endif; ?>
>

<?php if(empty($row['gambar'])): ?>

<div class="menu-placeholder" style="display:flex;">
    <i class="bi bi-cup-hot"></i>
</div>

<?php else: ?>

<img 
    src="../public/assets/uploads/<?= $row['gambar'] ?>"
    class="menu-card-img"
    alt=""
    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
>

<div class="menu-placeholder">
    <i class="bi bi-cup-hot"></i>
</div>

<?php endif; ?>

    <div class="menu-card-body">

        <div class="menu-card-cat">
            <?= $row['kategori_menu'] ?>
        </div>

        <div class="menu-card-name">
            <?= $row['nama_menu'] ?>
        </div>

        <div class="menu-card-footer">

            <span class="menu-card-price">
                Rp <?= number_format($row['harga'], 0, ',', '.') ?>
            </span>

            <?php if($isUnavailable): ?>

                <button class="btn-disabled" disabled>
                    Tidak Tersedia
                </button>

            <?php else: ?>

<button 
    class="btn-add" 
    type="button"
    onclick="event.stopPropagation(); addToCardAjax(<?= $row['id_menu'] ?>, 1, event)">
    <i class="bi bi-plus-lg"></i>
    Tambah
</button>

            <?php endif; ?>

        </div>

    </div>

</div>

            <?php endwhile; ?>

        </div>

    </div>

</main>

<!-- MODAL -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="modalNama" aria-modal="true">

    <div class="modal-dialog modal-dialog-centered custom-modal">

        <div class="modal-content">

<div class="modal-img-wrap">

    <img 
        id="modalImage" 
        src="" 
        alt=""
        onerror="this.style.display='none'; document.getElementById('modalPlaceholder').style.display='flex';"
    >

    <div id="modalPlaceholder" class="menu-placeholder">
        <i class="bi bi-cup-hot"></i>
    </div>

    <button class="modal-close-btn" data-bs-dismiss="modal" aria-label="Tutup">
        <i class="bi bi-x-lg"></i>
    </button>

</div>

            <div class="modal-inner">

                <span class="modal-badge" id="modalKategori"></span>

                <div id="modalNama"></div>

                <div id="modalHarga"></div>

                <div id="modalDeskripsi"></div>

                <hr class="divider">

                <div class="qty-row">
                    <button class="qty-btn" onclick="changeQty(-1)">−</button>
                    <span id="qtyValue">1</span>
                    <button class="qty-btn" onclick="changeQty(1)">+</button>
                </div>

                <button id="modalButton" class="btn-add-to-cart" type="button">
                    <i class="bi bi-bag-plus"></i>
                    Tambah ke Keranjang
                </button>

            </div>

        </div>

    </div>

</div>

<script>

let currentQty = 1;

function updateCartButton(id){

    const btn = document.getElementById('modalButton');

    btn.setAttribute('data-id', id);

    btn.onclick = function(e){
        e.preventDefault();
        addToCartAjax(id, currentQty);
    };

}

function openDetailModal(card){

    currentQty = 1;

    const id        = card.getAttribute('data-id');
    const nama      = card.getAttribute('data-nama');
    const harga     = card.getAttribute('data-harga');
    const gambar    = card.getAttribute('data-gambar');
    const kategori  = card.getAttribute('data-kategori');
    const deskripsi = card.getAttribute('data-deskripsi');

    document.getElementById('modalNama').innerText = nama;
    document.getElementById('modalHarga').innerText = 'Rp ' + harga;
    document.getElementById('modalKategori').innerText = kategori;
    document.getElementById('modalDeskripsi').innerText = deskripsi;

    const modalImage = document.getElementById('modalImage');
    const modalPlaceholder = document.getElementById('modalPlaceholder');

    modalPlaceholder.style.display = 'none';
    modalImage.style.display = 'block';

    if(gambar && !gambar.includes('undefined') && !gambar.endsWith('/')){
        modalImage.src = gambar;
    }else{
        modalImage.style.display = 'none';
        modalPlaceholder.style.display = 'flex';
    }

    document.getElementById('qtyValue').innerText = currentQty;

    updateCartButton(id);

    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}

document.addEventListener("DOMContentLoaded", function () {

    // Initialize cart badge
    const initialCartCount = <?php echo isset($_SESSION['keranjang']) ? count($_SESSION['keranjang']) : 0; ?>;

    if (initialCartCount > 0) {

        const badge = document.getElementById('cartBadge');
        const badgeMobile = document.getElementById('cartBadgeMobile');

        badge.innerText = initialCartCount;
        badge.style.display = 'flex';

        badgeMobile.innerText = initialCartCount;
        badgeMobile.style.display = 'flex';
    }

    // FILTER
    const searchInput  = document.getElementById('searchInput');
    const categoryBtns = document.querySelectorAll('.chip');
    const menuColumns  = document.querySelectorAll('.menu-column');

    function runFilter() {

        const searchText = searchInput.value.toLowerCase().trim();

        const activeBtn = document.querySelector('.chip.active');

        const activeCategory = activeBtn.getAttribute('data-filter').toLowerCase();

        menuColumns.forEach(col => {

            const name = col.getAttribute('data-name');
            const cat  = col.getAttribute('data-category');

            const matchSearch = name.includes(searchText);

            const matchCategory = (
                activeCategory === 'all' ||
                cat === activeCategory
            );

            col.style.display = (matchSearch && matchCategory)
                ? ''
                : 'none';

        });

    }

    categoryBtns.forEach(btn => {

        btn.addEventListener('click', function () {

            categoryBtns.forEach(b => b.classList.remove('active'));

            this.classList.add('active');

            runFilter();

        });

    });

    searchInput.addEventListener('input', runFilter);

    // QTY
    window.changeQty = function(amount){

        currentQty = Math.max(1, currentQty + amount);

        document.getElementById('qtyValue').innerText = currentQty;

        const id = document.getElementById('modalButton')
            .getAttribute('data-id');

        updateCartButton(id);

    };

    function getCartTargetRect(){

        const desktopCart = document.querySelector('.sidebar .nav-item[href*="keranjang"]');
        const mobileCart = document.querySelector('.cart-link-m');

        return window.innerWidth <= 768 && mobileCart
            ? mobileCart.getBoundingClientRect()
            : desktopCart
                ? desktopCart.getBoundingClientRect()
                : { top: 0, left: 0, width: 40, height: 40 };

    }

    function animateToCart(sourceElement){

        if(!sourceElement) return;

        const sourceRect = sourceElement.getBoundingClientRect();

        const cartRect = getCartTargetRect();

        const clone = sourceElement.cloneNode(true);

        clone.style.position = 'fixed';
        clone.style.top = `${sourceRect.top}px`;
        clone.style.left = `${sourceRect.left}px`;
        clone.style.width = `${sourceRect.width}px`;
        clone.style.height = `${sourceRect.height}px`;
        clone.style.zIndex = '9999';
        clone.style.pointerEvents = 'none';
        clone.style.margin = '0';
        clone.style.transition = 'transform 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94), top 0.7s ease, left 0.7s ease, opacity 0.7s ease';
        clone.style.transformOrigin = 'center center';
        clone.style.borderRadius = '18px';
        clone.style.objectFit = 'cover';

        document.body.appendChild(clone);

        requestAnimationFrame(() => {

            const targetX = cartRect.left + cartRect.width / 2 - sourceRect.width / 2;

            const targetY = cartRect.top + cartRect.height / 2 - sourceRect.height / 2;

            clone.style.top = `${targetY}px`;

            clone.style.left = `${targetX}px`;

            clone.style.transform = 'scale(0.18)';

            clone.style.opacity = '0.3';

        });

        setTimeout(() => {

            if(clone.parentNode){
                clone.parentNode.removeChild(clone);
            }

        }, 750);

    }

    window.addToCartAjax = function(id, qty){

        const modalImage = document.getElementById('modalImage');

        animateToCart(modalImage);

        const formData = new FormData();

        formData.append('id', id);
        formData.append('qty', qty);

        fetch('index.php?page=add_to_cart', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {

            if(data.success){

                showCartNotification(data.cart_count);

                const modal = bootstrap.Modal.getInstance(
                    document.getElementById('detailModal')
                );

                if(modal) modal.hide();
            }

        })
        .catch(error => console.error('Error:', error));

    }

    function showCartNotification(count){

        const badge = document.getElementById('cartBadge');
        const badgeMobile = document.getElementById('cartBadgeMobile');

        badge.innerText = count;
        badge.style.display = 'flex';

        badgeMobile.innerText = count;
        badgeMobile.style.display = 'flex';

    }

    window.addToCardAjax = function(id, qty, event){

        event.stopPropagation();

        const formData = new FormData();

        formData.append('id', id);
        formData.append('qty', qty);

        const card = event.target.closest('.menu-card');

        const sourceImage = card
            ? card.querySelector('.menu-card-img')
            : event.target;

        animateToCart(sourceImage || event.target);

        fetch('index.php?page=add_to_cart', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {

            if(data.success){
                showCartNotification(data.cart_count);
            }

        })
        .catch(error => console.error('Error:', error));

    }

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>