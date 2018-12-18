<?php

class M_company extends CI_Model
{

    public function count_data()
    {
        $data = $this->db->query("SELECT COUNT(company_id) as total FROM ms_company");
        return $data->row();
    }

    public function get_company()
    {
        $data = $this->db->query("SELECT * FROM ms_company");
        return $data->result();
    }
    public function get_company_ajax($like = array(), $iDisplayLength, $iDisplayStart)
    {
        $this->db->select('*');
        $this->db->from('ms_company');
        if(count($like)> 0){
            $this->db->like($like);
        }
        if($iDisplayLength >0 ){
            $this->db->limit($iDisplayLength, $iDisplayStart);
        }
        return $this->db->get();
    }

    public function get_edit($id)
    {
        $data = $this->db->query("SELECT * FROM ms_company WHERE company_id = '" . $id . "'");
        return $data->result();
    }

    public function save_edit($id, $comp_code, $comp_name, $db)
    {
        $this->db->query("
            UPDATE ms_company SET
            company_code = '".$comp_code."',
            company_name = '".$comp_name."',
            `database` = '".$db."'
            WHERE company_id = '".$id."'
        ");
    }
    public function get_new_project($id)
    {
        $data = $this->db->query("SELECT * FROM ms_project WHERE project_name = '" . $id . "'");
        return $data->row();
    }
    public function count_project()
    {
        $data = $this->db->query("SELECT * FROM ms_project");
        return $data;
    }

    public function get_consolidate()
    {
        $data = $this->db->query("
        SELECT
          cc.company_id,
          comp.company_code,
          comp.company_name,
          comp.database
        FROM
          company_consolidate cc
          JOIN ms_company comp ON comp.company_id = cc.company_id
        ");
        return $data->result();
    }

    public function delete_project(){
        $this->db->query("DELETE FROM ms_project");
    }

    public function delete_consolidate(){
        $this->db->query("DELETE FROM company_consolidate");
    }
}

?>