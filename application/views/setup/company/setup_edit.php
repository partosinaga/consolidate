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
<h1 class="page-title"><i class="fa fa-building"></i> Project
    <small>Edit</small>
</h1>
<form id="project-form" class="form-horizontal" action="javascript:;">
    <label class="control-label col-md-1">Project Name
        <span class="required"> * </span>
    </label>

    <div class="col-md-4">
        <div class="input-icon right">
            <i class="fa"></i>
            <input type="text" class="form-control input-sm" name="project_name" value="<?php echo $project->row()->project_name ?>"/>
        </div>
    </div>
    <button type="submit" class="btn grey-mint sbold uppercase btn-sm pull-right" name="submit"><i class="fa fa-save"></i> Save </button>
    <a href="<?php echo site_url('setup/company/company_setup'); ?>"><button type="button" style="margin-right: 12px" class="btn default btn-sm uppercase pull-right"><i class="fa fa-remove"></i> Cancel </button></a>

    <br>
    <hr>
    <table class="table table-bordered table-striped" id="company-consolidate">
        <thead>
        <tr>
            <th width="20%" style="text-align: center; font-weight: bold">COMPANY CODE</th>
            <th style="font-weight: bold">COMPANY NAME</th>
            <th width="5%" style="text-align: center; font-weight: bold">#</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($consolidate as $cons): ?>
                <tr>
                    <td align="center"><input type="hidden" name="company_id[]" value="<?php echo $cons->company_id ?>"><?php echo $cons->company_code ?></td>
                    <td><?php echo $cons->company_name ?></td>
                    <td align="center" ><button type="button" class="btn grey sbold btn-xs btn-sm" onclick="deleteRow(this)"><i class="fa fa-remove"></i> </button>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="3">
                <button class="btn blue-madison btn-sm tooltips" data-original-title="Add company"
                        data-placement="top"
                        data-container="body" data-toggle="modal" href="#static"><i class="fa fa-plus"></i></button>
            </th>
        </tr>
        </tfoot>
    </table>
</form>


<!--ADD COMPANY MODALS-->
<div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Add Company</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th width="5%" style="text-align: center; font-weight: bold">NO</th>
                        <th width="25%" style="text-align: center; font-weight: bold">COMPANY CODE</th>
                        <th style="font-weight: bold">COMPANY NAME</th>
                        <th width="5%" style="text-align: center; font-weight: bold">#</th>
                    </tr>
                    <?php $i = 1;
                    foreach ($company as $c): ?>
                        <tr>
                            <td align="center"><?php echo $i++ ?></td>
                            <td align="center"><?php echo $c->company_code ?></td>
                            <td><?php echo $c->company_name ?></td>
                            <td>
                                <button class="btn blue-oleo btn-xs select" comp-id="<?php echo $c->company_id ?>"
                                        comp-code="<?php echo $c->company_code ?>"
                                        comp-name="<?php echo $c->company_name ?>" name="select-comp"><i
                                        class="fa fa-plus"></i></button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>
            <div class="modal-footer form-actions">
                <button type="button" class="btn default btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!--END OF ADD COMPANY MODALS-->
<script>
    var rowIndex = <?php echo (isset($rowIndex) ? $rowIndex : 0) ; ?>;


    $(document).ready(function () {
        var tbody = $('#company-consolidate').children('tbody');
        var table = tbody.length ? tbody : $('#company-consolidate');
        $('button[name="select-comp"]').on('click', function () {
            var comp_id = $(this).attr("comp-id");
            var comp_code = $(this).attr('comp-code');
            var comp_name = $(this).attr('comp-name');
            var newRow = "<tr>" +
                "<td align=\"center\"><input type='hidden' name=\"company_id[]\" value=" + comp_id + ">" + comp_code + "</td>" +
                "<td>" + comp_name + "</td>" +
                "<td align=\"center\"><button onclick=\"deleteRow(this)\" class=\"btn grey btn-xs\"><i class=\"fa fa-remove\"></i></button></td>" +
                "</tr>";

            $('#company-consolidate tbody').append(newRow);
            rowIndex++;
            $('#static').modal('hide');
        })
    })

    function deleteRow(btn) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    };
    $('button[name="submit"]').on('click', function () {
        var url = '<?php echo base_url('/setup/company/save_edit_setup');?>';
        $("#project-form").attr("method", "post");
        $('#project-form').attr('action', url).submit();
    })
</script>