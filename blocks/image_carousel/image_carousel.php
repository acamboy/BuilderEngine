<?php
	global $carousel_js_settings;

        function initialize_custom_carousel_js()
        {
            global $carousel_js_settings;

            echo "
				<script type=\"text/javascript\" src=\"".base_url('blocks/image_carousel/js/owl.carousel.js')."\"></script>
				<script>
					$(document).ready(function() {
					  $(\"#owl-one\").owlCarousel({
						  autoPlay:true,
						  navigation : {$carousel_js_settings[0]}, // Show next and prev buttons
						  slideSpeed : {$carousel_js_settings[1]},
						  paginationSpeed : {$carousel_js_settings[2]},
						  singleItem:true,
					  });
					});
				</script>
            ";
        }
		add_action("be_foot", "initialize_custom_carousel_js");

    class image_carousel_block_handler extends block_handler
	{
        function info()
        {
            $info['category_name'] = "Core";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Image Carousel";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
		
		public function generate_admin()
		{
			$image1 = $this->block->data('image1');
			$image2 = $this->block->data('image2');
			$image3 = $this->block->data('image3');
			global $carousel_js_settings;
			$carousel_js_settings[0] = $this->block->data('carousel_navigation');
			$carousel_js_settings[1] = $this->block->data('carousel_speed');
			$carousel_js_settings[2] = $this->block->data('carousel_pagination_speed');
			
			$this->admin_select('carousel_type',array("custom" => "Image Carousel"),'Carousel Type');
			$this->admin_select('carousel_navigation',array("true" => "Show Navigation","false" => "Hide Navigation"),'Controls: ');
			$this->admin_select('carousel_speed',array("300" => "300 (ms)", "600" => "600 (ms)"),'Slide Speed (ms)');
			$this->admin_select('carousel_pagination_speed',array("300" => "300 (ms)", "600" => "600 (ms)"),'Pagination Speed (ms)');
			if(empty($image1))
                $image1 = "/files/blogimage.jpg";
			if(empty($image2))
				$image2 = "/files/blogimage.jpg";
			if(empty($image3))
				$image3 = "/files/blogimage.jpg";
			?>
			<style>
				.btn{height:35px !important;width:140px !important;}
			</style>
			<?php
			$this->admin_file('image1','Image 1: ', $image1, 'imgcar1'.$this->block->get_id(), true);
			$this->admin_file('image2','Image 2: ', $image2, 'imgcar2'.$this->block->get_id(), true);
			$this->admin_file('image3','Image 3: ', $image3, 'imgcar3'.$this->block->get_id(), true);
			?>
			<script>
				$("#imgcar1<?=$this->block->get_id()?>").click(function(e){
				   e.preventDefault();
				});	
				$("#imgcar2<?=$this->block->get_id()?>").click(function(e){
				   e.preventDefault();
				});	
				$("#imgcar3<?=$this->block->get_id()?>").click(function(e){
				   e.preventDefault();
				});					
			</script>			
			<?php
		}
		
		public function generate_style()
		{
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';

			$image1_animation_type = $this->block->data('image1_animation_type');	  
		    $image1_animation_duration = $this->block->data('image1_animation_duration');
		    $image1_animation_event = $this->block->data('image1_animation_event');
		    $image1_animation_delay = $this->block->data('image1_animation_delay');

			$image2_animation_type = $this->block->data('image2_animation_type');	  
		    $image2_animation_duration = $this->block->data('image2_animation_duration');
		    $image2_animation_event = $this->block->data('image2_animation_event');
		    $image2_animation_delay = $this->block->data('image2_animation_delay');

			$image3_animation_type = $this->block->data('image3_animation_type');	  
		    $image3_animation_duration = $this->block->data('image3_animation_duration');
		    $image3_animation_event = $this->block->data('image3_animation_event');
		    $image3_animation_delay = $this->block->data('image3_animation_delay');
	
          ?>
          <div role="tabpanel">

              <ul class="nav nav-tabs" role="tablist" style="margin-left: -20px;">
                  <li role="presentation" class="active"><a href="#img1" aria-controls="img1" role="tab" data-toggle="tab">Image 1</a></li>
                  <li role="presentation"><a href="#img2" aria-controls="img2" role="tab" data-toggle="tab">Image 2</a></li>
                  <li role="presentation"><a href="#img3" aria-controls="img3" role="tab" data-toggle="tab">Image 3</a></li>
				  <li role="presentation"><a href="#customcss" aria-controls="customcss" role="tab" data-toggle="tab">Custom CSS</a></li>
              </ul>

              <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade in active" id="img1">
                      <?php
						$this->admin_select('image1_animation_type', $types,'Animation type: ',$image1_animation_type);
						$this->admin_select('image1_animation_duration', $durations,'Animation duration: ',$image1_animation_duration);
						$this->admin_select('image1_animation_event', $events,'Animation Start: ',$image1_animation_event);
						$this->admin_select('image1_animation_delay', $delays,'Animation Delay: ',$image1_animation_delay);					  
                      ?>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="img2">
                      <?php
						$this->admin_select('image2_animation_type', $types,'Animation type: ',$image2_animation_type);
						$this->admin_select('image2_animation_duration', $durations,'Animation duration: ',$image2_animation_duration);
						$this->admin_select('image2_animation_event', $events,'Animation Start: ',$image2_animation_event);
						$this->admin_select('image2_animation_delay', $delays,'Animation Delay: ',$image2_animation_delay);				  
                      ?>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="img3">
                      <?php
						$this->admin_select('image3_animation_type', $types,'Animation type: ',$image3_animation_type);
						$this->admin_select('image3_animation_duration', $durations,'Animation duration: ',$image3_animation_duration);
						$this->admin_select('image3_animation_event', $events,'Animation Start: ',$image3_animation_event);
						$this->admin_select('image3_animation_delay', $delays,'Animation Delay: ',$image3_animation_delay);
                      ?>
                  </div>
				  <div role="tabpanel" class="tab-pane fade" id="customcss">
					  <?php
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
			global $carousel_js_settings;
			$image1 = $this->block->data('image1');
			$image2 = $this->block->data('image2');
			$image3 = $this->block->data('image3');
			
			$image1_animation_type = $this->block->data('image1_animation_type');	  
		    $image1_animation_duration = $this->block->data('image1_animation_duration');
		    $image1_animation_event = $this->block->data('image1_animation_event');
		    $image1_animation_delay = $this->block->data('image1_animation_delay');

			$image2_animation_type = $this->block->data('image2_animation_type');	  
		    $image2_animation_duration = $this->block->data('image2_animation_duration');
		    $image2_animation_event = $this->block->data('image2_animation_event');
		    $image2_animation_delay = $this->block->data('image2_animation_delay');

			$image3_animation_type = $this->block->data('image3_animation_type');	  
		    $image3_animation_duration = $this->block->data('image3_animation_duration');
		    $image3_animation_event = $this->block->data('image3_animation_event');
		    $image3_animation_delay = $this->block->data('image3_animation_delay');

			$settings[0][0] = 'imgcrs1'.$this->block->get_id();
			$settings[0][1] = $image1_animation_event;
			$settings[0][2] = $image1_animation_duration.' '.$image1_animation_delay.' '.$image1_animation_type;
			$settings[1][0] = 'imgcrs2'.$this->block->get_id();
			$settings[1][1] = $image2_animation_event;
			$settings[1][2] = $image2_animation_duration.' '.$image2_animation_delay.' '.$image2_animation_type;
			$settings[2][0] = 'imgcrs3'.$this->block->get_id();
			$settings[2][1] = $image3_animation_event;
			$settings[2][2] = $image3_animation_duration.' '.$image3_animation_delay.' '.$image3_animation_type;
			add_action("be_foot", generate_animation_events($settings));
			
			$carousel_js_settings[0] = $this->block->data('carousel_navigation');
			$carousel_js_settings[1] = $this->block->data('carousel_speed');
			$carousel_js_settings[2] = $this->block->data('carousel_pagination_speed');
			if(empty($carousel_js_settings[0]))
				$carousel_js_settings[0] = 'true';
			if(empty($carousel_js_settings[1]))
				$carousel_js_settings[1] = '300';
			if(empty($carousel_js_settings[2]))
				$carousel_js_settings[2] = '300';		
				
            switch ($this->block->data('carousel_type'))
            {
                case "custom":
                    return $this->output_custom_carousel();
                    break;
                default:
                    return $this->output_custom_carousel();
                    break;
            }
		}
		
		public function output_custom_carousel()
		{
			global $active_controller;
			$CI = &get_instance();
			$CI->load->module('layout_system');

			$custom_css = $this->block->data('custom_css');
			$style_arr['text'] = ';'.$custom_css;
			$this->block->set_data("style", $style_arr);

			$image1 = $this->block->data('image1');
			$image2 = $this->block->data('image2');
			$image3 = $this->block->data('image3');
			if(empty($image1))
                $image1 = "/files/blogimage.jpg";
			if(empty($image2))
				$image2 = "/files/blogimage.jpg";
			if(empty($image3))
				$image3 = "/files/blogimage.jpg";
			$output ='
				<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet">
				<link href="'.base_url('blocks/image_carousel/css/owl.carousel.css').'" rel="stylesheet">
				<link href="'.base_url('blocks/image_carousel/css/owl.theme.css').'" rel="stylesheet">
				<style>
					#owl-one .item img{
						display: block;
						width: 100%;
						height: auto;
					}
				</style>
				<div class="owl-container">
					<div id="demo-one-'.$this->block->get_id().'">
						<div id="owl-one" class="owl-carousel">
							  <div id="imgcrs1'.$this->block->get_id().'" class="item"><img src="'.$image1.'" alt="The Last of us"></div>
							  <div id="imgcrs2'.$this->block->get_id().'" class="item"><img src="'.$image2.'" alt="The Last of us"></div>
							  <div id="imgcrs3'.$this->block->get_id().'" class="item"><img src="'.$image3.'" alt="The Last of us"></div>
						</div>
					</div>
				</div>';

			return $output.$CI->layout_system->load_new_block_scripts($this->block->get_id(), '', $CI->BuilderEngine->get_page_path(), '', $this->block->get_name(), 'with_settings');
		}

    }
?>