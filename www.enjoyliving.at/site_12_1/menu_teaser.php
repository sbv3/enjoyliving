<?
for ($anz=1;$anz<=count($menus)-1;$anz+=1)
{

	///////////////menu_teaser reinladen	
	$menu_id_sub_query=mysql_query("select teaser_head, teaser_copy, teaser_asset_id from menu_teaser where menu_id='$menus[$anz]' and element_id='$elem_id' and site_id=$site_id") or die ("2.3".mysql_error());
	$menu_id_sub_result = mysql_fetch_row($menu_id_sub_query);

	$menu_id_sub_menu_id = $menus[$anz];
	$titel = $menu_id_sub_result[0];
	$copy = $menu_id_sub_result[1];
	$titel_href = find_googleurl($menus[$anz]);
	$menu_id_sub_teaser_asset_id = $menu_id_sub_result[2];
	
	// hier noch die Beschriftung der Parent_ID finden fÃ¼r die Anzeige...
	$menu_master_sub=find_parent($menus[$anz]);
	$menu_parent_googleurl=find_googleurl($menu_master_sub);
	$menu_description_parent=find_description($menu_master_sub);
	
	if($titel=="")
	{
		$titel=teaser_text($menus[$anz],"Titel",0,$elem_id);$titel=$titel[text];
	}
	
	if($copy=="")
	{
		$copy=teaser_text($menus[$anz],"Copy",$truncate_length,$elem_id);$copy=$copy[text];
	}
	
	//Schleife für die asset_id
	$imgs_details=teaser_bild($menus[$anz],$clippingbox_breite,$elem_id);
	
	$menu_id_sub_teaser_asset_id2=$imgs_details['asset_id'];//assets.ID
	$category=$imgs_details['asset_id'];//category
	$class=$imgs_details['class'];//class
	$path=$imgs_details['path'];//path
	$filename=$imgs_details['filename'];//filename
	$imgs_url=$imgs_details['imgs_url'];
	$imgs_breite=$imgs_details['imgs_breite'];//breite
	$imgs_hoehe=$imgs_details['imgs_hoehe'];//hoehe
	$alt_tag=$imgs_details['alt_tag'];//alt_tag
	$imgs_type2=$imgs_details['type'];
	$imgs_id2=$imgs_details['menu_teaser_id'];

	$teaser_h_offset_percent=$imgs_details['asset_h_offset_percent'];
	$teaser_v_offset_percent=$imgs_details['asset_v_offset_percent'];

	if($teaser_v_offset_percent===NULL){$teaser_v_offset_percent=0.5;}
	$asset_v_offset=($clippingbox_hoehe-($clippingbox_breite/$imgs_breite*$imgs_hoehe))*$teaser_v_offset_percent;
	
	if($teaser_h_offset_percent!==NULL){$teaser_h_offset_percent=0.5;}
	$asset_h_offset=($clippingbox_breite-($clippingbox_hoehe/$imgs_hoehe*$imgs_breite))*$teaser_h_offset_percent;

	?>
	
	<div style="width:<? echo $containerwidth;?>; padding-top:3px; margin-left:7px;float:left;"> 
		<? include("menu_teaser_display_contents.php");?>
	</div>
	 <? if($anz<count($menus)-1 and $col_nr==1){echo "<div style='width:100%;height:1px;float:left'class='trenner'></div>"; }?>
     <? if(($anz/2)==(int)($anz/2) and $anz<count($menus)-1 and $col_nr==2){echo "<div style='width:100%;height:1px;float:left'class='trenner'></div>"; }?>
     
	<?
}//Schleife Ende for all Menu ids
?>