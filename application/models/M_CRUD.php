<?php

class M_CRUD extends CI_Model
{

    // Insert data ke mysql
    public function insertData($data, $table)
    {
        $this->db->insert($table, $data);
    }

    // Update data ke mysql
    public function updateData($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
    }

    // Delete data ke mysql
    public function deleteData($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function insertBatchData($data, $table)
    {
        $this->db->insert_batch($table, $data);
        return $this->db->affected_rows();
    }
}
