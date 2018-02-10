<? 
include("usrdb_enjftfxb2.php");
$url_query=mysql_query("select concat('/neuesmag',googleurl) as googleurl from googleurl where create_date<'2011-11-01'") or die (mysql_error());
//$url_query=mysql_query("select googleurl from googleurl where create_date='2011-01-01 00:00:00'") or die (mysql_error());
$url_numrows=mysql_num_rows($url_query);

for($i=0;$i<20;$i++)
{
$url_pointer=rand(0,$url_numrows-1);
mysql_data_seek($url_query,$url_pointer);
$url_res=mysql_fetch_assoc($url_query);
$url="http://www.enjoyliving.at".$url_res['googleurl'];

//$url="http://www.enjoyliving.at/neuesmagazin/gesund-und-fit-magazin/ratgeber-gesundheit.html";

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$begintime = $time;

$handle = curl_init($url);
curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($handle,CURLOPT_NOBODY,FALSE);
/* Get the HTML or whatever is linked in $url. */
$response = curl_exec($handle);

/* Check for 404 (file not found). */
$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
if($httpCode > 399) {echo $handle."404!!!!!!!!!!!!!!";
    /* Handle 404 here. */
}
//echo $response;

curl_close($handle);
//echo $response."<br>"

$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$endtime = $time;
$totaltime = ($endtime - $begintime);
echo 'PHP parsed this page '.$url.' in ' .$totaltime. ' seconds.<br>';
$duration[$i]=$totaltime;
}
echo "Total: ".array_sum($duration)/$i;
/* Handle $response here. */
?>