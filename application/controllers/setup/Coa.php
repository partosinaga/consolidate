<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coa extends CI_Controller
{
//    public $dynamicDB;

    function __construct()
    {
        parent::__construct();
        $this->data_header = array(
            'style' => array(),
        );
        $this->data_footer = array(
            'script' => array(),
        );
        $this->load->model('setup/M_coa');
    }

    public function index()
    {
        if($this->session->userdata('username') == null){
            redirect('Login');
        }
        $data_header = $this->data_header;
        $data_footer = $this->data_footer;

        array_push($data_header['style'], base_url() . 'assets/global/plugins/datatables/datatables.min.css');
        array_push($data_header['style'], base_url() . 'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');
        array_push($data_header['style'], base_url() . 'assets/pages/css/faq.min.css');
        array_push($data_header['style'], base_url() . 'assets/global/plugins/ladda/ladda-themeless.min.css'); //button loading

        array_push($data_header['style'], base_url() . 'assets/global/plugins/datatables/datatables.min.css'); //ajax datatable
        array_push($data_header['style'], base_url() . 'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css'); //ajax datatable
        array_push($data_header['style'], base_url() . 'assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); //ajax datatable

        array_push($data_footer['script'], base_url() . 'assets/global/scripts/datatable.js');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/datatables/datatables.min.js');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js');
        array_push($data_footer['script'], base_url() . 'assets/pages/scripts/table-datatables-managed.js');

        array_push($data_footer['script'], base_url() . 'assets/global/plugins/ladda/spin.min.js');//button loading
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/ladda/ladda.min.js');//button loading
        array_push($data_footer['script'], base_url() . 'assets/pages/scripts/ui-buttons.min.js');//button loading
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');//ajax datatable
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/bootbox/bootbox.min.js');

        $data['company'] = $this->M_coa->get_company();
        $data['compTotal'] = $this->M_coa->count_company();
        $data['coa'] = $this->M_coa->get_coa();
        $this->load->view('template/header', $data_header);
        $this->load->view('setup/coa/coa', $data);
        $this->load->view('template/footer', $data_footer);
    }


    public function add_coa()
    {
        $this->db->trans_begin();

        $data['coa_id'] = $_POST['coa_code'];
        $data['coa_name'] = $_POST['coa_name'];
        $this->db->insert('coa', $data);

        $company_id = $_POST['company_id'];
        $coa_reff_code = $_POST['coa_reff_code'];
        $coa_reff_name = $_POST['coa_reff_name'];

        $datax = array();
        for ($i = 0; $i < count($company_id); $i++) {
            $datax[$i] = array(
                'coa_id' => $data['coa_id'],
                'company_id' => $company_id[$i],
                'coa_reff_id' => $coa_reff_code[$i],
                'coa_reff_name' => $coa_reff_name[$i],
            );
        }
        $this->db->insert_batch('coa_consolidate', $datax);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo $this->session->flashdata('error', 'Failed, Try Again');
        } else {
            $this->db->trans_commit();
            echo $this->session->flashdata('success', 'Succed add new COA');
        }
    }

    public function coa_list()
    {
        $ttl = $this->M_coa->count_coa();
        $iTotalRecords = $ttl->coa_total;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $records = array();
        $records["data"] = array();


        $like = array();
        if(isset($_REQUEST['order_coa_code'])){
            if($_REQUEST['order_coa_code'] != ''){
                $like['coa_id'] = $_REQUEST['order_coa_code'];
            }
        }
        if(isset($_REQUEST['order_coa_name'])){
            if($_REQUEST['order_coa_name'] != ''){
                $like['coa_name'] = $_REQUEST['order_coa_name'];
            }
        }


        $qry = $this->M_coa->get_coa_ajax($like, $iDisplayLength, $iDisplayStart);

        $i = $iDisplayStart + 1;
        foreach ($qry->result() as $row) {
            $records["data"][] = array(
                $i . '.',
                $row->coa_id,
                $row->coa_name,
                '<div class="btn-group">
                    <button class="btn green-meadow btn-xs dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">
                        <i class="fa fa-hand-pointer-o"></i>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="javascript:;" coa-id="' . $row->coa_id . '" coa-name="' . $row->coa_name . '" class="view">
                            <i class="fa fa-search"></i> View
                            </a>
                        </li>
                        <li>
                            <a href="' . site_url('setup/coa/get_coa_edit?id=') . $row->coa_id . '">
                            <i class="fa fa-edit"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" coa-id="' . $row->coa_id . '" class="remove">
                            <i class="fa fa-trash-o"></i> Delete
                            </a>
                        </li>
                    </ul>
				        </div>'
            );
            $i++;
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        echo json_encode($records);
    }

    public function coa_detail()
    {
        if (isset($_POST["id"])) {
            $coa_id = $_POST['id'];
            $qry = $this->M_coa->get_coa_detail($coa_id);
            $group = '';
            $result = '';
            foreach ($qry as $row) {
                if ($group != $row->company_code) {
                    $result .= '<tr >
                            <td colspan="2">' . $row->company_code . ' - ' . $row->company_name . '</td>
                          </tr>';
                    $group = $row->company_code;
                } else {
                    $result .= '';
                }
                $result .= '<tr>
                <td align="center"></td>
                <td>' . $row->coa_reff_id . ' | ' . $row->coa_reff_name . '</td>
                </tr>';
            }
            echo $result;
        }
    }

    public function coa_delete()
    {
        $this->db->trans_begin();

        $this->db->where('coa_id', $_GET['id']);
        $this->db->delete('coa');

        $this->db->where('coa_id', $_GET['id']);
        $this->db->delete('coa_consolidate');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Failed to save, try again later');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Success delete COA');
        }
        redirect('setup/coa');

    }

    public function get_coa_edit()
    {
        if($this->session->userdata('username') == null){
            redirect('Login');
        }
        $data_header = $this->data_header;
        $data_footer = $this->data_footer;
        array_push($data_header['style'], base_url() . 'assets/global/plugins/datatables/datatables.min.css');
        array_push($data_header['style'], base_url() . 'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');
        array_push($data_header['style'], base_url() . 'assets/global/plugins/ladda/ladda-themeless.min.css'); //button loading


        array_push($data_footer['script'], base_url() . 'assets/global/scripts/datatable.js');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/datatables/datatables.min.js');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js');
        array_push($data_footer['script'], base_url() . 'assets/pages/scripts/table-datatables-managed.js');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/ladda/spin.min.js');//button loading
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/ladda/ladda.min.js');//button loading
        array_push($data_footer['script'], base_url() . 'assets/pages/scripts/ui-buttons.min.js');//button loading
        $coa_id = $_GET['id'];
        $data['company'] = $this->M_coa->get_company();
        $data['compTotal'] = $this->M_coa->count_company();


        $data['header'] = $this->M_coa->get_coa_edit_header($coa_id);
        $data['detail'] = $this->M_coa->get_coa_edit($coa_id);

        $this->load->view('template/header', $data_header);
        $this->load->view('setup/coa/coa_edit', $data);
        $this->load->view('template/footer', $data_footer);

    }

    public function save_edit_coa(){
        $this->db->trans_begin();


        if($_POST['coa_code_old'] == $_POST['coa_code']){
            //1. remove existing row
            $this->M_coa->delete_coa_header($_POST['coa_code_old']);
            $this->M_coa->delete_coa_detail($_POST['coa_code_old']);
            //2. re-entry
            $data['coa_id'] = $_POST['coa_code'];
            $data['coa_name'] = $_POST['coa_name'];
            $result = $this->db->insert('coa', $data);

            $company_id = $_POST['company_id'];
            $coa_reff_code = $_POST['coa_reff_code'];
            $coa_reff_name = $_POST['coa_reff_name'];

            $datax = array();
            for ($i = 0; $i < count($company_id); $i++) {
                $datax[$i] = array(
                    'coa_id' => $data['coa_id'],
                    'company_id' => $company_id[$i],
                    'coa_reff_id' => $coa_reff_code[$i],
                    'coa_reff_name' => $coa_reff_name[$i],
                );
            }
            $result = $this->db->insert_batch('coa_consolidate', $datax);
        }else{
            $valid = $this->M_coa->get_coa_edit_header($_POST['coa_code']);
            if(count($valid) > 0){
                $result = 'COA Found!';
            }else{
                //1. remove existing row
                $this->M_coa->delete_coa_header($_POST['coa_code_old']);
                $this->M_coa->delete_coa_detail($_POST['coa_code_old']);
                //2. re-entry
                $data['coa_id'] = $_POST['coa_code'];
                $data['coa_name'] = $_POST['coa_name'];
                $result = $this->db->insert('coa', $data);

                $company_id = $_POST['company_id'];
                $coa_reff_code = $_POST['coa_reff_code'];
                $coa_reff_name = $_POST['coa_reff_name'];

                $datax = array();
                for ($i = 0; $i < count($company_id); $i++) {
                    $datax[$i] = array(
                        'coa_id' => $data['coa_id'],
                        'company_id' => $company_id[$i],
                        'coa_reff_id' => $coa_reff_code[$i],
                        'coa_reff_name' => $coa_reff_name[$i],
                    );
                }
                $result = $this->db->insert_batch('coa_consolidate', $datax);
            }
        }
        echo json_decode($result);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->flashdata('error', 'Failed, Try Again');
        } else {
            $this->db->trans_commit();
            $this->session->flashdata('success', 'Succed edit COA');
        }

    }
}
