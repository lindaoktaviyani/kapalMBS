<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marine extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('admin')) {
            redirect(site_url('login/admin'));
        }
    }
    public function index()
    {
        $data['title'] = "Marine";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"marine"], TRUE);
        $data['main'] = $this->load->view('admin/marine/index',["marines"=>$this->marine_model->getMarines()], TRUE);
        $this->load->view('master',$data);
    }
    public function tambah()
    {
        if($this->input->post('submit') !== null){
            if($this->marine_model->checkMarineUsername($this->input->post('username'))){
                $config['upload_path'] = 'uploads/marine/'; 
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 1024; 
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('tanda_tangan')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                } else {
                    $data = $this->upload->data();
                    $data = array(
                        'nama' => $this->input->post('nama'),
                        'username' => $this->input->post('username'),
                        'password' => md5($this->input->post('password')),
                        'tanda_tangan' => $data['file_name']
                    );
                    if($this->marine_model->saveMarine($data)){
                        $this->session->set_flashdata('success', "Berhasil menambah marine");
                    }else{
                        $this->session->set_flashdata('error', "Gagal menambah marine, silahkan coba lagi");
                    }
                }
            }else{
                $this->session->set_flashdata('error', "Username telah dipakai");
            }
        }
        
        $data['title'] = "Marine";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"marine"], TRUE);
        $data['main'] = $this->load->view('admin/marine/tambah',null, TRUE);
        $this->load->view('master',$data);
    }
    public function ubah($id)
    {
        if($this->input->post('submit') !== null){
            $data = array(
                'nama' => $this->input->post('nama')
            );
            if($this->input->post('password')){
                $data["password"] =  md5($this->input->post('password'));
            }
            if (!empty($_FILES['tanda_tangan']['name'])) {
                $config['upload_path'] = 'uploads/marine/'; 
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 1024; 
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('tanda_tangan')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                } else {
                    $data_upload = $this->upload->data();
                    $data["tanda_tangan"] =  $data_upload['file_name'];
                    $marine = $this->marine_model->getMarine($id);
                    $path = "uploads/marine/".$marine->tanda_tangan;
                }
            }
            if($this->marine_model->updateMarine($id,$data)){
                $this->session->set_flashdata('success', "Berhasil mengubah marine");
                if(isset($path)){
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }else{
                $this->session->set_flashdata('error', "Gagal mengubah marine, silahkan coba lagi");
            }
        }
        
        $data['title'] = "Marine";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"marine"], TRUE);
        $data['main'] = $this->load->view('admin/marine/ubah',["marine"=>$this->marine_model->getMarine($id)], TRUE);
        $this->load->view('master',$data);
    }
    public function hapus($id){
        $marine = $this->marine_model->getMarine($id);
        if($marine){
            $path = "uploads/marine/".$marine->tanda_tangan;
            if($this->marine_model->deleteMarine($id)){
                if (file_exists($path)) {
                    unlink($path);
                }
                $this->session->set_flashdata('success', "Berhasil menghapus marine");
            }else{
                $this->session->set_flashdata('error', "Gagal menghapus marine, silahkan coba lagi");
            }
        }else{
            $this->session->set_flashdata('error', "Data tidak ditemukan");
        }
        redirect(site_url('admins/marine'));
    }
}
