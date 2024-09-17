<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kegiatantambah_model extends CI_Model
{
    public function getAllKegiatan()
    {
        $this->db->select('kegiatantambah.*, sifat.sifat, jeniskegiatan.jeniskegiatan, bidang.nama_bidang, level.level');
        $this->db->from('kegiatantambah');
        $this->db->join('sifat', 'kegiatantambah.id_sifat = sifat.id');
        $this->db->join('jeniskegiatan', 'kegiatantambah.id_jeniskegiatan = jeniskegiatan.id');
        $this->db->join('bidang', 'kegiatantambah.id_bidang = bidang.id');
        $this->db->join('level', 'kegiatantambah.id_level = level.id');
        return $this->db->get()->result_array();
    }


    public function addKegiatan($data)
    {
        $this->db->insert('kegiatantambah', $data);
    }

    public function getKegiatanById($id)
    {
        $this->db->select('kegiatantambah.*, sifat.sifat, jeniskegiatan.jeniskegiatan, bidang.nama_bidang');
        $this->db->from('kegiatantambah');
        $this->db->join('sifat', 'kegiatantambah.id_sifat = sifat.id');
        $this->db->join('jeniskegiatan', 'kegiatantambah.id_jeniskegiatan = jeniskegiatan.id');
        $this->db->join('bidang', 'kegiatantambah.id_bidang = bidang.id');
        $this->db->join('level', 'kegiatantambah.id_level = level.id');
        $this->db->where('kegiatantambah.id', $id);
        return $this->db->get()->row_array();
    }


    public function updateKegiatan($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('kegiatantambah', $data);
    }

    public function deleteKegiatan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kegiatantambah');
    }
}
