<script language="JavaScript" type="text/javascript">
 <!--
//configuration
OAS_url ='http://austria1.adverserve.net/RealMedia/ads/';
OAS_listpos = 'Middle1,Middle2,Right1,Right2,x01,Top';
OAS_query = '';
<?
if ($thema=="urlaub-und-reisen" or $thema=="urlaub-trotz-krise" or $thema=="radtouren" or $thema=="burgwanderungen"){
echo"OAS_sitepage = 'www.enjoyliving.at/urlaub';";
}else{
####
if ($hauptkategorie=="gesundheit"){echo"OAS_sitepage = 'www.enjoyliving.at/gesundheit';";}
elseif ($hauptkategorie=="ernaehrung"){echo"OAS_sitepage = 'www.enjoyliving.at/ernaehrung';";}
elseif ($hauptkategorie=="geistseele"){echo"OAS_sitepage = 'www.enjoyliving.at/geistundseele';";}
elseif ($hauptkategorie=="fitvital"){echo"OAS_sitepage = 'www.enjoyliving.at/fitundvital';";}
elseif ($beauty=="beauty"){echo"OAS_sitepage = 'www.enjoyliving.at/beautyundfashion';";}
elseif ($hauptkategorie=="lebensart"){echo"OAS_sitepage = 'www.enjoyliving.at/lebensart';";}
elseif ($hauptkategorie==""){echo"OAS_sitepage = 'www.enjoyliving.at';";}
elseif ($hauptkategorie=="startseite"){echo"OAS_sitepage = 'www.enjoyliving.at/start';";}
else{echo"OAS_sitepage = 'www.enjoyliving.at';";}
###/marktplatz/special bei IA www.enjoyliving.at
}
?>
//end of configuration
OAS_version = 10;
OAS_rn = '001234567890'; OAS_rns = '1234567890';
OAS_rn = new String (Math.random()); OAS_rns = OAS_rn.substring (2, 11);
function OAS_NORMAL(pos) { 
document.write('<A HREF="' + OAS_url + 'click_nx.ads/' + OAS_sitepage + '/1' + OAS_rns + '@' + OAS_listpos + '!' + pos + OAS_query + '" TARGET=_top>');
document.write('<IMG SRC="' + OAS_url + 'adstream_nx.ads/' + OAS_sitepage + '/1' + OAS_rns + '@' + OAS_listpos + '!' + pos + OAS_query + '" BORDER=0 ALT="Click!"></A>');
}
//-->
</script>
<script language="JavaScript1.1" type="text/javascript">
<!--
OAS_version = 11;
if (navigator.userAgent.indexOf('Mozilla/3') != -1)
	OAS_version = 10;
if (OAS_version >= 11)
	document.write('<SC'+'RIPT LANGUAGE=JavaScript1.1 SRC="' + OAS_url + 'adstream_mjx.ads/' + OAS_sitepage + '/1' + OAS_rns + '@' + OAS_listpos + OAS_query + '"><\/SCRIPT>');
//-->
</script>
<script language="JavaScript" type="text/javascript">
<!-- 
document.write('');
function OAS_AD(pos) {
	if (OAS_version >= 11 && typeof(OAS_RICH)!='undefined')
OAS_RICH(pos);
	else
OAS_NORMAL(pos);
}
//-->
</script>
<!-- OAS SETUP end -->

<script type="text/javascript">
// <![CDATA[
	var nuggCall= new Image();
	var adserverurl= encodeURIComponent("http://austria1.adverserve.net/RealMedia/ads/cap.cgi?c=nggSTCook&va=NUGGVARS&e=6M");
	var nuggrid= encodeURIComponent(top.location.href);
	nuggCall.src = "http://styria.nuggad.net/bk?nuggn=1995838100&nuggsid=1265610032&nuggrid="+nuggrid+"&nuggl="+adserverurl+"&random="+Math.random();
// ]]>
</script>