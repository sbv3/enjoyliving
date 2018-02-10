<? $adminpath=$_SERVER['DOCUMENT_ROOT'];
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php"); 
?>
<script>
    if (typeof(jQuery) == 'undefined') {
		document.write("<scr" + "ipt type='text/javascript' src='/Connections/jquery-1.9.1.js'></scr" + "ipt>");
    }            

	if(typeof (jQuery_easing_loaded)=="undefined")
	{
		document.write("<scr" + "ipt type='text/javascript' src='/Connections/Slider/source/jquery_easing.js'></scr" + "ipt>");
		document.write("<scr" + "ipt type='text/javascript' src='/Connections/Slider/source/slides.min.jquery.js'></scr" + "ipt>");
	}
</script>
<style>
.grey {
  position: absolute;
  z-index: 1;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  bottom: 0;
  background: #000000;
  filter:alpha(opacity=60); /* IE5.5+ */
  -moz-opacity:0.6; /* Gecko browsers including Netscape 6+ and Firefox */
  -khtml-opacity: 0.6; /* Safari 1.1-1.3 */
  opacity: 0.6; /* Netscape 7.2+, Firefox, Safari 2+, Opera 9 */
  min-height: 1px; /* to trigger hasLayout in IE7 */
}
</style>

<?
/////////////////////////////////////////// POST Funktionen
##change sort order
$task=$_POST[task];
$swap_sort=$_POST[swap_sort];
$own=$_POST[own];
$own_sort=$_POST[own_sort];
$swap=$_POST[swap];

if($task=="sort_element_content_menu"){
	###zuerst die eigene sort-order überschreiben
	if($own!="" && $swap!=""){
		$updateSQL=sprintf("update element_content_menu SET sort=%u where ID=%u",
			GetSQLValueString($swap_sort,"int"),
			GetSQLValueString($own,"int"));
		$Result1=mysql_query($updateSQL) or die (mysql_error());
	}
	
	###Dann die andere sort-order überschreiben
	if($own!="" && $swap!=""){
		$updateSQL=sprintf("update element_content_menu SET sort=%u where ID=%u",
			GetSQLValueString($own_sort,"int"),
			GetSQLValueString($swap,"int"));
		$Result1=mysql_query($updateSQL) or die (mysql_error());
	}
	$task="";
	//$refresh_path=$_SERVER['REQUEST_URI'];
	//echo"<meta http-equiv=\"refresh\" content=\"0; URL=$refresh_path\" />";
}


##remove element
if($task=="remove_element_content_menu"){
	if($own!=""){
	$deleteSQL=mysql_query("delete from element_content_menu where ID='$own' limit 1") or die("delete".mysql_error());
	}
	$task="";
	//$refresh_path=$_SERVER['REQUEST_URI'];
	//echo"<meta http-equiv=\"refresh\" content=\"0; URL=$refresh_path\" />";
}

if($task=="make_manual"){
	if($teaser_make_manual_id!="" && $elem_id=$teaser_make_manual_element_id){
		create_menu_teaser($teaser_make_manual_id,$elem_id);
	}
	$task="";
}

if($task=="remove_manual"){
	if($teaser_remove_manual_id!="" && $elem_id=$teaser_remove_manual_element_id){
		mysql_query("delete from menu_teaser where id='$teaser_remove_manual_id' limit 1") or die(mysql_error());
	}
	$task="";
}

?>

<?
///////////////////////////////////Prep Queries

////load current settings
//set defaults
if($texts[1]=="" and $scope=="main" or $scope=="subcontent"){$texts[1]=1;}elseif($texts[1]=="" and $scope=="seitencontent"){$texts[1]=4;}//rowsetup ID
if($texts[2]==""){$texts[2]=1;}//img needed
if($texts[3]==""){$texts[3]=1;}//read more needed
if($texts[4]==""){$texts[4]=1;}//Einleitung needed
if($texts[5]==""){$texts[5]=1;}//Parent needed
if($texts[6]=="" and $scope=="main" or $scope=="subcontent"){$texts[6]=1;}elseif($texts[6]=="" and $scope=="seitencontent"){$texts[6]=4;}//img_pos setup ID
if($texts[7]==""){$texts[7]=1;}//selection method setup
if($texts[8]==""){$texts[8]=0;}//truncate text
if($texts[9]==""){$texts[9]=99;}//truncate length
if($texts[10]==""){$texts[10]=0;}//truncate forced
if($texts[11]==""){$texts[11]=3;}//sort1 (Startdate)
if($texts[12]==""){$texts[12]=1;}//sort 2 (create Seite)
if($texts[13]==""){$texts[13]=2;}//sort 3 create im Magazin
if($texts[14]==""){$texts[14]=2;}//depth siblings
if($texts[15]==""){$texts[15]=20;}//count entries
if($texts[16]==""){$texts[16]="false";}//text wrap
if($texts[17]=="" and $scope=="main" or $scope=="subcontent"){$texts[17]=1;}elseif($texts[17]=="" and $scope=="seitencontent"){$texts[17]=4;}//layout ID
if($texts[18]==""){$texts[18]="false";}//rollup
if($texts[19]==""){$texts[19]="false";}//thin separator

if($used_menu_id!=""){$auto_menu_id=$used_menu_id;}else{$auto_menu_id=$active_menu_id;}//to cater for the "Seitencontent"
if($texts[20]==""){$texts[20]=$auto_menu_id;}//Menu-ID für auto-selections
$auto_menu_id=$texts[20];

$img_needed=$texts[2];
$lesen_flag_needed=$texts[3];
$einleitung_needed=$texts[4];
$parent_needed=$texts[5];
$truncate_yn=$texts[8];
$truncate_length=$texts[9];
$truncate_forced=$texts[10];

$default_only="no";

//load details of setup
##rowsetup
$teaser_rowsetup_q=mysql_query("select * from menu_teaser_config_rowsetup where id=$texts[1] order by sort") or die ("rowsetup".mysql_error());
$teaser_rowsetup_r=mysql_fetch_assoc($teaser_rowsetup_q);
$teaser_col_nr[$elem_id]=$teaser_rowsetup_r[col_nr]; //vormals $col_nr
$teaser_teasercopycols[$elem_id]=$teaser_rowsetup_r[teasercopycols];//vormals $teasercopycols
$teaser_containerwidth[$elem_id]=$teaser_rowsetup_r[containerwidth];//vormals $containerwidth
$teaser_siblings_depth=$texts[14];
$teaser_count_entries=$texts[15];

##layout setup
$menu_teaser_layout_q=mysql_query("select * from menu_teaser_config_layout where id=$texts[17]") or die ("teaser layouts".mysql_error());
$menu_teaser_layout_r=mysql_fetch_assoc($menu_teaser_layout_q);
$menu_teaser_layout_is_slider=$menu_teaser_layout_r[slider_mode];

///////Darstellung der Optionen
?>
<?
//selection & sorting
list($teaser_menu_ids[$elem_id],$teaser_skipped[$elem_id],$teaser_menu_duplicate[$elem_id],$teaser_menu_ids_global,$teaser_select_auto_manual,$mru_new) = select_teaser_ids($texts[7],$auto_menu_id,$menus,$teaser_siblings_depth,$teaser_count_entries,$teaser_menu_ids_global,$img_needed,$einleitung_needed,$mru,0);

if(is_array($mru_new) and count($mru_new)>0 and $texts[7]=="6" and $scope=="seitencontent")
{
	if(is_array($mru)){$mru_len=count($mru);}
	if(is_array($mru_new)){$mru_new_len=count($mru_new);}
	if(is_array($mru)){
		$mru_to_delete=array_slice($mru,-$mru_new_len);
		$mru_keep=array_slice($mru,0,($mru_len-$mru_new_len));
	}
	if(is_array($mru_keep))
	{
		unset($mru);
		$mru=array_merge($mru_new,$mru_keep);
	}else{
		unset($mru);
		$mru=$mru_new;
	}
	?>
	<script>
		var mru_ids=new Array(<? if(is_array($mru)){echo "'".implode("','",$mru)."'";}else{}?>);
		var texts=new Array(<? echo "'".implode("','",$texts)."'";?>);
		var texts_id=new Array(<? echo "'".implode("','",$texts_id)."'";?>);
		var used_menu_id="<? echo $auto_menu_id;?>";
		var menus=new Array(<? echo "'".implode("','",$menus)."'";?>);
		var elem_id="<? echo $elem_id;?>";
	</script>
<? }
if($texts[7]=="6"){$texts[11]=0;$texts[12]=0;$texts[13]=0;}//wenn "recent" als Auswahl verwendet wurde, dann ist die Sortierreihenfolge fix "keep".
list($teaser_menu_ids[$elem_id],$teaser_sorting[$elem_id],$teaser_element_content_menu_id[$elem_id]) = sort_teaser_ids($teaser_menu_ids[$elem_id],$elem_id,$texts[11],$texts[12],$texts[13],$teaser_select_auto_manual);

$teaser_number_menus[$elem_id]=count($teaser_menu_ids[$elem_id]);
?>
<?
teaser_setup($elem_id,$texts,$texts_id,$menus,$teaser_select_auto_manual,$teaser_skipped[$elem_id],$teaser_menu_duplicate[$elem_id]);

///////////////////////display section starts
$clipping_box_q=mysql_query("select * from menu_teaser_config_rowsetup_X_img_pos where img_pos_id='$texts[6]' and rowsetup_id='$texts[1]'");
$clipping_box_r=mysql_fetch_assoc($clipping_box_q);

$teaser_img_pos_q=mysql_query("select * from menu_teaser_config_img_pos where id='$texts[6]'");
$teaser_img_pos_r=mysql_fetch_assoc($teaser_img_pos_q);

if($menu_teaser_layout_is_slider!=0)//Wenn es ein slider ist wird die angegebene clipping-box und die teaser_containerwidth um 48px reduziert. 
{
	$clipping_box_r[width]=$clipping_box_r[width]-(48/$teaser_col_nr[$elem_id]);//48px is die Breite der beiden Tasten
	$teaser_containerwidth[$elem_id]=$teaser_containerwidth[$elem_id]-(48/$teaser_col_nr[$elem_id]);
}

if($clipping_box_r[width]>0){$teaser_clipping_width=$clipping_box_r[width];}else{$teaser_clipping_width=$teaser_containerwidth[$elem_id];} // die clipping box hat entweder eine eigene Angabe oder ist so groß wir die containerbreite.
if($clipping_box_r[height]>0){$teaser_clipping_height=$clipping_box_r[height];}else{$teaser_clipping_height=$teaser_clipping_width/7*4;} // die clipping box hat entweder eine eigene Angabe oder ist so groß wir die containerbreite/7*4.


if($texts[16]=="false")//textwrap=false
{	
	if($img_needed==1)
	{
		$imgspacer=$teaser_img_pos_r[textbox_distance]+max($clipping_box_r[width],0);//85
		$texte_container_width=$teaser_containerwidth[$elem_id]-$imgspacer;
		$texte_container_style="width:".$texte_container_width."px;float:$teaser_img_pos_r[textbox_float];";
	}
	else
	{
		$texte_container_width=$teaser_containerwidth[$elem_id];
		$texte_container_style="width:100%;";
	}
}

if($teaser_img_pos_r[text_overlaps]==1){$img_needed=1;$parent_needed=0;$einleitung_needed=0;$lesen_flag_needed=0;}
?>
<style>
		#container {
			/*width:572px;*/
			/*padding:10px;*/
			margin:0 auto;
			position:relative;
			/*z-index:0;*/
			float:left;
			width:100%;
		}
		
		/*
			Slideshow style
		*/
		
		.slides {
			/*position:absolute;*/
			top:0px;
			left:0px;
			z-index:100;
		}
		
		/*
			Slides container
			Important:
			Set the width of your slides container
			If height not specified height will be set by the slide content
			Set to display none, prevents content flash
		*/
		
		.slides_container {
			width:572px;
			/*height:270px;*/
			overflow:hidden;
			position:relative;
			/*display:none;*/
			float:left;
		}
		
		/*
			Each slide
			Important:
			Set the width of your slides
			Offeset for the 20px of padding
			If height not specified height will be set by the slide content
			Set to display block
		*/
		
		.slides .slide {
			/*padding:20px;*/
			width:572px;
			/*height:130px;*/
			display:block;
			/*background-color:#CCCCCC;*/
		}
		
		/*
			Pagination
		*/
		
		.pagination {
			margin:10px auto 0;
			width:100px;
			padding:0px;
			clear:both;
		}
		
		.pagination li {
			float:left;
			margin:0 1px;
			list-style:none;
		}
		
		.pagination li a {
			display:block;
			width:12px;
			height:0;
			padding-top:12px;
			background-image:url(/site_12_1/css/pagination.png);
			background-position:0 0;
			float:left;
			overflow:hidden;
		}
		
		.pagination li.current a {
			background-position:0 -12px;
		}
	</style>
<div id="teaser_content_<? echo $elem_id;?>">
	<?
	if($menu_teaser_layout_is_slider>0)
	{?>
		<div id="container" name="overall_container_<? echo $elem_id;?>" style="float:left;">
			<div class="slides" id="slides_<? echo $elem_id;?>">
			<div name="leftnavi_<? echo $elem_id;?>" style="width:23px; float: left; position: relative;right:4px;overflow:hidden;"></div>
				<div name="container_<? echo $elem_id;?>" class="slides_container"><?
	} 
	else 
	{?>
		<div name="overall_container_<? echo $elem_id;?>">
			<div>
				<div>
			<? }//Ende des obersetn slide setups. ?>
			<?
			for ($anz=0,$anz_limit=count($teaser_menu_ids[$elem_id]);$anz<$anz_limit;$anz++)
			{
				$teaser_counter[$elem_id]=0;
			
			?><div class="slide_<? echo $elem_id;?>">
					<? do
					{
						$teaser_counter[$elem_id]=$teaser_counter[$elem_id]+1;
					
						$teaser_head_arr=teaser_text($teaser_menu_ids[$elem_id][$anz],"Titel",0,$elem_id);
						$teaser_head=$teaser_head_arr[text];
						
						switch($teaser_head_arr[source])
						{
							case "menu_teaser_own_element": $content_editing_mode="edit_entry"; break;
							case "menu_teaser_foreign_element":  $content_editing_mode="duplicate_mode"; break;
							case "menu_teaser_default_element":  $content_editing_mode="duplicate_mode"; break;
							case "text":  $content_editing_mode="duplicate_mode"; break;
							case "metadata":  $content_editing_mode="duplicate_mode"; break;
							default: $content_editing_mode="create_mode";
						}
						if($menu_teaser_layout_is_slider==1){$content_editing_mode="duplicate_mode";}
		
						$teaser_menu_teaser_id=$teaser_head_arr[id];
						$teaser_editor=$teaser_head_arr[editor];
						
						if($einleitung_needed==1)
						{
							if($truncate_yn==0){$truncate_length=0;}
							elseif($content_editing_mode=="edit_entry" && $truncate_forced==0){$truncate_length=0;}
							
							$teaser_copy_arr=teaser_text($teaser_menu_ids[$elem_id][$anz],"Copy",$truncate_length,$elem_id);
							$teaser_copy=$teaser_copy_arr[text];
						}
						
						if($img_needed==1)
						{
							$teaser_asset_arr=teaser_bild($teaser_menu_ids[$elem_id][$anz],$teaser_clipping_width,$elem_id);
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
		
							if($teaser_v_offset_percent===NULL){$teaser_v_offset_percent=0.5;}
							$teaser_v_offset=($teaser_clipping_height-($teaser_clipping_width/$teaser_imgs_breite*$teaser_imgs_hoehe))*$teaser_v_offset_percent;
							
							if($teaser_h_offset_percent!==NULL){$teaser_h_offset_percent=0.5;}
							$asset_h_offset=($teaser_clipping_width-($teaser_clipping_height/$teaser_imgs_hoehe*$teaser_imgs_breite))*$teaser_h_offset_percent;
						}
					
						if($parent_needed==1)
						{
							$teaser_parent_id=find_parent($teaser_menu_ids[$elem_id][$anz]);
							$teaser_parent_url=find_googleurl($teaser_parent_id);
							$teaser_parent_description=find_description($teaser_parent_id);
						}
					
						$teaser_url = find_googleurl($teaser_menu_ids[$elem_id][$anz]);
						
						?>
						<div name="teaser_management_box_<? echo $elem_id;?>" style="width:<? echo $teaser_containerwidth[$elem_id]."px";?>; float:left;"> 
							<? if($menu_teaser_layout_is_slider!=1){?>
								<div name="config_box" style="float:right;">
									<div style="float:right"><img src='/site_12_1/css/Element_subcontent_rechts.png' border='0' height='19px'></div>
									<div style='height:19px; position:relative; z-index:1000; float:right;'><img class="bg_image_scale" src="/site_12_1/css/Element_subcontent_taste_Mitte.png"/>
										<div name="config_box_middle" style="height:17px; float:left;position:relative; z-index:2000;padding-top:2px;padding-left:2px; padding-right:2px;" title="<? echo "Quelle des Inhalts: ".$teaser_head_arr[source]." Quelle des Bildes: ".$teaser_asset_arr[source];?>">
											<div name="config_box_id" style="float:left;">
												<? echo "ID: ".$teaser_menu_ids[$elem_id][$anz];?>
											</div>
										</div>
										<div name="config_box_middle_functions" style="float:left;">
											<?
											if($teaser_select_auto_manual=="manual")//Manuelle Auswahl = manuelles sorting, Eintrag kann gelöscht werden und active warning
											{
												//hier kommen die Sortierbuttons rein.
												//zuerst die sort-Funktionen vorbereiten
												$teaser_element_content_own_id=$teaser_element_content_menu_id[$elem_id][$anz];
												$teaser_element_content_next_id=$teaser_element_content_menu_id[$elem_id][$anz+1];
												$teaser_element_content_prev_id=$teaser_element_content_menu_id[$elem_id][$anz-1];
												
												$teaser_element_content_own_sort=$teaser_sorting[$elem_id][$anz];
												$teaser_element_content_next_sort=$teaser_sorting[$elem_id][$anz+1];
												$teaser_element_content_prev_sort=$teaser_sorting[$elem_id][$anz-1];
												
												///jetzt Warnflags: bei Manual kann es sein, dass ein Artikel nicht aktiv ist. Bei Auto kann es sein, dass nicht alle Elemente vorab geprüft werden.
												if($menus_active[$anz+1]=="A" and (($menus_start[$anz+1]<$date or $menus_start[$anz+1]=="0000-00-00") and ($menus_end[$anz+1]>$date or $menus_end[$anz+1]=="0000-00-00"))){} 
												else {?>
													<div style="height:17px; float:left; position:relative; z-index:2000; padding-top:1px;" title="ACHTUNG: Wird nicht angezeigt! Menüeintrag ist nicht aktiv, oder nicht im freigeschaltenen Datumsbereich."><a href="/site_12_1/admin/papa/menu.php?men_id=<? echo $menus_parent[$anz]?>"><img src="/site_12_1/css/Attention_small.png" height="16px"/></a></div>
												<? }
												
												if(
													($teaser_head!="")//test_id=menu_id, test_type=element_layout_description (zB "Titel"), truncate= wenn>0 wird der Text abgeschnitten nach x Zeichen, sonst nicht
													and ($teaser_copy!="" or $einleitung_needed==0) //test_id=menu_id, test_type=element_layout_description (zB "Copy"), truncate= wenn>0 wird der Text abgeschnitten nach x Zeichen, sonst nicht
													and ($teaser_asset_id>0 or $img_needed==0)//testet of ein Bild, das nicht das default-Bild ist, vorhanden ist.
												){} else {?>
													<div style="height:17px; float:left; position:relative; z-index:2000; padding-top:1px;" title="ACHTUNG: Wird nicht angezeigt! Es sind nicht alle Elemente vorhanden."><img src="/site_12_1/css/Attention_small.png" height="16px"/></div>
												<? }
												
												//dann die sort funktionen anzeigen?>
												<? if($anz > 0 and $teaser_number_menus[$elem_id] > 1)?>
													<div style="height:17px; float:left;">
														<? {?>
														<form action="<? echo $_SERVER['REQUEST_URI'];?>" method="post" target="_self">
															<input type="hidden" name="task" value="sort_element_content_menu">
															<input type="hidden" name="own" value="<? echo $teaser_element_content_own_id ;?>">
															<input type="hidden" name="own_sort" value="<? echo $teaser_element_content_own_sort ;?>">
															<input type="hidden" name="swap" value="<? echo $teaser_element_content_prev_id ;?>">
															<input type="hidden" name="swap_sort" value="<? echo $teaser_element_content_prev_sort ;?>">
															<input type="image" src="/site_12_1/css/button_up.png" style="height:17px; position:relative; z-index:2000;" title="Der Eintrag wird eines höher sortiert.">
														</form>
													</div>
												<? }?>
												<? if($anz < $teaser_number_menus[$elem_id]-1 and $teaser_number_menus[$elem_id] > 1){?> 
													<div style="height:17px; float:left;">
													<form action="<? echo $_SERVER['REQUEST_URI'];?>" method="post" target="_self">
														<input type="hidden" name="task" value="sort_element_content_menu">
														<input type="hidden" name="own" value="<? echo $teaser_element_content_own_id ;?>">
														<input type="hidden" name="own_sort" value="<? echo $teaser_element_content_own_sort ;?>">
														<input type="hidden" name="swap" value="<? echo $teaser_element_content_next_id ;?>">
														<input type="hidden" name="swap_sort" value="<? echo $teaser_element_content_next_sort ;?>">
														<input type="image" src="/site_12_1/css/button_down.png" style="height:17px; position:relative; z-index:2000;" title="Der Eintrag wird eines runter sortiert.">
													</form>	
													</div>
												<? }
												// Eintrag aus der element_content_menu löschen (quasi ohne den menu_id_selector zu bemühen?>		     
												<div style="height:17px; float:left;">
													<form action="<? echo $_SERVER['REQUEST_URI'];?>" method="post" target="_self">
														<input type="hidden" name="task" value="remove_element_content_menu">
														<input type="hidden" name="own" value="<? echo $teaser_element_content_own_id ;?>">
														<input type="image" src="/site_12_1/css/button_delete.png" style="height:17px; position:relative; z-index:2000;" title="Der Eintrag wird aus der manuellen Auswahl entfernt - ohne den Menu-ID-selector zu öffnen.">
													</form>	
												</div>
											<? }
											if($content_editing_mode!="edit_entry")//Quelle ist nicht das eigene Element, es kann also angelegt werden.
											{?>
												<div style="height:17px; float:left;">
													<form action="<? echo $_SERVER['REQUEST_URI'];?>" method="post" target="_self">
														<input type="hidden" name="task" value="make_manual">
														<input type="hidden" name="teaser_make_manual_element_id" value="<? echo $elem_id;?>">
														<input type="hidden" name="teaser_make_manual_id" value="<? echo $teaser_menu_ids[$elem_id][$anz];?>">
														<input type="image" src="/site_12_1/css/button_add.png" style="height:17px; position:relative; z-index:2000;" title="Die h&auml;ndische Bearbeitung wird m&ouml;glich gemacht.">
													</form>
												</div>
											<? }
											if($content_editing_mode=="edit_entry")//Quelle ist nicht das eigene Element, der Inhalt kann also resettet werden.
											{?>
												<div style="height:17px; float:left;">
													<form action="<? echo $_SERVER['REQUEST_URI'];?>" method="post" target="_self">
														<input type="hidden" name="task" value="remove_manual">
														<input type="hidden" name="teaser_remove_manual_element_id" value="<? echo $elem_id;?>">
														<input type="hidden" name="teaser_remove_manual_id" value="<? echo $teaser_menu_teaser_id;?>">
														<input type="image" src="/site_12_1/css/button_delete_content.png" style="height:17px; position:relative; z-index:2000;" title="Die manuelle Bearbeitung des Inhaltes wird gelöscht.">
													</form>
												</div>
											<? }
											?>
										</div>
									</div>		
									<div style="float:right"><img src='/site_12_1/css/Element_subcontent_links.png' border='0' height='19px'></div>
								</div>
								<div style="clear:both;"></div>
							<? }?>
							<div name="teaser_box" style="width:<? echo $teaser_containerwidth[$elem_id];?>px; position:relative; background-color:<? echo $teaser_backgroundcolor;?>; <? if($teaser_img_pos_r[text_overlaps]==1){echo "height:".$teaser_clipping_height."px;";} ?>">
								<?
								if($content_editing_mode=="edit_entry")// es handelt sich um einen editierbaren Eintrag
								{
									if($img_needed==1)
									{
										$imgrandom = rand(1000000000,9999999999);
										$clipping_aspect=$teaser_clipping_width/$teaser_clipping_height;
										$imgs_aspect=$teaser_imgs_breite/$teaser_imgs_hoehe;
										$slider_name="slider_".$teaser_menu_ids[$elem_id][$anz]."_".$imgrandom;
										if($imgs_aspect<=$clipping_aspect)
										{//Bild ist länglicher als clipping box = Vertikaler Slider
											$output_hoehe=$teaser_clipping_width/$teaser_imgs_breite*$teaser_imgs_hoehe;
											$top_crop=($teaser_clipping_height-$output_hoehe)/2;								
											require_once($_SERVER['DOCUMENT_ROOT'].'site_12_1/admin/slider.php');//den darf ich erst hier laden!
											?>
											<div class="teaser_image_config" style="float:left;width:<? echo $teaser_clipping_width+$teaser_img_pos_r[textbox_distance]; ?>px;height:<? echo $teaser_clipping_height?>px;"> <!--container box-->
												<div class="teaser_image" style="width:<? echo $teaser_clipping_width?>px; float:left;"> <!--image-->
													 <div style='float:left;width:<? echo $teaser_clipping_width?>px; height:<? echo $teaser_clipping_height?>px;overflow:hidden'>
														<div id="img_vertical_<?php echo $slider_name?>" style="position:relative; top:<? echo $teaser_v_offset;?>px;z-index:1;"> 
															<div style="height:<? echo $output_hoehe;?>px">
																<? $row_id=$slider_name;
																$imgs_type[$row_id]=$teaser_imgs_type;
																$assets_id[$row_id]=$teaser_asset_id; 
																$imgs_id[$row_id]=$teaser_menu_teaser_id_img; 
																$filename[$row_id]=$teaser_filename;
																$path[$row_id]=$teaser_path; 
																$imgs_category[$row_id]=$teaser_category;
																$imgs_class[$row_id]=$teaser_class;
																$imgs[$row_id]=$teaser_imgs_url;
																$imgs_scale_to_fit[$row_id]='true';
																$imgs_table[$row_id]='menu_teaser';
																$no_class=1;
																include("$adminpath/site_12_1/admin/admin_imageeditor.php");
																?>
															</div>
														</div>
													 </div>      
												</div>
												<div class="teaser_slider" style="width:0px; float:left;position:relative;right:19px;z-index:2;"> <!--vertical slider-->
													  <form method="get" name="form_<? echo $teaser_menu_ids[$elem_id][$anz];?>">
													  <input type="hidden" name="vertical_<?php echo $slider_name;?>" id="vertical_<?php echo $slider_name;?>" size="3">
													  <script language="JavaScript">
														   var A_TPL = {
																'b_vertical' : true,
																'b_watch': true,
																'n_controlWidth': 16,
																'n_controlHeight': <? echo 1*$teaser_clipping_height;?>,
																'n_sliderWidth': 15,
																'n_sliderHeight': 16,
																'n_pathLeft' : 1,
																'n_pathTop' : 1,
																'n_pathLength' : <? echo 1*$teaser_clipping_height;?>-17,
																's_imgControl': '/site_12_1/assets/img/adminarea/slider_imgs/sldr2v_bg.gif',
																's_imgSlider': '/site_12_1/assets/img/adminarea/slider_imgs/sldr2v_sl.gif',
																'n_zIndex': 1,
																'n_menu_teaser_id': '<? echo $teaser_menu_teaser_id;?>',
																'n_img_height': '<? echo $teaser_imgs_hoehe;?>',
																'n_img_width': '<? echo $teaser_imgs_breite;?>',
																'n_clipping_height': '<? echo $teaser_clipping_height;?>',
																'n_clipping_width': '<? echo $teaser_clipping_width;?>'
														   }
														   var A_INIT = {
																's_form' : 'form_<? echo $teaser_menu_ids[$elem_id][$anz];?>',
																's_name': 'vertical_<?php echo $slider_name?>',
																'n_minValue' : 0,
																'n_maxValue' : -1*<?php echo 1*$top_crop*2;?>,
																'n_value' : -1*<?php echo 1*$teaser_v_offset;?>,
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
											$output_breite=$teaser_clipping_height/$teaser_imgs_hoehe*$teaser_imgs_breite;
											$left_crop=($teaser_clipping_width-$output_breite)/2;
											require_once($_SERVER['DOCUMENT_ROOT'].'site_12_1/admin/slider.php');//den darf ich erst hier laden!
										
											?>
											<div class="teaser_image_config" style="float:left;width:<? echo $teaser_clipping_width+$teaser_img_pos_r[textbox_distance]?>px;height:<? echo $teaser_clipping_height?>px;"> <!--container box-->
												<div class="teaser_image" style="height:<? echo $teaser_clipping_height?>px; float:left;"> <!--image-->
													 <div style='float:left;width:<? echo $teaser_clipping_width?>px; height:<? echo $teaser_clipping_height?>px;overflow:hidden'>
														<div id="img_horizontal_<?php echo $slider_name?>" style="position:relative; left:<? echo $teaser_h_offset;?>px;z-index:1;"> 
															<div style="width:<? echo $output_breite;?>px">
																<? $row_id=$slider_name;
																$imgs_type[$row_id]=$teaser_imgs_type;
																$assets_id[$row_id]=$teaser_asset_id; 
																$imgs_id[$row_id]=$teaser_menu_teaser_id_img; 
																$filename[$row_id]=$teaser_filename;
																$path[$row_id]=$teaser_path; 
																$imgs_category[$row_id]=$teaser_category;
																$imgs_class[$row_id]=$teaser_class;
																$imgs[$row_id]=$teaser_imgs_url;
																$imgs_scale_to_fit[$row_id]='true';
																$imgs_table[$row_id]='menu_teaser';
																$no_class=1;
																include("$adminpath/site_12_1/admin/admin_imageeditor.php");
																?>
															</div>
														</div>
													 </div>      
												</div>
												<div class="teaser_slider" style="height:17px; float:left;position:relative;bottom:19px;z-index:2"> <!--horizontal slider-->
													<form method="get" name="form_<? echo $teaser_menu_ids[$elem_id][$anz];?>">
													<input type="hidden" name="horizontal_<?php echo $slider_name;?>" id="horizontal_<? echo $slider_name;?>" size="3">
													<script language="JavaScript">
														var A_TPL = {
															'b_vertical' : false,
															'b_watch': true,
															'n_controlWidth': <? echo 1*$teaser_clipping_width;?>,
															'n_controlHeight': 16,
															'n_sliderWidth': 15,
															'n_sliderHeight': 16,
															'n_pathLeft' : 1,
															'n_pathTop' : 1,
															'n_pathLength' : <? echo 1*$teaser_clipping_width;?>-17,
															's_imgControl': '/site_12_1/assets/img/adminarea/slider_imgs/sldr2h_bg.gif',
															's_imgSlider': '/site_12_1/assets/img/adminarea/slider_imgs/sldr2h_sl.gif',
															'n_zIndex': 1,
															'n_menu_teaser_id': '<? echo $teaser_menu_teaser_id;?>',
															'n_img_height': '<? echo $teaser_imgs_hoehe;?>',
															'n_img_width': '<? echo $teaser_imgs_breite;?>',
															'n_clipping_height': '<? echo $teaser_clipping_height;?>',
															'n_clipping_width': '<? echo $teaser_clipping_width;?>'
														}
														var A_INIT = {
															's_form' : 'form_<? echo $teaser_menu_ids[$elem_id][$anz];?>',
															's_name': 'horizontal_<?php echo $slider_name?>',
															'n_minValue' : <?php echo 1*$left_crop*2;?>,
															'n_maxValue' : 0,
															'n_value' : <?php echo 1*$asset_h_offset;?>,
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
									?>
									<div id="texte_container" style=' <? echo $texte_container_style;?>'>
										<? if($teaser_img_pos_r[text_overlaps]==1){?>
											<div name="grey"style="position:absolute;bottom:0px;padding-bottom:5px;padding-right:5px; padding-left:5px; padding-top:2px; width:<? echo $teaser_containerwidth[$elem_id]-10;?>px">
											<div class="grey"></div>
										<? }?>
										<div style="z-index:1;<? if($teaser_img_pos_r[text_overlaps]==1){echo "position:relative;";}?>">
											<? if($parent_needed==1){?>
												<a href='<? echo $teaser_parent_url;?>' class="teaser_parent"><? echo $teaser_parent_description;?></a>
												<br>
											<? }?>
											
											<? $field="teaser_head"; $table="menu_teaser"; $row_id="1"; $TXT_breite=$teaser_containerwidth[$elem_id]-5*$teaser_col_nr[$elem_id]; $rows="1"; $FCK_breite="700"; $texts[1]=$teaser_head; if($teaser_img_pos_r[text_overlaps]==1){$texts_style[1]="$clipping_box_r[textbox_style_head_grey]";}else{$texts_style[1]="$clipping_box_r[textbox_style_head]";} $texts_id[1]=$teaser_menu_teaser_id; $editors[1]=$teaser_editor; include("$adminpath/site_12_1/admin/admin_editor.php")?>
										
											<? if($einleitung_needed==1){?>
												<div style='height:1px;'>&nbsp;</div>
												<? $field="teaser_copy"; $table="menu_teaser"; $row_id="1"; $TXT_breite=$teaser_containerwidth[$elem_id]-5*$teaser_col_nr[$elem_id]; $rows="1"; $FCK_breite="700"; $texts[1]=$teaser_copy; $texts_style[1]='teasertext'; $texts_id[1]=$teaser_menu_teaser_id; $editors[1]=$teaser_editor; include("$adminpath/site_12_1/admin/admin_editor.php")?>
											<? }?>
										
											<? if($lesen_flag_needed==1){?>
												<div style='height:8px;'>&nbsp;</div>
												<a href='<? echo $teaser_url;?>' class='teasertext'>&raquo; Artikel lesen</a>
											<? }?>
										</div>
									</div>
									<? if($teaser_img_pos_r[text_overlaps]==1){?></div><? }?>
									<div style='clear:left'></div>
								<? }
								if($content_editing_mode!="edit_entry")// es handelt sich um einen nicht editierbaren Eintrag
								{
									if($img_needed=="1")
									{
										$clipping_aspect=$teaser_clipping_width/$teaser_clipping_height;
										$imgs_aspect=$teaser_imgs_breite/$teaser_imgs_hoehe;
										$slider_name="slider_".$teaser_menu_ids[$elem_id][$anz]."_".$imgrandom;
										if($imgs_aspect<=$clipping_aspect)
										{//Bild ist länglicher als clipping box
											$output_hoehe=$teaser_clipping_width/$teaser_imgs_breite*$teaser_imgs_hoehe;
											$top_crop=($teaser_clipping_height-$output_hoehe)/2;
											?>
											<div style="float:left;width:<? echo $teaser_clipping_width+$teaser_img_pos_r[textbox_distance]; ?>px;height:<? echo $teaser_clipping_height?>px;"> <!--container box1-->
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
										elseif($imgs_aspect>$clipping_aspect)
										{//Bild ist hochformatiger als clipping box
											$output_breite=$teaser_clipping_height/$teaser_imgs_hoehe*$teaser_imgs_breite;
											$left_crop=($teaser_clipping_width-$output_breite)/2;
											?>
											<div style="float:left;width:<? echo $teaser_clipping_width+$teaser_img_pos_r[textbox_distance]?>px;height:<? echo $teaser_clipping_height?>px;"> <!--container box-->
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
									
										<div id="texte_container" style=' <? echo $texte_container_style;?>'>
											<? if($teaser_img_pos_r[text_overlaps]==1){?>
												<div name="grey"style="position:absolute;bottom:0px;padding-bottom:5px;padding-right:5px; padding-left:5px; padding-top:2px; width:<? echo $teaser_containerwidth[$elem_id]-10;?>px">
												<div class="grey"></div>
											<? }?>
											<div style="z-index:1;<? if($teaser_img_pos_r[text_overlaps]==1){echo "position:relative;";}?>">
												<? if($teaser_head!="")
												{?>
													<? if($parent_needed==1){?>
														<a href='<? echo $teaser_parent_url;?>'class="teaser_parent"><? echo $teaser_parent_description;?></a>
														<br>
													<? }?>
													
													<a href='<? echo $teaser_url;?>' <? if($teaser_img_pos_r[text_overlaps]==1){echo "class='$clipping_box_r[textbox_style_head_grey]'";}else{echo "class='$clipping_box_r[textbox_style_head]'";}?>><? echo $teaser_head;?></a>
													
													<? if($einleitung_needed==1){?>
														<div style='height:1px;'>&nbsp;</div>
														<a href='<? echo $teaser_url;?>' class='teasertext'><? echo $teaser_copy;?></a>
													<? }?>
													
													<? if($lesen_flag_needed==1){?>
														<div style='height:8px;'>&nbsp;</div>
														<a href='<? echo $teaser_url;?>' class='teasertext'>&raquo; Artikel lesen</a>
													<? }?>
												<? } 
												else {
													if(substr(trace(),0,5)=="admin"){echo "Weder Titel-Element noch Metatag Title für Menu_ID $teaser_test_menu_id gefunden.";}
												}?>
											</div>
										</div>
									<? if($teaser_img_pos_r[text_overlaps]==1){?></div><? }?>
									<div style='clear:left'></div>
								<? }
								?>
							</div>
						</div>
						<div id='spacer' class='teaser_spacer'></div>
						<? 
						$anz=$anz+1;
					} while ($teaser_counter[$elem_id]<$teaser_col_nr[$elem_id] and $anz<$anz_limit);//hier wird die Schleife der Zeile geschlossen.
					$anz=$anz-1;
		
					if($menu_teaser_layout_is_slider!=1 && $anz<$anz_limit){?><div style="clear:both;"></div><? }?>
				</div>
				<? if($menu_teaser_layout_is_slider!=1 && $anz<$anz_limit-1){?><div name="teaser_trenner" style='width:100%;height:1px;float:left;'class='trenner'></div><? }?>
			<?
			}//Schleife Ende for all Menu ids
			?>
			
		</div>
		<?	if($menu_teaser_layout_is_slider>0)
			{?><div name="leftnavi_<? echo $elem_id;?>" style="width:23px; float: left; position: relative;left:4px;overflow:hidden;"></div><? }?>
		</div>
	</div>
</div>


<div style="clear:both"></div>
<div id="rollup_<? echo $elem_id;?>"></div> 

<?
if($texts[7]=="6" and $scope=="seitencontent"){
	//Auswahl = recent, es wird immer aktualisiert. 
	?>
	<div id="mru_response_hidden" style="display:none"></div>
	<script>
		var max_count="<? echo $teaser_count_entries;?>";
	
		function refresh_mru(mru_ids,texts,texts_id,used_menu_id,menus,elem_id,initiate)
		{
			url="/site_12_1/admin/includes/admin_teaser_mgt.php";

			$.ajax({
				type: "POST",
				url:  url,
				data: { 
					mru:mru_ids,
					texts:texts,
					texts_id:texts_id,
					used_menu_id:used_menu_id,
					menus:menus,
					elem_id:elem_id,
					menu_id:used_menu_id,
					initiate:initiate,
					css_is_included:"1",
					scope:"<? echo $scope;?>"
					},
				success: function(result)
				{
				   	$('#mru_response_hidden').html(result);
					$(document).ready(function(e) {
						count_new=$('#mru_response_hidden').find('.slide_<? echo $elem_id;?>').length;
						existing=$('#teaser_content_<? echo $elem_id;?>').find('.slide_<? echo $elem_id;?>');
						count_existing=existing.length;
						
						count_delete=Math.max(0,count_new+count_existing-max_count);
						count_add_overhang=Math.max(0,count_new-count_delete);
						count_delete_overhang=Math.max(0,count_delete-count_new);
						count_both=count_new-count_add_overhang;
						
						var	add_target=$('#teaser_content_<? echo $elem_id;?>  > > >');

						if(count_add_overhang>0)
						{
							for(var neu=1;neu<=count_add_overhang;neu++)
							{alert("wrong1");
								step=count_add_overhang-neu;
								add_entry=$('#mru_response_hidden .slide_<? echo $elem_id;?>').eq(step);
								add_entry.hide();
								add_target.prepend($("<div name='teaser_trenner' style='width:100%;height:1px;float:left;'class='trenner'></div>"));
								add_entry.prependTo(add_target);
								add_entry.slideDown("slow");
							}
						}
						
						for(var both=1;both<=count_both;both++)
						{
							step=count_both-both;
							add_entry=$('#mru_response_hidden .slide_<? echo $elem_id;?>').eq(step);
							add_entry.hide();
							add_target.prepend($("<div name='teaser_trenner' style='width:100%;height:1px;float:left;'class='trenner'></div>"));
							add_entry.prependTo(add_target);

							theQueue=$({});
							theQueue.queue("both_"+both,function(next)
							{
								add_entry.slideDown("slow");
								add_target.children().eq(max_count*2).slideUp("slow",function(){$(this).remove();});
								add_target.children().eq(max_count*2-1).slideUp("slow",function(){$(this).remove();});
								
								next();
							});
							theQueue.dequeue("both_"+both); 
						}
												
						if("<? echo $scope?>"=="seitencontent"){seitenconfig_middle_functions();}
						if("<? echo $texts[19]?>"=="true"){thin_separator();}
						
						$('#mru_response_hidden').html("")	
					});
				}
			});
		}
	</script>
	<?
	if($initiate ==""){?>
	<script>
		setInterval(function(){refresh_mru(mru_ids,texts,texts_id,used_menu_id,menus,elem_id,"1");},5000);
	</script>
	<? };

}
?>

<? if ($scope=='seitencontent'){//fade in controls?>
<script>
	function seitenconfig_middle_functions()
	{
		$("[name='config_box_middle_functions']").hide();
		$("[name='config_box']").hover(
		function(){$(this).css("width","163px").find("[name='config_box_middle_functions']").show();},
		function(){$(this).css("width","auto").find("[name='config_box_middle_functions']").hide();})
	}
	seitenconfig_middle_functions();
</script>
<? }?>

<? if($texts[19]=="true"){//thin separator?>
<script>
	function thin_separator()
	{
		$("[name='teaser_trenner']").css("margin-top","2px").css("margin-bottom","2px");
	}
	thin_separator();
</script>
<? }?>

<? if($menu_teaser_layout_is_slider==1){//slider setup?>
	<script>
		$(document).ready(function () {
			$("[name='leftnavi_<? echo $elem_id;?>']").first().append("<a href='#' class='prev'><img src='/site_12_1/css/arrow-prev.png' width='24' height='43' alt='Arrow Prev'></a>");
			$("[name='leftnavi_<? echo $elem_id;?>']").last().append("<a href='#' class='next'><img src='/site_12_1/css/arrow-next.png' width='24' height='43' alt='Arrow Next'></a>");
			if($(".slide_<? echo $elem_id;?>").length<2)
			{maxHeight=<? echo $teaser_clipping_height;?>}
			else
			{
				$("[name='teaser_management_box_<? echo $elem_id;?>']").css("height","auto");
				var maxHeight = Math.max.apply(null, $("[name='teaser_management_box_<? echo $elem_id;?>']").map(function ()
				{
					return Math.max(43,$(this).height());
				}).get());
			}
			$("#slides_<? echo $elem_id;?> .slide_<? echo $elem_id;?>").css("height",maxHeight);//setzt die Höhe des Banners, so dass alle Bilder gleich sind.
			$("#slides_<? echo $elem_id;?> .slides_container").css("height",(maxHeight));//setzt die Höhe des Containers
			
			$("[name='leftnavi_<? echo $elem_id;?>']").css("height",$("[name='overall_container_<? echo $elem_id;?>']").height());
			$("[name='leftnavi_<? echo $elem_id;?>'] img").css("position","relative").css("top",$("[name='overall_container_<? echo $elem_id;?>']").height()/2-28);
			$("[name='overall_container_<? echo $elem_id;?>']").css("height",(maxHeight)+22);//setzt die Höhe des Containers inkl. den Navi-Punkten
		});
		$(function(){
			$('#slides_<? echo $elem_id;?>').slides({
				preload: true,
				preloadImage: '/site_12_1/css/wait.gif',
				play: 5000,
				pause: 2500,
				hoverPause: true,
				generatePagination: true,
			});
			$('.pagination').css("width",$('.pagination').children().length*14).css("position","relative").css("top","8px");//zentriert die Navipunkte in die Mitte
		});	
	</script>
<? }?>
<? if($menu_teaser_layout_is_slider==2){//slider-preview setup?>
	<script>
		$(document).ready(function () {
			$("[name='leftnavi_<? echo $elem_id;?>']").first().css("border-right-style","dashed").css("border-right-color","#999999").css("border-right-width","thin").css("background-color","#eeeeee")
			$("[name='leftnavi_<? echo $elem_id;?>']").first().append("<img src='/site_12_1/css/arrow-prev.png' width='24' height='43' alt='Arrow Prev'>");
			$("[name='leftnavi_<? echo $elem_id;?>']").last().css("border-left-style","dashed").css("border-left-color","#999999").css("border-left-width","thin").css("background-color","#eeeeee")
			$("[name='leftnavi_<? echo $elem_id;?>']").last().append("<img src='/site_12_1/css/arrow-next.png' width='24' height='43' alt='Arrow Next'>");
			if($(".slide_<? echo $elem_id;?>").length<2)
			{maxHeight=<? echo $teaser_clipping_height;?>}
			else
			{
				var maxHeight = Math.max.apply(null, $("[name='teaser_management_box_<? echo $elem_id;?>']").map(function ()
				{
					return Math.max(43,$(this).height());
				}).get());
			}
			$("#slides_<? echo $elem_id;?> .slide").css("height",maxHeight);//setzt die Höhe des Banners, so dass alle Bilder gleich sind.
			$("[name='leftnavi_<? echo $elem_id;?>']").css("height",$("[name='overall_container_<? echo $elem_id;?>']").height());
			$("[name='leftnavi_<? echo $elem_id;?>'] img").css("position","relative").css("top",$("[name='overall_container_<? echo $elem_id;?>']").height()/2-28);
		});
	</script>
<? }?>

<? if($texts[18]=="true"){//rollup?>
<script>
		
	$(document).ready(function () {
		$('#rollup_<? echo $elem_id;?>').html("<div id='rollup_controller' style='margin-top:5px; background-color: #eeeeee; text-align:center;font-size: 9px;color: #666666;height:14px;cursor:pointer;'><img style='vertical-align:bottom;' src='/site_12_1/css/aufklappen.png'> Hier gibt's noch mehr...</div>")
		$('#teaser_content_<? echo $elem_id;?>').hide();
		$('#rollup_<? echo $elem_id;?>').toggle(
				function(){$('#teaser_content_<? echo $elem_id;?>').slideDown("slow");$('#rollup_<? echo $elem_id;?>').html("<div id='rollup_controller' style='margin-top:5px; background-color: #eeeeee; text-align:center;font-size: 9px;color: #666666;height:14px;cursor:pointer;'><img style='vertical-align:bottom;' src='/site_12_1/css/zuklappen.png'> Zuklappen...</div>");}
				,function(){$('#teaser_content_<? echo $elem_id;?>').slideUp("slow");$('#rollup_<? echo $elem_id;?>').html("<div id='rollup_controller' style='margin-top:5px; background-color: #eeeeee; text-align:center;font-size: 9px;color: #666666;height:14px;cursor:pointer;'><img style='vertical-align:bottom;' src='/site_12_1/css/aufklappen.png'> Hier gibt's noch mehr...</div>");}
				)
		  });
</script>
<? }?>
<script>
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
