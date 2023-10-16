<?php
class Hasil_survei_model extends CI_Model {
    public function getHasilSurveisMarine($id){
        $this->db->select('hasil_survei.*, kapal.nama as nama_kapal, permohonan_sertifikat.sertifikat as nama_sertifikat');
        $this->db->from('hasil_survei');
        $this->db->join('permohonan_survei', 'hasil_survei.permohonan_survei = permohonan_survei.id');
        $this->db->join('penugasan_marine', 'permohonan_survei.penugasan_marine = penugasan_marine.id');
        $this->db->join('permohonan_sertifikat', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('penugasan_marine.marine',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getHasilSurveisKasi(){
        $this->db->select('hasil_survei.id, permohonan_sertifikat.id AS permohonan_sertifikat_id, kapal.nama AS nama_kapal, permohonan_sertifikat.sertifikat AS nama_sertifikat, marine.nama AS nama_marine, sertifikat.setuju_kabid AS setuju_sertifikat_kabid');
        $this->db->from('hasil_survei');
        $this->db->join('permohonan_survei', 'hasil_survei.permohonan_survei = permohonan_survei.id');
        $this->db->join('penugasan_marine', 'permohonan_survei.penugasan_marine = penugasan_marine.id');
        $this->db->join('permohonan_sertifikat', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('(SELECT * FROM sertifikat WHERE id IN (SELECT MAX(id) FROM sertifikat GROUP BY permohonan_sertifikat)) AS sertifikat', 'sertifikat.permohonan_sertifikat = permohonan_sertifikat.id', 'left');
        $this->db->join('marine', 'penugasan_marine.marine = marine.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $query = $this->db->get();
        return $query->result();        
    }
    
    public function getHasilSurveisLaporan($awal, $akhir){
        $this->db->select('
        hasil_survei.id, 
        kapal.nama as nama_kapal, 
        permohonan_sertifikat.sertifikat as nama_sertifikat,
        permohonan_survei.tanggal as tanggal_survei, 
        hasil_survei.tanggal_terbit, 
        marine.nama as nama_marine,
        hasil_survei.keterangan
        ');
        $this->db->from('hasil_survei');
        $this->db->join('permohonan_survei', 'hasil_survei.permohonan_survei = permohonan_survei.id');
        $this->db->join('penugasan_marine', 'permohonan_survei.penugasan_marine = penugasan_marine.id');
        $this->db->join('permohonan_sertifikat', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('marine', 'penugasan_marine.marine = marine.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where("hasil_survei.tanggal_terbit BETWEEN '$awal' AND '$akhir'");
        $query = $this->db->get();
        return $query->result();
    }

    public function saveHasilSurvei($data) {
        return $this->db->insert('hasil_survei', $data);
    }

    public function getHasilSurvei($id){
        $this->db->select('
        hasil_survei.*,
        kapal.nama as nama_kapal, 
        permohonan_sertifikat.sertifikat as nama_sertifikat, 
        marine.tanda_tangan as tanda_tangan_marine, 
        marine.tanda_tangan2 as tanda_tangan_marine2,
        marine.nama as nama_marine');
        $this->db->from('hasil_survei');
        $this->db->join('permohonan_survei', 'hasil_survei.permohonan_survei = permohonan_survei.id');
        $this->db->join('penugasan_marine', 'permohonan_survei.penugasan_marine = penugasan_marine.id');
        $this->db->join('permohonan_sertifikat', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('marine', 'penugasan_marine.marine = marine.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('hasil_survei.id',$id);
        $query = $this->db->get();
        return $query->row();
    }
}
?>
