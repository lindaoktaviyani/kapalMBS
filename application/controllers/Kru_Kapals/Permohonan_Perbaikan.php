<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_Perbaikan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kru_kapal')) {
            redirect(site_url('login'));
        }
    }
    public function index()
    {
        $data['title'] = "Permohonan Perbaikan Kapal";
        $data['header'] = $this->load->view('kru_kapal/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kru_kapal/template/sidebar',["page"=>"permohonan_perbaikan"], TRUE);
        $data['main'] = $this->load->view('kru_kapal/permohonan_perbaikan/index',
        ["permohonan_perbaikans"=>
            $this->permohonan_perbaikan_model->getPermohonanPerbaikansKru(
                $this->session->userdata('kru_kapal')->kapal
            )
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    public function tambah()
    {
        if($this->input->post('submit') !== null){
            $config['upload_path'] = 'uploads/permohonan_perbaikan/'; 
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1024; 
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto_kerusakan')) {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
            } else {
                $data = $this->upload->data();
                $data = array(
                    'kapal' => $this->session->userdata('kru_kapal')->kapal,
                    'lokasi' => $this->input->post('lokasi'),
                    'detail_kerusakan' => $this->input->post('detail_kerusakan'),
                    'foto_kerusakan' => $data['file_name'],
                    'setuju_admin' => 0
                );
                if($this->permohonan_perbaikan_model->savePermohonanPerbaikan($data)){
                    $this->session->set_flashdata('success', "Berhasil membuat permohonan perbaikan");
                    redirect(site_url('kru_kapals/permohonan_perbaikan'));
                }else{
                    $this->session->set_flashdata('error', "Gagal membuat permohonan perbaikan, silahkan coba lagi");
                }
            }
        }
        $data['title'] = "Permohonan Perbaikan Kapal";
        $data['header'] = $this->load->view('kru_kapal/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kru_kapal/template/sidebar',["page"=>"permohonan_perbaikan"], TRUE);
        $data['main'] = $this->load->view('kru_kapal/permohonan_perbaikan/tambah',null, TRUE);
        $this->load->view('master',$data);
    }
}
