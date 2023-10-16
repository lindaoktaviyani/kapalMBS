<?php
class Hasil_perbaikan_model extends CI_Model {
    public function getHasilPerbaikansMarine($id){
        $this->db->select('hasil_perbaikan.*, kapal.nama as nama_kapal, permohonan_perbaikan.detail_kerusakan,permohonan_perbaikan.foto_kerusakan');
        $this->db->from('hasil_perbaikan');
        $this->db->join('penugasan_perbaikan', 'hasil_perbaikan.penugasan_perbaikan = penugasan_perbaikan.id');
        $this->db->join('permohonan_perbaikan', 'penugasan_perbaikan.permohonan_perbaikan = permohonan_perbaikan.id');
        $this->db->join('kapal', 'permohonan_perbaikan.kapal = kapal.id');
        $this->db->where('penugasan_perbaikan.marine',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function saveHasilPerbaikan($data) {
        return $this->db->insert('hasil_perbaikan', $data);
    }
    
    public function getPerbaikansLaporan($awal,$akhir) {
        $this->db->select('kapal.nama as nama_kapal, permohonan_perbaikan.foto_kerusakan, hasil_perbaikan.foto_kapal, hasil_perbaikan.tanggal_perbaikan, marine.nama AS nama_marine, hasil_perbaikan.catatan');
        $this->db->from('hasil_perbaikan');
        $this->db->join('penugasan_perbaikan', 'penugasan_perbaikan.id = hasil_perbaikan.penugasan_perbaikan');
        $this->db->join('permohonan_perbaikan', 'permohonan_perbaikan.id = penugasan_perbaikan.permohonan_perbaikan');
        $this->db->join('marine', 'marine.id = penugasan_perbaikan.marine');
        $this->db->join('kapal', 'kapal.id = permohonan_perbaikan.kapal');
        $this->db->where("hasil_perbaikan.tanggal_perbaikan BETWEEN '$awal' AND '$akhir'");
        $query = $this->db->get();
        return $query->result();
    }
}
?>
