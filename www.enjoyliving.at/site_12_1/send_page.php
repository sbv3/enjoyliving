<?
session_start();
$adminpath=$_SERVER['DOCUMENT_ROOT'];
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");

$menu_id=$active_menu_id;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?
######METATAGS Abfrage der table cache_cms mittels googleurl
if(substr($_SERVER['HTTP_REFERER'],0,strlen($href_root))!=$href_root)
{?>
	<meta http-equiv="Refresh" content="0; url=<? echo $href_root.find_googleurl($menu_id);?>" />
<? }
else
{
	$location=mysql_query("select metatag_title, metatag_keywords, metatag_description from menu where id='$menu_id'") or die ("x2");
	while ($locationshow=mysql_fetch_object($location))
	{
		$titel=$locationshow->metatag_title;
		$subhead=$locationshow->metatag_description;
		$pfadi="www.enjoyliving.at".find_googleurl($menu_id);
		if($subpage!=""){$pfadi.="/".$subpage;}
	
		echo"<title>$locationshow->metatag_title</title>";
		echo"<META NAME=\"description\" CONTENT=\"$locationshow->metatag_description\"/>";
		echo"<META NAME=\"keywords\" CONTENT=\"$locationshow->metatag_keywords\"/>";
	}
	?>
	</head>
	
	<body style="background-color:#ffffff;">
	<div>
		<div class="trenner"></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="70%"><img border="0"  src="<? echo $logo_url?>" max-width="300" height="80">
					<script language="JavaScript">
						<!--
						function checkform (fbe){
						  if (fbe.name.value == "") {
						 alert( "Bitte geben Sie Ihren Namen ein!" );
						 fbe.name.focus();
						 return false ;
						 }
							  if (fbe.email.value == "") {
						 alert( "Bitte geben Sie Ihre E-Mail Adresse ein!" );
						 fbe.email.focus();
						 return false ;
						 }
							if (fbe.email2.value == "") {
						 alert( "Bitte geben Sie eine Empfänger E-Mail Adresse ein!" );
						 fbe.email2.focus();
						 return false ;
						 }
							 if (fbe.securecode.value == "") {
						 alert( "Bitte geben Sie den Sicherheitscode ein!" );
						 fbe.securecode.focus();
						 return false ;
						 }
							 // ** END **
							return true ;
						}
						//-->
					</script>
				</td>
				<td width="30%"><div align="center"><a href="#" onClick="javascript:self.close();">Fenster schließen</a></div></td>
			</tr>
		</table>
		<div class="trenner"></div>
		<br />
		<div style="font:Verdana, Arial, Helvetica, sans-serif;font-size:16px;color:#FF8B19;font-weight:bold;line-height:25px;padding-left:0px;">Artikel versenden</div>
		<br />
		<?
		if ($eintrag=="1"  and $securecode=="$cccode1"){
			$textmessage=strip_tags($textmessage);
			$header = "MIME-Version: 1.0\r\n";
			$header .= "Return-Path: office@enjoyliving.at\n";
			$header .= "X-Sender: office@enjoyliving.at\n";
			$header .= "From: $email\n";
			$header .= "Bcc: EnjoyLiving <office@enjoyliving.at>\n";
			$header .= "X-Mailer:PHP 5.1\n";
			$header .= "MIME-Version: 1.0\n";
			$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
			
			####
			$text = "Liebe(r) Leser(in)!<br><br>Folgender Artikel auf <a href='http://www.enjoyliving.at'>http://www.enjoyliving.at</a> wird Ihnen von $name empfohlen:<br><br>
			$titel<br>
			Link zum Artikel: <a href='http://$pfadi'>$titel</a><br><br>
			Notiz von $name: $textmessage<br><br>
			--------------------------<br>
			<a href='http://www.enjoyliving.at'>www.enjoyliving.at</a>";
			###
			$betreff="EnjoyLiving.at - $titel";
			if (mail("$email2", "$betreff", "$text", $header)){
				echo"<strong>Der Artikel wurde versendet. </strong><br><br>Herzlichen Dank, dass Sie einen EnjoyLiving-Artikel weiterempfohlen haben. <br><br>";
			}
		}
		else
		{
			?>
			<div style='font:Verdana, Arial, Helvetica, sans-serif;font-size:14px;font-weight:bold;'><? echo $titel?> </div>
			<br><? echo $subhead;?><br><br>
			<?
			######Sicherheitscode
			$cccode="";
			$pool="";
			$pool .= "123456789";
			srand ((double)microtime()*1000000);
			for($index = 0; $index < 5; $index++)
			{$cccode .= substr($pool,(rand()%(strlen ($pool))), 1);}
			###
			if ($eintrag=="1" and $securecode!="$cccode1"){
				echo"<font color='#FF8B19'>Leider war die Eingabe Ihres Sicherheitscodes nicht korrekt. Bitte wiederholen Sie die Eingabe.</font><br><br>";
			}
			?>
			<br />
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<form name="fbe" onSubmit="return checkform(this);" method="post" action="send_page.php">
					<tr>
						<td width="30%" height="25">Ihr Name
							<input name="eintrag" type="hidden" id="eintrag" value="1" />
							<input name="cccode1" type="hidden" id="cccode1" value="<?echo"$cccode";?>" />
							<input name="pfadi" type="hidden" id="pfadi" value="<?echo"$pfadi";?>" />
							<input name="titel" type="hidden" id="titel" value="<? echo "$titel";?>" />
							<input name="subhead" type="hidden" id="subhead" value="<? echo "$subhead";?>" />
						</td>
						<td height="25" colspan="2">
							<input name="name" type="text" class="input" id="name" value="<?echo"$name";?>" size="40" />
						</td>
					</tr>
					<tr>
						<td width="30%" height="25">Ihre E-Mail</td>
						<td height="25" colspan="2">
							<input name="email" type="text" class="input" id="email" value="<?echo"$email";?>" size="40" />
						</td>
					</tr>
					<tr>
						<td width="30%" height="25">Empf&auml;nger E-Mail</td>
						<td height="25" colspan="2">
							<input name="email2" type="text" class="input" id="email2" value="<?echo"$email2";?>" size="40" />
						</td>
					</tr>
					<tr>
						<td height="25" valign="top">&nbsp;</td>
						<td height="25" colspan="2" valign="top">Bitte trennen Sie mehrere Empf&auml;nger durch Komma</td>
					</tr>
					<tr>
						<td width="30%" valign="top">Ihre Text-Nachricht</td>
						<td colspan="2" valign="top">
							<textarea name="textmessage" cols="37" rows="10" class="input" id="textmessage"><?echo"$textmessage";?></textarea>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td>Sicherheitscode</td>
						<td width="18">
							<img src="<? echo "/Connections/captcha.php"?>" border="0" title="Sicherheitscode" style="vertical-align:bottom;">
							<input type="text" name="sicherheitscode" size="5"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan="2"><br>Bitte geben Sie in das obige Feld die danebenstehende Zahlenkombination ein. Damit verhindern wir, dass das Formular zum automatisierten Versand von E-Mails benutzt werden kann.</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan="2"><input type="submit" value="Senden" sname="submit2222" />
							<input type="reset" value="L&ouml;schen" name="submit222" />
						</td>
					</tr>
				</form>
			</table>
		<? }?>
		<br />
		<br />
		<div class="trenner"></div>
		<strong>&copy; <? echo $site_description;?></strong> - <a href="http://<? echo $host_string;?>"><? echo $host_string;?></a> 
		<div class="trenner"></div>
		<br />
	</div>
<? }?>
</body>
</html>