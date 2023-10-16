<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('admin')) {
            redirect(site_url('login/admin'));
        }
    }

    public function hasil_survei()
    {
        $data['title'] = "Laporan Hasil Survei";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"laporan_hasil_survei"], TRUE);
        $data['main'] = $this->load->view('admin/laporan/hasil_survei',null,TRUE);
        $this->load->view('master',$data);
    }

    public function laporan_hasil_survei(){
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        if(strtotime($awal) > strtotime($akhir)){
            $this->session->set_flashdata('error', "Tanggal akhir harus lebih besar dari tanggal awal");
            redirect(site_url('admins/laporan/hasil_survei'));
        }
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "surat-hasil-survei.pdf";
        $this->pdf->load_view('laporan/hasil_survei', 
            [
                'awal' => $awal,
                'akhir' => $akhir,
                'hasil_surveis' => $this->hasil_survei_model->getHasilSurveisLaporan($awal,$akhir),
                'k' => $this->kasi_model->getKasi()
            ]
        );
    }

    public function penugasan_marine()
    {
        $data['title'] = "Laporan Hasil Survei";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"laporan_penugasan_marine"], TRUE);
        $data['main'] = $this->load->view('admin/laporan/penugasan_marine',null,TRUE);
        $this->load->view('master',$data);
    }

    public function laporan_penugasan_marine(){
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        if(strtotime($awal) > strtotime($akhir)){
            $this->session->set_flashdata('error', "Tanggal akhir harus lebih besar dari tanggal awal");
            redirect(site_url('admins/laporan/penugasan_marine'));
        }
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-penugasan-marine.pdf";
        $this->pdf->load_view('laporan/penugasan_marine', 
            [
                'awal' => $awal,
                'akhir' => $akhir,
                'penugasan_marines' => $this->penugasan_marine_model->getPenugasanMarineLaporan($awal,$akhir),
                'k' => $this->kasi_model->getKasi()
            ]
        );
    }

    public function pembatalan_survei()
    {
        $data['title'] = "Laporan Pembatalan Survei";
        $data['header'] = $this->load->view('admin/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('admin/template/sidebar',["page"=>"laporan_pembatalan_survei"], TRUE);
        $data['main'] = $this->load->view('admin/laporan/pembatalan_survei',null,TRUE);
        $this->load->view('master',$data);
    }

    public function laporan_pembatalan_survei(){
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        if(strtotime($awal) > strtotime($akhir)){
            $this->session->set_flashdata('error', "Tanggal akhir harus lebih besar dari tanggal awal");
            redirect(site_url('admins/laporan/pembatalan_survei'));
        }
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-pembatalan-survei.pdf";
        $this->pdf->load_view('laporan/pembatalan_survei', 
            [
                'awal' => $awal,
                'akhir' => $akhir,
                'pembatalan_surveis' => $this->permohonan_survei_model->getPembatalanSurveisLaporan($awal,$akhir),
                'k' => $this->kasi_model->getKasi()
            ]
        );
        ;
    }
}
