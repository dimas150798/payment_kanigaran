<?php

class M_TerminasiPelanggan extends CI_Model
{
    // Menampilkan Data Pelanggan Terminasi
    public function TerminasiPelanggan()
    {
        $query   = $this->db->query("SELECT client.id, client.code_client, client.phone, client.name,
            client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, client.start_date, client.disabled,
            client.stop_date, client.description, area.name as nama_area, sales.name as nama_sales, paket.name as nama_paket, client.keterangan
            
            FROM client
            
            LEFT JOIN area ON client.id_area = area.id
            LEFT JOIN sales ON client.id_sales = sales.id
            LEFT JOIN paket ON client.id_paket = paket.id

            WHERE stop_date IS NOT NULL
            
            GROUP BY client.name_pppoe
            ORDER BY client.stop_date DESC");

        return $query->result_array();
    }

    // Menampilkan Jumlah Pelanggan Terminasi
    public function JumlahTerminasi()
    {
        $query   = $this->db->query("SELECT client.id, client.code_client, client.phone, client.name,
        client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, client.start_date, 
        client.stop_date, client.description, area.name as nama_area, sales.name as nama_sales, paket.name as nama_paket
        
        FROM client
        
        LEFT JOIN area ON client.id_area = area.id
        LEFT JOIN sales ON client.id_sales = sales.id
        LEFT JOIN paket ON client.id_paket = paket.id

        WHERE stop_date IS NOT NULL
        
        GROUP BY client.name_pppoe
        ORDER BY client.stop_date DESC");

        return $query->num_rows();
    }

    // Edit Data Pelanggan
    public function EditPelanggan($id_customer)
    {
        $query   = $this->db->query("SELECT client.id, client.code_client, client.phone, client.name,
        client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, client.start_date, 
        client.stop_date, client.description, area.name as nama_area, sales.name as nama_sales, paket.name as nama_paket
        
        FROM client
        
        LEFT JOIN area ON client.id_area = area.id
        LEFT JOIN sales ON client.id_sales = sales.id
        LEFT JOIN paket ON client.id_paket = paket.id

        WHERE id = '$id_customer'
        
        GROUP BY client.name_pppoe
        ORDER BY client.stop_date DESC");

        return $query->result_array();
    }

    // Terminasi Months
    public function GetTerminasiMonth($tahun, $bulan)
    {
        $query   = $this->db->query("SELECT client.id, client.code_client, client.phone, client.name,
            client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, client.start_date, 
            client.stop_date, client.description, area.name as nama_area, sales.name as nama_sales, paket.name as nama_paket
            
            FROM client
            
            LEFT JOIN area ON client.id_area = area.id
            LEFT JOIN sales ON client.id_sales = sales.id
            LEFT JOIN paket ON client.id_paket = paket.id
    
            WHERE YEAR(stop_date) = '$tahun' AND MONTH(stop_date) = '$bulan'
            
            GROUP BY client.name_pppoe
            ORDER BY client.stop_date DESC");

        return $query->result_array();
    }

    // Jumlah Terminasi Months
    public function JumlahTerminasiMonth($tahun, $bulan)
    {
        $query   = $this->db->query("SELECT client.id, client.code_client, client.phone, client.name,
                client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, client.start_date, 
                client.stop_date, client.description, area.name as nama_area, sales.name as nama_sales, paket.name as nama_paket
                
                FROM client
                
                LEFT JOIN area ON client.id_area = area.id
                LEFT JOIN sales ON client.id_sales = sales.id
                LEFT JOIN paket ON client.id_paket = paket.id
        
                WHERE YEAR(stop_date) = '$tahun' AND MONTH(stop_date) = '$bulan'
                
                GROUP BY client.name_pppoe
                ORDER BY client.stop_date DESC");

        return $query->num_rows();
    }
}
