<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Balancesheet extends CI_Controller
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
        $this->load->model('finance/M_balancesheet');
        $this->load->model('setup/M_coa');

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

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Failed to get database source, Call IT Team!');
        }
        else
        {
            $this->db->trans_commit();
        }
        $this->load->view('template/header', $data_header);
        $this->load->view('finance/balancesheet/form');
        $this->load->view('template/footer', $data_footer);
    }

    public function generate()
    {
        $data['tittle'] = 'Balance Sheet';
        $month = $_GET['month'];
        $year = $_GET['year'];
        $date = $year . "-" . $month;
        $last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ",last day of this month");
        $period = date("Y-m-d", $last_date_find);

        $labaditahan_period = ($year - 1).'-12-31';

        $lababerjalan_period_from = $year.'-01-01';

        $data['coa_asset'] = $this->M_balancesheet->get_coa_asset();
        $data['asset'] = $this->M_balancesheet->get_asset($period);

        $data['coa_liability'] = $this->M_balancesheet->get_coa_liability();
        $data['liability'] = $this->M_balancesheet->get_liability($period);

        $data['laba_ditahan'] = $this->M_balancesheet->get_labaditahan($labaditahan_period);
        $data['laba_berjalan'] = $this->M_balancesheet->get_lababerjalan($lababerjalan_period_from, $period);

        $data['company'] = $this->M_coa->get_company();
        $data['month'] = $month;
        $data['year'] = $year;
        $this->load->view('template/report_header', $data);
        $this->load->view('finance/balancesheet/balancesheet', $data);
        $this->load->view('template/report_footer');
    }
}