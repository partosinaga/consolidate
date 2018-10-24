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
<h1 class="page-title"><i class="fa fa-edit"></i> User
    <small>Edit</small>
    <a href="javascript:;">
        <button type="submit" class="btn green-jungle btn-sm pull-right" onclick="goBack()"><i class="fa fa-chevron-left"></i> Cancel
        </button>
    </a>
    </button>
</h1>
<form action=" <?php echo site_url('admin/user/save_edit') ?> " method="POST" id="add-user" class="form-horizontal">
    <!--                   FORM VALIDATION LOCATION assets/pages/scripts/form-validation.js-->

    <div class="form-body">
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            You have some form errors. Please check below.
        </div>
        <?php foreach($user as $u): ?>
            <div class="form-group  margin-top-20">
                <label class="control-label col-md-3">Username
                    <span class="required"> * </span>
                </label>

                <div class="col-md-8">
                    <div class="input-icon right">
                        <i class="fa"></i>
                        <input type="hidden" class="form-control input-sm" name="user_id" value="<?php echo $u->user_id ?>"/>
                        <input type="text" class="form-control input-sm" name="username" value="<?php echo $u->username ?>" />
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
                        <input type="password" class="form-control input-sm" name="password" value="<?php echo $u->password ?>"/>
                        <span class="help-block"> only for change password </span>
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
                        <input type="email" class="form-control input-sm" name="email" value="<?php echo $u->email ?>"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Status
                    <span class="required"> * </span>
                </label>

                <div class="col-md-8">
                    <div class="input-icon right">
                        <i class="fa"></i>
                        <select class="form-control select2" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>

    <button type="submit" class="btn green btn-sm pull-right"><i class="fa fa-save"></i> Submit</button>
</form>
<script>
    function goBack() {
        window.history.back();
    }
</script>