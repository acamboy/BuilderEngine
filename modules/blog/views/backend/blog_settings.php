<script src="<?php echo get_theme_path()?>assets/plugins/jquery-1.8.2/jquery-1.8.2.min.js"></script>
<ol class="breadcrumb pull-right">
	<li><a href="<?=base_url()?>">Home</a></li>
	<li class="active">Blog Settings</li>
</ol>
<h1 class="page-header">Blog Settings <small>Administration Control Panel</small></h1>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Blog Details</h4>
            </div>
            <div class="panel-body panel-form">
                <form class="form-horizontal form-bordered" method="post" data-parsley-validate="true" name="demo-form">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4" for="websitetitle">Allow Comments:</label>
						<div class="col-md-6 col-sm-6">
							<?php if($this->BuilderEngine->get_option('be_blog_allow_comments') == 'yes')
						   	{
						   		$check1 = 'checked'; 
						   		$check2 = '';
						   	}
						   	else
						   	{
						   		$check1 = ''; 
						   		$check2 = 'checked';
						   	}
							?>									
							<label class="radio-inline">
                                <input type="radio" name="allow_comments" value="yes" <?=$check1?>/>
                                Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="allow_comments" value="no" <?=$check2?>/>
                                No Comments
                            </label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4" for="websitekeywords">Public / Private Comments:</label>
						<div class="col-md-8 col-sm-8">
							<?php if($this->BuilderEngine->get_option('be_blog_comments_private') == 'public')
							{
						   		$check1 = 'checked'; 
						   		$check2 = '';
						   	}
						   	else
						   	{
						   		$check1 = ''; 
						   		$check2 = 'checked';
						   	}
							?>									
							<label class="radio-inline">
                                <input type="radio" name="comments_private" value="public" <?=$check1?>/>
                                Everyone Can Comment (Public)
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="comments_private" value="private" <?=$check2?> />
                                Only Registered Users Can Comment (Private)
                            </label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4" for="websitetitle">Allow Comments Captcha Protection :</label>
						<div class="col-md-6 col-sm-6">
							<?php $captcha = $this->BuilderEngine->get_option('be_blog_captcha') == 'yes'; ?>
							<label class="radio-inline">
                                <input type="radio" name="captcha" value="yes" <?=$captcha ? 'checked="checked"' : '';?> />
                                Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="captcha" value="no"  <?=!$captcha ? 'checked="checked"' : '';?> />
                                No Captcha
                            </label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4" for="websitetitle">Show Tags:</label>
						<div class="col-md-6 col-sm-6">
							<?php if($this->BuilderEngine->get_option('be_blog_show_tags') != 'no')
							{
								$check1 = 'checked';
								$check2 = '';
								$show = '';
								$placeholder = '';
							}
							else
							{
								$check1 = '';
								$check2 = 'checked';
								$show = 'readonly';
								$placeholder = 'placeholder=" 10 , 20 , 50 etc."';
                            }
							?>										
							<label class="radio-inline">
                                <input type="radio" name="show_tags" value="yes" <?=$check1?> />
                                Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="show_tags" value="no" <?=$check2?>/>
                                Hide Tags
                            </label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4" for="adminemail">Number of Tags Displayed On Blog Sidebar:</label>
						<div class="col-md-6 col-sm-6">
					  	    <?php $tags = $this->BuilderEngine->get_option('be_blog_num_tags_displayed');?>
							<?php if(empty($tags))
								$tags = 0;
							?>
							<input class="form-control" type="text" name="num_tags_displayed" <?=$placeholder?> value="<?=$tags?>" <?=$show?>/>
						</div>
					</div>		
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4" for="adminemail">Number of Recent Posts Displayed On Blog Sidebar:</label>
						<div class="col-md-6 col-sm-6">
					  	    <?php $recent_posts = $this->BuilderEngine->get_option('be_blog_num_recent_posts_displayed');?>
							<?php if(empty($recent_posts))
								$recent_posts = 0;
							?>
							<input class="form-control" type="text" name="num_recent_posts_displayed" value="<?=$recent_posts?>" />
						</div>
					</div>									
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4" for="adminemail">How Many Posts Displayed On Main Page:</label>
						<div class="col-md-6 col-sm-6">
							<input class="form-control" type="text" name="num_posts_displayed" value="<?=$posts = $this->BuilderEngine->get_option('be_blog_num_posts_displayed');?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4" for="website">
						<i class="fa fa-question-circle" style="font-size:16px;" data-toggle="tooltip" data-placement="top" title="Allows a group membership policy to be defined for users registering by way of this Modules registration page, that takes precedence over the system default user group."></i>
						Module Default Registration Group(s):<br>
							
						</label>
						<div class="form-group">
						<div class="col-md-8 col-sm-8">
                            <ul id="access-groups">
		                      <?php $groups = explode(',', $this->BuilderEngine->get_option('be_blog_access_groups'));?>
		                      <?php foreach($groups as $group):?>
		                      	<li><?=$group?></li>
		                      <?php endforeach?>
							</div>
						</div>
					</div>
					<?php
					/*<div class="form-group">
						<label class="control-label col-md-4 col-sm-4" for="websitetitle">Make Default Module:</label>
						<div class="col-md-6 col-sm-6">
							<?php if($this->BuilderEngine->get_option('be_blog_default_module') == 'yes')
						   	{
						   		$check1 = 'checked'; 
						   		$check2 = '';
						   	}
						   	else
						   	{
						   		$check1 = ''; 
						   		$check2 = 'checked';
						   	}
							?>										
							<label class="radio-inline">
                                <input type="radio" name="default_module" value="yes" <?=$check1?>/>Yes (Blog Index Page replaces the Homepage)
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="default_module" value="no" <?=$check2?>/>No 
                            </label>
						</div>
					</div>*/?>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4"></label>
						<div class="col-md-6 col-sm-6">
							<button type="submit" class="btn btn-primary">Save Settings</button>
						</div>
					</div>
                </form>
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
<?php $groups = new Group;?>
<script>
    $(document).ready(function (){
	    $('#access-groups').tagit({
	        fieldName: "access_groups",
	        singleField: true,
	        showAutocompleteOnFocus: true,
	        availableTags: [ <?php foreach ($groups->get() as $group): ?>"<?php echo $group->name?>", <?php endforeach;?>]
	    });
	});
</script>

		
