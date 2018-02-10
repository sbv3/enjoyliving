<? session_start();?>
<? require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
if(test_right($_SESSION['user'],"enter_page_content")!="true")
	{
		echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$href_root/site_12_1/admin/papa/menu.php?men_id=$home_menu_id\">";
		exit;
	}
?>

<script language="JavaScript" type="text/javascript" charset="ISO-8859-1">
function update_img(element_id,asset_id,pfad,imgs_table)
{
	if(imgs_table=="menu_teaser")
		{dom_id="img_"+element_id;
		var row_id="<? echo $row_id;?>";
		var menu_id=row_id.substr(7);
		var url="Admin_table_result.php";
		url=url+"?task=update&field=teaser_asset_id&tabelle=menu_teaser&id="+element_id+"&value="+asset_id;
		display_data(url,'false');
		window.location.reload(true);
		}
	else if(imgs_table=="element_content_img")
		{
		dom_id="img_"+element_id;
		document.getElementById(dom_id).src=pfad;
		update_img_db(element_id,asset_id);
		window.location.reload(true);
		}
}
</script>


<?
$imgs_type2=$imgs_type[$row_id];
$assets_id2=$assets_id[$row_id];
$imgs_id2=$imgs_id[$row_id];
$filename=$filename[$row_id];
$path=$path[$row_id];
$category=$imgs_category[$row_id];
$class=$imgs_class[$row_id];
$src=$imgs[$row_id];
$imgs_scale_to_fit2=$imgs_scale_to_fit[$row_id];

if($imgs_table[$row_id]==""){$imgs_table2="element_content_img";}else{$imgs_table2=$imgs_table[$row_id];}

//"/site_12_1/assets/img$path$filename";

$imageeditor="imageeditor.php?no_class=$no_class&type=$imgs_type2&menu_id=$menu_id&path_uebergabe_in=$src&assets_ID_uebergabe_in=$assets_id2&content_element_img_ID_uebergabe_in=$imgs_id2&category=$category&class=$class&imgs_table=$imgs_table2&imgs_scale_to_fit=$imgs_scale_to_fit2";
?>

<? if($no_class==1){}else{echo "<div class='$imgs_type2'>";}?>
<? if(test_right($_SESSION['user'],"call_img_editor")=="true"){?>
	<input id="<? echo"img_$imgs_id2";?>" type="image" onClick="fenster=window.open('<? echo $imageeditor; ?>','popUpWindow','width=850,height=900,left=700,top=100,status=no,scrollbars=yes,toolbar=no,location=no,menubar=no,titlebar=no')" src="<? echo $src; ?>" <? if($imgs_scale_to_fit2=='true'){echo "width=100% height=100%";}?>>
<? } else{?>
	<img id="<? echo"img_$imgs_id2";?>" src="<? echo $src; ?>" <? if($imgs_scale_to_fit2=='true'){echo "width=100% height=100%";}?>>
	<script>
		$(document).ready(function(e) {
			$("[name^='vertical_slider_']").parent().remove();
		});
	</script>
<? }?>
<? if($no_class==1){}else{echo "</div>";}?>
<div id="table_result_error_messages"></div>