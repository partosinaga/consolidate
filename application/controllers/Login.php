<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Login extends CI_Controller
{
    function __construct()
    {
        parent:: __construct();
    }

    function index()
    {
        $this->load->view('login');
    }

    function login_post()
    {
        $result = array(
            'err' => '0',
            'message' => '',
            'link' => ''
        );
        $username = $_POST['username'];
        $password = $_POST['password'];

        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->where('status', '1');
        $check = $this->db->get('ms_user');
        if ($check->num_rows() > 0) {
            $logginData = array(
                'user_id' => $check->result_array()[0]['user_id'],
                'username' => $username,
                'password' => $password,
                'email' => $check->result_array()[0]['email'],
                'logged_in' => TRUE
            );
            $this->session->set_userdata($logginData);
            $log = array(
                'user_id' => $check->result_array()[0]['user_id'],
                'login_date' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('log_login', $log);
            $result['link'] = base_url('dashboard.gl');
        } else {
            $result['err'] = '1';
            $result['message'] = 'Wrong username or password.';
        }
        echo json_encode($result);
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}