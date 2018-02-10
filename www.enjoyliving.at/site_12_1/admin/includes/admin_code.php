<div style="height:35px;">
	<? if($row_id==""){$row_id=1;}?>
	<? if($codes_active[$row_id]==0){ /////Hier kommen die "nicht aktiv"?>
		<a style="width:23px; height:35px; overflow:hidden; float:right"><img id="<? echo 'code_active'.$codes_id[$row_id] ?>" src="/site_12_1/css/checkbox_unchecked.png" width="23" title="Das Element wird nicht angezeigt." onClick="update_code_active(<? echo "$codes_id[$row_id]";?>,1);"></a>
	<? }
	if($codes_active[$row_id]==1){ /////Hier kommen die "aktiv"?>
		<a style="width:23px; height:35px; overflow:hidden; float:right"><img id="<? echo 'code_active'.$codes_id[$row_id] ?>" src="/site_12_1/css/checkbox_checked.png" width="23" title="Das Element wird angezeigt." onClick="update_code_active(<? echo "$codes_id[$row_id]";?>,0);"></a>
	<? }?>
	<div style="float:left; height:19px;">Code-Element-Typ:</div>
	<div style="clear:left;overflow:hidden"><? echo strrchr($codes[$row_id],'/');?></div>
</div>
<div style="clear:both;"></div>
<div class="trenner"></div>
<?
include $codes[$row_id];
$row_id="";
?>
<div id="table_result_error_messages"></div>