<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
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
    $data['title'] = 'Dashboard Admin';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['unread_count'] = $this->unread_count;

    $this->load->view('templates/layout', ['data' => $data, 'konten' => 'admin/index', 'notifikasi' => $this->msg]);
  }

  public function role()
  {
    $data['title'] = 'Role';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['unread_count'] = $this->unread_count;

    $data['role'] = $this->db->get('user_role')->result_array();
    $this->load->view('templates/layout', ['data' => $data, 'konten' => 'admin/role', 'notifikasi' => $this->msg]);
  }

  public function roleAccess($role_id)
  {
    $data['title'] = 'Role Access';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['unread_count'] = $this->unread_count;

    $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

    // $this->db->where('id !=', 1);
    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->load->view('templates/layout', ['data' => $data, 'konten' => 'admin/role-access', 'notifikasi' => $this->msg]);
  }

  public function changeAccess()
  {
    $menu_id = $this->input->post('menuId');
    $role_id = $this->input->post('roleId');

    $data = [
      'role_id' => $role_id,
      'menu_id' => $menu_id
    ];

    $result = $this->db->get_where('user_access_menu', $data);

    if ($result->num_rows() < 1) {
      $this->db->insert('user_access_menu', $data);
    } else {
      $this->db->delete('user_access_menu', $data);
    }

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
  }

  public function addRole()
  {
    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() == false) {
      $this->role();
    } else {
      $data = ['role' => $this->input->post('role')];
      $this->db->insert('user_role', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New role added!</div>');
      redirect('admin/role');
    }
  }

  public function editRole($id)
  {
    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() == false) {
      $this->role();
    } else {
      $data = ['role' => $this->input->post('role')];
      $this->db->where('id', $id);
      $this->db->update('user_role', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role updated!</div>');
      redirect('admin/role');
    }
  }

  public function deleteRole($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_role');
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role deleted!</div>');
    redirect('admin/role');
  }
}
