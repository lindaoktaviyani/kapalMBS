<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_Perpanjangan_Sertifikat extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kasi')) {
            redirect(site_url('login/kasi'));
        }
    }
    public function index()
    {
        if($this->input->post('konfirmasi') !== null){
            $id = $this->input->post('id');
            $konfirmasi = $this->input->post('konfirmasi');
            if($this->permohonan_sertifikat_model->konfirmasiPermohonanSertifikatKasi($id,$konfirmasi)){
                $this->session->set_flashdata('success', "Berhasil konfirmasi permohonan perpanjangan sertifikat");
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi permohonan perpanjangan sertifikat, silahkan coba lagi");
            }
        }
        $data['title'] = "Permohonan Perpanjangan Sertifikat";
        $data['header'] = $this->load->view('kasi/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kasi/template/sidebar',["page"=>"perpanjangan_sertifikat"], TRUE);
        $data['main'] = $this->load->view('kasi/permohonan_perpanjangan_sertifikat/index',
        [
            "permohonan_perpanjangan_sertifikats"=>
            $this->permohonan_sertifikat_model->getPermohonanPerpanjanganSertifikatsKasi()
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
}
