<?php session_start();?>
<? 
require_once($_SERVER['DOCUMENT_ROOT'].'/Connections/usrdb_enjftfxb2.php');
print_r( menu_select(230,"up",1,0,0,0));
?>
<br />
<br />
<?
//echo find_parent(230);

$used_menu_id=204;
$evalfile="/includes/teaser.php";
$texts[1]=14;
$texts[2]=6;

ob_start();
eval("include '$evalfile';");
$seitencontentblock = ob_get_contents();
ob_end_clean();

echo "kkkk";
echo htmlspecialchars(_Strip_Tag($seitencontentblock));
echo "kkkk";

$text="<div style='clear:both;'></div>";

echo "1<br>".$seitencontentblock;
echo "2<br>".strip_tags($seitencontentblock);
if(_Strip_Tag($seitencontentblock)!=""){echo "3<br>".strip_tags($seitencontentblock);}

?>



<?php
$allow = '<p><ul><li><b><strong>';

$str = $seitencontentblock;

$result = strip_tags($str,$allow);

echo '<textarea>'._Strip_Tag($seitencontentblock).'</textarea>';
echo '<textarea>'.htmlspecialchars(($seitencontentblock)).'</textarea>';
echo '<textarea>'.htmlentities(($seitencontentblock)).'</textarea>';


//Clean the inside of the tags
function _Strip_Tag($Str_Input)
{
@settype($Str_Input, 'string');
$Str_Input= @strip_tags($Str_Input);
$_Ary_TagsList= array('jav&#x0A;ascript:', 'jav&#x0D;ascript:', 'jav&#x09;ascript:', '<!-', '<', '>', '%3C', '&lt', '&lt;', '&LT', '&LT;', '&#60', '&#060', '&#0060', '&#00060', '&#000060', '&#0000060', '&#60;', '&#060;', '&#0060;', '&#00060;', '&#000060;', '&#0000060;', '&#x3c', '&#x03c', '&#x003c', '&#x0003c', '&#x00003c', '&#x000003c', '&#x3c;', '&#x03c;', '&#x003c;', '&#x0003c;', '&#x00003c;', '&#x000003c;', '&#X3c', '&#X03c', '&#X003c', '&#X0003c', '&#X00003c', '&#X000003c', '&#X3c;', '&#X03c;', '&#X003c;', '&#X0003c;', '&#X00003c;', '&#X000003c;', '&#x3C', '&#x03C', '&#x003C', '&#x0003C', '&#x00003C', '&#x000003C', '&#x3C;', '&#x03C;', '&#x003C;', '&#x0003C;', '&#x00003C;', '&#x000003C;', '&#X3C', '&#X03C', '&#X003C', '&#X0003C', '&#X00003C', '&#X000003C', '&#X3C;', '&#X03C;', '&#X003C;', '&#X0003C;', '&#X00003C;', '&#X000003C;', '\x3c', '\x3C', '\u003c', '\u003C', chr(60), chr(62), '&nbsp;','&#09;', chr(9), chr(10));
$Str_Input= @str_replace($_Ary_TagsList, '', $Str_Input);
$Str_Input= @str_replace('', '', $Str_Input);
return((string)$Str_Input);
}
?>