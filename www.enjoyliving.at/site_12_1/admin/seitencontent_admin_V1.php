<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<?
$adminpath=$_SERVER['DOCUMENT_ROOT'];

require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
if(test_right($_SESSION['user'],"enter_page_content")=="true" and (test_right($_SESSION['user'],"edit_non_mastered_pages")=="true" or ($_SESSION[user_id]==find_master_user_id($menu_id))) and (test_right($_SESSION['user'],"edit_shared_content")=="true" or find_master_site_id($menu_id)==$site_id))
{}else{
	echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$href_root/site_12_1/admin/papa/menu.php?men_id=$home_menu_id\">";
	exit;
}

$active_menu_id=$menu_id;
$element_counter=0;

?>

<?
/////////////////////////////////////////// POST Funktionen
if (!isset($_SESSION['microtime']) or $_SESSION['microtime'] != $timestamp)
{
	##change sort order
	if($task=="sort"){
		###zuerst die eigene sort-order überschreiben
		if($own!="" && $swap!=""){
			$updateSQL=sprintf("update element SET sort=%u where ID=%u",
				GetSQLValueString($swap_sort,"int"),
				GetSQLValueString($own,"int"));
			$Result1=mysql_query($updateSQL) or die (mysql_error());
		}
		
		###Dann die andere sort-order überschreiben
		if($own!="" && $swap!=""){
			$updateSQL=sprintf("update element SET sort=%u where ID=%u",
				GetSQLValueString($own_sort,"int"),
				GetSQLValueString($swap,"int"));
			$Result1=mysql_query($updateSQL) or die (mysql_error());
		}
		$task="";
	}
	
	##delete element
	elseif($task=="delete")
	{
		$deleteSQL=mysql_query("delete from element where id=$own") or die (mysql_error());
	$task="";
	}
	
	##add element
	elseif($task=="add" && $element_layout_id!="Element auswählen")
	{
		$task="";
			new_element($menu_id,$element_layout_id,$sort,true);
		
	} //Ende add-Funktion
	
	
	## Neuen subcontent anlegen
	
	if ($subcontent_anlegen=="1"){
		$subcontent_anlegen=0;
		//Abfrage für das Hinzufügen einer neuen Subcontent-Seite
		$menu_params = mysql_query("select menu_hierarchy.active_startdate, menu_hierarchy.active_enddate, menu.pagetype, menu.description from menu,menu_hierarchy where site_id=$site_id and menu_hierarchy.menu_id=menu.id and menu.id=$menu_id_sub") or die (mysql_error());
		$menu_params_num_rows = mysql_num_rows($menu_params);
		if($menu_params_num_rows==1)
			{$menu_params_query = mysql_fetch_assoc($menu_params);
			$parent_id = find_parent($menu_id_sub);
			$display = '0';
			$active = 'D';
			$active_startdate = $menu_params_query['active_startdate'];
			$active_enddate = $menu_params_query['active_enddate'];
			$seitentyp = $menu_params_query['pagetype'];
			
			$sort_params_prep=menu_select($menu_id,"down",1,0,0,0);
			$sort_params=implode(",",$sort_params_prep[id]);
			
			$sort_params = mysql_query("select max(sort) from menu where id in ($sort_params)") or die ("couldn't get max sort");
			$sort_params_num_rows = mysql_num_rows($sort_params);
			if($sort_params_num_rows==1)
				{$sort_params_query = mysql_fetch_row($sort_params);
				$menu_ordering2=$sort_params_query[0]+10;
				}
			}
		newmenu($menu_ordering2,$parent_id,$titel2,$display,$active,$active_startdate,$active_enddate,$seitentyp,"Subseiten");
	}
	$_SESSION['microtime'] = $timestamp;
}
?>

<?
/////////////////////////////////////////// Vorbereitende Abfragen
//Abfrage für das Hinzufügen neuer Elemente
$element_layout= mysql_query("SELECT element_layout.id, element_layout.description, blocked.Anz, singular.Anz2
FROM element_layout
LEFT JOIN (
	SELECT element_layout.id, SUM(element_layout.block_sharing) AS Anz
	FROM element, element_layout, menu_hierarchy
	WHERE element.menu_id=menu_hierarchy.menu_id 
		AND menu_hierarchy.menu_id=$active_menu_id AND menu_hierarchy.site_id!=$site_id AND element_layout.id=element.element_layout_id AND element_layout.block_sharing>0
	GROUP BY element_layout.id, element_layout.id, menu_hierarchy.menu_id) AS blocked ON blocked.id=element_layout.id

LEFT JOIN (
	SELECT element_layout.id, SUM(element_layout.singular) AS Anz2
	FROM element, element_layout, menu_hierarchy
	WHERE element.menu_id=menu_hierarchy.menu_id 
		AND menu_hierarchy.menu_id=$active_menu_id AND menu_hierarchy.site_id=$site_id AND element_layout.id=element.element_layout_id AND element_layout.singular>0
	GROUP BY element_layout.id, element_layout.id, menu_hierarchy.menu_id) AS singular ON singular.id=element_layout.id

	
WHERE TYPE LIKE '%seitencontent%' AND element_layout.type NOT LIKE '%sponsorbanner%' AND active=1 and (available_to like '%,$site_id,%' or available_to is null)
GROUP BY description")or die("x4_sort");
$element_layout_num = mysql_num_rows($element_layout);

//Abfrage für die Sortierfunktion
$element_id_sort = mysql_query("select element.id, element.sort from element, menu_hierarchy where element_layout_id in (select id from element_layout where type like '%seitencontent%') and element.menu_id=$active_menu_id and element.site_id=$site_id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=element.site_id order by element.sort")or die("x4_sort");
$element_id_num_rows = mysql_num_rows($element_id_sort);

//Abfrage für das Öffnen der Menuverwaltung
$back_menu_id=find_parent($active_menu_id);

?>

<?
/////////////////////////////////////////// Inhalte aufbereiten
///Abfrage der einzelnen Elemente des Content mit der active_menu_id (Schleife)
?>

<body class="basislayout_body";>

<div name="admin content" style="width:312px; float:left;">
	<?
	
	$element_id = mysql_query("select element.id, element.element_layout_id from element, menu_hierarchy where element_layout_id in (select id from element_layout where type like '%seitencontent%') and element.menu_id=$active_menu_id and element.site_id=$site_id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=element.site_id order by element.sort")or die("x4"); //alle Element_IDs vom Menüpunkt aufrufen.
	while ($zeige=mysql_fetch_object($element_id)){
	$elem_id=$zeige->id;
	
	$text_abfrage= mysql_query("select id, text, editor, style_tag, sort from element_content_text where element_id='$zeige->id' order by sort")or die("x5");
	$texts_id=array("");
	$texts=array("");
	$editors=array("");
	$texts_style=array("");
	$texts_sort =array("");
	while ($zeigex=mysql_fetch_object($text_abfrage)){
		array_push($texts_id,"$zeigex->id");
		array_push($texts,"$zeigex->text");
		array_push($editors,"$zeigex->editor");
		array_push($texts_style,"$zeigex->style_tag");
		array_push($texts_sort,"$zeigex->sort");
	}
		
		
	$img_abfrage= mysql_query("select assets.ID as assets_id, element_content_img.id as element_content_img_id, element_content_img.sort as sort, category, class, element_content_img.type, filename, path from assets, element_content_img where element_id='$zeige->id' and element_content_img.assets_ID=assets.ID and category ='img' order by sort")or die("x6");
	$assets_id=array("");
	$imgs_id=array("");
	$imgs=array("");
	$imgs_category=array("");
	$imgs_class=array("");
	$imgs_type=array("");
	$filename=array("");
	$path=array("");
	$imgs_sort=array("");
	while ($zeigex=mysql_fetch_object($img_abfrage)){
		array_push($assets_id,"$zeigex->assets_id");
		array_push($imgs_id,"$zeigex->element_content_img_id");
		array_push($imgs,"/site_12_1/assets/$zeigex->category$zeigex->class$zeigex->path$zeigex->filename");
		array_push($imgs_category,"$zeigex->category");
		array_push($imgs_class,"$zeigex->class");
		array_push($imgs_type,"$zeigex->type");
		array_push($filename,"$zeigex->filename");
		array_push($path,"$zeigex->path");
		array_push($imgs_sort,"$zeigex->sort");
	}
		
		
		$menu_abfrage= mysql_query("select element_content_menu.id, element_content_menu.menu_id, menu_hierarchy.active, menu_hierarchy.active_startdate, menu_hierarchy.active_enddate from element_content_menu,menu,menu_hierarchy where element_id='$zeige->id' and element_content_menu.menu_id=menu.id and site_id=$site_id and menu_hierarchy.menu_id=menu.id order by element_content_menu.sort")or die("x7.2");
		$menus_id=array("");
		$menus=array("");
		$menus_parent=array("");
		$menus_active=array("");
		$menus_start=array("");
		$menus_end=array("");
		while ($zeigex=mysql_fetch_object($menu_abfrage)){
			array_push($menus_id,"$zeigex->id");
			array_push($menus,"$zeigex->menu_id");
			array_push($menus_parent,find_parent("$zeigex->menu_id"));
			array_push($menus_active,"$zeigex->active");
			array_push($menus_start,"$zeigex->active_startdate");
			array_push($menus_end,"$zeigex->active_enddate");
		}
		
		
		$code_abfrage= mysql_query("select id, url, admin_url, active from element_content_code where element_id='$zeige->id' order by sort")or die("x7.1");
		$codes_id=array("");
		$codes=array("");
		$codes_active=array("");
		while ($zeigex=mysql_fetch_object($code_abfrage)){
			array_push($codes_id,"$zeigex->id");
			array_push($codes_active,"$zeigex->active");
		if($zeigex->admin_url==""){array_push($codes,$_SERVER['DOCUMENT_ROOT']."site_12_1/$zeigex->url");}else{array_push($codes,$_SERVER['DOCUMENT_ROOT']."site_12_1/$zeigex->admin_url");}
		}
		
		
		$php_snippet = mysql_query("select description, php_admin_snippet, php_snippet from element_layout where id='$zeige->element_layout_id'")or die("x8");
		while ($zeiges=mysql_fetch_object($php_snippet)){ 
			$scope="seitencontent";
			?>
		
			<?
			##own element_id
			mysql_data_seek($element_id_sort, $element_counter); 
			$element_id_query = mysql_fetch_row($element_id_sort);
			$element_id_own = $element_id_query[0];
			$element_sort_own = $element_id_query[1];
			
			##next element_id
			if($element_counter < $element_id_num_rows-1){
			mysql_data_seek($element_id_sort, $element_counter+1); 
			$element_id_query = mysql_fetch_row($element_id_sort);
			$element_id_next = $element_id_query[0];
			$element_sort_next = $element_id_query[1];}
			
			##prev element_id
			if($element_counter > 0){
			mysql_data_seek($element_id_sort, $element_counter-1); 
			$element_id_query = mysql_fetch_row($element_id_sort);
			$element_id_prev = $element_id_query[0];
			$element_sort_prev = $element_id_query[1];}
			
			$element_counter=$element_counter+1;
			?>
          
			<div style='width:100%;background-image:url(/site_12_1/css/Element_Tops_Schatten.png);height:34px;background-repeat:repeat-x;'>
				<div style="height:34px;width:15px;float:right"></div>
				
				<? if($element_counter == 1){?><!-- Buttons, die nur beim ersten Element angezeigt werden-->
				<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:right"></div>
				<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:34px;float:right;">
					<div style="float:right; height:34px;">
						<div style="float:right;">
							<a href="papa/menu.php?men_id=<? echo $back_menu_id; ?>">
							<img src="/site_12_1/css/button_menu.png" border="0" vspace="1" title="Zurück zur Menüverwaltung"/>
							</a> 
						</div>
						<div style="float:right;">
							<? if($return_to_subcontent==1){?> 
							<a href="/site_12_1/admin/admin_V1.php?menu_id=<? echo $back_menu_id; ?>#subcontent_detail">
							<img src="/site_12_1/css/button_prev.png" border="0"/>
							</a> 
							<? }?>
						</div>
					</div>
				</div>
				<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:right"></div>
				<div style="height:34px;width:15px;float:right"></div>
				<? }?>
				
				
				<div style='background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:right'></div>
				<div style='background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:34px;float:right;'>
				<? if($element_id_num_rows > 1){?><!-- Zeige diese buttons an, sofern es überhaupt ein Element schon gibt. -->
					<div style="height:34px; float:left;">
						<? if($element_counter > 1){?> <!-- SORT UP BUTTON bei allen, die nicht das oberste Element sind-->
						<form action="seitencontent_admin_V1.php?menu_id=<? echo $menu_id;?>" method="post">
						<input type="hidden" name="task" value="sort">
						<input type="hidden" name="own" value="<? echo $element_id_own ;?>">
						<input type="hidden" name="own_sort" value="<? echo $element_sort_own ;?>">
						<input type="hidden" name="swap" value="<? echo $element_id_prev ;?>">
						<input type="hidden" name="swap_sort" value="<? echo $element_sort_prev ;?>">
						<input type="image" src="/site_12_1/css/button_up.png" title="Ein Element nach oben verschieben">
						<input type="hidden" name="timestamp" value="<? echo $timestamp = microtime();?>">
						</form>
						<? }?>
					</div>
				
					<div style="height:34px; float:left;">
						<? if($element_counter < $element_id_num_rows){?> <!-- SORT DOWN BUTTON bei allen, die nicht das letzte Element sind-->
						<form action="seitencontent_admin_V1.php?menu_id=<? echo $menu_id;?>" method="post">
						<input type="hidden" name="task" value="sort">
						<input type="hidden" name="own" value="<? echo $element_id_own ;?>">
						<input type="hidden" name="own_sort" value="<? echo $element_sort_own ;?>">
						<input type="hidden" name="swap" value="<? echo $element_id_next ;?>">
						<input type="hidden" name="swap_sort" value="<? echo $element_sort_next ;?>">
						<input type="image" src="/site_12_1/css/button_down.png"  title="Ein Element nach unten verschieben">
						<input type="hidden" name="timestamp" value="<? echo $timestamp = microtime();?>">
						</form>
						<? }?>		     
					</div>
				<? }?>
				
					<div style="height:34px; float:left;"><!-- Löschen button bei allen Elementen -->
						<form action="seitencontent_admin_V1.php?menu_id=<? echo $menu_id;?>" method="post">
						<input type="hidden" name="task" value="delete">
						<input type="hidden" name="own" value="<? echo $element_id_own ;?>">
						<input type="image" src="/site_12_1/css/button_delete.png" title="Element löschen">
						<input type="hidden" name="timestamp" value="<? echo $timestamp = microtime();?>">
						</form>		     
					</div>		
				</div>		
				<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:right"></div>
		
				<div style="height:34px;width:6px;float:left"></div>
				<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
				<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:30px; float:left; text-align:left; padding:8px" title="<? echo "$zeiges->description"; ?>"><? echo "$zeige->id"; ?> </div>
				<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
				<div style="clear:both"></div>
			</div>
			
			
		<div style="width:auto; height:auto; background-color:#FFFFFF; border-right:1px solid #cfcfcf; border-left:1px solid #cfcfcf; padding:5px"><? if($zeiges->php_admin_snippet!=""){include $_SERVER['DOCUMENT_ROOT']."site_12_1/$zeiges->php_admin_snippet";} else {include $_SERVER['DOCUMENT_ROOT']."site_12_1/$zeiges->php_snippet";}?></div>
		<div style="background-image:url(/site_12_1/css/Element_Bottom_Schatten.png); background-repeat:repeat-x; width:inherit; height:15px">&nbsp;</div>
		<?
		}
	}
	?>
	<? 
	if($element_counter == $element_id_num_rows and test_right($_SESSION['user'],"create_element")=="true"){?>
		<div style='background-image:url(/site_12_1/css/Element_subcontent_rechts.png);width:5px;height:38px;float:right'></div>
		<div style='background-image:url(/site_12_1/css/Element_subcontent_taste_Mitte.png);background-repeat:repeat-x;height:38px;float:right;'>
			<div style="height:48px; float:left;">
				<div style="float:left; max-height:38px;">
					<form action="seitencontent_admin_V1.php?menu_id=<? echo $menu_id;?>" method="post" style="float:left">
						<div style="float:left;height:38x;width:auto; max-width: 233px; padding-top:8px; padding-bottom:8px; padding-left:8px; padding-right:8px;">
							<? 
							if($element_id_num_rows){
								mysql_data_seek($element_id_sort, $element_counter-1);
								$element_id_query = mysql_fetch_row($element_id_sort);
							}?>
							<select name="element_layout_id" style="width:140px">
								<option value="Element auswählen">Element auswählen</option>
								<? if($element_layout_num>0)
								{while($row = mysql_fetch_assoc($element_layout)){
									echo "<option value=".$row[id]."\"";
									if($row['Anz']>0){echo " disabled title='Dieser Artikel wird mit anderen Magazinen geshared. Dieses Element kann nicht hinzugefügt werden.'";}
									if($row['Anz2']>0){echo " disabled title='Dieses Element kann nur einmal pro Artikel verwendet werden.'";}
									echo ">$row[description]</option>";}} 
								else {echo "<option>Kein Element vorhanden</option>";}?>
							</select> 
							<input type="hidden" name="sort" value="<? echo $element_id_query[1]+10 ;?>">
							<input type="hidden" name="timestamp" value="<? echo $timestamp = microtime();?>">
							<input type="hidden" name="task" value="add">
						</div>
						<div style="float:left;height:38px; width:36px;padding-top:1px; padding-bottom:8px; padding-left:8px; padding-right:0px;">
							<input type="image" src="/site_12_1/css/button_add.png" title="Element hinzufügen">
						</div>
					</form>
					<? if($element_id_num_rows == 0){?><!-- Buttons, die nur beim ersten Element angezeigt werden-->
						<div style="float:left;height:38px; width:36px;padding-top:3px; padding-bottom:8px; padding-left:0px; padding-right:0px;">
							<div style="float:left;">
								<form action="papa/menu.php?men_id=<? echo $back_menu_id; ?>" method="post">
								<input type="image" src="/site_12_1/css/button_menu.png" title="Zurück zur Menüverwaltung">
								</form>
							</div>
						</div>
					<? }?>
				</div>
			</div>
		</div>
		<div style="background-image:url(/site_12_1/css/Element_subcontent_links.png);width:4px;height:38px;float:right"></div>
	<? }?>	
</div>
</body>