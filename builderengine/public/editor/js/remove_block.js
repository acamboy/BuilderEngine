var test = 'test';
function initializeRemoveBlock()
{
  $(".block .block-controls .remove").bind( "click.delete_block",function (event) {
    event.stopPropagation();
    event.preventDefault();
    confirmation_text = "Are you sure you want to delete this block?";
    if(!confirm(confirmation_text))
      return;

    var block_obj_to_delete = $(this).closest('.block');
    var parent_name = $(block_obj_to_delete).closest('.block-children').attr('block-name');
    $.ajax(site_root+"/layout_system/ajax/delete_block/" + $(block_obj_to_delete).attr("name") + "/" + parent_name + "?page_path=" + page_path).error(function() {
      var success = false; 
      alert('There was an error performing this operation.\nPlease contact customer support.') 
    }).success(function()
    {
      notifyChange();
    });

    block_obj_to_delete.remove();
    block_obj_to_delete = null;
  });

  
}