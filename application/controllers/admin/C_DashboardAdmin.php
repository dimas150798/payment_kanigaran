<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_DashboardAdmin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('email') == null) {

            // Notifikasi Login Terlebih Dahulu
            $this->session->set_flashdata('BelumLogin_icon', 'error');
            $this->session->set_flashdata('BelumLogin_title', 'Login Terlebih Dahulu');

            redirect('C_FormLogin');
        }
    }

    public function index()
    {
        date_default_timezone_set("Asia/Jakarta");
        $toDay = date('Y-m-d');

        // Memisahkan Tanggal
        $pecahDay       = explode("-", $toDay);

        $tahun          = $pecahDay[0];
        $bulan          = $pecahDay[1];
        $tanggal        = $pecahDay[2];

        $checkKoneksi                   = $this->MikrotikModel->jumlahMikrotikAktif();
        $data['JumlahPelanggan']        = $this->M_Pelanggan->JumlahPelangganAktif();
        $data['JumlahPelangganBaru']    = $this->M_Pelanggan->JumlahPelangganBaru($bulan, $tahun);
        $data['JumlahSudahLunas']       = $this->M_SudahLunas->JumlahSudahLunas($bulan, $tahun, $toDay);
        $data['JumlahJatuhTempo']       = $this->M_JatuhTempo->JumlahJatuhTempo($toDay);

        // Memanggil data Mikrotik
        $this->MikrotikModel->index();

        if ($checkKoneksi == 0) {
            // Notifikasi gagal login
            $this->session->set_flashdata('CheckMikrotik_icon', 'error');
            $this->session->set_flashdata('CheckMikrotik_title', 'Koneksi Gagal');
            $this->session->set_flashdata('CheckMikrotik_text', 'Check Kembali Lagi Koneksi <br> Mikrotik Anda');

            $this->load->view('template/headerLogin', $data);
            $this->load->view('V_FormLogin', $data);
            $this->load->view('template/footerLogin', $data);

            // redirect('admin/DataPaket/C_DataPaket');
        } elseif ($checkKoneksi == 1) {

            // Notifikasi Login Berhasil
            $this->session->set_flashdata('LoginBerhasil_icon', 'success');
            $this->session->set_flashdata('LoginBerhasil_title', 'Selamat Datang <br>' . $this->session->userdata('email'));

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/V_DashboardAdmin', $data);
            $this->load->view('template/footer', $data);
        }
    }
}
