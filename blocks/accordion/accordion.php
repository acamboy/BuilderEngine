<?php
class accordion_block_handler extends  block_handler{
      function info()
      {
          $info['category_name'] = "Bootstrap";
          $info['category_icon'] = "dsf";

          $info['block_name'] = "Accordion";
          $info['block_icon'] = "fa-envelope-o";
      
          return $info;
      }
      public function generate_admin()
      {
      $titles = $this->block->data('titles');
      $texts = $this->block->data('texts');

      if(!is_array($titles) || empty($titles))
      {
          $titles[0] = "Title of the first accordion";
          $texts[0] = "This is a sample text for the first collapsible group.";
		  $titles[1] = "Title of the 2nd accordion";
          $texts[1] = "This is a sample text for the 2nd collapsible group.";
		  $titles[2] = "Title of the 3rd accordion";
          $texts[2] = "This is a sample text for the 3rd collapsible group.";
		  $titles[3] = "Title of the 4th accordion";
          $texts[3] = "This is a sample text for the 4th collapsible group.";
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
                  $('#slide-section-' + num_slides).find('[name="test_title"]').attr('name', 'titles[' + (new_slide_number) + ']');
                  $('#slide-section-' + num_slides).find('[name="test_text"]').attr('name', 'texts[' + (new_slide_number) + ']');
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
          <li style="height: 42px;"><span style="height: 100%;padding-top: 10px;" id="add-slide" class="btn btn-primary">Add Accordion</span></li>
          <?$i = 1;?>
          <?php foreach($texts as $key => $text):?>
              <li class="<?php if($i == 1) echo 'active'?>" id="slide-section-tab-<?=$i?>"><a href="#slide-section-<?=$i?>" data-toggle="tab">Item <?=$i?></a></li>
              <?$i++;?>
          <?php endforeach; ?>
          <?php if($num_slides == 0): ?>
              <li class="active"><a href="#slide-section-1" data-toggle="tab">Item 1</a></li>
			   <li class="active"><a href="#slide-section-2" data-toggle="tab">Item 2</a></li>
			    <li class="active"><a href="#slide-section-3" data-toggle="tab">Item 3</a></li>
				 <li class="active"><a href="#slide-section-4" data-toggle="tab">Item 4</a></li>
          <?php endif;?>
      </ul>
      <div class="tab-content" id="slide-sections">
          <!-- Template for creation -->
          <div class="tab-pane" id="slide-section-template">
              <?php
              $this->admin_input('test_title','text','Title: ', '');
              $this->admin_textarea('test_text','Text: ', '');
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
                  $this->admin_input('titles['.$key.']','text','Title: ', $titles[$key]);
                  $this->admin_textarea('texts['.$key.']','Text: ', $texts[$key]);
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
                  $this->admin_input('titles[0]','text','Title: ');
                  $this->admin_textarea('texts[0]','Text: ');
				  $this->admin_input('titles[1]','text','Title: ');
                  $this->admin_textarea('texts[1]','Text: ');
				  $this->admin_input('titles[2]','text','Title: ');
                  $this->admin_textarea('texts[2]','Text: ');
				  $this->admin_input('titles[3]','text','Title: ');
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
		  
          $title_font_color = $this->block->data('title_font_color');
          $title_font_weight = $this->block->data('title_font_weight');
          $title_font_size = $this->block->data('title_font_size');
          $title_background = $this->block->data('title_background');
 		  $title_animation_type = $this->block->data('title_animation_type');	  
		  $title_animation_duration = $this->block->data('title_animation_duration');
		  $title_animation_event = $this->block->data('title_animation_event');
		  $title_animation_delay = $this->block->data('title_animation_delay');
			
          $text_font_color = $this->block->data('text_font_color');
          $text_font_weight = $this->block->data('text_font_weight');
          $text_font_size = $this->block->data('text_font_size');
		  $text_background = $this->block->data('text_background');
 		  $text_animation_type = $this->block->data('text_animation_type');	  
		  $text_animation_duration = $this->block->data('text_animation_duration');
		  $text_animation_event = $this->block->data('text_animation_event');
		  $text_animation_delay = $this->block->data('text_animation_delay');

          $section_border_color = $this->block->data('section_border_color');
          ?>
          <div role="tabpanel">

              <ul class="nav nav-tabs" role="tablist" style="margin-left: -20px;">
                  <li role="presentation" class="active"><a href="#title" aria-controls="text" role="tab" data-toggle="tab">Title</a></li>
                  <li role="presentation"><a href="#text" aria-controls="profession" role="tab" data-toggle="tab">Text</a></li>
                  <li role="presentation"><a href="#background" aria-controls="profession" role="tab" data-toggle="tab">Background</a></li>
              </ul>

              <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade in active" id="title">
                      <?php
                      $this->admin_input('title_font_color','text', 'Font color: ', $title_font_color);
                      $this->admin_input('title_font_weight','text', 'Font weight: ', $title_font_weight);
                      $this->admin_input('title_font_size','text', 'Font size: ', $title_font_size);
					  $this->admin_select('title_animation_type', $types,'Animation type: ',$title_animation_type);
					  $this->admin_select('title_animation_duration', $durations,'Animation duration: ',$title_animation_duration);
					  $this->admin_select('title_animation_event', $events,'Animation Start: ',$title_animation_event);
					  $this->admin_select('title_animation_delay', $delays,'Animation Delay: ',$title_animation_delay);					  
                      ?>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="text">
                      <?php
                      $this->admin_input('text_font_color','text', 'Font color: ', $text_font_color);
                      $this->admin_input('text_font_weight','text', 'Font weight: ', $text_font_weight);
                      $this->admin_input('text_font_size','text', 'Font size: ', $text_font_size);
					  $this->admin_select('text_animation_type', $types,'Animation type: ',$text_animation_type);
					  $this->admin_select('text_animation_duration', $durations,'Animation duration: ',$text_animation_duration);
					  $this->admin_select('text_animation_event', $events,'Animation Start: ',$text_animation_event);	
					  $this->admin_select('text_animation_delay', $delays,'Animation Delay: ',$text_animation_delay);					  
                      ?>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="background">
                      <?php
                      $this->admin_input('title_background','text', 'Title background color: ', $title_background);
                      $this->admin_input('text_background','text', 'Text background color: ', $text_background);
                      $this->admin_input('section_border_color','text', 'Section border color: ', $section_border_color);
                      ?>
                  </div>
              </div>

          </div>
      <?php
    }
      public function generate_content()
      {
          $titles = $this->block->data('titles');
          $texts = $this->block->data('texts');

          if(!is_array($titles) || empty($titles))
          {
              $titles[0] = "Title of the first accordion";
              $texts[0] = "This is a sample text for the first collapsible group.";
			  
			  $titles[1] = "Title of the 2nd accordion";
              $texts[1] = "This is a sample text for the 2nd collapsible group.";
			  
			  $titles[2] = "Title of the 3rd accordion";
              $texts[2] = "This is a sample text for the 3rd collapsible group.";
			  
			  $titles[3] = "Title of the 4th accordion";
              $texts[3] = "This is a sample text for the 4th collapsible group.";
          }

          //style
          $title_font_color = $this->block->data('title_font_color');
          $title_font_weight = $this->block->data('title_font_weight');
          $title_font_size = $this->block->data('title_font_size');
 		  $title_animation_type = $this->block->data('title_animation_type');	  
		  $title_animation_duration = $this->block->data('title_animation_duration');
		  $title_animation_event = $this->block->data('title_animation_event');
		  $title_animation_delay = $this->block->data('title_animation_delay');
		  
          $text_font_color = $this->block->data('text_font_color');
          $text_font_weight = $this->block->data('text_font_weight');
          $text_font_size = $this->block->data('text_font_size');
 		  $text_animation_type = $this->block->data('text_animation_type');	  
		  $text_animation_duration = $this->block->data('text_animation_duration');
		  $text_animation_event = $this->block->data('text_animation_event');
		  $text_animation_delay = $this->block->data('text_animation_delay');
		  
          $title_background = $this->block->data('title_background');
          $text_background = $this->block->data('text_background');
          $section_border_color = $this->block->data('section_border_color');

          $num_slides = count($titles);
		  $settings = array();

			for($i = 0; $i < $num_slides; $i++)
			{
				$title_settings[0] = 'title'.$this->block->get_id().$i;
				$title_settings[1] = $this->block->data('title_animation_event');
				$title_settings[2] =$this->block->data('title_animation_duration').' '.$this->block->data('title_animation_delay').' '.$this->block->data('title_animation_type');
				array_push($settings,$title_settings);
				$text_settings[0] = 'text'.$this->block->get_id().$i;
				$text_settings[1] = $this->block->data('text_animation_event');
				$text_settings[2] =$this->block->data('text_animation_duration').' '.$this->block->data('text_animation_delay').' '.$this->block->data('text_animation_type');
				array_push($settings,$text_settings);
			}

		  add_action("be_foot", generate_animation_events($settings));

          $title_style =
              'style="
                    color: '.$title_font_color.' !important;
                    font-weight: '.$title_font_weight.' !important;
                    font-size: '.$title_font_size.' !important;
                "';
          $text_style =
              'style="
                    color: '.$text_font_color.' !important;
                    font-weight: '.$text_font_weight.' !important;
                    font-size: '.$text_font_size.' !important;
                    background-color: '.$text_background.' !important;
                    border-color: '.$section_border_color.' !important;
                "';
          $section_style =
              'style="
                    border-color: '.$section_border_color.' !important;
                "';
          $heading_style =
              'style="
                    background-color: '.$title_background.' !important;
                "';

          $output = '
		  <link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
          $i = 1;
          foreach($texts as $key => $text)
          {
              $output .= '
                <div class="panel panel-default" '.$section_style.'>
                    <div class="panel-heading" role="tab" id="headingOne" '.$heading_style.'>
                        <h4 class="panel-title" id="title'.$this->block->get_id().''.$i.'">
                            <i class="fa fa-info" style="margin-right: 5px; color: #96979d;"> </i> <a data-toggle="collapse" data-parent="#accordion" href="#collapse-'.$i.'" aria-expanded="false" aria-controls="collapseOne" '.$title_style.'>
                                '.$titles[$key].'
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-'.$i.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body" '.$text_style.'>
                            <p class="" id="text'.$this->block->get_id().''.$i.'" >'.$texts[$key].'</p>
                        </div>
                    </div>
                </div>
              ';
              $i++;
          }
          $output .= '
          </div>
        ';

        return $output;
      }
  }
?>
