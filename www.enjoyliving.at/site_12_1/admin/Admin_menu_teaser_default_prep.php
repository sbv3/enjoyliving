<?
$default_only="yes";
unset($teaser_menu_ids);

	$clippingbox_breite=150;
	$clippingbox_hoehe=85;
	$parent_needed=1; //sagt ob die Parent-Beschriftung angezeigt werden soll
	$einleitung_needed=1; // sagt of der Einleitungstext angezeigt werden soll
	$img_needed=1;
	$containerwidth="605px";
	$teasercopycols=67;
	$col_nr=1;
	$truncate_length=999;
//	$display_include_pfad=$adminpath.$teasertyp_used['display_include_pfad']; //wird nur f den auto gebraucht
//	$auto_manual=$teasertyp_used['auto_manual'];
//	$rubrik_subseiten=$teasertyp_used['rubrik_subseiten'];
	$lesen_flag_needed=0;
//	$teaser_select_type=$rubrik_subseiten;
	
//	$number_menus=$texts[2];


$teaser_menu_ids[0]['menu_id']=$menu_id;
include("admin_menu_teaser_auto.php");
$default_only="no";
?>
<div style="clear:both"></div>