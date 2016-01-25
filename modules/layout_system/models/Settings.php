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

    class Settings extends CI_Model {
    	private $layout_system_type = "bootstrap2";
    	public function set_layout_system_type($type)
    	{
    		$this->$layout_system_type = $type;
    	}
    	public function layout_system_type()
    	{
    		return $this->$layout_system_type;
    	}

    }
?>