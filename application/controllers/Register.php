<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function index()
    {
        if ($this->session->userdata('kru_kapal')) {
            redirect(site_url('kru_kapal'));
        }
        if($this->input->post('submit') !== null){
            if($this->kru_kapal_model->checkKruKapalUsername($this->input->post('username'))){
                if($this->input->post('password')==$this->input->post('password_konfirmasi')){
                    $data = array(
                        'nama' => $this->input->post('nama'),
                        'username' => $this->input->post('username'),
                        'password' => md5($this->input->post('password')),
                        'kapal' => $this->input->post('kapal'),
                        'konfirmasi' => 0
                    );
                    if($this->kru_kapal_model->saveKruKapal($data)){
                        $this->session->set_flashdata('success', "Berhasil menambah Kru Kapal");
                    }else{
                        $this->session->set_flashdata('error', "Gagal menambah Kru Kapal, silahkan coba lagi");
                    }
                }else{
                    $this->session->set_flashdata('error', "Konfirmasi password tidak sesuai");
                }
            }else{
                $this->session->set_flashdata('error', "Username telah dipakai");
            }
        }
        $this->load->view('kru_kapal/register',["kapals"=>$this->kapal_model->getKapals()]);
    }
}
