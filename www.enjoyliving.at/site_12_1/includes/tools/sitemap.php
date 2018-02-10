<?
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");	

echo "<b style='font-size:13px;color:#73ACE1;'>Sitemap</b><br>";

$sitemap=menu_select($home_menu_id,'down','99','1','0','1');
?>

<table>
	<? for($i=0,$i_max=count($sitemap['id']);$i<$i_max;$i++)
	{?>
		<tr>
			<td style="padding-left:<? echo ($sitemap['level_down'][$i]*20)."px";?>">
				<a 
                    href="<? echo $sitemap['googleurl'][$i]; ?>" 
                    class="<? if($sitemap['level_down'][$i]==0){echo "titel";}if($sitemap['level_down'][$i]==1){echo "einleitung";}if($sitemap['level_down'][$i]>1){echo "artikeltext";}?>" 
                    style=" <? if($sitemap['level_down'][$i]<$sitemap['level_down'][$i+1]){echo "font-weight:bold;";} ?>">
                <? if($sitemap['level_down'][$i]==0){echo "<br>";}echo $sitemap['description'][$i];?>
              </a>
			</td>
		</tr>
	<? } //Ende 1?>
</table>