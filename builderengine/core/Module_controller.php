<?php 
class Module_controller extends BE_Controller{
        private $initialized = false;
        private function _initialize()
        {
            unset($this->versions);
            $this->load->model("versions"); //hackfix
            unset($this->users);
            $this->load->model("users"); //hackfix
            unset($this->presentation);
            $this->load->model("be_presentation", "presentation"); //hackfix
            $this->initialize();
            $this->initialized = true;
        }
        public function initialize()
        {

        }
        public function _remap($method)
        {
            //echo "Method: $method <br>\n";
            //echo "Params: ";
            PC::_remap(func_get_args());
            $params = array_slice(func_get_args(), 1);
            if(!is_array($params))
            {
                $val = $params;
                $params = array($val);
            }
            

            if(method_exists($this, $method)){
                if(!$this->initialized)
                    $this->_initialize();
                return call_user_func_array(array($this, $method), $params);    
            }
                

            $string[0] = $method;
            for($i = 0; $i < count($params); $i++)
            {
                array_push($string, $params[$i]);
            }
            if ((strrpos($method, '.html') === strlen($method) - 5) && method_exists($this, "seo"))
            {
                if(!$this->initialized)
                    $this->_initialize();
                return call_user_func_array(array($this, "seo"), $string);
            }

            if(method_exists($this, "query"))
            {
                if(!$this->initialized)
                    $this->_initialize();
                return call_user_func_array(array($this, "query"), $string);
            }

            if(method_exists($this, "index"))
            {
                if(!$this->initialized)
                    $this->_initialize();
                return call_user_func_array(array($this, "index"), $string);
            }
                

           return "__404__";
        }
    }
