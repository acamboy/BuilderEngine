/**
 * Created by krastevd on 11/24/14.
 */
function initialize_block_admin_options()
{
    $(".toggle-class").unbind('click.toggleClass');
    $(".toggle-class").bind('click.toggleClass', function(event){
        event.preventDefault();
        toggled = $(this).hasClass('active');
        $(this).toggleClass('active');

        var target_block_name = $(this).closest('.block').attr("name");
        var _htmldiv = $(this).closest('.block');
        _type = _htmldiv.attr( "block-type" );
        //console.log( _type );
        //header
        //page
        //row

        switch( _type ){
            case 'header':{
                if( _htmldiv.hasClass( "container" ) ){
                    _htmldiv.removeClass( "container").addClass( "container-fluid" );
                }else{
                    _htmldiv.removeClass( "container-fluid").addClass( "container" );
                }
                break;
            }
            case 'page':{
                if( _htmldiv.hasClass( "container" ) ){
                    _htmldiv.removeClass( "container").addClass( "container-fluid" );
                }else{
                    _htmldiv.removeClass( "container-fluid").addClass( "container" );
                }
                break;
            }
            case 'footer':{
                if( _htmldiv.hasClass( "container" ) ){
                    _htmldiv.removeClass( "container").addClass( "container-fluid" );
                }else{
                    _htmldiv.removeClass( "container-fluid").addClass( "container" );
                }
                break;
            }
            case 'row':{
                if( _htmldiv.hasClass( "container" ) && _htmldiv.hasClass( "boxed-row" ) ){
                    _htmldiv.removeClass( "container  boxed-row").addClass( "container-fluid" );
                }else{
                    _htmldiv.removeClass( "container-fluid").addClass( "container  boxed-row" );
                }
                break;
            }
            default:{ break; }
        }




        $.post(site_root + "/layout_system/ajax/toggle_option/" + target_block_name,
        {
            page_path: page_path,
            data_toggle: $(this).attr("toggle-option"),
            data_toggle_state: !toggled

        },

        function(data) {
            reload_block(target_block_name, page_path, true);
            refresh_editor();

        })
        .fail(function() {
            alert('There was an error performing this operation.\nPlease contact customer support.') ;
        });

    });


    $(".block-select-option").unbind('click.selectOption');
    $(".block-select-option").bind('click.selectOption', function(event){
        event.preventDefault();
        toggled = $(this).hasClass('active');
        $(this).toggleClass('active');

        var target_block_name = $(this).closest('.block').attr("name");

        $.post(site_root + "/layout_system/ajax/select_option/" + target_block_name,
        {
            page_path: page_path,
            data_option_name: $(this).closest('.block-select-options').attr("data-option-name"),
            data_option_choice: $(this).attr("data-option-choice"),

        },

        function(data) {
            reload_block(target_block_name, page_path, true);
            refresh_editor();

        })
        .fail(function() {
            alert('There was an error performing this operation.\nPlease contact customer support.') ;
        });

    });



    
}