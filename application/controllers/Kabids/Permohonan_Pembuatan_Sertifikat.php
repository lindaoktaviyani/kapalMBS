<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_Pembuatan_Sertifikat extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kabid')) {
            redirect(site_url('login/kabid'));
        }
    }
    public function index()
    {
        if($this->input->post('konfirmasi') !== null){
            $id = $this->input->post('id');
            $konfirmasi = $this->input->post('konfirmasi');
            if($this->permohonan_sertifikat_model->konfirmasiPermohonanSertifikatKabid($id,$konfirmasi)){
                $this->session->set_flashdata('success', "Berhasil konfirmasi permohonan pembuatan sertifikat");
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi permohonan pembuatan sertifikat, silahkan coba lagi");
            }
        }
        $data['title'] = "Permohonan Pembuatan Sertifikat";
        $data['header'] = $this->load->view('kabid/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kabid/template/sidebar',["page"=>"pembuatan_sertifikat"], TRUE);
        $data['main'] = $this->load->view('kabid/permohonan_pembuatan_sertifikat/index',
        ["permohonan_pembuatan_sertifikats"=>
            $this->permohonan_sertifikat_model->getPermohonanPembuatanSertifikatsKabid()
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
}
