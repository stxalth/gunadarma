<?php defined('BASEPATH') or exit('No direct script access allowed');

class kegiatan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model(['kegiatan_m', 'mahasiswa_m']);
    }

    function get_ajax()
    {
        $list = $this->kegiatan_m->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $kegiatan) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $kegiatan->tahun;
            $row[] = $kegiatan->kategori;
            $row[] = $kegiatan->kepesertaan;
            $row[] = $kegiatan->namakegiatan;
            $row[] = $kegiatan->jmlpt;
            $row[] = $kegiatan->jmlpeserta;
            $row[] = $kegiatan->capaian;
            $row[] = $kegiatan->tglmulai;
            $row[] = $kegiatan->tglakhir;
            $row[] = $kegiatan->sertifpiala . '<br><a href="' . site_url('uploads/kegiatan/' . $kegiatan->sertifpiala) . '" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> Lihat</a>';
            $row[] = $kegiatan->url;
            $row[] = $kegiatan->foto  != null ? '<img src="' . base_url('uploads/kegiatan/' . $kegiatan->foto) . '" class="img" style="width:100px">' : null;
            $row[] = $kegiatan->surattugas . '<br><a href="' . site_url('uploads/kegiatan/' . $kegiatan->surattugas) . '" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> Lihat</a>';
            $row[] = $kegiatan->mhs_npm;
            $row[] = $kegiatan->mhs_nama;
            $row[] = $kegiatan->program_studi;
            $row[] = $kegiatan->mhs_angkatan;
            // add html for action
            $row[] = '<a href="' . site_url('kegiatan/edit/' . $kegiatan->kegiatan_id) . '" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Update</a>
                    <a href="' . site_url('kegiatan/del/' . $kegiatan->kegiatan_id) . '" onclick="return confirm(\'Yakin hapus data?\')"  class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->kegiatan_m->count_all(),
            "recordsFiltered" => $this->kegiatan_m->count_filtered(),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
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

    public function edit($id)
    {
        // $id = $this->input->post('id', true);
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
        $config['upload_path']      = './uploads/kegiatan/';
        $config['allowed_types']    = 'gif|jpg|png|jpeg|pdf';
        $config['max_size']         = 10000;
        $config['file_name']        = 'mahasiswa-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);
        $this->load->library('upload', $config);

        $post = $this->input->post(null, TRUE);
        if (isset($_POST['add'])) {
            // $this->kegiatan_m->add($post);
            if (@$_FILES['foto']['name'] != null) {
                if ($this->upload->do_upload('foto')) {
                    $post['foto'] = $this->upload->data('file_name');
                    // $this->kegiatan_m->add($post); 
                    // if ($this->db->affected_rows() > 0) {
                    //     $this->session->set_flashdata('success', 'Data berhasil disimpan');
                    // }
                    // Bentuk aslinya kaya yg di atas.
                    // yang di atas itu kalo cuma masukin 1 file, taronya di sini (Line 93-96)
                } else {
                    $error = $this->upload->display_error();
                    $this->session->set_flashdata('error', $error);
                    redirect('kegiatan/add');
                }
            }

            if (@$_FILES['sertifpiala']['name'] != null) {
                if ($this->upload->do_upload('sertifpiala')) {
                    $post['sertifpiala'] = $this->upload->data('file_name');
                    // $this->kegiatan_m->add($post);
                } else {
                    $error = $this->upload->display_error();
                    $this->session->set_flashdata('error', $error);
                    redirect('kegiatan/add');
                }
            }

            if (@$_FILES['surattugas']['name'] != null) {
                if ($this->upload->do_upload('surattugas')) {
                    $post['surattugas'] = $this->upload->data('file_name');
                    // $this->kegiatan_m->add($post);
                } else {
                    $error = $this->upload->display_error();
                    $this->session->set_flashdata('error', $error);
                    redirect('kegiatan/add');
                }
            } else {
                $post['sertifpiala'] = null;
                $post['foto'] = null;
                $post['surattugas'] = null;
                $this->kegiatan_m->add($post);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('success', 'Data berhasil disimpan');
                }
                redirect('kegiatan');
            }
            // nah ini karena kita masukin 3 file dalam 1 row, jadi kodingan yg dibawah masukin di sini.
            $this->kegiatan_m->add($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data berhasil disimpan');
            }
            redirect('kegiatan');
        } else if (isset($_POST['edit'])) {
            // $this->kegiatan_m->edit($post);
            if (@$_FILES['foto']['name'] != null) {
                if ($this->upload->do_upload('foto')) {
                    $kegiatan = $this->kegiatan_m->get($post['id'])->row();
                    if ($kegiatan->foto != null) {
                        $target_file = './uploads/kegiatan/' . $kegiatan->foto;
                        unlink($target_file);
                    }
                    $post['foto'] = $this->upload->data('file_name');
                    // $this->kegiatan_m->edit($post);
                    // if ($this->db->affected_rows() > 0) {
                    //     $this->session->set_flashdata('success', 'Data berhasil disimpan');
                    // }
                    // redirect('kegiatan'); 
                    // kodingan yg dikomen di atas pindah ke line 213-217
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect('kegiatan/edit');
                }
            }
            if (@$_FILES['sertifpiala']['name'] != null) {
                if ($this->upload->do_upload('sertifpiala')) {
                    $kegiatan = $this->kegiatan_m->get($post['id'])->row();
                    if ($kegiatan->sertifpiala != null) {
                        $target_file = './uploads/kegiatan/' . $kegiatan->sertifpiala;
                        unlink($target_file);
                    }
                    $post['sertifpiala'] = $this->upload->data('file_name');
                    // $this->kegiatan_m->edit($post);
                    // if ($this->db->affected_rows() > 0) {
                    //     $this->session->set_flashdata('success', 'Data berhasil disimpan');
                    // }
                    // redirect('kegiatan');
                    // kodingan yg dikomen di atas pindah ke line 213-217
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect('kegiatan/edit');
                }
            }
            if (@$_FILES['surattugas']['name'] != null) {
                if ($this->upload->do_upload('surattugas')) {
                    $kegiatan = $this->kegiatan_m->get($post['id'])->row();
                    if ($kegiatan->surattugas != null) {
                        $target_file = './uploads/kegiatan/' . $kegiatan->surattugas;
                        unlink($target_file);
                    }
                    $post['surattugas'] = $this->upload->data('file_name');
                    // $this->kegiatan_m->edit($post);
                    // if ($this->db->affected_rows() > 0) {
                    //     $this->session->set_flashdata('success', 'Data berhasil disimpan');
                    // }
                    // redirect('kegiatan');
                    // kodingan yg dikomen di atas pindah ke line 213-217
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect('kegiatan/edit');
                }
            } else {
                $post['foto'] = null;
                $post['sertifpiala'] = null;
                $post['surattugas'] = null;
                $this->kegiatan_m->edit($post);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('success', 'Data berhasil disimpan');
                }
                redirect('kegiatan');
            }
            $this->kegiatan_m->edit($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data berhasil disimpan');
            }
            redirect('kegiatan');
        }
    }

    public function del($id)
    {
        $kegiatan = $this->kegiatan_m->get($id)->row();
        if ($kegiatan->foto != null) {
            $target_file = './uploads/kegiatan/' . $kegiatan->foto;
            unlink($target_file);
        }
        if ($kegiatan->sertifpiala != null) {
            $target_file = './uploads/kegiatan/' . $kegiatan->sertifpiala;
            unlink($target_file);
        }
        if ($kegiatan->surattugas != null) {
            $target_file = './uploads/kegiatan/' . $kegiatan->surattugas;
            unlink($target_file);
        }
        $this->kegiatan_m->del($id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
        }
        redirect('kegiatan');
    }
}
