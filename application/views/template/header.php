<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>GL Consolidate</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Preview page of Metronic Admin Theme #1 for full width layout with mega menu" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN CORE PLUGINS -->
    <script src="<?php echo base_url() ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/global/plugins/pace/pace.min.js" type="text/javascript"></script>
    <link href="<?php echo base_url() ?>assets/global/plugins/pace/themes/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <!-- END CORE PLUGINS -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>assets/global/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?php echo base_url() ?>assets/global/css/components.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?php echo base_url() ?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?php echo base_url() ?>assets/layouts/layout/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="<?php echo base_url() ?>assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS TOASTR-->
    <link href="<?php echo base_url() ?>/assets/global/plugins/bootstrap-toastr/toastr.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS TOASTR-->

    <?php
    if(isset($style)) {
        if (count($style) > 0) {
            foreach ($style as $s) {
                echo '<link href="' . $s . '" rel="stylesheet" type="text/css" />';
            }
        }
    }

    ?>
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>/assets/layouts/layout/img/GL.png"/>
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-full-width">
    <div class="page-wrapper">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="<?php echo site_url("dashboard") ?>">
                        <img src="<?php echo base_url() ?>/assets/layouts/layout/img/logo-consol2.png" alt="logo" class="logo-default" />
                    </a>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN MEGA MENU -->
                <!-- DOC: Remove "hor-menu-light" class to have a horizontal menu with theme background instead of white background -->
                <!-- DOC: This is desktop version of the horizontal menu. The mobile version is defined(duplicated) in the responsive menu below along with sidebar menu. So the horizontal menu has 2 seperate versions -->
                <div class="hor-menu   hidden-sm hidden-xs">
                    <ul class="nav navbar-nav">
                        <!-- DOC: Remove data-hover="megamenu-dropdown" and data-close-others="true" attributes below to disable the horizontal opening on mouse hover -->
                        <?php if($this->session->userdata('username') == 'adm'){ ?>
                        <li class="classic-menu-dropdown" aria-haspopup="true">
                            <a href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true"><i class="fa fa-legal "></i> Admin
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-left">
                                <li>
                                    <a href="<?php echo site_url('/admin/user') ?>">
                                        <i class="fa fa-users"></i> User </a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                        <li class="classic-menu-dropdown" aria-haspopup="true">
                            <a href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true"><i class="fa fa-gears "></i> Setup
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-left">
                                <li class="dropdown-submenu" aria-haspopup="true">
                                    <a href="javascript:;">
                                        <i class="fa fa-building"></i> Company </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('/setup/company') ?>">
                                                <i class="fa fa-check-circle"></i> List </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('/setup/company/company_setup') ?>">
                                                <i class="fa fa-check-circle"></i> Setup </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('/setup/coa') ?>">
                                        <i class="fa fa-list-ul"></i> COA </a>
                                </li>
                            </ul>
                        </li>
                        <li class="classic-menu-dropdown" aria-haspopup="true">
                            <a href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true"><i class="fa fa-suitcase "></i> Finance
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-left">
                                <li>
                                    <a href="<?php echo site_url('/finance/trialbalance') ?>">
                                        <i class="fa fa-balance-scale"></i> Trial Balance </a>
                                </li>

                                <li class="dropdown-submenu" aria-haspopup="true">
                                    <a href="javascript:;">
                                        <i class="fa fa-file-o"></i> Financial Statement </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('/finance/balancesheet') ?>">
                                                <i class="fa fa-check-circle"></i> Balance Sheet
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('/finance/profitloss') ?>">
                                                <i class="fa fa-check-circle"></i> Profit & Loss Statement
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- END MEGA MENU -->

                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- END TODO DROPDOWN -->
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-hoverable dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle" src="<?php echo base_url() ?>/assets/layouts/layout/img/avatar.png" />
                                <span class="username username-hide-on-mobile"> <?php echo $this->session->userdata('username') ?> </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="<?php echo site_url('admin/user/get_edit?id=').$this->session->userdata('user_id') ?>">
                                        <i class="icon-user"></i> My Profile </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('login/logout') ?>">
                                        <i class="icon-key"></i> Log Out </a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- END SIDEBAR MENU -->
                    <div class="page-sidebar-wrapper">
                        <!-- BEGIN RESPONSIVE MENU FOR HORIZONTAL & SIDEBAR MENU -->
                        <ul class="page-sidebar-menu visible-sm visible-xs  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
                            data-slide-speed="200">
                            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                            <!-- DOC: This is mobile version of the horizontal menu. The desktop version is defined(duplicated) in the header above -->
                            <?php if($this->session->userdata('username') == 'adm'){ ?>
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link nav-toggle"> Admin
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('/admin/user') ?>" class="nav-link">
                                            <i class="fa fa-users"></i> User </a>
                                    </li>
                                </ul>
                            </li>
                            <?php } ?>
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link nav-toggle"> Setup
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-building"></i> Company
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="nav-item">
                                                <a href="<?php echo site_url('/setup/company') ?>">
                                                    <i class="fa fa-check-circle"></i> List </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo site_url('/setup/company/company_setup') ?>">
                                                    <i class="fa fa-check-circle"></i> Setup </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('/setup/coa') ?>">
                                            <i class="fa fa-list-ul"></i> COA </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link nav-toggle"> Finance
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="">
                                            <i class="fa fa-balance-scale"></i> Trial Balance </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-file-o"></i> Financial Statement
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="nav-item">
                                                <a href="">
                                                    <i class="fa fa-check-circle"></i> Layout Setting
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="">
                                                    <i class="fa fa-check-circle"></i> Balance Sheet
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="">
                                                    <i class="fa fa-check-circle"></i> Income Statement
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                        <!-- END RESPONSIVE MENU FOR HORIZONTAL & SIDEBAR MENU -->
                    </div>
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
