<a name="bioresult" id="bioresult"></a>
<?
if ($get=="1")
{
	$get="0";?>
	   <b>Ihr aktueller Biorhythmus 
	   ( Geburtsdatum: <?echo "$d1.$m1.$j1";
	   ?> ) :</b><br />
	   <br />
	   In der Phase oberhalb der schwarzen Null-Linie befinden Sie sich 
	   im aktiven Bereich, unterhalb der Null-Linie im passiven Bereich, 
	   den Wechsel von aktiv zu passiv bezeichnet man als &quot;kritische&quot; 
	   Tage.<br />
	   Eine neue Phase beginnt immer dann, wenn die Null-Linie passiert 
	   wird. <br />
	   <br />
	   Mit unserem Biorhythmus-Rechner f&auml;llt es Ihnen k&uuml;nftig 
	   leicht, herauszufinden weshalb es Tage gibt, an denen Ihnen alles 
	   so leicht von der Hand geht und Sie so dynamisch in den Tag starten 
	   und andere, an denen Sie schon morgens nur schlecht aus dem Bett 
	   finden ...<br />
	   <br />
	   Das Wissen um die pers&ouml;nliche Verfassung macht es uns leicht, 
	   den richtigen Zeitpunkt f&uuml;r private und berufliche Vorhaben 
	   zu finden! <br />
	   <br />
	   <br />
	<?
	$tag = date('d');
	$monat = date('m');
	$jahr = date('Y');
	$wochentag = date("l", mktime(0,0,0,$monat,$tag,$jahr));
	if ($wochentag=="Tuesday")
	{
		$bild="Di.gif";
	}
		elseif ($wochentag=="Wednesday")
	{
		$bild="Mi.gif";
	}
		elseif ($wochentag=="Thursday")
	{
		$bild="Do.gif";
	}
		elseif ($wochentag=="Friday")
	{
		$bild="Fr.gif";
	}
		elseif ($wochentag=="Saturday")
	{
		$bild="Sa.gif";
	}
		elseif ($wochentag=="Sunday")
	{
		$bild="So.gif";
	}
		elseif ($wochentag=="Monday")
	{
		$bild="Mo.gif";
	}
	else
	{}
	#print $wochentag;
	if($monat < 3)
	{
		$monat = $monat + 12;
		$jahr = $jahr - 1;
	}
	$today = $tag + floor((153 * $monat - 457) / 5) + 365 * $jahr + floor($jahr / 4) - floor($jahr / 100) + floor($jahr / 400) + 1721118.5;
	###DATUMSVERGLEICH
	#$daysalife= mktime(0,0,0,$monat,$tag,$jahr) - mktime(0,0,0,$m1,$d1,$j1);
	#$daysalife= floor($daysalife / (24 * 60 *60));
	#$daysalife=$daysalife-15;
	#echo "$daysalife";
	if($m1 < 3)
	{
		$m1 = $m1 + 12;
		$j1 = $j1 - 1;
	}
	$daysalife1 = $d1 + floor((153 * $m1 - 457) / 5) + 365 * $j1 + floor($j1 / 4) - floor($j1 / 100) + floor($j1 / 400) + 1721118.5;
	$daysalife=$today - $daysalife1 - 15;
	?>
	<div id='physical' style='position:absolute; width:491px; height:200px; z-index:1; text-align: left'>
			<img src='/site_12_1/includes/tools/img/biorythm/Background.gif' border='1'>
			<br>
			<img src='<? echo "/site_12_1/includes/tools/img/biorythm/Days/$bild";?>'>
</div>
	<?
	   ###biorythmus physical
	   $physical=floor(sin(($daysalife*(360/23))*pi()/180)*100);
	   $result2 = mysql_query("SELECT * FROM biorythm WHERE result='$physical' and code='physical'")or die("Kann keine Datenbankverbindung herstellen1!");
	   while ($show2=mysql_fetch_object($result2))
	   {
		?>
		<div id='physical' style='position:absolute; width:491px; height:200px; z-index:1; text-align: left'><img src='<? echo "/site_12_1/includes/tools/img/biorythm/1/$show2->img";?>'></div>
		<?
	   }
	   ?>
	<?
	   ###biorythmus emotional
	   $emotional=floor(sin(($daysalife*(360/28)+2)*pi()/180)*100);
	   $result2 = mysql_query("SELECT * FROM biorythm WHERE result='$emotional' and code='emotional'")or die("Kann keine Datenbankverbindung herstellen2!");
	   while ($show2=mysql_fetch_object($result2))
	   {
		?>
		<div id='emotional' style='position:absolute; width:491px; height:200px; z-index:1; text-align: left'><img src='<? echo "/site_12_1/includes/tools/img/biorythm/2/$show2->img";?>'></div>
			<?
	   }
	   ?>
<?
	###biorythmus mental
	$mental=floor(sin(($daysalife*(360/33))*pi()/180)*100);
	$result2 = mysql_query("SELECT * FROM biorythm WHERE result='$mental' and code='mental'")or die("Kann keine Datenbankverbindung herstellen3!");
	while ($show2=mysql_fetch_object($result2))
	{
	?>
			<div id='mental' style='position:absolute; width:491px; height:200px; z-index:1; text-align: left'><img src='<? echo "/site_12_1/includes/tools/img/biorythm/3/$show2->img";?>'></div>
	<?
	}
	?>
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   <br />
	   Legende:<br />
	   <br />
	   <p></p>
	   <table width="100%" cellspacing="0" cellpadding="0">
			<tr>
				 <td width="10%" valign="top"><img src="/site_12_1/includes/tools/img/biorythm/physical.gif" width="13" height="14" /></td>
					  <td width="90%" height="20"><b>K&ouml;rperrythmus</b> - Periode 
					  von 23 Tagen<br />
					  beeinflusst die k&ouml;rperliche Leistungsf&auml;higkeit<br />
					  <i>aktive Phase</i><i>:</i> g&uuml;nstig f&uuml;r alle k&ouml;rperlichen 
					  Aktivit&auml;ten, geringere Anf&auml;lligkeit f&uuml;r Krankheiten<br />
					  <i>passive Phase</i><i>:</i> schnellere Erm&uuml;dung, anf&auml;lliger 
					  f&uuml;r Krankheiten - nicht &uuml;berfordern!<br />
					  <i>kritische Tage</i>: labile K&ouml;rperverfassung, Unausgeglichenheit 
					  - die Kriterien der passiven Phase k&ouml;nnen noch verst&auml;rkt 
					  sein<br />
				 </td>
			</tr>
			<tr>
				 <td width="10%" valign="top"><img src="/site_12_1/includes/tools/img/biorythm/emotional.gif" width="13" height="14" /></td>
				 <td width="90%" height="20"><b>Seelenrythmus</b> - Periode von 
					  28 Tagen<br />
					  beeinflusst die psychische Belastbarkeit<br />
					  <i>aktive Phase</i><i>: </i>g&uuml;nstig f&uuml;r zwischenmenschliche 
					  Kontakte, kreatives Hoch<br />
					  <i>passive Phase</i><i>:</i> psychisch weniger belastbar, 
					  Unlustgef&uuml;hle<br />
					  <i>kritische Tage:</i> die Kriterien der passiven Phase k&ouml;nnen 
					  noch verst&auml;rkt sein.<br />
				 </td>
			</tr>
			<tr>
				 <td width="10%" valign="top"><img src="/site_12_1/includes/tools/img/biorythm/mental.gif" width="13" height="14" /></td>
				 <td width="90%" height="20"><b>Geistesrhytmus</b> - Periode 
					  von 33 Tagen<br />
					  beeinflusst die intellektuelle Verfassung<br />
					  <i>aktive Phase</i><i>:</i> g&uuml;nstig f&uuml;r die L&ouml;sung 
					  schwieriger Probleme, Verhandlungen, Pr&uuml;fungen<br />
					  <i>passive Phase:</i> Denkf&auml;higkeit und Konzentration 
					  ist vermindert - Regenerationsphase!<br />
					  <i>kritische Tage:</i> die Kriterien der passiven Phase k&ouml;nnen 
					  noch verst&auml;rkt sein!
				 </td>
			</tr>
	   </table>
	   <b><br />
	   </b>
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				 <td width="4%"><b><img src='/well/branchen/img/pfeil_1.gif' width='12' height='23' border="0" /></b></td>
				 <td width="96%"><a href="<? if ($subpage!=""){$subpage1="/$subpage";}echo $testpfad."$googleurl$subpage1";?>"><b><span class="bigfont_headline-grey">neuen Biorhythmus berechnen</span></b></a></td>
			</tr>
	   </table>
	   <br />
<? 
}
elseif($get=="")
{
?>
	   Zyklische Bewegungen bestimmen nicht nur das Auf und Ab von Ebbe 
	   und Flut, Tag und Nacht, etc. sondern wirken nat&uuml;rlich auch 
	   auf uns Menschen, auf unsere Verfassung und unser Wohlbefinden. 
	   Unsere k&ouml;rperliche, seeische und geistige Lebenskraft beginnt 
	   zum Zeitpunkt unserer Geburt wellenf&ouml;rmig auf und ab zu schwingen 
	   und pendelt zwischen aktiven, also leistungsf&auml;higen, und passiven 
	   Phasen, jenen zur Regeneration, gleichm&auml;&szlig;ig hin und her.<br />
	   <br />
	   <b>Berechnen Sie hier Ihren pers&ouml;nlichen Biorhythmus!</b><br />
	   Geben Sie dazu einfach im folgenden Formular Ihre Geburtsdaten ein 
	   und klicken Sie anschlie&szlig;end auf &quot;Berechnen&quot;.<br />
	   <br />
	   <form action="<? if ($subpage!=""){$subpage1="/$subpage";}echo $testpfad."$googleurl$subpage1#bioresult";?>" method="post" name="orderform" id="form_tool" target="_self">
			<table width="98%" cellspacing="0" cellpadding="0" align="center">
				 <tr>
					  <td height="35" valign="bottom">Geburtstag</td>
					  <td valign="bottom">
						<select name="d1" class="form-normal" style="font-family: Verdana; font-size: 8pt;">
								<option value="01" selected="selected">01</option>
								<option value="02" <?if ($tag=="02"){echo "selected";}else{}?>>02</option>
								<option value="03" <?if ($tag=="03"){echo "selected";}else{}?>>03</option>
								<option value="04" <?if ($tag=="04"){echo "selected";}else{}?>>04</option>
								<option value="05" <?if ($tag=="05"){echo "selected";}else{}?>>05</option>
								<option value="06" <?if ($tag=="06"){echo "selected";}else{}?>>06</option>
								<option value="07" <?if ($tag=="07"){echo "selected";}else{}?>>07</option>
								<option value="08" <?if ($tag=="08"){echo "selected";}else{}?>>08</option>
								<option value="09" <?if ($tag=="09"){echo "selected";}else{}?>>09</option>
								<option value="10" <?if ($tag=="10"){echo "selected";}else{}?>>10</option>
								<option value="11" <?if ($tag=="11"){echo "selected";}else{}?>>11</option>
								<option value="12" <?if ($tag=="12"){echo "selected";}else{}?>>12</option>
								<option value="13" <?if ($tag=="13"){echo "selected";}else{}?>>13</option>
								<option value="14" <?if ($tag=="14"){echo "selected";}else{}?>>14</option>
								<option value="15" <?if ($tag=="15"){echo "selected";}else{}?>>15</option>
								<option value="16" <?if ($tag=="16"){echo "selected";}else{}?>>16</option>
								<option value="17" <?if ($tag=="17"){echo "selected";}else{}?>>17</option>
								<option value="18" <?if ($tag=="18"){echo "selected";}else{}?>>18</option>
								<option value="19" <?if ($tag=="19"){echo "selected";}else{}?>>19</option>
								<option value="20" <?if ($tag=="20"){echo "selected";}else{}?>>20</option>
								<option value="21" <?if ($tag=="21"){echo "selected";}else{}?>>21</option>
								<option value="22" <?if ($tag=="22"){echo "selected";}else{}?>>22</option>
								<option value="23" <?if ($tag=="23"){echo "selected";}else{}?>>23</option>
								<option value="24" <?if ($tag=="24"){echo "selected";}else{}?>>24</option>
								<option value="25" <?if ($tag=="25"){echo "selected";}else{}?>>25</option>
								<option value="26" <?if ($tag=="26"){echo "selected";}else{}?>>26</option>
								<option value="27" <?if ($tag=="27"){echo "selected";}else{}?>>27</option>
								<option value="28" <?if ($tag=="28"){echo "selected";}else{}?>>28</option>
								<option value="29" <?if ($tag=="29"){echo "selected";}else{}?>>29</option>
								<option value="30" <?if ($tag=="30"){echo "selected";}else{}?>>30</option>
								<option value="31" <?if ($tag=="31"){echo "selected";}else{}?>>31</option>
					      </select>
					  </td>
					  <td valign="bottom">
						<select name="m1" class="form-normal" style="font-family: Verdana; font-size: 8pt;">
								<option value="01" selected="selected">01</option>
								<option value="02" <?if ($monat=="02"){echo "selected";}else{}?>>02</option>
								<option value="03" <?if ($monat=="03"){echo "selected";}else{}?>>03</option>
								<option value="04" <?if ($monat=="04"){echo "selected";}else{}?>>04</option>
								<option value="05" <?if ($monat=="05"){echo "selected";}else{}?>>05</option>
								<option value="06" <?if ($monat=="06"){echo "selected";}else{}?>>06</option>
								<option value="07" <?if ($monat=="07"){echo "selected";}else{}?>>07</option>
								<option value="08" <?if ($monat=="08"){echo "selected";}else{}?>>08</option>
								<option value="09" <?if ($monat=="09"){echo "selected";}else{}?>>09</option>
								<option value="10" <?if ($monat=="10"){echo "selected";}else{}?>>10</option>
								<option value="11" <?if ($monat=="11"){echo "selected";}else{}?>>11</option>
								<option value="12" <?if ($monat=="12"){echo "selected";}else{}?>>12</option>
					      </select>
					  </td>
					  <td valign="bottom">
						<select name="j1" class="form-normal" style="font-family: Verdana; font-size: 8pt;">
								<option value="00" selected="selected">Jahr</option>
								<option value="1901" <?if ($jahr =="1901"){echo "selected";}else{}?>>1901</option>
								<option value="1902" <?if ($jahr =="1902"){echo "selected";}else{}?>>1902</option>
								<option value="1903" <?if ($jahr =="1903"){echo "selected";}else{}?>>1903</option>
								<option value="1904" <?if ($jahr =="1904"){echo "selected";}else{}?>>1904</option>
								<option value="1905" <?if ($jahr =="1905"){echo "selected";}else{}?>>1905</option>
								<option value="1906" <?if ($jahr =="1906"){echo "selected";}else{}?>>1906</option>
								<option value="1907" <?if ($jahr =="1907"){echo "selected";}else{}?>>1907</option>
								<option value="1908" <?if ($jahr =="1908"){echo "selected";}else{}?>>1908</option>
								<option value="1909" <?if ($jahr =="1909"){echo "selected";}else{}?>>1909</option>
								<option value="1910" <?if ($jahr =="1910"){echo "selected";}else{}?>>1910</option>
								<option value="1911" <?if ($jahr =="1911"){echo "selected";}else{}?>>1911</option>
								<option value="1912" <?if ($jahr =="1912"){echo "selected";}else{}?>>1912</option>
								<option value="1913" <?if ($jahr =="1913"){echo "selected";}else{}?>>1913</option>
								<option value="1914" <?if ($jahr =="1914"){echo "selected";}else{}?>>1914</option>
								<option value="1915" <?if ($jahr =="1915"){echo "selected";}else{}?>>1915</option>
								<option value="1916" <?if ($jahr =="1916"){echo "selected";}else{}?>>1916</option>
								<option value="1917" <?if ($jahr =="1917"){echo "selected";}else{}?>>1917</option>
								<option value="1918" <?if ($jahr =="1918"){echo "selected";}else{}?>>1918</option>
								<option value="1919" <?if ($jahr =="1919"){echo "selected";}else{}?>>1919</option>
								<option value="1920" <?if ($jahr =="1920"){echo "selected";}else{}?>>1920</option>
								<option value="1921" <?if ($jahr =="1921"){echo "selected";}else{}?>>1921</option>
								<option value="1922" <?if ($jahr =="1922"){echo "selected";}else{}?>>1922</option>
								<option value="1923" <?if ($jahr =="1923"){echo "selected";}else{}?>>1923</option>
								<option value="1924" <?if ($jahr =="1924"){echo "selected";}else{}?>>1924</option>
								<option value="1925" <?if ($jahr =="1925"){echo "selected";}else{}?>>1925</option>
								<option value="1926" <?if ($jahr =="1926"){echo "selected";}else{}?>>1926</option>
								<option value="1927" <?if ($jahr =="1927"){echo "selected";}else{}?>>1927</option>
								<option value="1928" <?if ($jahr =="1928"){echo "selected";}else{}?>>1928</option>
								<option value="1929" <?if ($jahr =="1929"){echo "selected";}else{}?>>1929</option>
								<option value="1930" <?if ($jahr =="1930"){echo "selected";}else{}?>>1930</option>
								<option value="1931" <?if ($jahr =="1931"){echo "selected";}else{}?>>1931</option>
								<option value="1932" <?if ($jahr =="1932"){echo "selected";}else{}?>>1932</option>
								<option value="1933" <?if ($jahr =="1933"){echo "selected";}else{}?>>1933</option>
								<option value="1934" <?if ($jahr =="1934"){echo "selected";}else{}?>>1934</option>
								<option value="1935" <?if ($jahr =="1935"){echo "selected";}else{}?>>1935</option>
								<option value="1936" <?if ($jahr =="1936"){echo "selected";}else{}?>>1936</option>
								<option value="1937" <?if ($jahr =="1937"){echo "selected";}else{}?>>1937</option>
								<option value="1938" <?if ($jahr =="1938"){echo "selected";}else{}?>>1938</option>
								<option value="1939" <?if ($jahr =="1939"){echo "selected";}else{}?>>1939</option>
								<option value="1940" <?if ($jahr =="1940"){echo "selected";}else{}?>>1940</option>
								<option value="1941" <?if ($jahr =="1941"){echo "selected";}else{}?>>1941</option>
								<option value="1942" <?if ($jahr =="1942"){echo "selected";}else{}?>>1942</option>
								<option value="1943" <?if ($jahr =="1943"){echo "selected";}else{}?>>1943</option>
								<option value="1944" <?if ($jahr =="1944"){echo "selected";}else{}?>>1944</option>
								<option value="1945" <?if ($jahr =="1945"){echo "selected";}else{}?>>1945</option>
								<option value="1946" <?if ($jahr =="1946"){echo "selected";}else{}?>>1946</option>
								<option value="1947" <?if ($jahr =="1947"){echo "selected";}else{}?>>1947</option>
								<option value="1948" <?if ($jahr =="1948"){echo "selected";}else{}?>>1948</option>
								<option value="1949" <?if ($jahr =="1949"){echo "selected";}else{}?>>1949</option>
								<option value="1950" <?if ($jahr =="1950"){echo "selected";}else{}?>>1950</option>
								<option value="1951" <?if ($jahr =="1951"){echo "selected";}else{}?>>1951</option>
								<option value="1952" <?if ($jahr =="1952"){echo "selected";}else{}?>>1952</option>
								<option value="1953" <?if ($jahr =="1953"){echo "selected";}else{}?>>1953</option>
								<option value="1954" <?if ($jahr =="1954"){echo "selected";}else{}?>>1954</option>
								<option value="1955" <?if ($jahr =="1955"){echo "selected";}else{}?>>1955</option>
								<option value="1956" <?if ($jahr =="1956"){echo "selected";}else{}?>>1956</option>
								<option value="1957" <?if ($jahr =="1957"){echo "selected";}else{}?>>1957</option>
								<option value="1958" <?if ($jahr =="1958"){echo "selected";}else{}?>>1958</option>
								<option value="1959" <?if ($jahr =="1959"){echo "selected";}else{}?>>1959</option>
								<option value="1960" <?if ($jahr =="1960"){echo "selected";}else{}?>>1960</option>
								<option value="1961" <?if ($jahr =="1961"){echo "selected";}else{}?>>1961</option>
								<option value="1962" <?if ($jahr =="1962"){echo "selected";}else{}?>>1962</option>
								<option value="1963" <?if ($jahr =="1963"){echo "selected";}else{}?>>1963</option>
								<option value="1964" <?if ($jahr =="1964"){echo "selected";}else{}?>>1964</option>
								<option value="1965" <?if ($jahr =="1965"){echo "selected";}else{}?>>1965</option>
								<option value="1966" <?if ($jahr =="1966"){echo "selected";}else{}?>>1966</option>
								<option value="1967" <?if ($jahr =="1967"){echo "selected";}else{}?>>1967</option>
								<option value="1968" <?if ($jahr =="1968"){echo "selected";}else{}?>>1968</option>
								<option value="1969" <?if ($jahr =="1969"){echo "selected";}else{}?>>1969</option>
								<option value="1970" selected="selected">1970</option>
								<option value="1971" <?if ($jahr =="1971"){echo "selected";}else{}?>>1971</option>
								<option value="1972" <?if ($jahr =="1972"){echo "selected";}else{}?>>1972</option>
								<option value="1973" <?if ($jahr =="1973"){echo "selected";}else{}?>>1973</option>
								<option value="1974" <?if ($jahr =="1974"){echo "selected";}else{}?>>1974</option>
								<option value="1975" <?if ($jahr =="1975"){echo "selected";}else{}?>>1975</option>
								<option value="1976" <?if ($jahr =="1976"){echo "selected";}else{}?>>1976</option>
								<option value="1977" <?if ($jahr =="1977"){echo "selected";}else{}?>>1977</option>
								<option value="1978" <?if ($jahr =="1978"){echo "selected";}else{}?>>1978</option>
								<option value="1979" <?if ($jahr =="1979"){echo "selected";}else{}?>>1979</option>
								<option value="1980" <?if ($jahr =="1980"){echo "selected";}else{}?>>1980</option>
								<option value="1981" <?if ($jahr =="1981"){echo "selected";}else{}?>>1981</option>
								<option value="1982" <?if ($jahr =="1982"){echo "selected";}else{}?>>1982</option>
								<option value="1983" <?if ($jahr =="1983"){echo "selected";}else{}?>>1983</option>
								<option value="1984" <?if ($jahr =="1984"){echo "selected";}else{}?>>1984</option>
								<option value="1985" <?if ($jahr =="1985"){echo "selected";}else{}?>>1985</option>
								<option value="1986" <?if ($jahr =="1986"){echo "selected";}else{}?>>1986</option>
								<option value="1987" <?if ($jahr =="1987"){echo "selected";}else{}?>>1987</option>
								<option value="1988" <?if ($jahr =="1988"){echo "selected";}else{}?>>1988</option>
								<option value="1989" <?if ($jahr =="1989"){echo "selected";}else{}?>>1989</option>
								<option value="1990" <?if ($jahr =="1990"){echo "selected";}else{}?>>1990</option>
								<option value="1991" <?if ($jahr =="1991"){echo "selected";}else{}?>>1991</option>
								<option value="1992" <?if ($jahr =="1992"){echo "selected";}else{}?>>1992</option>
								<option value="1993" <?if ($jahr =="1993"){echo "selected";}else{}?>>1993</option>
								<option value="1994" <?if ($jahr =="1994"){echo "selected";}else{}?>>1994</option>
								<option value="1995" <?if ($jahr =="1995"){echo "selected";}else{}?>>1995</option>
								<option value="1996" <?if ($jahr =="1996"){echo "selected";}else{}?>>1996</option>
								<option value="1997" <?if ($jahr =="1997"){echo "selected";}else{}?>>1997</option>
								<option value="1998" <?if ($jahr =="1998"){echo "selected";}else{}?>>1998</option>
								<option value="1999" <?if ($jahr =="1999"){echo "selected";}else{}?>>1999</option>
								<option value="2000" <?if ($jahr =="2000"){echo "selected";}else{}?>>2000</option>
								<option value="2001" <?if ($jahr =="2001"){echo "selected";}else{}?>>2001</option>
								<option value="2002" <?if ($jahr =="2002"){echo "selected";}else{}?>>2002</option>
								<option value="2003" <?if ($jahr =="2003"){echo "selected";}else{}?>>2003</option>
								<option value="2004" <?if ($jahr =="2004"){echo "selected";}else{}?>>2004</option>
								<option value="2005" <?if ($jahr =="2005"){echo "selected";}else{}?>>2005</option>
								<option value="2006" <?if ($jahr =="2006"){echo "selected";}else{}?>>2006</option>
								<option value="2007" <?if ($jahr =="2007"){echo "selected";}else{}?>>2007</option>
								<option value="2008" <?if ($jahr =="2008"){echo "selected";}else{}?>>2008</option>
								<option value="2009" <?if ($jahr =="2009"){echo "selected";}else{}?>>2009</option>
								<option value="2010" <?if ($jahr =="2010"){echo "selected";}else{}?>>2010</option>
								<option value="2011" <?if ($jahr =="2011"){echo "selected";}else{}?>>2011</option>
								<option value="2012" <?if ($jahr =="2012"){echo "selected";}else{}?>>2012</option>
					      </select>
					  </td>
					  <td valign="bottom">
						   <font color="#010347"><b><font color="#010347">
						   <input type="hidden" name="get" value="1" />
						   </font></b></font>
					  </td>
				 </tr>
			</table>
	   </form>
<? include("tools_forced_click.php");?>	   
	   <br />
	   <br />
	<? 
}
	?>