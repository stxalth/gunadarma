<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            $row[] = $kegiatan->sertifpiala != null ? '<br><a href="' . site_url('uploads/kegiatan/' . $kegiatan->sertifpiala) . '" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> Lihat</a>' : null;
            $row[] = $kegiatan->url;
            $row[] = $kegiatan->foto  != null ? '<img src="' . base_url('uploads/kegiatan/' . $kegiatan->foto) . '" class="img" style="width:85px">' : null;
            $row[] = $kegiatan->surattugas != null ? '<br><a href="' . site_url('uploads/kegiatan/' . $kegiatan->surattugas) . '" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> Lihat</a>' : null;
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
        $query_mahasiswa = $this->mahasiswa_m->get();
        foreach ($query_mahasiswa->result() as $mhs) {
            $mahasiswa[$mhs->mahasiswa_id] = $mhs->nama;
        }

        $config['upload_path']      = './uploads/kegiatan/';
        $config['allowed_types']    = 'gif|jpg|png|jpeg|pdf';
        $config['max_size']         = 10000;
        $config['file_name']        = 'mahasiswa-' . $mhs->nama . date('ymd') . '-' . substr(md5(rand()), 0, 10);
        $this->load->library('upload', $config);

        $post = $this->input->post(null, TRUE);
        if (isset($_POST['add'])) {
            // $this->kegiatan_m->add($post);
            if (@$_FILES['foto']['name'] != null) {
                if ($this->upload->do_upload('foto')) {
                    $post['foto'] = $this->upload->data('file_name');
                } else {
                    $error = $this->upload->display_error();
                    $this->session->set_flashdata('error', $error);
                    redirect('kegiatan/add');
                }
            } else {
                $post['foto'] = null;
            }

            if (@$_FILES['sertifpiala']['name'] != null) {
                if ($this->upload->do_upload('sertifpiala')) {
                    $post['sertifpiala'] = $this->upload->data('file_name');
                } else {
                    $error = $this->upload->display_error();
                    $this->session->set_flashdata('error', $error);
                    redirect('kegiatan/add');
                }
            } else {
                $post['sertifpiala'] = null;
            }

            if (@$_FILES['surattugas']['name'] != null) {
                if ($this->upload->do_upload('surattugas')) {
                    $post['surattugas'] = $this->upload->data('file_name');
                } else {
                    $error = $this->upload->display_error();
                    $this->session->set_flashdata('error', $error);
                    redirect('kegiatan/add');
                }
            } else {
                $post['surattugas'] = null;
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
                    $this->kegiatan_m->edit($post);
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
                    $this->kegiatan_m->edit($post);
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
                    $this->kegiatan_m->edit($post);
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

    public function spreadsheet()
    {
        $query_kegiatan = $this->kegiatan_m->get_datatables();

        require 'assets/vendor/autoload.php';

        $object = new Spreadsheet();
        $object->getProperties()->setCreator('Gunadarma');
        $object->getProperties()->setLastModifiedBy('Gunadarma');
        $object->getProperties()->setTitle('Daftar Kegiatan');

        $object->setActiveSheetIndex(0);

        $object->getActiveSheet()->setCellValue('A1', 'NO.');
        $object->getActiveSheet()->setCellValue('B1', 'TAHUN');
        $object->getActiveSheet()->setCellValue('C1', 'KATEGORI');
        $object->getActiveSheet()->setCellValue('D1', 'KEPESERTAAN');
        $object->getActiveSheet()->setCellValue('E1', 'NAMA KEGIATAN');
        $object->getActiveSheet()->setCellValue('F1', 'JUMLAH PERGURUAN TINGGI');
        $object->getActiveSheet()->setCellValue('G1', 'JUMLAH PESERTA');
        $object->getActiveSheet()->setCellValue('H1', 'CAPAIAN');
        $object->getActiveSheet()->setCellValue('I1', 'TANGGAL MULAI');
        $object->getActiveSheet()->setCellValue('J1', 'TANGGAL AKHIR');
        $object->getActiveSheet()->setCellValue('K1', 'SERTIFIKAT/PIALA');
        $object->getActiveSheet()->setCellValue('L1', 'URL');
        $object->getActiveSheet()->setCellValue('M1', 'FOTO');
        $object->getActiveSheet()->setCellValue('N1', 'SURAT TUGAS');
        $object->getActiveSheet()->setCellValue('O1', 'NPM');
        $object->getActiveSheet()->setCellValue('P1', 'NAMA');
        $object->getActiveSheet()->setCellValue('Q1', 'PROGRAM STUDI');
        $object->getActiveSheet()->setCellValue('R1', 'ANGKATAN');

        $baris = 2;
        $no = 1;

        foreach ($query_kegiatan as $kegiatan) {
            $object->getActiveSheet()->setCellValue('A' . $baris, $no++);
            $object->getActiveSheet()->setCellValue('B' . $baris, $kegiatan->tahun);
            $object->getActiveSheet()->setCellValue('C' . $baris, $kegiatan->kategori);
            $object->getActiveSheet()->setCellValue('D' . $baris, $kegiatan->kepesertaan);
            $object->getActiveSheet()->setCellValue('E' . $baris, $kegiatan->namakegiatan);
            $object->getActiveSheet()->setCellValue('F' . $baris, $kegiatan->jmlpt);
            $object->getActiveSheet()->setCellValue('G' . $baris, $kegiatan->jmlpeserta);
            $object->getActiveSheet()->setCellValue('H' . $baris, $kegiatan->capaian);
            $object->getActiveSheet()->setCellValue('I' . $baris, $kegiatan->tglmulai);
            $object->getActiveSheet()->setCellValue('J' . $baris, $kegiatan->tglakhir);
            $object->getActiveSheet()->setCellValue('K' . $baris, $kegiatan->sertifpiala);
            $object->getActiveSheet()->setCellValue('L' . $baris, $kegiatan->url);
            $object->getActiveSheet()->setCellValue('M' . $baris, $kegiatan->foto);
            $object->getActiveSheet()->setCellValue('N' . $baris, $kegiatan->surattugas);
            $object->getActiveSheet()->setCellValue('O' . $baris, $kegiatan->mhs_npm);
            $object->getActiveSheet()->setCellValue('P' . $baris, $kegiatan->mhs_nama);
            $object->getActiveSheet()->setCellValue('Q' . $baris, $kegiatan->program_studi);
            $object->getActiveSheet()->setCellValue('R' . $baris, $kegiatan->mhs_angkatan);

            $baris++;
        }

        $filename = 'Daftar Kegiatan-' . date('y-m-d') . '.xlsx';

        $object->getActiveSheet()->setTitle('Daftar Kegiatan');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer = new Xlsx($object);
        $writer = IOFactory::createWriter($object, 'Xlsx');
        $writer->save('php://output');


        exit;
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
