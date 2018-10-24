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
<h1 class="page-title"><i class="fa fa-list-ul"></i> COA
    <small>Setup</small>
</h1>
<div class="panel">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_add"> <i
                    class="fa fa-plus"></i> Add COA</a>
        </h4>
    </div>
    <div id="collapse_add" class="panel-collapse collapse">
        <div class="panel-body" style="background-color: #e3e2e2">
            <form method="POST" action="javascript:;" id="add-coa">
                <div class="form-body">
                    <div class="form-group col-md-2">
                        <label class="control-label"> COA Code <span class="required"> * </span></label>

                        <div class="input-icon right">
                            <i class="fa"></i>
                            <input type="text" class="form-control input-sm" name="coa_code"/>
                        </div>
                    </div>
                    <div class="form-group col-md-8">
                        <label class="control-label"> COA Name <span class="required"> * </span></label>

                        <div class="input-icon right">
                            <i class="fa"></i>
                            <input type="text" class="form-control input-sm" name="coa_name"/>
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

                <table class="table table-bordered table-hover" id="coa-selected">
                    <thead>
                    <tr>
                        <th style="width: 20%; text-align: center; font-weight: bold">COA REFFERENCE CODE</th>
                        <th style="width: 10%; text-align: center; font-weight: bold">COMPANY</th>
                        <th style="font-weight: bold">COA REFFERENCE NAME</th>
                        <th style="text-align: center; width:5%; font-weight: bold">#</th>
                    </tr>
                    </thead>
                    <tbody id="list-row"></tbody>
                </table>
                <button type="submit" class="btn green btn-sm pull-right mt-ladda-btn ladda-button"
                        data-style="zoom-out" id="submit-form"><span class="ladda-label"><i class="fa fa-save"></i> Save</span>
                </button>
            </form>
        </div>
    </div>
</div>
<hr>

<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
    <thead>
    <tr role="row" class="heading">
        <th width="3%"> No </th>
        <th width="15%"> COA Code </th>
        <th width="200"> COA Name </th>
        <th width="5%"> # </th>
    </tr>
    <tr role="row" class="filter">
        <td>

        </td>
        <td>
            <input type="text" class="form-control form-filter input-sm" name="order_coa_code">
        </td>
        <td>
            <input type="text" class="form-control form-filter input-sm" name="order_coa_name">
        </td>
        <td>
            <div class="margin-bottom-5">
                <button class="btn btn-sm green btn-outline filter-submit margin-bottom tooltips" data-original-title="Search" data-placement="top" data-container="body"><i class="fa fa-search"></i></button>
            </div>
            <button class="btn btn-sm red btn-outline filter-cancel tooltips" data-original-title="Reset" data-placement="top" data-container="body"> <i class="fa fa-times"></i></button>
        </td>
    </tr>
    </thead>
    <tbody> </tbody>
</table>

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
<!--COA DETAIL MODAL-->
<div class="modal fade static" data-backdrop="static" id="basic" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" >
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="header-title"></h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>COMPANY</th>
                        <th style="text-align:center; width: 60%">DETAILS</th>
                    </tr>
                    </thead>
                    <tbody id="coa-detail">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm dark btn-outline" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--END OF COA DETAIL MODAL-->
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

    $(document).ready(function () {
        // process the form
        $('#submit-form').click(function (event) {
            var l = Ladda.create(this);
            l.start();

            // process the form
            $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('setup/coa/add_coa') ?>',
                    data: $('form').serialize(), // using .serialize() because there is data containning array object.
                    encode: true,
                    success: function (data, textStatus, jQxhr) {
                        toastr.success('Success add new COA');
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        toastr.error('Failed, try again later');
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
    });

    $(document).ready(function(){
        var TableDatatablesAjax = function () {

            var initPickers = function () {
                //init date pickers
                $('.date-picker').datepicker({
                    rtl: App.isRTL(),
                    autoclose: true
                });
            }

            $(document).ready(function(){
                    var grid = new Datatable();

                    grid.init({
                        src: $("#datatable_ajax"),
                        onSuccess: function (grid) {
                            // execute some code after table records loaded
                        },
                        onError: function (grid) {
                            // execute some code on network or other general error
                        },
                        onDataLoad: function(grid) {
                            // execute some code on ajax data load
                        },
                        loadingMessage: 'Populating ...',
                        dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options

                            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js).
                            // So when dropdowns used the scrollable div should be removed.
                            "dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",

                            "bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.

                            "lengthMenu": [
                                [10, 20, 50, 100, 150, -1],
                                [10, 20, 50, 100, 150, "All"] // change per page values here
                            ],
                            "aoColumns" : [
                                {"sClass":"text-center", "bSortable": true},
                                {"sClass":"text-center", "bSortable": true},
                                null,
                                {"sClass":"text-center"}
                            ],
                            "pageLength": 10, // default record count per page
                            "ajax": {
                                "url": "<?php echo base_url('setup/coa/coa_list')?>",
                            },
                            "order": [
                                [1, "asc"]
                            ]// set first column as a default sort by asc

                        }
                    });

                    var tableWrapper = $("#datatable_ajax_wrapper");

                    tableWrapper.find(".dataTables_length select").select2({
                        showSearchInput: false //hide search box with special css class
                    });

                    // handle group actionsubmit button click
                    grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
                        e.preventDefault();
                        var action = $(".table-group-action-input", grid.getTableWrapper());
                        if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                            grid.setAjaxParam("customActionType", "group_action");
                            grid.setAjaxParam("customActionName", action.val());
                            grid.setAjaxParam("id", grid.getSelectedRows());
                            grid.getDataTable().ajax.reload();
                            grid.clearAjaxParams();
                        } else if (action.val() == "") {
                            Metronic.alert({
                                type: 'danger',
                                icon: 'warning',
                                message: 'Please select an action',
                                container: grid.getTableWrapper(),
                                place: 'prepend'
                            });
                        } else if (grid.getSelectedRowsCount() === 0) {
                            Metronic.alert({
                                type: 'danger',
                                icon: 'warning',
                                message: 'No record selected',
                                container: grid.getTableWrapper(),
                                place: 'prepend'
                            });
                        }
                    });


                $(document.body).on('click', '.remove', function(){
                    var id = $(this).attr("coa-id");
                    bootbox.confirm("Are you sure?", function(result) {
                    if(result == true){
                        window.location.assign('<?php echo base_url('setup/coa/coa_delete?id=');?>' + id + '');
                    }
                    });
                });
                $(document.body).on('click', '.view', function(){
                    var id = $(this).attr("coa-id");
                    var coa_name = $(this).attr("coa-name");

                    $.ajax({
                        url: "<?php echo base_url('setup/coa/coa_detail');?>",
                        method: "post",
                        data: {id},
                        success: function (data) {
                            $('#coa-detail').html(data);
                            $('#basic').modal("show");
                            document.getElementById("header-title").innerHTML = id +'|'+ coa_name;
                        }
                    });

                });
            });

        }();
    })


</script>