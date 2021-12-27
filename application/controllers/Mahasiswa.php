<?php defined('BASEPATH') or exit('No direct script access allowed');

class mahasiswa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['mahasiswa_m', 'programstudi_m']);
    }

    function get_ajax()
    {
        $list = $this->mahasiswa_m->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $mahasiswa) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $mahasiswa->npm;
            $row[] = $mahasiswa->nama;
            $row[] = $mahasiswa->program_studi;
            $row[] = $mahasiswa->angkatan;
            // add html for action
            $row[] = '<a href="' . site_url('mahasiswa/edit/' . $mahasiswa->mahasiswa_id) . '" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Update</a>
                    <a href="' . site_url('mahasiswa/del/' . $mahasiswa->mahasiswa_id) . '" onclick="return confirm(\'Yakin hapus data?\')"  class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->mahasiswa_m->count_all(),
            "recordsFiltered" => $this->mahasiswa_m->count_filtered(),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
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
