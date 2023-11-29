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
                $inputFileName      = 'assets/uploads/imports/' . $upload_status;
                $inputTileType      = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                $reader             = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputTileType);
                $spreadsheet        = $reader->load($inputFileName);
                $sheetData          = $spreadsheet->getActiveSheet()->toArray();
            }

            for ($i = 5; $i < count($sheetData); $i++) {
                $code_client        = $sheetData[$i]['1'];
                $name               = $sheetData[$i]['2'];
                $phone              = $sheetData[$i]['3'];
                $nama_paket         = $sheetData[$i]['4'];
                $name_pppoe         = $sheetData[$i]['6'];
                $password_pppoe     = $sheetData[$i]['7'];
                $address            = $sheetData[$i]['8'];
                $email              = $sheetData[$i]['9'];
                $start_date         = $sheetData[$i]['10'];
                $nama_area          = $sheetData[$i]['11'];
                $nama_sales         = $sheetData[$i]['12'];
                $id_paket           = $sheetData[$i]['13'];
                $id_area            = $sheetData[$i]['14'];
                $id_sales           = $sheetData[$i]['15'];

                // Menyimpan data dalam array
                $data_customer = array(
                    'code_client'       => $code_client,
                    'phone'             => $phone,
                    'name'              => $name,
                    'id_paket'          => $id_paket,
                    'name_pppoe'        => $name_pppoe,
                    'password_pppoe'    => $password_pppoe,
                    'address'           => $address,
                    'email'             => $email,
                    'start_date'        => $start_date,
                    'id_area'           => $id_area,
                    'id_sales'          => $id_sales,
                );

                // Kondisi insert / update
                $conditionData = $this->db->get_where('client', array('name_pppoe' => $name_pppoe))->result_array();

                // Get data data_customer
                $getData = $this->db->query("SELECT id, code_client, phone, latitude, longitude, name, id_paket, name_pppoe, password_pppoe, id_pppoe, address, email, start_date, stop_date, id_area, description, id_sales, disabled, keterangan, created_at, updated_at FROM client")->result_array();

                // Condition update
                if (count($conditionData) != 0) {
                    foreach ($getData as $data) {
                        if ($data['name_pppoe'] == $sheetData[$i]['6']) {

                            $updateData = array(
                                'code_client' => $sheetData[$i]['1'],
                                'phone' => $sheetData[$i]['3'],
                                // Add more fields to update as needed
                            );

                            $this->db->where('id_pppoe', $data['id_pppoe']);
                            $this->db->update("client", $updateData);

                            echo "
                                <script>history.go(-1);</script>
                            ";
                        }
                    }
                }

                // Condition insert
                if (count($conditionData) == 0) {
                    $insertData = array(
                        'code_client'       => $code_client,
                        'phone'             => $phone,
                        'name'              => $name,
                        'id_paket'          => $id_paket,
                        'name_pppoe'        => $name_pppoe,
                        'password_pppoe'    => $password_pppoe,
                        'address'           => $address,
                        'email'             => $email,
                        'start_date'        => $start_date,
                        'id_area'           => $id_area,
                        'id_sales'          => $id_sales,
                        // Add more fields to insert as needed
                    );

                    if ($nama_paket == 'Free 20 Mbps') {
                        $profile_paket = 'HOME 20 B';
                    } elseif ($nama_paket == 'Free Up Home 50') {
                        $profile_paket = 'HOME 50 B';
                    } else {
                        $profile_paket = strtoupper($nama_paket) . " B";
                    }

                    // Tambah Pelanggan Ke Mikrotik
                    $api = connect();
                    $api->comm('/ppp/secret/add', [
                        "name"     => $name_pppoe,
                        "password" => $password_pppoe,
                        "service"  => "pppoe",
                        "profile"  => $profile_paket,
                        "comment"  => "",
                    ]);
                    $api->disconnect();

                    $this->db->insert('client', $insertData);

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
            $this->db->insert('data_excel', $data);


            $insert_id = $this->db->insert_id();
            $_SESSION['lastid'] = $insert_id;

            return $fileData['file_name'];
        } else {
            return false;
        }
    }
}
