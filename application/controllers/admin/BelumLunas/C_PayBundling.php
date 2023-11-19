<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_PayBundling extends CI_Controller
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

    public function Payment($id_customer)
    {

        $CheckPelanggan = $this->M_Pelanggan->CheckIDPelanggan($id_customer);

        if ($this->session->userdata('tahunGET') != NULL && $this->session->userdata('bulanGET') != NULL) {

            date_default_timezone_set("Asia/Jakarta");
            $data['Tanggal'] = $this->session->userdata('tahunGET') . '-' . $this->session->userdata('bulanGET') . '-' . $CheckPelanggan->JatuhTempo . ' ' . date("H:i:s");

            $data['DataPelanggan']  = $this->M_BelumLunas->Payment($id_customer);

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/BelumLunas/V_PayBundling', $data);
            $this->load->view('template/V_FooterBelumLunas', $data);
        } else {
            // Menggabungkan tanggal, bulan, tahun
            date_default_timezone_set("Asia/Jakarta");
            $datetime = new DateTime($transaction_time);

            $Tahun = $datetime->format("Y"); // Untuk tahun (format Y untuk tahun empat digit)
            $Bulan = $datetime->format("m"); // Untuk bulan (format m untuk bulan dua digit)
            $Tanggal = $datetime->format("d"); // Untuk tanggal (format d untuk tanggal dua digit)

            $data['Tanggal'] = $Tahun . '-' . $Bulan . '-' . $CheckPelanggan->JatuhTempo . ' ' . date("H:i:s");

            $data['DataPelanggan']  = $this->M_BelumLunas->Payment($id_customer);

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/BelumLunas/V_PayBundling', $data);
            $this->load->view('template/V_FooterBelumLunas', $data);
        }
    }

    public function PaymentSave()
    {
        date_default_timezone_set("Asia/Jakarta");

        // Mengambil data post pada view
        $id_pppoe               = $this->input->post('id_pppoe');
        $id                     = $this->input->post('id');
        $nama_paket             = $this->input->post('nama_paket');
        $gross_amount           = $this->input->post('gross_amount');
        $order_id               = $this->input->post('order_id');
        $name_pppoe             = $this->input->post('name_pppoe');
        $paket_bundling         = $this->input->post('paket_bundling');
        $biaya_admin            = $this->input->post('biaya_admin');
        $transaction_time       = $this->input->post('transaction_time');
        $nama_admin             = $this->input->post('nama_admin');
        $keterangan             = $this->input->post('keterangan');

        // Jumlah bulan yang ingin Anda tambahkan
        $jumlahBulan5 = 5; // Setiap 5 bulan
        $jumlahBulan12 = 12; // Setiap 12 bulan

        // Memanggil mysql dari model
        $data['DataPelanggan']  = $this->M_BelumLunas->Payment($id);

        // Check duplicate code
        $checkDuplicateCode = $this->M_Pelanggan->CheckDuplicateCode($order_id);

        // Rules form validation
        $this->form_validation->set_rules('biaya_admin', 'Biaya Admin', 'required');
        $this->form_validation->set_rules('transaction_time', 'Tanggal Transaksi', 'required');
        $this->form_validation->set_rules('nama_admin', 'Nama Admin', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/BelumLunas/V_PayBundling', $data);
            $this->load->view('template/V_FooterBelumLunas', $data);
        } else {
            if ($paket_bundling == 'Bundling_5') {
                // Inisialisasi tanggal awal
                $tanggalObjek = new DateTime($transaction_time);

                // Inisialisasi array untuk menyimpan data pembayaran
                $dataPayments = [];

                // Loop untuk menginput data setiap 5 bulan
                for ($i = 0; $i < 5; $i++) {
                    // Mengambil tanggal hasil dalam format yang Anda inginkan
                    $tanggalHasil = $tanggalObjek->format('Y-m-d H:i:s');

                    $CheckJumlahSudahLunas = $this->M_SudahLunas->CheckJumlahSudahLunas($Bulan, $Tahun, $name_pppoe);

                    // Mendapatkan order_id baru yang unik
                    $order_id = $this->M_BelumLunas->invoice();

                    // Menyimpan data payment ke dalam array
                    $dataPayment = array(
                        'order_id'          => $order_id,
                        'gross_amount'      => $gross_amount,
                        'biaya_admin'       => $biaya_admin,
                        'nama'              => $name_pppoe,
                        'paket'             => $nama_paket,
                        'nama_admin'        => $nama_admin,
                        'keterangan'        => $keterangan,
                        'transaction_time'  => $tanggalHasil,
                        'expired_date'      => $tanggalHasil, // Menggunakan tanggal hasil dari loop
                        'status_code'       => 200,
                        'created_at'        => date('Y-m-d H:i:s', time())
                    );

                    // Data duplicate dengan order_id baru yang berbeda
                    $dataPaymentDuplicate = array(
                        'order_id'          => $order_id,
                        'gross_amount'      => $gross_amount,
                        'biaya_admin'       => $biaya_admin,
                        'nama'              => $name_pppoe,
                        'paket'             => $nama_paket,
                        'nama_admin'        => $nama_admin,
                        'keterangan'        => $keterangan,
                        'transaction_time'  => $tanggalHasil,
                        'expired_date'      => $tanggalHasil, // Menggunakan tanggal hasil dari loop
                        'status_code'       => 200,
                        'created_at'        => date('Y-m-d H:i:s', time())
                    );

                    // Tambahkan data pembayaran ke dalam array
                    $dataPayments[] = $dataPayment;
                    $dataPayments[] = $dataPaymentDuplicate;

                    // Tambahkan 1 bulan ke tanggal awal
                    $tanggalObjek->modify('+1 month');
                }

                // Setelah loop selesai, insert semua data pembayaran ke database
                $this->M_CRUD->insertBatchData($dataPayments, 'data_pembayaran');
                $this->M_CRUD->insertBatchData($dataPayments, 'data_pembayaran_history');

                $this->session->set_flashdata('payment_icon', 'success');
                $this->session->set_flashdata('payment_title', 'Pembayaran An. <b>' . $name_pppoe . '</b> Berhasil');

                redirect('admin/BelumLunas/C_BelumLunas');
            } else {
                echo "Fitur Belum Ada";
            }
        }
    }
}
