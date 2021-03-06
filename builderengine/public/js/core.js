// Credit for style function stackoverflow http://stackoverflow.com/questions/2655925/apply-important-css-style-using-jquery
var blocks_mode = "none";
var resizable=false;
var editable=false;
var stylable=false;

function DisableAllModes()
{  
    DisableStylable();
    if(editable)
        ToggleEditable();

    if(resizable)
        ToggleResizable();

    if(draggable)
        ToggleDraggable();

    if(blocks_mode == "delete")
    {
        ToggleDelete();  
    }
    if(blocks_mode == "add")
    {
        ToggleAdd();  
    }

    if(blocks_mode == "copy")
        ToggleCopy();
}
// For those who need them (< IE 9), add support for CSS functions
var isStyleFuncSupported = !!CSSStyleDeclaration.prototype.getPropertyValue;
if (!isStyleFuncSupported) {
    CSSStyleDeclaration.prototype.getPropertyValue = function(a) {
        return this.getAttribute(a);
    };
    CSSStyleDeclaration.prototype.setProperty = function(styleName, value, priority) {
        this.setAttribute(styleName,value);
        var priority = typeof priority != 'undefined' ? priority : '';
        if (priority != '') {
            // Add priority manually
            var rule = new RegExp(RegExp.escape(styleName) + '\\s*:\\s*' + RegExp.escape(value) + '(\\s*;)?', 'gmi');
            this.cssText = this.cssText.replace(rule, styleName + ': ' + value + ' !' + priority + ';');
        } 
    }
    CSSStyleDeclaration.prototype.removeProperty = function(a) {
        return this.removeAttribute(a);
    }
    CSSStyleDeclaration.prototype.getPropertyPriority = function(styleName) {
        var rule = new RegExp(RegExp.escape(styleName) + '\\s*:\\s*[^\\s]*\\s*!important(\\s*;)?', 'gmi');
        return rule.test(this.cssText) ? 'important' : '';
    }
}

// Escape regex chars with \
RegExp.escape = function(text) {
    return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
}

// The style function
jQuery.fn.style = function(styleName, value, priority) {
    // DOM node
    var node = this.get(0);
    // Ensure we have a DOM node 
    if (typeof node == 'undefined') {
        return;
    }
    // CSSStyleDeclaration
    var style = this.get(0).style;
    // Getter/Setter
    if (typeof styleName != 'undefined') {
        if (typeof value != 'undefined') {
            // Set style property
            var priority = typeof priority != 'undefined' ? priority : '';
            style.setProperty(styleName, value, priority);
        } else {
            // Get style property
            return style.getPropertyValue(styleName);
        }
    } else {
        // Get CSSStyleDeclaration
        return style;
    }
}




function DisableStylable()
{
    $("[changeablebg=true]").css("cursor", "auto");
    $("[changeablebg=true]").unbind('click.stylable');
    $("#style-button").parent().removeClass("active");
}
function ToggleStylable() {

    if(stylable == false){
        DisableAllModes();
        $("[changeablebg=true]").css("cursor", "pointer");
        $("[changeablebg=true]").bind('click.stylable',function (event) {

            if(event.target.id != $(this).attr('id'))
                    return;
            target_id = $(this).attr('id');
            load_admin_window(
                '/admin/ajax/load_bg_selector', 
                {
                    'target'            : target_id
                },
                function(data) {
                    initialize_versions_manager(data);
                    $("#admin-window").css("z-index", "999");
                    $("#admin-window").css("width", "100%");

                    /*width = parseInt($("#admin-window").css("width"));
                    half_width = width/2;
                    screen_width = $( window ).width();
                    left = (screen_width/2) - half_width;


                    left = Math.round(left)+"px";
                    $("#admin-window").css("left", left);*/

                }
            )
           event.stopPropagation();
           event.preventDefault();
        });
        $("#style-button").parent().addClass("active");

    }else{
        DisableStylable();
    }
}
function ToggleEditable() {

    if (editable == false) {

        $.ajax("/index.php/admin/ajax/set_user_edit_mode/true");

        DisableAllModes();
        


        $(".block").attr("contenteditable", "true");
        CKEDITOR.inlineAll();
        editable = true;

        $("i[changeableicon=true]").parent().click(function (event) {
            event.preventDefault();
        });
        //$("i[changeableicon=true]").css("border", "1px dotted red");
        $("i[changeableicon=true]").css("cursor", "pointer");
        $("i[changeableicon=true]").click(function (event) {
            target_id = $(this).attr('id');
            load_admin_window(
                '/admin/ajax/load_icon_selector', 
                {
                    'html_tag'          : encodeURIComponent('i'),
                    'css_file'          : encodeURIComponent(icon_file),
                    'base_class_name'   : encodeURIComponent('icon'),
                    'target'            : target_id
                },
                function(data) {
                    initialize_versions_manager(data);
                    $("#admin-window").css("z-index", "999");
                    $("#admin-window").css("width", "100%");
                    /*
                    width = parseInt($("#admin-window").css("width"));
                    half_width = width/2;
                    screen_width = $( window ).width();
                    left = (screen_width/2) - half_width;*/


                    /*left = Math.round(left)+"px";
                    $("#admin-window").css("left", left);*/

                }
            )
           
        });


        

        $("#edit-button").parent().addClass("active");
    } else {
        $.ajax("/index.php/admin/ajax/set_user_edit_mode/false");
        $(".block").attr("contenteditable", "false");
        var editor;
        for (editor in CKEDITOR.instances) {
            CKEDITOR.instances[editor].destroy();
        }

        editable=false;
        $("#edit-button").parent().removeClass("active");

        $("i[changeableicon=true]").css("border", "none");
        $("i[changeableicon=true]").css("cursor", "auto");
        $("i[changeableicon=true]").parent().unbind('click');
        $("i[changeableicon=true]").unbind('click');
    }
}


function ToggleResizable() {
    if (resizable == false) {
        DisableAllModes();


        $( ".resizable" ).each(function() {
            if($(this).attr("expand") != 'false' || $(this).hasClass("area"))
                return;
            old_width = parseInt($(this).css("width"));
            new_width = old_width - 2;

            old_height = parseInt($(this).css("height"));
            new_height = old_height - 2;

            $( this ).css( "width", new_width );
            $( this ).css( "height", new_height );
        });
        $(".resizable").css("border", "1px dotted #000");
        $(".resizable").resizable({

            "start": function () {

                $(this).css("min-height", "0px");
                $(this).css("min-width", "0px");

            },
            "stop" : function() {
                style   = "left: " + $(this).css("left") + ";";
                style  += "top: " + $(this).css("top") + ";";
                style  += "min-height: " + $(this).css("height") + ";";
                style  += "min-width: " + $(this).css("width") + ";";
                style  += "position: " + $(this).css("position") + ";";
                style  += "float: " + $(this).css("float") + ";";
                style  += "z-index: " + $(this).css("z-index") + ";";

                $.post("/index.php/admin/ajax/save_block",
                {
                    style:style,
                    id:$(this).attr("blockid")
                },
                function(data,status){

                });
            }

        });
        $(".area").css("border", "1px dotted #f00");
        $(".area").resizable({
            grid: [10000, 1],
          "stop" : function() {
            style   = "left: " + $(this).css("left") + ";";
            style  += "top: " + $(this).css("top") + ";";
            style  += "min-height: " + $(this).css("height") + ";";
            style  += "min-width: " + $(this).css("width") + ";";
            style  += "position: " + $(this).css("position") + ";";
            style  += "float: " + $(this).css("float") + ";";
            style  += "z-index: " + $(this).css("z-index") + ";";

            $(this).css("min-height", $(this).css("height"));
            $(this).css("min-width", $(this).css("width"));

            $(this).css("height","auto");
            $(this).css("width", "auto");

            $.post(site_root +  "/admin/ajax/save_block",
            {
                style:style,
                id:$(this).attr("blockid")
            },
            function(data,status){

            });
          }

        });
        $("#resize-button").parent().addClass("active");
        resizable=true;

        
        


        if(editable){
            ToggleEditable();
        }
    } else {

        $( ".resizable" ).each(function() {
            if($(this).attr("expand") != 'false' || $(this).hasClass("area"))
                return;
            old_width = parseInt($(this).css("width"));
            new_width = old_width + 2;

            old_height = parseInt($(this).css("height"));
            new_height = old_height + 2;

            $( this ).css( "width", new_width );
            $( this ).css( "height", new_height );
        });
        $(".resizable").css("border", "none");
        $(".resizable").resizable("destroy");
        $("#resize-button").parent().removeClass("active");
        resizable=false;
    }
}

var draggable=false;
function ToggleDraggable() {
    if (draggable == false) {
        DisableAllModes();

        $( ".movable" ).each(function() {
            if($(this).attr("expand") != 'false' || $(this).hasClass("area"))
                return;
            old_width = parseInt($(this).css("width"));
            new_width = old_width - 2;

            old_height = parseInt($(this).css("height"));
            new_height = old_height - 2;

            $( this ).css( "width", new_width );
            $( this ).css( "height", new_height );
        });
        $(".movable").css("border", "1px dotted #000");
        $(".movable").css("cursor", "move");
        

        

        draggable=true;
        $(".movable").draggable({

          "stop" : function() {
            style   = "left: " + $(this).css("left") + ";";
            style  += "top: " + $(this).css("top") + ";";
            style  += "height: " + $(this).css("height") + ";";
            style  += "width: " + $(this).css("width") + ";";
            style  += "position: " + $(this).css("position") + ";";
            style  += "float: " + $(this).css("float") + ";";
            style  += "z-index: " + $(this).css("z-index") + ";";
            $.post(site_root + "/admin/ajax/save_block",
            {
                style:style,
                id:$(this).attr("blockid")
            },
            function(data,status){

            });
          } 
      });
        $("#move-button").parent().addClass("active");
    } else {
        $( ".movable" ).each(function() {

            if($(this).attr("expand") != 'false' || $(this).hasClass("area"))
                return;
            old_width = parseInt($(this).css("width"));
            new_width = old_width + 2;

            old_height = parseInt($(this).css("height"));
            new_height = old_height + 2;

            $( this ).css( "width", new_width );
            $( this ).css( "height", new_height );
        });

        $(".movable").css("border", "none");
        
        $(".movable").draggable("destroy");

        draggable=false;
        $("#move-button").parent().removeClass("active");
        $(".movable").css("cursor", "auto");
    }
}
function add_block(area)
{
    if(blocks_mode != "add")
        return;
    area_id = $("#"+area).attr("areaid");
    $.post(site_root + "/admin/ajax/add_block/",
    {
        area: area_id,
        page_path:$("#"+area).attr("page"),

    },
    function(data,status){
        $("#"+area).append('<div contenteditable="false" class="block resizable movable" id="block-'+data+'" blockid="'+data+'" style="float: left;">\
        <p>This is your new block.</p>\
        </div>');
    });
    
}

function paste_block(area)
{
    if(blocks_mode != "paste")
        return;

    area_id = $("#"+area).attr("areaid");
    $.post(site_root + "/admin/ajax/paste_block/",
    {
        area: area_id,
        page_path:$("#"+area).attr("page"),

    },
    function(data,status){
        location.reload();
    });
    
}
function delete_block(id)
{
    if(blocks_mode != "delete")
        return;



    if(confirm("Are you sure you want to delete this block?"))
    {
        $.ajax(site_root +  "/admin/ajax/delete_block/" + $("#" + id).attr("blockid"));
        $("#" + id).remove();

    }
}
function copy_block(id)
{
    if(blocks_mode != "copy")
        return;

    $.ajax("/admin/ajax/copy_block/" + $("#" + id).attr("blockid"));
    $("#paste-block-button").parent().removeClass("disabled");
}
var last_copied = null;
function ToggleCopy()
{
    if(blocks_mode != "copy"){
        DisableAllModes();

        blocks_mode = "copy";
        //$(".area").css("width","102%");
        $(".block").css("border", "1px dotted #7c9dff");
        $(".block").css("cursor", "pointer");
        $(".block").attr("title", "Copy Block");        
        $(".block").hover(function(){
          $(this).css("background-color","#accdff");
          },function(){
          $(this).css("background-color","transparent");
        });

        $("i[changeableicon=true]").css("border", "1px dotted #7c9dff");
        $("i[changeableicon=true]").css("cursor", "pointer");

        $("i[changeableicon=true]").hover(function(){
          $(this).css("background-color","#7c9dff");
          },function(){
          $(this).css("background-color","transparent");
        });

        $(".block").click(function (event){
            copy_block($(this).attr("id"));

            if(last_copied != null){
                $("#"+last_copied).css("background-color","transparent");
                $("#"+last_copied).hover(function(){
                  $(this).css("background-color","transparent");
                  },function(){
                  $(this).css("background-color","transparent");
                });
            }
            last_copied = $(this).attr("id");
            $(this).hover(function(){
              $(this).css("background-color","#7c9dff");
              },function(){
              $(this).css("background-color","#7c9dff");
            });

            event.preventDefault();
        });
        $("i[changeableicon=true]").click(function (event){
            copy_block($(this).attr("id"));
            if(last_copied != null){
                $("#"+last_copied).css("background-color","transparent");
                $("#"+last_copied).hover(function(){
                  $(this).css("background-color","transparent");
                  },function(){
                  $(this).css("background-color","transparent");
                });
            }

            last_copied = $(this).attr("id");
            $(this).hover(function(){
              $(this).css("background-color","#7c9dff");
              },function(){
              $(this).css("background-color","#7c9dff");
            });
             event.preventDefault();
        });


       
    }else{
        blocks_mode = "";
        $("i[changeableicon=true]").css("border", "none");
        $("i[changeableicon=true]").css("cursor", "auto");
        $(".block").attr("title", "");
        $(".area").css("width","100%");
        $("i[changeableicon=true]").hover(function(){
          $(this).css("background-color","transparent");
          },function(){
          $(this).css("background-color","transparent");
        });

        $(".block").css("border", "none");
        $(".block").css("cursor", "auto");
        $(".block").hover(function(){
          $(this).css("background-color","transparent");
          },function(){
          $(this).css("background-color","transparent");
        });
    }
}

function TogglePaste()
{
    if(blocks_mode != "paste"){
        DisableAllModes();

        blocks_mode = "paste";

        $(".area").css("width","102%");
        $(".area").css("border", "1px dotted green");
        $(".area").css("cursor", "pointer");
        $(".area").attr("title", "Paste Block Here");
        $(".area").click(function (){
            paste_block($(this).attr("id"));
        });
        
        $(".area").hover(function(){
            if(blocks_mode != "paste")
                return;
            backup_bg = "none"
            if($(this).css("background") != "none")
                backup_bg = $(this).css("background-image");

            $(this).attr("backup-bg", backup_bg);
            $(this).css("background-image","none");
            $(this).css("background-color","#AFA");
        },function(){
            $(this).css("background-color","transparent");
            $(this).css("background-image",$(this).attr("backup-bg"));
        });
        event.preventDefault();
    }else{
        blocks_mode = "";
        $(".area").css("width","100%");
        $(".area").css("border", "none");
        $(".area").css("cursor", "auto");


        

        $(".area").hover(function(){
          $(this).css("background-color","transparent");
          },function(){
          $(this).css("background-color","transparent");
        });
    }
}

function ToggleAdd()
{
    if(blocks_mode != "add"){
        DisableAllModes();

        blocks_mode = "add";
        $(".area").css("border", "1px dotted green");
        $(".area").css("cursor", "pointer");

        
        
        $(".area").hover(function(){
            if(blocks_mode != "add")
                return;
            backup_bg = "none"
            if($(this).css("background") != "none")
                backup_bg = $(this).css("background-image");

            $(this).attr("backup-bg", backup_bg);
            $(this).css("background-image","none");
          $(this).css("background-color","#AFAt");
          },function(){
          $(this).css("background-color","transparent");
          $(this).css("background-image",$(this).attr("backup-bg"));

        });
        event.preventDefault();
    }else{
        blocks_mode = "";
        $(".area").css("border", "none");
        $(".area").css("cursor", "auto");


        

        $(".area").hover(function(){
          $(this).css("background-color","transparent");
          },function(){
          $(this).css("background-color","transparent");
        });
    }
}

function ToggleDelete()
{
    if(blocks_mode != "delete"){
        DisableAllModes();

        blocks_mode = "delete";
        $(".area").css("border", "1px dotted yellow");
        kids = $(".area").children();
        kids.css("border", "1px dotted red");
        kids.css("cursor", "pointer");


        
        kids.hover(function(){
          $(this).css("background-color","red");

          },function(){
          $(this).css("background-color","transparent");
        });
        event.preventDefault();
    }else{
        blocks_mode = "";
        $(".area").css("border", "none");
        kids = $(".area").children();
        kids.css("border", "none");
        kids.css("cursor", "auto");


        

        kids.hover(function(){
          $(this).css("background-color","transparent");
          },function(){
          $(this).css("background-color","transparent");
        });
    }
}
function publish_button_action()
{
    $.post("/index.php/admin/ajax/publish_version",
    {
        page:$("#publish-button").attr("page")
    },
    function(data,status){
        $( "#publish-button" ).unbind( "click.publish");
        $("#publish-button").addClass("disabled");
        $("#publish-button").html("This page is published");
    });
}

$(document).ready( function(){


    kids = $(".area").children(".block");
    kids.click(function (){
        delete_block($(this).attr("id"));
    });

    kids = $(".area").children(".resizable").children(".block");
    kids.click(function (){
        delete_block($(this).attr("id"));
    });


    $("#style-button").click( function (){
        ToggleStylable();

    });
    $(".area").click(function (){
        add_block($(this).attr("id"));
    });
    $("#add-block-button").click(function (event) {
        ToggleAdd();
    });

    $("#copy-block-button").click(function (event) {
        ToggleCopy();
        event.preventDefault();
    });

    $("#paste-block-button").click(function (event) {
        TogglePaste();
        event.preventDefault();
    });

    $("#delete-block-button").click(function (event) {
        ToggleDelete();
    });

    $(".block").change(function (){
        //alert("change");
    });


    if(editable)
        $("#edit-button").parent().addClass("active");
    else
        $("#edit-button").parent().removeClass("active");   

    $("#edit-button").click( function (event) {
        ToggleEditable();
     
        event.preventDefault();
    });

    $("#resize-button").click( function (event) {
        ToggleResizable();
        event.preventDefault();
    });

    $("#move-button").click( function (event) {
        ToggleDraggable();
        event.preventDefault();
    });


    CKEDITOR.on( 'instanceCreated', function( event ) {
        var editor = event.editor,
            element = editor.element;
        // Customize editors for headers and tag list.
        // These editors don't need features like smileys, templates, iframes etc.

        editor.on( 'focus', function() {
            $(".cke_voice_label").css("display", "block");
            $(".cke_voice_label").css("width", "90%");
            $(".cke_voice_label").css("text-align", "center");
            $(".cke_voice_label").css("font-size", "9px");
            $("#cke_414").css("display", "none");
            $("#cke_492").css("display", "none");

            
        });
        editor.on( 'blur', function() {

            $.post("/index.php/admin/ajax/save_block",
            {
                contents:editor.getData(),
                id:element.getAttribute("blockid")
            },
            function(data,status){

            });
            if($("#publish-button").hasClass("disabled"))
                initialize_publish_button();

        });

    });
    if(!$("#publish-button").hasClass("disabled"))
        initialize_publish_button();

    
    function   initialize_publish_button()
    {
        $("#publish-button").removeClass("disabled");
        $("#publish-button").html("Publish");

        $( "#publish-button" ).bind( "click.publish",function () {
            $("#publish-button").html("Publishing...");
            setTimeout("publish_button_action();", 1000);
            
        });
    }
    
});

var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

function post() {
    alert("Post");
    // expensive update ajax call such as 
    // updating database or 
    // rewrite to file system etc ...
    $.post("update.php", 
        {data:ed.getData()}
    );
}

function load_admin_window(url, post_data, ready_function)
{
    $("#admin-window").remove();
    $( "body" ).append( "<div id='admin-window' style='position:fixed; top: 20px;'> </div>" );

    $.post(url,
        post_data,
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
            $("#admin-window").draggable();
            $("#admin-window-close").click(function(event){
                $("#admin-window").remove();   
                event.preventDefault();
            });

        });
}


$("#layout-versions-button").click(function () {
    $(this).parent().addClass("active");
    $("#page-versions-button").parent().removeClass("active");

    $("#admin-window").remove();
    $( "body" ).append( "<div id='admin-window' style='position:fixed; top: 100px;'> </div>" );

    $.post('/admin/ajax/load_versions_manager/layout',
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
            $("#layout-versions-button").parent().removeClass("active");
            event.preventDefault();
        });
    });
    

});