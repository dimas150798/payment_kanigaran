<?php

class M_Sales extends CI_Model
{
    // Menampilkan Data Sales
    public function DataSales()
    {
        $query   = $this->db->query("SELECT id, name , phone
                FROM sales
                ORDER BY name ASC");

        return $query->result_array();
    }

    public function EditSales($id_sales)
    {
        $query   = $this->db->query("SELECT id, name , phone
                FROM sales
                WHERE id = '$id_sales'");

        return $query->result_array();
    }

    // Check data sales
    public function CheckDuplicateSales($nama_sales)
    {
        $this->db->select('name, id');
        $this->db->where('name', $nama_sales);

        $this->db->limit(1);
        $result = $this->db->get('sales');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
}
