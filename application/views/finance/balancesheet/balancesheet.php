<div class="report-head">
    <p>BALANCE SHEET</p>

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
    $group = '';
    $i = 0;
    $balance = 0;
    $asset_balance = 0;
    $tot_asset_balance = 0;
    //asset
    foreach ($coa_asset as $c) {
        foreach ($asset as $ass) {
            if ($c->coa_id == $ass->coa_id) {
                $asset_balance = $ass->balance;
                break;
            } else {
                $asset_balance = 0;
            }
        }
        if ($group != $c->group) {
            echo '<tr>
                <th colspan="2">' . strtoupper($c->group) . '</th>
                </tr>';
            $group = $c->group;
        } else {
            echo '';
        }
        echo '<tr>
                <td style="padding-left: 6em;">' . $c->coa_id . " | " . $c->coa_name . '</td>
                <td align="right">' . number_format($asset_balance) . '</td>
                </tr>';
        $i++;
        $tot_asset_balance = $tot_asset_balance + $asset_balance;
        if ($i == count($coa_asset)) {
            echo '<tr>
                <th>TOTAL ' . strtoupper($c->group) . '</th>
                <th style="text-align:right; border-bottom: 2px double black">' . number_format($tot_asset_balance) . '</td>
                </tr>';
            $tot_asset_balance = 0;
        }
    }
    //end of asset
    ?>

    <?php
    //liability
    $i = 0;
    $group = '';
    $liability_balance = 0;
    $tot_liability_balance = 0;
    foreach ($coa_liability as $cli) {
        foreach ($liability as $lby) {
            if ($cli->coa_id == $lby->coa_id) {
                $liability_balance = $lby->balance;
                break;
            } else {
                $liability_balance = 0;
            }
        }
        if ($group != $cli->group) {
            echo '<tr>
                <th colspan="2">' . strtoupper($cli->group) . '</th>
                </tr>';
            $group = $cli->group;
        } else {
            echo '';
        }
        if ($cli->coa_id == 40100000000 ){ //if labaditahan
            $liability_balance = $liability_balance +  $laba_ditahan->labaditahan;
        }
        if ($cli->coa_id == 40200000000  ){ //if laba berjalan
            $liability_balance = $laba_berjalan->lababerjalan;
        }
        echo '<tr>
                <td style="padding-left: 6em;">' . $cli->coa_id . " | " . $cli->coa_name . '</td>
                <td align="right">' . number_format($liability_balance) . '</td>
                </tr>';
        $i++;
        $tot_liability_balance = $tot_liability_balance + $liability_balance;
        if ($i == count($coa_liability)) {
            echo '<tr>
                <th>TOTAL ' . strtoupper($cli->group) . '</th>
                <th style="text-align:right;border-bottom: 2px double black"> ' . number_format($tot_liability_balance) . '</td>
                </tr>';
        }
    }
    //end of liability
    ?>
    </tbody>
</table>