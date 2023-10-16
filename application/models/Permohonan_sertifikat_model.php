<?php
class Permohonan_sertifikat_model extends CI_Model {
    //admin
    public function getPermohonanPembuatanSertifikatsAdmin(){
        $this->db->select('permohonan_sertifikat.*, kapal.nama as nama_kapal');
        $this->db->from('permohonan_sertifikat');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('jenis',1);
        $query = $this->db->get();
        return $query->result();
    }
    public function getPermohonanPerpanjanganSertifikatsAdmin(){
        $this->db->select('permohonan_sertifikat.*, kapal.nama as nama_kapal');
        $this->db->from('permohonan_sertifikat');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('jenis',2);
        $query = $this->db->get();
        return $query->result();
    }
    public function tolakPermohonanSertifikatAdmin($id,$catatan){
        $this->db->where('id', $id);
        return $this->db->update('permohonan_sertifikat', ["setuju_admin"=>2,"penolakan"=>$catatan,"tanggal_penolakan"=>date('Y-m-d')]);
    }
    public function konfirmasiPermohonanSertifikatAdmin($id,$konfirmasi){
        $this->db->where('id', $id);
        return $this->db->update('permohonan_sertifikat', ["setuju_admin"=>$konfirmasi]);
    }


    //kabid
    public function getPermohonanPembuatanSertifikatsKabid(){
        $this->db->select('permohonan_sertifikat.*, kapal.nama as nama_kapal');
        $this->db->from('permohonan_sertifikat');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('jenis',1);
        $this->db->where('setuju_kasi',1);
        $query = $this->db->get();
        return $query->result();
    }
    public function getPermohonanPerpanjanganSertifikatsKabid(){
        $this->db->select('permohonan_sertifikat.*, kapal.nama as nama_kapal');
        $this->db->from('permohonan_sertifikat');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('jenis',2);
        $this->db->where('setuju_kasi',1);
        $query = $this->db->get();
        return $query->result();
    }
    public function konfirmasiPermohonanSertifikatKabid($id,$konfirmasi){
        $this->db->where('id', $id);
        return $this->db->update('permohonan_sertifikat', ["setuju_kabid"=>$konfirmasi]);
    }
    
    
    //kasi
    public function getPermohonanPembuatanSertifikatsKasi(){
        $this->db->select('permohonan_sertifikat.*, kapal.nama as nama_kapal, penugasan_marine.setuju_admin as setuju_penugasan_admin, penugasan_marine.setuju_marine as setuju_penugasan_marine');
        $this->db->from('permohonan_sertifikat');
        $this->db->join('(SELECT *
                        FROM penugasan_marine
                        WHERE id IN (SELECT MAX(id)
                                     FROM penugasan_marine
                                     GROUP BY permohonan_sertifikat)) AS penugasan_marine', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id', 'left');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('jenis', 1);
        $this->db->where('permohonan_sertifikat.setuju_admin',1);
        $query = $this->db->get();
        return $query->result();        
    }
    public function getPermohonanPerpanjanganSertifikatsKasi(){
        $this->db->distinct();
        $this->db->select('permohonan_sertifikat.*, kapal.nama as nama_kapal, penugasan_marine.setuju_admin as setuju_penugasan_admin, penugasan_marine.setuju_marine as setuju_penugasan_marine');
        $this->db->from('permohonan_sertifikat');
        $this->db->join('penugasan_marine', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id',"left");
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('jenis',2);
        $this->db->where('permohonan_sertifikat.setuju_admin',1);
        $query = $this->db->get();
        return $query->result();
    }
    public function konfirmasiPermohonanSertifikatKasi($id,$konfirmasi){
        $this->db->where('id', $id);
        $data["setuju_kasi"] = $konfirmasi;
        if($konfirmasi==2){
            $data["tanggal_penolakan"]=date('Y-m-d');
        }
        return $this->db->update('permohonan_sertifikat', $data);
    }
    public function getPermohonanSertifikat($id){
        $this->db->select('permohonan_sertifikat.*, kapal.nama as nama_kapal');
        $this->db->from('permohonan_sertifikat');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('permohonan_sertifikat.id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    //kru
    public function getPermohonanPembuatanSertifikatsKru($id_kapal){
        return $this->db->get_where('permohonan_sertifikat', array('kapal' => $id_kapal, 'jenis' => 1))->result();
    }
    public function getPermohonanPerpanjanganSertifikatsKru($id_kapal){
        return $this->db->get_where('permohonan_sertifikat', array('kapal' => $id_kapal, 'jenis' => 2))->result();
    }
    public function savePermohonanPembuatanSertifikat($data) {
        $data["jenis"] = 1;
        return $this->db->insert('permohonan_sertifikat', $data);
    }
    public function savePermohonanPerpanjanganSertifikat($data) {
        $data["jenis"] = 2;
        return $this->db->insert('permohonan_sertifikat', $data);
    }
    public function getSertifikatTerbuat($id) {
        $this->db->distinct();
        $this->db->select('sertifikat');
        $this->db->where('kapal',$id);
        $this->db->where('jenis',1);
        $this->db->where('setuju_kasi !=',2);
        $this->db->where('setuju_admin !=',2);
        $query = $this->db->get('permohonan_sertifikat');
        return $query->result();
    }
    public function checkPermohonanPerpanjanganTerakhir($id){
        $this->db->from('permohonan_sertifikat');
        $this->db->where('permohonan_sertifikat_diperpanjang',$id);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $pps = $query->row();
        if($pps==null){
            return true;
        }
        if($pps->setuju_admin==2||$pps->setuju_kasi==2){
            return true;
        }
        return false;
    }

    public function getPenolakanPermohonanSertifikatLaporan($awal, $akhir){
        $this->db->select('permohonan_sertifikat.*, kapal.nama');
        $this->db->from('permohonan_sertifikat');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where("permohonan_sertifikat.tanggal_penolakan BETWEEN '$awal' AND '$akhir'");
        $this->db->where("(setuju_admin = 2 OR setuju_kasi = 2)");
        $query = $this->db->get();
        return $query->result();
    }
    public function getPermohonanPembuatanSertifikatLaporan($awal, $akhir){
        $this->db->select('permohonan_sertifikat.*, kapal.nama, kapal.jenis_mesin');
        $this->db->from('permohonan_sertifikat');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where("permohonan_sertifikat.tanggal_pengajuan BETWEEN '$awal' AND '$akhir'");
        $this->db->where('permohonan_sertifikat.jenis',1);
        $query = $this->db->get();
        return $query->result();
    }
    public function getPermohonanPerpanjanganSertifikatLaporan($awal, $akhir){
        $this->db->select('perpanjangan.id,kapal.nama, perpanjangan.sertifikat, sertifikat.tanggal_terbit,sertifikat.id as id_sertifikat, sertifikat.tanggal_kedaluwarsa, perpanjangan.tanggal_pengajuan');
        $this->db->from('permohonan_sertifikat as perpanjangan');
        $this->db->join('permohonan_sertifikat as pembuatan', 'perpanjangan.permohonan_sertifikat_diperpanjang = pembuatan.id', 'left');
        $this->db->join('sertifikat', 'sertifikat.permohonan_sertifikat = pembuatan.id', 'left');
        $this->db->join('kapal', 'perpanjangan.kapal = kapal.id');
        $this->db->where("perpanjangan.tanggal_pengajuan BETWEEN '$awal' AND '$akhir'");
        $this->db->where('perpanjangan.jenis', 2);
        $query = $this->db->get();
        return $query->result();
    }
}
?>
