<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index()
    {
        if ($this->session->userdata('kru_kapal')) {
            redirect(site_url('kru_kapal'));
        }
        if($this->input->post('submit') !== null){
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $kru_kapal = $this->kru_kapal_model->login($username, $password);
            if ($kru_kapal) {
                if($kru_kapal->konfirmasi==1){
                    $this->session->set_userdata('kru_kapal', $kru_kapal);
                    redirect(site_url('kru_kapal'));
                }else if($kru_kapal->konfirmasi==2){
                    $this->session->set_flashdata('error', 'Akun telah ditolak, silahkan hubungi admin');
                }else{
                    $this->session->set_flashdata('error', 'Akun belum dikonfirmasi, silahkan hubungi admin.');
                }
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah');
            }
        }
        $this->load->view('kru_kapal/login');
    }
    public function admin()
    {
        if ($this->session->userdata('admin')) {
            redirect(site_url('admin'));
        }
        if($this->input->post('submit') !== null){
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $admin = $this->admin_model->login($username, $password);
            if ($admin) {
                $this->session->set_userdata('admin', $admin);
                redirect(site_url('admin'));
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah');
            }
        }
        $this->load->view('admin/login');
    }
    
    public function kabid()
    {
        if ($this->session->userdata('kabid')) {
            redirect(site_url('kabid'));
        }
        if($this->input->post('submit') !== null){
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $kabid = $this->kabid_model->login($username, $password);
            if ($kabid) {
                $this->session->set_userdata('kabid', $kabid);
                redirect(site_url('kabid'));
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah');
            }
        }
        $this->load->view('kabid/login');
    }
    public function kasi()
    {
        if ($this->session->userdata('kasi')) {
            redirect(site_url('kasi'));
        }
        if($this->input->post('submit') !== null){
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $kasi = $this->kasi_model->login($username, $password);
            if ($kasi) {
                $this->session->set_userdata('kasi', $kasi);
                redirect(site_url('kasi'));
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah');
            }
        }
        $this->load->view('kasi/login');
    }
    public function marine()
    {
        if ($this->session->userdata('marine')) {
            redirect(site_url('marine'));
        }
        if($this->input->post('submit') !== null){
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $marine = $this->marine_model->login($username, $password);
            if ($marine) {
                $this->session->set_userdata('marine', $marine);
                redirect(site_url('marine'));
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah');
            }
        }
        $this->load->view('marine/login');
    }
}
