<?php echo get_header() ?>

<?php echo get_sidebar() ?>
    <!-- begin #content -->
    <div id="content" class="content" style="min-height:800px">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="/admin">Home</a></li>
            <li><a href="#">Modules</a></li>
            <li class="active">Edit Module</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Edit Module <small>Administration Control Panel</small></h1>
        <!-- end page-header -->
        <!-- begin row -->
        <div class="row">
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
                        <h4 class="panel-title">Module Details</h4>
                    </div>
                    <div class="panel-body panel-form">
                        <?php
                        $frontend_groups = $module->permissions['frontend']['names'];
                            if(count($frontend_groups) == 0)
                                $frontend_groups = "Members, Guests";
                            else
                                $frontend_groups = implode(",", $frontend_groups);

                            $backend_groups = $module->permissions['backend']['names'];
                            if(count($backend_groups) == 0)
                                $backend_groups = "Administrators";
                            else
                                $backend_groups = implode(",", $backend_groups);
                        ?>
                        <!-- -->
                        <form class="form-horizontal form-bordered" data-parsley-validate="true" name="demo-form" method="post">
                            <input type="hidden" name='id' value='<?php echo $module->id?>'>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" for="fullname">Module Name:</label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" name="name" value='<?php echo $module->name?>' class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" style="margin-top: 1.2%;" for="website">Access Groups:</label>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6">
                                        <ul id="access-groups">
                                            <?php foreach ($module->permissions['frontend']['names'] as $permission):?>
                                                <li><?php echo $permission?></li>
                                            <?php endforeach;?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4" style="margin-top: 1.2%;" for="website">Admin Groups:</label>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6">
                                        <ul id="admin-groups">
                                            <?php foreach ($module->permissions['backend']['names'] as $permission):?>
                                                <li><?php echo $permission?></li>
                                            <?php endforeach;?>
                                        </ul>
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
                        <!-- -->
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
    </div><!-- End .main  -->
<?php echo get_footer()?>
<script>
    $('#access-groups').tagit({
        fieldName: "frontend-groups",
        singleField: true,
        showAutocompleteOnFocus: true,
        availableTags: [ <?php foreach ($groups as $group): ?>"<?php echo $group->name?>", <?php endforeach;?>]
    });
    $('#admin-groups').tagit({
        fieldName: "backend-groups",
        singleField: true,
        showAutocompleteOnFocus: true,
        availableTags: [ <?php foreach ($groups as $group): ?>"<?php echo $group->name?>", <?php endforeach;?>]
    });
</script>