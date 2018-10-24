<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class User extends CI_Controller
{
    function __construct()
    {
        parent:: __construct();
        $this->data_header = array(
            'style' => array(),
        );
        $this->data_footer = array(
            'script' => array(),
        );
        $this->load->model('admin/M_user');
    }

    public function index(){
        $data_header = $this->data_header;
        $data_footer = $this->data_footer;
//
//        array_push($data_header['style'], base_url() . 'assets/global/plugins/select2/css/select2.min.css');
//        array_push($data_header['style'], base_url() . 'assets/global/plugins/select2/css/select2-bootstrap.min.css ');

        array_push($data_header['style'], base_url() . 'assets/global/plugins/datatables/datatables.min.css');
        array_push($data_header['style'], base_url() . 'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');

//        array_push($data_footer['script'], base_url() . 'assets/global/plugins/select2/js/select2.full.min.js');
//        array_push($data_footer['script'], base_url() . 'assets/pages/scripts/components-select2.min.js');

        array_push($data_footer['script'], base_url() . 'assets/global/scripts/datatable.js');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/datatables/datatables.min.js');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/bootbox/bootbox.min.js');


        $this->load->view('template/header', $data_header);
        $this->load->view('admin/user');
        $this->load->view('template/footer', $data_footer);
    }

    public function add_user(){
        $data['username'] = $_POST['username'];
        $data['password'] = $_POST['password'];
        $data['email'] = $_POST['email'];
        $data['status'] = 1;
        $this->db->insert('ms_user', $data);
        $this->session->set_flashdata('success', 'Success add new user');
        redirect('admin/user');
    }

    public function user_list(){
        $total = $this->M_user->count_user();
        $iTotalRecords = $total->total;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $records = array();
        $records["data"] = array();

        $like = array();
        if(isset($_REQUEST['order_username'])){
            if($_REQUEST['order_username'] != ''){
                $like['username'] = $_REQUEST['order_username'];
            }
        }
        if(isset($_REQUEST['order_email'])){
            if($_REQUEST['order_email'] != ''){
                $like['email'] = $_REQUEST['order_email'];
            }
        }
        if (isset($_REQUEST['order_status'])) {
            if ($_REQUEST['order_status'] != '') {
                echo $like['status'] = $_REQUEST['order_status'];
            }
        }
        $i = 1;
        $query = $this->M_user->get_user_ajax($like, $iDisplayLength, $iDisplayStart);
//        echo $this->db->last_query();
        foreach ($query->result() as $row) {
            if($row->status == 1){
                $stts = '<span class="label label-primary"> Active </span>';
            } else {
                $stts = '<span class="label label-danger"> Inactive </span>';
            }
            $records["data"][] = array(
                $i++,
                $row->username,
                $row->email,
                $stts,
                '<div class="btn-group btn-group-solid">
                  <a class="btn btn-xs green-meadow tooltips" data-original-title="Edit" data-placement="top" data-container="body" href="' . site_url('admin/user/get_edit?id=') . $row->user_id . '"> <i class="fa fa-edit"></i> </a>
                  <a class="btn btn-xs red-thunderbird btn-bootbox tooltips" data-original-title="Delete" data-placement="top" data-container="body" href="javascript:;" data-id="' . $row->user_id . '"> <i class="fa fa-times"></i> </a>
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


    public function user_delete()
    {
        $this->db->where('user_id', $_GET['id']);
        $this->db->delete('ms_user');
        $this->session->set_flashdata('success', 'Success delete user');
        redirect('admin/user');

    }

    public function get_edit()
    {
        $data_header = $this->data_header;
        $data_footer = $this->data_footer;
        array_push($data_header['style'], base_url() . 'assets/global/plugins/select2/css/select2.min.css');
        array_push($data_header['style'], base_url() . 'assets/global/plugins/select2/css/select2-bootstrap.min.css ');
        array_push($data_footer['script'], base_url() . 'assets/global/plugins/select2/js/select2.full.min.js');
        array_push($data_footer['script'], base_url() . 'assets/pages/scripts/components-select2.min.js');

        $id = $_GET['id'];
        $data['user'] = $this->M_user->get_edit($id);
        $this->load->view('template/header', $data_header);
        $this->load->view('admin/edit_user', $data);
        $this->load->view('template/footer', $data_footer);
    }

    public function save_edit(){
        $this->db->trans_begin();
        $id = $_POST['user_id'];
        $us = $_POST['username'];
        $ps = $_POST['password'];
        $email = $_POST['email'];
        $status = $_POST['status'];

        $this->M_user->save_edit($id, $us, $ps, $email, $status);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Failed to edit, try again later');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Success edit user');
        }

        redirect('admin/user');
    }
}
