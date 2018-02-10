<?
session_start();
$adminpath=$_SERVER['DOCUMENT_ROOT'];
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");

$menu_id=$active_menu_id;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="alternate" type="application/rss+xml" title="EnjoyLiving" href="http://www.enjoyliving.at/xml/rss.xml" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?
######METATAGS Abfrage der table cache_cms mittels googleurl
if(substr($_SERVER['HTTP_REFERER'],0,strlen($href_root))!=$href_root)
{?>
	<meta http-equiv="Refresh" content="0; url=<? echo $href_root.find_googleurl($menu_id);?>" />
<? }
else
{
	$location=mysql_query("select metatag_title, metatag_keywords, metatag_description from menu where id='$menu_id'") or die ("x2");
	while ($locationshow=mysql_fetch_object($location))
	{
	echo"<title>$locationshow->metatag_title</title>";
	echo"<META NAME=\"description\" CONTENT=\"$locationshow->metatag_description\"/>";
	echo"<META NAME=\"keywords\" CONTENT=\"$locationshow->metatag_keywords\"/>";
	}
	?>
	</head>
	<body onLoad="self.print();">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="972" valign="top">
				<div style='width:972px;float:left;' id='basisdiv'>
					<div style="float:left; width:640px;" id='contentcontainer1'>
						<? include ("$adminpath/site_12_1/content_V1.php");?>
					</div>
				</div>
			</td>
		</tr>
	</table>
	</body>
	</html>
<?
}?>