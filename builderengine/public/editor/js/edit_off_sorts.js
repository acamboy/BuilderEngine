function initialize_edit_off_sorts()
	{
      if (typeof jQuery.ui == 'undefined') {
          alert('Warning! jQuery UI library is not present, which is unusual. Please check if  you have multiple libraries of the same type included several times (ex. jQuery, jQueryUI, etc.)');
          return;
      }

      $(".freeMode").draggable({
          start: function( e, ui ) {
            // $(this).css("position","absolute");
          },
          stop : function(e, ui) {
              block_name = $(e.target).attr('name');
              $(this).css("z-index",'9999')

              $.post(site_root + "/layout_system/ajax/save_block_free_mode",
              {
                  page_path: page_path,
                  name:block_name,
                  left:$(this).css("left"),
                  top:$(this).css("top")
              },
              function(data,status){

              });
          } 
      });
	}