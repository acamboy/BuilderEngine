	var drag_source_parent = null;
    function reload_block(block_name, page_path, forced)
    {
        //if(!has_focus)
        //    return;
        if(!forced && disable_auto_block_reload ){
            alert('nope ' + forced);
            return;
        }
        var getting_block = true;

        jQuery.ajax({
            type: "POST",
            data: { page_path: page_path },
            url:    site_root + '/layout_system/ajax/get_block/' + block_name + '?time='+new Date().getTime(),
            success: function(data) {
                $('.block').each(function(){
                    if($(this).attr("name") == block_name){

                        old_data = $(this).html();

                        cloned = $(this).clone();
                        cloned = cloned.replaceWith(data);
                        cloned_data = cloned.html();
                        $(this).attr('class', cloned.attr('class'));
                        cloned.remove();
                        if(old_data != cloned_data || forced)
                            $(this).replaceWith(data);
                        refresh_editor();

                    }
                });

                var getting_block = false;
            },
            async:   true
        });


    }
	function refresh_editor()
	{
		initialize_hovers();
		initialize_clicks();
		initialize_sorts();

        initialize_block_admin_options();

        enableResize();
        initializeRemoveBlock();
        initializeUndoBlock();

	}
	function get_block_children(name)
	{
		parent = $(".block-children[block-name=" + name + "]");
		var children=new Array(); 
		i = 0;
		parent.children().each(function () {
			if($(this).hasClass('block')){

				children[i] = $(this).attr('name');
				i++;
			}
		});
		return children;
	}
	function initialize_sorts()
	{
        if (typeof jQuery.ui == 'undefined') {
            alert('Warning! jQuery UI library is not present, which is unusual. Please check if  you have multiple libraries of the same type included several times (ex. jQuery, jQueryUI, etc.)');
            return;
        }


        $(".content-children.block-children").sortable(
        {
            helper : 'clone',
            // handle : '.drag',
            connectWith: '.content-children',
            forceHelperSize : true,
                handle : '.block-controls',
                // placeholder: "ui-state-highlight",
                dropOnEmpty: true,
                forceHelperSize : true,
                tolerance: 'pointer',
                cursor: "move",
            sort : function(e, ui) {
                total_width = parseInt(ui.placeholder.closest('.block-children').css('width')) - parseInt(ui.placeholder.css('width'));
                left_offset = total_width / 2;
                current_left = parseInt(ui.helper.css('left'));
                ui.helper.css('left', current_left + left_offset + 'px');
            },
            start : function(e, ui) {

                ui.placeholder.css('height', ui.item
                    .css('height'));
                ui.placeholder.css('margin-top', ui.item
                    .css('margin-top'));
                ui.placeholder.css('margin-bottom', ui.item
                    .css('margin-bottom'));
                ui.placeholder.css('padding-top', ui.item
                    .css('padding-top'));
                ui.placeholder.css('padding-bottom',
                    ui.item.css('padding-bottom'));

                obj = ui.item;
                block_name = obj.attr('name');
                drag_source_parent = obj.parent().attr('block-name');

            },
            stop: function (e, ui) {
                obj = ui.item;
                block_name = obj.attr('name');
                var parent_name = obj.parent().attr('block-name');

                var children = get_block_children(parent_name)
                $.post(site_root + "/layout_system/ajax/save_block_children",
                    {
                        children:JSON.stringify(children),
                        name:parent_name,
                        page_path: page_path
                    },
                    function(data,status){
                        notifyChange();
                    }).error(function() { alert('There was an error saving your changes.\nPlease contact customer support.'); });

                if(parent_name != drag_source_parent)
                {
                    var children = get_block_children(drag_source_parent)
                    $.post(site_root + "/layout_system/ajax/save_block_children",
                        {
                            children:JSON.stringify(children),
                            name:drag_source_parent,
                            page_path: page_path
                        },
                        function(data,status){
                            notifyChange();
                        }).error(function() { alert('There was an error saving your changes.\nPlease contact customer support.'); });

                }
                refresh_editor();

            },


        });
		$(".row-children.block-children").sortable(
			{
				helper : 'clone',
				// handle : '.drag',
                handle : '.block-controls',
                // placeholder: "ui-state-highlight",
                connectWith: '.row-children',
                dropOnEmpty: true,
				forceHelperSize : true,
                tolerance: 'pointer',
                cursor: "move",
				start : function(e, ui) {

					ui.placeholder.css('height', ui.item
							.css('height'));
					ui.placeholder.css('margin-top', ui.item
							.css('margin-top'));
					ui.placeholder.css('margin-bottom', ui.item
							.css('margin-bottom'));
					ui.placeholder.css('padding-top', ui.item
							.css('padding-top'));
					ui.placeholder.css('padding-bottom',
							ui.item.css('padding-bottom'));

					obj = ui.item;
		          	block_name = obj.attr('name');
					drag_source_parent = obj.parent().attr('block-name');
					
				},
				stop: function (e, ui) {
		          obj = ui.item;
		          block_name = obj.attr('name');
		          var parent_name = obj.parent().attr('block-name');
		        
		          var children = get_block_children(parent_name)
		          $.post(site_root + "/layout_system/ajax/save_block_children",
		          {
		              children:JSON.stringify(children),
		              name:parent_name,
		              page_path: page_path
		          },
		          function(data,status){
		            notifyChange();
		          }).error(function() { alert('There was an error saving your changes.\nPlease contact customer support.'); });

		          if(parent_name != drag_source_parent)
		          {
		          	var children = get_block_children(drag_source_parent)
			          $.post(site_root + "/layout_system/ajax/save_block_children",
			          {
			              children:JSON.stringify(children),
			              name:drag_source_parent,
			              page_path: page_path
			          },
			          function(data,status){
			            notifyChange();
			          }).error(function() { alert('There was an error saving your changes.\nPlease contact customer support.'); });

		          }
                    refresh_editor();
		        },

				
			});/*.attr('unselectable','on').css({'-moz-user-select':'-moz-none',
           '-moz-user-select':'none',
           '-o-user-select':'none',
           '-khtml-user-select':'none',
           '-webkit-user-select':'none',
           '-ms-user-select':'none',
           'user-select':'none'
     		}).bind('selectstart', function(){ return false; });*/


	$(".column-children.block-children").sortable(
			{
				helper : 'clone',
                // handle : '.drag',
                handle : '.block-controls',
				connectWith: '.column-children',
				forceHelperSize : true,
                cursor: "move",
                // placeholder: "ui-state-highlight",
                dropOnEmpty: true,
                appendTo: '.column-children',
                tolerance: 'pointer',
				start : function(e, ui) {
					ui.placeholder.css('height', ui.item
							.css('height'));
					ui.placeholder.css('margin-top', ui.item
							.css('margin-top'));
					ui.placeholder.css('margin-bottom', ui.item
							.css('margin-bottom'));
					ui.placeholder.css('padding-top', ui.item
							.css('padding-top'));
					ui.placeholder.css('padding-bottom',
							ui.item.css('padding-bottom'));

					obj = ui.item;
		          	block_name = obj.attr('name');
					drag_source_parent = obj.parent().attr('block-name');
					
				},
				stop: function (e, ui) {
		          obj = ui.item;
		          block_name = obj.attr('name');
		          var parent_name = obj.parent().attr('block-name');
		        
		          var children = get_block_children(parent_name)
		          $.post(site_root + "/layout_system/ajax/save_block_children",
		          {
		              children:JSON.stringify(children),
		              name:parent_name,
		              page_path: page_path
		          },
		          function(data,status){
		            notifyChange();
		          }).error(function() { alert('There was an error saving your changes.\nPlease contact customer support.'); });

		          if(parent_name != drag_source_parent)
		          {
		          	var children = get_block_children(drag_source_parent)
			          $.post(site_root + "/layout_system/ajax/save_block_children",
			          {
			              children:JSON.stringify(children),
			              name:drag_source_parent,
			              page_path: page_path
			          },
			          function(data,status){
			            notifyChange();
			          }).error(function() { alert('There was an error saving your changes.\nPlease contact customer support.'); });

		          }

                    refresh_editor();
                },

				
			});/*.attr('unselectable','on').css({'-moz-user-select':'-moz-none',
           '-moz-user-select':'none',
           '-o-user-select':'none',
           '-khtml-user-select':'none',
           '-webkit-user-select':'none',
           '-ms-user-select':'none',
           'user-select':'none'
     		}).bind('selectstart', function(){ return false; });/*disableSelection();*/
        $(".header-children.block-children").sortable(
            {
                helper : 'clone',
                handle : '.drag',
                forceHelperSize : true,
                handle : '.block-controls',
                // placeholder: "ui-state-highlight",
                dropOnEmpty: true,
                forceHelperSize : true,
                tolerance: 'pointer',
                cursor: "move",
                start : function(e, ui) {

                    ui.placeholder.css('height', ui.item
                        .css('height'));
                    ui.placeholder.css('margin-top', ui.item
                        .css('margin-top'));
                    ui.placeholder.css('margin-bottom', ui.item
                        .css('margin-bottom'));
                    ui.placeholder.css('padding-top', ui.item
                        .css('padding-top'));
                    ui.placeholder.css('padding-bottom',
                        ui.item.css('padding-bottom'));

                    obj = ui.item;
                    block_name = obj.attr('name');
                    drag_source_parent = obj.parent().attr('block-name');

                },
                stop: function (e, ui) {
                    obj = ui.item;
                    block_name = obj.attr('name');
                    var parent_name = obj.parent().attr('block-name');

                    var children = get_block_children(parent_name)
                    $.post(site_root + "/layout_system/ajax/save_block_children",
                        {
                            children:JSON.stringify(children),
                            name:parent_name,
                            page_path: page_path
                        },
                        function(data,status){
                            notifyChange();
                        }).error(function() { alert('There was an error saving your changes.\nPlease contact customer support.'); });

                    if(parent_name != drag_source_parent)
                    {
                        var children = get_block_children(drag_source_parent)
                        $.post(site_root + "/layout_system/ajax/save_block_children",
                            {
                                children:JSON.stringify(children),
                                name:drag_source_parent,
                                page_path: page_path
                            },
                            function(data,status){
                                notifyChange();
                            }).error(function() { alert('There was an error saving your changes.\nPlease contact customer support.'); });

                    }
                    refresh_editor();

                },


            });
        $(".page-children.block-children").sortable(
            {
                helper : 'clone',
                handle : '.drag',
                forceHelperSize : true,
                handle : '.block-controls',
                // placeholder: "ui-state-highlight",
                dropOnEmpty: true,
                forceHelperSize : true,
                tolerance: 'pointer',
                cursor: "move",
                sort : function(e, ui) {
                    total_width = parseInt(ui.placeholder.closest('.block-children').css('width')) - parseInt(ui.placeholder.css('width'));
                    left_offset = total_width / 2;
                    current_left = parseInt(ui.helper.css('left'));
                    ui.helper.css('left', current_left + left_offset + 'px');
                },
                start : function(e, ui) {

                    ui.placeholder.css('height', ui.item
                        .css('height'));
                    ui.placeholder.css('margin-top', ui.item
                        .css('margin-top'));
                    ui.placeholder.css('margin-bottom', ui.item
                        .css('margin-bottom'));
                    ui.placeholder.css('margin-left', ui.item
                        .css('margin-left'));
                    ui.placeholder.css('margin-right', ui.item
                        .css('margin-right'));
                    ui.placeholder.css('padding-top', ui.item
                        .css('padding-top'));
                    ui.placeholder.css('padding-bottom',
                        ui.item.css('padding-bottom'));

                    obj = ui.item;
                    block_name = obj.attr('name');
                    drag_source_parent = obj.parent().attr('block-name');

                },
                stop: function (e, ui) {
                    obj = ui.item;
                    block_name = obj.attr('name');
                    var parent_name = obj.parent().attr('block-name');

                    var children = get_block_children(parent_name)
                    $.post(site_root + "/layout_system/ajax/save_block_children",
                        {
                            children:JSON.stringify(children),
                            name:parent_name,
                            page_path: page_path
                        },
                        function(data,status){
                            notifyChange();
                        }).error(function() { alert('There was an error saving your changes.\nPlease contact customer support.'); });

                    if(parent_name != drag_source_parent)
                    {
                        var children = get_block_children(drag_source_parent)
                        $.post(site_root + "/layout_system/ajax/save_block_children",
                            {
                                children:JSON.stringify(children),
                                name:drag_source_parent,
                                page_path: page_path
                            },
                            function(data,status){
                                notifyChange();
                            }).error(function() { alert('There was an error saving your changes.\nPlease contact customer support.'); });

                    }
                    refresh_editor();

                },


            });
	}
	function initialize_clicks()
	{
		$(".add-row-column").unbind('click.addRowColumn');
		$(".add-row-column").bind('click.addRowColumn', function(){
			column_class = $(this).attr('data-class');
			target = $(this).closest(".be-row-block").find(".block-children").first();
			$.get("ajax/new_column.php?class=" + column_class, function(data) {
				$(target).prepend(data);
				initialize_hovers();
			});
			
		});

		$(".block-add-child-block").unbind('click.addChildBlock');
		$(".block-add-child-block").bind('click.addChildBlock',
				function(event) {
					event.preventDefault();
					
					dropdown = $(this).find("ul");
					$.get(site_root + "/layout_system/ajax/block_list_dropdown/" + $(this).closest('.block').attr('name') + "?page_path=" + page_path, function(
							data) {
						$(dropdown).html(data);
						$("a.insert-block").unbind('click.insertBlock');
						$("a.insert-block").bind('click.insertBlock',
								function() {
									content = $(this).closest(".block").find(".block-children").first();
									block_type = $(this).attr('block-type');
									data_class = $(this).attr('data-class');

									$.post(site_root+"/layout_system/ajax/add_block/" + $(content).attr("block-name") + "/" + block_type,
								      {
								        page_path: page_path,
								        data_class: data_class
								      },

								      function(data) {
                                        notifyChange();
								      $parentBlock = content.prepend(data);

                                          $childBlock = $parentBlock.find('.block.be-content-block').first();
                                          $childBlock.find('.block-content').attr("contenteditable", "true");
                                          $("#edit-button").parent().addClass("active");
                                          editModeRefresh();

										refresh_editor();

								    })
								      .fail(function() {
								        alert('There was an error performing this operation.\nPlease contact customer support.') ;
								      });


								});

						refresh_editor();

					})
                });

	}

    function editModeRefresh(){

        console.log('refresh editMode');

        editModeDisable();
        editModeEnable();
    }

	function initialize_hovers()
	{
		/*$(".block .block-content > *").unbind('mouseenter.removeComponent').unbind('mouseleave.removeComponent');
		$(".block .block-content > *").bind('mouseenter.removeComponent', function(){
			$(this).css('position', 'relative');
			$(this)
					.prepend(
							'<a href="#close" style="" class="remove label label-danger"><i class="glyphicon-remove glyphicon"></i> remove</a>');

			$(this).find('.remove').click(function() {
				$(this).parent().remove();
			})
		});
		
		$(".block .block-content > *").bind('mouseleave.removeComponent', function(){
			$(this).find('.remove').remove();
		});*/
	}