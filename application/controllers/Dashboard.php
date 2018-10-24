<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent:: __construct();
        $this->load->model('setup/M_coa');
    }

    public function index()
    {
        if($this->session->userdata('username') == null){
            redirect('Login');
        }
        $data['company'] = $this->M_coa->get_company();
        $data['compTotal'] = $this->M_coa->count_company();
        $this->load->view('template/header');
        $this->load->view('template/dashboard', $data);
        $this->load->view('template/footer');
    }
}
