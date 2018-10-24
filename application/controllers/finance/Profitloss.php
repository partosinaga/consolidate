<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Profitloss extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data_header = array(
            'style' => array(),
        );
        $this->data_footer = array(
            'script' => array(),
        );
        $this->load->model('finance/M_profitloss');
        $this->load->model('finance/M_balancesheet');
    }

    public function index()
    {
        if ($this->session->userdata('username') == null) {
            redirect('Login');
        }
        $this->db->trans_begin();
        $data_header = $this->data_header;
        $data_footer = $this->data_footer;
        array_push($data_header['style'], base_url() . 'assets/global/plugins/select2/css/select2.min.css');
        array_push($data_header['style'], base_url() . 'assets/global/plugins/select2/css/select2-bootstrap.min.css');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/select2/js/select2.full.min.js');
        array_push($data_footer['script'], base_url() . 'assets/pages/scripts/components-select2.min.js');


        //remove every balance sheet form opened
        $this->M_balancesheet->clear_closed_balance();
        //import from source databse to closed_balance
        $this->M_balancesheet->insert_closed_balance();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Failed to get database source, Call IT Team!');
        } else {
            $this->db->trans_commit();
        }
        $this->load->view('template/header', $data_header);
        $this->load->view('finance/profitloss/form');
        $this->load->view('template/footer', $data_footer);
    }

    public function generate()
    {
        $data['tittle'] = 'Profit & Loss Statement';
        $month = $_GET['month'];
        $year = $_GET['year'];
        $date = $year . "-" . $month;
        $first_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month");
        $period_from = date("Y-m-d",$first_date_find);

        $last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
        $period_to = date("Y-m-d",$last_date_find);

        $data['coa_income'] = $this->M_profitloss->get_coa_income();
        $data['income'] = $this->M_profitloss->get_income($period_from, $period_to);
        $data['other_income'] = $this->M_profitloss->get_other_income($period_from, $period_to);

        $data['coa_expense'] = $this->M_profitloss->get_coa_expense();
        $data['expense'] = $this->M_profitloss->get_expense($period_from, $period_to);
        $data['other_expense'] = $this->M_profitloss->get_other_expense($period_from, $period_to);

        $data['month'] = $month;
        $data['year'] = $year;
        $this->load->view('template/report_header', $data);
        $this->load->view('finance/profitloss/profitloss', $data);
        $this->load->view('template/report_footer');
    }


}