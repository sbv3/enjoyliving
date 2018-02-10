<?
$adminpath=$_SERVER['DOCUMENT_ROOT'];
$scope="subcontent";
?>

<?
###prepare for subpages
#$url = $_SERVER['PHP_SELF'];
$url=find_googleurl($active_menu_id)."/";
$subpage = $_GET["subpage"];

###get list of menu_ids of all subpages
$menu_ids_sub=menu_select($active_menu_id,"down",1,0,0,0);
$menu_ids_sub=implode(",",$menu_ids_sub[id]);
$menu_id_sub = mysql_query("select id from menu where id in ($menu_ids_sub) order by find_in_set(id,'$menu_ids_sub')")or die("subx3");
$menu_id_sub_row_count=mysql_num_rows($menu_id_sub);
$row_pointer=$subpage;

###setup navigation buttons
if($row_pointer==null or $row_pointer==1){$row_pointer=1;$prev="";} else {$prev1=$row_pointer-1;$prev="<a href='$url$prev1'><img src='$href_root/site_12_1/css/foto_back.gif' border='0'></a>";}

if($row_pointer==$menu_id_sub_row_count){$next="";} else {$next1=$row_pointer+1;$next="<a href='$url$next1'><img src='$href_root/site_12_1/css/foto_vor.gif' border='0'></a>";}

###define which subpage (menu_id) to show out of all menu_ids found
if ($menu_id_sub_row_count>0){mysql_data_seek($menu_id_sub, $row_pointer-1);}
$row=mysql_fetch_row($menu_id_sub);
$menu_id_sub=$row[0];


$navi="<div style='float:left;width:100px;'>$prev &nbsp;</div><div style='float:left;width:400px;padding-top:15px;text-align:center'>$row_pointer von $menu_id_sub_row_count</div><div style='float:left;width:100px;text-align:right'>$next &nbsp;</div>";
echo $navi;
echo "<div style='height:2px;clear:both'></div>";

?>
	<?
	
	###get elements of that sub-page
	$element_id_sub_query = mysql_query("SELECT element.id as element_id_sub, element_layout_id as element_layout_id_sub FROM element, element_layout WHERE menu_id='$menu_id_sub' and element_layout.id=element.element_layout_id and element_layout.type not like '%seitencontent%' and element_layout.type not like '%sponsorbanner%' order by sort")or die("subx4");
	while ($zeige=mysql_fetch_object($element_id_sub_query)){
		$element_id_sub="$zeige->element_id_sub";
		$element_layout_id_sub="$zeige->element_layout_id_sub";
		$elem_id=$element_id_sub;
	
		$text_abfrage_sub= mysql_query("select text,style_tag,sort from element_content_text where element_id='$element_id_sub' order by sort")or die("subx5");
		$texts=array("");
		$texts_style=array("");
		$texts_sort=array("");
		while ($zeigex_sub=mysql_fetch_object($text_abfrage_sub)){
		array_push($texts,"$zeigex_sub->text");
		array_push($texts_style,"$zeigex_sub->style_tag");
		array_push($texts_sort,"$zeigex_sub->sort");
		}
		
		
		$img_abfrage_sub= mysql_query("select assets.ID as assets_id, assets.category, assets.class, assets.path, assets.filename, alt_tag, element_content_img.sort as sort, element_content_img.type from assets, element_content_img where element_id='$element_id_sub' and element_content_img.assets_ID=assets.ID and category='img' order by sort")or die("subx6");
		$imgs=array("");
		$imgs_type=array("");
		$imgs_alt_tag=array("");
		$imgs_sort=array("");
		while ($zeigex_sub=mysql_fetch_object($img_abfrage_sub)){
			if($zeigex_sub->assets_id=="0")
			  {
				  array_push($imgs,"");
				  array_push($imgs_type,"");
				  array_push($imgs_alt_tag,"default");
				  array_push($imgs_sort,"");
				}
			else{
				array_push($imgs,"/site_12_1/assets/$zeigex_sub->category$zeigex_sub->class$zeigex_sub->path$zeigex_sub->filename");
				array_push($imgs_type,"$zeigex_sub->type");
				array_push($imgs_alt_tag,"$zeigex_sub->alt_tag");
				array_push($imgs_sort,"$zeigex_sub->sort");
			}
		}
		
		
		
		$menu_abfrage_sub= mysql_query("select element_content_menu.menu_id from element_content_menu,menu_hierarchy where element_id='$zeige->id_sub' and element_content_menu.menu_id=menu_hierarchy.menu_id and site_id=$site_id and menu_hierarchy.active='A' and menu_hierarchy.active_startdate<='$date' and (menu_hierarchy.active_enddate>='$date' or menu_hierarchy.active_enddate='0000-00-00') order by element_content_menu.sort")or die("subx7.1");
		$menus=array("");
		while ($zeigex_sub=mysql_fetch_object($menu_abfrage_sub)){
		array_push($menus,"$zeigex_sub->menu_id");
		}
		
		$code_abfrage_sub= mysql_query("select url, active from element_content_code where element_id='$element_id_sub' order by sort")or die("subx7");
		$codes=array("");
		$codes_active=array("");
		while ($zeigex_sub=mysql_fetch_object($code_abfrage_sub)){
		array_push($codes,"$zeigex_sub->url");
		array_push($codes_active,"$zeigex_sub->active");
		}
		
		
		$php_snippet_sub = mysql_query("select php_snippet from element_layout where id='$element_layout_id_sub'")or die("subx8");
		while ($zeiges_sub=mysql_fetch_object($php_snippet_sub)){
		include "$adminpath/site_12_1/$zeiges_sub->php_snippet";
		}
	}
	?><div id="xxx">
<!--</div><img src="/site_12_1/css/subcontent_bottom.jpg" width="619" height="8" align="left"/>--><? 
	
$navi="<div style='float:left;width:100px;'>$prev &nbsp;</div><div style='float:left;width:400px;padding-top:15px;text-align:center'>$row_pointer von $menu_id_sub_row_count</div><div style='float:left;width:100px;text-align:right'>$next &nbsp;</div>";
echo $navi;
echo "<div style='height:2px;clear:both'></div><br>";

?>
</div>


<?
#####drop down menü für kapitel
echo"<div style='font-weight:bold;padding-bottom:6px'>Artikeltitel: Kapitelübersicht</div>";
$cvs=0;
$menu_id_sub_query = mysql_query("select description from menu, menu_hierarchy where site_id=$site_id and menu_hierarchy.parent_id='$active_menu_id' and menu.id=menu_hierarchy.menu_id order by menu_hierarchy.sort")or die("subx3");
while ($zeige_menu_id_sub=mysql_fetch_object($menu_id_sub_query)){
	$cvs=$cvs+1;
echo"<div style='padding-left:8px;padding-bottom:6px'>&raquo; <a href='$url$cvs'>$zeige_menu_id_sub->description</a></div>";
}
?>
<br><br>