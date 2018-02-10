<?
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
///////////////////////////////POST Queries
if(test_right($_SESSION['user'],"enter_verwaiste_google_URL")!="true")
	{
		echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$href_root/site_12_1/admin/papa/menu.php?men_id=$home_menu_id\">";
		exit;
	}
else
{
	if($assigned==1){mysql_query("update googleurl set menu_id=$newassignment where id=$googleurlid limit 1") or die (mysql_error());}
	if($delete==1){mysql_query("delete from googleurl where id=$googleurlid limit 1") or die (mysql_error());}

	//create selectbox
	
	$sitemap=menu_select('230','down','4','1','0','1');
	for($i=0;$i<count($sitemap['id']);$i++)
	{
		$id=$sitemap['id'][$i];
		$description=$sitemap['description'][$i];
		$googleurl=$sitemap['googleurl'][$i];
		$level_down=$sitemap['level_down'][$i];
		$up_date=$sitemap_cache_test[0];
	
		if($level_down==0){$option_text="$option_text<option value='$id' style='font-weight:bold;color:#F00;'>$description</option>";}
		if($level_down==1){$option_text="$option_text<option value='$id' style='font-weight:bold'>&nbsp;&raquo; $description</option>";}
		if($level_down==2){$option_text="$option_text<option value='$id' style='text-decoration:underline'>&nbsp;&nbsp;&nbsp; $description</option>";}
		if($level_down>2){$option_text="$option_text<option value='$id'>".str_repeat("&nbsp;",$level_down)."&raquo; $description</option>";}
	}
	
	$result = mysql_query("select * from googleurl where menu_id not in (select id from menu) order by menu_id")or die("subx3");
	while ($zeige=mysql_fetch_assoc($result))
	{
		echo "<a href=\"".$testpfad.$zeige['googleurl']."\">Menu ID: ".$zeige['menu_id']." - ".$zeige['googleurl']."</a><br>";?>
		
		<form name="newassignment" method="post" target="_self" style="float:left">
			<select name="newassignment">
				<option value="">bitte ausw&auml;hlen....</option>
				<? echo $option_text;?>
			</select>
			<input type="submit" value="Speichern" name="submit">
			<input name="assigned" type="hidden" value="1">
			<input name="googleurlid" type="hidden" value="<? echo $zeige['id'];?>">
		</form>
		<form name="deleteurl" method="post" target="_self">
			<input type="submit" value="Löschen" name="submit">
			<input name="delete" type="hidden" value="1">
			<input name="googleurlid" type="hidden" value="<? echo $zeige['id'];?>">
		</form>

	<?	
	}
}
?>