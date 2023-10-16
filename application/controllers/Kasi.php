<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasi extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kasi')) {
            redirect(site_url('login/kasi'));
        }
    }
    public function index()
    {
        $data['title'] = "Dashboard";
        $data['header'] = $this->load->view('kasi/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kasi/template/sidebar',["page"=>"dashboard"], TRUE);
        $data['main'] = $this->load->view('kasi/dashboard',null, TRUE);;
        $this->load->view('master',$data);
    }
    public function profil()
    {
        if($this->input->post('submit') !== null){
            $data = array(
                'nama' => $this->input->post('nama')
            );
            if($this->input->post('password')){
                $data["password"] =  md5($this->input->post('password'));
            }
            if (!empty($_FILES['tanda_tangan']['name'])) {
                $config['upload_path'] = 'uploads/kasi/'; 
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 1024; 
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('tanda_tangan')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                } else {
                    $data_upload = $this->upload->data();
                    $data["tanda_tangan"] =  $data_upload['file_name'];
                    $kasi = $this->kasi_model->getKasiID($this->session->userdata('kasi')->id);
                    $path = "uploads/kasi/".$kasi->tanda_tangan;
                }
            }
            if($this->kasi_model->updateKasi($this->session->userdata('kasi')->id,$data)){
                $this->session->set_flashdata('success', "Berhasil mengubah profil");
                $this->session->set_userdata('kasi', $this->kasi_model->getKasiID($this->session->userdata('kasi')->id));
                if(isset($path)){
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }else{
                $this->session->set_flashdata('error', "Gagal mengubah profil, silahkan coba lagi");
            }
        }
        $data['title'] = "Profil";
        $data['header'] = $this->load->view('kasi/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kasi/template/sidebar',["page"=>""], TRUE);
        $data['main'] = $this->load->view('kasi/profil',null, TRUE);;
        $this->load->view('master',$data);
    }
    public function logout()
    {
        $this->session->unset_userdata('kasi');
        redirect(site_url('login/kasi'));
    }
}
