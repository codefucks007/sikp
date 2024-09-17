<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kegiatan_model extends CI_Model
{
    public function get_all_kegiatan_by_user($user_id, $sifat = null, $level = null, $partisipasi = null, $bidang = null, $status = null)
    {
        $this->db->select('kegiatan.*, jeniskegiatan.jeniskegiatan, partisipasi.partisipasi, level.level, bidang.nama_bidang, status.status, sifat.sifat, user.nrp, user.name as name, program_studi.program_studi, kegiatan.catatan');
        $this->db->select('(CASE
        WHEN partisipasi.partisipasi = "Panitia" THEN 4
        WHEN partisipasi.partisipasi = "Peserta" THEN 2
        ELSE 0
    END) * (CASE
        WHEN level.level = "Lokal" THEN 2
        WHEN level.level = "Regional" THEN 3
        WHEN level.level = "Nasional" THEN 4
        WHEN level.level = "Internasional" THEN 5
        ELSE 0
    END) * (CASE
        WHEN sifat.sifat = "Wajib" THEN 3
        WHEN sifat.sifat = "Pilihan" THEN 2
        ELSE 0
    END) AS bobot');
        $this->db->from('kegiatan');
        $this->db->join('jeniskegiatan', 'kegiatan.id_jeniskegiatan = jeniskegiatan.id', 'left');
        $this->db->join('bidang', 'kegiatan.id_bidang = bidang.id', 'left');
        $this->db->join('partisipasi', 'kegiatan.id_partisipasi = partisipasi.id', 'left');
        $this->db->join('level', 'kegiatan.id_level = level.id', 'left');
        $this->db->join('status', 'kegiatan.id_status = status.id', 'left');
        $this->db->join('sifat', 'kegiatan.id_sifat = sifat.id', 'left');  // Join sifat table
        $this->db->join('user', 'kegiatan.id_user = user.id', 'left');  // Join user table
        $this->db->join('program_studi', 'user.id_program_studi = program_studi.id', 'left');  // Join program_studi table
        $this->db->where('kegiatan.id_user', $user_id);

        // Apply filters
        if ($sifat) {
            $this->db->where('kegiatan.id_sifat', $sifat);
        }
        if ($level) {
            $this->db->where('kegiatan.id_level', $level);
        }
        if ($partisipasi) {
            $this->db->where('kegiatan.id_partisipasi', $partisipasi);
        }
        if ($bidang) {
            $this->db->where('kegiatan.id_bidang', $bidang);
        }
        if ($status) {
            $this->db->where('kegiatan.id_status', $status);
        }

        $query = $this->db->get();
        return $query->result_array();
    }



    public function get_kegiatan_by_id_and_user($id, $user_id)
    {
        $this->db->select('kegiatan.*, jeniskegiatan.jeniskegiatan, partisipasi.partisipasi, level.level, bidang.nama_bidang, status.status, sifat.sifat, user.nrp, user.name as name, program_studi.program_studi, kegiatan.catatan');
        $this->db->from('kegiatan');
        $this->db->join('jeniskegiatan', 'kegiatan.id_jeniskegiatan = jeniskegiatan.id', 'left');
        $this->db->join('bidang', 'kegiatan.id_bidang = bidang.id', 'left');
        $this->db->join('partisipasi', 'kegiatan.id_partisipasi = partisipasi.id', 'left');
        $this->db->join('level', 'kegiatan.id_level = level.id', 'left');
        $this->db->join('status', 'kegiatan.id_status = status.id', 'left');
        $this->db->join('sifat', 'kegiatan.id_sifat = sifat.id', 'left');  // Join sifat table
        $this->db->join('user', 'kegiatan.id_user = user.id', 'left');  // Join user table
        $this->db->join('program_studi', 'user.id_program_studi = program_studi.id', 'left');  // Join program_studi table
        $this->db->where('kegiatan.id_kegiatan', $id);
        $this->db->where('kegiatan.id_user', $user_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function add_kegiatan($kegiatan_data)
    {
        $bobot = $this->calculate_bobot($kegiatan_data['id_partisipasi'], $kegiatan_data['id_level']);

        $data = [
            'id_user' => $kegiatan_data['user_id'],
            'id_jeniskegiatan' => $kegiatan_data['id_jeniskegiatan'],
            'id_bidang' => $kegiatan_data['id_bidang'],
            'id_sifat' => $kegiatan_data['id_sifat'],
            'nama_kegiatan' => $kegiatan_data['nama_kegiatan'],
            'waktu_pelaksanaan' => $kegiatan_data['waktu_pelaksanaan'],
            'id_partisipasi' => $kegiatan_data['id_partisipasi'],
            'id_level' => $kegiatan_data['id_level'],
            'filebukti' => $kegiatan_data['filebukti'] ? $kegiatan_data['filebukti'] : '',
            'id_status' => $kegiatan_data['id_status'],
            'bobot' => $bobot
        ];
        $this->db->insert('kegiatan', $data);
    }

    public function update_kegiatan($id, $kegiatan_data)
    {
        $bobot = $this->calculate_bobot($kegiatan_data['id_partisipasi'], $kegiatan_data['id_level']);

        $data = [
            'id_jeniskegiatan' => $kegiatan_data['id_jeniskegiatan'],
            'id_bidang' => $kegiatan_data['id_bidang'],
            'id_sifat' => $kegiatan_data['id_sifat'],
            'nama_kegiatan' => $kegiatan_data['nama_kegiatan'],
            'waktu_pelaksanaan' => $kegiatan_data['waktu_pelaksanaan'],
            'id_partisipasi' => $kegiatan_data['id_partisipasi'],
            'id_level' => $kegiatan_data['id_level'],
            'filebukti' => $kegiatan_data['filebukti'],
            'id_status' => $kegiatan_data['id_status'],
            'bobot' => $bobot
        ];

        $this->db->where('id_kegiatan', $id);
        $this->db->update('kegiatan', $data);
    }

    public function delete_kegiatan($id)
    {
        $this->db->where('id_kegiatan', $id);
        $this->db->delete('kegiatan');
    }

    private function calculate_bobot($partisipasi_id, $level_id)
    {
        $bobot_partisipasi = 0;
        $bobot_level = 0;

        // Calculate bobot for partisipasi
        switch ($partisipasi_id) {
            case 1: // Panitia
                $bobot_partisipasi = 5;
                break;
            case 2: // Peserta
                $bobot_partisipasi = 3;
                break;
            default:
                $bobot_partisipasi = 0;
        }

        // Calculate bobot for level
        switch ($level_id) {
            case 1: // Lokal
                $bobot_level = 1;
                break;
            case 2: // Regional
                $bobot_level = 2;
                break;
            case 3: // Nasional
                $bobot_level = 3;
                break;
            case 4: // Internasional
                $bobot_level = 4;
                break;
            default:
                $bobot_level = 0;
        }

        return $bobot_partisipasi * $bobot_level;
    }

    public function get_bidang()
    {
        $query = $this->db->get('bidang');
        return $query->result_array();
    }

    public function get_jenis_kegiatan()
    {
        $query = $this->db->get('jeniskegiatan');
        return $query->result_array();
    }

    public function get_partisipasi()
    {
        $query = $this->db->get('partisipasi');
        return $query->result_array();
    }

    public function get_level()
    {
        $query = $this->db->get('level');
        return $query->result_array();
    }

    public function get_statuses()
    {
        $query = $this->db->get('status');
        return $query->result_array();
    }

    public function get_program_studi()
    {
        $query = $this->db->get('program_studi');
        return $query->result_array();
    }

    public function get_sifat_kegiatan()
    {
        $query = $this->db->get('sifat');
        return $query->result_array();
    }

    //PETUGAS

    public function get_all_kegiatan($program_studi = '', $jenis_kegiatan = '', $status = '')
    {
        $this->db->select('kegiatan.*, jeniskegiatan.jeniskegiatan, partisipasi.partisipasi, level.level, bidang.nama_bidang, status.status, user.name as nama, user.nrp, program_studi.program_studi as program_studi, sifat.sifat'); // Tambahkan sifat ke select
        $this->db->select('(CASE
        WHEN partisipasi.partisipasi = "Panitia" THEN 5
        WHEN partisipasi.partisipasi = "Peserta" THEN 3
        ELSE 0
    END) * (CASE
        WHEN level.level = "Lokal" THEN 2
        WHEN level.level = "Regional" THEN 3
        WHEN level.level = "Nasional" THEN 4
        WHEN level.level = "Internasional" THEN 5
        ELSE 0
    END) * (CASE
        WHEN sifat.sifat = "Wajib" THEN 3
        WHEN sifat.sifat = "Pilihan" THEN 2
        ELSE 0
    END) AS bobot');
        $this->db->from('kegiatan');
        $this->db->join('jeniskegiatan', 'kegiatan.id_jeniskegiatan = jeniskegiatan.id', 'left');
        $this->db->join('bidang', 'kegiatan.id_bidang = bidang.id', 'left');
        $this->db->join('partisipasi', 'kegiatan.id_partisipasi = partisipasi.id', 'left');
        $this->db->join('level', 'kegiatan.id_level = level.id', 'left');
        $this->db->join('status', 'kegiatan.id_status = status.id', 'left');
        $this->db->join('user', 'kegiatan.id_user = user.id', 'left');
        $this->db->join('program_studi', 'user.id_program_studi = program_studi.id', 'left');
        $this->db->join('sifat', 'kegiatan.id_sifat = sifat.id', 'left'); // Join dengan tabel sifat

        // Apply filters
        if ($program_studi) {
            $this->db->where('user.id_program_studi', $program_studi);
        }
        if ($jenis_kegiatan) {
            $this->db->where('kegiatan.id_jeniskegiatan', $jenis_kegiatan);
        }
        if ($status) {
            $this->db->where('kegiatan.id_status', $status);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_kegiatan_by_id($id)
    {
        $this->db->select('kegiatan.*, jeniskegiatan.jeniskegiatan, partisipasi.partisipasi, level.level, bidang.nama_bidang, status.status, user.name as nama, user.nrp, program_studi.program_studi as program_studi, sifat.sifat');
        $this->db->from('kegiatan');
        $this->db->join('jeniskegiatan', 'kegiatan.id_jeniskegiatan = jeniskegiatan.id', 'left');
        $this->db->join('bidang', 'kegiatan.id_bidang = bidang.id', 'left');
        $this->db->join('partisipasi', 'kegiatan.id_partisipasi = partisipasi.id', 'left');
        $this->db->join('level', 'kegiatan.id_level = level.id', 'left');
        $this->db->join('status', 'kegiatan.id_status = status.id', 'left');
        $this->db->join('user', 'kegiatan.id_user = user.id', 'left');
        $this->db->join('program_studi', 'user.id_program_studi = program_studi.id', 'left');
        $this->db->join('sifat', 'kegiatan.id_sifat = sifat.id', 'left'); // Join dengan tabel sifat
        $this->db->where('kegiatan.id_kegiatan', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function validasi_kegiatan($id, $status_id, $catatan_petugas)
    {
        $this->db->set('id_status', $status_id);
        $this->db->set('catatan', $catatan_petugas); // Simpan catatan petugas ke dalam kolom 'catatan'
        $this->db->where('id_kegiatan', $id);
        $this->db->update('kegiatan');
    }
}
