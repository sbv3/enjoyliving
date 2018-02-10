<?
$keyword_query = mysql_query("SELECT metatag_keywords FROM menu WHERE id=$active_menu_id")or die("keyword query failed: ".mysql_error());
$keyword_result = mysql_fetch_assoc($keyword_query);
$keyword_array=explode(",",$keyword_result[metatag_keywords]);
$keyword_array= array_slice($keyword_array, 0, 5); 
$keywords_match=implode("%' or metatag_keywords like '%",$keyword_array);
$keywords_match="'%".$keywords_match."%'";
$keyword_match_query = mysql_query("SELECT menu.id,description FROM menu,menu_hierarchy WHERE (metatag_keywords like $keywords_match) and search_type != 'Subseiten' and search_type != 'Pressemitteilung' and search_type!= 'Allgemeine Infos' and menu.id !='$active_menu_id' and (menu_hierarchy.active_startdate<=now() or menu_hierarchy.active_startdate='0000-00-00') and (menu_hierarchy.active_enddate>=now() or menu_hierarchy.active_enddate='0000-00-00') and menu_hierarchy.active='A' and site_id=$site_id and menu.id=menu_hierarchy.menu_id order by menu.createdate desc limit 5")or die("keyword match query failed: ".mysql_error());
if(mysql_num_rows($keyword_match_query)>0){
echo"<b style='font-size:13px;color:#73ACE1;'>Mehr zum Thema</b><br>";
?>
<table>
	<? while($keyword_match_result=mysql_fetch_assoc($keyword_match_query))
	{?>
		<tr>
			<td valign="top"><a href="<? echo find_googleurl($keyword_match_result['id']); ?>" class="teasertext" style="text-decoration:none">&raquo;</a></td>
			<td><a href="<? echo find_googleurl($keyword_match_result['id']); ?>" class="teasertext" style="text-decoration:none"><? echo $keyword_match_result[description]; ?></a></td>
		</tr>
	<? }?>
</table>
<div id=4 class='trenner'></div>
<? }?>