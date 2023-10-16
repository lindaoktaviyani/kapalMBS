<?php
class Permohonan_perbaikan_model extends CI_Model {
    //kru
    public function getPermohonanPerbaikansKru($id_kapal){
        return $this->db->get_where('permohonan_perbaikan', array('kapal' => $id_kapal))->result();
    }
    public function savePermohonanPerbaikan($data) {
        return $this->db->insert('permohonan_perbaikan', $data);
    }
    
    //admin
    public function getPermohonanPerbaikansAdmin(){
        $this->db->select('permohonan_perbaikan.*, kapal.nama, penugasan_perbaikan.setuju_marine as setuju_penugasan_marine');
        $this->db->from('permohonan_perbaikan');
        $this->db->join('(SELECT *
                        FROM penugasan_perbaikan
                        WHERE id IN (SELECT MAX(id)
                                     FROM penugasan_perbaikan
                                     GROUP BY permohonan_perbaikan)) AS penugasan_perbaikan', 'penugasan_perbaikan.permohonan_perbaikan = permohonan_perbaikan.id', 'left');
        $this->db->join('kapal', 'permohonan_perbaikan.kapal = kapal.id');
        $query = $this->db->get();
        return $query->result();        
    }
    public function konfirmasiPermohonanPerbaikanAdmin($id,$konfirmasi){
        $this->db->where('id', $id);
        return $this->db->update('permohonan_perbaikan', ["setuju_admin"=>$konfirmasi]);
    }

    public function getPermohonanPerbaikan($id){
        $this->db->select('permohonan_perbaikan.*, kapal.nama as nama_kapal');
        $this->db->from('permohonan_perbaikan');
        $this->db->join('kapal', 'permohonan_perbaikan.kapal = kapal.id');
        $this->db->where('permohonan_perbaikan.id',$id);
        $query = $this->db->get();
        return $query->row();
    }
}
?>
