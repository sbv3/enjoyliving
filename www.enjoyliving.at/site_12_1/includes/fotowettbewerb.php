<? 
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
?> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?
$max_pictures_on_overview_page=12;
$max_pictures_on_page=1; 

if(trace()=="content_V1.php"){$own_url=find_googleurl($menu_id)."?";}
if(trace()=="admin_V1.php"){$own_url="/site_12_1/admin/admin_V1.php?menu_id=".$active_menu_id."&";}
?>
<div style="min-height: 300px; background-color:#ffffff;">
	<?
	/////////////////////////////////////POST f den Gewinnspielselektor
	if($Gewinnspiel_eintragen[$elem_id]==1)
	{ 
		$gewinnspiel_eintrag=$gewinnspiel_id[$elem_id];
		$selected_gewinnspiel_zeile=$selected_gewinnspiel_zeile[$elem_id];
		mysql_query("update element_content_text set text='$gewinnspiel_eintrag' where id='$selected_gewinnspiel_zeile' limit 1") or die ("0.9");
	}
	
	$selected_gewinnspiele_query=mysql_query("select id,text from element_content_text where element_id=$elem_id and sort=10") or die ("1.0");
	$selected_gewinnspiel=mysql_fetch_assoc($selected_gewinnspiele_query);
	$selected_gewinnspiel_id['elem_id']=$selected_gewinnspiel['text'];
	$selected_gewinnspiel_zeile['elem_id']=$selected_gewinnspiel['id'];
	
	if (substr($_SERVER['PHP_SELF'],0,16)=="/site_12_1/admin")
	{
		$avail_gewinnspiele_query=mysql_query("select * from gewinnspiele where now()>=von and now()<=bis and aktiv='1' and gewinnspiel_typ='Fotowettbewerb' and site_id=$site_id") or die ("1.1");
		?>
		<form name="gewinnspielauswahl_<? echo $elem_id?>" method="post" target="_self" style="margin-right:10px;float:left;">
			<select name="gewinnspiel_id[<? echo $elem_id?>]" style="width:200px" onChange="if(this.value == 'Gewinnspiel ausw.'){} else {document.forms['gewinnspielauswahl_<? echo $elem_id?>'].submit()}">
				<? if(mysql_num_rows($avail_gewinnspiele_query)>0){ ?>
					<option value="Gewinnspiel ausw.">Gewinnspiel ausw.</option>
					<? while($avail_gewinnspiele_result=mysql_fetch_assoc($avail_gewinnspiele_query))
					{
						if ($avail_gewinnspiele_result[id]==$selected_gewinnspiel_id['elem_id'])
						{echo "<option selected value='$avail_gewinnspiele_result[id]'>$avail_gewinnspiele_result[titel]</option>";}
						else {echo "<option value='$avail_gewinnspiele_result[id]'>$avail_gewinnspiele_result[titel]</option>";}
					}
				}
				else{echo "<option value='Gewinnspiel ausw.'>Kein Gewinnspiel aktiv</option>";}
				?>
			</select>
			<input name="selected_gewinnspiel_zeile[<? echo $elem_id?>]" type="hidden" value="<? echo $selected_gewinnspiel_zeile['elem_id'];?>">
			<input name="Gewinnspiel_eintragen[<? echo $elem_id?>]" type="hidden" value="1" />
		</form>
		<div class="trenner"></div>
		<? 
	}
	if($selected_gewinnspiel_id['elem_id']!=""){//////////Wenn ein Gewinnspiel ausgewählt wurde, dann...
		///////////////////POST Aufgaben für den Eintrag.
		$stimmeintrag_OK=capture();
		if ($stimmeintrag=="1" and $stimmeintrag_OK==true){
			mysql_query("INSERT INTO gewinnspiel_votes (gewinnspiel_id,teilnehmer_id,IP) VALUES ('$gewinnspiel_id','$teilnehmer_id','$_SERVER[REMOTE_ADDR]')")or die("x");}


		/////Lade alle Gewinnspieldetails:
		$gewinnspiel_query=mysql_query("select * from gewinnspiele where id =".$selected_gewinnspiel_id['elem_id']." limit 1") or die ("1.2");
		$gewinnspiel=mysql_fetch_assoc($gewinnspiel_query);
		$gewinnspiel_titel=$gewinnspiel['titel'];
		$gewinnspiel_titelintern=$gewinnspiel['titelintern'];
		$gewinnspiel_id=$gewinnspiel['id'];
		if($gewinnspiel['von']>=date('Y-m-d') or $gewinnspiel['bis']<=date('Y-m-d') or $gewinnspiel['aktiv']!=1){$gewinnspiel_active=0;}else{$gewinnspiel_active=1;}
		/////////////////Dann zeige die Registerreiter & content an: 
		?>
		<? $row_id=1;
		$imgs_scale_to_fit[$row_id]='true';
		if (substr($_SERVER['PHP_SELF'],0,16)=="/site_12_1/admin"){include("$adminpath/site_12_1/admin/admin_imageeditor.php");}
		else{if($imgs_alt_tag[1]!="default"){echo "<img title='$imgs_alt_tag[1]' alt='$imgs_alt_tag[1]' src='$imgs[1]' style='width:100%'>";}}		
		?>

		<div style='width:100%;background-image:url(<? echo $href_root; ?>/site_12_1/css/Element_Tops_Schatten.png);background-size:contain;height:26px;background-repeat:repeat-x;'>
			<!--Taste-->
			<div class="register_schatten" style="height:25px; width:5px;"></div>
			<div class="register">
				<div class="register_links<? if($gewinnspielmodus=='Fotowettbewerb'){echo "_selected";}?>"></div>
				<div class="register_mitte<? if($gewinnspielmodus=='Fotowettbewerb'){echo "_selected";}?>" style="height:25px;">
					<div style="padding-top:5px;"><a class="register_text" href="<? echo $own_url."gewinnspielmodus=Fotowettbewerb";?>">Fotowettbewerb</a></div>
				</div>
				<div class="register_rechts<? if($gewinnspielmodus=='Fotowettbewerb'){echo "_selected";}?>" style="height:25px;width:5px;"></div>
			</div>
			<div style="clear:right"></div>
			<!--Taste Ende-->
			<!--Taste-->
			<div class="register_schatten" style="height:25px; width:5px;"></div>
			<div class="register">
				<div class="register_links<? if($gewinnspielmodus=='Preise'){echo "_selected";}?>"></div>
				<div class="register_mitte<? if($gewinnspielmodus=='Preise'){echo "_selected";}?>" style="height:25px;">
					<div style="padding-top:5px;"><a class="register_text" href="<? echo $own_url."gewinnspielmodus=Preise";?>">Preise</a></div>
				</div>
				<div class="register_rechts<? if($gewinnspielmodus=='Preise'){echo "_selected";}?>" style="height:25px;width:5px;"></div>
			</div>
			<div style="clear:right"></div>
			<!--Taste Ende-->
			<? if($gewinnspiel_active!=1){} else
			{?>
				<!--Taste-->
				<div class="register_schatten" style="height:25px; width:5px;"></div>
				<div class="register">
					<div class="register_links<? if($gewinnspielmodus=='Teilnehmen'){echo "_selected";}?>"></div>
					<div class="register_mitte<? if($gewinnspielmodus=='Teilnehmen'){echo "_selected";}?>" style="height:25px;">
						<div style="padding-top:5px;"><a class="register_text" href="<? echo $own_url."gewinnspielmodus=Teilnehmen";?>">Teilnehmen</a></div>
					</div>
					<div class="register_rechts<? if($gewinnspielmodus=='Teilnehmen'){echo "_selected";}?>" style="height:25px;width:5px;"></div>
				</div>
				<div style="clear:right"></div>
				<!--Taste Ende-->
			<? }?>
			<!--Taste-->
			<div class="register_schatten" style="height:25px; width:5px;"></div>
			<div class="register">
				<div class="register_links<? if($gewinnspielmodus=='Galerie' or $gewinnspielmodus=='Galeriedetail'){echo "_selected";}?>"></div>
				<div class="register_mitte<? if($gewinnspielmodus=='Galerie' or $gewinnspielmodus=='Galeriedetail'){echo "_selected";}?>" style="height:25px;">
					<div style="padding-top:5px;"><a class="register_text" href="<? echo $own_url."gewinnspielmodus=Galerie";?>">Galerie</a></div>
				</div>
				<div class="register_rechts<? if($gewinnspielmodus=='Galerie' or $gewinnspielmodus=='Galeriedetail'){echo "_selected";}?>" style="height:25px;width:5px;"></div>
			</div>
			<div style="clear:right"></div>
			<!--Taste Ende-->
			<!--Taste-->
			<div class="register_schatten" style="height:25px; width:5px;"></div>
			<div class="register">
				<div class="register_links<? if($gewinnspielmodus=='Gewinner'){echo "_selected";}?>"></div>
				<div class="register_mitte<? if($gewinnspielmodus=='Gewinner'){echo "_selected";}?>" style="height:25px;">
					<div style="padding-top:5px;"><a class="register_text" href="<? echo $own_url."gewinnspielmodus=Gewinner";?>">Gewinner</a></div>
				</div>
				<div class="register_rechts<? if($gewinnspielmodus=='Gewinner'){echo "_selected";}?>" style="height:25px;width:5px;"></div>
			</div>
			<div style="clear:right"></div>
			<!--Taste Ende-->
		</div>
		<div style="clear:left;"></div>
	
		<?
		if($gewinnspielmodus=="Fotowettbewerb" or $gewinnspielmodus=="")
		{	
			$field="text"; $table="element_content_text"; $row_id="2"; $TXT_breite="616"; $rows="30"; $FCK_breite="616";
			if (substr($_SERVER['PHP_SELF'],0,16)=="/site_12_1/admin"){include("$adminpath/site_12_1/admin/admin_editor.php");}
			else{echo "<div class='$texts_style[$row_id]'>$texts[$row_id]</div>";}
		}
		?>
		<?
		if($gewinnspielmodus=="Preise")
		{
			$field="text"; $table="element_content_text"; $row_id="3"; $TXT_breite="616"; $rows="30"; $FCK_breite="616";
			if (substr($_SERVER['PHP_SELF'],0,16)=="/site_12_1/admin"){include("$adminpath/site_12_1/admin/admin_editor.php");}
			else{echo "<div class='$texts_style[$row_id]'>$texts[$row_id]</div>";}
		}
		?>
		<?
		if($gewinnspielmodus=="Teilnehmen")
		{
			if($gewinnspiel_active!=1){echo "<br>Dieses Gewinnspiel ist bereits abgelaufen. Es ist keine weitere Teilnahme mehr möglich.";} else
			{?><div style="margin-top:10px;"></div><?
				/////////////////////Post Funktionen für Teilnehmen:
				### Eintrag aufnehmen:
				if ($eintrag=="1"){
					####Eingaben prüfen: Asset duplette
					####Eingabe prüfen: email duplette
					##$email_test=mysql_query("select id from gewinnspiel_teilnehmer where gewinnspiel_id=$gewinnspiel_id and email='$email'") or die ("1.4");
					##if(mysql_num_rows($email_test)>0){$stopper="2";}
	
					#######Überprüfen ob filename leer
					if ($filename1==""){$stopper="3";} 
					else {
						$img_md5=md5_file($filename1);
						$hash_test=mysql_query("select id from assets where hash_sha256='$img_md5'") or die ("1.3");
						if(mysql_num_rows($hash_test)>0){$stopper="1";}
						$size_x = getimagesize($filename1);
						####Eingabe prüfen: Filesize
						if($filename1_size >  2097152){$stopper="4";} 
						####Eingabe prüfen: Bild größe
						if ($size_x[0] >="800"){$stopper="5";}
						if ($size_x[1] >="800"){$stopper="6";}
						####Eingabe prüfen: Filetype
						#Grafik-Typ - 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF
						if($size_x[2]!="2"){$stopper="7";} 
					}
	
					####Eingabe prüfen: Berechnung
					if ($ergebnis!="$ergebnischeck"){$stopper="8";}
	
					////Fehlermeldungen ausspucken:
					if ($stopper=="1"){echo "<br>Dieses File wurde bereits einmal hochgeladen.<br><br>";}
					elseif ($stopper=="2"){echo "<br>Sie haben bereits unter dieser Email-Adresse teilgenommen.<br><br>";}
					elseif ($stopper=="3"){echo "<br>Es wurde keine Datei hochgeladen.<br><br>";}
					elseif ($stopper=="4"){echo "<br>Die Datei ist größer als 2MB. Bitte verkleinern Sie das Bild.<br><br>";}
					elseif ($stopper=="5"){echo "<br>Das bild ist Breiter als 800px. Bitte reduzieren Sie die Größe.<br><br>";}
					elseif ($stopper=="6"){echo "<br>Das bild ist Höher als 800px. Bitte reduzieren Sie die Größe.<br><br>";}
					elseif ($stopper=="7"){echo "<br>Das bild ist nicht vom jpg-Dateiformat. Bitte ändern Sie das Format auf jpg.<br><br>";}
					elseif ($stopper=="8"){echo "<br>Leider wurde die Rechenaufgabe zur Vermeidung von Mißbrauch nicht richtig gelöst. Bitte probieren Sie es noch einmal!<br><br>";}
					elseif ($stopper=="0" or $stopper==""){
						$anrede=GetSQLValueString($anrede,"text");
						$vorname=GetSQLValueString($vorname,"text");
						$nachname=GetSQLValueString($nachname,"text");
						$strasse=GetSQLValueString($strasse,"text");
						$plz=GetSQLValueString($plz,"int");
						$ort=GetSQLValueString($ort,"text");
						$land=GetSQLValueString($land,"text");
						$email=GetSQLValueString($email,"text");
						
						mysql_query("insert into gewinnspiel_teilnehmer 
						(gewinnspiel_id, anrede, vorname, nachname, strasse, plz, ort, land, email, IP, site_Id) values 
						('$gewinnspiel_id', $anrede, $vorname, $nachname, $strasse, $plz, $ort, $land, $email, '$REMOTE_ADDR',$site_id)") or die ("1.5: ");
	
						$teilnehmerID_query=mysql_query("select LAST_INSERT_ID() as id") or die ("1.6");
						$teilnehmerID_result=mysql_fetch_assoc($teilnehmerID_query);
						$teilnehmerID=$teilnehmerID_result['id'];
						
						####newsletter
						$result1 = mysql_query("SELECT * FROM newsletter WHERE email=$email and site_id=$site_id")or die("1.7");
						$ergebniscount = mysql_num_rows($result1);
						if ($ergebniscount=="0"){
							mysql_query("INSERT INTO newsletter (anrede, vorname, nachname, strasse, plz, ort, land, email, Reisen, Wellness, Beauty, Gesundheit, Fitness, Geist_Seele, Ernaehrung, Alternativmedizin, Frau_Familie, Natur_Umwelt, Home_Living,gewinnspiel,site_id) 
							VALUES ($anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,1,1,1,1,1,1,1,1,1,1,1,$gewinnspiel_id,$site_id)")or die("2Could not connect with the table $dbtable...");
						}
											
						$titel=GetSQLValueString($titel,"text");
						$kommentar=GetSQLValueString($kommentar,"text");
						
						mysql_query("insert into element_content_text (element_id,text,editor,style_tag,sort) values('$elem_id',$titel,'TXT','einleitung',$teilnehmerID*10)") or die ("1.71");
						mysql_query("insert into element_content_text (element_id,text,editor,style_tag,sort) values('$elem_id',$kommentar,'TXT','artikeltext',$teilnehmerID*10+1)") or die ("1.72:");
						
						$anhang=".jpg";
						$zz1="_big";
						$zz2="_small";
						$adminpath=$_SERVER['DOCUMENT_ROOT'];
						$verzeichnis="/site_12_1/assets";
						$category="img";
						$class="/fotowettbewerb";
						$type=$gewinnspiel_titelintern;//das kommt von der Gewinnspieltabelle und ist der "titelintern". Es muss ein Ordner dafür bestehen!!!
						$jahr=date("Y");
						$bildname="TN_$teilnehmerID";
						$bildname1="TN_$teilnehmerID$zz1";
						$bildname2="TN_$teilnehmerID$zz2";
						$sizegroup1="big/";
						$sizegroup2="small/";
						$path="/".$site_id."/".$type."/".$jahr."/";
						$path1="/".$site_id."/".$type."/".$jahr."/".$sizegroup1;
						$path2="/".$site_id."/".$type."/".$jahr."/".$sizegroup2;
						###bild uploaden - am schluss nicht auf löschen vergessen
						move_uploaded_file($filename1, $adminpath.$verzeichnis."/".$category.$class.$path.$bildname.$anhang);
						chmod($adminpath.$verzeichnis."/".$category.$class.$path.$bildname.$anhang, 0755);
						###querformat 
						if ($size_x[0]>$size_x[1]){
						$from1 = $adminpath.$verzeichnis."/".$category.$class.$path.$bildname.$anhang;
						$to1a = $adminpath.$verzeichnis."/".$category.$class.$path1.$bildname1.$anhang;
						$to2a = $adminpath.$verzeichnis."/".$category.$class.$path2.$bildname2.$anhang;
						thumb($from1, $to1a, 571,571, TRUE);//with,height
						thumb($from1, $to2a, 190,190, TRUE);//with,height
						}
						######hochformat
						if ($size_x[1]>$size_x[0]){
						$from1 = $adminpath.$verzeichnis."/".$category.$class.$path.$bildname.$anhang;
						$to1a = $adminpath.$verzeichnis."/".$category.$class.$path1.$bildname1.$anhang;
						$to2a = $adminpath.$verzeichnis."/".$category.$class.$path2.$bildname2.$anhang;
						thumb($from1, $to1a, 571, 571, TRUE);
						thumb($from1, $to2a, 150,150, TRUE);//with,height
						}
						######quadrat
						if ($size_x[1]==$size_x[0]){
						$from1 = $adminpath.$verzeichnis."/".$category.$class.$path.$bildname.$anhang;
						$to1a = $adminpath.$verzeichnis."/".$category.$class.$path1.$bildname1.$anhang;
						$to2a = $adminpath.$verzeichnis."/".$category.$class.$path2.$bildname2.$anhang;
						thumb($from1, $to1a, 571, 571, TRUE);
						thumb($from1, $to2a, 150,150, TRUE);//with,height
						}
						$size_large=getimagesize($to1a);
						$breite_large=$size_large[0];
						$hoehe_large=$size_large[1];
						$size_small=getimagesize($to2a);
						$breite_small=$size_small[0];
						$hoehe_small=$size_small[1];
	
						######file löschen
						unlink($adminpath.$verzeichnis."/".$category.$class.$path.$bildname.$anhang);
						###
						$stopper="0";
	
						mysql_query("INSERT INTO assets 
						(keywords,erstelldatum,path,alt_tag,breite,hoehe,jahr,category,class,type,filename,hash_sha256) VALUES 
						($titel,now(),'$path1','fotowettbewerb teilnehmerbild',$breite_large,$hoehe_large,'$jahr','$category','$class','$type','$bildname1$anhang','$img_md5')")or die("1.10");
						
						mysql_query("insert into element_content_img (element_id,assets_ID,type,sort) values('$elem_id',LAST_INSERT_ID(),'$type',$teilnehmerID*10)") or die ("1.11");
	
						mysql_query("INSERT INTO assets 
						(keywords,erstelldatum,path,alt_tag,breite,hoehe,jahr,category,class,type,filename,hash_sha256) VALUES 
						($titel,now(),'$path2','fotowettbewerb teilnehmerbild',$breite_small,$hoehe_small,'$jahr','$category','$class','$type','$bildname2$anhang','$img_md5')")or die("1.12");
						
						mysql_query("insert into element_content_img (element_id,assets_ID,type,sort) values('$elem_id',LAST_INSERT_ID(),'$type',$teilnehmerID*10+1)") or die ("1.11");
											
											
											
						echo"<br><b>Danke für Ihre Teilnahme am Fotowettbewerb!</b> Ihre Daten wurden gespeichert. Ihr Eintrag kann jederzeit ohne Angabe von Gründen von der Redaktion gelöscht werden. Details entnehmen Sie bitte unten angeführten Teilnahmebedingungen.
						<br><br>Ihr Bild finden Sie <a href='".$own_url."gewinnspielmodus=Galeriedetail&my_id=$teilnehmerID#Detail'>hier</a>. Wir wünschen Ihnen für Ihre Teilnahme viel Glück!<br><br>Ihr EnjoyLiving-Team.<br><br>";
	
					}
				}
				if($stopper!="0" or $stopper=="")
				{
			
					$zahla= rand(1,10);
					$zahlb=rand(1,10);
					$zahlc=$zahla+$zahlb;
					?>
					<script type="text/javascript" language="JavaScript">
					<!--
					function checkform(fbe2)
					{
					   if (fbe2.email.value == "") {
					 alert( "Bitte geben Sie Ihre E-Mail Adresse ein!" );
					 fbe2.email.focus();
					 return false ;
					 }
					 if(fbe2.email.value.indexOf('@')==-1||fbe2.email.value.indexOf('.')==-1)
					{
					alert ("Die eingegebene Email-Adresse ist keine gültige Email-Adresse!");
					fbe2.email.focus();
					return false
					}
					  if (fbe2.vorname.value == "") {
					 alert( "Bitte geben Sie Ihren Namen ein!" );
					 fbe2.vorname.focus();
					 return false ;
					 }
					   if (fbe2.nachname.value == "") {
					 alert( "Bitte geben Sie Ihren Namen ein!" );
					 fbe2.nachname.focus();
					 return false ;
					 }
					  if (fbe2.strasse.value == "") {
					 alert( "Bitte geben Sie Ihre Anschrift ein!" );
					 fbe2.strasse.focus();
					 return false ;
					 }
					   if (fbe2.plz.value == "") {
					 alert( "Bitte geben Sie Ihre Postleitzahl ein!" );
					 fbe2.plz.focus();
					 return false ;
					 }
					   if (fbe2.ort.value == "") {
					 alert( "Bitte geben Sie Ihren Wohnort ein!" );
					 fbe2.ort.focus();
					 return false ;
					 }
					   if (fbe2.land.value == "") {
					 alert( "Bitte geben Sie Ihr Land ein!" );
					 fbe2.land.focus();
					 return false ;
					 }
						   if (fbe2.titel.value == "") {
					 alert( "Bitte geben Sie Ihrem Foto einen Titel!" );
					 fbe2.titel.focus();
					 return false ;
					 }
	
					  var ext = document.fbe.filename1.value;
					  ext = ext.substring(ext.length-3,ext.length);
					  ext = ext.toLowerCase();
					  if(ext != 'jpg') {
					 alert( "Bitte laden Sie ein Bild vom Typ .jpg hoch!" );
					 fbe2.titel.focus();
					 return false ;
					 }
					if (fbe2.agb.checked == false) {
					 alert( "Bitte akzeptieren Sie die Teilnahmebedingungen!" );
					 fbe2.agb.focus();
					 return false ;
					 }
						 // ** END **
						return true ;
					}
					//-->
					</script>
					
					
					<form enctype="multipart/form-data" method="post" name="fbe" onSubmit="return checkform(this);">
					  <table style='background-color:#C2E0FA;padding:5px;border-style:solid;border-width:1px;border-color:#709FCD' width="590" border="0" >
						<tr>
						  <td height="20" colspan="3"><div style='color:#73ACE1;font-size: 1.3em; font-family: Georgia, serif;font-style: italic;font-weight:bold;padding-bottom:6px'>Pers&ouml;nliche Angaben</div></td>
						  </tr>
						<tr>
						  <td height="20">E-Mail Adresse*</td>
						  <td width="393" height="20" colspan="2"><input name="email" type="text" class="input" id="email" value="<? echo"$email";?>" size="40" /></td>
						</tr>
						<tr>
						  <td height="20">&nbsp;</td>
						  <td height="20" colspan="2">&nbsp;</td>
						</tr>
						<tr>
						  <td width="185" height="20">Anrede*</td>
						  <td height="20" colspan="2"><select name="anrede" id="anrede">
							<option value="Frau">Frau</option>
							<option value="Herr">Herr</option>
							</select>
						  </td>
						</tr>
						<tr>
						  <td height="20">Vorname*</td>
						  <td height="20" colspan="2"><input name="vorname" type="text" class="input" id="vorname" value="<? echo"$vorname";?>" size="40" /></td>
						</tr>
						<tr>
						  <td height="20">Nachname*</td>
						  <td height="20" colspan="2"><input name="nachname" type="text" class="input" id="nachname" value="<? echo"$nachname";?>" size="40" /></td>
						</tr>
						<tr>
						  <td height="20">Strasse/Nr*</td>
						  <td height="20" colspan="2"><input name="strasse" type="text" class="input" id="strasse" value="<? echo"$strasse";?>" size="40" /></td>
						</tr>
						<tr>
						  <td height="20">PLZ/Ort*</td>
						  <td height="20" colspan="2"><input name="plz" type="text" class="input" id="plz" value="<? echo "$plz";?>" size="10" />
							  <input name="ort" type="text" class="input" id="ort" value="<? echo"$ort";?>" size="27" /></td>
						</tr>
						<tr>
						  <td height="20">Land*</td>
						  <td height="20" colspan="2"><select name="land" id="land">
							<option value="AT" selected="selected">&Ouml;sterreich</option>
							<option value="DE">Deutschland</option>
							<option value="CH">Schweiz</option>
							<option value="LU">Luxemburg</option>
						  </select>      </td>
						</tr>
					  </table>
					  <br />
					  <br />
					  <table style='background-color:#C2E0FA;padding:5px;border-style:solid;border-width:1px;border-color:#709FCD' width="590" border="0" >
						<tr>
						  <td height="20" colspan="3"><div style='color:#73ACE1;font-size: 1.3em; font-family: Georgia, serif;font-style: italic;font-weight:bold;padding-bottom:6px'>Angaben zum Foto</div></td>
						</tr>
						<tr>
						  <td height="20">Fototitel*</td>
						  <td height="20" colspan="2"><input name="titel" type="text" class="input" id="titel" value="<? echo"$titel";?>" size="40" maxlength="19" /></td>
						</tr>
						<tr>
						  <td height="20" valign="top">Kurzkommentar zum Foto<br>(bitte maximal 190 Zeichen)</td>
						  <td height="20" colspan="2"><textarea name="kommentar" maxlength="200"  cols="38" rows="5" class="input" id="kommentar"><? echo"$kommentar";?></textarea></td>
						</tr>
						<tr>
						  <td height="20">Foto*</td>
						  <td height="20" colspan="2"><input type="file"  accept="image/jpeg" name="filename1" style="border-width:1px; border-color:#939598; border-style:solid; border-width: 1px 1px 1px 1px;background-color:#E1E2E3;font-family: Verdana; font-size: 8pt;width:350" /></td>
						</tr>
					  </table>
					  <br />
					  <table style='background-color:#C2E0FA;padding:5px;border-style:solid;border-width:1px;border-color:#709FCD' width="590" border="0" >
						<tr>
						  <td height="20" colspan="3"><div style='color:#73ACE1;font-size: 1.3em; font-family: Georgia, serif;font-style: italic;font-weight:bold;padding-bottom:6px'>Teilnahmebedingungen und Newsletter</div></td>
						</tr>
						<tr>
							<td valign="middle" height="35">Sicherheitsabfrage</td>
							<td><span style="height:140px;"><? echo"$zahla + $zahlb =";?>
								<input name="ergebnis" id="ergebnis" size="3" maxlength="2" />
									<input name="ergebnischeck" type="hidden" id="ergebnischeck" value="<? echo"$zahlc";?>" />
							</span></td>
						</tr>
						<tr>
						  <td height="20"><input name="agb" type="checkbox" id="agb" value="1" /></td>
						  <td width="541" height="20" colspan="2">Ich akzeptiere unten angeführte Teilnahmebedingungen</td>
						</tr>
						<tr>
						  <td height="20"><input name="el_nl" type="checkbox" id="el_nl" value="1" checked="checked" /></td>
						  <td height="20" colspan="2">Ich m&ouml;chte mich f&uuml;r den EnjoyLiving Newsletter anmelden</td>
						</tr>
					  </table>
					  <p><br />
					  <br />
					  <input type="submit" value="&raquo;  Daten speichern und Foto hochladen" style="background-color:#73ACE1;font-weight:bold;color:#ffffff;font-size:10pt;padding-left:8px;padding-right:8px;padding-top:1px;padding-bottom:1px;border:1px solid #999999;" name="submit" id="submit" />
					  <br />
					  <br />
					  Das Foto sollte mindestens 570 Pixel breit und 428 Pixel hoch sein. <br />
					  Das Foto darf jedoch nicht gr&ouml;&szlig;er als 800 Pixel breit und 800 Pixel hoch sein.<br />
					  Die maximale Dateigr&ouml;&szlig;e betr&auml;gt 2 MB, das erlaubte Dateiformat ist jpg.<br />
					  Alle mit einem * markierten Felder sind Pflichtfelder.
					  <br />
					  <input name="eintrag" type="hidden" value="1" />
					  </p>
</form>
				<?
				}?>
				<div class="trenner"></div>
				<div class="einleitung">Teilnahmebedingungen</div>
				<?
				$field="text"; $table="element_content_text"; $row_id="6"; $TXT_breite="616"; $rows="30"; $FCK_breite="616";
				if (substr($_SERVER['PHP_SELF'],0,16)=="/site_12_1/admin"){include("$adminpath/site_12_1/admin/admin_editor.php");}
				else{echo "<div class='$texts_style[$row_id]'>$texts[$row_id]</div>";}
			}
		}?>
		<?
		if($gewinnspielmodus=="Galerie")
		{?>
			<?
			
			$field="text"; $table="element_content_text"; $row_id="4"; $TXT_breite="616"; $rows="30"; $FCK_breite="616";
			if (substr($_SERVER['PHP_SELF'],0,16)=="/site_12_1/admin"){include("$adminpath/site_12_1/admin/admin_editor.php");}
			else{echo "<div class='$texts_style[$row_id]'>$texts[$row_id]</div>";}

			if($order!="" and $direction!=""){$sort_string=" order by $order $direction";} else {$sort_string=" order by datum desc";$order="datum";$direction="desc";}
			if($my_id!=""){$email_suche="";} 
			if($email_suche!=""){$email_suche1=GetSQLValueString($email_suche,"text");$append_string=" and email=$email_suche1";} 

			if($my_id!="") 
			{
				$my_id_test_query=mysql_query("select @rownum:=@rownum+1 row,res.* from (SELECT @rownum:=0) r,(select id from gewinnspiel_teilnehmer where gewinnspiel_teilnehmer.gewinnspiel_id=".$selected_gewinnspiel_id['elem_id'].$append_string." $sort_string) res") or die ("2.0");
				while($my_id_test=mysql_fetch_assoc($my_id_test_query))
				{
					if($my_id==$my_id_test['id'])
					{
						$page=ceil($my_id_test['row']/$max_pictures_on_overview_page);
						break;
					}
				}
			}
			
			if($page==""){$page=1;}
			$start=$page*$max_pictures_on_overview_page-$max_pictures_on_overview_page;
			if(!$start){$start=0;}
			
			$gesamtteilnehmer_query=mysql_query("select count(1) as anz from gewinnspiel_teilnehmer where gewinnspiel_id=".$selected_gewinnspiel_id['elem_id'].$append_string);
			$gesamtteilnehmer_result=mysql_fetch_assoc($gesamtteilnehmer_query);
			$gesamtteilnehmer=$gesamtteilnehmer_result['anz'];
			$seitenzahl=ceil($gesamtteilnehmer/$max_pictures_on_overview_page);

			$participants_details_query=mysql_query("select @rownum:=@rownum+1 row,res.* from (SELECT @rownum:=0) r,(select id, votes.anz from gewinnspiel_teilnehmer left join (select teilnehmer_id, count(1) as anz from gewinnspiel_votes group by teilnehmer_id) as votes on votes.teilnehmer_id=gewinnspiel_teilnehmer.id where gewinnspiel_teilnehmer.gewinnspiel_id=".$selected_gewinnspiel_id['elem_id'].$append_string." $sort_string limit $start, $max_pictures_on_overview_page) res") or die ("2.0");
			$totalRows_value = mysql_num_rows($participants_details_query);

			if($gesamtteilnehmer>$max_pictures_on_overview_page){
				###setup navigation buttons
				$url=$own_url."gewinnspielmodus=Galerie&order=$order&direction=$direction&email_suche=$email_suche&page=";
				if($page==null or $page==1){$page=1;$prev="";} else {$prev1=$page-1;$prev="<a href='$url$prev1#galerie'><img src='$href_root/site_12_1/css/foto_back.gif' border='0'></a>";}
				
				if($page==$seitenzahl){$next="";} else {$next1=$page+1;$next="<a href='$url$next1#galerie'><img src='$href_root/site_12_1/css/foto_vor.gif' border='0'></a>";}
								
				$navi="
				<div style='float:left;width:100px;'>
					$prev &nbsp;
				</div>
				<div style='float:left;width:400px;padding-top:15px;text-align:center'>
					$page von $seitenzahl
				</div>
				<div style='float:left;width:100px;text-align:right'>
					$next &nbsp;
				</div>
				<div style='height:2px;clear:both'>
				</div>";
			}?>
			<div>
				<form target="_self" method="post"  name="overview">
					<div class="trenner"></div>
					<table>
						<tr>
							<td width="200px" align="right">
								Sortieren nach:
							</td>
							<td width="160px" align="left">
								<select name="order" id="order" style="font-size:11px; width:150px;">
									<option value="datum" <? if ($order=="datum"){echo"selected=\"selected\"";}?>>Einstelldatum</option>
									<option value="anz" <? if ($order=="anz"){echo"selected=\"selected\"";}?>>Stimmen gesamt</option>
								</select>
							</td>
							<td>
							</td>
						</tr>
						<tr>
							<td width="200px" align="right">
								Reihenfolge:
							</td>
							<td width="160px" align="left">
								<select name="direction" id="direction" style="font-size:11px; width:150px;">
									<option value="asc" <? if ($direction=="asc"){echo"selected=\"selected\"";}?>>aufsteigend</option>
									<option value="desc" <? if ($direction=="desc"){echo"selected=\"selected\"";}?>>absteigend</option>
								</select>
							</td>
							<td align="left">
							</td>
						</tr>
						<tr>
							<td width="200px" align="right">
								Suche nach Teilnehmer-Email:
							</td>
							<td width="160px" align="left">
								<input name="email_suche" type="text" value="<? echo $email_suche;?>" style="font-size:11px; width:144px;"/>
							</td>
							<td>
								<input type="submit" name="button" id="button" value="aktualisieren" />
							</td>
						</tr>
					</table>
					<div style='clear:left'></div>
					<div class="trenner"></div>
				</form>
			</div>
			<?
			$totalRows_value=min($totalRows_value,$max_pictures_on_overview_page);
			if($totalRows_value==0){echo "<br><b>Keine Teilnehmer gefunden!</b><br><br>";}
			else
			{
				while($participants_details=mysql_fetch_assoc($participants_details_query))
				{
					$teilnehmer_id=$participants_details['id'];
					$img_large_row_id=array_search($participants_details['id']*10,$imgs_sort); 
					$img_small_row_id=array_search($participants_details['id']*10+1,$imgs_sort);
					$Fototitel_row_id=array_search($participants_details['id']*10,$texts_sort);
					$Fotokommentar_row_id=array_search($participants_details['id']*10+1,$texts_sort);

					//echo "TN-ID: ".$teilnehmer_id." | img_large: ".$img_large_row_id." | img_small: ".$img_small_row_id." |titel: ".$Fototitel_row_id." | kommentar: ".$Fotokommentar_row_id."<br><br>";
					?>
					<a name="galerie"></a>
					<div style="float:left; margin-right:3px;margin-left:3px;margin-bottom:6px;width:145px;height:200px; background-color:#E5F1FD; overflow:hidden; border-style:solid; border-width:1px; border-color:#73ACE1;" onMouseOver="this.style.backgroundColor='#73ACE1';this.style.backgroundColor='#73ACE1';document.body.style.cursor='pointer'; document.getElementById('titel_<? echo $teilnehmer_id?>').style.color='#ffffff';changecssproperty(this, shadowprop, '3px 3px 3px rgba(0,0,0,.5)');" onMouseOut="this.style.backgroundColor='#E5F1FD';document.body.style.cursor='default';document.getElementById('titel_<? echo $teilnehmer_id?>').style.color='#73ACE1';changecssproperty(this, shadowprop, '', 'remove');" onClick="location.href='<? echo $own_url."gewinnspielmodus=Galeriedetail&order=$order&direction=$direction&email_suche=$email_suche&page=$page&pagedetail=".($participants_details['row']+(($page-1)*$max_pictures_on_overview_page));?>';" >
						<div style="max-width:145px;height:160px; text-align:center">
							<img title='<? echo $texts[$Fototitel_row_id];?>' alt='<? echo $texts[$Fototitel_row_id];?>' src='<? echo $imgs[$img_small_row_id];?>' style='max-width:139px; max-height:150px; background-color:#666;padding:3px;'>
						</div>
						<div style="width:160px;text-align:center">
							<? 
							echo "<div class='artikelbeschriftung' style='padding-bottom:2px;'>Stimmanzahl: ";if($participants_details[anz]==""){echo "0";}else{echo $participants_details[anz];} echo "</div>";
							echo "<div id='titel_$teilnehmer_id'class='$texts_style[$Fototitel_row_id]' style='padding-bottom:2px;'>$texts[$Fototitel_row_id]</div>";
							?>
						</div>
					</div>
					<?
				}
			}?>
			<div style="clear:both"></div>
			<? echo $navi;
		}
		if($gewinnspielmodus=="Galeriedetail")
		{
			if($gewinnspiel_active!=1){echo "<br>Dieses Gewinnspiel ist bereits abgelaufen. Es ist keine weitere Teilnahme mehr möglich.";} 
			
			if($order!="" and $direction!=""){$sort_string=" order by $order $direction";} else {$sort_string=" order by datum desc";$order="datum";$direction="desc";}
			if($my_id!=""){$email_suche="";} 
			if($email_suche!=""){$email_suche1=GetSQLValueString($email_suche,"text");$append_string=" and email=$email_suche1";} 

			if($my_id!="") 
			{
				$my_id_test_query=mysql_query("select @rownum:=@rownum+1 row,res.* from (SELECT @rownum:=0) r,(select id from gewinnspiel_teilnehmer where gewinnspiel_teilnehmer.gewinnspiel_id=".$selected_gewinnspiel_id['elem_id'].$append_string." $sort_string) res") or die ("2.0");
				while($my_id_test=mysql_fetch_assoc($my_id_test_query))
				{
					if($my_id==$my_id_test['id'])
					{
						$pagedetail=ceil($my_id_test['row']/$max_pictures_on_page);
						break;
					}
				}
			}
			
			if($pagedetail==""){$pagedetail=1;}
			$start=$pagedetail*$max_pictures_on_page-$max_pictures_on_page;
			if(!$start){$start=0;}
			
			$gesamtteilnehmer_query=mysql_query("select count(1) as anz from gewinnspiel_teilnehmer where gewinnspiel_id=".$selected_gewinnspiel_id['elem_id'].$append_string);
			$gesamtteilnehmer_result=mysql_fetch_assoc($gesamtteilnehmer_query);
			$gesamtteilnehmer=$gesamtteilnehmer_result['anz'];
			$seitenzahl=ceil($gesamtteilnehmer/$max_pictures_on_page);
			$participants_details_query=mysql_query("select id, votes.anz from gewinnspiel_teilnehmer left join (select teilnehmer_id, count(1) as anz from gewinnspiel_votes group by teilnehmer_id) as votes on votes.teilnehmer_id=gewinnspiel_teilnehmer.id where gewinnspiel_teilnehmer.gewinnspiel_id=".$selected_gewinnspiel_id['elem_id'].$append_string." $sort_string limit $start, $max_pictures_on_page") or die ("2.0");
			$totalRows_value = mysql_num_rows($participants_details_query);

			if($gesamtteilnehmer>$max_pictures_on_page){
				###setup navigation buttons
				$url=$own_url."gewinnspielmodus=Galeriedetail&order=$order&direction=$direction&email_suche=$email_suche&page=$page&pagedetail=";
				if($pagedetail==null or $pagedetail==1){$pagedetail=1;$prev="";} else {$prev1=$pagedetail-1;$prev="<a href='$url$prev1#Detail'><img src='$href_root/site_12_1/css/foto_back.gif' border='0'></a>";}
				
				if($pagedetail==$seitenzahl){$next="";} else {$next1=$pagedetail+1;$next="<a href='$url$next1#Detail'><img src='$href_root/site_12_1/css/foto_vor.gif' border='0'></a>";}
								
				$navi="
				<div style='float:left;width:100px;'>
					$prev &nbsp;
				</div>
				<div style='float:left;width:400px;padding-top:15px;text-align:center'>
					$pagedetail von $seitenzahl
				</div>
				<div style='float:left;width:100px;text-align:right'>
					$next &nbsp;
				</div>
				<div style='height:2px;clear:both'>
				</div>";
			}
			$totalRows_value=min($totalRows_value,$max_pictures_on_page);?>
				<?
			$participants_details=mysql_fetch_assoc($participants_details_query);
			$teilnehmer_id=$participants_details['id'];
			$img_large_row_id=array_search($participants_details['id']*10,$imgs_sort); 
			$img_small_row_id=array_search($participants_details['id']*10+1,$imgs_sort);
			$Fototitel_row_id=array_search($participants_details['id']*10,$texts_sort);
			$Fotokommentar_row_id=array_search($participants_details['id']*10+1,$texts_sort);
			?>
			<div style="">
				<style type="text/css">
				.wraptocenter {display: table-cell;vertical-align: middle;width: 390px;height: 402px;}
				.wraptocenter * {vertical-align: middle;}
				/*\*//*/
				.wraptocenter {display: block;}
				.wraptocenter span {display: inline-block;height: 100%;width: 1px;}
				/**/
				</style>
				<!--[if lt IE 8]><style>
				.wraptocenter span {display: inline-block;height: 100%;}
				</style><![endif]-->
				<a name="Detail"></a>
				<div style='padding-left: 8px; padding-right: 8px; height: 570px;'>
					<div style="width:390px;">
						<div style="position: absolute; z-index: 50; padding-left: 101px; padding-top: 53px;">
							<div class="wraptocenter" style="background-color:#333333;text-align: center;"><span></span>
							<? 
							$imgs_size_path=$href_root."/".$imgs[$img_large_row_id];
							$imgs_size=getimagesize($imgs_size_path);
							$imgs_breite=$imgs_size[0];
							$imgs_hoehe=$imgs_size[1];
							if(($imgs_breite/$imgs_hoehe)>(390/400)){$style_tag="width:390px";}else{$style_tag="height:400px";}?>
								<img style="<? echo $style_tag; ?>"title='<? echo $texts[$Fototitel_row_id];?>' alt='<? echo $texts[$Fototitel_row_id];?>' src='<? echo $imgs[$img_large_row_id];?>'>
							</div>
						</div>
					</div>
					<img style='position: relative; z-index: 100; padding-left: 71px;' width="450px" src="<? echo $href_root; ?>/site_12_1/assets/img/fotowettbewerb/Fotorahmen.png"><br />
					
					<link rel="image_src" href="<? echo"$href_root/$imgs[$img_large_row_id]";?>" />
					<div class='einleitung' style='position: relative; left: 101px; width: 390px; z-index: 300; top: -112px; overflow: hidden; max-height: 23px; padding-bottom: 0px; text-align: center;'><? echo "Stimmen: ";if($participants_details[anz]==""){echo "0";}else{echo $participants_details[anz];}?></div>
					<div class='titel' style='position: relative; left: 101px; width: 390px; z-index: 300; top: -112px; overflow: hidden; max-height: 23px; text-align: center;'><? echo "Foto: ".$texts[$Fototitel_row_id];?></div>
					<div class='artikeltext' style='position: relative; z-index: 300; top: -111px; left: 85px; width: 424px; overflow: hidden; max-height: 53px; text-align: center;'><? echo $texts[$Fotokommentar_row_id];?></div>
				</div>
				<div>Link zu diesem Fotowettbewerb-Eintrag:<br /> <? $URL1a = $href_root."/".$own_url.("gewinnspielmodus=Galeriedetail&my_id=$teilnehmer_id"); echo"<a href='$URL1a' style='text-align:left;'>$URL1a</a>";?></div><? 
				echo $navi;
				
				if($gewinnspiel_active!=1){} else
				{
					if ($stimmeintrag=="1" and $stimmeintrag_OK==true){
						echo "<div class='einleitung' style='padding-top:14px;text-align:center;'>Deine Stimme wurde erfolgreich abgegeben!</div>";} else {
					if ($stimmeintrag=="1" and $stimmeintrag_OK==false)
						{echo "<div class='warning' style='padding-top:14px;text-align:center;'>ACHTUNG: Bitte gib das Sicherheitswort richtig ein!</div>";}
					if ($stimmeintrag!="1" or ($stimmeintrag=="1" and $stimmeintrag_OK==false)){
					?>
					<div class="einleitung" style="text-align:center; padding-bottom:5px;padding-top:10px;">Gib das Sicherheitswort ein und clicke um Deine Stimme abzugeben!</div>
					<div style="margin-left:91px;">
						<form target="_self" method="post">
							<img src="<? echo "/Connections/captcha.php"?>" border="0" title="Sicherheitscode" style="vertical-align:bottom;">
							<input type="text" name="sicherheitscode" size="5">

							<input type="submit" value="Meine Stimme hast Du!" style="width:180px;margin-top:4px;"/>
							<input type="hidden" name="stimmeintrag" value="1" />
							<input type="hidden" name="order" value="<? echo $order;?>" />
							<input type="hidden" name="direction" value="<? echo $direction;?>" />
							<input type="hidden" name="email_suche" value="<? echo $email_suche;?>" />
							<input type="hidden" name="gewinnspiel_id" value="<? echo $gewinnspiel_id;?>" />
							<input type="hidden" name="teilnehmer_id" value="<? echo $teilnehmer_id;?>" />
							<input type="hidden" name="stimmeintrag" value="1" />
						</form>
					</div>
					<? }}
				} ?>
				<div style="clear:both;"></div>
				<div style='text-align: center; margin-top:10px;'>
				
				
					<? $URL1 = $href_root.$own_url.urlencode("gewinnspielmodus=Galeriedetail&my_id=$teilnehmer_id");?>
					<a href='http://www.facebook.com/sharer.php?u=<? echo"$URL1";?>&t=Gib mir Deine Stimme!' target='_blank'> <img src='<? echo $href_root;?>/site_12_1/assets/img/fotowettbewerb/facebook.jpg' border='0' /></a>
				</div>
				<div style="clear:both"></div>
				<div style='float:left;text-align:right;'>
					<a href="<? 
					echo $url=$own_url."gewinnspielmodus=Galerie&order=$order&direction=$direction&email_suche=$email_suche&page=".ceil($pagedetail/$max_pictures_on_overview_page)."#galerie";?>">&laquo; zurück zur Übersicht</a>
				</div>
				<div style="clear:both"></div>
			</div>
		<? }
		if($gewinnspielmodus=="Gewinner")
		{
			$field="text"; $table="element_content_text"; $row_id="5"; $TXT_breite="616"; $rows="30"; $FCK_breite="616";
			if (substr($_SERVER['PHP_SELF'],0,16)=="/site_12_1/admin"){include("$adminpath/site_12_1/admin/admin_editor.php");}
			else{echo "<div class='$texts_style[$row_id]'>$texts[$row_id]</div>";}
		}
	}
	?>
</div>
<div style="height:12px;"></div>
<? $row_id="";?>