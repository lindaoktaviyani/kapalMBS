<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_Perpanjangan_Sertifikat extends CI_Controller {
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
            if($this->permohonan_sertifikat_model->konfirmasiPermohonanSertifikatAdmin($id,$konfirmasi)){
                $this->session->set_flashdata('success', "Berhasil konfirmasi permohonan perpanjangan sertifikat");
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi permohonan perpanjangan sertifikat, silahkan coba lagi");
            }
        }
        $data['title'] = "Permohonan Perpanjangan Sertifikat";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"perpanjangan_sertifikat"], TRUE);
        $data['main'] = $this->load->view('admin/permohonan_perpanjangan_sertifikat/index',
        ["permohonan_perpanjangan_sertifikats"=>
            $this->permohonan_sertifikat_model->getPermohonanPerpanjanganSertifikatsAdmin()
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    public function penolakan($id)
    {
        if($this->input->post('submit') !== null){
            $catatan = $this->input->post('catatan');
            if($this->permohonan_sertifikat_model->tolakPermohonanSertifikatAdmin($id,$catatan)){
                $this->session->set_flashdata('success', "Berhasil konfirmasi permohonan perpanjangan sertifikat");
                redirect(site_url('admins/permohonan_perpanjangan_sertifikat'));
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi permohonan perpanjangan sertifikat, silahkan coba lagi");
            }
        }
        $data['title'] = "Penolakan Permohonan Perpanjangan Sertifikat";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"perpanjangan_sertifikat"], TRUE);
        $data['main'] = $this->load->view('admin/permohonan_perpanjangan_sertifikat/penolakan',null,TRUE);
        $this->load->view('master',$data);
    }
}
