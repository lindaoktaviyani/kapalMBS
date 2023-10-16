<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sertifikat extends CI_Controller {
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
            if($this->sertifikat_model->konfirmasiSertifikatAdmin($id,$konfirmasi)){
                $this->session->set_flashdata('success', "Berhasil konfirmasi sertifikat");
            }else{
                $this->session->set_flashdata('error', "Gagal konfirmasi sertifikat, silahkan coba lagi");
            }
        }
        $data['title'] = "Sertifikat";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"sertifikat"], TRUE);
        $data['main'] = $this->load->view('admin/sertifikat/index',
        [
            "sertifikats"=>
            $this->sertifikat_model->getSertifikatsAdmin()
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    public function surat($id){
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "surat-sertifikat-$id.pdf";
        $this->pdf->load_view('kabid/sertifikat/surat', 
            [
                'id' => $id,
                's' => $this->sertifikat_model->getSertifikat($id),
                'k' => $this->kabid_model->getKabid()
            ]
        );
    }
}
