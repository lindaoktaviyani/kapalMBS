<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_Survei extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kasi')) {
            redirect(site_url('login/kasi'));
        }
    }
    public function index()
    {
        $data['title'] = "Hasil Survei Kapal";
        $data['header'] = $this->load->view('kasi/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kasi/template/sidebar',["page"=>"hasil_survei"], TRUE);
        $data['main'] = $this->load->view('kasi/hasil_survei/index',
        [
            "hasil_surveis"=>
                $this->hasil_survei_model->getHasilSurveisKasi()
        ],  
        TRUE);
        $this->load->view('master',$data);
    }
    public function surat($id){
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "surat-hasil-survei-$id.pdf";
        $this->pdf->load_view('marine/hasil_survei/surat', 
            [
                'id' => $id,
                'hs' => $this->hasil_survei_model->getHasilSurvei($id)
            ]
        );
    }
}
