<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require 'assets/vendor/autoload.php';

class Programstudi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('programstudi_m');
    }

    function get_ajax()
    {
        $list = $this->programstudi_m->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $programstudi) {
            $no++;
            $row = array();
            $row[] = $no . ".";
            $row[] = $programstudi->kode;
            $row[] = $programstudi->program;
            // add html for action
            $row[] = '<a href="' . site_url('programstudi/edit/' . $programstudi->programstudi_id) . '" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Update</a>
                    <a href="' . site_url('programstudi/del/' . $programstudi->programstudi_id) . '" onclick="return confirm(\'Yakin hapus data?\')"  class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->programstudi_m->count_all(),
            "recordsFiltered" => $this->programstudi_m->count_filtered(),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
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

    //silahkan disesuaikan dengan tabelnya
    public function spreadsheet()
    {
        $programstudi = $this->programstudi_m->get_datatables();

        $object = new Spreadsheet();
        $object->getProperties()->setCreator('Gunadarma');
        $object->getProperties()->setLastModifiedBy('Gunadarma');
        $object->getProperties()->setTitle('Program Studi');

        $object->setActiveSheetIndex(0);

        $object->getActiveSheet()->setCellValue('A1', 'NO.');
        $object->getActiveSheet()->setCellValue('B1', 'KODE');
        $object->getActiveSheet()->setCellValue('C1', 'PROGRAM');

        $baris = 2;
        $no = 1;

        foreach ($programstudi as $studi) {
            $object->getActiveSheet()->setCellValue('A' . $baris, $no++);
            $object->getActiveSheet()->setCellValue('B' . $baris, $studi->kode);
            $object->getActiveSheet()->setCellValue('C' . $baris, $studi->program);

            $baris++;
        }

        $filename = 'Program Studi-' . date('y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer = new Xlsx($object);
        $writer = IOFactory::createWriter($object, 'Xlsx');
        $writer->save('php://output');


        exit;
    }

    public function spreadsheet_import()
    {
        $upload_file = $_FILES['upload_file']['name'];
        $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
        if ($extension == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
        $sheetdata = $spreadsheet->getActiveSheet()->toArray();
        $sheetcount = count($sheetdata);
        if ($sheetcount > 1) {
            $data = array();
            $no = 1;
            for ($i = 1; $i < $sheetcount; $i++) {
                $no++;
                $kode = (int)$sheetdata[$i][1];
                $program = $sheetdata[$i][2];
                $data[] = array(
                    'kode' => $kode,
                    'program' => $program,
                );
            }
            $inserdata = $this->programstudi_m->insert_batch($data);
            if ($inserdata) {
                $this->session->set_flashdata('success', 'Data berhasil disimpan');
                redirect('programstudi');
            } else {
                $this->session->set_flashdata('message', 'Data tidak diupload. Mohon coba lagi');
                redirect('programstudi');
            }
        }
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
