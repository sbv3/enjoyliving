<style>

* {FONT-FAMILY: Verdana,Arial,Helvetica, sans-serif;font-size: 12px;}
.titel {color:#73ACE1;font-size: 24px; font-family: Georgia, serif;font-style: italic;font-weight:bold;padding-bottom:10px; text-decoration:none}
.einleitung{font-size:13px;font-weight:bold;color:#73ACE1;padding-bottom:14px; text-decoration:none}
.warning{font-size:13px;font-weight:bold;padding-top:14px;color:#FF0000;padding-bottom:14px; text-decoration:none}
.artikelbild{float:left; padding: 5px;margin-right: 10px;margin-bottom: 10px;border: 1px dotted #CCCCCC;}
.artikelbild_infobox{margin-bottom: 10px;}
.artikelbox{float:left;width:200px;margin-right:16px;margin-bottom:10px;border-width:1px;border-color:#BEB4B4;border-style:dotted;padding:5px;}
.artikeltext{line-height:17px;color: #000000; text-decoration:none}
.artikeltext:ul{line-height:17px;color: #000000; text-decoration:none; margin-left:15px; padding-left:15px;}
.artikellink{line-height:17px;color:rgb(115, 172, 225); font-size:11px;text-decoration:none}
.artikellink:hover{line-height:17px;color:rgb(115, 172, 225); font-size:11px;text-decoration:underline}
.whereamilink{line-height:17px;color:rgb(0,0,0); font-size:11px;text-decoration:none}
.whereamilink:hover{line-height:17px;color:rgb(0,0,0); font-size:11px;text-decoration:underline}
.infobox{line-height:15px;color: #000000;text-decoration:none;font-size: 11px;}
.advertorial{line-height:17px;font-size: 12px;color: #CCCCCC;padding-bottom: 5px;}
.artikelbeschriftung{font-style:italic}
.clear_left{clear:left}
.trenner{height:1px;margin-top:8px;margin-bottom:6px;border-style:dotted;color: #CCCCCC;border-width:1px 0px 0px 0px}
.line{border-style:solid; border-color:#C6E3FF;border-width:1px 0px 0px 0px;}
.hiddenField {display: none;}
.commentbox{color: #CCCCCC;margin-top:2px;margin-bottom:0px;padding-top: 5px;padding-right: 5px;padding-bottom: 5px;padding-left: 5px;border-top-width: 1px;border-top-style: dotted;}
.commentautor{font-size: 10px;font-style: italic;color: #CCCCCC;margin-bottom:3px;}
.fotostreckentitel{color: rgb(115, 172, 225);font-size: 2.15em;font-family: Georgia,serif;font-style: italic;text-align: center;}
.fotostrecke_gross{text-align:center;}
.bg_image_scale{left: 0; position: absolute; top: 0; width: 100%; height:100%; z-index:500;}
.teaser_parent{font-size:11px;color:#313131;font-weight:bold;font-size:11px;text-decoration:none}
.teaser_einleitung {font-size:11px;font-weight:bold;padding-bottom:20px;color:#73ACE1;padding-bottom:14px;text-decoration:none}
.teasertext {line-height:15px;color: #000000;text-decoration:none;font-size: 11px;}
.teaser_spacer{width:5px;height:1px;float:left;}
.feldrahmen_normal {margin-left:10px; text-align:center; vertical-align:middle; color:#ffffff; text-align:center; background-color:#73ACE1;}
.feldrand_links {margin-left:10px;}
.body {margin-left: 0px;margin-top: 8px;margin-right: 0px;margin-bottom: 8px;background-color:#E5F1FD;}
.infoboxzwischenheads{font-size:13px;color:#73ACE1;font-weight: bold;}
.kopf_fusszeile{color:rgb(115, 172, 225); text-decoration:none; font-size:11px;}
.kopf_fusszeile:hover{color:rgb(115, 172, 225); text-decoration:underline; font-size:11px;}
table.fixed{table-layout:fixed;}
body {margin-left: 0px;margin-top: 8px;margin-right: 0px;margin-bottom: 8px;background-color:#E5F1FD;}
.button{background-color: rgb(115, 172, 225); padding-left:4px; padding-right:4px; color:#FFFFFF; font-weight:bold; text-decoration:none;}
.button:hover{background-color:#Ff9900; padding-left:4px; padding-right:4px; color:#FFFFFF; font-weight:bold; text-decoration:underline; cursor:pointer}
.submenu{color:rgb(0,0,0); font-size:11px; vertical-align:middle; text-decoration:none}
.submenu:hover{color:rgb(0,0,0); font-size:11px; vertical-align:middle; text-decoration:underline}

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

#recaptcha_image,
#recaptcha_image img 
{
	width: 200px !important;
	height: 40px !important;
	cursor: pointer;
}
/*    #recaptcha_image img:hover
{
	position: absolute;
	width: 300px !important;
	height: 57px !important;
}
*/    
.recaptcha_only_if_image,
.recaptcha_only_if_audio
{
	display: block;
}

#menu {
	padding-left: 0px;
	margin-left: 0px;
	margin-right: 5px;
	margin-bottom: 0px;
	margin-top: 0px;
	width: 100%;
	background-color: rgb(115, 172, 225);
	font-family: Verdana, Geneva, sans-serif;
	font-size: 11px;
/*	height:30px;
*/	float: left;
	border:none;
	/*font-weight:bold;*/
	/*height:32px;*/
}
#menu ul {
	padding-left: 0px;
	float: left;
	list-style-type: none;
	background-color: rgb(115, 172, 225);
	margin-top: 0;
	margin-right: -2px;
	margin-bottom: 0;
	margin-left: 0;
	width:auto;
}

/*--definiert die "Drop-Down-Links" im Normalzustand--*/
#menu a {
	text-decoration: none;
	display: block;
	border: 1px solid rgb(195, 223, 249);
	color:#FFFFFF;
	padding-top: 5px;
	padding-right: 7px;
	padding-bottom: 5px;
	padding-left: 7px;
	width:auto;
}
/*--definiert die "Drop-Down-Links" im Hoverzustand--*/
#menu li:hover{
	text-decoration:none;
	background-color: rgb(195, 223, 249);
	background-image: url(hover_sub.gif);
	background-repeat: no-repeat;
	background-position: 0px center;
	white-space: nowrap;
	color:rgb(56, 81, 104);
}
.menu_li_selected{
	text-decoration:none;
	background-color: #Ff9900;
	background-image: url(hover_sub.gif);
	background-repeat: no-repeat;
	background-position: 0px center;
	white-space: nowrap;
	color:rgb(56, 81, 104);
}
/*verhindert im Zusammenhang mit position absolute bei ul ul
*eine Höhenvergr&ouml;&szlig;erung von #menu beim Hovern--
*/
#menu li li {float:none;}

#menu li {
	float:left;
	position: relative;
	margin: 2px;
}
/*--versteckt die "Drop-Down-Links", solange nicht gehovert wird--*/
#menu ul ul {
	position: absolute;
	z-index: 2;
	display: none;	
}
/*--lässt die Dropdown-Links beim Hovern erscheinen--*/
#menu ul li:hover ul {
	display: block;
	position:absolute;
	top:100%;
	left:0px;
	margin-top: 0;
	margin-right: 0;
	margin-bottom: 0;
	margin-left: -2px;
}
/*-- lässt die dritte Ebene verschwinden--*/
#menu ul li:hover ul ul {
	display: none;
}
/*-- lässt die dritte Ebene beim Hovern über die zweite in Erscheinung treten--*/
div#menu ul ul li:hover ul {
	display: block;
	position: absolute;
	top: 0;
	left: 100%;
	z-index:3;
	margin-top: -2px;
	margin-right: 0;
	margin-bottom: 0;
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