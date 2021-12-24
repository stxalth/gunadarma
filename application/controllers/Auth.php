<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{
    public function login()
    {
        check_already_login();
        $this->load->view('login');
    }
    public function process()
    {
        $post = $this->input->post(null, TRUE);
        if (isset($post['login'])) {
            $this->load->model('user_m'); //harus di-load biar ga error
            $query = $this->user_m->login($post);
            //kondisi ketika benar, maka session akan diproses, lalu masuk ke dashboard

            if ($query->num_rows() > 0) {
                //membuat session dengan mengambil array dari database
                $row = $query->row();
                $params = array(
                    //nama isi dari $row harus sesuai dengan yang di database
                    'userid' => $row->user_id, // sesuai
                    'level' => $row->level,    // sesuai
                );
                //mencetak session
                $this->session->set_userdata($params);

                //directing
                echo "<script>
                    window.location='" . site_url('dashboard') . "';
                </script>";

                //ketika salah, maka session tidak perlu dicetak dan kembali ke page login
            } else {
                echo "<script>
                    alert('Username / Password salah');
                    window.location='" . site_url('auth/login') . "';
                </script>";
            }
        }
    }

    public function logout()
    {
        $params = array('userid', 'level');
        $this->session->unset_userdata($params);
        redirect('auth/login');
    }
}
