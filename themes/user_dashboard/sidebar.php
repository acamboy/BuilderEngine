<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
<!-- begin sidebar scrollbar -->
<div data-scrollbar="true" data-height="100%">
<!-- begin sidebar user -->
<a href="<?=base_url()?>" style="text-decoration: none;">
<ul class="nav">
    <li class="nav-profile">
        <div class="image">
            <i class="fa fa-lock"></i>
        </div>
        <div class="info">
            <b>My Account</b>
            <small>Return To Website</small>
        </div>
    </li>
</ul>
</a>
<!-- end sidebar user -->
<!-- begin sidebar nav -->
<ul class="nav">
    <li class="nav-header">Members Control Panel</li>
    <li class="has-sub active">
        <a href="<?php echo home_url('login')?>">
            <b class="pull-right"></b>
            <i class="fa fa-laptop"></i>
            <span>Dashboard</span>
        </a>

    </li>
    <li class="has-sub">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-user"></i>
            <span>My Account Details</span>
        </a>
        <ul class="sub-menu" <?php if(isset($current_page) && ($current_page == 'users' || $current_page == 'groups')) echo 'style="display:block"';?>>
            <li><a <?=href("user", "main/edit/{$this->user->get_id()}")?> >Edit Account</a></li>
            <li><a <?=href("user", "main/groups")?> >View User Group</a></li>
        </ul>
    </li>
   
    <li class="has-sub">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-cogs"></i>
            <span>Settings</span>
        </a>
        <ul class="sub-menu" <?php if(isset($current_page) && $current_page == 'settings') echo 'style="display:block"';?>>
            <li><a <?=href("user", "settings/edit_settings")?>>Edit Settings</a></li>
        </ul>
    </li>
    <?php if(get_option('user_dashboard_blog') == 'yes'): ?>
    <li class="nav-header">Apps Control Panel</li>

	   <li class="has-sub">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-book"></i>
            <span>Blog</span>
        </a>
        <?php
            $groups_name = $this->users->get_user_group_name(get_active_user_id());
            $groups = array();
            $user_created_posts = '';
            $user_created_categories = '';

            foreach ($groups_name as $key => $value) {
                $group = $this->users->get_groups($value);

                if($group[0]->allow_posts)
                    $user_created_posts = 1;

                if($group[0]->allow_categories)
                    $user_created_categories = 1;

                $groups[] = $group[0];
            }
        ?>
       <ul class="sub-menu" <?php if(isset($current_page) && ($current_page == 'users' || $current_page == 'groups')) echo 'style="display:block"';?>>
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    Blog Posts
                </a>
                <ul class="sub-menu" <?php if(isset($current_page) && $current_page == 'groups') echo 'style="display:block"';?>>
                    <?php //if(get_option('user_created_posts') == 'yes'): ?>
                    <?php if($user_created_posts): ?>
                        <li><a <?php echo href("user", "blog/add_post/add")?>>Add New Post</a></li>
                    <?php endif; ?>
                    <li><a <?php echo href("user", "blog/posts")?>>View My Posts</a></li>
                </ul>
            </li>
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    Blog Categories
                </a>
                <ul class="sub-menu" <?php if(isset($current_page) && $current_page == 'groups') echo 'style="display:block"';?>>
                    <?php //if(get_option('user_created_categories') == 'yes'): ?>
                    <?php if($user_created_categories): ?>
                        <li><a <?php echo href("user", "blog/add_category/add")?>>Add New Category</a></li>
                    <?php endif; ?>
                    <li><a <?php echo href("user", "blog/categories")?>>View Categories</a></li>
                </ul>
            </li>
			
        </ul>
    </li>
    <?php endif; ?>
	<?php  if(get_option('user_dashboard_forum') == 'yes'):?>
	<li class="has-sub">
		<a href="javascript:;">
			<b class="caret pull-right"></b>
			<i class="fa fa-book"></i>
			<span>Forum</span>
		</a>
		<ul class="sub-menu">
            <li class="has-sub">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					Forum Posts
				</a>
                <ul class="sub-menu">
                    <li><a >View My Posts</a></li>
                </ul>
			</li>
		</ul>
	</li>
	<?php endif;?>
    <!-- begin sidebar minify button -->
    <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
    <!-- end sidebar minify button -->

</ul>
<!-- end sidebar nav -->
</div>
<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->