<?
$adminpath=$_SERVER['DOCUMENT_ROOT'];
$scope="subcontent";
?>
<a name=subcontent_detail></a>
<?
/////////////////////////////////////////// own location Funktion

###prepare for subpages
$url = $_SERVER['PHP_SELF'];
$subpage = $_GET["subpage"];
$url="$url?menu_id=$menu_id&subpage=";

###get list of menu_ids of all subpages
$menu_ids_sub=menu_select($active_menu_id,"down",1,0,0,0);
if($menu_ids_sub){$menu_ids_sub=implode(",",$menu_ids_sub[id]);

$menu_id_sub = mysql_query("select id from menu where id in ($menu_ids_sub) order by find_in_set(id,'$menu_ids_sub')")or die("subx3");
$menu_id_sub_row_count=mysql_num_rows($menu_id_sub);
$row_pointer=$subpage;

###setup navigation buttons
if($row_pointer==null or $row_pointer==1){if($menu_id_sub_row_count==0){$row_pointer=0;}else{$row_pointer=1;}$prev="";} else {$prev1=$row_pointer-1;$prev="<a href='$url$prev1'><img src='$href_root/site_12_1/css/foto_back.gif' border='0'></a>";}

if($row_pointer==$menu_id_sub_row_count or $menu_id_sub_row_count==0){$next="";} else {$next1=$row_pointer+1;$next="<a href='$url$next1'><img src='$href_root/site_12_1/css/foto_vor.gif' border='0'></a>";}

###define which subpage (menu_id) to show out of all menu_ids found
if ($menu_id_sub_row_count>0){mysql_data_seek($menu_id_sub, $row_pointer-1);}
$row=mysql_fetch_row($menu_id_sub);
$menu_id_sub=$row[0];
$menu_id_sub_return=find_parent($menu_id_sub);

?>

<div style='float:left;width:100px;'><? echo "$prev &nbsp"; ?></div>
<div style='float:left;width:400px;padding-top:15px;text-align:center'><? echo "$row_pointer von $menu_id_sub_row_count"; ?></div>
<div style='float:left;width:100px;text-align:right'><? echo "$next &nbsp"; ?></div>
<div style="height:2px;clear:right;clear:left"></div>

<img src="/site_12_1/css/subcontent_top.jpg" width="630" height="8" align="left"/>
<?

/////////////////////////////////////////// Inhalte aufbereiten
###get elements of that sub-page
$element_id_sub_query = mysql_query("SELECT element.id as element_id_sub, element_layout_id as element_layout_id_sub FROM element, element_layout WHERE menu_id='$menu_id_sub' and element_layout.id=element.element_layout_id and element_layout.type not like '%seitencontent%' and element_layout.type not like '%sponsorbanner%' order by sort")or die("subx4");
while ($zeige=mysql_fetch_object($element_id_sub_query)){
	$element_id_sub="$zeige->element_id_sub";
	$element_layout_id_sub="$zeige->element_layout_id_sub";
	$elem_id=$element_id_sub;

$text_abfrage_sub= mysql_query("select id, text, editor, style_tag, sort from element_content_text where element_id='$element_id_sub' order by sort")or die("subx5");
$texts_id=array("");
$texts=array("");
$editors=array("");
$texts_style=array("");
$texts_sort=array("");
while ($zeigex_sub=mysql_fetch_object($text_abfrage_sub)){
array_push($texts_id,"$zeigex_sub->id");
array_push($editors,"$zeigex_sub->editor");	
array_push($texts,"$zeigex_sub->text");
array_push($texts_style,"$zeigex_sub->style_tag");
array_push($texts_sort,"$zeigex_sub->sort");
}


$img_abfrage_sub= mysql_query("select assets.ID as assets_id, element_content_img.id as element_content_img_id, element_content_img.sort as sort, category, class, element_content_img.type, filename, path from assets, element_content_img where element_id='$element_id_sub' and element_content_img.assets_ID=assets.ID and category ='img' order by sort")or die("x6");
$assets_id=array("");
$imgs_id=array("");
$imgs=array("");
$imgs_category=array("");
$imgs_class=array("");
$imgs_type=array("");
$filename=array("");
$path=array("");
$imgs_sort=array("");
while ($zeigex_sub=mysql_fetch_object($img_abfrage_sub)){
array_push($assets_id,"$zeigex_sub->assets_id");
array_push($imgs_id,"$zeigex_sub->element_content_img_id");
array_push($imgs,"/site_12_1/assets/$zeigex_sub->category$zeigex_sub->class$zeigex_sub->path$zeigex_sub->filename");
array_push($imgs_category,"$zeigex_sub->category");
array_push($imgs_class,"$zeigex_sub->class");
array_push($imgs_type,"$zeigex_sub->type");
array_push($filename,"$zeigex_sub->filename");
array_push($path,"$zeigex_sub->path");
array_push($imgs_sort,"$zeigex_sub->sort");
}


$menu_abfrage_sub= mysql_query("select element_content_menu.id, element_content_menu.menu_id, menu_hierarchy.active, menu_hierarchy.active_startdate, menu_hierarchy.active_enddate from element_content_menu,menu,menu_hierarchy where element_id='$element_id_sub' and element_content_menu.menu_id=menu.id and site_id=$site_id and menu_hierarchy.menu_id=menu.id order by element_content_menu.sort")or die("subx7");
	$menus_id=array("");
	$menus=array("");
	$menus_parent=array("");
	$menus_active=array("");
	$menus_start=array("");
	$menus_end=array("");
while ($zeigex_sub=mysql_fetch_object($menu_abfrage_sub)){
		array_push($menus_id,"$zeigex_sub->id");
		array_push($menus,"$zeigex_sub->menu_id");
		array_push($menus_parent,find_parent("$zeigex_sub->menu_id"));
		array_push($menus_active,"$zeigex_sub->active");
		array_push($menus_start,"$zeigex_sub->active_startdate");
		array_push($menus_end,"$zeigex_sub->active_enddate");
}



$code_abfrage_sub= mysql_query("select id, url, admin_url, active from element_content_code where element_id='$element_id_sub' order by sort")or die("x7");
$codes_id=array("");
$codes=array("");
$codes_active=array("");
while ($zeigex_sub=mysql_fetch_object($code_abfrage_sub)){
array_push($codes_id,"$zeigex_sub->id");
array_push($codes_active,"$zeigex_sub->active");
if($zeigex_sub->admin_url==""){array_push($codes,$_SERVER['DOCUMENT_ROOT']."site_12_1/$zeigex_sub->url");}else{array_push($codes,$_SERVER['DOCUMENT_ROOT']."site_12_1/$zeigex_sub->admin_url");}
}


$php_snippet_sub = mysql_query("select php_admin_snippet,php_snippet from element_layout where id='$element_layout_id_sub'")or die("subx8");
while ($zeiges_sub=mysql_fetch_object($php_snippet_sub)){	
if($zeiges_sub->php_admin_snippet!=""){include $_SERVER['DOCUMENT_ROOT']."site_12_1/$zeiges_sub->php_admin_snippet";} else {include $_SERVER['DOCUMENT_ROOT']."site_12_1/$zeiges_sub->php_snippet";} 
}}
?>

<? } ?>
<img src="/site_12_1/css/subcontent_bottom.jpg" width="630" height="8" align="left"/>

<div style="height:2px;clear:right;clear:left"></div>
<div style='float:left;width:100px;'><? echo "$prev &nbsp"; ?></div>
<div style='float:left;width:400px;padding-top:15px;text-align:center'><? echo "$row_pointer von $menu_id_sub_row_count"; ?></div>
<div style='float:left;width:100px;text-align:right'><? echo "$next &nbsp"; ?></div>

<? echo "<br>";echo "<br>";echo "<br>";
if(test_right($_SESSION['user'],"create_menu")=="true" and $menu_id_sub_row_count>0){?>

	<div style='width:100%;height:1px;'class="trenner"></div>
	<div style="height:42px;width:28px;float:right"></div>
	<div style="background-image:url(/site_12_1/css/Element_subcontent_rechts.png);width:4px;height:38px;float:right"></div>
	<div style="background-image:url(/site_12_1/css/Element_subcontent_taste_Mitte.png);background-repeat:repeat-x;height:38px; float:right;">
		<div style="height:38px; float:left;">
			<form action="admin_V1.php?menu_id=<? echo"$menu_id&subpage=$subpage";?>" method="post">
				<div style="float:left; max-height:38px;">
					<div style="float:left;height:38x;width:auto; padding-top:7px; padding-bottom:8px; padding-left:8px; padding-right:8px;">
						Neuen subcontent anlegen: 
						<input name = "titel2" type="text"  align="left" title="Name des neuen subcontents" value="">
						<input type="hidden" name="menu_id_sub" value="<? echo $menu_id_sub ;?>">
						<input type="hidden" name="subcontent_anlegen" value="1">
						<input type="hidden" name="menu_id" value="<? echo $menu_id;?>" />
					</div>
					<div style="float:left;height:38px; width:36px;">
						<input type="image" src="/site_12_1/css/button_add.png" title="Eine Subcontent-Seite vom gleichen Typ hinzufügen">
					</div>
				 </div>
			</form>
		</div>
		<div style="height:38px; float:left;">
	
			<!--zurück zum Menu-->          
			<a href="papa/menu.php?men_id=<? echo $menu_id_sub_return; ?>">
			<img style="position:relative; top:2px;" src="/site_12_1/css/button_menu.png" border="0" title="Zurück zur Menüverwaltung des Subcontents"/>
			</a> 
		
			<!--Subceontent Elemente editieren-->
			<a href="/site_12_1/admin/admin_V1.php?menu_id=<? echo $menu_id_sub; ?>&return_to_subcontent=1">
			<img src="/site_12_1/css/button_next.png" border="0" title="Den Subcontent editieren"/>
			</a> 
		</div>
	</div>
	<div style="background-image:url(/site_12_1/css/Element_subcontent_links.png);width:4px;height:38px;float:right"></div>
	<div style="clear:right"></div>
<? }?>

<a href="admin_subcontent.php" src="url(/site_12_1/css/button_detail.png)"></a>