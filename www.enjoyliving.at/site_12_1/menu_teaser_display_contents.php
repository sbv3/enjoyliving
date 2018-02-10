<?
if($img_needed=="1" and $menu_id_sub_teaser_asset_id2!=0)
{
	$clipping_aspect=$clippingbox_breite/$clippingbox_hoehe;
	$imgs_aspect=$imgs_breite/$imgs_hoehe;
	$slider_name="slider_".$menu_id_sub_menu_id;
	if($imgs_aspect<$clipping_aspect)
	{//Bild ist länglicher als clipping box
		$output_hoehe=$clippingbox_breite/$imgs_breite*$imgs_hoehe;
		$top_crop=($clippingbox_hoehe-$output_hoehe)/2;
		?>
		<div style="float:left;width:<? echo $clippingbox_breite+10; ?>px;"> <!--container box-->
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
		?>
		<div style="float:left;width:<? echo $clippingbox_breite+10?>px;"> <!--container box-->
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
unset ($asset_h_offset,$asset_v_offset);
}

if($titel!="")
{?>
	<div style='width:auto'>
		<? if($parent_needed==1){?>
			<a href='<? echo $menu_parent_googleurl;?>'class="teaser_parent"><? echo $menu_description_parent;?></a>
			<br>
		<? }?>
		
		<a href='<? echo $titel_href;?>' class='teaser_einleitung'><? echo $titel;?></a>
		
		<? if($einleitung_needed==1){?>
			<div style='height:8px;'>&nbsp;</div>
			<a href='<? echo $titel_href;?>' class='teasertext'><? echo $copy;?></a>
		<? }?>
		
		<? if($lesen_flag_needed==1){?>
			<div style='height:8px;'>&nbsp;</div>
			<a href='<? echo $titel_href;?>' class='teasertext'>&raquo; Artikel lesen</a>
		<? }?>
	</div>
<? } 
else {
	if(substr(trace(),0,5)=="admin"){echo "Weder Titel-Element noch Metatag Title für Menu_ID $teaser_test_menu_id gefunden.";}
}
?>

<div style='clear:left'></div>