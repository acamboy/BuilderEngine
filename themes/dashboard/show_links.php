<?php echo get_header() ?>

<?php echo get_sidebar() ?>

<!-- begin #content -->
<div id="content" class="content">
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="/admin">Home</a></li>
	 <li><a href="#">Navigation</a></li>
	  <li class="active">Edit / Show Links</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Navigation Edit / Show Links <small>Administration Control Panel</small></h1>
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
                            <h4 class="panel-title">Navigation / Main Menu Links</h4>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Link Name</th>
                                        <th>Link Target</th>
                                        <th>Title</th>
										<th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($this->links->get_all() as $link): ?>
                                    <?php if($link['parent'] != 0) continue?>
                                    <tr>
                                        <td><?php echo $link['name']?></td>
                                        <td><?php echo $link['target']?></td>
                                        <td><?php echo $link['title']?></td>
                                        <td><a href="<?php echo base_url()?>admin/links/edit/<?php echo $link['id']?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a> <a href="<?php echo base_url()?>admin/links/delete/<?php echo $link['id']?>" onclick="return confirm('Are you sure you want to permanently delete this link?')" class="btn btn-inverse"><i class="fa fa-remove"></i> Delete</a></td>
                                    </tr>
                                    <?php if($link['childs']):?>
                                        <?php foreach($link['childs'] as $sub_link): ?>
                                            <tr>
                                                <td>^=><?php echo $sub_link['name']?></td>
                                                <td><?php echo $sub_link['target']?></td>
                                                <td><?php echo $sub_link['title']?></td>
                                                <td><a href="<?php echo base_url()?>admin/links/edit/<?php echo $sub_link['id']?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a> <a href="<?php echo base_url()?>admin/links/delete/<?php echo $sub_link['id']?>" onclick="return confirm('Are you sure you want to permanently delete this link?')" class="btn btn-inverse"><i class="fa fa-remove"></i> Delete</a></td>
                                            </tr>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                <?php endforeach;?>
                                    
                                </tbody>
                            </table>
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