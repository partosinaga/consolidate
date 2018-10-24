<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Company extends CI_Controller
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
        $this->load->model('setup/M_company');
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
        array_push($data_header['style'], base_url() . 'assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');

        array_push($data_footer['script'], base_url() . 'assets/global/scripts/datatable.js');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/datatables/datatables.min.js');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/bootbox/bootbox.min.js');

        $this->load->view('template/header', $data_header);
        $this->load->view('setup/company/company');
        $this->load->view('template/footer', $data_footer);
    }

    public function add()
    {
        $data['company_code'] = $_POST['company_code'];
        $data['company_name'] = $_POST['company_name'];
        $data['database'] = $_POST['database'];
        $this->db->insert('ms_company', $data);
        $this->session->set_flashdata('success', 'Success add new company');
        redirect('setup/Company');
    }

    public function company_list()
    {
        $total = $this->M_company->count_data();
        $iTotalRecords = $total->total;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $records = array();
        $records["data"] = array();

        $like = array();
        if(isset($_REQUEST['order_company_code'])){
            if($_REQUEST['order_company_code'] != ''){
                $like['company_code'] = $_REQUEST['order_company_code'];
            }
        }
        if(isset($_REQUEST['order_company_name'])){
            if($_REQUEST['order_company_name'] != ''){
                $like['company_name'] = $_REQUEST['order_company_name'];
            }
        }
        if (isset($_REQUEST['order_database'])) {
            if ($_REQUEST['order_database'] != '') {
                $like['database'] = $_REQUEST['order_database'];
            }
        }

        $i = 1;
        $query = $this->M_company->get_company_ajax($like, $iDisplayLength, $iDisplayStart);
        foreach ($query->result() as $row) {
            $records["data"][] = array(
                $i++,
                $row->company_code,
                $row->company_name,
                $row->database,
                '<div class="btn-group btn-group-solid">
                  <a class="btn btn-xs green-meadow tooltips" data-original-title="Edit" data-placement="top" data-container="body" href="' . site_url('setup/company/get_edit?id=') . $row->company_id . '"> <i class="fa fa-edit"></i> </a>
                  <a class="btn btn-xs red-thunderbird btn-bootbox tooltips" data-original-title="Delete" data-placement="top" data-container="body" href="javascript:;" data-id="' . $row->company_id . '"> <i class="fa fa-times"></i> </a>
                </div>'
            );
        }

        if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
            $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        echo json_encode($records);
    }

    public function company_delete()
    {
        $this->db->where('company_id', $_GET['id']);
        $this->db->delete('ms_company');
        $this->session->set_flashdata('success', 'Success delete company');
        redirect('setup/company');

    }

    public function get_edit()
    {
        if($this->session->userdata('username') == null){
            redirect('Login');
        }
        $id = $_GET['id'];
        $data['company'] = $this->M_company->get_edit($id);
        $this->load->view('template/header');
        $this->load->view('setup/company/company_edit', $data);
        $this->load->view('template/footer');
    }

    public function save_edit()
    {
        $this->db->trans_begin();
        $id = $_POST['id'];
        $comp_code = $_POST['company_code'];
        $comp_name = $_POST['company_name'];
        $db = $_POST['database'];
        $this->M_company->save_edit($id, $comp_code, $comp_name, $db);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Failed to edit, try again later');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Success edit company');
        }
        redirect('setup/company');
    }

    public function company_setup()
    {
        if($this->session->userdata('username') == null){
            redirect('Login');
        }
        $row = $this->M_company->count_project();
        if (count($row->result()) >= 1) { //IF PROJECT EXIST
            $data['project'] = $this->M_company->count_project();
            $data['consolidate'] = $this->M_company->get_consolidate();
            $this->load->view('template/header');
            $this->load->view('setup/company/consolidate_info', $data);
            $this->load->view('template/footer');
        } else { //NOT EXIST
            $datax['company'] = $this->M_company->get_company();
            $this->load->view('template/header');
            $this->load->view('setup/company/company_setup', $datax);
            $this->load->view('template/footer');
        }

    }

    public function add_company_consolidate()
    {
        $this->db->trans_begin();

        $data['project_name'] = $_POST['project_name'];
        $this->db->insert('ms_project', $data);

        $proj_id = $this->M_company->get_new_project($data['project_name']);

        $comp_id = $this->input->post('company_id');
        $datax = array();
        for ($i = 0; $i < count($comp_id); $i++) {
            $datax[$i] = array(
                'project_id' => $proj_id->project_id,
                'company_id' => $comp_id[$i],
            );
        }
        $this->db->insert_batch('company_consolidate', $datax);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Failed to save, try again later');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Success edit company');
        }
        redirect('setup/company/company_setup');
    }

    public function get_edit_project()
    {
        if($this->session->userdata('username') == null){
            redirect('Login');
        }
        $data['project'] = $this->M_company->count_project();
        $data['consolidate'] = $this->M_company->get_consolidate();
        $data['company'] = $this->M_company->get_company();
        $this->load->view('template/header');
        $this->load->view('setup/company/setup_edit', $data);
        $this->load->view('template/footer');
    }


    public function save_edit_setup()
    {
        $this->db->trans_begin();
        //1.remove from ms_project & ms_company
        $this->M_company->delete_project();
        $this->M_company->delete_consolidate();
        //2. Re-entry
        //2.1 to ms_project
        $data['project_name'] = $_POST['project_name'];
        $this->db->insert('ms_project', $data);
        //2.2 to consolidate_company
        $proj_id = $this->M_company->get_new_project($data['project_name']);

        $comp_id = $this->input->post('company_id');
        $datax = array();
        for ($i = 0; $i < count($comp_id); $i++) {
            $datax[$i] = array(
                'project_id' => $proj_id->project_id,
                'company_id' => $comp_id[$i],
            );
        }
        $this->db->insert_batch('company_consolidate', $datax);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Failed to edit, try again later');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Success edit project');
        }
        redirect('setup/company/company_setup');
    }
}