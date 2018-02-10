<? 
if($google_ad_client!="" and $google_ad_channel!=""){
	
	$URL1 = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- contentempfehlungEL -->
	<ins class="adsbygoogle"
		 style="display:block"
		 data-ad-client="<? echo $google_ad_client; ?>"
		 data-ad-slot="<? echo $google_ad_contentempfehlung; ?>"
		 data-ad-format="autorelaxed"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>		
	
<? }?>
