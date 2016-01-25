<?php 	/***********************************************************
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

	class Alert extends DataMapper 
	{
		/* DataMapper specific members below*/
		var $table = 'alerts';
		var $has_one = array('user');
		var $has_many = array();

		/* Alert specific members below*/


	}
?>