<? 
$color_background="#eeeeee";
$color_text_default="#616861";
$color_text_headline="#E87A30";
$color_text_subline="#E87A30";
$color_content_border="#E87A30";//E87A30
$color_dotted_line="#E87A30";
$color_warning="#FF0000";

$color_button_bg="#E87A30";
$color_button_font="#555555";
$color_botton_highlight_bg="#ffb178";
$color_botton_highlight_font="#ffffff";

$color_menu_hover="#fdecb4";//fdecb4
$color_menu_font="#000000";
$color_menu_selected_bg="#ffb178";
$color_menu_selected_font="#ffffff";

$color_breadcrums_bg="#eeeeee";
$color_kopf_fußzeile="#ffb178";

$teaser_backgroundcolor="#ffffff";

$logo_path="/site_12_1/css/mangoo/logo.jpg";
$basislayout_seitenkopf="<img border='0' width='267' alt='".$site_description."' src='".$logo_path."'>";
?>
<link href='http://fonts.googleapis.com/css?family=PT+Serif+Caption|Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>


<style>
/*  Diplomata+SC|  font-family: 'Diplomata SC', cursive;*/

* {font-family: 'PT Serif Caption', serif;font-size: 13px;}
a {text-decoration:none; color:<? echo $color_text_default;?>; cursor:pointer;}
table.fixed{table-layout:fixed;}
img{border:hidden;}
.basislayout_setup{width:972px;float:left;}
.basislayout_body{margin-left: 0px;margin-top: 8px;margin-right: 0px;margin-bottom: 8px;}
body{margin-left: 0px;margin-top: 8px;margin-right: 0px;margin-bottom: 8px;background-color:<? echo $color_background; ?>;}
.basislayout_kopfzeile{text-align:right;position: relative;top: 45px;}
.basislayout_seitenabstand{margin-left:8px;margin-right:8px;}
.basislayout_whereami_container{height:14px; padding-top:4px; padding-left:3px; padding-bottom:14px;clear:both;}
.basislayout_sponsorbanner_container{width:951px;padding-bottom:5px;}
.basislayout_contentcontainer1{float:left; width:632px;margin-right:12px;margin-left:8px;}
.basislayout_seitencontent_container{width:312px;float:left;}
.basislayout_footer{clear:left;margin-left:8px;margin-right:8px;padding-top:24px}

.content_v1{
	-moz-box-shadow: 3px 3px 3px rgba(0,0,0,.5); /* Firefox */
	-webkit-box-shadow: 3px 3px 3px rgba(0,0,0,.5); /* Safari, Chrome */
	box-shadow: 3px 3px 3px rgba(0,0,0,.5); /* CSS3 */
	border: 1px solid #888888;
}
.content_v1_elements{background-color:#FFFFFF; padding-top:5px; padding-bottom:5px; padding-left:10px; padding-right: 10px; }
.content_v1_elements_break_padding{padding-top:0px; padding-bottom:0px; padding-left:0px; padding-right: 0px;}
.menubar_submenu{clear:both; min-height:17px; padding-bottom: 5px; padding-top: 5px; padding-left: 7px; vertical-align:central;background-color:<? echo $color_breadcrums_bg;?>;}

.admin_body{background-color:<? echo $color_background; ?>;}

.titel {color:<? echo $color_text_headline; ?>;font-size: 26px; font-family: 'Open Sans Condensed', sans-serif;font-weight:bold;padding-bottom:10px; text-decoration:none}
.einleitung{font-family: 'Open Sans Condensed', sans-serif; font-size:15px;font-weight:bold;color:<? echo $color_text_subline; ?>;padding-bottom:14px; text-decoration:none}
.warning{font-size:13px;font-weight:bold;padding-top:14px;color:<? echo $color_warning; ?>;padding-bottom:14px; text-decoration:none}
.artikelbild{float:left; padding: 5px;margin-right: 10px;margin-bottom: 10px; margin-left: 10px; background-color:#eeeeee}
.artikelbild_infobox{margin-bottom: 10px;}
.artikelbox{float:left;width:200px;margin-right:16px;margin-bottom:10px;border-width:1px;border-color:<? echo $color_dotted_line;?>;border-style:dotted;padding:5px;}
.artikeltext{line-height:17px;color: <? echo $color_text_default;?>; text-decoration:none}
.artikeltext:ul{line-height:17px;color: <? echo $color_text_default;?>; text-decoration:none; margin-left:15px; padding-left:15px;}
.artikellink{line-height:17px;color:<? echo $color_text_headline;?>; font-size:11px;text-decoration:none}
.artikellink:hover{line-height:17px;<? echo $color_text_headline;?>; font-size:11px;text-decoration:underline}
.whereamilink{line-height:17px;color:<? echo $color_text_default;?>; font-size:11px;text-decoration:none}
.whereamilink:hover{line-height:17px;color:<? echo $color_text_default;?>; font-size:11px;text-decoration:underline}
.infobox{line-height:15px;color:<? echo $color_text_default;?>;text-decoration:none;font-size: 11px;}
.advertorial{line-height:17px;font-size: 12px;color: <? echo $color_dotted_line;?>;padding-bottom: 5px;}
.artikelbeschriftung{font-style:italic}
.clear_left{clear:left}
.trenner{height:1px;margin-top:8px;margin-bottom:6px;border-style:dotted;color: <? echo $color_dotted_line;?>;border-width:1px 0px 0px 0px}
.line{border-style:solid; border-color: <? echo $color_content_border;?>;border-width:1px 0px 0px 0px}
.hiddenField {display: none;}
.commentbox{color: <? echo $color_dotted_line;?>;margin-top:2px;margin-bottom:0px;padding-top: 5px;padding-right: 5px;padding-bottom: 5px;padding-left: 5px;border-top-width: 1px;border-top-style: dotted;}
.commentautor{font-size: 10px;font-style: italic;color: <? echo $color_dotted_line;?>;margin-bottom:3px;}
.fotostreckentitel{color: <? echo $color_text_headline; ?>;font-size: 2.15em;font-family: Georgia,serif;font-style: italic;text-align: center;}
.fotostrecke_gross{text-align:center;}
.fotostrecke_klein{width:300px;}
.bg_image_scale{left: 0; position: absolute; top: 0; width: 100%; height:100%; z-index:500;}
.teaser_parent{font-size:11px;color:<? echo $color_text_default;?>;font-weight:bold;font-size:11px;text-decoration:none;}
.teaser_einleitung {font-size:15px;font-weight:bold;padding-bottom:20px;color:<? echo $color_text_headline; ?>;padding-bottom:14px;text-decoration:none}
.teaser_einleitung_grey {font-size:11px;font-weight:bold;color:#ffffff;text-decoration:none}
.teasertext {line-height:15px;color: <? echo $color_text_default;?>;text-decoration:none;font-size: 11px;}
.teaser_spacer{width:5px;height:1px;float:left;}
.feldrand_links {margin-left:10px;}
.infoboxzwischenheads{font-size:13px;color:<? echo $color_text_headline; ?>;font-weight: bold;}
.kopf_fusszeile{color:<? echo $color_kopf_fußzeile; ?>; text-decoration:none; font-size:11px;}
.kopf_fusszeile:hover{color:<? echo $color_kopf_fußzeile; ?>; text-decoration:underline; font-size:11px;}
.button{background-color:<? echo $color_button_bg; ?>; padding-left:4px; padding-right:4px; color:<? echo $color_button_font; ?>; font-weight:bold; text-decoration:none;}
.button:hover{background-color:<? echo $color_botton_highlight; ?>; padding-left:4px; padding-right:4px; color:<? echo $color_botton_highlight_font; ?>; font-weight:bold; text-decoration:underline; cursor:pointer}
.submenu{color:<? echo $color_text_default; ?>; font-size:13px; vertical-align:middle; text-decoration:none}
.submenu:hover{color:<? echo $color_text_default; ?>; font-size:13px; vertical-align:middle; text-decoration:underline}
.banner {display: block;position: relative;text-align:center;}

.register_schatten{background-image:url(<? echo $href_root;?>/site_12_1/css/Element_Tops_Schatten_blau.png);background-size:contain;background-repeat:repeat-x;float:left;}
.register_links{background-image:url(<? echo $href_root;?>/site_12_1/css/Element_Tops_links_blau.png);background-size:contain;background-repeat:no-repeat;float:left;}
.register:hover .register_links{background-image:url(<? echo $href_root;?>/site_12_1/css/Element_Tops_links_orange.png);background-size:contain;background-repeat:no-repeat;float:left;}
.register_links_selected{background-image:url(<? echo $href_root;?>/site_12_1/css/Element_Tops_links_orange.png);background-size:contain;background-repeat:no-repeat;float:left;}
.register_mitte{background-image:url(<? echo $href_root;?>/site_12_1/css/Element_Tops_taste_Mitte_blau.png);background-size:contain;background-repeat:repeat-x;min-width:50px; float:left; text-align:left; padding-left:8px; padding-right:8px;float:left;}
.register_mitte_selected{background-image:url(<? echo $href_root;?>/site_12_1/css/Element_Tops_taste_Mitte_orange.png);background-size:contain;background-repeat:repeat-x;min-width:50px; float:left; text-align:left; padding-left:8px; padding-right:8px;float:left;}
.register:hover .register_mitte{background-image:url(<? echo $href_root;?>/site_12_1/css/Element_Tops_taste_Mitte_orange.png);background-size:contain;background-repeat:repeat-x;min-width:50px; float:left; text-align:left; padding-left:8px; padding-right:8px;float:left;}
.register_rechts{background-image:url(<? echo $href_root;?>/site_12_1/css/Element_Tops_rechts_blau.png);background-size:contain;background-repeat:no-repeat;float:left;}
.register:hover .register_rechts{background-image:url(<? echo $href_root;?>/site_12_1/css/Element_Tops_rechts_orange.png);background-size:contain;background-repeat:no-repeat;float:left;}
.register_rechts_selected{background-image:url(<? echo $href_root;?>/site_12_1/css/Element_Tops_rechts_orange.png);background-size:contain;background-repeat:no-repeat;float:left;}
.register_text{font-size:13px;font-weight:bold;color:#ffffff;text-decoration:none}
.register:hover .register_text{font-size:13px;font-weight:bold;color:#ffffff;text-decoration:underline}

#menu {
	padding-left: 0px;
	margin-left: 0px;
	margin-right: 5px;
	margin-bottom: 0px;
	margin-top: 7px;
	width: 100%;
	background-color: <? echo $color_button_bg; ?>;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 11px;
	height:33px;
	float: left;
	border:none;
	background-image:url('/site_12_1/css/mangoo/menubar_mittel2.png')
	/*font-weight:bold;*/
	/*height:32px;*/
}
#menu ul {
	padding-left: 0px;
	float: left;
	list-style-type: none;
	/*background-color: <? echo $color_button_bg; ?>;*/
	margin-top: 0px;
	margin-right: -2px;
	margin-bottom: 0px;
	margin-left: 0px;
	width:auto;
	}

/*--definiert die "Drop-Down-Links" im Normalzustand--*/
#menu a {
	text-decoration: none;
	display: block;
	/*border: 1px solid <? echo $color_menu_border; ?>;*/
	color:<? echo $color_menu_font;?>;
	padding-top: 3px;
	padding-right: 7px;
	padding-bottom: 5px;
	padding-left: 10px;
	width:auto;
}
/*--definiert die "Drop-Down-Links" im Hoverzustand--*/
#menu li:hover{
	text-decoration:none;
	background-color: <? echo $color_menu_hover; ?>;
	background-image: url('/site_12_1/css/mangoo/menubar_hell2.png');
	white-space: nowrap;
	color:<? echo $color_menu_selected_font;?>;
	background-position:0px 0px;
	height:33px;
}
.menu_li_selected{
	text-decoration:none;
	background-color: <? echo $color_menu_selected_bg;?>;
	background-image: url('/site_12_1/css/mangoo/menubar_selected2.png');
	background-position:0px 0px;
	white-space: nowrap;
	color:<? echo $color_menu_selected_font;?>;
	height:33px;
}
/*verhindert im Zusammenhang mit position absolute bei ul ul
*eine HÃ¶henvergr&ouml;&szlig;erung von #menu beim Hovern--
*/
#menu li li {float:none;margin:0px 0px 0px 0px;}

#menu li {
	float:left;
	position: relative;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 2px;
	margin-left: 0px;
}
/*--versteckt die "Drop-Down-Links", solange nicht gehovert wird--*/
#menu ul ul {
	position: absolute;
	z-index: 2;
	display: none;	
}
/*--lässt die Dropdown-Links beim Hovern erscheinen und positioniert sie --*/
#menu ul li:hover ul {
	display: block;
	position:absolute;
	top:100%;
	left:0px;
	margin-top: 0px;
	margin-right: -1px;
	margin-bottom: 0px;
	margin-left: 0px;
	z-index:999;
	background-color:#fef7ec;
	filter:alpha(opacity=90); /* IE5.5+ */
	-moz-opacity:0.9; /* Gecko browsers including Netscape 6+ and Firefox */
	-khtml-opacity: 0.9; /* Safari 1.1-1.3 */
	opacity: 0.9; /* Netscape 7.2+, Firefox, Safari 2+, Opera 9 */
	min-height: 1px; /* to trigger hasLayout in IE7 */
}

#menu ul li:hover ul li
{
	height:30px;
	background-image:url(/site_12_1/css/hover_sub.gif);
	background-repeat:no-repeat;
	background-position: 0px 10px;
}

#menu ul li:hover ul li:hover ul li
{
	background-image:none;
	height:30px;
	background-repeat:no-repeat;
	background-position: 0px 10px;
}

#menu ul li:hover ul li a
{
	color:#000000
	height:30px;
}

div#menu ul ul li:hover ul li a 
{color:#000000}

/*-- lässt die dritte Ebene verschwinden--*/
#menu ul li:hover ul ul {
	display: none;
}
/*-- lÃ¤sst die dritte Ebene beim Hovern Ã¼ber die zweite in Erscheinung treten--*/
div#menu ul ul li:hover ul {
	display: block;
	position: absolute;
	top: 0;
	left: 100%;
	z-index:3;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
}

/*--nur f&uuml;r IE-Versionen &lt;=6 erkennbar--*/
* html #menu ul li {
	float: left;
	width: 100%;
}
/*--nur f&uuml;r IE 7 erkennbar--*/
*+ html #menu ul li {
	float: left;
	width: 100%;
}
/*--bewirkt Hover-Effekt f&uuml;r IE &lt;7 auch f&uuml;r ul- und li-Elemente--*/
*html body {
	behavior:url(<? echo $_SERVER['DOCUMENT_ROOT']?>site_12_1/css/csshover3-source.htc);
	font-size: 100%;
}
*html #menu ul li a {
	height: 100%;
}

</style>