<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_Survei extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('marine')) {
            redirect(site_url('login/marine'));
        }
    }
    public function index()
    {
        $data['title'] = "Hasil Survei Kapal";
        $data['header'] = $this->load->view('marine/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('marine/template/sidebar',["page"=>"hasil_survei"], TRUE);
        $data['main'] = $this->load->view('marine/hasil_survei/index',
        [
            "hasil_surveis"=>
                $this->hasil_survei_model->getHasilSurveisMarine($this->session->userdata('marine')->id)
        ],  
        TRUE);
        $this->load->view('master',$data);
    }
    public function tambah($id)
    {
        if($this->input->post('submit') !== null){
            $config['upload_path'] = 'uploads/hasil_survei/'; 
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1024; 
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto_kapal')) {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
            } else {
                $data_foto_kapal = $this->upload->data();
                $config['upload_path'] = 'uploads/hasil_survei/'; 
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 1024;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('foto_p3k')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                } else {
                    $data_foto_p3k = $this->upload->data();
                    $config['upload_path'] = 'uploads/hasil_survei/'; 
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = 1024;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('foto_pelampung')) {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                    } else {
                        $data_foto_pelampung = $this->upload->data();
                        $config['upload_path'] = 'uploads/hasil_survei/'; 
                        $config['allowed_types'] = 'gif|jpg|png';
                        $config['max_size'] = 1024;
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('foto_oksigen')) {
                            $error = $this->upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                        } else {
                            $data_foto_oksigen = $this->upload->data();
                            $config['upload_path'] = 'uploads/hasil_survei/'; 
                            $config['allowed_types'] = 'gif|jpg|png';
                            $config['max_size'] = 1024;
                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('foto_navigasi')) {
                                $error = $this->upload->display_errors();
                                $this->session->set_flashdata('error', $error);
                            } else {
                                $data_foto_navigasi = $this->upload->data();
                                $config['upload_path'] = 'uploads/hasil_survei/'; 
                                $config['allowed_types'] = 'gif|jpg|png';
                                $config['max_size'] = 1024;
                                $this->load->library('upload', $config);
                                if (!$this->upload->do_upload('foto_radio')) {
                                    $error = $this->upload->display_errors();
                                    $this->session->set_flashdata('error', $error);
                                } else {
                                    $data_foto_radio = $this->upload->data();
                                    $data = array(
                                        'permohonan_survei' => $id,
                                        'kondisi_kapal' => $this->input->post('kondisi_kapal'),
                                        'surat_ukur' => $this->input->post('surat_ukur'),
                                        'pas_besar' => $this->input->post('pas_besar'),
                                        'inventaris_dek' => $this->input->post('inventaris_dek'),
                                        'inventaris_mesin' => $this->input->post('inventaris_mesin'),
                                        'keterangan' => $this->input->post('keterangan'),
                                        'foto_kapal' => $data_foto_kapal['file_name'],
                                        'lokasi_survei' => $this->input->post('lokasi_survei'),
                                        'tanggal_terbit' =>  date('Y-m-d'),
                                        'p3k' => $this->input->post('p3k'),
                                        'foto_p3k' => $data_foto_p3k['file_name'],
                                        'pelampung' => $this->input->post('pelampung'),
                                        'foto_pelampung' => $data_foto_pelampung['file_name'],
                                        'oksigen' => $this->input->post('oksigen'),
                                        'foto_oksigen' => $data_foto_oksigen['file_name'],
                                        'navigasi' => $this->input->post('navigasi'),
                                        'foto_navigasi' => $data_foto_navigasi['file_name'],
                                        'radio' => $this->input->post('radio'),
                                        'foto_radio' => $data_foto_radio['file_name']
                                    );
                                    if($this->hasil_survei_model->saveHasilSurvei($data)){
                                        $this->session->set_flashdata('success', "Berhasil membuat hasil survei");
                                        redirect(site_url('marines/hasil_survei'));
                                    }else{
                                        $this->session->set_flashdata('error', "Gagal membuat hasil survei, silahkan coba lagi");
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $data['title'] = "Hasil Survei Kapal";
        $data['header'] = $this->load->view('marine/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('marine/template/sidebar',["page"=>"hasil_survei"], TRUE);
        $data['main'] = $this->load->view('marine/hasil_survei/tambah',
        [
            "p"=>
                $this->permohonan_survei_model->getPermohonanSurvei($id)
        ],  
        TRUE);
        $this->load->view('master',$data);
    }
    public function surat($id){
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "surat-hasil-survei-$id.pdf";
        $this->pdf->load_view('marine/hasil_survei/surat', 
            [
                'id' => $id,
                'hs' => $this->hasil_survei_model->getHasilSurvei($id)
            ]
        );
    }
}
