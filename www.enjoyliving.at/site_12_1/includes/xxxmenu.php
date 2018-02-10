<?
for ($anz=0;$anz<=count($menus);$anz+=1)
	{
	$menu_url=mysql_query("select description from menu where id='$menus[$anz]'") or die ("x1");
	while ($menu_url_fetch=mysql_fetch_object($menu_url))
		{
		$menu_url_display="$menu_url_fetch->description";
		echo "$menu_url_display <br>";
		}
	}
?>