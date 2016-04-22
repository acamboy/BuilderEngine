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
                            <form class="form-horizontal form-bordered" method="post" data-parsley-validate="true" name="demo-form">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="websitetitle">Website Title:</label>
									<div class="col-md-6 col-sm-6">
										<input class="form-control" type="text" value="<?php echo $builderengine->get_option("website_title");?>" id="websitetitle" name="website_title" placeholder="Enter Default Name / Title for Website" data-parsley-required="true" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="websitekeywords">Website Keywords:</label>
									<div class="col-md-6 col-sm-6">
										<input class="form-control" type="text" id="websitekeywords" name="website_keywords" value="<?php echo $builderengine->get_option("website_keywords");?>" placeholder="Enter Default Keywords for Website" data-parsley-required="true" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="websitedesc">Website Description:</label>
									<div class="col-md-6 col-sm-6">
                                        <textarea class="form-control" placeholder="Enter Default Description for Website" rows="5" name="website_description"><?php echo $builderengine->get_option("website_description");?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="website">Default Group Access Allowed for Website:</label>
									<div class="form-group">
									<div class="col-md-8 col-sm-8">
                                        <ul id="jquery">
										<?php $default_groups = explode(',',$default_website_access_groups);?>
										<?php foreach($default_groups as $default_group):?>
											<li value="<?=$default_group?>"><?=$default_group?></li>
										<?php endforeach;?>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="ect">Erase Content Tools:</label>
									<div class="col-md-6 col-sm-6">
										<?php if( $erase_content_control == 'off' || empty($erase_content_control))
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
											<input type="radio" id="erase_content_control" name="erase_content_control" value="off" <?php echo $check1?>/>
											Off
										</label>
										<label class="radio-inline">
											<input type="radio" id="erase_content_control" name="erase_content_control" value="on" <?php echo $check2?>/>
											On
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" for="adminemail">Admin Email:</label>
									<div class="col-md-6 col-sm-6">
										<input class="form-control" type="text" id="adminemail" value="<?php echo $builderengine->get_option("adminemail");?>" name="adminemail" placeholder="Enter Default Email Address for Admin" data-parsley-required="true" />
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4"></label>
									<div class="col-md-6 col-sm-6">
										<button type="submit" class="btn btn-primary">Save Settings</button>
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
<?php $groups = new Group;?>
<script>
    $(document).ready(function (){
	    $('#jquery').tagit({
	        fieldName: "default_website_access_group",
	        singleField: true,
	        showAutocompleteOnFocus: true,
	        availableTags: [ <?php foreach ($groups->get() as $group): ?>"<?php echo $group->name?>", <?php endforeach;?>]
	    });
	});
</script>