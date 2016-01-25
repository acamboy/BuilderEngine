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
    </script>

    <div class="block-editor"  style="width: 740px; position: absolute;width: 100%;background-color: #2D353C;height: 400px;">
        <div style="width: 50%;margin-left: auto;margin-right: auto;max-height: 400px;">
            <div class="row" style="max-height: 400px;">
                <div style="max-height: 400px;">
                    <div style="padding-left: 10px; margin-top:20px">
                        <!--<h4 id="custom-editor-title" style="float:left">Block Settings</h4>-->
                        <a href="#" id="popup-close" style="margin-top:10px;font-size: 30px;line-height: 30px;position: absolute;left: 71.6%;color: #FA4F4B;" class="close i-close-2"><i class="fa fa-times btn btn-xs btn-danger"></i></a>
                    </div>

                    <div id='admin-window-content'>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>