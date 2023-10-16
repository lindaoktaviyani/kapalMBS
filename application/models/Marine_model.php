<?php
class Marine_model extends CI_Model {
    
    public function login($username, $password) {
        $sql = "SELECT * FROM marine WHERE username = ? AND password = md5(?)";
        $query = $this->db->query($sql, array($username, $password));
        $marine = $query->row();
        if ($marine) {
            return $marine;
        }
        return false;
    }

    public function getMarines(){
        return $this->db->get('marine')->result();
    }

    public function getMarine($id){
        return $this->db->get_where('marine', array('id' => $id))->row();
    }

    public function checkMarineUsername($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('marine');
        return ($query->num_rows() === 0);
    }

    public function saveMarine($data) {
        return $this->db->insert('marine', $data);
    }

    public function updateMarine($id,$data){
        $this->db->where('id', $id);
        return $this->db->update('marine', $data);
    }

    public function deleteMarine($id) {
        return $this->db->where('id', $id)->delete('marine');
    }
    
    public function checkKetersediaanMarine() {
        $query = $this->db->get('marine');
        return ($query->num_rows() !== 0);
    }
}
?>
