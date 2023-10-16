<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_Perbaikan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('marine')) {
            redirect(site_url('login/marine'));
        }
    }
    public function index()
    {
        $data['title'] = "Hasil Perbaikan Kapal";
        $data['header'] = $this->load->view('marine/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('marine/template/sidebar',["page"=>"hasil_perbaikan"], TRUE);
        $data['main'] = $this->load->view('marine/hasil_perbaikan/index',
        [
            "hasil_perbaikans"=>
                $this->hasil_perbaikan_model->getHasilPerbaikansMarine($this->session->userdata('marine')->id)
        ],  
        TRUE);
        $this->load->view('master',$data);
    }
    public function tambah($id)
    {
        if($this->input->post('submit') !== null){
            $config['upload_path'] = 'uploads/hasil_perbaikan/'; 
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1024; 
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto_kapal')) {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
            } else {
                $data = $this->upload->data();
                $data = array(
                    'penugasan_perbaikan' => $id,
                    'catatan' => $this->input->post('catatan'),
                    'foto_kapal' => $data['file_name'],
                    'tanggal_perbaikan' => $this->input->post('tanggal_perbaikan')
                );
                if($this->hasil_perbaikan_model->saveHasilPerbaikan($data)){
                    $this->penugasan_perbaikan_model->konfirmasiPenugasanPerbaikan($id,1);
                    $this->session->set_flashdata('success', "Berhasil membuat hasil perbaikan");
                    redirect(site_url('marines/hasil_perbaikan'));
                }else{
                    $this->session->set_flashdata('error', "Gagal membuat hasil perbaikan, silahkan coba lagi");
                }
            }
        }
        $data['title'] = "Hasil Perbaikan Kapal";
        $data['header'] = $this->load->view('marine/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('marine/template/sidebar',["page"=>"hasil_perbaikan"], TRUE);
        $data['main'] = $this->load->view('marine/hasil_perbaikan/tambah',
        [
            "p"=>
                $this->penugasan_perbaikan_model->getPenugasanPerbaikan($id)
        ],  
        TRUE);
        $this->load->view('master',$data);
    }
}
