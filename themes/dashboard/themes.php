<?php echo get_header() ?>

<?php echo get_sidebar() ?>

<?php if (isset($groups)): ?>
	
<script>
                    $(document).ready(function() {
                        $("#groups").select2({tags:[ <?php foreach ($groups as $group): ?>"<?php echo $group->name?>", <?php endforeach;?>]});
                        $("#tags").select2({tags:[]});
                    });
                </script>
<?php endif ?>
<!-- begin #content -->
<div id="content" class="content" style="min-height:800px">
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="/admin">Home</a></li>
	 <li><a href="#">Templates</a></li>
	  <li class="active">Show Themes</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Edit / Show Themes <small>Administration Control Panel</small></h1>
<!-- end page-header -->
			<!-- begin row -->
			<div class="row">
                <!-- begin col-8 -->
			    <div class="col-md-8">
			       <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Template Theme Details</h4>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs nav-tabs-inverse nav-justified nav-justified-mobile">
						<li class="active"><a href="#latest-post" data-toggle="tab"><i class="fa fa-picture-o m-r-5"></i> <span class="hidden-xs">Currently Active Theme</span></a></li>
						<li class=""><a href="#system" data-toggle="tab"><i class="fa fa-shopping-cart m-r-5"></i> <span class="hidden-xs">Themes Installed</span></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade active in" id="latest-post">
							<div class="height-sm" data-scrollbar="true">
								<ul class="media-list media-list-with-divider">
									<li class="media media-lg">
										<a href="javascript:;" class="pull-left">
											<img class="media-object" src="<?php echo $active_theme['screenshot_url']?>" alt="" />
										</a>
										<div class="media-body">
											<h4 class="media-heading"><?php echo $active_theme['name']?></h4>
											<p style="display:inline"><?php echo $active_theme['description']?></p>
											<!---->
											<form class="form-horizontal" style="float: right;width:50%" method="get">
					                        	<div class="form-group">
					                            	<label class="control-label col-md-6 col-sm-6" for="fullname">Available Colors:</label>
					                            	<div class="col-md-6 col-sm-6">
						                                <select class="form-control" name="color_pattern"/>
						                                <?php $colors = scandir('themes/'.$BuilderEngine->get_option("active_frontend_theme").'/css/color_patterns');?>
						                                	<option value="default">Default</option>
															<?php foreach($colors as $color):?>
																<?php if($color != '.' && $color != '..'):?>
																	<?php $color_name = str_replace('.css', '', $color);?>
																	<option value="<?=$color_name?>" <?if($BuilderEngine->get_option('theme_color_pattern') == $color_name) echo 'selected';?>><?=ucfirst($color_name)?></option>
																<?php endif;?>
															<?php endforeach;?>
															<?php
															/*<option value="red" <?php if($BuilderEngine->get_option('theme_color_pattern') == 'red') echo 'selected';?>>Red</option>
															<option value="blue" <?php if($BuilderEngine->get_option('theme_color_pattern') == 'blue') echo 'selected';?>>Blue</option>*/?>
						                            	</select>
					                            	</div>
					                        	</div>
					                        	<div class="form-group">
					                        		<label class="control-label col-md-6 col-sm-6" for="fullname"></label>
					                            	<div class="col-md-6 col-sm-6">
						                                <button type="submit" class="btn btn-primary">Apply</button>
					                            	</div>
					                        	</div>
					                        </form>
					                        <!---->
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="tab-pane fade" id="system">
							<div class="height-sm" data-scrollbar="true">
								<ul class="media-list media-list-with-divider">
								<?php foreach($themes as $theme):?>
									<li class="media media-lg">
										<a href="javascript:;" class="pull-left">
											<img class="media-object" src="<?php echo $theme['screenshot_url']?>" alt="" />
										</a>
										<div class="media-body">
											<h4 class="media-heading"><?php echo $theme['name']?></h4>
											<?php echo $theme['description']?>
										</div>
										<p></p>
										<div class="col-md-6 col-sm-6">
										<form action='' method='post'>
                                            <input type="hidden" name="theme" value="<?php echo $theme['name']?>">
                                        <?php if($theme['name'] == $active_theme['name']):?>
                                            <button class="btn btn-warning disabled" disabled> Already Active </button>
                                        <?php else:?>
                                            <input type=submit class="btn btn-warning " value="Activate">  
                                        <?php endif;?>
                                        </form>
											</div>
										</li>
								<?php endforeach;?>
								</ul>
							</div>
						</div>
					</div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-8 -->
			    <div class="col-md-4">
			    	<div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Support Builder</h4>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>BuilderEngine Support Forums</td>
							            <td><a href="#modal-dialog" class="btn btn-sm btn-primary" data-toggle="modal">View</a></td>
							        </tr>
							        <tr>
							            <td>BuilderEngine Tutorials/Guides</td>
							            <td><a href="#modal-guides" class="btn btn-sm btn-primary" data-toggle="modal">View</a></td>
							        </tr>
							        <tr>
							            <td>BuilderEngine Support Tickets</td>
							            <td><a href="#modal-tickets" class="btn btn-sm btn-primary" data-toggle="modal">View</a></td>
							        </tr>
							        <tr>
							            <td>BuilderEngine.com Account Login</td>
							            <td><a href="#modal-cloudlogin" class="btn btn-sm btn-success" data-toggle="modal">View</a></td>
							        </tr>
                                </tbody>
                            </table>
							<!-- #modal-dialog -->
							<div class="modal fade" id="modal-dialog">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">BuilderEngine Support Forums</h4>
										</div>
										<div class="modal-body">
											You are about to leave your Administration Control Panel, click Continue to view page.
										</div>
										<div class="modal-footer">
											<a href="" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
											<a href="http://builderengine.com/forums/" class="btn btn-sm btn-success">Continue</a>
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="modal-guides">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">BuilderEngine Tutorials/Guides</h4>
										</div>
										<div class="modal-body">
											You are about to leave your Administration Control Panel, click Continue to view page.
										</div>
										<div class="modal-footer">
											<a href="" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
											<a href="http://builderengine.com/page-support.html" class="btn btn-sm btn-success">Continue</a>
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="modal-tickets">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">BuilderEngine Support Tickets</h4>
										</div>
										<div class="modal-body">
											You are about to leave your Administration Control Panel, click Continue to view page.
										</div>
										<div class="modal-footer">
											<a href="" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
											<a href="http://builderengine.com/page-support.html" class="btn btn-sm btn-success">Continue</a>
										</div>
									</div>
								</div>
							</div>
							<div class="modal fade" id="modal-cloudlogin">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">BuilderEngine.com Account Login</h4>
										</div>
										<div class="modal-body">
											You are about to leave your Administration Control Panel, click Continue to view page.
										</div>
										<div class="modal-footer">
											<a href="" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
											<a href="http://builderengine.com/client/login" class="btn btn-sm btn-success">Continue</a>
										</div>
									</div>
								</div>
							</div>							
                        </div>
                    </div>
			    </div>
            </div>
            <!-- end row -->
            <?php
            /*
			<div class="row">
				<div class="col-md-8">
					<!-- begin page-header -->
					<h1 class="page-header">Available Themes <small>Install New Themes from the Cloud BuilderMarket</small></h1>
					<!-- end page-header -->
					<div id="options" class="m-b-10">
			            <span class="gallery-option-set" id="filter" data-option-key="filter">
			                <a href="#show-all" class="btn btn-default btn-xs active" data-option-value="*">
			                    Show All
			                </a>
			                <a href="#gallery-group-1" class="btn btn-default btn-xs" data-option-value=".gallery-group-1">
			                    Advertising & Marketing
			                </a>
			                <a href="#gallery-group-2" class="btn btn-default btn-xs" data-option-value=".gallery-group-2">
			                    Cars & Transportation
			                </a>
			                <a href="#gallery-group-3" class="btn btn-default btn-xs" data-option-value=".gallery-group-3">
			                    Charity & Non Profit
			                </a>
			                <a href="#gallery-group-4" class="btn btn-default btn-xs" data-option-value=".gallery-group-4">
			                    Community & Education
			                </a>
							<a href="#gallery-group-5" class="btn btn-default btn-xs" data-option-value=".gallery-group-5">
			                    Consulting & Business
			                </a>
							<a href="#gallery-group-6" class="btn btn-default btn-xs" data-option-value=".gallery-group-6">
			                    Finance & Law
			                </a>
							<a href="#gallery-group-7" class="btn btn-default btn-xs" data-option-value=".gallery-group-7">
			                    Health & Beauty
			                </a>
							<a href="#gallery-group-8" class="btn btn-default btn-xs" data-option-value=".gallery-group-8">
			                    Home & Trade
			                </a>
							<a href="#gallery-group-9" class="btn btn-default btn-xs" data-option-value=".gallery-group-9">
			                    Sports & Recreation
			                </a>
							<a href="#gallery-group-10" class="btn btn-default btn-xs" data-option-value=".gallery-group-10">
			                    Tech & Apps
			                </a>
			            </span>
			        </div>
			        <div id="gallery" class="gallery">
			            <div class="image gallery-group-1">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-1">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
			            <div class="image gallery-group-1">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-1">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Charity Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Charity Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Charity Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
						<div class="image gallery-group-2">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-2">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
						<div class="image gallery-group-2">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-2">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
						<div class="image gallery-group-3">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-3">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
						<div class="image gallery-group-3">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-3">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
						<div class="image gallery-group-4">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-4">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
						<div class="image gallery-group-4">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-4">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
						<div class="image gallery-group-5">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-5">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
						<div class="image gallery-group-5">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-5">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
						<div class="image gallery-group-6">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-6">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
						<div class="image gallery-group-7">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-7">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
						<div class="image gallery-group-8">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-8">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
						<div class="image gallery-group-9">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-9">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
						<div class="image gallery-group-10">
			                <div class="image-inner">
			                    <a href="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" data-lightbox="gallery-group-10">
			                        <img src="<?php echo get_theme_path()?>assets/img/default_theme_pro.jpg" alt="" />
			                    </a>
			                    <p class="image-caption">
			                        Business Theme
			                    </p>
			                </div>
			                <div class="image-info">
			                    <h5 class="title">Business Theme</h5>
			                    <div class="pull-right">
			                        <small>by</small> <a href="http://www.builderengine.com">BuilderEngine</a>
			                    </div>
			                    <button type="submit" class="btn btn-success">Install Theme</button>
								<p></p>
			                    <div class="desc">
			                        Business Theme for BuilderEngine. Includes various pages and new blocks with this theme.
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
            </div>*/?>
		</div>
		<!-- end #content -->
		
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
<?php echo get_footer()?>