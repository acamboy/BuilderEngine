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

function endswith($string, $test) {
    $strlen = strlen($string);
    $testlen = strlen($test);
    if ($testlen > $strlen) return false;
    return substr_compare($string, $test, -$testlen) === 0;
}


?>
<script src="<?php echo home_url("/builderengine/public/js/jquery.js")?>"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" ></script>

<?php
/*<script type="text/javascript" src="<?php echo home_url("/themes/dashboard/js/plugins/tables/datatables/jquery.dataTables.min.js")?>"></script><!-- Init plugins only for page -->
<link href="<?php echo home_url("/themes/dashboard/css/icons.css")?>" rel="stylesheet" />*/?>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo home_url("/builderengine/public/js/editor/custom.css")?>" />
<link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" />
<link href="http://vitalets.github.io/angular-xeditable/dist/css/xeditable.css" rel="stylesheet" />

<link href="<?php echo home_url("/builderengine/public/css/block-editor.css")?>" rel="stylesheet" />
<link href="<?php echo home_url("/builderengine/public/css/fix.css")?>" rel="stylesheet" />
<link href="<?php echo home_url("/builderengine/public/css/bootstrap-switch.min.css")?>" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="<?php echo home_url("/builderengine/public/css/normalize.css")?>" />
<link rel="stylesheet" type="text/css" href="<?php echo home_url("/builderengine/public/css/demo.css")?>" />
<link rel="stylesheet" type="text/css" href="<?php echo home_url("/builderengine/public/css/icons.css")?>" />
<link rel="stylesheet" type="text/css" href="<?php echo home_url("/builderengine/public/css/component.css")?>" />

<link rel='stylesheet' id='font-awesome-4-css'  href='<?php echo home_url("/builderengine/public/css/font-awesome.css?ver=4.0.3")?>' type='text/css' media='all' />
    <link href="<?php echo home_url("/builderengine/public/jquery-ui/css/smoothness/jquery-ui-1.10.4.custom.css")?>" rel="stylesheet" />
<script src="<?php echo home_url("/builderengine/public/jquery-ui/js/jquery-ui-1.10.4.custom.js")?>"></script>

<script type="text/javascript" src="<?php echo home_url("/builderengine/public/js/versions-management.js")?>"></script>
<script type="text/javascript" src="<?php echo home_url("/builderengine/public/js/bootstrap-switch.min.js")?>"></script>


<style>
body {
  margin: 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.scroller{
    overflow-y:hidden !important;
}
.dl-menuwrapper a:hover {
    text-decoration: none !important;
}
.dl-menuwrapper ul
{
    margin-left: 0px !important;
}
</style>
<script>
var page_path = '<?=$BuilderEngine->get_page_path()?>';
var base_path = "<?=$this->config->base_url();?>";
var site_root = "<?=$this->config->base_url();?>";

function page_url_change(new_url)
{
  page_path = new_url;
  $( "#publish-button" ).attr('page', page_path);
  $( "#publish-button" ).unbind( "click.publish");
  $( "#publish-button" ).html( "Loading...");

  $.post(site_root + "layout_system/ajax/is_page_pending_submission",
  {
      page_path:page_path,
  },
  function(data,status){
    if(data == 'true')
      initialize_publish_button();
    else if(data == 'false')
    {
      $( "#publish-button" ).html( "LIVE");
    }else
      alert('There was an error processing a system operation.\nPlease contact customer support.');

  });
  

}
function reload_block(block_name, page_path, forced)
{
  runFunction("reload_block", [block_name, page_path, forced]);
    
}
function initialize_versions_manager_controls() {
   $("#layout-versions-button").click(function () {

        $(this).parent().addClass("active");
        $("#layout-versions-button").parent().removeClass("active");

        $("#admin-window").remove();
        $( "body" ).append( "<div id='admin-window' style='position:fixed; top: 100px;'> </div>" );

        
        
        $.post(site_root + 'layout_system/ajax/versions_window/layout',
        {
            'page_path':encodeURIComponent(page_path)
        },
        function(data) {
            initialize_versions_manager(data);
            $("#admin-window").css("z-index", "999");
            $("#admin-window").css("width", "100%");
            /*
            width = parseInt($("#admin-window").css("width"));
            half_width = width/2;
            screen_width = $( window ).width();
            left = (screen_width/2) - half_width;


            left = Math.round(left)+"px";
            $("#admin-window").css("left", left);*/

            $("#versions-close").click(function (event) {
                $("#page-versions-button").parent().removeClass("active");
                event.preventDefault();
            });
        });
        

    });

    $("#page-versions-button").click(function (e) {
        $(this).parent().addClass("active");
        $("#page-versions-button").parent().removeClass("active");

        $("#admin-window").remove();
        $( "body" ).append( "<div id='admin-window' style='position:fixed; top: 100px;'> </div>" );

        $.post(site_root + 'layout_system/ajax/versions_window/page',
        {
            'page_path':encodeURIComponent(page_path)
        },
        function(data) {
            $("#admin-window").html(data);
            $("#admin-window").css("z-index", "999");
            $("#admin-window").css("width", "100%");
            /*
            width = parseInt($("#admin-window").css("width"));
            half_width = width/2;
            screen_width = $( window ).width();
            left = (screen_width/2) - half_width;


            left = Math.round(left)+"px";
            $("#admin-window").css("left", left);*/

            $("#versions-close").click(function (event) {
                $(".block-editor").remove();    
                $("#layout-versions-button").parent().removeClass("active");
                event.preventDefault();
            });
        });
        
        e.preventDefault();
    });
}
<?php if( isset($_GET['force-editor-mode'])):?>
function do_magic()
{
  $("[editor-mode-switch!='']").each(
        function ()
        {
          var attr = $(this).attr('editor-mode-switch');

          // For some browsers, `attr` is undefined; for others,
          // `attr` is false.  Check for both.
          if (typeof attr === 'undefined' || attr === false)
            return;

          if(attr == '<?=$_GET['force-editor-mode']?>')
          {

            current_editor_mode = editor_mode;
            if(editor_mode != "")
            {
              $(this).removeClass('active');
              mode = editor_mode + 'ModeDisable';
              runFunction('fire_event', ['editor_mode_change',mode]);
              while(window.frames[0].window.getting_block){}
              runFunction( editor_mode + 'ModeDisable', ['']);
              
              
              editor_mode = "";
            }
            if(current_editor_mode != attr)
            {
                $(this).addClass('active');
                mode = attr + 'ModeEnable';

                runFunction('fire_event', ['editor_mode_change', mode]);
                while(window.frames[0].window.getting_block){}

                if(mode == 'addBlockModeEnable')
                    runFunction( attr + 'ModeEnable', [$(this).attr('block-type')]);
                else
                    runFunction( attr + 'ModeEnable', ['']);
                    
              
              
              editor_mode = attr;
            }
          }
        }
        );
}
<?php endif;?>

$(document).ready(function (){
  $("#erase-page").click(function(e){
    e.preventDefault();
    if(!confirm('This will erase this page content and will revert it to its default one. Are you sure you want to do that?'))
      return;
    href = $(this).attr('href');
    page_path = $( "#publish-button" ).attr('page');
    $.get(href + "?page_path=" + page_path);
    
    setTimeout(function(){var iframe = document.getElementById("content-frame");iframe.src = iframe.src;}, 1000);
    
  });
});
$(window).ready(function (){
  <?php if( isset($_GET['force-editor-mode'])):?>
  $(window.frames[0].window).ready(function (){
    
        setTimeout("do_magic()", 1000);
      
  });
    <?php endif;?>

    initialize_versions_manager_controls();
    <?php if($versions->get_pending_page_version_id(get_page_path()) || $versions->get_pending_page_version_id("layout")):?>
    initialize_publish_button();
    <?php endif;?>
  $('#content-frame').load(function (){$(this).contents().find(".be-edit-btn").remove();});

  $('#content-frame').css("height",$(window).height() - 42);
  $( window ).resize(function() {
    $('#content-frame').css("height",$(window).height() -42 );
  });
  $('#content-frame').css("border","none");

  /*$.get("/layout_system/editor_nav?page_path="+page_path+"&iframed=true", function(data) {
    $( "#editor-nav" ).html(data);
    initialize_versions_manager_controls();
    if(!$("#publish-button").hasClass("disabled"))
          initialize_publish_button();
  });*/
     $("[editor-size-switch!='']").each(
    function ()
    {
      var attr = $(this).attr('editor-size-switch');
      // For some browsers, `attr` is undefined; for others,
      // `attr` is false.  Check for both.
      if (typeof attr === 'undefined' || attr === false) 
        return;

      $(this).click(function (event){
        $("[editor-size-switch!='']").each(
          function ()
          {
            var attr = $(this).attr('editor-size-switch');

            // For some browsers, `attr` is undefined; for others,
            // `attr` is false.  Check for both.
            if (typeof attr === 'undefined' || attr === false) 
              return;
            $(this).removeClass('active');
          });

          size_mode = attr;
          if(attr != 'lg'){
            disableEditMod();
          }

          $("body").css('background-color', '#666');
          $("body").css('text-align', 'center');
          $(".scroller-inner").css('text-align', 'left');


          $("#content-frame").css('margin-left', 'auto');
          $("#content-frame").css('margin-right', 'auto');
          $("#content-frame").css('width', $(this).attr('editor-size-pixels'));
          $(this).addClass('active');
        
        event.preventDefault();
      });
    }
  );

    $("[editor-mode-switch!='']").each(
    function ()
    {
      var attr = $(this).attr('editor-mode-switch');

      // For some browsers, `attr` is undefined; for others,
      // `attr` is false.  Check for both.
      if (typeof attr === 'undefined' || attr === false) 
        return;

      $(this).click(function (event){
        $("[editor-mode-switch!='']").each(
          function ()
          {
            var attr = $(this).attr('editor-mode-switch');

            // For some browsers, `attr` is undefined; for others,
            // `attr` is false.  Check for both.
            if (typeof attr === 'undefined' || attr === false) 
              return;
            $(this).removeClass('active');
          });
        current_editor_mode = editor_mode;
        if(editor_mode != "")
        {
          if(editor_mode != 'edit'){
            $(this).removeClass('active');
            mode = editor_mode + 'ModeDisable';
            runFunction('fire_event', ['editor_mode_change',mode]);
            while(window.frames[0].window.getting_block){}
            runFunction( editor_mode + 'ModeDisable', ['']);
          }else{
            disableEditMod();
          }
          
          
          editor_mode = "";
        }
        if(current_editor_mode != attr)
        {
            if(attr != 'edit'){
                $(this).addClass('active');
                mode = attr + 'ModeEnable';

                runFunction('fire_event', ['editor_mode_change', mode]);
                while(window.frames[0].window.getting_block){}

                if(mode == 'addBlockModeEnable')
                    runFunction( attr + 'ModeEnable', [$(this).attr('block-type')]);
                else
                    runFunction( attr + 'ModeEnable', ['']);
                editor_mode = attr;
            }else if(size_mode == 'lg'){
              $(this).addClass('active');
              FreeModeOff();
              $('#freeMode').show();
              editor_mode = attr;
            }
                
          
          
          // editor_mode = attr;
        }
        
        event.preventDefault();
      });
    }
  );

  function disableEditMod()
  {
    $('#freeMode').hide();
    $("[editor-mode-switch='edit']").removeClass('active');
    $('#change-color-switch').bootstrapSwitch('state', false, true);
    $('#freeModeText').text('Free Mode OFF');
    if(is_free_mode_off_initialized){
      runFunction( 'FreeModeDisableOff', ['']);
      is_free_mode_off_initialized = false;
    }
    if(is_free_mode_on_initialized){
      runFunction( 'FreeModeDisableOn', ['']);
      is_free_mode_on_initialized = false;
    }
  }

  function FreeModeOn()
  {
    is_free_mode_on_initialized = true;
    mode = 'editModeEnable';

    if(is_free_mode_off_initialized){
      runFunction( 'FreeModeDisableOff', ['']);
      is_free_mode_off_initialized = false;
    }
    runFunction( 'FreeModeEnableOn', ['']);
  }

  function FreeModeOff()
  {
    is_free_mode_off_initialized = true;
    mode = 'editModeDisable';

    if(is_free_mode_on_initialized){
      runFunction( 'FreeModeDisableOn', ['']);
      is_free_mode_on_initialized = false;
    }
    runFunction( 'FreeModeEnableOff', ['']);
  }

  $('#change-color-switch').on('switchChange.bootstrapSwitch', function(event, state) {
    if(size_mode == 'lg')
      if(state){
        $('#freeModeText').text('Free Mode ON');
        FreeModeOn();
      }else{
        $('#freeModeText').text('Free Mode OFF');
        FreeModeOff();
      }
  });
});
</script>

<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.8/angular.min.js"></script>
<script type="text/javascript">
var editor_mode = "";
var size_mode = "lg";
var is_free_mode_on_initialized = false;
var is_free_mode_off_initialized = false;
function initialize_publish_button()
{
    $("#publish-button").removeClass("disabled");
    $("#publish-button").html("Publish");

    $( "#publish-button" ).bind( "click.publish",function () {
        $("#publish-button").html("PUBLISHING...");
        setTimeout("publish_button_action();", 1000);
        
    });
}
function publish_button_action()
{
    $.post(site_root + "layout_system/ajax/publish_version",
    {
        page:$("#publish-button").attr("page")
    },
    function(data,status){
        $("#publish-button").unbind( "click.publish");
        $("#publish-button").addClass("disabled");
        $("#publish-button").html("LIVE");
    });
}
function notifyChange()
{
    if($("#publish-button").hasClass("disabled"))
      initialize_publish_button();
}
function runFunction(name, arguments)
{

    if($('#content-frame').length > 0)
      $('#content-frame')[0].contentWindow["runFunction"](name,arguments);
}
  function stopEditor()
  {
    window.top.location.href = $('#content-frame').attr('src');
  }
  function MainCtrl($scope) {
    $scope.updateIframe = function() {

      document.getElementById('content-frame').contentWindow.updatedata($scope);
    };
    
  }

function showAdminWindowIframe(url)
{
    $("#admin-window").remove();
    $('body').append( "<div id='admin-window' style='position:fixed; top: 70px;'></div>" );

      $.get(site_root + 'layout_system/ajax/admin_popup',
      {
          //'asd':'asd'
      },
      function(data) {
          $("#admin-window").html(data);
          $("#admin-window-content").html("<iframe src='" + url + "' style='width:100%; border:none;min-height:430px'></iframe>");
          $("#admin-window").css("z-index", "999");
          $("#admin-window").css("width", "100%");

          /*width = parseInt($("#admin-window").css("width"));
          half_width = width/2;
          screen_width = $( window ).width();
          left = (screen_width/2) - half_width;


          left = Math.round(left)+"px";
          $("#admin-window").css("left", left);*/

          $("#popup-close").click(function (event) {
              $(".block-editor").remove();    
              event.preventDefault();
          });
          
          //$('#content-frame')[0].contentWindow["runFunction"]("reload_angular",['']);

        });


}


function showAdminWindow(content)
{
  $("#admin-window").remove();
  $('body').append( "<div id='admin-window' style='position:fixed; top: 100px;'> </div>" );
  $.get(site_root + 'layout_system/ajax/admin_popup',
  {
      //'asd':'asd'
  },
  function(data) {
      $("#admin-window").html(data);
      $("#admin-window-content").html(content);
      $("#admin-window").css("z-index", "999");
      $("#admin-window").css("width", "100%");
      /*
      width = parseInt($("#admin-window").css("width"));
      half_width = width/2;
      screen_width = $( window ).width();
      left = (screen_width/2) - half_width;


      left = Math.round(left)+"px";
      $("#admin-window").css("left", left);*/

      $("#popup-close").click(function (event) {
          $(".block-editor").remove();    
          event.preventDefault();
      });
      
      //$('#content-frame')[0].contentWindow["runFunction"]("reload_angular",['']);

    });
}
</script>



<script src="<?=base_url('/builderengine/public/js/modernizr.custom.js')?>"></script>

<body ng:app ng:controller="MainCtrl">
   
                        <style>
                        body
                        {
                          overflow-y:hidden;
                          overflow-x:hidden;
                        }
                        .be-edit-btn{
                            -webkit-background-clip: border-box;
                            -webkit-background-origin: padding-box;
                            -webkit-background-size: auto;
                            background-attachment: scroll;
                            background-clip: border-box;
                            background-color: rgb(88, 95, 105);
                            background-image: none;
                            background-origin: padding-box;
                            background-size: auto;
                            border-bottom-left-radius: 0px;
                            border-bottom-right-radius: 0px;
                            border-top-left-radius: 0px;
                            border-top-right-radius: 0px;
                            color: rgb(255, 255, 255);
                            cursor: pointer;
                            display: block;
                            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                            font-size: 18px;
                            font-style: italic;
                            height: 28px;
                            line-height: 28.799999237060547px;
                            padding-bottom: 7px;
                            padding-left: 9px;
                            padding-right: 9px;
                            padding-top: 7px;
                            position: fixed;
                            right: -105px;
                            top: 37px;
                            width: 135px;
                            z-index: 555555;
                        }
                        #launch_editor {
                            display:none;
                        }

                        .top-nav .active
                        {
                          background: #3A80A1; /* Old browsers */
background: -moz-linear-gradient(top, #3A80A1 0%, #2F6B88 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#3A80A1), color-stop(100%,#2F6B88)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, #3A80A1 0%,#2F6B88 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, #3A80A1 0%,#2F6B88 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, #3A80A1 0%,#2F6B88 100%); /* IE10+ */
background: linear-gradient(to bottom, #3A80A1 0%,#2F6B88 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3A80A1', endColorstr='#2F6B88',GradientType=0 ); /* IE6-9 */

                        }
                        </style>
                        <script>
                            $(document).ready(function (){

                                $('.be-edit-btn').hover(function () {
                                    $('.be-edit-btn').animate({right: '0px'}, 500);
                                },
                                function () {
                                    $('.be-edit-btn').animate({right: '-105px'}, 500);
                                }
                                );

                            })
                        </script>
                        <form action='' method='post' id='launch_editor'>
                        <input type=hidden name='be_launch_editor'>
                        </form>
                        <!--<i class="be-edit-btn" id='trigger'>Edit This Page</i>-->

<?php     $params = array_merge($_GET, array("iframed" => "true"));
    $params = http_build_query($params);

    $url = strtok($url, '?');

    if(endswith($url, "/editor"))
        $url = str_replace("/editor", "", $url); 
    else
        $url = str_replace("/editor/", "/", $url);

?>
<!--<div id="editor-nav"></div>-->
<div class="containers">
            <!-- Push Wrapper -->
            <div class="mp-pusher" id="mp-pusher">

                <!-- mp-menu -->
                <nav id="mp-menu" class="mp-menu">
                    <div class="mp-level">
                        <h2 class="icon">Builder Menu</h2>
                        <ul>
                            <li class="icon icon-arrow-left">
                                <a href="#" style="text-align: center;"><i class="fa fa-camera-retro" style="font-size: 35px;margin-top: -5px; float:left"></i>&nbsp;&nbsp;&nbsp;Website Versions</a>
                                <div class="mp-level">
                                    <h2 class="icon">Website Versions</h2>
                                    <a class="mp-back" href="#">back</a>
                                    <ul>
                                        <li>
                                            <a class="" href="#" id="page-versions-button"><i class="fa fa-copy" style="margin-top: 2px; float:left">&nbsp;&nbsp;&nbsp;</i>Current Page Versions</a>
                                        </li>
                                        <li>
                                            <a class="" href="#" id="layout-versions-button"><i class="fa fa-file-o" style="margin-top: 2px; float:left">&nbsp;&nbsp;&nbsp;</i>Header/Footer Versions</a>
                                        </li>
					<?php if($this->BuilderEngine->get_option('erase_content_control') == 'on'):?>					
                     <h2 class="icon">Erase Content Tools</h2>
                                        <li>
                                            <a class="" href="<?=base_url('/layout_system/erase_all_blocks')?>" onclick="return confirm('This action will erase ALL your website Content / Blocks and will revert it to the original theme files in your system. Are you sure you want to do that?') && confirm('Please confirm that this operation will erase all website content and will revert it to its initial state. There is no going back after this! Press OK or Cancel.')"><i class="fa fa-undo"></i>&nbsp;&nbsp;&nbsp;Revert / Erase Everything</a>
                                        </li>
                                        <li>
                                            <a class="" id="erase-page" href="<?=base_url('/layout_system/erase_page_blocks')?>" onclick="return confirm('This will erase from the Database of all your Content / Blocks on this current page only. No other Pages will be affected by this action. Are you sure you want to do that?')"><i class="fa fa-undo"></i>&nbsp;&nbsp;&nbsp;Erase Page Content</a>
                                        </li>
					<?php else:?>
					<?php endif;?>
                                    </ul>
                                </div>
                            </li>
              
              <li class="icon icon-arrow-left">
                                <a href="#" style="text-align: center;"><i class="fa fa-book" style="font-size: 35px;margin-top: -5px; float:left"></i>&nbsp;&nbsp;&nbsp;Website Pages</a>
                                <div class="mp-level">
                                    <h2 class="icon">Website Pages</h2>
                                    <a class="mp-back" href="#">back</a>
                                    <ul>
                                        
                                        <li>
                                            <a class="" href="<?=base_url('/admin/module/page/add')?>"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New Page</a>
                                        </li>
                                        <li>
                                            <a class="" href="<?=base_url('/admin/module/page/show_pages')?>"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Show All Pages</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
              <li class="icon icon-arrow-left">
                                <a href="#" style="text-align: center;"><i class="fa fa-link" style="font-size: 35px;margin-top: -5px; float:left"></i>&nbsp;&nbsp;&nbsp;Navigation Links</a>
                                <div class="mp-level">
                                    <h2 class="icon">Navigation Links</h2>
                                    <a class="mp-back" href="#">back</a>
                                    <ul>
                                        
                                        <li>
                                            <a class="" href="<?=base_url('/admin/links/add')?>"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New Link</a>
                                        </li>
                                        <li>
                                            <a class="" href="<?=base_url('/admin/links/show')?>"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Show All Links</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
              <li class="icon icon-arrow-left">
                                <a href="#" style="text-align: center;"><i class="fa fa-floppy-o" style="font-size: 35px;margin-top: -5px; float:left"></i>&nbsp;&nbsp;&nbsp;File Manager</a>
                                <div class="mp-level">
                                    <h2 class="">File Manager</h2>
                                    <a class="mp-back" href="#">back</a>
                                    <ul>
                                        
                                        <li>
                                            <a class="" href="<?=base_url('/admin/files/show')?>"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;View File Manager</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>
              <li class="icon icon-arrow-left">
                                <a href="#" style="text-align: center;"><i class="fa fa-users" style="font-size: 35px;margin-top: -5px; float:left"></i>&nbsp;&nbsp;&nbsp;User Accounts</a>
                                <div class="mp-level">
                                    <h2 class="icon">User Accounts</h2>
                                    <a class="mp-back" href="#">back</a>
                                    <ul>
                                        
                                        <li>
                                            <a class="" href="<?=base_url('/admin/user/add')?>"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New User Account</a>
                                        </li>
                                        <li>
                                            <a class="" href="<?=base_url('/admin/user/search')?>"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Show All User Accounts</a>
                                        </li>
                    <li class="icon icon-arrow-left">
                                        <a href="#"><i class="fa fa-group"></i>&nbsp;&nbsp;&nbsp;User Groups</a>
                                        <div class="mp-level">
                                            <h2 class="" style="font-weight: bold">User Groups</h2>
                                            <a class="mp-back" href="#">back</a>
                                            <ul>
                                                <li>
                                            <a class="" href="<?=base_url('/admin/user/add_group')?>"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New Usergroup</a>
                                        </li>
                                        <li>
                                            <a class="" href="<?=base_url('/admin/user/groups')?>"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Show All Usergroups</a>
                                        </li>
                                                
                                            </ul>
                                        </div>
                                    </li>
                                    </ul>
                                </div>
                            </li>
              <li class="icon icon-arrow-left">
                                <a href="#" style="text-align: center;"><i class="fa fa-th" style="font-size: 35px;margin-top: -5px; float:left"></i>&nbsp;&nbsp;&nbsp;Themes</a>
                                <div class="mp-level">
                                    <h2 class="">Themes</h2>
                                    <a class="mp-back" href="#">back</a>
                                    <ul>
                                        
                                        <li>
                                            <a class="" href="<?=base_url('/admin/themes/show')?>"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Show All Themes</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>
              
                            <li><a href="<?=base_url()?>" id="exit_editor" style="text-align: center;"><i class="fa fa-sign-out" style="font-size: 35px;margin-top: -5px; float:left"></i>&nbsp;&nbsp;&nbsp;Exit Editor</a></li>
                        </ul>
                            
                    </div>
                </nav>
                <!-- /mp-menu -->
<script>
$(document).ready(function() {
    function pulsate() {
        $("#the-builderengine-logo").animate({ opacity: 0.8 }, 1500, 'linear')
                     .animate({ opacity: 1 }, 1500, 'linear', pulsate);
        }

    pulsate();
});
</script>


                <div class="scroller"><!-- this is for emulating position fixed of the nav -->
                    <div class="scroller-inner">
                        <!-- Top Navigation -->
                        <div class="codrops-top clearfix top-nav">
                            <a href="#" id="trigger" style="height: 54px; padding: 12px 8px; float: left" class=""><img alt="" id="the-builderengine-logo" style="height: 31px" src="<?=base_url('/themes/dashboard/assets/img/builderengine-logo.png')?>"/></a>
                            
              <a class="codrops-icon fa-icon fa-compass" href="<?=base_url('/admin')?>" style="margin-left: 10px;"><span>DASHBOARD</span></a>
                            <a class="codrops-icon fa-icon fa-edit" href="#" style="margin-left: 10px;" editor-mode-switch="editv3"><span>DESIGNER</span></a>
                            <a class="codrops-icon fa-icon fa-edit" href="#" style="margin-left: 10px;" editor-mode-switch="edit"><span>EDIT</span></a>
                            <!-- <a> -->
                            <span id="freeMode" style="color: #FFFFFF;" class='resetCss hide'><input id="change-color-switch" type="checkbox"  data-on-color="info" data-off-color="default"> <lable id='freeModeText'>Free Mode OFF</lable></span>
                            <!-- </a> -->
              <?php if($versions->get_pending_page_version_id(get_page_path()) || $versions->get_pending_page_version_id("layout")):?>
                            <span class="right"><a class="codrops-icon fa-icon fa-magic" href="#" id="publish-button" page="<?=get_page_path()?>"><span>PUBLISH</span></a></span>
                            <?php else: ?>
                            <span class="right"><a class="codrops-icon fa-icon fa-check disabled btn-success" href="#" id="publish-button" page="<?=get_page_path()?>"><span>LIVE</span></a></span>
                            <?php endif; ?>

              <span class="right"><a class="codrops-icon fa-icon fa-desktop" href="#" title="Desktop" style="margin-left: 0px;" editor-size-switch="lg" editor-size-pixels="100%"><span>&nbsp;</span></a></span>
                            <span class="right"><a class="codrops-icon fa-icon fa-laptop" href="#" title="Laptop" style="margin-left: 0px;" editor-size-switch="lg" editor-size-pixels="1180px"><span>&nbsp;</span></a></span>
                            <span class="right"><a class="codrops-icon fa-icon fa-tablet" href="#" title="Tablet" style="margin-left: 0px;" editor-size-switch="md" editor-size-pixels="788px"><span>&nbsp;</span></a></span>
                            <span class="right"><a class="codrops-icon fa-icon fa-mobile" href="#" title="Mobile" style="margin-left: 0px;" editor-size-switch="sm" editor-size-pixels="340px"><span>&nbsp;</span></a></span>
                            
                        </div>
                        
                    </div><!-- /scroller-inner -->
                    <iframe id="content-frame" src="<?=$url?>?<?=$params?>" style="width:100%; border:none"></iframe>
                </div><!-- /scroller -->

            </div><!-- /pusher -->

        </div><!-- /container -->

        <style>
          .be-edit-btn{
              -webkit-background-clip: border-box;
              -webkit-background-origin: padding-box;
              -webkit-background-size: auto;
              background-attachment: scroll;
              background-clip: border-box;
              background-color: #2d353c;
              background-image: none;
              background-origin: padding-box;
              background-size: auto;
              border-bottom-left-radius: 0px;
              border-bottom-right-radius: 0px;
              border-top-left-radius: 0px;
              border-top-right-radius: 0px;
              color: rgb(255, 255, 255);
              cursor: pointer;
              display: block;
              font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
              font-size: 18px;
              font-style: italic;
              height: 28px;
              line-height: 28.799999237060547px;
              padding-bottom: 7px;
              padding-left: 9px;
              padding-right: 9px;
              padding-top: 7px;
              position: fixed;
              
              height: 40px;
              width: 135px;
              z-index: 555555;
          }

          #page-styler
          {
              right: -80px;
              top: 87px;
          }
          </style>
        <script>
            $(document).ready(function (){
              $('#change-color-switch').bootstrapSwitch();
              $('.bootstrap-switch.bootstrap-switch-wrapper.bootstrap-switch-id-change-color-switch').css({'height':'30px','border-radius': '20px'});
              $('#freeMode').hide();

               /* $('#page-styler').hover(function () {
                    $(this).animate({right: '0px'}, 500);
                },
                function () {
                    $(this).animate({right: '-80px'}, 500);
                }
                );
                $('#page-styler').click( function (){
                    showAdminWindowIframe('/layout_system/ajax/block_styler/be_body_styler_'+'<?=$this->BuilderEngine->get_option("active_frontend_theme")?>'+'?page_path=page/index');
                });*/
                
            })
        </script>

        
        <script src="<?=base_url('/builderengine/public/js/classie.js')?>"></script>
        <script src="<?=base_url('/builderengine/public/js/mlpushmenu.js')?>"></script>
        <script>
            new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger' ) );
        </script>


</body>