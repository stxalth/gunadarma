<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kegiatan_m extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('kegiatan.*, mahasiswa.npm as mhs_npm, mahasiswa.nama as mhs_nama, mahasiswa.programstudi_id as mhs_program, mahasiswa.angkatan as mhs_angkatan');
        $this->db->select('mahasiswa.*, programstudi.program as program_studi');
        $this->db->join('mahasiswa', 'mahasiswa.mahasiswa_id = kegiatan.mahasiswa_id');
        $this->db->join('programstudi', 'programstudi.programstudi_id = mahasiswa.programstudi_id');
        $this->db->from('kegiatan');
        if ($id != null) {
            $this->db->where('kegiatan_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $params = [
            'tahun' => $post['tahun'],
            'kategori' => $post['kategori'],
            'kepesertaan' => $post['kepesertaan'],
            'namakegiatan' => $post['namakegiatan'],
            'jmlpt' => $post['jmlpt'],
            'jmlpeserta' => $post['jmlpeserta'],
            'capaian' => $post['capaian'],
            'tglmulai' => $post['tglmulai'],
            'tglakhir' => $post['tglakhir'],
            'sertifpiala' => $post['sertifpiala'],
            'url' => $post['url'],
            'foto' => $post['foto'],
            'surattugas' => $post['surattugas'],
            'mahasiswa_id' => $post['mahasiswa'],
        ];
        $this->db->insert('kegiatan', $params);
    }

    public function edit($post)
    {
        $params = [
            'tahun' => $post['tahun'],
            'kategori' => $post['kategori'],
            'kepesertaan' => $post['kepesertaan'],
            'namakegiatan' => $post['namakegiatan'],
            'jmlpt' => $post['jmlpt'],
            'jmlpeserta' => $post['jmlpeserta'],
            'capaian' => $post['capaian'],
            'tglmulai' => $post['tglmulai'],
            'tglakhir' => $post['tglakhir'],
            'sertifpiala' => $post['sertifpiala'],
            'url' => $post['url'],
            'foto' => $post['foto'],
            'surattugas' => $post['surattugas'],
            'mahasiswa_id' => $post['mahasiswa'],
        ];
        $this->db->where('kegiatan_id', $post['id']);
        $this->db->update('kegiatan', $params);
    }

    public function del($id)
    {
        $this->db->where('kegiatan_id', $id);
        $this->db->delete('kegiatan');
    }
}
