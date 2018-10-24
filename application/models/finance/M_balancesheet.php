<?php

class M_balancesheet extends CI_Model
{

    public function clear_closed_balance()
    {
        $this->db->query("DELETE FROM closed_balance");
    }

    public function insert_closed_balance()
    {
        $company = $this->db->query("SELECT * FROM ms_company");
        foreach ($company->result() as $com) {
            $this->db->query("INSERT INTO closed_balance (company_id, `date`, coa_id, coa_reff_id, balance)
                            SELECT
                              cc.company_id,
                              src.date,
                              cc.coa_id,
                              cc.coa_reff_id,
                              src.saldo  AS balance
                            FROM
                              " . $com->database . ".closed_saldo src
                              JOIN coa_consolidate cc ON src.coa_id = cc.coa_reff_id
                              JOIN coa c ON c.coa_id = cc.coa_id
                            WHERE
                              cc.company_id = " . $com->company_id . "
                              ");

        }
    }

    public function get_coa_asset()
    {
        $data = $this->db->query("
            SELECT
              'Asset' as `group`,
              coa_id,
              coa_name
            FROM
              coa
              where LEFT(coa_id, 1) = 1
        ");
        return $data->result();
    }

    public function get_asset($period)
    {
        $data = $this->db->query("SELECT
                                      cb.coa_id,
                                      c.coa_name,
                                      sum( cb.balance ) AS balance
                                    FROM
                                      closed_balance cb
                                      JOIN coa c ON c.coa_id = cb.coa_id
                                    WHERE
                                      cb.date <= '" . $period . "'
                                      AND LEFT ( cb.coa_id, 1 ) = 1
                                    GROUP BY
                                      cb.coa_id");
        return $data->result();
    }

    public function get_coa_liability()
    {
        $data = $this->db->query("SELECT
                                  'Liability' AS `group`,
                                  coa_id,
                                  coa_name
                                FROM
                                  coa
                                WHERE
                                  LEFT ( coa_id, 1 ) IN ( 2, 3, 4) ");
        return $data->Result();
    }

    public function get_liability($period)
    {
        $data = $this->db->query("SELECT
                                  cb.coa_id,
                                  c.coa_name,
                                  sum( cb.balance ) AS balance
                                FROM
                                  closed_balance cb
                                  JOIN coa c ON c.coa_id = cb.coa_id
                                WHERE
                                  cb.date <= '" . $period . "'
                                  AND LEFT ( cb.coa_id, 1 ) IN ( 2, 3, 4)
                                GROUP BY
                                  cb.coa_id");
        return $data->result();
    }

    public function get_labaditahan($labaditahan_period)
    {
        $data = $this->db->query(" CALL laba_ditahan('" . $labaditahan_period . "' ) ");
        mysqli_next_result($this->db->conn_id);
        return $data->row();

    }

    public function get_lababerjalan($lababerjalan_period_from, $period)
    {
        $data = $this->db->query(" CALL laba_berjalan('" . $lababerjalan_period_from . "', '" . $period . "' ) ");
        mysqli_next_result($this->db->conn_id);
        return $data->row();

    }

}