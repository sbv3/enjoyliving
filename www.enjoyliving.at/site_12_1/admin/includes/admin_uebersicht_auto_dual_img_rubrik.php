<div style="clear:right; height:10px;"></div>
<?
if($zeige->id==""){$elem_id=$element_id_sub;}else{$elem_id=$zeige->id;}

$clippingbox_breite=132;//70 f. den kleinen single
$clippingbox_hoehe=80;	//45	f. den kleinen single
$parent_needed=1; //sagt ob die Parent-Beschriftung angezeigt werden soll
$einleitung_needed=1; // sagt of der Einleitungstext angezeigt werden soll
$img_needed=1;
$number_menus=6;
$containerwidth="295px"; //312 f den kl single 
$teasercopycols=40;
$col_nr=2;
$teaser_select_type="newest_rubrik";
$truncate_length=100;
$display_include_pfad="$adminpath/site_12_1/admin/admin_menu_teaser_auto.php";

include("$adminpath/site_12_1/menu_teaser_auto_prep.php");
$truncate_length="";
?>
<div style='clear:left;height:4px'></div>