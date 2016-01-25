<?php
/***********************************************************
* BuilderEngine v3.1.0
* ---------------------------------
* BuilderEngine CMS Platform - Radian Enterprise Systems Limited
* Copyright Radian Enterprise Systems Limited 2012-2015. All Rights Reserved.
*
* http://www.builderengine.com
* Email: info@builderengine.com
* Time: 2015-08-31 | File version: 3.1.0
*
***********************************************************/

    class EventManager
    {
        private static $events = array();
        private static $is_initialized = false;
        private static $is_initializing = false;

        private static $queue = array();

        public static function subscribe($event, $callback)
        {
            if(!array_key_exists($event, self::$events))
                self::$events[$event] = array();
                
            array_push(self::$events[$event], $callback);
            
            //PC::EventManager("Subscribing $event -> $callback");
            //PC::EventManager(self::$events);
        }
        
        public static function fire($event, &$arg = null)
        {

            if(self::is_initializing())
            {
               // PC::EventManager("Queuing event $event");
                $queued_event['event'] = $event;
                $queued_event['arg'] = &$arg;
                array_push(self::$queue, $queued_event);
                return false;
            }
            

            if(!array_key_exists($event, self::$events))
            {
                //PC::EventManager("Event $event not found");
                return;
            }
                //PC::EventManager("Yey firing");
            foreach(self::$events[$event] as $callback)
            {
                PC::EventManager("Firing event $event -> $callback");
                if(function_exists($callback))
                    if($arg != null){
                        call_user_func($callback, $arg);
                    }else
                        call_user_func($callback);
                else
                    if($arg != null)
                    {
                        $output = Modules::run($callback, $arg);
                    } else{
                        $output =  Modules::run($callback);
                    }

                if(isset($output) && $output != "__NO_MODULE__" && $output != "__404__")
                    echo $output;
            }
            return self::$events[$event] > 0;
                
        }

        public static function is_initialized()
        {
            return self::$is_initialized;
        }
        public static function set_initialized($bool)
        {
            self::$is_initialized = $bool;

            if($bool == true)
            {
                self::$is_initializing = false;

                //PC::EventManager("Preparing to process ".count(self::$events)." elements in queue");
                foreach(self::$queue as $event)
                {
                    //PC::EventManager("Processing ".$event['event']." elements in queue");
                    self::fire($event['event'], $event['arg']);
                }
            }
        }

        public static function is_initializing()
        {
            return self::$is_initializing;
        }
        public static function set_initializing($bool)
        {
            self::$is_initializing = $bool;
        }

    }                        
    function add_action($event, $callback)
    {
        EventManager::subscribe($event, $callback);    
    }
    function fire_action($event, &$arg)
    {
        EventManager::fire($event, $arg); 
    }
	function generate_animation_events($custom_settings)
	{
		foreach($custom_settings as $key => $setting)
		{
			if($setting[1] != 'load')				
			{
			    echo "
					<script>
						$(function(){
							var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
							$('#{$setting[0]}').on('{$setting[1]}',function(){
								$(this).addClass('animated {$setting[2]}').one(animationEnd,
									function(){
										$(this).removeClass('animated {$setting[2]}');
								});
							});
						});
					</script>
				";
			}
			else
			{
				echo "
					<script>
						$(document).ready(function() {
							var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
								$('#{$setting[0]}').addClass('animated {$setting[2]}').one(animationEnd,
									function(){
										$(this).removeClass('animated {$setting[2]}');
								});
						});
					</script>
				";
			}
		}		
	}