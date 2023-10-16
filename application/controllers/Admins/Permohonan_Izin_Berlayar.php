<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_Izin_Berlayar extends CI_Controller {
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
            if($this->permohonan_izin_berlayar_model->konfirmasiPermohonanIzinBerlayarAdmin($id,$konfirmasi)){
                $this->session->set_flashdata('success', "Berhasil konfirmasi permohonan izin berlayar");
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi permohonan izin berlayar, silahkan coba lagi");
            }
        }
        $data['title'] = "Permohonan Izin Berlayar";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"permohonan_izin_berlayar"], TRUE);
        $data['main'] = $this->load->view('admin/permohonan_izin_berlayar/index',
        ["permohonan_izin_berlayars"=>
            $this->permohonan_izin_berlayar_model->getPermohonanIzinBerlayarsAdmin()
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
}
