<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>My Account | Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="BuilderEngine Dashboard" name="description" />
    <meta content="BuilderEngine" name="author" />

    <script>
        var site_root = "<?php echo home_url("")?>";

    </script>
    <style>
        .profile-avatar, .fileinput-button
        {
            float:left;
        }
        .file_preview{
            max-height: 34px;
            border-radius: 3px;
            margin-left: 5px;
        }
    </style>
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="<?php echo get_theme_path()?>assets/plugins/jquery-ui-1.10.4/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/bootstrap-3.2.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/css/animate.min.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/css/style.css?v2" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/css/theme/blue.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
    <link href="<?php echo get_theme_path()?>assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/morris/morris.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />

    <link href="<?php echo get_theme_path()?>assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/morris/morris.css" rel="stylesheet" />

    <link href="<?php echo get_theme_path()?>assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/ionRangeSlider/css/ion.rangeSlider.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/ionRangeSlider/css/ion.rangeSlider.skinNice.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/password-indicator/css/password-indicator.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
	<link href="<?php echo get_theme_path()?>assets/plugins/DataTables-1.10.2/css/data-table.css" rel="stylesheet" />
	
	<link href="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" />
    <link href="<?php echo get_theme_path()?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />
	
	<link href="<?php echo get_theme_path()?>assets/plugins/isotope/isotope.css" rel="stylesheet" />
  	<link href="<?php echo get_theme_path()?>assets/plugins/lightbox/css/lightbox.css" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL CSS STYLE ================== -->
</head>
<body>
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    <!-- begin #header -->
    <div id="header" class="header navbar navbar-inverse navbar-fixed-top">
        <!-- begin container-fluid -->
        <div class="container-fluid">
            <!-- begin mobile sidebar expand / collapse button -->
            <div class="navbar-header">
                <a href="/" class="navbar-brand"><span class="navbar-logo"><img src="<?php echo (!empty($this->BuilderEngine->get_option('logo_img')))?$this->BuilderEngine->get_option('logo_img'):get_logo_path()?>" alt="BuilderEngine" width="200" height="31"></span></a>
                <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- end mobile sidebar expand / collapse button -->

            <!-- begin header navigation right -->
            <ul class="nav navbar-nav navbar-right">
                
                <?php if ($user): ?>

                <li class="dropdown navbar-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?=$this->user->get_avatar()?>" alt="" />
                        <span class="hidden-xs"><?php echo $this->user->first_name." ".$this->user->last_name?></span> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInLeft">
                        <li class="arrow"></li>
                        <li><a <?=href("user", "main/edit/{$this->user->get_id()}")?> >Edit My Profile</a></li>
                        <li><a href="<?=base_url('user/settings/edit_settings')?>">Settings</a></li>
						<li><a href="<?=base_url()?>">Return to Website</a></li>
                        <li class="divider"></li>
                        <li><a <?=href('user','main/logout')?>>Log Out</a></li>
                    </ul>
                </li>

                <?php endif ?>

            </ul>
            <!-- end header navigation right -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end #header -->