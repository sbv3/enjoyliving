<? session_start();?>

<script>
function reload_page()
{
	location.reload(true)
}


</script>

<?
$adminpath=$_SERVER['DOCUMENT_ROOT'];
/////////////////////////////////////////// POST Funktionen
##change sort order
if (!isset($_SESSION['microtime']) or $_SESSION['microtime'] != $timestamp_buchtipp)
{
	$task=$_POST[task];
	$swap_sort=$_POST[swap_sort];
	$own=$_POST[own];
	$own_sort=$_POST[own_sort];
	$swap=$_POST[swap];
	if($task=="sort_buchtipp"){
		###zuerst die eigene sort-order überschreiben
		if($own!="" && $swap!="" && $own_img!="" && $swap_img!=""){
			$updateSQL=sprintf("update buchtipp SET sort=%u where id=%u",
				GetSQLValueString($swap_sort,"int"),
				GetSQLValueString($own,"int"));
			$Result1=mysql_query($updateSQL) or die (mysql_error());
			$updateSQL=sprintf("update element_content_img SET sort=%u where id=%u",
				GetSQLValueString($swap_sort_img,"int"),
				GetSQLValueString($own_img,"int"));
			$Result1=mysql_query($updateSQL) or die (mysql_error());
		}
		
		###Dann die andere sort-order überschreiben
		if($own!="" && $swap!="" && $own_img!="" && $swap_img!=""){
			$updateSQL=sprintf("update buchtipp SET sort=%u where id=%u",
				GetSQLValueString($own_sort,"int"),
				GetSQLValueString($swap,"int"));
			$Result1=mysql_query($updateSQL) or die (mysql_error());
			$updateSQL=sprintf("update element_content_img SET sort=%u where id=%u",
				GetSQLValueString($own_sort_img,"int"),
				GetSQLValueString($swap_img,"int"));
			$Result1=mysql_query($updateSQL) or die (mysql_error());
		}
		$task="";
		echo"<meta http-equiv=\"refresh\" content=\"0; URL=admin_V1.php?menu_id=$menu_id&timestamp=$timestamp_buchtipp\" />";
	}
	###buchtipp löschen
	$buchtipp_img_id=$_POST[buchtipp_img_id];
	$buchtipp_id=$_POST[buchtipp_id];
	if($task=="delete_buchtipp")
	{
		if($buchtipp_id!="" && $buchtipp_img_id!=""){
			$delete_query=mysql_query("delete from buchtipp where id='$buchtipp_id'") or die ("delete failed: ".mysql_error());
			$delete_query=mysql_query("delete from element_content_img where id='$buchtipp_img_id'") or die ("delete failed: ".mysql_error());
		}
		$task="";
		echo"<meta http-equiv=\"refresh\" content=\"0; URL=admin_V1.php?menu_id=$menu_id&timestamp=$timestamp_buchtipp\" />";
	}
	
	###buchtipp anlegen
	if($task=="add_buchtipp")
	{
		$insert_query=mysql_query("insert into buchtipp (element_id, sort) values ('$elem_id','$buchtipp_next_sort')") or die ("delete failed: ".mysql_error());
		$insert_query=mysql_query("insert into element_content_img (element_id, type, sort) values ('$elem_id','buchtipp','$buchtipp_img_next_sort')") or die ("delete failed: ".mysql_error());
		$task="";
		echo"<meta http-equiv=\"refresh\" content=\"0; URL=admin_V1.php?menu_id=$menu_id&timestamp=$timestamp_buchtipp\" />";
	}
	$_SESSION['microtime'] = $timestamp_buchtipp;
}

//////////////////////////////////////////Vorbereitende Abfragen

// Abfrage der buchtipp Tabelle
$buchtipp_query=mysql_query("select id,titel,subtitel,kurztext,bild,autor,verlag,ISBN,format,seiten,rezensionslink,amazonlink from buchtipp where element_id='$elem_id' order by sort") or die ("buchtipp Tabelle Abfrage1: ".mysql_error());
$buchtipp_num_rows = mysql_num_rows($buchtipp_query);

if($buchtipp_num_rows==0) //hier wird gecheckt, ob schon ein Eintrag da ist. Wenn ja, wird der genommen. Wenn nein, wird ein leerer Eintrag angelegt.
{
	mysql_query("INSERT INTO buchtipp (element_id) VALUES('$elem_id')") or die(mysql_error());
	mysql_query("INSERT INTO element_content_img (element_id, assets_ID, type, sort) VALUES('$elem_id','0','buchtipp','10')") or die(mysql_error());
	$buchtipp_query=mysql_query("select id,titel,subtitel,kurztext,bild,autor,verlag,ISBN,format,seiten,rezensionslink,amazonlink from buchtipp where element_id='$elem_id' order by sort") or die ("buchtipp Tabelle Abfrage2: ".mysql_error());
	$buchtipp_num_rows = mysql_num_rows($buchtipp_query);
}
while(($buchtipp_query_result[] = mysql_fetch_assoc($buchtipp_query)) || array_pop($buchtipp_query_result));

//Abfrage für die Sortierfunktion
$buchtipp_sort = mysql_query("SELECT id, sort FROM buchtipp WHERE element_id='$elem_id' order by sort")or die("x4_sort");
$buchtipp_sort_num_rows = mysql_num_rows($buchtipp_sort);

$buchtipp_img_sort = mysql_query("SELECT id, sort FROM element_content_img WHERE element_id='$elem_id' order by sort")or die("x5_sort");
$buchtipp_img_sort_num_rows = mysql_num_rows($buchtipp_img_sort);
?>




<?
// FÃ¼r jeden MenÃ¼punkt wird durchsucht, ob es schon Inhalte in der Tabelle menu_teaser gibt. Wenn nicht, mÃ¼ssen sie angelegt werden. Wenn doch, fragen wir der Reihe nach ab, was es schon gibt. Alles was leer ist wird von den Elementen befÃ¼llt.
for ($anz=0;$anz<=$buchtipp_num_rows-1;$anz+=1)
{
	?>
	<div style="width:201px; padding-top:1px; padding-right:5px; float:left"> 
		<div style="float:right">
			<? //hier kommen die Sortierbuttons rein.
			if($buchtipp_sort_num_rows > 1)
			{
				//zuerst die sort-Funktionen für die Buchtipp Tabelle vorbereiten.
				$Anz2=$anz;
				mysql_data_seek($buchtipp_sort, $Anz2); 
				$buchtipp_sort_result = mysql_fetch_row($buchtipp_sort);
				$buchtipp_id_own = $buchtipp_sort_result[0];
				$buchtipp_sort_own = $buchtipp_sort_result[1];
				
				##next element_id
				if($Anz2 < $buchtipp_sort_num_rows-1){
				mysql_data_seek($buchtipp_sort, $Anz2+1); 
				$buchtipp_sort_result = mysql_fetch_row($buchtipp_sort);
				$buchtipp_id_next = $buchtipp_sort_result[0];
				$buchtipp_sort_next = $buchtipp_sort_result[1];}
				
				##prev element_id
				if($Anz2 > 0){
				mysql_data_seek($buchtipp_sort, $Anz2-1); 
				$buchtipp_sort_result = mysql_fetch_row($buchtipp_sort);
				$buchtipp_id_prev = $buchtipp_sort_result[0];
				$buchtipp_sort_prev = $buchtipp_sort_result[1];}	


				//dann die sort-Funktionen für die element_content_img vorbereiten.
				$Anz2=$anz;
				mysql_data_seek($buchtipp_img_sort, $Anz2); 
				$buchtipp_img_sort_result = mysql_fetch_row($buchtipp_img_sort);
				$buchtipp_img_id_own = $buchtipp_img_sort_result[0];
				$buchtipp_img_sort_own = $buchtipp_img_sort_result[1];
				
				##next element_id
				if($Anz2 < $buchtipp_img_sort_num_rows-1){
				mysql_data_seek($buchtipp_img_sort, $Anz2+1); 
				$buchtipp_img_sort_result = mysql_fetch_row($buchtipp_img_sort);
				$buchtipp_img_id_next = $buchtipp_img_sort_result[0];
				$buchtipp_img_sort_next = $buchtipp_img_sort_result[1];}
				
				##prev element_id
				if($Anz2 > 0){
				mysql_data_seek($buchtipp_img_sort, $Anz2-1); 
				$buchtipp_img_sort_result = mysql_fetch_row($buchtipp_img_sort);
				$buchtipp_img_id_prev = $buchtipp_img_sort_result[0];
				$buchtipp_img_sort_prev = $buchtipp_img_sort_result[1];}	


				//dann die sort funktionen anzeigen	  
				?><!-- Zeige diese buttons an, sofern es überhaupt ein Element schon gibt. -->
				<div style="float:right"><img src='/site_12_1/css/Element_subcontent_rechts.png' border='0' height='19px'></div>
				<div style='height:19px; position:relative; z-index:1000; float:right;'><img class="bg_image_scale" src="/site_12_1/css/Element_subcontent_taste_Mitte.png"/>
		    
					<div style="height:17px; float:left;">
					<? if($Anz2 > 0)
						{?> <!-- SORT UP BUTTON bei allen, die nicht das oberste Element sind-->
						<form action="admin_V1.php?menu_id=<? echo $menu_id;?>" method="post" target="_self" style="float:left">
							<input type="hidden" name="task" value="sort_buchtipp">
							<input type="hidden" name="own" value="<? echo $buchtipp_id_own ;?>">
							<input type="hidden" name="own_sort" value="<? echo $buchtipp_sort_own ;?>">
							<input type="hidden" name="swap" value="<? echo $buchtipp_id_prev ;?>">
							<input type="hidden" name="swap_sort" value="<? echo $buchtipp_sort_prev ;?>">
							
							<input type="hidden" name="own_img" value="<? echo $buchtipp_img_id_own ;?>">
							<input type="hidden" name="own_sort_img" value="<? echo $buchtipp_img_sort_own ;?>">
							<input type="hidden" name="swap_img" value="<? echo $buchtipp_img_id_prev ;?>">
							<input type="hidden" name="swap_sort_img" value="<? echo $buchtipp_img_sort_prev ;?>">
							<input name="timestamp_buchtipp" type="hidden" value="<? echo microtime();?>">
							<input type="image" src="/site_12_1/css/button_up.png" style="height:17px; position:relative; z-index:2000;">
						</form>
					<? }?>
					</div>
				
					<div style="height:17px; float:left;">
						<? if($Anz2 < $buchtipp_sort_num_rows-1){?> <!-- SORT DOWN BUTTON bei allen, die nicht das letzte Element sind-->
						<form action="admin_V1.php?menu_id=<? echo $menu_id;?>" method="post" target="_self" style="float:left">
							<input type="hidden" name="task" value="sort_buchtipp">
							<input type="hidden" name="own" value="<? echo $buchtipp_id_own ;?>">
							<input type="hidden" name="own_sort" value="<? echo $buchtipp_sort_own ;?>">
							<input type="hidden" name="swap" value="<? echo $buchtipp_id_next ;?>">
							<input type="hidden" name="swap_sort" value="<? echo $buchtipp_sort_next ;?>">

							<input type="hidden" name="own_img" value="<? echo $buchtipp_img_id_own ;?>">
							<input type="hidden" name="own_sort_img" value="<? echo $buchtipp_img_sort_own ;?>">
							<input type="hidden" name="swap_img" value="<? echo $buchtipp_img_id_next ;?>">
							<input type="hidden" name="swap_sort_img" value="<? echo $buchtipp_img_sort_next ;?>">
							<input name="timestamp_buchtipp" type="hidden" value="<? echo microtime();?>">
							<input type="image" src="/site_12_1/css/button_down.png" style="height:17px; position:relative; z-index:2000; ">
						</form>
						<? }?>		     
					</div>
					
					<div style="height:17px; float:left;">
						<form action="admin_V1.php?menu_id=<? echo $menu_id;?>" method="post" target="_self" style="float:left">
							<input type="hidden" name="task" value="delete_buchtipp">
							<input type="hidden" name="buchtipp_id" value="<? echo $buchtipp_id_own ;?>">
							<input type="hidden" name="buchtipp_img_id" value="<? echo $buchtipp_img_id_own ;?>">
							<input type="image" src="/site_12_1/css/button_delete.png" style="height:17px; position:relative; z-index:2000;">
							<input name="timestamp_buchtipp" type="hidden" value="<? echo microtime();?>">
						</form>	
					</div>
					
				</div>		
				<div style="float:right"><img src='/site_12_1/css/Element_subcontent_links.png' border='0' height='19px'></div>
	
		    <? }?>
		</div>
		<div style="clear:right; height:5px"></div>
		<div id="Buchtipp" style="width:201px; text-align: center; position: relative;top: 50%;left: 0px;width: 100%;overflow: visible;visibility: visible;display: block;">
			<div style="width: 200px;margin-left: -100px;position: relative;left: 50%; visibility: visible;">
				<?
				$row_id=$anz+1;
				include("$adminpath/site_12_1/admin/admin_imageeditor.php");
				?>
			</div>
			<div style='width:auto'>
				<? $row_id=1;?>
				<div style="height:5px"></div>
				<? $field="titel"; $table="buchtipp"; $TXT_breite="200"; $rows="1"; $FCK_breite="100"; $texts[1]=$buchtipp_query_result[$anz]['titel']; $texts_style[1]='teaser_einleitung'; $texts_id[1]=$buchtipp_query_result[$anz]['id']; $editors[1]="TXT"; include("$adminpath/site_12_1/admin/admin_editor.php")?>
				<? $field="subtitel"; $table="buchtipp"; $TXT_breite="200"; $rows="1"; $FCK_breite="100"; $texts[1]=$buchtipp_query_result[$anz]['subtitel']; $texts_style[1]='artikeltext'; $texts_id[1]=$buchtipp_query_result[$anz]['id']; $editors[1]="TXT"; include("$adminpath/site_12_1/admin/admin_editor.php")?>
				<? $field="autor"; $table="buchtipp"; $TXT_breite="200"; $rows="1"; $FCK_breite="100"; $texts[1]=$buchtipp_query_result[$anz]['autor']; $texts_style[1]='artikelbeschriftung'; $texts_id[1]=$buchtipp_query_result[$anz]['id']; $editors[1]="TXT"; include("$adminpath/site_12_1/admin/admin_editor.php")?>
				<div style='height:8px;'>&nbsp;</div>
				<div style='text-align: left; '>
					<? $field="kurztext"; $table="buchtipp"; $TXT_breite="100"; $rows="1"; $FCK_breite="100"; $texts[1]=$buchtipp_query_result[$anz]['kurztext']; $texts_style[1]='teasertext'; $texts_id[1]=$buchtipp_query_result[$anz]['id']; $editors[1]="TXT"; include("$adminpath/site_12_1/admin/admin_editor.php")?>
					<br />
					<a class="teasertext">Verlag:&nbsp;</a>
					<span><? $field="verlag"; $table="buchtipp"; $TXT_breite="100"; $rows="1"; $FCK_breite="100"; $texts[1]=$buchtipp_query_result[$anz]['verlag']; $texts_style[1]='teasertext'; $texts_id[1]=$buchtipp_query_result[$anz]['id']; $editors[1]="TXT"; include("$adminpath/site_12_1/admin/admin_editor.php")?></span>

					<a class="teasertext" style="float:left">ISBN:&nbsp;</a>
					<span><? $field="ISBN"; $table="buchtipp"; $TXT_breite="100"; $rows="1"; $FCK_breite="100"; $texts[1]=$buchtipp_query_result[$anz]['ISBN']; $texts_style[1]='teasertext'; $texts_id[1]=$buchtipp_query_result[$anz]['id']; $editors[1]="TXT"; include("$adminpath/site_12_1/admin/admin_editor.php")?></span>
					
					<a class="teasertext" style="float:left">Format:&nbsp;</a>
					<span><? $field="format"; $table="buchtipp"; $TXT_breite="100"; $rows="1"; $FCK_breite="100"; $texts[1]=$buchtipp_query_result[$anz]['format']; $texts_style[1]='teasertext'; $texts_id[1]=$buchtipp_query_result[$anz]['id']; $editors[1]="TXT"; include("$adminpath/site_12_1/admin/admin_editor.php")?></span>
					
					<a class="teasertext" style="float:left">Seitenzahl:&nbsp;</a>
					<span><? $field="seiten"; $table="buchtipp"; $TXT_breite="100"; $rows="1"; $FCK_breite="100"; $texts[1]=$buchtipp_query_result[$anz]['seiten']; $texts_style[1]='teasertext'; $texts_id[1]=$buchtipp_query_result[$anz]['id']; $editors[1]="TXT"; include("$adminpath/site_12_1/admin/admin_editor.php")?></span>

					<a class="teasertext"><br />Link zur Rezension, wenn vorhanden</a>
					<span><? $field="rezensionslink"; $table="buchtipp"; $TXT_breite="200"; $rows="1"; $FCK_breite="100"; $texts[1]=$buchtipp_query_result[$anz]['rezensionslink']; $texts_style[1]='teasertext'; $texts_id[1]=$buchtipp_query_result[$anz]['id']; $editors[1]="TXT"; include("$adminpath/site_12_1/admin/admin_editor.php")?></span>

				</div>
			</div>
			<div style='clear:left;height:2px'>&nbsp;</div>
		</div>
     </div>
     <? if((($anz+1)/3)==(int)(($anz+1)/3) and $anz < $buchtipp_sort_num_rows-1){echo "<div style='float:left;width:100%;padding-top:8px; margin-bottom:5px;border-width:0px 0px 1px 0px;border-style:dotted;border-color:#ADAAAA'></div>"; }?>
     
	<?
}//Schleife Ende for all Menu ids
?>

<? //add Buchtipp Funktion
mysql_data_seek($buchtipp_sort, $buchtipp_sort_num_rows-1); 
$buchtipp_sort_result = mysql_fetch_row($buchtipp_sort);

mysql_data_seek($buchtipp_img_sort, $buchtipp_img_sort_num_rows-1); 
$buchtipp_img_sort_result = mysql_fetch_row($buchtipp_img_sort);

?>
    
<div style='width:100%;height:10px;'></div>
<div style="height:42px;width:28px;float:right"></div>
<div style="background-image:url(/site_12_1/css/Element_subcontent_rechts.png);width:4px;height:38px;float:right"></div>
<div style="background-image:url(/site_12_1/css/Element_subcontent_taste_Mitte.png);background-repeat:repeat-x;height:38px; float:right;">
     <div style="height:38px; float:left;">
			<form action="admin_V1.php?menu_id=<? echo $menu_id;?>" method="post" target="_self">
				<input type="hidden" name="task" value="add_buchtipp">
				<input type="hidden" name="buchtipp_next_sort" value="<? echo $buchtipp_sort_result[1];?>">
				<input type="hidden" name="buchtipp_img_next_sort" value="<? echo $buchtipp_img_sort_result[1];?>">
				<input type="image" src="/site_12_1/css/button_add.png" style="height:34px; position:relative; z-index:2000;">
				<input name="timestamp_buchtipp" type="hidden" value="<? echo microtime();?>">
			</form>	
     </div>
</div>
<div style="background-image:url(/site_12_1/css/Element_subcontent_links.png);width:4px;height:38px;float:right"></div>
<div style="clear:right"></div>


<div style='clear:left;height:4px'></div>