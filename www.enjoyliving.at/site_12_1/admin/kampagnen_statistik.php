<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
if(test_right($_SESSION['user'],"edit_kampagnen")!="true")
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
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px;"><a href="kampagnen_admin.php">Kampagne anlegen</a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
		<!--Taste Ende--> 
		<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px"><a href="kampagnen_code_admin.php">Kampagnencodes</a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
		<!--Taste Ende--> 
		<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px; font-weight:bolder; text-decoration:underline">Statistik</div>
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
<div style="clear:left;"> </div>
<?
function array_sum_key( $arr, $index = null ){
    if(!is_array( $arr ) || sizeof( $arr ) < 1){
        return 0;
    }
    $ret = 0;
    foreach( $arr as $id => $data ){
        if( isset( $index )  ){
            $ret += (isset( $data[$index] )) ? $data[$index] : 0;
        }else{
            $ret += $data;
        }
    }
    return $ret;
}
?>
<?
$Kampagnen_query=mysql_query("select * from kampagnen where site_id=$site_id") or die (mysql_error());
$Kampagnen_total_rows = mysql_num_rows($Kampagnen_query);
?>
<table border=0>
	<tr>
		<td width="250" align="right"><? if($kampagne!="" and $kampagne!="unselected") {echo "Verfügbare Kampagnen:";} else {echo "Zuerst Kampagne auswählen";}?></td>
		<td align="left"><form method="post" name="form_kampagne">
				<select style="width:400px;" name="kampagne" onChange="document.forms['form_kampagne'].submit()">
					<option value="unselected">Kampagne auswählen</option>
					<? if($Kampagnen_total_rows > 0)
					{
						while($row = mysql_fetch_assoc($Kampagnen_query))
						{
							if($row[id]==$kampagne)
							{echo "<option selected='selected' value=\"$row[id]\">$row[description]</option>";}
							else
							{echo "<option value=\"$row[id]\">$row[description]</option>";}
						}
					} 
					else 
					{echo "<option value=\"unselected\">Kein Element vorhanden</option>";}?>
				</select>
			</form></td>
	</tr>
	<? 
	if($kampagne!="" and $kampagne!="unselected"){
		$kampagne_select_query=mysql_query("select id,description,startdate,enddate from kampagnen where id='$kampagne'") or die (mysql_error());
		$kampagnen_select=mysql_fetch_row($kampagne_select_query);
		$kampagne_active=$kampagnen_select[1];/// das ist der Name der gewählten Kampagne!
	
		$kampagnen_code_query=mysql_query("select id, description from kampagnen_code where kampagnen_id='$kampagne'") or die (mysql_error());
		$kampagnen_code_total_rows = mysql_num_rows($kampagnen_code_query);

		?>
		<tr>
			<td align="right"><? if($kampagnen_code!="" and $kampagnen_code!="unselected") {echo "Verfügbare Kampagnen Codes:";} else {echo "Bitte Kampagnen Code auswählen:";}?></td>
			<td align="left"><form method="post" name="form_kampagnen_code">
					<select style="width:400px;" name="kampagnen_code" onChange="document.forms['form_kampagnen_code'].submit()">
						<option value="unselected">Code auswählen</option>
						<? if($kampagnen_code_total_rows > 0)
							{
								while($row = mysql_fetch_assoc($kampagnen_code_query))
								{
									if($row[id]==$kampagnen_code)
									{echo "<option selected='selected' value=\"$row[id]\">$row[description]</option>";}
									else
									{echo "<option value=\"$row[id]\">$row[description]</option>";}
								}
							} 
							else 
							{echo "<option value=\"unselected\">Kein Element vorhanden</option>";}?>
					</select>
					<input type="hidden" value="<? echo $kampagne?>" name="kampagne"/>
					<input type="hidden" value="<? echo $Jahr?>" name="Jahr"/>
					<input type="hidden" value="<? echo $Monat?>" name="Monat"/>
				</form></td>
		</tr>
			<?
			if($kampagnen_code!="" and $kampagnen_code!="unselected"){
				$kampagnen_code_query=mysql_query("select description from kampagnen_code where id='$kampagnen_code'") or die (mysql_error());
				$kampagnen_code_select=mysql_fetch_row($kampagnen_code_query);
				$kampagne_code_active=$kampagnen_code_select[0];/// das ist der Name des gewählten Codes!
			
				$kampagnen_element_query=mysql_query("select kampagnen_element.id, kampagnen_element.element_id as element_id, element_layout.description from kampagnen_element, element_layout, element where kampagnen_element.kampagnen_code_id='$kampagnen_code' and element.id=kampagnen_element.element_id and element.element_layout_id=element_layout.id") or die (mysql_error());
				$kampagnen_element_total_rows = mysql_num_rows($kampagnen_element_query);
				?>
			<tr>
				<td align="right"><? if($kampagnen_element!="" and $kampagnen_element!="unselected") {echo "Verfügbare Elemente:";} else {echo "Optional einschränken auf ein Element:";}?></td>
				<td align="left"><form method="post" name="form_kampagnen_element">
						<select style="width:400px;" name="kampagnen_element" onChange="document.forms['form_kampagnen_element'].submit()">
							<option value="unselected">Element auswählen</option>
							<? if($kampagnen_element_total_rows > 0)
								{
									while($row = mysql_fetch_assoc($kampagnen_element_query))
									{
										if($row[element_id]==$kampagnen_element)
										{echo "<option selected='selected' value=\"$row[element_id]\">$row[element_id] | $row[description]</option>";}
										else
										{echo "<option value=\"$row[element_id]\">$row[element_id] | $row[description]</option>";}
									}
								} 
								else 
								{echo "<option value=\"unselected\">Kein Element vorhanden</option>";}?>
						</select>
						<input type="hidden" value="<? echo $kampagne?>" name="kampagne"/>
						<input type="hidden" value="<? echo $kampagnen_code?>" name="kampagnen_code"/>
						<input type="hidden" value="<? echo $Jahr?>" name="Jahr"/>
						<input type="hidden" value="<? echo $Monat?>" name="Monat"/>
					</form></td>
			</tr>
			<tr height="15">
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2"><? /////////Ausgabe der gefundenen Kampagne / Elemente
						$kampagnen_element_query=mysql_query("select element_layout.description from kampagnen_element, element_layout, element where kampagnen_element.element_id='$kampagnen_element' and element.id=kampagnen_element.element_id and element.element_layout_id=element_layout.id") or die (mysql_error());
						$kampagnen_element_select=mysql_fetch_row($kampagnen_element_query);
						$kampagnen_element_active=$kampagnen_element_select[0];/// das ist der Name des gewählten Codes!
						
						//echo "Dzt. ausgew. Kampagne: <b>".$kampagne_active."</b><br>";
						//echo "Dzt. ausgew. Code: <b>".$kampagne_code_active."</b><br><br>";
						//if($kampagnen_element_active!=""){ echo "Dzt. ausgew. Element: <b>".$kampagnen_element." | ".$kampagnen_element_active."</b><br><br>";}
						?></td>
			</tr>
			<tr>
				<td colspan="2"><br>
					Enhaltener Code:<br></td>
			</tr>
			<tr>
				<td colspan="2" style='width:100%;border-width:1px 0px 1px 0px;border-style:dotted;border-color:#ADAAAA; height:1px;'><?
					$kampagnen_element_query=mysql_query("select code from kampagnen_code where id='$kampagnen_code'") or die ("Kampagnen Query".mysql_error());
					
					$kampagnen_element_text=mysql_fetch_row($kampagnen_element_query);
					$code=$kampagnen_element_text[0];
					$code=str_replace("...tagopen...","&lt;",$code);
					$code=str_replace("...tagclose...","&gt;",$code);
					
					echo "$code";
					?>
				</td>
			</tr>
			<tr height="15">
				<td colspan="2"></td>
			</tr>
		</table>
		<? 
		$heute=date("Y-m-d");
		$heute_Jahr=date("Y");
		$heute_Monat=date("M");
		
		if($Jahr==""){$Jahr=$heute_Jahr;}
		if($Monat==""){$Monat=$heute_Monat;}
		if($Tage==""){$Tage=date("t",strtotime($Jahr."-".$Monat."-01"));}
		//Monate auffüllen
		for($i=1;$i<13;++$i)
		{
			$Monatesname=date("M",strtotime($Jahr."-".$i."-01"));
			$Tagesanzahl=date("t",strtotime($Jahr."-".$i."-01"));
			$Monat_avail[$i]=array($Monatesname,$Tagesanzahl); 
		}
		
		?>
		<form method="post" name="Jahr" style="float:left; width:100px">
			<select style="width:100px; text-align:right" name="Jahr" onChange="document.forms['Jahr'].submit()">
				<option <? if ($Jahr=='2011'){echo "selected";}?> value="2011">2011</option>
				<option <? if ($Jahr=='2012'){echo "selected";}?> value="2012">2012</option>
				<option <? if ($Jahr=='2013'){echo "selected";}?> value="2013">2013</option>
			</select>
			<input type="hidden" value="<? echo $kampagne?>" name="kampagne"/>
			<input type="hidden" value="<? echo $kampagnen_code?>" name="kampagnen_code"/>
			<input type="hidden" value="<? echo $kampagnen_element?>" name="kampagnen_element"/>
			<input type="hidden" value="<? echo $Monat?>" name="Monat"/>
		</form>
		<form method="post" name="Monat" style="float:left; width:100px">
			<select style="width:100px; text-align:right" name="Monat" onChange="document.forms['Monat'].submit()">
				<? for($i=1;$i<13;++$i){?>
				<option <? if($Monat==$Monat_avail[$i][0]) {echo "selected=\"selected\"";} ?> value="<? echo $Monat_avail[$i][0];?>"><? echo $Monat_avail[$i][0];?></option>
				<? }?>
			</select>
			<input type="hidden" value="<? echo $kampagne?>" name="kampagne"/>
			<input type="hidden" value="<? echo $kampagnen_code?>" name="kampagnen_code"/>
			<input type="hidden" value="<? echo $kampagnen_element?>" name="kampagnen_element"/>
			<input type="hidden" value="<? echo $Jahr?>" name="Jahr"/>
		</form>
		<?
		$stat_dat=date("Y-m-d",strtotime($Jahr."-".$Monat."-01"));
		$stat_dat2=date("Y-m-d",strtotime($Jahr."-".$Monat."-".$Tage));
				
		if($kampagnen_element!="unselected" and $kampagnen_element!="")
		{    $statistik_query=mysql_query("select date, sum(count) as Anz, day(date) as db_dat from kampagnen_statistik where kampagnen_statistik.kampagnen_code_id='$kampagnen_code' and kampagnen_element_id='$kampagnen_element' and date>= '$stat_dat' and date <= '$stat_dat2' group by date") or die ("Statistik Query hat nicht funktioniert: ".$mysql_error());}
		else{$statistik_query=mysql_query("select date, sum(count) as Anz, day(date) as db_dat from kampagnen_statistik where kampagnen_statistik.kampagnen_code_id='$kampagnen_code' and date>= '$stat_dat' and date <= '$stat_dat2' group by date") or die ("Statistik Query hat nicht funktinoiert: ".$mysql_error());}
		while(($statistik_result[] = mysql_fetch_assoc($statistik_query)) || array_pop($statistik_result));
		?>
		<div style="clear:left; height:15px"></div>
		<table>
			<tr>
				<td width="100" align="left">Datum</td>
				<td width="150" align="left">Kampagne</td>
				<td width="150" align="left">Code</td>
				<? if($kampagnen_element!="unselected" and $kampagnen_element!=""){?><td width="250" align="left">Element</td><? }?>
				<td width="50" align="right">Anzahl</td>
			</tr>
			<? for($i=1;$i<$Tage+1;++$i){
				if($i<10){$ii = sprintf("%02d",$i);}else{$ii=$i;}
				if($Monat!=""){$Monat = date("m",strtotime($Jahr."-".$Monat."-01"));}
				$Datumszeile=$Jahr."-".$Monat."-".$ii;
				?>
				<tr>
					<td width="100" align="left"><? echo $Datumszeile ;?></td>
					<td width="150" align="left"><? echo $kampagne_active ;?></td>
					<td width="150" align="left"><? echo $kampagne_code_active ;?></td>
					<? if($kampagnen_element!="unselected" and $kampagnen_element!=""){?><td width="250" align="left"><? echo $kampagnen_element." | ".$kampagnen_element_active ;?></td><? }?>
					<td width="50" align="right"><? for($iii=0;$iii<count($statistik_result);$iii++){if($statistik_result[$iii][date]==$Datumszeile){echo $statistik_result[$iii][Anz];}}?></td>
				</tr>
			<? } //Ende Loop der Zeilen?>
				<tr>
					<td style='border-width:1px 0px 1px 0px;border-style:solid;border-color:#ADAAAA; height:1px;'><b>Summe:</b></td>
					<td colspan="4" align="right" style='border-width:1px 0px 1px 0px;border-style:solid;border-color:#ADAAAA; height:1px;'><? echo "<b>".array_sum_key($statistik_result,"Anz")."</b>"?></td>
				</tr>
		<? } //Ende if Kampagnen_Code wurde ausgewählt?>
	<? } //Ende if Kampagen wurde ausgewählt?>
</table>




