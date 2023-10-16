<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kabid extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kabid')) {
            redirect(site_url('login/kabid'));
        }
    }
    public function index()
    {
        $data['title'] = "Dashboard";
        $data['header'] = $this->load->view('kabid/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kabid/template/sidebar',["page"=>"dashboard"], TRUE);
        $data['main'] = $this->load->view('kabid/dashboard',null, TRUE);;
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
                $config['upload_path'] = 'uploads/kabid/'; 
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 1024; 
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('tanda_tangan')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                } else {
                    $data_upload = $this->upload->data();
                    $data["tanda_tangan"] =  $data_upload['file_name'];
                    $kabid = $this->kabid_model->getKabidID($this->session->userdata('kabid')->id);
                    $path = "uploads/kabid/".$kabid->tanda_tangan;
                }
            }
            if (!empty($_FILES['tanda_tangan2']['name'])) {
                $config['upload_path'] = 'uploads/kabid/'; 
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 1024; 
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('tanda_tangan2')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                } else {
                    $data_upload = $this->upload->data();
                    $data["tanda_tangan2"] =  $data_upload['file_name'];
                    $kabid = $this->kabid_model->getKabidID($this->session->userdata('kabid')->id);
                    $path = "uploads/kabid/".$kabid->tanda_tangan2;
                }
            }
            if($this->kabid_model->updateKabid($this->session->userdata('kabid')->id,$data)){
                $this->session->set_flashdata('success', "Berhasil mengubah profil");
                $this->session->set_userdata('kabid', $this->kabid_model->getKabidID($this->session->userdata('kabid')->id));
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
        $data['header'] = $this->load->view('kabid/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kabid/template/sidebar',["page"=>""], TRUE);
        $data['main'] = $this->load->view('kabid/profil',null, TRUE);;
        $this->load->view('master',$data);
    }
    public function logout()
    {
        $this->session->unset_userdata('kabid');
        redirect(site_url('login/kabid'));
    }
}
