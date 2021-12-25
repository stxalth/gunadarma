<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa_m extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('mahasiswa.*, programstudi.program as program_studi');
        $this->db->join('programstudi', 'programstudi.programstudi_id = mahasiswa.programstudi_id');
        $this->db->from('mahasiswa');
        if ($id != null) {
            $this->db->where('mahasiswa_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $params = [
            'npm' => $post['npm'],
            'nama' => $post['nama'],
            'programstudi_id' => $post['programstudi'],
            'angkatan' => $post['angkatan'],
        ];
        $this->db->insert('mahasiswa', $params);
    }

    public function edit($post)
    {
        $params = [
            'npm' => $post['npm'],
            'nama' => $post['nama'],
            'programstudi_id' => $post['programstudi'],
            'angkatan' => $post['angkatan'],
        ];
        $this->db->where('mahasiswa_id', $post['id']);
        $this->db->update('mahasiswa', $params);
    }

    public function del($id)
    {
        $this->db->where('mahasiswa_id', $id);
        $this->db->delete('mahasiswa');
    }
}
