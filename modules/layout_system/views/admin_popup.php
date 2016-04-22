<?php /***********************************************************
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
?>
<div id="block-editor" style="position:relative; width: 100%;">

    <script>
        $("#admin-window").css('display','block');
        $("#admin-window").draggable();
		
		$(".collapse-element").click(function () {
			$header = $(this);
			$content = $('.coll');
			$content.slideToggle(500, function () {
				$header.text(function () {
				});
			});
		});
    </script>

    <div class="block-editor"  data-sortable-id="ui-widget-7" style="position: absolute;width: 100%;">
        <div class="panel panel-inverse" style="width: 50%;margin-left: auto;margin-right: auto;max-height: 400px;">
            <div class="panel-heading">
				<div class="panel-heading-btn">
				   <a href="#" data-placement="top" class="collapse-element btn btn-xs btn-warning"><i class="fa fa-minus"></i></a>
				   <a href="#" id="popup-close" class="close i-close-2 btn btn-xs btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					<a href="#" id="" class="" data-click=""><i class=""></i></a>
				</div>
				<h4 class="panel-title">Block Settings</h4>
            </div>
			<div class="panel-body coll">
                <div data-scrollbar="true" data-height="280px">
					<div class="widget-content" id='admin-window-content'> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>