<?
 ///Abfrage der einzelnen Elemente des Content mit der Menü (Schleife)
 $element_id = mysql_query("SELECT element.id, element.element_layout_id FROM element, element_layout WHERE menu_id='$active_menu_id' and element_layout.id=element.element_layout_id and element_layout.type not like '%seitencontent%' and element_layout.type not like '%sponsorbanner%' order by sort")or die("x4");
 while ($zeige=mysql_fetch_object($element_id)){
	$elem_id=$zeige->id;
	
	$text_abfrage= mysql_query("select text, style_tag, sort from element_content_text where element_id='$zeige->id' order by sort")or die("x5");
	$texts=array("");
	$texts_style=array("");
	$texts_sort=array("");
	while ($zeigex=mysql_fetch_object($text_abfrage)){
	array_push($texts,"$zeigex->text");
	array_push($texts_style,"$zeigex->style_tag");
	array_push($texts_sort,"$zeigex->sort");
	}
	
	
	$img_abfrage= mysql_query("select assets.ID as assets_id, assets.category, assets.class, assets.path, assets.filename, alt_tag, element_content_img.sort as sort, element_content_img.type from assets, element_content_img where element_id='$zeige->id' and element_content_img.assets_ID=assets.ID and category='img' order by sort")or die("x6");
	$imgs=array("");
	$imgs_type=array("");
	$imgs_alt_tag=array("");
	$imgs_sort=array("");
	while ($zeigex=mysql_fetch_object($img_abfrage)){
	  if($zeigex->assets_id=="0")
	  {
		  array_push($imgs,"");
		  array_push($imgs_type,"");
		  array_push($imgs_alt_tag,"default");
		  array_push($imgs_sort,"");
		}
	  else{
	  array_push($imgs,"/site_12_1/assets/$zeigex->category$zeigex->class$zeigex->path$zeigex->filename");
	  array_push($imgs_type,"$zeigex->type");
	  array_push($imgs_alt_tag,"$zeigex->alt_tag");
	  array_push($imgs_sort,"$zeigex->sort");
	  }
	}
	
	$menu_abfrage= mysql_query("select element_content_menu.menu_id from element_content_menu,menu_hierarchy where element_id='$zeige->id' and element_content_menu.menu_id=menu_hierarchy.menu_id and site_id=$site_id and menu_hierarchy.active='A' and menu_hierarchy.active_startdate<='$date' and (menu_hierarchy.active_enddate>='$date' or menu_hierarchy.active_enddate='0000-00-00') order by element_content_menu.sort")or die("x7");
	$menus=array("");
	while ($zeigex=mysql_fetch_object($menu_abfrage)){
	array_push($menus,"$zeigex->menu_id");
	}
	
	
	$code_abfrage= mysql_query("select url, active from element_content_code where element_id='$zeige->id' order by sort")or die("x7.1");
	$codes=array("");
	$codes_active=array("");
	while ($zeigex=mysql_fetch_object($code_abfrage)){
	array_push($codes,"$zeigex->url");
	array_push($codes_active,"$zeigex->active");
	}
	
	$php_snippet = mysql_query("select type, php_snippet from element_layout where id='$zeige->element_layout_id'")or die("x8");
	while ($zeiges=mysql_fetch_object($php_snippet)){
		$scope="main";
		if(strchr($zeiges->type,"in padding"))
		{ 
			if($counter==0){echo "<div id='outsidebox_$elem_id' class='content_v1'>";$counter=1;}
			?>
			<div class="content_v1_elements"><? include $zeiges->php_snippet;?></div>
		<? }
		elseif(strchr($zeiges->type,"break padding"))
		{
			if($counter>0){echo "</div>";}
			$counter=0;?>
			<div class="content_v1_elements_break_padding"><? include $zeiges->php_snippet;?></div>
		<? }
	}
}
if($counter>0){echo "</div>";$counter=1;}?>
