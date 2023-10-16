<?php
class Kasi_model extends CI_Model {
    
    public function login($username, $password) {
        $sql = "SELECT * FROM kasi WHERE username = ? AND password = md5(?)";
        $query = $this->db->query($sql, array($username, $password));
        $kasi = $query->row();
        if ($kasi) {
            return $kasi;
        }
        return false;
    }

    public function getKasi(){
        $this->db->from('kasi');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getKasiID($id){
        return $this->db->get_where('kasi', array('id' => $id))->row();
    }
    
    public function updateKasi($id,$data){
        $this->db->where('id', $id);
        return $this->db->update('kasi', $data);
    }
}
?>
