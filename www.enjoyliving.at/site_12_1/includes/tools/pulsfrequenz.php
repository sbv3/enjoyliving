<a name="puls" id="puls"></a>
<SCRIPT language=JavaScript src="/site_12_1/includes/tools/puls.js"></SCRIPT>
<h1>Berechnen Sie Ihre optimale Trainings-Pulsfrequenz!</h1>
Berechnen Sie hier Ihre optimalen Puls-Frequenz f&uuml;r die Fettverbrennung 
              bei sportlicher Belastung (Gymnastik, Fitness-Studio, Nordic Walking 
              etc):<br />
              <br />
              <br/>
              <form name=modul action="" method=post>
                <table class=bordertabletotal id=tablecolor cellspacing=3 cellpadding=2 border=0 width="100%">
                  <tbody> 
                  <tr> 
                    <td valign=top align=left width=350 bgcolor=#ffffff height=100><span id=inhalt> 
                      <table cellspacing=0 cellpadding=0 border=0 width="100%">
                        <tbody> 
                        <tr valign=top> 
                          <td width=140 height=30><strong>Ihr Lebensalter:</strong></td>
                          <td height=30> 
                            <input class=ModulField tabindex=1 maxlength=2 size=2 name=alter>
                            Jahre</td>
                        </tr>
                        <tr valign=top> 
                          <td height=30><strong>Ihr Ruhepuls:</strong></td>
                          <td height=35> 
                            <input class=ModulField tabindex=2 maxlength=3 size=3 value=72 name=ruhepuls>
                            Schl‰ge/ Min</td>
                        </tr>
                        <tr valign=top> 
                          <td width=140 height=30><strong>Ihr Trainingszustand:</strong></td>
                          <td height=35> 
                            <input class=ModulField tabindex=3 type=radio name=zustand>
                            untrainiert<br>
                            <input class=ModulField tabindex=4 type=radio CHECKED name=zustand>
                            mittelm‰ﬂig trainiert<br>
                            <input class=ModulField tabindex=5 type=radio name=zustand>
                            gut trainiert</td>
                        </tr>
                        <tr valign=center> 
                          <td colspan=2 height=50> 
                            <input onClick=PulseFrequency(this.form) tabindex=6 type=button value=Berechnen name="button" style="color:black;font-size:8pt;background-image:url(/well/guide/img/button_bg.gif);background-repeat:repeat-x;padding-left:8px;padding-right:8px;padding-top:1px;padding-bottom:1px;border:1px solid #999999;">
                            <input onClick="NewEntry('modul','ausgabe')" tabindex=7 type=reset value=Neu name=Zur&uuml;cksetzen style="color:black;font-size:8pt;background-image:url(/well/guide/img/button_bg.gif);background-repeat:repeat-x;padding-left:8px;padding-right:8px;padding-top:1px;padding-bottom:1px;border:1px solid #999999;">
                          </td>
                        </tr>
                        </tbody> 
                      </table>
                      </span> </td>
                  </tr>
                  <tr> 
                    <td valign=top align=left width=350 bgcolor=#ffffff height=0><span id=ausgabe></span></td>
                  </tr>
                  </tbody> 
                </table>