<?
session_start();
?>
<?
class Timer{
  public $timerStart;
  public $timerEnd;
  public $name;
  
  public function start(){
    $this->timerStart = microtime(true);
    $this->timerEnd = 0;
  }

  public function stop(){
    $this->timerEnd = microtime(true);
  }

  public function get(){
    if($this->timerEnd == 0) $this->stop();
      $duration = $this->timerEnd - $this->timerStart;
	  $name=$this->name;
	  ?>
	  <script>console.log('name: ' + '<? echo $name;?>' + ' - execution time: ' + <? echo $duration ?> + ' seconds');</script>
	  <?
  }
}
?>
<?

$adminpath=$_SERVER['DOCUMENT_ROOT'];

$Timer_E2E = new Timer;
$Timer_E2E->name="End-to-End";
$Timer_E2E->start();

$Timer = new Timer;
$Timer->name="Load Connections";
$Timer->start();
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
$Timer->stop();
$Timer->get();
?>
<div id="pc_id_update_response"></div>
<?
$heute = date("Y-m-d");
//echo $googleurl."_1<br>";
//echo $subpage."_2<br>";
//echo $getcode."_3<br>";

//if(substr($googleurl,-3)=="php"){$googleurl=substr($googleurl,0,-3)."html";}
//echo $googleurl;
###definition der aktuellen MenuID des aktuelllen menus (channel, rubrik, schwerpunkt oder artikel)
$Timer = new Timer;
$Timer->name="find menu_id";
$Timer->start();

$active_menu_id_select=mysql_query("select googleurl.menu_id from googleurl, menu_hierarchy where googleurl='$googleurl' and menu_hierarchy.menu_id=googleurl.menu_id and menu_hierarchy.site_id=$site_id and menu_hierarchy.site_id=googleurl.site_id order by create_date desc limit 1") or die ("x1");
while ($active_menu_id_show=mysql_fetch_object($active_menu_id_select)){$active_menu_id="$active_menu_id_show->menu_id";}
if($active_menu_id==""){$active_menu_id=$home_menu_id;}
$menu_id=$active_menu_id; 

//echo $site_id;
//echo "<br>";
//echo $menu_id;


$Timer->stop();
$Timer->get();

$Timer = new Timer;
$Timer->name="PC-ID statistik";
$Timer->start();

include_once($_SERVER['DOCUMENT_ROOT']."Connections/flash_cookie/pc_id_tracking.php");
$Timer->stop();
$Timer->get();

?>
<?
$Timer = new Timer;
$Timer->name="kill bots + googleurl stat";
$Timer->start();

//Identifikation von robots
if (isset($_SERVER['HTTP_USER_AGENT'])){ $user_agent = ($_SERVER['HTTP_USER_AGENT']); } else { $b4yc_user_agent = ""; }
if (checkBot($user_agent)) {$bot=1;} else {$bot=0;}

if($onsitestats==1)
{//als nächstes tragen wir den Seitenaufruf in die googleurl_statistik ein.//
	$googleurl_sql=GetSQLValueString($googleurl,"text");
	$useragent_sql=GetSQLValueString($_SERVER['HTTP_USER_AGENT'],"text");
	mysql_query("call googleurl_count($googleurl_sql,$menu_id,$bot,$useragent_sql,$site_id);") or die (mysql_error());
}

$Timer->stop();
$Timer->get();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<head>
<link rel="alternate" type="application/rss+xml" title="EnjoyLiving" href="http://www.enjoyliving.at/xml/rss.xml" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?
$Timer = new Timer;
$Timer->name="build header";
$Timer->start();


$zufallszahl = rand(1000000000,9999999999);
?>
<?
######METATAGS Abfrage der table cache_cms mittels googleurl
$location=mysql_query("select metatag_title, metatag_keywords, metatag_description from menu where id='$menu_id'") or die ("x2");
while ($locationshow=mysql_fetch_object($location))
{
#$meta_fb_title=utf8_encode($locationshow->metatag_title);
$meta_fb_title=htmlentities ( $locationshow->metatag_title);
$meta_fb_description=htmlentities ( $locationshow->metatag_description );
$meta_fb_keywords=htmlentities ( $locationshow->metatag_keywords);

echo"<title>$meta_fb_title</title>";
echo"<META NAME=\"description\" CONTENT=\"$meta_fb_description\"/>";
echo"<META NAME=\"keywords\" CONTENT=\"$meta_fb_keywords\"/>";
//opengraph metatags für pinterest
$aktuelleseiteurl = $_SERVER['REQUEST_URI'];
echo"<meta property=\"og:type\" content=\"article\" />
<meta property=\"og:title\" content=\"$meta_fb_title\" />
<meta property=\"og:description\" content=\"$meta_fb_description\" />
<meta property=\"og:url\" content=\"http://www.enjoyliving.at$aktuelleseiteurl\" />
<meta property=\"og:site_name\" content=\"EnjoyLiving.at\" />
<meta property=\"article:published_time\" content=\"2016-02-10T00:04:25+00:00\" />
<meta property=\"article:author\" content=\"EnjoyLiving.at\" />";
///code für pintereest
echo"<meta name=\"p:domain_verify\" content=\"2a3dbc8f9f608eef8ae0474e67d778cd\"/>";
//// ende open graph
}
####interactive code
if($bot==0){include ("$adminpath/site_12_1/interactive_code.php");}
?>
<script>
function doPrint(reqUrl) {
 window.open(reqUrl, "displayWindow", "width=570,height=670,resizable=yes,scrollbars=yes").focus();
}
function openGuide(reqUrl) {
 window.open(reqUrl, "displayWindow", "width=570,height=1200,resizable=yes,scrollbars=yes").focus();
}
</script>

<?php #

$Timer->stop();
$Timer->get();

$Timer = new Timer;
$Timer->name="google analytics";
$Timer->start();

if($google_analytics!="" and $bot==0){include_once($_SERVER['DOCUMENT_ROOT']."Connections/analyticstracking.php");}
 
$Timer->stop();
$Timer->get();
?>
<?

/*#google adserver code
?>
<script type='text/javascript'>
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') + 
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
</script>

<script type='text/javascript'>
googletag.cmd.push(function() {
googletag.defineSlot('/8064520/Sitelink_small', [260, 90], 'div-gpt-ad-1327506663552-0').addService(googletag.pubads());
googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>
<?*/
##ende google adserver code

$Timer = new Timer;
$Timer->name="bis menubar";
$Timer->start();

?>

</head>
<body class="basislayout_body">
<table class="basistable" width="1034px" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="984" valign="top">
			<div class="basislayout_setup" id='basisdiv'>
				<!--Sky/Bigsize banner-->
     				<div class="basislayout_seitenabstand" id='banner1'>
						<? ####möglicher Ad für Kombi Ad aus Sky/Bigsize
						if($banners==1){echo"<div style='padding-bottom:6px;width:965px;'><script>OAS_AD('x01'); </script></div>";}//Bigsize
						?>
					</div>
				<!--Header-->
				<div class="basislayout_seitenabstand" id='header1'>
					<div class="basislayout_kopfzeile">
						<? 
						$find_header_q=mysql_query("select menu_id from site_menu_ids where site_id=$site_id and kopf_fuss='kopf'");
						while ($find_header_r=mysql_fetch_assoc($find_header_q))
						{
							if($head_run==1){?><font color="<? echo $color_kopf_fußzeile;?>">&#8226;</font><? } $head_run=1;
							?>
							<a class="kopf_fusszeile" href="<? echo $href_root.find_googleurl($find_header_r[menu_id]);?>"><? echo find_description($find_header_r[menu_id])?></a>
						<?
						}
						 ?>
					</div>
					<a href="<? echo $href_root //Kopfbildlink?>">
						<? echo $basislayout_seitenkopf; //Kopfbild
$Timer->stop();
$Timer->get();

$Timer = new Timer;
$Timer->name="menubar";
$Timer->start();


						?> 
					</a>
				</div>
				<div class="basislayout_seitenabstand" id='containerx1'>
					<!--Menubar-->
					<? 
					include ('menubar.php');
$Timer->stop();
$Timer->get();

$Timer = new Timer;
$Timer->name="whereami";
$Timer->start();


					?>
					<!--whereami-->
					<div class="basislayout_whereami_container">
						<? echo whereami("content",$menu_id); // der erste Parameter muss "content" oder "admin" sein, je nachdem welche Addresse als href ausgegeben werden soll?>
					</div>
					<!--sponsorbaner-->
					<div id="Sponsorbanner" class="basislayout_sponsorbanner_container">
	
						<?php /////////////Sponsorbanner
$Timer->stop();
$Timer->get();

$Timer = new Timer;
$Timer->name="sponsorbanner";
$Timer->start();

						$test_menu_id=$menu_id;
						do{
							$elements_exist_query=mysql_query("select count(1) as Anz, exklusiver_sponsorbanner from element, menu_hierarchy where element_layout_id in (select id from element_layout where type like '%sponsorbanner%') and element.menu_id=$test_menu_id and element.site_id=$site_id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=element.site_id") or die("x1.3");//testet ob elemente bestehen, danach wird getestet ob sponsorbannerelemente bestehen
							$elements_anzahl=mysql_fetch_assoc($elements_exist_query);
							$test_menu_id_parent = find_parent($test_menu_id);
							if ($elements_anzahl[Anz] == 0 or ($elements_anzahl[exklusiver_sponsorbanner]==1 and $test_menu_id!=$ergebnis->id))
							{$test_menu_id = $test_menu_id_parent;}
							else {$used_menu_id=$test_menu_id;break;}								
						} while ($test_menu_id > 0);
						
						if($used_menu_id!=""){//Finde die LayoutID vom Sponsorbanner. Dann finde alle Elemente, die die used_menu_id haben und vom Layouttyp sind. Schreibe die Element ID raus, und ruf den Sponsorbannerlayoutpfad auf.
							$sponsorbanner_element_layout_id_query=mysql_query("select id, php_snippet from element_layout where type like '%sponsorbanner%'");
							$sponsorbanner_element_layout_id_result=mysql_fetch_assoc($sponsorbanner_element_layout_id_query);
							$sponsorbanner_element_layout_id=$sponsorbanner_element_layout_id_result[id];
							$sponsorbanner_element_layout_path=$sponsorbanner_element_layout_id_result[php_snippet];
					
							$sponsorbanner_query=mysql_query("select element.id from element, menu_hierarchy where element_layout_id in (select id from element_layout where type like '%sponsorbanner%') and element.menu_id=$used_menu_id and element.site_id=$site_id and element.menu_id=menu_hierarchy.menu_id and menu_hierarchy.site_id=element.site_id")or die(mysql_error());
							$sponsorbanner_num_rows=mysql_num_rows($sponsorbanner_query);
							if($sponsorbanner_num_rows > 0){
								$sponsorbanner=mysql_fetch_assoc($sponsorbanner_query);
								$kampagne_element_id=$sponsorbanner[id];
								$element_content_id[$kampagne_element_id]=$sponsorbanner_element_layout_id;
								
								include"$sponsorbanner_element_layout_path";
							}
						}
						$used_menu_id="";
$Timer->stop();
$Timer->get();

$Timer = new Timer;
$Timer->name="content";
$Timer->start();
						?>				
					</div>
				</div>
				<!--Content-->
				<div class="basislayout_contentcontainer1" id='contentcontainer2'>
					<!-- google_ad_section_start -->
						<? include ("$adminpath/site_12_1/content_V1.php");?>
					<!-- google_ad_section_end -->
				</div>
				<!--Seitencontent-->
				<div class="basislayout_seitencontent_container">
					<? 
$Timer->stop();
$Timer->get();

$Timer = new Timer;
$Timer->name="seitencontent";
$Timer->start();
					if($seitencontent==1){include ("$adminpath/site_12_1/seitencontent_V1.php");}
					?>
				</div>
				<!--Footer-->
				<div class='basislayout_footer' id='footer1'>
					<div align="center">
						<? 
$Timer->stop();
$Timer->get();

$Timer = new Timer;
$Timer->name="footer";
$Timer->start();
						$find_header_q=mysql_query("select menu_id from site_menu_ids where site_id=$site_id and kopf_fuss='fuss'");
						while ($find_header_r=mysql_fetch_assoc($find_header_q))
						{
							if($footer_run==1){?><font color="<? echo $color_kopf_fußzeile;?>">&#8226;</font><? } $footer_run=1;
							?>
							<a class="kopf_fusszeile" href="<? echo $href_root.find_googleurl($find_header_r[menu_id]);?>"><? echo find_description($find_header_r[menu_id])?></a>
						<?
						}
$Timer->stop();
$Timer->get();

$Timer = new Timer;
$Timer->name="cleanup";
$Timer->start();
						 ?>
					</div>
				</div>
			</div>
		</td>
<?php /*?>		<td valign="top">
			<!--Skyscraper-->
			<div style='float:left;' id='sky'; >
				<? if($banners==1){?><script>OAS_AD('Right1'); //sky</script><? }?>
				<script>
					$("#sky").add($('#sky').children()).css("width","300px");
				</script>
			</div>
			<!--Footer-->
			<div style='float:left;' id='footer_banner'; >
				<? if($banners==1){?><script>OAS_AD('Right2'); //sky</script><? }?>
			</div>
		</td><?php */?>
	</tr>
</table>
<?
$Timer->stop();
$Timer->get();

$Timer_E2E->stop();
$Timer_E2E->get();

?>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
</body>
</html>