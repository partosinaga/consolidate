<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a><?php echo $this->uri->segment(1) ?></a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <?php echo $this->uri->segment(2) ?>
        </li>
    </ul>
</div>
<h1 class="page-title"><i class="fa fa-file"></i> Profit & Loss Statement</h1>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-check-circle"></i> Profit & Loss Statement Form
        </div>
    </div>
    <div class="portlet-body">
        <form method="GET" action="<?php echo site_url('finance/profitloss/generate') ?>" target="_blank">
            <div class="row">
                <div class="form-group">
                    <div class="col-md-2">
                        <label>Month</label>
                        <select id="single" class="form-control select2" name="month">
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                echo '<option value="' . $i . '" ' . ($i == date('n') ? 'selected' : '') . '>' . $i . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Year</label>
                        <select id="single" class="form-control select2" name="year">
                            <?php
                            $date = date('Y');
                            for ($i = 2010; $i <= $date; $i++) {
                                echo '<option value="' . $i . '" ' . ($i == date('Y') ? 'selected' : '') . '>' . $i . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <br>
                <div class="form-group">
                    <div class="col-md-6">
                        <button type="submit" class="btn green btn-sm submit"><i class="fa fa-search"></i> Generate</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
