<? //echo trace();
if($zeige->id==""){$elem_id=$element_id_sub;}else{$elem_id=$zeige->id;}

$clippingbox_breite=132;
$clippingbox_hoehe=80;
$parent_needed=1; //sagt ob die Parent-Beschriftung angezeigt werden soll
$einleitung_needed=1; // sagt of der Einleitungstext angezeigt werden soll
$img_needed=1;
//$number_menus=6; not needed as happens by manual selection with the id selector.
$containerwidth="298px";
$teasercopycols=40;
$col_nr=2;
//$teaser_select_type="newest_rubrik"; only needed in auto-elements
$truncate_length=999;
//$display_include_pfad="$adminpath/site_12_1/menu_teaser.php"; wird nur f auto elemente gebraucht

include("menu_teaser.php");////////////////////////hier wird der Code, der die Inhalte aufbereitet eingebunden! 
$truncate_length="";?>
<div style='clear:left;height:8px'>&nbsp;</div>