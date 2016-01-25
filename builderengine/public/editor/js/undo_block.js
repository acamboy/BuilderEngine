function initializeUndoBlock(){
	$(".block .block-controls .undo").bind( "click",function (event) {
		event.stopPropagation();
		event.preventDefault();
		confirmation_text = "Are you sure you want to undo this block?";
		if(!confirm(confirmation_text)){
			return;
		}else{

			var block = $(this).parents('.freeMode');
			block_name = block.attr('name');

			$.post(site_root + "/layout_system/ajax/undo_block_free_mode",
			{
			    page_path: page_path,
			    name:block_name
			},
			function(data,status){

			});
			block.css({'left':'','top':'','z-index':'','width':'','height':''});
		}
	});
}