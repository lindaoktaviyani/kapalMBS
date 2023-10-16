<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_Perbaikan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('admin')) {
            redirect(site_url('login'));
        }
    }
    public function index()
    {
        if($this->input->post('konfirmasi') !== null){
            $id = $this->input->post('id');
            $konfirmasi = $this->input->post('konfirmasi');
            if($this->permohonan_perbaikan_model->konfirmasiPermohonanPerbaikanAdmin($id,$konfirmasi)){
                $this->session->set_flashdata('success', "Berhasil konfirmasi permohonan perbaikan");
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi permohonan perbaikan, silahkan coba lagi");
            }
        }
        $data['title'] = "Permohonan Perbaikan Kapal";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"permohonan_perbaikan"], TRUE);
        $data['main'] = $this->load->view('admin/permohonan_perbaikan/index',
        ["permohonan_perbaikans"=>
            $this->permohonan_perbaikan_model->getPermohonanPerbaikansAdmin()
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
}
