<?php
class Permohonan_izin_berlayar_model extends CI_Model {
    //kru
    public function getPermohonanIzinBerlayarsKru($id_kapal){
        return $this->db->get_where('permohonan_izin_berlayar', array('kapal' => $id_kapal))->result();
    }
    //kru
    public function getSuratIzinBerlayarsKru($id_kapal){
        return $this->db->get_where('permohonan_izin_berlayar', array('kapal' => $id_kapal,"setuju_kabid"=>1))->result();
    }
    public function savePermohonanIzinBerlayar($data) {
        return $this->db->insert('permohonan_izin_berlayar', $data);
    }
    //admin
    public function getPermohonanIzinBerlayarsAdmin(){
        $this->db->select('permohonan_izin_berlayar.*, kapal.nama, kapal.GT');
        $this->db->from('permohonan_izin_berlayar');
        $this->db->join('kapal', 'permohonan_izin_berlayar.kapal = kapal.id');
        $query = $this->db->get();
        return $query->result();
    }
    public function konfirmasiPermohonanIzinBerlayarAdmin($id,$konfirmasi){
        $this->db->where('id', $id);
        return $this->db->update('permohonan_izin_berlayar', ["setuju_admin"=>$konfirmasi]);
    }
    //kabid
    public function getPermohonanIzinBerlayarsKabid(){
        $this->db->select('permohonan_izin_berlayar.*, kapal.nama, kapal.GT');
        $this->db->from('permohonan_izin_berlayar');
        $this->db->join('kapal', 'permohonan_izin_berlayar.kapal = kapal.id');
        $this->db->where('setuju_admin',1);
        $query = $this->db->get();
        return $query->result();
    }
    public function konfirmasiPermohonanIzinBerlayarKabid($id,$konfirmasi){
        $this->db->where('id', $id);
        $data["setuju_kabid"] = $konfirmasi;
        if($konfirmasi==1){
            date_default_timezone_set('Asia/Jakarta');
            $data["waktu_terbit"]=date('Y-m-d H:i:s');
        }
        return $this->db->update('permohonan_izin_berlayar', $data);
    }

    public function getPermohonanIzinBerlayar($id){
        $this->db->select('
        kapal.nama, 
        kapal.GT,
        permohonan_izin_berlayar.*');
        $this->db->from('permohonan_izin_berlayar');
        $this->db->join('kapal', 'permohonan_izin_berlayar.kapal = kapal.id');
        $this->db->where('permohonan_izin_berlayar.id',$id);
        $this->db->where('setuju_kabid',1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getPermohonanIzinBerlayarLaporan($awal, $akhir){
        $this->db->select('
        permohonan_izin_berlayar.*,
        kapal.nama, 
        kapal.GT,
        ');
        $this->db->from('permohonan_izin_berlayar');
        $this->db->join('kapal', 'permohonan_izin_berlayar.kapal = kapal.id');
        $this->db->where("permohonan_izin_berlayar.tanggal BETWEEN '$awal' AND '$akhir'");
        $query = $this->db->get();
        return $query->result();
    }

}
?>
