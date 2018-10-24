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
<h1 class="page-title"><i class="fa fa-edit"></i> COA
    <small>Edit</small>
    <a href="<?php echo site_url('setup/coa') ?>"><button type="submit" class="btn green-jungle btn-sm pull-right"><i class="fa fa-chevron-left"></i> Cancel
    </button></a>
</h1>
<div class="panel">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_add"> <i
                    class="fa fa-plus"></i> Add COA</a>
        </h4>
    </div>
    <div id="collapse_add" class="panel-collapse collapse in">
        <div class="panel-body" style="background-color: #e3e2e2">
            <form action="javascript:;" id="edit-coa">
                <?php foreach($header as $row): ?>
                <div class="form-body">
                    <div class="form-group col-md-2">
                        <label class="control-label"> COA Code <span class="required"> * </span></label>

                        <div class="input-icon right">
                            <i class="fa"></i>
                            <input type="hidden" class="form-control input-sm" name="coa_code_old" value="<?php echo $row->coa_id ?>"/>
                            <input type="text" class="form-control input-sm" name="coa_code" value="<?php echo $row->coa_id ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-md-8">
                        <label class="control-label"> COA Name <span class="required"> * </span></label>

                        <div class="input-icon right">
                            <i class="fa"></i>
                            <input type="text" class="form-control input-sm" name="coa_name" value="<?php echo $row->coa_name ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>

                        <div>
                            <button type="button" class="btn grey-mint sbold uppercase btn-sm" data-toggle="modal"
                                    href="#full">
                                <i class="fa fa-search"></i> COA List
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
                <table class="table table-bordered table-hover" id="coa-selected">
                    <thead>
                    <tr>
                        <th style="width: 20%; text-align: center; font-weight: bold">COA REFFERENCE CODE</th>
                        <th style="width: 10%; text-align: center; font-weight: bold">COMPANY</th>
                        <th style="font-weight: bold">COA REFFERENCE NAME</th>
                        <th style="text-align: center; width:5%; font-weight: bold">#</th>
                    </tr>
                    </thead>
                    <tbody id="list-row">
                    <?php foreach($detail as $rowDet): ?>
                        <tr>
                            <td align="center"><input type="hidden" name="coa_reff_code[]" value="<?php echo $rowDet->coa_reff_id ?>"><?php echo $rowDet->coa_reff_id ?></td>
                            <td align="center"><input type="hidden" name="company_id[]" value="<?php echo $rowDet->company_id ?>"><?php echo $rowDet->company_code ?></td>
                            <td> <input type="hidden" name="coa_reff_name[]" value="<?php echo $rowDet->coa_reff_name ?>"><?php echo $rowDet->coa_reff_name ?></td>
                            <td align="center"><button class="btn red btn-xs" onclick="remove(this)"><i class="fa fa-remove"></i></button></td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
                <button type="submit" class="btn green btn-sm pull-right mt-ladda-btn ladda-button"
                        data-style="zoom-out" id="submit-form"><span class="ladda-label"><i class="fa fa-save"></i> Save</span>
                </button>
            </form>
        </div>
    </div>
</div>
<!--COA LIST MODAL-->
<div class="modal fade static" data-backdrop="static" id="full" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-list"></i> Chart Of Account</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    $col = 12 / $compTotal->company_entity;
                    $i = 1;
                    foreach ($company as $comp) {
                        echo '
                        <div class="col-md-' . $col . '" >
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_' . $i . '">
                            <thead>
                            <tr>
                                    <th colspan="3" style="text-align: center; font-weight:bold">' . $comp->company_name . ' - ' . $comp->company_code . '</th>
                            </tr>
                            <tr>
                                    <th style="text-align: center; font-weight:bold">COA ID</th>
                                    <th style="text-align: center; font-weight:bold">NAME</th>
                                    <th style="text-align: center; font-weight:bold">#</th>
                            </tr>
                        </thead>
                        <tbody>';
                        $sql = "SELECT c.coa_id, c.name_coa, '" . $comp->database . "' as company_idt FROM " . $comp->database . ".coa c ORDER BY c.coa_id ASC";
                        $query = $this->db->query($sql);
                        foreach ($query->result() as $row) {
                            if ($comp->database == $row->company_idt) {
                                echo '
                                <tr>
                                <td align="center">' . $row->coa_id . '</td>
                                <td>' . $row->name_coa . '</td>
                                <td align="center"><button class="btn btn-xs yellow tooltips select-coa" company-id="' . $comp->company_id . '" company-code="' . $comp->company_code . '" coa-reff-id="' . $row->coa_id . '" coa-name="' . $row->name_coa . '" name="pick"><i class="fa fa-check"></i></button></td>
                                </tr>';
                            }
                        }
                        echo '
                            </tbody>
                        </table>
                        </div>';
                        $i++;
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline btn-sm" data-dismiss="modal"><i
                        class="fa fa-remove"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
<!--END OF COA LIST MODAL-->

<script>
    var rowIndex = <?php echo (isset($rowIndex) ? $rowIndex : 0) ; ?>;

    var tbody = $('#coa-selected').children('tbody');
    var table = tbody.length ? tbody : $('#coa-selected');
    $('button[name="pick"]').on('click', function () {
        var coaCode = $(this).attr('coa-reff-id');
        var companyID = $(this).attr('company-id');
        var companyCode = $(this).attr('company-code');
        var coaName = $(this).attr('coa-name');
        var newRow =
            "<tr>" +
            "<td align=\"center\"> <input type=\"hidden\" name=\"coa_reff_code[]\" value=" + coaCode + "> " + coaCode + " </td>" +
            "<td align=\"center\"> <input type=\"hidden\" name=\"company_id[]\" value=" + companyID + "> " + companyCode + " </td>" +
            "<td> <input type=\"hidden\" name=\"coa_reff_name[]\" value= '" + coaName + "'> " + coaName + " </td>" +
            "<td align=\"center\"> <button class=\"btn btn-xs red\" onclick=\"remove(this)\"><i class=\"fa fa-remove\"></i></button> </td>" +
            "</tr>";
        $('#coa-selected').append(newRow);
        rowIndex++;
        $('#full').modal('hide');
    })
    //delete row
    function remove(btn) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    };


    $('#submit-form').click(function (event) {
        var l = Ladda.create(this);
        l.start();
        // process the form
        $.ajax({
                type: 'POST',
                url: '<?php echo site_url('setup/coa/save_edit_coa') ?>',
                data: $('form').serialize(), // using .serialize() because there is data containning array object.
                dataType: 'JSON',
                success: function (msg) {
                    toastr.success('Success edit COA');
                    setTimeout(function(){
                        window.location.href ='<?php echo site_url('setup/coa') ?>';
                    }, 1000);

                },
                error: function (msg, errorThrown) {
                    toastr.error('COA Code sudah digunakan!');
                    console.log(errorThrown);
                }
            })
            .always(function () {
                l.stop();
            });
        return false;

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });
</script>