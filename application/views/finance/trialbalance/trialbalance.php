<div class="report-head">
    <p>TRIAL BALANCE</p>

    <p id="ammount">Amounts in (IDR)</p>

    <p>As Of <?php echo date("F Y", mktime(0, 0, 0, $month, 1, $year)); ?></p>
    <hr style="border-top: 2px double black">
</div>
<div>
    <table class="table table-bordered table-hover">
        <?php
        $cpmy_group = '';
        //HEADER
        echo '<thead><tr>
                  <td colspan="2" style="font-weight: bold; text-align: center">CONSOLIDATE</td>';
        foreach ($company as $comp) {
            echo '<td colspan="2" style="font-weight: bold; text-align: center">' . strtoupper($comp->company_name) . '</td>';

        }
        echo '<td rowspan="2" style="font-weight: bold">TOTAL BALANCE</td>';
        echo '</tr>';


        echo '<tr>';
        foreach ($company as $comp) {
            if ($cpmy_group == '') {
                echo '<th style="font-weight: bold; text-align: center; width: 100px">COA</th>
                      <th style="font-weight: bold">DESCRIPTION</th>';
            }
            $cpmy_group = $comp->company_id;
            if ($cpmy_group == $comp->company_id) {
                echo '<th style="font-weight: bold; text-align: center">COA</th>
                      <th style="font-weight: bold; text-align: right">BALANCE</th>';
            }
        }
        echo '</tr></thead>';
        //END OF HEADER
        ?>

        <?php
        $colspan = $tot_company->company_entity * 2 + 2;
        $sub_balance = 0;
        $tot_balance = 0;
        $footer_id = '';
        $footer_desc = '';
        $i=0;
        foreach ($main_coa as $coa) {
            $cpmy_group = '';
            if($footer_id != $coa->coa_id){
                if($footer_id != ''){
                    echo '<tr>
                                <td colspan="'.$colspan.'" style="font-style:italic; text-align:right; color: #4B8DF8; font-weight:bold">TOTAL BALANCE '.$footer_id ." | ".$footer_desc.'</td>
                                <td style="text-align:right; font-style:italic; color: #4B8DF8; font-weight:bold">'.number_format($tot_balance).'</td>
                            </tr>';
                    $tot_balance = 0;
                }
            }
            echo '<tbody><tr>';
            foreach ($company as $comp) {
                $coa_reff_sql = "SELECT
                                  cc.*
                                FROM
                                  coa_consolidate cc
                                  where cc.company_id = " . $comp->company_id . " ";
                $coa_reff_result = $this->db->query($coa_reff_sql);
                $balance_sql = "SELECT
                          cd.date,
                          c.name_coa,
                          cd.coa_id,
                          sum( cd.saldo ) AS balance
                        FROM
                          " . $comp->database . ".closed_saldo cd
                          JOIN " . $comp->database . ".coa c ON c.coa_id = cd.coa_id
                        WHERE
                          cd.date <= '".$period."'
                        GROUP BY
                          cd.coa_id";
                $balance_result = $this->db->query($balance_sql);
                foreach ($balance_result->result() as $blc) {//TO GET BALANCE EACH COA
                    if ($blc->coa_id == $coa->coa_reff_id) {
                        $balance = $blc->balance;
                        break;
                    } else {
                        $balance = 0;
                    }
                }
                foreach ($coa_reff_result->result() as $crr) { //TO GET COA DESCRIPTION
                    if ($crr->coa_reff_id == $coa->coa_reff_id) {
                        $identity = $coa->coa_reff_id;
                        break;
                    } else {
                        $identity = "-";
                    }
                }
                if ($cpmy_group == '') {
                    echo '<td align="center">' . $coa->coa_id . '</td>
                          <td>' . $coa->coa_name . '</td>';
                }
                $cpmy_group = $comp->company_id;
                echo '<td align="center">' . $identity . '</td>
                      <td align="right" style="background-color:#fafafa">' . number_format($balance) . '</td>';

                $sub_balance = $sub_balance + $balance; //TO GET SUBTOTAL BALANCE
                $tot_balance = $tot_balance + $balance;
            }
            echo '<td align="right" style="font-weight: bold; ">' . number_format($sub_balance) . '</td>';
            echo '</tr></tbody>';
            $sub_balance = 0;
            $footer_id = $coa->coa_id;
            $footer_desc = $coa->coa_name;
            $i++;
            if($i == count($main_coa)){
                if($footer_id != ''){
                    echo '<tr>
                                <td colspan="'.$colspan.'" style="font-style:italic; text-align:right; color: #4B8DF8; font-weight:bold">TOTAL BALANCE '.$footer_id ." | ".$footer_desc.'</td>
                                <td style="text-align:right; font-style:italic; color: #4B8DF8; font-weight:bold">'.number_format($tot_balance).'</td>
                            </tr>';
                }
            }
        }

        ?>
    </table>
</div>
