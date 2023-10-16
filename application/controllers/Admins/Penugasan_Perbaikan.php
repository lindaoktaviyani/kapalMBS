<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penugasan_Perbaikan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('admin')) {
            redirect(site_url('login/admin'));
        }
    }
    public function index()
    {
        $data['title'] = "Penugasan Marine";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"penugasan_perbaikan"], TRUE);
        $data['main'] = $this->load->view('admin/penugasan_perbaikan/index',
        [
            "penugasan_perbaikans"=>
            $this->penugasan_perbaikan_model->getPenugasanPerbaikans()
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    public function tambah($id)
    {
        if(!$this->marine_model->checkKetersediaanMarine()){
            $this->session->set_flashdata('error', "Marine belum ada, silahkan hubungi admin");
            redirect(site_url('admins/permohonan_perbaikan'));
        }
        if($this->input->post('submit') !== null){
            $data = array(
                'permohonan_perbaikan' => $id,
                'marine' => $this->input->post('marine'),
                'setuju_marine' => 0
            );
            if($this->penugasan_perbaikan_model->savePenugasanPerbaikan($data)){
                $this->permohonan_perbaikan_model->konfirmasiPermohonanPerbaikanAdmin($id,1);
                $this->session->set_flashdata('success', "Berhasil menugaskan marine");
                redirect(site_url('admins/penugasan_perbaikan'));
            }else{
                $this->session->set_flashdata('error', "Gagal menugaskan marine, silahkan coba lagi");
            }
        }
        $data['title'] = "Penugasan Perbaikan";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"penugasan_marine"], TRUE);
        $data['main'] = $this->load->view('admin/penugasan_perbaikan/tambah',
        [
            "pp"=>
                $this->permohonan_perbaikan_model->getPermohonanPerbaikan($id),
            "marines"=>$this->marine_model->getMarines()
        ],  
        TRUE);
        $this->load->view('master',$data);
    }
}
