<a name="advertorial"></a>

<?
if($_SERVER['PHP_SELF']=='/site_12_1/admin/admin_V1.php')/////wenn das advertorial im content ist.
{
	$target_url='/site_12_1/admin/admin_V1.php?menu_id='.$menu_id.'#advertorial';
	if($zeige->id==""){$kampagne_element_id=$element_id_sub;}else{$kampagne_element_id=$zeige->id;}
	if($zeige->element_layout_id==""){$element_layout_id[$kampagne_element_id]=$element_layout_id_sub;}else{$element_layout_id[$kampagne_element_id]=$zeige->element_layout_id;}
}
elseif($_SERVER['PHP_SELF']=='/site_12_1/admin/papa/menu.php'){/////wenn das advertorial im menu ist.
	if($ergebnis->id==""){$menu_id=230;}else{$menu_id=$ergebnis->id;}
/*	$menu_element_query=mysql_query("select element.id from element, element_layout where menu_id=$menu_id and element_layout_id=element_layout.id and kampagnentauglich=1 and element_layout") or die (mysql_error());
	if(mysql_num_rows($menu_element_query)!=1)
	{echo "Datenstruktur f Hauptmenü fehlerhaft. Es ist entweder kein, oder mehr als ein Element verfügbar.";}
	else{$menu_element_result=mysql_fetch_assoc($menu_element_query);$kampagne_element_id=$menu_element_result['id'];}
*/	$target_url='/site_12_1/admin/papa/menu.php?sponsortask=edit_sposorbanner&menu_id='.$menu_id.$navstring.'#advertorial';
	}
elseif($_SERVER['PHP_SELF']=="/site_12_1/admin/seitencontent_admin_V1.php")/////wenn das advertorial im seitencontent ist.
{
	$target_url='/site_12_1/admin/seitencontent_admin_V1.php?menu_id='.$menu_id.'#advertorial';
	if($zeige->id==""){$kampagne_element_id=$element_id_sub;}else{$kampagne_element_id=$zeige->id;}
	if($zeige->element_layout_id==""){$element_layout_id[$kampagne_element_id]=$element_layout_id_sub;}else{$element_layout_id[$kampagne_element_id]=$zeige->element_layout_id;}
}
//////////////////////// POST FUNCTIONS

if($UpdateKampagnenauswahl[$kampagne_element_id]==1)
{
	$UpdateKampagnenauswahl[$kampagne_element_id]=0;
	$Kampagne[$kampagne_element_id]=$Kampagne_neu[$kampagne_element_id];
	$Kampagne_ist_angelegt_step1[$kampagne_element_id]=1;
}

if($UpdateCodeauswahl[$kampagne_element_id]==1)
{
	$UpdateCodeauswahl[$kampagne_element_id]=0;
	if(($Kampagnencode_neu[$kampagne_element_id]=="deleteKampagne" or $Kampagnencode_neu[$kampagne_element_id]=="andereKampagne"))
	{
		$remove_query=mysql_query("delete from kampagnen_element where element_id='$kampagne_element_id'") or die ("remove did not work: ".mysql_error());
		$Kampagne[$kampagne_element_id]="";
		$Kampagne_neu[$kampagne_element_id]="";
		$Kampagnencode[$kampagne_element_id]="";
		$Kampagne_ist_angelegt_step1[$kampagne_element_id]=0;
	}
	else
	{
		$Kampagnencode[$kampagne_element_id]=$Kampagnencode_neu[$kampagne_element_id];
	}
	
	if($test_query_num_rows[$kampagne_element_id]>0)//prüft nur, ob es schon einen Eintrag in der Kampagnen_element Tabelle gibt. Wenn nicht, wird ein Eintrag erstellt.
		{$update_query=mysql_query("update kampagnen_element set kampagnen_code_id='$Kampagnencode[$kampagne_element_id]' where element_id='$kampagne_element_id'") or die ("x1".mysql_error());}
	elseif($test_query_num_rows[$kampagne_element_id]==0 and $Kampagnencode_neu[$kampagne_element_id]!="deleteKampagne" and $Kampagnencode_neu[$kampagne_element_id]!="andereKampagne")
		{$insert_query=mysql_query("insert into kampagnen_element (kampagnen_code_id,element_id) values('$Kampagnencode[$kampagne_element_id]','$kampagne_element_id')") or die ("x2".mysql_error());}
}


////////////////////////Vorbereitende Abfrage
//1) Wenn es schon einen Eintrag f das Element gibt, was sind die Details?
$update_test_query=mysql_query("select id from kampagnen_element where element_id='$kampagne_element_id'") or die ("x3".mysql_error());
$test_query_num_rows[$kampagne_element_id]=mysql_num_rows($update_test_query); 

if($test_query_num_rows[$kampagne_element_id]>0)
{
	$Kampagne_ist_angelegt[$kampagne_element_id]=1;
		
	$Kampanendetails_query=mysql_query("select kampagnen.description as kampagnen_description, code.description as code_description, kampagnen.id as kampagnen_id, code.id as code_id from kampagnen,(select id, kampagnen_id, kampagnen_code.description from kampagnen_code,(select kampagnen_code_id from kampagnen_element where element_id='$kampagne_element_id') as element where element.kampagnen_code_id=kampagnen_code.id group by kampagnen_id) as code where code.kampagnen_id=kampagnen.id") or die ("Kampagnenselektor load geht nicht: ".mysql_error());
	$Kampanendetails_result=mysql_fetch_assoc($Kampanendetails_query);
	$Kampagne_description[$kampagne_element_id]=$Kampanendetails_result[kampagnen_description];
	$Kampagne[$kampagne_element_id]=$Kampanendetails_result[kampagnen_id];
	$Kampagnencode_description[$kampagne_element_id]=$Kampanendetails_result[code_description];
	$Kampagnencode[$kampagne_element_id]=$Kampanendetails_result[code_id];
	$Kampagne_ist_angelegt_step1[$kampagne_element_id]=1;
}

//2) Alle f. das Layout verfügbaren Kampagnen werden geladen.
$avail_kampagnen_query=mysql_query("select id, description from kampagnen where site_id=$site_id and id in (select kampagnen_id from kampagnen_code where element_layout_id='$element_layout_id[$kampagne_element_id]')") or die ("Kampagnenselektor load geht nicht: ".mysql_error());
$avail_kampagnen_query_num_rows[$kampagne_element_id]=mysql_num_rows($avail_kampagnen_query);

//3) Alle f. Layout und Kampagne verfügbare Codes werden geladen.
$avail_code_query=mysql_query("select id, description from kampagnen_code where kampagnen_id='$Kampagne[$kampagne_element_id]' and element_layout_id='$element_layout_id[$kampagne_element_id]'") or die ("Kampagnenselektor load geht nicht: ".mysql_error());
$avail_code_query_num_rows[$kampagne_element_id]=mysql_num_rows($avail_code_query);


////////////////////Selectoren
//Zuerst Kampagne auswählen
?><div><?
	if($avail_kampagnen_query_num_rows[$kampagne_element_id] >0){
	?>
		<form name="Kampagnenauswahl_<? echo $kampagne_element_id?>" method="post" action="<? echo $target_url; ?>" style="width:80px;">
			<select name="Kampagne_neu[<? echo $kampagne_element_id?>]" style="width:200px" onchange="if(this.value == 'Kampagne ausw.'){} else {document.forms['Kampagnenauswahl_<? echo $kampagne_element_id?>'].submit()}" <? if($Kampagne_ist_angelegt[$kampagne_element_id]==1 or $Kampagne_ist_angelegt_step1[$kampagne_element_id]==1){echo "disabled";}?>>
				<option value="Kampagne ausw.">Kampagne ausw.</option>
				<? while($Kampagne_result=mysql_fetch_assoc($avail_kampagnen_query))
				{
					if ($Kampagne_result[id]==$Kampagne[$kampagne_element_id] or $Kampagne_result[id]==$selected_Kampagne_id[$kampagne_element_id])
					{echo "<option selected value='$Kampagne_result[id]'>$Kampagne_result[description]</option>";}
					else {echo "<option value='$Kampagne_result[id]'>$Kampagne_result[description]</option>";}
				}
				?>
			</select>
			<input name="Kampagnencode[<? echo $kampagne_element_id?>]" type="hidden" value="<? echo $Kampagnencode[$kampagne_element_id];?>">
			<input name="Kampagne[<? echo $kampagne_element_id?>]" type="hidden" value="<? echo $Kampagne[$kampagne_element_id];?>">
			<input name="kampagne_element_id" type="hidden" value="<? echo $kampagne_element_id;?>">
			<input name="element_layout_id[<? echo $kampagne_element_id?>]" type="hidden" value="<? echo $element_layout_id[$kampagne_element_id];?>">
			<input name="test_query_num_rows[<? echo $kampagne_element_id?>]" type="hidden" value="<? echo $test_query_num_rows[$kampagne_element_id];?>">
			<input name="UpdateKampagnenauswahl[<? echo $kampagne_element_id?>]" type="hidden" value="1" />
		</form>
		<br />
	<? }
	else {echo "<b>Keine Kampagne verfügbar</b>";echo "<br><br></div>";return;}	
	
	?>
	<form name="Codeauswahl_<? echo $kampagne_element_id?>" method="post" action="<? echo $target_url; ?>" style="width:80px;">
		<select name="Kampagnencode_neu[<? echo $kampagne_element_id?>]" style="width:200px" onchange="if(this.value == 'Kampagnencode ausw.'){} else {document.forms['Codeauswahl_<? echo $kampagne_element_id?>'].submit()}" <? if(!$Kampagne_ist_angelegt_step1[$kampagne_element_id]){echo "disabled";}?>>
			<option value="Kampagnencode ausw.">Kampagnencode ausw.</option>
			<option value="andereKampagne">Andere Kampagne wählen</option>
			<option value="deleteKampagne">Kampagne löschen</option>
			<? while($Kampagne_code_result=mysql_fetch_assoc($avail_code_query))
			{
				if ($Kampagne_code_result[id]==$Kampagnencode_neu[$kampagne_element_id] or $Kampagne_code_result[id]==$Kampagnencode[$kampagne_element_id])
				{echo "<option selected value='$Kampagne_code_result[id]'>$Kampagne_code_result[description]</option>";}
				else {echo "<option value='$Kampagne_code_result[id]'>$Kampagne_code_result[description]</option>";}
			}
			?>
		</select>
		<input name="Kampagnencode[<? echo $kampagne_element_id?>]" type="hidden" value="<? echo $Kampagnencode[$kampagne_element_id];?>">
		<input name="Kampagne[<? echo $kampagne_element_id?>]" type="hidden" value="<? echo $Kampagne[$kampagne_element_id];?>">
		<input name="kampagne_element_id" type="hidden" value="<? echo $kampagne_element_id;?>">
		<input name="element_layout_id[<? echo $kampagne_element_id?>]" type="hidden" value="<? echo $element_layout_id[$kampagne_element_id];?>">
		<input name="test_query_num_rows[<? echo $kampagne_element_id?>]" type="hidden" value="<? echo $test_query_num_rows[$kampagne_element_id];?>">
		<input name="UpdateCodeauswahl[<? echo $kampagne_element_id?>]" type="hidden" value="1" />
	</form>

<? 
if(	$Kampagne_ist_angelegt[$kampagne_element_id]==1){
	echo "<br>Enhaltener Code:<br>";	
	?>
	</div>
	<div style='width:100%;border-width:1px 0px 1px 0px;border-style:dotted;border-color:#ADAAAA;'>
		<?
		//////////////////////////////////////////7Ausgabe
		//Zuerst den anzuzeigenden code laden
		//dann die ...tags... wieder zurÃ¼ckkonvertieren
		//dann ausgeben
		//danach die Statistik dazu
		
		$kampagnen_element_query=mysql_query("select code from kampagnen_code, kampagnen,kampagnen_element where element_layout_id ='$element_layout_id[$kampagne_element_id]' and kampagnen_element.element_id='$kampagne_element_id' and kampagnen.id=kampagnen_code.kampagnen_id and kampagnen_code.id=kampagnen_element.kampagnen_code_id and (now() > startdate or enddate ='0000-00-00') and (now() < enddate or enddate ='0000-00-00')") or die ("Kampagnen Query".mysql_error());
		$kampagnen_element_text=mysql_fetch_row($kampagnen_element_query);
		$code=$kampagnen_element_text[0];
		$code=str_replace("...tagopen...","&lt;",$code);
		$code=str_replace("...tagclose...","&gt;",$code);
		
		echo "$code";
}?>
</div>
<br>