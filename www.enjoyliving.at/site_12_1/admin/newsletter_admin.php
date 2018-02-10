<? session_start();
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php"); 

if(test_right($_SESSION['user'],"enter_newsletter/gewinnspiele")!="true")
	{
		echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$href_root/site_12_1/admin/papa/menu.php?men_id=$home_menu_id\">";
		exit;
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<div>
	<div style='width:100%;background-image:url(/site_12_1/css/Element_Tops_Schatten.png);height:34px;background-repeat:repeat-x;'>
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px; font-weight:bolder; text-decoration:underline">Newsletter Verwaltung</div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px"><a href="gewinnspiel_admin.php">Gewinnspiel Verwaltung</a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:34px; float:left; text-align:left; padding:3px"><a href="papa/menu.php?men_id=230"><img src="/site_12_1/css/button_menu.png" title="Zurück zur Menüverwaltung"></a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
</div>
</div>
<div style="clear:both;"></div>
<body>
<?php
$table="newsletter";
$table_width=1300;
$URL= $_SERVER['PHP_SELF'];
$wanted_fields="id,anrede,vorname,nachname,strasse,plz,ort,land,email,Reisen,Wellness,Beauty,Gesundheit,Fitness,Geist_Seele,Ernaehrung,Alternativmedizin,Frau_Familie,Natur_Umwelt,Home_Living,NO,NO_werbemail,gewinnspiel";

#hier frage ich die Tabellenstruktur ab.
$query_table = mysql_query("describe $table") or die(mysql_error());
while(($table_desc[] = mysql_fetch_assoc($query_table)) || array_pop($table_desc));

$iid=0;
do {
	$row_table_desc[]=$table_desc[$iid]['Field'];
	$row_table_desc=array_intersect($row_table_desc,explode(",",$wanted_fields));
	$row_table_desc=array_values($row_table_desc);
	$iid=$iid+1;
} while ($iid<count($table_desc));
$totalRows_table_desc = count($row_table_desc);

$culumn_width=$table_width/($totalRows_table_desc+1);

##hier frage ich die eigentlichen Daten der Tabelle ab. 
//zuerst wird ein where-statment gebaut.
$iiw=0;
do {
	$name="input_".$iiw;
	if(${$name}!=""){$where_clause.= $row_table_desc[$iiw]." like '%".${$name}."%' and ";}
	$iiw=$iiw+1;
} while ($iiw<$totalRows_table_desc); ##increase the counter of the culumn to the next one

if($where_clause!="")
{
	$where_clause=" and ".$where_clause;
	$where_clause=substr($where_clause,0,-4);
}

$start=$page*100;
if($start==0){$start=0;}
$end=$start+100;

$gesamteinträge_query=mysql_query("select count(1) as anz from $table where site_id=$site_id $where_clause");
$gesamteinträge_result=mysql_fetch_assoc($gesamteinträge_query);
$gesamteinträge=$gesamteinträge_result['anz'];
$seitenzahl=ceil($gesamteinträge/100);

if($gesamteinträge>0){

	$query=mysql_query("select $wanted_fields from $table where site_id=$site_id $where_clause order by id limit $start, 100");
	$totalRows_value = mysql_num_rows($query);
	
	if($totalRows_value>100){echo "<b>Es werden nur die ersten 100 Ergebnisse angezeigt.</b><br><br>";}
	$totalRows_value=min($totalRows_value,100);
	
	$iie=0;
	$email=array();
	do{////Alle Emails werden ausgegeben
		mysql_data_seek($query, $iie); ## points to the value-query and gets the row.
		$email_result = mysql_fetch_assoc($query);
		array_push($email,$email_result['email']);
		$iie=$iie+1;
	} while($iie < $totalRows_value);
	
	$emails=implode("; ",$email);
	?>
	
	<div id="table_result_error_messages"></div>
	<? //Seitenselector
	$iip=1;
	if($seitenzahl>1)
	{
		do{?>
			<a href="newsletter_admin.php?page=<? echo $iip-1;?>" style="margin-left:10px;">S.<? echo $iip;?></a>
			<? $iip=$iip+1;
		} while($iip <= $seitenzahl);
	}
	?>
	<br />
	<br />
	<textarea cols="327" rows="3" id="emails" onFocus="this.select()" style="font-size:8px;"><? echo $emails;?></textarea>
	<br />
	<br />
	<table border="0" style="border-spacing:0px">
		<tr>
			<form target="_self" method="post">
				<? $iis=0;/////////////Suchfelder
				do {
					$name="input_".$iis;?>
					<td width="<? echo floor($culumn_width);?>">
						<input type="text" style="width:<? echo floor($culumn_width)-5; ?>px; border-spacing:0px;" name="<? echo "input_".$iis;?>" value="<? echo ${$name};?>">
					</td>
				<? $iis=$iis+1;
				} while ($iis<$totalRows_table_desc); ##increase the counter of the culumn to the next one?>  
				<td>
					<input type="submit" value="suche"/>
				</td>
			</form>
		</tr>
	</table>
	<br />
	<table id="<? echo $table;?>" width="<? echo $table_width; ?>" border="0" bgcolor="#FFFFFF" rules="all" frame=BOX class="fixed">
		<tr>
			<? $iih=0;///////Header
			do {?>
				<th width="<? echo floor($culumn_width);?>">
					<?
					echo wordwrap($row_table_desc[$iih],5,"&#8203;",true); ## takes the first field of the description table and of the row pointed to.
					?>
				</th>
			<? $iih=$iih+1;
			} while ($iih<$totalRows_table_desc); ##increase the counter of the culumn to the next one?>  
			<th width="<? echo floor($culumn_width);?>"></th>
		</tr>
		<?php
		$i=0; ##set the row counter to zero
		do { ?>
			<tr>
				<form id='$table' method="post">
					<? $ii=0; ## set culumn counter to zero
					do { ?>
						<td style="width:'<? echo floor($culumn_width);?>px'; text-align:center;">
							<div style="width:'<? echo floor($culumn_width);?>px'; overflow:hidden;">
								<?
								$Field = $row_table_desc[$ii]; ## takes the first field of the description table and of the row pointed to.
						
								mysql_data_seek($query, $i); ## points to the value-query and gets the row.
								$row_value = mysql_fetch_row($query);?>
								
								<!--create a div with a readonly element which has "_div" at the end-->
								<div id="<? echo $Field;?>_<?php echo $row_value[0]; ?>_div"><?php echo $row_value[$ii];?></div>
							</div>
						</td>
						<? $ii=$ii+1;
					} while ($ii<$totalRows_table_desc); ##increase the counter of the culumn to the next one?>  
				
					<td style="width:'<? echo floor($culumn_width);?>px'; text-align:center;">
						<input name="delete" type="button" onClick="deleteRow(this,'<? echo $table;?>',<? echo $row_value[0]; ?>)" value="del"/>
					</td>
				</form>
			</tr>
			<? $i=$i+1; ## increase the counter to the next row.
		} while ($i<$totalRows_value); ?>
	</table>
	<?  
	mysql_free_result($query);
} 	else{echo "<br><b>Es wurden keine Newsletter-Empfänger gefunden.</b><br><br>";}

?>
<div id="table_result_error_messages" style="height:5px";></div>
</body>
</html>