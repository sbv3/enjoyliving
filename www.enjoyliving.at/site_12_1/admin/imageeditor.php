<? session_start();
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
if(test_right($_SESSION['user'],"enter_page_content")!="true")
	{
		echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$href_root/site_12_1/admin/papa/menu.php?men_id=$home_menu_id\">";
		exit;
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


    <script language="JavaScript">
function setBild(path,id,master_site_id)
 {
  document.getElementById("Bildi").src = path;
  document.getElementById("BildiX").src = "imagedetail.php?ID_imagedetail="+id+"&master_site_id="+master_site_id;
  u_pfad=path;
  u_id=id;
}
//--></script>
</head>
<?

$adminpath=$_SERVER['DOCUMENT_ROOT'];
if($jahr==""){$jahr=date("Y");}

function upload_img($filehandler, $category, $class, $type, $master_site_id, $ordner, $xkeywords,$xalt_tag,$xchannel)
{
	if ($filehandler!="")
	{
		global $adminpath,$jahr;
		//////////Max Größe feststellen
		if(file_exists($_FILES[$filehandler]['tmp_name']) and ($_FILES[$filehandler]["type"] == 'image/png' || $_FILES[$filehandler]["type"] == 'image/jpeg' || $_FILES[$filehandler]["type"] == 'image/gif'))
		{
			$verza="site_12_1/assets/$category$class/$master_site_id/$type/$jahr/";
			$verzb="/$master_site_id/$type/$jahr/";
			if ($ordner!=""){$verza="$verza$ordner/";$verzb="$verzb$ordner/";}
			
			$filename=$_FILES[$filehandler]['name'];
			$von_pfad=$_FILES[$filehandler]['tmp_name'];
			
			$nach_tmp=$adminpath.$verza."tmp_".$filename;
			move_uploaded_file($von_pfad,$nach_tmp);
			chmod($nach_tmp, 0755);
			
			$info = getimagesize ($nach_tmp);
			
			$max_upload_dimensions_query=mysql_query("select breite, hoehe from pagetype_default_style_tag_img where default_type='$type' limit 1") or die ("max avail width: ".mysql_error());
			$max_upload_dimenstions=mysql_fetch_assoc($max_upload_dimensions_query);
			if($max_upload_dimenstions["breite"]!="0"){$max_upload_breite=$max_upload_dimenstions["breite"];}else{$max_upload_breite=min(620,$info[0]);}//das ist die maximale Breite
			if($max_upload_dimenstions["hoehe"]!="0"){$max_upload_hoehe=$max_upload_dimenstions["hoehe"];}else{$max_upload_hoehe=min(620,$info[0]);}//das ist die maximale Hoehe
	
			$filename_new = replace($filename);
			$filename_new = strtolower($filename_new);
			$filename_new = substr($filename_new,0,-3);
			$filename_new = $filename_new.".".substr($filename, -3);
			$nach_new=$adminpath.$verza.$filename_new;
			
			thumb($nach_tmp, $nach_new, $max_upload_breite,$max_upload_hoehe, TRUE);//das Original resizen
			unlink($nach_tmp);
			
			$to1 = $adminpath.$verza."~klein~".$filename_new;
			$to2 = $adminpath.$verza."~mini~".$filename_new;
			if($info[0]>150 || $info[1]>150){thumb($nach_new, $to1, 150,150, TRUE);}else{copy($nach_new, $to1);}//with,height
			if($info[0]>75 || $info[1]>75){thumb($nach_new, $to2, 75,75, TRUE);}else{copy($nach_new, $to2);}//with,height
			
			$datum_heute = date("Y-m-d");
			$zeit_heute = date("H:i");

			if(file_exists($nach_new) && file_exists($to1) && file_exists($to2))
			{
				mysql_query("INSERT INTO assets 
				(keywords,erstelldatum,path,alt_tag,breite,hoehe,jahr,category,class,type,channel,filename,site_id) VALUES 
				('$xkeywords','$datum_heute $zeit_heute','$verzb','$xalt_tag','$info[0]','$info[1]','$jahr','$category','$class','$type','$xchannel','$filename_new','$master_site_id')")or die("xxx");
				
				echo"<b>Das Bild \"$filename_new\" wurde hochgeladen.</b><br><br>";
			}
		}
		else
		{
			?> 
			<script> alert("Der Filetype von Bild: \"<? echo $_FILES[$filehandler]['name']; ?>\" wurde nicht hochgeladen, weil es nicht gefunden werden konnte oder weil es den falschen Dateityp (MIME-Type) hat.")</script> 
			<? 
		}
	}
}


####übergabe vom master folgender variablen:<br />
# bildpfad (wenn vorhanden): $path_uebergabe_in 
# ID des Bildes (wenn vorhanden): $assets_ID_uebergabe_in
# elementID: $content_element_img_ID_uebergabe_in<br />
#$type = bildtyp<br />

$array = explode ( '/', $path_uebergabe_in );
if ($array[9]!="" and $ordner=="" and $ordner!="root"){$ordner="$array[8]";}
#echo"$array[1] - $array[2] - $array[3] - $array[4]";
#

require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
?>

<body>
<div style='float:left;width:300px'>
<?
if ($type=="" and ($imagetypeselect==0 or $imagetypeselect=="" or !$imagetypeselect)){$imagetypeselect=1;}
if ($no_class==1){$imagetypeselect=2;}
if(!$master_site_id){
	$master_site_id_q=mysql_query("select menu.master_site_id from menu where id=$menu_id") or die("master_site_id_failed");
	$master_site_id_r=mysql_fetch_assoc($master_site_id_q);
	$master_site_id=$master_site_id_r[master_site_id];
}

///////////////////////////POST Funktionen
####update after default img
if ($task=="default_overruled"){
$type_arr=explode('/',$path_uebergabe_in);
$type=$type_arr[6];
}

####UPDATE
if ($eintrag=="1")
{	
	####neuen Ordner erstellen
	if ($ordnername!="")
	{
		if ( mkdir ( "$adminpath/site_12_1/assets/$category$class/$master_site_id/$type/$jahr/$ordnername", 0755 ) )
		{
			echo '<b>Neuer Ordner wurde erstellt!</b><br><br>';
		}
	}
	###upload
	if ($filename1!=""){upload_img("filename1", $category, $class, $type, $master_site_id, $ordner, $xkeywords,$xalt_tag,$xchannel);}
	if ($filename2!=""){upload_img("filename2", $category, $class, $type, $master_site_id, $ordner, $xkeywords,$xalt_tag,$xchannel);}
	if ($filename3!=""){upload_img("filename3", $category, $class, $type, $master_site_id, $ordner, $xkeywords,$xalt_tag,$xchannel);}
	if ($filename4!=""){upload_img("filename4", $category, $class, $type, $master_site_id, $ordner, $xkeywords,$xalt_tag,$xchannel);}
	if ($filename5!=""){upload_img("filename5", $category, $class, $type, $master_site_id, $ordner, $xkeywords,$xalt_tag,$xchannel);}
	
	
		#####cvs filename2
}
if ($ordner=="" or $ordner=="root"){$styler="font-weight:bold;color:#FF3919";}else{$styler="";}
if (substr($path_uebergabe_in,-16)=="/default_img.png" and ($imagetypeselect==0 or $imagetypeselect=="" or !$imagetypeselect)){$imagetypeselect=1;$type="";}
if($imagetypeselect>0)
{
?>
	<div style='padding:4px;border-style:solid;border-width:1px;border-color:#CCCCCC;background-color:#F0F3FA'> <b>Bildtyp auswählen:</b><br />
<? 
		$avail_asset_type_query=mysql_query("select default_type as type,breite,hoehe from pagetype_default_style_tag_img") or die ("avail asset type".mysql_error());
?>
		<form id="form_select_type" name="form_select_type" enctype="application/x-www-form-urlencoded" method="post" action="imageeditor.php">
			   <select name="path_uebergabe_in" id="path_uebergabe_in" style="width:200px" onchange="if(this.value == 'select'){} else {document.forms['form_select_type'].submit()}">
			   <option value="select">select</option>
<?			while($avail_asset_type_result=mysql_fetch_assoc($avail_asset_type_query))
			{?>
				<option value="<? echo '/site_12_1/assets/'.$category.$class.'/'.$master_site_id.'/'.$avail_asset_type_result['type'].'/'.$jahr;?>"<? if ($type==$avail_asset_type_result['type']){echo"selected";}?>><? echo $avail_asset_type_result['type']; if ($avail_asset_type_result['breite']!=0){echo " - Breite: ".$avail_asset_type_result['breite'];}; if ($avail_asset_type_result['hoehe']!=0){echo " - Höhe: ".$avail_asset_type_result['hoehe'];}?></option>
<? 			}?> 
				</select>
				<input name="content_element_img_ID_uebergabe_in" type="hidden" id="content_element_img_ID_uebergabe_in" value="<? echo"$content_element_img_ID_uebergabe_in";?>" />
				<input name="assets_ID_uebergabe_in" type="hidden" id="assets_ID_uebergabe_in" value="<? echo"$assets_ID_uebergabe_in";?>" />
				<input name="master_site_id" type="hidden" value="<? echo $master_site_id;?>" />
				<input name="imagetypeselect" type="hidden" value="2" />
				<input name="category" type="hidden" id="category" value="<? echo"$category";?>">
				<input name="class" type="hidden" id="class" value="<? echo"$class";?>">
				<input name="type" type="hidden" id="type" value="<? echo"$type";?>">
				<input name="imgs_table" type="hidden" id="imgs_table" value="<? echo"$imgs_table";?>">
				<input name="imgs_scale_to_fit" type="hidden" id="imgs_scale_to_fit" value="<? echo"$imgs_scale_to_fit";?>">
				<input name="ordner" type="hidden" id="ordner" value="<? echo"$ordner";?>" />
				<input name="task" type="hidden" value="default_overruled"/>
		  </form>
	</div>
<?
}

if($imagetypeselect!=1){
	
	
?>
	 <div style='padding:4px;border-style:solid;border-width:1px;border-color:#CCCCCC;background-color:#F0F3FA;margin-top:20px;'> <b>Verzeichnisauswahl:</b><br />
		<form name="form_year" method="post">
			   <select name="jahr" style="width:200px" onchange="document.forms['form_year'].submit()">
				   <option value=2018 <? if($jahr==2018){echo"selected";}?>>2018</option>
				   <option value=2017 <? if($jahr==2017){echo"selected";}?>>2017</option>
				   <option value=2016 <? if($jahr==2016){echo"selected";}?>>2016</option>
				   <option value=2015 <? if($jahr==2015){echo"selected";}?>>2015</option>
				   <option value=2014 <? if($jahr==2014){echo"selected";}?>>2014</option>
				   <option value=2013 <? if($jahr==2013){echo"selected";}?>>2013</option>
				   <option value=2012 <? if($jahr==2012){echo"selected";}?>>2012</option>
				   <option value=2011 <? if($jahr==2011){echo"selected";}?>>2011</option>
			   </select>
			   <input name="content_element_img_ID_uebergabe_in" type="hidden" id="content_element_img_ID_uebergabe_in" value="<? echo"$content_element_img_ID_uebergabe_in";?>" />
			   <input name="assets_ID_uebergabe_in" type="hidden" id="assets_ID_uebergabe_in" value="<? echo"$assets_ID_uebergabe_in";?>" />
			   <input name="path_uebergabe_in" type="hidden" id="path_uebergabe_in" value="<? echo"$path_uebergabe_in";?>" />
			   <input name="imagetypeselect" type="hidden" value="<? echo $imagetypeselect;?>" />
			   <input name="master_site_id" type="hidden" value="<? echo $master_site_id;?>" />
			   <input name="category" type="hidden" id="category" value="<? echo"$category";?>">
			   <input name="class" type="hidden" id="class" value="<? echo"$class";?>">
			   <input name="type" type="hidden" id="type" value="<? echo"$type";?>">
			   <input name="imgs_table" type="hidden" id="imgs_table" value="<? echo"$imgs_table";?>">
			   <input name="imgs_scale_to_fit" type="hidden" id="imgs_scale_to_fit" value="<? echo"$imgs_scale_to_fit";?>">
			   <input name="eintrag" type="hidden" id="eintrag" value="1" />
			   <input name="ordner" type="hidden" id="ordner" value="<? echo"$ordner";?>" />
		</form>

		<form style="padding:0px;margin:0px" name="form1" enctype="multipart/form-data" action="imageeditor.php" method="post">
			<br />
			<div>
<?     
			echo"
			<div style='padding-bottom:8px'>
				<a href='imageeditor.php?imgs_table=$imgs_table&imagetypeselect=$imagetypeselect&master_site_id=$master_site_id&imgs_scale_to_fit=$imgs_scale_to_fit&category=$category&class=$class&type=$type&path_uebergabe_in=$path_uebergabe_in&assets_ID_uebergabe_in=$assets_ID_uebergabe_in&content_element_img_ID_uebergabe_in=$content_element_img_ID_uebergabe_in&ordner=root'><img src='/site_12_1/assets/img/adminarea/ordner1.gif' border='0'></a> 
				<a href='imageeditor.php?imgs_table=$imgs_table&imagetypeselect=$imagetypeselect&master_site_id=$master_site_id&imgs_scale_to_fit=$imgs_scale_to_fit&category=$category&class=$class&type=$type&path_uebergabe_in=$path_uebergabe_in&assets_ID_uebergabe_in=$assets_ID_uebergabe_in&content_element_img_ID_uebergabe_in=$content_element_img_ID_uebergabe_in&ordner=root' style='$styler'>/$type/$jahr/</a>
			</div>";
			$verz = opendir ( $adminpath."site_12_1/assets/$category$class/$master_site_id/$type/$jahr/" );
			while ( $file = readdir ( $verz ) )
			{
				$endung = strtolower(strrchr($file,'.'));
				
				if ( $file != '.' and $file != '..' && $endung!='.jpg' && $endung!='.gif' && $endung!='.png')
				{
					if ($ordner=="$file"){$styler="font-weight:bold;color:#FF3919";}else{$styler="";}
					echo "
					<div style='padding-left:10px;padding-bottom:8px'>
						<a href='imageeditor.php?imgs_table=$imgs_table&imagetypeselect=$imagetypeselect&master_site_id=$master_site_id&imgs_scale_to_fit=$imgs_scale_to_fit&category=$category&class=$class&type=$type&path_uebergabe_in=$path_uebergabe_in&assets_ID_uebergabe_in=$assets_ID_uebergabe_in&content_element_img_ID_uebergabe_in=$content_element_img_ID_uebergabe_in&ordner=$file'><img src='/site_12_1/assets/img/adminarea/ordner2.gif' border='0'></a> 
						<a href='imageeditor.php?imgs_table=$imgs_table&imagetypeselect=$imagetypeselect&master_site_id=$master_site_id&imgs_scale_to_fit=$imgs_scale_to_fit&category=$category&class=$class&type=$type&path_uebergabe_in=$path_uebergabe_in&assets_ID_uebergabe_in=$assets_ID_uebergabe_in&content_element_img_ID_uebergabe_in=$content_element_img_ID_uebergabe_in&ordner=$file' style='$styler'>$file</a>
					</div>";
				}
			}
			closedir ( $verz );
			?>
			<br />
			<? if ($ordner=="" or $ordner=="root"){?>
					<strong>Unterordner anlegen</strong><br />
					Neuen Unterordner im ausgew&auml;hlten Ordner anlegen:<br />
					<br />
					<label for="ordnername"></label>
					<input type="text" name="ordnername" id="ordnername" style="width:200px"/>
					<input type="submit" name="Submit2" class="butti"  value="go" />
			<? }?>
			   <br /><br /><strong>Bilder des ausgew&auml;hlten Ordners</strong>:<br />
			   <br />
			<?
			if ($ordner=="" or $ordner=="root"){$path1="/$master_site_id/$type/$jahr/";}else{$path1="/$master_site_id/$type/$jahr/$ordner/";}
			$result = mysql_query("SELECT category,class,path,filename,ID as asset_ID_thumb FROM assets WHERE category='$category' and class='$class' and type='$type' and jahr='$jahr' and path like '%$path1' and site_id=$master_site_id order by erstelldatum")or die("x");
			while ($show=mysql_fetch_object($result))
			{
				$pfad="";	
				$pfad="/site_12_1/assets/$show->category$show->class$show->path$show->filename";
				echo"<a href='#' onclick=\"setBild('$pfad','$show->asset_ID_thumb',$master_site_id)\"><img title='$show->filename' class='thumbnail' src='$pfad' width='50px' height='50px' style='padding-right:2px; padding-bottom:2px;'></a> ";	
			}
			?>
			<style>
			#preview{
				position:absolute;
				border:1px solid #ccc;
				background:#333;
				padding:5px;
				display:none;
				color:#fff;
			}
			</style>
			<script>
			this.imagePreview = function(){	
				/* CONFIG */
					
					xOffset = +60;
					yOffset = +30;
					
					// these 2 variable determine popup's distance from the cursor
					// you might want to adjust to get the right result
					
				/* END CONFIG */
				$("img.thumbnail").hover(function(e){
					this.t = this.title;
					this.title = "";	
					var c = (this.t != "") ? "<br/>" + this.t : "";
					$("body").append("<p id='preview'><img src='"+ this.src +"' alt='Image preview' width='400px'/>"+ c +"</p>");								 
					$("#preview")
						.css("top",(e.pageY - xOffset) + "px")
						.css("left",(e.pageX + yOffset) + "px")
						.fadeIn("fast");						
				},
				function(){
					this.title = this.t;	
					$("#preview").remove();
				});	
				$("img.thumbnail").mousemove(function(e){
					$("#preview")
						.css("top",(e.pageY - xOffset) + "px")
						.css("left",(e.pageX + yOffset) + "px");
				});			
			};
			
			
			// starting the script on page load
			$(document).ready(function(){
				imagePreview();
			});
			</script>

		</div>
		<br />
		<div style='padding:4px;border-style:solid;border-width:1px;border-color:#CCCCCC;background-color:#F0F3FA'> 

			<p><b>Hochladen</b><br />
			Bild in ausgew&auml;hlten Ordner hochladen: 
			<input type="file"  name="filename1" style="border-width:1px; border-color:#939598; border-style:solid; border-width: 1px 1px 1px 1px;background-color:#E1E2E3;font-family: Verdana; font-size: 8pt;width:350">
			</p>
			<p>
			  <input type="file"  name="filename2" style="border-width:1px; border-color:#939598; border-style:solid; border-width: 1px 1px 1px 1px;background-color:#E1E2E3;font-family: Verdana; font-size: 8pt;width:350">
			</p>
			<p>
			  <input type="file"  name="filename3" style="border-width:1px; border-color:#939598; border-style:solid; border-width: 1px 1px 1px 1px;background-color:#E1E2E3;font-family: Verdana; font-size: 8pt;width:350">
			</p>
			<p>
			  <input type="file"  name="filename4" style="border-width:1px; border-color:#939598; border-style:solid; border-width: 1px 1px 1px 1px;background-color:#E1E2E3;font-family: Verdana; font-size: 8pt;width:350">
			</p>
			<p>
			  <input type="file"  name="filename5" style="border-width:1px; border-color:#939598; border-style:solid; border-width: 1px 1px 1px 1px;background-color:#E1E2E3;font-family: Verdana; font-size: 8pt;width:350">			  
			  <br />
			<br>Alt-Tag:<br />
			<input name="xalt_tag" type="text" id="xalt_tag" style="width:200px"/>
			<br />
			<? 
			$channels=mysql_query("select description from menu where id in (select menu_id from menu_hierarchy where parent_id = $home_menu_id and site_id=$master_site_id)") or die (mysql_error());
			   ?>
			Channel:<br />
			<select name="xchannel" id="xchannel" style="width:200px">
				<option value="">Channel auswählen</option>
			  <?				while($channels_result=mysql_fetch_assoc($channels))
				{?>
			  <option value="<? echo $channels_result['description']?>" <? if ($xchannel==$channels_result['description']){echo"selected";}?>><? echo $channels_result['description']?></option>
			  <? 				}?> 
			  </select>
			<br />
			Keywords:<br />
			<input name="xkeywords" type="text" id="xkeywords" style="width:200px"/>
				<br />
				(mehrere mit Komma getrennt)
				<br />
			   <input name="content_element_img_ID_uebergabe_in" type="hidden" id="content_element_img_ID_uebergabe_in" value="<? echo"$content_element_img_ID_uebergabe_in";?>" />
			   <input name="assets_ID_uebergabe_in" type="hidden" id="assets_ID_uebergabe_in" value="<? echo"$assets_ID_uebergabe_in";?>" />
			   <input name="path_uebergabe_in" type="hidden" id="path_uebergabe_in" value="<? echo"$path_uebergabe_in";?>" />
			   <input name="imagetypeselect" type="hidden" value="<? echo $imagetypeselect;?>" />
			   <input name="master_site_id" type="hidden" value="<? echo $master_site_id;?>" />
			   <input name="category" type="hidden" id="category" value="<? echo"$category";?>">
			   <input name="class" type="hidden" id="class" value="<? echo"$class";?>">
			   <input name="type" type="hidden" id="type" value="<? echo"$type";?>">
			   <input name="imgs_table" type="hidden" id="imgs_table" value="<? echo"$imgs_table";?>">
			   <input name="imgs_scale_to_fit" type="hidden" id="imgs_scale_to_fit" value="<? echo"$imgs_scale_to_fit";?>">
			   <input name="eintrag" type="hidden" id="eintrag" value="1">
			   <input name="ordner" type="hidden" id="ordner" value="<? echo"$ordner";?>" />
			   <input type="submit" name="Submit" class="butti"  value="go">
			</p>
		</div>
		<br />
	</form>
	</div>

	<form id="form1" name="form1" method="post" action="imageeditor.php">
		<div style='padding:4px;border-style:solid;border-width:1px;border-color:#CCCCCC;background-color:#F0F3FA;margin-top:20px;'>
			   <strong>Bildsuche</strong><br />
			   <br />
			   Suchbegriff<br />
			   
			   <input name="suchbegriff" type="text" id="suchbegriff" value="<? echo"$suchbegriff";?>" style="width:200px"/>
			   <input name="content_element_img_ID_uebergabe_in" type="hidden" id="content_element_img_ID_uebergabe_in" value="<? echo"$content_element_img_ID_uebergabe_in";?>" />
			   <input name="assets_ID_uebergabe_in" type="hidden" id="assets_ID_uebergabe_in" value="<? echo"$assets_ID_uebergabe_in";?>" />
			   <input name="path_uebergabe_in" type="hidden" id="path_uebergabe_in" value="<? echo"$path_uebergabe_in";?>" />
			   <input name="imagetypeselect" type="hidden" value="<? echo $imagetypeselect;?>" />
			   <input name="master_site_id" type="hidden" value="<? echo $master_site_id;?>" />
			   <input name="category" type="hidden" id="category" value="<? echo"$category";?>">
			   <input name="class" type="hidden" id="class" value="<? echo"$class";?>">
			   <input name="type" type="hidden" id="type" value="<? echo"$type";?>">
			   <input name="imgs_table" type="hidden" id="imgs_table" value="<? echo"$imgs_table";?>">
			   <input name="imgs_scale_to_fit" type="hidden" id="imgs_scale_to_fit" value="<? echo"$imgs_scale_to_fit";?>">
			   <input name="eintrag" type="hidden" id="eintrag" value="1" />
			   <input name="ordner" type="hidden" id="ordner" value="<? echo"$ordner";?>" />
			   <br />
			   <br />
			   Channel<br />
			   <select name="channel" id="channel" style="width:200px">
					<option value="">Channel auswählen</option>

<?			mysql_data_seek($channels,0);
			while($channels_result=mysql_fetch_assoc($channels))
				{?>
					<option value="<? echo $channels_result['description']?>" <? if ($channel==$channels_result['description']){echo"selected";}?>><? echo $channels_result['description']?></option>
<?				}?> 
			</select>
			   <br />
			   <br />
			<? 
			if($imagetypeselect>0)
			{
				$bildtypen=mysql_query("select type from assets group by type order by type") or die (mysql_error());
				?>
				   Bildtyp:<br />
				   <label for="bildtype"></label>
				   <select name="bildtype" id="bildtype" style="width:200px">
					<option value="">Bildtyp auswählen</option>

	<?				while($bildtypen_result=mysql_fetch_assoc($bildtypen))
					{?>
						<option value="<? echo $bildtypen_result['type']?>" <? if ($bildtype==$bildtypen_result['type']){echo"selected";}?>><? echo $bildtypen_result['type']?></option>
	<?		 		}?> 
				</select>
			<? } ?>
			   <br />
			   <br />
			   <input type="submit" name="Submit3" class="butti"  value="go" />
			<br />
<? 	
			if ($suchbegriff!="" or $channel!="" or $bildtype!="")
			{?>
				<br />
				<strong>gefunden Bilder anhand der Suche</strong>:<br />
				<br />
<?
				if ($bildtype!=""){$abfrage0="and type='$bildtype'";}else{$abfrage0="";}
				if ($channel!=""){$abfrage1="and channel='$channel'";}else{$abfrage1="";}
				if ($suchbegriff!=""){$abfrage2="and keywords like '%$suchbegriff%'";}else{$abfrage2="";}
				$result = mysql_query("SELECT * FROM assets WHERE site_id=$master_site_id $abfrage0 $abfrage1 $abfrage2 order by erstelldatum")or die("x");
				while ($show=mysql_fetch_object($result))
				{
					$pfad="";	
					$pfad="/site_12_1/assets/$show->category$show->class$show->path$show->filename";
					$pfad_uebergabe_out="$show->category$show->class$show->path$show->filename";
					#echo"<img src='/site_12_1/admin/thumb.php?image=..$adminpath/pfad&x=45' border='0'>";
					echo"<a href='#' onclick=\"setBild('$pfad','$show->ID',$master_site_id)\"><img title='$show->filename' class='thumbnail' src='$pfad' width='50px' height='50px' style='padding-right:2px; padding-bottom:2px;'></a> ";	
				}
			}	
?>
		</div>
	</form>
	 <br />
	 <br />
	 <br />
	 </div>
	 <? $arr2 = explode ( '/', $path_uebergabe_in );
	if (substr(end($arr2),-3)!="jpg" and substr(end($arr2),-3)!="gif" and substr(end($arr2),-3)!="png"){$path_uebergabe_in="";//$assets_ID_uebergabe_in="999999999";
	}
	?>
	 <div style='float:left;margin-left:10px'><strong>ausgew&auml;hltes Bild</strong><br />
		  <table width="100%" border="0">
			   <tr>
					<td ><iframe name="Bildi" id="Bildi" class="form-normal" src="<? if ($path_uebergabe_in!=""){echo"$path_uebergabe_in";}?>" style="width: 450px; height:450px;border-color:#CCCCCC; border-style:solid; border-width: 1px 1px 1px 1px;"></iframe>  <br />
						 <br />
						 <br />
						 <iframe name="BildiX" id="BildiX" class="form-normal" src="<? echo"imagedetail.php?ID_imagedetail=$assets_ID_uebergabe_in&master_site_id=$master_site_id";?>" style="width: 450px; height:290px;border-color:#CCCCCC; border-style:solid; border-width: 1px 1px 1px 1px;background-color:#F0F3FA"></iframe>
						 <br />
						 <br />
						 <br />
						 <input type="button" name="OK" value="Bild übernehmen"  onclick="
							window.close();
							window.opener.update_img(<? echo $content_element_img_ID_uebergabe_in;?>,u_id,u_pfad,'<? echo $imgs_table; ?>');
						 "/>
					</td>
			   </tr>
		  </table>
	 </div>
	 <div style='clear:left'></div>
	 <? 
 }?>
</body>
</html>