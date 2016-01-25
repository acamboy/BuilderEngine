<ol class="breadcrumb pull-right">
	<li><a href="<?=base_url();?>admin">Home</a></li>
	<li><a href="<?=base_url();?>admin/module/blog/settings">Blog</a></li>
	<li class="active">Show Comment Reports</li>
</ol>
<h1 class="page-header">Show Comment Reports <small>Administration Control Panel</small></h1>
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
                <h4 class="panel-title">Search Results for Comment Reports</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Post name</th>
								<th>Reported on</th>
                                <th>Comment info</th>
                                <th>Report Contents</th>
								<th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;?>
                            <?php foreach($objects as $object):?>
                                <tr class="odd gradeX">
                                    <td><?=$i?></td>
    								<td>
                                        <?php $comment = new Comment($object->comment_id);?>
                                        <?=$comment->post->get()->title?>
                                    </td>
    								<td><?=date('H:i:s d/m/Y', $object->time_of_creation)?></td>
                                    <td> 
                                        <a href="<?=base_url('module/blog/post/'.$comment->post->get()->slug)?>" target="_blank" class="btn btn-success" type="button" ><i class="fa fa-edit"></i> View Comment</a>
                                    </td>
                                    <td> 
                                        <a href="<?=base_url('admin/module/blog/show_report/'.$object->id)?>"  type="button" class="btn btn-info"><i class="fa fa-remove"></i> View Report</a>
                                    </td>
    								<td> 
                                    <?php if (isset($object->comment_id) && !empty($object->comment_id)): ?>
                                        <div class="btn-group-vertical">
                                           <a href="<?=base_url('admin/module/blog/delete_comment/'.$object->comment_id)?>" class="btn btn-danger" type="button" ><i class="fa fa-edit"></i> Delete Comment</a>
                                        </div>
                                    <?php endif ?>
    						            <div class="btn-group-vertical m-r-5">
    						               <a href="<?=base_url('admin/module/blog/delete_report/'.$object->id)?>" type="button" class="btn btn-inverse"><i class="fa fa-remove"></i> Delete Report</a>
    						            </div>
    								</td>
                                </tr>
                                <?php $i++;?>
						    <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

