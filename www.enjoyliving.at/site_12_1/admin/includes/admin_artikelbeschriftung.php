<? $adminpath=$_SERVER['DOCUMENT_ROOT'];?>

<script language="JavaScript" type="text/javascript" charset="ISO-8859-1">

function update_typenauswahl(id, value)
{
	var url="Admin_table_result.php";
	url=url+"?task=update&field=text&tabelle=element_content_text&id="+id+"&value="+value;
	display_data(url,'false');
}
</script>
<div  style="float: left;">
<form method="post" name="Typenauswahl" class="<? echo $texts_style[2];?>">
	<select name="typenauswahl" onchange="if(this.value == 'hier eingeben'){} else {update_typenauswahl(<? echo $texts_id[2];?>,this.options[selectedIndex].text)}">
		<option value="hier eingeben" <? if($texts[2]==""){echo "selected";}?> class="<? echo $texts_style[2];?>">hier eingeben</option>
		<option value="AutorIn: " <? if($texts[2]=="AutorIn:"){echo "selected";}?> class="<? echo $texts_style[2];?>">AutorIn: </option>
		<option value="Datum: " <? if($texts[2]=="Datum:"){echo "selected";}?> class="<? echo $texts_style[2];?>">Datum: </option>
		<option value="Quelle: " <? if($texts[2]=="Quelle:"){echo "selected";}?> class="<? echo $texts_style[2];?>">Quelle: </option>
		<option value="Fotocredit: " <? if($texts[2]=="Fotocredit:"){echo "selected";}?> class="<? echo $texts_style[2];?>">Fotocredit: </option>
	</select>
</form>
</div>
<div style="float: left; margin-left: 12px;">
<?
$field="text"; $table="element_content_text"; $row_id="1"; $TXT_breite="480"; $rows="1"; $FCK_breite="200";
include("$adminpath/site_12_1/admin/admin_editor.php");
?>
</div>
<div style="clear: both"></div>