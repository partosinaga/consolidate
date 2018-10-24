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
<h1 class="page-title"><i class="fa fa-users"></i> User
    <small>List</small>
    <button type="button" class="btn grey-mint btn-outline sbold uppercase btn-sm pull-right" data-toggle="modal"
            href="#static"><i class="fa fa-plus"></i> Add
    </button>
</h1>
<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
    <thead>
    <tr role="row" class="heading">
        <th width="2%">No</th>
        <th> Username</th>
        <th width="40%"> Email</th>
        <th width="10%"> Status</th>
        <th width="3%" style="text-align: center"> #</th>
    </tr>
    <tr role="row" class="filter">
        <td></td>
        <td>
            <input type="text" class="form-control form-filter input-sm" name="order_username">
        </td>
        <td>
            <input type="text" class="form-control form-filter input-sm" name="order_email">
        </td>
        <td>
            <select class="form-control select2 input-sm" name="order_status">
                <option>All</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </td>
        <td>
            <div class="margin-bottom-5">
                <button class="btn btn-sm green btn-outline filter-submit margin-bottom tooltips"
                        data-original-title="Search" data-placement="top" data-container="body"><i
                        class="fa fa-search"></i></button>
            </div>
            <button class="btn btn-sm red btn-outline filter-cancel tooltips" data-original-title="Reset"
                    data-placement="top" data-container="body"><i class="fa fa-times"></i></button>
        </td>
    </tr>
    </thead>
    <tbody></tbody>
</table>
<!--ADD MODALS-->
<div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Add New User</h4>
            </div>
            <div class="modal-body">
                <form action=" <?php echo site_url('admin/user/add_user')  ?> " method="POST" id="add-user" class="form-horizontal">
                    <!--                   FORM VALIDATION LOCATION assets/pages/scripts/form-validation.js-->
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                        </div>
                        <div class="form-group  margin-top-20">
                            <label class="control-label col-md-3">Username
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control input-sm" name="username" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Password
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="password" class="form-control input-sm" name="password" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="email" class="form-control input-sm" name="email" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer form-actions">
                        <button type="button" class="btn default btn-sm" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn green btn-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--END OF ADD MODALS-->

<script>
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
                            null,
                            null,
                            {"sClass":"text-center"},
                            {"sClass":"text-center"}
                        ],
                        "pageLength": 10, // default record count per page
                        "ajax": {
                            "url": "<?php echo site_url('admin/user/user_list') ?>",
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

                $(document.body).on('click', '.btn-bootbox', function(){
                    var id = $(this).attr('data-id');
                    bootbox.confirm("Are you sure?", function(result) {
                        if(result == true){
                            window.location.assign('<?php echo base_url('admin/user/user_delete?id=');?>' + id + '');
                        }
                    });
                })

            });

        }();
    })
</script>


