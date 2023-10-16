<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_Pembuatan_Sertifikat extends CI_Controller {
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
                $this->session->set_flashdata('success', "Berhasil konfirmasi permohonan pembuatan sertifikat");
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi permohonan pembuatan sertifikat, silahkan coba lagi");
            }
        }
        $data['title'] = "Permohonan Pembuatan Sertifikat";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"pembuatan_sertifikat"], TRUE);
        $data['main'] = $this->load->view('admin/permohonan_pembuatan_sertifikat/index',
        ["permohonan_pembuatan_sertifikats"=>
            $this->permohonan_sertifikat_model->getPermohonanPembuatanSertifikatsAdmin()
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    public function penolakan($id)
    {
        if($this->input->post('submit') !== null){
            $catatan = $this->input->post('catatan');
            if($this->permohonan_sertifikat_model->tolakPermohonanSertifikatAdmin($id,$catatan)){
                $this->session->set_flashdata('success', "Berhasil konfirmasi permohonan pembuatan sertifikat");
                redirect(site_url('admins/permohonan_pembuatan_sertifikat'));
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi permohonan pembuatan sertifikat, silahkan coba lagi");
            }
        }
        $data['title'] = "Penolakan Permohonan Pembuatan Sertifikat";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"pembuatan_sertifikat"], TRUE);
        $data['main'] = $this->load->view('admin/permohonan_pembuatan_sertifikat/penolakan',null,TRUE);
        $this->load->view('master',$data);
    }
}
