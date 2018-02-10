<div id="page_result_container" style="position:absolute; top:249px; left:4px;width:648px;z-index:3000;display:none;">
	<div id="page_result_bar" style="width:648px;height:18px;background-color:#000000;">
		<div style="float:right; padding-right:10px;padding-top:2px;color:#ffffff;" onclick="remove_mgt_bar_menu_id();">Fenster schlieﬂen [X]</div>
	</div>
	<div id="page_result" src="" style="width:648px;background-color:#fff;overflow-x:scroll;">
	</div>
</div>
<script>
function reload_mgt_bar_menu_id()
{
	$('#page_result_container').css("display","block");
	$('#page_result').load("/site_12_1/includes/seitencontent/management_bar_tasks_backend.php?mgt_bar_task=show_mgt_menu_id&mgt_bar_menu_id="+parseInt($('#mgt_bar_menu_id').val())
	,function(){
		$('#page_result').ready(function(){
			$('#page_result').css("border","1px solid grey");
			changecssproperty(document.getElementById('page_result_container'), shadowprop, '5px 5px 20px 10px rgba(0,0,0,.8)');
			$("body").append("<div id='block'>");
			$('#block').css({opacity:0.5}).css("position","absolute").css("top","0px").css("left","0px").css("height","100%").css("width","100%").css("background-color","#444444").css("z-index","2000");		
			$('#page_result').height(Math.min(700,$('#page_result').height()));			
		});
	});
}
function remove_mgt_bar_menu_id()
{
	$('#page_result_container').slideUp(function(){
		$('#block').remove();	
		$('#page_result').css("height","");
		$('#page_result').html("");
	});
}


</script>	
<form method="post" onsubmit="reload_mgt_bar_menu_id();return false;">
	<input type="text" name="mgt_bar_menu_id" id="mgt_bar_menu_id"/>
	<input type="button" onclick="reload_mgt_bar_menu_id()" value="update"/>
</form>
