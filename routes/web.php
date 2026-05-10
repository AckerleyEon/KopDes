<?php

$page = $_GET['page'] ?? 'login';

switch ($page) {

    case 'login':
        include '../app/views/admin/login.php';
        break;

    case 'dashboard':
        include '../app/views/admin/dashboard.php';
        break;

    case 'menu_admin':
        include '../app/controllers/MenuController.php';
        include '../app/models/Menu.php';
        $menu = new Menu($conn);
        $data = $menu->getAll();
        include '../app/views/admin/menu.php';
        break;

    case 'pesanan_admin':
        include '../app/controllers/PesananController.php';
        include '../app/models/Pesanan.php';
        $pesanan = new Pesanan($conn);
        $data = $pesanan->getAll();
        include '../app/views/admin/pesanan.php';
        break;
}