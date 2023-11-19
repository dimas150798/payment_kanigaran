<?php

defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

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
        $data['DataExcel']      = $this->M_ImportExcel->DataExcel();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataPelanggan/V_ImportExcel', $data);
        $this->load->view('template/V_FooterImportExcel', $data);
    }

    public function  ImportExcel()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $upload_status = $this->uploadDoc();
            if ($upload_status != false) {
                $inputFileName = 'assets/uploads/imports/' . $upload_status;
                $inputTileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputTileType);
                $spreadsheet = $reader->load($inputFileName);
                $sheet = $spreadsheet->getSheet(0);
                $count_Rows = 0;

                $counter = 0;
                foreach ($sheet->getRowIterator(6) as $row) {
                    if (++$counter == 6) continue;
                    $Kode_Customer      = $spreadsheet->getActiveSheet()->getCell('B' . $row->getRowIndex());
                    $Phone_Customer     = $spreadsheet->getActiveSheet()->getCell('C' . $row->getRowIndex());
                    $Nama_Customer      = $spreadsheet->getActiveSheet()->getCell('D' . $row->getRowIndex());
                    $Nama_Paket         = $spreadsheet->getActiveSheet()->getCell('E' . $row->getRowIndex());
                    $Name_PPPOE         = $spreadsheet->getActiveSheet()->getCell('F' . $row->getRowIndex());
                    $Password_PPPOE     = $spreadsheet->getActiveSheet()->getCell('G' . $row->getRowIndex());
                    $Alamat_Customer    = $spreadsheet->getActiveSheet()->getCell('H' . $row->getRowIndex());
                    $Email_Customer     = $spreadsheet->getActiveSheet()->getCell('I' . $row->getRowIndex());
                    $Tanggal_Registrasi = $spreadsheet->getActiveSheet()->getCell('J' . $row->getRowIndex())->getFormattedValue();
                    $Tanggal_Terminated = $spreadsheet->getActiveSheet()->getCell('K' . $row->getRowIndex())->getFormattedValue();
                    $Nama_Area          = $spreadsheet->getActiveSheet()->getCell('L' . $row->getRowIndex());
                    $Nama_Sales         = $spreadsheet->getActiveSheet()->getCell('M' . $row->getRowIndex());

                    $this->session->set_userdata('name_pppoe', $Name_PPPOE);

                    $CheckDuplicate     = $this->M_Pelanggan->CheckDuplicatePelanggan($Name_PPPOE);

                    // Convert Date
                    $spreadsheet->getActiveSheet()->getStyle('K' . $row->getRowIndex())
                        ->getNumberFormat()
                        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);

                    $spreadsheet->getActiveSheet()->getStyle('L' . $row->getRowIndex())
                        ->getNumberFormat()
                        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);

                    if ($CheckDuplicate->name_pppoe == $Name_PPPOE) {
                        // Notifikasi Gagal Import
                        $this->session->set_flashdata('ExcelGagal_icon', 'danger');
                        $this->session->set_flashdata('ExcelGagal_title', 'Terdapat Data Nama Yang Sama');

                        redirect('admin/DataPelanggan/C_ImportExcel');
                    } else {
                        if ($Tanggal_Terminated == NULL) {
                            $data = array(
                                'kode_customer'     => $Kode_Customer,
                                'phone_customer'    => $Phone_Customer,
                                'nama_customer'     => $Nama_Customer,
                                'nama_paket'        => $Nama_Paket,
                                'name_pppoe'        => $Name_PPPOE,
                                'password_pppoe'    => $Password_PPPOE,
                                'alamat_customer'   => $Alamat_Customer,
                                'email_customer'    => $Email_Customer,
                                'start_date'        => $Tanggal_Registrasi,
                                'nama_area'         => $Nama_Area,
                                'nama_sales'        => $Nama_Sales
                            );
                        } else {
                            $data = array(
                                'kode_customer'     => $Kode_Customer,
                                'phone_customer'    => $Phone_Customer,
                                'nama_customer'     => $Nama_Customer,
                                'nama_paket'        => $Nama_Paket,
                                'name_pppoe'        => $Name_PPPOE,
                                'password_pppoe'    => $Password_PPPOE,
                                'alamat_customer'   => $Alamat_Customer,
                                'email_customer'    => $Email_Customer,
                                'start_date'        => $Tanggal_Registrasi,
                                'stop_date'         => $Tanggal_Terminated,
                                'nama_area'         => $Nama_Area,
                                'nama_sales'        => $Nama_Sales
                            );
                        }
                        $this->db->insert('data_customer', $data);
                        $count_Rows++;

                        // Notifikasi Insert Data Berhasil
                        $this->session->set_flashdata('ExcelSuccess_icon', 'success');
                        $this->session->set_flashdata('ExcelSuccess_title', 'Insert Data Berhasil');

                        redirect('admin/DataPelanggan/C_DataPelanggan');
                    }
                }
            } else {
                // Notifikasi Insert Data Gagal
                $this->session->set_flashdata('ExcelGagal_icon', 'warning');
                $this->session->set_flashdata('ExcelGagal_title', 'Insert Data Gagal');

                redirect('admin/DataPelanggan/C_ImportExcel');
            }
        } else {
            // Notifikasi Insert Data Gagal
            $this->session->set_flashdata('ExcelGagal_icon', 'warning');
            $this->session->set_flashdata('ExcelGagal_title', 'Insert Data Gagal');

            redirect('admin/DataPelanggan/C_DataPelanggan');
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
            $this->db->insert('data_excel', $data);
            $insert_id = $this->db->insert_id();
            $_SESSION['lastid'] = $insert_id;

            return $fileData['file_name'];
        } else {
            return false;
        }
    }
}
