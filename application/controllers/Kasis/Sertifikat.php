<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sertifikat extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kasi')) {
            redirect(site_url('login/kasi'));
        }
    }
    public function index()
    {
        $data['title'] = "Sertifikat";
        $data['header'] = $this->load->view('kasi/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kasi/template/sidebar',["page"=>"sertifikat"], TRUE);
        $data['main'] = $this->load->view('kasi/sertifikat/index',
        [
            "sertifikats"=>
            $this->sertifikat_model->getSertifikatsKasi()
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    public function tambah($id)
    {
        if($this->input->post('submit') !== null){
            $tanggal_terbit = date('Y-m-d');
            $tanggal_kedaluwarsa =  $this->input->post('tanggal_kedaluwarsa');
            $terbit_date = new DateTime($tanggal_terbit);
            $kedaluwarsa_date = new DateTime($tanggal_kedaluwarsa);
            $terbit_date->add(new DateInterval('P4M'));
            if ($kedaluwarsa_date > $terbit_date) {
                $this->session->set_flashdata('error', "Jangka waktu sertifikat maksimal 4 bulan");
            }else{
                $data = array(
                    'permohonan_sertifikat' => $id,
                    'tanggal_terbit' =>  $tanggal_terbit,
                    'tanggal_kedaluwarsa' => $tanggal_kedaluwarsa,
                    'setuju_kabid' => 0,
                    'setuju_admin' => 0
                );
                if($this->sertifikat_model->saveSertifikat($data)){
                    $this->session->set_flashdata('success', "Berhasil menerbitkan sertifikat");
                    redirect(site_url('kasis/sertifikat'));
                }else{
                    $this->session->set_flashdata('error', "Gagal menerbitkan sertifikat, silahkan coba lagi");
                }
            }
        }
        $data['title'] = "Sertifikat";
        $data['header'] = $this->load->view('kasi/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kasi/template/sidebar',["page"=>"sertifikat"], TRUE);
        $data['main'] = $this->load->view('kasi/sertifikat/tambah',
        [
            "pps"=>
                $this->permohonan_sertifikat_model->getPermohonanSertifikat($id)
        ],  
        TRUE);
        $this->load->view('master',$data);
    }
}
