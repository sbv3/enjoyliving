<?
///Funktionsweise:
//Es werden alle Teaser Menu_IDs angeführt.
//Für jede ID wird geprüft ob es einen Teaser_cache gibt. Wenn es einen gibt, dann wir der übernommen und einfach angezeigt. <br />
//Es wird dann auch ein button angezeigt, der es ermöglicht den Eintrag zu kopieren und in eine eigene DatenbankZeile in der Tabelle menu_teaser zu geben, damit er editierbar wird. 
//dort kann er dann auch wieder gelöscht werden, womit wieder der ursprüngliche Status angezeigt wird. Der jeweilige Auto-Cache ist Element-spezifisch! Das ist wegen der unterschiedlichen Bildgrößen udn offsets nötig.

if($default_only=="yes"){$elem_id="0";}

/////////////////////////////////////////// POST Funktionen
##remove entry
if($task=="remove_auto_menu_teaser"){
	if($menu_teaser_row_id!=""){
		$deleteSQL=mysql_query("delete from menu_teaser where id='$menu_teaser_row_id' and site_id=$site_id limit 1") or die(mysql_error());
	}
	$task="";
}

if($task=="duplicate_menu_teaser_".$elem_id){
	if($menu_teaser_row_id!=""){
		mysql_query("insert into menu_teaser (menu_id, element_id, teaser_head, teaser_copy, teaser_asset_id, asset_h_offset, asset_v_offset, asset_h_offset_percent, asset_v_offset_percent, editor, site_id) select '$teaser_menu_id', '$teaser_element_id', teaser_head, teaser_copy, teaser_asset_id, asset_h_offset, asset_v_offset, asset_h_offset_percent, asset_v_offset_percent, editor,site_id from menu_teaser where id='$menu_teaser_row_id'") or die(mysql_error());
	}
	$task="";
}

if($task=="duplicate_menu_teaser_default"){
	if($menu_teaser_row_id!=""){
		mysql_query("insert into menu_teaser (menu_id, element_id, teaser_head, teaser_copy, teaser_asset_id, asset_h_offset, asset_v_offset, asset_h_offset_percent, asset_v_offset_percent, editor, site_id) select '$teaser_menu_id', '0', teaser_head, teaser_copy, teaser_asset_id, asset_h_offset, asset_v_offset, asset_h_offset_percent, asset_v_offset_percent, editor,site_id from menu_teaser where id='$menu_teaser_row_id'") or die(mysql_error());
	}
	$task="";
}

if($task=="create_menu_teaser_".$elem_id){
	if($teaser_menu_id!=""){
		$teaser_titel=GetSQLValueString(urldecode($teaser_titel),"text");
		$teaser_copy=GetSQLValueString(urldecode($teaser_copy),"text");
		mysql_query("insert into menu_teaser (menu_id, element_id, teaser_head, teaser_copy, teaser_asset_id, asset_h_offset, asset_v_offset, asset_h_offset_percent, asset_v_offset_percent, editor, site_id) values('$teaser_menu_id', '$teaser_element_id', $teaser_titel, $teaser_copy, '$teaser_asset_id', '0', '0', '0', '0', 'TXT','$site_id')") or die(mysql_error());
	}
	$task="";
}

if($task=="create_menu_teaser_default"){
	if($teaser_menu_id!=""){
		$teaser_titel=GetSQLValueString(urldecode($teaser_titel),"text");
		$teaser_copy=GetSQLValueString(urldecode($teaser_copy),"text");
		mysql_query("insert into menu_teaser (menu_id, element_id, teaser_head, teaser_copy, teaser_asset_id, asset_h_offset, asset_v_offset, asset_h_offset_percent, asset_v_offset_percent, editor, site_id) values('$teaser_menu_id', '0', $teaser_titel, $teaser_copy, '$teaser_asset_id', '0', '0', '0', '0', 'TXT','$site_id')") or die(mysql_error());
	}
	$task="";
}

//$teaser_menu_ids ist das array der anzuzeigenden Menu-IDs. 
for($i=count($teaser_menu_ids)-1;$i>=0;$i--)
{
	$teaser_test_menu_id=$teaser_menu_ids[$i]['menu_id'];
	//Test, ob ein Teaser Menu Item besteht. Dann wird das übernommen. 
	$menu_teaser_query=mysql_query("select * from menu_teaser where menu_id='$teaser_test_menu_id' and site_id=$site_id order by up_date desc") or die ("teaser1 failed: ".mysql_error());
	if(mysql_num_rows($menu_teaser_query)>0)
	{
		if($default_only=="yes"){$elem_id="0";}
		for($loop=0;$loop<mysql_num_rows($menu_teaser_query);$loop++)//Diese Schleife schaut sich alle Ergebnisse in menu_teaser an und sucht nach einem, dass dem Element entspricht. Wenn es einen Eintrag findet, wird der genommen.
		{
			$menu_teaser_result=mysql_fetch_assoc($menu_teaser_query);
			if($menu_teaser_result['element_id']==$elem_id)
			{$set_manual="remove_entry";break;}
			else
			{$set_manual="duplicate_mode";}
		}
		
		
		$menu_id_sub_teaser_id = $menu_teaser_result['id'];
		$menu_id_sub_menu_id = $teaser_test_menu_id;
		
		$titel=$menu_teaser_result['teaser_head'];
		$copy=$menu_teaser_result['teaser_copy'];
		$asset_id=$menu_teaser_result['teaser_asset_id'];
		$menu_teaser_row_id=$menu_teaser_result['id'];
		$menu_id_sub_teaser_editor = $menu_teaser_result['editor'];
		
		//hier die Bilddetails, die es nur dann gibt, wenn eine menu_teaser_Zeile exisitert (manual mode)
		$teaser_h_offset_percent=$menu_teaser_result['asset_h_offset_percent'];//asset_h_offset
		$teaser_v_offset_percent=$menu_teaser_result['asset_v_offset_percent'];//asset_v_offset	
		$imgs_id2=$menu_teaser_result['id'];
	}
	else
	{
		$titel=teaser_text($teaser_test_menu_id,"Titel",0);$titel=$titel[text];
		$copy=teaser_text($teaser_test_menu_id,"Copy",$truncate_length);$copy=$copy[text];
		$asset_id=teaser_bild($teaser_test_menu_id,$clippingbox_breite,$elem_id);
		$asset_id=$asset_id['asset_id'];
		$set_manual="create_mode";
	}
	if(
		($titel!="")//test_id=menu_id, test_type=element_layout_description (zB "Titel"), truncate= wenn>0 wird der Text abgeschnitten nach x Zeichen, sonst nicht))
		and ($copy!="" or $einleitung_needed==0) //test_id=menu_id, test_type=element_layout_description (zB "Copy"), truncate= wenn>0 wird der Text abgeschnitten nach x Zeichen, sonst nicht))
		and ($asset_id>0 or $img_needed==0)//testet of ein Bild, das nicht das default-Bild ist, vorhanden ist.
		){$teaser_OK=1;}else{$teaser_OK=0;}
	
	if($asset_id==""){$asset_id=0;}
	
	// hier noch die Beschriftung der Parent_ID finden für die Anzeige...
	if($parent_needed==1)
	{
		$menu_master_sub=find_parent($teaser_test_menu_id);
		$menu_parent_googleurl=find_googleurl($menu_master_sub);
		$menu_description_parent=find_description($menu_master_sub);
	}
	
	$titel_href = find_googleurl($teaser_test_menu_id);
	
	//und hier noch die Bilddetails	
	$menu_id_sub_img_query=mysql_query("Select assets.ID, category, class, path, filename, breite, hoehe, alt_tag, assets.type from assets where id='$asset_id'") or die ("5".mysql_error());
	$menu_id_sub_img_result=mysql_fetch_row($menu_id_sub_img_query);
	
	$menu_id_sub_teaser_asset_id2=$menu_id_sub_img_result[0];//assets.ID
	$category=$menu_id_sub_img_result[1];//category
	$class=$menu_id_sub_img_result[2];//class
	$path=$menu_id_sub_img_result[3];//path
	$filename=$menu_id_sub_img_result[4];//filename
	$imgs_url="/site_12_1/assets/$category$class$path$filename";
	$imgs_breite=$menu_id_sub_img_result[5];//breite
	$imgs_hoehe=$menu_id_sub_img_result[6];//hoehe
	$alt_tag=$menu_id_sub_img_result[7];//alt_tag
	$imgs_type2=$menu_id_sub_img_result[8];	

	if($teaser_v_offset_percent===NULL){$teaser_v_offset_percent=0.5;}
	$asset_v_offset=($clippingbox_hoehe-($clippingbox_breite/$imgs_breite*$imgs_hoehe))*$teaser_v_offset_percent;
	
	if($teaser_h_offset_percent!==NULL){$teaser_h_offset_percent=0.5;}
	$asset_h_offset=($clippingbox_breite-($clippingbox_hoehe/$imgs_hoehe*$imgs_breite))*$teaser_h_offset_percent;
	
	?>
	
	<div style="width:<? echo $containerwidth;?>; padding-top:1px; margin-left:7px; float:left;"> 
		<div style="float:right">
			<? //Hier kommt die "make manual"Taste ?>
			<div style="float:right"><img src='/site_12_1/css/Element_subcontent_rechts.png' border='0' height='19px'></div>
			<div style='height:19px; position:relative; z-index:1000; float:right;'><img class="bg_image_scale" src="/site_12_1/css/Element_subcontent_taste_Mitte.png"/>
				<div style="height:17px; float:left;position:relative; z-index:2000;padding-top:2px;padding-left:2px; padding-right:2px;">
					<? echo "ID: ".$teaser_test_menu_id;?>
				</div>
				<? if($set_manual=="remove_entry"){?>
					<div style="height:17px; float:left;">
						<form action="<? echo $_SERVER['REQUEST_URI'];?>" method="post" target="_self">
							<input type="hidden" name="task" value="remove_auto_menu_teaser">
							<input type="hidden" name="teaser_element_id" value="<? echo $elem_id;?>">
							<input type="hidden" name="teaser_menu_id" value="<? echo $teaser_test_menu_id;?>">
							<input type="hidden" name="menu_teaser_row_id" value="<? echo $menu_teaser_row_id;?>">
							<input type="image" src="/site_12_1/css/button_delete.png" style="height:17px; position:relative; z-index:2000;" title="Die manuelle Bearbeitung wird gel&ouml;scht und das automatisch generierte Element wiederhergestellt.">
						</form>
					</div>
				<? }
				if($set_manual=="duplicate_mode"){?>
					<div style="height:17px; float:left;">
						<form action="<? echo $_SERVER['REQUEST_URI'];?>" method="post" target="_self">
							<input type="hidden" name="task" value="duplicate_menu_teaser<? if($default_only=="yes"){echo "_default";}else{echo "_".$elem_id;}?>">
							<input type="hidden" name="teaser_element_id" value="<? echo $elem_id;?>">
							<input type="hidden" name="teaser_menu_id" value="<? echo $teaser_test_menu_id;?>">
							<input type="hidden" name="menu_teaser_row_id" value="<? echo $menu_teaser_row_id;?>">
							<input type="image" src="/site_12_1/css/button_add.png" style="height:17px; position:relative; z-index:2000;" title="Teaser wurde von einem h&auml;ndisch erstellten Teaser &uuml;bernommen. Die separate Bearbeitung wird m&ouml;glich gemacht.">
						</form>
					</div>
				<? }
				if($set_manual=="create_mode"){?>
					<div style="height:17px; float:left;">
						<form action="<? echo $_SERVER['REQUEST_URI'];?>" method="post" target="_self">
							<input type="hidden" name="task" value="create_menu_teaser<? if($default_only=="yes"){echo "_default";}else{echo "_".$elem_id;}?>">
							<input type="hidden" name="teaser_element_id" value="<? echo $elem_id;?>">
							<input type="hidden" name="teaser_menu_id" value="<? echo $teaser_test_menu_id;?>">
							
							<input type="hidden" name="teaser_titel" value="<? echo urlencode($titel);?>">
							<input type="hidden" name="teaser_copy" value="<? echo urlencode($copy);?>">
							<input type="hidden" name="teaser_asset_id" value="<? echo $asset_id;?>">
							
							<input type="image" src="/site_12_1/css/button_add.png" style="height:17px; position:relative; z-index:2000;" title="Teaser wurde von einem automatisch erstellten Teaser &uuml;bernommen. Die separate Bearbeitung wird m&ouml;glich gemacht.">
						</form>
					</div>
				<? }
				if($teaser_OK==0){?>
					<div style="height:17px; float:left; padding-top:2px;position:relative; z-index:2000;" title="Dieser Eintrag wird NICHT angezeigt, weil er unvollst&auml;ndig ist (Titel, Kurztext oder Bild fehlen)."><img border="0" src="/site_12_1/css/Attention_small.png" height="13px"/></div>
				<? }?>
			</div>		
			<div style="float:right"><img src='/site_12_1/css/Element_subcontent_links.png' border='0' height='19px'></div>
		</div>
		<div style="clear:right"></div>
		<? 
		if($teaser_OK==0){echo "<div class=greyscale>";}
		if($set_manual=="remove_entry"){include("admin_menu_teaser_edit_contents.php");}else{include("$adminpath/site_12_1/menu_teaser_display_contents.php");}
		if($teaser_OK==0){echo "</div>";}		

		//require_once("grayscale_script.php");?>
		<script>
		//grayscale( $('.greyscale') );
		$('.greyscale').find('*').css("color","#aaaaaa")
		
		</script>
		
		
	
     </div>
	 <? if($i>0 and $col_nr==1){echo "<div style='width:100%;height:1px;float:left'class='trenner'></div>"; }?>
     <? if(($i-count($teaser_menu_ids))/2==(int)(($i-count($teaser_menu_ids))/2) and $i!=0 and $col_nr==2){echo "<div style='width:100%;height:1px;float:left'class='trenner'></div>"; }?>
	<?
	if($img_needed=="1"){mysql_free_result($menu_id_sub_img_query);}
	$titel="";
	$copy="";
	$asset_id="";
	$asset_id=="";
	$set_manual="";
	$teaser_OK="";

}//Schleife Ende for all Menu ids
?>