<?php

class M_coa extends CI_Model
{
    public function get_company(){
        $data = $this->db->query("
            SELECT
              c.company_id,
              c.company_code,
              c.company_name,
              c.`database`
            FROM
              company_consolidate cc
              JOIN ms_company c ON c.company_id = cc.company_id
        ");
        return $data->result();
    }
    public function count_company(){
        $data = $this->db->query("
            SELECT
              count(c.company_code) as company_entity
            FROM
              company_consolidate cc
              JOIN ms_company c ON c.company_id = cc.company_id
        ");
        return $data->row();
    }
    public function get_coa(){
        $data = $this->db->query("SELECT * FROM coa");
        return $data->result();
    }

    function get_coa_ajax($like = array(), $limit_row, $limit_start){
        $this->db->select('*');
        $this->db->from('coa');
        if(count($like) > 0){
            $this->db->like($like);
        }
        if($limit_row > 0){
            $this->db->limit($limit_row, $limit_start);
        }
        return $this->db->get();
    }

    public function count_coa(){
        $data = $this->db->query("SELECT COUNT(coa_id) as coa_total FROM coa");
        return $data->row();
    }

    public function get_coa_detail($coa_id){
        $data = $this->db->query("
        SELECT
          cpy.company_name,
          cpy.company_code,
          cc.coa_id,
          cc.coa_reff_name,
          cc.coa_reff_id,
          c.coa_name
        FROM
          coa_consolidate cc
          JOIN coa c ON c.coa_id = cc.coa_id
          JOIN ms_company cpy ON cpy.company_id = cc.company_id
        WHERE c.coa_id = '".$coa_id."'
        ORDER BY
          cpy.company_code ASC, cc.coa_reff_id ASC
        ");
        return $data->result();
    }

    public function get_coa_edit_header($coa_id){
        $data = $this->db->query("
        SELECT * FROM coa WHERE coa_id = '".$coa_id."'
        ");
        return $data->result();
    }
    public function get_coa_edit($coa_id){
        $data = $this->db->query("
        SELECT
          c.coa_id,
          c.coa_name,
          cpy.company_id,
          cpy.company_code,
          cc.coa_reff_id,
          cc.coa_reff_name
        FROM
          coa_consolidate cc
          JOIN coa c ON c.coa_id = cc.coa_id
          JOIN ms_company cpy ON cpy.company_id = cc.company_id
        WHERE c.coa_id = '".$coa_id."'
        ");
        return $data->result();
    }

    public function delete_coa_header($coa_id){
        $this->db->query("DELETE FROM coa WHERE coa_id = '".$coa_id."'");
    }
    public function delete_coa_detail($coa_id){
        $this->db->query("DELETE FROM coa_consolidate WHERE coa_id = '".$coa_id."'");
    }
}

?>