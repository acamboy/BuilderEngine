<?php require_once('assets_loader.php');?>

<div id="wrapper">
	<div id="blog">
	
		<header id="page-title">
			<div class="container">
				<h1>All Posts</h1>

				<ul class="breadcrumb">
					<li><a href="<?=base_url()?>">Home</a></li>
                    <li><a href="<?=base_url()?>blog/all_posts">Blog</a></li>
                    <li class="active">All Posts</li>
				</ul>
			</div>
		</header>

		<section class="container masonry-sidebar">
			<div class="row">
				<div class="col-md-9">
				
					<ul class="masonry-list">
					 <?php 	$post_limit = $this->BuilderEngine->get_option('be_blog_num_posts_displayed');
                        if($post_limit == '')
                            $post_limit = 4;
                        $i = 1;
					 ?>
                     <?php foreach($posts as $post):?>
					    <?php if($i <= $post_limit):?>
							<li class="masonry-item">
							
								<div class="item">
									<div class="item-title">
										<h2><a href="<?=base_url('blog/post').'/'.$post->slug?>"> <?=$post->title?></a></h2>
									    <a class="label label-default light"><i>Post by:</i> <?=$user->username;?></a> <br/>
									        <?php $post_comments = array();
											      $comments = new Comment;
				                                   foreach($comments->where('post_id',$post->id)->get() as $comment)
									                {array_push($post_comments,$comment->id);}
											      $num_comments = count($post_comments);
											      $pluralizer = ($num_comments == 1) ? 'Comment' : 'Comments' ;
									        ?>											
										<a href="<?=base_url('blog/post').'/'.$post->slug?>#comments" class="label label-default light"><i class="fa fa-comment-o"></i> <?=$num_comments?> <?=$pluralizer?></a>
										<span class="label label-default light"><?=date('M d, Y', $post->time_created)?></span> 
									</div>

									<figure>
										<a href="<?=base_url('blog/post').'/'.$post->slug?>"><img src="<?=(isset($post->image) && !empty($post->image)) ? $post->image:''?>" class="img-responsive" alt="<?=$post->slug?>" /></a>
									</figure>
									<?php
									$text_without_slashes = strip_tags(ChEditorfix($post->text));
                                    if(strlen($post->text) > 300)
                                    {
                                        $text = substr($text_without_slashes, 0, 300).'...';
                                    }
                                    else{
										$text = $text_without_slashes;
                                    }
                                    ?>
                                    <?=$text?>
                                    <a href="<?=base_url('/blog/post').'/'.$post->slug?>" class="btn btn-primary btn-xs pull-right"><i class="fa fa-sign-out"></i>READ MORE</a>

								</div>
							<br/>
<div class="divider"></div>
							</li>
							<?php $i++;?>
						<?php endif;?>
                      <?php endforeach?>
					</ul>

					<div class="clearfix"></div>

					<!-- PAGINATION -->
					<div class="text-center">
						<ul class="pagination">
							<?php $number_of_posts = $posts->count()?>
							<?php if(!$this->BuilderEngine->get_option('be_blog_num_posts_displayed'))
					        {
					            $posts_per_page = 6;
					        }
					        else
					            $posts_per_page = $this->BuilderEngine->get_option('be_blog_num_posts_displayed');?>
					        <?php $total_pages = ceil($number_of_posts / $posts_per_page);?>

					        <?php if(!isset($_GET['page']))
					        	$current_page = 1;
					       	else
					       		$current_page = $_GET['page'];?>

					       	<?php $back_page =  $current_page - 1;?>
					       	<?php if($back_page > 0):?>
								<li><a href="<?=base_url('blog/all_posts/?page='.$back_page)?>"><i style="font-size:20px" class="fa fa-chevron-left"></i></a></li>
							<?php endif;?>
							
					        <?php for ($i = 1; $i <= $total_pages; $i++):?>
					        	<li><a href="<?=base_url('blog/all_posts/?page='.$i)?>" <?php if($i == $current_page) echo 'class="active"'?>><?=$i?></a></li>
					        <?php endfor;?>

					        <?php $front_page =  $current_page + 1;?>
					       	<?php if($front_page <= $total_pages):?>
								<li><a href="<?=base_url('blog/all_posts/?page='.$front_page)?>"><i style="font-size:20px" class="fa fa-chevron-right"></i></a></li>
							<?php endif;?>
						</ul>
					</div>
					<!-- /PAGINATION -->

				</div>

				<div class="col-md-3">


					<!-- blog search -->
					<div class="widget">
						<h3>BLOG SEARCH</h3>
						<form method="get" action="<?=base_url('/blog/search')?>" class="input-group">
							<input type="text" style="height:46px;" class="form-control" name="keyword" placeholder="search..." />
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
						        <li id="parent<?=$i?>"><a href="<?=base_url('blog/category/'.$parent_category->id)?>"><i class="fa fa-plus-circle"></i><?=stripslashes($parent_category->name)?></a></li>
								  <ul class="child<?=$i?> nav nav-list" style="display:none;margin-left:10%">
						                <li><a href="<?=base_url('blog/category/'.$parent_category->id)?>"><i class="fa fa-th-large"></i>All Posts: <?=stripslashes($parent_category->name)?></a></li>
						            <?php foreach($categories as $category):?>
						              <?php if($category->parent_id == $parent_category->id):?>
						                <li><a href="<?=base_url('blog/category/'.$category->id)?>"><i class="fa fa-arrow-circle-o-right"></i><?=stripslashes($category->name)?></a></li>
						              <?php endif;?>

						            <?php endforeach;?>
						          </ul>
						      <?php else:?>
						        <li><a href="<?=base_url('blog/category/'.$parent_category->id)?>"><i class="fa fa-arrow-circle-o-right"></i><?=stripslashes($parent_category->name)?></a></li>
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
						});

						function createCallback( i ){
						  return function(event){
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
						<?php 						   $all_posts = new Post();
						   $recent_posts = $all_posts->order_by('time_created','desc');
						   $recent_post_limit = $this->BuilderEngine->get_option('be_blog_num_recent_posts_displayed');
                            if($recent_post_limit == '' || $recent_post_limit == 0)
                                $recent_post_limit = 5;
						   $j=1;
						?>
						<?php foreach ($recent_posts->get() as $recent_post):?>
					        <?php if($j <= $recent_post_limit):?>
							    <li><a href="<?=base_url()?>blog/post/<?=$recent_post->slug?>"><i class="fa fa-sign-out"></i> <?=stripslashes($recent_post->title)?></a> <small> <?=date('d.M.Y / h:i',$recent_post->time_created)?></small></li>
							<?php $j++?>
							<?php else:?>
                            <?php endif?>							
						<?php endforeach?>	
						</ul>

					</div>
					<!-- TAGS -->
					<?php if($this->BuilderEngine->get_option('be_blog_show_tags') != 'no'):?>
						<div class="widget">
							<h4>TAGS</h4>
							 <?php
							 $available_tags = array();
						        $set_limit = $this->BuilderEngine->get_option('be_blog_num_tags_displayed');
                                if($set_limit == '' || $set_limit == 0)
                                    $set_limit = 12;
							    foreach($posts as $post)
							    {
								   $tags = explode(',',$post->tags);	
	                                foreach($tags as $tag)
								    {
									    array_push($available_tags,$tag);
									}
							    }
                                $available_tags = array_unique($available_tags);
	                            $available_tags = array_slice($available_tags,0,$set_limit);
							?>
							    <?php foreach($available_tags as $tag):?>
							        <a class="label label-default light" href="<?=base_url('blog/search/'.stripslashes($tag))?>"><i class="fa fa-tags"></i> <?=stripslashes($tag)?></a>
							    <?php endforeach?>
							<div class="clearfix"></div>
						</div>
			        <?php endif;?>

				</div>

			</div>
		</section>

	</div>
</div>
<!-- /WRAPPER -->