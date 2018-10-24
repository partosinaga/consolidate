<?php

class M_trialbalance extends CI_Model
{
    public function get_ms_coa(){
        $data = $this->db->query("
          SELECT
            c.*,
            cc.coa_reff_id,
            cc.coa_reff_name,
            cc.company_id
          FROM
            coa c
            JOIN coa_consolidate cc ON cc.coa_id = c.coa_id
          GROUP BY coa_reff_id
        ");
        return $data->result();
    }
}