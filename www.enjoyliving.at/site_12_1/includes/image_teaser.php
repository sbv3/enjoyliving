<?
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
?>
<?
if($texts[1]=="menu_id")
{$ref=$href_root.find_googleurl($texts[2]);
$target="_self";}

if($texts[1]=="href")
{$ref="http://".$texts[3];$target="_blank";}
if($imgs[1]!=""){?>
	<div title='<? echo $imgs_alt_tag[1]?>' alt='<? echo $imgs_alt_tag[1]?>' class='<? echo $imgs_type[1]?>'><a href="<? echo $ref;?>" target="<? echo $target;?>"><img src='<? echo $imgs[1]?>' /></a></div>
<? }?>