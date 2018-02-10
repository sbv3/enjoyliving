
<script>
function reload_page()
{
	location.reload(true)
}


</script>
<? //echo trace();
if($zeige->id==""){$elem_id=$element_id_sub;}else{$elem_id=$zeige->id;}

$clippingbox_breite=150;
$clippingbox_hoehe=85;
$parent_needed=1; //sagt ob die Parent-Beschriftung angezeigt werden soll
$einleitung_needed=1; // sagt of der Einleitungstext angezeigt werden soll
$img_needed=1;
//$number_menus=6; not needed as happens by manual selection with the id selector.
$containerwidth="617px";
$teasercopycols=67;
$col_nr=1;
//$teaser_select_type="newest_rubrik"; only needed in auto-elements
$truncate_length=999;
//$display_include_pfad="$adminpath/site_12_1/admin/admin_menu_teaser.php"; wird nur f den auto gebraucht

include("./Admin_menu_teaser.php");////////////////////////hier wird der Code, der die Inhalte aufbereitet eingebunden! 
$truncate_length="";?>
<div style='clear:left;height:8px'>&nbsp;</div>