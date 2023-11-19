<?php

ini_set('display_errors', 1);
error_reporting(E_ALL && ~E_NOTICE);

class MikrotikModel extends CI_Model
{
    public function index()
    {
        $response = [];

        $api = connect();
        $pppSecret = $api->comm('/ppp/secret/print');
        $api->disconnect();

        $paket = array(
            'HOME 5 A' => 1, 'HOME 5 B' => 1, 'HOME 10 A' => 2, 'HOME 10 B' => 2,
            'HOME 20 A' => 3, 'HOME 20 B' => 3, 'HOME 20 C' => 3, 'HOME 30 A' => 5, 'HOME 30 B' => 5,
            'HOME 50 A' => 6, 'HOME 50 B' => 6, 'HOME 100 A' => 9, 'HOME 100 B' => 9,
            'HOME TV 25 A' => 11, 'HOME TV 25 A' => 11, 'HOME TV 25 B' => 11
        );

        $getData = $this->db->query("
            SELECT 
            client.*,
            area.name as area_name, 
            paket.id as id_paket, 
            paket.price as paket_price, 
            sales.name as sales_name

            FROM client
            left join area on area.id = client.id_area
            left join paket on paket.id = client.id_paket
            left join sales on sales.id = client.id_sales
            order by client.id desc
            ")->result_array();

        foreach ($pppSecret as $keySecret => $valueSecret) {
            $status = false;

            foreach ($getData as $key => $value) {
                if ($valueSecret['name'] == $value['name_pppoe']) {
                    $status = true;

                    $this->db->update("client", ['id_pppoe' => $valueSecret['.id']], ['id' => $value['id']]);
                    $this->db->update("client", ['disabled' => $valueSecret['disabled']], ['id' => $value['id']]);


                    $response[$keySecret] = [
                        'id'                => $value['id'],
                        'code_client'       => $value['code_client'],
                        'phone'             => $value['phone'],
                        'latitude'          => $value['latitude'],
                        'longitude'         => $value['longitude'],
                        'name'              => $valueSecret['name'],
                        'id_paket'          => $paket[(string)$valueSecret['profile']],
                        'name_pppoe'        => $valueSecret['name'],
                        'password_pppoe'    => $valueSecret['password'],
                        'id_pppoe'          => $valueSecret['.id'],
                        'address'           => $value['address'],
                        'email'             => $value['email'],
                        'start_date'        => $value['start_date'],
                        'stop_date'         => $value['stop_date'],
                        'id_area'           => $value['id_area'],
                        'description'       => $value['description'],
                        'id_sales'          => $value['id_sales'],
                        'created_at'        => $value['created_at'],
                        'updated_at'        => $value['updated_at']
                    ];
                }
            }
            if ($status == false) {
                $this->db->insert("client", [
                    "code_client"       => '0',
                    "phone"             => '0',
                    "latitude"          => '0',
                    "longitude"         => '0',
                    "name"              => $valueSecret['name'],
                    "id_paket"          => $paket[(string)$valueSecret['profile']],
                    'name_pppoe'        => $valueSecret['name'],
                    'password_pppoe'    => $valueSecret['password'],
                    'id_pppoe'          => $valueSecret['.id'],
                    'address'           => '0',
                    'email'             => '0',
                    "start_date"        => NULL,
                    "stop_date"         => NULL,
                    "id_area"           => 0,
                    "description"       => '0',
                    "id_sales"          => 0,
                    "created_at"        => date('Y-m-d H:i:s', time()),
                    "updated_at"        => date('Y-m-d H:i:s', time()),
                ]);

                $response[$keySecret] = [
                    'id'                => $this->db->insert_id(),
                    'code_client'       => '0',
                    'phone'             => '0',
                    'latitude'          => '0',
                    'longitude'         => '0',
                    'name'              => $valueSecret['name'],
                    'id_paket'          => $paket[(string)$valueSecret['profile']],
                    'name_pppoe'        => $valueSecret['name'],
                    'password_pppoe'    => $valueSecret['password'],
                    'id_pppoe'          => $valueSecret['.id'],
                    'address'           => '0',
                    'email'             => '0',
                    'start_date'        => NULL,
                    'stop_date'         => null,
                    'id_area'           => '0',
                    'description'       => '0',
                    'id_sales'          => '0',
                    'created_at'        => date('Y-m-d H:i:s', time()),
                    'updated_at'        => date('Y-m-d H:i:s', time()),
                ];
            }
        }

        return $response;
    }

    // Menampilkan Data Login
    public function DataMikrotik()
    {
        $query   = $this->db->query("SELECT id_mikrotik, ip_mikrotik, username_mikrotik, password_mikrotik, status_mikrotik
                FROM data_mikrotik
    
                ORDER BY id_mikrotik DESC");

        return $query->result_array();
    }

    // Edit Mikrotik
    public function EditMikrotik($id_mikrotik)
    {
        $query   = $this->db->query("SELECT id_mikrotik, ip_mikrotik, username_mikrotik, password_mikrotik, status_mikrotik
                FROM data_mikrotik
                WHERE id_mikrotik = '$id_mikrotik'
                ORDER BY ip_mikrotik ASC");

        return $query->result_array();
    }

    // Check data mikrotik
    public function jumlahMikrotik()
    {
        $this->db->select('ip_mikrotik, username_mikrotik, password_mikrotik');

        $this->db->limit(1);
        $result = $this->db->get('data_mikrotik');

        return $result->num_rows();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    // Check data mikrotik
    public function jumlahMikrotikAktif()
    {
        $this->db->select('ip_mikrotik, username_mikrotik, password_mikrotik');
        $this->db->where('status_mikrotik', 'enable');
        $this->db->limit(1);
        $result = $this->db->get('data_mikrotik');

        return $result->num_rows();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    // Check status mikrotik
    public function CheckStatusMikrotik()
    {
        $this->db->select('ip_mikrotik, username_mikrotik, password_mikrotik', 'status_mikrotik');
        $this->db->where('status_mikrotik', 'enable');

        $this->db->limit(1);
        $result = $this->db->get('data_mikrotik');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    public function TerminasiAuto($bulan, $tahun, $tanggalAkhir, $tanggal)
    {
        // Terminasi Bulan 2 (Februari)
        if ($bulan == 2 && $tanggal == 28) {
            $getData = $this->db->query("SELECT client.id, client.code_client, client.phone, client.name, client.id_paket, 
            client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, 
            DAY(client.start_date) as tanggal, client.stop_date, client.id_area, client.description, client.id_sales,
            data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, data_pembayaran.nama, data_pembayaran.paket, 
            data_pembayaran.nama_admin, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
            data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
            data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, paket.name as namaPaket, paket.price as harga_paket
    
            FROM client
            LEFT JOIN paket ON client.id_paket = paket.id
            LEFT JOIN data_pembayaran ON client.name_pppoe = data_pembayaran.nama
            AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'
    
            WHERE client.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
            data_pembayaran.transaction_time IS NULL AND client.stop_date IS NULL
            AND paket.name != 'Free 20 Mbps' AND DAY(client.start_date) >= '$tanggal' AND
            client.disabled = 'false'
    
            GROUP BY client.name_pppoe
            ORDER BY DAY(client.start_date) ASC
            ")->result_array();

            foreach ($getData as $data) {
                date_default_timezone_set("Asia/Jakarta");
                $timeNow = date('H:i:s');
                $timeOut = date('18:55:00');

                if ($data['transaction_time'] == null && $data['status_code'] == null) {
                    if ($timeNow > $timeOut) {

                        // disable secret dan active otomatis 
                        $api = connect();
                        $api->comm('/ppp/secret/set', [
                            ".id" => $data['id_pppoe'],
                            "disabled" => 'true',
                        ]);

                        // disable active otomatis
                        $ambilid = $api->comm("/ppp/active/print", ["?name" => $data['name_pppoe']]);
                        $api->comm('/ppp/active/remove', [".id" => $ambilid[0]['.id']]);
                        $api->disconnect();
                    }
                }
            }
        } else {
            $getData = $this->db->query("SELECT client.id, client.code_client, client.phone, client.name, client.id_paket, 
            client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, 
            DAY(client.start_date) as tanggal, client.stop_date, client.id_area, client.description, client.id_sales,
            data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, data_pembayaran.nama, data_pembayaran.paket, 
            data_pembayaran.nama_admin, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
            data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
            data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, paket.name as namaPaket, paket.price as harga_paket
    
            FROM client
            LEFT JOIN paket ON client.id_paket = paket.id
            LEFT JOIN data_pembayaran ON client.name_pppoe = data_pembayaran.nama
            AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'
    
            WHERE client.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
            data_pembayaran.transaction_time IS NULL AND client.stop_date IS NULL
            AND paket.name != 'Free 20 Mbps' AND DAY(client.start_date) = '$tanggal' AND
            client.disabled = 'false'
    
            GROUP BY client.name_pppoe
            ORDER BY DAY(client.start_date) ASC
            ")->result_array();

            foreach ($getData as $data) {
                date_default_timezone_set("Asia/Jakarta");
                $timeNow = date('H:i:s');
                $timeOut = date('18:55:00');

                if ($data['transaction_time'] == null && $data['status_code'] == null) {
                    if ($timeNow > $timeOut) {

                        // disable secret dan active otomatis 
                        $api = connect();
                        $api->comm('/ppp/secret/set', [
                            ".id" => $data['id_pppoe'],
                            "disabled" => 'true',
                        ]);

                        // disable active otomatis
                        $ambilid = $api->comm("/ppp/active/print", ["?name" => $data['name_pppoe']]);
                        $api->comm('/ppp/active/remove', [".id" => $ambilid[0]['.id']]);
                        $api->disconnect();
                    }
                }
            }
        }
    }
}
