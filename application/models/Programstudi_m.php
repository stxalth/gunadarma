<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Programstudi_m extends CI_Model
{
    public function get($id = null)
    {
        $this->db->from('programstudi');
        if ($id != null) {
            $this->db->where('programstudi_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $params = [
            'kode' => $post['programstudi_kode'],
            'program' => $post['program'],
        ];
        $this->db->insert('programstudi', $params);
    }

    public function edit($post)
    {
        $params = [
            'kode' => $post['programstudi_kode'],
            'program' => $post['program'],
        ];
        $this->db->where('programstudi_id', $post['id']);
        $this->db->update('programstudi', $params);
    }

    public function del($id)
    {
        $this->db->where('programstudi_id', $id);
        $this->db->delete('programstudi');
    }
}
