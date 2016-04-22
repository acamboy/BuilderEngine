<ol class="breadcrumb pull-right">
	<li><a href="<?=base_url();?>admin">Home</a></li>
	<li><a href="<?=base_url();?>admin/module/blog/settings">Blog</a></li>
	<li class="active">Show Posts</li>
</ol>
<h1 class="page-header">Edit / Show Blog Posts <small>Administration Control Panel</small></h1>
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
                <h4 class="panel-title">Search Results for Blog Posts</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Post Title</th>
                                <th>Post URL slug</th>
                                <th>Category</th>
								<th>Groups</th>
								<th>Comments</th>
								<th>Post Date</th>
								<th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php foreach($objects as $post):?>
                            <tr class="odd gradeX">
							
                                <td><?=stripslashes($post->title);?></td>
                                <td><?=$post->slug;?></td>
								
								<?php $categories = new Category;?>
								<?php foreach($categories->get() as $category):?>
								<?php if($category->id == $post->category_id):?>
                                <td><?=stripslashes($category->name);?></td>
								<?php endif?>
								<?php endforeach?>

								<td><?=$post->groups_allowed?></td>
								<td>
									<?php 
										if($post->comments_allowed == 'yes')
											echo 'Enabled';
										if($post->comments_allowed == 'no')
											echo 'Disabled,showing existing';
										if($post->comments_allowed == 'hide')
											echo 'Disabled,Hidden';
									?>								
								</td>
                                <td><?=date('d.m.Y',$post->time_created)?></td>
								
								<td>
                                    <div class="btn-group-vertical m-r-5">
                                        <a href="<?=base_url()?>blog/post/<?=$post->slug?>" type="button" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                                    </div>
                                    <?php if($condition) : ?>
    								    <div class="btn-group-vertical">
    							            <a href="<?=base_url()?>admin/module/blog/modify_object/post/<?=$post->id?>" type="button" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
    							        </div>
    							        <div class="btn-group-vertical m-r-5">
    							            <a href="<?=base_url()?>admin/module/blog/delete_object/post/<?=$post->id?>" type="button" class="btn btn-inverse"><i class="fa fa-remove"></i> Delete</a>
    							        </div>
                                    <?php endif; ?>
							    </td>
                            </tr>
                          <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
