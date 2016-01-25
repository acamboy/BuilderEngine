<?php echo get_header() ?>

<?php echo get_sidebar() ?>
<link href="<?php echo get_theme_path()?>/assets/css/custom.css" rel="stylesheet">
		<!-- begin #content -->
		<div id="content" class="content" style="min-height:800px">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Extra</a></li>
				<li class="active">Search Results</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Search Results</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-12 -->
			    <div class="col-md-12">
                    <form method="post">
			        <div class="result-container">
			            <div class="input-group m-b-20">
                            <input type="text" name="keyword" class="form-control input-white" placeholder="Enter keywords here..." />
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-inverse"><i class="fa fa-search"></i> Search</button>
                                <button type="button" class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-cog"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:;">Action</a></li>
                                    <li><a href="javascript:;">Another action</a></li>
                                    <li><a href="javascript:;">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="javascript:;">Separated link</a></li>
                                </ul>
                            </div>
                        </div><?php
                        /*
                        <div class="dropdown pull-left">
                            <a href="javascript:;" class="btn btn-white btn-white-without-border dropdown-toggle" data-toggle="dropdown">
                                Filters by <span class="caret m-l-5"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:;">Posted Date</a></li>
                                <li><a href="javascript:;">View Count</a></li>
                                <li><a href="javascript:;">Total View</a></li>
                                <li class="divider"></li>
                                <li><a href="javascript:;">Location</a></li>
                            </ul>
                        </div>
                        <div class="btn-group m-l-10 m-b-20">
                            <a href="javascript:;" class="btn btn-white btn-white-without-border"><i class="fa fa-list"></i></a>
                            <a href="javascript:;" class="btn btn-white btn-white-without-border"><i class="fa fa-th"></i></a>
                            <a href="javascript:;" class="btn btn-white btn-white-without-border"><i class="fa fa-th-large"></i></a>
                        </div>
                        <ul class="pagination pagination-without-border pull-right m-t-0">
                            <li class="disabled"><a href="javascript:;">«</a></li>
                            <li class="active"><a href="javascript:;">1</a></li>
                            <li><a href="javascript:;">2</a></li>
                            <li><a href="javascript:;">3</a></li>
                            <li><a href="javascript:;">4</a></li>
                            <li><a href="javascript:;">5</a></li>
                            <li><a href="javascript:;">6</a></li>
                            <li><a href="javascript:;">7</a></li>
                            <li><a href="javascript:;">»</a></li>
                        </ul>*/?>
                        <ul class="result-list">
                            <?php if($keyword == 'Users' || $keyword == 'users' || $keyword == 'user' || $keyword == 'user'|| $keyword == 'members'|| $keyword == 'Members'|| $keyword == 'member'|| $keyword == 'Member'):?>
                                <li>
                                    <div class="result-info" style="max-width:50%">
                                        <h4 class="title"><a href="javascript:;">Users Section</a></h4>
                                        <p class="location">BuilderEngine main section</p>
                                        <p class="desc">
                                            In this section of the system you can control the existing users or create new ones.
                                        </p>
                                        <div class="btn-row">
                                            <a class="search-suboption" href="<?php echo base_url('/admin/user/add')?>"><i class="fa fa-fw fa-plus"></i>Add New User</a>
                                            <a class="search-suboption" href="<?php echo base_url('/admin/user/search')?>"><i class="fa fa-fw fa-search"></i>Search Users</a>
                                            <a class="search-suboption" href="<?php echo base_url('/admin/main/search/groups')?>"><i style="width: 150px;" class="fa fa-fw fa-users">User Groups</i></a>
                                        </div>
                                    </div>
                                </li>
                            <?php elseif($keyword == 'Pages' || $keyword == 'Website Pages' || $keyword == 'website pages' || $keyword == 'pages' || $keyword == 'Page' || $keyword == 'Website Page' || $keyword == 'website page' || $keyword == 'page'):?>
                                <li>
                                    <div class="result-info" style="max-width:50%">
                                        <h4 class="title"><a href="javascript:;">Website Pages Section</a></h4>
                                        <p class="location">BuilderEngine main section</p>
                                        <p class="desc">
                                            In this section of the system you can add or edit any page in your website.
                                        </p>
                                        <div class="btn-row">
                                            <a class="search-suboption" href="<?php echo base_url('/admin/module/page/add')?>"><i class="fa fa-fw fa-plus"></i>Add Page</a>
                                            <a class="search-suboption" href="<?php echo base_url('/admin/module/page/show_pages')?>"><i class="fa fa-fw fa-file-o"></i>Show Pages</a>
                                        </div>
                                    </div>
                                </li>
                            <?php elseif($keyword == 'Groups' || $keyword == 'User Groups' || $keyword == 'user groups' || $keyword == 'groups' || $keyword == 'Group' || $keyword == 'User Group' || $keyword == 'user group' || $keyword == 'group'):?>
                                <li>
                                    <div class="result-info" style="max-width:50%">
                                        <h4 class="title"><a href="javascript:;">User Groups Section</a></h4>
                                        <p class="location">BuilderEngine main section</p>
                                        <p class="desc">
                                            In this section of the system you can add or edit user groups.
                                        </p>
                                        <div class="btn-row">
                                            <a class="search-suboption" href="<?php echo base_url('/admin/user/add_group')?>"><i class="fa fa-fw fa-plus"></i>Add New Group</a>
                                            <a class="search-suboption" href="<?php echo base_url('/admin/user/groups')?>"><i class="fa fa-fw fa-users"></i>Edit/Show Groups</a>
                                        </div>
                                    </div>
                                </li>
                            <?php elseif($keyword == 'Links' || $keyword == 'Navigation Links' || $keyword == 'navigation links' || $keyword == 'links' || $keyword == 'Navigation' || $keyword == 'navigation' || $keyword == 'Link' || $keyword == 'Navigation Link' || $keyword == 'navigation link' || $keyword == 'link'):?>
                                <li>
                                    <div class="result-info" style="max-width:50%">
                                        <h4 class="title"><a href="javascript:;">Navigation Links Section</a></h4>
                                        <p class="location">BuilderEngine main section</p>
                                        <p class="desc">
                                            In this section of the system you can add or edit the navigation links that appear in the frontend.
                                        </p>
                                        <div class="btn-row">
                                            <a class="search-suboption" href="<?php echo base_url('/admin/links/add')?>"><i class="fa fa-fw fa-plus"></i>Add New Link</a>
                                            <a class="search-suboption" href="<?php echo base_url('/admin/links/show')?>"><i class="fa fa-fw fa-users"></i>Edit/Show Links</a>
                                        </div>
                                    </div>
                                </li>
                            <?php elseif($keyword == 'Themes' || $keyword == 'Theme' || $keyword == 'Template' || $keyword == 'Templates' || $keyword == 'themes' || $keyword == 'theme' || $keyword == 'template' || $keyword == 'templates'):?>
                                <li>
                                    <div class="result-info" style="max-width:50%">
                                        <h4 class="title"><a href="javascript:;">Templates Section</a></h4>
                                        <p class="location">BuilderEngine main section</p>
                                        <p class="desc">
                                            In this section of the system you can change the template of your website's frontend.
                                        </p>
                                        <div class="btn-row">
                                            <a class="search-suboption" href="<?php echo base_url('/admin/themes/show')?>"><i class="fa fa-fw fa-th"></i>Edit/Show Themes</a>
                                        </div>
                                    </div>
                                </li>
                            <?php elseif($keyword == 'Settings' || $keyword == 'Website Settings' || $keyword == 'Search Engine settings' || $keyword == 'Edit/Show Modules' || $keyword == 'Options' || $keyword == 'Search engine' || $keyword == 'Web settings' || $keyword == 'settings' || $keyword == 'website settings' || $keyword == 'search engine settings' || $keyword == 'edit/show Modules' || $keyword == 'options' || $keyword == 'search engine' || $keyword == 'web settings'):?>
                                <li>
                                    <div class="result-info" style="max-width:50%">
                                        <h4 class="title"><a href="javascript:;">Settings Section</a></h4>
                                        <p class="location">BuilderEngine main section</p>
                                        <p class="desc">
                                            In this section of the system you can modify aspects of builderengine to suit your needs. 
                                        </p>
                                        <div class="btn-row">
                                            <a class="search-suboption" href="<?php echo base_url('/admin/main/settings')?>"><i class="fa fa-fw fa-cogs"></i>Website Settings</a>
                                            <a class="search-suboption" href="<?php echo base_url('/admin/main/seo_settings')?>"><i class="fa fa-fw fa-google"></i>Search Engine Settings</a>
                                            <a class="search-suboption" href="<?php echo base_url('/admin/modules/show')?>"><i class="fa fa-fw fa-cube"></i>Edit/Show Modules</a>
                                        </div>
                                    </div>
                                </li>
                            <?php elseif($keyword == 'Files' || $keyword == 'File' || $keyword == 'files' || $keyword == 'file' || $keyword == 'files'  || $keyword == 'File Manager' || $keyword == 'file manager'):?>
                                <li>
                                    <div class="result-info" style="max-width:50%">
                                        <h4 class="title"><a href="javascript:;">File Manager Section</a></h4>
                                        <p class="location">BuilderEngine main section</p>
                                        <p class="desc">
                                            In this section of the system you can add any and all files you need to your website.
                                        </p>
                                        <div class="btn-row">
                                            <a class="search-suboption" href="<?php echo base_url('/admin/files/show')?>"><i class="fa fa-fw fa-file"></i>File Manager</a>
                                        </div>
                                    </div>
                                </li>
                            <?php else:?>
                                <li>
                                    <div class="result-info" style="max-width:50%">
                                        <h4 class="title"><a href="javascript:;">Your search returned no results</a></h4>
                                        <p class="location">BuilderEngine main section</p>
                                    </div>
                                </li>
                            <?php endif;?>
                        </ul>
                        <?php
                        /*
                        <div class="clearfix">
                            <ul class="pagination pagination-without-border pull-right">
                                <li class="disabled"><a href="javascript:;">«</a></li>
                                <li class="active"><a href="javascript:;">1</a></li>
                                <li><a href="javascript:;">2</a></li>
                                <li><a href="javascript:;">3</a></li>
                                <li><a href="javascript:;">4</a></li>
                                <li><a href="javascript:;">5</a></li>
                                <li><a href="javascript:;">6</a></li>
                                <li><a href="javascript:;">7</a></li>
                                <li><a href="javascript:;">»</a></li>
                            </ul>
                        </div>*/?>
                    </div>
                    </form>
			    </div>
			    <!-- end col-12 -->
			</div>
			<!-- end row -->
		</div>
		<!-- end #content -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script>
    $(document).ready(function() {
        App.init();
    });
</script>

<?php echo get_footer()?>
	
