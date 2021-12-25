<?php defined('BASEPATH') or exit('No direct script access allowed');

class Programstudi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('programstudi_m');
    }

    public function index()
    {
        $data['row'] = $this->programstudi_m->get();
        $this->template->load('template', 'programstudi/programstudi_data', $data);
    }

    public function add()
    {
        $programstudi = new stdClass();
        $programstudi->programstudi_id = null;
        $programstudi->kode = null;
        $programstudi->program = null;
        $data = array(
            'page' => 'add',
            'row' => $programstudi
        );

        $this->template->load('template', 'programstudi/programstudi_form', $data);
    }

    public function edit($id)
    {
        $query = $this->programstudi_m->get($id);
        if ($query->num_rows() > 0) {
            $programstudi = $query->row();
            $data = array(
                'page' => 'edit',
                'row' => $programstudi
            );
            $this->template->load('template', 'programstudi/programstudi_form', $data);
        } else {
            echo "<script>alert('Data tidak ditemukan');";
            echo "window.location='" . site_url('programstudi') . "'</script>";
        }
    }

    public function process()
    {
        $post = $this->input->post(null, TRUE);
        if (isset($_POST['add'])) {
            $this->programstudi_m->add($post);
        } else if (isset($_POST['edit'])) {
            $this->programstudi_m->edit($post);
        }
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan');
        }
        redirect('programstudi');
    }

    public function del($id)
    {
        $this->programstudi_m->del($id);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
        }
        redirect('programstudi');
    }
}
