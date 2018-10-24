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
<h1 class="page-title"><i class="fa fa-building"></i> Company
    <small>List</small>
    <button type="button" class="btn grey-mint btn-outline sbold uppercase btn-sm pull-right" data-toggle="modal" href="#static"><i class="fa fa-plus"></i> Add
    </button>
</h1>
<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
    <thead>
    <tr role="row" class="heading">
        <th width="2%">No</th>
        <th width="10%"> Company Code </th>
        <th> Company Name </th>
        <th width="10%"> Database Name </th>
        <th width="3%" style="text-align: center"> # </th>
    </tr>
    <tr role="row" class="filter">
        <td> </td>
        <td>
            <input type="text" class="form-control form-filter input-sm" name="order_company_code">
        </td>
        <td>
            <input type="text" class="form-control form-filter input-sm" name="order_company_name">
        </td>
        <td>
            <input type="text" class="form-control form-filter input-sm" name="order_database">
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

<!--ADD MODALS-->
<div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Company</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url('setup/company/add')?>" method="POST" id="add-company" class="form-horizontal">
<!--                   FORM VALIDATION LOCATION assets/pages/scripts/form-validation.js-->
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> You have some form errors. Please check below.
                        </div>
                        <div class="form-group  margin-top-20">
                            <label class="control-label col-md-3">Company Code
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control input-sm" name="company_code" />
                                </div>
                                <span class="help-block"> e.g: gltpp, gliem </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Company Name
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control input-sm" name="company_name" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Database Name
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control input-sm" name="database" />
                                    <span class="help-block"> get from GL Application  </span>
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

//        var initPickers = function () {
//            //init date pickers
//            $('.date-picker').datepicker({
//                rtl: Metronic.isRTL(),
//                autoclose: true
//            });
//        }

        var handleRecords = function () {

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
                loadingMessage: 'Loading...',
                dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options

                    // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                    // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js).
                    // So when dropdowns used the scrollable div should be removed.
                    //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",

                    "bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.
                    "aoColumns": [
                        { "bSortable": false , "sClass": "text-center"},
                        null,
                        null,
                        null,
                        { "bSortable": false , "sClass": "text-center"},

                    ],
                    "aaSorting": [],
                    "lengthMenu": [
                        [10, 20, 50, 100, 150, -1],
                        [10, 20, 50, 100, 150, "All"] // change per page values here
                    ],
                    "pageLength": 10, // default record count per page
                    "ajax": {
                        "url": "<?php echo base_url('setup/company/company_list');?>", // ajax source
                    },
                    "fnDrawCallback": function( oSettings ) {
                        $('.tooltips').tooltip();
                    }
                }
            });

            var tableWrapper = $("#datatable_ajax_wrapper");

            tableWrapper.find(".dataTables_length select").select2({
                showSearchInput: false //hide search box with special css class
            });

        }

        $(document.body).on('click', '.btn-bootbox', function(){
            var id = $(this).attr('data-id');
            bootbox.confirm("Are you sure?", function(result) {
                if(result == true){
                    window.location.assign('<?php echo base_url('setup/company/company_delete?id=');?>' + id + '');
                }
            });
        });
//        initPickers();
        handleRecords();
    });
</script>