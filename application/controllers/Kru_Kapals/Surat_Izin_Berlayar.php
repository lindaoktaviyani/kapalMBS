<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_Izin_Berlayar extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kru_kapal')) {
            redirect(site_url('login'));
        }
    }
    
    public function index()
    {
        $data['title'] = "Surat Izin Berlayar";
        $data['header'] = $this->load->view('kru_kapal/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kru_kapal/template/sidebar',["page"=>"surat_izin_berlayar"], TRUE);
        $data['main'] = $this->load->view('kru_kapal/surat_izin_berlayar/index',
        [
            "surat_izin_berlayars"=>
            $this->permohonan_izin_berlayar_model->getSuratIzinBerlayarsKru($this->session->userdata('kru_kapal')->kapal)
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    
    public function surat($id){
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "surat-izin-berlayar-$id.pdf";
        $this->pdf->load_view('kabid/permohonan_izin_berlayar/surat', 
            [
                'id' => $id,
                'p' => $this->permohonan_izin_berlayar_model->getPermohonanIzinBerlayar($id),
                'k' => $this->kabid_model->getKabid()
            ]
        );
    }
}
