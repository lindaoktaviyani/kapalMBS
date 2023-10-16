<?php
class Penugasan_marine_model extends CI_Model {
    public function getPenugasanMarines(){
        $this->db->select('penugasan_marine.id, kapal.nama as nama_kapal, permohonan_sertifikat.sertifikat as nama_sertifikat, marine.nama as nama_marine, penugasan_marine.catatan, penugasan_marine.setuju_admin, penugasan_marine.setuju_marine');
        $this->db->from('penugasan_marine');
        $this->db->join('permohonan_sertifikat', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('marine', 'penugasan_marine.marine = marine.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function getPenugasanMarinesMarine($marineId) {
        $query = "
            WITH RECURSIVE DataCTE AS (
                SELECT 
                    id, 
                    kapal,
                    sertifikat,
                    surat_ukur,
                    surat_pas_besar,
                    file_inventaris_dek,  
                    file_inventaris_mesin,
                    permohonan_sertifikat_diperpanjang
                FROM permohonan_sertifikat
                WHERE permohonan_sertifikat_diperpanjang IS NULL
    
                UNION ALL
    
                SELECT
                    permohonan_sertifikat.id, 
                    DataCTE.kapal,
                    DataCTE.sertifikat,
                    DataCTE.surat_ukur,
                    DataCTE.surat_pas_besar,
                    DataCTE.file_inventaris_dek,  
                    DataCTE.file_inventaris_mesin,
                    permohonan_sertifikat.permohonan_sertifikat_diperpanjang
                FROM permohonan_sertifikat
                INNER JOIN DataCTE ON permohonan_sertifikat.permohonan_sertifikat_diperpanjang = DataCTE.id
            )
            SELECT
                penugasan_marine.id,
                kapal.nama AS nama_kapal,
                DataCTE.sertifikat AS nama_sertifikat,
                DataCTE.surat_ukur,
                DataCTE.surat_pas_besar,
                DataCTE.file_inventaris_mesin,
                DataCTE.file_inventaris_dek,
                penugasan_marine.catatan,
                penugasan_marine.setuju_admin,
                penugasan_marine.setuju_marine,
                permohonan_survei.setuju_admin AS setuju_survei_admin
            FROM
                penugasan_marine
            LEFT JOIN
                (
                    SELECT *
                    FROM permohonan_survei
                    WHERE id IN (
                        SELECT MAX(id)
                        FROM permohonan_survei
                        GROUP BY penugasan_marine
                    )
                ) AS permohonan_survei ON permohonan_survei.penugasan_marine = penugasan_marine.id
            LEFT JOIN
                DataCTE ON penugasan_marine.permohonan_sertifikat = DataCTE.id
            LEFT JOIN
                kapal ON DataCTE.kapal = kapal.id
            WHERE
                penugasan_marine.marine = ?
                AND penugasan_marine.setuju_admin = 1";
    
        $result = $this->db->query($query, array($marineId));
        return $result->result();
    }
    


    public function getPenugasanMarine($id){
        $this->db->select('
        kapal.nama as nama_kapal, 
        permohonan_sertifikat.sertifikat as nama_sertifikat, 
        marine.nama as nama_marine, 
        penugasan_marine.catatan, 
        penugasan_marine.tanggal_terbit, 
        kasi.tanda_tangan as tanda_tangan_kasi, 
        kasi.nama as nama_kasi');
        $this->db->from('penugasan_marine');
        $this->db->join('permohonan_sertifikat', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('marine', 'penugasan_marine.marine = marine.id');
        $this->db->join('kasi', 'penugasan_marine.kasi = kasi.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where('penugasan_marine.id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getPenugasanMarineLaporan($awal, $akhir){
        $this->db->select('
        penugasan_marine.id,
        kapal.nama as nama_kapal, 
        permohonan_sertifikat.sertifikat as nama_sertifikat, 
        marine.nama as nama_marine, 
        penugasan_marine.catatan, 
        penugasan_marine.tanggal_terbit, 
        kasi.tanda_tangan as tanda_tangan_kasi, 
        kasi.nama as nama_kasi');
        $this->db->from('penugasan_marine');
        $this->db->join('permohonan_sertifikat', 'penugasan_marine.permohonan_sertifikat = permohonan_sertifikat.id');
        $this->db->join('marine', 'penugasan_marine.marine = marine.id');
        $this->db->join('kasi', 'penugasan_marine.kasi = kasi.id');
        $this->db->join('kapal', 'permohonan_sertifikat.kapal = kapal.id');
        $this->db->where("penugasan_marine.tanggal_terbit BETWEEN '$awal' AND '$akhir'");
        $query = $this->db->get();
        return $query->result();
    }

    public function konfirmasiPenugasanMarineAdmin($id,$konfirmasi){
        $this->db->where('id', $id);
        return $this->db->update('penugasan_marine', ["setuju_admin"=>$konfirmasi]);
    }

    public function konfirmasiPenugasanMarineMarine($id,$konfirmasi){
        $this->db->where('id', $id);
        return $this->db->update('penugasan_marine', ["setuju_marine"=>$konfirmasi]);
    }
    
    public function savePenugasanMarine($data) {
        return $this->db->insert('penugasan_marine', $data);
    }
}
?>
