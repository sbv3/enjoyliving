<a name="gewinnspiele" id="gewinnspiele"></a>
<p class="titel">Gru&szlig;karten - verschicken Sie einen lieben Gru&szlig;</p>
Mit unserem elektronischen Gru&szlig;karten-Service                       k&ouml;nnen Sie netten Menschen schnell und unkompliziert                       einen originellen oder lieben Gru&szlig; zukommen lassen.<br />
<br /><br />

<?
####Übersicht
$heute = date("Y-m-d");
$self=$_SERVER['REQUEST_URI'];
if ($subpage==""){
	$resultx = mysql_query("SELECT * FROM ecards WHERE  aktiv='1' and site_id=$site_id")or die("No");
	while ($showx=mysql_fetch_object($resultx))
	{
		echo"<div style='float:left;width:200px;padding-right:10px'><a href='$self&subpage=$showx->id'><img src='/site_12_1/assets/ecards/preview/$showx->preview' border='0'></a></div><div style='float:left'><a href='$self&subpage=$showx->id'>$showx->titel</a></div><div style='clear:left;height:10px'></div>";
	}
		?>
	<? 
	####Detail
	}else{
	if ($getcode==""){
		###ecard eerstellen und mail veeschicken
		if ($checkergebnis!="$ergebnischeck"){$eintrag="";$error=1;}
		if ($error=="1"){echo "Leider wurde die Rechenaufgabe zur Vermeidung von Mißbrauch nicht richtig gelöst. Bitte probieren Sie es noch einmal!<br><br>";}
		if ($eintrag=="1"){
		$pwd=rand(1000,9999);
		$text=nl2br($text);
		$text=addslashes($text);
		mysql_query("INSERT INTO ecards_post (name_an, email_an, name_von, email_von, karte, text, code) 
		VALUES ('$name_an', '$email_an', '$name_von', '$email_von', '$ecard', '$text', '$pwd')")or die("Could not connect with the table $dbtable...");
		#mail
		$header = "MIME-Version: 1.0\r\n";
		$header = "Return-Path: office@enjoyliving.at\n";
		$header .= "X-Sender: office@enjoyliving.at\n";
		$header .= "From: EnjoyLiving <office@enjoyliving.at>\n";
		$header .= "Bcc: office@enjoyliving.at\n";
		$header .= "X-Mailer:PHP 5.1\n";
		$header .= "MIME-Version: 1.0\n";
		$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$text = "<br>
		Liebe(r) $name_an !<br><br>
		$name_von (<a href='mailto: $email_von'>$email_von</a>) hat Ihnen eine Grußkarte geschickt.<br><br>
		Sie können die Grußkarte innerhalb der nächsten 14 Tage unter <a href='$href_root$self&getcode=$pwd'>$href_root</a> abrufen.<br><br>
		Sollte dies nicht funktionieren, gehen Sie bitte zu <a href='$href_root$self&getcode=$pwd'>$href_root$self&getcode=$pwd</a> und fügen dort diesen Code
		in das dafür vorgesehene Feld ein:<br><br>
		$pwd
		<br><br>
		Mit lieben Grüßen,<br><br>Ihr EnjoyLiving Team";
		$betreff="EnjoyLiving - Grußkarte";
		if (mail("$email_an", "$betreff", "$text", $header))
		{echo "<strong>Ihre Grußkarte wurde erfolgreich verschickt und ist ab sofort unter <a href='$href_root$self&getcode=$pwd'>$href_root$self&getcode=$pwd</a> abrufbar.</strong>";}
		
		}else{
		//subpage != aber getcode=""
		?>
		Bitte f&uuml;llen Sie einfach die Felder aus und klicken Sie danach auf den Button &quot;Gru&szlig;karten verschicken&quot;!<br />
		<br />
		<script language="JavaScript"><!--
		function checkform ( orderform )
		{
		 if (orderform.name_an.value == "") {
		 alert( "Bitte füllen Sie das Feld Name aus!" );
		 orderform.name_an.focus();
		 return false ;
		 }
		 if (orderform.email_an.value == "") {
		 alert( "Bitte füllen Sie das Feld Email aus!" );
		 orderform.email_an.focus();
		 return false ;
		 }
		 if(orderform.email_an.value.indexOf('@')==-1||orderform.email_an.value.indexOf('.')==-1)
		{
		alert ("Die eingegebene Email-Adresse ist keine gültige Email-Adresse!");
		orderform.email_an.focus();
		return false
		}
		 if (orderform.name_von.value == "") {
		 alert( "Bitte füllen Sie das Feld Name aus!" );
		 orderform.name_von.focus();
		 return false ;
		 }
		 if (orderform.email_von.value == "") {
		 alert( "Bitte füllen Sie das Feld Email aus!" );
		 orderform.email_von.focus();
		 return false ;
		 }
		 if(orderform.email_von.value.indexOf('@')==-1||orderform.email_von.value.indexOf('.')==-1)
		{
		alert ("Die eingegebene Email-Adresse ist keine gültige Email-Adresse!");
		orderform.email_von.focus();
		return false
		}
		 if (orderform.ergebnis.value == "") {
		 alert( "Bitte beantworten Sie die Sicherheitsabfrage!" );
		 orderform.ergebnis.focus();
		 return false ;
		 }
		 
		 // ** END **
		 return true ;
		}
		//--></script><form name="orderform" onSubmit="return checkform(this);" method="post" target="_self">
		<div style='border-style:solid;border-width:1px;border-color:#999999'>
			<div style='padding:5px;background-color:#CCCCCC'>
				<div style='background-color:#ffffff;padding-bottom:5px'>
				<?
		$resultx = mysql_query("SELECT * FROM ecards WHERE  id='$subpage' ")or die("No");
		while ($showx=mysql_fetch_object($resultx))
		{echo"$showx->code";}
				?></div>
		<div style='background-color:#ffffff;width:100%'>
		<div style='float:left;width:50%;background-color:#ffffff;padding:5px'>
			<textarea name="text"  style="font-family: Verdana; font-size: 8pt;" cols="40" rows="15"><? echo "$text";?></textarea>
			<input name="eintrag" type="hidden" id="eintrag" value="1" />
			<input name="subpage" type="hidden" id="subpage" value="<? echo"$subpage";?>" />
		</div><div style='float:left; background-color:#ffffff; padding:5px;'>
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="100"><b>An</b></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Name</td>
				<td><input type="text" name="name_an" class="form-normal" style="font-family: Verdana; font-size: 8pt;" size="25" value="<? echo "$name_an";?>" /></td>
			</tr>
			<tr>
				<td>E-Mail</td>
				<td><input type="text" name="email_an" class="form-normal" style="font-family: Verdana; font-size: 8pt;" size="25" value="<? echo "$email_an";?>" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><b>Von</b></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Name</td>
				<td><input type="text" name="name_von" class="form-normal" style="font-family: Verdana; font-size: 8pt;" size="25" value="<? echo "$name_von";?>" /></td>
			</tr>
			<tr>
				<td>E-Mail</td>
				<td><input type="text" name="email_von" class="form-normal" style="font-family: Verdana; font-size: 8pt;" size="25" value="<? echo "$email_von";?>" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><span style="height:140px;">Sicherheitsfrage<br />
					<? $zahla= rand(1,10);
		$zahlb=rand(1,10);
		$zahlc=$zahla+$zahlb; echo"$zahla + $zahlb =";?>
						<input name="checkergebnis" id="checkergebnis" size="3" maxlength="2" />
						<input name="ergebnischeck" type="hidden" id="ergebnischeck" value="<? echo"$zahlc";?>" />
				</span></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="Submit" style="color:black;font-size:8pt;padding-left:8px;padding-right:8px;padding-top:1px;padding-bottom:1px;border:1px solid #999999;" value="Gru&szlig;karte verschicken" /></td>
				</tr>
		</table>
		</div>
		
		<div style='clear:left'></div>
			</div></div></div></form>
		<? }
	}else{
		//abrufen der ecard
		$result = mysql_query("SELECT * FROM ecards_post WHERE code='$getcode' ")or die("No");
		while ($show=mysql_fetch_object($result))
		{
		?>Gru&szlig;karte abholen: <form name="orderform" method="post" target="_self">
			Code: 
			<input name="getcode" type="text" class="form-normal" id="getcode" style="font-family: Verdana; font-size: 8pt;" value="<? echo "$getcode";?>" size="25" />
			<input type="submit" name="Submit2" style="color:black;font-size:8pt;padding-left:8px;padding-right:8px;padding-top:1px;padding-bottom:1px;border:1px solid #999999;" value="Gru&szlig;karte abholen" />
		<input name="subpage" type="hidden" id="subpage" value="<? echo"$subpage";?>" /></form>
		<br />
		<br />
		
		<div style='border-style:solid;border-width:1px;border-color:#999'>
			<div style='padding:5px;background-color:#CCC'>
				<div style='background-color:#ffffff;padding-bottom:5px'>		<?
		$resultx = mysql_query("SELECT * FROM ecards WHERE  id='$subpage' ")or die("No");
		while ($showx=mysql_fetch_object($resultx))
		{echo"$showx->code";}
		#Bild/Flash - 602 px
				?></div>
				<div style='background-color:#ffffff;'>
				<div style='float:left;width:50%;padding:5px;font-family:Comic Sans MS;font-style:italic'><? echo"$show->datum: <br>$show->text";?></div>
				<div style='float:left;padding:5px'>An:<br />
					<? echo"$show->name_an ($show->email_an)";?><br />
		<br />
		Von:
				<br />
				<? echo"$show->name_von ($show->email_von)";?>
				</div>
				<div style='clear:left'></div>
			</div></div>
		</div>
		<br />
		<a href='<? echo $href_root;?>/tools-magazin/grusskarten-verschicken.html'>Jetzt eine eigene Gru&szlig;karte verschicken!</a><br />
		<? }}}?>
<br />
      <br />
