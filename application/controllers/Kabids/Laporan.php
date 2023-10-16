<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('kabid')) {
            redirect(site_url('login/kabid'));
        }
    }

    public function hasil_survei()
    {
        $data['title'] = "Laporan Hasil Survei";
        $data['header'] = $this->load->view('kabid/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kabid/template/sidebar',["page"=>"laporan_hasil_survei"], TRUE);
        $data['main'] = $this->load->view('kabid/laporan/hasil_survei',null,TRUE);
        $this->load->view('master',$data);
    }

    public function laporan_hasil_survei(){
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        if(strtotime($awal) > strtotime($akhir)){
            $this->session->set_flashdata('error', "Tanggal akhir harus lebih besar dari tanggal awal");
            redirect(site_url('kabids/laporan/hasil_survei'));
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

    public function permohonan_pembuatan_sertifikat()
    {
        $data['title'] = "Laporan Permohonan Pembuatan Sertifikat";
        $data['header'] = $this->load->view('kabid/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kabid/template/sidebar',["page"=>"laporan_permohonan_pembuatan_sertifikat"], TRUE);
        $data['main'] = $this->load->view('kabid/laporan/permohonan_pembuatan_sertifikat',null,TRUE);
        $this->load->view('master',$data);
    }

    public function laporan_permohonan_pembuatan_sertifikat(){
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        if(strtotime($awal) > strtotime($akhir)){
            $this->session->set_flashdata('error', "Tanggal akhir harus lebih besar dari tanggal awal");
            redirect(site_url('kabids/laporan/permohonan_pembuatan_sertifikat'));
        }
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-permohonan-pembuatan-sertifikat.pdf";
        $this->pdf->load_view('laporan/permohonan_pembuatan_sertifikat', 
            [
                'awal' => $awal,
                'akhir' => $akhir,
                'permohonan_pembuatan_sertifikats' => $this->permohonan_sertifikat_model->getPermohonanPembuatanSertifikatLaporan($awal,$akhir),
                'k' => $this->kasi_model->getKasi()
            ]
        );
    }

    public function permohonan_perpanjangan_sertifikat()
    {
        $data['title'] = "Laporan Permohonan Pembuatan Sertifikat";
        $data['header'] = $this->load->view('kabid/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kabid/template/sidebar',["page"=>"laporan_permohonan_perpanjangan_sertifikat"], TRUE);
        $data['main'] = $this->load->view('kabid/laporan/permohonan_perpanjangan_sertifikat',null,TRUE);
        $this->load->view('master',$data);
    }

    public function laporan_permohonan_perpanjangan_sertifikat(){
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        if(strtotime($awal) > strtotime($akhir)){
            $this->session->set_flashdata('error', "Tanggal akhir harus lebih besar dari tanggal awal");
            redirect(site_url('kabids/laporan/permohonan_perpanjangan_sertifikat'));
        }
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-permohonan-perpanjangan-sertifikat.pdf";
        $this->pdf->load_view('laporan/permohonan_perpanjangan_sertifikat', 
            [
                'awal' => $awal,
                'akhir' => $akhir,
                'permohonan_perpanjangan_sertifikats' => $this->permohonan_sertifikat_model->getPermohonanPerpanjanganSertifikatLaporan($awal,$akhir),
                'k' => $this->kasi_model->getKasi()
            ]
        );
    }


    public function permohonan_izin_berlayar()
    {
        $data['title'] = "Laporan Permohonan Pembuatan Sertifikat";
        $data['header'] = $this->load->view('kabid/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kabid/template/sidebar',["page"=>"laporan_permohonan_izin_berlayar"], TRUE);
        $data['main'] = $this->load->view('kabid/laporan/permohonan_izin_berlayar',null,TRUE);
        $this->load->view('master',$data);
    }

    public function laporan_permohonan_izin_berlayar(){
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        if(strtotime($awal) > strtotime($akhir)){
            $this->session->set_flashdata('error', "Tanggal akhir harus lebih besar dari tanggal awal");
            redirect(site_url('kabids/laporan/permohonan_izin_berlayar'));
        }
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-permohonan-izin-berlayar.pdf";
        $this->pdf->load_view('laporan/permohonan_izin_berlayar', 
            [
                'awal' => $awal,
                'akhir' => $akhir,
                'permohonan_izin_berlayars' => $this->permohonan_izin_berlayar_model->getPermohonanIzinBerlayarLaporan($awal,$akhir),
                'k' => $this->kabid_model->getKabid()
            ]
        );
    }

    public function perbaikan_kapal()
    {
        $data['title'] = "Laporan Perbaikan Kapal";
        $data['header'] = $this->load->view('kabid/template/header',null, TRUE);
        $data['sidebar'] = $this->load->view('kabid/template/sidebar',["page"=>"laporan_perbaikan_kapal"], TRUE);
        $data['main'] = $this->load->view('kabid/laporan/perbaikan_kapal',null,TRUE);
        $this->load->view('master',$data);
    }

    public function laporan_perbaikan_kapal(){
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        if(strtotime($awal) > strtotime($akhir)){
            $this->session->set_flashdata('error', "Tanggal akhir harus lebih besar dari tanggal awal");
            redirect(site_url('kabids/laporan/perbaikan_kapal'));
        }
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = "laporan-perbaikan-kapal.pdf";
        $this->pdf->load_view('laporan/perbaikan_kapal', 
            [
                'awal' => $awal,
                'akhir' => $akhir,
                'perbaikans' => $this->hasil_perbaikan_model->getPerbaikansLaporan($awal,$akhir),
                'k' => $this->kabid_model->getKabid()
            ]
        );
    }
}
