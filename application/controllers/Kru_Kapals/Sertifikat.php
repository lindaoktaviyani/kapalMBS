<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sertifikat extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kru_kapal')) {
            redirect(site_url('login'));
        }
    }
    public function index()
    {
        $data['title'] = "Sertifikat";
        $data['header'] = $this->load->view('kru_kapal/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kru_kapal/template/sidebar',["page"=>"sertifikat"], TRUE);
        $data['main'] = $this->load->view('kru_kapal/sertifikat/index',
        [
            "sertifikats"=>
            $this->sertifikat_model->getSertifikatsKru($this->session->userdata('kru_kapal')->kapal)
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    public function surat($id){
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "surat-sertifikat-$id.pdf";
        $this->pdf->load_view('kabid/sertifikat/surat', 
            [
                'id' => $id,
                's' => $this->sertifikat_model->getSertifikat($id),
                'k' => $this->kabid_model->getKabid()
            ]
        );
    }
}
