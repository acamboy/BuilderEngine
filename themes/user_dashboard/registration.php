<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Member Dashboard | Registration Page</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="BuilderEngine Dashboard" name="description" />
	<meta content="BuilderEngine" name="author" />

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
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->

	<div class="login-cover">
	    <div class="login-cover-image"><img src="<?php echo $url; ?>" data-id="login-cover-image" alt="" /></div>
	    <div class="login-cover-bg"></div>
	</div>
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
	    <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated flipInX" style="z-index:10000">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <span class="logo"></span><h1><?php echo $builderengine->get_option("register_title");?></h1>
                    <small><?php echo $builderengine->get_option("register_description");?></small>
                </div>
                <div class="icon">
                    <i class="fa fa-sign-in"></i>
                </div>
            </div>
            <!-- end brand -->
            <div class="login-content">
                <!-- <form action="index.html" method="POST" class="margin-bottom-0"> -->
                <form class="pure-form" id="asd">
                    <div class="form-group m-b-20">
                        <input type="text" class="form-control input-lg" placeholder="Username" id="username" required/>
                        <div data-name="username"></div>
                    </div>
                    <div class="form-group m-b-20">
                        <input type="email" class="form-control input-lg" placeholder="Email Address" id="email" required/>
                        <div data-name="email"></div>
                    </div>
                    <div class="form-group m-b-20">
                        <input type="text" class="form-control input-lg" placeholder="First Name" id="first_name" required/>
                        <div data-name="first_name"></div>
                    </div>
                    <div class="form-group m-b-20">
                        <input type="text" class="form-control input-lg" placeholder="Second Name" id="last_name" required/>
                        <div data-name="last_name"></div>
                    </div>
                    <div class="form-group m-b-20">
                        <input type="password" class="form-control input-lg" placeholder="Password" name="password" id="password" required/>
                        <div data-name="password"></div>
                    </div>
                    <div class="form-group m-b-20">
                        <input type="password" class="form-control input-lg" placeholder="Confirm Password" name="confirm_password" id="confirm_password" required/>
                    </div>
                    <div class="registration-buttons">
                        <button type="submit" class="btn btn-success btn-block btn-lg">Registration</button>
                        <div data-name=""></div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end login -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
    <?=$BuilderEngine->handle_head()?>
    <script>
        var site_root = "<?php echo home_url("")?>";
    </script>
	<script src="<?php echo get_theme_path()?>assets/plugins/jquery-1.8.2/jquery-1.8.2.min.js"></script>
	<script src="<?php echo get_theme_path()?>assets/plugins/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js"></script>
	<script src="<?php echo get_theme_path()?>assets/plugins/bootstrap-3.2.0/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo get_theme_path()?>assets/crossbrowserjs/html5shiv.js"></script>
		<script src="<?php echo get_theme_path()?>assets/crossbrowserjs/respond.min.js"></script>
		<script src="<?php echo get_theme_path()?>assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?php echo get_theme_path()?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo get_theme_path()?>assets/plugins/jquery-cookie/jquery.cookie.js"></script>
    <script src="<?php echo get_theme_path()?>assets/js/jquery.validate.min.js"></script>
	<!-- ================== END BASE JS ================== -->

    <!-- ================== BEGIN BuilderEngine JS ================== -->
    <script src="<?php echo get_theme_path()?>assets/js/registration.js"></script>
    <!-- ================== END BuilderEngine JS ================== -->

    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="<?php echo get_theme_path()?>assets/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
			//LoginV2.init();
		});
	</script>
</body>
</html>
