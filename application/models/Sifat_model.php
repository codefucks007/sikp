<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sifat_model extends CI_Model
{
    public function getAllSifat()
    {
        return $this->db->get('sifat')->result_array();
    }
}
