<?php
class Permohonan_survei_model extends CI_Model {
    public function getPermohonanSurveisMarine($id){
        $this->db->select(
            'permohonan_survei.id, 
            kapal.nama as nama_kapal, 
            permohonan_sertifikat.sertifikat as nama_sertifikat, 
            permohonan_survei.tanggal, 
            permohonan_survei.setuju_admin,
            permohonan_survei.catatan_batal,
            hasil_survei.id as hasil_survei'
        );
        $this->db->from('permohonan_survei');
        $this->db->join('hasil_survei', 'hasil_survei.permohonan_survei = permohonan_survei.id', 'left');
        $this->db->join('penugasan_marine', 'permohonan_survei.penugasan_marine = penugasan_marine.id');
        $this->db->join('permohonan_sertifikat', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('penugasan_marine.marine',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function batalPermohonaSurvei($id,$catatan){
        $this->db->where('id', $id);
        return $this->db->update('permohonan_survei', ["catatan_batal"=>$catatan]);
    }

    public function getPermohonanSurveisAdmin(){
        $this->db->select('permohonan_survei.id, kapal.nama as nama_kapal, permohonan_sertifikat.sertifikat as nama_sertifikat, permohonan_survei.tanggal, permohonan_survei.setuju_admin, marine.nama as nama_marine, permohonan_survei.catatan');
        $this->db->from('permohonan_survei');
        $this->db->join('penugasan_marine', 'permohonan_survei.penugasan_marine = penugasan_marine.id');
        $this->db->join('permohonan_sertifikat', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('marine', 'penugasan_marine.marine = marine.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('permohonan_survei.catatan_batal', NULL);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getPermohonanSurveisKru($id){
        $this->db->select('permohonan_survei.id,permohonan_survei.catatan, kapal.nama as nama_kapal, permohonan_sertifikat.sertifikat as nama_sertifikat, permohonan_survei.tanggal, marine.nama as nama_marine, permohonan_survei.catatan_batal');
        $this->db->from('permohonan_survei');
        $this->db->join('penugasan_marine', 'permohonan_survei.penugasan_marine = penugasan_marine.id');
        $this->db->join('permohonan_sertifikat', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('marine', 'penugasan_marine.marine = marine.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('kapal.id',$id);
        $this->db->where('permohonan_survei.setuju_admin',1);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getPermohonanSurvei($id){
        $this->db->select('
        kapal.nama as nama_kapal, 
        permohonan_survei.penugasan_marine,
        permohonan_sertifikat.sertifikat as nama_sertifikat, 
        permohonan_survei.tanggal, 
        permohonan_survei.tanggal_terbit, 
        marine.tanda_tangan as tanda_tangan_marine, 
        marine.nama as nama_marine');
        $this->db->from('permohonan_survei');
        $this->db->join('penugasan_marine', 'permohonan_survei.penugasan_marine = penugasan_marine.id');
        $this->db->join('permohonan_sertifikat', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('marine', 'penugasan_marine.marine = marine.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('permohonan_survei.id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function konfirmasiPermohonanSurvei($id,$konfirmasi){
        $this->db->where('id', $id);
        return $this->db->update('permohonan_survei', ["setuju_admin"=>$konfirmasi]);
    }
    
    public function savePermohonanSurvei($data) {
        return $this->db->insert('permohonan_survei', $data);
    }

    public function getPembatalanSurveisLaporan($awal,$akhir) {
        $this->db->select('permohonan_survei.id, kapal.nama as nama_kapal, permohonan_sertifikat.sertifikat as nama_sertifikat, permohonan_survei.tanggal, marine.nama as nama_marine, permohonan_survei.catatan_batal');
        $this->db->from('permohonan_survei');
        $this->db->join('penugasan_marine', 'permohonan_survei.penugasan_marine = penugasan_marine.id');
        $this->db->join('permohonan_sertifikat', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->join('marine', 'penugasan_marine.marine = marine.id');
        $this->db->where('permohonan_survei.catatan_batal IS NOT NULL');
        $this->db->where("permohonan_survei.tanggal BETWEEN '$awal' AND '$akhir'");
        $query = $this->db->get();
        return $query->result();
    }
}
?>
