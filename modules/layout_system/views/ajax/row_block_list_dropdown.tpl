
<li onmouseover="rowDetectEdge(this)" id="row-block-dropdown" class="dropdown-submenu">
    <a tabindex="-1" href="#">Column</a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
        <li onmouseover="rowDetectEdge(this)" class="dropdown-submenu"><a tabindex="-1" href="#">Simple Width Size</a>
            <ul class="dropdown-menu">
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-12">Full</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-6">Half</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-4">Third</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-3">Quarter</a></li>
            </ul></li>
        <li onmouseover="rowDetectEdge(this)" class="dropdown-submenu"><a tabindex="-1" href="#">Advanced Width Size</a>
            <ul class="dropdown-menu">
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-12">12/12</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-11">11/12</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-10">10/12</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-9">9/12</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-8">8/12</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-7">7/12</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-6">6/12</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-5">5/12</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-4">4/12</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-3">3/12</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-2">2/12</a></li>
                <li><a href="#" class="insert-block" block-type="column" data-class="col-lg-1">1/12</a></li>

            </ul></li>

    </ul>
</li>
<script>
    $(document).ready(function(){
        $('#row-block-dropdown').parent().css('left', '-188px');
    });
    function rowDetectEdge(obj){
        $(obj).parent().parent().parent().parent().find('#dropdownMenu1').css('z-index', '1001');
        var position = $(obj).find('.dropdown-menu').position();
        var absoluteRight = ($(window).width() - ($(obj).offset().left + $(obj).outerWidth()));
        if(absoluteRight < 220){
            $(obj).find('.dropdown-menu').css('left', '-188px');
        }
    }
</script>