<?php echo get_header() ?>

<?php echo get_sidebar() ?>
<div id="content" class="content" style="min-height:800px">
<ol class="breadcrumb pull-right">
	<li><a href="<?=base_url();?>login">Home</a></li>
	<li><a href="#">Blog</a></li>
	<li class="active">View My Posts</li>
</ol>
<h1 class="page-header">View My Posts</h1>
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
                <h4 class="panel-title">Search Results for Posts</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Post Title</th>
                                <th>Post URL slug</th>
                                <th>Category</th>
								<th width="270">Groups</th>
								<th>Post Date</th>
								<th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php foreach($objects as $post):?>
                            <?php if($post->user_id == $id_user):?>
                                <tr class="odd gradeX">
    							
                                    <td><?=$post->title;?></td>
                                    <td><?=$post->slug;?></td>

     								<?php $categories = new Category;?>
    								<?php foreach($categories->get() as $category):?>
    								<?php if($category->id == $post->category_id):?>
                                    <td><?=$category->name;?></td>
    								<?php endif?>
    								<?php endforeach?>

    								<td><?=$post->groups_allowed?></td>
                                    <td><?=date('d.m.Y',$post->time_created)?></td>
    								
    								<td>
                                        <div class="btn-group-vertical m-r-5">
                                            <a href="<?=base_url()?>blog/post/<?=$post->slug?>" type="button" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                                        </div>
    								    <div class="btn-group-vertical">
    							            <a href="<?=base_url()?>user/blog/add_post/edit/<?=$post->id?>" type="button" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
    							        </div>
    							        <div class="btn-group-vertical m-r-5">
    							            <a href="<?=base_url()?>user/blog/delete_post/<?=$post->id?>" type="button" class="btn btn-inverse"><i class="fa fa-remove"></i> Delete</a>
    							        </div>
    							    </td>
                                </tr>
                            <?php endif?>
                          <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php echo get_footer()?>