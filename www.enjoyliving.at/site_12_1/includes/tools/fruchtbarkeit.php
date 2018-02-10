<script language="JavaScript" type="text/JavaScript" src="/site_12_1/includes/tools/fkalender.js"></script>

<h1>Berechnen Sie Ihre fruchtbaren Tage</h1>
Berechnen Sie mit unserem Fruchtbarkeitskalender Ihre fruchtbaren/unfruchtbaren Tage
<form method="POST" enctype="application/x-www-form-urlencoded" onsubmit="$('.result_table').show();$('#banners').hide();$('.banner').hide();return fruchtbarkeitberechnen(this);" id="form_tool">
	<table bgcolor="#FFFFFF">
		<tr>
			<td width="289" height="30" bgcolor="#CED9E5" class=abstand>1.Tag 
				der letzten Periode:<br>
				<span class="smallfont">(Angaben bitte im Format TT.MM.JJJJ) </span></td>
			<td width="145" bgcolor="#CED9E5" class=abstand><input class="form-normal" type="TEXT" name="periode"size="14" maxlength="10" style="font-family: Verdana; font-size: 7pt;" value="01.01.1970"></td>
		</tr>
		<tr>
			<td width="289" height="30" bgcolor="#CED9E5" class=abstand>K&uuml;rzester 
				Zyklus der letzten 12 Monate:<br>
				<span class="smallfont">(22 bis 45 Tage, normal 28) </span></td>
			<td width="145" bgcolor="#CED9E5" class=abstand><input class="form-normal" type="TEXT" style="font-family: Verdana; font-size: 7pt;" name="kurz" size="3" maxlength="3" value="28" onfocus="this.form.kurz.value=''"></td>
		</tr>
		<tr>
			<td width="289" height="30" bgcolor="#CED9E5" class=abstand>L&auml;ngster 
				Zyklus der letzten 12 Monate:<br>
				<span class="smallfont">(22 bis 45 Tage, normal 28) </span></td>
			<td width="145" bgcolor="#CED9E5" class=abstand><input class="form-normal" type="TEXT" style="font-family: Verdana; font-size: 7pt;" name="lang" size="3" maxlength="3" value="28" onfocus="this.form.lang.value=''"></td>
		</tr>
	</table>
	<? include("tools_forced_click.php");?>
	<table bgcolor="#FFFFFF" class="result_table">
		<tr>
			<td colspan="2" >&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" height="28"><span style='FONT-SIZE: 15px; FONT-FAMILY: Verdana; color:#FF9900;font-weight: bold' class=abstand>Ergebnis</span></td>
		</tr>
		<tr>
			<td width="289" height="30" bgcolor="#CED9E5" class=abstand>Wahrscheinlicher 
				Eisprung:</td>
			<td width="145" bgcolor="#CED9E5" class=abstand><input type="TEXT" readonly name="eisprung" size="14"></td>
		</tr>
		<tr>
			<td width="289" height="30" bgcolor="#CED9E5" class=abstand>Erster 
				fruchtbarer Tag:</td>
			<td width="145" bgcolor="#CED9E5" class=abstand><input type="TEXT" readonly name="erstertag" size="14"></td>
		</tr>
		<tr>
			<td width="289" height="30" bgcolor="#CED9E5" class=abstand>Letzter 
				fruchtbarer Tag:</td>
			<td width="145" bgcolor="#CED9E5" class=abstand><input type="TEXT" readonly name="letztertag" size="14"></td>
		</tr>
		<tr>
			<td colspan="2" height="30"></td>
		</tr>
	</table>
	<input type="hidden" name="run" value="1" />
</form>
<div class="result_table">
<p>Bitte beachten Sie, dass eine zuverl&auml;ssige Aussage &uuml;ber 
	Ihre fruchtbaren / unfruchtbaren Tage nur nach einer gyn&auml;kologischen 
	Untersuchung m&ouml;glich ist!</p>

<a href="<? if ($subpage!=""){$subpage1="/$subpage";}echo $testpfad."$googleurl$subpage1";?>"><b><span class="bigfont_headline-grey">neu berechnen</span></b></a>
</div>
<script>$('.result_table').hide()</script>
