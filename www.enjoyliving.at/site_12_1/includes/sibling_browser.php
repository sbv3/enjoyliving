<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<? $adminpath=$_SERVER['DOCUMENT_ROOT'];?>

<? if(substr(trace(),0,5)=="admin"){?>
<script>
function update_setup(element_text_id, value)
{
	var url="Admin_table_result.php";
	url=url+"?task=update&field=text&tabelle=element_content_text&id="+element_text_id+"&value="+value;
	display_data(url,'false');
}
</script>

<form method="post" target="_self" name="rowsetup_<? echo $elem_id?>">
	<div id="href_<? echo $elem_id?>" style="float:left; margin-top:8px;width:85px;" >
		URL setup<br />
		<select id="href_setup_<? echo $elem_id;?>" name="href_setup_<? echo $elem_id?>" onchange="update_setup('<? echo $texts_id[1]?>',$('#href_setup_<? echo $elem_id;?>').val());">
			<option <? if ($texts[1]==1 or $texts[1]==""){echo "selected";}?> value='1' title='URL wird für subcontent gesetzt.'>href URL für Subcontentseiten</option>
			<option <? if ($texts[1]==2){echo "selected";}?> value='2' title='URL wird für normale Siblings gesetzt.'>href URL für normale Siblings</option>
		</select>
	</div>
	<div style="clear:both; width:100%;height:1px;" class="trenner"></div>
<? } ?>
<?
///////////////////////////////////Prep Queries

$img_needed=1;
$lesen_flag_needed=0;
$einleitung_needed=0;
$parent_needed=0;
$url_type=$texts[1];


$default_only="no";

##rowsetup
$teaser_col_nr[$elem_id]=1; //vormals $col_nr
$teaser_carouselwidth[$elem_id]=110;//vormals $carouselwidth
$teaser_siblings_depth=1;
$teaser_count_entries=999;

##layout setup
$menu_teaser_layout_is_slider=1;

if($menu_teaser_layout_is_slider==2){$menu_teaser_layout_is_slider=1;}

?>
<?
if($used_menu_id!=""){$auto_menu_id=$used_menu_id;}else{$auto_menu_id=$active_menu_id;}//to cater for the "Seitencontent"
?>
<?
//selection & sorting
$teaser_menu_select=menu_select($menu_id,'down','1','1','','0');//$start_id,$down,$number_levels=1,$only_active=1,$menu_only=0,$exclude_subseiten=0,$site_id_in=null
$teaser_menu_skipped=menu_select($menu_id,'down','1','0','','0');
if($teaser_menu_skipped and $teaser_menu_select){$teaser_skipped[$elem_id]=array_diff($teaser_menu_skipped[id],$teaser_menu_select[id]);}
if($teaser_menu_skipped and !$teaser_menu_select){$teaser_skipped[$elem_id]=$teaser_menu_skipped[id];}
if(!$teaser_menu_skipped and $teaser_menu_select){$teaser_skipped[$elem_id]="";}

$counter=0;
for($iteration=0;$counter<count($teaser_menu_select[id]);)
{
	$teaser_test_menu_id=$teaser_menu_select['id'][$counter];
	$counter=$counter+1;

	$teaser_asset=teaser_bild($teaser_test_menu_id,112,$elem_id);
	if($teaser_asset[asset_id]>0)//testet of ein Bild, das nicht das default-Bild ist, vorhanden ist.
	{
		$iteration=$iteration+1;
		$teaser_menu_ids[$elem_id][]=$teaser_test_menu_id;
	}
	else
	{$teaser_skipped[$elem_id][]=$teaser_test_menu_id;}
}
if(!$menu_ids_global){$menu_ids_global=$teaser_menu_ids[$elem_id];}
else
{
	if(count($teaser_menu_ids[$elem_id])>0){
		$teaser_menu_duplicate[$elem_id]=array_intersect($teaser_menu_ids[$elem_id],$menu_ids_global);
		$teaser_menu_ids[$elem_id]=array_diff($teaser_menu_ids[$elem_id],$menu_ids_global);
		$menu_ids_global=array_merge($menu_ids_global,$teaser_menu_ids[$elem_id]);
	}
}


list($teaser_menu_ids[$elem_id],$teaser_sorting[$elem_id],$teaser_element_content_menu_id[$elem_id]) = sort_teaser_ids($teaser_menu_ids[$elem_id],$elem_id,"5","1","3","auto");

if (count($teaser_skipped[$elem_id])>0 and substr(trace(),0,5)=="admin")
{?>
	<div title="<? echo "Folgende Artikel werden nicht angezeigt: "; echo implode(',',$teaser_skipped[$elem_id]);?>"><img src="/site_12_1/css/Attention_small.png" height="16px" style="margin-bottom:-2px;" /> <? echo count($teaser_skipped[$elem_id])." Einträge werden nicht gezeigt, weil sie kein Bild aufweisen, oder weil die Seiten nicht aktiv sind.";?></div>
	<div style='width:100%;height:1px;'class='trenner'></div>
	<div style="clear:both"></div>
<? }
if (count($teaser_menu_duplicate[$elem_id])>0 and substr(trace(),0,5)=="admin")
{?>
	<div title="<? echo "Folgende Artikel werden nicht angezeigt: "; echo implode(',',$teaser_menu_duplicate[$elem_id]);?>"><img src="/site_12_1/css/Attention_small.png" height="16px" style="margin-bottom:-2px;" /> <? echo count($teaser_menu_duplicate[$elem_id])." Einträge werden nicht gezeigt, weil sie von einem anderen Teaser schon gezeigt werden.";?></div>
	<div style='width:100%;height:1px;'class='trenner'></div>
	<div style="clear:both"></div>
<? }
if(count($teaser_menu_ids[$elem_id])<5 and substr(trace(),0,5)=="admin")
{?>
	<div title="<? echo "Weniger als 5 gütige Artikel!"; if($teaser_menu_ids[$elem_id]){echo "Es sind nur folgende Artikel gültig: "; echo implode(',',$teaser_menu_ids[$elem_id]);}?>"><img src="/site_12_1/css/Attention_small.png" height="16px" style="margin-bottom:-2px;" /> <? echo " Das Element wird nicht gezeigt, weil nur ".count($teaser_menu_ids[$elem_id])." gültige Artikel gefunden wurden.";?></div>
	<div style="clear:both"></div>
<? }
if(count($teaser_menu_ids[$elem_id])<5 and substr(trace(),0,5)!="admin")
{?>
<script>
$(".content_v1_elements").last().remove();
</script>
<? }?>

<div style="clear:both"></div>

<?
if(count($teaser_menu_ids[$elem_id])>=5)
{

	$teaser_number_menus[$elem_id]=count($teaser_menu_ids[$elem_id]);
	?>
	<?
	$clipping_box_r[width]=112;
	$clipping_box_r[height]=112;
	$clipping_box_r[textbox_style_head]="teaser_einleitung";
	$clipping_box_r[textbox_style_head_grey]="teaser_einleitung_grey";
	
	$teaser_carouselwidth[$elem_id]=112;
	$teaser_clipping_width=$clipping_box_r[width];
	$teaser_clipping_height=$clipping_box_r[height];
		
	?>
	<style>
		#carousel {
			width:570px;
			/*padding:10px;*/
			margin:0 auto;
			position:relative;
			/*z-index:0;*/
			float:left;
			width:100%;
		}
		.carousel_slides {
			float:left; /* important for inline positioning */
			width:570px; /* important (this width = width of list item(including margin) * items shown */
			overflow: hidden;  /* important (hide the items outside the div) */
			/* non-important styling bellow */
			background: #ffffff;
		}
		.carousel_slides_carousel {
			position:relative;
			left:-114px; /* important (this should be negative number of list items width(including margin) */
			list-style-type: none; /* removing the default styling for unordered list items */
			margin: 0px;
			padding: 0px;
			width:9999px; /* important */
			/* non-important styling bellow */
			padding-bottom:10px;
		}
		.carousel_slides_carousel .slide{
			float: left; /* important for inline positioning of the list items */
			width:112px;  /* fixed width, important */
			/* just styling bellow*/
			padding:0px;
			height:112px;
			background: #ffffff;
			margin-left:1px;
			margin-right:1px;
		}
	</style>
	<div id="teaser_content_<? echo $elem_id;?>" style="width:620px;">
	<?

?><div id="carousel" name="overall_carousel_<? echo $elem_id;?>"><div name="leftnavi_<? echo $elem_id;?>" style="width:24px; float: left; position: relative;right:4px;top:35px;overflow:hidden;"><a href="javascript:slide('left');" class="prev"><img src="/site_12_1/css/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a></div><div class="carousel_slides" id="carousel_slides_<? echo $elem_id;?>"><div name="carousel_<? echo $elem_id;?>" class="carousel_slides_carousel"><?
	//Ende des obersetn slide setups. ?>
		<?
		for ($anz=0,$anz_limit=count($teaser_menu_ids[$elem_id]);$anz<$anz_limit;$anz++)
		{
			$teaser_counter[$elem_id]=0;
		
			if($menu_teaser_layout_is_slider==1){?><div class="slide" id="<? echo $teaser_menu_ids[$elem_id][$anz];?>"><? } else { ?><div name="teaser_zeile" style="width:620px"><? } //Ende des obersetn slide setups. ?>
				<? do
				{
					$teaser_counter[$elem_id]=$teaser_counter[$elem_id]+1;
					
					if($img_needed==1)
					{
						$teaser_asset_arr=teaser_bild($teaser_menu_ids[$elem_id][$anz],112,$elem_id);
						$teaser_asset_id=$teaser_asset_arr[asset_id];//assets.ID
						$teaser_category=$teaser_asset_arr[category];//category
						$teaser_class=$teaser_asset_arr['class'];//class
						$teaser_path=$teaser_asset_arr[path];//path
						$teaser_filename=$teaser_asset_arr[filename];//filename
						$teaser_imgs_url=$teaser_asset_arr[imgs_url];//imgs_url
						$teaser_imgs_breite=$teaser_asset_arr[imgs_breite];//breite
						$teaser_imgs_hoehe=$teaser_asset_arr[imgs_hoehe];//hoehe
						$teaser_alt_tag=$teaser_asset_arr[alt_tag];//alt_tag
						$teaser_imgs_type=$teaser_asset_arr[type];
						$teaser_menu_teaser_id_img=$teaser_asset_arr['menu_teaser_id'];

						$teaser_h_offset_percent=$teaser_asset_arr['asset_h_offset_percent'];
						$teaser_v_offset_percent=$teaser_asset_arr['asset_v_offset_percent'];
	
						if($teaser_v_offset_percent==="0" or $teaser_v_offset_percent>0){$teaser_v_offset=($teaser_clipping_height-($teaser_clipping_width/$teaser_imgs_breite*$teaser_imgs_hoehe))*$teaser_v_offset_percent;}
						if($teaser_h_offset_percent==="0" or $teaser_h_offset_percent>0){$teaser_h_offset=($teaser_clipping_width-($teaser_clipping_height/$teaser_imgs_hoehe*$teaser_imgs_breite))*$teaser_h_offset_percent;}
					}

					if($url_type=="1" or $url_type==""){$teaser_url = find_googleurl(find_parent($teaser_menu_ids[$elem_id][$anz]))."/".($anz+1);}
					if($url_type=="2"){$teaser_url = find_googleurl($teaser_menu_ids[$elem_id][$anz]);}
					
					?>
						<div name="teaser_box" style="width:<? echo $teaser_carouselwidth[$elem_id];?>px; height:112px;position:relative; background-color:<? echo $teaser_backgroundcolor;?>;">
							<?
								if($img_needed=="1")
								{
									$clipping_aspect=$teaser_clipping_width/$teaser_clipping_height;
									$imgs_aspect=$teaser_imgs_breite/$teaser_imgs_hoehe;
									$slider_name="slider_".$teaser_menu_ids[$elem_id][$anz]."_".$imgrandom;
									if($imgs_aspect<$clipping_aspect)
									{//Bild ist länglicher als clipping box
										$output_hoehe=$teaser_clipping_width/$teaser_imgs_breite*$teaser_imgs_hoehe;
										$top_crop=($teaser_clipping_height-$output_hoehe)/2;
										if($teaser_v_offset==="" or $teaser_v_offset===NULL){$teaser_v_offset=$top_crop;}
										?>
										<div style="float:left;width:<? echo $teaser_clipping_width; ?>px;height:<? echo $teaser_clipping_height?>px;"> <!--carousel box1-->
											<div style="width:<? echo $teaser_clipping_width?>px; float:left;"> <!--image-->
												<div style='float:left;width:<? echo $teaser_clipping_width?>px; height:<? echo $teaser_clipping_height?>px;overflow:hidden'>
													<div id="img_vertical_<?php echo $slider_name?>" style="position:relative; top:<? echo $teaser_v_offset;?>px;"> 
														<div style="height:<? echo $output_hoehe;?>px">
															<a href='<? echo $teaser_url;?>'>
																<img title='<? echo $teaser_alt_tag;?>' alt='<? echo $teaser_alt_tag;?>' src='<? echo $teaser_imgs_url;?>' border='0' height='<? echo $output_hoehe;?>px'> 
															</a>
														</div>
													</div>
												</div>      
											</div>
										</div>
										<? 
									}
									elseif($imgs_aspect>=$clipping_aspect)
									{//Bild ist hochformatiger als clipping box
										$output_breite=$teaser_clipping_height/$teaser_imgs_hoehe*$teaser_imgs_breite;
										$left_crop=($teaser_clipping_width-$output_breite)/2;
										if($teaser_h_offset==="" or $teaser_h_offset===NULL){$teaser_h_offset=$left_crop;}
										?>
										<div style="float:left;width:<? echo $teaser_clipping_width?>px;height:<? echo $teaser_clipping_height?>px;"> <!--carousel box-->
											<div style="height:<? echo $teaser_clipping_height?>px; float:left;"> <!--image-->
												<div style='float:left;width:<? echo $teaser_clipping_width?>px; height:<? echo $teaser_clipping_height?>px;overflow:hidden'>
													<div id="img_horizontal_<?php echo $slider_name?>" style="position:relative; left:<? echo $teaser_h_offset;?>px;"> 
														<div style="width:<? echo $output_breite;?>px">
															<a href='<? echo $teaser_url;?>'>
																<img title='<? echo $teaser_alt_tag;?>' alt='<? echo $teaser_alt_tag;?>' src='<? echo $teaser_imgs_url;?>' border='0' width='<? echo $output_breite;?>px'> 
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
					<? 
					$anz=$anz+1;
				} while ($teaser_counter[$elem_id]<$teaser_col_nr[$elem_id] and $anz<$anz_limit);//hier wird die Schleife der Zeile geschlossen.
				$anz=$anz-1;
				?>
			</div>
		<?
		}//Schleife Ende for all Menu ids
		?>
		
	</div>
	</div>
	<? if($menu_teaser_layout_is_slider==1)
	{?> <div name="leftnavi_<? echo $elem_id;?>" style="width:24px; float: left; position: relative;left:4px;top:35px;overflow:hidden;"><a href="javascript:slide('right');" class="next"><img src="/site_12_1/css/arrow-next.png" width="24" height="43" alt="Arrow Next"></a></div><? }?>
	</div>
	</div>
	<div style="clear:both"></div>
	<input type='hidden' id='hidden_auto_slide_seconds' value=0 />
	<div id="rollup_<? echo $elem_id;?>"></div> 
	<div style='width:100%;height:1px;'class='trenner'></div>
	
	<script>
		//source: http://web.enavu.com/tutorials/making-a-jquery-infinite-carousel-with-nice-features/
	  $(document).ready(function() {
			if($('.carousel_slides_carousel .slide').size() <= 5){
				$('.carousel_slides_carousel .slide').clone().insertAfter('.carousel_slides_carousel .slide:last');
			}
			//options( 1 - ON , 0 - OFF)
			var auto_slide = 1;
			var hover_pause = 1;
			var key_slide = 1;
	
			//speed of auto slide(
			var auto_slide_seconds = 2000;
			var auto_slide_seconds_stored = auto_slide_seconds;
			/* IMPORTANT: i know the variable is called ...seconds but it's
			in milliseconds ( multiplied with 1000) '*/
	
			/*move the last list item before the first item. The purpose of this is
			if the user clicks to slide left he will be able to see the last item.*/
			$('.carousel_slides_carousel .slide:first').before($('.carousel_slides_carousel .slide:last'));
	
			//check if auto sliding is enabled
			if(auto_slide == 1){
				/*set the interval (loop) to call function slide with option 'right'
				and set the interval time to the variable we declared previously */
				var timer = setInterval('slide("right")', auto_slide_seconds);
	
				/*and change the value of our hidden field that hold info about
				the interval, setting it to the number of milliseconds we declared previously*/
				$('#hidden_auto_slide_seconds').val(auto_slide_seconds);
			}
	
			//check if hover pause is enabled
			if(hover_pause == 1){
				//when hovered over the list
				$('.carousel_slides_carousel').hover(function(){
					//stop the interval
					clearInterval(timer)
				},function(){
					//and when mouseout start it again
					timer = setInterval('slide("right")', auto_slide_seconds);
				});
	
			}
	
			//check if key sliding is enabled
			if(key_slide == 1){
	
				//binding keypress function
				$(document).bind('keypress', function(e) {
					//keyCode for left arrow is 37 and for right it's 39 '
					if(e.keyCode==37){
							//initialize the slide to left function
							slide('left');
					}else if(e.keyCode==39){
							//initialize the slide to right function
							slide('right');
					}
				});
	
			}
	
	  });
	
	//FUNCTIONS BELLOW
	
	//slide function
	function slide(where){
	
				//get the item width
				var item_width = $('.carousel_slides_carousel .slide').outerWidth();
	
				/* using a if statement and the where variable check
				we will check where the user wants to slide (left or right)*/
				if(where == 'left'){
					//...calculating the new left indent of the unordered list (ul) for left sliding
					var left_indent = parseInt($('.carousel_slides_carousel').css('left')) + item_width;
				}else{
					//...calculating the new left indent of the unordered list (ul) for right sliding
					var left_indent = parseInt($('.carousel_slides_carousel').css('left')) - item_width;
	
				}
	
				//make the sliding effect using jQuery's animate function... '
				$('.carousel_slides_carousel:not(:animated)').animate({'left' : left_indent},500,function(){
	
					/* when the animation finishes use the if statement again, and make an ilussion
					of infinity by changing place of last or first item*/
					if(where == 'left'){
						//...and if it slided to left we put the last item before the first item
						$('.carousel_slides_carousel .slide:first').before($('.carousel_slides_carousel .slide:last'));
					}else{
						//...and if it slided to right we put the first item after the last item
						$('.carousel_slides_carousel .slide:last').after($('.carousel_slides_carousel .slide:first'));
					}
	
					//...and then just get back the default left indent
					$('.carousel_slides_carousel').css({'left' : '-114px'});
				});
	
	}
	function adjust_grey_teaser_bars()
	{
		$("[name='grey']").css("height","auto");
		var maxHeight = Math.max.apply(null, $("[name='grey']").map(function ()
		{
			return $(this).height();
		}).get());
		$("[name='grey']").css("height",maxHeight);
	}
	</script>
	<?
}?>