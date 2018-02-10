<?
if($img_needed=="1")
{
	$imgrandom = rand(1000000000,9999999999);
	$clipping_aspect=$clippingbox_breite/$clippingbox_hoehe;
	$imgs_aspect=$imgs_breite/$imgs_hoehe;
	$slider_name="slider_".$menu_id_sub_menu_id."_".$imgrandom;
	if($imgs_aspect<$clipping_aspect)
	{//Bild ist lÃ¤nglicher als clipping box = Vertikaler Slider
		$output_hoehe=$clippingbox_breite/$imgs_breite*$imgs_hoehe;
		$top_crop=($clippingbox_hoehe-$output_hoehe)/2;
		require_once($_SERVER['DOCUMENT_ROOT'].'site_12_1/admin/slider.php');//den darf ich erst hier laden!
		?>
		<div style="float:left;width:<? echo $clippingbox_breite+17; ?>px;"> <!--container box-->
			<div style="width:<? echo $clippingbox_breite?>px; float:left;"> <!--image-->
				 <div style='float:left;width:<? echo $clippingbox_breite?>px; height:<? echo $clippingbox_hoehe?>px;overflow:hidden'>
					<div id="img_vertical_<?php echo $slider_name?>" style="position:relative; top:<? echo $asset_v_offset;?>px;"> 
						<div style="height:<? echo $output_hoehe;?>px">
						<?php /*?><a href='/geistseele-magazin/psyche/johanniskraut.html'><?php */?>
								<? $row_id=$slider_name;
								$imgs_type[$row_id]=$imgs_type2;
								$assets_id[$row_id]=$menu_id_sub_teaser_asset_id2; 
								$imgs_id[$row_id]=$imgs_id2; 
								$filename[$row_id]=$filename;
								$path[$row_id]=$path; 
								$imgs_category[$row_id]=$category;
								$imgs_class[$row_id]=$class;
								$imgs[$row_id]=$imgs_url;
								$imgs_scale_to_fit[$row_id]='true';
								$imgs_table[$row_id]='menu_teaser';
								$no_class=1;
								include("$adminpath/site_12_1/admin/admin_imageeditor.php");
								?>
						</div>
					</div>
				 </div>      
			</div>
			<div style="width:17px; float:left;"> <!--vertical slider-->
				  <form method="get" name="form_<? echo $menu_id_sub_teaser_id;?>">
				  <input type="hidden" name="vertical_<?php echo $slider_name;?>" id="vertical_<?php echo $slider_name;?>" size="3">
				  <script language="JavaScript">
					   var A_TPL = {
							'b_vertical' : true,
							'b_watch': true,
							'n_controlWidth': 16,
							'n_controlHeight': <? echo $clippingbox_hoehe;?>,
							'n_sliderWidth': 15,
							'n_sliderHeight': 16,
							'n_pathLeft' : 1,
							'n_pathTop' : 1,
							'n_pathLength' : <? echo $clippingbox_hoehe;?>-17,
							's_imgControl': '/site_12_1/assets/img/adminarea/slider_imgs/sldr2v_bg.gif',
							's_imgSlider': '/site_12_1/assets/img/adminarea/slider_imgs/sldr2v_sl.gif',
							'n_zIndex': 1,
							'n_menu_teaser_id': '<? echo $menu_id_sub_teaser_id;?>',
							'n_img_height': '<? echo $imgs_hoehe;?>',
							'n_img_width': '<? echo $imgs_breite;?>',
							'n_clipping_height': '<? echo $clippingbox_hoehe;?>',
							'n_clipping_width': '<? echo $clippingbox_breite;?>'
					   }
					   var A_INIT = {
							's_form' : 'form_<? echo $menu_id_sub_teaser_id;?>',
							's_name': 'vertical_<?php echo $slider_name?>',
							'n_minValue' : 0,
							'n_maxValue' : -1*<?php echo $top_crop*2;?>,
							'n_value' : -1*<?php echo $asset_v_offset;?>,
							'n_step' : 1
					   }
				  
					   new slider(A_INIT, A_TPL);
				  </script>
				  </form>
			</div>
		</div>
	
	
	
		<?
	}
	elseif($imgs_aspect>$clipping_aspect)
	{//Bild ist hochformatiger als clipping box = Horizontaler Slider
		$output_breite=$clippingbox_hoehe/$imgs_hoehe*$imgs_breite;
		$left_crop=($clippingbox_breite-$output_breite)/2;
		require_once($_SERVER['DOCUMENT_ROOT'].'site_12_1/admin/slider.php');//den darf ich erst hier laden!
		?>
		<div style="float:left;width:<? echo $clippingbox_breite?>px;"> <!--container box-->
			<div style="height:<? echo $clippingbox_hoehe?>px; float:left;"> <!--image-->
				 <div style='float:left;width:<? echo $clippingbox_breite?>px; height:<? echo $clippingbox_hoehe?>px;overflow:hidden'>
					<div id="img_horizontal_<?php echo $slider_name?>" style="position:relative; left:<? echo $asset_h_offset;?>px;"> 
						<div style="width:<? echo $output_breite;?>px">
							<?php /*?><a href='/geistseele-magazin/psyche/johanniskraut.html'><?php */?>
								<? $row_id=$slider_name;
								$imgs_type[$row_id]=$imgs_type2;
								$assets_id[$row_id]=$menu_id_sub_teaser_asset_id2; 
								$imgs_id[$row_id]=$imgs_id2; 
								$filename[$row_id]=$filename;
								$path[$row_id]=$path; 
								$imgs_category[$row_id]=$category;
								$imgs_class[$row_id]=$class;
								$imgs[$row_id]=$imgs_url;
								$imgs_scale_to_fit[$row_id]='true';
								$imgs_table[$row_id]='menu_teaser';
								$no_class=1;
								include("$adminpath/site_12_1/admin/admin_imageeditor.php");
								?>
						</div>
					</div>
				 </div>      
			</div>
			<div style="height:17px; float:left;"> <!--horizontal slider-->
				<form method="get" name="form_<? echo $menu_id_sub_teaser_id;?>">
				<input type="hidden" name="horizontal_<?php echo $slider_name;?>" id="horizontal_<? echo $slider_name;?>" size="3">
				<script language="JavaScript">
					var A_TPL = {
						'b_vertical' : false,
						'b_watch': true,
						'n_controlWidth': <? echo $clippingbox_breite;?>,
						'n_controlHeight': 16,
						'n_sliderWidth': 15,
						'n_sliderHeight': 16,
						'n_pathLeft' : 1,
						'n_pathTop' : 1,
						'n_pathLength' : <? echo $clippingbox_breite;?>-17,
						's_imgControl': '/site_12_1/assets/img/adminarea/slider_imgs/sldr2h_bg.gif',
						's_imgSlider': '/site_12_1/assets/img/adminarea/slider_imgs/sldr2h_sl.gif',
						'n_zIndex': 1,
						'n_menu_teaser_id': '<? echo $menu_id_sub_teaser_id;?>',
						'n_img_height': '<? echo $imgs_hoehe;?>',
						'n_img_width': '<? echo $imgs_breite;?>',
						'n_clipping_height': '<? echo $clippingbox_hoehe;?>',
						'n_clipping_width': '<? echo $clippingbox_breite;?>'
					}
					var A_INIT = {
						's_form' : 'form_<? echo $menu_id_sub_teaser_id;?>',
						's_name': 'horizontal_<?php echo $slider_name?>',
						'n_minValue' : <?php echo $left_crop*2;?>,
						'n_maxValue' : 0,
						'n_value' : <?php echo $asset_h_offset;?>,
						'n_step' : 1
					}
				
					new slider(A_INIT, A_TPL);
				</script>
				</form>
			</div>
		</div>
		<? 
	}
	$no_class=0;
}
unset ($asset_h_offset,$asset_v_offset);
?>

<div style='width:auto'>
	<? if($parent_needed==1){?>
		<a href='<? echo $menu_parent_googleurl;?>' class="teaser_parent"><? echo $menu_description_parent;?></a>
		<br>
	<? }?>
	
	<? $field="teaser_head"; $table="menu_teaser"; $row_id="1"; $TXT_breite=$containerwidth-$clippingbox_breite-25; $rows="1"; $FCK_breite="700"; $texts[1]=$titel; $texts_style[1]='teaser_einleitung'; $texts_id[1]=$menu_id_sub_teaser_id; $editors[1]=$menu_id_sub_teaser_editor; include("$adminpath/site_12_1/admin/admin_editor.php")?>

	<? if($einleitung_needed==1){?>
		<div style='height:8px;'>&nbsp;</div>
		<? $field="teaser_copy"; $table="menu_teaser"; $row_id="1"; $TXT_breite=$containerwidth*1; $rows="1"; $FCK_breite="700"; $texts[1]=$copy; $texts_style[1]='teasertext'; $texts_id[1]=$menu_id_sub_teaser_id; $editors[1]=$menu_id_sub_teaser_editor; include("$adminpath/site_12_1/admin/admin_editor.php")?>
	<? }?>

	<? if($lesen_flag_needed==1){?>
		<div style='height:8px;'>&nbsp;</div>
		<a href='<? echo $titel_href;?>' class='teasertext'>&raquo; Artikel lesen</a>
	<? }?>
</div>
<div style='clear:left'></div>