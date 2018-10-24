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
    <small>Info</small>
</h1>

<div class="portlet light portlet-fit bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cubes"></i>
            <span class="caption-subject bold uppercase">PROJECT: <?php echo strtoupper($project->row()->project_name) ?></span>
        </div>
        <div class="actions">
            <div class="btn-group btn-group-devided">
                <a href="<?php echo site_url('setup/company/get_edit_project') ?>"><button type="button" class="btn grey-mint btn-outline sbold uppercase btn-sm"><i class="fa fa-edit"></i> Edit </button></a>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <div class="timeline">
            <!-- TIMELINE ITEM -->
            <?php foreach ($consolidate as $cons): ?>
                <div class="timeline-item">
                    <div class="timeline-badge">
                        <img class="timeline-badge-userpic"
                             src="<?php echo base_url() ?>/assets/layouts/layout/img/GL.png"/></div>
                    <div class="timeline-body">
                        <div class="timeline-body-arrow"></div>
                        <div class="timeline-body-head">
                            <div class="timeline-body-head-caption">
                                <a href="javascript:;" class="timeline-body-title font-blue-madison"><?php echo $cons->company_code ?></a>
                            </div>
                        </div>
                        <div class="timeline-body-content">
                            <span class="font-grey-cascade"> <?php echo $cons->company_name ?> </span>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <!-- END TIMELINE ITEM -->

        </div>
    </div>
</div>
