<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Programstudi_m extends CI_Model
{

    // start datatables
    var $column_order = array(null, 'kode', 'program', null); //set column field database for datatable orderable
    var $column_search = array('kode', 'program',); //set column field database for datatable searchable
    var $order = array('programstudi_id' => 'asc'); // default order 

    private function _get_datatables_query()
    {
        $this->db->from('programstudi');
        $i = 0;
        foreach ($this->column_search as $programstudi) { // loop column 
            if (@$_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($programstudi, $_POST['search']['value']);
                } else {
                    $this->db->or_like($programstudi, $_POST['search']['value']);
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
        $this->db->from('programstudi');
        return $this->db->count_all_results();
    }
    // end datatables

    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('programstudi');
        if ($id != null) {
            $this->db->where('programstudi_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function insert_batch($data)
    {
        $this->db->insert_batch('programstudi', $data);
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function add($post)
    {
        $params = [
            'kode' => $post['programstudi_kode'],
            'program' => $post['program'],
        ];
        $this->db->insert('programstudi', $params);
    }

    public function edit($post)
    {
        $params = [
            'kode' => $post['programstudi_kode'],
            'program' => $post['program'],
        ];
        $this->db->where('programstudi_id', $post['id']);
        $this->db->update('programstudi', $params);
    }

    public function del($id)
    {
        $this->db->where('programstudi_id', $id);
        $this->db->delete('programstudi');
    }
}
