<?
///Funktionsweise:
//Es werden alle Teaser Menu_IDs angeführt.
//Für jede ID wird geprüft ob es einen Teaser_cache gibt. Wenn es einen gibt, dann wir der übernommen und einfach angezeigt. <br />

//$teaser_menu_ids ist das array der anzuzeigenden Menu-IDs. 
$number_iterations=count($teaser_menu_ids);
for($i=$number_iterations-1;$i>=0;$i--)
{
	$teaser_test_menu_id=$teaser_menu_ids[$i]['menu_id'];
	
	// hier noch die Beschriftung der Parent_ID finden für die Anzeige...
	$menu_id_parent=find_parent($teaser_test_menu_id);
	$menu_description_parent=find_description($menu_id_parent);
	$menu_parent_googleurl=find_googleurl($menu_id_parent);
	
	$titel_href = find_googleurl($teaser_test_menu_id);
	
	//und hier noch die Bilddetails	
	$teaser_test_menu_id_asset=teaser_bild($teaser_test_menu_id,$clippingbox_breite,$elem_id);
	$asset_id=$teaser_test_menu_id_asset[asset_id];
	
	$menu_id_sub_teaser_asset_id2=$teaser_test_menu_id_asset[asset_id];//assets.ID
	$category=$teaser_test_menu_id_asset[category];//category
	$class=$teaser_test_menu_id_asset['class'];//class
	$path=$teaser_test_menu_id_asset[path];//path
	$filename=$teaser_test_menu_id_asset[filename];//filename
	$imgs_url=$teaser_test_menu_id_asset[imgs_url];;
	$imgs_breite=$teaser_test_menu_id_asset[imgs_breite];//breite
	$imgs_hoehe=$teaser_test_menu_id_asset[imgs_hoehe];//hoehe
	$alt_tag=$teaser_test_menu_id_asset[alt_tag];//alt_tag
	$imgs_type2=$teaser_test_menu_id_asset[type];
	$teaser_v_offset_percent=$teaser_test_menu_id_asset[asset_v_offset_percent];
	$teaser_h_offset_percent=$teaser_test_menu_id_asset[asset_h_offset_percent];
	
	if($teaser_v_offset_percent===NULL){$teaser_v_offset_percent=0.5;}
	$asset_v_offset=($clippingbox_hoehe-($clippingbox_breite/$imgs_breite*$imgs_hoehe))*$teaser_v_offset_percent;
	
	if($teaser_h_offset_percent!==NULL){$teaser_h_offset_percent=0.5;}
	$asset_h_offset=($clippingbox_breite-($clippingbox_hoehe/$imgs_hoehe*$imgs_breite))*$teaser_h_offset_percent;

	?>
	
	<?
	if(($parent_needed=="1" and $menu_description_parent!="") or $parent_needed!="1"){
		$titel=teaser_text($teaser_test_menu_id,"Titel",0);$titel=$titel[text];
		$copy=teaser_text($teaser_test_menu_id,"Copy",0);$copy=$copy[text];
		if($titel!=""){
			if(($einleitung_needed=="1" and $copy!="") or $einleitung_needed!="1"){
				if(($img_needed=="1" and $menu_id_sub_teaser_asset_id2!=0 and $menu_id_sub_teaser_asset_id2!="")or $img_needed!="1"){
					?>
					<div style="width:<? echo $containerwidth;?>; padding-top:3px; margin-left:7px; float:left"> 
						<? include("menu_teaser_display_contents.php");?>
					</div>
					 <? if($i>0 and $col_nr==1){echo "<div style='width:100%;height:1px;float:left'class='trenner'></div>"; }?>
					 <? if(($i-$number_iterations)/2==(int)(($i-$number_iterations)/2) and $i!=0 and $col_nr==2){echo "<div style='width:100%;height:1px;float:left'class='trenner'></div>"; }?>
					<?
				}
			}
		}
	}

}//Schleife Ende for all Menu ids
?>