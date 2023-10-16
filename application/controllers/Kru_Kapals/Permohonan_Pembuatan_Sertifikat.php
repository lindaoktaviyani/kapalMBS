<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_Pembuatan_Sertifikat extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kru_kapal')) {
            redirect(site_url('login'));
        }
    }
    public function index()
    {
        $data['title'] = "Permohonan Pembuatan Sertifikat";
        $data['header'] = $this->load->view('kru_kapal/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kru_kapal/template/sidebar',["page"=>"pembuatan_sertifikat"], TRUE);
        $data['main'] = $this->load->view('kru_kapal/permohonan_pembuatan_sertifikat/index',
        ["permohonan_pembuatan_sertifikats"=>
            $this->permohonan_sertifikat_model->getPermohonanPembuatanSertifikatsKru(
                $this->session->userdata('kru_kapal')->kapal
            )
        ], 
        TRUE);
        $this->load->view('master',$data);
    }
    public function tambah()
    {
        if($this->input->post('submit') !== null){
            $this->load->library('upload');
            $config['upload_path'] = 'uploads/permohonan_sertifikat/surat_ukur/'; 
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = 4096; 
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('surat_ukur')) {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
            } else {
                $data_surat_ukur = $this->upload->data();
                $config['upload_path'] = 'uploads/permohonan_sertifikat/surat_pas_besar/'; 
                $config['allowed_types'] = 'pdf|doc|docx';
                $config['max_size'] = 4096; 
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('surat_pas_besar')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                } else {
                    $data_surat_pas_besar = $this->upload->data();
                    $config['upload_path'] = 'uploads/permohonan_sertifikat/inventaris_dek/'; 
                    $config['allowed_types'] = 'pdf|doc|docx';
                    $config['max_size'] = 4096; 
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('file_inventaris_dek')) {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                    } else {
                        $data_inventaris_dek = $this->upload->data();
                        $config['upload_path'] = 'uploads/permohonan_sertifikat/inventaris_mesin/'; 
                        $config['allowed_types'] = 'pdf|doc|docx';
                        $config['max_size'] = 4096; 
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('file_inventaris_mesin')) {
                            $error = $this->upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                        } else {
                            $data_inventaris_mesin = $this->upload->data();
                            $data = array(
                                'kapal' => $this->session->userdata('kru_kapal')->kapal,
                                'sertifikat' => $this->input->post('sertifikat'),
                                'tanggal_pengajuan' => date('Y-m-d'),
                                'posisi_kapal' => $this->input->post('posisi_kapal'),
                                'surat_ukur' => $data_surat_ukur['file_name'],
                                'surat_pas_besar' => $data_surat_pas_besar['file_name'],
                                'file_inventaris_dek' => $data_inventaris_dek['file_name'],
                                'file_inventaris_mesin' => $data_inventaris_mesin['file_name'],
                                'setuju_admin' => 0,
                                'setuju_kasi' => 0
                            );
                            if($this->permohonan_sertifikat_model->savePermohonanPembuatanSertifikat($data)){
                                $this->session->set_flashdata('success', "Berhasil menambah permohonan pembuatan sertifikat");
                            }else{
                                $this->session->set_flashdata('error', "Gagal menambah permohonan pembuatan sertifikat, silahkan coba lagi");
                            }
                        }
                    }
                }
            }
        }
        $data['title'] = "Permohonan Pembuatan Sertifikat";
        $data['header'] = $this->load->view('kru_kapal/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kru_kapal/template/sidebar',["page"=>"pembuatan_sertifikat"], TRUE);
        $data['main'] = $this->load->view('kru_kapal/permohonan_pembuatan_sertifikat/tambah',[
            "sertifikats" => $this->permohonan_sertifikat_model->getSertifikatTerbuat(
                $this->session->userdata('kru_kapal')->kapal
            )
        ], TRUE);
        $this->load->view('master',$data);
    }
}
