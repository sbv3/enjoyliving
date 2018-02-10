<a name="gewinnspiele" id="gewinnspiele"></a>
<h1>Gewinnspiele</h1>

<?
####Übersicht
$heute = date("Y-m-d");
$self=find_googleurl($active_menu_id);
if ($subpage=="")
{
	$resultx = mysql_query("SELECT * FROM gewinnspiele WHERE  aktiv='1' and von <='$heute' and bis >= '$heute' and gewinnspiel_typ='Gewinnspiel' and site_id=$site_id")or die("No");
	$ergebnis=mysql_num_rows($resultx);
	if ($ergebnis=="0")
	{echo"<br>Zur Zeit gibt es leider keine Gewinnspiele.";}
	else
	{echo"<br><strong>Gewinnen Sie Monat für Monat schöne Preise bei unseren Gewinnspielen. Zur Zeit können Sie an folgenden Gewinnspielen teilnehmen:</strong><br/><br/><br/>";}
	while ($showx=mysql_fetch_object($resultx))
	{
		?>
		<div style='float:left;width:200px;'>
			<a href="<? echo $self.'/'.$showx->id; ?>">
				<img src='<? echo $showx->bild?>' border='0' style="margin-left:5px;">
			</a>
		</div>
		<div style='float:left;width:300px;padding-left:5px'>
			<a href="<? echo $self.'/'.$showx->id; ?>" style='font-weight:bold;font-size:12px;color:#F4AF08'>
				<? echo $showx->titel;?>
			</a>
			<br/><br/><? echo $showx->shorttext;?><br/><br/>
			<a href="<? echo $self.'/'.$showx->id; ?>">mehr...</a>
		</div>
		<div style='clear:left;height:8px'></div>
		<div class="trenner"></div>
		<?
	}

	####Detail
}
else
{
	$resultx = mysql_query("SELECT * FROM gewinnspiele WHERE id='$subpage' and aktiv='1' and von <='$heute' and bis >= '$heute'  and gewinnspiel_typ='Gewinnspiel' and site_id=$site_id")or die("No");
	$ergebnis=mysql_num_rows($resultx);
	if ($ergebnis=="0"){echo"Dieses Gewinnspiel ist leider bereits abgelaufen.";}
	while ($showx=mysql_fetch_object($resultx))
	{
		echo"<strong>$showx->titel</strong><br><br>";
		####
		if ($eintrag=="1")
		{
			###überprüfen ob code stimmt
			$securecode1=md5($securecode);
			if ($securecode1=="$Codetext1")
			{
				#####eintragen
				$gewinnspiel=GetSQLValueString($gewinnspiel,"int");
				$antwort=GetSQLValueString($antwort,"text");
				$anrede=GetSQLValueString($anrede,"text");
				$vorname=GetSQLValueString($vorname,"text");
				$nachname=GetSQLValueString($nachname,"text");
				$strasse=GetSQLValueString($strasse,"text");
				$plz=GetSQLValueString($plz,"int");
				$ort=GetSQLValueString($ort,"text");
				$land=GetSQLValueString($land,"text");
				$email=GetSQLValueString($email,"text");
				$anmerkung=GetSQLValueString($anmerkung,"text");
								
				mysql_query("INSERT INTO gewinnspiel_teilnehmer (gewinnspiel_id, antwort, anrede, vorname, nachname, strasse, plz, ort, land, email, anmerkung, IP, site_id) 
				VALUES ($gewinnspiel,$antwort,$anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,$anmerkung,'$REMOTE_ADDR',$site_id)")or die("1Could not connect with the table $dbtable...");

				####newsletter
				$result1 = mysql_query("SELECT * FROM newsletter WHERE email=$email")or die("Kann keine Datenbankverbindung herstellen!");
				$ergebniscount = mysql_num_rows($result1);
				if ($ergebniscount=="0"){					
					mysql_query("INSERT INTO newsletter (anrede, vorname, nachname, strasse, plz, ort, land, email, Reisen, Wellness, Beauty, Gesundheit, Fitness, Geist_Seele, Ernaehrung, Alternativmedizin, Frau_Familie, Natur_Umwelt, Home_Living,gewinnspiel) 
					VALUES ($anrede,$vorname,$nachname,$strasse,$plz,$ort,$land,$email,1,1,1,1,1,1,1,1,1,1,1,$gewinnspiel)")or die("2Could not connect with the table $dbtable...");
			}
			#####text
			echo"<b>Vielen Dank f&uuml;r Ihre Teilnahme!</b><br>Wir w&uuml;nschen Ihnen viel Gl&uuml;ck bei der Verlosung!";
			}
			else
			{
				$stop="1";
				echo"<font color='#FF0000'>Der von Ihnen eingegebene Sicherheitscode stimmt leider nicht mit unserem Code überein. Bitte wiederholen Sie die Eingabe!</font><br><br>";
			}
		}
		
		if (($eintrag=="1" and $stop=="1") or $eintrag!="1")
		{
		echo"$showx->text<br/><br/><strong>Die Gewinnspielfrage:</strong><br/>$showx->frage<br/><br/>"; ?>
		<script language="JavaScript"><!--
		function checkform (fbe){
			if (fbe.antwort.value == "") {
				alert( "Bitte geben Sie eine Antwort ein!" );
				fbe.antwort.focus();
				return false ;
			}
			if (fbe.vorname.value == "") {
				alert( "Bitte geben Sie Ihren Vornamen ein!" );
				fbe.vorname.focus();
				return false ;
			}
			if (fbe.nachname.value == "") {
				alert( "Bitte geben Sie Ihren Nachname ein!" );
				fbe.nachname.focus();
				return false ;
			}
			if (fbe.strasse.value == "") {
				alert( "Bitte geben Sie Ihre Adresse ein!" );
				fbe.strasse.focus();
				return false ;
			}
			 if (fbe.plz.value == "") {
			 alert( "Bitte geben Sie Ihre Postleitzahl ein!" );
			 fbe.plz.focus();
			 return false ;
			 }
			 if (fbe.ort.value == "") {
			 alert( "Bitte geben Sie Ihren Wohnort ein!" );
			 fbe.ort.focus();
			 return false ;
			 }
			 if (fbe.land.value == "0") {
			 alert( "Bitte geben Sie Ihr Land ein!" );
			 fbe.land.focus();
			 return false ;
			 }
			if (fbe.email.value == "") {
				alert( "Bitte geben Sie Ihre E-Mail Adresse ein!" );
				fbe.email.focus();
				return false ;
			}
			 if(fbe.email.value.indexOf('@')==-1||fbe.email.value.indexOf('.')==-1)
			{
			alert ("Die eingegebene Email-Adresse ist keine gültige Email-Adresse!");
			fbe.email.focus();
			return false
			}
			if (fbe.securecode.value == "") {
				alert( "Bitte geben Sie den Sicherheitscode ein!" );
				fbe.securecode.focus();
				return false ;
			}
			if (fbe.agb.checked == false) {
				alert( "Bitte akzeptieren Sie die Teilnahmebedingungen des Gewinnspiels!" );
				fbe.agb.focus();
				return false ;
			}
			// ** END **
			return true ;
		}
		//--></script>
		<table width="100%" border="0" cellpadding="3" cellspacing="3" bgcolor="#DAECF6" style="border-width:1px;border-style:solid;border-color:#006699">
			<tr>
				<td>
					Bitte f&uuml;llen Sie unten  unten stehendes Teilnahmeformular aus, um sich so f&uuml;r die Teilnahme am Gewinnspiel zu registrieren
					<?
					$Codetext="";
					$pool="";
					$pool .= "123456789";
					srand ((double)microtime()*1000000);
					for($index = 0; $index < 5; $index++)
					{$Codetext .= substr($pool,(rand()%(strlen ($pool))), 1);}
					$Codetext1=md5($Codetext);
					?>
					<br />
					<form target="_self" method="post" name="fbe" id="fbe" onsubmit="return checkform(this);">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="19%" height="25">Antwort<b><font color="#FA7000">*</font></b></td>
								<td width="81%" height="25"><input name="antwort" type="text" class="form-normal" id="antwort" style="font-family: Verdana; font-size: 8pt;" value="<? echo"$antwort";?>" size="43" maxlength="50" /></td>
							</tr>
							<tr>
							  <td width="19%" height="25">Anrede<b><font color="#FA7000">*</font></b></td>
							  <td width="81%" height="25"><select name="anrede" id="anrede" style="font-family: Verdana; font-size: 8pt;" >
								<option value="Frau">Frau</option>
								<option value="Herr">Herr</option>
								</select>
							  </td>
							</tr>
							<tr>
								<td width="19%" height="25">Vorname<b><font color="#FA7000">*</font></b></td>
								<td width="81%" height="25"><input name="vorname" type="text" class="form-normal" id="vorname" style="font-family: Verdana; font-size: 8pt;" value="<? echo"$vorname";?>" size="43" maxlength="50" /></td>
							</tr>
							<tr>
								<td height="25">Nachname<b><font color="#FA7000">*</font></b></td>
								<td height="25">
									<input name="nachname" type="text" class="form-normal" id="nachname" style="font-family: Verdana; font-size: 8pt;" value="<? echo"$nachname";?>" size="43" maxlength="50" />
								</td>
							</tr>
							<tr>
								<td height="25">Strasse<b><font color="#FA7000">*</font></b></td>
								<td height="25">
									<input name="strasse" type="text" class="form-normal" id="strasse" style="font-family: Verdana; font-size: 8pt;" value="<? echo"$strasse";?>" size="43" maxlength="50" />
								</td>
							</tr>
							<tr>
								<td height="25">PLZ/Ort<b><font color="#FA7000">*</font></b></td>
								<td height="25">
									<input name="plz" type="text" class="form-normal" id="plz" style="font-family: Verdana; font-size: 8pt;" value="<? echo"$plz";?>" size="10" maxlength="50" />
									<input name="ort" type="text" class="form-normal" id="ort" style="font-family: Verdana; font-size: 8pt;" value="<? echo"$ort";?>" size="32" maxlength="50" />
								</td>
							</tr>
							<tr>
								<td height="25">E-Mail-Adresse<b><font color="#FA7000">*</font></b></td>
								<td height="25">
									<input type="text" class="form-normal" name="email" style="font-family: Verdana; font-size: 8pt;" size="43" maxlength="50" value="<? echo"$email";?>" />
							</tr>
							<tr>
								<td height="25">Land<b><font color="#FA7000">*</font></b></td>
								<td height="25">
									<label>
										<select name="land" id="land" style="font-family: Verdana; font-size: 8pt;">
											<option value="AT" selected="selected">&Ouml;sterreich</option>
											<option value="DE">Deutschland</option>
											<option value="CH">Schweiz</option>
											<option value="LU">Luxemburg</option>
										</select>
									</label>
								</td>
							</tr>
							<tr>
								<td valign="top">Anmerkung:</td>
								<td><textarea name="anmerkung" cols="40" rows="6" class="form-normal" id="anmerkung" style="font-family: Verdana; font-size: 8pt;"><? echo"$anmerkung";?></textarea></td>
							</tr>
							<tr>
								<td colspan="2"><br />
									Bitte geben Sie in 
									das unten stehende Feld den daneben dargestellten 
									Sicherheitscode ein. Mit diesem Schritt verhindern 
									wir automatische Registrierungen.<br />
									<br />
								</td>
							</tr>
							<tr>
								<td><img src="/page/image.php?Codetext=<?echo"$Codetext";?>" /></td>
								<td>
									<input type="text" class="form-normal" name="securecode" style="font-family: Verdana; font-size: 8pt;" size="20" maxlength="50" id="securecode" />
									<input name="Codetext1" type="hidden" id="Codetext1" value="<?echo"$Codetext1";?>" />
									<input name="gewinnspiel" type="hidden" id="gewinnspiel" value="<? echo"$showx->id";?>" />
									<input type="hidden" name="eintrag" value="1" />
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top">
									<span class="abstand">
										<input type="checkbox" name="agb" value="1" id="agb" />
									</span> 
									Ich akzeptiere die untenstehenden Teilnahmebedingungen 
									und ich bin damit einverstanden, in regelm&auml;&szlig;igen 
									Abst&auml;nden den Newsletter von EnjoyLiving 
									per E-Mail zu erhalten. 
									Ihre &uuml;bermittelten Daten werden vertraulich 
									behandelt und nicht an Dritte weitergegeben. 
									
									Das Einverst&auml;ndnis kann ich jederzeit und 
									ohne Angabe von Gr&uuml;nden widerrufen.<br />
									<br />
									<span class="smallfont"><b>Teilnahmebedingungen</b>: <? echo"$showx->teilnahmebe";?></span>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<span class="abstand">
										<br />
										<input type="submit" value="Am Gewinnspiel teilnehmen" name="submit" />
									</span>
								</td>
							</tr>
						</table>
					</form>
					<span class="abstand">Mit einem <b><font color="#FA7000">*</font></b> gekennzeichnete Felder sind Pflichtfelder</span>
					<br />
				</td>
			</tr>
		</table>
		<? 
		}  
	} 
}
?>