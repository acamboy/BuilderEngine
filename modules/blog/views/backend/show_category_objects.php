<ol class="breadcrumb pull-right">
	<li><a href="<?=base_url();?>admin">Home</a></li>
	<li><a href="<?=base_url();?>admin/module/blog/settings">Blog</a></li>
	<li class="active">Show Categories</li>
</ol>
<h1 class="page-header">Edit / Show Blog Categories <small>Administration Control Panel</small></h1>
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
                <h4 class="panel-title">Search Results for Blog Categories</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Parent Category</th>
								<th>Groups</th>
                                <?php if($condition) : ?>
								    <th>Actions</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach($objects as $object):?>
                            <tr class="odd gradeX">
                                <td><?=$object->name;?></td>
								<?php if($object->parent_id == 0):?>
                                <td>No Parent</td>
								<?php else:?>
								<?php $categories = new Category;?>
								<?php foreach($categories->where('id',$object->parent_id)->get() as $category): ?>
								<td><?=$category->name?></td>
                                <?php endforeach?>
								<?php endif?>
								<td><?=$object->groups_allowed?></td>
                                <?php if($condition) : ?>
    								<td> 
    							        <div class="btn-group-vertical">
    						               <a href="<?=base_url()?>admin/module/blog/modify_object/category/<?=$object->id?>" class="btn btn-success" type="button" ><i class="fa fa-edit"></i> Edit</a>
    						            </div>
    						            <div class="btn-group-vertical m-r-5">
    						               <a href="<?=base_url()?>admin/module/blog/delete_object/category/<?=$object->id?>" type="button" class="btn btn-inverse"><i class="fa fa-remove"></i> Delete</a>
    						            </div>
    								</td>
                                <?php endif; ?>
                            </tr>
						  <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

