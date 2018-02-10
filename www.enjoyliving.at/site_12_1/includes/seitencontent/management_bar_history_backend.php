<?php session_start();?>
<?php header ('Content-type: text/html; charset=iso-8859-1'); ?>
<?
ini_set("include_path",ini_get("include_path").":/home/enjftfxb/www.enjoyliving.at/"); 
require_once("Connections/usrdb_enjftfxb2_12_1.php");
?>
<?
$menus=explode("|",$menu_ids);
unset($tmp);
$result=array();
foreach ($menus as $m)
{
	if($menu_teaser_valid_count==10){break;}
	if(menu_teaser_valid($m,1,0))
	{
		$menu_teaser_valid_count=$menu_teaser_valid_count+1;
		array_push($result,$m);
	}
}

unset($menus);
$menus=$result;
array_unshift($menus,"");
?>
<?
$texts[1]="4";//rowsetup ID
$texts[2]="1";//img needed
$texts[3]="0";//read more needed
$texts[4]="0";//Einleitung needed
$texts[5]="1";//Parent needed
$texts[6]="4";//img_pos setup ID
$texts[7]="1";//selection method setup
$texts[8]="0";//truncate text
$texts[9]="99";//truncate length
$texts[10]="0";//truncate forced
$texts[11]="0";//sort1 (Startdate)
$texts[12]="0";//sort 2 (create Seite)
$texts[13]="0";//sort 3 create im Magazin
$texts[14]="0";//depth siblings
$texts[15]="10";//count entries
$texts[16]="false";//text wrap
$texts[17]="4";//layout ID
$texts[18]="false";//rollup
$texts[19]="true";//thin separator

$scope="seitencontent";

include("/site_12_1/includes/teaser_mgt.php");
?>