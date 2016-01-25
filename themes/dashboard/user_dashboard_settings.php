<?php echo get_header() ?>

<?php echo get_sidebar() ?>
<!-- begin #content -->
<div id="content" class="content" style="min-height:800px">
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="/admin">Home</a></li>
	 <li><a href="#">Settings</a></li>
	  <li class="active">Website Settings</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Website Settings <small>Administration Control Panel</small></h1>
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
                            <h4 class="panel-title">Website / General Details</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form id="dashForm" class="form-horizontal form-bordered" enctype="multipart/form-data" method="post" data-parsley-validate="true" name="demo-form">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="websitetitle">Login Title:</label>
									<div class="col-md-6 col-sm-6">
										<input class="form-control" type="text" value="<?php echo $builderengine->get_option("login_title");?>" id="websitetitle" name="login_title" placeholder="Enter Default Login Title" data-parsley-required="true" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="websitetitle">Login Description:</label>
									<div class="col-md-6 col-sm-6">
										<input class="form-control" type="text" value="<?php echo $builderengine->get_option("login_description");?>" id="websitetitle" name="login_description" placeholder="Enter Default Login Description" data-parsley-required="true" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="websitetitle">Register Title:</label>
									<div class="col-md-6 col-sm-6">
										<input class="form-control" type="text" value="<?php echo $builderengine->get_option("register_title");?>" id="websitetitle" name="register_title" placeholder="Enter Default Register Title" data-parsley-required="true" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="websitetitle">Register Description:</label>
									<div class="col-md-6 col-sm-6">
										<input class="form-control" type="text" value="<?php echo $builderengine->get_option("register_description");?>" id="websitetitle" name="register_description" placeholder="Enter Default Register Description" data-parsley-required="true" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="loginoption">User Can Login with:</label>
									<div class="col-md-8 col-sm-8">
										<label class="radio-inline">
										 	<input type="radio" name="user_login_option" value="username" <?php echo ( $user_login_option == 'username') ? 'checked="checked"' : ''; ?> > Username
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="user_login_option" value="email" <?php echo ( $user_login_option == 'email' ) ? 'checked="checked"' : ''; ?> > Email
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="user_login_option" value="both" <?php echo ( $user_login_option == 'both' ) ? 'checked="checked"' : ''; ?> >Both Username and Email
										</label>
									</div>
								</div>
		                        <div class="form-group">
		                            <label class="control-label col-md-4 col-sm-4" for="fullname">Background:</label>
		                            <div class="col-md-6 col-sm-6">
										<style>
											.file_preview {
												max-height: 110px;
												max-width:110px;
												margin-top: 10px;
											}
											.profile-avatar img{
												width:110px !important;
												max-height:110px;
											}
										</style>
										<span class="btn btn-success fileinput-button">
		                                    <i class="fa fa-plus"></i>
		                                    <span>Add image...</span>
		                                    <input id="f" type="file" name="background_img" rel="file_manager" file_value="<?=$builderengine->get_option("background_img")?>">
		                                </span>
											<?php if(!empty($builderengine->get_option("background_img"))):?>
												<button type="submit" id="background_img_btn" class="btn btn-primary btn-danger btn-xs" style="margin-left:-85px;margin-top:50px;"><i class="fa fa-times"></i> Remove</button>
												<input type="hidden" id="background_img" name="background_img" value="">
											<?php endif;?>								
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-md-4 col-sm-4" for="fullname">Logo:<br/> (best fit: 200 x 30 px)</label>
		                            <div class="col-md-6 col-sm-6">
										<span class="btn btn-success fileinput-button">
		                                    <i class="fa fa-plus"></i>
		                                    <span>Add image...</span>
		                                    <input id="d" type="file" name="logo_img" rel="file_manager" file_value="<?=$builderengine->get_option("logo_img")?>">
		                                </span>
											<?php if(!empty($builderengine->get_option("logo_img"))):?>
												<button type="submit" id="logo_img_btn" class="btn btn-primary btn-danger btn-xs" style="margin-left:-85px;margin-top:50px;"><i class="fa fa-times"></i> Remove</button>
												<input type="hidden" id="logo_img" name="logo_img" value="">
											<?php endif;?>										
		                            </div>
		                        </div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="fullname">User Dashboard Active:</label>
									<div class="col-md-6 col-sm-6">
										<label class="radio-inline">
										 	<input type="radio" name="user_dashboard_activ" value="yes" <?php echo ( !$user_dashboard_activ ) ? 'checked="checked"' : ''; ?> > Yes
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="user_dashboard_activ" value="no" <?php echo ( $user_dashboard_activ ) ? 'checked="checked"' : ''; ?> > No
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="fullname">User Dashboard Blog:</label>
									<div class="col-md-6 col-sm-6">
										<label class="radio-inline">
										 	<input type="radio" name="user_dashboard_blog" value="yes" <?php echo ( !$user_dashboard_blog ) ? 'checked="checked"' : ''; ?> > Yes
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="user_dashboard_blog" value="no" <?php echo ( $user_dashboard_blog ) ? 'checked="checked"' : ''; ?> > No
										</label>
									</div>
								</div>
								
							<!--	<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="fullname">User Dashboard Forum:</label>
									<div class="col-md-6 col-sm-6">
										<label class="radio-inline">
										 	<input type="radio" name="user_dashboard_forum" value="yes" <?php// echo ( !$user_dashboard_forum ) ? 'checked="checked"' : ''; ?> > Yes
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="user_dashboard_forum" value="no" <?php// echo ( $user_dashboard_forum ) ? 'checked="checked"' : ''; ?> > No
										</label>
									</div>
								</div> -->
								<!-- <div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="fullname">User Created Posts:</label>
									<div class="col-md-6 col-sm-6">
										<label class="radio-inline">
										 	<input type="radio" name="user_created_posts" value="yes" <?php //echo ( !$user_created_posts ) ? 'checked="checked"' : ''; ?> > Yes
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="user_created_posts" value="no" <?php //echo ( $user_created_posts ) ? 'checked="checked"' : ''; ?> > No
										</label>
									</div>
								</div> -->
								<!-- <div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="fullname">User Created Categories:</label>
									<div class="col-md-6 col-sm-6">
										<label class="radio-inline">
										 	<input type="radio" name="user_created_categories" value="yes" <?php //echo ( !$user_created_categories ) ? 'checked="checked"' : ''; ?> > Yes
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="user_created_categories" value="no" <?php// echo ( $user_created_categories ) ? 'checked="checked"' : ''; ?> > No
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="website">Default User Post Category:</label>
									<div class="form-group">
										<div class="col-md-8 col-sm-8">
						                    <ul id="default_user_post_category">
												<?php //foreach($default_user_post_category as $value):?>
												 	<li value="<?=$value?>"><?=$value?></li>
												<?php //endforeach?>
						                    </ul>
										</div>
									</div>
								</div> -->

								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4"></label>
									<div class="col-md-6 col-sm-6">
										<button id="submit_btn" type="submit" class="btn btn-primary">Save Settings</button>
									</div>
								</div>
                            </form>
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

              <div class="col-md-4">
			        <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">User Builder</h4>
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
                                        <td>User Login</td>
							            <td><a href="<?= base_url('user/main/userLogin');?>" class="btn btn-sm btn-primary">View Page</a></td>
							        </tr>
							        <tr>
							            <td>Registration</td>
							            <td><a href="<?= base_url('user/registration/index');?>" class="btn btn-sm btn-primary">View Page</a></td>
							        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
			    </div> 
            </div>
            <!-- end row -->
		</div>
		<!-- end #content -->
		
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
<?php echo get_footer()?>
<?php $categories = new Category();?>
<script>
    $(document).ready(function (){
	    $('#default_user_post_category').tagit({
	        fieldName: "default_user_post_category",
	        singleField: true,
	        showAutocompleteOnFocus: true,
	        availableTags: [ <?php foreach ($categories->get() as $category): ?>"<?php echo $category->name?>", <?php endforeach;?>]
	    });

		$('#logo_img_btn').click(function(event){
			$('#background_img').remove();
			$('#dashForm').submit();				
			event.preventDefault();
		});
		$('#background_img_btn').click(function(event){
			$('#logo_img').remove();
			$('#dashForm').submit();				
			event.preventDefault();
		});
		$('#submit_btn').click(function(event){
			$('#logo_img').remove();
			$('#background_img').remove();
			$('#dashForm').submit();				
			event.preventDefault();
		});
		
		$("#f").click(function(e){
		   e.preventDefault();
		});
		$("#d").click(function(e){
		   e.preventDefault();
		});
	});
</script>