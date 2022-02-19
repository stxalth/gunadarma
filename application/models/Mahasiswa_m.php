<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa_m extends CI_Model
{

    // start datatables
    var $column_order = array(null, 'npm', 'nama', 'program_studi', 'angkatan', null); //set column field database for datatable orderable
    var $column_search = array('npm', 'nama', 'angkatan', 'program'); //set column field database for datatable searchable
    var $order = array('mahasiswa_id' => 'asc'); // default order 

    private function _get_datatables_query()
    {
        $this->db->select('mahasiswa.*, programstudi.program as program_studi');
        $this->db->from('mahasiswa');
        $this->db->join('programstudi', 'programstudi.programstudi_id = mahasiswa.programstudi_id');
        $i = 0;
        foreach ($this->column_search as $mahasiswa) { // loop column 
            if (@$_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($mahasiswa, $_POST['search']['value']);
                } else {
                    $this->db->or_like($mahasiswa, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables()
    {
        $this->_get_datatables_query();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all()
    {
        $this->db->from('mahasiswa');
        return $this->db->count_all_results();
    }
    // end datatables

    public function get($id = null)
    {
        $this->db->select('mahasiswa.*, programstudi.program as program_studi');
        $this->db->join('programstudi', 'programstudi.programstudi_id = mahasiswa.programstudi_id');
        $this->db->from('mahasiswa');
        if ($id != null) {
            $this->db->where('mahasiswa_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function insert_batch($data)
    {
        $this->db->insert_batch('mahasiswa', $data);
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function add($post)
    {
        $params = [
            'npm' => $post['npm'],
            'nama' => $post['nama'],
            'programstudi_id' => $post['programstudi'],
            'angkatan' => $post['angkatan'],
        ];
        $this->db->insert('mahasiswa', $params);
    }

    public function edit($post)
    {
        $params = [
            'npm' => $post['npm'],
            'nama' => $post['nama'],
            'programstudi_id' => $post['programstudi'],
            'angkatan' => $post['angkatan'],
        ];
        $this->db->where('mahasiswa_id', $post['id']);
        $this->db->update('mahasiswa', $params);
    }

    public function del($id)
    {
        $this->db->where('mahasiswa_id', $id);
        $this->db->delete('mahasiswa');
    }
}
