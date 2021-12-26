<?php defined('BASEPATH') or exit('No direct script access allowed');

class kegiatan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['kegiatan_m', 'mahasiswa_m']);
    }

    public function index()
    {
        $data['row'] = $this->kegiatan_m->get();
        $this->template->load('template', 'kegiatan/kegiatan_data', $data);
    }

    public function add()
    {
        $kegiatan = new stdClass();
        $kegiatan->kegiatan_id = null;
        $kegiatan->tahun = null;
        $kegiatan->kategori = null;
        $kegiatan->kepesertaan = null;
        $kegiatan->namakegiatan = null;
        $kegiatan->jmlpt = null;
        $kegiatan->jmlpeserta = null;
        $kegiatan->capaian = null;
        $kegiatan->tglmulai = null;
        $kegiatan->tglakhir = null;
        $kegiatan->sertifpiala = null;
        $kegiatan->url = null;
        $kegiatan->foto = null;
        $kegiatan->surattugas = null;
        $kegiatan->mahasiswa_id = null;

        $query_mahasiswa = $this->mahasiswa_m->get();
        $mahasiswa[null] = '-- Pilih --';
        foreach ($query_mahasiswa->result() as $mhs) {
            $mahasiswa[$mhs->mahasiswa_id] = $mhs->nama;
        }

        $data = array(
            'page' => 'add',
            'row' => $kegiatan,
            'mahasiswa' => $mahasiswa, 'selectedmhs' => null,
        );

        $this->template->load('template', 'kegiatan/kegiatan_form', $data);
    }

    public function edit()
    {
        $id = $this->input->post('id', true);
        $query = $this->kegiatan_m->get($id);
        if ($query->num_rows() > 0) {
            $kegiatan = $query->row();

            $query_mahasiswa = $this->mahasiswa_m->get();
            $mahasiswa[null] = '-- Pilih --';
            foreach ($query_mahasiswa->result() as $mhs) {
                $mahasiswa[$mhs->mahasiswa_id] = $mhs->nama;
            }

            $data = array(
                'page' => 'edit',
                'row' => $kegiatan,
                'mahasiswa' => $mahasiswa,
                'selectedmhs' => $kegiatan->mahasiswa_id,
            );

            $this->template->load('template', 'kegiatan/kegiatan_form', $data);
        } else {
            echo "<script>alert('Data tidak ditemukan');";
            echo "window.location='" . site_url('kegiatan') . "'</script>";
        }
    }

    public function process()
    {
        $post = $this->input->post(null, TRUE);
        if (isset($_POST['add'])) {
            $this->kegiatan_m->add($post);
        } else if (isset($_POST['edit'])) {
            $this->kegiatan_m->edit($post);
        }
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan');
        }
        redirect('kegiatan');
    }

    public function del($id)
    {
        $this->kegiatan_m->del($id);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
        }
        redirect('kegiatan');
    }
}
