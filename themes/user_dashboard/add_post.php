<?php echo get_header() ?>

<?php echo get_sidebar() ?>
<div id="content" class="content" style="min-height:800px">
<ol class="breadcrumb pull-right">
	<li><a href="#">Home</a></li>
	<li><a href="#">Blog</a></li>
	<li class="active"><?=$page?> Post</li>
</ol>
<h1 class="page-header"><?=$page?> Post</h1>

<script src="<?php echo get_theme_path()?>assets/plugins/jquery-1.8.2/jquery-1.8.2.min.js"></script>
<script src="<?=base_url('/builderengine/public/js/editor/ckeditor.js')?>">
</script>
<script type="text/javascript">
    $(document).ready(function (){
        CKEDITOR.replace( 'editor1',{
			toolbarGroups:[
				{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
				{ name: 'forms' },
				'/',
				{ name: 'styles' },
				{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
				'/',
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
				{ name: 'colors' },
				{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
				{ name: 'links' },
			]
		});
    });
</script>
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
		        <h4 class="panel-title"><?=$page?> Post</h4>
		    </div>
		    <div class="panel-body panel-form">
		        <form class="form-horizontal form-bordered" data-parsley-validate="true" method="post" enctype="multipart/form-data" name="post">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4" for="title">Post Title:</label>
						<div class="col-md-8 col-sm-8">
							<input class="form-control" type="text" id="title" name="title" value="<?=$object->title?>" data-parsley-required="true" />
						</div>
					</div>
		            <div class="form-group">
		                <label class="control-label col-md-4 col-sm-4" for="slug">URL Slug:</label>
		                <div class="col-md-8 col-sm-8">
		                    <input class="form-control" type="text" id="slug" name="slug" placeholder="URL Address Link" value="<?=$object->slug?>" />
		                </div>
		            </div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4" for="blogimage">Post Image:</label>
						<div class="col-md-6 col-sm-6">
							<span class="btn btn-success fileinput-button">
								<i class="fa fa-plus"></i>
								<span><?=$page?> Image</span>
                                    <input type="file" name="image" id="uploadImage1" onchange="PreviewImage(1);$('#avat').show();$('#plc').remove();"><br/>
                                </span>
								<br/>
								<div id="avat" class="alert" style="display: block;width:130px;margin-top:10px;margin-bottom:10px;"> 
								<script>var input = "<input type=\"hidden\" name=\"image\" value=\"<?=base_url('builderengine/public/img/photo_placeholder.png')?>\">";</script>
									<a class="close" onclick="$('#avat').hide();$('#plc').append(input).show();('#uploadImage1').remove();">×</a> 
									<?php if($object->image==''){$object->image = base_url().'builderengine/public/img/photo_placeholder.png';}?>
									  <img id="uploadPreview1" src="<?=$object->image?>" width="80"/> 
								</div>
								<div id="plc" class="alert" style="display: none;width:130px;margin-top:10px;margin-bottom:10px;"> 
									<!--<a class="close" onclick="$('#plc').hide();$('#avat').show();">×</a> -->
									  <img id="uploadPreview1" src="<?=base_url('builderengine/public/img/photo_placeholder.png')?>" width="80"/>
									  
								</div>
						</div>
					</div>
			        <?php
			            $groups_name = $this->users->get_user_group_name(get_active_user_id());
			            $groups = array();
			            $use_created_categories = '';

			            foreach ($groups_name as $key => $value) {
			                $group = $this->users->get_groups($value);

			                if($group[0]->use_created_categories)
			                    $use_created_categories = 1;

			                $groups[] = $group[0];
			            }
			        ?>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4" for="categoryselection">Category Selection:</label>
						<div class="col-md-8 col-sm-8">								
							<select class="form-control" id="select-required" name="category_id" data-parsley-required="true">
								<option value="">Select Category</option>
								<?php //if(get_option('user_created_categories') == 'yes'):?>
								<?php if($use_created_categories):?>
			                        <?php $categories = new Category();?>
									<?php foreach($categories->get() as $category):?>
										<option value="<?=$category->id?>" <?php if($category->id == $object->category_id) echo 'selected'?>><?=$category->name?></option>
			                        <?php endforeach?>
		                        <?else:?>
									<?php foreach($default_user_post_category as $category):?>
										<option value="<?=$category->id?>" <?php if($category->id == $object->category_id) echo 'selected'?>><?=$category->name?></option>
			                        <?php endforeach?>
								<?php endif; ?>
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
						<label class="control-label col-md-4 col-sm-4" for="blogname">Post Content:</label>
						<div class="col-md-8 col-sm-8">
							<div class="panel-body panel-form">
					        <textarea class="ckeditor" id="editor1" name="text" rows="20"><?=ChEditorfix($object->text)?></textarea>
						</div>
						</div>
						<label class="control-label col-md-4 col-sm-4" for="blogname">Add Image:</label>
						<div class="col-md-8 col-sm-8">
							<div class="panel-body panel-form">
					        <input class="form-control" type="file" id="img" name="img">
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
    </div>
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
    });
   function PreviewImage(no) {
        var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById("uploadImage"+no).files[0]);
		oFReader.onload = function (oFREvent) {
			document.getElementById("uploadPreview"+no).src = oFREvent.target.result;
		};
    };
</script>
<?php echo get_footer()?>