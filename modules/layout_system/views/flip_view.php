<script src="<?=get_theme_path()?>plugins/flippant/flippant.js"></script>
<div id="flipthis" style="width:250px;border:1px solid #444;padding:4px;">
  	<h2>this is a card thing</h2>
  	<button id="flipCard">Card &raquo;</a>
</div>
<script>
	var content = '<?php echo $popup;?>'
    var front = document.getElementById('flipthis')
        , back_content = content
        , back
    document.getElementById("flipCard").addEventListener('click',function(e){
        back = flippant.flip(front, back_content, "modal")
    })
</script>
<script>
    $("#admin-window").css('display','block');
    $("#admin-window").draggable();
</script>