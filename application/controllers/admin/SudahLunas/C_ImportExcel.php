<?php

defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

use PhpOffice\PhpSpreadsheet\IOFactory;

class C_ImportExcel extends CI_Controller
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
        // Memanggil mysql dari model
        $data['DataPaket']      = $this->M_Paket->DataPaket();
        $data['DataArea']       = $this->M_Area->DataArea();
        $data['DataSales']      = $this->M_Sales->DataSales();
        $data['DataExcel']      = $this->M_ImportExcel->DataExcelPembayaran();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/SudahLunas/V_ImportExcel', $data);
        $this->load->view('template/V_FooterImportExcel', $data);
    }

    public function  ImportExcel()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $upload_status = $this->uploadDoc();
            if ($upload_status != false) {
                $inputFileName      = 'assets/uploads/imports/' . $upload_status;
                $inputTileType      = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                $reader             = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputTileType);
                $spreadsheet        = $reader->load($inputFileName);
                $sheetData          = $spreadsheet->getActiveSheet()->toArray();
            }

            for ($i = 5; $i < count($sheetData); $i++) {
                $order_id           = $sheetData[$i]['1'];
                $gross_amount       = $sheetData[$i]['2'];
                $biaya_admin        = $sheetData[$i]['3'];
                $biaya_instalasi    = $sheetData[$i]['4'];
                $nama               = $sheetData[$i]['5'];
                $paket              = $sheetData[$i]['6'];
                $nama_admin         = $sheetData[$i]['7'];
                $keterangan         = $sheetData[$i]['8'];
                $payment_type       = $sheetData[$i]['9'];
                $transaction_time   = $sheetData[$i]['10'];
                $expired_date       = $sheetData[$i]['11'];
                $bank               = $sheetData[$i]['12'];
                $va_number          = $sheetData[$i]['13'];
                $pertama_va_number  = $sheetData[$i]['14'];
                $payment_code       = $sheetData[$i]['15'];
                $bill_key           = $sheetData[$i]['16'];
                $biller_code        = $sheetData[$i]['17'];
                $pdf_url            = $sheetData[$i]['18'];
                $status_code        = $sheetData[$i]['19'];
                $created_at         = $sheetData[$i]['20'];

                // Menyimpan data dalam array
                $data_pembayaran = array(
                    'order_id'          => $order_id,
                    'gross_amount'      => $gross_amount,
                    'biaya_admin'       => $biaya_admin,
                    'biaya_instalasi'   => $biaya_instalasi,
                    'nama'              => $nama,
                    'paket'             => $paket,
                    'nama_admin'        => $nama_admin,
                    'keterangan'        => $keterangan,
                    'payment_type'      => $payment_type,
                    'transaction_time'  => $transaction_time,
                    'expired_date'      => $expired_date,
                    'bank'              => $bank,
                    'va_number'         => $va_number,
                    'permata_va_number' => $pertama_va_number,
                    'payment_code'      => $payment_code,
                    'bill_key'          => $bill_key,
                    'biller_code'       => $biller_code,
                    'pdf_url'           => $pdf_url,
                    'status_code'       => $status_code,
                    'created_at'        => $created_at,
                );

                // Kondisi insert / update
                $conditionData = $this->db->get_where('data_pembayaran', array('order_id' => $order_id))->result_array();

                // Get data data_pembayaran
                $getData = $this->db->query("SELECT order_id, gross_amount, biaya_admin, biaya_instalasi, nama, paket, nama_admin, keterangan, payment_type, transaction_time, expired_date, bank, va_number, permata_va_number, payment_code, bill_key, biller_code, pdf_url, status_code, created_at FROM data_pembayaran")->result_array();

                // Condition update
                if (count($conditionData) != 0) {
                    foreach ($getData as $data) {
                        if ($data['order_id'] == $sheetData[$i]['1']) {

                            $updateDataPembayaran = array(
                                'gross_amount'      => $sheetData[$i]['2'],
                                'biaya_admin'       => $sheetData[$i]['3'],
                                'biaya_instalasi'   => $sheetData[$i]['4'],
                                'nama'               => $sheetData[$i]['5'],
                                'paket'              => $sheetData[$i]['6'],
                                'nama_admin'         => $sheetData[$i]['7'],
                                'keterangan'         => $sheetData[$i]['8'],
                                'payment_type'       => $sheetData[$i]['9'],
                                'transaction_time'   => $sheetData[$i]['10'],
                                'expired_date'       => $sheetData[$i]['11'],
                                'bank'               => $sheetData[$i]['12'],
                                'va_number'          => $sheetData[$i]['13'],
                                'pertama_va_number'  => $sheetData[$i]['14'],
                                'payment_code'       => $sheetData[$i]['15'],
                                'bill_key'           => $sheetData[$i]['16'],
                                'biller_code'        => $sheetData[$i]['17'],
                                'pdf_url'            => $sheetData[$i]['18'],
                                'status_code'        => $sheetData[$i]['19'],
                                'created_at'         => $sheetData[$i]['20'],
                            );

                            $updateDataPembayaran_History = array(
                                'gross_amount'      => $sheetData[$i]['2'],
                                'biaya_admin'       => $sheetData[$i]['3'],
                                'biaya_instalasi'   => $sheetData[$i]['4'],
                                'nama'               => $sheetData[$i]['5'],
                                'paket'              => $sheetData[$i]['6'],
                                'nama_admin'         => $sheetData[$i]['7'],
                                'keterangan'         => $sheetData[$i]['8'],
                                'payment_type'       => $sheetData[$i]['9'],
                                'transaction_time'   => $sheetData[$i]['10'],
                                'expired_date'       => $sheetData[$i]['11'],
                                'bank'               => $sheetData[$i]['12'],
                                'va_number'          => $sheetData[$i]['13'],
                                'pertama_va_number'  => $sheetData[$i]['14'],
                                'payment_code'       => $sheetData[$i]['15'],
                                'bill_key'           => $sheetData[$i]['16'],
                                'biller_code'        => $sheetData[$i]['17'],
                                'pdf_url'            => $sheetData[$i]['18'],
                                'status_code'        => $sheetData[$i]['19'],
                                'created_at'         => $sheetData[$i]['20'],
                            );

                            $this->db->where('order_id', $data['order_id']);
                            $this->db->update("data_pembayaran", $updateDataPembayaran);

                            echo "
                                <script>history.go(-1);</script>
                            ";
                        }
                    }
                }

                // Condition insert
                if (count($conditionData) == 0) {
                    $insertData = array(
                        'order_id'          => $order_id,
                        'gross_amount'      => $gross_amount,
                        'biaya_admin'       => $biaya_admin,
                        'biaya_instalasi'   => $biaya_instalasi,
                        'nama'              => $nama,
                        'paket'             => $paket,
                        'nama_admin'        => $nama_admin,
                        'keterangan'        => $keterangan,
                        'payment_type'      => $payment_type,
                        'transaction_time'  => $transaction_time,
                        'expired_date'      => $expired_date,
                        'bank'              => $bank,
                        'va_number'         => $va_number,
                        'permata_va_number' => $pertama_va_number,
                        'payment_code'      => $payment_code,
                        'bill_key'          => $bill_key,
                        'biller_code'       => $biller_code,
                        'pdf_url'           => $pdf_url,
                        'status_code'       => $status_code,
                        'created_at'        => $created_at,
                    );


                    $this->db->insert('data_pembayaran', $insertData);
                    $this->db->insert('data_pembayaran_history', $insertData);

                    echo "
                        <script>history.go(-1);</script>
                    ";
                }
            }
        }
    }

    function uploadDoc()
    {
        $uploadPath = 'assets/uploads/imports/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE);
        }

        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = 'csv|xlsx|xls';
        $config['max_size'] = 1000000;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);


        if ($this->upload->do_upload('upload_excel')) {

            $fileData = $this->upload->data();
            $data['file_name'] = $fileData['file_name'];
            $data['keterangan'] = 'Pembayaran';
            $this->db->insert('data_excel', $data);
            $insert_id = $this->db->insert_id();
            $_SESSION['lastid'] = $insert_id;

            return $fileData['file_name'];
        } else {
            return false;
        }
    }
}
