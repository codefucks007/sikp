<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
  public $msg;
  public $unread_count;

  public function __construct()
  {
    parent::__construct();
    $this->load->model('notification_model');

    $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row();
    $this->msg = $this->notification_model->get_notifications_by_user($user->id);
    $this->unread_count = $this->notification_model->get_unread_count($user->id);

    is_logged_in();
  }

  public function index()
  {
    $data['title'] = 'Beranda';
    $data['user'] = $this->db->select('user.*, program_studi.program_studi')
      ->from('user')
      ->join('program_studi', 'user.id_program_studi = program_studi.id')
      ->where('user.email', $this->session->userdata('email'))
      ->get()
      ->row_array();

    $data['unread_count'] = $this->unread_count;

    // Ambil data kegiatan dan hitung status
    $data['kegiatan'] = $this->kegiatan_model->get_all_kegiatan_by_user($data['user']['id']);
    $data['belum_diperiksa_count'] = 0;
    $data['valid_count'] = 0;
    $data['tidak_valid_count'] = 0;
    $data['wajib_count'] = 0;
    $data['total_poin'] = 0; // Inisialisasi total poin
    $total_kegiatan_count = count($data['kegiatan']); // Hitung total kegiatan

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

    $data['bobot_user'] = $data['user']['bobot'];

    // Tambahkan total kegiatan ke dalam data
    $data['total_kegiatan_count'] = $total_kegiatan_count;

    $this->load->view('templates/layout', ['data' => $data, 'konten' => 'user/index', 'notifikasi' => $this->msg]);
  }


  public function edit()
  {
    $data['title'] = 'Edit Profile';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['program_studi'] = $this->db->get('program_studi')->result_array(); // Ambil data program_studi

    $data['unread_count'] = $this->unread_count;

    $this->form_validation->set_rules('nrp', 'NRP', 'required|trim');
    $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
    $this->form_validation->set_rules('no_telepon', 'Phone Number', 'required|trim');
    $this->form_validation->set_rules('program_studi', 'Program Studi', 'required|trim');
    $this->form_validation->set_rules('angkatan', 'Angkatan', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/layout', ['data' => $data, 'konten' => 'user/edit', 'notifikasi' => $this->msg]);
    } else {
      $nrp = $this->input->post('nrp');
      $name = $this->input->post('name');
      $email = $this->input->post('email');
      $no_telepon = $this->input->post('no_telepon');
      $id_program_studi = $this->input->post('program_studi'); // Ambil ID dari program studi
      $angkatan = $this->input->post('angkatan');

      $upload_image = $_FILES['image']['name'];

      if ($upload_image) {
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = '2048';
        $config['upload_path'] = './assets/img/profile/';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
          $old_image = $data['user']['image'];
          if ($old_image != 'default.jpg') {
            unlink(FCPATH . 'assets/img/profile/' . $old_image);
          }
          $new_image = $this->upload->data('file_name');
          $this->db->set('image', $new_image);
        } else {
          echo $this->upload->display_errors();
        }
      }

      $this->db->set('nrp', $nrp);
      $this->db->set('name', $name);
      $this->db->set('no_telepon', $no_telepon);
      $this->db->set('id_program_studi', $id_program_studi); // Simpan ID program studi
      $this->db->set('angkatan', $angkatan);
      $this->db->set('is_profile_complete', 1); // Set is_profile_complete to 1
      $this->db->where('email', $email);
      $this->db->update('user');

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated!</div>');
      redirect('user');
    }
  }

  public function changePassword()
  {
    $data['title'] = 'Change Password';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['unread_count'] = $this->unread_count;

    $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
    $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
    $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/layout', ['data' => $data, 'konten' => 'user/changepassword', 'notifikasi' => $this->msg]);
    } else {
      $current_password = $this->input->post('current_password');
      $new_password = $this->input->post('new_password1');
      if (!password_verify($current_password, $data['user']['password'])) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password!</div>');
        redirect('user/changepassword');
      } else {
        if ($current_password == $new_password) {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password!</div>');
          redirect('user/changepassword');
        } else {
          // password sudah ok
          $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

          $this->db->set('password', $password_hash);
          $this->db->where('email', $this->session->userdata('email'));
          $this->db->update('user');

          $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password changed!</div>');
          redirect('user/changepassword');
        }
      }
    }
  }
}
