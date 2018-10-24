<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Trialbalance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data_header = array(
            'style' => array()
        );
        $this->data_footer = array(
            'script' => array()
        );
        $this->load->model('setup/M_coa');
        $this->load->model('finance/M_trialbalance');
    }

    public function index()
    {
        if ($this->session->userdata('username') == null) {
            redirect('Login');
        }
        $data_header = $this->data_header;
        $data_footer = $this->data_footer;
        array_push($data_header['style'], base_url() . 'assets/global/plugins/select2/css/select2.min.css');
        array_push($data_header['style'], base_url() . 'assets/global/plugins/select2/css/select2-bootstrap.min.css');

        array_push($data_footer['script'], base_url() . 'assets/global/plugins/select2/js/select2.full.min.js');
        array_push($data_footer['script'], base_url() . 'assets/pages/scripts/components-select2.min.js');


        $data['company'] = $this->M_coa->get_company();


        $this->load->view('template/header', $data_header);
        $this->load->view('finance/trialbalance/form', $data);
        $this->load->view('template/footer', $data_footer);
    }

    public function generate()
    {
        $data['tittle'] = 'Trial Balance';
        $month = $_GET['month'];
        $year = $_GET['year'];

        $date = $year . "-" . $month;

        $last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ",last day of this month");
        $data['period'] = date("Y-m-d", $last_date_find);

        $data['company'] = $this->M_coa->get_company();
        $data['tot_company'] = $this->M_coa->count_company();
        $data['month'] = $month;
        $data['year'] = $year;

        $data['main_coa'] = $this->M_trialbalance->get_ms_coa();
        $this->load->view('template/report_header', $data);
        $this->load->view('finance/trialbalance/trialbalance', $data);
        $this->load->view('template/report_footer');
    }
}