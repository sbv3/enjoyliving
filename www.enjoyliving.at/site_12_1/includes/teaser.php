<? $adminpath=$_SERVER['DOCUMENT_ROOT'];
///////////////////////////////////Prep Queries
if($texts[1]!="")
{
	$teasertyp_used_query=mysql_query("select * from menu_teaser_configs where id=$texts[1]") or die (mysql_error());
	$teasertyp_used=mysql_fetch_assoc($teasertyp_used_query);
	$clippingbox_breite=$teasertyp_used['clippingbox_breite'];
	$clippingbox_hoehe=$teasertyp_used['clippingbox_hoehe'];
	$parent_needed=$teasertyp_used['parent_needed']; //sagt ob die Parent-Beschriftung angezeigt werden soll
	$einleitung_needed=$teasertyp_used['einleitung_needed']; // sagt of der Einleitungstext angezeigt werden soll
	$img_needed=$teasertyp_used['img_needed'];
	$containerwidth=$teasertyp_used['containerwidth']."px";
	$teasercopycols=$teasertyp_used['teasercopycols'];
	$col_nr=$teasertyp_used['col_nr'];
	$truncate_length=$teasertyp_used['truncate_length'];
	$display_include_pfad=$adminpath.$teasertyp_used['display_include_pfad']; //wird nur f den auto gebraucht
	$auto_manual=$teasertyp_used['auto_manual'];
	$rubrik_subseiten=$teasertyp_used['rubrik_subseiten'];
	$lesen_flag_needed=$teasertyp_used['lesen_flag_needed'];
	$teaser_select_type=$rubrik_subseiten;
	$default_only="no";
	$number_menus=$texts[2];
}

if($auto_manual!="")
{
	if($auto_manual=="auto")
	{include("./menu_teaser_auto_prep.php");}
	elseif($auto_manual=="manual")
	{include("menu_teaser.php");}
	$truncate_length="";
}?>
<div style='clear:left;height:4px'></div>