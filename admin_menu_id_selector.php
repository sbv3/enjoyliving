<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<link href="/site_11_1/css/style.css" rel="stylesheet" type="text/css" />


<?
$adminpath="/enjftfxb/www.enjoyliving.at";
require_once('/enjftfxb/www.enjoyliving.at/Connections/usrdb_enjftfxb2.php');
?>
<script type="text/javascript">
function teste_ceckboxen(elm) {
  var checkboxes = 0;
  var multi_selected_menu_ids_out = document.form_show_menu_result.elements["selected_menu_ids_out[]"];
alert(multi_selected_menu_ids_out.length);
  for (i=0; i<multi_selected_menu_ids_out.length; i++){
    if (multi_selected_menu_ids_out[i].checked==true) {
	  checkboxes++;
	  break;
	}
  }
  if (!checkboxes) {
	alert("Keine Checkbox aktiviert!");
	return false;
  }
  return true;
}

function add_menus(menu_ids_add,element_id) {
	var myString = new String(menu_ids_add);
	var myarray = myString.split('|'); 
	//menu_ids_add_arr = menu_ids_add.split("|")
	if(myarray.length > 0){
		for (i=0; i<myarray.length; i++){
			if(myarray[i]>0 && element_id>0){
				var url="Admin_table_result.php";
				url=url+"?task=add_element_content_menu&element_id="+element_id+"&menu_id="+myarray[i];
				display_data(url);
			}
		}
	}
}

function remove_menus(menu_ids_remove,element_id) {
	var myString = new String(menu_ids_remove);
	var myarray = myString.split('|'); 
	//menu_ids_add_arr = menu_ids_add.split("|")
	if(myarray.length > 0){
		for (i=0; i<myarray.length; i++){
			if(myarray[i]>0 && element_id>0){
				var url="Admin_table_result.php";
				url=url+"?task=remove_element_content_menu&element_id="+element_id+"&menu_id="+myarray[i];
				display_data(url);
			}
		}
	}
}


</script>


<div id="table_result_error_messages"></div>

<?
//////////////////vorbereitende Queries
$menu_hierarchy=mysql_query("SELECT * FROM menu_hierarchy order by level") or die (mysql_error());
$totalRows_menu_hierarchy= mysql_num_rows($menu_hierarchy);

if($menu_pfad_ids[0]!=""){
	$menu_pfad_ids=explode ('|',$menu_pfad_ids);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
	$menu_pfad_ids=array_values($menu_pfad_ids);
	$avail_menu_query=mysql_query("SELECT * FROM menu where hierarchy_level='$last_level' order by sort") or die (mysql_error());
	$totalRows_avail_menu_query = mysql_num_rows($avail_menu_query);
	if(count($selected_menu_ids_in)>0){
		$selected_menu_ids_in=explode ('|',$selected_menu_ids_in);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
		$selected_menu_ids_in=array_values($selected_menu_ids_in);
		if($selected_menu_ids_in[0]==""){
		unset($selected_menu_ids_in[0]);
		$selected_menu_ids_in=array_values($selected_menu_ids_in);
		}

	}
}

elseif($last_level==""){//hier wird der hierarchie-level initial gesetzt
//	echo "111";
	$last_level=20;
	$avail_menu_query=mysql_query("SELECT * FROM menu where hierarchy_level='$last_level' order by sort") or die (mysql_error());
	$totalRows_avail_menu_query = mysql_num_rows($avail_menu_query);
	$menu_pfad_ids=array("");
	}
	else{//hier heben wir den hierarchie-level auf den nächsten Wert
//	echo "222";
	if(count($selected_menu_ids_in)>0){
		$selected_menu_ids_in=explode ('|',$selected_menu_ids_in_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
		$selected_menu_ids_in=array_values($selected_menu_ids_in);
	}

	for ($i=0;$i<$totalRows_menu_hierarchy;$i++){
		mysql_data_seek($menu_hierarchy,$i);
		$menu_hierarchy_row = mysql_fetch_row($menu_hierarchy);
		if($last_level==$menu_hierarchy_row[1]){
			if($i<$totalRows_menu_hierarchy-1){
				mysql_data_seek($menu_hierarchy,$i+1);
				$menu_hierarchy_row = mysql_fetch_row($menu_hierarchy);
				$last_level=$menu_hierarchy_row[1];
				break;
			}
		}
	}
}





if ($task != ""){
//	echo "bisherige IDs: $menu_pfad_ids_imploded";
//	echo "menu_pfad_add_id: $menu_pfad_add_id";
	//if($menu_pfad_ids){
	$menu_pfad_ids=explode ('|',$menu_pfad_ids_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
	$menu_pfad_ids=array_values($menu_pfad_ids);
	$selected_menu_ids_in=explode ('|',$selected_menu_ids_in_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
	$selected_menu_ids_in=array_values($selected_menu_ids_in);
	//}
	
	if($task=="add_level"){
		$task="";
		if($selected_menu_ids_in!=""){
		$selected_menu_ids_in=explode ('|',$selected_menu_ids_in_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
		$selected_menu_ids_in=array_values($selected_menu_ids_in);
		}
		
//		echo "task: add level";
//		echo "<br> menu pfad id zum anhängen: $menu_pfad_add_id";
//		echo "<br> last_level: $last_level";
		array_push($menu_pfad_ids,$menu_pfad_add_id);
		$menu_pfad_ids=array_values($menu_pfad_ids);
//		echo "<br>neues menu_pfad_array: "; echo implode('|',$menu_pfad_ids);
		$avail_menu_query=mysql_query("SELECT * FROM menu where parent_id='$menu_pfad_add_id' order by sort") or die (mysql_error());
		$totalRows_avail_menu_query = mysql_num_rows($avail_menu_query);
	}
	elseif($task=="menu_depth_adjust"){
		if($return==1)
		{?> <script> alert("bin drin")</script> <? 
			$task="";
			if($selected_menu_ids_in!=""){
			$selected_menu_ids_in=explode ('|',$selected_menu_ids_in_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
			$selected_menu_ids_in=array_values($selected_menu_ids_in);
			}
			$menu_pfad_ids=array_values($menu_pfad_ids);
			if($depth==count($menu_pfad_ids)-1){}else{
				for ($iii=count($menu_pfad_ids)-1;$depth < $iii;--$iii){
	//				echo "<br>";echo $iii;
					unset($menu_pfad_ids[$iii]);
	//				echo "<br>";echo implode('|',$menu_pfad_ids);
				}}
			$avail_menu_query=mysql_query("SELECT * FROM menu where parent_id='$menu_pfad_remove' order by sort") or die (mysql_error());
			$totalRows_avail_menu_query = mysql_num_rows($avail_menu_query);
		}
		else
		{ 
			$task="";
			if($selected_menu_ids_in!=""){
			$selected_menu_ids_in=explode ('|',$selected_menu_ids_in_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
			$selected_menu_ids_in=array_values($selected_menu_ids_in);
			}
	//		echo "task: menu depth adjust";
	//		echo "<br>depth adjust: ";echo $depth;
			$depth2=$depth;
	//		echo "<br>Anzahl: ";echo count($menu_pfad_ids);
	//		echo "<br> vor dem rausnehmen: "; echo implode('|',$menu_pfad_ids);
			$menu_pfad_ids=array_values($menu_pfad_ids);
			if($depth==count($menu_pfad_ids)-1){}else{
				for ($iii=count($menu_pfad_ids)-1;$depth < $iii;--$iii){
	//				echo "<br>";echo $iii;
					unset($menu_pfad_ids[$iii]);
	//				echo "<br>";echo implode('|',$menu_pfad_ids);
				}}
	//		echo "<br> nach dem rausnehmen: "; echo implode('|',$menu_pfad_ids);
	//		echo "<br> level of Id to be inserted: "; echo $depth2;
			//array_push($menu_pfad_ids,$menu_pfad_add_id);
			
	//		echo "<br>An welcher Stelle gehört die ausgewählte ID hin"; echo $depth2;
	//		echo "<br>Was ist die ausgewählte ID"; echo $menu_pfad_remove;
			$menu_pfad_ids[$depth2]=$menu_pfad_remove;
			$menu_pfad_ids=array_values($menu_pfad_ids);
	//		echo "<br>nach dem reshuffle: "; print_r($menu_pfad_ids);
			
			$avail_menu_query=mysql_query("SELECT * FROM menu where parent_id='$menu_pfad_remove' order by sort") or die (mysql_error());
			$totalRows_avail_menu_query = mysql_num_rows($avail_menu_query);
	//		echo "<br> nach dem neu einfügen: "; echo implode('|',$menu_pfad_ids);
		}
	}
	elseif($task=="submit_selection"){
		if($selected_menu_ids_in[0]==""){
		unset($selected_menu_ids_in[0]);
		$selected_menu_ids_in=array_values($selected_menu_ids_in);
		}

		if($selected_menu_ids_in!=""){
		$selected_menu_ids_in=explode ('|',$selected_menu_ids_in_imploded);//hier wird eine eventuell übergebene Variable wieder als array aufgebaut.
		$selected_menu_ids_in=array_values($selected_menu_ids_in);
		}

		
		
		$selected_menu_ids_overlap=array_intersect($selected_menu_ids_in,$selected_menu_ids_out);
		
		$selected_menu_ids_remove=array_diff($selected_menu_ids_in,$selected_menu_ids_overlap);
//		echo "was entfernt werden muss: ".implode("|",$selected_menu_ids_remove); echo "<br>";echo "<br>";echo "<br>";
		$selected_menu_ids_remove_imploded=implode("|",$selected_menu_ids_remove);
		echo "<script>remove_menus('$selected_menu_ids_remove_imploded','$element_id')</script>";
		
		$selected_menu_ids_add=array_diff($selected_menu_ids_out,$selected_menu_ids_overlap);
//		echo "was hinzugefügt werden muss: ".implode("|",$selected_menu_ids_add); echo "<br>";echo "<br>";echo "<br>";
		$selected_menu_ids_add_imploded=implode("|",$selected_menu_ids_add);
		echo "<script>add_menus('$selected_menu_ids_add_imploded','$element_id')</script>";
		
		$selected_menu_ids_in=$selected_menu_ids_overlap+$selected_menu_ids_add;
//		echo "Das sind die ausgewählten Menus: "; print_r($selected_menu_ids_in);

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



?>



<table>
<tr>
<?
for ($i=1;$i<$totalRows_menu_hierarchy;++$i){
?>
	<td width="200px">
	<?
//	echo "<br> Menus, die jetzt abgearbeitet werden: "; echo implode('|',$menu_pfad_ids);
//	echo "<br> Anzahl der Menus: "; echo count($menu_pfad_ids);
//	echo "<br> wo stehen wir: "; echo $i;
//	echo "<br> welche ist die nächste id: "; echo $menu_pfad_ids[$i];
	if($menu_pfad_ids[$i]!=""){
//		echo "<br>welche pfad_id ist hier drinnen: "; echo $menu_pfad_ids[$i];
		$target_id=$menu_pfad_ids[$i];
//		echo "<br>SELECT id, description FROM menu where id='$target_id'";
		$menu_pfad_description_query=mysql_query("SELECT id, description FROM menu where id='$target_id'") or die (mysql_error());
		$menu_pfad_description_result=mysql_fetch_row($menu_pfad_description_query);
//		echo "<br><br><br><br>menu_pfad_description_result: $menu_pfad_description_result[0]<br><br><br>";

		$menu_pfad_lastavail_query=mysql_query("SELECT id, description, hierarchy_level FROM menu where parent_id in (select parent_id from menu where id='$target_id')") or die (mysql_error());
		$totalRows_menu_pfad_lastavail_query = mysql_num_rows($menu_pfad_lastavail_query);
		//echo $totalRows_menu_pfad_lastavail_query;
		$menu_pfad_lastavail_result=mysql_fetch_row($menu_pfad_lastavail_query);
		//echo $menu_pfad_lastavail_result[1];
//		echo "<br>";
		
		for ($ii=0; $ii < $totalRows_menu_pfad_lastavail_query;++$ii){
				mysql_data_seek($menu_pfad_lastavail_query,$ii);
				$menu_pfad_lastavail_result=mysql_fetch_row($menu_pfad_lastavail_query);
//				echo "<br>Gewählte id 1: "; echo $menu_pfad_ids[$i];
//				echo "<br>menu_pfad_lastavail_result 1: "; echo $menu_pfad_lastavail_result[0];
		}
		
		
		?>
   		<form method="post" name="menu_pfad_level_<? echo $i;?>">
			<select style="width:200px" name="menu_pfad_remove" onchange="if(this.value == 'change'){} else {document.forms['menu_pfad_level_<? echo $i;?>'].submit()}">
			<option value="change">change selection</option>
			<? 
			for ($ii=0; $ii < $totalRows_menu_pfad_lastavail_query;$ii++){
				mysql_data_seek($menu_pfad_lastavail_query,$ii);
				$menu_pfad_lastavail_result=mysql_fetch_row($menu_pfad_lastavail_query);
				if($menu_pfad_ids[$i]==$menu_pfad_lastavail_result[0])
				{echo "<option selected='selected' value=\"$menu_pfad_lastavail_result[0]\">$menu_pfad_lastavail_result[1]</option>"; }
				else {echo "<option value=\"$menu_pfad_lastavail_result[0]\">$menu_pfad_lastavail_result[1]</option>"; }
			}?>
			</select>
               <input type="hidden" name="selected_menu_ids_in_imploded" value="<? echo implode('|',$selected_menu_ids_in)?>">
               <input type="hidden" name="menu_pfad_ids_imploded" value="<? echo implode('|',$menu_pfad_ids)?>">
			<input type="hidden" name="element_id" value="<? echo $element_id;?>">
			<input type="hidden" name="depth" value="<? echo $i;?>">
			<input type="hidden" name="task" value="menu_depth_adjust">
			<input type="hidden" name="last_level" value="<? echo $menu_pfad_lastavail_result[2];?>">
               <input type="button" name="return" value="<<" onclick="document.forms['menu_pfad_level_<? echo $i;?>'].submit()">
			</form>
<?	}
	else{//echo "<br>hier kommen die neuen Anhänge dran";
		?>
		<form method="post" name="newlevel_<? echo $i;?>">
		<? if($totalRows_avail_menu_query > 0){?>
			<select style="width:200px" name="menu_pfad_add_id" onchange="if(this.value == 'change'){} else {document.forms['newlevel_<? echo $i;?>'].submit()}">
			<option value="change">select</option>
			<? mysql_data_seek($avail_menu_query,0);
			while($row = mysql_fetch_assoc($avail_menu_query)){?>
				<option value="<? echo $row[id];?>"><? echo $row[description];?></option>
		<?		}
			} 
		?>
		</select> 
		<input type="hidden" name="last_level" value="<? echo $last_level;?>">
		<input type="hidden" name="element_id" value="<? echo $element_id;?>">
          <input type="hidden" name="selected_menu_ids_in_imploded" value="<? echo implode('|',$selected_menu_ids_in)?>">
          <input type="hidden" name="menu_pfad_ids_imploded" value="<? echo implode('|',$menu_pfad_ids)?>">
		<input type="hidden" name="task" value="add_level">
		</form>
		<div style="height:22px"></div>
		</td>
<? break;
	}
}
?>
</tr>
</table>
<div style="height:30px"></div>

<? 
$show_menu_id=end($menu_pfad_ids); 

echo "xxxx";
$selected_menu_ids_out=array();
Print_r($selected_menu_ids_out);

$show_menu=mysql_query("SELECT id, description, pagetype, active_startdate, active_enddate FROM menu where parent_id ='$show_menu_id'") or die (mysql_error());
$totalRows_show_menu = mysql_num_rows($show_menu);
while(($show_menu_result[] = mysql_fetch_assoc($show_menu)) || array_pop($show_menu_result)); 

//print_r($show_menu_result);
if($totalRows_show_menu>0 and $show_menu_result[0][id]!="1"){
?>
     <form name="form_show_menu_result">
     <table>
     <th style="text-align:left">Select</td>
     <th style="text-align:left">Description</td>
     <th style="text-align:left">Pagetype</td>
     <th style="text-align:left">Start</td>
     <th style="text-align:left">End</td>
     
	<? for ($i=0;$i <$totalRows_show_menu;++$i){?>
          <tr>
               <td style="width:20px"> <input type="checkbox" 
				<?
				for($ii=0;$ii<count($selected_menu_ids_in)+1;++$ii){
					if($show_menu_result[$i][id]==$selected_menu_ids_in[$ii]){echo "checked=\"checked\"";}
				}
				?> 
                    name="selected_menu_ids_out[]" value="<? echo $show_menu_result[$i][id];?>"/> 
               </td>
               <td style="width:50px"> <? echo $show_menu_result[$i][id];?> </td>
               <td style="width:200px"> <? echo $show_menu_result[$i][description];?> </td>
               <td style="width:200px"> <? echo $show_menu_result[$i][pagetype];?> </td>
               <td style="width:200px"> <? echo $show_menu_result[$i][active_startdate];?> </td>
               <td style="width:200px"> <? echo $show_menu_result[$i][active_enddate];?> </td>
          </tr>
     <? } ?>
	</table>
     <input type="hidden" name="last_level" value="<? echo $last_level;?>">
	<input type="hidden" name="element_id" value="<? echo $element_id;?>">
     <input type="hidden" name="selected_menu_ids_in_imploded" value="<? echo implode('|',$selected_menu_ids_in)?>">
     <input type="hidden" name="menu_pfad_ids_imploded" value="<? echo implode('|',$menu_pfad_ids)?>">
	<input type="hidden" name="task" value="submit_selection">
	<!--<input type="button" name="submit" value="submit"  onclick="window.close();window.opener.update_menu_ids();"/>-->
	<input type="button" name="OK" value="OK"  onclick="
     Ergebnis = teste_ceckboxen(this);
     if(Ergebnis==true){document.forms['form_show_menu_result'].submit();}
     "/>
     </form>

<? }?>
</html>