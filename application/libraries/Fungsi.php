<?php

class Fungsi
{
    protected $ci;

    function __construct()
    {
        $this->ci = &get_instance();
    }

    function user_login()
    {
        $this->ci->load->model('user_m');
        $user_id = $this->ci->session->userdata('userid');
        $user_data = $this->ci->user_m->get($user_id)->row();
        return $user_data;
    }

    public function count_data($table)
    {
        return $this->ci->db->get($table)->num_rows();
    }
    public function get_internasional()
    {
        $this->ci->load->model('kegiatan_m');
        return $this->ci->kegiatan_m->get_internasional();
    }
    public function get_nasional()
    {
        $this->ci->load->model('kegiatan_m');
        return $this->ci->kegiatan_m->get_nasional();
    }
    public function get_provinsi()
    {
        $this->ci->load->model('kegiatan_m');
        return $this->ci->kegiatan_m->get_provinsi();
    }
    public function get_wilayah()
    {
        $this->ci->load->model('kegiatan_m');
        return $this->ci->kegiatan_m->get_wilayah();
    }
}
