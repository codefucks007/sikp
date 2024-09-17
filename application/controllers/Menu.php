<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
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
    $data['title'] = 'Menu Management';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['unread_count'] = $this->unread_count;

    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->form_validation->set_rules('menu', 'Menu', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/layout', ['data' => $data, 'konten' => 'menu/index', 'notifikasi' => $this->msg]);
    } else {
      $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-success" role="alert">New Menu has been added
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></div>'
      );
      redirect('menu');
    }
  }

  public function submenu()
  {
    $data['title'] = 'Sub Menu Management';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['unread_count'] = $this->unread_count;

    $this->load->model('Menu_model', 'menu');

    $data['subMenu'] = $this->menu->getSubMenu();
    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required');
    $this->form_validation->set_rules('url', 'URL', 'required');
    $this->form_validation->set_rules('icon', 'icon', 'required');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/layout', ['data' => $data, 'konten' => 'menu/submenu', 'notifikasi' => $this->msg]);
    } else {
      $data = [
        'title' => $this->input->post('title'),
        'menu_id' => $this->input->post('menu_id'),
        'url' => $this->input->post('url'),
        'icon' => $this->input->post('icon'),
        'is_active' => $this->input->post('is_active')
      ];
      $this->db->insert('user_sub_menu', $data);
      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-success" role="alert">New Sub Menu has been added
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></div>'
      );
      redirect('menu/submenu');
    }
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_menu');
    $this->session->set_flashdata(
      'message',
      '<div class="alert alert-success" role="alert">Menu has been deleted
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button></div>'
    );
    redirect('menu');
  }

  public function edit()
  {
    $this->form_validation->set_rules('menu', 'Menu', 'required');

    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-danger" role="alert">Failed to update menu
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></div>'
      );
    } else {
      $id = $this->input->post('id');
      $menu = $this->input->post('menu');
      $this->db->set('menu', $menu);
      $this->db->where('id', $id);
      $this->db->update('user_menu');

      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-success" role="alert">Menu has been updated
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></div>'
      );
    }
    redirect('menu');
  }

  public function deleteSubmenu($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_sub_menu');
    $this->session->set_flashdata(
      'message',
      '<div class="alert alert-success" role="alert">Submenu has been deleted
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></div>'
    );
    redirect('menu/submenu');
  }

  public function editSubmenu()
  {
    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required');
    $this->form_validation->set_rules('url', 'URL', 'required');
    $this->form_validation->set_rules('icon', 'Icon', 'required');

    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-danger" role="alert">Failed to update submenu
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button></div>'
      );
    } else {
      $id = $this->input->post('id');
      $data = [
        'title' => $this->input->post('title'),
        'menu_id' => $this->input->post('menu_id'),
        'url' => $this->input->post('url'),
        'icon' => $this->input->post('icon'),
        'is_active' => $this->input->post('is_active')
      ];
      $this->db->where('id', $id);
      $this->db->update('user_sub_menu', $data);

      $this->session->set_flashdata(
        'message',
        '<div class="alert alert-success" role="alert">Submenu has been updated
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button></div>'
      );
    }
    redirect('menu/submenu');
  }
}

/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */
