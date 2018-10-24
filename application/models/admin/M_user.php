<?php

class M_user extends CI_Model
{
    public function count_user(){
        $data = $this->db->query("
            SELECT
              count(user_id) as total
            FROM
              ms_user
        ");
        return $data->row();
    }

    function get_user_ajax($like = array(), $limit_row, $limit_start){
        $this->db->select('*');
        $this->db->from('ms_user');
        if(count($like) > 0){
            $this->db->like($like);
        }
        if($limit_row > 0){
            $this->db->limit($limit_row, $limit_start);
        }
        return $this->db->get();
    }

    public function get_edit($id){
        $data = $this->db->query("SELECT * FROM ms_user WHERE user_id = '".$id."' ");
        return $data->result();
    }

    public function save_edit($id, $us, $ps, $email, $status){
        $this->db->query("
            UPDATE ms_user SET username = '".$us."',
            password = '".$ps."',
            email = '".$email."',
            status = '".$status."'
            WHERE user_id = '".$id."'
        ");
    }
}