<?php
class quote_block_handler extends  block_handler{
		function info()
		{
			$info['category_name'] = "Core";
			$info['category_icon'] = "dsf";

			$info['block_name'] = "Quote";
			$info['block_icon'] = "fa-envelope-o";
			
			return $info;
		}
		public function generate_admin()
		{
			$author = $this->block->data('author');
            $quotation = $this->block->data('quotation');
            $from = $this->block->data('from');
            $quote_content = $this->block->data('quote_content');
			
			$this->admin_select('quote_content',array("default" => "Default Content","custom" => "Custom Content"),'Quote Content',$quote_content);
            $this->admin_input('author','text', 'Author: ', $author);
            $this->admin_input('quotation','text', 'Quotation: ', $quotation);
            $this->admin_input('from','text', 'From: ', $from);
		}
		public function generate_style()
		{
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';
			
            $quotation_font_color = $this->block->data('quotation_font_color');
            $quotation_font_weight = $this->block->data('quotation_font_weight');
            $quotation_font_size = $this->block->data('quotation_font_size');

            $author_font_color = $this->block->data('author_font_color');
            $author_font_weight = $this->block->data('author_font_weight');
            $author_font_size = $this->block->data('author_font_size');

            $from_font_color = $this->block->data('from_font_color');
            $from_font_weight = $this->block->data('from_font_weight');
            $from_font_size = $this->block->data('from_font_size');

			$background_color = $this->block->data('background_color');
            $background_image = $this->block->data('background_image');
			$background_option = $this->block->data('background_option');

			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');

            ?>
            <div role="tabpanel">

                <ul class="nav nav-tabs" role="tablist" style="margin-left: -20px;">
                    <li role="presentation" class="active"><a href="#quotation" aria-controls="quotation" role="tab" data-toggle="tab">Quotation</a></li>
                    <li role="presentation"><a href="#author" aria-controls="author" role="tab" data-toggle="tab">Author</a></li>
                    <li role="presentation"><a href="#from" aria-controls="from" role="tab" data-toggle="tab">From</a></li>
                    <li role="presentation"><a href="#background" aria-controls="background" role="tab" data-toggle="tab">Background</a></li>
					<li role="presentation"><a href="#animation" aria-controls="animation" role="tab" data-toggle="tab">Animation</a></li>
                </ul>

                <div class="tab-content">
                	 <div role="tabpanel" class="tab-pane fade in active" id="quotation">
                        <?php
                        $this->admin_input('quotation_font_color','text', 'Font color: ', $quotation_font_color);
            			$this->admin_input('quotation_font_weight','text', 'Font weight: ', $quotation_font_weight);
            			$this->admin_input('quotation_font_size','text', 'Font size: ', $quotation_font_size);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="author">
                        <?php
                        $this->admin_input('author_font_color','text', 'Font color: ', $author_font_color);
            			$this->admin_input('author_font_weight','text', 'Font weight: ', $author_font_weight);
            			$this->admin_input('author_font_size','text', 'Font size: ', $author_font_size);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="from">
                        <?php
                        $this->admin_input('from_font_color','text', 'Font color: ', $from_font_color);
            			$this->admin_input('from_font_weight','text', 'Font weight: ', $from_font_weight);
            			$this->admin_input('from_font_size','text', 'Font size: ', $from_font_size);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="background">
                        <?php
						$this->admin_select('background_option', array("image" => "Use image background","color" => "Use Color Background"),'Background Option',$background_option);
						$this->admin_input('background_color','text', 'Background color: ', $background_color);
                        $this->admin_file('background_image','Add Background image ', $background_image , 'quote'.$this->block->get_id(), true );
                        ?>
						<script>
							$("#quote<?=$this->block->get_id()?>").click(function(e){
							   e.preventDefault();
							});						
						</script>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="animation">
                        <?php
						$this->admin_select('animation_type', $types,'Animation type: ',$animation_type);
						$this->admin_select('animation_duration', $durations,'Animation duration: ',$animation_duration);
						$this->admin_select('animation_event', $events,'Animation Start: ',$animation_event);
						$this->admin_select('animation_delay', $delays,'Animation Delay: ',$animation_delay);
                        ?>
                    </div>
                </div>

            </div>
            <?php
        }
		public function generate_content()
		{
			$author = $this->block->data('author');
            $quotation = $this->block->data('quotation');
            $from = $this->block->data('from');
			$quote_content = $this->block->data('quote_content');
            // style
            $quotation_font_color = $this->block->data('quotation_font_color');
            $quotation_font_weight = $this->block->data('quotation_font_weight');
            $quotation_font_size = $this->block->data('quotation_font_size');

            $author_font_color = $this->block->data('author_font_color');
            $author_font_weight = $this->block->data('author_font_weight');
            $author_font_size = $this->block->data('author_font_size');

            $from_font_color = $this->block->data('from_font_color');
            $from_font_weight = $this->block->data('from_font_weight');
            $from_font_size = $this->block->data('from_font_size');

			$background_color = $this->block->data('background_color');
            $background_image = $this->block->data('background_image');
			$background_option = $this->block->data('background_option');

			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');

			$settings[0][0] = 'quote'.$this->block->get_id();
			$settings[0][1] = $animation_event;
			$settings[0][2] = $animation_duration.' '.$animation_delay.' '.$animation_type;
			add_action("be_foot", generate_animation_events($settings));
			
			if($background_option == 'color'){
				if($quote_content != 'custom'){
					$background_style = '';
					$bg_class = 'bg-black-darker';
				}else{
					$background_style = 
						'style="background:'.$background_color.' !important;"';
					$bg_class = '';
				}
			}
			else{
				if($quote_content != 'custom'){
					$background_image = base_url().'';
					$background_style = '';
					$bg_class = 'bg-black-darker';
				}else{
					$background_style = 
					'style="background: url('.$background_image.') no-repeat; !important;
					 background-size:cover !important";
					';
					$bg_class = '';
				}
			}
            if($quote_content != 'custom'){
            	$quotation = 'Passion leads to design, design leads to performance, performance leads to success!';
            	$author = 'Sean Murphy';
            	$from = 'Web Guru';
			}
            $quotation_style = 
                'style="
                    color: '.$quotation_font_color.' !important;
                    font-weight: '.$quotation_font_weight.' !important;
                    font-size: '.$quotation_font_size.' !important;
                "';
            $author_style = 
                'style="
                    color: '.$author_font_color.' !important;
                    font-weight: '.$author_font_weight.' !important;
                    font-size: '.$author_font_size.' !important;
                    display: inline;
                "';
            $from_style = 
                'style="
                    color: '.$from_font_color.' !important;
                    font-weight: '.$from_font_weight.' !important;
                    font-size: '.$from_font_size.' !important;
                    display: inline;
                "';

			$output = '
			<link href="'.base_url('blocks/quote/style.css').'" rel="stylesheet">
			<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
			<div id="quote" class="blockcontent-quote '.$bg_class.' has-bg" data-scrollview="true" '.$background_style.'>
	            <div class="content-bg">
	                
	            </div>
	            <div class="" data-animation="true" data-animation-type="fadeInLeft">
	                <div class="row">
	                    <div id="quote'.$this->block->get_id().'" class="col-md-12 quote" '.$quotation_style.'>
	                        <i class="fa fa-quote-left"></i> '.$quotation.'  
	                        <i class="fa fa-quote-right"></i>
	                        <small><div '.$author_style.'>'.$author.'</div> , <div '.$from_style.'> '.$from.'</div></small>
	                    </div>
	                </div>
	            </div>
	        </div>';

	        return $output;
		}
		public function generate_admin_menus()
		{
			
		}
	}
?>