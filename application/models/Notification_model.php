<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification_model extends CI_Model
{

    public function get_unread_count($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('is_read', 0);
        return $this->db->count_all_results('notifications');
    }

    public function add_notification($user_id, $message)
    {
        $data = [
            'user_id' => $user_id,
            'message' => $message,
            'is_read' => 0, // 0 berarti notifikasi belum dibaca
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('notifications', $data);
    }

    public function get_notifications_by_user($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('is_read', 0);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('notifications');
        return $query->result_array();
    }

    public function mark_as_read($notification_id)
    {
        $this->db->set('is_read', 1);
        $this->db->where('id', $notification_id);
        $this->db->update('notifications');
    }

    public function mark_all_as_read($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->update('notifications', ['is_read' => 1]);
    }
}
