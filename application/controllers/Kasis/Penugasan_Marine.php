<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penugasan_Marine extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kasi')) {
            redirect(site_url('login/kasi'));
        }
    }
    public function index()
    {
        $data['title'] = "Penugasan Marine";
        $data['header'] = $this->load->view('kasi/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kasi/template/sidebar',["page"=>"penugasan_marine"], TRUE);
        $data['main'] = $this->load->view('kasi/penugasan_marine/index',
        [
            "penugasan_marines"=>
            $this->penugasan_marine_model->getPenugasanMarines()
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    public function tambah($id)
    {
        if(!$this->marine_model->checkKetersediaanMarine()){
            $this->session->set_flashdata('error', "Marine belum ada, silahkan hubungi admin");
            redirect(site_url('kasis/permohonan_pembuatan_sertifikat'));
        }
        if($this->input->post('submit') !== null){
            $data = array(
                'permohonan_sertifikat' => $id,
                'kasi' => $this->session->userdata('kasi')->id,
                'marine' => $this->input->post('marine'),
                'catatan' => $this->input->post('catatan'),
                'tanggal_terbit' =>  date('Y-m-d'),
                'setuju_admin' => 0,
                'setuju_marine' => 0
            );
            if($this->penugasan_marine_model->savePenugasanMarine($data)){
                $this->permohonan_sertifikat_model->konfirmasiPermohonanSertifikatKasi($id,1);
                $this->session->set_flashdata('success', "Berhasil menugaskan marine");
                redirect(site_url('kasis/penugasan_marine'));
            }else{
                $this->session->set_flashdata('error', "Gagal menugaskan marine, silahkan coba lagi");
            }
        }
        $data['title'] = "Penugasan Marine";
        $data['header'] = $this->load->view('kasi/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kasi/template/sidebar',["page"=>"penugasan_marine"], TRUE);
        $data['main'] = $this->load->view('kasi/penugasan_marine/tambah',
        [
            "pps"=>
                $this->permohonan_sertifikat_model->getPermohonanSertifikat($id),
            "marines"=>$this->marine_model->getMarines()
        ],  
        TRUE);
        $this->load->view('master',$data);
    }
}
