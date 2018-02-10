<? 
// Funktionsweise: 
//Zuerst wird geschaut, ob der Typ "Sibling" ist. Wenn ja, wird der Sibling ausgegeben. 
//Wenn es nicht vom Typ Sibling ist, werden die neuesten Artikel aus der Rubrik genommen (home-Channel-Rubrik) und es wird geschaut ob es einen Cache gibt. Wenn ja, wird der gelesen, wenn nein, wird der Cache generiert.

require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
unset($teaser_menu_ids);

$iteration=0;
if($used_menu_id!=""){$auto_menu_id=$used_menu_id;}else{$auto_menu_id=$active_menu_id;}
////////////Finde alle MenuIDs wo es ein "..auto.."Element gibt.

if($teaser_select_type=="sibling")
{
	$sibling_menus=menu_select($auto_menu_id,'down','1','1','','1');//($start_id,$direction,$number_levels,$only_active,$menu_only,$exclude_subseiten)
	//if($_SESSION['user']=="claudia"){print_r($sibling_menus);}
	//$sibling_menus=array_reverse($sibling_menus);
	for($iteration=0;$iteration<count($sibling_menus['id']);$iteration++)
	{
		$teaser_menu_ids[$iteration]['menu_id']=$sibling_menus['id'][$iteration];
	}
	$number_menus=count($teaser_menu_ids['id']);
	include ($display_include_pfad);
}
else
{
	$sibling_menus=menu_select($auto_menu_id,'down','99','1','2','1');//nimmt aus den 99 Ebenen darunter alle, die aktiv, aber kein Menu sind.
	if(count($sibling_menus['id'])>0){$sibling_menus=implode(",",$sibling_menus['id']);}else {$sibling_menus=$auto_menu_id;}
	///////////ACHTUNG: lädt nur jene Artikel mit Titel, Einleiung oder Meta-Teile und Bild!
	$menu_id_latest=mysql_query("select menu.id, up_date from menu, menu_hierarchy where menu.id=menu_hierarchy.menu_id and site_id=$site_id and (menu_hierarchy.active_startdate<=now() or menu_hierarchy.active_startdate='0000-00-00') and (menu_hierarchy.active_enddate>=now() or menu_hierarchy.active_enddate='0000-00-00') and menu_hierarchy.active='A' and menu_id in ($sibling_menus) and menu_id != $auto_menu_id order by menu_hierarchy.active_startdate, menu.createdate, menu.up_date") or die ("1.1".mysql_error());//lade alle Menu IDs nach Datum sortiert und schau mal durch ob die gehen würden.
	while($menu_id_latest_result=mysql_fetch_assoc($menu_id_latest))
	{
		if($iteration>=$number_menus){break;}
		$teaser_test_menu_id=$menu_id_latest_result['id'];
		$teaser_test_menu_id_asset=teaser_bild($teaser_test_menu_id,$clippingbox_breite,$elem_id);
		
/*		echo $teaser_test_menu_id.": <br>";
		echo "TITEL: ".teaser_text($teaser_test_menu_id,"Titel",0)."<br>";
		echo "COPY: ".teaser_text($teaser_test_menu_id,"Copy",0)."<br>";
		echo "ImageID: ".$teaser_test_menu_id_asset[asset_id]."<br>";
		echo "Iteration: ".$iteration."<br><br><br>";
*/		
		$titel=teaser_text($teaser_test_menu_id,"Titel",0);$titel=$titel[text];
		$copy=teaser_text($teaser_test_menu_id,"Copy",0);$copy=$copy[text];
		if(
			($titel!="")//test_id=menu_id, test_type=element_layout_description (zB "Titel"), truncate= wenn>0 wird der Text abgeschnitten nach x Zeichen, sonst nicht))
			and ($copy!="" or $einleitung_needed==0) //test_id=menu_id, test_type=element_layout_description (zB "Copy"), truncate= wenn>0 wird der Text abgeschnitten nach x Zeichen, sonst nicht))
			and ($teaser_test_menu_id_asset[asset_id]>0 or $img_needed==0)//testet of ein Bild, das nicht das default-Bild ist, vorhanden ist.
			) 
		{
			$iteration=$iteration+1;
			$teaser_menu_ids[][menu_id]=$teaser_test_menu_id;
		}
	}
	
	include ($display_include_pfad);	
	mysql_free_result($menu_id_latest);
	$iteration=0;
}
?>