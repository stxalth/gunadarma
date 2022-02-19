<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require 'assets/vendor/autoload.php';

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
        $mahasiswa->programstudi_id = null;

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

    public function spreadsheet()
    {
        $query_mahasiswa = $this->mahasiswa_m->get_datatables();

        $object = new Spreadsheet();
        $object->getProperties()->setCreator('Gunadarma');
        $object->getProperties()->setLastModifiedBy('Gunadarma');
        $object->getProperties()->setTitle('Daftar Mahasiswa');

        $object->setActiveSheetIndex(0);

        $object->getActiveSheet()->setCellValue('A1', 'NO.');
        $object->getActiveSheet()->setCellValue('B1', 'NPM');
        $object->getActiveSheet()->setCellValue('C1', 'NAMA');
        $object->getActiveSheet()->setCellValue('D1', 'PROGRAM STUDI');
        $object->getActiveSheet()->setCellValue('E1', 'ANGKATAN');

        $baris = 2;
        $no = 1;

        foreach ($query_mahasiswa as $mahasiswa) {
            $object->getActiveSheet()->setCellValue('A' . $baris, $no++);
            $object->getActiveSheet()->setCellValue('B' . $baris, $mahasiswa->npm);
            $object->getActiveSheet()->setCellValue('C' . $baris, $mahasiswa->nama);
            $object->getActiveSheet()->setCellValue('D' . $baris, $mahasiswa->program_studi);
            $object->getActiveSheet()->setCellValue('E' . $baris, $mahasiswa->angkatan);

            $baris++;
        }

        $filename = 'Daftar Mahasiswa-' . date('y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer = new Xlsx($object);
        $writer = IOFactory::createWriter($object, 'Xlsx');
        $writer->save('php://output');


        exit;
    }

    // public function spreadsheet_import()
    // {
    //     $upload_file = $$_FILES['upload_file']['name'];
    //     $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
    //     if ($extension == 'csv') {
    //         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    //     } else if ($extension == 'xls') {
    //         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    //     } else {
    //         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    //     }
    //     $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
    //     $sheetdata = $spreadsheet->getActiveSheet()->toArray();
    //     $sheetcount = count($sheetdata);
    //     if ($sheetcount > 1) {
    //         $data = array();
    //         $no = 1;
    //         for ($i = 1; $i < $sheetcount; $i++) {
    //             $no++;
    //             $npm = $sheetdata[$i][1];
    //             $nama = $sheetdata[$i][2];
    //             $programstudi = $sheetdata[$i][3];
    //             $angkatan = $sheetdata[$i][4];
    //             $data[] = array(
    //                 'npm' => $npm,
    //                 'nama' => $nama,
    //                 'programstudi_id' => $programstudi,
    //                 'angkatan' => $angkatan,
    //             );
    //         }
    //         $inserdata = $this->mahasiswa_m->insert_batch($data);
    //         if ($inserdata) {
    //             $this->session->set_flashdata('success', 'Data berhasil disimpan');
    //             redirect('mahasiswa');
    //         } else {
    //             $this->session->set_flashdata('message', 'Data tidak dipload. Mohon coba lagi');
    //             redirect('mahasiswa');
    //         }
    //     }
    // }

    public function del($id)
    {
        $this->mahasiswa_m->del($id);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
        }
        redirect('mahasiswa');
    }
}
