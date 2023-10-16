<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sertifikat extends CI_Controller {
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
            if($this->sertifikat_model->konfirmasiSertifikatKabid($id,$konfirmasi)){
                $this->session->set_flashdata('success', "Berhasil konfirmasi sertifikat");
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi sertifikat, silahkan coba lagi");
            }
        }
        $data['title'] = "Sertifikat";
        $data['header'] = $this->load->view('kabid/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kabid/template/sidebar',["page"=>"sertifikat"], TRUE);
        $data['main'] = $this->load->view('kabid/sertifikat/index',
        [
            "sertifikats"=>
            $this->sertifikat_model->getSertifikatsKabid()
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
}
