<?php

class M_Pelanggan extends CI_Model
{
    // Menampilkan Data Pelanggan
    public function DataPelanggan()
    {
        $query   = $this->db->query("SELECT client.id, client.code_client, client.phone, client.name, client.id_paket, 
            client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, 
            DAY(client.start_date) as tanggal, client.start_date, client.stop_date, client.id_area, client.description, client.id_sales, client.disabled,
            area.name as nama_area, sales.name as nama_sales, paket.name as nama_paket
            
            FROM client
            
            LEFT JOIN area ON client.id_area = area.id
            LEFT JOIN sales ON client.id_sales = sales.id
            LEFT JOIN paket ON client.id_paket = paket.id

            WHERE client.stop_date IS NULL 
            
            GROUP BY client.name_pppoe
            ORDER BY client.name_pppoe ASC");

        return $query->result_array();
    }

    // Menampilkan Jumlah Pelanggan
    public function JumlahPelanggan()
    {
        $query   = $this->db->query("SELECT client.id, client.code_client, client.phone, client.name, client.id_paket, 
        client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, 
        DAY(client.start_date) as tanggal, client.stop_date, client.id_area, client.description, client.id_sales,
        area.name as nama_area, sales.name as nama_sales, paket.name as nama_paket
        
        FROM client
        
        LEFT JOIN area ON client.id_area = area.id
        LEFT JOIN sales ON client.id_sales = sales.id
        LEFT JOIN paket ON client.id_paket = paket.id

        WHERE client.stop_date IS NULL 
        
        GROUP BY client.name_pppoe
        ORDER BY client.name_pppoe ASC");

        return $query->num_rows();
    }

    // Menampilkan Jumlah Pelanggan Aktif
    public function JumlahPelangganAktif()
    {
        $query   = $this->db->query("SELECT client.id, client.code_client, client.phone, client.name, client.id_paket, 
            client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, 
            DAY(client.start_date) as tanggal, client.stop_date, client.id_area, client.description, client.id_sales,
            area.name as nama_area, sales.name as nama_sales, paket.name as nama_paket
            
            FROM client
            
            LEFT JOIN area ON client.id_area = area.id
            LEFT JOIN sales ON client.id_sales = sales.id
            LEFT JOIN paket ON client.id_paket = paket.id

            WHERE client.stop_date IS NULL
            
            GROUP BY client.name_pppoe
            ORDER BY client.name_pppoe ASC");

        return $query->num_rows();
    }

    // Menampilkan Jumlah Pelanggan Baru
    public function JumlahPelangganBaru($bulan,  $tahun)
    {
        $query   = $this->db->query("SELECT client.id, client.code_client, client.phone, client.name, client.id_paket, 
                client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, 
                DAY(client.start_date) as tanggal, client.stop_date, client.id_area, client.description, client.id_sales,
                area.name as nama_area, sales.name as nama_sales, paket.name as nama_paket
                
                FROM client
                
                LEFT JOIN area ON client.id_area = area.id
                LEFT JOIN sales ON client.id_sales = sales.id
                LEFT JOIN paket ON client.id_paket = paket.id
    
                WHERE YEAR(client.start_date) = '$tahun' AND MONTH(client.start_date) = '$bulan' 
                
                GROUP BY client.name_pppoe
                ORDER BY client.name_pppoe ASC");

        return $query->num_rows();
    }

    // Edit Data Pelanggan
    public function EditPelanggan($id_customer)
    {
        $query   = $this->db->query("SELECT client.id, client.code_client, client.phone, client.name, client.id_paket, 
        client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, 
        DAY(client.start_date) as tanggal, client.start_date, client.stop_date, client.id_area, client.description, client.id_sales,
        area.name as nama_area, sales.name as nama_sales, paket.name as nama_paket
        
        FROM client
        
        LEFT JOIN area ON client.id_area = area.id
        LEFT JOIN sales ON client.id_sales = sales.id
        LEFT JOIN paket ON client.id_paket = paket.id

        WHERE client.id = '$id_customer'
        
        GROUP BY client.name_pppoe
        ORDER BY client.name_pppoe ASC");

        return $query->result_array();
    }

    // Check data pelanggan
    public function CheckDuplicatePelanggan($Name_PPPOE)
    {
        $this->db->select('name, id_pppoe, name_pppoe');
        $this->db->where('name_pppoe', $Name_PPPOE);

        $this->db->limit(1);
        $result = $this->db->get('client');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    // Check data pelanggan
    public function CheckIDPelanggan($id_customer)
    {
        $this->db->select('name, id_pppoe, name_pppoe, DAY(start_date) as JatuhTempo');
        $this->db->where('id', $id_customer);

        $this->db->limit(1);
        $result = $this->db->get('client');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    // Check data code client
    public function CheckDuplicateCode($code_invoice)
    {
        $this->db->select('order_id, nama');
        $this->db->where('order_id', $code_invoice);

        $this->db->limit(1);
        $result = $this->db->get('data_pembayaran');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }


    // Invoice payment
    public function kodePelanggan()
    {
        $sql = "SELECT MAX(MID(code_client,4,4)) AS invoiceID 
            FROM client";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $dataRow    = $query->row();
            $dataN      = ((int)$dataRow->invoiceID) + 1;
            $no         = sprintf("%'.04d", $dataN);
        } else {
            $no         = "0001";
        }

        $invoice = "lc" . $no;
        return $invoice;
    }

    // Name PPPOE
    public function KodeNamePppoe()
    {
        // Query untuk mendapatkan kode terakhir dari database
        $sqlExistingCode = "SELECT MAX(name_pppoe) AS existingCode FROM client WHERE MID(name_pppoe, 4, 4)";
        $queryExistingCode = $this->db->query($sqlExistingCode);

        if ($queryExistingCode->num_rows() > 0) {
            $dataRowExistingCode = $queryExistingCode->row();
            $existingCode = $dataRowExistingCode->existingCode;
        } else {
            $existingCode = "kng0000"; // Default value jika tidak ada data
        }

        // Mengambil angka dari kode yang diperoleh dari database
        $existingNumber = (int)substr($existingCode, 3, 4);

        // Membuat kueri SQL dengan klausa WHERE
        $sql = "SELECT MAX(MID(name_pppoe, 4, 4)) AS invoiceID 
         FROM client 
         WHERE MID(name_pppoe, 4, 4) = $existingNumber";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $dataRow = $query->row();
            $dataN = ((int)$dataRow->invoiceID) + 1;
        } else {
            $dataN = 1;
        }

        $no = sprintf("%'.04d", $dataN);

        $invoice = "kng" . $no . '-';
        return $invoice;
    }

    // Name Pelanggan
    public function KodePelangganNew()
    {
        // Query untuk mendapatkan kode terakhir dari database
        $sqlExistingCode = "SELECT MAX(name_pppoe) AS existingCode FROM client WHERE MID(name_pppoe, 4, 4)";
        $queryExistingCode = $this->db->query($sqlExistingCode);

        if ($queryExistingCode->num_rows() > 0) {
            $dataRowExistingCode = $queryExistingCode->row();
            $existingCode = $dataRowExistingCode->existingCode;
        } else {
            $existingCode = "kng0000"; // Default value jika tidak ada data
        }

        // Mengambil angka dari kode yang diperoleh dari database
        $existingNumber = (int)substr($existingCode, 3, 4);

        // Membuat kueri SQL dengan klausa WHERE
        $sql = "SELECT MAX(MID(name_pppoe, 4, 4)) AS invoiceID 
             FROM client 
             WHERE MID(name_pppoe, 4, 4) = $existingNumber";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $dataRow = $query->row();
            $dataN = ((int)$dataRow->invoiceID) + 1;
        } else {
            $dataN = 1;
        }

        $no = sprintf("%'.04d", $dataN);

        $invoice = "kng" . $no;
        return $invoice;
    }

    public function cekData($kode_nama)
    {
        // Memisahkan kode dan nama dari input
        $kode_nama_parts = explode('-', $kode_nama);
        $kode = $kode_nama_parts[0];
        $nama = $kode_nama_parts[1];

        // Query untuk memeriksa keberadaan data di database
        $sql = "SELECT * FROM client WHERE MID(name_pppoe, 1, 3) = ? AND MID(name_pppoe, 5) = ?";
        $query = $this->db->query($sql, array($kode, $nama));

        // Memeriksa hasil query
        return $query->num_rows() > 0;
    }
}
