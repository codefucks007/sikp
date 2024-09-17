<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bidang_model extends CI_Model
{
    public function getAllBidang()
    {
        return $this->db->get('bidang')->result_array();
    }

    public function addBidang($data)
    {
        return $this->db->insert('bidang', $data);
    }

    public function deleteBidang($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('bidang');
    }

    public function updateBidang($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('bidang', $data);
    }
}
