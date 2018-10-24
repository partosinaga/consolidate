<div class="report-head">
    <p>PROFIT & LOSS STATEMENT</p>

    <p id="ammount">Amounts in (IDR)</p>

    <p>As Of <?php echo date("F Y", mktime(0, 0, 0, $month, 1, $year)); ?></p>
    <hr style="border-top: 2px double black">
</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th width="90%" style="border-bottom: 2px double black"><b>DESCRIPTION</b></th>
        <th style="border-bottom: 2px double black; text-align: right"><b>BALANCE</b></th>
    </tr>
    </thead>
    <tbody>

    <?php
    //income
    $group = '';
    $i = 0;
    $income_balance = 0;
    $tot_income_balance = 0;
    foreach ($coa_income as $ci) {
        foreach ($income as $in) { //get income
            if ($in->coa_id == $ci->coa_id) {
                $income_balance = $in->income;
                break;
            } else {
                $income_balance = 0;
            }
        }
        if( $ci->coa_id ==  80000000000 ){ //other income
            $income_balance = $other_income->other_income;
        }
        if ($group != $ci->group) {
            echo '<tr>
                        <th colspan="2">' . strtoupper($ci->group) . '</th>
                        </tr>';
            $group = $ci->group;
        } else {
            echo '';
        }
        echo '<tr>
                 <td style="padding-left: 6em;">' . $ci->coa_id . ' | ' . $ci->coa_name . '</td>
                <td align="right">' . number_format($income_balance) . '</td>
                </tr>';
        $i++;
        $tot_income_balance = $tot_income_balance + $income_balance;
        if ($i == count($coa_income)) {
            echo '<tr>
                        <th>TOTAL ' . strtoupper($ci->group) . '</th>
                        <th style="text-align:right">' . number_format($tot_income_balance) . '</td>
                        </tr>';
        }
    }
    //end of income
    ?>


    <?php
    //expense
    $group = '';
    $i = 0;
    $expense_balance = 0;
    $tot_expense_balance = 0;
    foreach ($coa_expense as $ce) {
        foreach ($expense as $ex) {
            if ($ce->coa_id == $ex->coa_id) {
                $expense_balance = $ex->expense;
                break;
            } else {
                $expense_balance = 0;
            }
        }
        if($ce->coa_id ==  80000000000 ){ //other expense
            $expense_balance = $other_expense->other_expense;
        }
        if ($group != $ce->group) {
            echo '<tr>
                        <th colspan="2">' . strtoupper($ce->group) . '</th>
                        </tr>';
            $group = $ce->group;
        } else {
            echo '';
        }
        echo '<tr>
                 <td style="padding-left: 6em;">' . $ce->coa_id . ' | ' . $ce->coa_name . '</td>
                <td align="right">' . number_format($expense_balance) . '</td>
                </tr>';
        $i++;
        $tot_expense_balance = $tot_expense_balance + $expense_balance;
        if ($i == count($coa_expense)) {
            echo '<tr>
                        <th>TOTAL ' . strtoupper($ce->group) . '</th>
                        <th style="text-align:right">'.number_format($tot_expense_balance).'</td>
                        </tr>';
        }
    }
    //end of expense
    echo '<tr>
        <th>NET PROFIT & LOSS</th>
        <th style="text-align:right; border-bottom: 2px double black">'.number_format($tot_income_balance - $tot_expense_balance).'</th>
        </tr>';
    ?>

    </tbody>
</table>