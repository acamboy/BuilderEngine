<?php
class quotation_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Bootstrap";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Quotation";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
            $quote_author = $this->block->data('author');
            $quote_quotation = $this->block->data('quotation');
            $quote_from = $this->block->data('from');
            
            $this->admin_input('author','text', 'Author: ', $quote_author);
            $this->admin_input('quotation','text', 'Quotation: ', $quote_quotation);
            $this->admin_input('from','text', 'From: ', $quote_from);
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
            $quote_author = $this->block->data('author');
            $quote_quotation = $this->block->data('quotation');
            $quote_from = $this->block->data('from');

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

			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');

			$settings[0][0] = 'quotation'.$this->block->get_id();
			$settings[0][1] = $animation_event;
			$settings[0][2] = $animation_duration.' '.$animation_delay.' '.$animation_type;
			add_action("be_foot", generate_animation_events($settings));

            $text_style = 
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
				
			if($quote_author == '')
            	$quote_author = 'John Doe';
			if($quote_quotation == '')
            	$quote_quotation = 'To Be Or Not To Be';
			if($quote_from == '')
            	$quote_from = 'BuilderEngine';

            $output = '
			<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
                <blockquote id="quotation'.$this->block->get_id().'">
                    <p '.$text_style.'>"'.$quote_quotation.'"</p>
                    <small>
                        <span '.$author_style.'>'.$quote_author.'</span>
                        <cite title="Source Title">
                            <span '.$from_style.'>&nbsp;&nbsp;'.$quote_from.'</span>
                        </cite>
                    </small>
                </blockquote>
            ';
            return $output;
        }
        public function generate_admin_menus()
        {
        }
    }
?>