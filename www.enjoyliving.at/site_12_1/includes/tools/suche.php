<span class="einleitung">Seitensuche</span><br />
<div style='height:1px;line-height:1px;width:610px;margin-top:3px; background-color:#E5F1FD'>&nbsp;</div>

<form id="form1" name="form1" method="post" target="_self">
	<input name="suchbegriff" type="text" id="suchbegriff" value="<? echo"$suchbegriff";?>" size="50" maxlength="80" style='padding:0px 3px 0px 3px;margin:0px ;border-width:1px;border-style:solid;border-color:#999999;height:25px'/>
	<input type="submit" name="button" id="button" value="Suchen" class="button" style="margin-top:6px; vertical-align:bottom; border-width:0px;height:25px;"/>
</form>
<?

$akturl = $_SERVER['REQUEST_URI'];
if ($limit1=="" or $limit1==0){$limit1=0;$limit=1;$prev="";}else{$prev=$limit1-10;}
if ($limit==""){$limit=$limit1+1;}
$limit2=10;
if ($suchbegriff !=""){
$suchabfrage1=mysql_query("select element.menu_id, menu.search_type from element, element_content_text, menu, menu_hierarchy where element_content_text.text like '%$suchbegriff%' and (menu_hierarchy.active_startdate<=now() or menu_hierarchy.active_startdate='0000-00-00') and (menu_hierarchy.active_enddate>=now() or menu_hierarchy.active_enddate='0000-00-00') and menu_hierarchy.active='A' and element_content_text.element_id=element.id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=$site_id and search_type!='Subseiten' and menu.id=menu_hierarchy.menu_id group by element.menu_id") or die ("x2.1");
$ergebniscount1=mysql_num_rows($suchabfrage1);
$suchabfrage=mysql_query("select element.menu_id, menu.search_type from element, element_content_text, menu, menu_hierarchy where element_content_text.text like '%$suchbegriff%' and (menu_hierarchy.active_startdate<=now() or menu_hierarchy.active_startdate='0000-00-00') and (menu_hierarchy.active_enddate>=now() or menu_hierarchy.active_enddate='0000-00-00') and menu_hierarchy.active='A' and element_content_text.element_id=element.id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=$site_id and search_type!='Subseiten' and menu.id=menu_hierarchy.menu_id group by element.menu_id limit $limit1, $limit2 ") or die ("x2.2");
$ergebniscount=mysql_num_rows($suchabfrage);
$limit1=$limit1+10;
?>


<br />
<? echo"$ergebniscount1";?> Ergebnisse gefunden für Suchbegriff <? echo"<b>$suchbegriff</b>";?><br />
<br />
<div style='height:20px;padding:5px;width:auto;background-color:#E5F1FD'>
	<table width="100%" border="0">
		<tr>
			<td width="70%">Ergebnisse: <? echo "$limit bis $limit1";?></td>
			<td width="30%">
			<? if ($prev >=0 and $prev!=""){?>
				<form name="form1" method="post" target="_self" style="width:80px;float:left">
					<input name="" type="submit" value="&laquo; zurück" style="border-style:none;border-width:0px;color:<? echo $color_button_font;?>; background-color:<? echo $color_button_bg;?>;"/>
					<input name="suchbegriff" type="hidden" value="<? echo"$suchbegriff";?>" />
					<input name="limit1" type="hidden" value="<? echo"$prev";?>" />
				</form>
			<? }?>
			<? if ($limit1 < $ergebniscount1){?>
				<form name="form1" method="post" target="_self" style="width:80px;float:left">
					<input name="" type="submit" value="vorwärts &raquo;" style="border-style:none;border-width:0px;color:<? echo $color_button_font;?>; background-color:<? echo $color_button_bg;?>;"/>
					<input name="suchbegriff" type="hidden" value="<? echo"$suchbegriff";?>" />
					<input name="limit1" type="hidden" value="<? echo"$limit1";?>" />
				</form>
			<? }?>
			</td>
		</tr>
	</table>
</div>
<br />
<br />
<br />
<div style='height:1px;line-height:1px;width:610px;background-color:#999999'>&nbsp;</div>

<? 

//while ($zeigesuchergebnis=mysql_fetch_object($suchabfrage))
//{?>

<?
$clippingbox_breite=70;//132 f. den dual
$clippingbox_hoehe=45;	//80	f. den dual
$number_menus=$ergebniscount;
$i=0;

while($menu_id_latest_result=mysql_fetch_assoc($suchabfrage))
{
//Schritt 1: test ob es einen Text vom Element_layout "TITEL" gibt. Wenn ja (Schritt 2), test ob es ein Bild gibt. Wenn nein, nimm die nächste MenuID.
	if($i>$number_menus){break;}
	$test_menu_id=$menu_id_latest_result['menu_id'];
	$search_result_titel=teaser_text($test_menu_id,"Titel",0,$elem_id);$search_result_titel=$search_result_titel[text];
	$search_result_subhead=teaser_text($test_menu_id,"Copy",140,$elem_id);$search_result_subhead=$search_result_subhead[text];
	$titel_href=find_googleurl($test_menu_id);
	$search_result_img=teaser_bild($test_menu_id,$clippingbox_breite,$elem_id);
		?>
		<div style='width:80px;float:left;padding-top:6px;padding-bottom:6px'> <!-- -------------------------------------Neue Suchergebnisszeile------------------------>
			<? if($search_result_img[asset_id] != "")
			{
				$i=$i+1;
				$asset_id=$search_result_img[asset_id];
				$menu_id_sub_teaser_asset_id2=$search_result_img[asset_id];//assets.ID
				$imgs_url=$search_result_img[imgs_url];//category
				$imgs_breite=$search_result_img[imgs_breite];//breite
				$imgs_hoehe=$search_result_img[imgs_hoehe];//hoehe
				$alt_tag=$search_result_img[alt_tag];//alt_tag
				$imgs_type2=$search_result_img[type];
	
	
				$clipping_aspect=$clippingbox_breite/$clippingbox_hoehe;
				$imgs_aspect=$imgs_breite/$imgs_hoehe;
				$slider_name="slider_".$menu_id_sub_menu_id;
				
				if($imgs_aspect<$clipping_aspect)
					{//Bild ist länglicher als clipping box
						$output_hoehe=$clippingbox_breite/$imgs_breite*$imgs_hoehe;
						$top_crop=($clippingbox_hoehe-$output_hoehe)/2;
						if($asset_v_offset=="" or $asset_v_offset==NULL){$asset_v_offset=$top_crop;}?>
						<div style="float:left;width:<? echo $clippingbox_breite; ?>px;"> <!--container box-->
							<div style="width:<? echo $clippingbox_breite?>px; float:left;"> <!--image-->
								 <div style='float:left;width:<? echo $clippingbox_breite?>px; height:<? echo $clippingbox_hoehe?>px;overflow:hidden'>
									<div id="img_vertical_<?php echo $slider_name?>" style="position:relative; top:<? echo $asset_v_offset;?>px;"> 
										<div style="height:<? echo $output_hoehe;?>px">
											<a href='<? echo $titel_href;?>'>
												<img title='<? echo $alt_tag;?>' alt='<? echo $alt_tag;?>' src='<? echo $imgs_url;?>' border='0' height='<? echo $output_hoehe;?>px'> 
											</a>
										</div>
									</div>
								 </div>      
							</div>
						</div>
					
					
					
						<? 
					}
					elseif($imgs_aspect>$clipping_aspect)
					{//Bild ist hochformatiger als clipping box
						$output_breite=$clippingbox_hoehe/$imgs_hoehe*$imgs_breite;
						$left_crop=($clippingbox_breite-$output_breite)/2;
						if($asset_h_offset=="" or $asset_h_offset==NULL){$asset_h_offset=$left_crop;}
						?>
						<div style="float:left;width:<? echo $clippingbox_breite?>px;"> <!--container box-->
							<div style="height:<? echo $clippingbox_hoehe?>px; float:left;"> <!--image-->
								 <div style='float:left;width:<? echo $clippingbox_breite?>px; height:<? echo $clippingbox_hoehe?>px;overflow:hidden'>
									<div id="img_horizontal_<?php echo $slider_name?>" style="position:relative; left:<? echo $asset_h_offset;?>px;"> 
										<div style="width:<? echo $output_breite;?>px">
											<a href='<? echo $titel_href;?>'>
												<img title='<? echo $alt_tag;?>' alt='<? echo $alt_tag;?>' src='<? echo $imgs_url;?>' border='0' width='<? echo $output_breite;?>px'> 
											</a>
										</div>
									</div>
								 </div>      
							</div>
						</div>
						<? 
					}
				}?>
		</div>
		<div style='float:left;width:480px;padding-top:6px;padding-bottom:6px'><a href='<? echo $titel_href;?>' class='teaser_einleitung'><? echo $search_result_titel; ?></a><div style="height:5px"></div><a href='<? echo $titel_href;?>' class='teasertext'><? echo $search_result_subhead; ?></a></div>
		<div style='float:left;width:50px;padding-top:6px;padding-bottom:6px'><a href='<? echo $titel_href;?>' class='teasertext'><? echo $menu_id_latest_result[search_type];?></a></div>
		<div style='clear:left;'></div>
		<div style='height:1px;line-height:1px;width:610px;background-color:#999999'>&nbsp;</div>
		<?
}
?>

<br /><br />
<div style='height:20px;padding:5px;width:auto;background-color:#E5F1FD'>
	<table width="100%" border="0">
		<tr>
			<td width="70%">Ergebnisse: <? echo "$limit bis $limit1";?></td>
			<td width="30%"><? if ($prev ==0 and $prev>0){?>
				<form method="post" name="form1" target="_self" id="form2" style="width:80px;float:left">
					<input name="input" type="submit" value="&laquo; zur&uuml;ck" style="border-style:none;border-width:0px;color:<? echo $color_button_font;?>; background-color:<? echo $color_button_bg;?>;"/>
					<input name="suchbegriff" type="hidden" value="<? echo"$suchbegriff";?>" />
					<input name="limit1" type="hidden" value="<? echo"$prev";?>" />
				</form>
				<? }?>
				<? if ($limit1 < $ergebniscount1){?>
				<form method="post" name="form1" target="_self" id="form2" style="width:80px;float:left">
					<input name="input" type="submit" value="vorw&auml;rts &raquo;" style="border-style:none;border-width:0px;color:<? echo $color_button_font;?>; background-color:<? echo $color_button_bg;?>;"/>
					<input name="suchbegriff" type="hidden" value="<? echo"$suchbegriff";?>" />
					<input name="limit1" type="hidden" value="<? echo"$limit1";?>" />
				</form>
				<? }?></td>
		</tr>
	</table>
</div>
<? }?>
