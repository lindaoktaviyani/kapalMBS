<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('admin')) {
            redirect(site_url('login/admin'));
        }
    }
    public function index()
    {
        $data['title'] = "Dashboard";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"dashboard"], TRUE);
        $data['main'] = $this->load->view('admin/dashboard',null, TRUE);;
        $this->load->view('master',$data);
    }
    public function logout()
    {
        $this->session->unset_userdata('admin');
        redirect(site_url('login/admin'));
    }
}
