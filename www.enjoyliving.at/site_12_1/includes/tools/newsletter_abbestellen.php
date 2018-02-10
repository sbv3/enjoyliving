<a name="newsletter" id="newsletter"></a>
<h1>Newsletter abbestellen</h1>
<br />
<table width="98%" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top"><?
		
		$email=GetSQLValueString($email,"text");
			if ($abmelden=="2")
			{
				$dbtable= "newsletter";
				$result1 = mysql_query("SELECT * FROM $dbtable WHERE email=$email and NO_werbemail not like '1' and site_id=$site_id")or die("Kann keine Datenbankverbindung herstellen!");
				$ergebnis_count1 = mysql_num_rows($result1);
				if ($ergebnis_count1=="0"){echo "Die von Ihnen eingegebene E-Mail Adresse ist nicht in unserem Newsletter-Verteiler vorhanden.<br><br>";}
				else
				{
					while ($xx=mysql_fetch_object($result1)){$olddate="$xx->datum";}
					$jetzt = date("Y-m-d H:i:s");
					$update1 = mysql_query("UPDATE $dbtable SET NO_werbemail='1',NO_Date='$jetzt',datum='$olddate' WHERE email=$email and site_id=$site_id");
					echo "Die von Ihnen eingegebene Email Adresse <b>$email</b> wurde aus unserem Newsletter-Verteiler für Zusendungen unserer Kooperationspartner entfernt. Sie erhalten weiterhin unseren Newsletter, der Sie über aktuelle Magazinbeiträge informiert.";
					$supi="1";
				}
			}
			###########################
			if ($abmelden=="1")
			{
				$dbtable= "newsletter";
				$result = mysql_query("SELECT * FROM $dbtable WHERE email=$email and NO not like '1' and site_id=$site_id")or die("Kann keine Datenbankverbindung herstellen!");
				$ergebnis_count = mysql_num_rows($result);
				if ($ergebnis_count=="0")
				{echo "Die von Ihnen eingegebene E-Mail Adresse ist nicht in unserem Newsletter-Verteiler vorhanden.<br><br>";}
				else
				{
					while ($xx=mysql_fetch_object($result)){$olddate="$xx->datum";}
					$jetzt = date("Y-m-d H:i:s");
					$update1 = mysql_query("UPDATE $dbtable SET NO='1',NO_werbemail='1',NO_Date='$jetzt',datum='$olddate' WHERE email=$email and site_id=$site_id");
					echo "Die von Ihnen eingegebene Email Adresse <b>$email</b> wurde aus unserem Newsletter-Verteiler entfernt.";
					$supi="1";
				}
			}
			if ($supi!="1")
			{?>
				<script language="JavaScript"><!--
				function checkform ( orderform )
				{
				 if (orderform.email.value == "") {
				 alert( "Bitte geben Sie Ihre E-Mail Adresse ein!" );
				 orderform.email.focus();
				 return false ;
				 }
				 // ** END **
				 return true ;
				}
				//--></script> 
				<img src="/page/guide/blank.gif" width="1" height="1" name="bild">
				</td>
			</tr>
			<tr>
				<td valign="top">
					<table class="table2" width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
						<tr>
							<td bgcolor="white">
								<b>Sie m&ouml;chten den Newsletter abbestellen?</b><br>
								<br>Wenn Sie in Zukunft von uns <strong>weiterhin den 2-wöchentlich erscheinenden EnjoyLiving-Newsletter</strong>, der Sie über aktuelle Magazinbeiträge informiert, beziehen wollen, jedoch <strong>keine Zusendungen, die  wir im Auftrag unserer Kooperationspartner verschicken</strong>, mehr erhalten wollen,  können Sie Sie sich hier mit Ihrer E-Mail Adresse abmelden: <br>
								<br>
								<form name="orderform" onSubmit="return checkform(this);" method="post" target="_self">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width="150" height="25"><div align="left">Email-Adresse <b><font color="#FA7000">*</font></b></div></td>
											<td width="200"><div align="left">
													<input name="email" type="text" class="form-normal" id="email" style="font-family: Verdana; font-size: 7pt;" value="<?echo"$newsletter";?>" size="30">
												</div>
											</td>
											<td><input type="submit" value="abbestellen" style="color:black;font-size:8pt;background-image:url(/well/guide/img/button_bg.gif);background-repeat:repeat-x;padding-left:8px;padding-right:8px;padding-top:1px;padding-bottom:1px;border:1px solid #999999;" name="Newsletter2">
												<input name="abmelden" type="hidden" id="abmelden" value="2">
											</td>
										</tr>
									</table>
								</form>
								<br>
								<br>
								Wenn Sie in Zukunft von uns <strong>keinerlei elektronische Zusendungen</strong> mehr erhalten wollen,   können Sie Sie sich hier mit Ihrer E-Mail Adresse abmelden: <br>
								<br>
								<form name="orderform" onSubmit="return checkform(this);" method="post" target="_self">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width="100" height="25"><div align="left">Email-Adresse <b><font color="#FA7000">*</font></b></div></td>
											<td width="200"><div align="left">
													<input type="text" name="email" value="<?echo"$newsletter";?>" class="form-normal" style="font-family: Verdana; font-size: 7pt;" size="30">
												</div>
											</td>
											<td><input type="submit" value="abbestellen" style="color:black;font-size:8pt;background-image:url(/well/guide/img/button_bg.gif);background-repeat:repeat-x;padding-left:8px;padding-right:8px;padding-top:1px;padding-bottom:1px;border:1px solid #999999;" name="Newsletter">
												<input type="hidden" name="abmelden" value="1">
											</td>
										</tr>
									</table>
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="top">
			<? }?>
		</td>
	</tr>
</table>