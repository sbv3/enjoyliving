<div class='artikelbox' style="float:left">
	<div style="width:200px; overflow: hidden;">
		<? ###Advertorial
		if ($codes[2] !="" and $codes_active[2]==1){include $codes[2];}
		?>
	</div>
	<?
	
###Image	
if($imgs_alt_tag[1]!="default"){
	echo"<link rel='image_src' href='$href_root/$imgs[1]' />";
	echo "<img title='$imgs_alt_tag[1]' alt='$imgs_alt_tag[1]' src='$imgs[1]' style='width:100%'>";
	echo "<div id=17 class='trenner'></div>";
}

###Zusatzinfo
if ($texts[1] !=""){
echo"<b class='infoboxzwischenheads'>Info</b><br>";
echo "<div class='$texts_style[1]'>$texts[1]</div>";
	echo "<div id=2 class='trenner'></div>";}
	
###Tags
if ($codes[3] !="" and $codes_active[3]==1){include $codes[3];}
	
###Mehr zum Thema
if ($codes[1] !="" and $codes_active[1]==1){include $codes[1];}

###Webtipps
	if ($texts[2] !=""){
	echo"<b class='infoboxzwischenheads'>Webtipps</b><br>";
	$links_array=explode(",",$texts[2]);
	for($i=0;$i<count($links_array)+1;++$i)
	{
		echo "<a href='http://".$links_array[$i]."' class='artikeltext' target='_blank'>".$links_array[$i]."</a><br>";
	}
	echo "<div id=5 class='trenner'></div>";
}

	
###Google
echo"<script type=\"text/javascript\"><!--
google_ad_client = \"pub-5166723294900636\";
/* 200x200, Erstellt 28.01.11 */
google_ad_slot = \"7427494366\";
google_ad_width = 200;
google_ad_height = 200;
//-->
</script>
<script type=\"text/javascript\"
src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
</script>";

echo"</div>";

###text
echo "<div class='$texts_style[3]'>$texts[3]</div>";

echo"<div class='clear_left'></div>";

?>