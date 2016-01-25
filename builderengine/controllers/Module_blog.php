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

  class Module_blog extends BE_Controller{
      
      public function module_blog()
      {
          parent::__construct();
      }
      
      public function index()
      {
        $this->show->frontend("blog");    
      }
      
  }
?>
