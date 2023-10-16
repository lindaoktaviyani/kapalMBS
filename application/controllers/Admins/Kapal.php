<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kapal extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('admin')) {
            redirect(site_url('login/admin'));
        }
    }
    public function index()
    {
        $data['title'] = "Kapal";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"kapal"], TRUE);
        $data['main'] = $this->load->view('admin/kapal/index',["kapals"=>$this->kapal_model->getKapals()], TRUE);
        $this->load->view('master',$data);
    }
    public function tambah()
    {
        if($this->input->post('submit') !== null){
            $data = array(
                'nama' => $this->input->post('nama'),
                'pengenal' => $this->input->post('pengenal'),
                'pelabuhan' => $this->input->post('pelabuhan'),
                'GT' => $this->input->post('gt'),
                'jenis_mesin' => $this->input->post('jenis_mesin')
            );
            if($this->kapal_model->saveKapal($data)){
                $this->session->set_flashdata('success', "Berhasil menambah kapal");
            }else{
                $this->session->set_flashdata('error', "Gagal menambah kapal, silahkan coba lagi");
            }
        }
        $data['title'] = "Kapal";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"kapal"], TRUE);
        $data['main'] = $this->load->view('admin/kapal/tambah',null, TRUE);
        $this->load->view('master',$data);
    }
    public function ubah($id)
    {
        if($this->input->post('submit') !== null){
            $data = array(
                'nama' => $this->input->post('nama'),
                'pengenal' => $this->input->post('pengenal'),
                'pelabuhan' => $this->input->post('pelabuhan'),
                'GT' => $this->input->post('gt'),
                'jenis_mesin' => $this->input->post('jenis_mesin')
            );
            if($this->kapal_model->updateKapal($id,$data)){
                $this->session->set_flashdata('success', "Berhasil mengubah kapal");
            }else{
                $this->session->set_flashdata('error', "Gagal  mengubah kapal, silahkan coba lagi");
            }
        }
        $data['title'] = "Kapal";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"kapal"], TRUE);
        $data['main'] = $this->load->view('admin/kapal/ubah',["kapal"=>$this->kapal_model->getKapal($id)], TRUE);
        $this->load->view('master',$data);
    }
    public function hapus($id){
        if($this->kapal_model->deleteKapal($id)){
            $this->session->set_flashdata('success', "Berhasil menghapus kapal");
        }else{
            $this->session->set_flashdata('error', "Gagal menghapus kapal, silahkan coba lagi");
        }
        redirect(site_url('admins/kapal'));
    }
}
