<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_Survei extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kru_kapal')) {
            redirect(site_url('login'));
        }
    }
    public function index()
    {
        $data['title'] = "Jadwal Survei Kapal";
        $data['header'] = $this->load->view('kru_kapal/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kru_kapal/template/sidebar',["page"=>"jadwal_survei"], TRUE);
        $data['main'] = $this->load->view('kru_kapal/jadwal_survei/index',
        [
            "permohonan_surveis"=>
            $this->permohonan_survei_model->getPermohonanSurveisKru($this->session->userdata('kru_kapal')->kapal)
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    public function surat($id){
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "surat-permohonan-survei-$id.pdf";
        $this->pdf->load_view('marine/permohonan_survei/surat', 
            [
                'id' => $id,
                'ps' => $this->permohonan_survei_model->getPermohonanSurvei($id)
            ]
        );
    }
}
