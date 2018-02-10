<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<? $adminpath=$_SERVER['DOCUMENT_ROOT'];?>
<script language="JavaScript" type="text/javascript" charset="ISO-8859-1">

function update_teasertyp(id, value)
{
	var url="Admin_table_result.php";
	url=url+"?task=update&field=text&tabelle=element_content_text&id="+id+"&value="+value;
	display_data(url,'false');
}
function update_number_menus(id, value)
{
	var url="Admin_table_result.php";
	url=url+"?task=update&field=text&tabelle=element_content_text&id="+id+"&value="+value;
	display_data(url,'false');
}

</script>
<?
//////////////////////////////////POST Funktionen
if($task=="update_number_menus"){
	if($number_menus!="" and $number_menus!=0){
		mysql_query("update element_content_text set text=$number_menus where id= $element_text_id") or die(mysql_error());
		$texts[2]=$number_menus;
	}
}



///////////////////////////////////Prep Queries
if($texts[1]!="")
{
	$teasertyp_used_query=mysql_query("select * from menu_teaser_configs where id=$texts[1]") or die (mysql_error());
	$teasertyp_used=mysql_fetch_assoc($teasertyp_used_query);
	$clippingbox_breite=$teasertyp_used['clippingbox_breite'];
	$clippingbox_hoehe=$teasertyp_used['clippingbox_hoehe'];
	$parent_needed=$teasertyp_used['parent_needed']; //sagt ob die Parent-Beschriftung angezeigt werden soll
	$einleitung_needed=$teasertyp_used['einleitung_needed']; // sagt of der Einleitungstext angezeigt werden soll
	$img_needed=$teasertyp_used['img_needed'];
	$containerwidth=$teasertyp_used['containerwidth']."px";
	$teasercopycols=$teasertyp_used['teasercopycols'];
	$col_nr=$teasertyp_used['col_nr'];
	$truncate_length=$teasertyp_used['truncate_length'];
	$display_include_pfad=$adminpath.$teasertyp_used['admin_display_include_pfad']; //wird nur f den auto gebraucht
	$auto_manual=$teasertyp_used['auto_manual'];
	$rubrik_subseiten=$teasertyp_used['rubrik_subseiten'];
	$lesen_flag_needed=$teasertyp_used['lesen_flag_needed'];
	$explanation=$teasertyp_used['explanation'];
	$teaser_select_type=$rubrik_subseiten;
	$default_only="no";
	if($texts[2]==""){
		$element_text_id=$texts_id[2];
		mysql_query("update element_content_text set text=6 where id= $element_text_id") or die(mysql_error());
		$texts[2]=6;
	}
	$number_menus=$texts[2];
}

if(trace()=="seitencontent_admin_V1.php"){$teasertyp_avail_appendix=" where description like '%seitenc.%'";} elseif(trace()=="admin_V1.php"){$teasertyp_avail_appendix=" where description not like '%seitenc.%'";}
$teasertyp_avail_query=mysql_query("select id,description from menu_teaser_configs $teasertyp_avail_appendix order by id") or die (mysql_error());

?>

<div style="float:right; margin-left:5px;">
	<div style="background-image:url(/site_12_1/css/Element_subcontent_rechts.png);width:4px;height:38px;float:right"></div>
	<div style="background-image:url(/site_12_1/css/Element_subcontent_taste_Mitte.png);background-repeat:repeat-x;height:38px; float:right;">
		<div style="float:left; margin-top:8px; margin-left:5px; margin-right:5px" >
			<form method="post" target="_self" name="Teasertyp_<? echo $elem_id?>">
				<select name="Teasertyp" onchange="if(this.value == 'hier eingeben'){} else {update_teasertyp(<? echo $texts_id[1];?>,this.options[selectedIndex].value); document.forms['Teasertyp_<? echo $elem_id?>'].submit();}">
					<option value="hier eingeben" <? if($texts[1]==""){echo "selected";}?> class="<? echo $texts_style[1];?>">hier eingeben</option>
					<? while($teasertyp_avail_result=mysql_fetch_assoc($teasertyp_avail_query))
					{		
								if ($teasertyp_avail_result['id']==$texts[1])
								{echo "<option selected value='$teasertyp_avail_result[id]' title='$explanation'>$teasertyp_avail_result[description]</option>";}
								else {echo "<option value='$teasertyp_avail_result[id]' title='$explanation'>$teasertyp_avail_result[description]</option>";}
					 }?>
				</select>
			</form>
		</div>
		<?
		if($auto_manual=="auto" and $rubrik_subseiten!="sibling"){?>
			<div style="float:left;" >
				<form method="post" target="_self" name="Teaseranz_<? echo $elem_id?>" style="float:left;">
					<table cellpadding="0" cellspacing="0" border="0" style="height:34px;">
						<tr>
							<td rowspan="2"><input type="text" name="number_menus" value="<? echo $number_menus;?>" style="width:50px;height:23px; text-align:right"/></td>
							<td><input type="button" value=" /\ " onclick="this.form.number_menus.value++;" style="font-size:7px;width:22px;height:15px;" ></td>
							<td rowspan="2"><input type="button" value="update" onclick="document.forms['Teaseranz_<? echo $elem_id?>'].submit();" style="margin-left:5px;"/></td>
						</tr>
						<tr>
							<td><input type=button value=" \/ " onclick="if(this.form.number_menus.value > 1){this.form.number_menus.value--;}" style="font-size:7px;width:22px;height:15px;" ></td>
						</tr>
					</table>
					<input type="hidden" name="task" value="update_number_menus" />
					<input type="hidden" name="element_text_id" value="<? echo $texts_id[2]?>" />
				</form>
			</div>
		<? }?>
	</div>
	<div style="background-image:url(/site_12_1/css/Element_subcontent_links.png);width:4px;height:38px;float:right"></div>
</div>
<div style="clear:right"></div>

<a style="font-size:9px; color:#999999; margin-left:1em">
<br><br>Bei Autoelementen gilt folgende Reihenfolge bei der Aufbereitung der Inhalte:
<br>1) Ein manuell erstellter Menu-Teaser für das Element besteht. Dieser könnte auch gelöscht werden. 
<br>2) Ein manuell erstellter Menu-Teaser beseht zwar, aber für ein anderes Element. Dieser könnte kopiert werden. 
<br>3) Suche nach Elementen mit dem Namen 'Titel', 'Einleitung' und irgend ein Bild von der Seite, egal in welchem Element. 
<br>3a) Wird kein Element 'Titel' gefunden, wird der Metatag-Titel genutzt. Ist der auch leer, bleibt die Headline leer. 
<br>3b) Wird kein Element 'Einleitung' gefunden, wird die Metatag-Description genutzt. Ist die leer, bleibt die Beschreibung leer. 
<br />3c) Wird kein Bild gefunden, so wird das default Bild genommen.
</a>

<div style="clear: both"></div>
<div style='width:100%;height:1px;'class="trenner"></div>
	<?
	if($auto_manual!="")
	{
		if($auto_manual=="auto")
		{include("site_12_1/menu_teaser_auto_prep.php");}
		elseif($auto_manual=="manual")
		{include("site_12_1/admin/Admin_menu_teaser.php");}
		$truncate_length="";
	}?>
<div style='clear:left;height:4px'></div>