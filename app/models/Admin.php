<?php
class Admin {
    private $db;
    public function __construct($db_conn) { $this->db = $db_conn; }

    public function login($username, $password) {
        $query = "SELECT * FROM admin WHERE username = '$username'";
        $result = mysqli_query($this->db, $query);
        $data = mysqli_fetch_assoc($result);
        if ($data && password_verify($password, $data['password'])) {
            return $data;
        }
        return false;
    }
}
?>