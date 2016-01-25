<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="description" content="{$BuilderEngine->get_option('website_description')}">
	<meta name="keywords" content="{$BuilderEngine->get_option('website_keywords')}">
	<meta name="author" content="BuilderEngine">
  	
  	{literal}
  	<script>
        var site_root = "{/literal}{home_url("")}{literal}";
    </script>
    {/literal}

    <title id="primary-website-title">{$BuilderEngine->get_option('website_title')}</title>
	
    <style>
      .open
      {
        position:relative;
      }
    </style>

	<!-- Stylesheets -->
	{$BuilderEngine->handle_head()}
	<!-- Favicon -->
	<link rel="shortcut icon" href="{get_theme_path()}images/favicon/favicon.png">
	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
	<!-- Font Awesome -->
	<link href="{get_theme_path()}plugins/font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<!-- Bootstrap & Custom Styles -->
	<link href="{get_theme_path()}css/bootstrap.min.css" rel="stylesheet">
	<link href="{get_theme_path()}css/be_animate.css" rel="stylesheet">
	<link href="{get_theme_path()}css/styles.css" rel="stylesheet">
	<link href="{get_theme_path()}css/be_predefined_classes.css" rel="stylesheet">
	<link href="{get_theme_path()}css/be_components.css" rel="stylesheet">
   <!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
			<script src="js/excanvas.min.js"></script>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
</head>
	
	<div id="page-container" class="fade">
		<header>		
		    <div id="header" class="header navbar navbar-inverse no-border-radius">
			    {block type='header' name="header-section" global="true"}
                    {block type='row' class='row clearfix container boxed-row' global="true" name="header-section-container-row-1"}
                        {block type='column' class='col-md-3 col-sm-3 column col-lg-3' global="true" name="header-section-container-row-1-col-1"}
                            {block type='generic' global="true" name="header-section-container-row-1-col-1-block-1"}
                                {content}
                                    <a href="{base_url()}" class="navbar-brand">
                                        <span class="brand-logo"><img src="{get_theme_path()}images/logo.png" alt="" /></span>
                                        <span class="brand-text">
                                            Builder<span class="text-theme">Engine</span>
                                        </span>
                                    </a>
                                {/content}
                            {/block}
                        {/block}
                        {block type='column' class='col-md-9 col-sm-9 col-lg-9 column' global="true" name="header-section-container-row-1-col-2"}
                            {block type='navbar' style="margin-bottom:0px" global="true" name="header-section-container-row-1-col-2-block-1"}
                                {content}
                                {/content}
                            {/block}
                        {/block}
                    {/block}
				{/block}
			</div>
		</header>