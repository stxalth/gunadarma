<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_m extends CI_Model
{
    // start datatables
    var $column_order = array(null, 'username', 'level', null); //set column field database for datatable orderable
    var $column_search = array('username', 'level'); //set column field database for datatable searchable
    var $order = array('user_id' => 'asc'); // default order 

    private function _get_datatables_query()
    {
        $this->db->from('user'); //ini jangan sampe lupa
        $i = 0;
        foreach ($this->column_search as $user) { // loop column 
            if (@$_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($user, $_POST['search']['value']);
                } else {
                    $this->db->or_like($user, $_POST['search']['value']);
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
        $this->db->from('user');
        return $this->db->count_all_results();
    }
    // end datatables

    public function login($post)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username', $post['username']);
        $this->db->where('password', ($post['password'])); //tambahin "sha1" sesuai di databasenya untuk enkripsi
        $query = $this->db->get();
        return $query;
    }

    public function get($id = null)
    {
        $this->db->from('user');
        if ($id != null) {
            $this->db->where('user_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        // $params['sesuaiyangdifielddatabase'] = $post['sesuainameyangdiform'];
        $params['username'] = $post['username'];
        $params['password'] = ($post['password']); //ganti jadi sha1($post['password']) kalo butuh enkripsi
        $params['level'] = $post['level'];
        $this->db->insert('user', $params);
    }

    public function edit($post)
    {
        $params['username'] = $post['username'];
        // Jika bagian 'password' tidak kosong, maka post data ke database.
        if (!empty($post['password'])) {
            $params['password'] = ($post['password']); //ganti jadi sha1($post['password']) kalo butuh enkripsi
        }
        $params['level'] = $post['level'];
        $this->db->where('user_id', $post['user_id']); // tunjuk ke user_id
        $this->db->update('user', $params); // update data ke tabel 'user'
    }

    public function del($id)
    {
        $this->db->where('user_id', $id);
        $this->db->delete('user');
    }
}
