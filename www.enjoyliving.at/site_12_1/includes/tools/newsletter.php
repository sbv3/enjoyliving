<a name="newsletter" id="newsletter"></a>
<h1>Newsletter</h1>
 <?
 ###sicherheitsbafrage stimmt?
if ($ergebnis!="$ergebnischeck"){$anmelden="";$error=1;}
///
if ($anmelden=="1")
{
	$dbtable= "newsletter";
	$result = mysql_query("SELECT * FROM $dbtable WHERE email='$email' and NO!=1 and site_id=$site_id")or die("Kann keine Datenbankverbindung herstellen!");
	$ergebnis_count = mysql_num_rows($result);
	if ($ergebnis_count=="0")
	{
		$anrede=GetSQLValueString($anrede,"text");
		$vorname=GetSQLValueString($vorname,"text");
		$nachname=GetSQLValueString($nachname,"text");
		$strasse=GetSQLValueString($strasse,"text");
		$plz=GetSQLValueString($plz,"int");
		$ort=GetSQLValueString($ort,"text");
		$land=GetSQLValueString($land,"text");
		$email=GetSQLValueString($email,"text");
		$birthdate=GetSQLValueString($tag.$monat.$jahr,"date");
		$i0=GetSQLValueString($i0,"int");
		$i1=GetSQLValueString($i1,"int");
		$i2=GetSQLValueString($i2,"int");
		$i3=GetSQLValueString($i3,"int");
		$i4=GetSQLValueString($i4,"int");
		$i5=GetSQLValueString($i5,"int");
		$i6=GetSQLValueString($i6,"int");
		$i7=GetSQLValueString($i7,"int");
		$i8=GetSQLValueString($i8,"int");
		$i9=GetSQLValueString($i9,"int");
		
		if ($i0=="1" or $i1=="1" or $i2=="1" or $i3=="1" or $i4=="1" or $i5=="1" or $i6=="1" or $i7=="1" or $i8=="1" or $i9=="1")
		{mysql_query("INSERT INTO $dbtable (anrede, vorname, nachname, strasse, plz, ort, land, email, IP, geburtsdatum, Reisen, Wellness, Beauty, Gesundheit, Fitness, Geist_Seele, Ernaehrung, Alternativmedizin, Frau_Familie, Natur_Umwelt, Home_Living,site_id) VALUES ($anrede, $vorname, $nachname, $strasse, $plz, $ort, $land, $email,'$REMOTE_ADDR',$birthdate,$i9,'',$i3,$i1,$i7,$i6,$i4,'',$i5,$i2,$i8,'$site_id')")or die("1Could not connect with the table $dbtable...");}
		else{
			mysql_query("INSERT INTO $dbtable (anrede, vorname, nachname, strasse, plz, ort, land, email, IP, geburtsdatum, Reisen, Wellness, Beauty, Gesundheit, Fitness, Geist_Seele, Ernaehrung, Alternativmedizin, Frau_Familie, Natur_Umwelt, Home_Living,site_id) VALUES ($anrede, $vorname, $nachname, $strasse, $plz, $ort, $land, $email,'$REMOTE_ADDR',$birthdate,1,1,1,1,1,1,1,1,1,1,1,'$site_id')")or die("2Could not connect with the table $dbtable...");}
	
		echo "<b>Danke für Ihre Newsletter-Bestellung!</span></b><br><br>Die Email Adresse <b>$email</b> wurde in unseren Newsletter-Verteiler aufgenommen.";
	}
	else {echo "Die von Ihnen angegebene Email Adresse <b>$email</b> ist bereits in unserem Newsletter Verteiler enthalten und wird daher nicht noch einmal eingetragen.";}
}
else
{
	?>
	<script language="JavaScript"><!--
	function checkform ( orderform )
	{
	 if (orderform.vorname.value == "") {
	 alert( "Bitte geben Sie Ihren Namen ein!" );
	 orderform.vorname.focus();
	 return false ;
	 }
	  if (orderform.nachname.value == "") {
	 alert( "Bitte geben Sie Ihren Namen ein!" );
	 orderform.nachname.focus();
	 return false ;
	 }
	  if (orderform.strasse.value == "") {
	 alert( "Bitte geben Sie Ihre Adresse ein!" );
	 orderform.strasse.focus();
	 return false ;
	 }
	 if (orderform.plz.value == "") {
	 alert( "Bitte geben Sie Ihre Postleitzahl ein!" );
	 orderform.plz.focus();
	 return false ;
	 }
	 if (orderform.ort.value == "") {
	 alert( "Bitte geben Sie Ihren Wohnort ein!" );
	 orderform.ort.focus();
	 return false ;
	 }
	 if (orderform.land.value == "0") {
	 alert( "Bitte geben Sie Ihr Land ein!" );
	 orderform.land.focus();
	 return false ;
	 }
	 if (orderform.email.value == "") {
	 alert( "Bitte füllen Sie das Feld Email aus!" );
	 orderform.email.focus();
	 return false ;
	 }
	 if(orderform.email.value.indexOf('@')==-1||orderform.email.value.indexOf('.')==-1)
	{
	alert ("Die eingegebene Email-Adresse ist keine gültige Email-Adresse!");
	orderform.email.focus();
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
	//--></script>
	<?
	if ($error=="1"){echo"Leider wurde die Rechenaufgabe zur Vermeidung von Mißbrauch nicht richtig gelöst. Bitte probieren Sie es noch einmal!<br><br>";}
	
	$zahla= rand(1,10);
	$zahlb=rand(1,10);
	$zahlc=$zahla+$zahlb;
	?>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
			<tr> 
			  <td width="447" bgcolor="white"> 
				<form name="orderform" onSubmit="return checkform(this);" method="post" target="_self">
				  <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr> 
					  <td colspan="2" height="20">Mit einem <b><font color="#FA7000">*</font></b> 
						gekennzeichnete Felder sind Pflichtfelder</td>
					</tr>
					<tr>
					  <td width="50" height="25">Anrede<b><font color="#FA7000">*</font></b></td>
					  <td width="50%" height="14"><select name="anrede" id="anrede" style="font-family: Verdana; font-size: 7pt;" >
						<option value="Frau">Frau</option>
						<option value="Herr">Herr</option>
						</select>
					  </td>
					</tr>
					<tr> 
					  <td width="50%" height="25">Vorname<b></b><b><font color="#FA7000">*</font></b> 
					  <td width="50%" height="14"> 
						<div align="left"> 
						  <input name="vorname" type="text" class="form-normal" style="font-family: Verdana; font-size: 7pt;" value="<? echo"$vorname";?>" size="30">
						<input type="hidden" name="anmelden" value="1">
						</div>                  </td>
					</tr>
					<tr> 
					  <td width="50%" height="25">Nachname<b><font color="#FA7000">*</font></b><b></b></td>
					  <td width="50%"> 
						<div align="left"> 
						  <input name="nachname" type="text" class="form-normal" style="font-family: Verdana; font-size: 7pt;" value="<? echo"$nachname";?>" size="30">
						</div>                  </td>
					</tr>
					<tr> 
					  <td width="50%" height="25">Strasse<b><font color="#FA7000">*</font></b><b></b></td>
					  <td width="50%"> 
						<div align="left"> 
						  <input name="strasse" type="text" class="form-normal" style="font-family: Verdana; font-size: 7pt;" value="<? echo"$strasse";?>" size="30">
						</div>                  </td>
					</tr>
					<tr>
					  <td width="50%" height="25">PLZ/Ort<b><font color="#FA7000">*</font></b></td>
					  <td width="50%">
						<input name="plz" type="text" class="form-normal" style="font-family: Verdana; font-size: 7pt;" value="<? echo"$plz";?>" size="10">
						<input name="ort" type="text" class="form-normal" style="font-family: Verdana; font-size: 7pt;" value="<? echo"$ort";?>" size="19">                  </td>
					</tr>
					<tr> 
					  <td width="50%" height="25">Land<b><font color="#FA7000">*</font></b></td>
					  <td width="50%"> 
						<div align="left"> 
						  <select name="land" class="form-normal" style="font-family: Verdana; font-size: 7pt;">
							<option value="0" selected>--- ausw&auml;hlen ---</option>
							<option value="AT" <?if ($land_re=="AT" or $show->land=="AT"){echo "selected";} else{}?>>&Ouml;sterreich</option>
							<option value="DE" <?if ($land_re=="DE" or $show->land=="DE"){echo "selected";} else{}?>>Deutschland</option>
							<option value="CH" <?if ($land_re=="CH" or $show->land=="CH"){echo "selected";} else{}?>>Schweiz</option>
							<option value="LU" <?if ($land_re=="LU" or $show->land=="LU"){echo "selected";} else{}?>>Luxemburg</option>
							<option value="IT" <?if ($land_re=="IT" or $show->land=="IT"){echo "selected";} else{}?>>Italien</option>
							<option value="FR" <?if ($land_re=="FR" or $show->land=="FR"){echo "selected";} else{}?>>Frankreich</option>
							<option value="GB" <?if ($land_re=="GB" or $show->land=="GB"){echo "selected";} else{}?>>Gro&szlig;britannien</option>
							<option value="BE" <?if ($land_re=="BE" or $show->land=="BE"){echo "selected";} else{}?>>Belgien</option>
						  </select>
						</div>                  </td>
					</tr>
				  </table>
				  <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr> 
					  <td width="50%" height="25">Email-Adresse <b><font color="#FA7000">*</font></b></td>
					  <td width="50%"> 
						<div align="left"> 
						  <input type="text" name="email" value="<?echo"$email";?>" class="form-normal" style="font-family: Verdana; font-size: 7pt;" size="30">
						</div>                  </td>
					</tr>
					<tr> 
					  <td width="50%" valign="middle" height="25">Geburtsdatum</td>
					  <td width="50%"> 
						<div align="left"> 
						  <select name="tag" class="form-normal" style="font-family: Verdana; font-size: 7pt;">
							<option value="00" selected>Tag</option>
							<option value="01" <?if ($show->geburt_tag=="01" or $tag=="01"){echo "selected";}else{}?>>01</option>
							<option value="02" <?if ($show->geburt_tag=="02" or $tag=="02"){echo "selected";}else{}?>>02</option>
							<option value="03" <?if ($show->geburt_tag=="03" or $tag=="03"){echo "selected";}else{}?>>03</option>
							<option value="04" <?if ($show->geburt_tag=="04" or $tag=="04"){echo "selected";}else{}?>>04</option>
							<option value="05" <?if ($show->geburt_tag=="05" or $tag=="05"){echo "selected";}else{}?>>05</option>
							<option value="06" <?if ($show->geburt_tag=="06" or $tag=="06"){echo "selected";}else{}?>>06</option>
							<option value="07" <?if ($show->geburt_tag=="07" or $tag=="07"){echo "selected";}else{}?>>07</option>
							<option value="08" <?if ($show->geburt_tag=="08" or $tag=="08"){echo "selected";}else{}?>>08</option>
							<option value="09" <?if ($show->geburt_tag=="09" or $tag=="09"){echo "selected";}else{}?>>09</option>
							<option value="10" <?if ($show->geburt_tag=="10" or $tag=="10"){echo "selected";}else{}?>>10</option>
							<option value="11" <?if ($show->geburt_tag=="11" or $tag=="11"){echo "selected";}else{}?>>11</option>
							<option value="12" <?if ($show->geburt_tag=="12" or $tag=="12"){echo "selected";}else{}?>>12</option>
							<option value="13" <?if ($show->geburt_tag=="13" or $tag=="13"){echo "selected";}else{}?>>13</option>
							<option value="14" <?if ($show->geburt_tag=="14" or $tag=="14"){echo "selected";}else{}?>>14</option>
							<option value="15" <?if ($show->geburt_tag=="15" or $tag=="15"){echo "selected";}else{}?>>15</option>
							<option value="16" <?if ($show->geburt_tag=="16" or $tag=="16"){echo "selected";}else{}?>>16</option>
							<option value="17" <?if ($show->geburt_tag=="17" or $tag=="17"){echo "selected";}else{}?>>17</option>
							<option value="18" <?if ($show->geburt_tag=="18" or $tag=="18"){echo "selected";}else{}?>>18</option>
							<option value="19" <?if ($show->geburt_tag=="19" or $tag=="19"){echo "selected";}else{}?>>19</option>
							<option value="20" <?if ($show->geburt_tag=="20" or $tag=="20"){echo "selected";}else{}?>>20</option>
							<option value="21" <?if ($show->geburt_tag=="21" or $tag=="21"){echo "selected";}else{}?>>22</option>
							<option value="22" <?if ($show->geburt_tag=="22" or $tag=="22"){echo "selected";}else{}?>>23</option>
							<option value="23" <?if ($show->geburt_tag=="23" or $tag=="23"){echo "selected";}else{}?>>23</option>
							<option value="24" <?if ($show->geburt_tag=="24" or $tag=="24"){echo "selected";}else{}?>>24</option>
							<option value="25" <?if ($show->geburt_tag=="25" or $tag=="25"){echo "selected";}else{}?>>25</option>
							<option value="26" <?if ($show->geburt_tag=="26" or $tag=="26"){echo "selected";}else{}?>>26</option>
							<option value="27" <?if ($show->geburt_tag=="27" or $tag=="27"){echo "selected";}else{}?>>27</option>
							<option value="28" <?if ($show->geburt_tag=="28" or $tag=="28"){echo "selected";}else{}?>>28</option>
							<option value="29" <?if ($show->geburt_tag=="29" or $tag=="29"){echo "selected";}else{}?>>29</option>
							<option value="30" <?if ($show->geburt_tag=="30" or $tag=="30"){echo "selected";}else{}?>>30</option>
							<option value="31" <?if ($show->geburt_tag=="31" or $tag=="31"){echo "selected";}else{}?>>31</option>
						  </select>
						  <select name="monat" class="form-normal" style="font-family: Verdana; font-size: 7pt;">
							<option value="00" selected>Monat</option>
							<option value="01" <?if ($show->geburt_monat=="01" or $monat=="01"){echo "selected";}else{}?>>01</option>
							<option value="02" <?if ($show->geburt_monat=="02" or $monat=="02"){echo "selected";}else{}?>>02</option>
							<option value="03" <?if ($show->geburt_monat=="03" or $monat=="03"){echo "selected";}else{}?>>03</option>
							<option value="04" <?if ($show->geburt_monat=="04" or $monat=="04"){echo "selected";}else{}?>>04</option>
							<option value="05" <?if ($show->geburt_monat=="05" or $monat=="05"){echo "selected";}else{}?>>05</option>
							<option value="06" <?if ($show->geburt_monat=="06" or $monat=="06"){echo "selected";}else{}?>>06</option>
							<option value="07" <?if ($show->geburt_monat=="07" or $monat=="07"){echo "selected";}else{}?>>07</option>
							<option value="08" <?if ($show->geburt_monat=="08" or $monat=="08"){echo "selected";}else{}?>>08</option>
							<option value="09" <?if ($show->geburt_monat=="09" or $monat=="09"){echo "selected";}else{}?>>09</option>
							<option value="10" <?if ($show->geburt_monat=="10" or $monat=="10"){echo "selected";}else{}?>>10</option>
							<option value="11" <?if ($show->geburt_monat=="11" or $monat=="11"){echo "selected";}else{}?>>11</option>
							<option value="12" <?if ($show->geburt_monat=="12" or $monat=="12"){echo "selected";}else{}?>>12</option>
						  </select>
						  <select name="jahr" class="form-normal" style="font-family: Verdana; font-size: 7pt;">
							<option value="00" selected>Jahr</option>
							<option value="1901" <?if ($show->geburt_jahr =="1901"or $jahr=="1901"){echo "selected";}else{}?>>1901</option>
							<option value="1902" <?if ($show->geburt_jahr =="1902"or $jahr=="1902"){echo "selected";}else{}?>>1902</option>
							<option value="1903" <?if ($show->geburt_jahr =="1903"or $jahr=="1903"){echo "selected";}else{}?>>1903</option>
							<option value="1904" <?if ($show->geburt_jahr =="1904"or $jahr=="1904"){echo "selected";}else{}?>>1904</option>
							<option value="1905" <?if ($show->geburt_jahr =="1905"or $jahr=="1905"){echo "selected";}else{}?>>1905</option>
							<option value="1906" <?if ($show->geburt_jahr =="1906"or $jahr=="1906"){echo "selected";}else{}?>>1906</option>
							<option value="1907" <?if ($show->geburt_jahr =="1907"or $jahr=="1907"){echo "selected";}else{}?>>1907</option>
							<option value="1908" <?if ($show->geburt_jahr =="1908"or $jahr=="1908"){echo "selected";}else{}?>>1908</option>
							<option value="1909" <?if ($show->geburt_jahr =="1909"or $jahr=="1909"){echo "selected";}else{}?>>1909</option>
							<option value="1910" <?if ($show->geburt_jahr =="1910"or $jahr=="1910"){echo "selected";}else{}?>>1910</option>
							<option value="1911" <?if ($show->geburt_jahr =="1911"or $jahr=="1911"){echo "selected";}else{}?>>1911</option>
							<option value="1912" <?if ($show->geburt_jahr =="1912"or $jahr=="1912"){echo "selected";}else{}?>>1912</option>
							<option value="1913" <?if ($show->geburt_jahr =="1913"or $jahr=="1913"){echo "selected";}else{}?>>1913</option>
							<option value="1914" <?if ($show->geburt_jahr =="1914"or $jahr=="1914"){echo "selected";}else{}?>>1914</option>
							<option value="1915" <?if ($show->geburt_jahr =="1915"or $jahr=="1915"){echo "selected";}else{}?>>1915</option>
							<option value="1916" <?if ($show->geburt_jahr =="1916"or $jahr=="1916"){echo "selected";}else{}?>>1916</option>
							<option value="1917" <?if ($show->geburt_jahr =="1917"or $jahr=="1917"){echo "selected";}else{}?>>1917</option>
							<option value="1918" <?if ($show->geburt_jahr =="1918"or $jahr=="1918"){echo "selected";}else{}?>>1918</option>
							<option value="1919" <?if ($show->geburt_jahr =="1919"or $jahr=="1919"){echo "selected";}else{}?>>1919</option>
							<option value="1920" <?if ($show->geburt_jahr =="1920"or $jahr=="1920"){echo "selected";}else{}?>>1920</option>
							<option value="1921" <?if ($show->geburt_jahr =="1921"or $jahr=="1921"){echo "selected";}else{}?>>1921</option>
							<option value="1922" <?if ($show->geburt_jahr =="1922"or $jahr=="1922"){echo "selected";}else{}?>>1922</option>
							<option value="1923" <?if ($show->geburt_jahr =="1923"or $jahr=="1923"){echo "selected";}else{}?>>1923</option>
							<option value="1924" <?if ($show->geburt_jahr =="1924"or $jahr=="1924"){echo "selected";}else{}?>>1924</option>
							<option value="1925" <?if ($show->geburt_jahr =="1925"or $jahr=="1925"){echo "selected";}else{}?>>1925</option>
							<option value="1926" <?if ($show->geburt_jahr =="1926"or $jahr=="1926"){echo "selected";}else{}?>>1926</option>
							<option value="1927" <?if ($show->geburt_jahr =="1927"or $jahr=="1927"){echo "selected";}else{}?>>1927</option>
							<option value="1928" <?if ($show->geburt_jahr =="1928"or $jahr=="1928"){echo "selected";}else{}?>>1928</option>
							<option value="1929" <?if ($show->geburt_jahr =="1929"or $jahr=="1929"){echo "selected";}else{}?>>1929</option>
							<option value="1930" <?if ($show->geburt_jahr =="1930"or $jahr=="1930"){echo "selected";}else{}?>>1930</option>
							<option value="1931" <?if ($show->geburt_jahr =="1931"or $jahr=="1931"){echo "selected";}else{}?>>1931</option>
							<option value="1932" <?if ($show->geburt_jahr =="1932"or $jahr=="1932"){echo "selected";}else{}?>>1932</option>
							<option value="1933" <?if ($show->geburt_jahr =="1933"or $jahr=="1933"){echo "selected";}else{}?>>1933</option>
							<option value="1934" <?if ($show->geburt_jahr =="1934"or $jahr=="1934"){echo "selected";}else{}?>>1934</option>
							<option value="1935" <?if ($show->geburt_jahr =="1935"or $jahr=="1935"){echo "selected";}else{}?>>1935</option>
							<option value="1936" <?if ($show->geburt_jahr =="1936"or $jahr=="1936"){echo "selected";}else{}?>>1936</option>
							<option value="1937" <?if ($show->geburt_jahr =="1937"or $jahr=="1937"){echo "selected";}else{}?>>1937</option>
							<option value="1938" <?if ($show->geburt_jahr =="1938"or $jahr=="1938"){echo "selected";}else{}?>>1938</option>
							<option value="1939" <?if ($show->geburt_jahr =="1939"or $jahr=="1939"){echo "selected";}else{}?>>1939</option>
							<option value="1940" <?if ($show->geburt_jahr =="1940"or $jahr=="1940"){echo "selected";}else{}?>>1940</option>
							<option value="1941" <?if ($show->geburt_jahr =="1941"or $jahr=="1941"){echo "selected";}else{}?>>1941</option>
							<option value="1942" <?if ($show->geburt_jahr =="1942"or $jahr=="1942"){echo "selected";}else{}?>>1942</option>
							<option value="1943" <?if ($show->geburt_jahr =="1943"or $jahr=="1943"){echo "selected";}else{}?>>1943</option>
							<option value="1944" <?if ($show->geburt_jahr =="1944"or $jahr=="1944"){echo "selected";}else{}?>>1944</option>
							<option value="1945" <?if ($show->geburt_jahr =="1945"or $jahr=="1945"){echo "selected";}else{}?>>1945</option>
							<option value="1946" <?if ($show->geburt_jahr =="1946"or $jahr=="1946"){echo "selected";}else{}?>>1946</option>
							<option value="1947" <?if ($show->geburt_jahr =="1947"or $jahr=="1947"){echo "selected";}else{}?>>1947</option>
							<option value="1948" <?if ($show->geburt_jahr =="1948"or $jahr=="1948"){echo "selected";}else{}?>>1948</option>
							<option value="1949" <?if ($show->geburt_jahr =="1949"or $jahr=="1949"){echo "selected";}else{}?>>1949</option>
							<option value="1950" <?if ($show->geburt_jahr =="1950"or $jahr=="1950"){echo "selected";}else{}?>>1950</option>
							<option value="1951" <?if ($show->geburt_jahr =="1951"or $jahr=="1951"){echo "selected";}else{}?>>1951</option>
							<option value="1952" <?if ($show->geburt_jahr =="1952"or $jahr=="1952"){echo "selected";}else{}?>>1952</option>
							<option value="1953" <?if ($show->geburt_jahr =="1953"or $jahr=="1953"){echo "selected";}else{}?>>1953</option>
							<option value="1954" <?if ($show->geburt_jahr =="1954"or $jahr=="1954"){echo "selected";}else{}?>>1954</option>
							<option value="1955" <?if ($show->geburt_jahr =="1955"or $jahr=="1955"){echo "selected";}else{}?>>1955</option>
							<option value="1956" <?if ($show->geburt_jahr =="1956"or $jahr=="1956"){echo "selected";}else{}?>>1956</option>
							<option value="1957" <?if ($show->geburt_jahr =="1957"or $jahr=="1957"){echo "selected";}else{}?>>1957</option>
							<option value="1958" <?if ($show->geburt_jahr =="1958"or $jahr=="1958"){echo "selected";}else{}?>>1958</option>
							<option value="1959" <?if ($show->geburt_jahr =="1959"or $jahr=="1959"){echo "selected";}else{}?>>1959</option>
							<option value="1960" <?if ($show->geburt_jahr =="1960"or $jahr=="1960"){echo "selected";}else{}?>>1960</option>
							<option value="1961" <?if ($show->geburt_jahr =="1961"or $jahr=="1961"){echo "selected";}else{}?>>1961</option>
							<option value="1962" <?if ($show->geburt_jahr =="1962"or $jahr=="1962"){echo "selected";}else{}?>>1962</option>
							<option value="1963" <?if ($show->geburt_jahr =="1963"or $jahr=="1963"){echo "selected";}else{}?>>1963</option>
							<option value="1964" <?if ($show->geburt_jahr =="1964"or $jahr=="1964"){echo "selected";}else{}?>>1964</option>
							<option value="1965" <?if ($show->geburt_jahr =="1965"or $jahr=="1965"){echo "selected";}else{}?>>1965</option>
							<option value="1966" <?if ($show->geburt_jahr =="1966"or $jahr=="1966"){echo "selected";}else{}?>>1966</option>
							<option value="1967" <?if ($show->geburt_jahr =="1967"or $jahr=="1967"){echo "selected";}else{}?>>1967</option>
							<option value="1968" <?if ($show->geburt_jahr =="1968"or $jahr=="1968"){echo "selected";}else{}?>>1968</option>
							<option value="1969" <?if ($show->geburt_jahr =="1969"or $jahr=="1969"){echo "selected";}else{}?>>1969</option>
							<option value="1970" <?if ($show->geburt_jahr =="1970"or $jahr=="1970"){echo "selected";}else{}?>>1970</option>
							<option value="1971" <?if ($show->geburt_jahr =="1971"or $jahr=="1971"){echo "selected";}else{}?>>1971</option>
							<option value="1972" <?if ($show->geburt_jahr =="1972"or $jahr=="1972"){echo "selected";}else{}?>>1972</option>
							<option value="1973" <?if ($show->geburt_jahr =="1973"or $jahr=="1973"){echo "selected";}else{}?>>1973</option>
							<option value="1974" <?if ($show->geburt_jahr =="1974"or $jahr=="1974"){echo "selected";}else{}?>>1974</option>
							<option value="1975" <?if ($show->geburt_jahr =="1975"or $jahr=="1975"){echo "selected";}else{}?>>1975</option>
							<option value="1976" <?if ($show->geburt_jahr =="1976"or $jahr=="1976"){echo "selected";}else{}?>>1976</option>
							<option value="1977" <?if ($show->geburt_jahr =="1977"or $jahr=="1977"){echo "selected";}else{}?>>1977</option>
							<option value="1978" <?if ($show->geburt_jahr =="1978"or $jahr=="1978"){echo "selected";}else{}?>>1978</option>
							<option value="1979" <?if ($show->geburt_jahr =="1979"or $jahr=="1979"){echo "selected";}else{}?>>1979</option>
							<option value="1980" <?if ($show->geburt_jahr =="1980"or $jahr=="1980"){echo "selected";}else{}?>>1980</option>
							<option value="1981" <?if ($show->geburt_jahr =="1981"or $jahr=="1981"){echo "selected";}else{}?>>1981</option>
							<option value="1982" <?if ($show->geburt_jahr =="1982"or $jahr=="1982"){echo "selected";}else{}?>>1982</option>
							<option value="1983" <?if ($show->geburt_jahr =="1983"or $jahr=="1983"){echo "selected";}else{}?>>1983</option>
							<option value="1984" <?if ($show->geburt_jahr =="1984"or $jahr=="1984"){echo "selected";}else{}?>>1984</option>
							<option value="1985" <?if ($show->geburt_jahr =="1985"or $jahr=="1985"){echo "selected";}else{}?>>1985</option>
							<option value="1986" <?if ($show->geburt_jahr =="1986"or $jahr=="1986"){echo "selected";}else{}?>>1986</option>
							<option value="1987" <?if ($show->geburt_jahr =="1987"or $jahr=="1987"){echo "selected";}else{}?>>1987</option>
							<option value="1988" <?if ($show->geburt_jahr =="1988"or $jahr=="1988"){echo "selected";}else{}?>>1988</option>
							<option value="1989" <?if ($show->geburt_jahr =="1989"or $jahr=="1989"){echo "selected";}else{}?>>1989</option>
							<option value="1990" <?if ($show->geburt_jahr =="1990"or $jahr=="1990"){echo "selected";}else{}?>>1990</option>
							<option value="1991" <?if ($show->geburt_jahr =="1991"or $jahr=="1991"){echo "selected";}else{}?>>1991</option>
							<option value="1992" <?if ($show->geburt_jahr =="1992"or $jahr=="1992"){echo "selected";}else{}?>>1992</option>
							<option value="1993" <?if ($show->geburt_jahr =="1993"or $jahr=="1993"){echo "selected";}else{}?>>1993</option>
							<option value="1994" <?if ($show->geburt_jahr =="1994"or $jahr=="1994"){echo "selected";}else{}?>>1994</option>
							<option value="1995" <?if ($show->geburt_jahr =="1995"or $jahr=="1995"){echo "selected";}else{}?>>1995</option>
							<option value="1996" <?if ($show->geburt_jahr =="1996"or $jahr=="1996"){echo "selected";}else{}?>>1996</option>
							<option value="1997" <?if ($show->geburt_jahr =="1997"or $jahr=="1997"){echo "selected";}else{}?>>1997</option>
							<option value="1998" <?if ($show->geburt_jahr =="1998"or $jahr=="1998"){echo "selected";}else{}?>>1998</option>
							<option value="1999" <?if ($show->geburt_jahr =="1999"or $jahr=="1999"){echo "selected";}else{}?>>1999</option>
							<option value="2000" <?if ($show->geburt_jahr =="2000"or $jahr=="2000"){echo "selected";}else{}?>>2000</option>
						  </select>
						</div>                  </td>
					</tr>
					<tr> 
					  <td width="50%" valign="middle">&nbsp;</td>
					  <td width="50%">&nbsp;</td>
					</tr>
					<tr> 
					  <td colspan="2" valign="middle" height="20"><b>Meine Interessensgebiete:</b></td>
					</tr>
					<tr> 
					  <td colspan="2" valign="middle"> 
						<table width="100%" cellspacing="0" cellpadding="0">
						  <tr> 
							<td colspan="2">&nbsp; </td>
						  </tr>
						  <tr> 
							<td width="5%"> 
							  <input type="checkbox" name="i1" value="1">                        </td>
							<td height="18">Gesundheit </td>
						  </tr>
						  <tr> 
							<td> 
							  <input type="checkbox" name="i2" value="1">                        </td>
							<td>Natur &amp; Umwelt </td>
						  </tr>
						  <tr> 
							<td> 
							  <input type="checkbox" name="i3" value="1">                        </td>
							<td>Beauty </td>
						  </tr>
						  <tr> 
							<td> 
							  <input type="checkbox" name="i4" value="1">                        </td>
							<td>Ern&auml;hrung </td>
						  </tr>
						  <tr> 
							<td> 
							  <input type="checkbox" name="i5" value="1">                        </td>
							<td>Frau &amp; Familie </td>
						  </tr>
						  <tr> 
							<td> 
							  <input type="checkbox" name="i6" value="1">                        </td>
							<td>Geist &amp; Seele </td>
						  </tr>
						  <tr> 
							<td> 
							  <input type="checkbox" name="i7" value="1">                        </td>
							<td>Fit &amp; Vital </td>
						  </tr>
						  <tr> 
							<td> 
							  <input type="checkbox" name="i8" value="1">                        </td>
							<td>Home &amp; Living </td>
						  </tr>
						  <tr> 
							<td> 
							  <input type="checkbox" name="i9" value="1">                        </td>
							<td>Wellness Reisen </td>
						  </tr>
						  <tr> 
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						  </tr>
						</table>                  </td>
					</tr>
					<tr>
						<td valign="middle" height="35">Sicherheitsabfrage</td>
						<td><span style="height:140px;"><? echo"$zahla + $zahlb =";?>
							<input name="ergebnis" id="ergebnis" size="3" maxlength="2" />
								<input name="ergebnischeck" type="hidden" id="ergebnischeck" value="<? echo"$zahlc";?>" />
						</span></td>
						</tr>
					<tr>
						<td height="35" colspan="2" valign="middle">Um Mi&szlig;brauch zu verhindern, kn&uuml;pfen wir die Newsletterregistrierung an das richtige L&ouml;sen der kleinen Rechenaufgabe.</td>
						</tr>
					<tr> 
					  <td width="50%" valign="middle" height="35"> 
						<input type="submit" value="Newsletter bestellen" style="color:black;font-size:8pt;background-image:url(/well/guide/img/button_bg.gif);background-repeat:repeat-x;padding-left:8px;padding-right:8px;padding-top:1px;padding-bottom:1px;border:1px solid #999999;" name="Newsletter">                  </td>
					  <td width="50%"> 
						<div align="right"></div>                  </td>
					</tr>
				  </table>
				</form>          </td>
			</tr>
		  </table>
<? }?>
<br />
<br />
Wenn Sie sich mit Ihrer E-Mail Adresse von unserem Newsletter-Verteiler abmelden möchten, nutzten Sie bitte folgenden Link:<br>
<a href="<? echo $href_root.find_googleurl(5473);?>"><? echo $href_root.find_googleurl(5473);?></a><br />