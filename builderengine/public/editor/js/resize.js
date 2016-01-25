var device_size = "lg";
var initial_class = "";

function detect_device_size()
{
  size_x = parseInt($("body").css('width'));
  if(size_x < 768)
  {
    device_size = "xs";
  }else{ 
    if(size_x >= 768 && size_x < 992)
    {

      device_size = "sm";

    }else
    { 
      if(size_x >= 992 && size_x < 1200)
      {
        device_size = "md";

      }
      else
      {
        device_size = "lg";

      }
    }
  }
}
function enableResize()
{
    $(".be-column-block").each(function () {
      $(this).resizable({

        resize: function () {
          if(row == null){
            console.log("Getting new row");
            row = getParentRowInfo($(this));
          }
          if(row['type'] == "row"){
            if(span_step == 0)
              span_step = detectSpanWidth($(this));

            current_width = parseInt($(this).css("width"));
            $(this).css("width", "");

            
            span = get_element_col_size(this);
            if(current_width > (span * span_step) + 10)
            {

              current_span = get_element_col_size(this);
              if(current_span != 12)
              {
                $(this).removeClass("col-" + device_size + "-" + current_span);
                current_span++;
                $(this).addClass("col-" + device_size + "-" + current_span);
                $(this).css("width", "");
                
              }
            }

            if(current_width < ((span-2) * span_step) + 10)
            {

              current_span = get_element_col_size(this);
              if(current_span != 1)
              {
                $(this).removeClass("col-" + device_size + "-" + current_span);
                current_span--;
                $(this).addClass("col-" + device_size + "-" + current_span);
                $(this).css("width", "");
              }
            }

          }else{
             span_step = 0;
              if(span_step == 0)
                span_step = detectSpanWidth($(this));

              current_width = parseInt($(this).css("width")) + 30;
              $(this).css("width", "");

              
              span = get_element_col_size(this);
              console.log("Current width " + current_width + " next step is " + row['width'] * fluid_span[(span + 1)] + " row width " + row['width'] + " span " + fluid_span[(span + 1)]);
              if(current_width > row['width'] * fluid_span[(span + 1)]  )
              {

                current_span = get_element_col_size(this);
                console.log("Current span " + current_span);
                if(current_span != 12)
                {
                  $(this).removeClass("col-" + device_size + "-" + current_span);
                  current_span++;
                  $(this).addClass("col-" + device_size + "-" + current_span);
                  $(this).css("width", "");
                  
                }
              }

              if(current_width < row['width'] * fluid_span[(span - 1)])
              {

                current_span = get_element_col_size(this);
                if(current_span != 1)
                {
                  $(this).removeClass("col-" + device_size + "-" + current_span);
                  current_span--;
                  $(this).addClass("col-" + device_size + "-" + current_span);
                  $(this).css("width", "");
                
                }
              }
          }
          },
        start: function (event, ui) {
                detect_device_size();
                row = null;
                $(this).attr('resizing', 'true');
                block = ui.originalElement;
                min_height = block.css('min-height');
                height = block.css('height');
                if(parseInt(min_height) > parseInt(height))
                  height = min_height;

                block.css('height', height);
                block.css('min-height', '0px');

                span = get_element_col_size(this);
                initial_class = "col-" + device_size + "-" + span;

                
        }, 
        stop: function (event, ui) {
          detect_device_size();
          span_step = 0;
                $(this).attr('resizing', 'false');
                block = ui.originalElement;
                height = block.css('height');
                block.css('height', 'auto');
                block.css('min-height', height);
                span_count = get_element_col_size(block);
                span = "col-" + device_size + "-" + span_count;
                block_name = block.attr('name');
                $.post(site_root + "/layout_system/ajax/save_block",
                  {
                      page_path: page_path,
                      size:span,
                      initial_size: initial_class,
                      height:block.css('min-height'),
                      name:block_name,
                  },
                  function(data,status){
                    notifyChange();
                  }).error(function() { alert('There was an error saving your changes.\nPlease contact customer support.'); });

              }
      });

      /*$(this).hover( function(){
        $(this).prepend("<div class='block-overlay'></div>");
        $(this).find(".block-overlay").css('position', 'absolute');
        $(this).find(".block-overlay").css('top', '0px');
        $(this).find(".block-overlay").css('left', '0px');
        $(this).find(".block-overlay").css('width', '100%');
        $(this).find(".block-overlay").css('height', '100%');
        $(this).find(".block-overlay").css('opacity', '0.5');
        $(this).find(".block-overlay").css('border', '2px dotted #999');
        $(this).find(".block-overlay").css('z-index', '1');
        if($(this).hasClass('row')){
          $(this).find(".block-overlay").css('left', '20px');  
          width = parseInt($(this).find(".block-overlay").css('width'));
          new_width = width - 20;
          $(this).find(".block-overlay").css('width', new_width + 'px');  

        }
          
      },function (){
          $(this).find(".block-overlay").remove();
      }
      )*/
      
    });
  

    

    

    function check_total_span_sum(element)
    {
      
      sum = 0;
      element.children().each(function (){
        sum += get_element_col_size(this);

      });
      return sum;
    }

}
function freeModeEnableResize(){
      $(".freeMode").each(function () {
      $(this).resizable({
        start: function (event, ui) {
          $(this).css({
              position: "relative",
              // left: $(this).originalPosition.left,
              // width:$(this).originalSize.width
          });
        },
        stop: function (event, ui) {
          block_name = $(event.target).attr('name');
          // console.log(block_name)
          $.post(site_root + "/layout_system/ajax/save_block_free_mode_risize",
          {
              page_path: page_path,
              name:block_name,
              width:$(this).css("width"),
              height:$(this).css("height")
          },
          function(data,status){

          });
        }
      });
    });
}
function getParentRowInfo(obj)
{
  up = obj;

  while(!up.is('body'))
  {
    up = up.parent();
    if(up.hasClass('row-fluid'))
    {
      w = parseInt(up.css('width'));
      console.log("Detected row width: " + w );
      return {type: 'row-fluid', width: w};
    }

    if(up.hasClass('row'))
    {
      console.log("Detected standard row ");
      return {type: 'row', width: 0};
    }
  }
      console.log("Assumed standard row ");
  return {type: 'row', step: 0};
}
function detectSpanWidth(tester)
{/*
  span = parseInt(get_element_span(tester));
  span -= 1;
  width = parseInt($(tester).css('width'));
  width -= 80;

  return Math.round(width/span);*/
  if(row == null)
  row = getParentRowInfo(tester);

  if(row['type'] == "row")
  {
    span = parseInt(get_element_span(tester));
    span -= 1;
    width = parseInt($(tester).css('width'));
    width -= 80;
    console.log("Returning something");
    return Math.round(width/span);
  }else
  {
    return row['step'];

  }
}

function get_element_col_size(element)
{
  if($(element).hasClass("col-" + device_size + "-1"))
    return 1;
  if($(element).hasClass("col-" + device_size + "-2"))
    return 2;
  if($(element).hasClass("col-" + device_size + "-3"))
    return 3;
  if($(element).hasClass("col-" + device_size + "-4"))
    return 4;
  if($(element).hasClass("col-" + device_size + "-5"))
    return 5;
  if($(element).hasClass("col-" + device_size + "-6"))
    return 6;
  if($(element).hasClass("col-" + device_size + "-7"))
    return 7;
  if($(element).hasClass("col-" + device_size + "-8"))
    return 8;
  if($(element).hasClass("col-" + device_size + "-9"))
    return 9;
  if($(element).hasClass("col-" + device_size + "-10"))
    return 10;
  if($(element).hasClass("col-" + device_size + "-11"))
    return 11;
  if($(element).hasClass("col-" + device_size + "-12"))
    return 12;

}