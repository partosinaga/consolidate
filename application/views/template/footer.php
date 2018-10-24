            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
        </div>  
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"><?php echo date('Y') ?> &copy;  <a target="_blank" href="http://monstera.id/" rel="noopener">Monstera Inti Teknologi</a>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
    </div>

    <!--[if lt IE 9]>
<script src="<?php echo base_url() ?>/assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url() ?>/assets/global/plugins/excanvas.min.js"></script> 
<script src="<?php echo base_url() ?>/assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="<?php echo base_url() ?>assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="<?php echo base_url() ?>assets/layouts/layout/scripts/layout.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="<?php echo base_url() ?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!--    <script src="--><?php //echo base_url() ?><!--assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>-->
<!--    <script src="--><?php //echo base_url() ?><!--assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>-->
    <script src="<?php echo base_url() ?>assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS FORM VAIDATION-->
    <script src="<?php echo base_url() ?>assets/pages/scripts/form-validation.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS FORM VAIDATION-->

    <!-- BEGIN PAGE LEVEL SCRIPTS TOASTER-->
    <script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-toastr/toastr.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS  TOASTR-->

    <?php
    if(isset($style)) {
        if (count($style) > 0) {
            foreach ($script as $s) {
                echo '<script src="' . $s . '" type="text/javascript"></script>';
            }
        }
    }
    ?>

</body>
<script type="text/javascript">

    <?php if($this->session->flashdata('success')){ ?>
    toastr.success("<?php echo $this->session->flashdata('success'); ?>");
    <?php }
      else if($this->session->flashdata('error')){  ?>
    toastr.error("<?php echo $this->session->flashdata('error'); ?>");
    <?php }
      else if($this->session->flashdata('warning')){  ?>
    toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
    <?php }
      else if($this->session->flashdata('info')){  ?>
    toastr.info("<?php echo $this->session->flashdata('info'); ?>");
    <?php } ?>

</script>
</html>