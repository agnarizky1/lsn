<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_model extends CI_Model
{
    public function getAllUser()
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('role_user', 'role_user.id_role = user.id_role', 'LEFT');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getAllUserById($id_user)
    {
        return $this->db->get_where('user', ['id_user' => $id_user])->row();
    }
    public function edit($data)
    {
        $this->db->where('id_user', $data['id_user']);
        $this->db->update('user', $data);
    }
}
