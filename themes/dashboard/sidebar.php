<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
<!-- begin sidebar scrollbar -->
<div data-scrollbar="true" data-height="100%">
<!-- begin sidebar user -->
<a href="<?=base_url('/editor')?>" style="text-decoration: none;">
<ul class="nav">
    <li class="nav-profile">
        <div class="image">
            <i class="fa fa-edit"></i>
        </div>
        <div class="info">
            <b>Frontend</b>
            <small>Edit / View Website</small>
        </div>
    </li>
</ul>
</a>
<!-- end sidebar user -->
<!-- begin sidebar nav -->
<ul class="nav">
    <li class="nav-header">Administration Panel</li>
    <li class="has-sub active">
        <a href="<?php echo home_url('admin')?>">
            <b class="pull-right"></b>
            <i class="fa fa-laptop"></i>
            <span>Dashboard</span>
        </a>

    </li>
    <li class="has-sub">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-users"></i>
            <span>User Accounts</span>
        </a>
        <ul class="sub-menu" <?php if(isset($current_page) && ($current_page == 'users' || $current_page == 'groups')) echo 'style="display:block"';?>>
            <li><a <?php echo href("admin", "user/add")?>>Add New User</a></li>
            <li><a <?php echo href("admin", "user/search")?>>Search Users</a></li>
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    User Group Accounts
                </a>
                <ul class="sub-menu" <?php if(isset($current_page) && $current_page == 'groups') echo 'style="display:block"';?>>
                    <li><a <?php echo href("admin", "user/add_group")?>>Add New Group</a></li>
                    <li><a <?php echo href("admin", "user/groups")?>>Edit/Show Groups</a></li>
                </ul>
            </li>
			<li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    User Register Settings
                </a>
                <ul class="sub-menu" <?php if(isset($current_child_page) && $current_child_page == 'register') echo 'style="display:block"';?>>
                    <li><a <?php echo href("admin", "user/register_settings")?>>Sign-up Verification</a></li>
                    <li><a <?php echo href("admin", "user/register_email_settings")?>>Email Messages</a></li>
                    <li><a <?php echo href("admin", "user/register_glogbal_settings")?>>Global Settings</a></li>
                </ul>
            </li>
			<li><a <?php echo href("admin", "user/user_dashboard_settings")?>>User Dashboard</a></li>
        </ul>
    </li>
    <li class="has-sub">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-link"></i>
            <span>Navigation Links</span>
        </a>
        <ul class="sub-menu" <?php if(isset($current_page) && $current_page == 'navigation') echo 'style="display:block"';?>>
            <li><a <?php echo href("admin", "links/add")?>>Add New Link</a></li>
            <li><a <?php echo href("admin", "links/show")?>>Edit/Show Links</a></li>
        </ul>
    </li>
    <!--<li class="has-sub">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-newspaper-o"></i>
            <span>Website Pages</span>
        </a>
        <ul class="sub-menu">
            <li><a href="add_page.html">Add New Page</a></li>
            <li><a href="pages_search.html">Edit/Show Pages</a></li>
        </ul>
    </li>-->
    <?php
    $links = get_admin_links();
    foreach($links as $key => $menu):
        $module = $key;
        $module[0] = strtoupper($module[0]);
        ?>
        <?php if($module == 'Pages'):?>
            <li class="has-sub">
                <a href="#">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-file-o"></i>
                    <span><?php echo 'Website Pages';?></span>
                </a> 
                <ul class="sub-menu">
                    <?php foreach( $links[$key] as $sub_key => $link):

                        ?>
                            <?php if(is_array($links[$key][$sub_key])): ?>
                        <li class="has-sub">
                            <a href="javascript:;">
                                <?php else: ?>
                        <li>
                        <?php // echo $link;?>
                                <a href="<?php echo $link?>">
                                    <?php endif;?>
                                    <?php echo $sub_key?>
                                </a>
                                <?php if(is_array($links[$key][$sub_key])): ?>
                                    <ul class="sub">
                                        <?php foreach($links[$key][$sub_key] as $sub_sub_key => $link): ?>
                                            <li>
                                                <a href="<?php echo $link?>">
                                                    <?php echo $sub_sub_key?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                        </li>
                    <?php endforeach; ?>

                </ul>
            </li>
        <?php endif;?>
    <?php endforeach; ?>
    <li class="has-sub">
        <a <?php echo href("admin", "files/show")?>>
            <i class="fa fa-floppy-o"></i>
            <span>File Manager</span></span>
        </a>
    </li>
    <li class="has-sub">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-cogs"></i>
            <span>Settings</span>
        </a>
        <ul class="sub-menu" <?php if(isset($current_page) && $current_page == 'settings') echo 'style="display:block"';?>>
            <li><a <?php echo href("admin", "main/settings")?>>Website Settings</a></li>
            <li><a <?php echo href("admin", "main/seo_settings")?>>Search Engine Settings</a></li>
            <li><a <?php echo href("admin", "modules/show")?>>Edit/Show Modules</a></li>
            <li><a <?php echo href("admin", "backup/backup")?>>Backup</a></li>
            <li><a <?php echo href("admin", "backup/restore")?>>Restore</a></li>
        </ul>
    </li>
    <li class="has-sub">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-th"></i>
            <span>Templates</span>
        </a>
        <ul class="sub-menu">
            <li><a <?php echo href("admin", "themes/show")?>>Edit/View Themes</a></li>
        </ul>
    </li>
    <li class="nav-header">Modules / Apps Panel</li>

	    <?php

    $links = get_admin_links();
    foreach($links as $key => $menu):
        $module = $key;
        $module[0] = strtoupper($module[0]);
        ?>
        <?php if($module != 'Pages'):?>
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-cube"></i>
                    <span><?php echo $module?></span>
                </a>
                <ul class="sub-menu">
                    <?php foreach( $links[$key] as $sub_key => $link):

                        ?>

                            <?php if(is_array($links[$key][$sub_key])): ?>
                        <li class="has-sub">
                            <a href="javascript:;">
                                <?php else: ?>
                        <li>
                                <a href="<?php echo $link?>">
                                    <?php endif;?>
                                    <b class="caret pull-right"></b>
                                    <?php echo $sub_key?>
                                </a>
                                <?php if(is_array($links[$key][$sub_key])): ?>
                                    <ul class="sub-menu">
                                        <?php foreach($links[$key][$sub_key] as $sub_sub_key => $link): ?>
                                            <li>
                                                <a href="<?php echo $link?>">
                                                    <?php echo $sub_sub_key?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                        </li>
                    <?php endforeach; ?>

                </ul>
            </li>
        <?php endif;?>

    <?php endforeach; ?>
    <li class="nav-header">Marketplace Panel</li>
    <li class="has-sub color-green">
        <a href="javascript:;">
            <i class="fa fa-cloud"></i>
            <span>Cloud Apps / Packages</span>
        </a>
    </li>
    <li class="has-sub">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-shopping-cart"></i>
            <span>BuilderMarket</span>
        </a>
       <!--  <ul class="sub-menu">
            <li><a <?php echo href("admin", "module/builder_market/modules")?>>Modules / Apps</a></li>
            <li><a <?php echo href("admin", "module/builder_market/themes")?> >Template Themes</a></li>
            <li><a <?php echo href("admin", "module/builder_market/blocks")?>>Blocks</a></li>
        </ul>-->
    </li>

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