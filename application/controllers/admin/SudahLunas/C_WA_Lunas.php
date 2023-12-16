<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_WA_Lunas extends CI_Controller
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

    public function KirimWA_Lunas($id_customer)
    {
        $bulan      = $this->session->userdata('bulan');
        $tahun      = $this->session->userdata('tahun');
        $bulanGET   = $this->session->userdata('bulanGET');
        $tahunGET   = $this->session->userdata('tahunGET');

        if ($bulanGET == '' && $tahunGET == '') {
            //memanggil mysql dari model 
            $data['DataPelanggan']  = $this->M_SudahLunas->Payment($id_customer, $bulan, $tahun);

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/SudahLunas/V_WA_Lunas', $data);
            $this->load->view('template/V_FooterSudahLunas', $data);
        } else {
            //memanggil mysql dari model 
            $data['DataPelanggan']  = $this->M_SudahLunas->Payment($id_customer, $bulanGET, $tahunGET);

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/SudahLunas/V_WA_Lunas', $data);
            $this->load->view('template/V_FooterSudahLunas', $data);
        }
    }

    public function KirimWAAksi()
    {
        //mengambil data post pada view 
        $code_client            = $this->input->post('code_client');
        $nama_paket             = $this->input->post('nama_paket');
        $harga_paket            = $this->input->post('harga_paket');
        $biaya_admin            = $this->input->post('biaya_admin');
        $name                   = $this->input->post('name');
        $phone                  = $this->input->post('phone');
        $bulan_tansaksi         = $this->input->post('bulan_transaksi');

        $code_client_uppercase = strtoupper($code_client);

        // convert to rupiah
        $harga_paket_c          = number_format($harga_paket, 0, ',', '.');
        $biaya_admin_c          = number_format($biaya_admin, 0, ',', '.');
        $total                  = number_format($harga_paket + $biaya_admin, 0, ',', '.');

        $convertPhone = preg_replace('/^\+?08/', '628', $phone);

        header("location:https://api.whatsapp.com/send?phone=$convertPhone&text=*INFLY NETWORKS* %0a%0a Yth Bapak / Ibu %0a Nama : $name %0a Kode Pelanggan : $code_client_uppercase %0a Telepon : $phone %0a%0a *PEMBAYARAN* %0a Tagihan Bulan : $bulan_tansaksi %0a Jenis Paket : $nama_paket %0a Harga Paket : Rp.$harga_paket_c %0a Biaya Admin : Rp.$biaya_admin_c %0a Total : Rp.$total (Sudah Termasuk PPN) %0a Keterangan : *Lunas* %0a%0a *Informasi Tambahan* %0a Simpan struk ini sebagai bukti telah melakukan pembayaran. %0a%0a Jika ada pertanyaan lebih lanjut, anda dapat langsung membalas pesan ini. %0a%0a Terima Kasih. %0a Hormat Kami. %0a%0a *INFLY NETWORKS*
            ");

        echo "
        <script>
            window.location=history.go(-1);
        </script>
        ";
    }
}
