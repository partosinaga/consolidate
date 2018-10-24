<?php

class M_profitloss extends CI_Model
{
    public function get_coa_income()
    {
        $data = $this->db->query("SELECT
                                  'Income' AS `group`,
                                  coa_id,
                                  coa_name
                                FROM
                                  coa
                                WHERE
                                  LEFT ( coa_id, 1 ) IN ( 5, 8 )");
        return $data->result();
    }

    public function get_income($period_from, $period_to)
    {
        $data = $this->db->query("SELECT
                                  cb.coa_id,
                                  c.coa_name,
                                   COALESCE( sum( cb.balance ),0 ) AS income
                                FROM
                                  closed_balance cb
                                  JOIN coa c ON c.coa_id = cb.coa_id
                                WHERE
                                  cb.date BETWEEN '" . $period_from . "' AND '" . $period_to . "'
                                  AND LEFT ( cb.coa_id, 1 ) = 5
                                GROUP BY
                                  cb.coa_id;");
        return $data->result();
    }

    public function get_other_income($period_from, $period_to)
    {
        $data = $this->db->query("SELECT
                                  cb.coa_id,
                                  c.coa_name,
                                  sum( cb.balance ) AS other_income
                                FROM
                                  closed_balance cb
                                  JOIN coa c ON c.coa_id = cb.coa_id
                                WHERE
                                  cb.date BETWEEN '" . $period_from . "' AND '" . $period_to . "'
                                  AND LEFT ( cb.coa_reff_id, 3 ) = 801
                                GROUP BY
                                  cb.coa_id");
        return $data->row();
    }


    public function get_coa_expense()
    {
        $data = $this->db->query("SELECT
                                  'Expense' AS `group`,
                                  coa_id,
                                  coa_name
                                FROM
                                  coa
                                WHERE
                                  LEFT ( coa_id, 1 ) IN ( 6, 7, 8, 9 )");
        return $data->result();
    }

    public function get_expense($period_from, $period_to)
    {
        $data = $this->db->query("SELECT
                                  cb.coa_id,
                                  c.coa_name,
                                  sum( cb.balance ) AS expense
                                FROM
                                  closed_balance cb
                                  JOIN coa c ON c.coa_id = cb.coa_id
                                WHERE
                                  cb.date BETWEEN '" . $period_from . "' AND '" . $period_to . "'
                                  AND LEFT ( cb.coa_id, 1 ) IN (6, 7, 9)
                                GROUP BY
                                  cb.coa_id");
        return $data->result();
    }

    public function get_other_expense($period_from, $period_to)
    {
        $data = $this->db->query("SELECT
                                  cb.coa_id,
                                  c.coa_name,
                                  sum( cb.balance ) AS other_expense
                                FROM
                                  closed_balance cb
                                  JOIN coa c ON c.coa_id = cb.coa_id
                                WHERE
                                  cb.date BETWEEN '" . $period_from . "' AND '" . $period_to . "'
                                  AND LEFT ( cb.coa_reff_id, 3 ) = 802
                                GROUP BY
                                  cb.coa_id");
        return $data->row();
    }
}