<ol class="breadcrumb pull-right">
    <li><a href="<?=base_url();?>admin">Home</a></li>
    <li><a href="<?=base_url();?>admin/module/new_blog/settings">Pages</a></li>
    <li class="active">Show Pages</li>
</ol>
<h1 class="page-header">Edit / Show Pages <small>Administration Control Panel</small></h1>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Website Pages</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Page Title</th>
                                <th>Page Template Used</th>
                                <th>Groups</th>
                                <th>Creation Date</th>
                                <th>Author</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($pages as $result): ?>
                                <tr class="odd gradeX">
                                    <td><?=$result->title?></td>
                                    <td><?=$result->template?></td>
                                    <td><?=$result->groups?></td>
                                    <td><?=date("G:i:s d-m-Y", $result->date_created)?></td>
                                    <td><?=$result->author->username?></td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a href="<?=base_url('admin/module/page/edit_page').'/'.$result->id?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                        </div>
                                        <div class="btn-group-vertical m-r-5">
                                            <a href="<?=base_url('admin/module/page/delete_page').'/'.$result->id?>" class="btn btn-inverse" onclick="return confirm('Are you sure you want to permanently delete this page?')"><i class="fa fa-remove"></i> Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

