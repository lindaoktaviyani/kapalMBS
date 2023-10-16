<?php
class Sertifikat_model extends CI_Model {
    public function getSertifikatsKasi(){
        $this->db->select('
        sertifikat.*, 
        kapal.nama as nama_kapal, 
        permohonan_sertifikat.sertifikat as nama_sertifikat');
        $this->db->from('sertifikat');
        $this->db->join('permohonan_sertifikat', 'sertifikat.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $query = $this->db->get();
        return $query->result();
    }
    public function saveSertifikat($data) {
        return $this->db->insert('sertifikat', $data);
    }
    
    
    //kabid
    public function getSertifikatsKabid(){
        $this->db->select('
        sertifikat.*, 
        kapal.nama as nama_kapal, 
        permohonan_sertifikat.sertifikat as nama_sertifikat');
        $this->db->from('sertifikat');
        $this->db->join('permohonan_sertifikat', 'sertifikat.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $query = $this->db->get();
        return $query->result();
    }
    public function konfirmasiSertifikatKabid($id,$konfirmasi){
        $this->db->where('id', $id);
        return $this->db->update('sertifikat', ["setuju_kabid"=>$konfirmasi]);
    }
    
    
    //admin
    public function getSertifikatsAdmin(){
        $this->db->select('
        sertifikat.*, 
        kapal.nama as nama_kapal, 
        permohonan_sertifikat.sertifikat as nama_sertifikat');
        $this->db->from('sertifikat');
        $this->db->join('permohonan_sertifikat', 'sertifikat.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('sertifikat.setuju_kabid', 1);
        $query = $this->db->get();
        return $query->result();
    }
    public function konfirmasiSertifikatAdmin($id,$konfirmasi){
        $this->db->where('id', $id);
        return $this->db->update('sertifikat', ["setuju_admin"=>$konfirmasi]);
    }
    public function getSertifikat($id){
        $this->db->select('
        kapal.nama as nama_kapal, 
        kapal.pengenal as pengenal_kapal,
        kapal.pelabuhan as pelabuhan_kapal,
        kapal.gt as gt_kapal,
        kapal.jenis_mesin as jenis_mesin_kapal,
        permohonan_sertifikat.posisi_kapal,
        permohonan_sertifikat.sertifikat as nama_sertifikat,
        sertifikat.*');
        $this->db->from('sertifikat');
        $this->db->join('permohonan_sertifikat', 'sertifikat.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('sertifikat.id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    
    //kru
    public function getSertifikatsKru($id_kapal){
        $this->db->select('
        s1.*, 
        kapal.nama as nama_kapal, 
        p1.sertifikat as nama_sertifikat');
        $this->db->from('sertifikat s1');
        $this->db->join('permohonan_sertifikat p1', 'p1.id = s1.permohonan_sertifikat', 'left');
        $this->db->join('kapal', 'p1.kapal = kapal.id');
        $this->db->where('s1.setuju_kabid', 1);
        $this->db->where('s1.setuju_admin', 1);
        $this->db->where('p1.kapal', $id_kapal);
        $this->db->where("s1.tanggal_terbit = (SELECT MAX(s2.tanggal_terbit) FROM sertifikat s2 JOIN permohonan_sertifikat p2 ON p2.id = s2.permohonan_sertifikat WHERE p2.sertifikat = p1.sertifikat AND p2.kapal = $id_kapal)", NULL, FALSE);
        $this->db->group_by('p1.sertifikat');
        $query = $this->db->get();
        return $query->result();
    }
}
?>
