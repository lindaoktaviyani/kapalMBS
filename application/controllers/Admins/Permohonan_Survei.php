<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_Survei extends CI_Controller {
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
            if($this->permohonan_survei_model->konfirmasiPermohonanSurvei($id,$konfirmasi)){
                $this->session->set_flashdata('success', "Berhasil konfirmasi permohonan survei");
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi permohonan survei, silahkan coba lagi");
            }
        }
        $data['title'] = "Permohonan Survei Kapal";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"permohonan_survei"], TRUE);
        $data['main'] = $this->load->view('admin/permohonan_survei/index',
        [
            "permohonan_surveis"=>
            $this->permohonan_survei_model->getPermohonanSurveisAdmin()
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    
}
