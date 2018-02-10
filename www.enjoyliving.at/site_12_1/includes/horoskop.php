<?
####horoskop=übersichtssseite - name def. das include file
####horoskopID=welches horoskop soll aufgerufne werden
####zodiacID= horoskop für welches sternzeichen wird angezeogt
$calledurl=$_SERVER['REQUEST_URI'];
$horoskopID=strstr($calledurl,"/horoskope/horoskope/");

$horoskopID=substr($horoskopID,21);

$zodiacstart=strpos($horoskopID,",");
$zodiacID=substr($horoskopID,$zodiacstart+1);

if($zodiacstart!=""){$horoskopID=substr($horoskopID,0,$zodiacstart);}
if(substr($horoskopID,-1)=="/"){$horoskopID=substr($horoskopID,0,-1);}

if ($horoskopID=="")
{
#####Übersichtsseiten
#echo"Übersicht";

if ($horoskop==""){include ("$adminpath/site_12_1/includes/tools/horoskop/includes/start.php");  }
if ($horoskop=="horoskope"){include ("$adminpath/site_12_1/includes/tools/horoskop/includes/horoskope.php");  }
if ($horoskop=="astroguides"){include ("$adminpath/site_12_1/includes/tools/horoskop/includes/astroguides.php");  }
}
else
####Detailseiten
{
include ("$adminpath/site_12_1/includes/tools/horoskop/horoskopinclude.php");  
#echo"Detail";
}
?>