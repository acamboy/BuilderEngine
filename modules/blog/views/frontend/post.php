<?php require_once('assets_loader.php');?>
<div id="wrapper">
	<div id="blog">

		<header id="page-title">
			<div class="container">
                <?php $cat = $categories->where('id',$post->category_id)->get();?>
                <h1><?=$cat->name?></h1>

				<ul class="breadcrumb">
					<li><a href="<?=base_url()?>">Home</a></li>
					<li><a href="<?=base_url()?>blog/all_posts">Blog</a></li>		
					<li><a href="<?=base_url()?>blog/category/<?=$post->category_id?>"><?=$cat->name?></a></li>
					<li class="active"><?=$post->title?></li>
				</ul>
			</div>
		</header>

		<section class="container">
			<div class="row">
				<div class="left col-md-9">
					<header class="blog-post">
						<h1><?=$post->title?></h1>
						<small class="space18">
					         <?php $post_comments=array();?>
                             <?php foreach($comments as $comment)
					          {array_push($post_comments,$comment->id);}
					         ?>							
							<a href="#comments" class="scrollTo label label-default light"><i class="fa fa-comment-o"></i> <?=$count = count($post_comments);?> <?=$pluralizer = ($count == 1) ? 'Comment' : 'Comments' ;?></a>
							<span class="label label-default light"> <?=date('d.M.Y',$post->time_created)?></span> 
							<span class="label label-default pull-right"><span><i>Post by:</i></span> <span class="light" ><a href="#"><?=$pub_user->username;?></a></span></span>
						</small>
					</header>

					<?php if(!empty($post->image)): ?>
					<div class="item" style="padding-bottom:0px">
						<img src="<?=$post->image?>" class="img-responsive" alt="<?=$post->slug?>" />
					</div>
					<?php endif; ?>

					<article>
                        <?=str_replace('\"','"',ChEditorfix($post->text))?>
					</article>

					<hr />

					<?php 
					/*<p class="socials">
						<a href="#" class="rounded-icon social fa fa-facebook"><!-- facebook --></a>
						<a href="#" class="rounded-icon social fa fa-twitter"><!-- twitter --></a>
						<a href="#" class="rounded-icon social fa fa-google-plus"><!-- google plus --></a>
						<a href="#" class="rounded-icon social fa fa-pinterest"><!-- pinterest --></a>
						<a href="#" class="rounded-icon social fa fa-linkedin"><!-- linkedin --></a>
					</p>*/?>

					<?php if($this->BuilderEngine->get_option('be_blog_show_tags') != 'no'): ?>
						<p class="space16"> <b>Tags:</b>
	                        <?php foreach($post as $item): ?>
	                        	<?php if($item->tags != ''): ?>
							    	<?php $tags = explode(',',$item->tags); ?>
								    <?php foreach($tags as $tag): ?>
								        <a class="label label-default light" href="<?=base_url('blog/search/'.$tag)?>" ><i class="fa fa-tags"></i> <?=$tag?></a> 
									<?php endforeach; ?>
								<?php else: ?>
									-
								<?php endif; ?>
							<?php endforeach; ?>
							<div class="clearfix"></div>
						</p>
					<?php endif;?>

					<div class="divider"></div>

                <?php $comments_alowed = 'no';foreach( $post->stored as $key => $val ){ if( $key == 'comments_allowed' && $val == 'yes'){ $comments_alowed = 'yes';}}?>
                <?php if($comments_alowed == 'yes' && $this->BuilderEngine->get_option('be_blog_allow_comments') != 'no'):?>
					<div id="comments">
						<h4><?=$count?> <?=$pluralizer?></h4>

						<?php $i = 1;?>
					 	<?php foreach($comments->all as $comment):?>
						<div class="comment">
							<span class="user-avatar">
								<?php if($comment->user_id == 0 || $comment->user_id == ''):?>
									<img class="pull-left media-object" src="<?=get_theme_path()?>/images/avatars/no_avatar.jpg" width="64" height="64" alt="">
								<?php else:?>
									<?php $commenter = new User($comment->user_id);?>
									<?php $users = new Users();?>
									<?php $allow_avatar = new Setting();?>
									<?php
										if($users->is_admin_by_id($comment->user_id) || isset($allow_avatar->get_user_settings($comment->user_id)->all[0]->allow_avatar) && $allow_avatar->get_user_settings($comment->user_id)->all[0]->allow_avatar != 0)
											$allow_avatar = 1;
										else
											$allow_avatar = 0;
									?>
									<?php if((!isset($commenter->avatar) || $commenter->avatar == '') || !intval($allow_avatar)):?>
										<img class="pull-left media-object" src="<?=get_theme_path()?>/images/avatars/no_avatar.jpg" width="64" height="64" alt="">
									<?php else:?>
										<img class="pull-left media-object" src="<?=$commenter->avatar?>" width="64" height="64" alt="">
									<?php endif;?>
								<?php endif;?>
							</span>

							<div class="media-body">
								<h3 class="media-heading bold"><?=$comment->name;?></h3>
								<small class="block"><?=date('d.M.Y - h:i',$comment->time_created)?></small>
								<br/>
								<?=$comment->text?>
							</div>

							<div class="btn-group pull-right" role="group">
								<a href="#commentForm" data-toggle="modal" data-target="#report<?=$i?>" class="btn btn-danger">Report</a>
								<?php if($this->user->is_member_of("Administrators")): ?>
									<a href="javascript:;" data-id="<?=$comment->id?>" class="btn btn-danger delete-comment">Delete</a>
								<?php endif; ?>
							</div>
							<!-- Modal -->
							<div class="modal fade" id="report<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							  	<div class="modal-dialog" style="z-index:10">
							    	<div class="modal-content">
							      		<div class="modal-header">
							        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        		<h4 class="modal-title" id="myModalLabel">Report Comment</h4>
							      		</div>
							      		<form method="post" action="<?=base_url('blog/report_comment/')?>">
								      		<div class="modal-body">
								      			<input type="hidden" name="comment_id" value="<?=$comment->id?>">
								        		<p>Please describe what aspect of this comment or it's author you find inadequate, inappropriate or insulting</p>
									        	<div class="form-group">
												    <textarea class="form-control" name="text" placeholder="Describe your reason for reporting this comment"></textarea>
												</div>
								      		</div>
									      	<div class="modal-footer">
									        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									        	<button type="submit" name="report" class="btn btn-primary">Report</button>
									      	</div>
								    	</form>
							    	</div>
							  	</div>
							</div>
						</div>
						<?php $i++;?>
					  	<?php endforeach?>
					  	<?php if($this->BuilderEngine->get_option('be_blog_comments_private') == 'private'):?>
					  		<?php if(!$user->is_guest()): ?>
								<br/>
							  	<div class="divider"></div>
								<h4>Leave a comment</h4>
								<form id="commentForm" class="form-horizontal" method="post">
		                            <input type="hidden" name="post_id" value="<?=$post->id?>">
									<div class="row">
										<div class="col-md-12">
											<textarea required class="form-control input-lg" id="comment" name="text" rows="5" placeholder="Your Comment"><?=set_value('text')?></textarea>
											<?=form_error('text')?>
										</div>
									</div>
									<br>
									<?php $check_captcha = $this->BuilderEngine->get_option('be_blog_captcha') == 'yes'; ?>
									<?php if($check_captcha): ?>
									<div class="row">
										<div class="col-md-2">
											<label>Captcha *</label>
										</div>
										<div class="col-md-3">
											<input required class="form-control input-lg" type="text" name="captcha" id="captcha" />
										</div>
										<div class="col-md-4">
											<?=$captcha?>
										</div>
										<div class="clearfix"></div>
										<?=form_error('captcha')?>
									</div>
									<?php endif; ?>
									<div class="row">
										<div class="col-md-12">
											<p><button class="btn btn-primary">Post Comment</button></p>
										</div>
									</div>
								</form>
							<?php endif; ?>
						<?php else: ?>
							<br/>
						  	<div class="divider"></div>
							<h4>Leave a comment</h4>
							<form id="commentForm" class="form-horizontal" method="post">
								<div class="row">
	                             	<input type="hidden" name="post_id" value="<?=$post->id?>">
	                             	<?php if(!empty($user) && isset($user) && $user->is_guest()) :?>
										<div class="col-md-4">
											<label>Name *</label>
											<input required class="form-control input-lg" type="text" name="name" id="author" value="<?=set_value('name')?>" />
											<?=form_error('name')?>
										</div>
										<?php
										/*<div class="col-md-4">
											<label>Email *</label>
											<input required class="form-control input-lg" type="text" name="author_email" id="email" value="" />
										</div>*/?>
									<?php endif; ?>
								</div>
								<div class="row">
									<div class="col-md-12">
										<textarea required class="form-control input-lg" id="comment" name="text" rows="5" placeholder="Your Comment"><?=set_value('text')?></textarea>
										<?=form_error('text')?>
									</div>
								</div>
								<br>
								<?php $check_captcha = $this->BuilderEngine->get_option('be_blog_captcha') == 'yes'; ?>
								<?php if($check_captcha): ?>
								<div class="row">
									<div class="col-md-2">
										<label>Captcha *</label>
									</div>
									<div class="col-md-3">
										<input required class="form-control input-lg" type="text" name="captcha" id="captcha" />
									</div>
									<div class="col-md-4">
										<?=$captcha?>
									</div>
									<div class="clearfix"></div>
									<?=form_error('captcha')?>
								</div>
								<?php endif; ?>
								<div class="row">
									<div class="col-md-12">
										<p><button class="btn btn-primary">Post Comment</button></p>
									</div>
								</div>
							</form>
						<?php endif; ?>
					</div>
				<?php endif;?>
				</div>

				<!-- SIDEBAR -->
				<div class="col-md-3">

					<div class="widget">
						<h3>BLOG SEARCH</h3>
						<form method="get" action="<?=base_url('/blog/search')?>" class="input-group">
							<input type="text" class="form-control" name="keyword" placeholder="search..." />
							<span class="input-group-btn">
								<button class="btn btn-primary"><i class="fa fa-search"></i></button>
							</span>
						</form>
					</div>

					<!-- Categories -->
					<div class="widget">
						<h3>CATEGORIES</h3>
						<ul class="nav nav-list">
						  <li><a href="<?=base_url('blog/all_posts')?>"><i class="fa fa-th-large"></i>All Posts</a></li>
						  <?php $i = 1;?>
						  <?php $categories = new Category();?>
						  <?php $categories = $categories->get();?>
						  <?php foreach($categories as $parent_category):?>
						    <?php if($parent_category->parent_id == 0):?>

						      <?php if($parent_category->has_children()):?>
						        <li id="parent<?=$i?>"><a href="<?=base_url('blog/category/'.$parent_category->id)?>"><i class="fa fa-plus-circle"></i><?=$parent_category->name?></a></li>
						          <ul class="child<?=$i?> nav nav-list" style="display: none; margin-left: 10%">
						                <li><a href="<?=base_url('blog/category/'.$parent_category->id)?>"><i class="fa fa-th-large"></i>All Posts: <?=$parent_category->name?></a></li>
						            <?php foreach($categories as $category):?>
						              <?php if($category->parent_id == $parent_category->id):?>
						                <li><a href="<?=base_url('blog/category/'.$category->id)?>"><i class="fa fa-arrow-circle-o-right"></i><?=$category->name?></a></li>
						              <?php endif;?>
						            <?php endforeach;?>
						          </ul>
						      <?php else:?>
						        <li><a href="<?=base_url('blog/category/'.$parent_category->id)?>"><i class="fa fa-arrow-circle-o-right"></i><?=$parent_category->name?></a></li>
						      <?php endif;?>

						    <?php endif;?>
						    <?php $i++;?>
						  <?php endforeach;?>
						</ul>

						<style>
						.visible-li
						{
						  display: block !important;
						}
						</style>
						<?php $number_of_parents = $categories->where('parent_id', 0)->get()->count();?>
						<script>
						$(document).ready(function()
						{
							var number = "<?=$number_of_parents?>";
							for (var i = 1; i < number; i++) 
							{
								$("#parent" + i).click( createCallback( i ) );
							}

							$('.delete-comment').click(function(e){
								e.preventDefault();
								var id = $(this).attr('data-id');
								$('#delete-comment input[name=comment_id]').val(id);
								$('#delete-comment').modal('show');
							})

						});

						function createCallback( i ){
							return function(){
								event.preventDefault();
								if($(".child" + i).hasClass('visible-li'))
									$(".child" + i).removeClass('visible-li');
								else
									$(".child" + i).addClass('visible-li');
							}
						}
						</script>
					</div>
					<!-- recent posts -->
					<div class="widget">

						<h4>RECENT POSTS</h4>

						<ul class="nav nav-list">
						<?php
						   $all_posts = new Post();
						   $recent_posts = $all_posts->order_by('time_created','desc');
						   $recent_post_limit = $this->BuilderEngine->get_option('be_blog_num_recent_posts_displayed');
                            if($recent_post_limit == '' || $recent_post_limit == 0)
                                $recent_post_limit = 5;
						   $j=1;
						?>
						<?php foreach ($recent_posts->get() as $recent_post):?>
					        <?php if($j <= $recent_post_limit):?>
							    <li><a href="<?=base_url()?>blog/post/<?=$recent_post->slug?>"><i class="fa fa-sign-out"></i> <?=$recent_post->title?></a> <small> <?=date('d.M.Y / h:i',$recent_post->time_created)?></small></li>
							<?php $j++?>
							<?php else:?>
                            <?php endif?>							
						<?php endforeach?>	
						</ul>
					</div>
				</aside>
				<!-- /SIDEBAR -->
			</div>
		</section>
	</div>
</div>
<!-- /WRAPPER -->
<?php if($this->user->is_member_of("Administrators")): ?>
<div class="modal fade" id="delete-comment" tabindex="-1" role="dialog" aria-hidden="true">
  	<div class="modal-dialog" style="z-index:10">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title">Delete comment</h4>
      		</div>
      		<form method="post" action="<?=base_url('blog/deleteComment')?>">
      			<div class="modal-body">
	        		<p>Are you sure you want to delete this comment?</p>
	        		<input type="hidden" name="comment_id">
	      		</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        	<button type="submit" class="btn btn-primary">Delete</button>
		      	</div>
	    	</form>
    	</div>
  	</div>
</div>
<?php endif; ?>