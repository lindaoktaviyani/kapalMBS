<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_Survei extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('marine')) {
            redirect(site_url('login/marine'));
        }
    }
    public function index()
    {
        $data['title'] = "Permohonan Survei Kapal";
        $data['header'] = $this->load->view('marine/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('marine/template/sidebar',["page"=>"permohonan_survei"], TRUE);
        $data['main'] = $this->load->view('marine/permohonan_survei/index',
        [
            "permohonan_surveis"=>
                $this->permohonan_survei_model->getPermohonanSurveisMarine($this->session->userdata('marine')->id)
        ],  
        TRUE);
        $this->load->view('master',$data);
    }
    public function tambah($id)
    {
        if($this->input->post('submit') !== null){
            $data = array(
                'penugasan_marine' => $id,
                'tanggal' => $this->input->post('tanggal'),
                'catatan' => $this->input->post('catatan'),
                'tanggal_terbit' =>  date('Y-m-d'),
                'setuju_admin' => 0
            );
            if($this->permohonan_survei_model->savePermohonanSurvei($data)){
                $this->penugasan_marine_model->konfirmasiPenugasanMarineMarine($id,1);
                $this->session->set_flashdata('success', "Berhasil membuat permohonan survei");
                redirect(site_url('marines/permohonan_survei'));
            }else{
                $this->session->set_flashdata('error', "Gagal membuat permohonan survei, silahkan coba lagi");
            }
        }
        $data['title'] = "Permohonan Survei Kapal";
        $data['header'] = $this->load->view('marine/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('marine/template/sidebar',["page"=>"permohonan_survei"], TRUE);
        $data['main'] = $this->load->view('marine/permohonan_survei/tambah',
        [
            "p"=>
                $this->penugasan_marine_model->getPenugasanMarine($id)
        ],  
        TRUE);
        $this->load->view('master',$data);
    }
    public function batal($id)
    {
        if($this->input->post('submit') !== null){
            $catatan = $this->input->post('catatan');
            if($this->permohonan_survei_model->batalPermohonaSurvei($id,$catatan)){
                
                $this->penugasan_marine_model->konfirmasiPenugasanMarineMarine($this->permohonan_survei_model->getPermohonanSurvei($id)->penugasan_marine,0);

                $this->session->set_flashdata('success', "Berhasil konfirmasi permohonan survei");
                redirect(site_url('marines/permohonan_survei'));
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi permohonan survei, silahkan coba lagi");
            }
        }
        $data['title'] = "Batal Permohonan Survei";
        $data['header'] = $this->load->view('marine/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('marine/template/sidebar',["page"=>"permohonan_survei"], TRUE);
        $data['main'] = $this->load->view('marine/permohonan_survei/batal',null,TRUE);
        $this->load->view('master',$data);
    }
}
