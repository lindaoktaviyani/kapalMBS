<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penugasan_Perbaikan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('marine')) {
            redirect(site_url('login/marine'));
        }
    }
    public function index()
    {
        if($this->input->post('konfirmasi') !== null){
            $id = $this->input->post('id');
            $konfirmasi = $this->input->post('konfirmasi');
            if($this->penugasan_perbaikan_model->konfirmasiPenugasanPerbaikan($id,$konfirmasi)){
                $this->session->set_flashdata('success', "Berhasil konfirmasi penugasan");
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi penugasan, silahkan coba lagi");
            }
        }
        $data['title'] = "Penugasan";
        $data['header'] = $this->load->view('marine/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('marine/template/sidebar',["page"=>"penugasan_perbaikan"], TRUE);
        $data['main'] = $this->load->view('marine/penugasan_perbaikan/index',
        [
            "penugasan_perbaikan"=>
            $this->penugasan_perbaikan_model->getPenugasanPerbaikansMarine($this->session->userdata('marine')->id)
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
}
