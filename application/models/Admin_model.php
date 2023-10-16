<?php
class Admin_model extends CI_Model {
    
    public function login($username, $password) {
        $sql = "SELECT * FROM admin WHERE username = ? AND password = md5(?)";
        $query = $this->db->query($sql, array($username, $password));
        $admin = $query->row();
        if ($admin) {
            return $admin;
        }
        return false;
    }
}
?>
