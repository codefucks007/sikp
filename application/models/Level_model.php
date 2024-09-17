<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Level_model extends CI_Model
{
    public function getAllLevel()
    {
        return $this->db->get('level')->result_array();
    }
}
