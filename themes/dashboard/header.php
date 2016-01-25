<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>BuilderEngine | Dashboard</title>
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
                <a href="<?=base_url('/admin')?>" class="navbar-brand"><span class="navbar-logo"><img src="<?php echo get_logo_path()?>" alt="BuilderEngine" width="200" height="31"></span></a>
                <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- end mobile sidebar expand / collapse button -->

            <!-- begin header navigation right -->
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <form class="navbar-form full-width" method="post" action="<?=base_url('/admin/main/search')?>">
                        <div class="form-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Search Dashboard" />
                            <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                        <i class="fa fa-microphone"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                        <i class="fa fa-arrows-alt"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                        <i class="fa fa-bell-o"></i>

                        <?php if( $user && isset($user) && !empty($user)):?>
                            <?php if(count($this->user->alert->get()->all) > 0): ?>
                                <span class="label"><?php echo count($this->user->alert->get()->all)?></span>
                            <?php endif;?>
                        <?php endif;?>
                    </a>
                    <ul class="dropdown-menu media-list pull-right animated bounceIn" style="min-width: 280px">
                        <li class="dropdown-header">Notifications (<?=($this->user) ? count($this->user->alert->get()->all) : '0'; ?>)</li>
                        <?php if(isset($user) && !empty($user)):?>
                            <?php if( count($this->user->alert->get()->all) == 0): ?>
                            <?php else:?>
                                <?php foreach($this->user->alert->get()->all as $alert): ?>
                                    <li class="media">
                                        <a href="<?php echo $alert->url?>">
                                            <div class="pull-left media-object bg-blue"><i class="icon16 <?php echo $alert->icon?>"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">System Notification</h6>
                                                <p><?php echo $alert->text?></p>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach;?>
                            <?php endif;?>
                        <?php endif;?>



                        <li class="dropdown-footer text-center">
                            <a href="javascript:;">View more</a>
                        </li>
                    </ul>
                </li>
                <?php if ($user): ?>
                <li class="dropdown navbar-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?=$this->user->get_avatar()?>" alt="" />
                        <span class="hidden-xs"><?php echo $this->user->first_name." ".$this->user->last_name?></span> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInLeft">
                        <li class="arrow"></li>
                        <li><a <?=href("admin", "user/edit/{$this->user->get_id()}")?> >Edit My Profile</a></li>
                        <li><a <?php echo href("admin", "main/settings")?>>Settings</a></li>
                        <li><a href="<?=base_url('/admin')?>" >Website Statistics</a></li>
                        <li class="divider"></li>
                        <li><a href="<?=base_url('/admin/main/logout')?>">Log Out</a></li>
                    </ul>
                </li>

                <?php endif ?>

            </ul>
            <!-- end header navigation right -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end #header -->