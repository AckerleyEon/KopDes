<?php
$conn = mysqli_connect('localhost', 'root', '', 'kopdes_dinein');
if (!$conn) {
    echo 'CONNECT_FAIL: ' . mysqli_connect_error();
    exit(1);
}
$queries = [
    'menu' => 'SELECT COUNT(*) AS total FROM menu',
    'pending' => "SELECT COUNT(*) AS total FROM pesanan WHERE status = 'menunggu'",
    'profit' => "SELECT SUM(total_harga) AS total FROM pesanan WHERE status = 'selesai'",
    'sale' => "SELECT COUNT(*) AS total FROM pesanan WHERE status = 'selesai'"
];
foreach ($queries as $name => $sql) {
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        echo "$name FAIL: " . mysqli_error($conn) . "\n";
        continue;
    }
    $row = mysqli_fetch_assoc($res);
    echo "$name=" . ($row['total'] ?? 0) . "\n";
}
