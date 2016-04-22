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
            $category_count = $this->block->data('category_count');
            $alphabetical_order_category = $this->block->data('alphabetical_order_category');
            
            $count = array(
                "1" => "1",
                "2" => "2",
                "3" => "3",
                "4" => "4",
                "5" => "5",
                "all" => "All"
                );

            $option = array(
                "az" => "Alphabetical from A to Z",
                "za" => "Alphabetical from Z to A",
				"latest" => "Latest categories",
				"oldest" => "Oldest categories",
				"updated" => "Updated categories",
				"most_visited" => "Most visited",
				"less_visited" => "Less visited"
                );
				
            $this->admin_select('category_count', $count, 'Post Count: ', $category_count);
            $this->admin_select('alphabetical_order_category', $option, 'Category Order: ', $alphabetical_order_category);
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
                        $custom_css = $this->block->data('custom_css');
                        $custom_classes = $this->block->data('custom_classes');
                        $this->admin_textarea('custom_css','Custom CSS: ', $custom_css, 4);
                        $this->admin_textarea('custom_classes','Custom Classes: ', $custom_classes, 2);
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        public function generate_content()
        {
            global $active_controller;
            $CI = &get_instance();
            $CI->load->module('layout_system');

            $CI->load->model('visits');
            $sequence = $CI->visits->popular_category_by_visits();

            $custom_css = $this->block->data('custom_css');
            $style_arr['text'] = ';'.$custom_css;
            $this->block->set_data("style", $style_arr);

            $sections_font_color = $this->block->data('sections_font_color');
            $sections_font_weight = $this->block->data('sections_font_weight');
            $sections_font_size = $this->block->data('sections_font_size');
            $sections_background_color = $this->block->data('sections_background_color');
            $category_count = $this->block->data('category_count');
            $alphabetical_order_category = $this->block->data('alphabetical_order_category');

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
							$all_categories = new Category();
                            $categories = new Category();
                            $categories = $categories->get();
							$all = $categories->count();
                            if($category_count != '')
                                if($category_count == 'all'){
                                    $count = $all;
                                    foreach ($categories->all as $key => $value) {
                                        if($value->parent_id == 0)
                                            $count++;
                                    }
                                }else{
                                    $count = $category_count;
                                }
                            else
                                $count = 5;
                            $category_name = array();
                            foreach ($categories->all as $key => $value) {
                                if($value->parent_id == 0)
                                    array_push($category_name,$value->name);
                            }

                            if($alphabetical_order_category == 'az')
                                asort($category_name);
                            if($alphabetical_order_category == 'za')
                                rsort($category_name);
							if($alphabetical_order_category == 'oldest'){
								$category_name = array();
								foreach ($categories->order_by('time_created','asc')->get() as $key => $value) {
									if($value->parent_id == 0)
										array_push($category_name,$value->name);
								}	
							}								
							if($alphabetical_order_category == 'latest'){
								$category_name = array();
								foreach ($categories->order_by('time_created','desc')->get() as $key => $value) {
									if($value->parent_id == 0)
										array_push($category_name,$value->name);
								}	
							}	
							if($alphabetical_order_category == 'updated'){
								$category_name = array();
								foreach ($categories->order_by('time_created','desc')->get() as $key => $value) {
									if($value->parent_id == 0)
										array_push($category_name,$value->name);
								}	
							}	
							if($alphabetical_order_category == 'most_visited')//ok
								arsort($sequence);
							if($alphabetical_order_category == 'less_visited')//ok
								asort($sequence);
	
							if($alphabetical_order_category == 'az' || $alphabetical_order_category == 'za' || $alphabetical_order_category == 'oldest' || $alphabetical_order_category == 'latest' || $alphabetical_order_category == 'updated'){
								foreach ($category_name as $key => $value) {
									foreach($categories as $parent_category){
										if($value == $parent_category->name){
											if($i <= $count)
												if($parent_category->parent_id == 0){
													if($parent_category->has_children()){
														$output .= '
															<li id="parent'.$i.'"><a '.$section_link_style.' href="'.base_url('blog/category/'.$parent_category->id).'"><i class="fa fa-plus-circle"></i> '.stripslashes($parent_category->name).'</a></li>
																<ul class="child'.$i.' nav nav-list" style="display: none; margin-left: 2%">
																	  <li><a '.$section_link_style.' href="'.base_url('blog/category/'.$parent_category->id).'"><i class="fa fa-th-large"></i> All Posts: '.stripslashes($parent_category->name).'</a></li>';
																	foreach($categories as $category){
																		if($category->parent_id == $parent_category->id){
																			$output .= '
																			<li><a '.$section_link_style.' href="'.base_url('blog/category/'.$category->id).'"><i class="fa fa-arrow-circle-o-right"></i>'.stripslashes($category->name).'</a></li>';
																		}
																	}
														$output .= '
															</ul>';
													}else{
														$output .= '
															<li>
																<a '.$section_link_style.' href="'.base_url('blog/category/'.$parent_category->id).'">
																	<i class="fa fa-arrow-circle-o-right"></i>
																'.stripslashes($parent_category->name).'</a>
															</li>';
													}
												}
											$i++;
										}
									}
								}
							}else{
								foreach ($sequence as $k => $v){
									foreach($categories as $parent_category){
										if($k == $parent_category->id){
											if($i <= $count)
												if($parent_category->parent_id == 0){
													if($parent_category->has_children()){
														$output .= '
															<li id="parent'.$i.'"><a '.$section_link_style.' href="'.base_url('blog/category/'.$parent_category->id).'"><i class="fa fa-plus-circle"></i> '.stripslashes($parent_category->name).'</a></li>
																<ul class="child'.$i.' nav nav-list" style="display: none; margin-left: 2%">
																	  <li><a '.$section_link_style.' href="'.base_url('blog/category/'.$parent_category->id).'"><i class="fa fa-th-large"></i> All Posts: '.stripslashes($parent_category->name).'</a></li>';
																	foreach($categories as $category){
																		if($category->parent_id == $parent_category->id){
																			$output .= '
																			<li><a '.$section_link_style.' href="'.base_url('blog/category/'.$category->id).'"><i class="fa fa-arrow-circle-o-right"></i>'.stripslashes($category->name).'</a></li>';
																		}
																	}
														$output .= '
															</ul>';
													}else{
														$output .= '
															<li>
																<a '.$section_link_style.' href="'.base_url('blog/category/'.$parent_category->id).'">
																	<i class="fa fa-arrow-circle-o-right"></i>
																'.stripslashes($parent_category->name).'</a>
															</li>';
													}
												}
											$i++;
										}
									}	
								}
							}
            $output .= '
                        </ul>
                    </div></div>
						<style>
						.visible-li
						{
						  display: block !important;
						}
						</style>';
						 $number_of_parents = $categories->where('parent_id', 0)->get()->count();
						$output .='<script>
						$(document).ready(function()
						{
						  var number = "'.$number_of_parents.'";
						  for (var i = 1; i < number; i++) 
						  {
						    $("#parent" + i).click( createCallback( i ) );
						  }
						});

						function createCallback( i ){
						  return function(event){
						    event.preventDefault();
						      if($(".child" + i).hasClass("visible-li"))
						        $(".child" + i).removeClass("visible-li");
						      else
						        $(".child" + i).addClass("visible-li");
						  }
						}
						</script>';

            return $output.$CI->layout_system->load_new_block_scripts($this->block->get_id(), '', $CI->BuilderEngine->get_page_path(), '', $this->block->get_name(), 'with_settings');
        }
    }
?>