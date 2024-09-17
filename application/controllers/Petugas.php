<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Petugas extends CI_Controller
{

  public $msg;
  public $unread_count;

  public function __construct()
  {
    parent::__construct();
    $this->load->model('kegiatan_model');
    $this->load->model('bidang_model');
    $this->load->model('jeniskegiatan_model');
    $this->load->model('Kegiatantambah_model');
    $this->load->model('Sifat_model');
    $this->load->model('Level_model');
    $this->load->model('notification_model');

    $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row();
    $this->msg = $this->notification_model->get_notifications_by_user($user->id);
    $this->unread_count = $this->notification_model->get_unread_count($user->id);
    is_logged_in();
  }

  public function index()
  {
    $data['title'] = 'Dashboard';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $role_id = $data['user']['role_id'];
    $role = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
    $data['user_role'] = $role['role'];

    $data['unread_count'] = $this->unread_count;
    // Ambil data kegiatan dan hitung status
    $data['kegiatan'] = $this->kegiatan_model->get_all_kegiatan();
    $data['belum_diperiksa_count'] = 0;
    $data['valid_count'] = 0;
    $data['tidak_valid_count'] = 0;
    // $data['total_poin'] = 0; // Inisialisasi total poin

    foreach ($data['kegiatan'] as $kegiatan) {
      switch ($kegiatan['id_status']) {
        case 1:
          $data['belum_diperiksa_count']++;
          break;
        case 2:
          $data['valid_count']++;
          // $data['total_poin'] += $kegiatan['bobot']; // Tambahkan bobot ke total poin
          break;
        case 3:
          $data['tidak_valid_count']++;
          break;
        default:
          break;
      }
    }
    // Hitung total daftar kegiatan mahasiswa yang ada
    $data['total_kegiatan'] = count($data['kegiatan']);
    $this->load->view('templates/layout', ['data' => $data, 'konten' => 'petugas/index', 'notifikasi' => $this->msg]);
  }

  //DAFTAR KEGIATAN MHS//
  public function daftarkegiatanmhs()
  {
    $data['title'] = 'Daftar Kegiatan Mahasiswa';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['unread_count'] = $this->unread_count;

    // Get filter parameters from POST request
    $program_studi = $this->input->post('program_studi', true); // true untuk mencegah XSS
    $jeniskegiatan = $this->input->post('jeniskegiatan', true); // true untuk mencegah XSS
    $status = $this->input->post('status', true); // true untuk mencegah XSS

    if ($program_studi || $jeniskegiatan || $status) {
      $this->session->set_flashdata('filter_applied', true);
    } else {
      $this->session->set_flashdata('filter_applied', false);
    }

    // Pass filters to model
    $data['kegiatan'] = $this->kegiatan_model->get_all_kegiatan($program_studi, $jeniskegiatan, $status);

    // Get dropdown data for filters
    $data['program_studi'] = $this->kegiatan_model->get_program_studi();
    $data['jeniskegiatan'] = $this->kegiatan_model->get_jenis_kegiatan();
    $data['statuses'] = $this->kegiatan_model->get_statuses();
    $data['sifat'] = $this->kegiatan_model->get_sifat_kegiatan(); // Menambahkan sifat kegiatan

    // Load view with data
    $this->load->view('templates/layout', ['data' => $data, 'konten' => 'petugas/daftarkegiatanmhs', 'notifikasi' => $this->msg]);
  }

  public function clearfilter()
  {
    // Redirect to daftarkegiatanmhs without any filter
    redirect('petugas/daftarkegiatanmhs');
  }

  public function validasikegiatan($id)
  {
    $data['title'] = 'Validasi Kegiatan';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['kegiatan'] = $this->kegiatan_model->get_kegiatan_by_id($id);
    $data['unread_count'] = $this->unread_count;

    // Load statuses from the model
    $data['statuses'] = $this->kegiatan_model->get_statuses();

    if (!$data['kegiatan']) {
      show_error('Kegiatan tidak ditemukan.', 404);
    }

    $this->load->view('templates/layout', ['data' => $data, 'konten' => 'petugas/validasikegiatan', 'notifikasi' => $this->msg]);
  }

  public function validasi($id_kegiatan)
  {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // Set validation rules
      $this->form_validation->set_rules('status', 'Status', 'required');
      // $this->form_validation->set_rules('catatan_petugas', 'Catatan Petugas', 'trim'); // Optional: Add validation rules for 'catatan_petugas' if needed

      // Run validation
      if ($this->form_validation->run() == FALSE) {
        // If validation fails, reload the form with validation errors

        $data['title'] = 'Validasi Kegiatan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['kegiatan'] = $this->kegiatan_model->get_kegiatan_by_id($id_kegiatan);
        $data['unread_count'] = $this->unread_count;
        $data['statuses'] = $this->kegiatan_model->get_statuses();

        if (!$data['kegiatan']) {
          show_error('Kegiatan tidak ditemukan.', 404);
        }

        $this->load->view('templates/layout', ['data' => $data, 'konten' => 'petugas/validasikegiatan', 'notifikasi' => $this->msg]);
      } else {
        // If validation succeeds, proceed with updating the kegiatan

        $status_id = $this->input->post('status', true);
        $catatan_petugas = $this->input->post('catatan_petugas', true); // Ambil nilai catatan petugas dari form

        // Update kegiatan status dan catatan petugas
        $this->kegiatan_model->validasi_kegiatan($id_kegiatan, $status_id, $catatan_petugas);

        // Ambil user_id dan nama_kegiatan dari kegiatan yang divalidasi
        $kegiatan = $this->kegiatan_model->get_kegiatan_by_id($id_kegiatan);
        $user_id = $kegiatan['id_user'];
        $nama_kegiatan = $kegiatan['nama_kegiatan']; // Assuming 'nama_kegiatan' is the column for activity name

        // Tambahkan notifikasi
        $this->load->model('notification_model');
        $message = ($status_id == 2)
          ? 'Kegiatan Anda "' . $nama_kegiatan . '" telah divalidasi.'
          : 'Kegiatan Anda "' . $nama_kegiatan . '" tidak valid.';

        $this->notification_model->add_notification($user_id, $message);

        // Redirect or load another view as needed
        redirect('petugas/daftarkegiatanmhs');
      }
    } else {
      // Load data untuk menampilkan form
      $data['title'] = 'Validasi Kegiatan';
      $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
      $data['kegiatan'] = $this->kegiatan_model->get_kegiatan_by_id($id_kegiatan);
      $data['unread_count'] = $this->unread_count;
      $data['statuses'] = $this->kegiatan_model->get_statuses();

      if (!$data['kegiatan']) {
        show_error('Kegiatan tidak ditemukan.', 404);
      }

      $this->load->view('templates/layout', ['data' => $data, 'konten' => 'petugas/validasi', 'notifikasi' => $this->msg]);
    }
  }


  //END DAFTAR KEGIATAN MHS

  //EDIT PROFILE//

  public function edit_petugas()
  {
    $data['title'] = 'Edit Profile';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['roles'] = $this->db->get('user_role')->result_array(); // Get roles from user_role table
    $data['unread_count'] = $this->unread_count;

    // Fetch role name for the user
    $role_id = $data['user']['role_id'];
    $role = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
    $data['user_role'] = $role['role'];

    $this->form_validation->set_rules('nip', 'NIP', 'required|trim');
    $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
    $this->form_validation->set_rules('no_telepon', 'Phone Number', 'required|trim');
    // No need to set validation for role_id since it will be read-only

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/layout', ['data' => $data, 'konten' => 'petugas/edit_petugas', 'notifikasi' => $this->msg]);
    } else {
      $nip = $this->input->post('nip');
      $name = $this->input->post('name');
      $email = $this->input->post('email');
      $no_telepon = $this->input->post('no_telepon');

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

      $this->db->set('nip', $nip);
      $this->db->set('name', $name);
      $this->db->set('no_telepon', $no_telepon);
      $this->db->set('is_profile_complete', 1); // Set is_profile_complete to 1
      $this->db->where('email', $email);
      $this->db->update('user');

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated!</div>');
      redirect('petugas');
    }
  }


  //END EDIT PROFILE//

  //CHANGE PASSWORD//

  public function changepassword()
  {
    $data['title'] = 'Change Password';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['unread_count'] = $this->unread_count;

    $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
    $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
    $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/layout', ['data' => $data, 'konten' => 'petugas/changepassword', 'notifikasi' => $this->msg]);
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
          redirect('petugas/changepassword');
        }
      }
    }
  }

  //END CHANGE PASSWORD//

  // CRUD for Bidang

  public function bidang()
  {
    $data['title'] = 'Isi Bidang';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['bidang'] = $this->bidang_model->getAllBidang();
    $data['unread_count'] = $this->unread_count;

    $this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/layout', ['data' => $data, 'konten' => 'petugas/bidang', 'notifikasi' => $this->msg]);
    } else {
      $data = [
        'nama_bidang' => $this->input->post('nama_bidang', true)
      ];

      $this->bidang_model->addBidang($data);
      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-success" role="alert">New bidang added!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button></div>'
      );
      redirect('petugas/bidang');
    }
  }

  public function deleteBidang($id)
  {
    $this->bidang_model->deleteBidang($id);
    $this->session->set_flashdata(
      'message',
      '<div class="alert alert-success" role="alert">Bidang has been deleted!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button></div>'
    );
    redirect('petugas/bidang');
  }

  public function editBidang()
  {
    $this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required');

    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-danger" role="alert">Failed to update bidang!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button></div>'
      );
      redirect('petugas/bidang');
    } else {
      $id = $this->input->post('id', true);
      $data = [
        'nama_bidang' => $this->input->post('nama_bidang', true)
      ];

      $this->bidang_model->updateBidang($id, $data);
      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-success" role="alert">Bidang has been updated!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button></div>'
      );
      redirect('petugas/bidang');
    }
  }

  // JENIS KEGIATAN

  public function jeniskegiatan()
  {
    $data['title'] = 'Isi Jenis Kegiatan';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['jeniskegiatan'] = $this->jeniskegiatan_model->getAllJeniskegiatan();
    $data['unread_count'] = $this->unread_count;

    $this->form_validation->set_rules('jeniskegiatan', 'Jenis Kegiatan', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/layout', ['data' => $data, 'konten' => 'petugas/jeniskegiatan', 'notifikasi' => $this->msg]);
    } else {
      $data = [
        'jeniskegiatan' => $this->input->post('jeniskegiatan', true)
      ];

      $this->jeniskegiatan_model->addJeniskegiatan($data);
      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-success" role="alert">New Jenis Kegiatan added!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button></div>'
      );
      redirect('petugas/jeniskegiatan');
    }
  }

  public function deleteJenisKegiatan($id)
  {
    $this->jeniskegiatan_model->deleteJeniskegiatan($id);
    $this->session->set_flashdata(
      'message',
      '<div class="alert alert-success" role="alert">Jenis Kegiatan has been deleted!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></div>'
    );
    redirect('petugas/jeniskegiatan');
  }

  public function editJenisKegiatan()
  {
    $this->form_validation->set_rules('jeniskegiatan', 'Jenis Kegiatan', 'required');

    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-danger" role="alert">Failed to update jenis kegiatan!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button></div>'
      );
      redirect('petugas/jeniskegiatan');
    } else {
      $id = $this->input->post('id', true);
      $data = [
        'jeniskegiatan' => $this->input->post('jeniskegiatan', true)
      ];

      $this->jeniskegiatan_model->updateJeniskegiatan($id, $data);
      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-success" role="alert">Jenis Kegiatan has been updated!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button></div>'
      );
      redirect('petugas/jeniskegiatan');
    }
  }

  //KEGIATAN TAMBAH

  public function kegiatantambah()
  {
    $data['title'] = 'Isi Kegiatan';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['unread_count'] = $this->unread_count;
    $data['sifat'] = $this->Sifat_model->getAllSifat(); // Get all sifat
    $data['level'] = $this->Level_model->getAllLevel(); // Get all level
    $data['kegiatantambah'] = $this->Kegiatantambah_model->getAllKegiatan();
    $data['jeniskegiatan'] = $this->jeniskegiatan_model->getAllJenisKegiatan(); // Get all jenis kegiatan
    $data['bidang'] = $this->bidang_model->getAllBidang(); // Get all bidang

    $this->form_validation->set_rules('nama_kegiatantambah', 'Nama Kegiatan', 'required|trim');
    $this->form_validation->set_rules('waktu', 'Waktu Pelaksanaan', 'required|trim');
    $this->form_validation->set_rules('id_jeniskegiatan', 'Jenis Kegiatan', 'required|trim');
    $this->form_validation->set_rules('id_sifat', 'Sifat', 'required|trim');
    $this->form_validation->set_rules('id_bidang', 'Bidang', 'required|trim');
    $this->form_validation->set_rules('id_level', 'Level', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/layout', ['data' => $data, 'konten' => 'petugas/kegiatantambah', 'notifikasi' => $this->msg]);
    } else {
      $newData = [
        'nama_kegiatantambah' => $this->input->post('nama_kegiatantambah'),
        'waktu' => $this->input->post('waktu'),
        // 'id_sifat' => 1, // Default to 'wajib'
        'id_sifat' => $this->input->post('id_sifat'),
        'id_jeniskegiatan' => $this->input->post('id_jeniskegiatan'),
        'id_bidang' => $this->input->post('id_bidang'),
        'id_level' => $this->input->post('id_level')
      ];

      $this->Kegiatantambah_model->addKegiatan($newData);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New kegiatan added!</div>');
      redirect('petugas/kegiatantambah');
    }
  }

  public function editKegiatan()
  {
    $data['title'] = 'Edit Kegiatan Tambah';

    $this->form_validation->set_rules('nama_kegiatantambah', 'Nama Kegiatan', 'required|trim');
    $this->form_validation->set_rules('waktu', 'Waktu Pelaksanaan', 'required|trim');
    $this->form_validation->set_rules('id_jeniskegiatan', 'Jenis Kegiatan', 'required|trim');
    $this->form_validation->set_rules('id_bidang', 'Bidang', 'required|trim');
    $this->form_validation->set_rules('id_level', 'Level', 'required|trim');
    $this->form_validation->set_rules('id_sifat', 'Sifat', 'required|trim');

    if ($this->form_validation->run() == false) {
      redirect('petugas/kegiatantambah');
    } else {
      $id = $this->input->post('id');
      $updatedData = [
        'nama_kegiatantambah' => $this->input->post('nama_kegiatantambah'),
        'waktu' => $this->input->post('waktu'),
        'id_sifat' => $this->input->post('id_sifat'),
        'id_jeniskegiatan' => $this->input->post('id_jeniskegiatan'),
        'id_level' => $this->input->post('id_level'),
        'id_bidang' => $this->input->post('id_bidang')
      ];

      $this->Kegiatantambah_model->updateKegiatan($id, $updatedData);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kegiatan updated!</div>');
      redirect('petugas/kegiatantambah');
    }
  }

  public function deleteKegiatan($id)
  {
    $this->Kegiatantambah_model->deleteKegiatan($id);
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kegiatan deleted!</div>');
    redirect('petugas/kegiatantambah');
  }
}
