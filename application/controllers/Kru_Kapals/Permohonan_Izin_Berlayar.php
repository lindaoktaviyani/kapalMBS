<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_Izin_Berlayar extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kru_kapal')) {
            redirect(site_url('login'));
        }
    }
    public function index()
    {
        $data['title'] = "Permohonan Izin Berlayar";
        $data['header'] = $this->load->view('kru_kapal/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kru_kapal/template/sidebar',["page"=>"permohonan_izin_berlayar"], TRUE);
        $data['main'] = $this->load->view('kru_kapal/permohonan_izin_berlayar/index',
        ["permohonan_izin_berlayars"=>
            $this->permohonan_izin_berlayar_model->getPermohonanIzinBerlayarsKru(
                $this->session->userdata('kru_kapal')->kapal
            )
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    public function tambah()
    {
        if($this->input->post('submit') !== null){
            $data = array(
                'kapal' => $this->session->userdata('kru_kapal')->kapal,
                'nahkoda' => $this->input->post('nahkoda'),
                'asal' =>  $this->input->post('asal'),
                'tujuan' =>  $this->input->post('tujuan'),
                'tanggal' =>  $this->input->post('tanggal'),
                'jumlah_awak' =>  $this->input->post('jumlah_awak'),
                'setuju_admin' => 0,
                'setuju_kabid' => 0
            );
            if($this->permohonan_izin_berlayar_model->savePermohonanIzinBerlayar($data)){
                $this->session->set_flashdata('success', "Berhasil menambah permohonan izin berlayar");
            }else{
                $this->session->set_flashdata('error', "Gagal menambah permohonan izin berlayar, silahkan coba lagi");
            }
        }
        $data['title'] = "Permohonan Izin Berlayar";
        $data['header'] = $this->load->view('kru_kapal/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kru_kapal/template/sidebar',["page"=>"permohonan_izin_berlayar"], TRUE);
        $data['main'] = $this->load->view('kru_kapal/permohonan_izin_berlayar/tambah',null, TRUE);
        $this->load->view('master',$data);
    }
}
