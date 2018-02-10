<? session_start();?>

<?
//$elem_id ist die Element_ID (entweder vom Haupt oder von subcontent
//$clippingbox_breite ist die Clippingboxbreite vom Bild
//clippingbox_hoehe ist die Clippingboxhöhe vom Bild
//$containerwidth ist die Breite des gesamtcontainers f einen Eintrag (ist wichtig f die 2 Spaltigen...
//$teasercopycols gibt an, wie viele Spalten das Textfeld breit sein soll von der Copy.
//$col_nr gibt die Anzahl der verwendeten Spalten an.


$adminpath=$_SERVER['DOCUMENT_ROOT'];
/////////////////////////////////////////// POST Funktionen
##change sort order
$task=$_POST[task];
$swap_sort=$_POST[swap_sort];
$own=$_POST[own];
$own_sort=$_POST[own_sort];
$swap=$_POST[swap];

if($task=="sort"){
	###zuerst die eigene sort-order überschreiben
	if($own!="" && $swap!=""){
		$updateSQL=sprintf("update element_content_menu SET sort=%u where ID=%u",
			GetSQLValueString($swap_sort,"int"),
			GetSQLValueString($own,"int"));
		$Result1=mysql_query($updateSQL) or die (mysql_error());
	}
	
	###Dann die andere sort-order überschreiben
	if($own!="" && $swap!=""){
		$updateSQL=sprintf("update element_content_menu SET sort=%u where ID=%u",
			GetSQLValueString($own_sort,"int"),
			GetSQLValueString($swap,"int"));
		$Result1=mysql_query($updateSQL) or die (mysql_error());
	}
	$task="";
	$refresh_path=$_SERVER['REQUEST_URI'];
	echo"<meta http-equiv=\"refresh\" content=\"0; URL=$refresh_path\" />";
}


##remove element
if($task=="remove"){
	if($own!=""){
	$deleteSQL=mysql_query("delete from element_content_menu where ID='$own'") or die("delete".mysql_error());
	}
	$task="";
	$refresh_path=$_SERVER['REQUEST_URI'];
	echo"<meta http-equiv=\"refresh\" content=\"0; URL=$refresh_path\" />";
}

/////////////////////////////Vorbereitende Queries f Menu_id_selector
?>

<? ///Sammelt alle ausgewählten Menü-IDs, damit sie an den Menü-id-selector übergeben werden können.
$menu_pfad_ids=array();
if($menus[1]!=""){
	$menu_parents=(menu_select($menus[1],"up",99,0,0,0));
		if($menus[1]==0){break;}
		elseif($menus[1]==$home_menu_id){array_push($menu_pfad_ids,$home_menu_id);}
		else{$menu_pfad_ids=$menu_parents[id];
		array_shift($menu_pfad_ids);}
}
array_push($menu_pfad_ids,"");
$menu_pfad_ids=array_reverse($menu_pfad_ids);

//print_r($menu_pfad_ids);
//implode $menus führt dazu, dass alle ausgewählten Menu IDs an den Menu_id_selektor übergeben werden kÃ¶nnen.

$admin_menu_id_selector="admin_menu_id_selector.php?target=element_content_menu&selected_menu_ids_in_imploded=".implode("|",$menus)."&menu_pfad_ids_imploded=".implode("|",$menu_pfad_ids)."&element_id=".$elem_id
?>

<?php 
//Abfrage für die Sortierfunktion
$element_content_menu_sort = mysql_query("SELECT element_content_menu.id, element_content_menu.sort FROM element_content_menu, menu_hierarchy WHERE element_id='$elem_id' and menu_hierarchy.menu_id = element_content_menu.menu_id and site_id=$site_id order by element_content_menu.sort")or die("x4_sort");
$element_content_menu_sort_num_rows = mysql_num_rows($element_content_menu_sort);

?>
<!-- hier ist der Button, der den MenÃ¼-id-selektor aufruft -->
<div style='width:100%;height:10px;'></div>
<div style="height:42px;width:28px;float:right"></div>
<div style="background-image:url(/site_12_1/css/Element_subcontent_rechts.png);width:4px;height:38px;float:right"></div>
<div style="background-image:url(/site_12_1/css/Element_subcontent_taste_Mitte.png);background-repeat:repeat-x;height:38px; float:right;">
     <div style="height:38px; float:left;">
 		<? if(test_right($_SESSION['user'],"call_menu_id_selector")=="true"){?>
         <input id="<? echo"img_$imgs_id";?>" type="image" onclick="fenster=window.open('<? echo $admin_menu_id_selector; ?>','popUpWindow','width=1200,height=900,left=400,top=50,scrollbars=yes,statusbar=no,personalbar=no,locationbar=no,menubar=no,location=no')" src="/site_12_1/css/button_next.png" class='$imgs_type'>
		<? } else{?><img border="0" src="/site_12_1/css/button_next_disabled.png" title="Sie haben nicht die erforderlichen Rechte um Menü-IDs auszuwählen."><? }?>
     </div><!--,status=no,scrollbars=yes,toolbar=no,location=no,menubar=no,titlebar=no-->
</div>
<div style="background-image:url(/site_12_1/css/Element_subcontent_links.png);width:4px;height:38px;float:right"></div>
<div style="clear:right"></div>
<div style='width:100%;height:1px;'class="trenner"></div>
<div id="table_result_error_messages"></div>


<?
// Für jeden MenÃ¼punkt wird durchsucht, ob es schon Inhalte in der Tabelle menu_teaser gibt. Wenn nicht, mÃ¼ssen sie angelegt werden. Wenn doch, fragen wir der Reihe nach ab, was es schon gibt. Alles was leer ist wird von den Elementen befÃ¼llt.
for ($anz=1;$anz<=$element_content_menu_sort_num_rows;$anz+=1)
{
?>
	
	
	<? //////////////////////////////////Anfang der Inhalteaufbereitung	
	//Variablen, die vorher vorbereitet sein müssen: 
	//Dieses Script wird in eine Schleife eingebaut. $anz ist die Variable, die durch die Schleife zählt. Verändert wird dadurch die jeweilige Zeile aus dem $Menus-Array, dass von Admin.php gebaut wird.
	//weiters braucht man die $elem_id in der die Element-ID gespeichert wird. 
	
	// Als Ergebnis werden folgende Variablen zurück geliefert:
	
	//$menu_id_sub_teaser_id: Die ID von der Zeile die in der Tabelle menu_teaser gerade bearbeitet wird.
	//$titel: die headline
	//$copy: die subline
	//$titel_href: die google-URL
	//$menu_parent_googleurl: den parent link
	//menu_description_parent: die parent link description
	//$menu_id_sub_teaser_asset_id. die asset ID vom Bild.
	//$menu_id_sub_teaser_editor: der Editor Typ.
	
	//$menu_id_sub_teaser_asset_id2: assets.ID
	//$category: category
	//$class: class
	//$path: path
	//$filename: filename
	//$imgs_url="/site_12_1/assets/$category$class$path$filename";
	//$imgs_breite: breite
	//$imgs_hoehe: hoehe
	//$alt_tag: alt_tag
	//$asset_h_offset: asset_h_offset
	//$asset_v_offset: asset_v_offset	
	//$imgs_type2: 2te Variable f den Imagetyp
	//$imgs_id2: 2te Variable f die ID der Zeile in der menu_teaser

	$menu_id_sub_query=mysql_query("select id, teaser_head, teaser_copy, teaser_asset_id, editor from menu_teaser where menu_id='$menus[$anz]' and element_id='$elem_id' and site_id=$site_id") or die ("2".mysql_error());
	$menu_id_sub_query_num_rows = mysql_num_rows($menu_id_sub_query);

	if($menu_id_sub_query_num_rows==0) //hier wird gecheckt, ob schon ein Eintrag da ist. Wenn ja, wird der genommen. Wenn nein, wird ein leerer Eintrag angelegt.
	{ 
		$default_prep_exists_query=mysql_query("select id from menu_teaser where menu_id='$menus[$anz]' and element_id=0") or die ("2.1".mysql_error());
		if(mysql_num_rows($default_prep_exists_query)==0)
		{
			mysql_query("INSERT INTO menu_teaser(menu_id,element_id,site_id) VALUES('$menus[$anz]','$elem_id','$site_id')") or die(mysql_error());
		}
		else 
		{
			mysql_query("insert into menu_teaser (menu_id, element_id, teaser_head, teaser_copy, teaser_asset_id, asset_h_offset, asset_v_offset, asset_h_offset_percent, asset_v_offset_percent, editor, site_id) select '$menus[$anz]', '$elem_id', teaser_head, teaser_copy, teaser_asset_id, asset_h_offset, asset_v_offset, asset_h_offset_percent, asset_v_offset_percent, editor,'$site_id' from menu_teaser where menu_id='$menus[$anz]' and element_id=0") or die ("2.2".mysql_error());
		}
		$menu_id_sub_query=mysql_query("select id, teaser_head, teaser_copy, teaser_asset_id, editor from menu_teaser where menu_id='$menus[$anz]' and element_id='$elem_id' and site_id=$site_id") or die ("2.3".mysql_error());
	}
	$menu_id_sub_result = mysql_fetch_row($menu_id_sub_query);

	$menu_id_sub_teaser_id = $menu_id_sub_result[0];
	$menu_id_sub_menu_id = $menus[$anz];
	$menu_id_sub_element_id = $elem_id;
	$titel = $menu_id_sub_result[1];
	$copy = $menu_id_sub_result[2];
	$titel_href = find_googleurl($menus[$anz]);
	$menu_id_sub_teaser_asset_id = $menu_id_sub_result[3];
	$menu_id_sub_teaser_editor = $menu_id_sub_result[4];
	
	// hier noch die Beschriftung der Parent_ID finden fÃ¼r die Anzeige...
	$menu_master_sub=find_parent($menus[$anz]);
	$menu_parent_googleurl=find_googleurl($menu_master_sub);
	$menu_description_parent=find_description($menu_master_sub);
	
	if($titel=="")
	{
		$titel=teaser_text($menus[$anz],"Titel",0,$elem_id);
		$titel=$titel[text];
		$titel2=GetSQLValueString($titel,"text");
		$Result1=mysql_query("update menu_teaser SET teaser_head=$titel2 where menu_id=$menus[$anz] and element_id=$elem_id") or die ("head.1: ".mysql_error());
		$titel2="";
	}
	
	if($copy=="")
	{
		$copy=teaser_text($menus[$anz],"Copy",$truncate_length,$elem_id);
		$copy=$copy[text];
		$copy2=GetSQLValueString($copy,"text");
		$Result1=mysql_query("update menu_teaser SET teaser_copy=$copy2 where menu_id=$menus[$anz] and element_id=$elem_id") or die ("copy: ".mysql_error());
		$copy2="";
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

	$teaser_h_offset_percent=$imgs_details['asset_h_offset_percent'];
	$teaser_v_offset_percent=$imgs_details['asset_v_offset_percent'];
	
	if($teaser_v_offset_percent===NULL){$teaser_v_offset_percent=0.5;}
	$asset_v_offset=($clippingbox_hoehe-($clippingbox_breite/$imgs_breite*$imgs_hoehe))*$teaser_v_offset_percent;
	
	if($teaser_h_offset_percent!==NULL){$teaser_h_offset_percent=0.5;}
	$asset_h_offset=($clippingbox_breite-($clippingbox_hoehe/$imgs_hoehe*$imgs_breite))*$teaser_h_offset_percent;
	
	$imgs_type2=$imgs_details['type'];
	$imgs_id2=$imgs_details['menu_teaser_id'];
	
	$Result1=mysql_query("update menu_teaser SET teaser_asset_id='$menu_id_sub_teaser_asset_id2' where menu_id=$menus[$anz] and element_id=$elem_id and site_id=$site_id") or die ("asset_id: ".mysql_error());
	$menu_id_sub_teaser_asset_id = "";
	
	//////////////////////////////////Ende der Inhalteaufbereitung
	?>

	<div style="width:<? echo $containerwidth;?>; padding-top:1px; margin-left:7px;float:left;"> 
		<div style="float:right">
		<? //hier kommen die Sortierbuttons rein.
		//zuerst die sort-Funktionen vorbereiten
			$Anz2=$anz-1;
			mysql_data_seek($element_content_menu_sort, $Anz2); 
			$element_content_menu_id_query = mysql_fetch_row($element_content_menu_sort);
			$element_content_menu_id_own = $element_content_menu_id_query[0];
			$element_content_menu_sort_own = $element_content_menu_id_query[1];
			
			##next element_id
			if($Anz2 < $element_content_menu_sort_num_rows-1){
			mysql_data_seek($element_content_menu_sort, $Anz2+1); 
			$element_content_menu_id_query = mysql_fetch_row($element_content_menu_sort);
			$element_content_menu_id_next = $element_content_menu_id_query[0];
			$element_content_menu_sort_next = $element_content_menu_id_query[1];}
			
			##prev element_id
			if($Anz2 > 0){
			mysql_data_seek($element_content_menu_sort, $Anz2-1); 
			$element_content_menu_id_query = mysql_fetch_row($element_content_menu_sort);
			$element_content_menu_id_prev = $element_content_menu_id_query[0];
			$element_content_menu_sort_prev = $element_content_menu_id_query[1];}	
			  
			//dann die sort funktionen anzeigen	  ?>
			<div style="float:right"><img src='/site_12_1/css/Element_subcontent_rechts.png' border='0' height='19px'></div>
			<div style='height:19px; position:relative; z-index:1000; float:right;'><img class="bg_image_scale" src="/site_12_1/css/Element_subcontent_taste_Mitte.png"/>
				<div style="height:17px; float:left;position:relative; z-index:2000;padding-top:2px;padding-left:2px; padding-right:2px;">
					<? echo "ID: ".$menus[$anz];?>
				</div>
				<? if($menus_active[$anz]=="A" and (($menus_start[$anz]<$date or $menus_start[$anz]=="0000-00-00") and ($menus_end[$anz]>$date or $menus_end[$anz]=="0000-00-00"))){} 
				else {?>
					<div style="height:17px; float:left; position:relative; z-index:2000; padding-top:1px;" title="ACHTUNG: Wird nicht angezeigt! Menüeintrag ist nicht aktiv, oder nicht im freigeschaltenen Datumsbereich."><a href="/site_12_1/admin/papa/menu.php?men_id=<? echo $menus_parent[$anz]?>"><img src="/site_12_1/css/Attention_small.png" height="16px"/></a></div>
				<? }?>
				
				<div style="height:17px; float:left;">
				<? if($Anz2 > 0 and $element_content_menu_sort_num_rows > 1)
					{?> <!-- SORT UP BUTTON bei allen, die nicht das oberste Element sind-->
					<form action="<? echo $_SERVER['REQUEST_URI'];?>" method="post" target="_self">
						<input type="hidden" name="task" value="sort">
						<input type="hidden" name="own" value="<? echo $element_content_menu_id_own ;?>">
						<input type="hidden" name="own_sort" value="<? echo $element_content_menu_sort_own ;?>">
						<input type="hidden" name="swap" value="<? echo $element_content_menu_id_prev ;?>">
						<input type="hidden" name="swap_sort" value="<? echo $element_content_menu_sort_prev ;?>">
						<input type="image" src="/site_12_1/css/button_up.png" style="height:17px; position:relative; z-index:2000;">
					</form>
				<? }?>
				</div>
			
				<div style="height:17px; float:left;">
					<? if($Anz2 < $element_content_menu_sort_num_rows-1 and $element_content_menu_sort_num_rows > 1){?> <!-- SORT DOWN BUTTON bei allen, die nicht das letzte Element sind-->
					<form action="<? echo $_SERVER['REQUEST_URI'];?>" method="post" target="_self">
						<input type="hidden" name="task" value="sort">
						<input type="hidden" name="own" value="<? echo $element_content_menu_id_own ;?>">
						<input type="hidden" name="own_sort" value="<? echo $element_content_menu_sort_own ;?>">
						<input type="hidden" name="swap" value="<? echo $element_content_menu_id_next ;?>">
						<input type="hidden" name="swap_sort" value="<? echo $element_content_menu_sort_next ;?>">
						<input type="image" src="/site_12_1/css/button_down.png" style="height:17px; position:relative; z-index:2000; ">
					</form>	
					<? }?>		     
				</div>
					
				<div style="height:17px; float:left;">
					<!-- Eintrag löschen -->
					<form action="<? echo $_SERVER['REQUEST_URI'];?>" method="post" target="_self">
						<input type="hidden" name="task" value="remove">
						<input type="hidden" name="own" value="<? echo $element_content_menu_id_own ;?>">
						<input type="image" src="/site_12_1/css/button_delete.png" style="height:17px; position:relative; z-index:2000; ">
					</form>	
				</div>
			</div>		
			<div style="float:right"><img src='/site_12_1/css/Element_subcontent_links.png' border='0' height='19px'></div>
		</div>
		<div style="clear:right"></div>
		<? include("admin_menu_teaser_edit_contents.php");?>
     </div>
     <? if($anz<count($menus)-1 and $col_nr==1){echo "<div style='width:100%;height:1px;float:left'class='trenner'></div>"; }?>
     <? if(($anz/2)==(int)($anz/2) and $anz<count($menus)-1 and $col_nr==2){echo "<div style='width:100%;height:1px;float:left'class='trenner'></div>"; }?>
     
	<?
}//Schleife Ende for all Menu ids
?>