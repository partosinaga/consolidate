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
<h1 class="page-title"><i class="fa fa-edit"></i> Company
    <small>Edit</small>
    <a href="<?php echo site_url('setup/company') ?>"><button type="submit" class="btn green-jungle btn-sm pull-right"><i class="fa fa-chevron-left"></i> Cancel
        </button></a>
</h1>
<form action="<?php echo site_url('setup/company/save_edit') ?>" method="POST" id="add-company" class="form-horizontal">
    <div class="form-body">
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            You have some form errors. Please check below.
        </div>
        <?php foreach ($company as $comp): ?>
            <div class="hidden">
                <label class="control-label col-md-3">Company ID
                    <span class="required"> * </span>
                </label>
                <div class="col-md-8">
                    <div class="input-icon right">
                        <i class="fa"></i>
                        <input type="text" class="form-control input-sm" name="id" value="<?php echo $comp->company_id ?>"/>
                    </div>
                    <span class="help-block"> e.g: gltpp, gliem .. </span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Company Code
                    <span class="required"> * </span>
                </label>

                <div class="col-md-8">
                    <div class="input-icon right">
                        <i class="fa"></i>
                        <input type="text" class="form-control input-sm" name="company_code" value="<?php echo $comp->company_code ?>"/>
                    </div>
                    <span class="help-block"> e.g: gltpp, gliem .. </span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Company Name
                    <span class="required"> * </span>
                </label>

                <div class="col-md-8">
                    <div class="input-icon right">
                        <i class="fa"></i>
                        <input type="text" class="form-control input-sm" name="company_name" value="<?php echo $comp->company_name ?>"/>
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
                        <input type="text" class="form-control input-sm" name="database" value="<?php echo $comp->database ?>" />
                        <span class="help-block"> get from GL Application  </span>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <div class="text-center">
        <button type="submit" class="btn green btn-sm pull-right"><i class="fa fa-save"></i> Submit</button>
    </div>
</form>