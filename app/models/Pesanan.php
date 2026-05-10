<?php
class Pesanan {
    private $db;
    public function __construct($db_conn) { $this->db = $db_conn; }

    public function getIncomingOrders() {
        return mysqli_query($this->db, "SELECT * FROM pesanan ORDER BY tanggal DESC");
    }

    public function updateStatus($id, $status) {
        return mysqli_query($this->db, "UPDATE pesanan SET status = '$status' WHERE id_pesanan = $id");
    }
}
?>