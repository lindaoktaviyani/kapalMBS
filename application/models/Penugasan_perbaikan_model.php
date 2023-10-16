<?php
class Penugasan_perbaikan_model extends CI_Model {
    public function savePenugasanPerbaikan($data) {
        return $this->db->insert('penugasan_perbaikan', $data);
    }
    public function getPenugasanPerbaikans(){
        $this->db->select('penugasan_perbaikan.id, kapal.nama as nama_kapal, permohonan_perbaikan.detail_kerusakan, marine.nama as nama_marine, penugasan_perbaikan.setuju_marine');
        $this->db->from('penugasan_perbaikan');
        $this->db->join('permohonan_perbaikan', 'penugasan_perbaikan.permohonan_perbaikan = permohonan_perbaikan.id');
        $this->db->join('marine', 'penugasan_perbaikan.marine = marine.id');
        $this->db->join('kapal', 'permohonan_perbaikan.kapal = kapal.id');
        $query = $this->db->get();
        return $query->result();
    }
    public function getPenugasanPerbaikansMarine($id){
        $this->db->select('penugasan_perbaikan.id, kapal.nama as nama_kapal, permohonan_perbaikan.detail_kerusakan, permohonan_perbaikan.lokasi, permohonan_perbaikan.foto_kerusakan, penugasan_perbaikan.setuju_marine');
        $this->db->from('penugasan_perbaikan');
        $this->db->join('permohonan_perbaikan', 'penugasan_perbaikan.permohonan_perbaikan = permohonan_perbaikan.id');
        $this->db->join('kapal', 'permohonan_perbaikan.kapal = kapal.id');
        $this->db->where('penugasan_perbaikan.marine',$id);
        $query = $this->db->get();
        return $query->result();
    }
    public function getPenugasanPerbaikan($id){
        $this->db->select('kapal.nama as nama_kapal, permohonan_perbaikan.detail_kerusakan');
        $this->db->from('penugasan_perbaikan');
        $this->db->join('permohonan_perbaikan', 'penugasan_perbaikan.permohonan_perbaikan = permohonan_perbaikan.id');
        $this->db->join('kapal', 'permohonan_perbaikan.kapal = kapal.id');
        $this->db->where('penugasan_perbaikan.id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function konfirmasiPenugasanPerbaikan($id,$konfirmasi){
        $this->db->where('id', $id);
        return $this->db->update('penugasan_perbaikan', ["setuju_marine"=>$konfirmasi]);
    }
}
?>
