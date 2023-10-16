<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_Perpanjangan_Sertifikat extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kru_kapal')) {
            redirect(site_url('login'));
        }
    }
    public function index()
    {
        $data['title'] = "Perpanjangan Sertifikat";
        $data['header'] = $this->load->view('kru_kapal/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kru_kapal/template/sidebar',["page"=>"perpanjangan_sertifikat"], TRUE);
        $data['main'] = $this->load->view('kru_kapal/permohonan_perpanjangan_sertifikat/index',
        ["permohonan_perpanjangan_sertifikats"=>
            $this->permohonan_sertifikat_model->getPermohonanPerpanjanganSertifikatsKru(
                $this->session->userdata('kru_kapal')->kapal
            )
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    public function tambah($id)
    {
        $permohonan_sertifikat = $this->permohonan_sertifikat_model->getPermohonanSertifikat($id);
        if($this->input->post('submit') !== null){
            if(!$this->permohonan_sertifikat_model->checkPermohonanPerpanjanganTerakhir($id)){
                $this->session->set_flashdata('error', "Sertifikat sedang diperpanjang");
                redirect(site_url('kru_kapals/sertifikat'));
            }
            $this->load->library('upload');
            $config['upload_path'] = 'uploads/permohonan_sertifikat/p3k/'; 
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1024; 
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('foto_p3k')) {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
            } else {
                $data_p3k = $this->upload->data();
                $config['upload_path'] = 'uploads/permohonan_sertifikat/alat_navigasi/'; 
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 1024; 
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('foto_alat_navigasi')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                } else {
                    $data_alat_navigasi = $this->upload->data();
                    $config['upload_path'] = 'uploads/permohonan_sertifikat/radio/'; 
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = 1024; 
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('foto_radio')) {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                    } else {
                        $data_radio = $this->upload->data();
                        $config['upload_path'] = 'uploads/permohonan_sertifikat/sertifikat_lama/'; 
                        $config['allowed_types'] = 'pdf|doc|docx';
                        $config['max_size'] = 4096; 
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('sertifikat_lama')) {
                            $error = $this->upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                        } else {
                            $data_sertifikat_lama = $this->upload->data();
                            $data = array(
                                'kapal' => $permohonan_sertifikat->kapal,
                                'sertifikat' => $permohonan_sertifikat->sertifikat,
                                'tanggal_pengajuan' => date('Y-m-d'),
                                'posisi_kapal' => $this->input->post('posisi_kapal'),
                                'foto_p3k' => $data_p3k['file_name'],
                                'foto_alat_navigasi' => $data_alat_navigasi['file_name'],
                                'foto_radio' => $data_radio['file_name'],
                                'sertifikat_lama' => $data_sertifikat_lama['file_name'],
                                'setuju_admin' => 0,
                                'setuju_kasi' => 0,
                                'permohonan_sertifikat_diperpanjang' => $id
                            );
                            if($this->permohonan_sertifikat_model->savePermohonanPerpanjanganSertifikat($data)){
                                $this->session->set_flashdata('success', "Berhasil menambah permohonan perpanjangan sertifikat");
                                redirect(site_url('kru_kapals/permohonan_perpanjangan_sertifikat'));
                            }else{
                                $this->session->set_flashdata('error', "Gagal menambah permohonan perpanjangan sertifikat, silahkan coba lagi");
                            }
                        }
                    }
                }
            }
        }
        $data['title'] = "Permohonan Perpanjangan Sertifikat";
        $data['header'] = $this->load->view('kru_kapal/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kru_kapal/template/sidebar',["page"=>"perpanjangan_sertifikat"], TRUE);
        $data['main'] = $this->load->view('kru_kapal/permohonan_perpanjangan_sertifikat/tambah',[
            "pps" => $permohonan_sertifikat
        ], TRUE);
        $this->load->view('master',$data);
    }
}
