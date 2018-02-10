<a name="sternresult" id="sternresult"></a>
<h1>Die Harmonie der Sternzeichen - wer passt zu Ihnen?</h1>"
Neben  vielen anderen astrologischen Faktoren, wie zum Beispiel dem Aszendent, dem Mondzeichen oder der Planetenkonstellation zum Zeitpunkt der Geburt, verr&auml;t uns das Sternzeichen eines Menschen viel &uuml;ber seine Eigenschaften und Charakterz&uuml;ge.
<br>
<br>
Mit unserem Test k&ouml;nnen Sie feststellen, wie verschiedene Sternzeichen grunds&auml;tzlich miteinander harmonieren, mit welchem  Astro-Partner Sie erotische H&ouml;henfl&uuml;ge erleben werden, und von wem Sie lieber die Finger lassen sollten. 
<br>
Bitte beachten Sie dabei jedoch folgendes: Wenn das Ergebnis des Tests nicht nach Ihren Vorstellungen und W&uuml;nschen ist, lassen Sie sich dadurch bitte nicht verunsichern, sondern vertrauen Sie in erster Linie Ihren Gef&uuml;hlen.
<br>
<br>

<strong>Machen Sie hier unseren Test:</strong>
<br/><br/>
<? if ($stern1=="" and $stern2=="")
{?>
<form action="<? if ($subpage!=""){$subpage1="/$subpage";}echo $testpfad."$googleurl$subpage1#sternresult";?>" method="post" name="orderform" id="form_tool" target="_self"> 
	<table width="100%" border="0" cellspacing="0" cellpadding="0">    
		<tr>
		<td width="5%"><label></label></td>
		<td width="25%">
			<select name="stern1" id="stern1">
				<option value="steinbock" <?if ($stern1=="steinbock"){echo"selected";}?>>Steinbock</option>
				<option value="wassermann" <?if ($stern1=="wassermann"){echo"selected";}?>>Wassermann</option>
				<option value="fisch" <?if ($stern1=="fisch"){echo"selected";}?>>Fische</option>
				<option value="widder" <?if ($stern1=="widder"){echo"selected";}?>>Widder</option>
				<option value="stier" <?if ($stern1=="stier"){echo"selected";}?>>Stier</option>
				<option value="zwilling" <?if ($stern1=="zwilling"){echo"selected";}?>>Zwilling</option>
				<option value="krebs" <?if ($stern1=="krebs"){echo"selected";}?>>Krebs</option>
				<option value="loewe" <?if ($stern1=="loewe"){echo"selected";}?>>L&ouml;we</option>
				<option value="jungfrau" <?if ($stern1=="jungfrau"){echo"selected";}?>>Jungfrau</option>
				<option value="waage" <?if ($stern1=="waage"){echo"selected";}?>>Waage</option>
				<option value="skorpion" <?if ($stern1=="skorpion"){echo"selected";}?>>Skorpion</option>
				<option value="schuetze" <?if ($stern1=="schuetze"){echo"selected";}?>>Sch&uuml;tze</option>
			</select>
		</td>
		<td width="25%">
			<select name="stern2" id="stern2">
				<option value="steinbock" <?if ($stern2=="steinbock"){echo"selected";}?>>Steinbock</option>
				<option value="wassermann" <?if ($stern2=="wassermann"){echo"selected";}?>>Wassermann</option>
				<option value="fisch" <?if ($stern2=="fisch"){echo"selected";}?>>Fische</option>
				<option value="widder" <?if ($stern2=="widder"){echo"selected";}?>>Widder</option>
				<option value="stier" <?if ($stern2=="stier"){echo"selected";}?>>Stier</option>
				<option value="zwilling" <?if ($stern2=="zwilling"){echo"selected";}?>>Zwilling</option>
				<option value="krebs" <?if ($stern2=="krebs"){echo"selected";}?>>Krebs</option>
				<option value="loewe" <?if ($stern2=="loewe"){echo"selected";}?>>L&ouml;we</option>
				<option value="jungfrau" <?if ($stern2=="jungfrau"){echo"selected";}?>>Jungfrau</option>
				<option value="waage" <?if ($stern2=="waage"){echo"selected";}?>>Waage</option>
				<option value="skorpion" <?if ($stern2=="skorpion"){echo"selected";}?>>Skorpion</option>
				<option value="schuetze" <?if ($stern2=="schuetze"){echo"selected";}?>>Sch&uuml;tze</option>
			</select>
		</td>
		<td width="25%">
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	</table>
</form>
<? include("tools_forced_click.php");?><? 
}
if ($stern1!="" and $stern2!="")
{?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="15%" valign="top"><? echo"<img src='/site_12_1/includes/tools/img/sternzeichen/$stern1.gif'>";?></td>
			<td width="70%">
				<div align="center"><strong>
					<?
					if ($stern1=="steinbock"){echo"Steinbock";}
					if ($stern1=="wassermann"){echo"Wassermann";}
					if ($stern1=="fisch"){echo"Fische";}
					if ($stern1=="widder"){echo"Widder";}
					if ($stern1=="stier"){echo"Stier";}
					if ($stern1=="zwilling"){echo"Zwilling";}
					if ($stern1=="krebs"){echo"Krebs";}
					if ($stern1=="loewe"){echo"Löwe";}
					if ($stern1=="jungfrau"){echo"Jungfrau";}
					if ($stern1=="waage"){echo"Waage";}
					if ($stern1=="skorpion"){echo"Skorpion";}
					if ($stern1=="schuetze"){echo"Schütze";}
					?> mit 
					<?
					if ($stern2=="steinbock"){echo"Steinbock";}
					if ($stern2=="wassermann"){echo"Wassermann";}
					if ($stern2=="fisch"){echo"Fische";}
					if ($stern2=="widder"){echo"Widder";}
					if ($stern2=="stier"){echo"Stier";}
					if ($stern2=="zwilling"){echo"Zwilling";}
					if ($stern2=="krebs"){echo"Krebs";}
					if ($stern2=="loewe"){echo"L&ouml;we";}
					if ($stern2=="jungfrau"){echo"Jungfrau";}
					if ($stern2=="waage"){echo"Waage";}
					if ($stern2=="skorpion"){echo"Skorpion";}
					if ($stern2=="schuetze"){echo"Sch&uuml;tze";}
					?>
				</strong><br></div>
				<br>
				<?
				$result= mysql_query("SELECT * FROM sternzeichen WHERE  (sternzeichen1='$stern1' and sternzeichen2='$stern2') or (sternzeichen1='$stern2' and sternzeichen2='$stern1') ")or die("Kann keine Datenbankverbindung herstellen brancheXX!");
				while ($show=mysql_fetch_object($result)) 
				{
					echo"$show->texti";
				}
				?>
			</td>
			<td width="15%" valign="top"> <div align="right"><?echo"<img src='/site_12_1/includes/tools/img/sternzeichen/$stern2.gif'>";?></div></td>
		</tr>
		<tr>
			 <td colspan=3 width="96%"><br /><a href="<? if ($subpage!=""){$subpage1="/$subpage";}echo $testpfad."$googleurl$subpage1";?>"><b><span class="bigfont_headline-grey">Welches Sternzeichen passt zu Ihnen – neu berechnen</span></b></a><br /><br /></td>
		</tr>
	</table>
	
	
	<?
}?>        