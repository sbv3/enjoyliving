<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
if(test_right($_SESSION['user'],"edit_kampagnen")!="true")
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


<div>
	<div style='width:100%;background-image:url(/site_12_1/css/Element_Tops_Schatten.png);height:34px;background-repeat:repeat-x;'>
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px;"><a href="kampagnen_admin.php">Kampagne anlegen</a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px; font-weight:bolder; text-decoration:underline">Kampagnencodes</div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px"><a href="kampagnen_statistik.php">Statistik</a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:34px; float:left; text-align:left; padding:3px"><a href="papa/menu.php?men_id=230"><img src="/site_12_1/css/button_menu.png" title="Zurück zur Menüverwaltung"></a></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
</div>
</div>

<div style="clear:left;"> </div>



<body>

<?
////////////////////POST QUERIES
$table="kampagnen_code";

if (!isset($_SESSION['microtime']) or $_SESSION['microtime'] != $timestamp_kampagnen_code)
{
	if($add==1)
	{
	$add=0;
	mysql_query("INSERT INTO $table (kampagnen_id, description, code, element_layout_id) VALUES('$kampagne','new','new','$element_layout_id')") or die(mysql_error());  
	}

	if($new_element_layout_id==1)
	{
	$new_element_layout_id=0;
	mysql_query("update $table set element_layout_id='$element_layout_id' where id=$kampagnen_code_id") or die(mysql_error());  
	}
	
	if($change_insert_click_tags==1)
	{
	$change_insert_click_tags=0;
	mysql_query("update $table set insert_click_tags='$insert_click_tags' where id=$kampagnen_code_id") or die(mysql_error());  
	}
	
	$_SESSION['microtime'] = $timestamp_kampagnen_code;

}


$Kampagnen_query=mysql_query("select * from kampagnen where site_id=$site_id") or die (mysql_error());
$Kampagnen_total_rows = mysql_num_rows($Kampagnen_query);

?>
<table border=0>
	<tr>
		<td><? if($kampagne!="" and $kampagne!="unselected") {echo "Verfügbare Kampagnen:";} else {echo "Zuerst Kampagne auswählen";}?> </td>
		<td></td>
		<td>
			<form method="post" name="form_kampagne">
				<select style="width:200px;" name="kampagne" onchange="document.forms['form_kampagne'].submit()">
					<option value="unselected">Kampagne auswählen</option>
					<? if($Kampagnen_total_rows > 0)
					{
						while($row = mysql_fetch_assoc($Kampagnen_query))
						{
							if($row[id]==$kampagne)
							{echo "<option selected='selected' value=\"$row[id]\">$row[description]</option>";}
							else
							{echo "<option value=\"$row[id]\">$row[description]</option>";}
						}
					} 
					else 
					{echo "<option value=\"unselected\">Kein Element vorhanden</option>";}?>
				</select> 
			</form>
		</td>
	</tr>
</table>



<?
if($kampagne!="" and $kampagne!="unselected"){
	$kampagne_select_query=mysql_query("select id,description,startdate,enddate from kampagnen where id='$kampagne'") or die (mysql_error());
	$kampagnen_select=mysql_fetch_row($kampagne_select_query);
	$kampagne_active=$kampagnen_select[1];

	$element_layout_query=mysql_query("select id,description from element_layout where kampagnentauglich='1'") or die (mysql_error());
	
    $result=mysql_query("select kampagnen_code.id, kampagnen_code.description, code, insert_click_tags, element_layout.description as layout_description, element_layout.id as layout_id, Anz.nr from element_layout, kampagnen_code left join (select kampagnen_code_id, count(1) as nr from kampagnen_element group by kampagnen_code_id) as Anz on Anz.kampagnen_code_id=kampagnen_code.id
where kampagnen_id='$kampagne' and element_layout_id=element_layout.id");
    $row_Recordset1 = mysql_fetch_assoc($result);

	?>
	<br />
	<table id="<? echo $table; ?>" width="900px" border="0" bgcolor="#FFFFFF" rules=ROWS frame=BOX>
	<tr style="background-color: rgb(180,220,256);">
		<td style="width:150px; color:#000000;">ID</td>
		<td style="width:150px; color:#000000;">Bezeichnung</td>
		<td style="width:150px; color:#000000;">Gültiges Element</td>
		<td style="width:150px; color:#000000;">Code</td>
		<td style="width:150px; color:#000000;">Click Tag</td>
		<td style="width:150px">&nbsp;</td>
	</tr>
	
	<?php
	if($row_Recordset1){mysql_data_seek($result, 0);}
	 while ($row_Recordset1 = mysql_fetch_assoc($result)) { ?>
		   <tr>
			   <form id="selector" name="selector_<? echo $row_Recordset1['id'];?>" method="post">
				 <td style="width:150px"><div id="idi_<?php echo $row_Recordset1['id']; ?>_div"><?php echo $row_Recordset1['id']; ?></div></td>
		 
				 <td style="width:150px"><div id="description_<?php echo $row_Recordset1['id']; ?>_div" onclick="editField(this,'<?php echo urlencode($row_Recordset1['description']); ?>')"><?php echo $row_Recordset1['description']; ?></div>
				 <input name="description" type="text" class="hiddenField" id="description_<?php echo $row_Recordset1['id']; ?>" onblur="updateField(this,'<? echo $table; ?>',<?php echo $row_Recordset1['id']; ?>)" value="<?php echo $row_Recordset1['description']; ?>" /></td>
		
				 <td style="width:150px">
				 <? if ($row_Recordset1['id']) {?>
						 <select style="width:150px" name="element_layout_id" onchange="document.forms['selector_<? echo $row_Recordset1['id'];?>'].submit()" <? if($row_Recordset1[nr]>0){echo "disabled"; echo ' title="Dieses Layout ist noch in Verwendung"';}?>>
							<? while($row = mysql_fetch_assoc($element_layout_query))
							{
								if($row[id]==$row_Recordset1[layout_id])
								{echo "<option selected='selected' value=\"$row[id]\">$row[description]</option>";}
								else
								{echo "<option value=\"$row[id]\">$row[description]</option>";}
							}
							mysql_data_seek($element_layout_query, 0);?>
								 
						 </select>
						   <input type="hidden" name="new_element_layout_id" value="1">
						   <input type="hidden" name="kampagnen_code_id" value="<?php echo $row_Recordset1['id']; ?>">
						   <input type="hidden" name="kampagne" value="<? echo $kampagne;?>">
						   <input type="hidden" name="timestamp_kampagnen_code" value="<? echo $timestamp_kampagnen_code = microtime();?>">
					<? }?>
				 </td>
				 <td style="width:150px"><div style="display:block; max-width:150px; overflow:hidden" id="code_<?php echo $row_Recordset1['id']; ?>_div" onclick="editField(this,'<?php echo urlencode($row_Recordset1['code']); ?>')"><?php echo $row_Recordset1['code']; ?></div>
				 <textarea name="code" rows="4" class="hiddenField" id="code_<?php echo $row_Recordset1['id']; ?>" onblur="updateField(this,'<? echo $table; ?>',<?php echo $row_Recordset1['id']; ?>,'script')" value="<?php echo $row_Recordset1['code']; ?>" /></textarea></td>
				</form>
				<form id="insert_click_tags" name="insert_click_tags_<? echo $row_Recordset1['id'];?>" method="post">
					<td style="width:150px">
					<? if ($row_Recordset1['id']) {?>
						 <select style="width:150px" name="insert_click_tags" onchange="document.forms['insert_click_tags_<? echo $row_Recordset1['id'];?>'].submit()">
							<option <? if($row_Recordset1[insert_click_tags]==0){echo "selected";}?> value=0>no</option>
							<option <? if($row_Recordset1[insert_click_tags]==1){echo "selected";}?> value=1>yes</option>
						 </select>
						<input type="hidden" name="change_insert_click_tags" value="1">
						<input type="hidden" name="kampagnen_code_id" value="<?php echo $row_Recordset1['id']; ?>">
						<input type="hidden" name="kampagne" value="<? echo $kampagne;?>">
						<input type="hidden" name="timestamp_kampagnen_code" value="<? echo $timestamp_kampagnen_code = microtime();?>">
					<? }?>
					</td>
				</form>
	
				<form id="delete" name="delete_<? echo $row_Recordset1['id'];?>" method="post">
					 <td style="width:150px"><input name="delete" type="button" onclick="deleteRow(this,'<? echo $table; ?>',<?php echo $row_Recordset1['id']; ?>)" value="delete" <? if($row_Recordset1[nr]>0){echo "disabled"; echo ' title="Dieses Layout ist noch in Verwendung"';}?>></td> 
				 </form>
		   </tr>
	  <?php } ; ?>
	</table>
	
		 <?  mysql_free_result($result);?>
	<div id="table_result_error_messages"></div>
	<br />
		 <table id="add" width="750px" border="0"bgcolor="#FFFFFF" rules=ROWS frame=BOX>
		 <tr>
		 <form name="addRecord" method="post" action="kampagnen_code_admin.php">
			<td width="150px"></td>
			<td width="150px"></td>
			<td width="150px">
			<select style="width:150px" name="element_layout_id">
				<? while($row = mysql_fetch_assoc($element_layout_query))
				{
					if($row[id]==$row_Recordset1[layout_id])
					{echo "<option selected='selected' value=\"$row[id]\">$row[description]</option>";}
					else
					{echo "<option value=\"$row[id]\">$row[description]</option>";}
				}
				mysql_data_seek($element_layout_query, 0);?>
					 
			 </select>
			</td>
			<td width="150px"></td>
			<td width="150px">
			   <input name="add" type="submit" id="add" value="add">
			   <input type="hidden" name="add" value="1">
			   <input type="hidden" name="kampagne" value="<? echo $kampagne;?>">
			   <input type="hidden" name="timestamp_kampagnen_code" value="<? echo $timestamp_kampagnen_code = microtime();?>">

		    </td>
		 </form>
		 </table>
<? }?>
</body>
</html>