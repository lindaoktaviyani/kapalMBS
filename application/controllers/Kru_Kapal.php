<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kru_Kapal extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kru_kapal')) {
            redirect(site_url('login/'));
        }
    }
    public function index()
    {
        $data['title'] = "Dashboard";
        $data['header'] = $this->load->view('kru_kapal/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kru_kapal/template/sidebar',["page"=>"dashboard"], TRUE);
        $data['main'] = $this->load->view('kru_kapal/dashboard',null, TRUE);;
        $this->load->view('master',$data);
    }
    public function logout()
    {
        $this->session->unset_userdata('kru_kapal');
        redirect(site_url('login'));
    }
}
