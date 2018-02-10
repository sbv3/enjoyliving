<?
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");

$img_q=mysql_query("select * from assets order by id asc");
while ($img_r=mysql_fetch_assoc($img_q))
{
	$from = "/site_12_1/assets/".$img_r[category].$img_r['class'].$img_r[path].$img_r[filename];
	$to1 = "/site_12_1/assets/".$img_r[category].$img_r['class'].$img_r[path]."~klein~".$img_r[filename];
	$to2 = "/site_12_1/assets/".$img_r[category].$img_r['class'].$img_r[path]."~mini~".$img_r[filename];
	if(!file_exists($_SERVER['DOCUMENT_ROOT'].$to1))
	{
		thumb($_SERVER['DOCUMENT_ROOT'].$from, $_SERVER['DOCUMENT_ROOT'].$to1, 150,150, TRUE);//with,height
		echo "klein: ".$img_r['ID']."<br>";
	}
	if(!file_exists($_SERVER['DOCUMENT_ROOT'].$to2))
	{
		thumb($_SERVER['DOCUMENT_ROOT'].$from, $_SERVER['DOCUMENT_ROOT'].$to2, 75,75, TRUE);//with,height
		echo "mini: ".$img_r['ID']."<br>";
	}
	
/*
	echo "<img src='$from'>";
	echo "<img src='$to1'>";
	echo "<img src='$to2'>";
	echo "<br>";
*/}
?>