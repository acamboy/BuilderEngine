<?php echo get_header() ?>

<?php echo get_sidebar() ?>

<!-- begin #content -->
<div id="content" class="content">
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="/admin">Home</a></li>
	 <li><a href="#">User</a></li>
	  <li class="active">Search Users</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Search / Edit Users <small>Administration Control Panel</small></h1>
<!-- end page-header -->
			<!-- begin row -->
			<div class="row">
			    <!-- begin col-12 -->
			    <div class="col-md-12">
				<div class="result-container">
			            <div class="input-group m-b-20">
                            <input type="text" class="form-control input-white" placeholder="Enter keywords here..." />
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-inverse"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                      </div>
			        <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                            <h4 class="panel-title">Search Results</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
											<th>Avatar</th>
                                            <th>First Name</th>
											<th>Surname</th>
                                            <th>Email</th>
                                            <th>Date Registered</th>
                                            <th>Group Level</th>
											<th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($search_results as $result): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $result->username?></td>
											<td><?php echo '<img src="'.$result->avatar.'" class="img-responsive" width="80">';?></td>
                                            <td><?php echo $result->first_name?></td>
                                            <td><?php echo $result->last_name?></td>
                                            <td><?php echo $result->email?></td>
                                            <td><?php echo date("G:i:s d-m-Y", $result->date_registered)?></td>
											<td><?php $usr = new User($result->id);
                                                $str = "";
                                                foreach($usr->group->get() as $group) $str .= $group->name.", ";
                                                $str = trim($str, ', ');
                                                echo $str;
                                                ?></td>
											<td><div class="btn-group-vertical">
										<a <?php echo href("admin", "user/edit/{$result->id}")?>class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
										</div>
										<div class="btn-group-vertical m-r-5">
										<a <?php echo href("admin", "user/delete/{$result->id}")?> class="btn btn-inverse" onclick="return confirm('Are you sure you want to permanently delete this user?')"><i class="fa fa-remove"></i> Delete</a>
										</div></td>
                                        </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->
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