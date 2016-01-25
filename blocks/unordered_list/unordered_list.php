<?php
class unordered_list_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Bootstrap";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Unordered List";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
		  $texts = $this->block->data('texts');

		  if(!is_array($texts) || empty($texts))
		  {
			$texts[0] = "Lorem ipsum dolor sit amet.";
			$texts[1] = "Consectetur adipiscing elit.";
			$texts[2] = "Integer molestie lorem at massa.";
			$texts[3] = "Facilisis in pretium nisl aliquet.";
		  }
          $num_slides = count($texts);
          end($texts);
          $last_key = key($texts) + 1;
          reset($texts);
          ?>

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
					  $("#slide-section-tabs").append('<li id="slide-section-tab-' + num_slides +'"><a href="#slide-section-' + num_slides + '" data-toggle="tab">Item ' + num_slides + '</a></li>');
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
					  $('#slide-section-' + num_slides).find('[name="test"]').attr('name', 'texts[' + (new_slide_number) + ']');
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
		  <ul class="nav nav-tabs" id="slide-section-tabs" style="margin-left:-15px">
			  <li style="height: 42px;"><span style="height: 100%;padding-top: 10px;" id="add-slide" class="btn btn-primary">Add List Item</span></li>
              <?$i = 1;?>
              <?php foreach($texts as $key => $text):?>
                  <li class="<?php if($i == 1) echo 'active'?>" id="slide-section-tab-<?=$i?>"><a href="#slide-section-<?=$i?>" data-toggle="tab">Item <?=$i?></a></li>
                  <?$i++;?>
              <?php endforeach; ?>
			  <?php if($num_slides == 0): ?>
				  <li class="active"><a href="#slide-section-1" data-toggle="tab">List Item 1</a></li>
				   <li class="active"><a href="#slide-section-2" data-toggle="tab">List Item 2</a></li>
					<li class="active"><a href="#slide-section-3" data-toggle="tab">List Item 3</a></li>
					 <li class="active"><a href="#slide-section-4" data-toggle="tab">List Item 4</a></li>
			  <?php endif;?>
		  </ul>
		  <div class="tab-content" id="slide-sections">
              <!-- Template for creation -->
              <div class="tab-pane" id="slide-section-template">
                  <?php
                  $this->admin_textarea('test','Text: ', '');
                  ?>
                  <div class="form-group">
                      <span class="btn btn-danger delete-slide" slide="template">Delete Item</span>
                  </div>
              </div>
              <!-- /Template for creation -->
              <?$i = 1;?>
              <?php foreach($texts as $key => $text):?>
				  <div class="tab-pane <?php if($i == 1) echo 'active'?>" id="slide-section-<?=$i?>">
					  <?php
					  $this->admin_textarea('texts['.$key.']','Text: ', $text);
					  ?>
					  <div class="form-group">
						  <span class="btn btn-danger delete-slide" slide="<?=$i?>">Delete Item</span>
					  </div>
				  </div>
                  <?$i++;?>
              <?php endforeach; ?>


			  <?php if($num_slides == 0): ?>
				  <div class="tab-pane active" id="slide-section-1">
					  <?php
					  $this->admin_textarea('texts[0]','Text: ');
					  $this->admin_textarea('texts[1]','Text: ');
					  $this->admin_textarea('texts[2]','Text: ');
					  $this->admin_textarea('texts[3]','Text: ');
					  ?>
				  </div>
			  <?php endif;?>
		  </div>
		 <?php
        }
        public function generate_style()
        {
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';

            $text_font_color = $this->block->data('text_font_color');
            $text_font_weight = $this->block->data('text_font_weight');
            $text_font_size = $this->block->data('text_font_size');
			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');

            $this->admin_input('text_font_color','text', 'Font color: ', $text_font_color);
            $this->admin_input('text_font_weight','text', 'Font weight: ', $text_font_weight);
            $this->admin_input('text_font_size','text', 'Font size: ', $text_font_size);
			$this->admin_select('animation_type', $types,'Animation type: ',$animation_type);
			$this->admin_select('animation_duration', $durations,'Animation duration: ',$animation_duration);
			$this->admin_select('animation_event', $events,'Animation Start: ',$animation_event);
			$this->admin_select('animation_delay', $delays,'Animation Delay: ',$animation_delay);
        }
        public function generate_content()
        {
			$texts = $this->block->data('texts');
			  if(!is_array($texts) || empty($texts))
			  {
				  $texts[0] = "Lorem ipsum dolor sit amet.";
				  $texts[1] = "Consectetur adipiscing elit.";
				  $texts[2] = "Integer molestie lorem at massa.";
				  $texts[3] = "Facilisis in pretium nisl aliquet.";
			  }

            $text_font_color = $this->block->data('text_font_color');
            $text_font_weight = $this->block->data('text_font_weight');
            $text_font_size = $this->block->data('text_font_size');
			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');

			$num_slides = count($texts);

			$settings[0][0] = 'unordered'.$this->block->get_id();
			$settings[0][1] = $animation_event;
			$settings[0][2] = $animation_duration.' '.$animation_delay.' '.$animation_type;
			add_action("be_foot", generate_animation_events($settings));
            $text_style = 
                'style="
                    color: '.$text_font_color.' !important;
                    font-weight: '.$text_font_weight.' !important;
                    font-size: '.$text_font_size.' !important;
                "';

            $output = '
			<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
                <ul id="unordered'.$this->block->get_id().'">';
                    foreach($texts as $text)
					{
						$output .='<li '.$text_style.'>'.$text.'</li>';
					}
				$output .='
                </ul>
            ';

            return $output;
        }
        public function generate_admin_menus()
        {
            
        }
    }
?>