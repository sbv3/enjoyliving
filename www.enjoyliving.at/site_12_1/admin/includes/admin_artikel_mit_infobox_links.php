<script language="JavaScript" type="text/javascript" charset="ISO-8859-1">

function update_infoboxtypenauswahl(id, value)
{
	if(value=="hier eingeben"){value="";}
	var url="Admin_table_result.php";
	url=url+"?task=update&field=text&tabelle=element_content_text&id="+id+"&value="+value;
	display_data(url,'false');
}
</script>



<div class='artikelbox' style="float:left">
	<div style="width:200px; overflow: hidden;">
		<? ###Advertorial
		$row_id=2;
		if ($codes[$row_id] !=""){include("$adminpath/site_12_1/admin/includes/admin_code.php");}
		?>
	</div>
	
	<? $adminpath=$_SERVER['DOCUMENT_ROOT'];?>
	
	<? ###Image
	$row_id=1;
	$imgs_scale_to_fit[$row_id]='true';
	include("$adminpath/site_12_1/admin/admin_imageeditor.php");
	echo "<div id=1 class='trenner'></div>";	
	//echo $class.$path.$filename;
	?>
	
<div>
	
	<? ###Zusatzinfo ?>
	<form method="post" name="Infoboxtypenauswahl" class="<? echo $texts_style[4];?>">
		<select name="infoboxtypenauswahl" class="<? echo $texts_style[4];?>" onchange="update_infoboxtypenauswahl(<? echo $texts_id[4];?>,this.options[selectedIndex].text)">
			<option value="hier eingeben" <? if($texts[4]==""){echo "selected";}?> class="<? echo $texts_style[4];?>">hier eingeben / leeren</option>
			<option value="Mehr Info" <? if($texts[4]=="Mehr Info"){echo "selected";}?> class="<? echo $texts_style[4];?>">Mehr Info</option>
			<option value="Zutaten" <? if($texts[4]=="Zutaten"){echo "selected";}?> class="<? echo $texts_style[4];?>">Zutaten</option>
			<option value="Weintipp" <? if($texts[4]=="Weintipp"){echo "selected";}?> class="<? echo $texts_style[4];?>">Weintipp</option>
			<option value="Buchtipp" <? if($texts[4]=="Buchtipp"){echo "selected";}?> class="<? echo $texts_style[4];?>">Buchtipp</option>
		</select>
	</form>
	<br/>
<?
	$field="text"; $table="element_content_text"; $row_id="1"; $TXT_breite="200"; $rows="5"; $FCK_breite="200";
	include("$adminpath/site_12_1/admin/admin_editor.php");
	echo "<br><div id=2 class='trenner'></div>"; ?> 
</div>	
	
	<? ###Tags
	$row_id=3;
	if ($codes[$row_id] !=""){include("$adminpath/site_12_1/admin/includes/admin_code.php");}
	
	###Mehr zum Thema 
	$row_id=1;
	if ($codes[$row_id] !=""){include("$adminpath/site_12_1/admin/includes/admin_code.php");}
	?>
	
	<? ###Webtipps
	$field="text"; $table="element_content_text"; $row_id="2"; $TXT_breite="200"; $rows="5"; $FCK_breite="200";
	echo"<b style='font-size:13px;color:#73ACE1;'>Webtipps</b><br><a class='infobox'> (URLs mit \",\" getrennt eingeben)</a><br>";
	include("$adminpath/site_12_1/admin/admin_editor.php");
	echo "<div id=2 class='trenner'></div>"; ?>
	
		
	<? ###Google
		echo"<script type=\"text/javascript\"><!--
		google_ad_client = \"pub-5166723294900636\";
		/* 200x200, Erstellt 28.01.11 */
		google_ad_slot = \"7427494366\";
		google_ad_width = 200;
		google_ad_height = 200;
		//-->
		</script>
		<script type=\"text/javascript\"
		src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
		</script>";
	?>
</div>
<div  style="float:left; width:390px">
<?
###text
$field="text"; $table="element_content_text"; $row_id="3"; $cols="70"; $rows="30"; $FCK_breite="390";
include("$adminpath/site_12_1/admin/admin_editor.php");
$row_id="";
?>
</div>
<div class='clear_left'></div>