<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kru_Kapal extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('admin')) {
            redirect(site_url('login/admin'));
        }
    }
    public function index()
    {
        if($this->input->post('konfirmasi') !== null){
            $id = $this->input->post('id');
            $konfirmasi = $this->input->post('konfirmasi');
            if($this->kru_kapal_model->konfirmasiKruKapal($id,$konfirmasi)){
                $this->session->set_flashdata('success', "Berhasil konfirmasi kru kapal");
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi kru kapal, silahkan coba lagi");
            }
        }
        $data['title'] = "Kru Kapal";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"kru_kapal"], TRUE);
        $data['main'] = $this->load->view('admin/kru_kapal/index',["kru_kapals"=>$this->kru_kapal_model->getKruKapals()], TRUE);
        $this->load->view('master',$data);
    }
    public function ubah($id)
    {
        if($this->input->post('submit') !== null){
            $data = array(
                'nama' => $this->input->post('nama'),
                'kapal' => $this->input->post('kapal')
            );
            if($this->input->post('password')){
                $data["password"] =  md5($this->input->post('password'));
            }
            if($this->kru_kapal_model->updateKruKapal($id,$data)){
                $this->session->set_flashdata('success', "Berhasil mengubah kru kapal");
            }else{
                $this->session->set_flashdata('error', "Gagal mengubah kru kapal, silahkan coba lagi");
            }
        }
        
        $data['title'] = "Kru Kapal";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"kru_kapal"], TRUE);
        $data['main'] = $this->load->view('admin/kru_kapal/ubah',["kru_kapal"=>$this->kru_kapal_model->getKruKapal($id),"kapals"=>$this->kapal_model->getKapals()], TRUE);
        $this->load->view('master',$data);
    }
    public function hapus($id){
        if($this->kru_kapal_model->deleteKruKapal($id)){
            $this->session->set_flashdata('success', "Berhasil menghapus kru kapal");
        }else{
            $this->session->set_flashdata('error', "Gagal menghapus kru kapal, silahkan coba lagi");
        }
        redirect(site_url('admins/kru_kapal'));
    }
}
