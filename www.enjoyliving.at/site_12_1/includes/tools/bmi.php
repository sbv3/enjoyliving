<a name="bmi" id="bmi"></a>
<h1>Berechnen Sie Ihren BMI (Body Mass Index)!</h1>
Ihr K&ouml;rpergewicht alleine sagt nicht viel dar&uuml;ber aus, 
              ob Sie zu dick sind oder nicht. Wesentlich bei der Beurteilung dieser 
              Frage ist der sogenannte BMI (Body Mass Index), der das Verh&auml;ltnis 
              zwischen K&ouml;rpergewicht und K&ouml;rpergr&ouml;sse darstellt. 
              <br>
              <br>
              <b>Mit nachfolgendem Formular k&ouml;nnen Sie Ihren BMI berechnen.</b> 
              <script language="JavaScript"><!--
function checkform (form2)
{
 if (form2.weight.value == "") {
 alert( "Bitte geben Sie Ihr Körpergewicht ein !" );
 form2.weight.focus();
 return false ;
 }
 if (form2.size.value == "") {
 alert( "Bitte geben Sie Ihre Körpergröße ein !" );
 form2.size.focus();
 return false ;
 }
 
 if(form2.size.value.indexOf('.')==1||form2.size.value.indexOf(',')==1)
{
alert ("Bitte geben Sie Ihre Körpergröße in cm ein !");
form2.size.focus();
return false
}
 if (form2.age.value == "") {
 alert( "Bitte geben Sie Ihre Alter ein !" );
 form2.age.focus();
 return false ;
 }
 if (form2.age.value <= "18") {
 alert( "Sie müssen über 18 sein, um an der Berechnung teilnehmen zu können !" );
 form2.age.focus();
 return false ;
 }
 // ** END **
 return true ;
}
//--></script>
              <br>
              <br>
              <table width="100%" cellspacing="0" cellpadding="0">
                <tr> 
                  <td colspan="2"></td>
                </tr>
                <tr> 
                  <td colspan="2" valign="top"> 
                    <form id="form_tool" onSubmit="return checkform(this);" method="post" target="_self">
                      <table class=bordertabletotal width="90%" border="0" cellspacing="2" cellpadding="2">
                        <tr> 
                          <td> 
                            <table width="100%" cellspacing="0" cellpadding="0" bgcolor="#F1F3FD">
                              <tr> 
                                <td width="50%">&nbsp;Ihr K&ouml;rpergewicht in 
                                  kg:</td>
                                <td width="50%"> 
                                  <input type="text" class="form-normal" name="weight" style="font-family: Verdana; font-size: 8pt;" size="12" maxlength="100" value="<?echo "$weight";?>">
                                </td>
                              </tr>
                              <tr> 
                                <td width="50%">&nbsp;Ihre K&ouml;rpergr&ouml;&szlig;e 
                                  in cm:</td>
                                <td width="50%"> 
                                  <input type="text" name="size" class="form-normal" style="font-family: Verdana; font-size: 8pt;" size="12" maxlength="100" value="<?echo "$size";?>">
                                </td>
                              </tr>
                              <tr> 
                                <td width="50%">&nbsp;Ihr Alter:</td>
                                <td width="25%"> 
                                  <input type="text" name="age" class="form-normal" style="font-family: Verdana; font-size: 8pt;" size="12" maxlength="100" value="<?echo "$age";?>">
                                  <input type="hidden" name="checker" value="1">
                                  <input type="hidden" name="co" value="<?echo "$co";?>">
                                </td>
                              </tr>
                              <tr> 
                                <td width="50%"> 
                                </td>
                                <td width="25%">&nbsp;</td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </form>
                    <? if (empty($checker)){?>
						<? include("tools_forced_click.php");?>
						<? }?>
                  </td>
                </tr>
                <tr> 
                  <td colspan="2"> 
                    <? if (empty($checker)){} else{?>
                 </td>
                </tr>
                <tr> 
                  <td colspan="2"><span class="bigfont_headline-grey"><br />
<b>Ihre Auswertung:</b></span> 
                    <?
##BMI Berechnung
$bmi=($weight/(($size/100)*($size/100)));
$bmi=round($bmi,1);
$bmi_normal=(21.5*(($size/100)*($size/100)));
$bmi_normal=round($bmi_normal,1);
#echo "$bmi_normal - ";
#echo "$bmi";
$a="<font color='#CC3300'><b>Achtung!</b><br><br></font><br><br>Ihr BMI betr&auml;gt <b>$bmi</b> und liegt somit unter dem Normalbereich (20-24,9). <br>Sie haben Untergewicht. <br>Es k&ouml;nnte bei Ihnen Magersucht vorliegen.<br>Sprechen Sie mit einem Arzt &uuml;ber Ihr Gewicht. <br>Ihr Idealgewicht liegt bei ungef&auml;hr $bmi_normal kg.<br><bR>";
$b="Ihr BMI betr&auml;gt <b>$bmi</b> und liegt somit leicht unter dem Normalbereich (20-24,9). <br>Sie haben leichtes Untergewicht. <br>Wenn Sie sich wohlf&uuml;hlen und keinerlei gesundheitliche Schwierigkeiten haben, ist der Wert noch zu akzeptieren. <br>Achten Sie jedoch darauf, keinesfalls weiter abzunehmen.<br>Ihr Idealgewicht liegt bei ungef&auml;hr $bmi_normal kg. 
<br><bR>";
$c="<b>Herzlichen Gl&uuml;ckwunsch!</b><br><br>Ihr BMI betr&auml;gt <b>$bmi</b> und liegt somit im Normalbereich (20-24,9).<br>Ihr Idealgewicht liegt bei ungef&auml;hr $bmi_normal kg.<br><bR>";
$d="Ihr BMI betr&auml;gt <b>$bmi</b> und liegt somit &uuml;ber dem Normalbereich (20-24,9). <br>Sie haben leichtes bis mittleres &Uuml;bergewicht (25-30). <br>Achten Sie drauf, ob eventuell Risikofaktoren wie Diabetes, Bluthochdruck oder erh&ouml;hte Cholesterinwerte vorliegen. <br>
Ist dies der Fall, sollten Sie jedenfalls einen Arzt aufsuchen und mit ihm &uuml;ber eine m&ouml;gliche Gewichtsreduktion sprechen. <br>Auf jeden Fall ist eine Gewichtsabnahme empfehlenswert. <br>Ihr Idealgewicht liegt bei ungef&auml;hr $bmi_normal kg.<br><bR>";
$e="<font color='#CC3300'><b>Achtung!</b><br><br></font> Ihr BMI betr&auml;gt <b>$bmi</b> und liegt somit stark &uuml;ber dem Normalbereich (20-24,9). <br>Sie haben starkes
&Uuml;bergewicht (31-39,9). <br>Eine Gewichtsreduktion ist dringend ratsam. <br>Ihr &Uuml;bergewicht belastet nicht nur Ihr Herz-Kreislaufsystem sondern
erh&ouml;ht auch das Risiko, an Diabetes zu erkranken. <br>Suchen Sie einen Arzt auf und besprechen Sie mit ihm die M&ouml;glichkeiten einer Gewichtsabnahme bzw. Nahrungsumstellung. 
<br>Ihr Idealgewicht liegt bei ungef&auml;hr $bmi_normal kg.<br><br>";
$f="<font color='#CC3300'><b>Achtung!</b></font><br><br> Ihr BMI betr&auml;gt <b>$bmi</b> und liegt somit stark &uuml;ber dem Normalbereich (20-24,9). <br>Sie haben sehr starkes
&Uuml;bergewicht (&uuml;ber 40). <br>Eine Gewichtsreduktion ist dringend ratsam. <br>Ihr &Uuml;bergewicht belastet nicht nur Ihr Herz-Kreislaufsystem sondern
erh&ouml;ht auch das Risiko, an Diabetes zu erkranken. <br>Suchen Sie einen Arzt auf und besprechen Sie mit ihm die M&ouml;glichkeiten einer Gewichtsabnahme bzw. Nahrungsumstellung. 
<br>Ihr Idealgewicht liegt bei ungef&auml;hr $bmi_normal kg.<br><br>";
 ?>
                    <?
$y=11;
if ($bmi < "18")
{
$info="$a";
$x=11;
}
elseif ($bmi > "18" and $bmi < "19")
{
$info="$b";
$x=$y+12;
}
elseif ($bmi >= "19" and $bmi < "20")
{
$info="$b";
$x=$y+(12*2);
}
elseif ($bmi >= "20" and $bmi < "21")
{
$info="$c";
$x=$y+(12*3);
}
elseif ($bmi >= "21" and $bmi < "22")
{
$info="$c";
$x=$y+(12*4);
}
elseif ($bmi >= "22" and $bmi < "23")
{
$info="$c";
$x=$y+(12*5);
}
elseif ($bmi >= "23" and $bmi < "24")
{
$info="$c";
$x=$y+(12*6);
}
elseif ($bmi >= "24" and $bmi <= "25")
{
$info="$c";
$x=$y+(12*7);
}
elseif ($bmi > "25" and $bmi < "26")
{
$info="$d";
$x=$y+(12*8);
}
elseif ($bmi >= "26" and $bmi < "27")
{
$info="$d";
$x=$y+(12*9);
}
elseif ($bmi >= "27" and $bmi < "28")
{
$info="$d";
$x=$y+(12*10);
}
elseif ($bmi >= "28" and $bmi < "29")
{
$info="$d";
$x=$y+(12*11);
}
elseif ($bmi >= "29" and $bmi <= "30")
{
$info="$d";
$x=$y+(12*12);
}
elseif ($bmi > "30" and $bmi < "31")
{
$info="$e";
$x=$y+(12*13);
}
elseif ($bmi >= "31" and $bmi < "32")
{
$info="$e";
$x=$y+(12*14);
}
elseif ($bmi >= "32" and $bmi < "33")
{
$info="$e";
$x=$y+(12*15);
}
elseif ($bmi >= "33" and $bmi < "34")
{
$info="$e";
$x=$y+(12*16);
}
elseif ($bmi >= "34" and $bmi < "35")
{
$info="$e";
$x=$y+(12*17);
}
elseif ($bmi >= "35" and $bmi < "36")
{
$info="$e";
$x=$y+(12*18);
}
elseif ($bmi >= "36" and $bmi < "37")
{
$info="$e";
$x=$y+(12*19);
}
elseif ($bmi >= "38" and $bmi < "39")
{
$info="$e";
$x=$y+(12*20);
}
elseif ($bmi >= "39" and $bmi < "40")
{
$info="$e";
$x=$y+(12*21);
}
elseif ($bmi >= "40" and $bmi < "41")
{
$info="$f";
$x=$y+(12*22);
}
elseif ($bmi >= "41" and $bmi < "42")
{
$info="$f";
$x=$y+(12*23);
}
elseif ($bmi >= "42" and $bmi < "43")
{
$info="$f";
$x=$y+(12*24);
}
elseif ($bmi >= "43")
{
$info="$f";
$x=$y+(12*24);
}
else
{
$x="11";
} 
?>
                  </td>
                </tr>
                <tr> 
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr> 
                  <td colspan="2"> 
                    <?echo "$info";
 if ($age > "35")
 {
 echo "Ab einem Alter von 50 Jahren wird ein Body Mass Index bis 26 noch als normal angesehen.<br><br>
";
 }
 elseif ($age < "18")
 {
 echo "Unter einem Alter von 18 Jahren ist der Body Mass Index zur Berechnung des Normalgewichtes nicht geeignet.<br><br>";
 }
 ?>
                  </td>
                </tr>
                <tr> 
                  <td colspan="2" valign="top"> 
                    <div id="Layer1" style="position:absolute; width:200px; height:115px; z-index:1"><img src="/page/tools/img/diet/1.jpg" width="318" height="90"></div>
                    <div align="left"> 
                      <div id="Layer1" style="position:absolute; width:320px; height:115px; z-index:1"><img src="/page/tools/img/diet/leer.gif" width="<?echo "$x";?>" height="72"><img src="/page/tools/img/diet/balken.gif" width="11" height="72"></div>
                    </div>
                  </td>
                </tr>
                <tr> 
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr> 
                  <td colspan="2" height="20"><br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <span class="bigfont_headline-grey"><b>Beurteilung:</b></span></td>
                </tr>
                <tr> 
                  <td colspan="2"> 
                    <table width="95%" border=0 cellspacing="2" cellpadding="2" bgcolor="white">
                      <tr> 
                        <td>&nbsp;</td>
                        <td valign="top"><b>BMI</b></td>
                        <td>Risiko, &uuml;bergewichtsbedingte Erkrankungen zu 
                          bekommen</td>
                      </tr>
                      <tr bgcolor=yellow> 
                        <td>Untergewicht</td>
                        <td>-19</td>
                        <td>keines</td>
                      </tr>
                      <tr bgcolor="#66cc00"> 
                        <td>Normalgewicht</td>
                        <td>19-25</td>
                        <td>durchschnittlich</td>
                      </tr>
                      <tr bgcolor=yellow> 
                        <td bgcolor="yellow">&Uuml;bergewicht</td>
                        <td>25-30</td>
                        <td>erh&ouml;ht</td>
                      </tr>
                      <tr bgcolor=#ffcc00> 
                        <td>Adipositas Klasse I</td>
                        <td>30-35</td>
                        <td>deutlich erh&ouml;ht</td>
                      </tr>
                      <tr bgcolor=#ff6600> 
                        <td><font color="white">Adipositas Klasse II</font></td>
                        <td><font color="white">35-40</font></td>
                        <td><font color="white"><b>hoch</b></font></td>
                      </tr>
                      <tr bgcolor=red> 
                        <td><font color="white">Adipositas&nbsp;Klasse&nbsp;III 
                          </font></td>
                        <td><font color="white">40+</font></td>
                        <td><font color="white"><b>sehr hoch</b></font></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr> 
				 <td colspan=3 width="96%"><br /><a href="<? if ($subpage!=""){$subpage1="/$subpage";}echo $testpfad."$googleurl$subpage1";?>"><b><span class="bigfont_headline-grey">BMI neu berechnen</span></b></a><br /><br /></td>
                </tr>
                <tr> 
                  <td colspan="2"> 
                    <? }?>
                  </td>
                </tr>
              </table>
			  
