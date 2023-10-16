<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marine extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('marine')) {
            redirect(site_url('login/marine'));
        }
    }
    public function index()
    {
        $data['title'] = "Dashboard";
        $data['header'] = $this->load->view('marine/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('marine/template/sidebar',["page"=>"dashboard"], TRUE);
        $data['main'] = $this->load->view('marine/dashboard',null, TRUE);;
        $this->load->view('master',$data);
    }
    public function logout()
    {
        $this->session->unset_userdata('marine');
        redirect(site_url('login/marine'));
    }
}
