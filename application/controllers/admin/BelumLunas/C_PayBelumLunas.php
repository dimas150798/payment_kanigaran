<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_PayBelumLunas extends CI_Controller
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
            $this->load->view('admin/BelumLunas/V_PayBelumLunas', $data);
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
            $this->load->view('admin/BelumLunas/V_PayBelumLunas', $data);
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
        $biaya_admin            = $this->input->post('biaya_admin');
        $transaction_time       = $this->input->post('transaction_time');
        $nama_admin             = $this->input->post('nama_admin');
        $keterangan             = $this->input->post('keterangan');

        $datetime = new DateTime($transaction_time);

        $Tahun = $datetime->format("Y"); // Untuk tahun (format Y untuk tahun empat digit)
        $Bulan = $datetime->format("m"); // Untuk bulan (format m untuk bulan dua digit)
        $Tanggal = $datetime->format("d"); // Untuk tanggal (format d untuk tanggal dua digit)

        $CheckJumlahSudahLunas = $this->M_SudahLunas->CheckJumlahSudahLunas($Bulan, $Tahun, $name_pppoe);

        // Menyimpan data payment ke dalam array
        $dataPayment = array(
            'order_id'          => $order_id,
            'gross_amount'      => $gross_amount,
            'biaya_admin'       => $biaya_admin,
            'nama'              => $name_pppoe,
            'paket'             => $nama_paket,
            'nama_admin'        => $nama_admin,
            'keterangan'        => $keterangan,
            'transaction_time'  => $transaction_time,
            'expired_date'      => $transaction_time,
            'status_code'       => 200,
            'created_at'        => date('Y-m-d H:i:s', time())
        );

        $dataPaymentDuplicate = array(
            'order_id'          => $this->M_BelumLunas->invoice(),
            'gross_amount'      => $gross_amount,
            'biaya_admin'       => $biaya_admin,
            'nama'              => $name_pppoe,
            'paket'             => $nama_paket,
            'nama_admin'        => $nama_admin,
            'keterangan'        => $keterangan,
            'transaction_time'  => $transaction_time,
            'expired_date'      => $transaction_time,
            'status_code'       => 200,
            'created_at'        => date('Y-m-d H:i:s', time())
        );

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
            $this->load->view('admin/BelumLunas/V_PayBelumLunas', $data);
            $this->load->view('template/V_FooterBelumLunas', $data);
        } else {
            if ($CheckJumlahSudahLunas == 0) {
                if ($order_id != $checkDuplicateCode->order_id) {
                    $api = connect();
                    $api->comm('/ppp/secret/set', [
                        ".id" => $id_pppoe,
                        "disabled" => 'false',
                    ]);
                    $api->disconnect();

                    $this->M_CRUD->insertData($dataPayment, 'data_pembayaran');
                    $this->M_CRUD->insertData($dataPayment, 'data_pembayaran_history');

                    $this->session->set_flashdata('payment_icon', 'success');
                    $this->session->set_flashdata('payment_title', 'Pembayaran An. <b>' . $name_pppoe . '</b> Berhasil');

                    redirect('admin/BelumLunas/C_BelumLunas');
                } else {
                    $api = connect();
                    $api->comm('/ppp/secret/set', [
                        ".id" => $id_pppoe,
                        "disabled" => 'false',
                    ]);
                    $api->disconnect();

                    $this->M_CRUD->insertData($dataPaymentDuplicate, 'data_pembayaran');
                    $this->M_CRUD->insertData($dataPaymentDuplicate, 'data_pembayaran_history');

                    $this->session->set_flashdata('payment_icon', 'success');
                    $this->session->set_flashdata('payment_title', 'Pembayaran An. <b>' . $name_pppoe . '</b> Berhasil');

                    redirect('admin/BelumLunas/C_BelumLunas');
                }
            } else {
                // Notifikasi duplicate payment
                $this->session->set_flashdata('DuplicatePay_icon', 'error');
                $this->session->set_flashdata('DuplicatePay_title', 'Payment Gagal');
                $this->session->set_flashdata('DuplicatePay_text', 'Customer sudah melakukan <br> Pembayaran bulan yang di pilih');

                redirect($_SERVER['HTTP_REFERER']); // Mengarahkan pengguna kembali ke halaman sebelumnya
            }
        }
    }
}
