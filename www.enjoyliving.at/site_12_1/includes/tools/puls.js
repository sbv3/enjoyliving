  // bestimme Browserversion
  var brw = navigator.appName.toLowerCase();

  var ie  = (brw.indexOf("microsoft") != -1);	//Internet Explorer ab Vers. 1
  var nav = (brw.indexOf("netscape") != -1) && (parseInt(navigator.appVersion) < 5);	// Netscape 4
  var net = (brw.indexOf("netscape") != -1) && (parseInt(navigator.appVersion) >= 5);	// Composer ab 6.1


 function NewEntry(form,id)
	{
	var ausgabe = document.getElementById(id);
	ausgabe.innerHTML = "";
	}

 function PulseFrequency(form)
	{
	var ta = new Number(form.alter.value);
	var rhf = new Number(form.ruhepuls.value);
	var mhf = 220 - ta;
	var x;
	var thf;
	var span = document.getElementById("ausgabe");
	var fehlermeldung = 0;
	var meldung;
	var sghf;
	var afhf;
	var vfhf;
	
	// checke Eingabe
	if(form[1].value == "") fehlermeldung = "Bitte geben Sie Ihren Ruhepuls ein (Standard = ca.70)!";
	if(form[0].value == "") fehlermeldung = "Bitte geben Sie Ihr Lebensalter in Jahren ein!";

	
	// bestimme Trainingszustand
	if(form[2].checked) x = 0.6;
	if(form[3].checked) x = 0.7;
	if(form[4].checked) x = 0.75;

	// bestimme Trainingsbereiche
	sghf_u = Math.ceil(mhf/100*50);
	sghf_o = Math.ceil(mhf/100*60);
	sghf = sghf_u+"-"+sghf_o;

	afhf_u = Math.ceil(mhf/100*60);
	afhf_o = Math.ceil(mhf/100*70);
	afhf = afhf_u+"-"+afhf_o;

	vfhf_u = Math.ceil(mhf/100*70);
	vfhf_o = Math.ceil(mhf/100*85);
	vfhf = vfhf_u+"-"+vfhf_o;

	
	// berechne Grenzpuls
	thf = Math.round( rhf+(220-(ta/4*3)-rhf)*x );

	// Text für Ausgabe
	var text = "\
	<table border='0' cellspacing='0' cellpadding='0' class='ModulResult'>\
          <tr valign='top'> \
            <td height='25'  width='350'colspan='2'><u>Ihr Pulsfrequenzbereich f&uuml;r maximale \
              Erfolge!</u></td>\
          </tr>\
          <tr align='left'> \
            <td width='200' height='18'>Stabile Gesundheit:</td>\
            <td width='150' height='18'>"+sghf+"</td>\
          </tr>\
          <tr align='left' bgcolor='#F7F7F7'> \
            <td width='200' height='18'>Aktiver Fettstoffwechsel:</td>\
            <td width='150' height='18'>"+afhf+"</td>\
          </tr>\
          <tr align='left'> \
            <td width='200' height='18'>Verbesserte Fitness:</td>\
            <td width='150' height='18'>"+vfhf+"</td>\
          </tr>\
          <tr align='left' bgcolor='#F7F7F7' valign='bottom'> \
            <td width='200' height='22'>Grenzpuls f&uuml;r Ausdauer:</td>\
            <td width='150' height='22'>"+thf+"</td>\
          </tr>\
          <tr align='left' valign='bottom'> \
            <td width='200' height='18'>Maximalpuls:</td>\
            <td width='150' height='18'>"+mhf+"</td>\
          </tr>\
        </table>	";

	
	// ausgabe der Meldung
	if(fehlermeldung) meldung = "<font class='ModulError'>"+fehlermeldung+"</font>";
	else meldung = text;
	
	span.innerHTML = meldung;
	}
