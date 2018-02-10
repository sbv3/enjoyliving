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
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px; font-weight:bolder; text-decoration:underline">Kampagne anlegen</div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_rechts.png);width:4px;height:34px;float:left"></div>
		<div style="clear:right"></div>
	<!--Taste Ende-->
	<!--Taste-->
		<div style="background-image:url(/site_12_1/css/Element_Tops_Schatten.png);background-repeat:repeat-x;height:34px;width:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_links.png);width:4px;height:34px;float:left"></div>
		<div style="background-image:url(/site_12_1/css/Element_Tops_taste_Mitte.png);background-repeat:repeat-x;height:18px; min-width:200px; float:left; text-align:left; padding:8px"><a href="kampagnen_code_admin.php">Kampagnencodes</a></div>
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
<?php
$table="kampagnen";

if (!isset($_SESSION['microtime']) or $_SESSION['microtime'] != $timestamp_kampagnen_admin)
{
	if($add==1)
	{
	$add=0;
	mysql_query("INSERT INTO $table (description,site_id) VALUES('new',$site_id) ") or die(mysql_error());  
	}
	$_SESSION['microtime'] = $timestamp_kampagnen_admin;
}


    $query="select id, description, startdate, enddate from $table where site_id=$site_id order by up_date,createdate";
    $result=mysql_query($query);
    $row_Recordset1 = mysql_fetch_assoc($result);
?>
<br />
<table id="<? echo $table; ?>" width="750px" border="0" bgcolor="#FFFFFF" rules=ROWS frame=BOX>
	<tr style="background-color: rgb(180,220,256);">
		<td style="width:150px; color:#000000;">ID</td>
		<td style="width:150px; color:#000000;">Kampagnenname</td>
		<td style="width:150px; color:#000000;">Start-Datum</td>
		<td style="width:150px; color:#000000;">Ende-Datum</td>
		<td style="width:150px">&nbsp;</td>
	</tr>
<?php
if($row_Recordset1){mysql_data_seek($result, 0);}
 while ($row_Recordset1 = mysql_fetch_assoc($result)) { ?>
        <tr>
        <form id="selector" name="selector" method="post">
           <td width="150px"><div id="idi_<?php echo $row_Recordset1['id']; ?>_div"><?php echo $row_Recordset1['id']; ?></div></td>

           <td width="150px"><div id="description_<?php echo $row_Recordset1['id']; ?>_div" onclick="editField(this,'<?php echo urlencode($row_Recordset1['description']); ?>')"><?php echo $row_Recordset1['description']; ?></div>
           <input name="description" type="text" class="hiddenField" id="description_<?php echo $row_Recordset1['id']; ?>" onblur="updateField(this,'<? echo $table; ?>',<?php echo $row_Recordset1['id']; ?>)" value="<?php echo $row_Recordset1['description']; ?>" /></td>

           <td width="150px"><div id="startdate_<?php echo $row_Recordset1['id']; ?>_div" onclick="editField(this,'<?php echo urlencode($row_Recordset1['startdate']); ?>')"><?php echo $row_Recordset1['startdate']; ?></div>
           <input name="startdate" type="text" class="hiddenField" id="startdate_<?php echo $row_Recordset1['id']; ?>" onblur="updateField(this,'<? echo $table; ?>',<?php echo $row_Recordset1['id']; ?>)" value="<?php echo $row_Recordset1['startdate']; ?>" /></td>

           <td width="150px"><div id="enddate_<?php echo $row_Recordset1['id']; ?>_div" onclick="editField(this,'<?php echo urlencode($row_Recordset1['enddate']); ?>')"><?php echo $row_Recordset1['enddate']; ?></div>
           <input name="enddate" type="text" class="hiddenField" id="enddate_<?php echo $row_Recordset1['id']; ?>" onblur="updateField(this,'<? echo $table; ?>',<?php echo $row_Recordset1['id']; ?>)" value="<?php echo $row_Recordset1['enddate']; ?>" /></td>


			<td width="150px"><input name="delete" type="button" onclick="deleteRow(this,'<? echo $table; ?>',<?php echo $row_Recordset1['id']; ?>)" value="delete"/></td>
		</form>
        </tr>
  <?php } ; ?>
</table>

      <?  mysql_free_result($result);?>
<div id="table_result_error_messages"></div>
<br />
      <table id="add" width="750px" border="0"bgcolor="#FFFFFF" rules=ROWS frame=BOX>
      <tr>
      <form name="addRecord" method="post" action="kampagnen_admin.php">
      	<td width="150px"></td>
      	<td width="150px"></td>
      	<td width="150px"></td>
      	<td width="150px"></td>
      	<td width="150px">
             <input name="add" type="submit" id="add" value="add">
             <input type="hidden" name="add" value="1">
		   	<input type="hidden" name="timestamp_kampagnen_admin" value="<? echo $timestamp_kampagnen_admin = microtime();?>">

         </td>
      </form>
      </table>
</body>
</html>