<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kru_kapal')) {
            redirect(site_url('login'));
        }
    }

    public function penolakan_permohonan_sertifikat()
    {
        $data['title'] = "Laporan Hasil Survei";
        $data['header'] = $this->load->view('kru_kapal/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kru_kapal/template/sidebar',["page"=>"laporan_penolakan_permohonan_sertifikat"], TRUE);
        $data['main'] = $this->load->view('kru_kapal/laporan/penolakan_permohonan_sertifikat',null,TRUE);
        $this->load->view('master',$data);
    }

    public function laporan_penolakan_permohonan_sertifikat(){
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        
        if(strtotime($awal) > strtotime($akhir)){
            $this->session->set_flashdata('error', "Tanggal akhir harus lebih besar dari tanggal awal");
            redirect(site_url('kru_kapals/laporan/penolakan_permohonan_sertifikat'));
        }
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-penolakan-permohonan-sertifikat.pdf";
        $this->pdf->load_view('laporan/penolakan_permohonan_sertifikat', 
            [
                'awal' => $awal,
                'akhir' => $akhir,
                'nama_kapal' => $this->kapal_model->getKapal($this->session->userdata('kru_kapal')->kapal)->nama,
                'penolakan_permohonan_sertifikats' => $this->permohonan_sertifikat_model->getPenolakanPermohonanSertifikatLaporan($awal,$akhir),
                'k' => $this->kabid_model->getKabid()
            ]
        );
    }
}
