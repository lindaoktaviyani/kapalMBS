<?php
class Kabid_model extends CI_Model {
    
    public function login($username, $password) {
        $sql = "SELECT * FROM kabid WHERE username = ? AND password = md5(?)";
        $query = $this->db->query($sql, array($username, $password));
        $kabid = $query->row();
        if ($kabid) {
            return $kabid;
        }
        return false;
    }

    public function getKabidID($id){
        return $this->db->get_where('kabid', array('id' => $id))->row();
    }

    public function getKabid(){
        $this->db->from('kabid');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function updateKabid($id,$data){
        $this->db->where('id', $id);
        return $this->db->update('kabid', $data);
    }
}
?>
