<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_KwitansiLunas extends CI_Controller
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

    public function Kwitansi($id_customer)
    {
        $bulan      = $this->session->userdata('bulan');
        $tahun      = $this->session->userdata('tahun');
        $bulanGET   = $this->session->userdata('bulanGET');
        $tahunGET   = $this->session->userdata('tahunGET');


        if ($bulanGET == '' && $tahunGET == '') {
            //memanggil mysql dari model 
            $data['DataPelanggan']  = $this->M_SudahLunas->Kwitansi($id_customer, $bulan, $tahun);

            $this->load->view('template/V_HeaderKwitansi', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/SudahLunas/V_KwitansiLunas', $data);
            $this->load->view('template/V_FooterSudahLunas', $data);
        } else {
            //memanggil mysql dari model 
            $data['DataPelanggan']  = $this->M_SudahLunas->Kwitansi($id_customer, $bulanGET, $tahunGET);

            $this->load->view('template/V_HeaderKwitansi', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/SudahLunas/V_KwitansiLunas', $data);
            $this->load->view('template/V_FooterSudahLunas', $data);
        }
    }

    public function KirimWAAksi()
    {
        //mengambil data post pada view 
        $id_customer            = $this->input->post('id_customer');
        $nama_paket             = $this->input->post('nama_paket');
        $harga_paket            = $this->input->post('harga_paket');
        $nama_customer          = $this->input->post('nama_customer');
        $phone_customer         = $this->input->post('phone_customer');
        $tanggal_penagihan      = $this->input->post('tanggal_penagihan');
        $bulan_penagihan        = $this->input->post('bulan_penagihan');
        $tahun_penagihan        = $this->input->post('tahun_penagihan');

        $convertPhone = preg_replace('/^\+?08/', '628', $phone_customer);

        header("location:https://api.whatsapp.com/send?phone=$convertPhone&text=*INFLY NETWORKS* %0a%0a Yth Bapak / Ibu %0a Nama : $nama_customer %0a Telepon : $phone_customer %0a%0a *PEMBAYARAN* %0a Tagihan Bulan : $bulan_penagihan %0a Jenis Paket : $nama_paket %0a Harga Paket : $harga_paket %0a Total : $harga_paket (Sudah Termasuk PPN) %0a Keterangan : *Lunas* %0a%0a *Informasi Tambahan* %0a Simpan struk ini sebagai bukti telah melakukan pembayaran. %0a%0a Jika ada pertanyaan lebih lanjut, anda dapat langsung membalas pesan ini. %0a%0a Terima Kasih. %0a Hormat Kami. %0a%0a *INFLY NETWORKS*
            ");

        echo "
        <script>
            window.location=history.go(-1);
        </script>
        ";
    }
}
