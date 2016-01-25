<?php echo get_header() ?>

<?php echo get_sidebar() ?>

<!-- begin #content -->
<div id="content" class="content" style="min-height:800px">
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="/admin">Home</a></li>
	 <li><a href="#">Usergroups</a></li>
	   <li class="active">Edit Group</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Edit User Group <small>Administration Control Panel</small></h1>
<!-- end page-header -->
            <form class="form-horizontal form-bordered" data-parsley-validate="true" name="demo-form" method="post">
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
                            <h4 class="panel-title">User Group Account Details</h4>
                        </div>
                        <div class="panel-body panel-form">
                                <input type="hidden" name="id" value="<?php echo $group->id?>">
                                <div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="fullname">Group Name:</label>
									<div class="col-md-6 col-sm-6">
										<input class="form-control" type="text" id="groupname" name="group" value="<?php echo $group->name?>" placeholder="Enter Name for Usergroup" data-parsley-required="true" required />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="fullname">Group Description:</label>
									<div class="col-md-6 col-sm-6">
                                        <textarea class="form-control" placeholder="Write a Description about this Group." rows="5" name="description"><?php echo $group->description?></textarea>
									</div>
								</div>
								<!--
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="website">Group Access Allowed:</label>
									<div class="form-group">
									<div class="col-md-8 col-sm-8">
                                        <ul id="jquery-tagIt-default" class="warning">
                                            <li>Blogs Module</li>
                                            <li>Blogs Create Posts</li>
											<li>Blogs Create Categories</li>
											<li>Edit Profile</li>
											<li>Search Users</li>
											<li>View Pages</li>
											<li>Register Account</li>
											<li>Login Account</li>
                                        </ul>
										</div>
									</div>
								</div>-->
								<div class="form-group">
									<?php if(!$default_group ):?>
									<label class="control-label col-md-4 col-sm-4" for="fullname">Set Default For Register:</label>
									<div class="col-md-6 col-sm-6">
										<label class="radio-inline">
										 	<input type="radio" name="default_group" value="1" <?php echo ( $default_group ) ? 'checked="checked"' : ''; ?> > Yes
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="default_group" value="0" <?php echo ( !$default_group ) ? 'checked="checked"' : ''; ?> > No
										</label>
									</div>
									<?php else:?>
									<div class="col-md-12">
										<div class="alert alert-danger">
										<i class="fa fa-info-circle"></i>
											This group is set default for register.If you want to change it,just edit other group you want to set and 
											choose "Yes" for the <strong>Set Default for Register</strong> option.
										</div>
									</div>
									<?php endif;?>
								</div>
								<div class="form-group">
									<?php if(!$default_group ):?>
									<label class="control-label col-md-4 col-sm-4"></label>
									<div class="col-md-6 col-sm-6">
										<button type="submit" class="btn btn-primary">Save Group</button>
									</div>
									<?php else:?>
									<div class="col-md-12 col-sm-12 text-center">
										<button type="submit" class="btn btn-primary text-center">Save Group</button>
									</div>
									<?php endif;?>
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
                            <h4 class="panel-title">Blog</h4>
                        </div>
                        <div class="panel-body panel-form">
                                <input type="hidden" name="id" value="<?php echo $group->id?>">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="fullname">Create Blog Posts:</label>
									<div class="col-md-6 col-sm-6">
										<label class="radio-inline">
										 	<input type="radio" name="posts" value="1" <?php echo ( $group->allow_posts ) ? 'checked="checked"' : ''; ?> > Yes
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="posts" value="0" <?php echo ( !$group->allow_posts ) ? 'checked="checked"' : ''; ?> > No
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="fullname">Create Categories:</label>
									<div class="col-md-6 col-sm-6">
										<label class="radio-inline">
										 	<input type="radio" name="categories" value="1" <?php echo ( $group->allow_categories ) ? 'checked="checked"' : ''; ?> > Yes
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="categories" value="0" <?php echo ( !$group->allow_categories ) ? 'checked="checked"' : ''; ?> > No
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="fullname">User Created Categories:</label>
									<div class="col-md-6 col-sm-6">
										<label class="radio-inline">
										 	<input type="radio" name="use_created_categories" value="1" <?php echo ( $group->use_created_categories ) ? 'checked="checked"' : ''; ?> > Yes
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="use_created_categories" value="0" <?php echo ( !$group->use_created_categories ) ? 'checked="checked"' : ''; ?> > No
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="website">Default User Post Category:</label>
									<div class="form-group">
										<div class="col-md-8 col-sm-8">
						                    <ul id="default_user_post_category">
												<?php foreach(explode(',',$group->default_user_post_category) as $value):?>
												 	<li value="<?=$value?>"><?=$value?></li>
												<?php endforeach?>
						                    </ul>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4"></label>
									<div class="col-md-6 col-sm-6">
										<button type="submit" class="btn btn-primary">Save Group</button>
									</div>
								</div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
            </div>
            <!-- end row -->
		</div>
		<!-- end #content -->
        </form>
		
		
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
	});
</script>