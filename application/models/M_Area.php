<?php

class M_Area extends CI_Model
{
    // Menampilkan Data Area
    public function DataArea()
    {
        $query   = $this->db->query("SELECT id, name, nama_dp
                FROM area
                ORDER BY name ASC");

        return $query->result_array();
    }
    public function EditArea($id_area)
    {
        $query   = $this->db->query("SELECT id, name, nama_dp
        FROM area
        WHERE id = '$id_area'
        ORDER BY name ASC");

        return $query->result_array();
    }

    // Check data area
    public function CheckDuplicateArea($nama_area)
    {
        $this->db->select('name, id, nama_dp');
        $this->db->where('name', $nama_area);

        $this->db->limit(1);
        $result = $this->db->get('area');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
}
