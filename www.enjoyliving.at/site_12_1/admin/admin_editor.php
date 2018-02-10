<? session_start();?>
<?
$adminpath=$_SERVER['DOCUMENT_ROOT'];
include("$adminpath/site_12_1/admin/fckeditor/fckeditor.php");
?>

<div class=<? echo $texts_style[$row_id];?> 
	id="<? echo $field;?>_<?php echo $texts_id[$row_id]; ?>_div" 
	onclick="editField(this,'<? echo rawurlencode($texts[$row_id]);?>')">
	<?php if($texts[$row_id]==""){echo "<span class='$texts_style[$row_id]' style='color:#CCCCCC'>hier eingeben</span>";}
	else{echo $texts[$row_id];} ?>
</div>
<? $anzahl_zeichen=strlen($texts[$row_id]);?>
<? if($editors[$row_id]=="TXT"){?>
	<!--create a field and call it the same as above-->
	<form method="post" >
		<textarea name="<? echo $field;?>" 
			style="width:<? echo $TXT_breite;?>px" 
			cols="1"
			rows="<? echo $rows;?>" 
			class="hiddenField" 
			id="<? echo $field;?>_<?php echo $texts_id[$row_id]; ?>" 
			onblur="updateField(this,'<? echo $table; ?>',<?php echo $texts_id[$row_id]; ?>)">
			<?php if($texts[$row_id]=""){"hier eingeben";}else{echo $texts[$row_id];} ?>
		</textarea>
	</form>
	<? } else { ?>
	<script type="text/javascript" src="/site_12_1/admin/fckeditor/fckeditor.js"></script>
	<div class="hiddenField" id="<? echo $field;?>_<?php echo $texts_id[$row_id]; ?>" > 
		<script type="text/javascript">
		var FCK_Editor_create_ID="<? echo $table;?>_<?php echo $texts_id[$row_id]; ?>";
		var oFCKeditor = new FCKeditor(FCK_Editor_create_ID);
		oFCKeditor.BasePath = "/site_12_1/admin/fckeditor/";
		oFCKeditor.ToolbarSet = "Basic";
		var hoehe="<? echo $anzahl_zeichen;?>";
		var breite="<? echo $FCK_breite;?>";
		oFCKeditor.Height = Math.max(Math.ceil(hoehe/120)*30+100,300);
		oFCKeditor.Width = breite;
		oFCKeditor.Config["CustomConfigurationsPath"] = "/js/fckconfig.js";
		oFCKeditor.Config["EditorAreaCSS"] = "/css/fckeditor.css";
		oFCKeditor.Value = URLdecode("<? echo urlencode($texts[$row_id]);?>");
		oFCKeditor.Create();
		</script>
		<div>
			<input name="<? echo $table;?>_<?php echo $texts_id[$row_id]; ?>" type="button" value="update" onclick="updateFieldFCK('<? echo $table;?>_<?php echo $texts_id[$row_id]; ?>','<? echo $table; ?>','<?php echo $texts_id[$row_id]; ?>','<? echo $field;?>')">
		</div>
	</div>
	<? } ?>
<div id="table_result_error_messages"></div>