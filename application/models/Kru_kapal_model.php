<?php
class Kru_kapal_model extends CI_Model {
    
    public function login($username, $password) {
        $sql = "SELECT * FROM kru_kapal WHERE username = ? AND password = md5(?)";
        $query = $this->db->query($sql, array($username, $password));
        $kru_kapal = $query->row();
        if ($kru_kapal) {
            return $kru_kapal;
        }
        return false;
    }
    public function konfirmasiKruKapal($id,$konfirmasi){
        $this->db->where('id', $id);
        return $this->db->update('kru_kapal', ["konfirmasi"=>$konfirmasi]);
    }
    public function getKruKapals(){
        $this->db->select('kru_kapal.*, kapal.nama as nama_kapal');
        $this->db->from('kru_kapal');
        $this->db->join('kapal', 'kru_kapal.kapal = kapal.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function getKruKapal($id){
        return $this->db->get_where('kru_kapal', array('id' => $id))->row();
    }

    public function checkKruKapalUsername($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('kru_kapal');
        return ($query->num_rows() === 0);
    }

    public function saveKruKapal($data) {
        return $this->db->insert('kru_kapal', $data);
    }

    public function updateKruKapal($id,$data){
        $this->db->where('id', $id);
        return $this->db->update('kru_kapal', $data);
    }
    
    public function deleteKruKapal($id) {
        return $this->db->where('id', $id)->delete('kru_kapal');
    }
}
?>
