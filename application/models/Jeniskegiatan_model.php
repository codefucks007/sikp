<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jeniskegiatan_model extends CI_Model
{
    public function getAllJeniskegiatan()
    {
        return $this->db->get('jeniskegiatan')->result_array();
    }

    public function addJeniskegiatan($data)
    {
        $this->db->insert('jeniskegiatan', $data);
    }

    public function deleteJeniskegiatan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('jeniskegiatan');
    }

    public function updateJeniskegiatan($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('jeniskegiatan', $data);
    }
}
