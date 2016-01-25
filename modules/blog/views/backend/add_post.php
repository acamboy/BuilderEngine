<script src="<?=base_url('builderengine/public/js/editor/ckeditor.js')?>"></script>
<script type="text/javascript">
    $(document).ready(function (){
        CKEDITOR.replace( 'editor1' );
    });
// $(document).ready( function () {
//     $( '#post_contents').ckeditor({
//         toolbarGroups: [
//             { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },

//             { name: 'forms' },
//             '/',

//             { name: 'styles' },
//             { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
//             { name: 'insert' },
//             '/',
//             { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
//             { name: 'colors' },
//             { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
            
//             { name: 'links' },
//         ]

//     });

// });
</script>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title"><?=$page?> Blog Post</h4>
    </div>
    <div class="panel-body panel-form">
        <form class="form-horizontal form-bordered" data-parsley-validate="true" method="post" enctype="multipart/form-data" name="post">
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" for="title">Blog Title:</label>
				<div class="col-md-8 col-sm-8">
					<input class="form-control" type="text" id="title" name="title" value="<?=$object->title?>" data-parsley-required="true" required />
				</div>
			</div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4" for="slug">URL Slug:</label>
                <div class="col-md-8 col-sm-8">
                    <input class="form-control" type="text" id="slug" name="slug" placeholder="URL Address Link" value="<?=$object->slug?>" required />
                </div>
            </div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" for="blogimage">Blog Image:</label>
				<div class="col-md-6 col-sm-6">
					<span class="btn btn-success fileinput-button">
                <i class="fa fa-plus"></i>
                <span><?=$page?> Image</span>
				<style>
					.file_preview {
						max-height: 100px;
						margin-top: 10px;
					}
					.profile-avatar{
						float:none !important;
						    margin-left: -14px;
					}
					.profile-avatar img{
						width:100px !important;
						max-height:50%;
						max-width:50%;
					}
				</style>
                <input id="f" type="file" name="image" rel="file_manager" file_value="<?=$object->image?>">
            </span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" for="categoryselection">Category Selection:</label>
				<div class="col-md-8 col-sm-8">								
					<select class="form-control" id="select-required" name="category_id" data-parsley-required="true" required>
						<option value="">Select Category</option>					 
                        <?php $categories = new Category();?>
						<?php foreach($categories->get() as $category):?>
							<option value="<?=$category->id?>" <?php if($category->id == $object->category_id) echo 'selected'?>><?=$category->name?></option>
                        <?php endforeach?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" for="fullname">Allow Comments:</label>
				<div class="col-md-6 col-sm-6">
					<label class="radio-inline">
						<?php if($object->comments_allowed == 'yes') 
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
                      	<input type="radio" name="comments_allowed" value="yes" <?=$check1?>/>Yes
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="comments_allowed" value="no" <?=$check2?>/>No Comments
                    </label>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" for="website">Add Tags:</label>
				<div class="form-group">
					<div class="col-md-8 col-sm-8">
	                    <ul id="tags" class="white">
	                    	<?php if($page == 'Edit'):?>
								<?php $tags = explode(',', $object->tags);?>
								<?php foreach($tags as $tag):?>
								 	<li><?=$tag?></li>
								<?php endforeach?>
							<?php endif;?>
	                    </ul>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" for="website">Groups (Accounts) Access Allowed:</label>
				<div class="form-group">
					<div class="col-md-8 col-sm-8">
	                    <ul id="access-groups">
	                    	<?php if($page == 'Edit'):?>
								<?php $groups = explode(',', $object->groups_allowed);?>
								<?php foreach($groups as $group):?>
								 	<li><?=$group?></li>
								<?php endforeach?>
							<?php else:?>
								<li>Guests</li>
                            	<li>Members</li>
							<?php endif;?>
	                    </ul>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4" for="blogname">Blog Content:</label>
				<div class="col-md-8 col-sm-8">
					<div class="panel-body panel-form">
			        <textarea class="ckeditor" id="editor1" name="text" rows="20"><?=ChEditorfix($object->text)?></textarea>
				</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4"></label>
				<div class="col-md-6 col-sm-6">
					<button type="submit" class="btn btn-primary"><?=$page?> Post</button>
				</div>
			</div>
			<input type="hidden" name="user_id" id="user_id" value="<?=$this->user->id?>">
        </form>
    </div>
</div>
<?php $groups = new Group;?>
<script>
    $(document).ready(function (){
	    $('#access-groups').tagit({
	        fieldName: "groups_allowed",
	        singleField: true,
	        showAutocompleteOnFocus: true,
	        availableTags: [ <?php foreach ($groups->get() as $group): ?>"<?php echo $group->name?>", <?php endforeach;?>]
	    });
	    $('#tags').tagit({
	        fieldName: "tags",
	        singleField: true,
	        showAutocompleteOnFocus: true
	    });
	});
</script>
<script>
    function convertToSlug(Text)
    {
        return Text
            .toLowerCase()
            .replace(/ /g,'-')
            .replace(/[^\w-]+/g,'')
            ;
    }
    $(document).ready(function (){
        $("#title").keyup(function() {
            $("#slug").val($("#title").val());
            $("#slug").change();
        });

        $("#slug").keyup(function() {
            $("#slug").change();
        });
        $("#slug").change(function() {
            $("#slug").val(convertToSlug($("#slug").val()));
        });
		
		$("#f").click(function(e){
		   e.preventDefault();
		});
    });
</script>