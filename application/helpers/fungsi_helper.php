<?php

function check_already_login()
{
    $ci = &get_instance();
    $user_session = $ci->session->userdata('userid');
    if ($user_session) {
        redirect('dashboard');
    }
}

function check_not_login()
{
    $ci = &get_instance();
    $user_session = $ci->session->userdata('userid');
    if (!$user_session) {
        redirect('auth/login');
    }
}

function check_admin()
{
    $ci = &get_instance();
    // load library 'fungsi' maksudnya dari Fungsi.php  
    $ci->load->library('fungsi');
    // jika level user_login bukan 1, maka redirect ke page dashboard
    if ($ci->fungsi->user_login()->level != 1) {
        redirect('dashboard');
    }
}
