<?php echo get_header() ?>

<?php echo get_sidebar() ?>

    <!-- begin #content -->
    <div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="/admin">Home</a></li>
        <li><a href="#">User</a></li>
        <li class="active">Add New User</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Edit Account <small>Users Control Panel</small></h1>
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
                    <h4 class="panel-title">User / Member Details</h4>
                </div>
                <div class="panel-body panel-form">
                    <form class="form-horizontal form-bordered" enctype="multipart/form-data" data-parsley-validate="true" name="demo-form" method="post">
                        <input type="hidden" name="id" value="<?php echo $user_data->id?>">
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="fullname">Username:</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text"  value="<?php echo $user_data->username?>" id="username" name="username" placeholder="Required" data-parsley-required="true" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="fullname">First Name:</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text"  value="<?php echo $user_data->first_name?>" id="firstname" name="first_name" placeholder="First Name" data-parsley-required="true" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="fullname">Surname Name:</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" id="surname"  value="<?php echo $user_data->last_name?>" name="last_name" placeholder="Surname Name" data-parsley-required="true" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="fullname">Avatar:</label>
							<style>
								.file_preview {
									max-height: 100px;
									margin-top: 10px;
								}
							</style>
                            <div class="col-md-6 col-sm-6">
								<span class="btn btn-success fileinput-button">
                                    <i class="fa fa-plus"></i>
                                    <span>Add image...</span>
                                    <input type="file" name="avatar" id="uploadImage1" onchange="PreviewImage(1);$('#avat').show();$('#plc').remove();"><br/>
                                </span>
								<br/>
								<div id="avat" class="alert" style="display: block;width:130px;margin-top:10px;margin-bottom:10px;"> 
								<script>var input = "<input type=\"hidden\" name=\"avatar1\" value=\"<?=base_url('builderengine/public/img/avatar.png')?>\">";</script>
									<a class="close" onclick="$('#avat').hide();$('#plc').append(input).show();('#uploadImage1').remove();">×</a>  
									  <img id="uploadPreview1" src="<?=$user_data->avatar?>" width="80"/> 
								</div>
								<div id="plc" class="alert" style="display: none;width:130px;margin-top:10px;margin-bottom:10px;"> 
									<!--<a class="close" onclick="$('#plc').hide();$('#avat').show();">×</a> -->
									  <img id="uploadPreview1" src="<?=base_url('builderengine/public/img/avatar.png')?>" width="80"/>
									  
								</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="email">Email:</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" type="text" id="email"  value="<?php echo $user_data->email?>" name="email" data-parsley-type="email" placeholder="Email" data-parsley-required="true" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="fullname">Password:</label>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" name="password" id="password-indicator-visible" class="form-control m-b-5" />
                                    <div id="passwordStrengthDiv2" class="is0 m-t-5"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4"></label>
                            <div class="col-md-6 col-sm-6">
                                <button type="submit" class="btn btn-primary">Save</button>
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
<script>
    $('#user-groups-select').tagit({
        fieldName: "groups",
        singleField: true,
        showAutocompleteOnFocus: true,
        availableTags: [ <?php foreach ($groups as $group): ?>"<?php echo $group->name?>", <?php endforeach;?>]
    });

   function PreviewImage(no) {
        var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById("uploadImage"+no).files[0]);
		oFReader.onload = function (oFREvent) {
			document.getElementById("uploadPreview"+no).src = oFREvent.target.result;
		};
    };
</script>