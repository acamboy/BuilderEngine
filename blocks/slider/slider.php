<?php
global $flexslider_js_settings;

        function initialize_flexslider_js()
        {
            global $flexslider_js_settings;
            echo "
            <script type=\"text/javascript\" src=\"".base_url()."blocks/slider/js/jquery.flexslider-min.js\"></script>

            <script>
                $(document).ready(function() {
                    $('#flexslider-{$flexslider_js_settings[5]}').flexslider({
                        animation: \"slide\",
                        direction: \"{$flexslider_js_settings[0]}\",
                        controlNav: {$flexslider_js_settings[1]},
                        directionNav: {$flexslider_js_settings[2]},
                        pauseOnHover: {$flexslider_js_settings[3]},
                        slideshowSpeed: {$flexslider_js_settings[4]}
                   });
                });
            </script>
            ";
        }
        add_action("be_foot", "initialize_flexslider_js");

        class slider_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Core";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Slider";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
            $slide_titles = $this->block->data('slide_title');
            $slide_url = $this->block->data('slide_url');
            $slide_images = $this->block->data('slide_image');
            $slide_texts = $this->block->data('slide_text');
            
            if(!is_array($slide_titles) || empty($slide_titles))
            {
                $slide_titles[0] = "Example Slide";
                $slide_url[0] = "#";
                $slide_images[0] = "#";
                $slide_texts[0] = "This is a nice new slider. Click edit to customize.";
                $slide_titles[1] = "Example Slide";
                $slide_url[1] = "#";
                $slide_images[1] = "#";
                $slide_texts[1] = "This is a nice new slider. Click edit to customize.";

            }
            $num_slides = count($slide_titles);
            end($slide_titles);
            $last_key = key($slide_titles) + 1;
            reset($slide_titles);
            ?>

            <!-- Nav tabs -->
            <script>
            var num_slides = <?=$num_slides?>;
            var new_slide_number = <?=$last_key?>;
            <?php if($num_slides == 0): ?>
            var num_slides = 1;
            <?php endif;?>

            $(document).ready(function (){
                $("#myTab a").click(function (e) {
                  e.preventDefault();
                  $(this).tab("show");
                });

                $(".delete-slide").bind("click.delete_slide",function (e) {
                    slide = $(this).attr('slide');
                    $("#slide-section-" + slide).remove();
                    $("#slide-section-tab-" + slide).remove();

                });

                $("#add-slide").click(function (e) {
                    num_slides++;
                    $("#slide-section-tabs").append('<li id="slide-section-tab-' + num_slides +'"><a href="#slide-section-' + num_slides + '" data-toggle="tab">Slide ' + num_slides + '</a></li>');
                
                    $("#slide-sections").append('\
                        <div class="tab-pane" id="slide-section-' + num_slides + '">\
                          \
                        </div>\
                            ');
                    e.preventDefault();

                    html = $("#slide-section-template").html();
                    $("#slide-section-" + num_slides).html(html);
                    $('#slides a:last').tab('show');
                    $('#slide-section-' + num_slides).find('.delete-slide').attr('slide', num_slides);
                    $('#slide-section-' + num_slides).find('[name="test_image"]').attr('name', 'slide_image[' + (new_slide_number) + ']');
                    $('#slide-section-' + num_slides).find('[name="test_title"]').attr('name', 'slide_title[' + (new_slide_number) + ']');
                    $('#slide-section-' + num_slides).find('[name="test_url"]').attr('name', 'slide_url[' + (new_slide_number) + ']');
                    $('#slide-section-' + num_slides).find('[name="test_text"]').attr('name', 'slide_text[' + (new_slide_number) + ']');
                    $('#slide-section-' + num_slides).find('[name="test_image_old"]').attr('onclick', 'file_manager(\'slide_image[' + (new_slide_number) + ']\')');
                    $('#slide-section-' + num_slides).find('[name="test_image_old"]').attr('name', 'slide_image[' + (new_slide_number) + ']_old');
                    $(".delete-slide").unbind("click.delete_slide");
                    $(".delete-slide").bind("click.delete_slide",function (e) {
                        slide = $(this).attr('slide');
                        $("#slide-section-" + slide).remove();
                        $("#slide-section-tab-" + slide).remove();
                        $('#slides a:first').tab('show');
                    });
                    new_slide_number++;
                });
            });
            </script>
            <style>
            #settings-content .form-group
            {
                margin-left:0px !important;
                width:90% !important;
            }
            </style>
                <ul id="myTab" class="nav nav-tabs" style="margin-left:-15px">
                    <li class="active"><a href="#general" data-toggle="tab">General</a></li>
                    <li><a href="#settings" data-toggle="tab">Settings</a></li>
                    <li><a href="#slides" data-toggle="tab">Slides</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="general">
                        <?php $this->admin_select('slider_type',array("flexslider" => "FlexSlider"),'Slider Type');?>
                    </div>
                    <div class="tab-pane" id="settings">
                        <div class="tabbable tabs-left">
                            <ul class="nav nav-tabs" id="slider-settings">
                                <li class="active"><a href="#slider-settings-flexslider" data-toggle="tab">FlexSlider</a></li>
                            </ul>
                            <div class="tab-content" id="settings-content" style="height: 240px; overflow-y: scroll">
                                <div class="tab-pane active" id="slider-settings-flexslider" >
                                    <?php
                                    $this->admin_select('flexslider_settings_direction',array("horizontal" => "Horizontal","vertical" => "Vertical"),'Direction');
                                    $this->admin_input('flexslider_settings_slideshowSpeed',"text",'Speed (ms)', '10000');
                                    $this->admin_select('flexslider_settings_pauseOnHover',array("true" => "Yes","false" => "No"),'Pause on hover');
                                    $this->admin_select('flexslider_settings_directionNav',array("true" => "Yes","false" => "No"),'Direction Nav');
                                    $this->admin_select('flexslider_settings_controlNav',array("true" => "Yes","false" => "No"),'Control Nav');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="slides">
                        <div class="tabbable tabs-left">
                            <ul class="nav nav-tabs" id="slide-section-tabs">
                                <li style="height:42px"><span style="height: 100%;padding-top: 10px;" id="add-slide" class="btn btn-primary">Add Slide</span></li>
                                <?$i = 1;?>
                                <?php foreach($slide_titles as $key => $slide_title):?>
                                    <li class="<?php if($i == 1) echo 'active'?>" id="slide-section-tab-<?=$i?>"><a href="#slide-section-<?=$i?>" data-toggle="tab">Slide <?=$i?></a></li>
                                    <?$i++;?>
                                <?php endforeach; ?>

                                <?php if($num_slides == 0): ?>
                                    <li class="active"><a href="#slide-section-1" data-toggle="tab">Slide 1</a></li>
                                <?php endif;?>
                            </ul>
                            <div class="tab-content" id="slide-sections">
                                <!-- Template for creation -->
                                <div class="tab-pane" id="slide-section-template">
                                    <?php
                                    $this->admin_input('test_title','text','Title: ', '');
                                    $this->admin_input('test_url','text','Link Address: ', '');
                                    $this->admin_textarea('test_text','Slide Text: ', '');
                                    $this->admin_file('test_image','Image: ', '', 'slider1'.$this->block->get_id().$i, true );
                                    ?>
									<script>
										$("#slider1<?=$this->block->get_id().$i?>").click(function(e){
										   e.preventDefault();
										});						
									</script>									
                                    <span style="margin-left:25px" class="btn btn-danger delete-slide" slide="template">Delete Slide</span>
                                </div>
                                <!-- /Template for creation -->
                                <?$i = 1;?>
                                <?php foreach($slide_titles as $key => $slide_title):?>
                                    <div class="tab-pane <?php if($i == 1) echo 'active'?>" id="slide-section-<?=$i?>">
                                        <?php
                                        $this->admin_input('slide_title['.$key.']','text','Title: ', $slide_titles[$key]);
                                        $this->admin_input('slide_url['.$key.']','text','Link Address: ', $slide_url[$key]);
                                        $this->admin_textarea('slide_text['.$key.']','Slide Text: ', $slide_texts[$key]);
                                        $this->admin_file('slide_image['.$key.']','Image: ', $slide_images[$key], 'slider2'.$this->block->get_id().$i, true );
                                        ?>
										<script>
											$("#slider2<?=$this->block->get_id().$i?>").click(function(e){
											   e.preventDefault();
											});						
										</script>
                                        <span style="margin-left:25px" class="btn btn-danger delete-slide" slide="<?=$i?>">Delete Slide</span>
                                    </div>
                                    <?$i++;?>
                                <?php endforeach; ?>

                                <?php if($num_slides == 0): ?>
                                    <div class="tab-pane active" id="slide-section-1">
                                        <?php
                                        $this->admin_input('slide_title[0]','text','Title: ');
                                        $this->admin_input('slide_url[0]','text','Link Address: ');
                                        $this->admin_textarea('slide_text[0]','Slide Text: ');
                                        $this->admin_file('slide_image[0]','Image: ', '', 'slider3'.$this->block->get_id().$i, true );
                                        ?>
										<script>
											$("#slider3<?=$this->block->get_id().$i?>").click(function(e){
											   e.preventDefault();
											});						
										</script>										
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
		public function generate_style()
		{
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';
			
            $title_color = $this->block->data('title_color');
			$title_background_color = $this->block->data('text_background_color');
            $text_color = $this->block->data('text_color');		
			$text_background_color = $this->block->data('text_background_color');
			$title_animation_type = $this->block->data('title_animation_type');	  
		    $title_animation_duration = $this->block->data('title_animation_duration');
		    $title_animation_event = $this->block->data('title_animation_event');
		    $title_animation_delay = $this->block->data('title_animation_delay');
			$text_animation_type = $this->block->data('text_animation_type');	  
			$text_animation_duration = $this->block->data('text_animation_duration');
			$text_animation_event = $this->block->data('text_animation_event');
			$text_animation_delay = $this->block->data('text_animation_delay');
			
			?>
            <div role="tabpanel">
			
                <ul class="nav nav-tabs" role="tablist" style="margin-left: -20px;">
					<li role="presentation" class="active"><a href="#title" aria-controls="title" role="tab" data-toggle="tab">Title</a></li>
                    <li role="presentation"><a href="#text" aria-controls="text1" role="tab" data-toggle="tab">Text</a></li>
                </ul>
				
                <div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade in active" id="title">
                        <?php
                        $this->admin_input('title_color','text', 'Font color: ', $title_color);
                        $this->admin_input('title_background_color','text', 'Background color: ', $title_background_color);
					    $this->admin_select('title_animation_type', $types,'Animation type: ',$title_animation_type);
					    $this->admin_select('title_animation_duration', $durations,'Animation duration: ',$title_animation_duration);
					    $this->admin_select('title_animation_event', $events,'Animation Start: ',$title_animation_event);
					    $this->admin_select('title_animation_delay', $delays,'Animation Delay: ',$title_animation_delay);
                        ?>
                    </div>
                     <div role="tabpanel" class="tab-pane fade" id="text">
                        <?php
                        $this->admin_input('text_color','text', 'Font color: ', $text_color);
                        $this->admin_input('text_background_color','text', 'Background color: ', $text_background_color);
					    $this->admin_select('text_animation_type', $types,'Animation type: ',$text_animation_type);
					    $this->admin_select('text_animation_duration', $durations,'Animation duration: ',$text_animation_duration);
					    $this->admin_select('text_animation_event', $events,'Animation Start: ',$text_animation_event);
					    $this->admin_select('text_animation_delay', $delays,'Animation Delay: ',$text_animation_delay);
                        ?>
                    </div>
                </div>
            </div>			
			<?php
		}
		
        public function generate_content()
        {
            global $flexslider_js_settings;

            $flexslider_js_settings[0] = $this->block->data('flexslider_settings_direction');
            $flexslider_js_settings[1] = $this->block->data('flexslider_settings_controlNav');
            $flexslider_js_settings[2] = $this->block->data('flexslider_settings_directionNav');
            $flexslider_js_settings[3] = $this->block->data('flexslider_settings_pauseOnHover');
            $flexslider_js_settings[4] = $this->block->data('flexslider_settings_slideshowSpeed');
            $flexslider_js_settings[5] = $this->block->name;

            $slide_titles = $this->block->data('slide_title');


            if(!is_array($slide_titles) || empty($slide_titles))
            {
                $this->block->force_data_modification();

                $this->block->set_data('slide_title', array("Example Slide","Example Slide #2"));
                $this->block->set_data('slide_url', array("#","#"));
                $this->block->set_data('slide_image', array("/files/blogimage.jpg","/blocks/slider/images/sliderimg.jpg"));
                $this->block->set_data('slide_text', array("This is a nice new slider. Click edit to customize.","This is a nice new 2nd slider. Click edit to customize."));
                $this->block->set_data('slider_type', 'flexslider');
            }
            switch ($this->block->data('slider_type'))
            {
                case "flexslider":
                    return $this->output_flexslider();
                    break;

                default:
                    return $this->output_flexslider();
                    break;
            }
            
        }

        function output_flexslider()
        {
            $direction = $this->block->data('flexslider_settings_direction');
            if(!$direction)
            {
                $this->block->set_data('flexslider_settings_direction', "horizontal");
                $this->block->set_data('flexslider_settings_controlNav', "false");
                $this->block->set_data('flexslider_settings_directionNav', "true");
                $this->block->set_data('flexslider_settings_pauseOnHover', "true");
                $this->block->set_data('flexslider_settings_slideshowSpeed', "5000");
            }
			$slide_titles = $this->block->data('slide_title');
            $title_color = $this->block->data('title_color');
			$title_background_color = $this->block->data('title_background_color');
            $text_color = $this->block->data('text_color');		
			$text_background_color = $this->block->data('text_background_color');
			$title_animation_type = $this->block->data('title_animation_type');	  
		    $title_animation_duration = $this->block->data('title_animation_duration');
		    $title_animation_event = $this->block->data('title_animation_event');
		    $title_animation_delay = $this->block->data('title_animation_delay');
			$text_animation_type = $this->block->data('text_animation_type');	  
			$text_animation_duration = $this->block->data('text_animation_duration');
			$text_animation_event = $this->block->data('text_animation_event');
			$text_animation_delay = $this->block->data('text_animation_delay');

            $num_slides = count($slide_titles);
		    $settings = array();

            $i = 1;
			foreach($slide_titles as $key => $slide_title)
			{
				$title_settings[0] = 'title'.$this->block->get_id().$i;
				$title_settings[1] = $title_animation_event;
				$title_settings[2] = $title_animation_duration.' '.$title_animation_delay.' '.$title_animation_type;
				array_push($settings,$title_settings);
				$text_settings[0] = 'text'.$this->block->get_id().$i;
				$text_settings[1] = $text_animation_event;
				$text_settings[2] = $text_animation_duration.' '.$text_animation_delay.' '.$text_animation_type;
				array_push($settings,$text_settings);

                $i++;
			}
			
			add_action("be_foot", generate_animation_events($settings));
			
            $title_style = 
                'style="
                    color: '.$title_color.' !important;
					background-color: '.$title_background_color.' !important;
                "';
            $text_style = 
                'style="
                    color: '.$text_color.' !important;
					background-color: '.$text_background_color.' !important;
                "';
            $output = "
			<link href=\"".base_url()."builderengine/public/animations/css/animate.min.css\" rel=\"stylesheet\" />
            <link href=\"".base_url()."blocks/slider/css/flexslider.css\" rel=\"stylesheet\" />
            <div class=\"flex-image flexslider\" id=\"flexslider-{$this->block->name}\">
                <ul class=\"slides\">";
                    $slide_titles = $this->block->data('slide_title');
                    $slide_images = $this->block->data('slide_image');
                    $slide_texts = $this->block->data('slide_text');
                    $slide_urls = $this->block->data('slide_url');
                    $num_slides = count($slide_titles);
                    $i = 1;
                    foreach($slide_titles as $key => $slide_title)
                    {
						if($i == 1)
						{
							$output .= "<li style=\"display:list-item;\">";
							if($slide_urls[$key] != "")
								$output .="<a href=\"{$slide_urls[$key]}\">";
							else
								$output .="<a href=\"#\">";
						}
						else
						{
							$output .= "<li style=\"display:block;\">";
							if($slide_urls[$key] != "")
								$output .="<a href=\"{$slide_urls[$key]}\">";
							else
								$output .="<a href=\"#\">";
						}
						
                        $caption = "
                            <div class=\"flex-caption\">
                                <!-- Title -->
                                <h3 id=\"title".$this->block->get_id()."".$i."\" ".$title_style."><span>".$slide_titles[$key]."</span></h3>
                                <!-- Para -->
                                <p id=\"text".$this->block->get_id()."".$i."\" ".$text_style.">".$slide_texts[$key]."</p>
                            </div></li>
                        ";
                        $output .="
                            <img src=\"".$slide_images[$key]."\" />
                        ";
                        if($slide_texts[$key] != "" && $slide_titles[$key] != "")
                            $output .= $caption;
						else
							$output .= "</a></li>";
                        $i++;
                    }
                    $output .= "
                </ul>
            </div>

            ";
            return $output;
        }
    }
?>