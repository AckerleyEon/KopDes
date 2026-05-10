<?php
$conn = mysqli_connect('localhost','root','','kopdes_dinein');
if (!$conn) { echo 'CONNECT FAIL: '.mysqli_connect_error(); exit(1); }
$sql = "SELECT p.id_pesanan, p.no_meja, p.total_harga, p.tanggal, GROUP_CONCAT(CONCAT(m.nama_menu, '|', pd.jumlah, '|', pd.harga, '|', pd.subtotal) SEPARATOR '||') AS items FROM pesanan p LEFT JOIN pesanan_detail pd ON p.id_pesanan = pd.id_pesanan LEFT JOIN menu m ON pd.id_menu = m.id_menu WHERE p.status = 'menunggu' GROUP BY p.id_pesanan, p.no_meja, p.total_harga, p.tanggal ORDER BY p.tanggal ASC";
$res = mysqli_query($conn,$sql);
if (!$res) { echo 'QUERY FAIL: '.mysqli_error($conn); exit(1); }
echo 'ROWS='.mysqli_num_rows($res)."\n";
while ($row = mysqli_fetch_assoc($res)) {
    echo $row['id_pesanan'].'|'.$row['no_meja'].'|'.$row['total_harga'].'|'.substr($row['items'],0,50)."\n";
}
?>
