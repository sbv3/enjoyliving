<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<? $adminpath=$_SERVER['DOCUMENT_ROOT'];?>




<div style="float:right">
<? ###Image
$row_id=1;
include("$adminpath/site_12_1/admin/admin_imageeditor.php");
?></div>
<?
###text
$field="text"; $table="element_content_text"; $row_id="1"; $rows="30"; $FCK_breite="550";
include("$adminpath/site_12_1/admin/admin_editor.php");
?>
<div style="clear:right"></div>