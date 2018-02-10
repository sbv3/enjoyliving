<? session_start();
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
if(test_right($_SESSION['user'],"enter_page_content")!="true")
	{
		echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$href_root/site_12_1/admin/papa/menu.php?men_id=$home_menu_id\">";
		exit;
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>


<?
$adminpath=$_SERVER['DOCUMENT_ROOT'];
?>
<script type="text/javascript">

function kontrolle_checkboxen() {
	var check = 0;
	for (var zaehler = 0; zaehler < (document.getElementsByName("selected_menu_ids_out[]").length); zaehler++) {
	 if (document.getElementsByName("selected_menu_ids_out[]")[zaehler].checked) {
	  check++;
	 }
	}
	if (check > 0) {return true;}
	 else {
		 alert("Keine Checkbox aktiviert!");
		 return false;
	 }
	}
function add_menus(menu_ids_add,element_id,task,site_id_in) {
	var myString = new String(menu_ids_add);
	var myarray = myString.split('|'); 
	//menu_ids_add_arr = menu_ids_add.split("|")
	if(myarray.length > 0){
		for (i=0; i<myarray.length; i++){
			if(myarray[i]>0 && element_id>0){
				var url="Admin_table_result.php";
				url=url+"?task="+task+"&element_id="+element_id+"&menu_id="+myarray[i]+"&site_id_in="+site_id_in;
				display_data(url,'false');
			}
		}
	}
}
function remove_menus(menu_ids_remove,element_id,task,site_id_in) {
	var myString = new String(menu_ids_remove);
	var myarray = myString.split('|'); 
	//menu_ids_add_arr = menu_ids_add.split("|")
	if(myarray.length > 0){
		for (i=0; i<myarray.length; i++){
			if(myarray[i]>0 && element_id>0){
				var url="Admin_table_result.php";
				url=url+"?task="+task+"&element_id="+element_id+"&menu_id="+myarray[i]+"&site_id_in="+site_id_in;
				display_data(url,'false');
			}
		}
	}
}
</script>

<div id="table_result_error_messages"></div>

<?
function show_menu_result($target,$used_site_id,$site_id,$mode,$suche,$menu_pfad_ids,$task,$number_last_created)
{
	global $incl_subseiten;
	if($incl_subseiten==0){$subseitenstring=" and search_type !='Subseiten'";}
	
	if($target=="menu_pool"){
		$menu_master_string="menu.master_site_id=$used_site_id and ";
		$check_pool_string=", menu_pool where menu_pool.site_id=$site_id and menu_hierarchy.menu_id=menu_pool.menu_id and";
		}else{
		$menu_master_string="";
		$check_pool_string="where";
		}
	if($mode=="suche"){
		if($number_last_created==0){$order_string="order by menu_hierarchy.active_startdate desc, menu_hierarchy.sort";}
		elseif($number_last_created>0){$order_string="order by menu.createdate desc limit $number_last_created";}
				
		$show_menu=mysql_query("SELECT menu.id, menu.description, menu.pagetype, menu.search_type, DATE_FORMAT(menu.createdate,'%Y.%m.%d') as createdate, menu_hierarchy.active_startdate, menu_hierarchy.active_enddate, menu_hierarchy.active, menu_hierarchy.display FROM menu, menu_hierarchy $check_pool_string menu_hierarchy.site_id=$used_site_id and $menu_master_string menu.id=menu_hierarchy.menu_id and menu.description like '%$suche%' $subseitenstring and menu.id!=0 $order_string") or die ("suche menu: ".mysql_error());
	}else{
		$show_menu_id=end($menu_pfad_ids);
		$show_menu=mysql_query("SELECT menu.id, menu.description, menu.pagetype, menu.search_type, DATE_FORMAT(menu.createdate,'%Y.%m.%d') as createdate, menu_hierarchy.active_startdate, menu_hierarchy.active_enddate, menu_hierarchy.active, menu_hierarchy.display FROM menu, menu_hierarchy $check_pool_string menu_hierarchy.site_id=$used_site_id and $menu_master_string menu.id=menu_hierarchy.menu_id and menu_hierarchy.parent_id ='$show_menu_id' $subseitenstring  and menu.id!=0 order by menu_hierarchy.sort desc") or die ("show_menu: ".mysql_error());
	}
	$totalRows_show_menu = mysql_num_rows($show_menu);
	while(($show_menu_result[] = mysql_fetch_assoc($show_menu)) || array_pop($show_menu_result)); 
	return array($show_menu_result,$totalRows_show_menu);
}

?>

<?
//////////////////vorbereitende Queries
if($target=="menu_pool_init"){///einfach nur, damit die initiale Maagazinauswahl angezeigt wird. 
	$site_avail_q=mysql_query("select id,description,top_menu_id from sites where id!=$site_id and id in (select site_id from user_groups_x_site_pool where user_groups_x_site_pool.group_id in (select groups_id from user_users_x_groups where user_users_x_groups.users_ID in(select id from user_users where username = '$user')))") or die (mysql_error());
	?>
	<form method="post" target="_self" name="source_site_id">
		<select name="source_site_id" onChange="if(this.value == 'change'){} else {document.forms['source_site_id'].submit()}">
			<option value="change">Quellmagazin auswählen</option>
			<? while($site_avail_r=mysql_fetch_assoc($site_avail_q))
			{?>
				<option value="<? echo $site_avail_r[id]?>"><? echo $site_avail_r[description]?></option>	
			<? }?>
		</select>
		<input type="hidden" name="target" value="menu_pool_init2">
        <input type="hidden" name="element_id" value="<? echo $element_id;?>">
	</form>
	<?
}
else
{//Magazinauswahl wurde getroffen
	if($target=="menu_pool_init2" and !$selected_menu_ids_in and !$selected_menu_ids_in_imploded){///2te Phase des Setups
		$select_used_menus_q=mysql_query("select menu_id from menu_hierarchy where site_id=$site_id and parent_id=$element_id") or die (mysql_error());//lädt alle menu_ids rein, die auf der gewählten Seite im Magazin verwendet werden.
		$selected_menu_ids_prep=array("");
		if(mysql_num_rows($select_used_menus_q)>0){
			while($select_used_menus_r=mysql_fetch_assoc($select_used_menus_q))
			{$selected_menu_ids_prep[]=$select_used_menus_r[menu_id];}
			//print_r($selected_menu_ids_prep);
		}
		$selected_menu_ids_in_imploded=implode("|",$selected_menu_ids_prep);
		$target="menu_pool";
		$home_menu_id_source_q=mysql_query("select top_menu_id from sites where id=$source_site_id");
		$home_menu_id_source_r=mysql_fetch_assoc($home_menu_id_source_q);
		$menu_pfad_ids_imploded="|".$home_menu_id_source_r[top_menu_id];
	}
	if($target=="menu_pool"){$submit_label="Menupunkt mit der ID: ";if($used_site_id==""){$used_site_id=$source_site_id;}}else{$submit_label="Element mit der ID: ";if($used_site_id==""){$used_site_id=$site_id;}}
	
	$used_menu_ids_q=mysql_query("select menu_id from menu_hierarchy where site_id=$site_id");//lädt alle menu_ids rein, die überhaupt in dem Magazin existieren.
	while(($used_menu_ids[] = mysql_fetch_assoc($used_menu_ids_q)) || array_pop($used_menu_ids)); 

	$menu_pfad_ids=explode('|',$menu_pfad_ids_imploded);
	$menu_pfad_ids=array_values($menu_pfad_ids);
	

	$selected_menu_ids_in=explode ('|',$selected_menu_ids_in_imploded);
	if($selected_menu_ids_in[0]=="" && count($selected_menu_ids_in)>1)
	{
		unset($selected_menu_ids_in[0]);
		$selected_menu_ids_in=array_values($selected_menu_ids_in);
	}
	$selected_menu_ids_in_imploded=implode("|",$selected_menu_ids_in);
	
	
	$selected_menu_ids_stored=explode("|",$selected_menu_ids_stored_imploded);
	if($selected_menu_ids_stored[0]=="" && count($selected_menu_ids_in)>0)
	{
		$selected_menu_ids_stored=$selected_menu_ids_in;
	}
	$selected_menu_ids_stored_imploded=implode("|",$selected_menu_ids_stored);
	
	
	$task2=$task;
	
	if ($task != ""){
		
		if($task=="add_level"){
			$task="";
			array_push($menu_pfad_ids,$menu_pfad_add_id);
			$menu_pfad_ids=array_values($menu_pfad_ids);
			$menu_pfad_ids_imploded=implode('|',$menu_pfad_ids);
		}
		elseif($task=="menu_depth_adjust"){
			if($return=="<<")
			{
				$task="";
				$menu_pfad_ids=array_values($menu_pfad_ids);
				if($depth==count($menu_pfad_ids)-1){}else{
					for ($iii=count($menu_pfad_ids)-1;$depth-1 < $iii;--$iii){
						unset($menu_pfad_ids[$iii]);
					}}
			}
			else
			{
				$task="";
				$depth2=$depth;
				$menu_pfad_ids=array_values($menu_pfad_ids);
				if($depth==count($menu_pfad_ids)-1){}else{
					for ($iii=count($menu_pfad_ids)-1;$depth < $iii;--$iii){
						unset($menu_pfad_ids[$iii]);
					}}
				$menu_pfad_ids[$depth2]=$menu_pfad_remove;
				$menu_pfad_ids=array_values($menu_pfad_ids);
			}
			$menu_pfad_ids_imploded=implode('|',$menu_pfad_ids);
		}
		elseif($task=="goto"){
				$task="";
				$goto_pfad=menu_select($goto_id,"up",99,0,0,0,$site_id);//($start_id,$direction,$number_levels,$only_active,$menu_only,$exclude_subseiten,$site_id_in=null)
				$depth=count($goto_pfad[id])-1;
				$goto_pfad_ids=$goto_pfad[id];
				unset($goto_pfad_ids[0]);
				print_r($goto_pfad_ids);
				$goto_pfad_ids=array_values($goto_pfad_ids);
				array_push($goto_pfad_ids,"");
				$goto_pfad_ids=array_reverse($goto_pfad_ids);
				$menu_pfad_ids=$goto_pfad_ids;
				$menu_pfad_ids_imploded=implode('|',$menu_pfad_ids);
		}
		elseif($task=="add_to_pool"){
	//		echo "G";
			$task="";
			if($selected_menu_ids_out!=""){
	//			echo "H";
				if($selected_menu_ids_stored_imploded!=""){
	//				echo "I";
					$selected_menu_ids_stored=explode ('|',$selected_menu_ids_stored_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
					//$selected_menu_ids_stored=array_values($selected_menu_ids_stored);
				}else{$selected_menu_ids_stored=array();
	//			echo"J";
				}
				$selected_menu_ids_in=explode ('|',$selected_menu_ids_in_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
				$selected_menu_ids_in=array_values($selected_menu_ids_in);
	//			echo"<br>menu ids out: ";print_r($selected_menu_ids_out);
	//			echo"<br>menu ids stored: ";print_r($selected_menu_ids_stored);
				$selected_menu_ids_stored=array_merge($selected_menu_ids_stored, $selected_menu_ids_out);
				//$selected_menu_ids_stored=array_values($selected_menu_ids_stored);
	//			echo"<br>menu ids stored after array merge: ";print_r($selected_menu_ids_stored);
				$last_menu_pfad_id=end($menu_pfad_ids); 
			}
		}
		elseif($task=="remove_from_store"){
			if($selected_menu_ids_in!=""){
				$selected_menu_ids_in=explode ('|',$selected_menu_ids_in_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
				$selected_menu_ids_stored=explode ('|',$selected_menu_ids_stored_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
			}
			$selected_menu_ids_stored = array_diff($selected_menu_ids_stored,array($remove_id));
		}
			
		elseif($task=="submit_selection"){
			$task="";
			if($selected_menu_ids_in[0]==""){
			unset($selected_menu_ids_in[0]);
			$selected_menu_ids_in=array_values($selected_menu_ids_in);
			}
	
			if($selected_menu_ids_in!=""){
			$selected_menu_ids_in=explode ('|',$selected_menu_ids_in_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
			$selected_menu_ids_in=array_values($selected_menu_ids_in);
			}
			
			if($selected_menu_ids_stored_imploded!=""){
			$selected_menu_ids_stored=explode ('|',$selected_menu_ids_stored_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
			//$selected_menu_ids_stored=array_values($selected_menu_ids_stored);
			
				//echo "In Übergabe: ";print_r($selected_menu_ids_stored);
			
			
				$selected_menu_ids_overlap=array_intersect($selected_menu_ids_in,$selected_menu_ids_stored);
				
				$selected_menu_ids_remove=array_diff($selected_menu_ids_in,$selected_menu_ids_overlap);
				//echo "was entfernt werden muss: ".implode("|",$selected_menu_ids_remove); echo "<br>";echo "<br>";echo "<br>";
				$selected_menu_ids_remove_imploded=implode("|",$selected_menu_ids_remove);
				echo "<script>remove_menus('$selected_menu_ids_remove_imploded','$element_id','remove_$target','$site_id')</script>";///hier wird die Ziel-Site_ID verwendet, weil ja ein Eintrag gelöscht werden soll.
				
				$selected_menu_ids_add=array_diff($selected_menu_ids_stored,$selected_menu_ids_overlap);
				//echo "was hinzugefügt werden muss: ".implode("|",$selected_menu_ids_add); echo "<br>";echo "<br>";echo "<br>";
				$selected_menu_ids_add_imploded=implode("|",$selected_menu_ids_add);
				echo "<script>add_menus('$selected_menu_ids_add_imploded','$element_id','add_$target','$used_site_id')</script>";///hier wird die Artikel-Quell-Site_ID verwendet, weil ja ein Eintrag von dort kopiert werden soll.
				
				$selected_menu_ids_in=$selected_menu_ids_overlap+$selected_menu_ids_add;
				//echo "Das sind die ausgewählten Menus: "; print_r($selected_menu_ids_in);
		
				?>
				<script> 
				
				if (window.opener && !window.opener.closed) {
					window.opener.location.reload();
				}
				window.close();
				</script>
				<?
			}
		}
		elseif($task=="select_all"){
			$task="";
			if($selected_menu_ids_stored_imploded!=""){
				$selected_menu_ids_stored=explode ('|',$selected_menu_ids_stored_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
				//$selected_menu_ids_stored=array_values($selected_menu_ids_stored);
				}else{$selected_menu_ids_stored=array();
			}
			$selected_menu_ids_in=explode ('|',$selected_menu_ids_in_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
			$selected_menu_ids_in=array_values($selected_menu_ids_in);
	
			$all_menu_ids_stored=implode(',',$selected_menu_ids_stored);
			if($all_menu_ids_stored!=""){$where_clause="and id not in(".$all_menu_ids_stored.")";}
			
			if($menu_pfad_ids){$last_menu_pfad_id=end($menu_pfad_ids);}else{$menu_pfad_ids=array("");$last_menu_pfad_id=0;}
		
			list ($show_menu_result,$totalRows_show_menu)=show_menu_result($target,$used_site_id,$site_id,$mode,$suche,$menu_pfad_ids,$task,$number_last_created);
			
			for($ii=0;$ii<count($show_menu_result);++$ii)
			{
				$all_menus[].=$show_menu_result[$ii][id];
				
				$non_shareble_test_id=$show_menu_result[$ii][id];
				$non_shareable_q=mysql_query("select sum(block_sharing) as Anz from element, element_layout where menu_id in ('$non_shareble_test_id') and element.element_layout_id=element_layout.id");
				$non_shareable_r=mysql_fetch_assoc($non_shareable_q);
				if($non_shareable_r[Anz]>0){$non_shareable[]=$non_shareble_test_id;}
			}
			
			if($target=="menu_pool"){
				for($iii=0;$iii<count($used_menu_ids);++$iii){$used_menu_ids_imploded.=$used_menu_ids[$iii][menu_id].",";}
				$used_menu_ids_imploded=substr($used_menu_ids_imploded,0,-1);
				$all_menu_query=implode(",",$all_menus);
				if(count($non_shareable)>0){$non_shareable=implode(",",$non_shareable);$non_shareable_querystring="and menu.id not in ($non_shareable)";}
				if($all_menu_ids_stored!=""){$all_menu_ids_stored_querystring="and menu.id not in($all_menu_ids_stored)";}
				unset ($all_menus);
				
				$all_menu_query=mysql_query("select id from (SELECT menu.id, sum(element_layout.block_sharing) as Anz
				FROM menu, element, element_layout
				WHERE 
				menu.id=element.menu_id AND 
				element.element_layout_id=element_layout.id AND 
				menu.id IN ($all_menu_query) and 
				menu.id not in ($used_menu_ids_imploded) $non_shareable_querystring
				group by menu.id) as data where Anz=0
				ORDER BY FIND_IN_SET(data.id,'$all_menu_query')") or die (mysql_error());
				while($all_menus_r=mysql_fetch_assoc($all_menu_query)){$all_menus[]=$all_menus_r[id];}
			}
			print_r($all_menus);
			
			$selected_menu_ids_stored=array_merge($selected_menu_ids_stored,$all_menus);
		}
	}

	?>
	<div style="padding:4px;border-style:solid;border-width:1px;border-color:#CCC;background-color:#F0F3FA">
	<div style="float:left; padding-top:5px; font-weight:bold">Navigation in der Menühierarchie</div>
	<div style="float:right">
		<form method="post" name="suche2" target="_self" style="margin-bottom:-4px;">
			<select name="incl_subseiten" title="Subseiten auch anzeigen?"onChange="document.forms['suche2'].submit()">
				<option <? if($incl_subseiten==1){echo "selected";}?> value="1">Subseiten anzeigen</option>
				<option <? if($incl_subseiten==0){echo "selected";}?> value="0">Subseiten ausblenden</option>
			</select>
			<input type="hidden" name="task" value="<? echo $task;?>">
			<input type="hidden" name="mode" value="<? echo $mode; ?>">
			<input type="hidden" name="suche" value="<? echo $suche;?>">		
			<input type="hidden" name="selected_menu_ids_in_imploded" value="<? if($selected_menu_ids_in){echo implode('|',$selected_menu_ids_in);}?>">
			<input type="hidden" name="selected_menu_ids_stored_imploded" value="<? if($selected_menu_ids_stored){echo implode('|',$selected_menu_ids_stored);}?>">
			<input type="hidden" name="menu_pfad_ids_imploded" value="<? echo $menu_pfad_ids_imploded;?>">
			<input type="hidden" name="element_id" value="<? echo $element_id;?>">
			<input type="hidden" name="target" value="<? echo $target;?>">
			<input type="hidden" name="used_site_id" value="<? echo $used_site_id;?>">
			<input type="hidden" name="number_last_created" value="<? echo $number_last_created;?>">
		</form>
	</div>
	<div style="float:right">
		<form method="post" name="suche" target="_self" style="margin-bottom:-4px">
			<input type="text" name="suche" value="<? echo $suche;?>">
			<input name="Submit" type="submit" value="suche">
			<input type="hidden" name="task" value="suche1">
			<input type="hidden" name="mode" value="suche">
			<input type="hidden" name="selected_menu_ids_in_imploded" value="<? if($selected_menu_ids_in){echo implode('|',$selected_menu_ids_in);}?>">
			<input type="hidden" name="selected_menu_ids_stored_imploded" value="<? if($selected_menu_ids_stored){echo implode('|',$selected_menu_ids_stored);}?>">
			<input type="hidden" name="menu_pfad_ids_imploded" value="<? echo $menu_pfad_ids_imploded;?>">
			<input type="hidden" name="element_id" value="<? echo $element_id;?>">
			<input type="hidden" name="target" value="<? echo $target;?>">
			<input type="hidden" name="used_site_id" value="<? echo $used_site_id;?>">
			<input type="hidden" name="incl_subseiten" value="<? echo $incl_subseiten;?>">
		</form>
	</div>
	<div style="float:right">
		<form method="post" name="suche3" target="_self" style="margin-bottom:-4px;">
			<select name="number_last_created" title="Suchergebnis auf die jüngsten 10/20/30 Artikel einschränken"onChange="if(this.value == 'edit'){} else {document.forms['suche3'].submit()}">
				<option value='edit'>Die letzten n Artikeln</option>
				<option <? if($number_last_created==10){echo "selected";}?> value="10">Die letzten 10 Artikeln</option>
				<option <? if($number_last_created==20){echo "selected";}?> value="20">Die letzten 20 Artikeln</option>
				<option <? if($number_last_created==30){echo "selected";}?> value="30">Die letzten 30 Artikeln</option>
			</select>
			<input type="hidden" name="task" value="suche3">
			<input type="hidden" name="mode" value="suche">
			<input type="hidden" name="selected_menu_ids_in_imploded" value="<? if($selected_menu_ids_in){echo implode('|',$selected_menu_ids_in);}?>">
			<input type="hidden" name="selected_menu_ids_stored_imploded" value="<? if($selected_menu_ids_stored){echo implode('|',$selected_menu_ids_stored);}?>">
			<input type="hidden" name="menu_pfad_ids_imploded" value="<? echo $menu_pfad_ids_imploded;?>">
			<input type="hidden" name="element_id" value="<? echo $element_id;?>">
			<input type="hidden" name="target" value="<? echo $target;?>">
			<input type="hidden" name="used_site_id" value="<? echo $used_site_id;?>">
			<input type="hidden" name="incl_subseiten" value="<? echo $incl_subseiten;?>">
		</form>
	</div>

	<? if($mode!="suche"){
		?><div style="float:right; margin-right:10px;">
			<form method="post" name="select_all" target="_self" style="margin-bottom:-4px">
				<input name="Submit" type="submit" value="select all">
				<input type="hidden" name="task" value="select_all">
				<input type="hidden" name="selected_menu_ids_in_imploded" value="<? if($selected_menu_ids_in){echo implode('|',$selected_menu_ids_in);}?>">
				<input type="hidden" name="selected_menu_ids_stored_imploded" value="<? if($selected_menu_ids_stored){echo implode('|',$selected_menu_ids_stored);}?>">
			<input type="hidden" name="menu_pfad_ids_imploded" value="<? echo $menu_pfad_ids_imploded;?>">
				<input type="hidden" name="element_id" value="<? echo $element_id;?>">
				<input type="hidden" name="mode" value="<? echo $mode;?>">
				<input type="hidden" name="suche" value="<? echo $suche;?>">		
				<input type="hidden" name="target" value="<? echo $target;?>">
				<input type="hidden" name="used_site_id" value="<? echo $used_site_id;?>">
			<input type="hidden" name="incl_subseiten" value="<? echo $incl_subseiten;?>">
			</form>
		</div>
	<? }?>
	<div style="clear:both"></div>
	<div class="trenner"></div>
	<table>
	<tr>
	<?
		
	if(count($selected_menu_ids_in)==0 or $selected_menu_ids_in=="|" or $selected_menu_ids_in=="")
	{
	//	echo "M"; 
		$selected_menu_ids_in=array();
	}
	if(count($selected_menu_ids_stored)==0 or $selected_menu_ids_stored=="|" or $selected_menu_ids_stored==""){
	//	echo "N"; 
		if(count($selected_menu_ids_in)==0 or $selected_menu_ids_in=="|" or $selected_menu_ids_in=="")
			{
	//			echo "O"; 
				$selected_menu_ids_stored=array();
			}
		else
			{
	//			echo "P"; 
				if($task2!="remove_from_store"){$selected_menu_ids_stored=$selected_menu_ids_in;}
			}
		}
	
	//		echo "<br>Element ID: ".$element_id;
	//		echo "<br>selected_menu_ids_in_imploded: ".implode('|',$selected_menu_ids_in);
	//		echo "<br>selected_menu_ids_stored_imploded: ".implode('|',$selected_menu_ids_stored);
	//		echo "<br>menu_pfad_ids_imploded: ".implode('|',$menu_pfad_ids);
	//		echo "<br>task: ".$task2;
	
	if(!$menu_pfad_ids){$menu_pfad_ids=array(0);}	
	$last_menu_pfad_id=end($menu_pfad_ids);

	if($incl_subseiten==0){$subseitenstring=" and search_type !='Subseiten'";}	
	if($target=="menu_pool"){$avail_menu_query=mysql_query("SELECT menu.id, menu.createdate, menu.description FROM menu, menu_hierarchy WHERE menu_hierarchy.site_id=$used_site_id AND menu_hierarchy.parent_id='$last_menu_pfad_id' AND menu_hierarchy.menu_id=menu.id $subseitenstring and menu.id!=0 group by menu.id ORDER BY menu_hierarchy.sort desc") or die (mysql_error());}


	else{$avail_menu_query=mysql_query("SELECT menu.id, menu.createdate, menu.description FROM menu, menu_hierarchy where site_id=$used_site_id and menu_hierarchy.parent_id='$last_menu_pfad_id' and menu.id=menu_hierarchy.menu_id $subseitenstring and menu.id!=0 order by menu_hierarchy.sort desc") or die (mysql_error());}
	$totalRows_avail_menu_query = mysql_num_rows($avail_menu_query);
	
	
	
	//	echo "<br> Menus, die jetzt abgearbeitet werden: "; echo implode('|',$menu_pfad_ids);
	//	echo "<br> Anzahl der Menus: "; echo count($menu_pfad_ids);
	//	echo "<br> wo stehen wir: "; echo $i;
	//	echo "<br> welche ist die nächste id: "; echo $menu_pfad_ids[$i];
	$i=1;
	do{
		if($menu_pfad_ids[$i]!=""){?>
			<td width='200px'>
				<?
	//			echo "<br>welche pfad_id ist hier drinnen: "; echo $menu_pfad_ids[$i];
				$target_id=$menu_pfad_ids[$i];
				
				$menu_pfad_lastavail_parent=find_parent($target_id,$used_site_id);
				$menu_pfad_lastavail_result=menu_select($menu_pfad_lastavail_parent,"down",1,0,0,0,$used_site_id);
				?>
				<form method="post" name="menu_pfad_level_<? echo $i;?>">
					<select style="width:200px" name="menu_pfad_remove" onChange="if(this.value == 'change'){} else {document.forms['menu_pfad_level_<? echo $i;?>'].submit()}">
						<? if($menu_pfad_lastavail_parent==0)
						{?> <option value="<? echo $home_menu_id; ?>">home</option> <? }
						else
						{?>
							<option value="change">change selection</option>
							<? 
							for ($ii=0; $ii < count($menu_pfad_lastavail_result[id]);$ii++)
							{
								$menu_pfad_lastavail_result_id=$menu_pfad_lastavail_result[id][$ii];
								$menu_pfad_lastavail_result_desc=$menu_pfad_lastavail_result[description][$ii];
								//if($target=="menu_pool"){$menu_pfad_lastavail_result_enable_q=mysql_query("select id from menu_pool where site_id=$site_id and menu_id=$menu_pfad_lastavail_result_id");}
								if($target_id==$menu_pfad_lastavail_result_id)
								{
									echo "<option selected='selected' value=\"$menu_pfad_lastavail_result_id\"";
									//if($target=="menu_pool" and mysql_num_rows($menu_pfad_lastavail_result_enable_q)==0){echo "disabled";}
									echo ">$menu_pfad_lastavail_result_desc</option>";
								}else
								{
									echo "<option value=\"$menu_pfad_lastavail_result_id\"";
									if($target=="menu_pool")
									{
										$enable_disable_prep=menu_select($menu_pfad_lastavail_result_id,"down",99,0,0,0,$used_site_id);
										if(count($enable_disable_prep[id])>0)
										{
											$enable_disable_prep2=implode(",",$enable_disable_prep[id]);
											$enable_disable_q=mysql_query("select count(1) as Anz from menu_pool where menu_id in ($enable_disable_prep2) and site_id=$site_id");
											$enable_disable_r=mysql_fetch_assoc($enable_disable_q);
											if($enable_disable_r[Anz]==0){echo "disabled";}
										}
										else{echo "disabled";}
										unset($enable_disable_prep);
									}
									echo ">$menu_pfad_lastavail_result_desc</option>";
								}
							}
						}
?>
					</select>
					<input type="hidden" name="selected_menu_ids_in_imploded" value="<? echo implode('|',$selected_menu_ids_in)?>">
					<input type="hidden" name="selected_menu_ids_stored_imploded" value="<? echo implode('|',$selected_menu_ids_stored)?>">
					<input type="hidden" name="menu_pfad_ids_imploded" value="<? echo $menu_pfad_ids_imploded;?>">
					<input type="hidden" name="element_id" value="<? echo $element_id;?>">
					<input type="hidden" name="depth" value="<? echo $i;?>">
					<input type="hidden" name="mode" value="">
					<input type="hidden" name="suche" value="<? echo $suche;?>">
					<input type="hidden" name="task" value="menu_depth_adjust">
					<input type="hidden" name="target" value="<? echo $target;?>">
					<input type="hidden" name="used_site_id" value="<? echo $used_site_id;?>">
					<input type="hidden" name="incl_subseiten" value="<? echo $incl_subseiten;?>">
				</form>
				<form method="post" name="menu_pfad_reduce_<? echo $i;?>">
					<input type="hidden" name="selected_menu_ids_in_imploded" value="<? echo implode('|',$selected_menu_ids_in)?>">
					<input type="hidden" name="selected_menu_ids_stored_imploded" value="<? echo implode('|',$selected_menu_ids_stored)?>">
					<input type="hidden" name="menu_pfad_ids_imploded" value="<? echo $menu_pfad_ids_imploded;?>">
					<input type="hidden" name="element_id" value="<? echo $element_id;?>">
					<input type="hidden" name="depth" value="<? echo $i;?>">
					<input type="hidden" name="mode" value="">
					<input type="hidden" name="suche" value="<? echo $suche;?>">
					<input type="hidden" name="task" value="menu_depth_adjust">
					<input type="hidden" name="target" value="<? echo $target;?>">
					<input type="hidden" name="used_site_id" value="<? echo $used_site_id;?>">
					<input type="hidden" name="return" value="<<">
					<input type="button" value="<<" onClick="document.forms['menu_pfad_reduce_<? echo $i;?>'].submit()">
					<input type="hidden" name="incl_subseiten" value="<? echo $incl_subseiten;?>">
				</form>
			</td>
			<?
		}
		$i=$i+1;
	} while ($menu_pfad_ids[$i]!="");
	//echo "<br>hier kommen die neuen Anhänge dran";
	
	if($totalRows_avail_menu_query > 0){?>
		<td width="200px">
		<form method="post" name="newlevel_<? echo $i;?>">
				<select style="width:200px" name="menu_pfad_add_id" onChange="if(this.value == 'change'){} else {document.forms['newlevel_<? echo $i;?>'].submit()}">
				<option value="change">select</option>
				<? mysql_data_seek($avail_menu_query,0);
				while($row = mysql_fetch_assoc($avail_menu_query)){
					if($row[id]!=0)
					{?>
						<option value="<? echo $row[id];?>" 
							<? if($target=="menu_pool")
							{
								$enable_disable_prep=menu_select($row[id],"down",99,0,0,0,$used_site_id);
								if(count($enable_disable_prep[id])>0)
								{
									$enable_disable_prep=implode(",",$enable_disable_prep[id]);
									$enable_disable_q=mysql_query("select count(1) as Anz from menu_pool where menu_id in ($enable_disable_prep) and site_id=$site_id");
									if(mysql_num_rows($enable_disable_q)>0){
										$enable_disable_r=mysql_fetch_assoc($enable_disable_q);
										if($enable_disable_r[Anz]==0){echo "disabled";}
									}
								}
								else{echo "disabled";}
							}?>
							>
							<? echo $row[description];?>
						</option>
			<?		}}?>
			</select> 
			<input type="hidden" name="element_id" value="<? echo $element_id;?>">
			<input type="hidden" name="selected_menu_ids_in_imploded" value="<? echo implode('|',$selected_menu_ids_in)?>">
			<input type="hidden" name="selected_menu_ids_stored_imploded" value="<? echo implode('|',$selected_menu_ids_stored)?>">
			<input type="hidden" name="menu_pfad_ids_imploded" value="<? echo $menu_pfad_ids_imploded;?>">
			<input type="hidden" name="task" value="add_level">
			<input type="hidden" name="mode" value="">
			<input type="hidden" name="target" value="<? echo $target;?>">
			<input type="hidden" name="used_site_id" value="<? echo $used_site_id;?>">
			<input type="hidden" name="suche" value="<? echo $suche;?>">
			<input type="hidden" name="incl_subseiten" value="<? echo $incl_subseiten;?>">
	</form>
		<div style="height:23px"></div>
		</td>
	<? }
	//////////Hier geht das obere Auswahlformular los.
	?>
	
	</tr>
	</table>
	</div>
	<div style="height:30px"></div>
	
	<? 
	list ($show_menu_result,$totalRows_show_menu)=show_menu_result($target,$used_site_id,$site_id,$mode,$suche,$menu_pfad_ids,$task,$number_last_created);
	

	if(count($selected_menu_ids_stored)>0){
		if(($selected_menu_ids_stored_imploded!="") or (count($selected_menu_ids_stored)>0 and $selected_menu_ids_stored[0]!="")){
	//		print_r($selected_menu_ids_stored);
			$show_selected_menu_ids_stored_imploded=implode(',',$selected_menu_ids_stored);	
			
			if($target=="menu_pool"){$show_stored_details=mysql_query("SELECT menu.id, menu.description, menu.pagetype, menu.search_type, menu_hierarchy.active_startdate, menu_hierarchy.active_enddate, menu_hierarchy.active, menu_hierarchy.display FROM menu, menu_hierarchy where master_site_id!=$site_id and site_id=$used_site_id and menu.id=menu_hierarchy.menu_id and menu_hierarchy.menu_id in ($show_selected_menu_ids_stored_imploded) order by find_in_set(menu.id,'$show_selected_menu_ids_stored_imploded')") or die ("show_stored_details: ".mysql_error());}
			else{
				$show_stored_details=mysql_query("SELECT menu.id, menu.description, menu.pagetype, menu.search_type, menu_hierarchy.active_startdate, menu_hierarchy.active_enddate, menu_hierarchy.active, menu_hierarchy.display FROM menu, menu_hierarchy where site_id=$used_site_id and menu.id=menu_hierarchy.menu_id and menu_hierarchy.menu_id in ($show_selected_menu_ids_stored_imploded) order by find_in_set(menu.id,'$show_selected_menu_ids_stored_imploded')") or die ("show_stored_details: ".mysql_error());}

			$totalRows_show_stored_details = mysql_num_rows($show_stored_details);
			while(($show_stored_details_result[] = mysql_fetch_assoc($show_stored_details)) || array_pop($show_stored_details_result));
		}
	}
	
	//print_r($show_stored_details_result);
	if($totalRows_show_menu>0 and $show_menu_result[0][id]!="1"){
		
		?>
		<div style="padding:4px;border-style:solid;border-width:1px;border-color:#CCC;background-color:#F0F3FA">
			<strong>Menüauswahl</strong>
			<div class="trenner"></div>
			<form name="form_show_menu_result" method="post" >
				<table class="tablesorter-ice" id="menutable">
					<thead>
						<th style="text-align:center;">Select</th>
						<th style="text-align:right">ID</th>
						<th style="text-align:left">Description</th>
						<th style="text-align:left">Pagetype</th>
						<th style="text-align:left">Searchtype</th>
						<th style="text-align:left">Create</th>
						<th style="text-align:left">Start</th>
						<th style="text-align:left">End</th>
						<th style="text-align:center">Active</th>
						<th style="text-align:center">Menü?</th>
					</thead>
					<tbody>
						<? 
						for ($i=0;$i <$totalRows_show_menu;++$i){
							for($ii=0;$ii<count($show_stored_details_result)+1;++$ii)
							{
								if($show_menu_result[$i][id]==$show_stored_details_result[$ii][id]){$hide[$i]="pos";}
							}
							if($target=="menu_pool"){
								for($iii=0;$iii<count($used_menu_ids)+1;++$iii){if($show_menu_result[$i][id]==$used_menu_ids[$iii][menu_id] and $hide[$i]!="pos"){$hide[$i]="pos2";}}
								
								$non_shareble_test_id=$show_menu_result[$i][id];
								$non_shareable_q=mysql_query("select sum(block_sharing) as Anz from element, element_layout where menu_id in ('$non_shareble_test_id') and element.element_layout_id=element_layout.id");
								$non_shareable_r=mysql_fetch_assoc($non_shareable_q);
								if($non_shareable_r[Anz]>0 and $hide[$i]!="pos" and $hide[$i]!="pos2"){$hide[$i]="pos3";}
							}
							
							///ENDE der for-Schleife wo alle gewählten durchgecheckt werden
							if($hide[$i]=="pos" or $hide[$i]=="pos2" or $hide[$i]=="pos3"){$color="#999999";}else{$color="#000000";}
							?>
							<tr style="color:<? echo $color;?>">
								<td style="width:70px; text-align:center;"> <input type="checkbox" 
									<? if($hide[$i]=="pos"){echo "disabled checked title='Diese Seite ist bereits ausgewählt.'";} 
									if($hide[$i]=="pos2"){echo "disabled checked title='Diese Seite wird an anderer Stelle des Magazins bereits verwendet.'";}
									if($hide[$i]=="pos3"){echo "disabled checked title='Diese Seite verwendet ein un-shareable Element.'";} ?>
									name="selected_menu_ids_out[]" value="<? echo $show_menu_result[$i][id];?>" onClick="document.forms['form_show_menu_result'].submit()"/> 
								</td>
								<td style="width:60px; text-align:right;">
									<? 
									if($show_menu_result[$i][active]=="A" and (($show_menu_result[$i][active_startdate]<$date or $show_menu_result[$i][active_startdate]=="0000-00-00") and ($show_menu_result[$i][active_enddate]>$date or $show_menu_result[$i][active_enddate]=="0000-00-00"))){} 
									else {?> <img title="ACHTUNG: Dieser Eintrag ist nicht aktiv, oder nicht im freigeschaltenen Datumsbereich." style="float:left; padding-right:4px; margin-bottom:-4px;"src="/site_12_1/css/Attention_small.png" height="16px"/><? }
									echo $show_menu_result[$i][id];?>
								</td>
								<td style="width:400px"> <? echo $show_menu_result[$i][description];?> </td>
								<td style="width:100px"> <? echo $show_menu_result[$i][pagetype];?> </td>
								<td style="width:100px"> <? echo $show_menu_result[$i][search_type];?> </td>
								<td style="width:100px"> <? echo $show_menu_result[$i][createdate];?> </td>
								<td style="width:100px"> <? echo $show_menu_result[$i][active_startdate];?> </td>
								<td style="width:100px"> <? echo $show_menu_result[$i][active_enddate];?> </td>
								<td style="width:50px; text-align:center;"> <? echo $show_menu_result[$i][active];?> </td>
								<td style="width:50px; text-align:center;"> <? echo $show_menu_result[$i][display];?> </td>
							</tr>
							<?
						}///ENDE der ID Schleife ?>
					</tbody>
				</table>
				<input type="hidden" name="element_id" value="<? echo $element_id;?>">
				<input type="hidden" name="selected_menu_ids_in_imploded" value="<? echo implode('|',$selected_menu_ids_in)?>">
				<input type="hidden" name="selected_menu_ids_stored_imploded" value="<? echo implode('|',$selected_menu_ids_stored)?>">
			<input type="hidden" name="menu_pfad_ids_imploded" value="<? echo $menu_pfad_ids_imploded;?>">
				<input type="hidden" name="task" value="add_to_pool">
				<input type="hidden" name="mode" value="<? echo $mode;?>">
				<input type="hidden" name="target" value="<? echo $target;?>">
				<input type="hidden" name="used_site_id" value="<? echo $used_site_id;?>">
				<input type="hidden" name="suche" value="<? echo $suche;?>">
				<input type="hidden" name="incl_subseiten" value="<? echo $incl_subseiten;?>">
				<input type="hidden" name="number_last_created" value="<? echo $number_last_created;?>">
			</form>
			
			<link rel="stylesheet" type="text/css" href="/Connections/tablesorter/css/theme.ice.css"/>
			<script>
			$(document).ready(function() 
				{ 
					$("#menutable").tablesorter({
						headers: 
						{
							0:{filter: false}
							,1:{}
							,2:{}
							,3:{}
							,4:{}
							,5:{sorter: "shortDate",dateFormat: "yyyymmdd",filter: false}
							,6:{sorter: "shortDate",dateFormat: "yyyymmdd",filter: false}
							,7:{sorter: "shortDate",dateFormat: "yyyymmdd",filter: false}
							,8:{}
							,9:{}
						}
						,textExtraction: 
						{
							0:function(node0) {return node0.children[0].checked;}
						}
						,widthFixed : true
						,widgets: ["filter"]
						,widgetOptions : {
						  // if true, a filter will be added to the top of each table column; 
						  // disabled by using -> headers: { 1: { filter: false } } OR add class="filter-false" 
						  // if you set this to false, make sure you perform a search using the second method below 
						  filter_columnFilters : true, 
					 
						  // css class applied to the table row containing the filters & the inputs within that row 
						  filter_cssFilter : 'tablesorter-filter', 
					 
						  // add custom filter functions using this option 
						  // see the filter widget custom demo for more specifics on how to use this option 
						  filter_functions : null, 
					 
						  // if true, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately 
						  // below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus 
						  filter_hideFilters : false, 
					 
						  // Set this option to false to make the searches case sensitive 
						  filter_ignoreCase : false, 
					 
						  // jQuery selector string of an element used to reset the filters 
						  filter_reset : 'button.reset', 
					 
						  // Delay in milliseconds before the filter widget starts searching; This option prevents searching for 
						  // every character while typing and should make searching large tables faster. 
						  filter_searchDelay : 300, 
					 
						  // Set this option to true to use the filter to find text from the start of the column 
						  // So typing in "a" will find "albert" but not "frank", both have a's; default is false 
						  filter_startsWith : true, 
					 
						  // Filter using parsed content for ALL columns 
						  // be careful on using this on date columns as the date is parsed and stored as time in seconds 
						  filter_useParsedData : false 
					 
						} 
					,sortReset   : true 
					,sortRestart : true
					,emptyTo: 'zero' 
					,debug:false
					//,textExtraction: myTextExtraction
					})
				} 
			); 
			</script>
			
			
		</div>
			
		<? 
	}
		//////////Hier geht das untere Auswahlformular los. 
	if($totalRows_show_stored_details>0){?>
		<div style="height:30px"></div>
		<div style="padding:4px;border-style:solid;border-width:1px;border-color:#CCC;background-color:#F0F3FA">
			<strong>Ausgewählte Menüpunkte</strong>
			<div class="trenner"></div>
			<table>
				<th style="text-align:center;">Remove</td>
				<th style="text-align:center;">GoTo</td>
				<th style="text-align:right">ID</td>
				<th style="text-align:left">Description</td>
				<th style="text-align:left">Pagetype</td>
				<th style="text-align:left">Searchtype</td>
				<th style="text-align:left">Start</td>
				<th style="text-align:left">End</td>
				<th style="text-align:center">Active</td>
				<th style="text-align:center">Menü?</td>
			<? 
			for ($i=0;$i < $totalRows_show_stored_details;++$i){?>
				<tr>
					<td style="width:70px; text-align:center;">
						<form method="post" name="form_selected_menu_ids_stored">
							<input type="submit" value="del" name="remove_from_store"/>
							<input type="hidden" name="remove_id" value="<? echo $show_stored_details_result[$i][id];?>" />
							<input type="hidden" name="element_id" value="<? echo $element_id;?>">
							<input type="hidden" name="selected_menu_ids_in_imploded" value="<? echo implode('|',$selected_menu_ids_in)?>">
							<input type="hidden" name="selected_menu_ids_stored_imploded" value="<? echo implode('|',$selected_menu_ids_stored)?>">
							<input type="hidden" name="menu_pfad_ids_imploded" value="<? echo $menu_pfad_ids_imploded;?>">
							<input type="hidden" name="task" value="remove_from_store">
							<input type="hidden" name="mode" value="<? echo $mode;?>">
							<input type="hidden" name="target" value="<? echo $target;?>">
							<input type="hidden" name="used_site_id" value="<? echo $used_site_id;?>">
							<input type="hidden" name="suche" value="<? echo $suche;?>">
							<input type="hidden" name="incl_subseiten" value="<? echo $incl_subseiten;?>">
							<input type="hidden" name="number_last_created" value="<? echo $number_last_created;?>">
						</form>
					</td>
					<td style="width:70px; text-align:center;">
						<form method="post" name="goto_clicked">
							<input type="submit" value="goto" name="goto"/>
							<input type="hidden" name="goto_id" value="<? echo $show_stored_details_result[$i][id];?>" />
							<input type="hidden" name="element_id" value="<? echo $element_id;?>">
							<input type="hidden" name="selected_menu_ids_in_imploded" value="<? echo implode('|',$selected_menu_ids_in)?>">
							<input type="hidden" name="selected_menu_ids_stored_imploded" value="<? echo implode('|',$selected_menu_ids_stored)?>">
							<input type="hidden" name="menu_pfad_ids_imploded" value="<? echo $menu_pfad_ids_imploded;?>">
							<input type="hidden" name="task" value="goto">
							<input type="hidden" name="mode" value="">
							<input type="hidden" name="target" value="<? echo $target;?>">
							<input type="hidden" name="used_site_id" value="<? echo $used_site_id;?>">
							<input type="hidden" name="suche" value="<? echo $suche;?>">
							<input type="hidden" name="incl_subseiten" value="<? echo $incl_subseiten;?>">
							<input type="hidden" name="number_last_created" value="<? echo $number_last_created;?>">
						</form>
					</td>
					<td style="width:60px; text-align:right;"> 
						<? 
						if($show_stored_details_result[$i][active]=="A" and (($show_stored_details_result[$i][active_startdate]<$date or $show_stored_details_result[$i][active_startdate]=="0000-00-00") and ($show_stored_details_result[$i][active_enddate]>$date or $show_stored_details_result[$i][active_enddate]=="0000-00-00"))){} 
						else {?> <img title="ACHTUNG: Dieser Eintrag ist nicht aktiv, oder nicht im freigeschaltenen Datumsbereich." style="float:left; padding-right:4px; margin-bottom:-4px;"src="/site_12_1/css/Attention_small.png" height="16px"/><? }
						echo $show_stored_details_result[$i][id];?></td>
					<td style="width:400px"> <? echo $show_stored_details_result[$i][description];?> </td>
					<td style="width:100px"> <? echo $show_stored_details_result[$i][pagetype];?> </td>
					<td style="width:100px"> <? echo $show_stored_details_result[$i][search_type];?> </td>
					<td style="width:100px"> <? echo $show_stored_details_result[$i][active_startdate];?> </td>
					<td style="width:100px"> <? echo $show_stored_details_result[$i][active_enddate];?> </td>
					<td style="width:50px; text-align:center;"> <? echo $show_stored_details_result[$i][active];?> </td>
					<td style="width:50px; text-align:center;"> <? echo $show_stored_details_result[$i][display];?> </td>
				</tr>
			<? } ?>
			</table>
			<div class="trenner"></div>
			<? }?>
			<? //"Ausgewählt: ".print_r($selected_menu_ids_stored)?>
			<form name="form_submitted_menu_ids" method="post" >
				<input type="hidden" name="element_id" value="<? echo $element_id;?>">
				<input type="hidden" name="selected_menu_ids_in_imploded" value="<? echo implode('|',$selected_menu_ids_in)?>">
				<input type="hidden" name="selected_menu_ids_stored_imploded" value="<? echo implode('|',$selected_menu_ids_stored)?>">
				<input type="hidden" name="menu_pfad_ids_imploded" value="<? echo $menu_pfad_ids_imploded;?>">
				<input type="hidden" name="task" value="submit_selection">
				<input type="hidden" name="mode" value="<? echo $mode;?>">
				<input type="hidden" name="suche" value="<? echo $suche;?>">
				<input type="hidden" name="target" value="<? echo $target;?>">
				<input type="hidden" name="used_site_id" value="<? echo $used_site_id;?>">
				<input type="button" name="OK" value="<? echo $submit_label.$element_id;?> aktualisieren"  onclick="document.forms['form_submitted_menu_ids'].submit();"/>
				<input type="hidden" name="incl_subseiten" value="<? echo $incl_subseiten;?>">
				<input type="hidden" name="number_last_created" value="<? echo $number_last_created;?>">
			</form>
		</div>
	<? 
}?>
</html>