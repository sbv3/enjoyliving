<? //////////vorbereitende Queries
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");

///Finding active channel for highlighting.
if($menu_id!=$home_menu_id and $menu_id!=0){
	$parent_channel=menu_select($menu_id,'up','','1','1','1');
	if(count($parent_channel[id])>0)
	{
		$parent_channel_level=end($parent_channel['id']);
		$parent_channel_level=array_search($parent_channel_level,$parent_channel['id']);
		$parent_channel_level=$parent_channel_level-1;
		$parent_channel_id=$parent_channel['id'][$parent_channel_level];
	}
}
?>

<?
$menubar=menu_select($home_menu_id,'down','3','1','1','1');
/*for($i=0;$i<count($menubar['id']);$i++)

{
	echo str_repeat("..",$menubar[level_down][$i]).$menubar[description][$i]." (".$menubar[level_down][$i].")<br>";
	}
*///print_r($menubar);?>
<div id="menu"><!-- öffnet die Navigationsleiste-->
	<? 
	$menubar['level_down'][-1]=-1;
	for($i=0;$i<count($menubar['id']);$i++)
	{?>
		<? if($menubar['level_down'][$i]-1 == $menubar['level_down'][$i-1]){echo "<ul><li";if($menubar['id'][$i]==$parent_channel_id){echo " class='menu_li_selected'";}echo ">";}?>
		<? if($menubar['level_down'][$i]+0 == $menubar['level_down'][$i-1]){echo "</li><li";if($menubar['id'][$i]==$parent_channel_id){echo " class='menu_li_selected'";}echo ">";}?>
		<? if($menubar['level_down'][$i]+1 == $menubar['level_down'][$i-1]){echo "</li></ul></li><li";if($menubar['id'][$i]==$parent_channel_id){echo " class='menu_li_selected'";}echo ">";}?>
		<? if($menubar['level_down'][$i]+2 == $menubar['level_down'][$i-1]){echo "</li></ul></li></ul></li><li";if($menubar['id'][$i]==$parent_channel_id){echo " class='menu_li_selected'";}echo ">";}?>
		<a href="<? echo $menubar['googleurl'][$i]; ?>"><? echo $menubar['description'][$i];?></a>
	<? } //Ende 1<?
	
	?>
</div>
<?	
if($menu_id!=$home_menu_id and $menu_id!=0 and count($parent_channel[id])>0)
{?>
	<div class="menubar_submenu">
		<?
		$rubriken=menu_select($parent_channel_id,'down','1','1','1','1');
		$subcount=0;
		do
		{?>
			<a href="<? echo $rubriken['googleurl'][$subcount]; ?>" class="submenu"><? echo $rubriken['description'][$subcount];?></a>
			<? if($rubriken['description'][$subcount+1]!=""){echo " | ";}
			$subcount=$subcount+1;
		} while($subcount<count($rubriken['id']));?>
	</div>		
<? }
?>
