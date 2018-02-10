<?
$adminpath=$_SERVER['DOCUMENT_ROOT'];
unset($teaser_menu_ids_global);
////////////Vorbereitende Queries

///Abfrage, welche Menu_ID Seitencontent hat, in einer Schleife durch die Parent_IDs in der Hierarchie nach oben.
$test_menu_id=$active_menu_id;
do{
	$elements_exist_query=mysql_query("select count(1) as Anz, exklusiver_seitencontent from element, menu_hierarchy where element_layout_id in (select id from element_layout where type like '%seitencontent%') and element.menu_id=$test_menu_id and element.site_id=$site_id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=element.site_id") or die("x1.3");//testet ob elemente bestehen, danach wird getestet ob seitencontentelemente bestehen
	$elements_anzahl=mysql_fetch_assoc($elements_exist_query);
	$test_menu_id_parent = find_parent($test_menu_id);
	if ($elements_anzahl[Anz] == 0 or ($elements_anzahl[exklusiver_seitencontent]==1 and $test_menu_id!=$active_menu_id))
	{$test_menu_id = $test_menu_id_parent;}
	else {$used_menu_id=$test_menu_id;break;}								
} while ($test_menu_id > 0);

//echo "used menu: ".$used_menu_id;
if($used_menu_id!=""){
	$seitencontent_element_id = mysql_query("select element.id, element.element_layout_id from element, menu_hierarchy where element_layout_id in (select id from element_layout where type like '%seitencontent%') and element.menu_id=$used_menu_id and element.site_id=$site_id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=element.site_id order by element.sort")or die("x41"); //alle Element_IDs vom Menüpunkt aufrufen.
	
	while(($seitencontent_element_id_r[] = mysql_fetch_assoc($seitencontent_element_id)) || array_pop($seitencontent_element_id_r));
	
	
	
	if(count($seitencontent_element_id_r)>0)
	{
		///Abfrage der einzelnen Elemente des Content mit der Menü ID 29 (Schleife)
		//$element_id = mysql_query("SELECT id, element_layout_id FROM element WHERE menu_id='$used_menu_id' order by sort")or die("x4");
		for($i_seitencontent=0,$zähler=count($seitencontent_element_id_r);$i_seitencontent<$zähler;$i_seitencontent++)
		{
			$curr_element_id=$seitencontent_element_id_r[$i_seitencontent][id];
			$prev_element_id=$seitencontent_element_id_r[$i_seitencontent-1][id];
			$curr_element_layout_id=$seitencontent_element_id_r[$i_seitencontent][element_layout_id];
			$elem_id=$curr_element_id;
			
			  $text_abfrage= mysql_query("select text, style_tag, sort from element_content_text where element_id='$curr_element_id' order by sort")or die("x5");
			  $texts=array("");
			  $texts_style=array("");
			  $texts_sort=array("");
			  while ($zeigex=mysql_fetch_object($text_abfrage)){
			  array_push($texts,"$zeigex->text");
			  array_push($texts_style,"$zeigex->style_tag");
			  array_push($texts_sort,"$zeigex->sort");
			  }
			
			
			  $img_abfrage= mysql_query("select assets.ID as assets_id, assets.category, assets.class, assets.path, assets.filename, alt_tag, element_content_img.sort as sort, element_content_img.type from assets, element_content_img where element_id='$curr_element_id' and element_content_img.assets_ID=assets.ID and category='img' order by sort")or die("x6");
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
			
			$menu_abfrage= mysql_query("select element_content_menu.menu_id from element_content_menu,menu_hierarchy where element_id='$curr_element_id' and element_content_menu.menu_id=menu_hierarchy.menu_id and site_id=$site_id and menu_hierarchy.active='A' and menu_hierarchy.active_startdate<='$date' and (menu_hierarchy.active_enddate>='$date' or menu_hierarchy.active_enddate='0000-00-00') order by element_content_menu.sort")or die("x7");
			$menus=array("");
			while ($zeigex=mysql_fetch_object($menu_abfrage)){
			array_push($menus,"$zeigex->menu_id");
			}
			
			
			$code_abfrage= mysql_query("select url, active from element_content_code where element_id='$curr_element_id' order by sort")or die("x7.1");
			$codes=array("");
			$codes_active=array("");
			while ($zeigex=mysql_fetch_object($code_abfrage)){
			array_push($codes,"$zeigex->url");
			array_push($codes_active,"$zeigex->active");
			}
			
			
			$php_snippet = mysql_query("select type, php_snippet from element_layout where id='$curr_element_layout_id'")or die("x8");
			
			while ($zeiges=mysql_fetch_object($php_snippet)){
				$scope="seitencontent";
				$evalfile=$zeiges->php_snippet;
				ob_start();
				eval("include '$evalfile';");
				$seitencontentblock = ob_get_contents();
				ob_end_clean();
							
				if(strchr($zeiges->type,"in padding"))
				{
					if($counter_seitencontent==0){echo "<div id='outsidebox_$curr_element_id' class='content_v1' style='border-width:1px 1px 1px 1px;'>";$counter_seitencontent=1;}
					?>
					<div id="<? echo $curr_element_id;?>" style="background-color:#FFFFFF; padding-top:5px; padding-bottom:5px; padding-left:5px; padding-right: 5px; "><? echo $seitencontentblock;?></div>
				<? }
				elseif(strchr($zeiges->type,"break padding"))
				{
					if($counter_seitencontent>0){echo "</div>";}
					$counter_seitencontent=0;?>
					<div id="<? echo $curr_element_id;?>" style="padding-top:0px; padding-bottom:0px; padding-left:0px; padding-right: 0px; border-style:none"><? echo $seitencontentblock;?></div>
				<? }
				$seitencontentblock="";
				?>
				<script>
					function test_size()
					{
						if(
							document.getElementById("<? echo $curr_element_id;?>") && 
							(document.getElementById("<? echo $curr_element_id;?>").offsetHeight < 25 && 
							(document.getElementById("<? echo $curr_element_id;?>").innerText =="" || !document.getElementById("<? echo $curr_element_id;?>").innerText)) && 
							document.getElementById("<? echo $curr_element_id;?>").style.paddingLeft!="0px" && 
							document.getElementById("<? echo $curr_element_id;?>").style.paddingRight!="0px")//delete the preceeding line and the element
						{document.getElementById("<? echo $curr_element_id;?>").style.display="none";}
						
						var test_element_id = new Array();
						<?
						foreach ($seitencontent_element_id_r as $v1) {
							foreach ($v1 as $k2=>$v2) {
								if($k2=="id"){print "test_element_id.push($v2);";} // This line updates the script array with new entry
							}
						}
						?>
						var counter=test_element_id.indexOf(<? echo $curr_element_id?>);
						test_element_id=test_element_id.slice(0,counter);//schneidet das Array ab. Es werden nur jene Elemente genommen, die oberhalb der eigenen ID liegen.
						test_element_id=test_element_id.reverse();
						//test_element_id=test_element_id.slice(0,1);
				
						function test_element(element_id)
						{
							var show=false;
							var final=false;
							if(document.getElementById(element_id) && document.getElementById(element_id).style.display!="none"){
								if(document.getElementById(element_id).style.paddingLeft!="0px" && document.getElementById(element_id).style.paddingRight!="0px"){return {show : true, final : true}}
							}
	
							if(document.getElementById(element_id) && document.getElementById(element_id).style.display!="none"){
								if(document.getElementById(element_id).style.paddingLeft=="0px" && document.getElementById(element_id).style.paddingRight=="0px"){return {show : false, final : true}}
							}
	
							if(document.getElementById(element_id) && document.getElementById(element_id).style.display=="none"){return {show : false, final : false}}
						}
						
						var test_id;
						var test;
						for (test_id in test_element_id)
						{
							test=test_element(test_element_id[test_id]);
							if(test.final==true){break;}
						}
						if(test){if(test.show==false && document.getElementById("<? echo $curr_element_id?>").style.paddingLeft=="0px" && document.getElementById("<? echo $curr_element_id?>").style.paddingRight=="0px"){document.getElementById("<? echo $curr_element_id?>").style.display="none";}}
					}
					$(document).ready(test_size());
				</script>
	<?
			}
		}
		if($counter_seitencontent>0){echo "</div>";$counter_seitencontent=1;}?>
		<script>
			function clear_empty_frames(element)
			{	
				if(document.getElementById(element)){
				if(document.getElementById(element).offsetHeight<3)
				{document.getElementById(element).style.display="none";}}
			}
			var test_element_id = new Array();
			<?
			foreach ($seitencontent_element_id_r as $v1) {
				foreach ($v1 as $k2=>$v2) {
					if($k2=="id"){print "test_element_id.push($v2);";} // This line updates the script array with new entry
				}
			}
			?>
			for (test_id in test_element_id)
			{
				test="outsidebox_"+test_element_id[test_id];
				clear_empty_frames(test);
			}
		</script>
		</div>
	<? 
	}
}?>