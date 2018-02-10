<?
if ((PHP_VERSION>='5')&&extension_loaded('xsl'))
 require_once($_SERVER['DOCUMENT_ROOT'].'site_12_1/includes/tools/horoskop/xslt-php4-to-php5.php'); //Load the PHP5 converter

//echo "<p>horoskopID: '" . $horoskopID . "'</p>";
//echo "<p>zodiacID: '" . $zodiacID . "'</p>";

//check the variable content and set default values if empty:
if (strlen($horoskopID) == 0)
 {
 $horoskopID = "start";
 }
 echo $zodiaxID;
if (strlen($zodiacID) == 0)
 {
 $zodiacID = "widder";
 }

// find the proper horoscope xml file:  (select the tageshorskop, if retriving the proper horoscope xml file fails )
$xslh = xslt_create();
$xslhxmlurl = $_SERVER['DOCUMENT_ROOT']."site_12_1/includes/tools/horoskop/includes/horoscopes.xml";
$xslhxml = file_get_contents($xslhxmlurl);
$xslhxslurl = $_SERVER['DOCUMENT_ROOT']."site_12_1/includes/tools/horoskop/includes/returnxmlurl.xsl";
$xslhxsl = file_get_contents($xslhxslurl);

$xslharguments = array('/_xml' => $xslhxml,'/_xsl' => $xslhxsl);
$xslhparameters = array('horoskopID' => $horoskopID);

$xslhresult = xslt_process($xslh,'arg:/_xml','arg:/_xsl',NULL,$xslharguments,$xslhparameters);
if ($xslhresult)
 {
 $xmlurl = $xslhresult;
 }
else
 {
 $xmlurl = "http://api.viversum.de/xml/horoscopeDayFormal?apikey=6497f017cc4594fb777ae56904234f62";
 }
 
xslt_free($xslh);

//perform the transformation of the xml file containing the horoscope text:
$xh = xslt_create();

$xml = file_get_contents($xmlurl);
$xslurl = $_SERVER['DOCUMENT_ROOT']."site_12_1/includes/tools/horoskop/includes/horoskop.xsl";
$xsl = file_get_contents($xslurl);

$arguments = array('/_xml' => $xml,'/_xsl' => $xsl);
$parameters = array('horoskopID' => $horoskopID,'zodiacID' => $zodiacID);

$result = xslt_process($xh,'arg:/_xml','arg:/_xsl',NULL,$arguments,$parameters);

$result=str_replace("/enjftfxb/www.enjoyliving.at/",$_SERVER['DOCUMENT_ROOT'],$result);

//return the transformed result (the HTML) to the browser
if ($result)
 {
 echo utf8_decode($result);
 }
 else
 {
 echo "A transformation error occured: ";
 echo "The reason is supposedly that " . xslt_error($xh);
 echo " and the error code is " . xslt_errno($xh);
}

xslt_free($xh);
?>