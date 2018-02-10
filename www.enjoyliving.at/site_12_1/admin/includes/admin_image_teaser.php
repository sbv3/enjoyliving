<?
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
?>
<script language="JavaScript" type="text/javascript" charset="ISO-8859-1">
function update_men_href(id, value)
{
	var url="Admin_table_result.php";
	url=url+"?task=update&field=text&tabelle=element_content_text&id="+id+"&value="+value;
	display_data(url,'false');
}
</script>

<form method="post" name="men_href_selector_<? echo $elem_id;?>" class="<? echo $texts_style[2];?>">
	<select name="men_href_selector" onchange="if(this.value == 'hier eingeben'){} else {update_men_href(<? echo $texts_id[1];?>,this.options[selectedIndex].value);document.forms['men_href_selector_<? echo $elem_id;?>'].submit()}">
		<option value="hier eingeben" <? if($texts[1]==""){echo "selected";}?> class="<? echo $texts_style[1];?>">hier eingeben</option>
		<option value="menu_id" <? if($texts[1]=="menu_id"){echo "selected";}?> class="<? echo $texts_style[1];?>">Link zu einer Menu_ID</option>
		<option value="href" <? if($texts[1]=="href"){echo "selected";}?> class="<? echo $texts_style[1];?>">Externer Link</option>
	</select>
</form>
<div id="table_result_error_messages"></div>

<?
if($texts[1]=="menu_id")
{
	?>
	<div  style="float: left;margin-top:10px;">
		<? echo "Menu_ID: ";?>
	</div>
	<div style="float: left; margin-left: 12px;margin-top:10px;">
		<?
		$field="text"; $table="element_content_text"; $row_id="2"; $TXT_breite="200"; $rows="1"; $FCK_breite="550";
		include("site_12_1/admin/admin_editor.php");
		?>
	</div>
	<div style="clear: both"></div>
	<?
}

if($texts[1]=="href")
{
	?>
	<div  style="float: left;margin-top:10px;">
		<? echo "URL: http://";?>
	</div>
	<div style="float: left; margin-left: 12px;margin-top:10px;">
		<?
		$field="text"; $table="element_content_text"; $row_id="3"; $TXT_breite="200"; $rows="1"; $FCK_breite="550";
		include("site_12_1/admin/admin_editor.php");
		?>
	</div>
	<div style="clear: both"></div>
	<?
}
?>

<div class="trenner"></div>

<?
$row_id=1;
include("site_12_1/admin/admin_imageeditor.php");
?>
