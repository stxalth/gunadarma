<?php defined('BASEPATH') or exit('No direct script access allowed');

class mahasiswa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['mahasiswa_m', 'programstudi_m']);
    }

    public function index()
    {
        $data['row'] = $this->mahasiswa_m->get();
        $this->template->load('template', 'mahasiswa/mahasiswa_data', $data);
    }

    public function add()
    {
        $mahasiswa = new stdClass();
        $mahasiswa->mahasiswa_id = null;
        $mahasiswa->npm = null;
        $mahasiswa->nama = null;
        $mahasiswa->angkatan = null;

        $query_programstudi = $this->programstudi_m->get();
        $programstudi[null] = '-- Pilih --';
        foreach ($query_programstudi->result() as $studi) {
            $programstudi[$studi->programstudi_id] = $studi->program;
        }

        $data = array(
            'page' => 'add',
            'row' => $mahasiswa,
            'programstudi' => $programstudi, 'selectedprogram' => null,
        );

        $this->template->load('template', 'mahasiswa/mahasiswa_form', $data);
    }

    public function edit($id)
    {
        $query = $this->mahasiswa_m->get($id);
        if ($query->num_rows() > 0) {
            $mahasiswa = $query->row();

            $query_programstudi = $this->programstudi_m->get();
            $programstudi[null] = '-- Pilih --';
            foreach ($query_programstudi->result() as $studi) {
                $programstudi[$studi->programstudi_id] = $studi->program;
            }

            $data = array(
                'page' => 'edit',
                'row' => $mahasiswa,
                'programstudi' => $programstudi,
                'selectedprogram' => $mahasiswa->programstudi_id,
            );

            $this->template->load('template', 'mahasiswa/mahasiswa_form', $data);
        } else {
            echo "<script>alert('Data tidak ditemukan');";
            echo "window.location='" . site_url('mahasiswa') . "'</script>";
        }
    }

    public function process()
    {
        $post = $this->input->post(null, TRUE);
        if (isset($_POST['add'])) {
            $this->mahasiswa_m->add($post);
        } else if (isset($_POST['edit'])) {
            $this->mahasiswa_m->edit($post);
        }
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan');
        }
        redirect('mahasiswa');
    }

    public function del($id)
    {
        $this->mahasiswa_m->del($id);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
        }
        redirect('mahasiswa');
    }
}
