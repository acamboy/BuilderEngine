<?php
    class Categories_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Blog";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Category List";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
            $categoty_count = $this->block->data('categoty_count');
            $alphabetical_order_categoty = $this->block->data('alphabetical_order_categoty');
            
            $count = array(
                "1" => "1",
                "2" => "2",
                "3" => "3",
                "4" => "4",
                "5" => "5",
                "all" => "All"
                );

            $option = array(
                "yes" => "Yes",
                "no" => "No"
                );
            $this->admin_select('categoty_count', $count, 'Post Count: ', $categoty_count);
            $this->admin_select('alphabetical_order_categoty', $option, 'Alphabetical Order (a-z): ', $alphabetical_order_categoty);
        }
        public function generate_style()
        {
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';

            $sections_font_color = $this->block->data('sections_font_color');
            $sections_font_weight = $this->block->data('sections_font_weight');
            $sections_font_size = $this->block->data('sections_font_size');
            $sections_background_color = $this->block->data('sections_background_color');
			$sections_animation_type = $this->block->data('sections_animation_type');	  
		    $sections_animation_duration = $this->block->data('sections_animation_duration');
		    $sections_animation_event = $this->block->data('sections_animation_event');
		    $sections_animation_delay = $this->block->data('sections_animation_delay');
            ?>
            <div role="tabpanel">
                <div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade in active" id="sections">
                        <?php
                        $this->admin_input('sections_font_color','text', 'Font color: ', $sections_font_color);
                        $this->admin_input('sections_font_weight','text', 'Font weight: ', $sections_font_weight);
                        $this->admin_input('sections_font_size','text', 'Font size: ', $sections_font_size);
                        $this->admin_input('sections_background_color','text', 'Background color: ', $sections_background_color);
						$this->admin_select('sections_animation_type', $types,'Animation type: ',$sections_animation_type);
						$this->admin_select('sections_animation_duration', $durations,'Animation duration: ',$sections_animation_duration);
						$this->admin_select('sections_animation_event', $events,'Animation Start: ',$sections_animation_event);
						$this->admin_select('sections_animation_delay', $delays,'Animation Delay: ',$sections_animation_delay);
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        public function generate_content()
        {
            $sections_font_color = $this->block->data('sections_font_color');
            $sections_font_weight = $this->block->data('sections_font_weight');
            $sections_font_size = $this->block->data('sections_font_size');
            $sections_background_color = $this->block->data('sections_background_color');
            $categoty_count = $this->block->data('categoty_count');
            $alphabetical_order_categoty = $this->block->data('alphabetical_order_categoty');

			$sections_animation_type = $this->block->data('sections_animation_type');	  
		    $sections_animation_duration = $this->block->data('sections_animation_duration');
		    $sections_animation_event = $this->block->data('sections_animation_event');
		    $sections_animation_delay = $this->block->data('sections_animation_delay');
			$settings[0][0] ='blog_cat';
			$settings[0][1] = $sections_animation_event;
			$settings[0][2] = $sections_animation_duration.' '.$sections_animation_delay.' '.$sections_animation_type;
			add_action("be_foot", generate_animation_events($settings));

            $section_style = 
                'style="
                    background:'.$sections_background_color.' !important;
                "';
            $section_link_style = 
                'style="
                    color: '.$sections_font_color.' !important;
                    font-weight: '.$sections_font_weight.' !important;
                    font-size: '.$sections_font_size.' !important;
                "';
			$section_color = 'style="color:'.$sections_font_color.' !important;"';
            $output = '
                    <link href="'.base_url('blocks/categories/style.css').'" rel="stylesheet">
					<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
					<div class="widgetblogcategorylist" id="blog_cat">
					<div class="masonry-item-blog-category-list" '.$section_style.'>
                        <h4 '.$section_color.'>BLOG CATEGORIES</h4>
                        <ul class="nav nav-list">
                            <li><a '.$section_link_style.' href="'.base_url('blog/all_posts').'"><i class="fa fa-th-large"></i> All Blog Posts</a></li>';
                            $i = 1;
                            $categories = new Category();
                            $categories = $categories->get();
                            if($categoty_count != '')
                                if($categoty_count == 'all'){
                                    $count = 0;
                                    foreach ($categories->all as $key => $value) {
                                        if($value->parent_id == 0)
                                            $count++;
                                    }
                                }else{
                                    $count = $categoty_count;
                                }
                            else
                                $count = 5;
                            $category_name = array();
                            foreach ($categories->all as $key => $value) {
                                if($value->parent_id == 0)
                                    array_push($category_name,$value->name);
                            }

                            if($alphabetical_order_categoty == 'yes')
                                asort($category_name);

                            foreach ($category_name as $key => $value) {
                                foreach($categories as $parent_category){
                                    if($value == $parent_category->name){
                                        if($i <= $count)
                                            if($parent_category->parent_id == 0){
                                                if($parent_category->has_children()){
                                                    $output .= '
                                                        <li id="parent'.$i.'"><a '.$section_link_style.' href="'.base_url('blog/category/'.$parent_category->id).'"><i class="fa fa-plus-circle"></i> '.$parent_category->name.'</a></li>
                                                            <ul class="child'.$i.'nav nav-list" style="display: none; margin-left: 10%">
                                                                  <li><a '.$section_link_style.' href="'.base_url('blog/category/'.$parent_category->id).'"><i class="fa fa-th-large"></i> All Posts: '.$parent_category->name.'</a></li>';
                                                                foreach($categories as $category){
                                                                    if($category->parent_id == $parent_category->id){
                                                                        $output .= '
                                                                        <li><a '.$section_link_style.' href="'.base_url('blog/category/'.$category->id).'"><i class="fa fa-arrow-circle-o-right"></i>'.$category->name.'</a></li>';
                                                                    }
                                                                }
                                                    $output .= '
                                                        </ul>';
                                                }else{
                                                    $output .= '
                                                        <li>
                                                            <a '.$section_link_style.' href="'.base_url('blog/category/'.$parent_category->id).'">
                                                                <i class="fa fa-arrow-circle-o-right"></i>
                                                            '.$parent_category->name.'</a>
                                                        </li>';
                                                }
                                            }
                                        $i++;
                                    }
                                }
                            }
            $output .= '
                        </ul>
                    </div></div>';
            return $output;
        }
        public function generate_admin_menus()
        {
        }
    }
?>