<?php

class M_Paket extends CI_Model
{
    // Menampilkan Data Paket
    public function DataPaket()
    {
        $query   = $this->db->query("SELECT id, name, price, description
                FROM paket
                ORDER BY id ASC");

        return $query->result_array();
    }

    // Edit Paket
    public function EditPaket($id_paket)
    {
        $query   = $this->db->query("SELECT id, name, price, description
        FROM paket

        WHERE id = '$id_paket'
        ORDER BY id ASC");

        return $query->result_array();
    }

    // Check data paket
    public function CheckDuplicatePaket($nama_paket)
    {
        $this->db->select('name, id');
        $this->db->where('name', $nama_paket);

        $this->db->limit(1);
        $result = $this->db->get('paket');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    // Get Data Paket
    public function GetDataPaket($id_paket)
    {
        $this->db->select('price, name, id');
        $this->db->where('id', $id_paket);

        $this->db->limit(1);
        $result = $this->db->get('paket');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
}
