<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penugasan_Marine extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('admin')) {
            redirect(site_url('login/admin'));
        }
    }

    public function index()
    {
        if($this->input->post('konfirmasi') !== null){
            $id = $this->input->post('id');
            $konfirmasi = $this->input->post('konfirmasi');
            if($this->penugasan_marine_model->konfirmasiPenugasanMarineAdmin($id,$konfirmasi)){
                $this->session->set_flashdata('success', "Berhasil konfirmasi penugasan marine");
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi penugasan marine, silahkan coba lagi");
            }
        }
        $data['title'] = "Penugasan Marine";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"penugasan_marine"], TRUE);
        $data['main'] = $this->load->view('admin/penugasan_marine/index',
        [
            "penugasan_marines"=>
            $this->penugasan_marine_model->getPenugasanMarines()
        ], 
        TRUE);
        $this->load->view('master',$data);
    }

    public function surat($id){
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "surat-tugas-$id.pdf";
        $this->pdf->load_view('kasi/penugasan_marine/surat', 
            [
                'id' => $id,
                'pm' => $this->penugasan_marine_model->getPenugasanMarine($id)
            ]
        );
    }
}
