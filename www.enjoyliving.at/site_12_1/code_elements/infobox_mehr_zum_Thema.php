<?
$keyword_match_result = teaser_select_similar($active_menu_id,5);

if(count($keyword_match_result)>0){
echo"<b style='font-size:13px;color:#73ACE1;'>Mehr zum Thema</b><br>";
?>
<table>
	<? for($i=0,$i_limit=count($keyword_match_result);$i<$i_limit;$i++)
	{?>
		<tr>
			<td valign="top"><a href="<? echo find_googleurl($keyword_match_result[$i]); ?>" class="teasertext" style="text-decoration:none">&raquo;</a></td>
			<td><a href="<? echo find_googleurl($keyword_match_result[$i]); ?>" class="teasertext" style="text-decoration:none"><? echo find_description($keyword_match_result[$i]); ?></a></td>
		</tr>
	<? }?>
</table>
<div id=4 class='trenner'></div>
<? }?>