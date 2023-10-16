<?php
class Kapal_model extends CI_Model {
    public function getKapals(){
        return $this->db->get('kapal')->result();
    }
    public function getKapal($id){
        return $this->db->get_where('kapal', array('id' => $id))->row();
    }
    public function saveKapal($data) {
        return $this->db->insert('kapal', $data);
    }
    public function updateKapal($id,$data){
        $this->db->where('id', $id);
        return $this->db->update('kapal', $data);
    }
    public function deleteKapal($id) {
        return $this->db->where('id', $id)->delete('kapal');
    }
    public function checkKetersediaanKapal() {
        $query = $this->db->get('kapal');
        return ($query->num_rows() !== 0);
    }
}
?>
