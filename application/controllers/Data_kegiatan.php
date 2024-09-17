<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_kegiatan extends CI_Controller
{
  public $msg;
  public $unread_count;
  public function __construct()
  {
    parent::__construct();
    $this->load->model('kegiatan_model');
    $this->load->model('kegiatantambah_model');
    $this->load->model('sifat_model');
    $this->load->library('upload');
    $this->load->model('notification_model');
    $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row();
    $this->msg = $this->notification_model->get_notifications_by_user($user->id);
    $this->unread_count = $this->notification_model->get_unread_count($user->id);
    // is_logged_in();
  }

  public function index($id = '')
  {
    if ($id) {
      // update notif
      $this->notification_model->mark_as_read($id);
      redirect('data_kegiatan');
    }

    $data['title'] = 'Daftar Kegiatan';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['unread_count'] = $this->unread_count;
    $user_id = $data['user']['id'];

    // Get filter parameters from POST request
    $sifat = $this->input->post('sifat', true);
    $level = $this->input->post('level', true);
    $partisipasi = $this->input->post('partisipasi', true);
    $bidang = $this->input->post('bidang', true);
    $status = $this->input->post('status', true);

    if ($sifat || $level || $partisipasi || $bidang || $status) {
      $this->session->set_flashdata('filter_applied', true);
    } else {
      $this->session->set_flashdata('filter_applied', false);
    }

    // Fetch kegiatan by user with filters
    $data['kegiatan'] = $this->kegiatan_model->get_all_kegiatan_by_user($user_id, $sifat, $level, $partisipasi, $bidang, $status);

    // Initialize counters
    $data['belum_diperiksa_count'] = 0;
    $data['valid_count'] = 0;
    $data['tidak_valid_count'] = 0;
    $data['wajib_count'] = 0;
    $data['total_poin'] = 0;
    $total_kegiatan_count = count($data['kegiatan']); // Hitung total kegiatan

    // Count statuses and points
    foreach ($data['kegiatan'] as $kegiatan) {
      switch ($kegiatan['id_status']) {
        case 1:
          $data['belum_diperiksa_count']++;
          break;
        case 2:
          $data['valid_count']++;
          $data['total_poin'] += $kegiatan['bobot'];
          if ($kegiatan['id_sifat'] == 1) {
            $data['wajib_count']++;
          }
          break;
        case 3:
          $data['tidak_valid_count']++;
          break;
        default:
          break;
      }
    }

    $this->db->where('id', $user_id);
    $this->db->update('user', ['total_poin' => $data['total_poin']]);
    // Total points from user table
    $data['bobot_user'] = $data['user']['bobot'];

    $data['total_kegiatan_count'] = $total_kegiatan_count;

    // Get dropdown data for filters
    $data['sifat'] = $this->kegiatan_model->get_sifat_kegiatan();
    $data['level'] = $this->kegiatan_model->get_level();
    $data['partisipasi'] = $this->kegiatan_model->get_partisipasi();
    $data['bidang'] = $this->kegiatan_model->get_bidang();
    $data['statuses'] = $this->kegiatan_model->get_statuses();

    $this->load->view('templates/layout', ['data' => $data, 'konten' => 'data_kegiatan/data_kegiatan', 'notifikasi' => $this->msg]);
  }

  public function clearfilter()
  {
    // Redirect to index without any filter
    redirect('data_kegiatan');
  }


  public function add()
  {
    $data['title'] = 'Tambah Kegiatan';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['unread_count'] = $this->unread_count;
    $data['jeniskegiatan'] = $this->kegiatan_model->get_jenis_kegiatan();
    $data['bidang'] = $this->kegiatan_model->get_bidang();
    $data['partisipasi'] = $this->kegiatan_model->get_partisipasi();
    $data['level'] = $this->kegiatan_model->get_level();
    $data['kegiatantambah'] = $this->kegiatantambah_model->getAllKegiatan();
    $data['sifat'] = $this->sifat_model->getAllSifat();

    // $this->form_validation->set_rules('nama_kegiatantambah', 'Nama Kegiatan Pilihan', 'required');
    $this->form_validation->set_rules('nama_kegiatan', 'Nama Kegiatan', 'required');
    $this->form_validation->set_rules('waktu_pelaksanaan', 'Waktu Pelaksanaan', 'required');
    $this->form_validation->set_rules('id_jeniskegiatan', 'Jenis Kegiatan', 'required');
    $this->form_validation->set_rules('id_bidang', 'Bidang', 'required');
    $this->form_validation->set_rules('id_sifat', 'Sifat', 'required');
    $this->form_validation->set_rules('id_partisipasi', 'Partisipasi', 'required');
    $this->form_validation->set_rules('id_level', 'Level', 'required');
    $this->form_validation->set_rules('filebukti', 'File Bukti', 'callback_check_file_uploaded|callback_check_file_size|callback_check_file_type');


    if ($this->form_validation->run() == false) {
      $this->load->view('templates/layout', ['data' => $data, 'konten' => 'data_kegiatan/add_kegiatan', 'notifikasi' => $this->msg]);
    } else {
      $filebukti = null;

      if (!empty($_FILES['filebukti']['name'])) {
        $config['upload_path'] = './assets/filebukti/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 5120;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('filebukti')) {
          $fileData = $this->upload->data();
          $filebukti = $fileData['file_name'];
        } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Upload file gagal! ' . $this->upload->display_errors() . '</div>');
          redirect('data_kegiatan/add');
        }
      }

      $user_id = $data['user']['id'];
      $status_id = 1;

      $kegiatantambah_id = $this->input->post('nama_kegiatantambah');
      $kegiatantambah = $this->kegiatantambah_model->getKegiatanById($kegiatantambah_id);

      $kegiatan_data = [
        'nama_kegiatan' => $kegiatantambah['nama_kegiatantambah'],
        'nama_kegiatan' => $this->input->post('nama_kegiatan'),
        'id_sifat' => $kegiatantambah['id_sifat'],
        'id_sifat' => $this->input->post('id_sifat'),
        'waktu_pelaksanaan' => $kegiatantambah['waktu'],
        'waktu_pelaksanaan' => $this->input->post('waktu_pelaksanaan'),
        'id_jeniskegiatan' => $kegiatantambah['id_jeniskegiatan'],
        'id_jeniskegiatan' => $this->input->post('id_jeniskegiatan'),
        'id_bidang' => $kegiatantambah['id_bidang'],
        'id_bidang' => $this->input->post('id_bidang'),
        'id_level' => $kegiatantambah['id_level'],
        'id_level' => $this->input->post('id_level'),
        'id_partisipasi' => $this->input->post('id_partisipasi'),
        'filebukti' => $filebukti,
        'user_id' => $user_id,
        'id_status' => $status_id
      ];

      $this->kegiatan_model->add_kegiatan($kegiatan_data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kegiatan berhasil ditambahkan!</div>');
      redirect('data_kegiatan');
    }
  }

  public function get_kegiatantambah_data()
  {
    $id = $this->input->post('id');
    $data = $this->kegiatantambah_model->getKegiatanById($id);
    echo json_encode($data);
  }

  public function edit($id)
  {
    $data['title'] = 'Edit Kegiatan';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['unread_count'] = $this->unread_count;
    $data['kegiatan'] = $this->kegiatan_model->get_kegiatan_by_id_and_user($id, $data['user']['id']);

    if (!$data['kegiatan']) {
      show_error('You do not have permission to access this page.', 403);
    }

    $data['jeniskegiatan'] = $this->kegiatan_model->get_jenis_kegiatan();
    $data['bidang'] = $this->kegiatan_model->get_bidang();
    $data['partisipasi'] = $this->kegiatan_model->get_partisipasi();
    $data['level'] = $this->kegiatan_model->get_level();
    $data['sifat'] = $this->sifat_model->getAllSifat();

    $this->form_validation->set_rules('nama_kegiatan', 'Nama Kegiatan', 'required');
    $this->form_validation->set_rules('waktu_pelaksanaan', 'Waktu Pelaksanaan', 'required');
    $this->form_validation->set_rules('id_jeniskegiatan', 'Jenis Kegiatan', 'required');
    $this->form_validation->set_rules('id_bidang', 'Bidang', 'required');
    $this->form_validation->set_rules('id_sifat', 'Sifat', 'required');
    $this->form_validation->set_rules('id_partisipasi', 'Partisipasi', 'required');
    $this->form_validation->set_rules('id_level', 'Level', 'required');
    $this->form_validation->set_rules('filebukti', 'File Bukti', 'callback_check_file_size');


    if ($this->form_validation->run() == false) {
      $this->load->view('templates/layout', ['data' => $data, 'konten' => 'data_kegiatan/edit_kegiatan', 'notifikasi' => $this->msg]);
    } else {
      $filebukti = $data['kegiatan']['filebukti'];

      if (!empty($_FILES['filebukti']['name'])) {
        $config['upload_path'] = './assets/filebukti/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 5120;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('filebukti')) {
          $fileData = $this->upload->data();
          $filebukti = $fileData['file_name'];
        } else {
          // Tambahkan debugging untuk mengetahui kesalahan
          $error = $this->upload->display_errors();
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Upload file gagal! ' . $error . '</div>');
          redirect('data_kegiatan/edit/' . $id);
          return;
        }
      }

      $user_id = $data['user']['id'];
      $status_id = 1;

      $kegiatan_data = [
        'id_jeniskegiatan' => $this->input->post('id_jeniskegiatan', true),
        'id_bidang' => $this->input->post('id_bidang', true),
        'id_sifat' => $this->input->post('id_sifat', true),
        'nama_kegiatan' => $this->input->post('nama_kegiatan', true),
        'waktu_pelaksanaan' => $this->input->post('waktu_pelaksanaan', true),
        'id_partisipasi' => $this->input->post('id_partisipasi', true),
        'id_level' => $this->input->post('id_level', true),
        'filebukti' => $filebukti,
        'user_id' => $user_id,
        'id_status' => $status_id
      ];

      $this->kegiatan_model->update_kegiatan($id, $kegiatan_data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kegiatan berhasil diperbarui!</div>');
      redirect('data_kegiatan');
    }
  }

  public function delete($id)
  {
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['unread_count'] = $this->unread_count;
    $kegiatan = $this->kegiatan_model->get_kegiatan_by_id_and_user($id, $data['user']['id']);
    if (!$kegiatan) {
      show_error('You do not have permission to access this page.', 403);
    }

    $this->kegiatan_model->delete_kegiatan($id);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kegiatan berhasil dihapus!</div>');
    redirect('data_kegiatan');
  }

  public function check_file_size()
  {
    if (isset($_FILES['filebukti']['size']) && $_FILES['filebukti']['size'] > 0) {
      $file_size = $_FILES['filebukti']['size'];
      if ($file_size > 5120 * 1024) { // Ukuran dalam byte, 2048 KB = 2 MB
        $this->form_validation->set_message('check_file_size', 'Ukuran file bukti tidak boleh melebihi 2MB.');
        return false;
      }
    }
    return true;
  }

  public function check_file_uploaded()
  {
    if (empty($_FILES['filebukti']['name'])) {
      $this->form_validation->set_message('check_file_uploaded', 'File Bukti wajib diupload.');
      return false;
    }
    return true;
  }

  public function check_file_type()
  {
    $allowed_mime_types = ['application/pdf'];
    $mime_type = get_mime_by_extension($_FILES['filebukti']['name']);
    if (!in_array($mime_type, $allowed_mime_types)) {
      $this->form_validation->set_message('check_file_type', 'File Bukti harus berformat PDF.');
      return false;
    }
    return true;
  }
}
