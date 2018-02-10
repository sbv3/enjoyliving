<?
$visitor->load_visited_menu_ids();
$menus=array_keys($visitor->visited_menu_ids);
$menus=array_unique($menus);
$menus=implode("|",$menus);
?>
<div id="histroy_result" style="background-color:#fff; width:300px;">

</div>

<script>
if(typeof (jQuery_easing_loaded)=="undefined")
{
	document.write("<scr" + "ipt type='text/javascript' src='/Connections/Slider/source/jquery_easing.js'></scr" + "ipt>");
	document.write("<scr" + "ipt type='text/javascript' src='/Connections/Slider/source/slides.min.jquery.js'></scr" + "ipt>");
}

function load_history()
{
	//$('#histroy_result').load("/site_12_1/includes/seitencontent/xxx.php"
	$('#histroy_result').load("/site_12_1/includes/seitencontent/management_bar_history_backend.php?menu_ids=<? echo $menus;?>&elem_id=<? echo $elem_id;?>&used_menu_id=<? echo $active_menu_id?>&css_is_included=1"
	,function(){
		$("[name='management_tab1_list']").slideToggle("fast");
		$("[name='management_tab1_selected']").toggle();
	}
	);
}
</script>